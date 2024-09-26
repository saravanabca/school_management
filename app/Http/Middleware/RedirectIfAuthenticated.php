<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next,$guard)
    {
        // If the user is authenticated, redirect them to the dashboard
        if (Auth::guard($guard)->check()) {
            return redirect()->url('dashboard'); // Adjust to your login route

        }

        return $next($request);
    }
}