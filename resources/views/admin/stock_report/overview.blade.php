@extends('admin.partials.master')

@section('stock_report_active', 'active')
@section('stock_overview', 'active')  {{-- This marks the Overview tab active --}}
@section('title')
    {{ __('Stock Report Overview') }}
@endsection
@php

    $filter = request()->get('filter', null);
@endphp

@section('main-content')
    <section class="section">
        <div class="section-body">
            <!-- Header Section -->
            <div class="d-flex justify-content-between">
                <div class="d-block">
                    <h2 class="section-title">{{ __('Stock Report') }}</h2>
                    <p class="section-lead">
                        {{ __('Overview of Stock Levels') }}
                    </p>
                </div>
            </div>
            <!-- Optional Filter Form -->
            <div class="row">
                <div class="col-sm-xs-12 col-md-9 middle">
                    <div class="card">
                        <div class="card-body">
                        <form id="filterForm" method="GET">
                            <div class="form-row">
                                <div class="form-group col-sm-xs-12 col-md-5">
                                    <label for="filter">{{ __('Filter') }}</label>
                                    <input type="text" name="filter" id="filter"
                                        value="{{ old('filter', $filter) }}"
                                        placeholder="{{ __('Enter filter keyword') }}"
                                        class="form-control">
                                </div>
                                <div class="form-group col-sm-xs-12 col-md-2 ">
                                    <label>&nbsp;</label>
                                    <button type="submit" class="btn btn-outline-primary form-control">{{ __('Apply') }}</button>
                                </div>
                            </div>
                        </form>

                        </div>
                    </div>
                </div>
            </div>
            <!-- Stock Overview Table -->
            <div class="row">
                 <div class="col-sm-xs-12 col-md-9 middle">
                    <div class="card">
                        <div class="card-header">
                            <h4>{{ __('Stock Overview') }}</h4>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-striped table-md">
                                    <thead>
                                        <tr>
                                            <th>{{ __('SKU') }}</th>
                                            <th>{{ __('Status') }}</th>
                                            <th>{{ __('Total Quantity') }}</th>
                                            <th>{{ __('Reserved Quantity') }}</th>
                                            <th>{{ __('Available Quantity') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($products as $product)
                                            <tr>
                                                <td>{{ $product->barcode ?? 'N/A' }}</td>
                                                <td>{{ $product->status }}</td>
                                                <td>{{ $product->current_stock }}</td>
                                                <td>{{ $product->reserved_quantity ?? 0 }}</td>
                                                <td>
                                                    {{ $product->available_quantity ?? ($product->current_stock - ($product->reserved_quantity ?? 0)) }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- If you need pagination, add it here -->
                        <div class="card-footer">
                            <nav class="d-inline-block">
                                {{ $products->appends(Request::except('page'))->links('pagination::bootstrap-4') }}
                            </nav>
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
