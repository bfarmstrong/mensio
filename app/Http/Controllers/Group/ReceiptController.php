<?php

namespace App\Http\Controllers\Group;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\CreateReceiptRequest;
use App\Models\Receipt;
use App\Notifications\ReceiptCreated;
use App\Services\Criteria\General\WithRelation;
use App\Services\Impl\IGroupService;
use App\Services\Impl\IReceiptService;
use App\Services\Impl\IUserService;
use DB;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Notification;

/**
 * Management operations for receipts of an encounter with a group.
 */
class ReceiptController extends Controller
{
    /**
     * The group service implementation.
     *
     * @var IGroupService
     */
    protected $groupService;

    /**
     * The receipt service implementation.
     *
     * @var IReceiptService
     */
    protected $receiptService;

    /**
     * The user service implementation.
     *
     * @var IUserService
     */
    protected $userService;

    /**
     * Creates an instance of `ReceiptController`.
     *
     * @param IGroupService   $groupService
     * @param IReceiptService $receiptService
     * @param IUserService    $userService
     */
    public function __construct(
        IGroupService $groupService,
        IReceiptService $receiptService,
        IUserService $userService
    ) {
        $this->groupService = $groupService;
        $this->receiptService = $receiptService;
        $this->userService = $userService;
    }

    /**
     * Returns the page to create a new receipt for a group.
     *
     * @param string $id
     *
     * @return Response
     */
    public function create(string $id)
    {
        $this->authorize('create', Receipt::class);
        $group = $this->groupService->findBy('uuid', $id);

        return view('admin.groups.receipts.create')->with([
            'group' => $group,
        ]);
    }

    /**
     * Returns a PDF of the receipt to the requester.
     *
     * @param string $group
     * @param string $receipt
     *
     * @return Response
     */
    public function download(string $group, string $receipt)
    {
        $this->authorize('view', Receipt::class);
        $this->groupService->findBy('uuid', $group);
        $receipt = $this->receiptService
            ->pushCriteria(new WithRelation('clinic'))
            ->pushCriteria(new WithRelation('supervisor'))
            ->pushCriteria(new WithRelation('therapist'))
            ->pushCriteria(new WithRelation('user'))
            ->findBy('uuid', $receipt);
        $pdf = $this->receiptService->exportAsPdf($receipt);

        return $pdf->stream();
    }

    /**
     * Creates a receipt in the database.
     *
     * @param CreateReceiptRequest $request
     * @param string               $id
     *
     * @return Response
     */
    public function store(CreateReceiptRequest $request, string $id)
    {
        return DB::transaction(function () use ($request, $id) {
            $this->authorize('create', Receipt::class);
            $group = $this->groupService->findBy('uuid', $id);
            $clients = $this->groupService->findClients($group);

            foreach ($clients as $client) {
                $supervisor = $this->userService->findSupervisor($client, $request->user());

                $receipt = $this->receiptService->create([
                    'appointment_date' => $request->get('appointment_date'),
                    'clinic_id' => $request->attributes->get('clinic')->id,
                    'group_id' => $group->id,
                    'supervisor_id' => $supervisor->id ?? null,
                    'therapist_id' => $request->user()->id,
                    'user_id' => $client->id,
                ]);

                Notification::send($client, new ReceiptCreated($receipt));
            }

            return redirect()
                ->to("groups/$group->uuid/notes")
                ->with([
                    'message' => __('clients.receipts.create.created-receipt'),
                ]);
        });
    }
}
