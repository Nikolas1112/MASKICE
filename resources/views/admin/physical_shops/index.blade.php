@extends('admin.partials.master')

@section('physicalShop_active')
    active
@endsection

@section('title')
    {{ __('Physical Shops') }}
@endsection

@section('main-content')
    <section class="section">
        <div class="section-body">
            <div class="d-flex justify-content-between">
                <h2 class="section-title">{{ __('All Physical Shops') }}</h2>
                <div class="buttons add-button">
                <a href="{{ route('physical_shops.create') }}" class="btn btn-outline-primary">
                        <i class='bx bx-plus'></i>{{ __('Add New Physical Shop') }}
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{ __('Name') }}</th>
                                            <th>{{ __('Address') }}</th>
                                            <th>{{ __('Options') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($physicalShops as $key => $shop)
                                        <tr id="row_{{ $shop->id }}">
                                            <td>{{ $shop->id }}</td>
                                            <td>{{ $shop->name }}</td>
                                            <td>{{ $shop->address }}</td>
                                            <td>
                                                <a href="{{ route('physical_shops.edit', $shop->id) }}" class="btn btn-outline-secondary btn-circle">
                                                    <i class="bx bx-edit"></i>
                                                </a>
                                                <a href="javascript:void(0)" onclick="delete_row('delete/physical_shops/', {{ $shop->id }})" class="btn btn-outline-danger btn-circle">
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
                            {{ $physicalShops->links('pagination::bootstrap-4') }}  <!-- Now it will work correctly -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@include('admin.common.delete-ajax')
