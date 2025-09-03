<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'submitRoute' => route('role.kl.logistik.index'),
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
    'submitRoute' => route('role.kl.logistik.index'),
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<div id="filter-overlay" class="bpbd-overlay" aria-hidden="true" hidden>
    <div class="bpbd-modal" role="dialog" aria-modal="true" aria-labelledby="filterKlTitle">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <h5 id="filterKlTitle" class="m-0">
                <i class="bi bi-funnel"></i> Filter Laporan KL
            </h5>
            <button type="button" class="btn-close" id="close-filter" aria-label="Tutup"></button>
        </div>

        <form method="GET" action="<?php echo e($submitRoute); ?>" id="filter-form">
            <div class="row g-2">
                <div class="col-md-6">
                    <label class="form-label">Nama barang / satuan</label>
                    <input type="text" name="q" class="form-control" placeholder="Contoh: beras / dus"
                        value="<?php echo e(request('q')); ?>">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Bulan (opsional)</label>
                    <input type="month" name="month" class="form-control" value="<?php echo e(request('month')); ?>">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Tanggal mulai</label>
                    <input type="date" name="start_date" class="form-control" value="<?php echo e(request('start_date')); ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Tanggal sampai</label>
                    <input type="date" name="end_date" class="form-control" value="<?php echo e(request('end_date')); ?>">
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
<?php /**PATH C:\laragon\www\BPBD\resources\views/components/kl/logistik/filter-overlay.blade.php ENDPATH**/ ?>