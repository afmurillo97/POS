<?php $__env->startSection('content'); ?>
    
    <!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">PROVIDERS</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/home">Home</a></li>
                    <li class="breadcrumb-item active">Providers</li>
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
    <div class="row" id="table-hover-row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="col-xl-12">
                        <div class="row">
                            <div class="col-md-6">
                                <form action="<?php echo e(route('providers.index')); ?>" method="GET">
                                    <div class="input-group mb-6">
                                        <span class="input-group-text" id="basic-addon1"><i class="bi bi-search"></i></span>
                                        <input type="text" class="form-control" name="searchText" placeholder="Search providers" value="<?php echo e($searchText); ?>" aria-label="Recipient's username" aria-describedby="button-addon2">
                                        <button class="btn btn-outline-secondary" type="submit" id="button-addon2">Search</button>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-2">
                                <div class="input-group mb-6">
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Create Providers')): ?>
                                    <span class="input-group-text" id="basic-addon1"><i class="bi bi-plus-circle-fill"></i></span>
                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalCreate" title="New Provider">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-md-4 d-flex justify-content-end">
                                <?php if($searchText === ''): ?>
                                <div class="btn-group btn-sm align-middle">
                                    <form action="#">
                                        <button id="copy" class="btn btn-secondary" type="button" title="Copy page to clipboard">Copy</button>
                                    </form>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Export Providers')): ?>
                                    <form action="<?php echo e(route( 'export.csv', ['table_name' => 'providers'] )); ?>" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <button class="btn btn-secondary" type="submit" title="Export to CSV">CSV</button>
                                    </form>
                                    <form action="<?php echo e(route( 'export.excel', ['table_name' => 'providers'] )); ?>" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <button class="btn btn-secondary" type="submit" title="Export to Excel">Excel</button>
                                    </form>
                                    <form action="<?php echo e(route( 'export.pdf', ['table_name' => 'providers'] )); ?>" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <button class="btn btn-secondary" type="submit" title="Export to PDF">PDF</button>
                                    </form>
                                    <?php endif; ?>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>    
                    </div>
                </div>
                <div class="card-content">
                    <div class="card-body">
                    </div>
                    <!-- table hover -->
                    <div class="table-responsive">
                        <table id="table_providers" class="table table-striped w-100" aria-describedby="table_providers_info">
                            <thead>
                                <tr>
                                    <th>Actions</th>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>ID Type</th>
                                    <th>ID Number</th>
                                    <th>Address</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $providers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $provider): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td class="btn-group btn-sm align-items-center">
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Edit Providers')): ?>
                                            <!-- Button trigger for edit theme modal -->
                                            <button type="button" class="btn btn-outline-warning btn-sm editClient" data-toggle="modal" data-target="#modalEdit<?php echo e($provider->id); ?>" title="Update Provider">
                                                <i class="fas fa-pen"></i>
                                            </button>
                                            <?php endif; ?>
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Delete Providers')): ?>
                                            <!-- Button trigger for danger theme modal -->
                                            <button type="button" class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#modalDelete<?php echo e($provider->id); ?>" title="Delete Provider">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                            <?php endif; ?>
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Edit Providers')): ?>
                                            <form id="switchForm<?php echo e($provider->id); ?>" action="<?php echo e(route('providers.toggle', $provider)); ?>" method="POST" class="form">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('PUT'); ?>
                                                <input type="hidden" name="page" value="<?php echo e($providers->currentPage()); ?>">
                                                <div class="custom-control cursor-pointer custom-switch custom-switch-off-danger custom-switch-on-success ml-2" title="Enable/disable Provider">
                                                    <input type="checkbox" name="disable-provider" class="custom-control-input switch-trigger" id="customSwitch<?php echo e($provider->id); ?>" data-clientid="<?php echo e($provider->id); ?>" <?php echo e($provider->status == 1 ? 'checked' : ''); ?>>
                                                    <label class="custom-control-label" for="customSwitch<?php echo e($provider->id); ?>"></label>
                                                </div>
                                            </form>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo e($provider->id); ?></td>
                                        <td><?php echo e($provider->name); ?></td>
                                        <td><?php echo e($provider->id_type); ?></td>
                                        <td><?php echo e($provider->id_number); ?></td>
                                        <td><?php echo e($provider->address); ?></td>
                                        <td><?php echo e($provider->phone); ?></td>
                                        <td><?php echo e($provider->email); ?></td>
                                    </tr>
                                    <?php echo $__env->make('shopping.providers.modals', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                        <?php echo e($providers->links()); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Hoverable rows end -->

<!-- Modal Create -->
<div class="modal fade" id="modalCreate" tabindex="-1" role="dialog" aria-labelledby="modalCreateLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create Provider</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?php echo e(route('providers.store')); ?>" method="POST" class="form">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name" class="col-form-label">Name:</label>
                        <input type="text" class="form-control" name="name" id="name" aria-describedby="name-error" aria-invalid="true">
                    </div>
                    <div class="form-group">
                        <label for="id_type" class="col-form-label">ID Type</label>
                        <select class="form-control" name="id_type" id="id_type">
                            <option value="Citizenship Card" title="Citizenship Card">Citizenship Card</option>
                            <option value="Foreigner ID" title="Foreigner ID">Foreigner ID</option>
                            <option value="Identity card" title="Identity card">Identity card</option>
                            <option value="NIT" title="NIT">NIT</option> 
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="naid_numbere" class="col-form-label">ID Number:</label>
                        <input type="number" class="form-control" name="id_number" id="id_number" aria-describedby="id_number-error" aria-invalid="true">
                    </div>
                    <div class="form-group">
                        <label for="address" class="col-form-label">Address:</label>
                        <input type="text" class="form-control" name="address" id="address" aria-describedby="address-error" aria-invalid="true">
                    </div>
                    <div class="form-group">
                        <label for="phone" class="col-form-label">Phone:</label>
                        <input type="number" class="form-control" name="phone" id="phone" aria-describedby="phone-error" aria-invalid="true">
                    </div>
                    <div class="form-group">
                        <label for="email" class="col-form-label">Email:</label>
                        <input type="text" class="form-control" name="email" id="email" aria-describedby="email-error" aria-invalid="true">
                    </div>
                </div>    
                <div class="modal-footer">
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Create Providers')): ?>
                    <button type="reset" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script>
        $(document).ready(function() {
            // Inicializar el validador para el modal de creación
            $('#modalCreate .form').validate({
                rules: {
                    name: {
                        required: true
                    },
                    id_type: {
                        required: true
                    },
                    id_number: {
                        required: true,
                        digits: true,
                        maxlength: 12
                    },
                    phone: {
                        required: false,
                        digits: true,
                        maxlength: 12
                    },
                    email: {
                        required: true,
                        email: true
                    }
                },
                messages: {
                    name: {
                        required: "Please enter a provider name"
                    },
                    id_type: {
                        required: "Please enter an ID type "
                    },
                    id_number: {
                        required: "Please enter an ID number ",
                        digits: "Please enter only digits",
                        maxlength: "ID number must be at most 12 digits"
                    },
                    phone: {
                        digits: "Please enter only digits",
                        maxlength: "Phone number must be at most 12 digits"
                    },
                    email: {
                        required: "Please enter an email",
                        email: "Please enter a valid email address"
                    }
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

            // Initialize DataTable
            $(function () {
                $('#table_providers').DataTable({
                    searching: false, 
                    paging: false, 
                    info: false, 
                    select: true,
                    columnDefs: [{
                        targets: [0], 
                        searchable: false, 
                        orderable: false 
                    }]
                });
            });

            $('#copy').on('click', copyToClipboard);

            // Escuchar el cambio en el interruptor
            $(".switch-trigger").change(function() {
                $(this).closest('form').submit();
            });
        });

        function copyToClipboard() {

            var selectedData = "";
            var table = $('#table_providers').DataTable();
            var selectedRows = table.rows({ selected: true }).data();
            var columnsToCopy = [1, 2, 3, 4, 5, 6, 7];

            selectedRows.each(function(rowData) {
                columnsToCopy.forEach(function(colIndex) {
                    selectedData += rowData[colIndex] + "\t";
                });
                selectedData += "\n";
            });

            // Copy to clipboard
            navigator.clipboard.writeText(selectedData).then(function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Copied to Clipboard!',
                    showConfirmButton: false,
                    timer: 1500
                });

                var copyButton = document.getElementById("copy");
                copyButton.innerHTML = '<i class="fas fa-check-double"></i>';
                copyButton.disabled = true;
            }, function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Error copying data!'
                });
            });
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/pos-demo-admin/htdocs/www.pos-demo.online/resources/views/shopping/providers/index.blade.php ENDPATH**/ ?>