@extends('admin.partials.master')

@php
    $title = isset($edit) ? trans('Edit Physical Shop') : __('Add New Physical Shop');
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
                <a href="{{ route('physical_shops.index') }}" class="btn btn-outline-primary"><i class="bx bx-arrow-back"></i> {{ __('Back') }}</a>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-8 mx-auto">
                    <div class="card">
                        <div class="card-header input-title">
                            <h4>{{ isset($edit) ? __('Edit Physical Shop') : __('Add New Physical Shop') }}</h4>
                        </div>
                        <div class="card-body">
                            @php
                                $route = isset($edit) ? route('physical_shops.update', $edit->id) : route('physical_shops.store')
                            @endphp

                            <form method="POST" action="{{ $route }}" enctype="multipart/form-data">
                                @csrf
                                @isset($edit)
                                    @method('PUT')
                                @endisset

                                <div class="form-group">
                                    <label for="name">{{__('Shop Name')}}</label>
                                    <input type="text" class="form-control" name="name" id="name"
                                        value="{{ isset($edit) ? $edit->name : old('name') }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="address">{{__('Shop Address')}}</label>
                                    <input type="text" class="form-control" name="address" id="address"
                                        value="{{ isset($edit) ? $edit->address : old('address') }}" required>
                                </div>
                                

                                <div class="form-group text-right">
                                    <button type="submit" class="btn btn-primary">
                                        {{ isset($edit) ? __('Update Shop') : __('Create Shop') }}
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
