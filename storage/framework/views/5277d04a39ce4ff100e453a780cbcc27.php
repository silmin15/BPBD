

<?php $__env->startSection('title', 'SOP Kebencanaan'); ?>
<?php $__env->startSection('page_title', 'SOP Kebencanaan'); ?>
<?php $__env->startSection('page_icon'); ?> <i class="bi bi-journal-text"></i> <?php $__env->stopSection(); ?>

<?php
    // prefix route berdasar role
    $ns = 'admin';
    if (Route::is('pk.*')) {
        $ns = 'pk';
    } elseif (Route::is('kl.*')) {
        $ns = 'kl';
    } elseif (Route::is('rr.*')) {
        $ns = 'rr';
    }

    $total = $sops->total() ?? 0;
?>

<?php $__env->startSection('page_actions'); ?>
    <a href="<?php echo e(route($ns . '.sop.create')); ?>" class="btn btn-success">
        <i class="bi bi-plus-lg me-1"></i> Tambah SOP
    </a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php if(session('ok')): ?>
        <div class="alert alert-success"><?php echo e(session('ok')); ?></div>
    <?php endif; ?>

    <div class="card shadow-sm">
        
        <div class="card-body pb-2">
            <form method="get" class="row g-2 align-items-center">
                <div class="col-lg-7">
                    <div class="input-group">
                        <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                        <input type="text" name="q" value="<?php echo e($q ?? ''); ?>" class="form-control"
                            placeholder="Cari nomor / judul SOP…">
                    </div>
                </div>

                <?php if (\Illuminate\Support\Facades\Blade::check('role', 'Super Admin')): ?>
                    <div class="col-lg-3">
                        <select name="role" class="form-select">
                            <option value="">— Semua Role —</option>
                            <?php $__currentLoopData = ['Super Admin', 'PK', 'KL', 'RR']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($r); ?>" <?php if(($role ?? '') === $r): echo 'selected'; endif; ?>><?php echo e($r); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                <?php endif; ?>

                <div class="col-lg-2 d-grid d-md-block">
                    <button class="btn btn-primary"><i class="bi bi-funnel me-1"></i> Filter</button>
                    <?php if(($q ?? null) || ($role ?? null)): ?>
                        <a href="<?php echo e(route($ns . '.sop.index')); ?>" class="btn btn-outline-secondary ms-md-2 mt-2 mt-md-0">
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
                        <th style="width:72px" class="text-center">#</th>
                        <th style="width:180px">Nomor</th>
                        <th>Judul</th>
                        <?php if (\Illuminate\Support\Facades\Blade::check('role', 'Super Admin')): ?>
                            <th style="width:140px">Role</th>
                        <?php endif; ?>
                        <th style="width:160px">Publik</th>
                        <th style="width:290px" class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $sops; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $sop): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td class="text-center"><?php echo e($sops->firstItem() + $i); ?></td>
                            <td class="fw-semibold"><?php echo e($sop->nomor); ?></td>
                            <td><?php echo e($sop->judul); ?></td>
                            <?php if (\Illuminate\Support\Facades\Blade::check('role', 'Super Admin')): ?>
                                <td><span class="badge text-bg-info"><?php echo e($sop->owner_role); ?></span></td>
                            <?php endif; ?>
                            <td>
                                <?php if($sop->is_published): ?>
                                    <span class="badge text-bg-success">Published</span>
                                    <small
                                        class="text-muted d-block"><?php echo e(optional($sop->published_at)->format('d M Y H:i')); ?></small>
                                <?php else: ?>
                                    <span class="badge text-bg-secondary">Internal / Draft</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-end">
                                <a href="<?php echo e(route($ns . '.sop.download', $sop)); ?>" class="btn btn-sm btn-outline-secondary">
                                    <i class="bi bi-download"></i> Download
                                </a>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('update', $sop)): ?>
                                    <a href="<?php echo e(route($ns . '.sop.edit', $sop)); ?>" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('publish', $sop)): ?>
                                    <form action="<?php echo e(route($ns . '.sop.toggle', $sop)); ?>" method="post" class="d-inline">
                                        <?php echo csrf_field(); ?>
                                        <button class="btn btn-sm btn-outline-warning">
                                            <i class="bi bi-broadcast"></i> <?php echo e($sop->is_published ? 'Unpublish' : 'Publish'); ?>

                                        </button>
                                    </form>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete', $sop)): ?>
                                    <form action="<?php echo e(route($ns . '.sop.destroy', $sop)); ?>" method="post" class="d-inline"
                                        onsubmit="return confirm('Hapus SOP ini?')">
                                        <?php echo csrf_field(); ?> <?php echo method_field('delete'); ?>
                                        <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                    </form>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="<?php if (\Illuminate\Support\Facades\Blade::check('role', 'Super Admin')): ?>6 <?php else: ?> 5 <?php endif; ?>" class="text-center text-muted py-4">
                                Belum ada data.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        
        <div class="card-footer bg-white d-flex flex-column flex-md-row justify-content-between align-items-center">
            <small class="text-muted mb-2 mb-md-0">
                Menampilkan <?php echo e($sops->count() ? $sops->firstItem() . '–' . $sops->lastItem() : 0); ?> dari <?php echo e($total); ?>

                data
            </small>
            <?php echo e($sops->onEachSide(1)->links()); ?>

        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app_admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\BPBD\resources\views/role/shared/sop/index.blade.php ENDPATH**/ ?>