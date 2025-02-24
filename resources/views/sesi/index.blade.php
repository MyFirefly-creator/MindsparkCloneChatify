<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mindspark</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .header {
            border-bottom: 2px solid #007bff;
        }
        .nav-link {
            color: #555 !important;
            margin-right: 15px;
        }
        .hero {
            padding: 50px 0;
        }
        .hero img {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
        }
        .btn-green {
            background-color: #28a745;
            color: white;
            border-radius: 5px;
            padding: 10px 20px;
            border: none;
        }
        .btn-green:hover {
            background-color: #218838;
        }
        .btn-gray {
            background-color: #e0e0e0;
            color: #555;
            border-radius: 5px;
            padding: 10px 20px;
            border: none;
        }
        .btn-gray:hover {
            background-color: #d6d6d6;
        }
    </style>
</head>
<body>
    <header class="header bg-white shadow-sm">
        <div class="container d-flex justify-content-between align-items-center py-3">
            <div class="d-flex align-items-center">
                <!-- Tambahkan logo di sini -->
                <img src="{{ asset('bahan/LogoMindspark.jpg') }}" alt="Mindspark Logo" style="height: 40px; width: auto; margin-right: 10px;">
                <h1 class="h4 fw-bold mb-0">Mindspark</h1>
            </div>
            <button class="btn btn-outline-secondary d-md-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <i class="fas fa-bars"></i>
            </button>
            <nav class="collapse navbar-collapse d-md-flex justify-content-end" id="navbarNav">
                <a href="{{ route('index') }}" class="nav-link d-none d-md-inline">Beranda</a>
                <a href="{{ route('dashboard.index') }}" class="nav-link d-none d-md-inline">Dashboard</a>
                <a href="{{ route('loginForm') }}" class="btn btn-green ms-3">Login</a>
            </nav>
        </div>
    </header>

    <main class="container hero">
        <div class="row align-items-center">
            <div class="col-12 col-md-6 text-center text-md-start mb-4">
                <h2 class="fw-bold mb-3">Halo, Selamat Datang di Mindspark</h2>
                <p class="lead mb-4">Yuk Mulai Belajar dan Membaca</p>
                <div class="d-flex flex-column flex-md-row gap-3">
                    <a href="{{ route('loginForm') }}" class="btn btn-green">Mulai Baca!</a>
                    <a href="{{ route('dashboard.index') }}" class="btn btn-gray">Jelajahi</a>
                </div>
            </div>
            <div class="col-12 col-md-6 text-center">
                <img src="{{ url('bahan/1.jpg') }}" alt="Gambar Ilustrasi" class="img-fluid">
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
