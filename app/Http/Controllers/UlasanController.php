<?php

namespace App\Http\Controllers;

use App\Models\Ulasan;
use Illuminate\Http\Request;

class UlasanController extends Controller
{

    public function store(Request $request)
    {
        $request->validate([
            'BukuID' => 'required|exists:bukus,id',
            'Ulasan' => 'required|string',
            'Rating' => 'required|integer|min:1|max:5',
        ]);

        Ulasan::create([
            'UserID' => auth()->id(),
            'BukuID' => $request->BukuID,
            'Ulasan' => $request->Ulasan,
            'Rating' => $request->Rating,
        ]);

        return redirect()->back()->with('success', 'Ulasan berhasil ditambahkan.');
    }
}
