<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<head>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/js/app_admin.js']); ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <?php echo $__env->yieldPushContent('styles'); ?>

</head>

<body data-scope="admin" data-page="<?php echo e('role/admin/' . str_replace('.', '/', request()->route()->getName())); ?>"
    class="tw-font-sans tw-antialiased">

    
    <?php echo $__env->make('layouts.partials.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    
    <div id="sidebar-backdrop" class="tw-fixed tw-inset-0 tw-bg-black/40 tw-z-30 tw-hidden"></div>

    
    <?php echo $__env->make('layouts.partials.navigation_admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    
    <div id="main-content"
        class="tw-min-h-screen tw-bg-gray-100 tw-flex tw-flex-col tw-transition-[padding] tw-duration-200 tw-ease-in-out md:tw-pl-72">

        
        <header class="tw-px-4 sm:tw-px-6 lg:tw-px-8 tw-pt-4">
            <?php if (! empty(trim($__env->yieldContent('page_title')))): ?>
            <div class="tw-flex tw-items-center tw-justify-between tw-gap-3 tw-flex-wrap">
                <div>
                    <h1 class="tw-flex tw-items-center tw-gap-2 tw-text-xl tw-font-semibold tw-text-slate-800">
                        <?php echo $__env->yieldContent('page_icon'); ?>
                        <?php echo $__env->yieldContent('page_title'); ?>
                    </h1>
                    <?php if (! empty(trim($__env->yieldContent('page_breadcrumb')))): ?>
                    <ol class="breadcrumb tw-text-sm tw-text-slate-500 tw-mt-1">
                        <li class="breadcrumb-item active">
                            <?php echo $__env->yieldContent('page_breadcrumb'); ?>
                        </li>
                    </ol>
                    <?php endif; ?>
                </div>
                <div class="tw-flex tw-items-center tw-gap-2">
                    <?php echo $__env->yieldContent('page_actions'); ?>
                </div>
            </div>
            <?php endif; ?>
        </header>

        
        <main class="tw-flex-1 tw-px-4 sm:tw-px-6 lg:tw-px-8 tw-pb-8 tw-pt-4">
            <?php echo $__env->yieldContent('content'); ?>
        </main>
    </div>
    <?php echo $__env->yieldPushContent('scripts'); ?>

</body>

</html><?php /**PATH C:\laragon\www\BPBD\resources\views/layouts/app_admin.blade.php ENDPATH**/ ?>