
<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'align' => 'end', // start | center | end | between
    'stack' => false, // true => tombol vertikal (mobile)
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
    'align' => 'end', // start | center | end | between
    'stack' => false, // true => tombol vertikal (mobile)
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    $justify =
        [
            'start' => 'justify-content-start',
            'center' => 'justify-content-center',
            'end' => 'justify-content-end',
            'between' => 'justify-content-between',
        ][$align] ?? 'justify-content-end';

    $base = $stack ? 'd-grid gap-2' : "d-flex gap-2 $justify";
?>

<div <?php echo e($attributes->merge(['class' => "form-actions $base"])); ?>>
    <?php echo e($slot); ?>

</div>
<?php /**PATH C:\laragon\www\BPBD\resources\views/components/form/actions.blade.php ENDPATH**/ ?>