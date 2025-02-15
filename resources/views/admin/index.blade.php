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
            <img src="{{ Auth::user()->foto_profil ? asset('profil/' . Auth::user()->avatar) : asset('profil/avatar.png') }}" class="rounded-circle" width="60" height="60" alt="Admin profile picture">
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
            <h1 class="fs-4">Dashboard</h1>
            <div class="d-flex align-items-center">
                <img src="{{ Auth::user()->foto_profil ? asset('profil/' . Auth::user()->foto_profil) : asset('profil/avatar.png') }}" class="rounded-circle me-3" width="40" height="40" alt="User profile picture">
                <span class="me-3">{{ $user->username }}</span>
                <i class="fas fa-bell fs-5"></i>
            </div>
        </header>
        <main class="mt-4">
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="bg-success text-white p-4 rounded shadow">
                        <h2 class="fs-5">Total Pengguna</h2>
                        <p class="fs-2 mt-2">{{ $jumlahUser }}</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="bg-info text-white p-4 rounded shadow">
                        <h2 class="fs-5">Buku Dipinjam Bulan Ini</h2>
                        <p class="fs-2 mt-2">{{ $jumlahBukuDipinjam }}</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="bg-danger text-white p-4 rounded shadow">
                        <h2 class="fs-5">Buku Baru Bulan Ini</h2>
                        <p class="fs-2 mt-2">{{ $jumlahBukuBaru }}</p>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
