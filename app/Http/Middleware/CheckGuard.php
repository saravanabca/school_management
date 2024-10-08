<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckGuard
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard)
    {
        if (!Auth::guard($guard)->check()) {
            return redirect('/'); 
        }

        return $next($request);
    }
}