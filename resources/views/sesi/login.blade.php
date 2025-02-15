<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
        }
        .form-control {
            border-radius: 8px;
            background-color: #e9ecef;
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
        .toggle-password {
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
            <!-- Carousel Section -->
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

            <!-- Login Form -->
            <div class="col-12 col-md-6 d-flex flex-column align-items-center justify-content-center">
                <div class="w-100" style="max-width: 350px;">
                    <h2 class="text-center fw-bold mb-3">Login</h2>
                    <form id="loginForm" action="{{ route('login') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <input type="text" name="nis" class="form-control" placeholder="NIS" required>
                        </div>
                        <div class="mb-3 password-wrapper">
                            <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
                            <i class="fas fa-eye toggle-password" onclick="togglePassword('password')"></i>
                        </div>
                        <button type="button" class="btn btn-custom w-100" onclick="submitForm()">Login</button>
                    </form>
                    <p class="text-center mt-3">
                        Belum Ada Akun? <a href="{{ route('registerForm') }}" class="text-primary">Register Disini</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script>
        @if(session('error'))
            Swal.fire({
                title: 'Gagal!',
                text: '{{ session('error') }}',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        @endif

        function togglePassword(id) {
            var input = document.getElementById(id);
            var icon = input.nextElementSibling;
            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            } else {
                input.type = "password";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            }
        }

        function submitForm() {
            var nis = document.querySelector('input[name="nis"]').value;
            var password = document.querySelector('input[name="password"]').value;
            if (!nis || !password) {
                Swal.fire({
                    title: 'Error!',
                    text: 'Semua field harus diisi!',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            } else {
                Swal.fire({
                    title: 'Konfirmasi Login',
                    text: 'Apakah Anda yakin ingin login?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Login!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('loginForm').submit();
                    }
                });
            }
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
