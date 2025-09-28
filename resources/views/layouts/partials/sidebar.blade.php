@php
/** @var \App\Models\User|null $auth */
$auth = auth()->user();

$dashUrl = route('dashboard');
if ($auth) {
if ($auth->hasRole('Super Admin')) {
$dashUrl = route('admin.dashboard');
} elseif ($auth->hasRole('PK')) {
$dashUrl = route('pk.dashboard');
} elseif ($auth->hasRole('KL')) {
$dashUrl = route('kl.dashboard');
} elseif ($auth->hasRole('RR')) {
$dashUrl = route('rr.dashboard');
}
}
@endphp

<aside id="main-sidebar"
    class="fixed inset-y-0 left-0 z-40 w-72 bg-white border-r border-orange-200
           p-4 transform transition-transform duration-200 ease-in-out
           -translate-x-full md:translate-x-0">

    <div class="flex items-center justify-between mb-6">
        <a href="{{ $dashUrl }}" class="flex items-center gap-2">
            <img src="{{ asset('images/logo-bpbd.png') }}" class="h-9" alt="BPBD Logo" />
            <span class="text-lg font-extrabold text-gray-800">BPBD Banjarnegara</span>
        </a>
        <button id="sidebar-close" data-sidebar-toggle class="md:hidden p-2">
            <i class="bi bi-x-lg"></i>
        </button>
    </div>

    {{-- MENU --}}
    <nav class="flex flex-col space-y-3">

        {{-- ====== SUPER ADMIN ====== --}}
        @role('Super Admin')
            <a href="{{ route('admin.dashboard') }}"
                class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-house-door-fill me-2"></i> Dashboard
            </a>

            @if (Route::has('admin.rekap-kegiatan.rekap'))
                <a href="{{ route('admin.rekap-kegiatan.rekap') }}"
                    class="sidebar-link {{ request()->routeIs('admin.rekap-kegiatan.*') ? 'active' : '' }}">
                    <i class="bi bi-clipboard2-data-fill me-2"></i> Laporan
                </a>
            @endif

            <a href="{{ route('admin.logistik.rekap', now()->year) }}"
                class="sidebar-link {{ request()->routeIs('admin.logistik.*') ? 'active' : '' }}">
                <i class="bi bi-clipboard2-data"></i> Rekap Logistik
            </a>

            <a href="{{ route('admin.manajemen-user.index') }}"
                class="sidebar-link {{ request()->routeIs('admin.manajemen-user.*') ? 'active' : '' }}">
                <i class="bi bi-people-fill me-2"></i> Manajemen User
            </a>

            <a href="{{ route('admin.sk.index') }}"
                class="sidebar-link {{ request()->routeIs('admin.sk.*') ? 'active' : '' }}">
                <i class="bi bi-journal-text me-2"></i> Data & Rekap SK
            </a>

            {{-- SOP Kebencanaan (Admin) --}}
            <a href="{{ route('admin.sop.index') }}"
                class="sidebar-link {{ request()->routeIs('admin.sop.*') ? 'active' : '' }}">
                <i class="bi bi-life-preserver me-2"></i> SOP Kebencanaan
            </a>
        @endrole

        {{-- ====== PK ====== --}}
        @role('PK')
        <a href="{{ route('pk.dashboard') }}"
            class="sidebar-link {{ request()->routeIs('pk.dashboard') ? 'active' : '' }}">
            <i class="bi bi-house-door-fill me-2"></i> Dashboard
        </a>

            <a href="{{ route('pk.lap-kegiatan.index') }}"
                class="sidebar-link {{ request()->routeIs('pk.lap-kegiatan.*') ? 'active' : '' }}">
                <i class="bi bi-file-text-fill me-2"></i> Input Kegiatan
            </a>

            <a href="{{ route('pk.sk.index') }}" class="sidebar-link {{ request()->routeIs('pk.sk.*') ? 'active' : '' }}">
                <i class="bi bi-journal-text me-2"></i> Data & Rekap SK
            </a>

            {{-- SOP Kebencanaan (PK) --}}
            <a href="{{ route('pk.sop.index') }}"
                class="sidebar-link {{ request()->routeIs('pk.sop.*') ? 'active' : '' }}">
                <i class="bi bi-life-preserver me-2"></i> SOP Kebencanaan
            </a>
            
            <a href="{{ route('pk.bast.index') }}"
                class="sidebar-link {{ request()->routeIs('pk.bast.*') ? 'active' : '' }}">
                <i class="bi bi-file-earmark-text me-2"></i> BAST
            </a>
        @endrole

        {{-- ====== KL ===== --}}
        @role('KL')
        <a href="{{ route('kl.dashboard') }}"
            class="sidebar-link {{ request()->routeIs('kl.dashboard') ? 'active' : '' }}">
            <i class="bi bi-house-door-fill me-2"></i> Dashboard
        </a>

        <a href="{{ route('kl.lap-kegiatan.index') }}"
            class="sidebar-link {{ request()->routeIs('kl.lap-kegiatan.*') ? 'active' : '' }}">
            <i class="bi bi-file-text-fill me-2"></i> Input Kegiatan
        </a>

        @php
        $logistikIndexRoute = Route::has('kl.logistik.index') ? 'kl.logistik.index' : null;
        $isLogistikActive = request()->routeIs('kl.logistik.*');

        $thisYear = now()->year;
        $years = range($thisYear, $thisYear - 5);
        @endphp

        @if ($logistikIndexRoute)
        <a href="{{ route($logistikIndexRoute) }}" class="sidebar-link {{ $isLogistikActive ? 'active' : '' }}">
            <i class="bi bi-box-seam-fill me-2"></i> Input Logistik
        </a>
        @endif
        <a href="{{ route('kl.sk.index') }}" class="sidebar-link {{ request()->routeIs('rr.sk.*') ? 'active' : '' }}">
            <i class="bi bi-journal-text me-2"></i> Data & Rekap SK
        </a>

        @php
        $isBencanaGroupActive = request()->routeIs('kl.kejadian-bencana.*') || request()->routeIs('kl.jenis-bencana.*');
        @endphp
        <details class="sidebar-group" @if($isBencanaGroupActive) open @endif>
            <summary class="sidebar-link d-flex align-items-center">
                <i class="bi bi-journal-text me-2"></i>
                <span>Manajemen Bencana</span>
                <i class="bi bi-chevron-down ms-auto"></i>
            </summary>
            <div class="ps-3 d-flex flex-column gap-2 mt-2">
                <a href="{{ route('kl.kejadian-bencana.index') }}" class="sidebar-link {{ request()->routeIs('kl.kejadian-bencana.index') ? 'active' : '' }}">
                    Data Kejadian
                </a>
                @if (Route::has('kl.kejadian-bencana.import.form'))
                <a href="{{ route('kl.kejadian-bencana.import.form') }}" class="sidebar-link {{ request()->routeIs('kl.kejadian-bencana.import.*') ? 'active' : '' }}">
                    Impor GeoJSON
                </a>
                @endif
                <a href="{{ route('kl.jenis-bencana.index') }}" class="sidebar-link {{ request()->routeIs('kl.jenis-bencana.*') ? 'active' : '' }}">
                    Jenis Bencana
                </a>
            </div>
        </details>

        @endrole

        {{-- ====== RR ====== --}}
        @role('RR')
        <a href="{{ route('rr.dashboard') }}"
            class="sidebar-link {{ request()->routeIs('rr.dashboard') ? 'active' : '' }}">
            <i class="bi bi-house-door-fill me-2"></i> Dashboard
        </a>

            <a href="{{ route('rr.lap-kegiatan.index') }}"
                class="sidebar-link {{ request()->routeIs('rr.lap-kegiatan.*') ? 'active' : '' }}">
                <i class="bi bi-file-text-fill me-2"></i> Input Kegiatan
            </a>

            <a href="{{ route('rr.sk.index') }}" class="sidebar-link {{ request()->routeIs('rr.sk.*') ? 'active' : '' }}">
                <i class="bi bi-journal-text me-2"></i> Data & Rekap SK
            </a>

            {{-- SOP Kebencanaan (RR) --}}
            <a href="{{ route('rr.sop.index') }}"
                class="sidebar-link {{ request()->routeIs('rr.sop.*') ? 'active' : '' }}">
                <i class="bi bi-life-preserver me-2"></i> SOP Kebencanaan
            </a>
        @endrole

        {{-- ====== STAF BPBD (opsional) ====== --}}
        @role('Staf BPBD')
        @if (Route::has('admin.inventaris.index'))
        <a href="{{ route('admin.inventaris.index') }}"
            class="sidebar-link {{ request()->routeIs('admin.inventaris.*') ? 'active' : '' }}">
            <i class="bi bi-card-checklist me-2"></i> Inventaris
        </a>
        @endif
        @endrole

    </nav>
</aside>

{{-- Overlay (mobile) --}}
<div id="sidebar-backdrop" class="fixed inset-0 bg-black/40 z-30 hidden"></div>