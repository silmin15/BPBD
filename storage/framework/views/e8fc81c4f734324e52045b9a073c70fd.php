

<?php $__env->startSection('title', 'Data & Rekap SK'); ?>
<?php $__env->startSection('page_title', 'Data & Rekap SK'); ?>
<?php $__env->startSection('page_icon'); ?> <i class="bi bi-journal-text"></i> <?php $__env->stopSection(); ?>

<?php $__env->startSection('page_actions'); ?>
    <?php if($activeTab === 'data'): ?>
        <a href="<?php echo e(route($routeBase . '.sk.create')); ?>" class="btn-orange">
            <i class="bi bi-plus-lg"></i> Tambah SK
        </a>
    <?php else: ?>
        
        <?php if(Route::has($routeBase . '.sk.rekap.years')): ?>
            <a href="<?php echo e(route($routeBase . '.sk.rekap.years')); ?>" class="btn btn-warning me-2">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        <?php endif; ?>

        <button type="submit" class="btn-gray" id="top-print-selected" form="form-selected" formtarget="_blank" disabled>
            <i class="bi bi-printer"></i> Cetak PDF (Yang Dipilih)
        </button>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-fluid px-0">

        
        <div class="d-flex gap-2 mb-3">
            <a href="<?php echo e(route($routeBase . '.sk.index', ['tab' => 'data'])); ?>"
                class="btn <?php echo e($activeTab === 'data' ? 'btn-primary' : 'btn-outline-primary'); ?>">
                Data SK
            </a>

            <a href="<?php echo e(route($routeBase . '.sk.index', ['tab' => 'rekap', 'year' => $year])); ?>"
                class="btn <?php echo e($activeTab === 'rekap' ? 'btn-primary' : 'btn-outline-primary'); ?>">
                Rekap SK
            </a>

            <?php if($activeTab === 'rekap'): ?>
                
                <div class="ms-auto">
                    <form method="GET" action="<?php echo e(route($routeBase . '.sk.index')); ?>" class="d-inline">
                        <input type="hidden" name="tab" value="rekap">
                        <select name="year" class="form-select form-select-sm d-inline w-auto"
                            onchange="this.form.submit()">
                            <?php for($y = now()->year + 1; $y >= now()->year - 6; $y--): ?>
                                <option value="<?php echo e($y); ?>" <?php echo e($y == $year ? 'selected' : ''); ?>>
                                    <?php echo e($y); ?>

                                </option>
                            <?php endfor; ?>
                        </select>
                    </form>
                </div>
            <?php endif; ?>
        </div>

        
        <div class="<?php echo e($activeTab === 'data' ? '' : 'd-none'); ?>">
            <div class="table-card overflow-x-auto">
                <table class="bpbd-table min-w-full">
                    <thead>
                        <tr>
                            <th class="text-start">#</th>
                            <th class="text-start">No SK</th>
                            <th class="text-start">Judul SK</th>
                            <th class="text-center">Masa Berlaku</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Tanggal SK</th>
                            <th class="text-center">PDF</th>
                            <th class="col-aksi text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $sk): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td class="text-start"><?php echo e($list->firstItem() + $i); ?></td>
                                <td class="fw-semibold text-start"><?php echo e($sk->no_sk); ?></td>
                                <td class="text-start"><?php echo e($sk->judul_sk); ?></td>

                                <td class="text-center text-nowrap">
                                    <?php echo e($sk->start_at?->format('d/m/Y')); ?> — <?php echo e($sk->end_at?->format('d/m/Y')); ?>

                                </td>

                                <td class="text-center">
                                    <?php $expired = $sk->end_at && now()->gt($sk->end_at); ?>
                                    <span class="badge <?php echo e($expired ? 'bg-secondary' : 'bg-success'); ?>">
                                        <?php echo e($expired ? 'Tidak Aktif' : 'Aktif'); ?>

                                    </span>
                                </td>

                                <td class="text-center"><?php echo e($sk->tanggal_sk->format('d/m/Y')); ?></td>

                                <td class="text-center">
                                    <?php if($sk->pdf_path): ?>
                                        <a href="<?php echo e(route($routeBase . '.sk.download', $sk)); ?>" target="_blank"
                                            class="text-danger d-inline-flex align-items-center gap-1">
                                            <i class="bi bi-file-pdf"></i>
                                            <span class="d-none d-sm-inline">Unduh</span>
                                        </a>
                                    <?php else: ?>
                                        <span class="text-muted">—</span>
                                    <?php endif; ?>
                                </td>

                                <td class="text-center text-nowrap">
                                    <a href="<?php echo e(route($routeBase . '.sk.edit', $sk)); ?>" class="btn-edit me-1">Edit</a>
                                    <form action="<?php echo e(route($routeBase . '.sk.destroy', $sk)); ?>" method="POST"
                                        class="d-inline" onsubmit="return confirm('Hapus SK ini?')">
                                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                        <button class="btn-delete">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="8" class="text-center text-slate-500 py-6">Belum ada data.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="mt-4 d-flex justify-content-end">
                <?php echo e($list->withQueryString()->onEachSide(1)->links()); ?>

            </div>
        </div>

        
        <div class="<?php echo e($activeTab === 'rekap' ? '' : 'd-none'); ?>">
            <form method="GET" action="<?php echo e(route($routeBase . '.sk.rekap.pdf', $year)); ?>" target="_blank"
                id="form-selected" class="mb-3">

                <div class="d-flex align-items-center gap-3 mb-2 flex-wrap">
                    <label class="form-check d-inline-flex align-items-center gap-2 mb-0">
                        <input type="checkbox" id="check-all" class="form-check-input">
                        <span>Pilih semua</span>
                    </label>
                    <div class="ms-auto">
                        <span class="text-muted">Tahun:</span> <strong><?php echo e($year); ?></strong>
                    </div>
                    <button type="submit" class="btn-gray" id="top-print-selected" formtarget="_blank" disabled>
                        <i class="bi bi-printer"></i> Cetak PDF (Yang Dipilih)
                    </button>
                </div>

                <div class="table-card overflow-x-auto">
                    <table class="bpbd-table min-w-full">
                        <thead>
                            <tr>
                                <th width="36">#</th>
                                <th class="text-start">No SK</th>
                                <th class="text-start">Judul SK</th>
                                <th class="text-center">Tanggal SK</th>
                                <th class="text-center">Masa Berlaku</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">PDF</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $byMonth; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ym => $rows): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr class="table-subheader">
                                    <td colspan="7" class="fw-semibold">
                                        <?php echo e(\Carbon\Carbon::parse($ym . '-01')->translatedFormat('F Y')); ?>

                                    </td>
                                </tr>

                                <?php $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sk): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td class="text-center">
                                            <input type="checkbox" class="row-check" name="selected_ids[]"
                                                value="<?php echo e($sk->id); ?>">
                                        </td>
                                        <td class="fw-semibold text-start"><?php echo e($sk->no_sk); ?></td>
                                        <td class="text-start"><?php echo e($sk->judul_sk); ?></td>
                                        <td class="text-center"><?php echo e($sk->tanggal_sk->format('d/m/Y')); ?></td>
                                        <td class="text-center text-nowrap">
                                            <?php echo e($sk->start_at?->format('d/m/Y')); ?> — <?php echo e($sk->end_at?->format('d/m/Y')); ?>

                                        </td>
                                        <td class="text-center">
                                            <?php $expired = $sk->end_at && now()->gt($sk->end_at); ?>
                                            <span class="badge <?php echo e($expired ? 'bg-secondary' : 'bg-success'); ?>">
                                                <?php echo e($expired ? 'Kedaluwarsa' : 'Aktif'); ?>

                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <?php if($sk->pdf_path): ?>
                                                <a href="<?php echo e(route($routeBase . '.sk.download', $sk)); ?>" target="_blank"
                                                    class="text-danger d-inline-flex align-items-center gap-1">
                                                    <i class="bi bi-file-pdf"></i>
                                                    <span class="d-none d-sm-inline">Unduh</span>
                                                </a>
                                            <?php else: ?>
                                                <span class="text-muted">—</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="7" class="text-center text-slate-500 py-6">
                                        Belum ada data pada tahun ini.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    <button type="submit" class="btn-gray" id="bottom-print-selected" disabled>
                        <i class="bi bi-printer"></i> Cetak PDF (Yang Dipilih)
                    </button>
                </div>
            </form>
        </div>

    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app_admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\BPBD\resources\views/role/shared/sk/index.blade.php ENDPATH**/ ?>