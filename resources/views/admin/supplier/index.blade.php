@extends('admin.partials.master')

@section('supplier_active')
    active
@endsection

@section('title')
    {{ __('Physical Shops') }}
@endsection

@section('main-content')
    <section class="section">
        <div class="section-body">
            <div class="d-flex justify-content-between">
                <h2 class="section-title">{{ __('All Suppliers') }}</h2>
                <div class="buttons add-button">
                    <a href="{{ route('supplier.create') }}" class="btn btn-outline-primary">
                        <i class='bx bx-plus'></i> {{ __('Add New Supplier') }}
                    </a>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <form action="">
                            <div class="card-header input-title">
                                <h4>{{ __('Supplier') }}</h4>
                            </div>
                        </form>

                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{ __('Name') }}</th>
                                            <th>{{ __('Supplier Code') }}</th>
                                            <th>{{ __('Supplier Price') }}</th>
                                            <th>{{ __('Product Link') }}</th>
                                            <th>{{ __('Options') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($suppliers as $key => $supplier)
                                        <tr id="row_{{ $supplier->id }}">
                                            <td>{{ $loop->iteration }}</td>  {{-- Using Laravel's built-in $loop helper --}}
                                            <td>{{ $supplier->name }}</td>
                                            <td>{{ $supplier->supplier_code }}</td>
                                            <td>{{ $supplier->supplier_price }}</td>
                                            <td>
                                                <a href="{{ $supplier->product_link }}" target="_top" class="text-primary">
                                                    {{ __('View Product') }}
                                                </a>
                                            </td>
                                            <td>
                                                <a href="{{ route('supplier.edit', $supplier->id) }}" class="btn btn-outline-secondary btn-circle">
                                                    <i class="bx bx-edit"></i>
                                                </a>
                                                <a href="javascript:void(0)" onclick="delete_row('delete/suppliers/', {{ $supplier->id }})" class="btn btn-outline-danger btn-circle">
                                                    <i class="bx bx-trash"></i>
                                                </a>
                                            </td>
                                            </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        @if($suppliers->hasPages())
                            <div class="card-footer d-flex justify-content-center">
                                {{ $suppliers->links('pagination::bootstrap-4') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@include('admin.common.delete-ajax')
