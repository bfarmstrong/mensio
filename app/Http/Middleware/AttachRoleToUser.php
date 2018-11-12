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

        if (
            ! is_null($request->attributes->get('clinic')) &&
            ! $request->user()->isSuperAdmin()
        ) {
            $currentClinic = $request->attributes->get('clinic');

            if (! $clinics->contains($currentClinic)) {
                return response()->view('errors.401', [], 401);
            } else {
                View::share('currentClinic', $currentClinic);
            }
        }

        return $next($request);
    }
}
