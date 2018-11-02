<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserInviteRequest;
use App\Services\Criteria\General\OrderBy;
use App\Services\Criteria\General\WithRelation;
use App\Services\Criteria\User\WithRole;
use App\Services\Criteria\User\WhereClient;
use App\Services\Criteria\User\WhereTherapist;
use App\Services\Impl\IDoctorService;
use App\Services\Impl\IRoleService;
use App\Services\Impl\IUserService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Services\Impl\IClinicService;
use App\Services\Criteria\General\WhereEqual;
use App\Http\Requests\Admin\AdminAssignClinicRequest;
use Config;
/**
 * Manages administrative actions against users.
 */
class UserController extends Controller
{
    /**
     * The doctor service implementation.
     *
     * @var IDoctorService
     */
    protected $doctorService;

    /**
     * The role service implementation.
     *
     * @var IRoleService
     */
    protected $roleService;

    /**
     * The user service implementation.
     *
     * @var IUserService
     */
    protected $userService;

    /**
     * Creates an instance of `UserController`.
     *
     * @param IDoctorService $doctorService
     * @param IRoleService   $roleService
     * @param IUserService   $userService
     */
    public function __construct(
        IDoctorService $doctorService,
        IRoleService $roleService,
        IUserService $userService,
		IClinicService $clinicservice
    ) {
        $this->doctorService = $doctorService;
        $this->roleService = $roleService;
        $this->userService = $userService;
		$this->clinicservice = $clinicservice;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
		if (request()->user()->isSuperAdmin()) {
			$users = $this->userService
				->getByCriteria(new WithRole())
				->paginate();
		} else {
			$users = $this->userService
				->getByCriteria(new WithRole())
				->getByCriteria(new WhereEqual('is_active', 1))
				->paginate();
		}
        return view('admin.users.index')->with([
            'users' => $users,
        ]);
    }

    /**
     * Display a listing of the resource searched.
     *
     * @return Response
     */
    public function search(Request $request)
    {
        if (! $request->search) {
            return redirect('admin/users');
        }
		if (request()->user()->isSuperAdmin()) {
			$users = $this->userService
				->getByCriteria(new WithRole())
				->search($request->search);
		} else {
 
			$users = $this->userService
				->getByCriteria(new WithRole())
				->getByCriteria(new WhereEqual('is_active', 1))
				->search($request->search);
		}
        if ($users->isNotEmpty()) {
            if (1 === $users->count()) {
                $user = $users->first();

                return redirect("admin/users/$user->id");
            }

            return view('admin.users.index')->with([
                'users' => $users,
            ]);
        }

        return redirect()->back()->withErrors([
            __('admin.users.index.no-search-results'),
        ]);
    }

    /**
     * Show the form for inviting a customer.
     *
     * @return Response
     */
    public function getInvite()
    {
        $doctors = $this->doctorService->all();
        $roles = $this->roleService->all();

        return view('admin.users.invite', [
            'doctors' => $doctors,
            'roles' => $roles,
        ]);
    }

    /**
     * Creates a new user in the database.  Sends them a welcome email.
     *
     * @return Response
     */
    public function postInvite(UserInviteRequest $request)
    {
		$user = $this->userService->invite($request->except(['_token', '_method']));
		$clinic = $this->clinicservice->findBy('subdomain',Config::get('subdomain'));
		$this->userService->assignClinic($clinic->id,$user->id);
	
        return redirect('admin/users')->with([
            'message' => __('admin.users.index.created-user'),
        ]);
    }

    /**
     * Switch to a different User profile.
     *
     * @param string $id
     *
     * @return Response
     */
    public function switchToUser(string $id)
    {
        $user = $this->userService->find($id);
        $this->userService->switchToUser($id);

        return redirect('dashboard')->with([
            'message' => __('admin.users.index.switched-to', [
                'user' => $user->name,
            ]),
        ]);
    }

    /**
     * Switch back to your original user.
     *
     * @return Response
     */
    public function switchUserBack()
    {
        $this->userService->switchBack();

        return redirect('admin/dashboard')->with([
            'message' => __('admin.users.index.switched-back'),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param string $id
     *
     * @return Response
     */
    public function edit(string $id)
    {
        $user = $this->userService->getByCriteria(new WithRole())->find($id);

        if (is_null($user)) {
            abort(404);
        }

        $doctors = $this->doctorService
            ->getByCriteria(new OrderBy('is_default', 'desc'))
            ->getByCriteria(new OrderBy('name'))
            ->all();
        $roles = $this->roleService->all();

        return view('admin.users.edit')->with([
            'doctors' => $doctors,
            'roles' => $roles,
            'user' => $user,
        ]);
    }

    /**
     * Shows the page to view static user information.
     *
     * @param string $id
     *
     * @return Response
     */
    public function show(string $id)
    {
        $user = $this->userService
            ->pushCriteria(new WithRelation('doctor'))
            ->pushCriteria(new WithRelation('referrer'))
            ->pushCriteria(new WithRelation('role'))
            ->find($id);

        if (is_null($user)) {
            abort(404);
        }

        return view('admin.users.show')->with([
            'user' => $user,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param string  $id
     *
     * @return Response
     */
    public function update(Request $request, string $id)
    { 
        $this->userService->update(
            $id,
            $request->except(['_token', '_method'])
        );

        return back()->with([
            'message' => __('admin.users.index.updated-user'),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param string $id
     *
     * @return Response
     */
    public function destroy(string $id)
    {
		if (request()->user()->isSuperAdmin()) {
			$this->userService->delete($id);
		}
        return redirect('admin/users')->with([
            'message' => __('admin.users.index.deleted-user'),
        ]);
    }
	
	
	/**
     * Show the form to assign a clinic.
     *
     * @return Response
    */	
	public function getassignclinic()
	{
		
		$clinic = $this->clinicservice->findBy('subdomain',Config::get('subdomain'));
			
        return view('admin.users.clinics.form-assignclinic', [
            'clinic' => $clinic,
        ]);
	}
	
	/**
     * assign a user to clinic.
     *
     * @return Response
    */
	public function postassignclinic(AdminAssignClinicRequest $request)
	{
		
		$clinic = $this->clinicservice->findBy('subdomain',Config::get('subdomain'));
		$clients = $this->userService
				->findBy('health_card_number',$request->health_card_number)
				->all();

		foreach($clients as $client){
			$this->userService->assignClinic($clinic->id,$client->id);
		}
		
		return redirect('admin/users')->with([
            'message' => __('clinic assigned'),
        ]);
	}
	
	/**
     * activate a user.
     *
     * @return Response
    */
	public function activateUser(string $id){

        if (is_null($id)) {
            abort(404);
        }
		$this->userService->update(
            $id,
            ['is_active'=>0]
        );
        return redirect('admin/users')->with([
            'message' => __('admin.users.index.inactive-user'),
        ]);
	}
}
