

<?php $__env->startSection('title', 'Rekap SK (Tahun)'); ?>
<?php $__env->startSection('page_title', 'Rekap SK (Tahun)'); ?>
<?php $__env->startSection('page_icon'); ?> <i class="bi bi-clipboard2-check"></i> <?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="card p-3">
        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tahun</th>
                        <th>Jumlah</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $years; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i=>$y): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><?php echo e($i + 1); ?></td>
                            <td><?php echo e($y->year); ?></td>
                            <td><?php echo e($y->rows); ?></td>
                            <td><a class="btn btn-sm btn-primary" href="<?php echo e(route('kl.sk.rekap.year', $y->year)); ?>">Lihat</a>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">Belum ada data.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app_admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\BPBD\resources\views/role/kl/sk/rekap-years.blade.php ENDPATH**/ ?>