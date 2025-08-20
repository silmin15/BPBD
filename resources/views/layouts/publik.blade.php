<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <title>Peta Bencana - BPBD Banjarnegara</title>

    @vite(['resources/scss/app.scss', 'resources/js/app.js'])

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />

    <style>
    </style>
</head>

<body class="d-flex flex-column min-vh-100">
    @include('layouts.partials._header')

    <main class="flex-grow-1">
        @yield('content')
    </main>

    @include('layouts.partials._footer')


    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 1rem; background-color: rgba(255, 255, 255, 0.85); backdrop-filter: blur(5px);">

                {{-- Form Login --}}
                <form id="loginFormModal" method="POST" action="{{ url('/api/login') }}">
                    @csrf
                    <div class="modal-body p-4 p-lg-5 text-black">

                        <div class="text-center mb-4">
                            <img src="{{ asset('images/logo-bpbd.png') }}" alt="Logo BPBD" style="width: 80px;" class="mx-auto">
                            <h4 class="mt-3 mb-2 fw-bold">BPBD Banjarnegara</h4>
                            <p class="text-muted">Hai, Selamat Datang di sistem BPBD</p>
                        </div>

                        {{-- Untuk menampilkan error umum (mis: "Email atau password salah") --}}
                        <div id="login-error-alert" class="alert alert-danger d-none" role="alert"></div>

                        <div class="form-outline mb-4">
                            <label class="form-label fw-bold" for="emailModal">Username / E-mail</label>
                            <input type="email" id="emailModal" name="email" class="form-control form-control-lg" placeholder="Lorem123 atau Lorem@gmail.com" required />
                            <div id="email-error" class="text-danger mt-1 small"></div>
                        </div>

                        <div class="form-outline mb-4">
                            <label class="form-label fw-bold" for="passwordModal">Password</label>
                            <input type="password" id="passwordModal" name="password" class="form-control form-control-lg" placeholder="Lorem123124234" required />
                            <div id="password-error" class="text-danger mt-1 small"></div>
                        </div>

                        <div class="pt-1 mb-4">
                            <button class="btn btn-primary btn-lg w-100" type="submit">Login</button>
                        </div>

                        <a class="small text-muted" href="{{ route('password.request') }}">Lupa kata sandi?</a>

                    </div>
                </form>

            </div>
        </div>
    </div>




    @vite(['resources/js/app.js'])
    <!-- JS Leaflet -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script src="{{ asset('js/peta-publik.js') }}"></script>
</body>

</html>