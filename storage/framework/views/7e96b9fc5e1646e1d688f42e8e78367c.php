
<?php
    $idr = fn($n) => 'Rp ' . number_format((float) $n, 0, ',', '.'); // format rupiah tanpa desimal
    $qty = fn($n) => number_format((int) $n, 0, ',', '.'); // format angka qty
?>
<?php $__env->startSection('title', 'Laporan KL'); ?>
<?php $__env->startSection('page_title', 'Laporan KL'); ?>
<?php $__env->startSection('page_icon'); ?> <i class="bi bi-box-seam-fill"></i> <?php $__env->stopSection(); ?>

<?php $__env->startSection('page_actions'); ?>
    
    <form method="GET" class="d-flex align-items-center gap-2">
        <div class="input-group">
            <span class="input-group-text"><i class="bi bi-search"></i></span>
            <input type="text" name="q" value="<?php echo e(request('q')); ?>" class="form-control"
                placeholder="Cari barang / satuan / tanggal">
        </div>

        
        <button type="button" class="btn-blue" id="open-filter">
            <i class="bi bi-funnel"></i> Filter
        </button>

        <a class="btn-orange" href="<?php echo e(route('role.kl.logistik.create')); ?>">
            <i class="bi bi-plus-lg"></i> Buat Laporan
        </a>
    </form>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <?php if (isset($component)) { $__componentOriginal4473e8639534cb1dd5b08ec3278f89d2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4473e8639534cb1dd5b08ec3278f89d2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.kl.logistik.filter-overlay','data' => ['submitRoute' => route('role.kl.logistik.index')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('kl.logistik.filter-overlay'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['submit-route' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('role.kl.logistik.index'))]); ?>
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
    <div class="container px-0">

        <?php if(session('success')): ?>
            <div class="alert alert-success"><?php echo e(session('success')); ?></div>
        <?php endif; ?>

        <div class="table-card overflow-x-auto">
            <table class="bpbd-table min-w-full">
                <thead>
                    <tr>
                        <th class="text-start">Nama Barang</th>
                        <th class="text-start">Satuan</th>
                        <th class="text-center">Tanggal</th>
                        <th class="text-end">Volume</th>
                        <th class="text-end">Harga Sat</th>
                        <th class="text-end">Jumlah Harga</th>
                        <th class="text-end">Keluar</th>
                        <th class="text-end">Harga</th>
                        <th class="text-end">Sisa (Barang)</th>
                        <th class="text-end">Sisa (Harga)</th>
                        <th class="col-aksi text-center">Aksi</th>
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
                            <td class="text-center text-nowrap">
                                <a href="<?php echo e(route('role.kl.logistik.edit', $it)); ?>" class="btn-edit">Edit</a>
                                <form action="<?php echo e(route('role.kl.logistik.destroy', $it)); ?>" method="POST" class="d-inline"
                                    onsubmit="return confirm('Hapus data ini?')">
                                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn-delete">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="11" class="text-center text-slate-500 py-6">Belum ada data logistik.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="mt-4 d-flex justify-content-end">
            <?php echo e($items->onEachSide(1)->withQueryString()->links()); ?>

        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app_admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\BPBD\resources\views/role/kl/logistik/index.blade.php ENDPATH**/ ?>