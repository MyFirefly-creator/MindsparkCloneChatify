<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pengguna</title>
    <!-- Menambahkan Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Detail Pengguna</h1>

        <table class="table table-bordered">
            <tr>
                <th>NIS</th>
                <td>{{ $user->nis }}</td>
            </tr>
            <tr>
                <th>Nama</th>
                <td>{{ $user->nama }}</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>{{ $user->email }}</td>
            </tr>
            <tr>
                <th>Alamat</th>
                <td>{{ $user->alamat }}</td>
            </tr>
            <tr>
                <th>Role</th>
                <td>{{ $user->role }}</td>
            </tr>
            <tr>
                <th>Avatar</th>
                <td><img src="{{ asset($user->avatar)}}" alt="Avatar" class="img-fluid" width="100"></td>
            </tr>
            <tr>
                <th>Foto KTP</th>
                <td><img src="{{ asset('storage/' . $user->foto_ktp) }}" alt="Foto KTP" class="img-fluid" width="100"></td>
            </tr>
            <tr>
                <th>Foto Diri</th>
                <td><img src="{{ asset('storage/' . $user->foto_diri) }}" alt="Foto Diri" class="img-fluid" width="100"></td>
            </tr>
            <tr>
                <th>Status Verifikasi</th>
                <td>{{ $user->status_verifikasi ? 'Terverifikasi' : 'Belum Terverifikasi' }}</td>
            </tr>
        </table>

        <a href="{{ route('admin.users') }}" class="btn btn-secondary">Kembali ke Daftar Pengguna</a>
    </div>

    <!-- Menambahkan Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
