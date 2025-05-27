@extends('layouts.admin')
@section('content')
    
    <!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/home">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('sales.index') }}">Sales</a></li>
                    <li class="breadcrumb-item active">New</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

@if ($errors->any())
    <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h5><i class="icon fas fa-ban"></i> It seems that something has gone wrong!</h5>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (Session::get('success'))
    <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h5><i class="icon fas fa-check"></i> Excelent!</h5>
        {{Session::get('success')}}
    </div>
@endif

<!-- Hoverable rows start -->
<section class="section">
    <div class="row">
        <div class="col-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">New Sale</h3>
                </div>

                <form id="saleForm">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="client" class="col-form-label">Client</label>
                                    <select class="form-control selectpicker show-tick" name="client" id="client" data-live-search="true">
                                        <option value="-1">Select Client</option>
                                        @foreach($clients as $client)
                                            <option value="{{ $client->id }}" title="{{ $client->name }}">{{ $client->name  }} [ {{ $client->id_number }} ]</option>
                                        @endforeach
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
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="product" class="col-form-label">Products</label>
                                    <select class="form-control selectpicker dropdown show-tick" name="product" id="product" data-live-search="true">
                                        <option value="-1">Select Product</option>
                                        @foreach($products as $product)
                                            <option value="{{ $product->id }}" title="{{ $product->name }}">{{ $product->name  }} [{{ $product->code }}]</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group">
                                    <label for="stock" class="col-form-label">Stock</label>
                                    <input type="text" class="form-control" name="stock" id="stock" aria-describedby="-error" aria-invalid="true" disabled>
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
                                    <label for="sale_price" class="col-form-label">Sale Price:</label>
                                    <input type="text" min="0" class="form-control" name="sale_price" id="sale_price" aria-describedby="sale_price-error" aria-invalid="true">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="discount" class="col-form-label">Discount:</label>
                                    <input type="number" min="0" class="form-control" name="discount" id="discount" aria-describedby="discount-error" aria-invalid="true">
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
                                                <th style="width: 15%;">Sale Price</th>
                                                <th style="width: 15%;">Discount</th>
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
                        @can('Create Sales')
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <button type="button" id="save" name="save" class="btn btn-primary">Save</button>
                        @endcan
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Hoverable rows end -->

@endsection

@section('scripts')
    <script>

    const $clientSelect = $('#client');
    const $productSelect = $('#product');
    const $stockInput = $('#stock');
    const $amountInput = $('#amount');
    const $discountInput = $('#discount');
    const $salePriceInput = $('#sale_price');
    const $saveButton = $("#save");
    const $totalDisplay = $('#total');
    const $detailsTable = $('#details');

    $('.selectpicker').selectpicker({
        dropupAuto: false
    });

    $('#add').on('click', add);

    $('#saleForm').on('keypress', function(event) {
        if (event.which === 13) {
            event.preventDefault();
            add();
        }
    });

    $saveButton.hide();
    $saveButton.on('click', validateSale);
    $('input[type="number"]').on('keydown', allowOnlyNumbers);
    $detailsTable.on('change', 'input[name="discount[]"]', changeValues);
    $clientSelect.on('change', function () {
        $('#saleForm').valid();
    });
    $productSelect.on('change', loadProduct);

    let cont = 0;
    let total = 0;
    let subtotal = [];

    function add() {

        let product_id = $productSelect.val();
        let product = $productSelect.find('option:selected').text();
        let stock = parseInt($stockInput.val());
        let amount = parseInt($amountInput.val());
        let sale_price = parseInt($salePriceInput.val());
        let discount = ($discountInput.val() != '') ? parseInt($discountInput.val()) : 0;

        if(amount > stock){

            Swal.fire({
                icon: 'error',
                title: 'Oops!!',
                text: 'The amount cannot be greater than stock!!'
            });

            console.log({amount, stock});

            return false;

        } 

        if (product_id != '-1' && amount != '' && amount > 0 && stock != '' && sale_price != '') {

            subtotal[cont] = (amount * sale_price - discount);
            total += subtotal[cont];

            let row = generateRow(product_id, product, amount, sale_price, discount, subtotal[cont]);

            cont++;

            clean();
            $totalDisplay.html('$ ' + total.toFixed(2));
            evaluate();
            $detailsTable.append(row);
            $("#product option[value='" + product_id + "']").prop('disabled', true);
            $productSelect.selectpicker('refresh');

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
        $stockInput.val("");
        $amountInput.val("");
        $discountInput.val("");
        $salePriceInput.val("");
    }

    function evaluate() {
        $saveButton.toggle(total > 0);
    }

    function deleteRow(index) {
        let product_id = $("input[name='product_id[]']").val();

        total -= subtotal[index];
        $totalDisplay.html('$ ' + total);
        $('#fila' + index).remove();
        $("#product option[value='" + product_id + "']").prop('disabled', false);
        $productSelect.selectpicker('refresh');
        evaluate();
    }

    function generateRow(product_id, product, amount, sale_price, discount, subtotal) {
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
                        <input type="text" value="${amount}" name="amount[]" class="form-control" disabled>
                    </div>
                </td>
                <td style="width: 15%;" class="">
                    <div class="form-group">
                        <input type="text" value="${sale_price.toFixed(2)}" name="sale_price[]" class="form-control" disabled>
                    </div>
                </td>
                <td style="width: 15%;" class="">
                    <div class="form-group">
                        <input type="number" value="${discount.toFixed(2)}" name="discount[]" class="form-control">
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

    function validateSale() {
        $('#saleForm').validate({
            rules: {
                client: {
                    required: true,
                    notEqual: "-1" 
                },
                voucher_type: {
                    required: true,
                    notEqual: "-1" 
                }
            },
            messages: {
                client: {
                    required: "Please select a client",
                    notEqual: "Please select a valid client"
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

        if ($('#saleForm').valid()) {
            newSale();
        }
    }

    $.validator.addMethod("notEqual", function(value, element, param) {
        if (value === "-1") {
            return false;
        }
        // De lo contrario, se aplica la comparación normal
        return this.optional(element) || value !== param;
    }, "Please enter a valid value.");
    
    function newSale() {

        let token = $("input[name='_token']").val();

        let productIds = $("input[name='product_id[]']").map(function() {
            return $(this).val();
        }).get();

        let amounts = $("input[name='amount[]']").map(function() {
            return $(this).val();
        }).get();

        let discounts = $("input[name='discount[]']").map(function() {
            return $(this).val();
        }).get();

        let salePrices = $("input[name='sale_price[]']").map(function() {
            return $(this).val();
        }).get();

        let client = $clientSelect.val();
        let voucherType = $("#voucher_type").val();
        let voucherNumber = $("#voucher_number").val();

        let dataToSend = {
            _token: token,
            productIds: productIds,
            amounts: amounts,
            discounts: discounts,
            salePrices: salePrices,
            client_id: client,
            voucher_type: voucherType,
            voucher_number: voucherNumber,
            total: total.toFixed(2)
        };

        // console.log(dataToSend);

        $.ajax({
            url: "{{ route('sales.store') }}",
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
                        window.location.href = "{{ route('sales.index') }}";
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
        let discount = parseFloat($row.find('input[name="discount[]"]').val()) || 0;
        let sale_price = parseFloat($row.find('input[name="sale_price[]"]').val()) || 0;

        let subtotal = amount * sale_price - discount;

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

    function loadProduct() {
        
        let token = $("input[name='_token']").val();
        let product_id = $productSelect.val();
        let dataToSend = {
            '_token': token,
            'product_id': product_id,
        };
        
        // console.log(dataToSend);

        if (product_id == "-1") {

            $stockInput.val("");
            $salePriceInput.val("");

        } else {

            $.ajax({
                url: `/depot/products/${product_id}`,
                type: 'GET',
                dataType: 'json',
                data: dataToSend,
                success: function(response) {

                    if (response.status) {
                        
                        $stockInput.val(response.product.stock);;
                        $salePriceInput.val(response.product.sale_price);

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

    }

    </script>
@endsection
