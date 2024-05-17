<?php $__env->startSection('content'); ?>
    
    <!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/home">Home</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo e(route('incomes.index')); ?>">Incomes</a></li>
                    <li class="breadcrumb-item active">New</li>
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
                    <h3 class="card-title">New Income</h3>
                </div>

                <form id="incomeForm">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="provider" class="col-form-label">Provider</label>
                                    <select class="form-control selectpicker show-tick" name="provider" id="provider" data-live-search="true">
                                        <option value="-1">Select Provider</option>
                                        <?php $__currentLoopData = $providers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $provider): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($provider->id); ?>" title="<?php echo e($provider->name); ?>"><?php echo e($provider->name); ?> [ <?php echo e($provider->id_number); ?> ]</option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="voucher_type" class="col-form-label">Voucher Type</label>
                                    <select class="form-control" name="voucher_type" id="voucher_type">
                                        <option value="-1" title="Select Type">Select Type</option>
                                        <option value="Sale Ticket" title="Sale Ticket">Sale Ticket</option>
                                        <option value="Sale Receipt" title="Sale Receipt">Sale Receipt</option>
                                        <option value="Credit Note" title="Credit Note">Credit Note</option> 
                                        <option value="Invoice" title="Invoice">Invoice</option> 
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3" title="Automatically generated if this input is empty...">
                                <div class="form-group">
                                    <label for="voucher_number" class="col-form-label">Voucher Number:</label>
                                    <input type="number" class="form-control" name="voucher_number" id="voucher_number" aria-describedby="voucher_number-error" aria-invalid="true" placeholder="Automatically generated">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="product" class="col-form-label">Products</label>
                                    <select class="form-control selectpicker dropdown show-tick" name="product" id="product" data-live-search="true">
                                        <option value="-1">Select Product</option>
                                        <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($product->id); ?>" title="<?php echo e($product->name); ?>"><?php echo e($product->name); ?> [<?php echo e($product->code); ?>]</option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="amount" class="col-form-label">Amount</label>
                                    <input type="number" class="form-control" name="amount" id="amount" aria-describedby="-error" aria-invalid="true">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="purchase_price" class="col-form-label">Purchase Price:</label>
                                    <input type="number" min="0" class="form-control" name="purchase_price" id="purchase_price" aria-describedby="purchase_price-error" aria-invalid="true">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="sale_price" class="col-form-label">Sale Price:</label>
                                    <input type="number" min="0" class="form-control" name="sale_price" id="sale_price" aria-describedby="sale_price-error" aria-invalid="true">
                                </div>
                            </div>
                            <div class="col-md-1 d-flex align-items-center text-center">
                                <div class="form-group" title="Press Enter to add product!">
                                    <label for="product" class="col-form-label">Actions</label>
                                    <button type="button" id="add" class="btn btn-outline-success btn-sm">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover w-100">
                                        <thead>
                                            <tr>
                                                <th style="width: 5%;">Options</th>
                                                <th style="width: 40%;">Product</th>
                                                <th style="width: 10%;">Amount</th>
                                                <th style="width: 15%;">Purchase Price</th>
                                                <th style="width: 15%;">Sale Price</th>
                                                <th style="width: 15%;">Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <th class="text-center">TOTAL</th>
                                            <th colspan="4"></th>
                                            <th><h4 class="text-center" id="total">$ 0.00</h4></th>
                                        </tfoot>
                                        <tbody id="details">
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                
                    <div class="card-footer">
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Create Incomes')): ?>
                        <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                        <button type="button" id="save" name="save" class="btn btn-primary">Update</button>
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

    const $providerSelect = $('#provider');
    const $productSelect = $('#product');
    const $amountInput = $('#amount');
    const $purchasePriceInput = $('#purchase_price');
    const $salePriceInput = $('#sale_price');
    const $saveButton = $("#save");
    const $totalDisplay = $('#total');
    const $detailsTable = $('#details');

    $('.selectpicker').selectpicker({
        dropupAuto: false
    });

    $('#add').on('click', add);

    $('#incomeForm').on('keypress', function(event) {
        if (event.which === 13) {
            event.preventDefault();
            add();
        }
    });

    $saveButton.hide();
    $saveButton.on('click', validateIncome);
    $('input[type="number"]').on('keydown', allowOnlyNumbers);
    $detailsTable.on('change', 'input[name="amount[]"], input[name="purchase_price[]"]', changeValues);
    $providerSelect.on('change', function () {
        $('#incomeForm').valid();
    });

    let cont = 0;
    let total = 0;
    let subtotal = [];

    function add() {
        let product_id = $productSelect.val();
        let product = $productSelect.find('option:selected').text();
        let amount = $amountInput.val();
        let purchase_price = $purchasePriceInput.val();
        let sale_price = $salePriceInput.val();

        if (product_id != '-1' && amount != '' && amount > 0 && purchase_price != '' && sale_price != '') {
            subtotal[cont] = (amount * purchase_price);
            total += subtotal[cont];

            let row = generateRow(product_id, product, amount, purchase_price, sale_price, subtotal[cont]);

            cont++;

            clean();
            $totalDisplay.html('$ ' + total.toFixed(2));
            evaluate();
            $detailsTable.append(row);
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Oops!!',
                text: 'Parameters Missing!!!'
            });
        }
    }

    function clean() {
        $productSelect.val("-1");
        $productSelect.selectpicker('refresh');
        $amountInput.val("");
        $purchasePriceInput.val("");
        $salePriceInput.val("");
    }

    function evaluate() {
        $saveButton.toggle(total > 0);
    }

    function deleteRow(index) {
        total -= subtotal[index];
        $totalDisplay.html('$ ' + total);
        $('#fila' + index).remove();
        evaluate();
    }

    function generateRow(product_id, product, amount, purchase_price, sale_price, subtotal) {
        return `
            <tr class="" id="fila${cont}">
                <td style="width: 5%;" class="text-center">
                    <button type="button" onclick="deleteRow(${cont});" class="btn btn-outline-danger btn-sm">
                        <i class="fas fa-minus"></i>
                    </button>
                </td>
                <td style="width: 40%;" class="">
                    <div class="form-group">
                        <input type="hidden" name="product_id[]" value="${product_id}">
                        <p class="col-form-label">${product}</p>
                    </div>
                </td>
                <td style="width: 10%;" class="">
                    <div class="form-group">
                        <input type="number" value="${amount}" name="amount[]" class="form-control">
                    </div>
                </td>
                <td style="width: 15%;" class="">
                    <div class="form-group">
                        <input type="number" value="${purchase_price}" name="purchase_price[]" class="form-control">
                    </div>
                </td>
                <td style="width: 15%;" class="">
                    <div class="form-group">
                        <input type="number" value="${sale_price}" name="sale_price[]" class="form-control">
                    </div>
                </td>
                <td style="width: 15%;" class="text-center">
                    <div class="form-group">
                        <p class="col-form-label">${subtotal.toFixed(2)}</p>
                    </div>
                </td>
            </tr>
        `;
    }

    function validateIncome() {
        $('#incomeForm').validate({
            rules: {
                provider: {
                    required: true,
                    notEqual: "-1" 
                },
                voucher_type: {
                    required: true,
                    notEqual: "-1" 
                }
            },
            messages: {
                provider: {
                    required: "Please select a provider",
                    notEqual: "Please select a valid provider"
                },
                voucher_type: {
                    required: "Please select a voucher type",
                    notEqual: "Please select a valid voucher type"
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

        if ($('#incomeForm').valid()) {
            newIncome();
        }
    }

    $.validator.addMethod("notEqual", function(value, element, param) {
        if (value === "-1") {
            return false;
        }
        // De lo contrario, se aplica la comparación normal
        return this.optional(element) || value !== param;
    }, "Please enter a valid value.");
    
    function newIncome() {

        let token = $("input[name='_token']").val();

        let productIds = $("input[name='product_id[]']").map(function() {
            return $(this).val();
        }).get();

        let amounts = $("input[name='amount[]']").map(function() {
            return $(this).val();
        }).get();

        let purchasePrices = $("input[name='purchase_price[]']").map(function() {
            return $(this).val();
        }).get();

        let salePrices = $("input[name='sale_price[]']").map(function() {
            return $(this).val();
        }).get();

        let provider = $("#provider").val();
        let voucherType = $("#voucher_type").val();
        let voucherNumber = $("#voucher_number").val();

        let dataToSend = {
            _token: token,
            productIds: productIds,
            amounts: amounts,
            purchasePrices: purchasePrices,
            salePrices: salePrices,
            provider_id: provider,
            voucher_type: voucherType,
            voucher_number: voucherNumber
        };

        // console.log(dataToSend);

        $.ajax({
            url: "<?php echo e(route('incomes.store')); ?>",
            type: 'POST',
            dataType: 'json',
            data: dataToSend,
            success: function(response) {

                if (response.status) {
                    
                    Swal.fire({
                        icon: 'success',
                        title: response.title,
                        text: response.message
                    });

                    console.log(response);

                    setTimeout(() => {
                        window.location.href = "<?php echo e(route('incomes.index')); ?>";
                    }, 1050);	

                } else {
                    Swal.fire({
                        icon: 'error',
                        title: response.title,
                        text: response.message
                    });
                }

            },
            error: function(xhr, status, error) {

                let message = ': ' + xhr.responseJSON.message ?? '';

                console.log({xhr, status, error});
                Swal.fire({
                    icon: status,
                    title: 'Oops!!',
                    text: error + message
                });

            }
        });
    }

    function changeValues() {

        let $row = $(this).closest('tr');

        let amount = parseFloat($row.find('input[name="amount[]"]').val()) || 0;
        let purchase_price = parseFloat($row.find('input[name="purchase_price[]"]').val()) || 0;
        let sale_price = parseFloat($row.find('input[name="sale_price[]"]').val()) || 0;

        let subtotal = amount * purchase_price;

        $row.find('.col-form-label').last().text(subtotal.toFixed(2));

        recalculateTotal();
    }

    function recalculateTotal() {
        total = 0;

        // Iterar sobre todas las filas y sumar los subtotales
        $detailsTable.find('tr').each(function() {
            let subtotal = parseFloat($(this).find('.col-form-label').last().text()) || 0;
            total += subtotal;
        });

        // Actualizar el total en el elemento correspondiente
        $totalDisplay.html('$ ' + total.toFixed(2));

        // Realizar cualquier otra evaluación necesaria
        evaluate();
    }

    function allowOnlyNumbers(event) {
        // Allow navigation, backspace, delete and tab keys
        if ($.inArray(event.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
            // Allow: Ctrl+A, Ctrl+C, Ctrl+V, Ctrl+X
            (event.keyCode === 65 && (event.ctrlKey === true || event.metaKey === true)) ||
            (event.keyCode === 67 && (event.ctrlKey === true || event.metaKey === true)) ||
            (event.keyCode === 86 && (event.ctrlKey === true || event.metaKey === true)) ||
            (event.keyCode === 88 && (event.ctrlKey === true || event.metaKey === true)) ||

            (event.keyCode >= 35 && event.keyCode <= 39)) {
                return;
        }

        if ((event.shiftKey || (event.keyCode < 48 || event.keyCode > 57)) && (event.keyCode < 96 || event.keyCode > 105)) {
                event.preventDefault();
        }
    }

    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/pos-demo-admin/htdocs/www.pos-demo.online/resources/views/shopping/incomes/create.blade.php ENDPATH**/ ?>