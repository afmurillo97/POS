@extends('layouts.admin')
@section('content')
    
    <!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">SALES</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Sales</li>
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
                    <div class="col-xl-12">
                        <div class="row">
                            <div class="col-md-6">
                                <form action="{{ route('sales.index') }}" method="GET">
                                    <div class="input-group mb-6">
                                        <span class="input-group-text" id="basic-addon1"><i class="bi bi-search"></i></span>
                                        <input type="text" class="form-control" name="searchText" placeholder="Search sales" value="{{ $searchText }}" aria-label="Recipient's username" aria-describedby="button-addon2">
                                        <button class="btn btn-outline-secondary" type="submit" id="button-addon2">Search</button>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-2">
                                <div class="input-group mb-6">
                                    @can('Create Sales')
                                    <span class="input-group-text" id="basic-addon1"><i class="bi bi-plus-circle-fill"></i></span>
                                    <a class="bth btn-primary btn-sm" href="{{ route('sales.create') }}">
                                        <i class="fas fa-plus"></i>
                                    </a>
                                    @endcan
                                </div>
                            </div>
                            <div class="col-md-4 d-flex justify-content-end">
                                @if($searchText === '')
                                <div class="btn-group btn-sm align-middle">
                                    <form action="#">
                                        <button id="copy" class="btn btn-secondary" type="button" title="Copy page to clipboard">Copy</button>
                                    </form>
                                    @can('Export Sales')
                                    <form action="{{ route( 'export.csv', ['table_name' => 'sales'] ) }}" method="POST">
                                        @csrf
                                        <button class="btn btn-secondary" type="submit" title="Export to CSV">CSV</button>
                                    </form>
                                    <form action="{{ route( 'export.excel', ['table_name' => 'sales'] ) }}" method="POST">
                                        @csrf
                                        <button class="btn btn-secondary" type="submit" title="Export to Excel">Excel</button>
                                    </form>
                                    <form action="{{ route( 'export.pdf', ['table_name' => 'sales'] ) }}" method="POST">
                                        @csrf
                                        <button class="btn btn-secondary" type="submit" title="Export to PDF">PDF</button>
                                    </form>
                                    @endcan
                                </div>
                                @endif
                            </div>
                        </div>    
                    </div>
                </div>
                <div class="card-content">
                    <div class="card-body">
                    </div>
                    <!-- table hover -->
                    <div class="table-responsive">
                        <table id="table_sales" class="table table-striped w-100" aria-describedby="table_sales_info">
                            <thead>
                                <tr>
                                    <th>Actions</th>
                                    <th>Id</th>
                                    <th>Date</th>
                                    <th>Client</th>
                                    <th>Voucher</th>
                                    <th>Product</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($sales as $sale)
                                    <tr>
                                        <td class="btn-group btn-sm align-items-center">
                                            @can('Show Sales')
                                            <!-- Button trigger for edit theme modal -->
                                            <a href="{{ route('sales.show', $sale) }}" class="btn btn-outline-secondary btn-sm" title="Show Sale">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @endcan
                                            @can('Delete Sales')
                                            <!-- Button trigger for danger theme modal -->
                                            <button type="button" class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#modalDelete{{ $sale->id }}" title="Delete Sale">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                            @endcan
                                            @can('Edit Sales')
                                            <form id="switchForm{{ $sale->id }}" action="{{ route('sales.toggle', $sale) }}" method="POST" class="form">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="page" value="{{ $sales->currentPage() }}">
                                                <div class="custom-control cursor-pointer custom-switch custom-switch-off-danger custom-switch-on-success ml-2" title="Enable/disable Sale">
                                                    <input type="checkbox" name="disable-sale" class="custom-control-input switch-trigger" id="customSwitch{{ $sale->id }}" data-incomeid="{{ $sale->id }}" {{ $sale->status == 1 ? 'checked' : '' }}>
                                                    <label class="custom-control-label" for="customSwitch{{ $sale->id }}"></label>
                                                </div>
                                            </form>
                                            @endcan
                                        </td>
                                        <td>{{ $sale->id }}</td>
                                        <td>{{ \Carbon\Carbon::parse($sale->date)->format('Y-m-d') }}</td>
                                        <td>{{ $sale->client }}</td>
                                        <td>{{ $sale->voucher_type . ': ' . $sale->voucher_number }}</td>
                                        <td>{{ $sale->product }}</td>
                                        <td>{{ $sale->total }}</td>
                                        <td>{{ $sale->status === '1' ? 'Aproved' : 'Pending' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $sales->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Hoverable rows end -->

@endsection

@section('scripts')
    <script>
        $(function () {
            $('#table_sales').DataTable({
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
            var table = $('#table_sales').DataTable();
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
@endsection
