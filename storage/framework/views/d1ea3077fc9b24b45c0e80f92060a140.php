

<?php $__env->startSection('title', "Rekap Logistik Tahun $year"); ?>
<?php $__env->startSection('page_title', "Rekap Logistik Tahun $year"); ?>
<?php $__env->startSection('page_icon'); ?> <i class="bi bi-file-bar-graph"></i> <?php $__env->stopSection(); ?>
<?php $__env->startSection('page_actions'); ?>
    <button type="button" class="btn-blue" id="open-filter">
        <i class="bi bi-funnel"></i> Filter
    </button>
    <button type="submit" class="btn-gray" id="top-print-selected" form="form-selected" formtarget="_blank" disabled>
        <i class="bi bi-printer"></i> Cetak PDF (Yang Dipilih)
    </button>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-fluid px-0">

        
        <?php if (isset($component)) { $__componentOriginal7fe042c73efdb02c131417d42cf6be48 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7fe042c73efdb02c131417d42cf6be48 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.logistik.filter-overlay','data' => ['year' => $year,'filters' => $filters ?? [],'klList' => $klList,'submitRoute' => route('admin.logistik.rekap', $year),'pdfRoute' => route('admin.logistik.rekap.pdf', $year)]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.logistik.filter-overlay'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['year' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($year),'filters' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($filters ?? []),'kl-list' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($klList),'submit-route' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('admin.logistik.rekap', $year)),'pdf-route' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('admin.logistik.rekap.pdf', $year))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal7fe042c73efdb02c131417d42cf6be48)): ?>
<?php $attributes = $__attributesOriginal7fe042c73efdb02c131417d42cf6be48; ?>
<?php unset($__attributesOriginal7fe042c73efdb02c131417d42cf6be48); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal7fe042c73efdb02c131417d42cf6be48)): ?>
<?php $component = $__componentOriginal7fe042c73efdb02c131417d42cf6be48; ?>
<?php unset($__componentOriginal7fe042c73efdb02c131417d42cf6be48); ?>
<?php endif; ?>

        
        <form method="GET" action="<?php echo e(route('admin.logistik.rekap.pdf', $year)); ?>" target="_blank" id="form-selected"
            class="mb-3">

            
            <?php if (isset($component)) { $__componentOriginalbadcb9bf46a7dd99a40228079d21ca90 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbadcb9bf46a7dd99a40228079d21ca90 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.select-bar','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('select-bar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbadcb9bf46a7dd99a40228079d21ca90)): ?>
<?php $attributes = $__attributesOriginalbadcb9bf46a7dd99a40228079d21ca90; ?>
<?php unset($__attributesOriginalbadcb9bf46a7dd99a40228079d21ca90); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbadcb9bf46a7dd99a40228079d21ca90)): ?>
<?php $component = $__componentOriginalbadcb9bf46a7dd99a40228079d21ca90; ?>
<?php unset($__componentOriginalbadcb9bf46a7dd99a40228079d21ca90); ?>
<?php endif; ?>

            
            <?php $__currentLoopData = $byMonth; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ym => $rows): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if (isset($component)) { $__componentOriginalb62715a7739497cb9109526ec52e7cf6 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb62715a7739497cb9109526ec52e7cf6 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.logistik.month-table','data' => ['ym' => $ym,'rows' => $rows,'sum' => $monthly[$ym] ?? []]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.logistik.month-table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['ym' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($ym),'rows' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($rows),'sum' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($monthly[$ym] ?? [])]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalb62715a7739497cb9109526ec52e7cf6)): ?>
<?php $attributes = $__attributesOriginalb62715a7739497cb9109526ec52e7cf6; ?>
<?php unset($__attributesOriginalb62715a7739497cb9109526ec52e7cf6); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb62715a7739497cb9109526ec52e7cf6)): ?>
<?php $component = $__componentOriginalb62715a7739497cb9109526ec52e7cf6; ?>
<?php unset($__componentOriginalb62715a7739497cb9109526ec52e7cf6); ?>
<?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </form>

        <div class="alert alert-info fw-bold mt-4">
            GRAND TOTAL TAHUN <?php echo e($year); ?> :
            Masuk Rp <?php echo e(number_format($grand['sum_jumlah'], 0, ',', '.')); ?>,
            Keluar Rp <?php echo e(number_format($grand['sum_keluar'], 0, ',', '.')); ?>,
            Sisa Rp <?php echo e(number_format($grand['sum_sisa'], 0, ',', '.')); ?>

        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app_admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\BPBD\resources\views/role/admin/logistik/rekap.blade.php ENDPATH**/ ?>