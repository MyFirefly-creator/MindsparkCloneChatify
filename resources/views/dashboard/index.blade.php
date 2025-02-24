@extends('component.app')

@section('content')
    <div class="container">
        <form method="GET" action="{{ route('dashboard.index') }}">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <input type="text" class="form-control w-50" name="search" placeholder="Cari buku atau kategori" value="{{ request()->get('search') }}">
                <button type="submit" class="btn btn-primary ms-2">Search</button>
            </div>
        </form>

        @if(isset($query) && $query != '')
            <h4 class="text-center mb-4">Hasil pencarian untuk: <strong>"{{ $query }}"</strong></h4>
        @endif

        <div id="buku-list">
            @forelse($dataBuku as $buku)
            @empty
                <p class="text-center">Buku tidak ada</p>
            @endforelse
        </div>

        <div class="card position-relative" style="width: 961px; height: 200px; overflow: hidden;">
            <img src="{{ asset('bahan/4.jpg') }}" class="card-img-top rounded" alt="Books" style="height: 100%; object-fit: cover;">
            <div class="card-img-overlay d-flex align-items-end justify-content-center p-0">
                <a href="#" class="btn btn-dark w-100 rounded-0">Let's Go</a>
            </div>
        </div>

        <h3 class="mt-4">Daftar Buku</h3>
        <div class="row mt-3" id="masonry-grid" data-masonry='{"percentPosition": true }'>
            @foreach($dataBuku as $buku)
                <div class="col-md-3 mb-4">
                    <div class="card p-3" style="height: 400px;">
                        <img src="{{ asset('storage/' . $buku->image) }}"
                            class="card-img-top rounded"
                            alt="{{ $buku->NamaBuku }}"
                            style="width: 100%; height: 200px; object-fit: cover;">
                        <div class="card-body text-center d-flex flex-column justify-content-between">
                            <h5 class="mb-2">{{ $buku->NamaBuku }}</h5>
                            <p>{{ Str::limit($buku->deskripsi, 50) }}</p>
                            <a href="{{ route('buku.show', $buku->id) }}" class="btn btn-primary btn-sm mt-auto">Detail</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Masonry JS --}}
    <script src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            new Masonry('#masonry-grid', {
                itemSelector: '.col-md-3',
                columnWidth: '.col-md-3',
                percentPosition: true
            });
        });
    </script>
@endsection
