<!-- Modal Edit -->
<div class="modal fade" id="modalEdit<?php echo e($category->id); ?>" tabindex="-1" role="dialog" aria-labelledby="modalEdit<?php echo e($category->id); ?>Label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?php echo e(route('categories.update', $category)); ?>" method="POST" class="form">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name" class="col-form-label">Name:</label>
                        <input type="text" value="<?php echo e($category->name); ?>" class="form-control" name="name" id="name" aria-describedby="name-error" aria-invalid="true">
                    </div>
                    <div class="form-group">
                        <label for="description" class="col-form-label">Description:</label>
                        <textarea class="form-control" name="description" id="description"><?php echo e($category->description); ?></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Edit Categories')): ?>
                    <button type="reset" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Delete -->
<div class="modal fade" id="modalDelete<?php echo e($category->id); ?>" tabindex="-1" aria-labelledby="modalDelete<?php echo e($category->id); ?>Label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fs-5" id="modalDelete<?php echo e($category->id); ?>Label">Delete Category</h1>
            </div>
            <div class="modal-body">
                Are you sure to delete the category <?php echo e($category->name); ?>?
            </div>
            <div class="modal-footer">
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Delete Categories')): ?>
                <form action="<?php echo e(route('categories.destroy', $category )); ?>" method="POST" class="d-inline">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div><?php /**PATH /home/pos-demo-admin/htdocs/www.pos-demo.online/resources/views/depot/categories/modals.blade.php ENDPATH**/ ?>