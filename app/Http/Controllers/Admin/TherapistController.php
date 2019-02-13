<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Roles;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\Criteria\User\WhereNotCurrentTherapist;
use App\Services\Criteria\User\WhereRole;
use App\Services\Criteria\User\WhereTherapist;
use App\Services\Criteria\User\WithRole;
use App\Services\Criteria\User\WithSupervisors;
use App\Services\Criteria\User\WithTherapistsAndSupervisors;
use App\Services\Impl\IUserService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Manage a therapist resource for a user.
 */
class TherapistController extends Controller
{
    /**
     * The user service implementation.
     *
     * @var IUserService
     */
    protected $user;

    /**
     * Creates an instance of `TherapistController`.
     *
     * @param IUserService $user
     */
    public function __construct(IUserService $user)
    {
        $this->user = $user;
    }

    /**
     * Removes a therapist linking from a user.
     *
     * @param string $user
     * @param string $therapist
     *
     * @return Response
     */
    public function destroy(string $user, string $therapist)
    {
        $user = $this->user->find($user);
        $this->authorize('removeTherapist', $user);
        $this->user->removeTherapist($therapist, $user->id);

        return redirect()
            ->back()
            ->with('message', __('admin.users.therapists.index.removed-therapist'));
    }

    /**
     * Displays the page to add therapists to a user.
     *
     * @param string $user
     *
     * @return Response
     */
    public function index(string $user)
    {
        $user = $this->user
            ->getByCriteria(new WithTherapistsAndSupervisors($user))
            ->find($user);

        if (is_null($user)) {
            abort(404);
        }

        $this->authorize('viewTherapists', $user);
        $therapists = $this->user
            ->pushCriteria(new WithSupervisors($user->id))
            ->pushCriteria(new WhereTherapist())
            ->pushCriteria(new WithRole())
            ->pushCriteria(new WhereNotCurrentTherapist($user->id))
            ->all()
            ->sortBy('name');

        $supervisors = $this->user
            ->pushCriteria(new WhereRole(Roles::SeniorTherapist))
            ->pushCriteria(new WhereNotCurrentTherapist($user->id))
            ->all()
            ->sortBy('name');

        return view('admin.users.therapists.index')->with([
            'supervisors' => $supervisors,
            'therapists' => $therapists,
            'user' => $user,
        ]);
    }

    /**
     * Adds a therapist linking to a user.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $user = $this->user->find($request->user_id);
        $this->authorize('addTherapist', $user);
        $this->user->addTherapist(
            $request->get('therapist_id'),
            $request->user_id
        );

        return redirect()
            ->back()
            ->with('message', __('admin.users.therapists.index.added-therapist'));
    }
	
	/**
     * Adds a therapist and associate supervisors linking to a user.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function storeTherapistSupervisor(Request $request)
    {	
		foreach($request->user_id as $key => $user_id) { 
			$client = $this->user->find($user_id);
			$therapist = $this->user->find($request->get('therapist_id')[$key]);
			$this->user->addTherapist(
				$request->get('therapist_id')[$key],
				$user_id
			);
			//if ($request->get('supervisor_id')[$key]) {	
			$this->user->updateSupervisor(
				$client,
				$therapist,
				$request->get('supervisor_id')[$key] ?? null
			);
			//}
		}
        return redirect()
            ->back()
            ->with('message', __('admin.users.therapists.index.added-therapist'));
    }
}
