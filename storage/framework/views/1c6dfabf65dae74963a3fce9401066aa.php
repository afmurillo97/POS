<!-- Modal Edit -->
<div class="modal fade" id="modalEdit<?php echo e($client->id); ?>" tabindex="-1" role="dialog" aria-labelledby="modalEdit<?php echo e($client->id); ?>Label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Client</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?php echo e(route('clients.update', $client)); ?>" method="POST" class="form">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name" class="col-form-label">Name:</label>
                        <input type="text" value="<?php echo e($client->name); ?>" class="form-control" name="name" id="name" aria-describedby="name-error" aria-invalid="true">
                    </div>
                    <div class="form-group">
                        <label for="client_type" class="col-form-label">Client Type:</label>
                        <input type="text" value="<?php echo e($client->client_type); ?>" class="form-control" name="client_type" id="client_type" aria-describedby="-error" aria-invalid="true">
                    </div>
                    <div class="form-group">
                        <label for="id_type" class="col-form-label">ID Type</label>
                        <select class="form-control" name="id_type" id="id_type">
                            <option value="Citizenship Card" title="Citizenship Card" <?php echo e($client->id_type == 'Citizenship Card' ? 'selected' : ''); ?>>Citizenship Card</option>
                            <option value="Foreigner ID" title="Foreigner ID" <?php echo e($client->id_type == 'Foreigner ID' ? 'selected' : ''); ?>>Foreigner ID</option>
                            <option value="Identity card" title="Identity card" <?php echo e($client->id_type == 'Identity card' ? 'selected' : ''); ?>>Identity card</option>
                            <option value="NIT" title="NIT" <?php echo e($client->id_type == 'NIT' ? 'selected' : ''); ?>>NIT</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="id_number" class="col-form-label">ID Number:</label>
                        <input type="number" value="<?php echo e($client->id_number); ?>" class="form-control" name="id_number" id="id_number" aria-describedby="-error" aria-invalid="true" disabled>
                    </div>
                    <div class="form-group">
                        <label for="address" class="col-form-label">Address:</label>
                        <input type="text" value="<?php echo e($client->address); ?>" class="form-control" name="address" id="address" aria-describedby="-error" aria-invalid="true">
                    </div>
                    <div class="form-group">
                        <label for="phone" class="col-form-label">Phone:</label>
                        <input type="number" value="<?php echo e($client->phone); ?>" class="form-control" name="phone" id="phone" aria-describedby="-error" aria-invalid="true">
                    </div>
                    <div class="form-group">
                        <label for="email" class="col-form-label">Email:</label>
                        <input type="text" value="<?php echo e($client->email); ?>" class="form-control" name="email" id="email" aria-describedby="-error" aria-invalid="true">
                    </div>
                </div>
                <div class="modal-footer">
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Edit Clients')): ?>
                    <button type="reset" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Delete -->
<div class="modal fade" id="modalDelete<?php echo e($client->id); ?>" tabindex="-1" aria-labelledby="modalDelete<?php echo e($client->id); ?>Label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fs-5" id="modalDelete<?php echo e($client->id); ?>Label">Delete Client</h1>
            </div>
            <div class="modal-body">
                Are you sure to delete the Client <?php echo e($client->name); ?>?
            </div>
            <div class="modal-footer">
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Delete Clients')): ?>
                <form action="<?php echo e(route('clients.destroy', $client )); ?>" method="POST" class="d-inline">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div><?php /**PATH /home/pos-demo-admin/htdocs/www.pos-demo.online/resources/views/sales/clients/modals.blade.php ENDPATH**/ ?>