@extends('admin.partials.master')

@section('administrators_active')
    active
@endsection
@section('permission_active')
    active
@endsection

@section('title')
    {{ __('Permission') }}
@endsection

@section('main-content')
    <section class="section">
        <div class="section-body">
            <div class="d-flex justify-content-between">
                <h2 class="section-title">{{ __('All Permissions') }}</h2>
                <div class="buttons add-button">
                    <a href="{{ route('permission.create') }}" class="btn btn-outline-primary">
                        <i class='bx bx-plus'></i>{{ __('Add New Permission') }}
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <form action="">
                            <div class="card-header input-title">
                                <h4>{{ __('Permission') }}</h4>
                            </div>
                        </form>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{ __('Attribute') }}</th>
                                            <th>{{ __('KeyWords') }}</th>
                                            <th>{{ __('Options') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($permissions as $key => $perm)
                                            <tr id="row_{{ $perm->id }}">
                                                <td>{{ $perm->id }}</td>
                                                <td>{{ $perm->attribute }}</td>
                                                <td>{{ is_array($perm->keywords) ? implode(', ', $perm->keywords) : $perm->keywords }}</td>
                                                <td>
                                                    <a href="{{ route('permission.edit', $perm->id) }}" class="btn btn-outline-secondary btn-circle">
                                                        <i class="bx bx-edit"></i>
                                                    </a>
                                                    <a href="javascript:void(0)" onclick="delete_row('delete/permissions/', {{ $perm->id }})" class="btn btn-outline-danger btn-circle">
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
                            {{ $permissions->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@include('admin.common.delete-ajax')
