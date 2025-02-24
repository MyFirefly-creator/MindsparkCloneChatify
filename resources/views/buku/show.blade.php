@extends('component.app')

@section('content')
<div class="d-flex">
    <div class="col-10 p-4">
        <div class="d-flex justify-content-between mb-4">
            <form method="GET" action="{{ route('dashboard.index') }}">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <input type="text" class="form-control w-50" name="search" placeholder="Cari buku atau kategori" value="{{ request()->get('search') }}">
                    <button type="submit" class="btn btn-primary ms-2">Search</button>
                </div>
            </form>

            <button class="btn btn-primary">Kategori <i class="fas fa-chevron-down"></i></button>
        </div>

        <div class="row">
            <div class="col-md-8 bg-white p-4 rounded shadow-sm">
                <a href="#" class="text-muted">&larr; Kembali ke Daftar Buku</a>
                <div class="d-flex mt-3">
                    <div class="book-image w-25">
                        <img src="{{ asset('storage/' . $buku->image) }}" alt="{{ $buku->NamaBuku }}" class="img-fluid">
                    </div>
                    <div class="ms-3 w-75">
                        <div class="d-flex align-items-center">
                            <span class="text-warning">{{ $averageStarDisplay }}</span>
                            <span class="ms-2">{{ number_format($averageRating, 1) }}/5</span>
                        </div>
                        <h2 class="fw-bold">{{ $buku->NamaBuku }}</h2>
                        <p>{{ $buku->deskripsi }}</p>

                        <div class="d-flex gap-2">
                            @if($sedangDipinjam)
                                <button class="btn btn-secondary" disabled>Sudah Dipinjam</button>
                            @elseif($buku->stokBuku == 0)
                                <button class="btn btn-danger" disabled>Stok Habis</button>
                                <p class="fst-italic text-danger mt-2">*Buku sudah habis/dipinjam</p>
                            @else
                                <a href="{{ route('peminjaman.create', ['bukuID' => $buku->id]) }}" class="btn btn-primary">Pinjam</a>
                            @endif

                            <button class="btn btn-primary" id="reviewButton">Tulis Ulasan</button>

                            <form id="favoritForm" action="{{ route('favorit.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="BukuID" value="{{ $buku->id }}">
                                <button type="button" class="btn btn-danger" id="btnFavorit">Tambah ke Favorit</button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="mt-4 bg-light p-3 rounded">
                    <h3 class="fw-bold">Detail Buku</h3>
                    <div class="row">
                        <div class="col-md-6"><strong>Penulis:</strong> {{ $buku->penulis }}</div>
                        <div class="col-md-6">
                            <strong>Genre:</strong>
                            @foreach($kategoribuku as $kategori)
                                <span>{{ $kategori->NamaKategori }}</span>@if(!$loop->last), @endif
                            @endforeach
                        </div>
                        <div class="col-md-6"><strong>Tahun Terbit:</strong> {{ \Carbon\Carbon::parse($buku->tanggal_terbit)->year }}</div>
                        <div class="col-md-6"><strong>Penerbit:</strong> {{ $buku->penerbit }}</div>
                    </div>
                </div>

                <div class="mt-4 p-3 rounded bg-light">
                    <h3 class="fw-bold">Komentar</h3>
                    @foreach ($ulasans as $ulasan)
                        <div class="comment-box d-flex align-items-start p-2 mt-3">
                            <div class="me-3">
                                <img src="{{ $ulasan->user && $ulasan->user->avatar ? asset($ulasan->user->avatar) : asset('profil/avatar.png') }}"
                                     alt="{{ $ulasan->user->name }}"
                                     class="rounded-circle"
                                     style="width: 40px; height: 40px; object-fit: cover;">
                            </div>
                            <div>
                                <strong>{{ $ulasan->user->name }}</strong>
                                <span class="text-warning">{{ $ulasan->starDisplay }}</span>
                                <span>{{ $ulasan->Rating }}</span>
                                <p class="m-0">{{ $ulasan->Ulasan }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="col-md-4 bg-white p-4 rounded shadow-sm">
                <h3 class="fw-bold">Buku Lainnya</h3>
                <div class="mt-3">
                    @foreach ($relatedBooks as $relatedBook)
                        <a href="{{ route('buku.show', ['bukuID' => $relatedBook->id]) }}" class="d-flex mb-2 text-decoration-none text-dark">
                            <div class="book-image w-25">
                                <img src="{{ asset('storage/' . $relatedBook->image) }}" alt="{{ $relatedBook->NamaBuku }}" class="img-fluid rounded">
                            </div>
                            <div class="ms-2">
                                <h5 class="mb-1">{{ $relatedBook->NamaBuku }}</h5>
                                <span class="text-warning">
                                    {{ str_repeat('★', floor($relatedBook->ulasans_avg_rating ?? 0)) }}
                                    {{ ($relatedBook->ulasans_avg_rating ?? 0) - floor($relatedBook->ulasans_avg_rating ?? 0) >= 0.5 ? '½' : '' }}
                                    {{ str_repeat('☆', 5 - ceil($relatedBook->ulasans_avg_rating ?? 0)) }}
                                </span>
                                <span>{{ number_format($relatedBook->ulasans_avg_rating ?? 0, 1) }}</span>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="reviewModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reviewModalLabel">Tulis Ulasan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('ulasans.store', ['bukuID' => $buku->id]) }}" method="POST">
                    @csrf
                    <input type="hidden" name="BukuID" value="{{ $buku->id }}">
                    <div class="form-group">
                        <label for="Ulasan">Komentar</label>
                        <textarea name="Ulasan" rows="3" class="form-control" placeholder="Tulis komentar Anda..." required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="Rating">Rating</label>
                        <select name="Rating" class="form-control" required>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Kirim Ulasan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('reviewButton').addEventListener('click', function() {
        var myModal = new bootstrap.Modal(document.getElementById('reviewModal'));
        myModal.show();
    });

    document.getElementById('btnFavorit').addEventListener('click', function (e) {
        e.preventDefault();

        Swal.fire({
            title: "Tambahkan ke Favorit?",
            text: "Buku ini akan ditambahkan ke daftar favorit Anda.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#6c757d",
            confirmButtonText: "Ya, tambahkan!",
            cancelButtonText: "Batal"
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('favoritForm').submit();
            }
        });
    });
</script>
@endsection
