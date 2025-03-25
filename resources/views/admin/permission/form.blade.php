@extends('admin.partials.master')

@php
    $title = isset($edit) ? trans('Edit Permission') : __('Add New Permission');
@endphp

@section('title')
    {{ $title }}
@endsection

@section('main-content')
    <section class="section">
        <div class="section-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="section-title">{{ $title }}</h2>
                <a href="{{ route('permission.index') }}" class="btn btn-outline-primary">
                    <i class="bx bx-arrow-back"></i> {{ __('Back') }}
                </a>
            </div>
            <div class="row">
                <div class="col-md-8 mx-auto">
                    <div class="card shadow-sm">
                        <div class="card-header input-title">
                            <h4>{{ isset($edit) ? __('Edit Permission') : __('Add Permission') }}</h4>
                        </div>
                        <div class="card-body">
                            @php
                                $route = isset($edit) ? route('permission.update', $edit->id) : route('permission.store');
                            @endphp

                            <form method="POST" action="{{ $route }}" enctype="multipart/form-data">
                                @csrf
                                @isset($edit)
                                    @method('PUT')
                                @endisset

                                <div class="form-group">
                                    <label for="attribute" class="fw-bold">{{ __('Attribute') }}</label>
                                    <input type="text" class="form-control form-control-lg" name="attribute" id="attribute"
                                           value="{{ isset($edit) ? $edit->attribute : old('attribute') }}" required>
                                </div>

                                <div class="form-group">
                                    <label class="fw-bold">{{ __('Keywords') }}</label>
                                    <div class="d-flex flex-wrap gap-3">
                                        <div class="custom-control custom-checkbox" style="margin-right:15px;">
                                            <input type="checkbox" name="permissions[]" value="read" class="custom-control-input" id="read"
                                                {{ isset($edit) && isset($edit->keywords['read']) ? 'checked' : '' }}>
                                            <label class="custom-control-label fw-bold" for="read" style="font-size: 17px;">Read</label>
                                        </div>
                                        <div class="custom-control custom-checkbox" style="margin-right:15px;">
                                            <input type="checkbox" name="permissions[]" value="create" class="custom-control-input" id="create"
                                                {{ isset($edit) && isset($edit->keywords['create']) ? 'checked' : '' }}>
                                            <label class="custom-control-label fw-bold" for="create" style="font-size: 17px;">Create</label>
                                        </div>
                                        <div class="custom-control custom-checkbox" style="margin-right:15px;">
                                            <input type="checkbox" name="permissions[]" value="update" class="custom-control-input" id="update"
                                                {{ isset($edit) && isset($edit->keywords['update']) ? 'checked' : '' }}>
                                            <label class="custom-control-label fw-bold" for="update" style="font-size: 17px;">Update</label>
                                        </div>
                                        <div class="custom-control custom-checkbox" style="margin-right:15px;">
                                            <input type="checkbox" name="permissions[]" value="delete" class="custom-control-input" id="delete"
                                                {{ isset($edit) && isset($edit->keywords['delete']) ? 'checked' : '' }}>
                                            <label class="custom-control-label fw-bold" for="delete" style="font-size: 17px;">Delete</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group text-right">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="bx bx-save"></i> {{ isset($edit) ? __('Update') : __('Save') }}
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
