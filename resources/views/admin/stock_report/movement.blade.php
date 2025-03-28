@extends('admin.partials.master')

@section('admin_report_active', 'active')
@section('stock_report_active', 'active')
@section('stock_movement', 'active')  {{-- This sets the Stock Movement tab as active --}}

@section('title')
    {{ __('Stock Movement') }}
@endsection

@section('main-content')
    <section class="section">
        <div class="section-body">
            <!-- Header -->
            <div class="d-flex justify-content-between">
                <div class="d-block">
                    <h2 class="section-title">{{ __('Stock Movement') }}</h2>
                    <p class="section-lead">{{ __('View details of stock movements for products.') }}</p>
                </div>
            </div>

            <!-- Stock Movement Table -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>{{ __('Stock Movement Details') }}</h4>
                        </div>
                        <div class="card-body">
                            @if($stockMovements->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-striped table-md">
                                        <thead>
                                            <tr>
                                                <th>{{ __('Date') }}</th>
                                                <th>{{ __('Product') }}</th>
                                                <th>{{ __('Movement Type') }}</th>
                                                <th>{{ __('Quantity') }}</th>
                                                <th>{{ __('Remarks') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($stockMovements as $movement)
                                                <tr>
                                                    <td>{{ $movement->created_at->format('Y-m-d H:i:s') }}</td>
                                                    <td>{{ $movement->product->name ?? 'N/A' }}</td>
                                                    <td>{{ ucfirst($movement->movement_type) }}</td>
                                                    <td>{{ $movement->quantity }}</td>
                                                    <td>{{ $movement->reference ?? '-' }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <!-- Pagination Controls -->
                                <div class="d-flex justify-content-center">
                                    {{ $stockMovements->links() }}
                                </div>
                            @else
                                <p>{{ __('No stock movements found.') }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('page-style')
    <link rel="stylesheet" href="{{ static_asset('admin/css/daterangepicker.css') }}">
@endsection

@push('script')
    <script type="text/javascript" src="{{ static_asset('admin/js/daterangepicker.min.js') }}"></script>
    <script type="text/javascript" src="{{ static_asset('admin/js/daterangepicker_customs.js') }}"></script>
@endpush
