<?php
    $ns = strtolower($ctx); // pk | kl | rr
    $isEdit = isset($report) && optional($report)->exists;
    $action = $isEdit ? route($ns . '.lap-kegiatan.update', $report) : route($ns . '.lap-kegiatan.store');
?>


<?php $__env->startSection('title', ($isEdit ? 'Edit' : 'Buat') . " Laporan $ctx"); ?>
<?php $__env->startSection('page_title', ($isEdit ? 'Edit' : 'Buat') . " Laporan $ctx"); ?>
<?php $__env->startSection('page_icon'); ?> <i class="bi bi-clipboard2-check-fill"></i> <?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    
    <?php if($errors->any()): ?>
        <div class="alert alert-danger">
            <div class="fw-semibold mb-1">Periksa kembali isian Anda:</div>
            <ul class="mb-0">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($e); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST" action="<?php echo e($action); ?>" enctype="multipart/form-data" class="row g-3">
                <?php echo csrf_field(); ?>
                <?php if($isEdit): ?>
                    <?php echo method_field('PUT'); ?>
                <?php endif; ?>

                
                <div class="col-12">
                    <label class="form-label fw-semibold">LAPORAN KEGIATAN <span class="text-danger">*</span></label>
                    <input type="text" name="judul_laporan" class="form-control" required
                        value="<?php echo e(old('judul_laporan', $report->judul_laporan ?? '')); ?>">
                    <?php $__errorArgs = ['judul_laporan'];
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
                    <label class="form-label fw-semibold">KEPADA</label>
                    <input type="text" name="kepada_yth" class="form-control"
                        value="<?php echo e(old('kepada_yth', $report->kepada_yth ?? '')); ?>">
                    <?php $__errorArgs = ['kepada_yth'];
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
                    <label class="form-label fw-semibold">JENIS KEGIATAN</label>
                    <input type="text" name="jenis_kegiatan" class="form-control"
                        value="<?php echo e(old('jenis_kegiatan', $report->jenis_kegiatan ?? '')); ?>">
                    <?php $__errorArgs = ['jenis_kegiatan'];
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

                
                <div class="col-12">
                    <label class="form-label fw-semibold d-block mb-1">WAKTU KEGIATAN</label>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Hari</label>
                            <input type="text" name="hari" class="form-control" placeholder="Senin"
                                value="<?php echo e(old('hari', $report->hari ?? '')); ?>">
                            <?php $__errorArgs = ['hari'];
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
                            <label class="form-label">Tanggal</label>
                            <input type="date" name="tanggal" class="form-control"
                                value="<?php echo e(old('tanggal', isset($report->tanggal) ? $report->tanggal->format('Y-m-d') : '')); ?>">
                            <?php $__errorArgs = ['tanggal'];
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
                            <label class="form-label">Pukul</label>
                            <input type="text" name="pukul" class="form-control" placeholder="08:30–10:00"
                                value="<?php echo e(old('pukul', $report->pukul ?? '')); ?>">
                            <?php $__errorArgs = ['pukul'];
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
                    </div>
                </div>

                
                <div class="col-12">
                    <label class="form-label fw-semibold">LOKASI KEGIATAN</label>
                    <input type="text" name="lokasi_kegiatan" class="form-control"
                        value="<?php echo e(old('lokasi_kegiatan', $report->lokasi_kegiatan ?? '')); ?>">
                    <?php $__errorArgs = ['lokasi_kegiatan'];
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

                
                <div class="col-12">
                    <label class="form-label fw-semibold">HASIL KEGIATAN</label>
                    <textarea name="hasil_kegiatan" rows="4" class="form-control"><?php echo e(old('hasil_kegiatan', $report->hasil_kegiatan ?? '')); ?></textarea>
                    <?php $__errorArgs = ['hasil_kegiatan'];
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

                
                <div class="col-12">
                    <label class="form-label fw-semibold">UNSUR YANG TERLIBAT</label>
                    <textarea name="unsur_yang_terlibat" rows="3" class="form-control"
                        placeholder="Contoh: BPBD, TNI, Polri, Relawan, Perangkat Desa, dsb."><?php echo e(old('unsur_yang_terlibat', $report->unsur_yang_terlibat ?? '')); ?></textarea>
                    <?php $__errorArgs = ['unsur_yang_terlibat'];
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

                
                <div class="col-12">
                    <label class="form-label fw-semibold">PETUGAS</label>
                    <input type="text" name="petugas" class="form-control" placeholder="Nama dipisah koma"
                        value="<?php echo e(old('petugas', $report->petugas ?? '')); ?>">
                    <?php $__errorArgs = ['petugas'];
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

                
                <div class="col-12">
                    <label class="form-label fw-semibold">DOKUMENTASI (boleh multiple)</label>
                    <input type="file" name="dokumentasi[]" accept="image/*" class="form-control" multiple>
                    <?php $__errorArgs = ['dokumentasi.*'];
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

                
                <?php if($isEdit && !empty($report->dokumentasi)): ?>
                    <div class="col-12">
                        <label class="form-label d-block mb-2">Dokumentasi saat ini</label>
                        <div class="d-flex flex-wrap gap-3">
                            <?php $__currentLoopData = $report->dokumentasi; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="border rounded p-2 text-center">
                                    <img src="<?php echo e(asset('storage/' . $p)); ?>" style="height:80px" class="d-block mb-2"
                                        alt="foto">
                                    <label class="form-check">
                                        <input type="checkbox" class="form-check-input" name="hapus_foto[]"
                                            value="<?php echo e($p); ?>">
                                        <span class="form-check-label">Hapus</span>
                                    </label>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                <?php endif; ?>

                
                <div class="col-12 d-flex gap-2">
                    <a href="<?php echo e(route($ns . '.lap-kegiatan.index')); ?>" class="btn btn-secondary">Batal</a>
                    <button class="btn btn-primary">
                        <i class="bi bi-save me-1"></i> <?php echo e($isEdit ? 'Simpan Perubahan' : 'Simpan'); ?>

                    </button>
                </div>
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app_admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\BPBD\resources\views/role/shared/lap-kegiatan/form.blade.php ENDPATH**/ ?>