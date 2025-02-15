<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Kategori Buku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="main-content">
        <header class="d-flex justify-content-between align-items-center bg-white p-3 shadow">
            <h1 class="fs-4">Tambah Kategori Buku</h1>
        </header>

        <main class="mt-4">
            <form action="{{ route('kategori_buku.store') }}" method="POST">
                @csrf
                <div class="card">
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="BukuID" class="form-label">Buku</label>
                            <select name="BukuID" id="BukuID" class="form-select @error('BukuID') is-invalid @enderror">
                                <option value="">Pilih Buku</option>
                                @foreach ($bukus as $buku)
                                    <option value="{{ $buku->id }}" {{ old('BukuID') == $buku->id ? 'selected' : '' }}>{{ $buku->NamaBuku }}</option>
                                @endforeach
                            </select>
                            @error('BukuID')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="KategoriID" class="form-label">Kategori</label>
                            <select name="KategoriID" id="KategoriID" class="form-select @error('KategoriID') is-invalid @enderror">
                                <option value="">Pilih Kategori</option>
                                @foreach ($kategoris as $kategori)
                                    <option value="{{ $kategori->id }}" {{ old('KategoriID') == $kategori->id ? 'selected' : '' }}>{{ $kategori->NamaKategori }}</option>
                                @endforeach
                            </select>
                            @error('KategoriID')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="{{ route('kategori_buku.index') }}" class="btn btn-secondary ms-3">Kembali</a>
                        </div>
                    </div>
                </div>
            </form>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
