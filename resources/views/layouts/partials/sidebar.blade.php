<aside id="main-sidebar" class="w-64 bg-white flex-shrink-0 p-4">
    {{-- Top Section of Sidebar --}}
    <div class="flex items-center justify-between mb-6">
        <a href="{{ route('dashboard') }}" class="flex items-center">
            <img src="{{ asset('images/logo-bpbd.png') }}" class="h-8 me-2" alt="BPBD Logo" />
            <span class="text-lg font-bold text-gray-800">BPBD Banjarnegara</span>
        </a>
        {{-- Tombol hamburger --}}
    </div>

    {{-- Menu Navigation --}}
    <nav class="flex flex-col space-y-2">
        <a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="bi bi-house-door-fill me-3"></i> Dashboard
        </a>
        <a href="#" class="sidebar-link">
            <i class="bi bi-people-fill me-3"></i> Data Relawan
        </a>
        <a href="{{ route('admin.inventaris.index') }}" class="sidebar-link {{ request()->routeIs('admin.inventaris.*') ? 'active' : '' }}">
            <i class="bi bi-box-seam-fill me-3"></i> Kelola Inventaris
        </a>

        <a href="{{ route('admin.kejadian.index') }}" class="sidebar-link {{ request()->routeIs('admin.kejadian.*') ? 'active' : '' }}">
            <i class="bi bi-journal-text me-3"></i> Catatan Kejadian
        </a>
        {{-- ... dst ... --}}
    </nav>
</aside>