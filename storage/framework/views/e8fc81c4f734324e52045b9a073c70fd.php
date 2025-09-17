

<?php $__env->startSection('title', 'Data & Rekap SK'); ?>
<?php $__env->startSection('page_title', 'Data & Rekap SK'); ?>
<?php $__env->startSection('page_icon'); ?> <i class="bi bi-journal-text"></i> <?php $__env->stopSection(); ?>

<?php
    // Tentukan namespace route (admin|pk|kl|rr)
    $ns = $routeBase ?? (Route::is('pk.*') ? 'pk' : (Route::is('kl.*') ? 'kl' : (Route::is('rr.*') ? 'rr' : 'admin')));

    $isAdmin = $ns === 'admin';
    $q = trim(request('q', ''));
    $ownerRole = request('owner_role');

    // total untuk footer (menyerupai SOP)
    $totalData = isset($list) ? $list->total() ?? 0 : 0;
?>


<?php $__env->startSection('page_actions'); ?>
    <?php if(($activeTab ?? 'data') === 'data'): ?>
        <a href="<?php echo e(route($ns . '.sk.create')); ?>" class="btn btn-success">
            <i class="bi bi-plus-lg me-1"></i> Tambah SK
        </a>
    <?php else: ?>
        <?php if(Route::has($ns . '.sk.rekap.years')): ?>
            <a href="<?php echo e(route($ns . '.sk.rekap.years')); ?>" class="btn btn-warning me-2">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        <?php endif; ?>
        <button type="submit" class="btn btn-outline-secondary" id="top-print-selected" form="form-selected"
            formtarget="_blank" disabled>
            <i class="bi bi-printer me-1"></i> Cetak PDF (Yang Dipilih)
        </button>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php if(session('ok')): ?>
        <div class="alert alert-success"><?php echo e(session('ok')); ?></div>
    <?php endif; ?>

    
    <div class="mb-3 d-flex align-items-center gap-2">
        <a href="<?php echo e(route($ns . '.sk.index', ['tab' => 'data'] + request()->except('page'))); ?>"
            class="btn <?php echo e(($activeTab ?? 'data') === 'data' ? 'btn-primary' : 'btn-outline-primary'); ?>">
            Data SK
        </a>
        <a href="<?php echo e(route($ns . '.sk.index', ['tab' => 'rekap', 'year' => $year] + request()->except('page'))); ?>"
            class="btn <?php echo e(($activeTab ?? 'data') === 'rekap' ? 'btn-primary' : 'btn-outline-primary'); ?>">
            Rekap SK
        </a>
    </div>

    
    <div class="<?php echo e(($activeTab ?? 'data') === 'data' ? '' : 'd-none'); ?>">
        <div class="card shadow-sm">
            
            <div class="card-body pb-2">
                <form method="get" class="row g-2 align-items-center">
                    
                    <input type="hidden" name="tab" value="data">

                    <div class="col-lg-7">
                        <div class="input-group">
                            <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                            <input type="text" name="q" value="<?php echo e($q); ?>" class="form-control"
                                placeholder="Cari nomor / judul SK…">
                        </div>
                    </div>

                    <?php if($isAdmin): ?>
                        <div class="col-lg-3">
                            <select name="owner_role" class="form-select">
                                <option value="">— Semua Role —</option>
                                <?php $__currentLoopData = $allRoles ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($r); ?>" <?php if($ownerRole === $r): echo 'selected'; endif; ?>><?php echo e($r); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    <?php endif; ?>

                    <div class="col-lg-2 d-grid d-md-block">
                        <button class="btn btn-primary"><i class="bi bi-funnel me-1"></i> Filter</button>
                        <?php if($q || $ownerRole): ?>
                            <a href="<?php echo e(route($ns . '.sk.index', ['tab' => 'data'])); ?>"
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
                            <th style="width:160px">No SK</th>
                            <th>Judul SK</th>
                            <?php if($isAdmin): ?>
                                <th style="width:200px">Pembuat</th>
                            <?php endif; ?>
                            <th style="width:200px" class="text-center">Masa Berlaku</th>
                            <th style="width:120px" class="text-center">Status</th>
                            <th style="width:140px" class="text-center">Tanggal SK</th>
                            <th style="width:120px" class="text-center">PDF</th>
                            <th style="width:290px" class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $sk): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td class="text-center"><?php echo e($list->firstItem() + $i); ?></td>
                                <td class="fw-semibold"><?php echo e($sk->no_sk); ?></td>
                                <td><?php echo e($sk->judul_sk); ?></td>

                                <?php if($isAdmin): ?>
                                    <?php
                                        $roleName = optional($sk->creator?->roles->first())->name;
                                        $creator = $sk->creator?->name;
                                    ?>
                                    <td>
                                        <?php if($roleName): ?>
                                            <span class="badge text-bg-info"><?php echo e($roleName); ?></span>
                                        <?php endif; ?>
                                        <small class="text-muted ms-1"><?php echo e($creator ?? '—'); ?></small>
                                    </td>
                                <?php endif; ?>

                                <td class="text-center text-nowrap">
                                    <?php echo e($sk->start_at?->format('d/m/Y')); ?> — <?php echo e($sk->end_at?->format('d/m/Y')); ?>

                                </td>

                                <?php $expired = $sk->end_at && now()->gt($sk->end_at); ?>
                                <td class="text-center">
                                    <span class="badge <?php echo e($expired ? 'text-bg-secondary' : 'text-bg-success'); ?>">
                                        <?php echo e($expired ? 'Tidak Aktif' : 'Aktif'); ?>

                                    </span>
                                </td>

                                <td class="text-center"><?php echo e($sk->tanggal_sk->format('d/m/Y')); ?></td>

                                <td class="text-center">
                                    <?php if($sk->pdf_path): ?>
                                        <a href="<?php echo e(route($ns . '.sk.download', $sk)); ?>" target="_blank"
                                            class="btn btn-sm btn-outline-secondary">
                                            <i class="bi bi-download"></i> Unduh
                                        </a>
                                    <?php else: ?>
                                        <span class="text-muted">—</span>
                                    <?php endif; ?>
                                </td>

                                <td class="text-end">
                                    <a href="<?php echo e(route($ns . '.sk.edit', $sk)); ?>" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>
                                    <form action="<?php echo e(route($ns . '.sk.destroy', $sk)); ?>" method="POST" class="d-inline"
                                        onsubmit="return confirm('Hapus SK ini?')">
                                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                        <button class="btn btn-sm btn-outline-danger">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="<?php echo e($isAdmin ? 9 : 8); ?>" class="text-center text-muted py-4">Belum ada data.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            
            <div class="card-footer bg-white d-flex flex-column flex-md-row justify-content-between align-items-center">
                <small class="text-muted mb-2 mb-md-0">
                    Menampilkan <?php echo e($list->count() ? $list->firstItem() . '–' . $list->lastItem() : 0); ?> dari
                    <?php echo e($totalData); ?> data
                </small>
                <?php echo e($list->withQueryString()->onEachSide(1)->links()); ?>

            </div>
        </div>
    </div>

    
    <div class="<?php echo e(($activeTab ?? 'data') === 'rekap' ? '' : 'd-none'); ?>">
        <div class="card shadow-sm">

            
            <div class="card-body pb-2">
                <form id="form-selected" method="GET" action="<?php echo e(route($ns . '.sk.rekap.pdf', ['year' => $year])); ?>"
                    target="_blank" class="row g-2 align-items-center">

                    
                    <div class="col-lg-3">
                        <div class="input-group">
                            <span class="input-group-text bg-white"><i class="bi bi-calendar4"></i></span>
                            <select name="year" class="form-select"
                                onchange="
                      this.form.action = '<?php echo e(route($ns . '.sk.rekap.pdf', ['year' => '__YEAR__'])); ?>'
                        .replace('__YEAR__', this.value);
                    ">
                                <?php for($y = now()->year + 1; $y >= now()->year - 6; $y--): ?>
                                    <option value="<?php echo e($y); ?>" <?php if($y == $year): echo 'selected'; endif; ?>><?php echo e($y); ?>

                                    </option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>

                    
                    <?php if($isAdmin): ?>
                        <div class="col-lg-3">
                            <select name="owner_role" class="form-select"
                                onchange="location.href='<?php echo e(route($ns . '.sk.index')); ?>?tab=rekap&year=<?php echo e($year); ?>&owner_role=' + this.value">
                                <option value="">— Semua Role —</option>
                                <?php $__currentLoopData = $allRoles ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($r); ?>" <?php if(request('owner_role') === $r): echo 'selected'; endif; ?>><?php echo e($r); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    <?php endif; ?>

                    <div class="col-lg-6 d-grid d-md-flex justify-content-md-end align-items-center">
                        <div class="form-check me-md-3 mb-2 mb-md-0">
                            <input type="checkbox" class="form-check-input" id="check-all">
                            <label for="check-all" class="form-check-label">Pilih semua</label>
                        </div>
                        <button type="submit" class="btn btn-outline-secondary" id="top-print-selected" disabled>
                            <i class="bi bi-printer me-1"></i> Cetak PDF (Yang Dipilih)
                        </button>
                    </div>
                </form>
            </div>

            
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app_admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\BPBD\resources\views/role/shared/sk/index.blade.php ENDPATH**/ ?>