<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class FactoryMiddleware
{
    public function handle($request, Closure $next)
    {
        if (Auth::guard('factory')->check()) {
            return $next($request);
        }
        return redirect()->route('login')->with('error', 'Access denied.');
    }
}
