<?php

namespace App\Http\Middleware;

use App\Exceptions\NoSelectedClinicException;
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
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        Auth::user()->load('role');

        if (! $request->user()->isSuperAdmin()) {
            $clinics = Auth::user()->clinics;
            View::share('availableClinics', $clinics);
        }

        if (
            is_null($request->attributes->get('clinic')) &&
            ! $request->user()->isSuperAdmin()
        ) {
            throw new NoSelectedClinicException();
        }

        if (! is_null($request->attributes->get('clinic'))) {
            $currentClinic = $request->attributes->get('clinic');
            View::share('currentClinic', $currentClinic);
        }

        if (
            ! $request->user()->isSuperAdmin() &&
            ! $clinics->contains($currentClinic)
        ) {
            throw new NoSelectedClinicException();
        }

        return $next($request);
    }
}
