<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Peminjaman Buku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 50px;
        }
        .form-container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #333;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="form-container">
        <h1>Form Peminjaman Buku</h1>

        <form action="{{ route('peminjaman.store') }}" method="POST">
            @csrf

            <div class="form-group mb-3">
                <div class="form-group">
                    <label for="UserID">User</label>
                    <select name="UserID" id="UserID" class="form-control" {{ $loggedInUser->role != 'superadmin' ? 'disabled' : '' }}>
                        @if($loggedInUser->role != 'superadmin')
                            <option value="{{ $loggedInUser->id }}" selected>{{ $loggedInUser->nama }}</option>
                        @else
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" {{ old('UserID') == $user->id ? 'selected' : '' }}>{{ $user->nama }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                @error('UserID')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="BukuID">Buku</label>
                <select class="form-control @error('BukuID') is-invalid @enderror" id="BukuID" name="BukuID">
                    <option value="">Pilih Buku</option>
                    @foreach($bukus as $buku)
                        <option value="{{ $buku->id }}" {{ old('BukuID') == $buku->id ? 'selected' : '' }}>{{ $buku->NamaBuku }}</option>
                    @endforeach
                </select>
                @error('BukuID')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="TanggalPeminjaman">Tanggal Peminjaman</label>
                <input type="date" class="form-control @error('TanggalPeminjaman') is-invalid @enderror" id="TanggalPeminjaman" name="TanggalPeminjaman" value="{{ now()->format('Y-m-d') }}" readonly>
                @error('TanggalPeminjaman')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="TanggalPengembalian">Tanggal Pengembalian</label>
                <input type="date" class="form-control @error('TanggalPengembalian') is-invalid @enderror" id="TanggalPengembalian" name="TanggalPengembalian" value="{{ now()->addDays(7)->format('Y-m-d') }}" readonly>
                @error('TanggalPengembalian')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Tambah Peminjaman</button>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
