

<?php $__env->startSection('content'); ?>
    <div class="container my-4">
        <div class="d-flex align-items-center mb-3">
            <h5 class="mb-0">Edit Logistik: <?php echo e($item->nama_barang); ?></h5>
        </div>

        <div class="card border-0 shadow-lg">
            <div class="card-body">
                <form method="POST" action="<?php echo e(route('kl.logistik.update', $item)); ?>" id="formLogistik">
                    <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>

                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">Tanggal</label>
                            <input type="date" name="tanggal" class="form-control"
                                value="<?php echo e(old('tanggal', $item->tanggal->format('Y-m-d'))); ?>" required>
                            <?php $__errorArgs = ['tanggal'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <small class="text-danger"><?php echo e($message); ?></small>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Nama Barang</label>
                            <input type="text" name="nama_barang" class="form-control"
                                value="<?php echo e(old('nama_barang', $item->nama_barang)); ?>" required>
                            <?php $__errorArgs = ['nama_barang'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <small class="text-danger"><?php echo e($message); ?></small>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Satuan</label>
                            <input type="text" name="satuan" class="form-control"
                                value="<?php echo e(old('satuan', $item->satuan)); ?>" required>
                            <?php $__errorArgs = ['satuan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <small class="text-danger"><?php echo e($message); ?></small>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Volume</label>
                            <input type="number" name="volume" class="form-control calc" min="0" step="1"
                                value="<?php echo e(old('volume', $item->volume)); ?>" required>
                            <?php $__errorArgs = ['volume'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <small class="text-danger"><?php echo e($message); ?></small>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Harga Satuan (Rp)</label>
                            <input type="number" name="harga_satuan" class="form-control calc" min="0"
                                step="0.01" value="<?php echo e(old('harga_satuan', $item->harga_satuan)); ?>" required>
                            <?php $__errorArgs = ['harga_satuan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <small class="text-danger"><?php echo e($message); ?></small>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Jumlah Harga (Rp)</label>
                            <input type="number" name="jumlah_harga" class="form-control" step="0.01"
                                value="<?php echo e(old('jumlah_harga', $item->jumlah_harga)); ?>" readonly>
                        </div>

                        <div class="col-12">
                            <fieldset class="border rounded-3 p-3">
                                <legend class="float-none w-auto px-2">Jumlah</legend>
                                <div class="row g-3">
                                    <div class="col-md-3">
                                        <label class="form-label">Keluar (Barang)</label>
                                        <input type="number" name="jumlah_keluar" class="form-control calc" min="0"
                                            step="1" value="<?php echo e(old('jumlah_keluar', $item->jumlah_keluar)); ?>">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Keluar (Harga) Rp</label>
                                        <input type="number" name="jumlah_harga_keluar" class="form-control" step="0.01"
                                            value="<?php echo e(old('jumlah_harga_keluar', $item->jumlah_harga_keluar)); ?>" readonly>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Sisa (Barang)</label>
                                        <input type="number" name="sisa_barang" class="form-control" step="1"
                                            value="<?php echo e(old('sisa_barang', $item->sisa_barang)); ?>" readonly>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Sisa (Harga) Rp</label>
                                        <input type="number" name="sisa_harga" class="form-control" step="0.01"
                                            value="<?php echo e(old('sisa_harga', $item->sisa_harga)); ?>" readonly>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </div>

                    <div class="mt-4 d-flex gap-2">
                        <button class="btn btn-primary" type="submit">Simpan Perubahan</button>
                        <a href="<?php echo e(route('kl.logistik.index')); ?>" class="btn btn-outline-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app_admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\BPBD\resources\views/role/kl/logistik/edit.blade.php ENDPATH**/ ?>