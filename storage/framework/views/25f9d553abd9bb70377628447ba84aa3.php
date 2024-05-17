<!-- Modal Edit -->
<div class="modal fade" id="modalEdit<?php echo e($role->id); ?>" tabindex="-1" role="dialog" aria-labelledby="modalEdit<?php echo e($role->id); ?>Label" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Role and Permissions</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?php echo e(route('roles.update', $role)); ?>" method="POST" class="form">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name" class="col-form-label">Role Name:</label>
                        <input type="text" value="<?php echo e($role->name); ?>" class="form-control" name="name" id="name" aria-describedby="name-error" aria-invalid="true">
                    </div>
                    <div class="form-group">
                        <label for="permissions" class="col-form-label" title="Select All Permissions">
                            Permissions List:
                            <input type="checkbox" onchange="selAll(this)">
                        </label>
                        <div class="custom-table">
                            <?php $__currentLoopData = $permissions->chunk(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $chunk): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="custom-row">
                                    <?php $__currentLoopData = $chunk; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="custom-cell">
                                            <div class="form-check">
                                                <input class="form-check-input permission-checkbox" type="checkbox" name="permissions[]" value="<?php echo e($permission->id); ?>" <?php echo e($role->hasPermissionTo($permission->id) ? 'checked' : ''); ?>>
                                                <label class="form-check-label"><?php echo e($permission->name); ?></label>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Edit Roles')): ?>
                    <button type="reset" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Delete -->
<div class="modal fade" id="modalDelete<?php echo e($role->id); ?>" tabindex="-1" aria-labelledby="modalDelete<?php echo e($role->id); ?>Label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fs-5" id="modalDelete<?php echo e($role->id); ?>Label">Delete Role</h1>
            </div>
            <div class="modal-body">
                Are you sure to delete the role <?php echo e($role->name); ?>?
            </div>
            <div class="modal-footer">
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Delete Roles')): ?>
                <form action="<?php echo e(route('roles.destroy', $role )); ?>" method="POST" class="d-inline">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div><?php /**PATH /home/pos-demo-admin/htdocs/www.pos-demo.online/resources/views/security/roles/modals.blade.php ENDPATH**/ ?>