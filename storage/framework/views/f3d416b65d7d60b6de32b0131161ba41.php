<nav class="navbar navbar-expand-lg navbar-dark topbar-custom py-2 shadow-sm">
    <div class="container-fluid">
        <a class="navbar-brand d-flex align-items-center fw-bold" href="<?php echo e(url('/')); ?>">
            <img src="<?php echo e(asset('images/logo-bpbd.png')); ?>" alt="Logo BPBD" width="40" height="40"
                class="d-inline-block align-text-top me-3">
            BPBD Banjarnegara
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navPublik"
            aria-controls="navPublik" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navPublik">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-lg-center">

                
                <?php $homeActive = Route::has('home.publik') ? request()->routeIs('home.publik') : url()->current() === url('/'); ?>
                <li class="nav-item">
                    <?php if(Route::has('home.publik')): ?>
                        <a class="nav-link <?php echo e($homeActive ? 'active fw-semibold' : 'text-white'); ?>"
                            href="<?php echo e(route('home.publik')); ?>">
                            Home
                        </a>
                    <?php else: ?>
                        
                        <a class="nav-link text-white" href="<?php echo e(url('/')); ?>">Home</a>
                    <?php endif; ?>
                </li>

                
                <li class="nav-item">
                    <a class="nav-link <?php echo e(request()->routeIs('peta.publik') ? 'active fw-semibold' : 'text-white'); ?>"
                        href="<?php echo e(route('peta.publik')); ?>">
                        Peta Bencana
                    </a>
                </li>

                
                <li class="nav-item">
                    <a class="nav-link <?php echo e(request()->routeIs('grafik.publik') ? 'active fw-semibold' : 'text-white'); ?>"
                        href="<?php echo e(route('grafik.publik')); ?>">
                        Grafik
                    </a>
                </li>

                
                <?php $sopActive = request()->routeIs('sop.publik.*'); ?>
                <li class="nav-item">
                    <?php if(Route::has('sop.publik.index')): ?>
                        <a class="nav-link <?php echo e($sopActive ? 'active fw-semibold' : 'text-white'); ?>"
                            href="<?php echo e(route('sop.publik.index')); ?>">
                            SOP Kebencanaan
                        </a>
                    <?php else: ?>
                        
                        <a class="nav-link text-white" href="<?php echo e(url('/sop-kebencanaan')); ?>">
                            SOP Kebencanaan
                        </a>
                    <?php endif; ?>
                </li>

                
                <li class="nav-item">
                    <a class="nav-link text-white" href="#">Dokumentasi</a>
                </li>
                
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
                        
                    </ul>
                </li>

                
                <li class="nav-item ms-lg-3">
                    <?php if (isset($component)) { $__componentOriginalf19ed3397ad4322442ed2e9a328489a4 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf19ed3397ad4322442ed2e9a328489a4 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.search-bar','data' => ['id' => 'searchGlobal','placeholder' => 'Cari apapun...']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.search-bar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'searchGlobal','placeholder' => 'Cari apapun...']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf19ed3397ad4322442ed2e9a328489a4)): ?>
<?php $attributes = $__attributesOriginalf19ed3397ad4322442ed2e9a328489a4; ?>
<?php unset($__attributesOriginalf19ed3397ad4322442ed2e9a328489a4); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf19ed3397ad4322442ed2e9a328489a4)): ?>
<?php $component = $__componentOriginalf19ed3397ad4322442ed2e9a328489a4; ?>
<?php unset($__componentOriginalf19ed3397ad4322442ed2e9a328489a4); ?>
<?php endif; ?>
                </li>

                
                <li class="nav-item ms-lg-3">
                    <?php if (isset($component)) { $__componentOriginal238d5211cc9d80261ec96f21f6b79bb3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal238d5211cc9d80261ec96f21f6b79bb3 = $attributes; } ?>
<?php $component = App\View\Components\Ui\Button::resolve(['variant' => 'footer'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Ui\Button::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'fw-bold','data-bs-toggle' => 'modal','data-bs-target' => '#loginModal']); ?>
                        Login
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal238d5211cc9d80261ec96f21f6b79bb3)): ?>
<?php $attributes = $__attributesOriginal238d5211cc9d80261ec96f21f6b79bb3; ?>
<?php unset($__attributesOriginal238d5211cc9d80261ec96f21f6b79bb3); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal238d5211cc9d80261ec96f21f6b79bb3)): ?>
<?php $component = $__componentOriginal238d5211cc9d80261ec96f21f6b79bb3; ?>
<?php unset($__componentOriginal238d5211cc9d80261ec96f21f6b79bb3); ?>
<?php endif; ?>
                </li>
            </ul>
        </div>
    </div>
</nav>
<?php /**PATH C:\laragon\www\BPBD\resources\views/layouts/partials/navigation_publik.blade.php ENDPATH**/ ?>