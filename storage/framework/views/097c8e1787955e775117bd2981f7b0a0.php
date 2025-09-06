<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Laporan <?php echo e($ctx); ?> #<?php echo e($report->id); ?></title>
  <style>
    body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
    h1 { font-size: 18px; margin: 0 0 10px; text-transform: uppercase; }
    table.meta { width: 100%; border-collapse: collapse; margin-bottom: 8px; }
    table.meta td { padding: 4px 6px; vertical-align: top; }
    .label { width: 180px; font-weight: bold; text-transform: uppercase; }
    .box { border:1px solid #999; padding:10px; margin-top:8px; }
    .photos img { height: 100px; margin: 4px; border: 1px solid #ccc; }
    .muted { color:#666; }
  </style>
</head>
<body>
  <h1>LAPORAN KEGIATAN (<?php echo e($ctx); ?>)</h1>

  <table class="meta">
    <tr>
      <td class="label">LAPORAN KEGIATAN</td>
      <td>: <?php echo e($report->judul_laporan ?: '—'); ?></td>
    </tr>
    <tr>
      <td class="label">KEPADA</td>
      <td>: <?php echo e($report->kepada_yth ?: '—'); ?></td>
    </tr>
    <tr>
      <td class="label">JENIS KEGIATAN</td>
      <td>: <?php echo e($report->jenis_kegiatan ?: '—'); ?></td>
    </tr>
    <tr>
      <td class="label">WAKTU KEGIATAN</td>
      <td>
        <div>Hari&nbsp;&nbsp;: <?php echo e($report->hari ?: '—'); ?></div>
        <div>Tgl&nbsp;&nbsp;&nbsp;: <?php echo e(optional($report->tanggal)->format('d/m/Y') ?: '—'); ?></div>
        <div>Pukul : <?php echo e($report->pukul ?: '—'); ?></div>
      </td>
    </tr>
    <tr>
      <td class="label">LOKASI KEGIATAN</td>
      <td>: <?php echo e($report->lokasi_kegiatan ?: '—'); ?></td>
    </tr>
    <tr>
      <td class="label">PETUGAS</td>
      <td>: <?php echo e($report->petugas ?: '—'); ?></td>
    </tr>
    <tr>
      <td class="label muted">DIBUAT</td>
      <td class="muted">: <?php echo e($report->author?->name ?? '—'); ?> • <?php echo e($report->created_at?->format('d/m/Y H:i') ?? '—'); ?></td>
    </tr>
  </table>

  <div class="box">
    <strong>HASIL KEGIATAN</strong><br>
    <?php echo $report->hasil_kegiatan ? nl2br(e($report->hasil_kegiatan)) : '—'; ?>

  </div>

  <div class="box">
    <strong>UNSUR YANG TERLIBAT</strong><br>
    <?php echo $report->unsur_yang_terlibat ? nl2br(e($report->unsur_yang_terlibat)) : '—'; ?>

  </div>

  <?php if(!empty($report->dokumentasi)): ?>
    <div class="box">
      <strong>DOKUMENTASI</strong><br>
      <div class="photos">
        <?php $__currentLoopData = $report->dokumentasi; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          
          <img src="<?php echo e(public_path('storage/'.$p)); ?>">
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>
    </div>
  <?php else: ?>
    <div class="box">
      <strong>DOKUMENTASI</strong><br> —
    </div>
  <?php endif; ?>
</body>
</html>
<?php /**PATH C:\laragon\www\BPBD\resources\views/role/lap-kegiatan/pdf.blade.php ENDPATH**/ ?>