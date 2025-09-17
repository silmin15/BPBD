

<?php $__env->startSection('title', 'BAST (Publik)'); ?>
<?php $__env->startSection('page_title', 'BAST (Publik)'); ?>
<?php $__env->startSection('page_icon'); ?> <i class="bi bi-journal-text"></i> <?php $__env->stopSection(); ?>

<?php
    $total = $basts->total() ?? 0;
?>



<?php $__env->startSection('content'); ?>
    <?php if(session('ok')): ?>
        <div class="alert alert-success"><?php echo e(session('ok')); ?></div>
    <?php endif; ?>
    <?php if(session('err')): ?>
        <div class="alert alert-danger"><?php echo e(session('err')); ?></div>
    <?php endif; ?>

    <div class="card shadow-sm">
        
        <div class="card-body pb-2">
            <form method="get" action="<?php echo e(route('pk.bast.index')); ?>" class="row g-2 align-items-center">
                <div class="col-lg-7">
                    <div class="input-group">
                        <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                        <input type="text" name="q" value="<?php echo e(request('q')); ?>" class="form-control"
                            placeholder="Cari nama perwakilan / kecamatan / desa…">
                    </div>
                </div>

                <div class="col-lg-3">
                    <select name="status" class="form-select">
                        <option value="">— Semua Status —</option>
                        <option value="pending" <?php if(request('status') === 'pending'): echo 'selected'; endif; ?>>Pending</option>
                        <option value="approved" <?php if(request('status') === 'approved'): echo 'selected'; endif; ?>>Approved</option>
                    </select>
                </div>

                <div class="col-lg-2 d-grid d-md-block">
                    <button class="btn btn-primary"><i class="bi bi-funnel me-1"></i> Filter</button>
                    <?php if(request('q') || request('status')): ?>
                        <a href="<?php echo e(route('pk.bast.index')); ?>" class="btn btn-outline-secondary ms-md-2 mt-2 mt-md-0">
                            Reset
                        </a>
                    <?php endif; ?>
                </div>
            </form>
        </div>

        
        <div class="table-responsive">
            <table class="table table-hover table-striped align-middle mb-0">
                <thead class="table-light sticky-top">
                    <tr>
                        <th style="width:72px" class="text-center">#</th>
                        <th style="width:170px">Pengajuan</th>
                        <th>Perwakilan</th>
                        <th style="width:180px">Kecamatan</th>
                        <th style="width:220px">Desa</th>
                        <th style="width:120px" class="text-center">Surat</th>
                        <th style="width:130px" class="text-center">Status</th>
                        <th style="width:170px" class="text-center">Dicetak</th>
                        <th style="width:170px" class="text-center">Disetujui</th>
                        <th style="width:290px" class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $basts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $bast): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td class="text-center"><?php echo e($basts->firstItem() + $i); ?></td>

                            <td class="text-muted">
                                <div class="fw-semibold">#<?php echo e($bast->id); ?></div>
                                <small class="text-muted d-block">
                                    <?php echo e(optional($bast->created_at)->format('d/m/Y H:i')); ?>

                                </small>
                            </td>

                            <td class="fw-semibold"><?php echo e($bast->nama_perwakilan); ?></td>
                            <td><?php echo e($bast->kecamatan); ?></td>
                            <td><?php echo e($bast->desa); ?></td>

                            <td class="text-center">
                                <?php if($bast->surat_path): ?>
                                    <a href="<?php echo e(route('pk.bast.surat', $bast)); ?>" class="btn btn-sm btn-outline-secondary"
                                        target="_blank">
                                        <i class="bi bi-download"></i> <span class="d-none d-md-inline">Unduh</span>
                                    </a>
                                <?php else: ?>
                                    <span class="text-muted">—</span>
                                <?php endif; ?>
                            </td>

                            <td class="text-center">
                                <?php if($bast->status === 'approved'): ?>
                                    <span class="badge text-bg-success">Approved</span>
                                <?php else: ?>
                                    <span class="badge text-bg-secondary">Pending</span>
                                <?php endif; ?>
                            </td>

                            <td class="text-center">
                                <?php if($bast->printed_at): ?>
                                    <span
                                        class="badge bg-light text-dark"><?php echo e($bast->printed_at->format('d/m/Y H:i')); ?></span>
                                <?php else: ?>
                                    <span class="text-muted">—</span>
                                <?php endif; ?>
                            </td>

                            <td class="text-center">
                                <?php if($bast->approved_at): ?>
                                    <span
                                        class="badge bg-light text-dark"><?php echo e($bast->approved_at->format('d/m/Y H:i')); ?></span>
                                <?php else: ?>
                                    <span class="text-muted">—</span>
                                <?php endif; ?>
                            </td>

                            <td class="text-end">
                                <a href="<?php echo e(route('pk.bast.show', $bast)); ?>" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-eye"></i> Detail
                                </a>

                                <a href="<?php echo e(route('pk.bast.print', $bast)); ?>" target="_blank"
                                    class="btn btn-sm btn-outline-secondary">
                                    <i class="bi bi-printer"></i>
                                    <?php echo e($bast->status === 'approved' ? 'Cetak Ulang' : 'Cetak'); ?>

                                </a>

                                <form action="<?php echo e(route('pk.bast.destroy', $bast)); ?>" method="POST" class="d-inline"
                                    onsubmit="return confirm('Hapus BAST ini?')">
                                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="10" class="text-center text-muted py-4">Belum ada pengajuan.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        
        <div class="card-footer bg-white d-flex flex-column flex-md-row justify-content-between align-items-center">
            <small class="text-muted mb-2 mb-md-0">
                Menampilkan <?php echo e($basts->count() ? $basts->firstItem() . '–' . $basts->lastItem() : 0); ?>

                dari <?php echo e($total); ?> data
            </small>
            <?php echo e($basts->withQueryString()->onEachSide(1)->links()); ?>

        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app_admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\BPBD\resources\views/role/pk/bast/index.blade.php ENDPATH**/ ?>