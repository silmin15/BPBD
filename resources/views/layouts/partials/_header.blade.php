<header class="navbar navbar-expand-lg navbar-dark bg-orange py-2 shadow-sm">
    <div class="container-fluid">
        <a class="navbar-brand d-flex align-items-center fw-bold" href="{{ url('/') }}">
            <img src="{{ asset('images/logo-bpbd.png') }}" alt="Logo BPBD" width="40" height="40" class="d-inline-block align-text-top me-3">
            BPBD Banjarnegara
        </a>

        <div class="ms-auto d-flex align-items-center">
            <nav class="navbar-nav d-none d-lg-flex">
                <a class="nav-link text-white" href="#">Peta Bencana</a>
                <a class="nav-link text-white" href="#">Grafik</a>
                <a class="nav-link text-white" href="#" data-bs-toggle="modal" data-bs-target="#loginModal">Inventaris BPBD</a>
            </nav>

            <div class="theme-toggle mx-3">
                <button class="btn btn-outline-light">
                    <i class="bi bi-moon-stars-fill"></i> / <i class="bi bi-sun-fill"></i>
                </button>
            </div>

            <a href="#" class="btn btn-primary fw-bold">Login</a>

        </div>
    </div>
</header>