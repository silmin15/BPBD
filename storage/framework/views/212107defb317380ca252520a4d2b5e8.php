<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>Rekap SK <?php echo e($year); ?></title>
    <style>
        body {
            font-family: DejaVu Sans, Arial, sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
        }

        th,
        td {
            border: 1px solid #bbb;
            padding: 6px 8px;
        }

        th {
            background: #f3f3f3;
        }

        h3,
        h4 {
            margin: 0 0 8px;
        }
    </style>
</head>

<body>
    <h3>Rekap SK Tahun <?php echo e($year); ?></h3>
    <?php if(!empty($context)): ?>
        <p style="margin:0 0 8px;">Mode: Baris Terpilih • Jumlah: <?php echo e($context['count'] ?? 0); ?></p>
    <?php endif; ?>

    <?php $__currentLoopData = $byMonth; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ym => $rows): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <h4><?php echo e(\Carbon\Carbon::createFromFormat('Y-m', $ym)->translatedFormat('F Y')); ?></h4>
        <table>
            <thead>
                <tr>
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
            </tbody>
        </table>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</body>

</html>
<?php /**PATH C:\laragon\www\BPBD\resources\views/role/kl/sk/pdf.blade.php ENDPATH**/ ?>