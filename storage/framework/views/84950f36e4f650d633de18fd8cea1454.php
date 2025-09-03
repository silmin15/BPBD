<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'submitRoute' => '#',
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
    'submitRoute' => '#',
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<div id="filter-overlay" class="bpbd-overlay" aria-hidden="true" hidden>
    <div class="bpbd-modal" role="dialog" aria-modal="true" aria-labelledby="lkFilterTitle">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <h5 id="lkFilterTitle" class="m-0">
                <i class="bi bi-funnel"></i> Filter Laporan Kegiatan
            </h5>
            <button type="button" class="btn-close" id="close-filter" aria-label="Tutup"></button>
        </div>

        <form method="GET" action="<?php echo e($submitRoute); ?>" id="filter-form">
            <div class="row g-2">
                <div class="col-md-6">
                    <label class="form-label">Tanggal mulai</label>
                    <input type="date" name="start_date" class="form-control" value="<?php echo e(request('start_date')); ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Tanggal sampai</label>
                    <input type="date" name="end_date" class="form-control" value="<?php echo e(request('end_date')); ?>">
                </div>

                <div class="col-md-4">
                    <label class="form-label">Jenis kegiatan</label>
                    <input type="text" name="jenis" class="form-control" placeholder="Contoh: evakuasi"
                        value="<?php echo e(request('jenis')); ?>">
                </div>

                <div class="col-md-4">
                    <label class="form-label">Lokasi</label>
                    <input type="text" name="lokasi" class="form-control" placeholder="Dusun / Desa / Kec."
                        value="<?php echo e(request('lokasi')); ?>">
                </div>

                <div class="col-md-4">
                    <label class="form-label">Petugas</label>
                    <input type="text" name="petugas" class="form-control" placeholder="Nama petugas"
                        value="<?php echo e(request('petugas')); ?>">
                </div>
            </div>

            <div class="d-flex justify-content-between mt-3">
                <a href="<?php echo e($submitRoute); ?>" class="btn btn-light">Reset</a>
                <div>
                    <button type="button" class="btn btn-outline-secondary me-2" id="cancel-filter">Batal</button>
                    <button class="btn btn-primary">Terapkan</button>
                </div>
            </div>
        </form>
    </div>
</div>
<?php /**PATH C:\laragon\www\BPBD\resources\views/components/lap-kegiatan/filter-overlay.blade.php ENDPATH**/ ?>