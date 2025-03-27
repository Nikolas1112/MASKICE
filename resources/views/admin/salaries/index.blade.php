@extends('admin.partials.master')

@section('administrators_active')
    active
@endsection

@section('salarie_active')
    active
@endsection

@section('title')
    {{ __('Salaries') }}
@endsection

@section('main-content')
<section class="section">
    <div class="section-body">
        <div class="d-flex justify-content-between">
            <h2 class="section-title">{{ __('All Salaries') }}</h2>
            <div class="buttons add-button">
                <a href="{{ route('salaries.create') }}" class="btn btn-outline-primary">
                    <i class='bx bx-plus'></i> {{ __('Add New Salary') }}
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <!-- Filter Form -->
                    <form action="" method="GET">
                        <div class="card-header input-title d-flex align-items-center">
                            <h4 class="me-3">{{ __('Filter Salaries by Date') }}</h4>
                            <input type="date" name="date" value="{{ request('date') }}" class="form-control w-auto me-2">
                            <button type="submit" class="btn btn-secondary">{{ __('Filter') }}</button>
                        </div>
                    </form>
                    <!-- Salary Table -->
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('Admin Info') }}</th>
                                        <th>{{ __('Salary') }}</th>
                                        <th>{{ __('Percentage') }}</th>
                                        <th>{{ __('Total') }}</th>
                                        <th>{{ __('Type') }}</th>
                                        <th>{{ __('Number') }}</th>
                                        <th>{{ __('Date & Time') }}</th>
                                        <th>{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($salaries as $salarie)
                                        @php
                                            // Calculate base salary, bonus, total, percentage, and type
                                            $baseSalary = $salarie->net_salary;
                                            $bonus = $salarie->bonus ?? 0;
                                            $total = $baseSalary + $bonus;
                                            $percentage = $baseSalary > 0 ? round(($bonus / $baseSalary) * 100, 2) : 0;
                                            $salaryType = $bonus > 0 ? 'Commission' : 'Salary';
                                            // Use a tracking number if available, else fallback to id
                                            $trackingNumber = $salarie->tracking_number ?? $salarie->id;
                                            $dateTime = $salarie->created_at->format('d M, Y H:i');
                                            $adminName = $salarie->first_name . ' ' . $salarie->last_name;
                                        @endphp
                                        <tr id="row_{{ $salarie->id }}">
                                            <td>{{ $salarie->id }}</td>
                                            <td>{{ $adminName }}</td>
                                            <td>{{ number_format($baseSalary, 2) }}</td>
                                            <td>{{ $percentage }}%</td>
                                            <td>{{ number_format($total, 2) }}</td>
                                            <td>{{ $salaryType }}</td>
                                            <td>{{ $trackingNumber }}</td>
                                            <td>{{ $dateTime }}</td>
                                            <td>
                                                <!-- Edit Button (opens in new window) -->
                                                <a href="{{ route('salaries.edit', $salarie->id) }}" target="_blank" class="btn btn-outline-secondary btn-circle">
                                                    <i class="bx bx-edit"></i>
                                                </a>
                                                <!-- Delete Button -->
                                                <form action="{{ route('salaries.destroy', $salarie->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger btn-circle" onclick="return confirm('{{ __('Are you sure you want to delete this record?') }}')">
                                                        <i class="bx bx-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- Pagination -->
                    <div class="card-footer">
                        {{ $salaries->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@include('admin.common.delete-ajax')
