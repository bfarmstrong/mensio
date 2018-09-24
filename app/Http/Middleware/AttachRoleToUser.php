<?php

namespace App\Http\Middleware;

use Closure;

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
        \Auth::user()->load('role');

        return $next($request);
    }
}
