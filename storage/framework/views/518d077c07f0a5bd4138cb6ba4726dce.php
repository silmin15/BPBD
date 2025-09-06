<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'year',
    'filters' => [],
    'klList' => collect(),
    'submitRoute',
    'pdfRoute',
    'openBtnId' => 'open-filter',
    'closeBtnId' => 'close-filter',
]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter(([
    'year',
    'filters' => [],
    'klList' => collect(),
    'submitRoute',
    'pdfRoute',
    'openBtnId' => 'open-filter',
    'closeBtnId' => 'close-filter',
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<div id="filter-overlay" class="bpbd-overlay" aria-hidden="true" hidden>
    <div class="bpbd-modal" role="dialog" aria-modal="true" aria-labelledby="filterTitle">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <h5 id="filterTitle" class="m-0"><i class="bi bi-funnel"></i> Filter Rekap Logistik</h5>
            <button type="button" class="btn-close" id="<?php echo e($closeBtnId); ?>" aria-label="Tutup"></button>
        </div>

        <form method="GET" action="<?php echo e($submitRoute); ?>" id="filter-form">
            <div class="row g-2">
                <div class="col-md-3">
                    <label class="form-label">Tanggal mulai</label>
                    <input type="date" name="start_date" class="form-control"
                        value="<?php echo e($filters['start'] ?? ($filters['start_date'] ?? '')); ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Tanggal sampai</label>
                    <input type="date" name="end_date" class="form-control"
                        value="<?php echo e($filters['end'] ?? ($filters['end_date'] ?? '')); ?>">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Bulan dari</label>
                    <input type="number" min="1" max="12" name="month_from" class="form-control"
                        value="<?php echo e(request('month_from')); ?>">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Bulan sampai</label>
                    <input type="number" min="1" max="12" name="month_to" class="form-control"
                        value="<?php echo e(request('month_to')); ?>">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Stok</label>
                    <select name="stok" class="form-select">
                        <option value="">— Semua —</option>
                        <option value="ada" <?php if(request('stok') === 'ada'): echo 'selected'; endif; ?>>Masih ada</option>
                        <option value="habis"<?php if(request('stok') === 'habis'): echo 'selected'; endif; ?>>Habis</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">KL (Penginput)</label>
                    <select name="kl_id" class="form-select">
                        <option value="">— Semua —</option>
                        <?php $__currentLoopData = $klList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($kl->id); ?>" <?php if(request('kl_id') == $kl->id): echo 'selected'; endif; ?>><?php echo e($kl->name); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Kata kunci</label>
                    <input type="text" name="q" class="form-control" placeholder="Nama barang / satuan"
                        value="<?php echo e(request('q')); ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Urutkan</label>
                    <select name="sort" class="form-select">
                        <option value="tanggal_asc" <?php if(request('sort') === 'tanggal_asc'): echo 'selected'; endif; ?>>Tanggal ↑</option>
                        <option value="tanggal_desc" <?php if(request('sort') === 'tanggal_desc'): echo 'selected'; endif; ?>>Tanggal ↓</option>
                        <option value="nama_asc" <?php if(request('sort') === 'nama_asc'): echo 'selected'; endif; ?>>Nama A→Z</option>
                        <option value="nama_desc" <?php if(request('sort') === 'nama_desc'): echo 'selected'; endif; ?>>Nama Z→A</option>
                    </select>
                </div>
            </div>

            <div class="d-flex justify-content-between mt-3">
                <a href="<?php echo e($submitRoute); ?>" class="btn btn-light">Reset</a>
                <div>
                    <button type="button" class="btn btn-outline-secondary me-2" id="cancel-filter">Batal</button>
                    <button class="btn btn-primary">Terapkan Filter</button>
                    <button type="button" class="btn btn-success ms-2" id="apply-print"
                        data-pdf-url="<?php echo e($pdfRoute); ?>">
                        <i class="bi bi-printer"></i> Terapkan & Cetak
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<?php /**PATH C:\laragon\www\BPBD\resources\views/components/logistik/filter-overlay.blade.php ENDPATH**/ ?>