<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Ban;
use App\Models\User;
use App\Models\Warning;
use Illuminate\Http\Request;

class BanController extends Controller
{
    public function index()
    {
        $users = User::all();
        $warnings = Warning::all();
        $pelanggaranOptions = Warning::distinct()->pluck('jenis_pelanggaran_id');
        $ban = Ban::where('UserID', auth()->id())->latest()->first();

        return view('ban.index', compact('users', 'warnings', 'pelanggaranOptions','ban'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'Deskripsi' => 'required|string|max:255',
            'duration' => 'required|numeric',
            'unit' => 'required|in:minutes,hours,days',
            'user_id' => 'required|exists:users,id',
        ]);

        // Set timezone Asia/Jakarta
        $now = Carbon::now('Asia/Jakarta');

        $banUntil = match ($request->unit) {
            'minutes' => $now->copy()->addMinutes($request->duration),
            'hours' => $now->copy()->addHours($request->duration),
            'days' => $now->copy()->addDays($request->duration),
        };

        $ban = new Ban();
        $ban->Deskripsi = $request->Deskripsi;
        $ban->Ban_Until = $banUntil;
        $ban->UserID = $request->user_id;
        $ban->save();

        return redirect()->route('admin.users')->with('success', 'User berhasil di-banned.');
    }
}
