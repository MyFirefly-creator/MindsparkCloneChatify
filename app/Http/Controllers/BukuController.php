<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\KategoriBuku;
use App\Models\User;
use App\Models\Ulasan;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class BukuController extends Controller
{
    public function index()
    {
        $user = Auth::User();

        $dataBuku = Buku::orderBy('id', 'asc')->paginate(10);
        return view('buku.index', compact('dataBuku','user'));
    }

    public function create()
    {
        if (!$this->isAdminOrSuperadmin()) {
            return redirect()->route('buku.index')->with('error', 'Anda tidak memiliki akses untuk menambah buku.');
        }

        return view('buku.create');
    }

    public function store(Request $request)
    {
        if (!$this->isAdminOrSuperadmin()) {
            return redirect()->route('buku.index')->with('error', 'Anda tidak memiliki akses untuk menambah buku.');
        }


        $request->validate([
            'NamaBuku' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'penerbit' => 'required|max:255|string',
            'penulis' => 'required|max:255|string',
            'tanggal_terbit' => 'required|date',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:204800'
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('buku', 'public');
        } else {
            return back()->with('error', 'Foto tidak ditemukan');
        }

        $tanggal_terbit = Carbon::createFromFormat('Y-m-d', $request->tanggal_terbit, 'Asia/Jakarta');

        $buku = new Buku();
        $buku->NamaBuku = $request->NamaBuku;
        $buku->deskripsi = $request->deskripsi;
        $buku->penerbit = $request->penerbit;
        $buku->penulis = $request->penulis;
        $buku->tanggal_terbit = $tanggal_terbit;
        $buku->image = $path;
        $buku->save();

        return redirect()->route('buku.index')->with('success', 'Buku berhasil ditambahkan.');
    }


    public function show($id)
    {
        $buku = Buku::findOrFail($id);
        $ulasans = Ulasan::where('BukuID', $id)->with('user')->get();
        $kategoribuku = $buku->kategoris;
        $averageRating = $buku->ulasans()->avg('rating');

        $peminjamanTerakhir = $buku->peminjamans()->latest()->first();
        $sedangDipinjam = $peminjamanTerakhir && $peminjamanTerakhir->status === 'dipinjam';

        $relatedBooks = Buku::inRandomOrder()->limit(5)->get();

        return view('buku.show', compact('buku', 'sedangDipinjam', 'peminjamanTerakhir','relatedBooks','ulasans','kategoribuku','averageRating'));
    }

    public function edit($id)
    {
        if (!$this->isAdminOrSuperadmin()) {
            return redirect()->route('buku.index')->with('error', 'Anda tidak memiliki akses untuk mengedit buku ini.');
        }

        $buku = Buku::findOrFail($id);
        return view('buku.edit', compact('buku'));
    }

    public function update(Request $request, $id)
    {
        if (!$this->isAdminOrSuperadmin()) {
            return redirect()->route('buku.index')->with('error', 'Anda tidak memiliki akses untuk mengedit buku ini.');
        }

        $buku = Buku::findOrFail($id);

        $request->validate([
            'NamaBuku' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'penerbit' => 'required|max:255|string',
            'penulis' => 'required|max:255|string',
            'tanggal_terbit' => 'required|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $data = $request->only(['NamaBuku', 'deskripsi', 'penerbit', 'penulis']);
        $data['tanggal_terbit'] = Carbon::parse($request->tanggal_terbit)->timezone('Asia/Jakarta');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('buku', 'public');
        }

        $buku->update($data);

        return redirect()->route('buku.index')->with('success', 'Buku berhasil diperbarui.');
    }


    public function destroy($id)
    {
        if (!$this->isAdminOrSuperadmin()) {
            return redirect()->route('buku.index')->with('error', 'Anda tidak memiliki akses untuk menghapus buku ini.');
        }

        $buku = Buku::findOrFail($id);
        $buku->delete();

        return redirect()->route('buku.index')->with('success', 'Buku berhasil dihapus.');
    }

    private function isAdminOrSuperadmin()
    {
        return Auth::check() && in_array(Auth::user()->role, ['admin', 'superadmin']);
    }
}
