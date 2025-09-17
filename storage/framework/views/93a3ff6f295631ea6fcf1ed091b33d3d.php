


<?php $__env->startSection('title', $sop->exists ? 'Edit SOP' : 'Tambah SOP'); ?>
<?php $__env->startSection('page_title', $sop->exists ? 'Edit SOP' : 'Tambah SOP'); ?>
<?php $__env->startSection('page_icon'); ?> <i class="bi bi-journal-text">
</i> <?php $__env->stopSection(); ?>

<?php
    $ns = 'admin';
    if (Route::is('pk.*')) {
        $ns = 'pk';
    } elseif (Route::is('kl.*')) {
        $ns = 'kl';
    } elseif (Route::is('rr.*')) {
        $ns = 'rr';
    }
?>

<?php $__env->startSection('content'); ?>
    <?php if($errors->any()): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($e); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="card">
        <div class="card-body">
            <form action="<?php echo e($sop->exists ? route($ns . '.sop.update', $sop) : route($ns . '.sop.store')); ?>" method="post"
                enctype="multipart/form-data" class="row g-3">
                <?php echo csrf_field(); ?>
                <?php if($sop->exists): ?>
                    <?php echo method_field('put'); ?>
                <?php endif; ?>

                <?php if (\Illuminate\Support\Facades\Blade::check('role', 'Super Admin')): ?>
                    <div class="col-12">
                        <div class="alert alert-info mb-0">
                            <strong>Catatan:</strong> Owner role SOP ini: <span
                                class="badge text-bg-info"><?php echo e(strtoupper($sop->owner_role ?: auth()->user()->getRoleNames()->first() ?? 'PK')); ?></span>
                            (ditetapkan otomatis saat simpan).
                        </div>
                    </div>
                <?php endif; ?>

                <div class="col-md-4">
                    <label class="form-label">Nomor SOP <span class="text-danger">*</span></label>
                    <input type="text" name="nomor" class="form-control" value="<?php echo e(old('nomor', $sop->nomor)); ?>"
                        required>
                    <?php $__errorArgs = ['nomor'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="text-danger small"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="col-md-8">
                    <label class="form-label">Judul SOP <span class="text-danger">*</span></label>
                    <input type="text" name="judul" class="form-control" value="<?php echo e(old('judul', $sop->judul)); ?>"
                        required>
                    <?php $__errorArgs = ['judul'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="text-danger small"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="col-md-6">
                    <label class="form-label">File PDF <?php echo e($sop->exists ? '(opsional jika tidak ganti)' : '*'); ?></label>
                    <input type="file" name="file" class="form-control" accept="application/pdf"
                        <?php echo e($sop->exists ? '' : 'required'); ?>>
                    <?php $__errorArgs = ['file'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="text-danger small"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                    <?php if($sop->exists && $sop->file_path): ?>
                        <small class="text-muted d-block mt-2">File saat ini:
                            <a href="<?php echo e($sop->fileUrl()); ?>" target="_blank" rel="noopener">Lihat</a>
                        </small>
                    <?php endif; ?>
                </div>

                <div class="col-md-3 d-flex align-items-end">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" id="pubCheck" name="is_published"
                            <?php echo e(old('is_published', $sop->is_published) ? 'checked' : ''); ?>>
                        <label class="form-check-label" for="pubCheck">Tampilkan ke Publik (Publish)</label>
                    </div>
                </div>

                <div class="col-12 d-flex gap-2">
                    <button class="btn btn-primary"><i class="bi bi-save"></i> Simpan</button>
                    <a href="<?php echo e(route($ns . '.sop.index')); ?>" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app_admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\BPBD\resources\views/role/shared/sop/form.blade.php ENDPATH**/ ?>