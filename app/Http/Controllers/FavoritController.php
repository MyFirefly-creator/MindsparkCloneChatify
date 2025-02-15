<?php

namespace App\Http\Controllers;

use App\Models\Favorit;
use Illuminate\Http\Request;

class FavoritController extends Controller
{
    public function index()
    {
        $favorits = Favorit::where('UserID', auth()->id())->with('buku')->get();
        return view('favorit.index', compact('favorits'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'BukuID' => 'required|exists:bukus,id'
        ]);

        Favorit::firstOrCreate([
            'UserID' => auth()->id(),
            'BukuID' => $request->BukuID
        ]);

        return redirect()->back()->with('success', 'Buku ditambahkan ke favorit.');
    }

    public function destroy($id)
    {
        $favorit = Favorit::where('UserID', auth()->id())->where('BukuID', $id)->first();

        if ($favorit) {
            $favorit->delete();
            return redirect()->back()->with('success', 'Buku dihapus dari favorit.');
        }

        return redirect()->back()->with('error', 'Buku tidak ditemukan di favorit.');
    }
}
