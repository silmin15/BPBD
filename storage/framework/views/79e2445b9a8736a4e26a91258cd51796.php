

<?php $__env->startSection('title', ($sk->exists ? 'Edit' : 'Tambah') . ' SK'); ?>
<?php $__env->startSection('page_title', ($sk->exists ? 'Edit' : 'Tambah') . ' SK'); ?>
<?php $__env->startSection('page_icon'); ?> <i class="bi bi-journal-text"></i> <?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-fluid px-0">
        <form method="POST"
            action="<?php echo e($sk->exists ? route($routeBase . '.sk.update', $sk) : route($routeBase . '.sk.store')); ?>"
            enctype="multipart/form-data" class="bpbd-form">
            <?php echo csrf_field(); ?>
            <?php if($sk->exists): ?>
                <?php echo method_field('PUT'); ?>
            <?php endif; ?>

            <div class="mb-3">
                <label class="form-label">Nomor SK</label>
                <input type="text" name="no_sk" class="form-control" value="<?php echo e(old('no_sk', $sk->no_sk)); ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Judul SK</label>
                <input type="text" name="judul_sk" class="form-control" value="<?php echo e(old('judul_sk', $sk->judul_sk)); ?>"
                    required>
            </div>

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Tanggal SK</label>
                    <input type="date" name="tanggal_sk" class="form-control"
                        value="<?php echo e(old('tanggal_sk', optional($sk->tanggal_sk)->format('Y-m-d'))); ?>" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Berlaku dari</label>
                    <input type="date" name="start_at" class="form-control"
                        value="<?php echo e(old('start_at', optional($sk->start_at)->format('Y-m-d'))); ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label">s.d.</label>
                    <input type="date" name="end_at" class="form-control"
                        value="<?php echo e(old('end_at', optional($sk->end_at)->format('Y-m-d'))); ?>">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Bulan (opsional)</label>
                <input type="text" name="bulan_text" class="form-control"
                    value="<?php echo e(old('bulan_text', $sk->bulan_text)); ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">File PDF</label>
                <input type="file" name="pdf" class="form-control" <?php echo e($sk->exists ? '' : 'required'); ?>>
                <?php if($sk->pdf_path): ?>
                    <small class="d-block mt-1 text-muted">
                        Sudah ada file. <a href="<?php echo e(route($routeBase . '.sk.download', $sk)); ?>" target="_blank">Unduh</a>
                    </small>
                <?php endif; ?>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn-orange">
                    <i class="bi bi-save"></i> Simpan
                </button>
                <a href="<?php echo e(route($routeBase . '.sk.index')); ?>" class="btn-gray">Batal</a>
            </div>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app_admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\BPBD\resources\views/role/shared/sk/form.blade.php ENDPATH**/ ?>