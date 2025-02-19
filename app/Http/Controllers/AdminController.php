<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\User;
use App\Models\Warning;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use App\Models\JenisPelanggaran;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        $jumlahUser = User::count();
        $jumlahBukuDipinjam = Peminjaman::whereMonth('created_at', now()->month)->count();
        $jumlahBukuBaru = Buku::whereMonth('created_at', now()->month)->count();
        $user = Auth::user();

        return view('admin.index', compact('jumlahUser', 'jumlahBukuDipinjam', 'jumlahBukuBaru', 'user'));
    }

    public function user(Request $request)
    {
        $search = $request->get('search', '');
        $users = User::when($search, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->orWhere('nis', 'like', "%{$search}%");
        })->get();

        $jenisPelanggaran = JenisPelanggaran::all();

        return view('admin.users.index', compact('users', 'jenisPelanggaran', 'search'));
    }

    public function storeWarning(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'jenis_pelanggaran_id' => 'required|exists:jenis_pelanggarans,id',
        ]);

        Warning::create([
            'UserID' => $request->user_id,
            'jenis_pelanggaran_id' => $request->jenis_pelanggaran_id,
        ]);

        $user = User::find($request->user_id);
        $user->increment('jumlah_pelanggaran');

        return redirect()->back()->with('success', 'Peringatan berhasil diberikan.');
    }

    public function createUser()
    {
        return view('admin.users.create');
    }

    public function storeUser(Request $request)
    {
        $validated = $request->validate([
            'nis' => 'required|unique:users,nis',
            'password' => 'required|min:6|confirmed',
            'name' => 'required|string|max:255',
            'alamat' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|string',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['avatar'] = $validated['avatar'] ?? 'profil/avatar.png';

        User::create($validated);

        return redirect()->route('admin.users')->with('success', 'User created successfully');
    }

    public function showUser(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    public function editUser(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function updateUser(Request $request, User $user)
    {
        $validated = $request->validate([
            'nis' => 'required|unique:users,nis,' . $user->id,
            'password' => 'nullable|min:6|confirmed',
            'name' => 'required|string|max:255',
            'alamat' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|string',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:102400'
        ]);

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $avatarPath = public_path('profil');

            if (!file_exists($avatarPath)) {
                mkdir($avatarPath, 0777, true);
            }

            $avatarName = time() . '_' . $avatar->getClientOriginalName();
            $avatar->move($avatarPath, $avatarName);

            $validated['avatar'] = 'profil/' . $avatarName;
        }

        $user->update($validated);

        return redirect()->route('admin.users')->with('success', 'User updated successfully');
    }

    public function destroyUser(User $user)
    {
        $user->delete();

        return redirect()->route('admin.users')->with('success', 'User deleted successfully');
    }

    public function searchUsers(Request $request)
    {
        $query = $request->get('query');
        $users = User::where('name', 'like', '%' . $query . '%')
            ->orWhere('email', 'like', '%' . $query . '%')
            ->orWhere('nis', 'like', '%' . $query . '%')
            ->get();

        return response()->json($users);
    }

    public function daftarVerifikasi()
    {
        $users = User::where('status_verifikasi', 'pending')->get();
        return view('admin.verifikasi', compact('users'));
    }

    public function verifikasiUser($id, $status)
    {
        $user = User::find($id);
        if (!$user) {
            return redirect()->back()->with('error', 'User tidak ditemukan');
        }

        if ($status == 'diterima') {
            $user->status_verifikasi = 'diterima';
            $user->save();
            return redirect()->back()->with('success', 'Status verifikasi diperbarui.');
        } else {
            $user->status_verifikasi = 'ditolak';
            $user->save();
            $user->delete();
            return redirect()->back()->with('success', 'User telah dihapus setelah ditolak.');
        }
    }
}
