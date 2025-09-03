<div class="flex items-center justify-between gap-3 flex-wrap mb-4">
    <div>

        <h1 class="flex items-center gap-2 text-xl font-semibold text-slate-800">
            @yield('page_icon')
            @yield('page_title', 'Dashboard')
        </h1>

        <ol class="breadcrumb text-sm text-slate-500 mt-1">
            <li class="breadcrumb-item active">
                @yield('page_breadcrumb', 'Statistik')
            </li>
        </ol>
    </div>

    <div class="flex items-center gap-2">
        @yield('page_actions')
    </div>
</div>
