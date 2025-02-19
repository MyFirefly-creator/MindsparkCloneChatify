<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index()
    {
        return view('sesi.index');
    }

    public function loginForm()
    {
        return view('sesi.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'nis' => 'required',
            'password' => 'required',
        ]);

        $user = User::where('nis', $request->nis)->first();

        if (!$user) {
            return back()->with('error', 'NIS tidak ditemukan.');
        }

        if ($user->status_verifikasi == 'pending') {
            return back()->with('error', 'Akun Anda belum diverifikasi oleh admin.');
        }

        if ($user->status_verifikasi == 'ditolak') {
            return back()->with('error', 'Pendaftaran Anda ditolak.');
        }

        if (Auth::attempt(['nis' => $request->nis, 'password' => $request->password])) {
            return redirect()->route('dashboard.index');
        }

        return back()->with('error', 'NIS atau password salah.');
    }

    public function registerForm()
    {
        return view('sesi.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'nis' => 'nullable|numeric|unique:users',
            'name' => 'required|string|max:255',
            'email' => 'required|unique:users,email|string|max:255',
            'alamat' => 'required|string|max:255',
            'password' => 'required|min:6|confirmed',
            'foto_ktp' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'foto_diri' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $fotoKtpPath = $request->file('foto_ktp')->store('uploads/ktp', 'public');
        $fotoDiriPath = $request->file('foto_diri')->store('uploads/diri', 'public');

        User::create([
            'nis' => $validated['nis'],
            'password' => Hash::make($validated['password']),
            'name' => $validated['name'],
            'alamat' => $validated['alamat'],
            'email' => $validated['email'],
            'role' => 'user',
            'avatar' => 'profil/avatar.png',
            'foto_ktp' => $fotoKtpPath,
            'foto_diri' => $fotoDiriPath,
            'status_verifikasi' => 'pending',
        ]);

        return redirect()->route('index')->with('success', 'Registrasi berhasil, menunggu verifikasi admin.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('login')->with('success', 'Anda telah logout.');
    }

    public function dashboard(Request $request)
    {
        $query = $request->input('search');

        $dataBuku = $query
            ? Buku::join('kategori_bukus', 'bukus.id', '=', 'kategori_bukus.BukuID')
                ->join('kategoris', 'kategori_bukus.KategoriID', '=', 'kategoris.id')
                ->where(function ($queryBuilder) use ($query) {
                    $queryBuilder->where('bukus.NamaBuku', 'like', '%' . $query . '%')
                                ->orWhere('kategoris.NamaKategori', 'like', '%' . $query . '%');
                })
                ->orderBy('bukus.created_at', 'desc')
                ->get()
            : Buku::orderBy('created_at', 'desc')->take(8)->get();

        return view('dashboard.index', compact('dataBuku', 'query'));
    }

    public function setting()
    {
        $User = Auth::user();

        return view('settings.index', compact('User'));
    }

    public function edit($id)
    {
        $User = User::findOrFail($id);
        return view('sesi.edit', compact('User'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|unique:users,email,' . $id . '|string|max:255',
            'alamat' => 'required|string|max:255',
            'password' => 'nullable|min:6|confirmed',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:20480000',
        ]);

        $user = User::findOrFail($id);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->alamat = $validated['alamat'];

        if ($request->filled('password')) {
            $user->password = Hash::make($validated['password']);
        }

        if ($request->hasFile('avatar')) {
            if ($user->avatar && $user->avatar !== 'avatar.jpg' && file_exists(public_path('profil/' . $user->avatar))) {
                unlink(public_path('profil/' . $user->avatar));
            }

            $avatar = $request->file('avatar');
            $avatarName = time() . '.' . $avatar->getClientOriginalExtension();

            $avatar->move(public_path('profil'), $avatarName);

            $user->avatar = 'profil/' . $avatarName;
        }

        $user->save();

        return redirect()->route('sesi.edit', $user->id)->with('success', 'User updated successfully.');
    }
}
