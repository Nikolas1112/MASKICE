@extends('admin.partials.master')

@section('title')
    {{ __('Edit Salary') }}
@endsection

@section('main-content')
    <section class="section">
        <div class="section-body">
            <h2 class="section-title">{{ __('Edit Salary Record') }}</h2>
            <form action="{{ route('salaries.update', $salary->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="form-group">
                    <label for="net_salary">{{ __('Net Salary') }}</label>
                    <input type="number" step="0.01" name="net_salary" id="net_salary" class="form-control" value="{{ old('net_salary', $salary->net_salary) }}" required>
                </div>

                <div class="form-group">
                    <label for="gross_salary">{{ __('Gross Salary') }}</label>
                    <input type="number" step="0.01" name="gross_salary" id="gross_salary" class="form-control" value="{{ old('gross_salary', $salary->gross_salary) }}" required>
                </div>

                <div class="form-group">
                    <label for="bonus">{{ __('Bonus') }}</label>
                    <input type="number" step="0.01" name="bonus" id="bonus" class="form-control" value="{{ old('bonus', $salary->bonus) }}">
                </div>

                <!-- Add any additional fields as necessary -->

                <button type="submit" class="btn btn-primary">{{ __('Update Salary') }}</button>
            </form>
        </div>
    </section>
@endsection
