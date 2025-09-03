

<?php $__env->startSection('title', 'Data SK (KL)'); ?>
<?php $__env->startSection('page_title', 'Data SK'); ?>
<?php $__env->startSection('page_icon'); ?> <i class="bi bi-file-earmark-text"></i> <?php $__env->stopSection(); ?>
<?php $__env->startSection('page_actions'); ?>
    <a href="<?php echo e(route('kl.sk.create')); ?>" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Tambah SK</a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="card p-3">
        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>No SK</th>
                        <th>Judul SK</th>
                        <th>Masa Berlaku</th>
                        <th>Status</th>
                        <th>Tanggal SK</th>
                        <th>PDF</th>
                        <th style="width:140px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i=>$sk): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><?php echo e($list->firstItem() + $i); ?></td>
                            <td><?php echo e($sk->no_sk); ?></td>
                            <td><?php echo e($sk->judul_sk); ?></td>
                            <td>
                                <?php if($sk->start_at): ?>
                                    <?php echo e($sk->start_at->format('d/m/Y')); ?>

                                <?php endif; ?> —
                                <?php if($sk->end_at): ?>
                                    <?php echo e($sk->end_at->format('d/m/Y')); ?>

                                <?php endif; ?>
                            </td>
                            <td>
                                <?php
                                    $cls = match ($sk->status_label) {
                                        'Aktif' => 'badge bg-success',
                                        'Belum Berlaku' => 'badge bg-warning text-dark',
                                        default => 'badge bg-secondary',
                                    };
                                ?>
                                <span class="<?php echo e($cls); ?>"><?php echo e($sk->status_label); ?></span>
                            </td>
                            <td><?php echo e($sk->tanggal_sk->translatedFormat('d F Y')); ?></td>
                            <td>
                                <a href="<?php echo e(route('kl.sk.download', $sk)); ?>" class="link-primary"><i
                                        class="bi bi-file-earmark-pdf"></i> Unduh</a>
                            </td>
                            <td>
                                <a class="btn btn-sm btn-outline-primary" href="<?php echo e(route('kl.sk.edit', $sk)); ?>">Edit</a>
                                <form action="<?php echo e(route('kl.sk.destroy', $sk)); ?>" method="POST" class="d-inline"
                                    onsubmit="return confirm('Hapus SK ini?');">
                                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                    <button class="btn btn-sm btn-outline-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">Belum ada data.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="mt-2"><?php echo e($list->links()); ?></div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app_admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\BPBD\resources\views/role/kl/sk/index.blade.php ENDPATH**/ ?>