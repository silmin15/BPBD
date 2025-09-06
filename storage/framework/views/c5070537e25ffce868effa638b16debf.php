<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['variant'=>'info','closable'=>true]));

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

foreach (array_filter((['variant'=>'info','closable'=>true]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<div <?php echo e($attributes->merge(['class'=>"ui-alert ui-alert--$variant"])); ?>>
  <div class="ui-alert__content">
    <?php echo e($slot); ?>

  </div>
  <?php if($closable): ?>
    <button type="button" class="ui-alert__close" onclick="this.closest('.ui-alert').remove()">✕</button>
  <?php endif; ?>
</div>
<?php /**PATH C:\laragon\www\BPBD\resources\views/components/ui/alert.blade.php ENDPATH**/ ?>