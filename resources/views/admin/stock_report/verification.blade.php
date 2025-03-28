@extends('admin.partials.master')


@section('admin_report_active', 'active')
@section('stock_report_active', 'active')
@section('stock_verification', 'active') {{-- This marks the Stock Verification tab as active --}}

@section('title')
    {{ __('Stock Verification') }}
@endsection


@section('main-content')
    <section class="section">
        <div class="section-body">
            <!-- Header -->
            <div class="d-flex justify-content-between">
                <div class="d-block">
                    <h2 class="section-title">{{ __('Stock Verification') }}</h2>
                    <p class="section-lead">{{ __('Review and verify stock levels and discrepancies.') }}</p>
                </div>
            </div>

            <!-- Stock Verification Table -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>{{ __('Stock Verification Details') }}</h4>
                        </div>
                        <div class="card-body">
                            @if(count($verifications) > 0)
                                <div class="table-responsive">
                                    <table class="table table-striped table-md">
                                        <thead>
                                            <tr>
                                                <th>{{ __('Date') }}</th>
                                                <th>{{ __('Product') }}</th>
                                                <th>{{ __('Verified By') }}</th>
                                                <th>{{ __('Recorded Stock') }}</th>
                                                <th>{{ __('Physical Count') }}</th>
                                                <th>{{ __('Discrepancy') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($verifications as $verification)
                                                <tr>
                                                    <td>{{ $verification->date }}</td>
                                                    <td>{{ $verification->product->name ?? 'N/A' }}</td>
                                                    <td>{{ $verification->verified_by }}</td>
                                                    <td>{{ $verification->recorded_stock }}</td>
                                                    <td>{{ $verification->physical_count }}</td>
                                                    <td>{{ $verification->discrepancy }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <p>{{ __('No verification records found.') }}</p>
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
