<?php $__env->startSection('content'); ?>
    
    <!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/home">Home</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo e(route('users.index')); ?>">Users</a></li>
                    <li class="breadcrumb-item active"><?php echo e($user->name); ?></li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<?php if($errors->any()): ?>
    <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h5><i class="icon fas fa-ban"></i> It seems that something has gone wrong!</h5>
        <ul>
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($error); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>
<?php endif; ?>

<?php if(Session::get('success')): ?>
    <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h5><i class="icon fas fa-check"></i> Excelent!</h5>
        <?php echo e(Session::get('success')); ?>

    </div>
<?php endif; ?>

<!-- Hoverable rows start -->
<section class="section">
    <div class="row">
        <div class="col-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title"><?php echo e($user->name); ?></h3>
                </div>
                <form action="<?php echo e(route('users.update', $user)); ?>" method="POST" class="form">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    <div class="row">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="role" class="col-form-label">User Role:</label>
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
                    </div>   
                    <div class="card-footer">
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Edit Users')): ?>
                        <button type="submit" class="btn btn-primary">Update</button>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Hoverable rows end -->

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script>

        $(document).ready(function() {
            // Inicializar el validador para el modal de creación
            $('.form').validate({
                rules: {
                    role_id: {
                        required: true
                    },
                    name: {
                        required: true
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    password: {
                        required: false,
                        minlength: 6
                    }
                },
                messages: {
                    role_id: {
                        required: "Please select a role"
                    },
                    name: {
                        required: "Please enter a user name"
                    },
                    email: {
                        required: "Please enter a user email",
                        email: "Please enter a valid email address"
                    },
                    password: {
                        required: "Please enter a user password",
                        minlength: "Password must be at least 6 characters long"
                    },
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });

            // Prevenir el envío del formulario si no es válido
            $('.form').on('submit', function(e) {
                if (!$(this).valid()) {
                    e.preventDefault();
                    return false;
                }
            });
        });

    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/pos-demo-admin/htdocs/www.pos-demo.online/resources/views/security/users/edit.blade.php ENDPATH**/ ?>