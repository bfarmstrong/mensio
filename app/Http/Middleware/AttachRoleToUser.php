<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Clinic;
use Config;
use App\Services\Impl\IClinicService;
use App\Services\Impl\IUserService;
use Illuminate\Support\Facades\URL;

/**
 * Middleware which attaches the user role to the user object so that it does
 * not have to be queried multiple times when doing permission checks.
 */
class AttachRoleToUser
{
	/**
     * The clinic service implementation.
     *
     * @var IClinicService
    */
	public function __construct(
        IClinicService $clinicservice,
		IUserService $userService
    ) {
		$this->clinicservice = $clinicservice;
		$this->userService = $userService;
    }
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    { 
		if (Config::get('subdomain') != '' && !$request->user()->isSuperAdmin()){
			$UserAssignedClinic = array('Switch Clinic');
			$url = parse_url(URL::current());
			$domain = explode('.', $url['host']);
			$subdomain = $domain[0];
			$clinic = $this->clinicservice->findBy('subdomain',Config::get('subdomain'));
			$count = $clinic->users()->where('user_id',\Auth::user()->id)->count();
			$assignedClinics = $this->userService->find(\Auth::user()->id);
			if($count == 0 ){
				return response()->view('errors.401', [], 401);
			} else {
				$UserClinic = $assignedClinics->clinics->pluck('name','id'); 
				foreach($UserClinic as $k => $v){
					if($subdomain != strtolower($v)){
						$UserAssignedClinic[$k] = $v;
					}
				}
				\View::share('totalClinicAssign',$assignedClinics->clinics->count());
				\View::share('assignedClinics',$UserAssignedClinic);
			}
		}
		
			\Auth::user()->load('role');
			return $next($request);
		
    }
}
