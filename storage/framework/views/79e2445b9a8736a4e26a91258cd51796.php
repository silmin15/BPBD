

<?php $__env->startSection('title', ($sk->exists ? 'Edit' : 'Tambah') . ' SK'); ?>
<?php $__env->startSection('page_title', ($sk->exists ? 'Edit' : 'Tambah') . ' SK'); ?>
<?php $__env->startSection('page_icon'); ?> <i class="bi bi-journal-text"></i> <?php $__env->stopSection(); ?>

<?php
    // Gunakan $routeBase yang sudah kamu pakai; fallback auto-detect bila perlu
    $ns = $routeBase ?? (Route::is('pk.*') ? 'pk' : (Route::is('kl.*') ? 'kl' : (Route::is('rr.*') ? 'rr' : 'admin')));
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

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST" action="<?php echo e($sk->exists ? route($ns . '.sk.update', $sk) : route($ns . '.sk.store')); ?>"
                enctype="multipart/form-data" class="row g-3">
                <?php echo csrf_field(); ?>
                <?php if($sk->exists): ?>
                    <?php echo method_field('PUT'); ?>
                <?php endif; ?>

                
                <div class="col-md-4">
                    <label class="form-label">Nomor SK <span class="text-danger">*</span></label>
                    <input type="text" name="no_sk" class="form-control" value="<?php echo e(old('no_sk', $sk->no_sk)); ?>"
                        required>
                    <?php $__errorArgs = ['no_sk'];
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
                    <label class="form-label">Judul SK <span class="text-danger">*</span></label>
                    <input type="text" name="judul_sk" class="form-control" value="<?php echo e(old('judul_sk', $sk->judul_sk)); ?>"
                        required>
                    <?php $__errorArgs = ['judul_sk'];
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

                
                <div class="col-md-4">
                    <label class="form-label">Tanggal SK <span class="text-danger">*</span></label>
                    <input type="date" name="tanggal_sk" class="form-control"
                        value="<?php echo e(old('tanggal_sk', optional($sk->tanggal_sk)->format('Y-m-d'))); ?>" required>
                    <?php $__errorArgs = ['tanggal_sk'];
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
                <div class="col-md-4">
                    <label class="form-label">Berlaku dari</label>
                    <input type="date" name="start_at" class="form-control"
                        value="<?php echo e(old('start_at', optional($sk->start_at)->format('Y-m-d'))); ?>">
                    <?php $__errorArgs = ['start_at'];
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
                <div class="col-md-4">
                    <label class="form-label">s.d.</label>
                    <input type="date" name="end_at" class="form-control"
                        value="<?php echo e(old('end_at', optional($sk->end_at)->format('Y-m-d'))); ?>">
                    <?php $__errorArgs = ['end_at'];
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
                    <label class="form-label">Bulan (opsional)</label>
                    <input type="text" name="bulan_text" class="form-control"
                        value="<?php echo e(old('bulan_text', $sk->bulan_text)); ?>">
                    <?php $__errorArgs = ['bulan_text'];
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
                    <label class="form-label">
                        File PDF <?php echo e($sk->exists ? '(opsional jika tidak ganti)' : '*'); ?>

                    </label>
                    <input type="file" name="pdf" class="form-control" accept="application/pdf"
                        <?php echo e($sk->exists ? '' : 'required'); ?>>
                    <?php $__errorArgs = ['pdf'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="text-danger small"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                    <?php if($sk->pdf_path): ?>
                        <small class="text-muted d-block mt-2">
                            File saat ini:
                            <a href="<?php echo e(route($ns . '.sk.download', $sk)); ?>" target="_blank" rel="noopener">Unduh</a>
                        </small>
                    <?php endif; ?>
                </div>

                
                <div class="col-12 d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i> Simpan
                    </button>
                    <a href="<?php echo e(route($ns . '.sk.index')); ?>" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app_admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\BPBD\resources\views/role/shared/sk/form.blade.php ENDPATH**/ ?>