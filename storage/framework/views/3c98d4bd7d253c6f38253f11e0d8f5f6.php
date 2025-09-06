

<?php $__env->startSection('title', 'Input Logistik (Banyak Barang)'); ?>
<?php $__env->startSection('page_title', 'Input Logistik (Banyak Barang)'); ?>
<?php $__env->startSection('page_icon'); ?> <i class="bi bi-box-seam-fill"></i> <?php $__env->stopSection(); ?>
<?php $__env->startSection('page_actions'); ?>
    <a href="<?php echo e(route('kl.logistik.index')); ?>" class="btn-orange">
        <i class="bi bi-arrow-left me-1"></i> Kembali
    </a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="container px-0">
        <?php if($errors->any()): ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($e); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>

        <form id="formLogistik" method="POST" action="<?php echo e(route('kl.logistik.store')); ?>">
            <?php echo csrf_field(); ?>

            <div class="mb-3 d-flex align-items-center gap-3">
                <label class="fw-800">Tanggal</label>
                <input type="date" name="tanggal" class="form-control" style="max-width:220px"
                    value="<?php echo e(old('tanggal')); ?>" required>
            </div>

            <div class="table-card overflow-x-auto">
                <table class="bpbd-table align-middle mb-0" id="itemsTable">
                    <thead>
                        <tr class="text-center">
                            <th style="width:40px">#</th>
                            <th>Nama Barang</th>
                            <th style="width:110px">Volume</th>
                            <th style="width:110px">Satuan</th>
                            <th style="width:140px">Harga Sat</th>
                            <th style="width:150px">Jumlah Harga</th>
                            <th style="width:110px">Keluar</th>
                            <th style="width:150px">Harga</th>
                            <th style="width:120px">Sisa (Barang)</th>
                            <th style="width:150px">Sisa (Harga)</th>
                            <th class="text-center" style="width:80px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="tbody">
                        
                    </tbody>
                    <tfoot>
                        <tr style="background:#fff7b5">
                            <th colspan="5" class="text-end">JUMLAH</th>
                            <th class="text-end"><span id="ft_jumlah_harga">Rp 0,00</span></th>
                            <th></th>
                            <th class="text-end"><span id="ft_keluar_harga">Rp 0,00</span></th>
                            <th></th>
                            <th class="text-end"><span id="ft_sisa_harga">Rp 0,00</span></th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="mt-3 d-flex gap-2">
                <button type="button" class="btn btn-outline-secondary" id="btnAdd">
                    <i class="bi bi-plus-lg me-1"></i> Tambah Baris
                </button>
                <button class="btn-orange" type="submit">
                    <i class="bi bi-save2 me-1"></i> Simpan Semua
                </button>
            </div>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app_admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\BPBD\resources\views/role/kl/logistik/create.blade.php ENDPATH**/ ?>