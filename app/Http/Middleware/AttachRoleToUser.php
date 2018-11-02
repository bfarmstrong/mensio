<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Clinic;
use Config;
use App\Services\Impl\IClinicService;
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
        IClinicService $clinicservice
    ) {
		$this->clinicservice = $clinicservice;
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
			$clinic = $this->clinicservice->findBy('subdomain',Config::get('subdomain'));
			$count = $clinic->users()->where('user_id',\Auth::user()->id)->count();
			if($count == 0 ){
				return response()->view('errors.401', [], 401);
			}
		}
		
			\Auth::user()->load('role');
			return $next($request);
		
    }
}
