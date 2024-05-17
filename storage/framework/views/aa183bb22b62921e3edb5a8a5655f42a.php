<?php $__env->startSection('content'); ?>
    
    <!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/home">Home</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo e(route('incomes.index')); ?>">Incomes</a></li>
                    <li class="breadcrumb-item active">Show</li>
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
                    <h3 class="card-title">Show Income</h3>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="provider" class="col-form-label">Provider</label>
                                <p class="form-control"><?php echo e($income->provider); ?></p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="voucher_type" class="col-form-label">Voucher Type</label>
                                <p class="form-control"><?php echo e($income->voucher_type); ?></p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="voucher_number" class="col-form-label">Voucher Number:</label>
                                <p class="form-control"><?php echo e($income->voucher_number); ?></p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table id="table_incomes_show" class="table table-bordered table-hover w-100">
                                    <thead>
                                        <tr>
                                            <th style="width: 40%;">Product</th>
                                            <th style="width: 10%;">Amount</th>
                                            <th style="width: 15%;">Purchase Price</th>
                                            <th style="width: 15%;">Sale Price</th>
                                            <th style="width: 15%;">Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody id="details">
                                        <?php
                                            $total = 0;
                                        ?>
                                        <?php $__currentLoopData = $income_detail; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php
                                                $purchase_price = floatval($detail->purchase_price);
                                                $amount = intval($detail->amount);
                                                $subtotal = $amount * $purchase_price;
                                                $total += $subtotal;
                                            ?>
                                            <tr>
                                                <td><?php echo e($detail->product); ?></td>
                                                <td><?php echo e($detail->amount); ?></td>
                                                <td><?php echo e($detail->purchase_price); ?></td>
                                                <td><?php echo e($detail->sale_price); ?></td>
                                                <td><?php echo e(number_format($subtotal, 2)); ?></td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                    <tfoot>
                                        <th class="text-center">TOTAL</th>
                                        <th colspan="3"></th>
                                        <th><h4 class="text-center" id="total">$ <?php echo e(number_format($total, 2)); ?></h4></th>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
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
            $('#table_incomes_show').DataTable({
                searching: false, 
                paging: false, 
                info: false, 
                select: true
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/pos-demo-admin/htdocs/www.pos-demo.online/resources/views/shopping/incomes/show.blade.php ENDPATH**/ ?>