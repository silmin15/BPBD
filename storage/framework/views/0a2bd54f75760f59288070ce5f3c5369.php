

<?php $__env->startSection('title', 'Detail BAST'); ?>
<?php $__env->startSection('page_title', 'Detail BAST'); ?>
<?php $__env->startSection('page_icon'); ?> <i class="bi bi-file-earmark-text"></i> <?php $__env->stopSection(); ?>

<?php $__env->startSection('page_actions'); ?>
    <a href="<?php echo e(route('pk.bast.index')); ?>" class="btn-orange">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>

    <?php if($bast->status !== 'approved'): ?>
        <a href="<?php echo e(route('pk.bast.print', $bast)); ?>" target="_blank" class="btn-gray">
            <i class="bi bi-printer"></i> Cetak & ACC
        </a>
    <?php else: ?>
        <a href="<?php echo e(route('pk.bast.print', $bast)); ?>" target="_blank" class="btn-gray">
            <i class="bi bi-printer"></i> Cetak Ulang
        </a>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="mb-2"><strong>ID</strong>
                        <div>#<?php echo e($bast->id); ?></div>
                    </div>
                    <div class="mb-2"><strong>Tanggal Pengajuan</strong>
                        <div><?php echo e($bast->created_at?->format('d/m/Y H:i')); ?></div>
                    </div>
                    <div class="mb-2"><strong>Status</strong>
                        <div>
                            <?php if($bast->status === 'approved'): ?>
                                <span class="badge bg-success">Approved</span>
                                <small class="text-muted ms-2"><?php echo e($bast->approved_at?->format('d/m/Y H:i')); ?></small>
                            <?php else: ?>
                                <span class="badge bg-secondary">Pending</span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="mb-2"><strong>Dicetak</strong>
                        <div><?php echo e($bast->printed_at?->format('d/m/Y H:i') ?? '—'); ?></div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-2"><strong>Nama Perwakilan</strong>
                        <div><?php echo e($bast->nama_perwakilan); ?></div>
                    </div>
                    <div class="mb-2"><strong>Kecamatan</strong>
                        <div><?php echo e($bast->kecamatan); ?></div>
                    </div>
                    <div class="mb-2"><strong>Desa/Kelurahan</strong>
                        <div><?php echo e($bast->desa); ?></div>
                    </div>
                    <div class="mb-2"><strong>Alamat</strong>
                        <div><?php echo e($bast->alamat ?: '—'); ?></div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="mb-2"><strong>Catatan</strong>
                        <div><?php echo e($bast->catatan ?: '—'); ?></div>
                    </div>
                </div>

                <div class="col-12">
                    <strong>Surat Permohonan</strong>
                    <div class="mt-1">
                        <?php if($bast->surat_path): ?>
                            <a class="btn btn-sm btn-outline-secondary" href="<?php echo e(route('pk.bast.surat', $bast)); ?>"
                                target="_blank">
                                <i class="bi bi-download"></i> Unduh Surat
                            </a>
                        <?php else: ?>
                            <span class="text-muted">Tidak ada file.</span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="mt-4 d-flex gap-2">
                <a href="<?php echo e(route('pk.bast.index')); ?>" class="btn btn-light">Kembali</a>

                <?php if($bast->status !== 'approved'): ?>
                    <a href="<?php echo e(route('pk.bast.print', $bast)); ?>" target="_blank" class="btn-gray">
                        <i class="bi bi-printer"></i> Cetak & ACC
                    </a>
                <?php else: ?>
                    <a href="<?php echo e(route('pk.bast.print', $bast)); ?>" target="_blank" class="btn-gray">
                        <i class="bi bi-printer"></i> Cetak Ulang
                    </a>
                <?php endif; ?>

                <form action="<?php echo e(route('pk.bast.destroy', $bast)); ?>" method="POST" class="d-inline"
                    onsubmit="return confirm('Hapus BAST ini?')">
                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="btn-delete">Hapus</button>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app_admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\BPBD\resources\views/role/pk/bast/show.blade.php ENDPATH**/ ?>