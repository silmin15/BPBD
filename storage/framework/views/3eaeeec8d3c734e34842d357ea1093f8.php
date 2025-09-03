<?php $__env->startSection('content'); ?>
    
    <?php if (isset($component)) { $__componentOriginalf19ed3397ad4322442ed2e9a328489a4 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf19ed3397ad4322442ed2e9a328489a4 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.search-bar','data' => ['id' => 'searchPublik','class' => 'mb-3','showFilter' => true,'filterTarget' => '#offcanvasFilter']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.search-bar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'searchPublik','class' => 'mb-3','show-filter' => true,'filter-target' => '#offcanvasFilter']); ?>
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

    
    <div class="map-container py-4 px-4">
        <div id="map" class="rounded-lg shadow-soft"></div>
    </div>

    
    <div class="offcanvas offcanvas-start bg-orange text-white" tabindex="-1" id="offcanvasFilter"
        aria-labelledby="offcanvasFilterLabel">
        <div class="offcanvas-header">
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"
                aria-label="Close"></button>
        </div>

        <div class="offcanvas-body">
            <div class="filter-section mb-4">
                <h6>KECAMATAN</h6>
                <div class="row">
                    <div class="col-6">
                        <ul class="list-unstyled">
                            <li><a href="#" class="text-white text-decoration-none">• BANJARMANGU</a></li>
                            <li><a href="#" class="text-white text-decoration-none">• BANJARNEGARA</a></li>
                            <li><a href="#" class="text-white text-decoration-none">• BATUR</a></li>
                        </ul>
                    </div>
                    <div class="col-6">
                        <ul class="list-unstyled">
                            <li><a href="#" class="text-white text-decoration-none">• PANDANARUM</a></li>
                            <li><a href="#" class="text-white text-decoration-none">• PAJAWARAN</a></li>
                            <li><a href="#" class="text-white text-decoration-none">• PUNGGELAN</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <hr>

            <div class="filter-section mb-4">
                <h6>JENIS BENCANA</h6>
                <ul class="list-unstyled">
                    <li><a href="#" class="text-white text-decoration-none">• KEBAKARAN</a></li>
                    <li><a href="#" class="text-white text-decoration-none">• BANJIR</a></li>
                    <li><a href="#" class="text-white text-decoration-none">• LONGSOR</a></li>
                </ul>
            </div>

            <hr>

            <div class="filter-section mb-4">
                <h6>WAKTU</h6>
                <p>
                    <span class="badge bg-light text-dark">Apr 1, 2025</span>
                    <span class="badge bg-light text-dark">9:41 AM</span>
                </p>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app_publik', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\BPBD\resources\views/pages/publik/peta.blade.php ENDPATH**/ ?>