@extends('admin.partials.master')

@php
    $title = isset($edit) ? trans('Edit Redirect') : __('Add New Redirect');
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
                <a href="{{ route('redirect.index') }}" class="btn btn-outline-primary"><i class="bx bx-arrow-back"></i> {{ __('Back') }}</a>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-8 mx-auto">
                    <div class="card">
                        <div class="card-header input-title">
                            <h4>{{ isset($edit) ? __('Edit Redirect') : __('Add New Redirect') }}</h4>
                        </div>
                        <div class="card-body">
                            @php
                                $route = isset($edit) ? route('redirect.update', $edit->id) : route('redirect.store')
                            @endphp

                            <form method="POST" action="{{ $route }}" enctype="multipart/form-data">
                                @csrf
                                @isset($edit)
                                    @method('PUT')
                                @endisset

                                <div class="form-group">
                                    <label for="main_url">{{__('Main Url')}}</label>
                                    <input type="text" class="form-control" name="main_url" id="main_url" placeholder="http://127.0.0.1:8000/"
                                        value="{{ isset($edit) ? $edit->main_url : old('main_url') }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="redirect_url">{{__('Redirect Url')}}</label>    
                                    <input type="text" class="form-control" name="redirect_url" id="redirect_url"
                                        value="{{ isset($edit) ? $edit->redirect_url : old('redirect_url') }}" required>
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
