@extends('admin.partials.master')

@section('title')
    {{ __('Customer Lists') }}
@endsection
@section('customers')
    active
@endsection
@section('customer_list')
    active
@endsection
@php
    if(isset($_GET['q'])){
        $q          = $_GET['q'];
    }
@endphp
@section('main-content')
    <section class="section">
        <div class="section-body">
            <div class="d-flex justify-content-between">
                <div class="d-block">
                    <h2 class="section-title">{{ __('Customer Lists') }}</h2>
                    <p class="section-lead">
                        {{ __('You have total') . ' ' . $users->total() . ' ' . __('customers') }}
                    </p>
                </div>
                @if(hasPermission('customer_create'))
                    <div class="buttons add-button">
                        <a href="{{ route('customer.create') }}" class="btn btn-icon icon-left btn-outline-primary">
                            <i class="bx bx-plus"></i>{{ __('Add Customer') }}</a>
                    </div>
                @endif
            </div>
            <div class="row">
                <div class="col-sm-xs-12 col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>{{ __('Customers') }}</h4>
                            <div class="card-header-form">
                                <form class="form-inline" id="sorting">
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="q" value="{{ @$q }}"
                                               placeholder="{{ __('Search') }}">
                                        <div class="input-group-btn">
                                            <button class="btn btn-outline-primary"><i class="bx bx-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-striped table-md">
                                    <tbody>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('Name') }}</th>
                                        <th>{{ __('Phone') }}</th>
                                        <th>{{ __('Current Balance') }}</th>
                                        <th>{{ __('Last Login') }}</th>
                                        <th>{{ __('Status') }}</th>
                                        @if (hasPermission('customer_update') || hasPermission('customer_delete'))
                                            <th>{{ __('Options') }}</th>
                                        @endif
                                    </tr>
                                    @foreach ($users as $key => $user)
                                        <tr id="row_{{$user->id}}">
                                            <td>{{ $users->firstItem() + $key }}</td>
                                            <td width="300">
                                                <a href="javascript:void(0)" class="modal-menu" data-title="{{__('Profile')}}"
                                                   data-url="{{ route('edit-info', ['page_name' => 'customer-profile', 'param1' => $user->id]) }}"
                                                   data-toggle="modal" data-target="#common-modal">
                                                    <div class="d-flex">
                                                        <figure class="avatar mr-2">
                                                            <img src="{{ getFileLink('40x40',$user->images) }}" alt="{{ $user->first_name }}" width="40">
                                                            @if(\Illuminate\Support\Facades\Cache::has('user-is-online-' . $user->id))
                                                                <i class="avatar-presence online"></i>
                                                            @else
                                                                <i class="avatar-presence offline"></i>
                                                            @endif
                                                        </figure>
                                                        <div class="ml-1">
                                                            {{ $user->first_name . ' ' . $user->last_name }}<br/>
                                                            <i class='bx bx-check-circle
                                                            {{ \Cartalyst\Sentinel\Laravel\Facades\Activation::completed($user) == true ? "text-success" : "text-warning" }} '>
                                                            </i>
                                                            {{ config('app.demo_mode') ? emailAddressMask($user->email) : $user->email }}
                                                        </div>
                                                    </div>
                                                </a>
                                            </td>
                                            <td> {{ config('app.demo_mode') ? Str::of($user->phone)->mask('*', 0, strlen($user->phone)-3) : @$user->phone }}</td>
                                            <td>{{ get_price($user->balance) }}</td>
                                            <td>{{ $user->last_login != '' ? date('M d, Y h:i a', strtotime($user->last_login)) : '' }}</td>
                                            <td>
                                                @if($user->is_user_banned == 1)
                                                    <div class="d-flex">
                                                        <div
                                                            class="ml-1 badge badge-pill badge-danger">{{ __('Banned') }}</div>
                                                    </div>
                                                @else
                                                    <label class="custom-switch mt-2 {{ hasPermission('customer_update') ? '' : 'cursor-not-allowed' }}">
                                                        <input type="checkbox" name="custom-switch-checkbox"
                                                               value="customer-status-change/{{$user->id}}"
                                                               {{ $user->status == 1 ? 'checked' : '' }}  {{ hasPermission('customer_update') ? '' : 'disabled'}} class="{{ hasPermission('customer_update') ? 'status-change' : '' }} custom-switch-input">
                                                        <span class="custom-switch-indicator"></span>
                                                    </label>
                                                @endif
                                            </td>

                                            <td>
                                                @if (hasPermission('customer_update'))
                                                    <a href="{{ route('customer.edit', $user->id) }}"
                                                       class="btn btn-outline-secondary btn-circle"
                                                       data-toggle="tooltip" title=""
                                                       data-original-title="{{ __('Edit') }}"><i class="bx bx-edit"></i>
                                                    </a>
                                                @endif
                                                <a href="javascript:void(0)" data-toggle="dropdown"
                                                   class="btn btn-outline-secondary btn-circle" title=""
                                                   data-original-title="{{ __('Options') }}">
                                                    <i class='bx bx-dots-vertical-rounded'></i>
                                                </a>
                                                <div class="dropdown-menu">
                                                    <a href="javascript:void(0)"
                                                       class="dropdown-item has-icon modal-menu"
                                                       data-title="{{__('Profile')}}"
                                                       data-url="{{ route('edit-info', ['page_name' => 'customer-profile', 'param1' => $user->id]) }}"
                                                       data-toggle="modal" data-target="#common-modal">
                                                        <i class="bx bx-user"></i>{{__('Profile') }}
                                                    </a>
                                                    @if(hasPermission('customer_ban'))
                                                      @if($user->is_user_banned == 0)
                                                        <a href="{{ route('user.ban', $user->id) }}"
                                                        class="dropdown-item has-icon"><i
                                                            class='bx bx-lock'></i>{{ __('Ban This customer') }}</a>
                                                        @else
                                                            <a href="{{ route('user.ban', $user->id) }}"
                                                            class="dropdown-item has-icon"><i
                                                                    class='bx bx-lock-open'></i>{{ __('Unban This customer') }}
                                                            </a>
                                                        @endif
                                                    @endif
                                                    @if (hasPermission('customer_update'))
                                                        @if(\Cartalyst\Sentinel\Laravel\Facades\Activation::completed($user) == true)
                                                            <a href="{{ route('customer.email.verify', $user->id) }}"
                                                               class="dropdown-item has-icon"><i
                                                                    class='bx bx-x-circle'></i>{{ __('Unverify Account') }}
                                                            </a>
                                                        @else
                                                            <a href="{{ route('customer.email.verify', $user->id) }}"
                                                               class="dropdown-item has-icon"><i
                                                                    class='bx bx-check-circle'></i>{{ __('Verify Account') }}
                                                            </a>
                                                        @endif
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer">
                            <nav class="d-inline-block">
                                {{ $users->appends(Request::except('page'))->links('pagination::bootstrap-4') }}
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@include('admin.common.delete-ajax')
@include('admin.common.common-modal')
