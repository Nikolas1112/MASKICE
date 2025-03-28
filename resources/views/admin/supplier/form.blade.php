@extends('admin.partials.master')

@php
    $title = isset($edit) ? trans('Edit Supplier') : __('Add New Supplier');
@endphp

@section('title')
    {{ $title }}
@endsection

@section('main-content')
    <section class="section">
        <div class="section-body">
            <div class="d-flex justify-content-between">
                <h2 class="section-title">{{ $title }}</h2>
                <div class="buttons add-button">
                <a href="{{ route('supplier.index') }}" class="btn btn-outline-primary"><i class="bx bx-arrow-back"></i> {{ __('Back') }}</a>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-8 mx-auto">
                    <div class="card">
                        <div class="card-header input-title">
                            <h4>{{ isset($edit) ? __('Edit Supplier') : __('Add New Supplier') }}</h4>
                        </div>
                        <div class="card-body">
                            @php
                                $route = isset($edit) ? route('supplier.update', $edit->id) : route('supplier.store')
                            @endphp

                            <form method="POST" action="{{ $route }}" enctype="multipart/form-data">
                                @csrf
                                @isset($edit)
                                    @method('PUT')
                                @endisset

                                <div class="form-group">
                                    <label for="name">{{__('Name')}}</label>
                                    <input type="text" class="form-control" name="name" id="name"
                                        value="{{ isset($edit) ? $edit->name : old('name') }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="supplier_code">{{__('Supplier code')}}</label>
                                    <input type="text" class="form-control" name="supplier_code" id="supplier_code"
                                        value="{{ isset($edit) ? $edit->supplier_code : old('supplier_code') }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="supplier_price">{{__('Supplier price')}}</label>
                                    <input type="text" class="form-control" name="supplier_price" id="supplier_price"
                                        value="{{ isset($edit) ? $edit->supplier_price : old('supplier_price') }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="product_link">{{__('Product link')}}</label>
                                    <input type="text" class="form-control" name="product_link" id="product_link"
                                        value="{{ isset($edit) ? $edit->product_link : old('product_link') }}" required>
                                </div>
                                

                                <div class="form-group text-right">
                                    <button type="submit" class="btn btn-primary">
                                        {{ isset($edit) ? __('Update') : __('Save') }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('style')
    <link rel="stylesheet" href="{{ static_asset('admin/css/custom.css') }}">
@endsection
