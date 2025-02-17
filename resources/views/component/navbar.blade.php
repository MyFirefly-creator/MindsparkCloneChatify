<div class="sidebar">
    <div class="text-center mb-4">
        <img src="{{ Auth::check() ? asset(Auth::user()->avatar) : asset('profil/avatar.png') }}"
        class="rounded-circle"
        style="width: 60px; height: 60px; object-fit: cover; margin: auto;">
        <p class="fw-bold mt-2">
            {{ Auth::check() ? Auth::user()->nama : 'Guest' }}
        </p>
    </div>

    <nav>
        <ul class="list-unstyled">
            <li><a href="{{ route('dashboard.index') }}"><i class="fas fa-home"></i> Beranda</a></li>

            @if (Auth::check())
                <li><a href="{{ route('dashboard.index') }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                <li><a href="{{ route('settings') }}"><i class="fas fa-cog"></i> Settings</a></li>
                <li>
                    <a href="{{ route('peminjaman.show',['userId' => Auth::id()])}}">
                        <i class="fas fa-book"></i> Peminjaman
                    </a>
                </li>
                <li><a href="{{ route('favorit.index') }}"><i class="fas fa-heart"></i> Favorit</a></li>

                @if(Auth::check() && in_array(Auth::user()->role, ['admin', 'superadmin']))
                    <li><a class="text-danger" href="{{ route('admin.index') }}"><i class="fas fa-user-shield"></i> Admin</a></li>
                @endif

                <li><a href="{{ route('logout') }}" class="text-danger"><i class="fas fa-sign-out-alt"></i> Logout</a></li>

            @else
                <li class="mt-3 text-center">
                    <a href="{{ route('loginForm') }}" class="btn btn-outline-primary me-2"><i class="fas fa-sign-in-alt"></i> Login</a>
                    <a href="{{ route('registerForm') }}" class="btn btn-primary"><i class="fas fa-user-plus"></i> Register</a>
                </li>
            @endif
        </ul>
    </nav>
</div>
