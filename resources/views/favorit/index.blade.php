@extends('component.app')

@section('content')
<div class="container">
    <h2>Daftar Buku Favorit</h2>
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Judul Buku</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($favorits as $favorit)
                <tr>
                    <td>{{ $favorit->buku->NamaBuku }}</td>
                    <td>
                        <a href="{{ route('buku.show', $favorit->BukuID) }}" class="btn btn-info">Show</a>
                        <form action="{{ route('favorit.destroy', $favorit->BukuID) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
