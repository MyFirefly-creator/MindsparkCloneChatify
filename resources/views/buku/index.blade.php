<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <style>
        .sidebar {
            width: 250px;
            height: 100vh;
            background-color: #1E3A8A;
            color: white;
            position: fixed;
        }
        .sidebar a {
            display: block;
            padding: 10px 20px;
            color: white;
            text-decoration: none;
        }
        .sidebar a:hover {
            background-color: #1E40AF;
        }
        .main-content {
            margin-left: 250px;
            padding: 20px;
        }
    </style>
</head>
<body class="bg-light">
    <div class="sidebar d-flex flex-column">
        <div class="text-center mt-4">
            <img src="{{ Auth::user()->avatar ? asset(Auth::user()->avatar) : asset('profil/avatar.png') }}" class="rounded-circle" width="60" height="60" alt="Admin profile picture">
            <h2 class="fs-5 mt-2">{{ $user->nama }}</h2>
        </div>
        <nav class="mt-4">
            <a href="{{ route('admin.index') }}" class="{{ request()->routeIs('admin.index') ? 'bg-primary text-white' : '' }}">
                <i class="fas fa-tachometer-alt me-2"></i> Dashboard
            </a>
            <a href="{{ route('kategori.index') }}" class="{{ request()->routeIs('kategori.index') ? 'bg-primary text-white' : '' }}">
                <i class="fas fa-layer-group me-2"></i> Manage Kategori
            </a>
            <a href="{{ route('kategori_buku.index') }}" class="{{ request()->routeIs('kategori_buku.index') ? 'bg-primary text-white' : '' }}">
                <i class="fas fa-tags me-2"></i> Manage Kategori Buku
            </a>
            <a href="{{ route('buku.index') }}" class="{{ request()->routeIs('buku.index') ? 'bg-primary text-white' : '' }}">
                <i class="fas fa-book me-2"></i> Manage Buku
            </a>
            <a href="{{ route('peminjaman.index') }}" class="{{ request()->routeIs('peminjaman.index') ? 'bg-primary text-white' : '' }}">
                <i class="fas fa-handshake me-2"></i> Manage Peminjaman
            </a>
            <a href="{{ route('admin.users') }}" class="{{ request()->routeIs('admin.users') ? 'bg-primary text-white' : '' }}">
                <i class="fas fa-users me-2"></i> Manage Users
            </a>
            <a href="{{ route('admin.verifikasi.list') }}" class="{{ request()->routeIs('admin.verifikasi') ? 'active' : '' }}">
                <i class="fas fa-check-circle me-2"></i> Verifikasi Pengguna
            </a>
        </nav>
    </div>
    <div class="main-content">
        <header class="d-flex justify-content-between align-items-center bg-white p-3 shadow">
            <h1 class="fs-4">Manage Buku</h1>
            <div class="d-flex align-items-center">
                <img src="{{ Auth::user()->avatar ? asset(Auth::user()->avatar) : asset('profil/avatar.png') }}" class="rounded-circle me-3" width="40" height="40" alt="User profile picture">
                <span class="me-3">{{ $user->username }}</span>
                <i class="fas fa-bell fs-5"></i>
            </div>
        </header>
        <main class="mt-4">
            <div class="d-flex justify-content-between mb-3">
                <h2 class="fs-4">Daftar Buku</h2>
                <a href="{{ route('buku.create') }}" class="btn btn-primary">Tambah Buku</a>
            </div>
            <table class="table table-bordered bg-white shadow">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Foto</th>
                        <th>Judul</th>
                        <th>Penulis</th>
                        <th>Penerbit</th>
                        <th>Tahun Terbit</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dataBuku as $buku)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td><img src="{{ asset('storage/' . $buku->image) }}" alt="" width="50px" height="50px"></td>
                        <td>{{ $buku->NamaBuku }}</td>
                        <td>{{ $buku->penulis }}</td>
                        <td>{{ $buku->penerbit }}</td>
                        <td>{{ \Carbon\Carbon::parse($buku->tanggal_terbit)->year }}</td>
                        <td>
                            <a href="{{ route('buku.edit', $buku->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('buku.destroy', $buku->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus buku ini?');">Hapus</button>
                            </form>
                            <a href="{{ route('peminjaman.create', ['BukuID' => $buku->id]) }}" class="btn btn-success btn-sm">Peminjaman</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="d-flex justify-content-center mt-3">
                {{ $dataBuku->links() }}
            </div>
        </main>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
