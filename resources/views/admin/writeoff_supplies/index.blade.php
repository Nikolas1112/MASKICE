@extends('admin.partials.master')
@section('writeoff_supplies_active')
active
@endsection
@section('title')
{{ __('Services') }}
@endsection
@section('main-content')
<section class="section">
    <div class="section-body ">
        <div class="d-flex justify-content-between">
            <div class="d-block">
                <h2 class="section-title">{{__('All Write-Off Supplies')}}</h2>
            </div>
            <div class="buttons add-button">
                <a href="{{ route('writeoff.supplies.create') }}" class="btn btn-icon icon-left btn-outline-primary">
                    <i class='bx bx-plus'></i>{{ __('Add new Write-Off Supplies') }}
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-xs-12 col-md-12">
                <div class="card">
                    <form action="">
                        <div class="card-header input-title">
                            <h4>{{__('Write-Off Supplies')}}</h4>
                        </div>
                    </form>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped table-md">
                                <tbody>
                                <tr>
                                    <th>{{__('#')}}</th>
                                    <th>{{__('Shop Name')}}</th>
                                    <th>{{__('Product SKU')}}</th>
                                    <th>{{__('Write-Off Quantites')}}</th>
                                    <th>{{__('Reason')}}</th>
                                    <th>{{__('Added At')}}</th>
                                    <th>{{__('Action')}}</th>
                                </tr>
                                @foreach($write_off_supplies as $key => $write_off_supplier)

                                <tr id="row_{{ $write_off_supplier->id }}" class="table-data-row">
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $write_off_supplier->shop_name }}</td>
                                    <td>{{ $write_off_supplier->product_sku_code }}</td>
                                    <td>{{ $write_off_supplier->writeoff_quantities }}</td>
                                    <td>{{ $write_off_supplier->reason }}</td>
                                    <td>{{ \Carbon\Carbon::parse($write_off_supplier->added_at)->format('d-m-Y H:i') }}</td>
                                    <td>
                                        <a href="{{route('writeoff.supplies.edit',$write_off_supplier->id)}}" class="btn btn-outline-secondary btn-circle"
                                           data-toggle="tooltip" title=""
                                           data-original-title="{{ __('Edit') }}"><i class="bx bx-edit"></i></a>
                                        <a href="javascript:void(0)" onclick="delete_row('delete/writeoff_supplies/',{{ $write_off_supplier->id }})"
                                           class="btn btn-outline-danger btn-circle" data-toggle="tooltip"
                                           title=""
                                           data-original-title="{{ __('Delete') }}"><i class="bx bx-trash"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        <nav class="d-inline-block">
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
