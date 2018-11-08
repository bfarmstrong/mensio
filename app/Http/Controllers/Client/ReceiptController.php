<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\CreateReceiptRequest;
use App\Models\Receipt;
use App\Notifications\ReceiptCreated;
use App\Services\Criteria\General\WithRelation;
use App\Services\Impl\IReceiptService;
use App\Services\Impl\IUserService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Notification;

/**
 * Management operations for receipts of an encounter with a client.
 */
class ReceiptController extends Controller
{
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
     * @param IReceiptService $receiptService
     * @param IUserService    $userService
     */
    public function __construct(
        IReceiptService $receiptService,
        IUserService $userService
    ) {
        $this->receiptService = $receiptService;
        $this->userService = $userService;
    }

    /**
     * Returns the page to create a new receipt for a client.
     *
     * @param string $id
     *
     * @return Response
     */
    public function create(string $id)
    {
        $this->authorize('create', Receipt::class);
        $client = $this->userService->find($id);

        return view('clients.receipts.create')->with([
            'client' => $client,
        ]);
    }

    /**
     * Returns a PDF of the receipt to the requester.
     *
     * @param string $client
     * @param string $receipt
     *
     * @return Response
     */
    public function download(string $client, string $receipt)
    {
        $this->authorize('view', Receipt::class);
        $this->userService->find($client);
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
        $this->authorize('create', Receipt::class);
        $client = $this->userService->find($id);
        $supervisor = $this->userService->findSupervisor($client, $request->user());

        $this->receiptService->create([
            'appointment_date' => $request->get('appointment_date'),
            'clinic_id' => $request->attributes->get('clinic')->id,
            'supervisor_id' => $supervisor->id ?? null,
            'therapist_id' => $request->user()->id,
            'user_id' => $client->id,
        ]);

        Notification::send($client, new ReceiptCreated($receipt));

        return redirect()
            ->to("clients/$client->id/notes")
            ->with([
                'message' => __('clients.receipts.create.created-receipt'),
            ]);
    }
}
