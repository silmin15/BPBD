

<?php $__env->startSection('title', "Rekap SK Tahun $year"); ?>
<?php $__env->startSection('page_title', "Rekap SK Tahun $year"); ?>
<?php $__env->startSection('page_icon'); ?> <i class="bi bi-clipboard2-check"></i> <?php $__env->stopSection(); ?>

<?php $__env->startSection('page_actions'); ?>
    <a href="<?php echo e(route('kl.sk.rekap.years')); ?>" class="btn btn-warning"><i class="bi bi-arrow-left"></i> Kembali</a>
    
    <button type="submit" class="btn btn-secondary" id="top-print-selected" form="form-selected" formtarget="_blank" disabled>
        <i class="bi bi-printer"></i> Cetak PDF (Yang Dipilih)
    </button>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="container px-0">
        <form method="GET" action="<?php echo e(route('kl.sk.rekap.pdf', $year)); ?>" target="_blank" id="form-selected"
            class="mb-3">
            <div class="d-flex justify-content-between align-items-center">
                <label class="form-check">
                    <input type="checkbox" id="check-all" class="form-check-input">
                    <span class="ms-1">Pilih Semua</span>
                </label>
            </div>

            <?php $__currentLoopData = $byMonth; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ym => $rows): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $bulan = \Carbon\Carbon::createFromFormat('Y-m', $ym)->translatedFormat('F Y');
                ?>

                <h5 class="fw-bold mt-4 mb-2"><?php echo e($bulan); ?></h5>
                <div class="table-card overflow-x-auto mb-4">
                    <table class="table table-striped align-middle">
                        <thead>
                            <tr>
                                <th style="width:36px;"></th>
                                <th>No</th>
                                <th>No SK</th>
                                <th>Judul SK</th>
                                <th>Masa Berlaku</th>
                                <th>Status</th>
                                <th>Tanggal SK</th>
                                <th>Bulan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $it): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><input type="checkbox" name="selected_ids[]" value="<?php echo e($it->id); ?>"
                                            class="row-check"></td>
                                    <td><?php echo e($i + 1); ?></td>
                                    <td><?php echo e($it->no_sk); ?></td>
                                    <td><?php echo e($it->judul_sk); ?></td>
                                    <td>
                                        <?php if($it->start_at): ?>
                                            <?php echo e($it->start_at->format('d/m/Y')); ?>

                                        <?php endif; ?> —
                                        <?php if($it->end_at): ?>
                                            <?php echo e($it->end_at->format('d/m/Y')); ?>

                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo e($it->status_label); ?></td>
                                    <td><?php echo e($it->tanggal_sk->translatedFormat('d F Y')); ?></td>
                                    <td><?php echo e($it->bulan_text ?? $it->tanggal_sk->translatedFormat('F')); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <tr class="table-warning fw-bold">
                                <td></td>
                                <td colspan="7" class="text-end">Jumlah SK bulan ini: <?php echo e($rows->count()); ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app_admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\BPBD\resources\views/role/kl/sk/rekap.blade.php ENDPATH**/ ?>