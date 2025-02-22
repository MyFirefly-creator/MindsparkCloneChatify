@extends('component.app')

@section('content')
    <div class="container">
        <h1>Edit User</h1>

        <form method="POST" action="{{ route('sesi.update', $User->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="nama">Nama</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $User->name) }}">
                @error('name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $User->email) }}">
                @error('email')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="alamat">Alamat</label>
                <input type="text" class="form-control" id="alamat" name="alamat" value="{{ old('alamat', $User->alamat) }}">
                @error('alamat')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Password (Leave empty to keep current password)</label>
                <input type="password" class="form-control" id="password" name="password">
                @error('password')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="avatar">Avatar</label>
                <input type="file" class="form-control" id="avatar" name="avatar">
                @error('avatar')
                    <div class="text-danger">{{ $message }}</div>
                @enderror

                @if($User->avatar && file_exists(public_path($User->avatar)))
                    <div class="mt-3">
                        <img src="{{ asset($User->avatar) }}" alt="Avatar" width="100" height="100">
                    </div>
                @else
                    <div class="mt-3">
                        <p>No avatar available.</p>
                    </div>
                @endif
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
@endsection
