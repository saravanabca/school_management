<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckAuth
{
    public function handle($request, Closure $next)
    {
        if (!Auth::check()) {
            // Redirect to login page if user is not authenticated
            return redirect('/');
        }

        return $next($request);
    }
}