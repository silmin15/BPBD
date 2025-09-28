

<?php $__env->startSection('title', 'Beranda'); ?>


<?php $__env->startSection('content'); ?>
    
    <section class="py-5" style="background: linear-gradient(135deg,#ED1C24 0%,#283891 60%,#FF883A 100%);">
        <div class="container text-center text-white">
            <img src="<?php echo e(asset('images/logo-bpbd.png')); ?>" alt="BPBD" class="mb-3" style="height:72px">
            <h1 class="mb-1 fw-bold">BPBD Banjarnegara</h1>
            <p class="mb-0">Sistem informasi terintegrasi untuk monitoring, penanggulangan, dan manajemen bencana dengan teknologi GIS modern.</p>
        </div>
    </section>

    <div class="container my-4">

        
        <div class="row g-3 mb-4 row-cols-1 row-cols-md-3 row-cols-lg-6">
            <div class="col">
                <div class="card kpi-card p-3">
                    <div class="kpi-label">Bencana</div>
                    <div class="kpi-value"><?php echo e(number_format($stats['bencana'] ?? 0)); ?></div>
                </div>
            </div>
            <div class="col">
                <div class="card kpi-card p-3">
                    <div class="kpi-label">Meninggal Dunia</div>
                    <div class="kpi-value"><?php echo e(number_format($stats['meninggal'] ?? 0)); ?></div>
                </div>
            </div>
            <div class="col">
                <div class="card kpi-card p-3">
                    <div class="kpi-label">Hilang</div>
                    <div class="kpi-value"><?php echo e(number_format($stats['hilang'] ?? 0)); ?></div>
                </div>
            </div>
            <div class="col">
                <div class="card kpi-card p-3">
                    <div class="kpi-label">Luka-luka</div>
                    <div class="kpi-value"><?php echo e(number_format($stats['luka'] ?? 0)); ?></div>
                </div>
            </div>
            <div class="col">
                <div class="card kpi-card p-3">
                    <div class="kpi-label">Mengungsi</div>
                    <div class="kpi-value"><?php echo e(number_format($stats['mengungsi'] ?? 0)); ?></div>
                </div>
            </div>
            <div class="col">
                <div class="card kpi-card p-3">
                    <div class="kpi-label">Menderita</div>
                    <div class="kpi-value"><?php echo e(number_format($stats['menderita'] ?? 0)); ?></div>
                </div>
            </div>
        </div>

        
        <div class="map-preview mb-5">
            
            <img class="map-img" src="<?php echo e(asset('images/map-preview.jpg')); ?>" alt="Peta Bencana (Preview)">
            <a href="<?php echo e(route('peta.publik')); ?>" class="overlay">
                <span class="btn-view">Baca selengkapnya →</span>
            </a>
        </div>

        
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="h5 section-title mb-0">Sosialisasi / Berita Terbaru</h2>
            <?php if(Route::has('sosialisasi.publik.index')): ?>
                <a href="<?php echo e(route('sosialisasi.publik.index')); ?>" class="btn btn-sm btn-outline-primary">Lihat semua</a>
            <?php endif; ?>
        </div>

        <div class="row g-3">
            <?php $__empty_1 = true; $__currentLoopData = $news; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="col-md-4">
                    <a href="<?php echo e($item['url']); ?>" class="text-decoration-none text-reset">
                        <div class="card news-card">
                            <img class="news-thumb" src="<?php echo e($item['thumb'] ?? asset('images/news-default.jpg')); ?>"
                                alt="thumb">
                            <div class="card-body">
                                <div class="small text-muted mb-1">
                                    <?php echo e(\Illuminate\Support\Carbon::parse($item['date'])->translatedFormat('d M Y')); ?></div>
                                <div class="news-title"><?php echo e($item['title']); ?></div>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="col-12">
                    <div class="alert alert-light border">Belum ada berita.</div>
                </div>
            <?php endif; ?>
        </div>

    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app_publik', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\BPBD\resources\views/pages/publik/home.blade.php ENDPATH**/ ?>