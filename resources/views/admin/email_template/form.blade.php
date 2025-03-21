
@extends('admin.partials.master')

@php
    $title = isset($edit) ? trans('Email Template Edit') : __('Email Template Add')
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
                    <a href="{{ route('services.index')}}" class="btn btn-icon icon-left btn-outline-primary"><i
                                class="bx bx-arrow-back"></i>{{ __('Back') }}</a>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-xs-12 col-md-8 middle">
                    <div class="card">
                        <div class="card-header input-title">
                            <h4>{{ isset($edit) ? trans('Edit Email Template') : __('Add New Email Template')}}</h4>
                        </div>
                        <div class="card-body card-body-paddding">
                            @php
                                $route = isset($edit) ? route('templates.update',$edit->id) : route('templates.store')
                            @endphp
                            @isset($edit)
                                <form id="lang">
                                    <div class="form-group">
                                        <label for="">{{ __('Language') }}</label>
                                        <input type="hidden" value="{{ old('r') ? old('r') : (@$r ? $r : url()->previous() )}}" name="r">
                                        <select class="form-control selectric lang" name="lang">
                                            <option value="">{{ __('Select Language') }}</option>
                                            @foreach($languages as $language)
                                                <option
                                                        value="{{ $language->locale }}" {{( $lang != '' ? ($language->locale == $lang ? 'selected' : '') : ($language->locale == 'en' ? 'selected' : '')) }}>{{ $language->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </form>
                            @endisset
                            <form method="POST" action="{{ $route }}" enctype="multipart/form-data">
                                @csrf
                                @isset($edit)
                                    @method('put')
                                    <input type="hidden" value="{{ $email_template_language->translation_null == 'not-found' ? '' : $email_template_language->id }}" name="translate_id">

                                    <input type="hidden" value="{{ old('r') ? old('r') : (@$r ? $r : url()->previous() )}}" name="r">
                                    <input type="hidden" value="{{ $lang }}" name="lang">
                                @endisset
                                <div class="form-group">
                                    <label for="title">{{__('Name')}}</label>
                                    <input type="text" class="form-control" name="name" id="name"
                                           value="{{ isset($email_template_language) ? $email_template_language->name : old('name') }}"
                                           placeholder="{{__('Name')}}" tabindex="1" required>
                                    @if ($errors->has('name'))
                                        <div class="invalid-feedback">
                                            <p>{{ $errors->first('name') }}</p>
                                        </div>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="title">{{__('Type')}}</label>
                                    <input type="text" class="form-control" name="type" id="type"
                                           value="{{ isset($email_template_language) ? $email_template_language->type : old('type') }}"
                                           placeholder="{{__('Type')}}" tabindex="1" required>
                                    @if ($errors->has('type'))
                                        <div class="invalid-feedback">
                                            <p>{{ $errors->first('type') }}</p>
                                        </div>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="title">{{__('Subject')}}</label>
                                    <input type="text" class="form-control" name="subject" id="subject"
                                           value="{{ isset($email_template_language) ? $email_template_language->subject : old('subject') }}"
                                           placeholder="{{__('Subject')}}" tabindex="1" required>
                                    @if ($errors->has('subject'))
                                        <div class="invalid-feedback">
                                            <p>{{ $errors->first('subject') }}</p>
                                        </div>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="title">{{__('Description')}}</label>
                                    <textarea type="text" class="form-control" name="description" id="description"
                                              placeholder="{{ __('Description') }}" tabindex="1" required>{{ isset($email_template_language) ? $email_template_language->description : old('description') }}</textarea>

                                @if ($errors->has('description'))
                                        <div class="invalid-feedback">
                                            <p>{{ $errors->first('description') }}</p>
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



