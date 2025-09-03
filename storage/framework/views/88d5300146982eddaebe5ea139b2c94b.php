
<div class="modal fade" id="loginModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content login-glass rounded-lg shadow-soft">
            <div class="modal-body p-4 p-lg-5 text-black">

                
                <div class="text-center mb-4">
                    <img src="<?php echo e(asset('images/logo-bpbd.png')); ?>" alt="Logo BPBD" style="width:90px;height:auto;"
                        class="mx-auto mb-2">
                    <h4 class="fw-bold mb-1">BPBD Banjarnegara</h4>
                    <p class="text-muted small">Melayani masyarakat dalam penanggulangan bencana dengan sistem informasi
                        terintegrasi.</p>
                </div>

                
                <form id="loginFormModal" method="POST" action="<?php echo e(route('login')); ?>" novalidate>
                    <?php echo csrf_field(); ?>
                    
                    
                    <?php if (isset($component)) { $__componentOriginal115fead9001cb250833bb983c7be3f11 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal115fead9001cb250833bb983c7be3f11 = $attributes; } ?>
<?php $component = App\View\Components\Form\Group::resolve(['for' => 'emailModal','label' => 'Username / E-mail'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.group'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Form\Group::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
                        <?php if (isset($component)) { $__componentOriginalc1d2405c7f8100d77292f2d0299ccd96 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc1d2405c7f8100d77292f2d0299ccd96 = $attributes; } ?>
<?php $component = App\View\Components\Form\Input::resolve(['name' => 'email','type' => 'email','placeholder' => 'user123 atau user@mail.com'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Form\Input::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'emailModal','required' => true,'autofocus' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc1d2405c7f8100d77292f2d0299ccd96)): ?>
<?php $attributes = $__attributesOriginalc1d2405c7f8100d77292f2d0299ccd96; ?>
<?php unset($__attributesOriginalc1d2405c7f8100d77292f2d0299ccd96); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc1d2405c7f8100d77292f2d0299ccd96)): ?>
<?php $component = $__componentOriginalc1d2405c7f8100d77292f2d0299ccd96; ?>
<?php unset($__componentOriginalc1d2405c7f8100d77292f2d0299ccd96); ?>
<?php endif; ?>
                        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <?php if (isset($component)) { $__componentOriginal024700bb3b1afbadbf97b6cf5efa18f3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal024700bb3b1afbadbf97b6cf5efa18f3 = $attributes; } ?>
<?php $component = App\View\Components\Ui\Alert::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.alert'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Ui\Alert::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'danger','class' => 'mt-1 small']); ?><?php echo e($message); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal024700bb3b1afbadbf97b6cf5efa18f3)): ?>
<?php $attributes = $__attributesOriginal024700bb3b1afbadbf97b6cf5efa18f3; ?>
<?php unset($__attributesOriginal024700bb3b1afbadbf97b6cf5efa18f3); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal024700bb3b1afbadbf97b6cf5efa18f3)): ?>
<?php $component = $__componentOriginal024700bb3b1afbadbf97b6cf5efa18f3; ?>
<?php unset($__componentOriginal024700bb3b1afbadbf97b6cf5efa18f3); ?>
<?php endif; ?>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal115fead9001cb250833bb983c7be3f11)): ?>
<?php $attributes = $__attributesOriginal115fead9001cb250833bb983c7be3f11; ?>
<?php unset($__attributesOriginal115fead9001cb250833bb983c7be3f11); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal115fead9001cb250833bb983c7be3f11)): ?>
<?php $component = $__componentOriginal115fead9001cb250833bb983c7be3f11; ?>
<?php unset($__componentOriginal115fead9001cb250833bb983c7be3f11); ?>
<?php endif; ?>

                    
                    <?php if (isset($component)) { $__componentOriginal115fead9001cb250833bb983c7be3f11 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal115fead9001cb250833bb983c7be3f11 = $attributes; } ?>
<?php $component = App\View\Components\Form\Group::resolve(['for' => 'passwordModal','label' => 'Password','class' => 'mt-3'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.group'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Form\Group::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
                        <?php if (isset($component)) { $__componentOriginalc1d2405c7f8100d77292f2d0299ccd96 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc1d2405c7f8100d77292f2d0299ccd96 = $attributes; } ?>
<?php $component = App\View\Components\Form\Input::resolve(['name' => 'password','type' => 'password','placeholder' => '••••••••'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Form\Input::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'passwordModal','required' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc1d2405c7f8100d77292f2d0299ccd96)): ?>
<?php $attributes = $__attributesOriginalc1d2405c7f8100d77292f2d0299ccd96; ?>
<?php unset($__attributesOriginalc1d2405c7f8100d77292f2d0299ccd96); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc1d2405c7f8100d77292f2d0299ccd96)): ?>
<?php $component = $__componentOriginalc1d2405c7f8100d77292f2d0299ccd96; ?>
<?php unset($__componentOriginalc1d2405c7f8100d77292f2d0299ccd96); ?>
<?php endif; ?>
                        <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <?php if (isset($component)) { $__componentOriginal024700bb3b1afbadbf97b6cf5efa18f3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal024700bb3b1afbadbf97b6cf5efa18f3 = $attributes; } ?>
<?php $component = App\View\Components\Ui\Alert::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.alert'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Ui\Alert::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'danger','class' => 'mt-1 small']); ?><?php echo e($message); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal024700bb3b1afbadbf97b6cf5efa18f3)): ?>
<?php $attributes = $__attributesOriginal024700bb3b1afbadbf97b6cf5efa18f3; ?>
<?php unset($__attributesOriginal024700bb3b1afbadbf97b6cf5efa18f3); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal024700bb3b1afbadbf97b6cf5efa18f3)): ?>
<?php $component = $__componentOriginal024700bb3b1afbadbf97b6cf5efa18f3; ?>
<?php unset($__componentOriginal024700bb3b1afbadbf97b6cf5efa18f3); ?>
<?php endif; ?>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal115fead9001cb250833bb983c7be3f11)): ?>
<?php $attributes = $__attributesOriginal115fead9001cb250833bb983c7be3f11; ?>
<?php unset($__attributesOriginal115fead9001cb250833bb983c7be3f11); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal115fead9001cb250833bb983c7be3f11)): ?>
<?php $component = $__componentOriginal115fead9001cb250833bb983c7be3f11; ?>
<?php unset($__componentOriginal115fead9001cb250833bb983c7be3f11); ?>
<?php endif; ?>

                    
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember_me">
                            <label class="form-check-label" for="remember_me">Ingat saya</label>
                        </div>
                        <a href="<?php echo e(route('password.request')); ?>" class="login-forgot">Lupa kata sandi?</a>
                    </div>

                    
                    <?php if (isset($component)) { $__componentOriginal91361259c52fab60e09492f897c10333 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal91361259c52fab60e09492f897c10333 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.form.actions','data' => ['class' => 'mt-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.actions'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mt-4']); ?>
                        <?php if (isset($component)) { $__componentOriginal238d5211cc9d80261ec96f21f6b79bb3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal238d5211cc9d80261ec96f21f6b79bb3 = $attributes; } ?>
<?php $component = App\View\Components\Ui\Button::resolve(['variant' => 'footer'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Ui\Button::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'submit','class' => 'w-100']); ?>
                            Login
                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal238d5211cc9d80261ec96f21f6b79bb3)): ?>
<?php $attributes = $__attributesOriginal238d5211cc9d80261ec96f21f6b79bb3; ?>
<?php unset($__attributesOriginal238d5211cc9d80261ec96f21f6b79bb3); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal238d5211cc9d80261ec96f21f6b79bb3)): ?>
<?php $component = $__componentOriginal238d5211cc9d80261ec96f21f6b79bb3; ?>
<?php unset($__componentOriginal238d5211cc9d80261ec96f21f6b79bb3); ?>
<?php endif; ?>
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal91361259c52fab60e09492f897c10333)): ?>
<?php $attributes = $__attributesOriginal91361259c52fab60e09492f897c10333; ?>
<?php unset($__attributesOriginal91361259c52fab60e09492f897c10333); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal91361259c52fab60e09492f897c10333)): ?>
<?php $component = $__componentOriginal91361259c52fab60e09492f897c10333; ?>
<?php unset($__componentOriginal91361259c52fab60e09492f897c10333); ?>
<?php endif; ?>
                </form>

            </div>
        </div>
    </div>
</div>
<?php /**PATH C:\laragon\www\BPBD\resources\views/components/ui/modal.blade.php ENDPATH**/ ?>