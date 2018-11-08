<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\CreateCommunicationLogRequest;
use App\Models\CommunicationLog;
use App\Services\Impl\ICommunicationLogService;
use App\Services\Impl\IUserService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Manages communication logs on a client resource.
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
     * The user service implementation.
     *
     * @var IUserService
     */
    protected $userService;

    /**
     * Creates an instance of `CommunicationLogController`.
     *
     * @param ICommunicationLogService $communicationLogService
     * @param IUserService             $userService
     */
    public function __construct(
        ICommunicationLogService $communicationLogService,
        IUserService $userService
    ) {
        $this->communicationLogService = $communicationLogService;
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
        $client = $this->userService->find($id);

        return view('clients.communication.create')->with([
            'client' => $client,
        ]);
    }

    /**
     * Renders the page to view a communication log.
     *
     * @param string $client
     * @param string $communication
     *
     * @return Response
     */
    public function show(string $client, string $communication)
    {
        $this->authorize('view', CommunicationLog::class);
        $client = $this->userService->find($client);
        $communication = $this->communicationLogService->findBy(
            'uuid',
            $communication
        );

        return view('clients.communication.show')->with([
            'client' => $client,
            'communication' => $communication,
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
        $this->authorize('create', CommunicationLog::class);
        $client = $this->userService->find($id);
        $this->communicationLogService->create(array_merge(
            $request->all(),
            [
                'clinic_id' => $request->attributes->get('clinic')->id,
                'therapist_id' => $request->user()->id,
                'user_id' => $client->id,
            ]
        ));

        return redirect()
            ->to("clients/$client->id/notes")
            ->with([
                'message' => __('clients.communication.create.created-communication-log'),
            ]);
    }
}
