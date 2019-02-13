<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Criteria\General\WithRelation;
use App\Services\Criteria\General\WhereEqual;
use App\Services\Criteria\General\WhereRelationEqual;
use App\Services\Impl\IClinicService;
use App\Services\Impl\IDoctorService;
use App\Services\Impl\IRoleService;
use App\Services\Impl\IUserService;
use Route;

class DashboardController extends Controller
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
     * Dashboard.
     *
     * @return \Illuminate\Http\Response
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


			$users = $query->paginate();

			$clients = $users->filter(function ($user) {
				return $user->isClient();
			});

			$therapists = $users->filter(function ($user) {
				return $user->isTherapist();
			});
			
			$admin = $users->filter(function ($user) {
				return $user->isAdmin();
			});

        return view('admin.dashboard.dashboard')->with([
				'clients' => $clients,
				'therapists' => $therapists,
				'admin' => $admin,
				'users' => $users,
				//'type' => $type,
			]);
    }
}
