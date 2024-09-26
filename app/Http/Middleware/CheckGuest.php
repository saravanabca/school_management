<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckGuest
{
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            // Redirect to dashboard or another route if user is authenticated
            return redirect('/dashboard');
        }

        return $next($request);
    }
}