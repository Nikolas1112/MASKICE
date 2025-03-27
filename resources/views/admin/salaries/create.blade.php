@extends('admin.partials.master')

@section('title')
    {{ __('Add New Salary') }}
@endsection

@section('main-content')
<section class="section">
    <div class="section-body">
        <h2 class="section-title">{{ __('Add New Salary Record') }}</h2>
        <form action="{{ route('salaries.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="net_salary">{{ __('Net Salary') }}</label>
                <input type="number" step="0.01" name="net_salary" id="net_salary" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="gross_salary">{{ __('Gross Salary') }}</label>
                <input type="number" step="0.01" name="gross_salary" id="gross_salary" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="bonus">{{ __('Bonus') }}</label>
                <input type="number" step="0.01" name="bonus" id="bonus" class="form-control">
            </div>

            <!-- Add any additional fields as needed -->

            <button type="submit" class="btn btn-primary">{{ __('Create Salary') }}</button>
        </form>
    </div>
</section>
@endsection
