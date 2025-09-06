

<?php $__env->startSection('title','Dashboard PK'); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
  <h1 class="mb-3">Dashboard PK</h1>
  <div class="alert alert-info">Selamat datang, tim PK!</div>

  
  <div class="row g-3">
    <div class="col-md-4">
      <div class="card shadow-sm">
        <div class="card-body">
          <h5 class="card-title mb-2">Ringkasan Hari Ini</h5>
          <p class="mb-0 text-muted">Isi dengan metrik PK…</p>
        </div>
      </div>
    </div>
    
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app_admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\BPBD\resources\views/role/pk/dashboard.blade.php ENDPATH**/ ?>