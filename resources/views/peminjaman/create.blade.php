<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Peminjaman Buku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        body { background-color: #f8f9fa; }
        .container { margin-top: 50px; }
        .form-container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h1 { color: #333; }
    </style>
</head>
<body>

<div class="container">
    <div class="form-container">
        <h1>Form Peminjaman Buku</h1>

        <form action="{{ route('peminjaman.store') }}" method="POST" id="peminjaman-form">
            @csrf

            <!-- User ID -->
            <div class="form-group mb-3">
                <label for="UserID">User</label>
                <select name="UserID" id="UserID" class="form-control" {{ $loggedInUser->role != 'superadmin' ? 'disabled' : '' }}>
                    @if($loggedInUser->role != 'superadmin')
                        <option value="{{ $loggedInUser->id }}" selected>{{ $loggedInUser->name }}</option>
                        <input type="hidden" name="UserID" value="{{ $loggedInUser->id }}">
                    @else
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" {{ old('UserID') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                        @endforeach
                    @endif
                </select>
            </div>

            <!-- Buku ID -->
            <div class="form-group mb-3">
                <label for="BukuID">Buku</label>
                <select class="form-control @error('BukuID') is-invalid @enderror" id="BukuID" name="BukuID" required>
                    <option value="">Pilih Buku</option>
                </select>
                @error('BukuID')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Tanggal Peminjaman -->
            <div class="form-group mb-3">
                <label for="TanggalPeminjaman">Tanggal Peminjaman</label>
                <input type="date" class="form-control" id="TanggalPeminjaman" name="TanggalPeminjaman" value="{{ now()->format('Y-m-d') }}" readonly>
            </div>

            <!-- Tanggal Pengembalian -->
            <div class="form-group mb-3">
                <label for="TanggalPengembalian">Tanggal Pengembalian</label>
                <input type="date" class="form-control" id="TanggalPengembalian" name="TanggalPengembalian" value="{{ now()->addDays(7)->format('Y-m-d') }}" readonly>
            </div>

            <button type="submit" class="btn btn-primary">Tambah Peminjaman</button>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        // Inisialisasi Select2 untuk Buku
        $('#BukuID').select2({
            placeholder: "Pilih Buku",
            allowClear: true
        });

        // Inisialisasi Select2 untuk User
        $('#UserID').select2({
            placeholder: "Pilih User",
            allowClear: true
        });

        // Ambil semua data buku melalui AJAX
        getAllBooks();

        // Validasi sebelum submit form
        $('#peminjaman-form').on('submit', function(e) {
            console.log('UserID:', $('#UserID').val());
            console.log('BukuID:', $('#BukuID').val());

            if ($('#BukuID').val() === "") {
                e.preventDefault();
                alert('Silakan pilih buku terlebih dahulu');
            }
        });
    });

    // Fungsi untuk mengambil data buku via AJAX
    function getAllBooks() {
        $.ajax({
            url: '{{ route('peminjaman.search') }}',
            method: 'GET',
            data: { query: '' },
            success: function(data) {
                let options = '<option value="">Pilih Buku</option>';
                if (data.length > 0) {
                    data.forEach(function(buku) {
                        options += `<option value="${buku.id}">${buku.NamaBuku}</option>`;
                    });
                } else {
                    options += '<option value="">Tidak ada buku ditemukan</option>';
                }
                $('#BukuID').html(options).trigger('change');
            },
            error: function() {
                alert('Gagal memuat data buku. Coba lagi.');
            }
        });
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
