
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
    <?php if (isset($component)) { $__componentOriginalde3cf3d53aa9e79855e2b44f314bcd20 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalde3cf3d53aa9e79855e2b44f314bcd20 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.rekap.filter-overlay-monthyear','data' => ['activeRole' => $activeRole,'submitRoute' => route('admin.rekap-kegiatan.rekap.role.index', $activeRole)]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('rekap.filter-overlay-monthyear'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['active-role' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($activeRole),'submit-route' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('admin.rekap-kegiatan.rekap.role.index', $activeRole))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalde3cf3d53aa9e79855e2b44f314bcd20)): ?>
<?php $attributes = $__attributesOriginalde3cf3d53aa9e79855e2b44f314bcd20; ?>
<?php unset($__attributesOriginalde3cf3d53aa9e79855e2b44f314bcd20); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalde3cf3d53aa9e79855e2b44f314bcd20)): ?>
<?php $component = $__componentOriginalde3cf3d53aa9e79855e2b44f314bcd20; ?>
<?php unset($__componentOriginalde3cf3d53aa9e79855e2b44f314bcd20); ?>
<?php endif; ?>
    <ul class="nav bpbd-tabs mb-3">
        <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li class="nav-item">
                <a class="nav-link <?php echo e($r === $activeRole ? 'active' : ''); ?>"
                    href="<?php echo e(route('admin.rekap-kegiatan.rekap.role.index', $r)); ?>">
                    Laporan <?php echo e($r); ?>

                </a>
            </li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>

    
    <div class="table-card overflow-x-auto mt-4">
        <table class="bpbd-table min-w-full">
            <thead>
                <tr>
                    <th style="width:5%">No</th>
                    <th>Bulan</th>
                    <th>Tahun</th>
                    <th>Total Laporan</th>
                    <th class="col-aksi">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($rows->firstItem() + $i); ?></td>
                        <td><?php echo e(\Carbon\Carbon::create()->month($row->month)->translatedFormat('F')); ?></td>
                        <td><?php echo e($row->year); ?></td>
                        <td class="font-semibold"><?php echo e($row->total); ?></td>
                        <td class="col-aksi">
                            <a href="<?php echo e(route('admin.rekap-kegiatan.rekap.month.role.pdf', [sprintf('%04d-%02d', $row->year, $row->month), $activeRole])); ?>"
                                class="btn-edit" target="_blank">
                                Cetak
                            </a>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="5" class="text-center text-slate-500 py-6">Belum ada data</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        <?php echo e($rows->withQueryString()->links()); ?>

    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app_admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\BPBD\resources\views/role/admin/rekap-kegiatan/rekap-role-index.blade.php ENDPATH**/ ?>