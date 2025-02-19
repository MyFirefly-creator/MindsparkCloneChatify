<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Cek apakah pengguna sudah login
        if (!Auth::check()) {
            return redirect('/login');
        }

        // Cek apakah pengguna memiliki salah satu peran yang diizinkan
        if (!in_array(Auth::user()->role, $roles)) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}
