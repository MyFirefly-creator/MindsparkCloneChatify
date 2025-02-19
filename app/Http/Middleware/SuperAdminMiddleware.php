<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SuperAdminMiddleware
{
    /**
     * Handle an incoming request.
     */
        public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && in_array(Auth::user()->role, ['superadmin'])) {
            return $next($request);
        }

        return back()->with('error', 'Anda tidak memiliki izin untuk mengakses halaman ini.');
    }
}



