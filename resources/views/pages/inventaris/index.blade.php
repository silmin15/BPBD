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

</body>

</html>