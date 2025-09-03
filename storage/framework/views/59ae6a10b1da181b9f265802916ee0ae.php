
<?php $__env->startSection('title', "Laporan $ctx"); ?>

<?php use Illuminate\Support\Str; ?>


<?php $__env->startSection('page_title', "Laporan $ctx"); ?>
<?php $__env->startSection('page_icon'); ?> <i class="bi bi-clipboard2-check-fill"></i> <?php $__env->stopSection(); ?>
<?php $__env->startSection('page_actions'); ?>
    <form method="GET" class="d-flex align-items-center gap-2">
        <form class="d-flex align-items-center gap-2" method="get">
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-search"></i></span>
                <input type="text" name="q" value="<?php echo e(request('q')); ?>" class="form-control"
                    placeholder="Cari barang / satuan / tanggal">
            </div>
            
            <button type="button" class="btn-blue" id="open-filter">
                <i class="bi bi-funnel"></i> Filter
            </button>
        </form>

        <a href="<?php echo e(route(strtolower($ctx) . '.lap-kegiatan.create')); ?>"
            class="btn-orange d-inline-flex align-items-center gap-2">
            <i class="bi bi-plus-lg"></i> Buat Laporan
        </a>
    </form>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <?php if (isset($component)) { $__componentOriginal2987fdcc3c55d0adf3073fcab35ce062 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2987fdcc3c55d0adf3073fcab35ce062 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.lap-kegiatan.filter-overlay','data' => ['submitRoute' => route(strtolower($ctx) . '.lap-kegiatan.index')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('lap-kegiatan.filter-overlay'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['submit-route' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route(strtolower($ctx) . '.lap-kegiatan.index'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal2987fdcc3c55d0adf3073fcab35ce062)): ?>
<?php $attributes = $__attributesOriginal2987fdcc3c55d0adf3073fcab35ce062; ?>
<?php unset($__attributesOriginal2987fdcc3c55d0adf3073fcab35ce062); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal2987fdcc3c55d0adf3073fcab35ce062)): ?>
<?php $component = $__componentOriginal2987fdcc3c55d0adf3073fcab35ce062; ?>
<?php unset($__componentOriginal2987fdcc3c55d0adf3073fcab35ce062); ?>
<?php endif; ?>

    <div class="container px-0">

        
        <?php if(session('success')): ?>
            <div class="alert alert-success"><?php echo e(session('success')); ?></div>
        <?php endif; ?>

        
        <div class="table-card overflow-x-auto">
            <table class="bpbd-table min-w-full">
                <thead>
                    <tr>
                        <th style="white-space:nowrap;">Laporan Kegiatan</th>
                        <th>Kepada</th>
                        <th>Jenis Kegiatan</th>
                        <th style="min-width:180px;">Waktu Kegiatan</th>
                        <th>Lokasi Kegiatan</th>
                        <th>Hasil Kegiatan</th>
                        <th>Unsur Terlibat</th>
                        <th>Petugas</th>
                        <th>Dokumentasi</th>
                        <th class="col-aksi">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            
                            <td class="fw-semibold"><?php echo e($r->judul_laporan); ?></td>

                            
                            <td><?php echo e($r->kepada_yth ?? '—'); ?></td>

                            
                            <td><?php echo e($r->jenis_kegiatan ?? '—'); ?></td>

                            
                            <td class="text-muted" style="line-height:1.3">
                                <div>Hari : <?php echo e($r->hari ?? '—'); ?></div>
                                <div>Tgl : <?php echo e($r->tanggal?->format('d/m/Y') ?? '—'); ?></div>
                                <div>Pukul : <?php echo e($r->pukul ?? '—'); ?></div>
                            </td>

                            
                            <td><?php echo e($r->lokasi_kegiatan ?? '—'); ?></td>

                            
                            <td title="<?php echo e($r->hasil_kegiatan); ?>"><?php echo e(Str::limit($r->hasil_kegiatan ?? '—', 80)); ?></td>

                            
                            <td><?php echo e($r->unsur_yang_terlibat ?? '—'); ?></td>

                            
                            <td><?php echo e($r->petugas ?? '—'); ?></td>

                            
                            <td>
                                <?php $docs = $r->dokumentasi ?? []; ?>
                                <?php if(count($docs)): ?>
                                    <span class="badge-soft"><?php echo e(count($docs)); ?> file</span>
                                <?php else: ?>
                                    <span class="text-muted">—</span>
                                <?php endif; ?>
                            </td>

                            
                            <td class="col-aksi">
                                <a class="btn-edit"
                                    href="<?php echo e(route(strtolower($ctx) . '.lap-kegiatan.edit', $r)); ?>">Edit</a>

                                <a href="<?php echo e(route(strtolower($ctx) . '.lap-kegiatan.pdf', $r)); ?>" target="_blank"
                                    class="btn-gray">PDF</a>

                                <form method="POST" action="<?php echo e(route(strtolower($ctx) . '.lap-kegiatan.destroy', $r)); ?>"
                                    class="d-inline" onsubmit="return confirm('Hapus laporan?')">
                                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn-delete">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="10" class="text-center text-slate-500 py-6">Belum ada laporan</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            <?php echo e($items->links()); ?>

        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app_admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\BPBD\resources\views/role/lap-kegiatan/index.blade.php ENDPATH**/ ?>