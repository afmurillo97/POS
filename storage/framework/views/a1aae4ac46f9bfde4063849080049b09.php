<!-- Modal Edit -->
<div class="modal fade" id="modalEdit<?php echo e($user->id); ?>" tabindex="-1" role="dialog" aria-labelledby="modalEdit<?php echo e($user->id); ?>Label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?php echo e(route('users.update', $user)); ?>" method="POST" class="form">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="role_id" class="col-form-label">Role:</label>
                        <select name="role_id" id="role_id" class="form-control">
                            <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($role->id); ?>" <?php echo e($user->hasAnyRole($role->id) ? 'selected' : ''); ?>>
                                    <?php echo e($role->name); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-form-label">Name:</label>
                        <input type="text" value="<?php echo e($user->name); ?>" class="form-control" name="name" id="name" aria-describedby="name-error" aria-invalid="true">
                    </div>
                    <div class="form-group">
                        <label for="email" class="col-form-label">Email</label>
                        <input type="email" value="<?php echo e($user->email); ?>" name="email" id="email" class="form-control" aria-describedby="email-error" aria-invalid="true">
                    </div>
                    <div class="form-group">
                        <label for="password" class="col-form-label">Password:</label>
                        <input type="password" name="password" id="password" class="form-control" aria-describedby="password-error" aria-invalid="true">
                    </div>
                </div>
                <div class="modal-footer">
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Edit Users')): ?>
                    <button type="reset" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Delete -->
<div class="modal fade" id="modalDelete<?php echo e($user->id); ?>" tabindex="-1" aria-labelledby="modalDelete<?php echo e($user->id); ?>Label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fs-5" id="modalDelete<?php echo e($user->id); ?>Label">Delete User</h1>
            </div>
            <div class="modal-body">
                Are you sure to delete the user <?php echo e($user->name); ?>?
            </div>
            <div class="modal-footer">
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Delete Users')): ?>
                <form action="<?php echo e(route('users.destroy', $user )); ?>" method="POST" class="d-inline">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div><?php /**PATH /home/pos-demo-admin/htdocs/www.pos-demo.online/resources/views/security/users/modals.blade.php ENDPATH**/ ?>