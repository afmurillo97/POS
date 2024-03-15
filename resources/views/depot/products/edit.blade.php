@extends('layouts.admin')
@section('content')
    
    <!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Products</a></li>
                    <li class="breadcrumb-item active">{{ $product->name }}</li>
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
                    <h3 class="card-title">{{ $product->name }} [ {{ $product->code }} ]</h3>
                </div>
                <form action="{{route('products.update', $product)}}" method="POST" enctype="multipart/form-data" class="form">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="product" class="col-form-label">Name:</label>
                                    <input type="text" value="{{ $product->name }}" class="form-control" name="name" id="name" aria-describedby="product-error" aria-invalid="true" placeholder="Enter a product name">
                                </div>
                                <div class="form-group">
                                    <label>Category</label>
                                    <select class="form-control" name="category_id" id="category_id">
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" title="{{ $category->description }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="product" class="col-form-label">Code:</label>
                                    <input type="text" value="{{ $product->code }}" class="form-control" name="code" id="code" aria-describedby="product-error" aria-invalid="true" placeholder="Enter the product code">
                                </div>
                                <div class="form-group">
                                    <label for="product" class="col-form-label">Stock:</label>
                                    <input type="number" value="{{ $product->stock }}" class="form-control" name="stock" id="stock" aria-describedby="product-error" aria-invalid="true" placeholder="Enter the quantity in stock">
                                </div>
                                <div class="form-group">
                                    <label for="description" class="col-form-label">Description:</label>
                                    <textarea class="form-control" name="description" id="description">{{ $product->description }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="image">Update Image:</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="image" id="image" accept="image/jpeg,image/png,image/bmp">
                                        <label class="custom-file-label" for="image">Choose a new image for the product</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card-body">
                                @if($product->image)
                                <div class="form-group">
                                    <label for="currentImage">&nbsp;</label>
                                    <img class="img-fluid pad" src="{{ asset($product->image) }}" alt="{{ $product->name }}" id="currentImage">
                                </div>
                                @endif
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
        });

    </script>
@endsection
