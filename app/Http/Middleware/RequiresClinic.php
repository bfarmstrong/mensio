<?php

namespace App\Http\Middleware;

use App\Exceptions\NoSelectedClinicException;
use Closure;

/**
 * Middleware which requires that a clinic is selected for a particular route.
 */
class RequiresClinic
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
        if (is_null($request->attributes->get('clinic'))) {
            throw new NoSelectedClinicException();
        }

        return $next($request);
    }
}
