

<?php $isEdit = $sk->exists; ?>
<?php $__env->startSection('title', $isEdit ? 'Edit SK' : 'Tambah SK'); ?>
<?php $__env->startSection('page_title', $isEdit ? 'Edit SK' : 'Tambah SK'); ?>
<?php $__env->startSection('page_icon'); ?> <i class="bi bi-file-earmark-text"></i> <?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="card p-3">
        <form action="<?php echo e($isEdit ? route('kl.sk.update', $sk) : route('kl.sk.store')); ?>" method="POST"
            enctype="multipart/form-data">
            <?php echo csrf_field(); ?> <?php if($isEdit): ?>
                <?php echo method_field('PUT'); ?>
            <?php endif; ?>

            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">NO SK</label>
                    <input type="text" name="no_sk" class="form-control" required value="<?php echo e(old('no_sk', $sk->no_sk)); ?>">
                </div>
                <div class="col-md-8">
                    <label class="form-label">Judul SK</label>
                    <input type="text" name="judul_sk" class="form-control" required
                        value="<?php echo e(old('judul_sk', $sk->judul_sk)); ?>">
                </div>

                <div class="col-md-3">
                    <label class="form-label">Mulai Berlaku</label>
                    <input type="date" name="start_at" class="form-control"
                        value="<?php echo e(old('start_at', optional($sk->start_at)->format('Y-m-d'))); ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Akhir Berlaku</label>
                    <input type="date" name="end_at" class="form-control"
                        value="<?php echo e(old('end_at', optional($sk->end_at)->format('Y-m-d'))); ?>">
                </div>

                <div class="col-md-3">
                    <label class="form-label">Tanggal SK</label>
                    <input type="date" name="tanggal_sk" id="tanggal_sk" class="form-control" required
                        value="<?php echo e(old('tanggal_sk', optional($sk->tanggal_sk)->format('Y-m-d'))); ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Bulan (teks)</label>
                    <input type="text" name="bulan_text" id="bulan_text" class="form-control" placeholder="Agustus"
                        value="<?php echo e(old('bulan_text', $sk->bulan_text)); ?>">
                    <div class="form-text">Otomatis dari Tanggal SK (boleh diubah).</div>
                </div>

                <div class="col-md-12">
                    <label class="form-label">Unggah PDF</label>
                    <input type="file" name="pdf" class="form-control" accept="application/pdf"
                        <?php echo e($isEdit ? '' : 'required'); ?>>
                    <?php if($isEdit && $sk->pdf_path): ?>
                        <small class="text-muted">File saat ini: <a
                                href="<?php echo e(route('kl.sk.download', $sk)); ?>">unduh</a></small>
                    <?php endif; ?>
                </div>
            </div>

            <div class="mt-3 d-flex justify-content-end">
                <a href="<?php echo e(route('kl.sk.index')); ?>" class="btn btn-light me-2">Batal</a>
                <button class="btn btn-primary"><?php echo e($isEdit ? 'Simpan Perubahan' : 'Simpan'); ?></button>
            </div>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app_admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\BPBD\resources\views/role/kl/sk/form.blade.php ENDPATH**/ ?>