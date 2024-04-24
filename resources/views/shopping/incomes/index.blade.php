@extends('layouts.admin')
@section('content')
    
    <!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">INCOMES</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Incomes</li>
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
                                <form action="{{ route('incomes.index') }}" method="GET">
                                    <div class="input-group mb-6">
                                        <span class="input-group-text" id="basic-addon1"><i class="bi bi-search"></i></span>
                                        <input type="text" class="form-control" name="searchText" placeholder="Search incomes" value="{{ $searchText }}" aria-label="Recipient's username" aria-describedby="button-addon2">
                                        <button class="btn btn-outline-secondary" type="submit" id="button-addon2">Search</button>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-2">
                                <div class="input-group mb-6">
                                    <span class="input-group-text" id="basic-addon1"><i class="bi bi-plus-circle-fill"></i></span>
                                    <a class="bth btn-primary btn-sm" href="{{ route('incomes.create') }}">
                                        <i class="fas fa-plus"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-4 d-flex justify-content-end">
                                @if($searchText === '')
                                <div class="btn-group btn-sm align-middle">
                                    <form action="#">
                                        <button id="copy" class="btn btn-secondary" type="button" title="Copy page to clipboard">Copy</button>
                                    </form>
                                    <form action="{{ route( 'export.csv', ['table_name' => 'incomes'] ) }}" method="POST">
                                        @csrf
                                        <button class="btn btn-secondary" type="submit" title="Export to CSV">CSV</button>
                                    </form>
                                    <form action="{{ route( 'export.excel', ['table_name' => 'incomes'] ) }}" method="POST">
                                        @csrf
                                        <button class="btn btn-secondary" type="submit" title="Export to Excel">Excel</button>
                                    </form>
                                    <form action="{{ route( 'export.pdf', ['table_name' => 'incomes'] ) }}" method="POST">
                                        @csrf
                                        <button class="btn btn-secondary" type="submit" title="Export to PDF">PDF</button>
                                    </form>
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
                                @foreach ($incomes as $income)
                                    <tr>
                                        <td class="btn-group btn-sm align-items-center">
                                            <!-- Button trigger for edit theme modal -->
                                            <a href="{{ route('incomes.show', $income) }}" class="btn btn-secondary btn-sm" title="Show Income">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <!-- Button trigger for danger theme modal -->
                                            <button type="button" class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#modalDelete{{ $income->id }}" title="Delete Income">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>

                                            <form id="switchForm{{ $income->id }}" action="{{ route('incomes.toggle', $income) }}" method="POST" class="form">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="page" value="{{ $incomes->currentPage() }}">
                                                <div class="custom-control cursor-pointer custom-switch custom-switch-off-danger custom-switch-on-success ml-2" title="Enable/disable Income">
                                                    <input type="checkbox" name="disable-income" class="custom-control-input switch-trigger" id="customSwitch{{ $income->id }}" data-incomeid="{{ $income->id }}" {{ $income->status == 1 ? 'checked' : '' }}>
                                                    <label class="custom-control-label" for="customSwitch{{ $income->id }}"></label>
                                                </div>
                                            </form>
                                        </td>
                                        <td>{{ $income->id }}</td>
                                        <td>{{ \Carbon\Carbon::parse($income->date)->format('Y-m-d') }}</td>
                                        <td>{{ $income->provider }}</td>
                                        <td>{{ $income->voucher_type . ': ' . $income->voucher_number }}</td>
                                        <td>{{ $income->product }}</td>
                                        <td>{{ $income->total }}</td>
                                        <td>{{ $income->status === '1' ? 'Aproved' : 'Pending' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $incomes->links() }}
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
@endsection
