<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <!-- Bootstrap & FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            background-color: #f8f9fa;
        }
        .card-custom {
            max-width: 900px;
            margin: auto;
            border-radius: 10px;
            overflow: hidden;
            background: white;
        }
        .carousel img {
            border-radius: 10px;
            object-fit: cover;
            height: 100%;
            min-height: 250px;
        }
        .form-control {
            border-radius: 8px;
            background-color: #e9ecef;
        }
        .form-control:focus {
            background-color: #e9ecef;
            box-shadow: none;
            border: none;
        }
        .btn-custom {
            background-color: #007bff;
            color: white;
            border-radius: 8px;
        }
        .btn-custom:hover {
            background-color: #0056b3;
        }
        .password-wrapper {
            position: relative;
        }
        .password-wrapper .toggle-password {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
        }
        @media (max-width: 768px) {
            .carousel {
                display: none;
            }
        }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center min-vh-100">
    <div class="card p-4 shadow-lg card-custom">
        <div class="row g-4 align-items-center">
            <div class="col-md-6 d-none d-md-block">
                <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="{{ url('bahan/1.jpg') }}" class="d-block w-100" alt="Image 1">
                        </div>
                        <div class="carousel-item">
                            <img src="{{ url('bahan/2.jpg') }}" class="d-block w-100" alt="Image 2">
                        </div>
                        <div class="carousel-item">
                            <img src="{{ url('bahan/3.jpg') }}" class="d-block w-100" alt="Image 3">
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    </button>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <h2 class="text-center fw-bold mb-3">Register</h2>
                <form id="registerForm" method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <input type="text" class="form-control" name="nis" placeholder="NIS" required>
                    </div>
                    <div class="mb-3">
                        <input type="text" class="form-control" name="nama" placeholder="Nama" required>
                    </div>
                    <div class="mb-3">
                        <input type="email" class="form-control" name="email" placeholder="Email" required>
                    </div>
                    <div class="mb-3">
                        <input type="text" class="form-control" name="alamat" placeholder="Alamat" required>
                    </div>
                    <!-- Foto Diri -->
                    <div class="mb-3">
                        <label for="foto_diri" class="form-label">Foto Diri</label>
                        <input type="file" class="form-control" name="foto_diri" id="foto_diri" required>
                    </div>
                    <!-- Foto KTP -->
                    <div class="mb-3">
                        <label for="foto_ktp" class="form-label">Foto KTP</label>
                        <input type="file" class="form-control" name="foto_ktp" id="foto_ktp" required>
                    </div>
                    <div class="mb-3 password-wrapper">
                        <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
                        <i class="fas fa-eye toggle-password" onclick="togglePassword('password')"></i>
                    </div>
                    <div class="mb-3 password-wrapper">
                        <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="Konfirmasi Password" required>
                        <i class="fas fa-eye toggle-password" onclick="togglePassword('password_confirmation')"></i>
                    </div>
                    <button type="submit" class="btn btn-custom w-100">Register</button>
                </form>
                <p class="text-center mt-3">
                    Sudah Ada Akun? <a href="{{ route('loginForm') }}" class="text-primary">Login Kesini</a>
                </p>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function togglePassword(id) {
            var input = document.getElementById(id);
            if (input.type === "password") {
                input.type = "text";
            } else {
                input.type = "password";
            }
        }
        document.getElementById('registerForm').addEventListener('submit', function(event) {
            event.preventDefault();
            Swal.fire({
                title: 'Sukses!',
                text: 'Pendaftaran berhasil!',
                icon: 'success',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            });
        });
    </script>
</body>
</html>
