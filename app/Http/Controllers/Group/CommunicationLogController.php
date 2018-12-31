<?php

namespace App\Http\Controllers\Group;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\CreateCommunicationLogRequest;
use App\Models\CommunicationLog;
use App\Services\Impl\ICommunicationLogService;
use App\Services\Impl\IGroupService;
use App\Services\Impl\IUserService;
use DB;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Manages communication logs on a group resource.
 */
class CommunicationLogController extends Controller
{
    /**
     * The communication log service.
     *
     * @var ICommunicationLogService
     */
    protected $communicationLogService;

    /**
     * The group service implementation.
     *
     * @var IGroupService
     */
    protected $groupService;

    /**
     * The user service implementation.
     *
     * @var IUserService
     */
    protected $userService;

    /**
     * Creates an instance of `CommunicationLogController`.
     *
     * @param ICommunicationLogService $communicationLogService
     * @param IGroupService            $groupService
     * @param IUserService             $userService
     */
    public function __construct(
        ICommunicationLogService $communicationLogService,
        IGroupService $groupService,
        IUserService $userService
    ) {
        $this->communicationLogService = $communicationLogService;
        $this->groupService = $groupService;
        $this->userService = $userService;
    }

    /**
     * Renders the page to create a new communication log.
     *
     * @param string $id
     *
     * @return Response
     */
    public function create(string $id)
    {
        $this->authorize('create', CommunicationLog::class);
        $group = $this->groupService->findBy('uuid', $id);

        return view('admin.groups.communication.create')->with([
            'group' => $group,
        ]);
    }

    /**
     * Renders the page to view a communication log.
     *
     * @param string $group
     * @param string $communication
     *
     * @return Response
     */
    public function show(string $group, string $communication)
    {
        $this->authorize('view', CommunicationLog::class);
        $group = $this->groupService->findBy('uuid', $group);
        $communication = $this->communicationLogService->findBy(
            'uuid',
            $communication
        );

        return view('admin.groups.communication.show')->with([
            'communication' => $communication,
            'group' => $group,
        ]);
    }

    /**
     * Creates a new communication log in the database.
     *
     * @param CreateCommunicationLogRequest $request
     * @param string                        $id
     *
     * @return Response
     */
    public function store(CreateCommunicationLogRequest $request, string $id)
    {
        return DB::transaction(function () use ($request, $id) {
            $this->authorize('create', CommunicationLog::class);
            $group = $this->groupService->findBy('uuid', $id);
            $clients = $this->groupService->findClients($group);

            foreach ($clients as $client) {
                $this->communicationLogService->create(array_merge(
                    $request->all(),
                    [
                        'clinic_id' => $request->attributes->get('clinic')->id,
                        'group_id' => $group->id,
                        'therapist_id' => $request->user()->id,
                        'user_id' => $client->id,
                    ]
                ));
            }

            return redirect()
                ->to("groups/$group->uuid/notes")
                ->with([
                    'message' => __('clients.communication.create.created-communication-log'),
                ]);
        });
    }
}
