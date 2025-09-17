


<?php $__env->startSection('page_title', 'Manajemen User'); ?>
<?php $__env->startSection('page_icon'); ?> <i class="bi bi-people-fill"></i> <?php $__env->stopSection(); ?>


<?php $__env->startSection('page_actions'); ?>
    <button type="button" class="btn btn-success d-inline-flex align-items-center gap-2" data-bs-toggle="modal"
        data-bs-target="#createUserModal" aria-label="Buat user baru">
        <i class="bi bi-plus-lg"></i><span>Buat User</span>
    </button>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    
    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
            <?php echo e(session('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>
    <?php if(session('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
            <?php echo e(session('error')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    
    <div class="card shadow-sm">

        
        

        
        <div class="table-responsive">
            <table class="table table-hover table-striped align-middle mb-0">
                <thead class="table-light sticky-top">
                    <tr>
                        <th style="width:72px" class="text-center">#</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th style="width:220px">Role</th>
                        <th style="width:220px" class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td class="text-center"><?php echo e($users->firstItem() + $i); ?></td>
                            <td class="fw-semibold"><?php echo e($u->name); ?></td>
                            <td><?php echo e($u->email); ?></td>
                            <td>
                                <?php $rolesText = $u->getRoleNames()->join(', '); ?>
                                <span class="badge text-bg-primary-subtle text-primary"><?php echo e($rolesText ?: '—'); ?></span>
                            </td>
                            <td class="text-end">
                                <a href="<?php echo e(route('admin.manajemen-user.edit', $u)); ?>"
                                    class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>

                                <form action="<?php echo e(route('admin.manajemen-user.destroy', $u)); ?>" method="POST"
                                    class="d-inline" onsubmit="return confirm('Hapus user ini?')">
                                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">Belum ada user.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        
        <div class="card-footer bg-white d-flex flex-column flex-md-row justify-content-between align-items-center">
            <?php $total = method_exists($users, 'total') ? $users->total() : $users->count(); ?>
            <small class="text-muted mb-2 mb-md-0">
                Menampilkan <?php echo e($users->count() ? $users->firstItem() . '–' . $users->lastItem() : 0); ?> dari <?php echo e($total); ?>

                data
            </small>
            <?php echo e($users->withQueryString()->onEachSide(1)->links()); ?>

        </div>
    </div>

    
    <div class="modal fade" id="createUserModal" tabindex="-1" aria-labelledby="createUserModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createUserModalLabel">Buat User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>

                <form method="POST" action="<?php echo e(route('admin.manajemen-user.store')); ?>" novalidate>
                    <?php echo csrf_field(); ?>
                    <div class="modal-body">
                        <?php if($errors->createUser->any()): ?>
                            <div class="alert alert-danger">Periksa kembali isian Anda.</div>
                        <?php endif; ?>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Nama</label>
                                <input name="name" class="form-control <?php $__errorArgs = ['name', 'createUser'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    value="<?php echo e(old('name')); ?>" required>
                                <?php $__errorArgs = ['name', 'createUser'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input name="email" type="email"
                                    class="form-control <?php $__errorArgs = ['email', 'createUser'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    value="<?php echo e(old('email')); ?>" required>
                                <?php $__errorArgs = ['email', 'createUser'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Username (opsional)</label>
                                <input name="username"
                                    class="form-control <?php $__errorArgs = ['username', 'createUser'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    value="<?php echo e(old('username')); ?>">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">No. HP (opsional)</label>
                                <input name="phone"
                                    class="form-control <?php $__errorArgs = ['phone', 'createUser'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    value="<?php echo e(old('phone')); ?>">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Password</label>
                                <input name="password" type="password"
                                    class="form-control <?php $__errorArgs = ['password', 'createUser'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Konfirmasi Password</label>
                                <input name="password_confirmation" type="password" class="form-control" required>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Role</label>
                                <select name="role" class="form-select <?php $__errorArgs = ['role', 'createUser'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    required>
                                    <option value="" disabled <?php echo e(old('role') ? '' : 'selected'); ?>>Pilih role
                                    </option>
                                    <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if(in_array($name, ['PK', 'KL', 'RR', 'Staf BPBD'])): ?>
                                            <option value="<?php echo e($name); ?>" <?php if(old('role') === $name): echo 'selected'; endif; ?>>
                                                <?php echo e($name); ?></option>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    
    <?php if($errors->createUser->any()): ?>
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const el = document.getElementById('createUserModal');
                if (!el) return;
                const modal = new bootstrap.Modal(el);
                modal.show();
                setTimeout(() => {
                    const firstInvalid = el.querySelector('.is-invalid');
                    if (firstInvalid) firstInvalid.focus();
                }, 300);
            });
        </script>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app_admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\BPBD\resources\views/role/admin/manajemen-user/index.blade.php ENDPATH**/ ?>