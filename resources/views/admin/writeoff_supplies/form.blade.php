@extends('admin.partials.master')

@php
$title = isset($writeoff_supplies) ? trans('Write-Off Supplies Edit') : __('Add Write-Off Supplies ')
@endphp
@section('title')
{{ $title}}
@endsection
@section('main-content')
<section class="section">
    <div class="section-body ">
        <div class="d-flex justify-content-between">
            <div class="d-block">
                <h2 class="section-title">{{ $title }}</h2>
            </div>
            <div class="buttons add-button">
                <a href="{{ route('writeoff.supplies.index')}}" class="btn btn-icon icon-left btn-outline-primary"><i
                            class="bx bx-arrow-back"></i>{{ __('Back') }}</a>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-xs-12 col-md-8 middle">
                <div class="card">
                    <div class="card-header input-title">
                        <h4>{{ isset($writeoff_supplies) ? trans('Edit Write-Off') : __('Add New Write-Off')}}</h4>
                    </div>
                    <div class="card-body card-body-paddding">
                        @php
                        $route = isset($writeoff_supplies) ? route('writeoff.supplies.update',$writeoff_supplies->id) : route('writeoff.supplies.store')
                        @endphp
                        @isset($writeoff_supplies)

                        @endisset
                        <form method="POST" action="{{ $route }}" enctype="multipart/form-data">
                            @csrf
                            @isset($writeoff_supplies)
                            @method('put')

                            <input type="hidden" value="{{ old('r') ? old('r') : (@$r ? $r : url()->previous() )}}" name="r">
                            @endisset
                            
                            <div class="form-group">
                                <label for="shop_name">{{__('Shop')}}</label>
                                <select class="form-control" name="shop_name" id="shop_name" required>
                                    <option value="" disabled selected>{{ __('Select Shop') }}</option>
                                    @foreach($physical_shops as $shop)
                                        <option value="{{ $shop->name }}" {{ isset($writeoff_supplies) && $writeoff_supplies->shop_name == $shop->name ? 'selected' : (old('shop_name') == $shop->name ? 'selected' : '') }}>
                                            {{ $shop->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @if ($errors->has('shop_name'))
                                <div class="invalid-feedback">
                                    <p>{{ $errors->first('shop_name') }}</p>
                                </div>
                                @endif
                            </div>



                            <div class="form-group">
                                <label for="title">{{__('Product SKU Code')}}</label>
                                <input type="text" class="form-control" name="product_sku_code" id="product_sku_code"
                                       value="{{ isset($writeoff_supplies) ? $writeoff_supplies->product_sku_code : old('product_sku_code') }}"
                                       placeholder="{{__('Product SKU Code')}}" tabindex="1" required>
                                @if ($errors->has('product_sku_code'))
                                <div class="invalid-feedback">
                                    <p>{{ $errors->first('product_sku_code') }}</p>
                                </div>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="title">{{__('Write-Off Quantities')}}</label>
                                <input type="text" class="form-control" name="writeoff_quantities" id="writeoff_quantities"
                                       value="{{ isset($writeoff_supplies) ?  $writeoff_supplies->writeoff_quantities : old('writeoff_quantities') }}"
                                       placeholder="{{__('Write-Off Quantities')}}" tabindex="1" required {{ isset($writeoff_supplies) ? 'readonly' : '' }}>
                                @if ($errors->has('writeoff_quantities'))
                                <div class="invalid-feedback">
                                    <p>{{ $errors->first('writeoff_quantities') }}</p>
                                </div>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="title">{{__('Reason')}}</label>
                                <input type="text" class="form-control" name="reason" id="reason"
                                       value="{{ isset($writeoff_supplies) ? $writeoff_supplies->reason : old('reason') }}"
                                       placeholder="{{__('Reason')}}" tabindex="1" required>
                                @if ($errors->has('reason'))
                                <div class="invalid-feedback">
                                    <p>{{ $errors->first('reason') }}</p>
                                </div>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="title">{{__('Entry At')}}</label>
                              
                                <input type="date" class="form-control" name="added_at" id="added_at"
                                       value="{{ isset($writeoff_supplies) ? \Carbon\Carbon::parse($writeoff_supplies->added_at)->format('Y-m-d') : old('added_at') }}"
                                       placeholder="{{__('Entry At')}}" tabindex="1" required>
                                @if ($errors->has('added_at'))
                                <div class="invalid-feedback">
                                    <p>{{ $errors->first('added_at') }}</p>
                                </div>
                                @endif
                            </div>

                            <div class="form-group text-right">
                                <button type="submit" class="btn btn-outline-primary" tabindex="4">
                                    {{ __('Save') }}
                                </button>
                            </div>
                        </form>
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



