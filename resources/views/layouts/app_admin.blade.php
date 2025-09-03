<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @vite(['resources/js/app_admin.js'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>

<body data-scope="admin" data-page="{{ 'role/admin/' . str_replace('.', '/', request()->route()->getName()) }}"
    class="tw-font-sans tw-antialiased">

    {{-- SIDEBAR --}}
    @include('layouts.partials.sidebar')

    {{-- OVERLAY (untuk off-canvas mobile) --}}
    <div id="sidebar-backdrop" class="tw-fixed tw-inset-0 tw-bg-black/40 tw-z-30 tw-hidden"></div>

    {{-- TOPBAR --}}
    @include('layouts.partials.navigation_admin')

    {{-- WRAPPER KONTEN --}}
    <div id="main-content"
        class="tw-min-h-screen tw-bg-gray-100 tw-flex tw-flex-col tw-transition-[padding] tw-duration-200 tw-ease-in-out md:tw-pl-72">

        {{-- ===== PAGE HEADER ===== --}}
        <header class="tw-px-4 sm:tw-px-6 lg:tw-px-8 tw-pt-4">
            @hasSection('page_title')
                <div class="tw-flex tw-items-center tw-justify-between tw-gap-3 tw-flex-wrap">
                    <div>
                        <h1 class="tw-flex tw-items-center tw-gap-2 tw-text-xl tw-font-semibold tw-text-slate-800">
                            @yield('page_icon')
                            @yield('page_title')
                        </h1>
                        @hasSection('page_breadcrumb')
                            <ol class="breadcrumb tw-text-sm tw-text-slate-500 tw-mt-1">
                                <li class="breadcrumb-item active">
                                    @yield('page_breadcrumb')
                                </li>
                            </ol>
                        @endif
                    </div>
                    <div class="tw-flex tw-items-center tw-gap-2">
                        @yield('page_actions')
                    </div>
                </div>
            @endif
        </header>

        {{-- KONTEN HALAMAN --}}
        <main class="tw-flex-1 tw-px-4 sm:tw-px-6 lg:tw-px-8 tw-pb-8 tw-pt-4">
            @yield('content')
        </main>
    </div>
</body>

</html>
