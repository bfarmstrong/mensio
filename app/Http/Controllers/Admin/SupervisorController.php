<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateSupervisorRequest;
use App\Services\Impl\IUserService;
use Illuminate\Http\Response;

/**
 * Manage supervisors for junior therapists against a client.
 */
class SupervisorController extends Controller
{
    /**
     * The user service implementation.
     *
     * @var IUserService
     */
    protected $userService;

    /**
     * Creates an instance of `SupervisorController`.
     *
     * @param IUserService $userService
     */
    public function __construct(IUserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Updates the supervisor for a therapist against a client.
     *
     * @param UpdateSupervisorRequest $request
     *
     * @return Response
     */
    public function update(UpdateSupervisorRequest $request)
    {
        $client = $this->userService->find($request->user_id);
        if (is_null($client)) {
            abort(404);
        }

        $therapist = $this->userService->find($request->therapist_id);
        if (is_null($therapist)) {
            abort(404);
        }

        $this->userService->updateSupervisor(
            $client,
            $therapist,
            $request->get('supervisor_id') ?? null
        );

        return redirect()->back()->with([
            'message' => is_null($request->get('supervisor_id')) ?
                __('admin.users.therapists.index.removed-supervisor') :
                __('admin.users.therapists.index.added-supervisor'),
        ]);
    }
}
