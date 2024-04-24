@extends('layouts.admin')
@section('content')
    
    <!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('incomes.index') }}">Incomes</a></li>
                    <li class="breadcrumb-item active">Show</li>
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
                    <h3 class="card-title">Show Income</h3>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="provider" class="col-form-label">Provider</label>
                                <p class="form-control">{{ $income->provider }}</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="voucher_type" class="col-form-label">Voucher Type</label>
                                <p class="form-control">{{ $income->voucher_type }}</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="voucher_number" class="col-form-label">Voucher Number:</label>
                                <p class="form-control">{{ $income->voucher_number }}</p>
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
                                        @php
                                            $total = 0;
                                        @endphp
                                        @foreach($income_detail as $detail)
                                            @php
                                                $subtotal = number_format($detail->amount * $detail->purchase_price, 2);
                                                $total += $subtotal;
                                            @endphp
                                            <tr>
                                                <td>{{ $detail->product }}</td>
                                                <td>{{ $detail->amount }}</td>
                                                <td>{{ $detail->purchase_price }}</td>
                                                <td>{{ $detail->sale_price }}</td>
                                                <td>{{ $subtotal }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <th class="text-center">TOTAL</th>
                                        <th colspan="3"></th>
                                        <th><h4 class="text-center" id="total">$ {{ number_format($total, 2) }}</h4></th>
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

@endsection

@section('scripts')
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
@endsection
