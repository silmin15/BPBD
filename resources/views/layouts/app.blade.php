<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    {{-- ... head content ... --}}
    @vite(['resources/scss/app.scss', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100 flex">

        {{-- =================================== --}}
        {{-- ======== BAGIAN SIDEBAR BARU ======== --}}
        {{-- =================================== --}}
        @include('layouts.partials.sidebar')

        {{-- =================================== --}}
        {{-- ====== AREA KONTEN UTAMA BARU ====== --}}
        {{-- =================================== --}}
        <div class="flex-1 flex flex-col">

            {{-- Navigasi Atas (Top Bar) --}}
            @include('layouts.navigation')

            <!-- Page Heading -->
            @if (isset($header))
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
            @endif

            <!-- Page Content -->
            <main class="flex-1">
                {{ $slot }}
            </main>
        </div>

    </div>
</body>

</html>