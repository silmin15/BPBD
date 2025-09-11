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

                {{-- Home --}}
                @php $homeActive = Route::has('home.publik') ? request()->routeIs('home.publik') : url()->current() === url('/'); @endphp
                <li class="nav-item">
                    @if (Route::has('home.publik'))
                        <a class="nav-link {{ $homeActive ? 'active fw-semibold' : 'text-white' }}"
                            href="{{ route('home.publik') }}">
                            Home
                        </a>
                    @else
                        {{-- fallback jika belum ada route name home.publik --}}
                        <a class="nav-link text-white" href="{{ url('/') }}">Home</a>
                    @endif
                </li>

                {{-- Peta --}}
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('peta.publik') ? 'active fw-semibold' : 'text-white' }}"
                        href="{{ route('peta.publik') }}">
                        Peta Bencana
                    </a>
                </li>

                {{-- Grafik --}}
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('grafik.publik') ? 'active fw-semibold' : 'text-white' }}"
                        href="{{ route('grafik.publik') }}">
                        Grafik
                    </a>
                </li>

                {{-- SOP Kebencanaan (Publik) --}}
                @php $sopActive = request()->routeIs('sop.publik.*'); @endphp
                <li class="nav-item">
                    @if (Route::has('sop.publik.index'))
                        <a class="nav-link {{ $sopActive ? 'active fw-semibold' : 'text-white' }}"
                            href="{{ route('sop.publik.index') }}">
                            SOP Kebencanaan
                        </a>
                    @else
                        {{-- fallback kalau route name belum terdaftar --}}
                        <a class="nav-link text-white" href="{{ url('/sop-kebencanaan') }}">
                            SOP Kebencanaan
                        </a>
                    @endif
                </li>

                {{-- Dokumentasi (placeholder) --}}
                <li class="nav-item">
                    <a class="nav-link text-white" href="#">Dokumentasi</a>
                </li>
                {{-- LAYANAN MASYARAKAT (dropdown) --}}
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white" href="#" id="layananDrop" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Layanan Masyarakat
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="layananDrop">
                        <li>
                            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#bastModal">
                                <i class="bi bi-clipboard2-check me-2"></i>
                                BAST (Peminjaman Alat)
                            </a>
                        </li>
                        {{-- Tambahkan item layanan lain di sini nanti --}}
                    </ul>
                </li>

                {{-- Search global --}}
                <li class="nav-item ms-lg-3">
                    <x-ui.search-bar id="searchGlobal" placeholder="Cari apapun..." />
                </li>

                {{-- Login --}}
                <li class="nav-item ms-lg-3">
                    <x-ui.button variant="footer" class="fw-bold" data-bs-toggle="modal" data-bs-target="#loginModal">
                        Login
                    </x-ui.button>
                </li>
            </ul>
        </div>
    </div>
</nav>