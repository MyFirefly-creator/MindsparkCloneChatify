<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Buku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h1 class="fs-4 mb-4">Tambah Buku</h1>

                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <form action="{{ route('buku.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label for="NamaBuku" class="form-label">Nama Buku</label>
                        <input type="text" name="NamaBuku" id="NamaBuku" class="form-control" value="{{ old('NamaBuku') }}" required>
                        @error('NamaBuku')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea name="deskripsi" id="deskripsi" class="form-control" required>{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="penulis" class="form-label">Penulis</label>
                        <input type="text" name="penulis" id="penulis" class="form-control" value="{{ old('penulis') }}" required>
                        @error('penulis')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="penerbit" class="form-label">Penerbit</label>
                        <input type="text" name="penerbit" id="penerbit" class="form-control" value="{{ old('penerbit') }}" required>
                        @error('penerbit')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="stokBuku" class="form-label">Tanggal Terbit</label>
                        <input type="date" name="tanggal_terbit" id="tanggal_terbit" class="form-control" value="{{ old('tanggal_terbit') }}" required>
                        @error('tanggal_terbit')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="stokBuku" class="form-label">Stok Buku</label>
                        <input type="number" name="stokBuku" id="stokBuku" class="form-control" min="0" value="{{ old('stokBuku', $buku->stokBuku ?? '') }}" required>
                        @error('stokBuku')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">Gambar Buku</label>
                        <input type="file" name="image" id="image" class="form-control" required>
                        @error('image')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan Buku</button>
                    <a href="{{ route('buku.index') }}" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
