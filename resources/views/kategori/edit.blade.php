<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kategori</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.css">
</head>
<body>

<div class="container mt-4">
    <div class="card">
        <div class="card-header bg-warning text-white">
            <h4 class="mb-0">Edit Kategori</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('kategori.update', $kategori->id) }}" method="POST" class="ui form">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="NamaKategori" class="form-label">Nama Kategori</label>
                    <input type="text" class="form-control {{ $errors->has('NamaKategori') ? 'is-invalid' : '' }}" id="NamaKategori" name="NamaKategori" value="{{ $kategori->NamaKategori }}" required>
                    @if ($errors->has('NamaKategori'))
                        <div class="invalid-feedback">{{ $errors->first('NamaKategori') }}</div>
                    @endif
                </div>
                <button type="submit" class="ui yellow button">Update</button>
                <a href="{{ route('kategori.index') }}" class="ui button">Kembali</a>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.js"></script>

</body>
</html>
