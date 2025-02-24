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
    public function index(Request $request)
    {
        $user = Auth::user();
        $search = $request->get('search', '');

        $peminjaman = Peminjaman::with(['user', 'buku'])
            ->when($search, function ($query, $search) {
                return $query->whereHas('user', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('nis', 'like', "%{$search}%");
                });
            })
            ->paginate(10);

        return view('peminjaman.index', compact('peminjaman', 'search','user'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
{
    $loggedInUser = Auth::user();

    if ($loggedInUser->role == 'admin') {
        return redirect()->route('admin.index')->with('error', 'Access denied for admin users.');
    }

    $bukus = Buku::all();
    $users = User::all();

    if ($request->has('query')) {
        $query = $request->get('query');
        $books = Buku::where('NamaBuku', 'LIKE', '%' . $query . '%')->get();
        return response()->json($books);
    }

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

    // Create the new borrowing record
    Peminjaman::create([
        'UserID' => auth()->id(),
        'BukuID' => $request->BukuID,
        'TanggalPeminjaman' => now()->format('Y-m-d'),
        'TanggalPengembalian' => now()->addDays(7)->format('Y-m-d'),
        'StatusPeminjaman' => 'pending',
    ]);

    return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil!');
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
            return redirect()->route('admin.index')->with('error', 'Access denied for admin users.');
        }

        $bukus = Buku::all();
        $users = User::all();
        return view('peminjaman.edit', compact('peminjaman','bukus', 'users', 'loggedInUser'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'UserID' => 'required|exists:users,id',
            'BukuID' => 'required|exists:bukus,id',
            'TanggalPeminjaman' => 'required|date',
            'TanggalPengembalian' => 'required|date|after_or_equal:TanggalPeminjaman',
            'StatusPeminjaman' => 'required|in:dipinjam,dikembalikan,pending',
        ]);

        $peminjaman = Peminjaman::find($id);
        $buku = Buku::find($peminjaman->BukuID);

        $statusLama = $peminjaman->StatusPeminjaman;
        $statusBaru = $request->StatusPeminjaman;

        // Debugging

        if ($statusBaru === 'dipinjam' && $statusLama !== 'dipinjam') {
            if ($buku->stokBuku > 0) {
                $buku->stokBuku -= 1;
                $buku->save();
            } else {
                return redirect()->back()->with('error', 'Stok buku habis!');
            }
        }

        if ($statusBaru === 'dikembalikan') {
            $buku->stokBuku += 1;
            $buku->save();

            $peminjaman->StatusPeminjaman = $statusBaru;
            $peminjaman->save();

            return redirect()->route('peminjaman.index')->with('success', 'Buku berhasil dikembalikan!');
        }

        $peminjaman->StatusPeminjaman = $statusBaru;
        $peminjaman->save();

        return redirect()->route('peminjaman.index')->with('success', 'Status peminjaman berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Peminjaman $peminjaman)
    {
        $peminjaman->delete();
        return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil dihapus!');
    }


    public function laporan(Request $request)
    {
        $user = auth()->user();

        $query = Peminjaman::with('buku', 'user')->where('UserID', $user->id);

        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('TanggalPeminjaman', [$request->start_date, $request->end_date]);
        }

        $peminjaman = $query->get();

        if ($peminjaman->isEmpty()) {
            return back()->with('error', 'Tidak ada data peminjaman pada rentang tanggal yang dipilih.');
        }

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

    public function search(Request $request)
    {
        $query = $request->get('query');

        $books = Buku::where('NamaBuku', 'LIKE', '%' . $query . '%')->get();

        return response()->json($books);
    }

}
