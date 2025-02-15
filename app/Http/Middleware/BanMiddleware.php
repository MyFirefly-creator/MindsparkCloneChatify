<?php

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Ban;

class BanMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if ($user) {
            $ban = Ban::where('UserID', $user->id)->first();

            if ($ban && Carbon::now('Asia/Jakarta')->lessThan($ban->Ban_Until)) {
                return redirect()->route('ban.index');
            } elseif ($ban && Carbon::now('Asia/Jakarta')->greaterThanOrEqualTo($ban->Ban_Until)) {
                $ban->delete(); // Hapus ban jika waktu telah habis
            }
        }

        return $next($request);
    }
}
