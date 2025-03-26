@extends('admin.partials.master')

@section('administrators_active')
    active
@endsection
@section('redirect_active')
    active
@endsection

@section('title')
    {{ __('Physical Shops') }}
@endsection

@section('main-content')
    <section class="section">
        <div class="section-body">
            <div class="d-flex justify-content-between">
                <h2 class="section-title">{{ __('All Redirects') }}</h2>
                <div class="buttons add-button">
                <a href="{{ route('redirect.create') }}" class="btn btn-outline-primary">
                        <i class='bx bx-plus'></i>{{ __('Add New Redirect') }}
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <form action="">
                            <div class="card-header input-title">
                                <h4>{{__('Redirect')}}</h4>
                            </div>
                        </form>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{ __('Main url') }}</th>
                                            <th>{{ __('Redirect url') }}</th>
                                            <th>{{ __('Options') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($redirects as $key => $redirect)
                                        <tr id="row_{{ $redirect->id }}">
                                            <td>{{ $redirect->id }}</td>
                                            <td>
                                                <a href="{{ $redirect->main_url }}" target="_top" class="text-primary">
                                                    {{ $redirect->main_url }}
                                                </a>
                                            </td>
                                            <td>{{ $redirect->redirect_url }}</td>
                                            <td>
                                                <a href="{{ route('redirect.edit', $redirect->id) }}" class="btn btn-outline-secondary btn-circle">
                                                    <i class="bx bx-edit"></i>
                                                </a>
                                                <a href="javascript:void(0)" onclick="delete_row('delete/redirects/', {{ $redirect->id }})" class="btn btn-outline-danger btn-circle">
                                                    <i class="bx bx-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach 
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer">
                            {{ $redirects->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@include('admin.common.delete-ajax')
