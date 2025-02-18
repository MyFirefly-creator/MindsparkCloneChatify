<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        .profile-img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
        }
        .edit-icon {
            position: absolute;
            bottom: 0;
            right: 0;
            background: white;
            padding: 5px;
            border-radius: 50%;
        }
    </style>
</head>
<body class="bg-light d-flex align-items-center justify-content-center min-vh-100">
    <div class="container bg-white p-4 rounded shadow" style="max-width: 400px;">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <a href="{{ route('dashboard.index') }}" class="text-dark"><i class="fas fa-arrow-left fa-2x"></i></a>
            <h2 class="m-0">Settings</h2>
            <a href="{{ route('settings') }}" class="text-dark"><i class="fas fa-sync-alt fa-2x text-dark"></i></a>
        </div>
        <div class="text-center mb-4">
            <div class="position-relative d-inline-block">
                <img src="{{ Auth::user()->avatar ? asset(Auth::user()->avatar) : asset('profil/avatar.png') }}" alt="Profile Picture" class="profile-img">
                <div class="edit-icon">
                    <i class="fas fa-pen text-dark"></i>
                </div>
            </div>
            <h4 class="mt-2">{{ Auth::user()->nama }}</h4>
            <p class="text-muted">{{ Auth::user()->email }}</p>
        </div>
        <div class="list-group mb-4">
            <a href="{{ route('sesi.edit', $User->id) }}" class="list-group-item list-group-item-action d-flex align-items-center">
                <i class="fas fa-user-edit fa-lg me-3"></i> Edit Profile
            </a>
            <a href="#" class="list-group-item list-group-item-action d-flex align-items-center">
                <i class="fas fa-envelope fa-lg me-3"></i> Contact Us
            </a>
        </div>
        <div class="d-flex justify-content-between">
            <a href="{{ route('dashboard.index') }}" class="btn btn-secondary">Kembali</a>
            <a href="{{ route('logout') }}" class="btn btn-danger">Logout</a>
        </div>
    </div>
</body>
</html>
