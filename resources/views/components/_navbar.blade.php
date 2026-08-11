<nav class="navbar navbar-expand-lg" id="smartNavbar" data-aos="fade-down" data-aos-duration="1200">
    <div class="container">
        <a class="navbar-brand fs-2" href="{{ url('/') }}">
            <i class="fas fa-crown me-2"></i>SANDY HOTEL
        </a>
        <button class="navbar-toggler bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item"><a class="nav-link mx-2" href="{{ url('/') }}">Home</a></li>
                <li class="nav-item"><a class="nav-link mx-2" href="#fasilitas">Facilities</a></li>
                <li class="nav-item"><a class="nav-link mx-2" href="#rooms">Rooms</a></li>
                
                @auth
                    @if(Auth::user()->role == 'admin')
                        <li class="nav-item"><a class="nav-link mx-2 text-warning fw-bold" href="{{ url('/admin') }}"><i class="fas fa-tools"></i> Panel Admin</a></li>
                    @elseif(Auth::user()->role == 'petugas')
                        <li class="nav-item"><a class="nav-link mx-2 text-warning fw-bold" href="{{ url('/petugas') }}"><i class="fas fa-concierge-bell"></i> Panel Petugas</a></li>
                    @else
                        <li class="nav-item"><a class="nav-link mx-2" href="{{ url('/riwayat') }}">Riwayat</a></li>
                    @endif
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-outline-warning btn-sm ms-3 px-4 rounded-pill">Logout</button>
                        </form>
                    </li>
                @else
                    <li class="nav-item"><a class="btn btn-warning btn-sm ms-3 px-4 rounded-pill fw-bold text-dark" href="{{ url('/login') }}">Login</a></li>
                @endauth
            </ul>
        </div>
    </div>
</nav>