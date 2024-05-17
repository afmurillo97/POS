<!-- Modal Edit -->
<div class="modal fade" id="modalEdit<?php echo e($product->id); ?>" tabindex="-1" role="dialog" aria-labelledby="modalEdit<?php echo e($product->id); ?>Label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Product</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?php echo e(route('products.update', $product)); ?>" method="POST" enctype="multipart/form-data" class="form">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="product" class="col-form-label">Name:</label>
                        <input type="text" value="<?php echo e($product->name); ?>" class="form-control" name="name" id="name" aria-describedby="product-error" aria-invalid="true" placeholder="Enter a product name">
                    </div>
                    <div class="form-group">
                        <label>Category</label>
                        <select class="form-control" name="category_id" id="category_id">
                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($category->id); ?>" title="<?php echo e($category->description); ?>" <?php echo e($product->category_id == $category->id ? 'selected' : ''); ?>><?php echo e($category->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="product" class="col-form-label">Code:</label>
                        <input type="text" value="<?php echo e($product->code); ?>" class="form-control" name="code" id="code" aria-describedby="product-error" aria-invalid="true" placeholder="Enter the product code">
                    </div>
                    <div class="form-group">
                        <label for="product" class="col-form-label">Stock:</label>
                        <input type="number" value="<?php echo e($product->stock); ?>" class="form-control" name="stock" id="stock" aria-describedby="product-error" aria-invalid="true" placeholder="Enter the quantity in stock">
                    </div>
                    <div class="form-group">
                        <label for="description" class="col-form-label">Description:</label>
                        <textarea class="form-control" name="description" id="description"><?php echo e($product->description); ?></textarea>
                    </div>
                    <?php if($product->image): ?>
                    <div class="form-group">
                        <label for="currentImage">Image:</label>
                        <img src="<?php echo e(asset($product->image)); ?>" alt="<?php echo e($product->name); ?>" class="img-thumbnail" id="currentImage" style="max-width: 200px;">
                    </div>
                    <?php endif; ?>
                    <div class="form-group">
                        <label for="image">Update Image:</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="image" id="image" accept="image/jpeg,image/png,image/bmp">
                            <label class="custom-file-label" for="image">Choose a new image for the product</label>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Edit Products')): ?>
                    <button type="reset" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Delete -->
<div class="modal fade" id="modalDelete<?php echo e($product->id); ?>" tabindex="-1" aria-labelledby="modalDelete<?php echo e($product->id); ?>Label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fs-5" id="modalDelete<?php echo e($product->id); ?>Label">Delete Product</h1>
            </div>
            <div class="modal-body">
                Are you sure to delete the product <?php echo e($product->name); ?>?
            </div>
            <div class="modal-footer">
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Delete Products')): ?>
                <form action="<?php echo e(route('products.destroy', $product)); ?>" method="POST" class="d-inline">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Modal Image -->
<?php if($product->image): ?>
    <div class="modal fade" id="imageProductModal<?php echo e($product->id); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <img id="modalImage" src="<?php echo e(asset($product->image)); ?>"  class="img-fluid">
                </div>
            </div>
        </div>
    </div>
<?php endif; ?><?php /**PATH /home/pos-demo-admin/htdocs/www.pos-demo.online/resources/views/depot/products/modals.blade.php ENDPATH**/ ?>