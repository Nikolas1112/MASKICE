@extends('admin.partials.master')

@section('administrators_active')
    active
@endsection
@section('warehouseWorker_active')
    active
@endsection

@section('title')
    {{ __('Warehouses') }}
@endsection

@section('main-content')
    <section class="section">
        <div class="section-body">
            <div class="d-flex justify-content-between">
                <div class="d-block">
                    <h2 class="section-title">{{ __('All Warehouses Worker') }}</h2>
                </div>
                
            </div>

            <div class="row">
                <div class="col-sm-xs-12 col-md-12">
                    <div class="card">
                        <form action="">
                            <div class="card-header input-title">
                                <h4>{{ __('Warehouse Worker List') }}</h4>
                            </div>
                        </form>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-striped table-md">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{ __('Group') }}</th>
                                            <th>{{ __('Username') }}</th>
                                            <th>{{ __('Warehouse') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($warehouseworkers as $worker)
                                            <tr id="row_{{ $worker->id }}">
                                                <td>{{ $worker->id }}</td>
                                                <td>{{ $worker->group }}</td>
                                                <td>{{ $worker->username }}</td>
                                                <td>{{ $worker->warehouse }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer">
                            <nav class="d-inline-block">
                                {{ $warehouseworkers->appends(Request::except('page'))->links('pagination::bootstrap-4') }}
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('admin.common.selector-modal')
@endsection

@include('admin.common.delete-ajax')

@section('style')
    <link rel="stylesheet" href="{{ static_asset('admin/css/dropzone.css') }}">
@endsection

@push('script')
    <script type="text/javascript" src="{{ static_asset('admin/js/dropzone.min.js') }}"></script>
@endpush

