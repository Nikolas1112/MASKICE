@extends('admin.partials.master')

@php
$title = isset($edit) ? trans('Survey Pool Edit') : __('Survey Pool Add')
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
                <a href="{{ route('survey.index')}}" class="btn btn-icon icon-left btn-outline-primary"><i
                            class="bx bx-arrow-back"></i>{{ __('Back') }}</a>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-xs-12 col-md-8 middle">
                <div class="card">
                    <div class="card-header input-title">
                        <h4>{{ isset($edit) ? trans('Edit Survey Poll') : __('Add New Survey Poll')}}</h4>
                    </div>
                    <div class="card-body card-body-paddding">
                        @php
                        $route = isset($edit) ? route('survey.update',$edit->id) : route('survey.store')
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
                            <input type="hidden" value="{{ $survey_language->translation_null == 'not-found' ? '' : $survey_language->id }}" name="translate_id">

                            <input type="hidden" value="{{ old('r') ? old('r') : (@$r ? $r : url()->previous() )}}" name="r">
                            <input type="hidden" value="{{ $lang }}" name="lang">
                            @endisset
                            <div class="form-group">
                                <label for="title">{{__('Name')}}</label>
                                <input type="text" class="form-control" name="name" id="name"
                                       value="{{ isset($survey_language) ? $survey_language->name : old('name') }}"
                                       placeholder="{{__('Name')}}" tabindex="1" required>
                                @if ($errors->has('name'))
                                <div class="invalid-feedback">
                                    <p>{{ $errors->first('name') }}</p>
                                </div>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="title">{{__('Question')}}</label>
                                <input type="text" class="form-control" name="question" id="question"
                                       value="{{ isset($survey_language) ? $survey_language->question : old('question') }}"
                                       placeholder="{{__('Question')}}" tabindex="1" required>
                                @if ($errors->has('question'))
                                <div class="invalid-feedback">
                                    <p>{{ $errors->first('question') }}</p>
                                </div>
                                @endif
                            </div>

                            <div class="form-group row mt-2">
                                <label class="col-md-2 col-form-label">{{ __('Status') }}</label>
                                <input type="hidden" name="is_active" value="0">
                                <div class="col-md-10">
                                    <label class="custom-switch">
                                        <input type="checkbox" value="1" name="is_active"
                                               class="custom-switch-input"
                                               {{ old('is_active', 1) == 1 ? 'checked' : '' }}>
                                        <span class="custom-switch-indicator"></span>
                                        <span class="custom-switch-description">{{ __("This question is currently active.") }}</span>
                                    </label>
                                    @error('is_active')
                                    <div class="invalid-feedback">
                                        <p>{{ $message }}</p>
                                    </div>
                                    @enderror
                                </div>
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



