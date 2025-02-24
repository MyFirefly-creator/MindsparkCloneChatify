<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Peminjaman Buku</title>
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
        <h1>Edit Peminjaman Buku</h1>

        <form action="{{ route('peminjaman.update', $peminjaman->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group mb-3">
                <label for="UserID">User</label>
                <input type="text" class="form-control" id="UserID"
                    value="{{ old('UserID', $users->find($peminjaman->UserID)?->name) }}"
                    @if(!in_array($loggedInUser->role, ['admin', 'superadmin'])) disabled @endif>

                <input type="hidden" name="UserID" value="{{ old('UserID', $peminjaman->UserID) }}">

                @error('UserID')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="BukuID">Buku</label>
                <select class="form-control @error('BukuID') is-invalid @enderror" id="BukuID" name="BukuID">
                    <option value="">Pilih Buku</option>
                    @foreach($bukus as $buku)
                        <option value="{{ $buku->id }}" {{ old('BukuID', $peminjaman->BukuID) == $buku->id ? 'selected' : '' }}>{{ $buku->NamaBuku }}</option>
                    @endforeach
                </select>
                @error('BukuID')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="TanggalPeminjaman">Tanggal Peminjaman</label>
                <input type="date" class="form-control @error('TanggalPeminjaman') is-invalid @enderror" id="TanggalPeminjaman" name="TanggalPeminjaman" value="{{ \Carbon\Carbon::parse($peminjaman->TanggalPeminjaman)->format('Y-m-d') }}">
                @error('TanggalPeminjaman')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="TanggalPengembalian">Tanggal Pengembalian</label>
                <input type="date" class="form-control @error('TanggalPengembalian') is-invalid @enderror" id="TanggalPengembalian" name="TanggalPengembalian" value="{{ \Carbon\Carbon::parse($peminjaman->TanggalPengembalian)->format('Y-m-d') }}">
                @error('TanggalPengembalian')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="StatusPeminjaman">Status</label>
                <select class="form-control @error('StatusPeminjaman') is-invalid @enderror" id="StatusPeminjaman" name="StatusPeminjaman" required>
                    <option value="dipinjam" {{ old('StatusPeminjaman', $peminjaman->StatusPeminjaman) == 'dipinjam' ? 'selected' : '' }}>dipinjam</option>
                    <option value="dikembalikan" {{ old('StatusPeminjaman', $peminjaman->StatusPeminjaman) == 'dikembalikan' ? 'selected' : '' }}>dikembalikan</option>
                    <option value="pending" {{ old('StatusPeminjaman', $peminjaman->StatusPeminjaman) == 'pending' ? 'selected' : '' }}>pending</option>

                </select>
                @error('StatusPeminjaman')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Update Peminjaman</button>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
