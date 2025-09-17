

<?php
    $idr = fn($n) => 'Rp ' . number_format((float) $n, 0, ',', '.'); // format rupiah
    $qty = fn($n) => number_format((int) $n, 0, ',', '.'); // format angka qty
    $total = method_exists($items, 'total') ? $items->total() : $items->count();
?>

<?php $__env->startSection('title', 'Laporan KL'); ?>
<?php $__env->startSection('page_title', 'Laporan KL'); ?>
<?php $__env->startSection('page_icon'); ?> <i class="bi bi-box-seam-fill"></i> <?php $__env->stopSection(); ?>


<?php $__env->startSection('page_actions'); ?>
    <a class="btn btn-success" href="<?php echo e(route('kl.logistik.create')); ?>">
        <i class="bi bi-plus-lg me-1"></i> Buat Laporan
    </a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    
    <?php if (isset($component)) { $__componentOriginal4473e8639534cb1dd5b08ec3278f89d2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4473e8639534cb1dd5b08ec3278f89d2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.kl.logistik.filter-overlay','data' => ['submitRoute' => route('kl.logistik.index')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('kl.logistik.filter-overlay'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['submit-route' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('kl.logistik.index'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal4473e8639534cb1dd5b08ec3278f89d2)): ?>
<?php $attributes = $__attributesOriginal4473e8639534cb1dd5b08ec3278f89d2; ?>
<?php unset($__attributesOriginal4473e8639534cb1dd5b08ec3278f89d2); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal4473e8639534cb1dd5b08ec3278f89d2)): ?>
<?php $component = $__componentOriginal4473e8639534cb1dd5b08ec3278f89d2; ?>
<?php unset($__componentOriginal4473e8639534cb1dd5b08ec3278f89d2); ?>
<?php endif; ?>

    <?php if(session('success')): ?>
        <div class="alert alert-success"><?php echo e(session('success')); ?></div>
    <?php endif; ?>

    <div class="card shadow-sm">
        
        <div class="card-body pb-2">
            <form method="GET" class="row g-2 align-items-center">
                <div class="col-lg-7">
                    <div class="input-group">
                        <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                        <input type="text" name="q" value="<?php echo e(request('q')); ?>" class="form-control"
                            placeholder="Cari barang / satuan / tanggal…">
                    </div>
                </div>

                <div class="col-lg-5 d-grid d-md-block">
                    <button type="button" class="btn btn-primary" id="open-filter">
                        <i class="bi bi-funnel me-1"></i> Filter
                    </button>

                    <?php if(request('q')): ?>
                        <a href="<?php echo e(route('kl.logistik.index')); ?>" class="btn btn-outline-secondary ms-md-2 mt-2 mt-md-0">
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
                        <th>Nama Barang</th>
                        <th>Satuan</th>
                        <th class="text-center">Tanggal</th>
                        <th class="text-end">Volume</th>
                        <th class="text-end">Harga Sat</th>
                        <th class="text-end">Jumlah Harga</th>
                        <th class="text-end">Keluar</th>
                        <th class="text-end">Harga</th>
                        <th class="text-end">Sisa (Barang)</th>
                        <th class="text-end">Sisa (Harga)</th>
                        <th class="text-end" style="width:220px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $it): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td class="fw-semibold"><?php echo e($it->nama_barang); ?></td>
                            <td><?php echo e($it->satuan); ?></td>
                            <td class="text-center text-nowrap"><?php echo e($it->tanggal->format('d/m/Y')); ?></td>
                            <td class="text-end"><?php echo e($qty($it->volume)); ?></td>
                            <td class="text-end"><?php echo e($idr($it->harga_satuan)); ?></td>
                            <td class="text-end"><?php echo e($idr($it->jumlah_harga)); ?></td>
                            <td class="text-end"><?php echo e($qty($it->jumlah_keluar)); ?></td>
                            <td class="text-end"><?php echo e($idr($it->jumlah_harga_keluar)); ?></td>
                            <td class="text-end"><?php echo e($qty($it->sisa_barang)); ?></td>
                            <td class="text-end"><?php echo e($idr($it->sisa_harga)); ?></td>
                            <td class="text-end">
                                <a href="<?php echo e(route('kl.logistik.edit', $it)); ?>" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <form action="<?php echo e(route('kl.logistik.destroy', $it)); ?>" method="POST" class="d-inline"
                                    onsubmit="return confirm('Hapus data ini?')">
                                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="11" class="text-center text-muted py-4">Belum ada data logistik.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        
        <div class="card-footer bg-white d-flex flex-column flex-md-row justify-content-between align-items-center">
            <small class="text-muted mb-2 mb-md-0">
                Menampilkan <?php echo e($items->count() ? $items->firstItem() . '–' . $items->lastItem() : 0); ?>

                dari <?php echo e($total); ?> data
            </small>
            <?php echo e($items->onEachSide(1)->withQueryString()->links()); ?>

        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app_admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\BPBD\resources\views/role/kl/logistik/index.blade.php ENDPATH**/ ?>