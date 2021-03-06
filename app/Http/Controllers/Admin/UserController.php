<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Roles;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminAssignClinicRequest;
use App\Http\Requests\UserInviteRequest;
use App\Services\Criteria\General\OrderBy;
use App\Services\Criteria\General\WhereEqual;
use App\Services\Criteria\General\WhereRelationEqual;
use App\Services\Criteria\General\WhereRelationNotEqual;
use App\Services\Criteria\General\WithRelation;
use App\Services\Criteria\User\WhereTherapist;
use App\Services\Criteria\User\WithRole;
use App\Services\Impl\IClinicService;
use App\Services\Impl\IDoctorService;
use App\Services\Impl\IRoleService;
use App\Services\Impl\IUserService;
use Config;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Route;
use App\Services\Criteria\General\WhereNotEqual;
use Yajra\Datatables\Datatables;

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
     * The clinic service implementation.
     *
     * @var IClinicService
     */
    protected $clinicservice;

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
        $query = $this->userService
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

        $type = Route::currentRouteName();
        if ('admin.clients' === $type) {
            $type = 'clients';
            $query = $query->pushCriteria(
                new WhereRelationEqual(
                    'roles',
                    'level',
                    Roles::Client
                )
            );
        } elseif ('admin.therapists' === $type) {
            $type = 'therapists';
            $query = $query->pushCriteria(
                new WhereRelationNotEqual(
                    'roles',
                    'level',
                    Roles::Client
                )
            );
        }

        // Data tables support.  Utilizes the existing query.
        if (request()->expectsJson()) {
            $query->applyCriteria();

            return DataTables::of($query->getModel())->toJson();
        }

        $users = $query->paginate();

        $clients = $users->filter(function ($user) {
            return $user->isClient();
        });

        $therapists = $users->filter(function ($user) {
            return $user->isTherapist() || $user->isAdmin();
        });

        return view('admin.users.index')->with([
            'clients' => $clients,
            'therapists' => $therapists,
            'type' => $type,
            'users' => $users,
        ]);
    }
	/**
     * Display a listing of the therapist.
     *
     * @return Response
     */
    public function gettherapists()
    {
        if (request()->user()->isSuperAdmin()) {
            $users = $this->userService
                ->pushCriteria(new WithRole())
				->pushCriteria(new WhereTherapist())
                ->pushCriteria(new WhereEqual('is_active', 1))
                ->all();
        } else {
            $user_id = UserClinic::where(
                'clinic_id',
                request()->attributes->get('clinic')->id
            )->pluck('user_id');
            $users = $this->userService
                ->pushCriteria(new WithRole())
                ->pushCriteria(new WhereEqual('is_active', 1))
				->pushCriteria(new WhereTherapist())
                ->pushCriteria(new WhereIn('id', $user_id))
                ->all();
        }

        return view('admin.users.index')->with([
            'therapists' => $users,
        ]);
    }
	/**
     * Display a listing of the clients.
     *
     * @return Response
     */
    public function getclients()
    {
        if (request()->user()->isSuperAdmin()) {
            $users = $this->userService
                ->pushCriteria(new WithRole())
				->pushCriteria(new WhereRelationEqual('roles', 'level', 1))
                ->pushCriteria(new WhereEqual('is_active', 1))
                ->all();
        } else {
            $user_id = UserClinic::where(
                'clinic_id',
                request()->attributes->get('clinic')->id
            )->pluck('user_id');
            $users = $this->userService
                ->pushCriteria(new WithRole())
                ->pushCriteria(new WhereEqual('is_active', 1))
				->pushCriteria(new WhereRelationEqual('roles', 'level', 1))
                ->pushCriteria(new WhereIn('id', $user_id))
                ->all();
        }

        return view('admin.users.index')->with([
            'clients' => $users,
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
                ->pushCriteria(new WithRole())
                ->pushCriteria(new WhereEqual('is_active', 1))
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
		if (request()->user()->isSuperAdmin()) {
			$roles = $this->roleService->all();
		} else {
			$roles = $this->roleService
					->pushCriteria(new WhereNotEqual('level',5))
					->all();
		}
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
        $user = $this->userService->invite($request->except(['_token', '_method','role_id']));
        $clinic = $request->attributes->get('clinic');
        if (! is_null($clinic)) {
            $this->userService->assignClinic($clinic->id, $user->id,$request->role_id);
        } else {
			$this->userService->assignClinic(false, $user->id,$request->role_id);
		}

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
     * Switch to a different clinic.
     *
     * @param string $id
     *
     * @return Response
     */
    public function switchToClinic(Request $request)
    {
        $explodehost = explode('://', env('APP_URL'));
        $host = $explodehost[0];
        $maindomain = $explodehost[1];
        $clinic = $this->clinicservice->find($request->clinic_id);
        $current_clinic = $this->clinicservice->findBy('subdomain', Config::get('subdomain'));
        $user = \Auth::id();

        return redirect($host.'://'.$clinic->subdomain.'.'.$maindomain.'/sessionlogin/'.$user.'/'.$current_clinic->id);
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
     * Switch back to your original user.
     *
     * @return Response
     */
    public function switchClinicBack()
    {
        $explodehost = explode('://', env('APP_URL'));
        $host = $explodehost[0];
        $maindomain = $explodehost[1];
        $subdomainback = $this->clinicservice->switchBackClinic();

        return redirect($host.'://'.$subdomainback.'.'.$maindomain.'/admin/dashboard');
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
            ->pushCriteria(new WithRelation('clinics'))
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
            $request->except(['_token', '_method','role_id'])
        );
		if (Config::get('subdomain') != ''){
			$clinic = $this->clinicservice->findBy('subdomain', Config::get('subdomain'));
			$this->userService->assignClinic($clinic->id, $id, $request->role_id);

		} else {
			$this->userService->assignClinic(false, $id, $request->role_id);
		}
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
        $clinic = $this->clinicservice->findBy('subdomain', Config::get('subdomain'));

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
        $clinic = $this->clinicservice->findBy('subdomain', Config::get('subdomain'));

        $clients = $this->userService
                ->getByCriteria(new WithRole())
                ->getByCriteria(new WhereEqual('is_active', 1))
                ->searchencryptedcolumn($request->health_card_number, 'health_card_number_bidx');

        foreach ($clients as $client) {
            $this->userService->assignClinic($clinic->id, $client->id);
        }

        return redirect('admin/users')->with([
            'message' => __('admin.users.index.clinic-assigned'),
        ]);
    }

    /**
     * Deactivates a user account.  Makes it so that they can no longer use the
     * system.
     *
     * @param string $id
     *
     * @return Response
     */
    public function inactivateUser(string $id)
    {
        $user = $this->userService->find($id);
        $this->userService->update(
            $user,
            ['is_active' => 0]
        );

        return redirect('admin/users')->with([
            'message' => __('admin.users.index.inactive-user'),
        ]);
    }

    /**
     * Activates a user, allowing them to once again use the system.
     *
     * @param string $id
     *
     * @return Response
     */
    public function activateUser(string $id)
    {
        $user = $this->userService->find($id);
        $this->userService->update(
            $user,
            ['is_active' => 1]
        );

        return redirect('admin/users')->with([
            'message' => __('admin.users.index.active-user'),
        ]);
    }

    /**
     * Specified resource to set for session.
     *
     * @param string $id
     * @param string $clinic_id
     *
     * @return Response
     */
    public function setsession(string $id, string $clinic_id)
    {
        $this->clinicservice->switchToClinic($id, $clinic_id);

        return redirect('admin/dashboard');
    }
}
