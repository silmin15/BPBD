

<?php $__env->startSection('title', 'SOP Kebencanaan'); ?>

<?php $__env->startSection('content'); ?>
    <div class="container py-4">

        <div class="d-flex align-items-center justify-content-between mb-3">
            <div>
                <h1 class="h3 mb-0">SOP Kebencanaan</h1>
                <small class="text-muted">Dokumen resmi yang telah dipublikasikan (format PDF).</small>
            </div>
            
            <?php if(Route::has('peta.publik')): ?>
                <a href="<?php echo e(route('peta.publik')); ?>" class="btn btn-outline-secondary d-none d-md-inline">
                    <i class="bi bi-map"></i> Peta
                </a>
            <?php endif; ?>
        </div>

        <?php if(session('ok')): ?>
            <div class="alert alert-success"><?php echo e(session('ok')); ?></div>
        <?php endif; ?>

        <form method="get" class="row g-2 mb-3">
            <div class="col-md-9">
                <input type="text" name="q" class="form-control" placeholder="Cari nomor / judul SOP…"
                    value="<?php echo e($q ?? ''); ?>" />
            </div>
            <div class="col-md-3">
                <button class="btn btn-outline-primary w-100">Cari</button>
            </div>
        </form>

        <div class="table-responsive bg-white shadow-sm rounded">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width:90px">#</th>
                        <th>Nomor</th>
                        <th>Judul</th>
                        <th style="width:200px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $sops; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $sop): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><?php echo e($sops->firstItem() + $i); ?></td>
                            <td><?php echo e($sop->nomor); ?></td>
                            <td><?php echo e($sop->judul); ?></td>
                            <td>
                                <a class="btn btn-sm btn-success" href="<?php echo e(route('sop.publik.download', $sop)); ?>">
                                    <i class="bi bi-download"></i> Download
                                </a>
                                <a class="btn btn-sm btn-outline-secondary" target="_blank" rel="noopener"
                                    href="<?php echo e($sop->fileUrl()); ?>">
                                    <i class="bi bi-box-arrow-up-right"></i> Buka
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="4" class="text-center text-muted">Belum ada SOP terpublikasi.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            <?php echo e($sops->links()); ?>

        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app_publik', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\BPBD\resources\views/pages/publik/sop.blade.php ENDPATH**/ ?>