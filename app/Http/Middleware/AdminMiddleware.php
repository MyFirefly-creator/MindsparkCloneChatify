<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
        public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && in_array(Auth::user()->role, ['admin', 'superadmin'])) {
            return $next($request);
        }

        return redirect()->route('dashboard.index')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }
}
