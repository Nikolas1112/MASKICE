@extends('admin.partials.master')
@section('report')
    active
@endsection
@section('order_report_active')
    active
@endsection
@section('title')
    {{ __('Order Report') }}
@endsection
@php
    $c                = isset($_GET['c']) ? $_GET['c'] : null;
    $dt               = isset($_GET['dt']) ? $_GET['dt'] : null;
@endphp
@section('main-content')
    <section class="section">
        <div class="section-body">
            <div class="d-flex justify-content-between">
                <div class="d-block">
                    <h2 class="section-title">{{ __('Report') }}</h2>
                    <p class="section-lead">
                        {{ __('Order Report') }}
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-xs-12 col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <form class="" id="sorting">
                                <div class="form-row justify-content-end">
                                    <div class="form-group col-sm-xs-12 col-md-4">
                                        <label for="time_period">{{ __('Filter by Time Period') }}</label>
                                        <select class="form-control selectric sorting" name="time_period" id="time_period">
                                            <option value="today" @if($timePeriod == 'today') selected @endif>Today</option>
                                            <option value="yesterday" @if($timePeriod == 'yesterday') selected @endif>Yesterday</option>
                                            <option value="last_seven_days" @if($timePeriod == 'last_seven_days') selected @endif>Last 7 Days</option>
                                            <option value="this_month" @if($timePeriod == 'this_month') selected @endif>This Month</option>
                                            <option value="last_month" @if($timePeriod == 'last_month') selected @endif>Last Month</option>
                                            <option value="yearly" @if($timePeriod == 'yearly') selected @endif>Yearly</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-sm-xs-12 col-md-2 mt-2">
                                        <label for=""></label>
                                        <button type="submit" class="btn btn-outline-primary form-control">{{__('Filter')}}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-sm-xs-12 col-md-12 middle">
                    <div class="card">
                        <div class="card-header" id="summary_header">
                        <h4>{{ __('Summary of Order Report for ') }} <span id="selected-period">{{ $timePeriodText }}</span></h4> <!-- Displaying selected period -->
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <!-- Total Orders -->
                                <div class="col-md-4">
                                    <div class="mini-stats-wid card bg-primary">
                                        <div class="card-body">
                                            <div class="d-flex">
                                                <div class="flex-grow-1">
                                                    <p class="fw-medium  text-white ">{{ __('Total Orders') }}</p>
                                                    <h4 class="mb-0">{{ $totalOrderCount }}</h4> <!-- Example Value -->
                                                </div>
                                                <div class="mini-stat-icon avatar-sm rounded-circle align-self-center">
                                                    <span class="avatar-title">
                                                        <i class="bx bx-trending-up font-size-24"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Total Amount -->
                                <div class="col-md-4">
                                    <div class="mini-stats-wid card bg-success">
                                        <div class="card-body">
                                            <div class="d-flex">
                                                <div class="flex-grow-1">
                                                    <p class="fw-medium">{{ __('Total Amount') }}</p>
                                                    <h4 class="mb-0">{{ get_price($totalAmountOfOrder,user_curr()) }}</h4> 
                                                </div>
                                                <div class="mini-stat-icon avatar-sm rounded-circle align-self-center">
                                                    <span class="avatar-title">
                                                        <i class="bx bx-dollar font-size-24"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Orders With Fees -->
                                <div class="col-md-4">
                                    <div class="mini-stats-wid card bg-warning">
                                        <div class="card-body">
                                            <div class="d-flex">
                                                <div class="flex-grow-1">
                                                    <p class="fw-medium">{{ __('Orders With Fees') }}</p>
                                                    <h4 class="mb-0">{{ $totalOrderWithFees }}</h4> 
                                                </div>
                                                <div class="mini-stat-icon avatar-sm rounded-circle align-self-center">
                                                    <span class="avatar-title">
                                                        <i class="bx bxl-product-hunt font-size-24"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Orders Without Fees -->
                                <div class="col-md-4">
                                    <div class="mini-stats-wid card bg-danger">
                                        <div class="card-body">
                                            <div class="d-flex">
                                                <div class="flex-grow-1">
                                                    <p class="fw-medium">{{ __('Orders Without Fees') }}</p>
                                                    <h4 class="mb-0">{{ $totalOrderWithoutFees }}</h4> 
                                                </div>
                                                <div class="mini-stat-icon avatar-sm rounded-circle align-self-center">
                                                    <span class="avatar-title">
                                                        <i class="bx bx-group font-size-24"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Average Orders per Day -->
                                <div class="col-md-4">
                                    <div class="mini-stats-wid card  bg-info">
                                        <div class="card-body">
                                            <div class="d-flex">
                                                <div class="flex-grow-1">
                                                    <p class="fw-medium">{{ __('Average Orders per Day') }}</p>
                                                    <h4 class="mb-0">{{ $argOrderPerDay }}</h4> 
                                                </div>
                                                <div class="mini-stat-icon avatar-sm rounded-circle align-self-center">
                                                    <span class="avatar-title">
                                                        <i class="bx bx-calendar-check font-size-24"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="card card-statistic-5">
                                <div class="card-stats">
                                    <div class="card-stats-title d-flex justify-content-between">
                                        <h4>{{__('Order By Cities')}}</h4>
                                    </div>
                                    <div class="card-body">
                                        <canvas id="order_by_cities_chart" height="100px"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('script')
    <script src="{{ static_asset('admin/js/chart.js') }}"></script>
    <script type="text/javascript">
        const order_state = document.getElementById('order_by_cities_chart');
        
        const ordersByCityChart = new Chart(order_state, {
            type: 'bar',
            data: {
                labels: {!! json_encode($numberOfOrderByCitiesChartData['cities']) !!},  // City names
                datasets: [{
                    label: 'Number of Orders',
                    data: {!! json_encode($numberOfOrderByCitiesChartData['orderCounts']) !!},  // Order counts per city
                    backgroundColor: 'rgba(54, 162, 235, 0.2)', // Bar color
                    borderColor: 'rgba(54, 162, 235, 1)', // Border color
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,  // Ensures the y-axis starts at zero
                        ticks: {
                            min: 0, // Force minimum value to be 0
                            max: Math.max(...{!! json_encode($numberOfOrderByCitiesChartData['orderCounts']) !!}), // Set the max value to the highest data value
                            stepSize: 1
                        }
                    }
                }
            }
        });
    </script>
@endpush