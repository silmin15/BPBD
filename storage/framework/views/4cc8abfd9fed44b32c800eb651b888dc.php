<?php
  $isEdit = isset($report);
  $action = $isEdit
    ? route(strtolower($ctx).'.lap-kegiatan.update',$report)
    : route(strtolower($ctx).'.lap-kegiatan.store');
?>


<?php $__env->startSection('title', ($isEdit?'Edit':'Buat')." Laporan $ctx"); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
  <h1 class="h4 mb-3"><?php echo e($isEdit ? 'Edit' : 'Buat'); ?> Laporan <?php echo e($ctx); ?></h1>

  <?php if($errors->any()): ?>
    <div class="alert alert-danger">Periksa kembali isian Anda.</div>
  <?php endif; ?>

  <form method="POST" action="<?php echo e($action); ?>" enctype="multipart/form-data" class="row g-3">
    <?php echo csrf_field(); ?>
    <?php if($isEdit): ?> <?php echo method_field('PUT'); ?> <?php endif; ?>

    
    <div class="col-12">
      <label class="form-label fw-bold">LAPORAN KEGIATAN *</label>
      <input name="judul_laporan" class="form-control" required
             value="<?php echo e(old('judul_laporan', $report->judul_laporan ?? '')); ?>">
    </div>

    
    <div class="col-12 col-md-6">
      <label class="form-label fw-bold">KEPADA</label>
      <input name="kepada_yth" class="form-control"
             value="<?php echo e(old('kepada_yth', $report->kepada_yth ?? '')); ?>">
    </div>

    
    <div class="col-12 col-md-6">
      <label class="form-label fw-bold">JENIS KEGIATAN</label>
      <input name="jenis_kegiatan" class="form-control"
             value="<?php echo e(old('jenis_kegiatan', $report->jenis_kegiatan ?? '')); ?>">
    </div>

    
    <div class="col-12">
      <label class="form-label fw-bold d-block mb-1">WAKTU KEGIATAN</label>
      <div class="row g-3">
        <div class="col-12 col-md-4">
          <label class="form-label">Hari</label>
          <input name="hari" class="form-control" placeholder="Senin"
                 value="<?php echo e(old('hari', $report->hari ?? '')); ?>">
        </div>
        <div class="col-12 col-md-4">
          <label class="form-label">Tgl</label>
          <input type="date" name="tanggal" class="form-control"
                 value="<?php echo e(old('tanggal', isset($report->tanggal) ? $report->tanggal->format('Y-m-d') : '')); ?>">
        </div>
        <div class="col-12 col-md-4">
          <label class="form-label">Pukul</label>
          <input name="pukul" class="form-control" placeholder="08:30–10:00"
                 value="<?php echo e(old('pukul', $report->pukul ?? '')); ?>">
        </div>
      </div>
    </div>

    
    <div class="col-12">
      <label class="form-label fw-bold">LOKASI KEGIATAN</label>
      <input name="lokasi_kegiatan" class="form-control"
             value="<?php echo e(old('lokasi_kegiatan', $report->lokasi_kegiatan ?? '')); ?>">
    </div>

    
    <div class="col-12">
      <label class="form-label fw-bold">HASIL KEGIATAN</label>
      <textarea name="hasil_kegiatan" rows="4" class="form-control"><?php echo e(old('hasil_kegiatan', $report->hasil_kegiatan ?? '')); ?></textarea>
    </div>

    
    <div class="col-12">
      <label class="form-label fw-bold">UNSUR YANG TERLIBAT</label>
      <textarea name="unsur_yang_terlibat" rows="3" class="form-control"
        placeholder="Contoh: BPBD, TNI, Polri, Relawan, Perangkat Desa, dsb."><?php echo e(old('unsur_yang_terlibat', $report->unsur_yang_terlibat ?? '')); ?></textarea>
    </div>

    
    <div class="col-12">
      <label class="form-label fw-bold">PETUGAS</label>
      <input name="petugas" class="form-control" placeholder="Nama dipisah koma"
             value="<?php echo e(old('petugas', $report->petugas ?? '')); ?>">
    </div>

    
    <div class="col-12">
      <label class="form-label fw-bold">DOKUMENTASI (boleh multiple)</label>
      <input type="file" name="dokumentasi[]" accept="image/*" class="form-control" multiple>
    </div>

    
    <?php if($isEdit && !empty($report->dokumentasi)): ?>
      <div class="col-12">
        <label class="form-label d-block mb-2">Dokumentasi saat ini</label>
        <div class="d-flex flex-wrap gap-3">
          <?php $__currentLoopData = $report->dokumentasi; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="border rounded p-2 text-center">
              <img src="<?php echo e(asset('storage/'.$p)); ?>" style="height:80px" class="d-block mb-2">
              <label class="form-check">
                <input type="checkbox" class="form-check-input" name="hapus_foto[]" value="<?php echo e($p); ?>">
                <span class="form-check-label">Hapus</span>
              </label>
            </div>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
      </div>
    <?php endif; ?>

    <div class="col-12 d-flex gap-2">
      <a href="<?php echo e(route(strtolower($ctx).'.lap-kegiatan.index')); ?>" class="btn btn-light">Batal</a>
      <button class="btn btn-primary"><?php echo e($isEdit ? 'Simpan Perubahan' : 'Simpan'); ?></button>
    </div>
  </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app_admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\BPBD\resources\views/role/lap-kegiatan/form.blade.php ENDPATH**/ ?>