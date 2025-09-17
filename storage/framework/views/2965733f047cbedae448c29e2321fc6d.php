<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'id' => 'searchbar',
    'placeholder' => 'Pencarian',
    'value' => '',
    'name' => 'q',
    'showFilter' => false,
    'filterTarget' => null, // contoh: '#offcanvasFilter'
    'action' => null, // URL untuk submit (opsional)
    'method' => 'GET', // GET/POST/PUT/PATCH/DELETE
    'debounce' => 350, // ms (untuk JS input debounce, kalau ada)
    'size' => 'md', // 'md' | 'nav' (kecil untuk navbar)
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
    'name' => 'q',
    'showFilter' => false,
    'filterTarget' => null, // contoh: '#offcanvasFilter'
    'action' => null, // URL untuk submit (opsional)
    'method' => 'GET', // GET/POST/PUT/PATCH/DELETE
    'debounce' => 350, // ms (untuk JS input debounce, kalau ada)
    'size' => 'md', // 'md' | 'nav' (kecil untuk navbar)
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    $method = strtoupper($method ?? 'GET');
    // class dasar + varian ukuran
    $classes = 'searchbar' . ($size === 'nav' ? ' searchbar--nav' : '');
?>

<form id="<?php echo e($id); ?>" role="search" data-debounce="<?php echo e($debounce); ?>"
    <?php echo e($attributes->merge(['class' => $classes])); ?>

    <?php if($action): ?> action="<?php echo e($action); ?>" method="<?php echo e(in_array($method, ['GET', 'POST']) ? $method : 'POST'); ?>" <?php endif; ?>>

    
    <?php if($action && !in_array($method, ['GET', 'POST'])): ?>
        <?php echo method_field($method); ?>
    <?php endif; ?>
    <?php if($action && ($method === 'POST' || !in_array($method, ['GET', 'POST']))): ?>
        <?php echo csrf_field(); ?>
    <?php endif; ?>

    <?php if($showFilter && $filterTarget): ?>
        <button class="searchbar__btn searchbar__btn--ghost" type="button" data-bs-toggle="offcanvas"
            data-bs-target="<?php echo e($filterTarget); ?>" aria-controls="<?php echo e(ltrim($filterTarget, '#')); ?>" aria-label="Buka filter">
            <i class="bi bi-sliders"></i>
        </button>
    <?php endif; ?>

    <input class="searchbar__input" type="search" name="<?php echo e($name); ?>" value="<?php echo e($value); ?>"
        placeholder="<?php echo e($placeholder); ?>" autocomplete="off" aria-label="Kolom pencarian">

    <button class="searchbar__btn" type="submit" aria-label="Cari">
        <i class="bi bi-search"></i>
    </button>
</form>
<?php /**PATH C:\laragon\www\BPBD\resources\views/components/ui/search-bar.blade.php ENDPATH**/ ?>