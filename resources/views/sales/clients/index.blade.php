@extends('layouts.admin')
@section('content')
    
    <!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">CLIENTS</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Clients</li>
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
                                <form action="{{ route('clients.index') }}" method="GET">
                                    <div class="input-group mb-6">
                                        <span class="input-group-text" id="basic-addon1"><i class="bi bi-search"></i></span>
                                        <input type="text" class="form-control" name="searchText" placeholder="Search clients" value="{{ $searchText }}" aria-label="Recipient's username" aria-describedby="button-addon2">
                                        <button class="btn btn-outline-secondary" type="submit" id="button-addon2">Search</button>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-2">
                                <div class="input-group mb-6">
                                    @can('Create Clients')
                                    <span class="input-group-text" id="basic-addon1"><i class="bi bi-plus-circle-fill"></i></span>
                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalCreate" title="New Client">
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
                                    @can('Export Clients')
                                    <form action="{{ route( 'export.csv', ['table_name' => 'clients'] ) }}" method="POST">
                                        @csrf
                                        <button class="btn btn-secondary" type="submit" title="Export to CSV">CSV</button>
                                    </form>
                                    <form action="{{ route( 'export.excel', ['table_name' => 'clients'] ) }}" method="POST">
                                        @csrf
                                        <button class="btn btn-secondary" type="submit" title="Export to Excel">Excel</button>
                                    </form>
                                    <form action="{{ route( 'export.pdf', ['table_name' => 'clients'] ) }}" method="POST">
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
                        <table id="table_clients" class="table table-striped w-100" aria-describedby="table_categories_info">
                            <thead>
                                <tr>
                                    <th>Actions</th>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Client Type</th>
                                    <th>ID Type</th>
                                    <th>ID Number</th>
                                    <th>Address</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($clients as $client)
                                    <tr>
                                        <td class="btn-group btn-sm align-items-center">
                                            @can('Edit Clients')
                                            <!-- Button trigger for edit theme modal -->
                                            <button type="button" class="btn btn-outline-warning btn-sm editClient" data-toggle="modal" data-target="#modalEdit{{ $client->id }}" title="Update Client">
                                                <i class="fas fa-pen"></i>
                                            </button>
                                            @endcan
                                            @can('Delete Clients')
                                            <!-- Button trigger for danger theme modal -->
                                            <button type="button" class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#modalDelete{{ $client->id }}" title="Delete Client">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                            @endcan
                                            @can('Edit Clients')
                                            <form id="switchForm{{ $client->id }}" action="{{ route('clients.toggle', $client) }}" method="POST" class="form">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="page" value="{{ $clients->currentPage() }}">
                                                <div class="custom-control cursor-pointer custom-switch custom-switch-off-danger custom-switch-on-success ml-2" title="Enable/disable Client">
                                                    <input type="checkbox" name="disable-client" class="custom-control-input switch-trigger" id="customSwitch{{ $client->id }}" data-clientid="{{ $client->id }}" {{ $client->status == 1 ? 'checked' : '' }}>
                                                    <label class="custom-control-label" for="customSwitch{{ $client->id }}"></label>
                                                </div>
                                            </form>
                                            @endcan
                                            
                                        </td>
                                        <td>{{ $client->id }}</td>
                                        <td>{{ $client->name }}</td>
                                        <td>{{ $client->client_type }}</td>
                                        <td>{{ $client->id_type }}</td>
                                        <td>{{ $client->id_number }}</td>
                                        <td>{{ $client->address }}</td>
                                        <td>{{ $client->phone }}</td>
                                        <td>{{ $client->email }}</td>
                                    </tr>
                                    @include('sales.clients.modals')
                                @endforeach
                            </tbody>
                        </table>
                        {{ $clients->links() }}
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
                <h5 class="modal-title" id="exampleModalLabel">Create Client</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('clients.store') }}" method="POST" class="form">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name" class="col-form-label">Name:</label>
                        <input type="text" class="form-control" name="name" id="name" aria-describedby="name-error" aria-invalid="true">
                    </div>
                    <div class="form-group">
                        <label for="client_type" class="col-form-label">Client Type:</label>
                        <input type="text" class="form-control" name="client_type" id="client_type" aria-describedby="client_type-error" aria-invalid="true">
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
                    @can('Create Clients')
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
            // Inicializar el validador para el modal de creación
            $('#modalCreate .form').validate({
                rules: {
                    name: {
                        required: true
                    },
                    client_type: {
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
                        required: "Please enter a client name"
                    },
                    client_type: {
                        required: "Please enter a client type "
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
                $('#table_clients').DataTable({
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
            var table = $('#table_clients').DataTable();
            var selectedRows = table.rows({ selected: true }).data();
            var columnsToCopy = [1, 2, 3, 4, 5, 6, 7, 8];

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
