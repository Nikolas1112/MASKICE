@extends('admin.partials.master')

@section('title')
    {{ __('Product Low On Stocks') }}
@endsection
@section('product_active')
    active
@endsection
@section('product_low_on_stocks')
    active
@endsection
@section('main-content')
    <section class="section">
        <div class="section-body">
            <div class="d-flex justify-content-between">
                <div class="d-block">
                    <h2 class="section-title">{{__('Product Low On Stocks')}}</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-12">
                    <div class="card">
                        <div class="card-body p-0">
                            @if(addon_is_activated('ai_writer') && settingHelper('ai_review_option') == 2)
                                <table class="table table-md">
                                    <tbody>
                                    <tr>
                                        <td>{{ __('automated_reply_for_review') }}</td>
                                        <td width="300">
                                            <label class="custom-switch mt-2">
                                                <input type="checkbox" name="custom-switch-checkbox"
                                                       value="config-user-review/{{ authId() }}" {{ authUser()->ai_review_option == 1 ? 'checked' : '' }}
                                                       class="custom-switch-input status-change">
                                                <span class="custom-switch-indicator"></span>
                                            </label>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            @endif
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h4>{{__('Product Low On Stocks')}}</h4>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-striped table-md">
                                    <tbody>
                                    <tr>
                                        <th>#</th>
                                        <th>{{__('Product Code')}}</th>
                                        <th>{{__('Product Name')}}</th>
                                        <th>{{__('Image')}}</th>
                                        <th>{{ __('Amount') }}</th>
                                        <th>{{__('Reserved')}}</th>
                                        <th>{{__('Available')}}</th>
                                        <th>{{__('Stock Threshold')}}</th>
                                    </tr>

                                        @php
                                            use Illuminate\Support\Arr;
                                        @endphp

                                        @foreach ($product_stocks as $key => $productStock)
                                            <tr id="row_{{$productStock['product_id']}}">
                                                <td>{{$key + 1}}</td>
                                                <td>{{$productStock['product_code']}}</td>
                                                <td>{{ $productStock['product_name'] }}</td>

                                                @php
                                                    $firstImage = Arr::first($productStock['product_image']);
                                                @endphp

                                                @if ($firstImage)
                                                    <td>
                                                        <img src="{{ getFileLink('original_image', $firstImage) }}"
                                                            alt="{{ $productStock['product_name'] }}" width="100">
                                                    </td>
                                                @else
                                                    <td>No Image</td>
                                                @endif

                                                <td>{{ $productStock['product_amount'] }}</td>
                                                <td>{{ $productStock['stock_reserved'] }}</td>
                                                <td>{{ $productStock['stocks_available'] }}</td>
                                                <td>{{ $productStock['stock_threshold'] ?? 0 }}</td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
