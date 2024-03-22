@extends('layouts.admin')
@section('content')
    
    <!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('providers.index') }}">Providers</a></li>
                    <li class="breadcrumb-item active">{{ $provider->name }}</li>
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
                    <h3 class="card-title">{{ $provider->name }}</h3>
                </div>
                <form action="{{route('providers.update', $provider)}}" method="POST" class="form">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="name" class="col-form-label">Name:</label>
                                    <input type="text" value="{{ $provider->name }}" class="form-control" name="name" id="name" aria-describedby="name-error" aria-invalid="true">
                                </div>
                                <div class="form-group">
                                    <label for="id_type" class="col-form-label">ID Type</label>
                                    <select class="form-control" name="id_type" id="id_type">
                                        <option value="Citizenship Card" title="Citizenship Card" {{ $provider->id_type === 'Citizenship Card' ? 'selected' : '' }}>Citizenship Card</option>
                                        <option value="Foreigner ID" title="Foreigner ID" {{ $provider->id_type === 'Foreigner ID' ? 'selected' : '' }}>Foreigner ID</option>
                                        <option value="Identity Card" title="Identity Card" {{ $provider->id_type === 'Identity Card' ? 'selected' : '' }}>Identity card</option>
                                        <option value="NIT" title="NIT" {{ $provider->id_type === 'NIT' ? 'selected' : '' }}>NIT</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="id_number" class="col-form-label">ID Number:</label>
                                    <input type="number" value="{{ $provider->id_number }}" class="form-control" name="id_number" id="id_number" aria-describedby="-error" aria-invalid="true" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="address" class="col-form-label">Address:</label>
                                    <input type="text" value="{{ $provider->address }}" class="form-control" name="address" id="address" aria-describedby="-error" aria-invalid="true">
                                </div>
                                <div class="form-group">
                                    <label for="phone" class="col-form-label">Phone:</label>
                                    <input type="number" value="{{ $provider->phone }}" class="form-control" name="phone" id="phone" aria-describedby="-error" aria-invalid="true">
                                </div>
                                <div class="form-group">
                                    <label for="email" class="col-form-label">Email:</label>
                                    <input type="text" value="{{ $provider->email }}" class="form-control" name="email" id="email" aria-describedby="-error" aria-invalid="true">
                                </div>
                            </div>
                        </div>
                    </div>
                       
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Update</button>
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

        $(document).ready(function() {
            // Inicializar el validador para el modal de creación
            $('.form').validate({
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
        });

    </script>
@endsection
