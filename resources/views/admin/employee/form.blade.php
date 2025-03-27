@extends('admin.partials.master')

@php
    $title = isset($edit) ? trans('Edit Employee') : __('Add New Employee');
@endphp

@section('title')
    {{ $title }}
@endsection

@section('main-content')
    <section class="section">
        <div class="section-body">
            <div class="d-flex justify-content-between">
                <h2 class="section-title">{{ $title }}</h2>
                <div class="buttons add-button">
                    <a href="{{ route('employee.index') }}" class="btn btn-outline-primary"><i class="bx bx-arrow-back"></i> {{ __('Back') }}</a>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-8 mx-auto">
                    <div class="card">
                        <div class="card-header input-title">
                            <h4>{{ isset($edit) ? __('Edit Employee') : __('Add Employee') }}</h4>
                        </div>
                        <div class="card-body">
                            @php
                                $route = isset($edit) ? route('employee.update', $edit->id) : route('employee.store')
                            @endphp

                            <form method="POST" action="{{ $route }}" enctype="multipart/form-data">
                                @csrf
                                @isset($edit)
                                    @method('PUT')
                                @endisset

                                <div class="form-group">
                                    <label for="username">{{__('Username')}}</label>
                                    <input type="text" class="form-control" name="username" id="username"
                                           value="{{ isset($edit) ? $edit->username : old('username') }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="first_name">{{__('First Name')}}</label>
                                    <input type="text" class="form-control" name="first_name" id="first_name"
                                           value="{{ isset($edit) ? $edit->first_name : old('first_name') }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="last_name">{{__('Last Name')}}</label>
                                    <input type="text" class="form-control" name="last_name" id="last_name"
                                           value="{{ isset($edit) ? $edit->last_name : old('last_name') }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="email">{{__('Email')}}</label>
                                    <input type="email" class="form-control" name="email" id="email"
                                           value="{{ isset($edit) ? $edit->email : old('email') }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="password">{{__('Password')}}</label>
                                    <input type="password" class="form-control" name="password" id="password"
                                           {{ !isset($edit) ? 'required' : '' }}>
                                </div>

                                <div class="form-group">
                                    <label for="group">{{__('Group')}}</label>
                                    <select class="form-control" name="group" id="group">
                                        <option value="">{{__('Select Role')}}</option>
                                        <option value="warehouse_worker" {{ isset($edit) && $edit->group == 'warehouse_worker' ? 'selected' : '' }}>{{__('Warehouse Worker')}}</option>
                                        <option value="seller" {{ isset($edit) && $edit->group == 'seller' ? 'selected' : '' }}>{{__('Seller')}}</option>
                                        <option value="empolyee" {{ isset($edit) && $edit->group == 'empolyee' ? 'selected' : '' }}>{{__('Empolyee')}}</option>
                                        <option value="cashier" {{ isset($edit) && $edit->group == 'cashier' ? 'selected' : '' }}>{{__('Cashier')}}</option>
                                        <option value="moderator" {{ isset($edit) && $edit->group == 'moderator' ? 'selected' : '' }}>{{__('Moderator')}}</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="additional_roles">{{__('Additional Roles')}}</label>
                                    <select class="form-control" name="additional_roles" id="additional_roles">
                                        <option value="">{{__('Select Additional Role')}}</option>
                                        @php
                                            $roles = ['admin', 'moderator', 'barcode', 'treasurer', 'web', 'driver', 'reporter', 'employee'];
                                        @endphp
                                        @foreach ($roles as $role)
                                            <option value="{{ $role }}" 
                                                {{ isset($edit) && $edit->additional_roles == $role ? 'selected' : '' }}>
                                                {{ ucfirst($role) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>


                                <div class="form-group">
                                    <label class="custom-switch mt-2">
                                        <span class="custom-switch-description" style="margin-right:10px;">{{ __('Is Active') }}</span>
                                        <input type="checkbox" name="is_active" class="custom-switch-input"
                                            value="1" {{ isset($edit) ? ($edit->is_active ? 'checked' : '') : 'checked' }}>
                                        <span class="custom-switch-indicator"></span>
                                    </label>
                                </div>


                                <div class="form-group">
                                    <label for="city">{{__('City')}}</label>
                                    <input type="text" class="form-control" name="city" id="city"
                                           value="{{ isset($edit) ? $edit->city : old('city') }}">
                                </div>

                                <div class="form-group">
                                    <label for="address">{{__('Address')}}</label>
                                    <input type="text" class="form-control" name="address" id="address"
                                           value="{{ isset($edit) ? $edit->address : old('address') }}">
                                </div>

                                <div class="form-group">
                                    <label for="oib">{{__('OIB')}}</label>
                                    <input type="text" class="form-control" name="oib" id="oib"
                                           value="{{ isset($edit) ? $edit->oib : old('oib') }}">
                                </div>

                                <div class="form-group">
                                    <label for="agreement_start_date">{{__('Agreement Start Date')}}</label>
                                    <input type="date" class="form-control" name="agreement_start_date" id="agreement_start_date"
                                    value="{{ old('agreement_start_date', isset($edit) ? \Carbon\Carbon::parse($edit->agreement_start_date)->format('Y-m-d') : '') }}"
                                    >
                                </div>

                                <div class="form-group">
                                    <label for="agreement_end_date">{{__('Agreement End Date')}}</label>
                                    <input type="date" class="form-control" name="agreement_end_date" id="agreement_end_date"
                                        value="{{ isset($edit) ? \Carbon\Carbon::parse($edit->agreement_end_date)->format('Y-m-d') : old('agreement_end_date') }}">
                                </div>

                                <div class="form-group">
                                    <label for="agreement_file">{{__('Upload Agreement')}}</label>
                                    <input type="file" class="form-control" name="agreement_file" id="agreement_file">
                                    @if(isset($edit) && $edit->agreement_file)
                                        <a href="{{ asset($edit->agreement_file) }}" target="_blank">{{__('View Current File')}}</a>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="net_salary">{{__('Net Salary')}}</label>
                                    <input type="number" step="0.01" class="form-control" name="net_salary" id="net_salary"
                                           value="{{ isset($edit) ? $edit->net_salary : old('net_salary') }}">
                                </div>

                                <div class="form-group">
                                    <label for="gross_salary">{{__('Gross Salary')}}</label>
                                    <input type="number" step="0.01" class="form-control" name="gross_salary" id="gross_salary"
                                           value="{{ isset($edit) ? $edit->gross_salary : old('gross_salary') }}">
                                </div>

                                <div class="form-group">
                                    <label for="bonus">{{__('Bonus')}}</label>
                                    <input type="number" step="0.01" class="form-control" name="bonus" id="bonus"
                                           value="{{ isset($edit) ? $edit->bonus : old('bonus') }}">
                                </div>

                                <div class="form-group">
                                    <label for="additional_message">{{__('Additional Message')}}</label>
                                    <textarea class="form-control" name="additional_message" id="additional_message">{{ isset($edit) ? $edit->additional_message : old('additional_message') }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label for="warehouse">{{__('Warehouse (Webshop?)')}}</label>
                                    <input type="text" class="form-control" name="warehouse" id="warehouse"
                                           value="{{ isset($edit) ? $edit->warehouse : old('warehouse') }}">
                                </div>

                                <div class="form-group text-right">
                                    <button type="submit" class="btn btn-primary">
                                        {{ isset($edit) ? __('Update') : __('Save') }}
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
