@extends('admin.partials.master')

@section('administrators_active')
    active
@endsection
@section('employee_active')
    active
@endsection

@section('title')
    {{ __('Employees') }}
@endsection

@section('main-content')
    <section class="section">
        <div class="section-body">
            <div class="d-flex justify-content-between">
                <h2 class="section-title">{{ __('All Employees') }}</h2>
                <div class="buttons add-button">
                    <a href="{{ route('employee.create') }}" class="btn btn-outline-primary">
                        <i class='bx bx-plus'></i>{{ __('Add New Employee') }}
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <form action="">
                            <div class="card-header input-title">
                                <h4>{{__('Employees')}}</h4>
                            </div>
                        </form>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{ __('Username') }}</th>
                                            <th>{{ __('First Name') }}</th>
                                            <th>{{ __('Last Name') }}</th>
                                            <th>{{ __('Email') }}</th>
                                            <th>{{ __('City') }}</th>
                                            <th>{{ __('Net Salary') }}</th>
                                            <th>{{ __('Status') }}</th>
                                            <th>{{ __('Joining Date') }}</th>
                                            <th>{{ __('Options') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($employees as $key => $employee)
                                        <tr id="row_{{ $employee->id }}">
                                            <td>{{ $employee->id }}</td>
                                            <td>{{ $employee->username }}</td>
                                            <td>{{ $employee->first_name }}</td>
                                            <td>{{ $employee->last_name }}</td>
                                            <td>{{ $employee->email }}</td>
                                            <td>{{ $employee->city }}</td>
                                            <td>{{ $employee->net_salary }}</td>
                                            <td>
                                                <label class="custom-switch mt-2">
                                                    <input type="checkbox" class="custom-switch-input" value="{{ $employee->id }}" 
                                                        {{ $employee->is_active == 1 ? 'checked' : '' }} disabled>
                                                    <span class="custom-switch-indicator"></span>
                                                </label>
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($employee->agreement_start_date)->format('d M, Y') }}</td>
                                            <td>
                                                <a href="{{ route('employee.edit', $employee->id) }}" class="btn btn-outline-secondary btn-circle">
                                                    <i class="bx bx-edit"></i>
                                                </a>
                                                <a href="javascript:void(0)" onclick="delete_row('delete/employees/', {{ $employee->id }})" class="btn btn-outline-danger btn-circle">
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
                            {{ $employees->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@include('admin.common.delete-ajax')