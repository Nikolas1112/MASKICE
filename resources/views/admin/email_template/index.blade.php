@extends('admin.partials.master')
@section('template_active')
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
                    <h2 class="section-title">{{__('All Email Templates')}}</h2>
                </div>
                <div class="buttons add-button">
                    <a href="{{ route('templates.create') }}" class="btn btn-icon icon-left btn-outline-primary">
                        <i class='bx bx-plus'></i>{{ __('Add new Email Template') }}
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-xs-12 col-md-12">
                    <div class="card">
                        <form action="">
                            <div class="card-header input-title">
                                <h4>{{__('Email Template')}}</h4>
                            </div>
                        </form>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-striped table-md">
                                    <tbody>
                                    <tr>
                                        <th>{{__('#')}}</th>
                                        <th>{{__('Name')}}</th>
                                        <th>{{__('Type')}}</th>
                                        <th>{{__('Description')}}</th>
                                        <th>{{__('Options')}}</th>
                                    </tr>
                                    @foreach($emailTemplates as $key => $template)

                                        <tr id="row_{{ $template->id }}" class="table-data-row">
                                            <td>{{ $template->id }}</td>
                                            <td>{{ $template->name }}</td>
                                            <td>{{ $template->type }}</td>
                                            <td>{{ $template->description }}</td>
                                            <td>
                                                <a href="{{route('templates.edit',$template->id)}}" class="btn btn-outline-secondary btn-circle"
                                                   data-toggle="tooltip" title=""
                                                   data-original-title="{{ __('Edit') }}"><i class="bx bx-edit"></i></a>
                                                <a href="javascript:void(0)" onclick="delete_row('delete/email_templates/',{{ $template->id }})"
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
{{--                                {{ $emailTemplates->appends(Request::except('page'))->links('pagination::bootstrap-4') }}--}}
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
