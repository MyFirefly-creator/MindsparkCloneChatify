<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KategoriController extends Controller
{
    public function index()
    {
        $user = Auth::User();

        $dataKategori = Kategori::orderBy('id', 'asc')->paginate(10);
        return view('kategori.index', compact('dataKategori','user'));
    }

    public function create()
    {
        if (!$this->isAdminOrSuperadmin()) {
            return redirect()->route('kategori.index')->with('error', 'Anda tidak memiliki akses untuk menambah kategori.');
        }

        return view('kategori.create');
    }

    public function store(Request $request)
    {
        if (!$this->isAdminOrSuperadmin()) {
            return redirect()->route('kategori.index')->with('error', 'Anda tidak memiliki akses untuk menambah kategori.');
        }

        $request->validate([
            'NamaKategori' => 'required|string|max:255'
        ]);

        Kategori::create([
            'NamaKategori' => $request->NamaKategori,
            'UserID' => Auth::id(),
        ]);

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function edit($id)
    {
        if (!$this->isAdminOrSuperadmin()) {
            return redirect()->route('kategori.index')->with('error', 'Anda tidak memiliki akses untuk mengedit kategori ini.');
        }

        $kategori = Kategori::findOrFail($id);
        return view('kategori.edit', compact('kategori'));
    }

    public function update(Request $request, $id)
    {
        if (!$this->isAdminOrSuperadmin()) {
            return redirect()->route('kategori.index')->with('error', 'Anda tidak memiliki akses untuk mengedit kategori ini.');
        }

        $kategori = Kategori::findOrFail($id);

        $request->validate([
            'NamaKategori' => 'required|string|max:255'
        ]);

        $kategori->update([
            'NamaKategori' => $request->NamaKategori
        ]);

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diperbarui!');
    }

    public function destroy($id)
    {
        if (!$this->isAdminOrSuperadmin()) {
            return redirect()->route('kategori.index')->with('error', 'Anda tidak memiliki akses untuk menghapus kategori ini.');
        }

        $kategori = Kategori::findOrFail($id);
        $kategori->delete();

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil dihapus!');
    }

    private function isAdminOrSuperadmin()
    {
        return Auth::check() && in_array(Auth::user()->role, ['admin', 'superadmin']);
    }
}
