<nav class="navbar navbar-expand-lg navbar-dark topbar-custom py-2 shadow-sm fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand d-flex align-items-center fw-bold" href="{{ url('/') }}">
            <img src="{{ asset('images/logo-bpbd.png') }}" alt="Logo BPBD" width="40" height="40"
                class="d-inline-block align-text-top me-3">
            BPBD Banjarnegara
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navPublik"
            aria-controls="navPublik" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navPublik">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-lg-center">
                <li class="nav-item"><a class="nav-link text-white" href="{{ route('peta.publik') }}">Peta Bencana</a>
                </li>
                <li class="nav-item"><a class="nav-link text-white" href="{{ route('grafik.publik') }}">Grafik</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="#">Dokumentasi</a></li>

                {{-- Search global (global site search) --}}
                <li class="nav-item ms-lg-3">
                    <x-ui.search-bar id="searchGlobal" placeholder="Cari apapun..." />
                </li>

                {{-- Tombol login --}}
                <li class="nav-item ms-lg-3">
                    <x-ui.button variant="footer" class="fw-bold" data-bs-toggle="modal" data-bs-target="#loginModal">
                        Login
                    </x-ui.button>
                </li>
            </ul>
        </div>
    </div>
</nav>