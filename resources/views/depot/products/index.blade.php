@extends('layouts.admin')
@section('content')
    
    <!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">PRODUCTS</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Products</li>
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
    <div class="row" id="table-hover-row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <form action="{{ route('products.index') }}" method="GET">
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon1"><i class="bi bi-search"></i></span>
                                    <input type="text" class="form-control" name="searchText" placeholder="Search products" value="{{ $searchText }}" aria-label="Recipient's username" aria-describedby="button-addon2">
                                    <button class="btn btn-outline-secondary" type="submit" id="button-addon2">Search</button>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-2">
                            <div class="input-group mb-6">
                                @can('Create Products')
                                <span class="input-group-text" id="basic-addon1"><i class="bi bi-plus-circle-fill"></i></span>
                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalCreate" title="New Product">
                                    <i class="fas fa-plus"></i>
                                </button>
                                @endcan
                            </div>
                        </div>
                        <div class="col-md-4 d-flex justify-content-end">
                            @if($searchText === '')
                            <div class="btn-group btn-sm align-middle">
                                <form action="#">
                                    <button id="copy" class="btn btn-secondary" type="button" title="Copy page to clipboard">Copy</button>
                                </form>
                                @can('Export Products')
                                <form action="{{ route( 'export.csv', ['table_name' => 'products'] ) }}" method="POST">
                                    @csrf
                                    <button class="btn btn-secondary" type="submit" title="Export to CSV">CSV</button>
                                </form>
                                <form action="{{ route( 'export.excel', ['table_name' => 'products'] ) }}" method="POST">
                                    @csrf
                                    <button class="btn btn-secondary" type="submit" title="Export to Excel">Excel</button>
                                </form>
                                <form action="{{ route( 'export.pdf', ['table_name' => 'products'] ) }}" method="POST">
                                    @csrf
                                    <button class="btn btn-secondary" type="submit" title="Export to PDF">PDF</button>
                                </form>
                                @endcan
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table id="table_products" class="table table-striped w-100" aria-describedby="table_products_info">
                            <thead>
                                <tr>
                                    <th class="text-center">Actions</th>
                                    <th class="text-center">Image</th>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Category</th>
                                    <th>code</th>
                                    <th>stock</th>
                                    <th>Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                    <tr class="">
                                        <td class="btn-group btn-sm align-items-center">
                                            @can('Edit Products')
                                            <!-- Button trigger for edit theme modal -->
                                            <button type="button" class="btn btn-outline-warning btn-sm" data-toggle="modal" data-target="#modalEdit{{ $product->id }}" title="Update Product">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            @endcan
                                            @can('Delete Products')
                                            <!-- Button trigger for danger theme modal -->
                                            <button type="button" class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#modalDelete{{ $product->id }}" title="Delete Product">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                            @endcan
                                            @can('Edit Products')
                                            <form id="switchForm{{ $product->id }}" action="{{ route('products.toggle', $product) }}" method="POST" class="form">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="page" value="{{ $products->currentPage() }}">
                                                <div class="custom-control cursor-pointer custom-switch custom-switch-off-danger custom-switch-on-success ml-2" title="Enable/disable Product">
                                                    <input type="checkbox" name="disable-product" class="custom-control-input switch-trigger" id="customSwitch{{ $product->id }}" data-productid="{{ $product->id }}" {{ $product->status == 1 ? 'checked' : '' }}>
                                                    <label class="custom-control-label" for="customSwitch{{ $product->id }}"></label>
                                                </div>
                                            </form>
                                            @endcan
                                        </td>
                                        <td>
                                            @if($product->image)
                                                <a href="#" data-toggle="modal" data-target="#imageProductModal{{ $product->id }}">
                                                    <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" height="70px" width="70px" class="img-thumbnail">
                                                </a>
                                            @endif
                                        </td>
                                        <td class="align-middle">{{ $product->id }}</td>
                                        <td class="align-middle">{{ $product->name }}</td>
                                        <td class="align-middle">{{ $product->category }}</td>
                                        <td class="align-middle">{{ $product->code }}</td>
                                        <td class="align-middle">{{ $product->stock }}</td>
                                        <td class="align-middle">{{ $product->description }}</td>
                                    </tr>
                                    @include('depot.products.modals')
                                @endforeach
                            </tbody>
                        </table>
                        {{ $products->appends(request()->query())->links() }}
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
                <h5 class="modal-title" id="exampleModalLabel">Create Product</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('products.store')}}" method="POST" enctype="multipart/form-data" class="form">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="product" class="col-form-label">Name:</label>
                        <input type="text" class="form-control" name="name" id="name" aria-describedby="product-error" aria-invalid="true" placeholder="Enter a product name">
                    </div>
                    <div class="form-group">
                        <label>Category</label>
                        <select class="form-control" name="category_id" id="category_id">
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" title="{{ $category->description }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="product" class="col-form-label">Code:</label>
                        <input type="text" class="form-control" name="code" id="code" aria-describedby="product-error" aria-invalid="true" placeholder="Enter the product code">
                    </div>
                    <div class="form-group">
                        <label for="product" class="col-form-label">Stock:</label>
                        <input type="number" class="form-control" name="stock" id="stock" aria-describedby="product-error" aria-invalid="true" placeholder="Enter the quantity in stock">
                    </div>
                    <div class="form-group">
                        <label for="description" class="col-form-label">Description:</label>
                        <textarea class="form-control" name="description" id="description"></textarea>
                    </div>
                    <div class="form-group">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="image" id="image" accept="image/jpeg,image/png,image/bmp">
                            <label class="custom-file-label" for="image">Choose an image for the product</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    @can('Create Products')
                    <button type="reset" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                    @endcan
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#modalCreate .form').validate({
                rules: {
                    code: {
                        required: true
                    },
                    name: {
                        required: true
                    },
                    stock: {
                        required: true
                    }
                },
                messages: {
                    code: {
                        required: "Please enter a code"
                    },
                    name: {
                        required: "Please enter a name"
                    },
                    stock: {
                        required: "Please enter a valid quantity"
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
                $('#table_products').DataTable({
                    searching: false, 
                    paging: false, 
                    info: false, 
                    select: true,
                    columnDefs: [{
                        targets: [0, 1], 
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
            var table = $('#table_products').DataTable();
            var selectedRows = table.rows({ selected: true }).data();
            var columnsToCopy = [2, 3, 4, 5, 6, 7];

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
@endsection
