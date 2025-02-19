<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Ban Pengguna</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .sidebar {
            width: 250px;
            height: 100vh;
            background-color: #1E3A8A;
            color: white;
            position: fixed;
            top: 0;
            left: 0;
            padding-top: 20px;
        }

        .sidebar .text-center img {
            width: 60px;
            height: 60px;
            border-radius: 50%;
        }

        .sidebar a {
            display: block;
            padding: 12px 20px;
            color: white;
            text-decoration: none;
            margin-bottom: 10px;
            border-radius: 4px;
        }

        .sidebar a:hover {
            background-color: #1E40AF;
        }

        .sidebar a.active {
            background-color: #3B82F6;
            color: white;
        }

        .main-content {
            margin-left: 250px;
            padding: 20px;
        }

        .main-content header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: white;
            padding: 15px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .main-content header img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
        }

        .main-content header .user-info span {
            margin-right: 15px;
        }

        .card {
            margin-top: 20px;
        }

        .card-header {
            background-color: #f8fafc;
            font-weight: bold;
        }

        .card-body form {
            padding: 20px;
        }

        .btn-primary,
        .btn-danger,
        .btn-warning {
            font-size: 14px;
            padding: 10px 20px;
            border-radius: 5px;
        }

        .table th,
        .table td {
            text-align: center;
            vertical-align: middle;
        }

        .table-bordered {
            border-color: #e5e5e5;
        }

        .badge {
            font-size: 0.85rem;
        }

        .badge.bg-danger {
            background-color: #e74c3c;
        }

        .dropdown-item {
            padding: 5px 10px;
            cursor: pointer;
        }

        .dropdown-item:hover {
            background-color: #f1f1f1;
        }

        /* Add spacing between title and buttons */
        .page-header {
            margin-bottom: 20px;
        }

        .add-user-btn {
            margin-top: 15px;
        }

        /* Adjust margins for header */
        .main-content header .user-info {
            margin-left: auto;
            display: flex;
            align-items: center;
        }
    </style>
</head>

<body>
    <div class="container-fluid d-flex">
        <div class="sidebar">
            <div class="text-center mt-4">
                <img src="{{ Auth::user()->avatar ? asset(Auth::user()->avatar) : asset('profil/avatar.png') }}" class="rounded-circle" alt="Admin profile picture">
                <h2 class="fs-5 mt-2">{{ Auth::user()->nama }}</h2>
            </div>
            <nav class="mt-4">
                <a href="{{ route('admin.index') }}" class="{{ request()->routeIs('admin.index') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                </a>
                <a href="{{ route('kategori.index') }}" class="{{ request()->routeIs('kategori.index') ? 'active' : '' }}">
                    <i class="fas fa-layer-group me-2"></i> Manage Kategori
                </a>
                <a href="{{ route('kategori_buku.index') }}" class="{{ request()->routeIs('kategori_buku.index') ? 'active' : '' }}">
                    <i class="fas fa-tags me-2"></i> Manage Kategori Buku
                </a>
                <a href="{{ route('buku.index') }}" class="{{ request()->routeIs('buku.index') ? 'active' : '' }}">
                    <i class="fas fa-book me-2"></i> Manage Buku
                </a>
                <a href="{{ route('peminjaman.index') }}" class="{{ request()->routeIs('peminjaman.index') ? 'active' : '' }}">
                    <i class="fas fa-handshake me-2"></i> Manage Peminjaman
                </a>
                <a href="{{ route('admin.users') }}" class="{{ request()->routeIs('admin.users') ? 'active' : '' }}">
                    <i class="fas fa-users me-2"></i> Manage Users
                </a>
                <a href="{{ route('admin.verifikasi.list') }}" class="{{ request()->routeIs('admin.verifikasi') ? 'active' : '' }}">
                    <i class="fas fa-check-circle me-2"></i> Verifikasi Pengguna
                </a>
            </nav>
        </div>

        <div class="main-content flex-grow-1">
            <header class="d-flex justify-content-between align-items-center bg-white p-3 shadow">
                <h1 class="fs-4 page-header">Manajemen Pengguna</h1>
                <div class="d-flex align-items-center">
                    <img src="{{ Auth::user()->avatar ? asset(Auth::user()->avatar) : asset('profil/avatar.png') }}" class="rounded-circle me-3" width="40" height="40" alt="User profile picture">
                    <span class="me-3">{{ Auth::user()->username }}</span>
                    <i class="fas fa-bell fs-5"></i>
                </div>
            </header>

            <a href="{{ route('admin.users.create') }}" class="btn btn-primary add-user-btn">
                <i class="fas fa-user-plus me-2"></i> Tambah User
            </a>

            <div class="container mt-4">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                {{-- Search Form --}}
                <div class="card">
                    <div class="card-header">Cari Pengguna</div>
                    <div class="card-body">
                        <form method="GET" action="{{ route('admin.users') }}">
                            <div class="mb-3">
                                <input type="text" id="search" name="search" class="form-control" placeholder="Search by name, email, or NIS" value="{{ $search }}">
                            </div>
                            <button type="submit" class="btn btn-primary">Cari</button>
                        </form>
                    </div>
                </div>

                {{-- Ban Form --}}
                <div class="card mt-4">
                    <div class="card-header">Form Ban Pengguna</div>
                    <div class="card-body">
                        <form action="{{ route('ban.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="user_id_ban" class="form-label">Pilih Pengguna</label>
                                <select name="user_id" id="user_id_ban" class="form-control">
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->nama }} ({{ $user->email }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="Deskripsi" class="form-label">Deskripsi</label>
                                <input type="text" name="Deskripsi" id="Deskripsi" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="duration" class="form-label">Durasi Ban</label>
                                <input type="number" name="duration" id="duration" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="unit" class="form-label">Unit Waktu</label>
                                <select name="unit" id="unit" class="form-control">
                                    <option value="minutes">Menit</option>
                                    <option value="hours">Jam</option>
                                    <option value="days">Hari</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-danger">Ban Pengguna</button>
                        </form>
                    </div>
                </div>

                {{-- Daftar Pengguna --}}
                <div class="card mt-4">
                    <div class="card-header">Daftar Pengguna</div>
                    <div class="card-body">
                        <table class="table table-bordered bg-white shadow">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Pelanggaran</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    @if (!in_array($user->role, ['admin', 'superadmin']))
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $user->nama }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>
                                                @foreach($user->warnings as $warning)
                                                    <span class="badge bg-danger">{{ $warning->jenisPelanggaran->jenis_pelanggaran }}</span>
                                                @endforeach
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-primary btn-sm">Edit</a>
                                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this user?')">Delete</button>
                                                </form>
                                                <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-secondary btn-sm">Show</a>                                                                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('searchUserBan').addEventListener('input', function() {
            let query = this.value;
            let resultsContainer = document.getElementById('user-search-results-ban');
            let userDropdown = document.getElementById('user_id_ban');

            if (query.length > 2) {
                fetch(`/search-users?query=${query}`)
                    .then(response => response.json())
                    .then(data => {
                        resultsContainer.innerHTML = '';
                        userDropdown.innerHTML = '';

                        if (data.length > 0) {
                            resultsContainer.style.display = 'block';
                            data.forEach(user => {
                                let option = document.createElement('a');
                                option.classList.add('dropdown-item');
                                option.href = '#';
                                option.textContent = `${user.nama} (${user.email})`;

                                option.onclick = function() {
                                    let selectOption = document.createElement('option');
                                    selectOption.value = user.id;
                                    selectOption.textContent = `${user.nama} (${user.email})`;
                                    userDropdown.appendChild(selectOption);

                                    document.getElementById('searchUserBan').value = user.nama;

                                    resultsContainer.style.display = 'none';
                                };

                                resultsContainer.appendChild(option);
                            });
                        } else {
                            resultsContainer.style.display = 'none';
                        }
                    });
            } else {
                resultsContainer.style.display = 'none';
            }
        });
    </script>
</body>

</html>
