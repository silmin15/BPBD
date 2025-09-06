<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Rekap <?php echo e($role); ?> - <?php echo e($monthLabel); ?></title>
  <style>
    body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
    h1 { font-size: 18px; margin: 0 0 10px; }
    table { width:100%; border-collapse: collapse; }
    th, td { border:1px solid #999; padding:6px; vertical-align: top; }
    .muted { color:#666; }
  </style>
</head>
<body>
  <h1>Rekap <?php echo e($role); ?> (<?php echo e($monthLabel); ?>)</h1>
  <div class="muted">Periode: <?php echo e($start->format('d/m/Y')); ?> – <?php echo e($end->format('d/m/Y')); ?></div>

  <table>
    <thead>
      <tr>
        <th style="width:5%">#</th>
        <th>Judul</th>
        <th>Jenis</th>
        <th>Tanggal</th>
        <th>Lokasi</th>
        <th>Petugas</th>
      </tr>
    </thead>
    <tbody>
      <?php $__empty_1 = true; $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <tr>
          <td><?php echo e($i+1); ?></td>
          <td><?php echo e($r->judul_laporan); ?></td>
          <td><?php echo e($r->jenis_kegiatan); ?></td>
          <td><?php echo e(optional($r->tanggal)->format('d/m/Y')); ?></td>
          <td><?php echo e($r->lokasi_kegiatan); ?></td>
          <td><?php echo e($r->petugas); ?></td>
        </tr>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <tr><td colspan="6" style="text-align:center">Tidak ada data</td></tr>
      <?php endif; ?>
    </tbody>
  </table>
</body>
</html>
<?php /**PATH C:\laragon\www\BPBD\resources\views/role/admin/rekap-kegiatan/rekap-role-bulanan-pdf.blade.php ENDPATH**/ ?>