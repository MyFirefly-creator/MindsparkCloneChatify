<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\User;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class PeminjamanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::User();

        $peminjaman = Peminjaman::where('StatusPeminjaman', 'Dipinjam')->paginate(10);
        return view('peminjaman.index', compact('peminjaman','user'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $loggedInUser = Auth::user();

        if ($loggedInUser->role == 'admin') {
            return redirect()->route('home')->with('error', 'Access denied for admin users.');
        }

        $bukus = Buku::all();
        $users = User::all();

        return view('peminjaman.create', compact('bukus', 'users', 'loggedInUser'));
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'UserID' => 'required|exists:users,id',
            'BukuID' => 'required|exists:bukus,id',
            'TanggalPeminjaman' => 'required|date',
            'TanggalPengembalian' => 'required|date|after:TanggalPeminjaman',
        ]);

        Peminjaman::create([
            'UserID' => auth()->id(),
            'BukuID' => $request->BukuID,
            'TanggalPeminjaman' => now()->format('Y-m-d'),
            'TanggalPengembalian' => now()->addDays(7)->format('Y-m-d'),
            'StatusPeminjaman' => 'dipinjam',
        ]);

        return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil ditambahkan!');
    }


    /**
     * Display the specified resource.
     */

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Peminjaman $peminjaman)
    {
        $loggedInUser = Auth::user();

        if ($loggedInUser->role == 'admin') {
            return redirect()->route('home')->with('error', 'Access denied for admin users.');
        }

        $bukus = Buku::all();
        $users = User::all();
        return view('peminjaman.edit', compact('peminjaman','bukus', 'users', 'loggedInUser'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Peminjaman $peminjaman)
    {
        $request->validate([
            'BukuID' => 'required|exists:bukus,id',
            'TanggalPeminjaman' => 'nullable|date',
            'TanggalPengembalian' => 'nullable|date|after:TanggalPeminjaman',
            'StatusPeminjaman' => 'required|in:dipinjam,dikembalikan',
        ]);

        $data = [
            'BukuID' => $request->BukuID,
            'StatusPeminjaman' => $request->StatusPeminjaman,
        ];

        if ($request->has('TanggalPeminjaman') && $request->TanggalPeminjaman) {
            $data['TanggalPeminjaman'] = $request->TanggalPeminjaman;
        }

        if ($request->has('TanggalPengembalian') && $request->TanggalPengembalian) {
            $data['TanggalPengembalian'] = $request->TanggalPengembalian;
        }

        $peminjaman->update($data);

        return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Peminjaman $peminjaman)
    {
        $peminjaman->delete();
        return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil dihapus!');
    }

    public function laporan()
    {
        $user = auth()->user();

        $peminjaman = Peminjaman::with('buku', 'user')
                                ->where('UserID', $user->id)
                                ->get();

        $pdf = Pdf::loadView('peminjaman.laporan', compact('peminjaman'));

        return $pdf->download('laporan_peminjaman.pdf');
    }


    public function showUserHistory($userId)
    {
        $peminjaman = Peminjaman::with('buku')
                                ->where('UserID', $userId)
                                ->get();

        return view('peminjaman.show', compact('peminjaman'));
    }
}
