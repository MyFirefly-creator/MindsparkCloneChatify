@extends('component.app')

@section('content')
<div class="container">
    @if($peminjaman->isNotEmpty())
        <h1 class="mb-4">History Peminjaman - {{ $peminjaman->first()->user->nama }}</h1>
    @else
        <h1 class="mb-4">History Peminjaman</h1>
        <p>Belum ada peminjaman untuk pengguna ini.</p>
    @endif


    <div class="row mb-4">
        <div class="col-md-6">
            <form action="{{ route('peminjaman.laporan') }}" method="GET">
                <div class="row">
                    <div class="col">
                        <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
                    </div>
                    <div class="col">
                        <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
                    </div>
                    <div class="col">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-filter"></i> Filter
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('peminjaman.laporan', ['start_date' => request('start_date'), 'end_date' => request('end_date')]) }}" class="btn btn-danger">
                <i class="fas fa-file-pdf"></i> Download Laporan PDF
            </a>
        </div>
    </div>


    @if($peminjaman->isEmpty())
        <p>Belum ada peminjaman untuk pengguna ini.</p>
    @else
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Buku</th>
                    <th>Tanggal Peminjaman</th>
                    <th>Tanggal Pengembalian</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($peminjaman as $index => $pinjam)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $pinjam->buku->NamaBuku }}</td>
                    <td>{{ \Carbon\Carbon::parse($pinjam->TanggalPeminjaman)->format('d-m-Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($pinjam->TanggalPengembalian)->format('d-m-Y') }}</td>
                    <td>{{ $pinjam->StatusPeminjaman }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
