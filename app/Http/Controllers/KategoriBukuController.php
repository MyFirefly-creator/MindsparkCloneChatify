<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\KategoriBuku as KategoriBukuModel;

class KategoriBukuController extends Controller
{
    public function index()
    {
        $user = Auth::User();

        $kategoriBuku = KategoriBukuModel::paginate(10);
        return view('kategori_buku.index', compact('kategoriBuku','user'));
    }

    public function create()
    {
        $user = Auth::User();
        $bukus = Buku::all();
        $kategoris = Kategori::all();
        return view('kategori_buku.create', compact('user', 'bukus','kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'BukuID' => 'required|exists:bukus,id',
            'KategoriID' => 'required|exists:kategoris,id',
        ]);

        KategoriBukuModel::create([
            'BukuID' => $request->BukuID,
            'KategoriID' => $request->KategoriID,
        ]);

        return redirect()->route('kategori_buku.index')->with('success', 'Kategori Buku berhasil ditambahkan!');
    }

    public function edit(KategoriBukuModel $kategoriBuku)
    {
        $user = Auth::User();
        $bukus = Buku::all();
        $kategoris = Kategori::all();
        return view('kategori_buku.edit', compact('kategoriBuku','user', 'bukus','kategoris'));
    }

    public function update(Request $request, KategoriBukuModel $kategoriBuku)
    {
        $request->validate([
            'BukuID' => 'required|exists:bukus,id',
            'KategoriID' => 'required|exists:kategoris,id',
        ]);

        $kategoriBuku->update($request->only(['BukuID', 'KategoriID']));

        return redirect()->route('kategori_buku.index')->with('success', 'Kategori Buku berhasil diperbarui!');
    }

    public function destroy(KategoriBukuModel $kategoriBuku)
    {
        $kategoriBuku->delete();
        return redirect()->route('kategori_buku.index')->with('success', 'Kategori Buku berhasil dihapus!');
    }
}
