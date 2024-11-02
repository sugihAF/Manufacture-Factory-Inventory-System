<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class SupervisorMiddleware
{
    public function handle($request, Closure $next)
    {
        if (Auth::guard('supervisor')->check()) {
            return $next($request);
        }
        return redirect()->route('login')->with('error', 'Access denied.');
    }
}
