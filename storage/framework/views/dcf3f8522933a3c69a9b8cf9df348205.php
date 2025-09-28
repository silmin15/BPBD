
<?php ($roles = ['PK', 'KL', 'RR']); ?>


<?php $__env->startSection('page_title', "Rekap Laporan {$activeRole}"); ?>
<?php $__env->startSection('page_icon'); ?> <i class="bi bi-file-bar-graph"></i> <?php $__env->stopSection(); ?>

<?php $__env->startSection('page_actions'); ?>
    <div class="d-flex align-items-center gap-2">
        <button type="button" class="btn-orange" id="open-filter">
            <i class="bi bi-funnel-fill me-1"></i> Filter
        </button>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    
    <?php if (isset($component)) { $__componentOriginal9b220ba361d4f56989aebaf64cb6dc60 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9b220ba361d4f56989aebaf64cb6dc60 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.rekap.filter-overlay-monthyear','data' => ['activeRole' => $activeRole,'submitRoute' => route('admin.rekap-kegiatan.rekap.role.index', $activeRole)]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.rekap.filter-overlay-monthyear'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['active-role' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($activeRole),'submit-route' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('admin.rekap-kegiatan.rekap.role.index', $activeRole))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9b220ba361d4f56989aebaf64cb6dc60)): ?>
<?php $attributes = $__attributesOriginal9b220ba361d4f56989aebaf64cb6dc60; ?>
<?php unset($__attributesOriginal9b220ba361d4f56989aebaf64cb6dc60); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9b220ba361d4f56989aebaf64cb6dc60)): ?>
<?php $component = $__componentOriginal9b220ba361d4f56989aebaf64cb6dc60; ?>
<?php unset($__componentOriginal9b220ba361d4f56989aebaf64cb6dc60); ?>
<?php endif; ?>

    
    <ul class="nav nav-tabs mb-3">
        <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li class="nav-item">
                <a class="nav-link <?php echo e($r === $activeRole ? 'active' : ''); ?>"
                    href="<?php echo e(route('admin.rekap-kegiatan.rekap.role.index', $r)); ?>">
                    Laporan <?php echo e($r); ?>

                </a>
            </li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>

    <div class="card shadow-sm">
        
        <div class="card-body pb-2">
            <div class="d-flex align-items-center gap-2">
                <button type="button" class="btn btn-primary" id="open-filter">
                    <i class="bi bi-funnel me-1"></i> Filter
                </button>
                <?php if(request('month') || request('year')): ?>
                    <a href="<?php echo e(route('admin.rekap-kegiatan.rekap.role.index', $activeRole)); ?>"
                        class="btn btn-outline-secondary">Reset</a>
                <?php endif; ?>
            </div>
        </div>

        
        <div class="table-responsive">
            <table class="table table-hover table-striped align-middle mb-0">
                <thead class="table-light sticky-top">
                    <tr>
                        <th style="width:72px" class="text-center">#</th>
                        <th style="width:180px">Bulan</th>
                        <th style="width:120px">Tahun</th>
                        <th style="width:160px" class="text-center">Total Laporan</th>
                        <th style="width:220px" class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td class="text-center"><?php echo e($rows->firstItem() + $i); ?></td>
                            <td><?php echo e(\Carbon\Carbon::create()->month($row->month)->translatedFormat('F')); ?></td>
                            <td><?php echo e($row->year); ?></td>
                            <td class="text-center fw-semibold"><?php echo e($row->total); ?></td>
                            <td class="text-end">
                                <a class="btn btn-sm btn-outline-secondary" target="_blank"
                                    href="<?php echo e(route('admin.rekap-kegiatan.rekap.month.role.pdf', [sprintf('%04d-%02d', $row->year, $row->month), $activeRole])); ?>">
                                    <i class="bi bi-printer"></i> Cetak PDF
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">Belum ada data</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        
        <div class="card-footer bg-white d-flex flex-column flex-md-row justify-content-between align-items-center">
            <small class="text-muted mb-2 mb-md-0">
                Menampilkan <?php echo e($rows->count() ? $rows->firstItem() . '–' . $rows->lastItem() : 0); ?>

                dari <?php echo e(method_exists($rows, 'total') ? $rows->total() : $rows->count()); ?> data
            </small>
            <?php echo e($rows->withQueryString()->onEachSide(1)->links()); ?>

        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app_admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\BPBD\resources\views/role/admin/rekap-kegiatan/rekap-role-index.blade.php ENDPATH**/ ?>