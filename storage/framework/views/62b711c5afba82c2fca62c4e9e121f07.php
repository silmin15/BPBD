<?php
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
?>

<aside id="main-sidebar"
    class="fixed inset-y-0 left-0 z-40 w-72 bg-white border-r border-orange-200
           p-4 transform transition-transform duration-200 ease-in-out
           -translate-x-full md:translate-x-0">

    <div class="flex items-center justify-between mb-6">
        <a href="<?php echo e($dashUrl); ?>" class="flex items-center gap-2">
            <img src="<?php echo e(asset('images/logo-bpbd.png')); ?>" class="h-9" alt="BPBD Logo" />
            <span class="text-lg font-extrabold text-gray-800">BPBD Banjarnegara</span>
        </a>
        <button id="sidebar-close" data-sidebar-toggle class="md:hidden p-2">
            <i class="bi bi-x-lg"></i>
        </button>
    </div>

    
    <nav class="flex flex-col space-y-3">

        
        <?php if (\Illuminate\Support\Facades\Blade::check('role', 'Super Admin')): ?>
            <a href="<?php echo e(route('admin.dashboard')); ?>"
                class="sidebar-link <?php echo e(request()->routeIs('admin.dashboard') ? 'active' : ''); ?>">
                <i class="bi bi-house-door-fill me-2"></i> Dashboard
            </a>

            <?php if(Route::has('admin.rekap-kegiatan.rekap')): ?>
                <a href="<?php echo e(route('admin.rekap-kegiatan.rekap')); ?>"
                    class="sidebar-link <?php echo e(request()->routeIs('admin.rekap-kegiatan.*') ? 'active' : ''); ?>">
                    <i class="bi bi-clipboard2-data-fill me-2"></i> Laporan
                </a>
            <?php endif; ?>

            <a href="<?php echo e(route('admin.logistik.rekap', now()->year)); ?>"
                class="sidebar-link <?php echo e(request()->routeIs('admin.logistik.*') ? 'active' : ''); ?>">
                <i class="bi bi-clipboard2-data"></i> Rekap Logistik
            </a>

            <a href="<?php echo e(route('admin.manajemen-user.index')); ?>"
                class="sidebar-link <?php echo e(request()->routeIs('admin.manajemen-user.*') ? 'active' : ''); ?>">
                <i class="bi bi-people-fill me-2"></i> Manajemen User
            </a>

            <a href="<?php echo e(route('admin.sk.index')); ?>"
                class="sidebar-link <?php echo e(request()->routeIs('admin.sk.*') ? 'active' : ''); ?>">
                <i class="bi bi-journal-text me-2"></i> Data & Rekap SK
            </a>

            
            <a href="<?php echo e(route('admin.sop.index')); ?>"
                class="sidebar-link <?php echo e(request()->routeIs('admin.sop.*') ? 'active' : ''); ?>">
                <i class="bi bi-life-preserver me-2"></i> SOP Kebencanaan
            </a>
        <?php endif; ?>

        
        <?php if (\Illuminate\Support\Facades\Blade::check('role', 'PK')): ?>
            <a href="<?php echo e(route('pk.dashboard')); ?>"
                class="sidebar-link <?php echo e(request()->routeIs('pk.dashboard') ? 'active' : ''); ?>">
                <i class="bi bi-house-door-fill me-2"></i> Dashboard
            </a>

            <a href="<?php echo e(route('pk.lap-kegiatan.index')); ?>"
                class="sidebar-link <?php echo e(request()->routeIs('pk.lap-kegiatan.*') ? 'active' : ''); ?>">
                <i class="bi bi-file-text-fill me-2"></i> Input Kegiatan
            </a>

            <a href="<?php echo e(route('pk.sk.index')); ?>" class="sidebar-link <?php echo e(request()->routeIs('pk.sk.*') ? 'active' : ''); ?>">
                <i class="bi bi-journal-text me-2"></i> Data & Rekap SK
            </a>

            
            <a href="<?php echo e(route('pk.sop.index')); ?>"
                class="sidebar-link <?php echo e(request()->routeIs('pk.sop.*') ? 'active' : ''); ?>">
                <i class="bi bi-life-preserver me-2"></i> SOP Kebencanaan
            </a>
            
            <a href="<?php echo e(route('pk.bast.index')); ?>"
                class="sidebar-link <?php echo e(request()->routeIs('pk.bast.*') ? 'active' : ''); ?>">
                <i class="bi bi-file-earmark-text me-2"></i> BAST
            </a>
        <?php endif; ?>

        
        <?php if (\Illuminate\Support\Facades\Blade::check('role', 'KL')): ?>
            <a href="<?php echo e(route('kl.dashboard')); ?>"
                class="sidebar-link <?php echo e(request()->routeIs('kl.dashboard') ? 'active' : ''); ?>">
                <i class="bi bi-house-door-fill me-2"></i> Dashboard
            </a>

            <a href="<?php echo e(route('kl.lap-kegiatan.index')); ?>"
                class="sidebar-link <?php echo e(request()->routeIs('kl.lap-kegiatan.*') ? 'active' : ''); ?>">
                <i class="bi bi-file-text-fill me-2"></i> Input Kegiatan
            </a>

            <?php
                $logistikIndexRoute = Route::has('kl.logistik.index') ? 'kl.logistik.index' : null;
                $isLogistikActive = request()->routeIs('kl.logistik.*');
            ?>
            <?php if($logistikIndexRoute): ?>
                <a href="<?php echo e(route($logistikIndexRoute)); ?>" class="sidebar-link <?php echo e($isLogistikActive ? 'active' : ''); ?>">
                    <i class="bi bi-box-seam-fill me-2"></i> Input Logistik
                </a>
            <?php endif; ?>

            <a href="<?php echo e(route('kl.sk.index')); ?>" class="sidebar-link <?php echo e(request()->routeIs('kl.sk.*') ? 'active' : ''); ?>">
                <i class="bi bi-journal-text me-2"></i> Data & Rekap SK
            </a>

            
            <a href="<?php echo e(route('kl.sop.index')); ?>"
                class="sidebar-link <?php echo e(request()->routeIs('kl.sop.*') ? 'active' : ''); ?>">
                <i class="bi bi-life-preserver me-2"></i> SOP Kebencanaan
            </a>
        <?php endif; ?>

        
        <?php if (\Illuminate\Support\Facades\Blade::check('role', 'RR')): ?>
            <a href="<?php echo e(route('rr.dashboard')); ?>"
                class="sidebar-link <?php echo e(request()->routeIs('rr.dashboard') ? 'active' : ''); ?>">
                <i class="bi bi-house-door-fill me-2"></i> Dashboard
            </a>

            <a href="<?php echo e(route('rr.lap-kegiatan.index')); ?>"
                class="sidebar-link <?php echo e(request()->routeIs('rr.lap-kegiatan.*') ? 'active' : ''); ?>">
                <i class="bi bi-file-text-fill me-2"></i> Input Kegiatan
            </a>

            <a href="<?php echo e(route('rr.sk.index')); ?>" class="sidebar-link <?php echo e(request()->routeIs('rr.sk.*') ? 'active' : ''); ?>">
                <i class="bi bi-journal-text me-2"></i> Data & Rekap SK
            </a>

            
            <a href="<?php echo e(route('rr.sop.index')); ?>"
                class="sidebar-link <?php echo e(request()->routeIs('rr.sop.*') ? 'active' : ''); ?>">
                <i class="bi bi-life-preserver me-2"></i> SOP Kebencanaan
            </a>
        <?php endif; ?>

        
        <?php if (\Illuminate\Support\Facades\Blade::check('role', 'Staf BPBD')): ?>
            <?php if(Route::has('admin.inventaris.index')): ?>
                <a href="<?php echo e(route('admin.inventaris.index')); ?>"
                    class="sidebar-link <?php echo e(request()->routeIs('admin.inventaris.*') ? 'active' : ''); ?>">
                    <i class="bi bi-card-checklist me-2"></i> Inventaris
                </a>
            <?php endif; ?>
        <?php endif; ?>

    </nav>
</aside>


<div id="sidebar-backdrop" class="fixed inset-0 bg-black/40 z-30 hidden"></div>
<?php /**PATH C:\laragon\www\BPBD\resources\views/layouts/partials/sidebar.blade.php ENDPATH**/ ?>