<?php

namespace App\Http\Middleware;

use App\Models\Clinic;
use App\Services\Impl\IClinicService;
use App\Services\Impl\IUserService;
use Auth;
use Closure;
use View;

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
        if (
            ! is_null($request->attributes->get('clinic')) &&
            ! $request->user()->isSuperAdmin()
        ) {
            $clinics = Auth::user()->clinics;
            $currentClinic = $request->attributes->get('clinic');

            if (! $clinics->contains($currentClinic)) {
                return response()->view('errors.401', [], 401);
            } else {
                View::share('currentClinic', $currentClinic);
                View::share('availableClinics', $clinics);
            }
        }

        Auth::user()->load('role');

        return $next($request);
    }
}
