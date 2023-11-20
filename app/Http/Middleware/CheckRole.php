<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle($request, Closure $next, $role)
    {
        // Check if the user is authenticated and has the required role
        if (Auth::check() && Auth::user()->role == $role) {
            return $next($request);
        }

        // Redirect to home or show an error page
        return redirect('/')->with('error', 'Unauthorized access.');
    }
}
