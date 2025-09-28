<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Peta Bencana - BPBD Banjarnegara</title>

    {{-- Vite: JS publik (di dalamnya mengimport SCSS publik) --}}
    @vite(['resources/js/app_publik.js'])

    {{-- Ikon & Leaflet CSS --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">

    {{-- Stack: styles khusus halaman --}}
    @stack('styles')

    <style>
        /* Beri ruang di atas untuk navbar fixed */
        body { padding-top: 70px; }

        /* Pastikan navbar selalu di atas */
        .navbar.fixed-top { z-index: 2000; }

        /* Map dan kontrol berada di bawah overlay/offcanvas */
        .leaflet-container { z-index: 1; }
        .leaflet-top, .leaflet-bottom { z-index: 1; }

        /* Offcanvas filter di atas peta */
        .offcanvas { z-index: 2100; }
    </style>
</head>

<body class="d-flex flex-column min-vh-100">
    {{-- Navbar publik --}}
    @include('layouts.partials.navigation_publik')
    @include('pages.publik.bast-modal')
    <main class="flex-grow-1">
        @yield('content')
    </main>

    {{-- Footer --}}
    @include('layouts.partials._footer')

    {{-- Modal Login (cukup satu id="loginModal" di seluruh halaman) --}}
    <x-ui.modal />

    {{-- Leaflet JS (harus ada agar peta hidup) --}}
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    {{-- Stack: scripts khusus halaman --}}
    @stack('scripts')
</body>

</html>
