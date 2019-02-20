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
use App\Services\Criteria\General\WithRelation;
use App\Services\Criteria\General\WhereEqual;
use App\Services\Criteria\General\WhereRelationEqual;
use App\Services\Impl\IRoleService;
use App\Services\Criteria\General\WhereIn;
use App\Http\Requests\TherapistInviteRequest;
use App\Http\Requests\ClientInviteRequest;
use App\Services\Impl\IDoctorService;

/**
 * Manage a therapist resource for a user.
 */
class TherapistController extends Controller
{
	 /**
     * The doctor service implementation.
     *
     * @var IDoctorService
     */
    protected $doctorService;
	
    /**
     * The user service implementation.
     *
     * @var IUserService
     */
    protected $user;
	
    /**
     * The role service implementation.
     *
     * @var IRoleService
     */
    protected $roleService;
	
    /**
     * Creates an instance of `TherapistController`.
     *
     * @param IUserService $user
     */
    public function __construct(IUserService $user, IRoleService $roleService, IDoctorService $doctorService)
    {
        $this->user = $user;
		$this->roleService = $roleService;
		$this->doctorService = $doctorService;
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
			$user = $this->user
				->getByCriteria(new WithTherapistsAndSupervisors($user_id))
				->find($user_id);
			
			foreach($request->therapist_id as $therapist_id){
				if(in_array($therapist_id,$user->therapists->pluck('id')->toArray())){
					$this->user->removeTherapist($therapist_id, $user_id);
				} else {
					$this->user->addTherapist(
						$therapist_id,
						$user_id
					);
				}
			}
		}
        return redirect()
            ->back()
            ->with('message', __('admin.users.therapists.index.added-therapist'));
    }
	
	/**
     * check a therapist and associate client.
     *
     * @param Request $request
     *
     * @return Response
     */	
	public function checkAssignment(Request $request){ 
		$return='';
		if(count($_POST['therapist_id']) > 1){
			$assignedclient_name = [];
			$assignedtherapist_name = [];
			$deassignedclient_name = [];
			$deassignedtherapist_name = [];
			foreach($_POST['client_id'] as $key => $user_id) { 
				$user = $this->user
					->getByCriteria(new WithTherapistsAndSupervisors($user_id))
					->find($user_id);
			
				foreach($_POST['therapist_id'] as $therapist_id){
					$therapist_name = $this->user->find($therapist_id);
					
					if(in_array($therapist_id,$user->therapists->pluck('id')->toArray())){
						$assignedtherapist_name[] = $therapist_name->name;
						$assignedclient_name[] = $user->name;
					} else {
						$deassignedtherapist_name[] = $therapist_name->name;
						$deassignedclient_name[] = $user->name;
					}
				}
			}
			if (!empty($assignedtherapist_name)){
				$return .= 'You are currently assigning '.implode(',',$assignedtherapist_name).' to '.implode(',',array_unique($assignedclient_name)).'.';
			} if (!empty($deassignedtherapist_name)){
			$return .= 'You are currently de-assigning '.implode(',',$deassignedtherapist_name).' to '.implode(',',array_unique($deassignedclient_name)).'.'; 
			}
			$return .= 'Are you sure you want to do this?';
		} else {
			$user = $this->user
            ->getByCriteria(new WithTherapistsAndSupervisors($_POST['client_id'][0]))
            ->find($_POST['client_id'][0]);
			if(in_array($_POST['therapist_id'][0],$user->therapists->pluck('id')->toArray())){
				$return .= 'De-assign';
			} else {
				$return .= 'Assign';
			}
		}
		return $return;
	}
	
	/**
     * Show the form for inviting a therapist.
     *
     * @return Response
     */
	public function getInviteTherapist()
	{
		$query = $this->user
				->pushCriteria(new WithRelation('clinics'))
				->pushCriteria(new WithRelation('roles'))
				->pushCriteria(new WhereEqual('is_active', 1));

			if (
				! request()->user()->isSuperAdmin() ||
				! is_null(request()->attributes->get('clinic'))
			) {
				$query = $query->pushCriteria(
					new WhereRelationEqual(
						'clinics',
						'clinics.id',
						request()->attributes->get('clinic')->id
					)
				);
			}
		$users = $query->all();

		$therapists = $users->filter(function ($user) {
				return $user->isTherapist();
			});
		
		$supervisors = $users->filter(function ($user) {
				return $user->isSeniorTherapist();
			});
					
		$roles = $this->roleService
					->pushCriteria(new WhereIn('level', [2,3]))
					->all();
        return view('admin.dashboard.form-therapist')->with([
            'therapists' => $therapists,
			'roles' => $roles,
			'supervisors' => $supervisors
        ]);
	}
	
	/**
     * Creates a new therapist in the database.  Sends them a welcome email.
     *
     * @return Response
     */
	public function postInviteTherapist(TherapistInviteRequest $request)
	{
		$user = $this->user->invite($request->except(['_token', '_method','role_id']));
		$clinic = $request->attributes->get('clinic');
		if (! is_null($clinic)) {
            $this->user->assignClinic($clinic->id, $user->id,$request->role_id);
        } else {
			$this->user->assignClinic(false, $user->id,$request->role_id);
		}
		
		return redirect('admin/dashboard')->with([
            'message' => __('admin.form-client.created-therapist'),
        ]);
	}
	
	/**
     * Show the form for inviting a client.
     *
     * @return Response
     */
	public function getInviteClient()
	{
		$doctors = $this->doctorService->all();
		return view('admin.dashboard.form-client')->with([
            'doctors' => $doctors
        ]);
	}
	
	/**
     * Creates a new client in the database.  Sends them a welcome email.
     *
     * @return Response
     */
	public function postInviteClient(ClientInviteRequest $request)
	{
		$user = $this->user->invite($request->except(['_token', '_method','role_id','fees','language']));
		$clinic = $request->attributes->get('clinic');
		if (! is_null($clinic)) {
            $this->user->assignClinic($clinic->id, $user->id,$request->role_id);
        } else {
			$this->user->assignClinic(false, $user->id,$request->role_id);
		}
		
		return redirect('admin/dashboard')->with([
            'message' => __('admin.form-client.created-client'),
        ]);
	}

}
