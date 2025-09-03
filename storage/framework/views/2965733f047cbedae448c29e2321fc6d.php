<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'id' => 'searchbar',
    'placeholder' => 'Pencarian',
    'value' => '',
    'showFilter' => false,
    'filterTarget' => null, // contoh: '#offcanvasFilter'
    'action' => null, // opsi: submit ke route
    'method' => 'GET', // GET/POST
    'debounce' => 350, // ms (untuk event input real-time)
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
    'id' => 'searchbar',
    'placeholder' => 'Pencarian',
    'value' => '',
    'showFilter' => false,
    'filterTarget' => null, // contoh: '#offcanvasFilter'
    'action' => null, // opsi: submit ke route
    'method' => 'GET', // GET/POST
    'debounce' => 350, // ms (untuk event input real-time)
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<form id="<?php echo e($id); ?>" role="search" data-debounce="<?php echo e($debounce); ?>"
    <?php echo e($attributes->merge(['class' => 'searchbar'])); ?>

    <?php if($action): ?> action="<?php echo e($action); ?>" method="<?php echo e($method); ?>" <?php endif; ?>>
    <?php if($showFilter && $filterTarget): ?>
        <button class="searchbar__btn searchbar__btn--ghost" type="button" data-bs-toggle="offcanvas"
            data-bs-target="<?php echo e($filterTarget); ?>" aria-label="Buka filter">
            <i class="bi bi-list"></i>
        </button>
    <?php endif; ?>

    <input class="searchbar__input" type="search" name="q" value="<?php echo e($value); ?>"
        placeholder="<?php echo e($placeholder); ?>" autocomplete="off" />

    <button class="searchbar__btn" type="submit" aria-label="Cari">
        <i class="bi bi-search"></i>
    </button>
</form>
<?php /**PATH C:\laragon\www\BPBD\resources\views/components/ui/search-bar.blade.php ENDPATH**/ ?>