
<?php $__env->startSection('title', "Laporan $ctx"); ?>

<?php
    use Illuminate\Support\Str;
    $ns = strtolower($ctx); // pk|kl|rr
    $total = $items->total() ?? 0;
?>

<?php $__env->startSection('page_title', "Laporan $ctx"); ?>
<?php $__env->startSection('page_icon'); ?> <i class="bi bi-clipboard2-check-fill"></i> <?php $__env->stopSection(); ?>


<?php $__env->startSection('page_actions'); ?>
    <a href="<?php echo e(route($ns . '.lap-kegiatan.create')); ?>" class="btn btn-success">
        <i class="bi bi-plus-lg me-1"></i> Buat Laporan
    </a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    
    <?php if (isset($component)) { $__componentOriginal2987fdcc3c55d0adf3073fcab35ce062 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2987fdcc3c55d0adf3073fcab35ce062 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.lap-kegiatan.filter-overlay','data' => ['submitRoute' => route($ns . '.lap-kegiatan.index')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('lap-kegiatan.filter-overlay'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['submit-route' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route($ns . '.lap-kegiatan.index'))]); ?>
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

    <?php if(session('success')): ?>
        <div class="alert alert-success"><?php echo e(session('success')); ?></div>
    <?php endif; ?>

    <div class="card shadow-sm">
        
        <div class="card-body pb-2">
            <form method="GET" action="<?php echo e(route($ns . '.lap-kegiatan.index')); ?>" class="row g-2 align-items-center">
                <div class="col-lg-8">
                    <div class="input-group">
                        <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                        <input type="text" name="q" value="<?php echo e(request('q')); ?>" class="form-control"
                            placeholder="Cari judul / kepada / jenis / tanggal / lokasi">
                    </div>
                </div>

                <div class="col-lg-4 d-grid d-md-flex justify-content-md-end">
                    <button type="button" id="open-filter" class="btn btn-outline-secondary me-md-2">
                        <i class="bi bi-funnel"></i> Filter
                    </button>
                    <button class="btn btn-primary">
                        <i class="bi bi-search me-1"></i> Cari
                    </button>
                    <?php if(request('q')): ?>
                        <a href="<?php echo e(route($ns . '.lap-kegiatan.index')); ?>"
                            class="btn btn-outline-secondary ms-md-2 mt-2 mt-md-0">Reset</a>
                    <?php endif; ?>
                </div>
            </form>
        </div>

        
        <div class="table-responsive">
            <table class="table table-hover table-striped align-middle mb-0">
                <thead class="table-light sticky-top">
                    <tr>
                        <th style="width:72px" class="text-center">#</th>
                        <th>Laporan Kegiatan</th>
                        <th style="width:160px">Kepada</th>
                        <th style="width:160px">Jenis Kegiatan</th>
                        <th style="min-width:180px">Waktu Kegiatan</th>
                        <th>Lokasi</th>
                        <th style="min-width:220px">Hasil</th>
                        <th>Unsur Terlibat</th>
                        <th style="width:120px" class="text-center">Dokumentasi</th>
                        <th style="width:260px" class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td class="text-center"><?php echo e($items->firstItem() + $i); ?></td>

                            <td class="fw-semibold"><?php echo e($r->judul_laporan); ?></td>

                            <td><?php echo e($r->kepada_yth ?? '—'); ?></td>

                            <td><?php echo e($r->jenis_kegiatan ?? '—'); ?></td>

                            <td class="text-muted" style="line-height:1.3">
                                <div>Hari : <?php echo e($r->hari ?? '—'); ?></div>
                                <div>Tgl : <?php echo e(optional($r->tanggal)->format('d/m/Y') ?? '—'); ?></div>
                                <div>Pukul: <?php echo e($r->pukul ?? '—'); ?></div>
                            </td>

                            <td><?php echo e($r->lokasi_kegiatan ?? '—'); ?></td>

                            <td title="<?php echo e($r->hasil_kegiatan); ?>">
                                <?php echo e(Str::limit($r->hasil_kegiatan ?? '—', 80)); ?>

                            </td>

                            <td><?php echo e($r->unsur_yang_terlibat ?? '—'); ?></td>

                            <td class="text-center">
                                <?php $docs = $r->dokumentasi ?? []; ?>
                                <?php if(count($docs)): ?>
                                    <span class="badge text-bg-info"><?php echo e(count($docs)); ?> file</span>
                                <?php else: ?>
                                    <span class="text-muted">—</span>
                                <?php endif; ?>
                            </td>

                            <td class="text-end">
                                <a href="<?php echo e(route($ns . '.lap-kegiatan.pdf', $r)); ?>" target="_blank"
                                    class="btn btn-sm btn-outline-secondary">
                                    <i class="bi bi-filetype-pdf"></i> PDF
                                </a>

                                <a href="<?php echo e(route($ns . '.lap-kegiatan.edit', $r)); ?>"
                                    class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>

                                <form method="POST" action="<?php echo e(route($ns . '.lap-kegiatan.destroy', $r)); ?>"
                                    class="d-inline" onsubmit="return confirm('Hapus laporan?')">
                                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="10" class="text-center text-muted py-4">Belum ada laporan.</td>
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
            <?php echo e($items->withQueryString()->onEachSide(1)->links()); ?>

        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app_admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\BPBD\resources\views/role/shared/lap-kegiatan/index.blade.php ENDPATH**/ ?>