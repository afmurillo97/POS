<?php $__env->startSection('content'); ?>
    
    <!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">INCOMES</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/home">Home</a></li>
                    <li class="breadcrumb-item active">Incomes</li>
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
                                <form action="<?php echo e(route('incomes.index')); ?>" method="GET">
                                    <div class="input-group mb-6">
                                        <span class="input-group-text" id="basic-addon1"><i class="bi bi-search"></i></span>
                                        <input type="text" class="form-control" name="searchText" placeholder="Search incomes" value="<?php echo e($searchText); ?>" aria-label="Recipient's username" aria-describedby="button-addon2">
                                        <button class="btn btn-outline-secondary" type="submit" id="button-addon2">Search</button>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-2">
                                <div class="input-group mb-6">
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Create Incomes')): ?>
                                    <span class="input-group-text" id="basic-addon1"><i class="bi bi-plus-circle-fill"></i></span>
                                    <a class="bth btn-primary btn-sm" href="<?php echo e(route('incomes.create')); ?>">
                                        <i class="fas fa-plus"></i>
                                    </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-md-4 d-flex justify-content-end">
                                <?php if($searchText === ''): ?>
                                <div class="btn-group btn-sm align-middle">
                                    <form action="#">
                                        <button id="copy" class="btn btn-secondary" type="button" title="Copy page to clipboard">Copy</button>
                                    </form>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Export Incomes')): ?>
                                    <form action="<?php echo e(route( 'export.csv', ['table_name' => 'incomes'] )); ?>" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <button class="btn btn-secondary" type="submit" title="Export to CSV">CSV</button>
                                    </form>
                                    <form action="<?php echo e(route( 'export.excel', ['table_name' => 'incomes'] )); ?>" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <button class="btn btn-secondary" type="submit" title="Export to Excel">Excel</button>
                                    </form>
                                    <form action="<?php echo e(route( 'export.pdf', ['table_name' => 'incomes'] )); ?>" method="POST">
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
                        <table id="table_incomes" class="table table-striped w-100" aria-describedby="table_incomes_info">
                            <thead>
                                <tr>
                                    <th>Actions</th>
                                    <th>Id</th>
                                    <th>Date</th>
                                    <th>Provider</th>
                                    <th>Voucher</th>
                                    <th>Product</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $incomes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $income): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td class="btn-group btn-sm align-items-center">
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Show Incomes')): ?>
                                            <!-- Button trigger for edit theme modal -->
                                            <a href="<?php echo e(route('incomes.show', $income)); ?>" class="btn btn-outline-secondary btn-sm" title="Show Income">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <?php endif; ?>
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Delete Incomes')): ?>
                                            <!-- Button trigger for danger theme modal -->
                                            <button type="button" class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#modalDelete<?php echo e($income->id); ?>" title="Delete Income">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                            <?php endif; ?>
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Edit Incomes')): ?>
                                            <form id="switchForm<?php echo e($income->id); ?>" action="<?php echo e(route('incomes.toggle', $income)); ?>" method="POST" class="form">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('PUT'); ?>
                                                <input type="hidden" name="page" value="<?php echo e($incomes->currentPage()); ?>">
                                                <div class="custom-control cursor-pointer custom-switch custom-switch-off-danger custom-switch-on-success ml-2" title="Enable/disable Income">
                                                    <input type="checkbox" name="disable-income" class="custom-control-input switch-trigger" id="customSwitch<?php echo e($income->id); ?>" data-incomeid="<?php echo e($income->id); ?>" <?php echo e($income->status == 1 ? 'checked' : ''); ?>>
                                                    <label class="custom-control-label" for="customSwitch<?php echo e($income->id); ?>"></label>
                                                </div>
                                            </form>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo e($income->id); ?></td>
                                        <td><?php echo e(\Carbon\Carbon::parse($income->date)->format('Y-m-d')); ?></td>
                                        <td><?php echo e($income->provider); ?></td>
                                        <td><?php echo e($income->voucher_type . ': ' . $income->voucher_number); ?></td>
                                        <td><?php echo e($income->product); ?></td>
                                        <td><?php echo e($income->total); ?></td>
                                        <td><?php echo e($income->status === '1' ? 'Aproved' : 'Pending'); ?></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                        <?php echo e($incomes->links()); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Hoverable rows end -->

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script>
        $(function () {
            $('#table_incomes').DataTable({
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

        function copyToClipboard() {

            var selectedData = "";
            var table = $('#table_incomes').DataTable();
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

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/pos-demo-admin/htdocs/www.pos-demo.online/resources/views/shopping/incomes/index.blade.php ENDPATH**/ ?>