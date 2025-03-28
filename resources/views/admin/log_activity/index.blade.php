@extends('admin.partials.master')

@section('logs_activity')
    active
@endsection

@section('title')
    {{ __('Log Activity') }}
@endsection

@section('main-content')
    <section class="section">
        <div class="section-body">
            <div class="d-flex justify-content-between">
                <h2 class="section-title">{{ __('All Logs Activity') }}</h2>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <form action="">
                            <div class="card-header input-title">
                                <h4>{{ __('Logs Activity') }}</h4>
                            </div>
                        </form>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{ __('User Name') }}</th>
                                            <th>{{ __('URL') }}</th>
                                            <th>{{ __('IP') }}</th>
                                            <th>{{ __('Browser') }}</th>
                                            <th>{{ __('Platform') }}</th>
                                            <th>{{ __('Log Name') }}</th>
                                            <th>{{ __('Event') }}</th>
                                            <th>{{ __('Description') }}</th>
                                            <th>{{ __('Location') }}</th>
                                            <th>{{ __('Date') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($logActivityData as $logActivity)
                                        <tr id="row_{{ $logActivity->id }}">
                                            <td>{{ $logActivity->id }}</td>
                                            <td>{{ $logActivity->user ? $logActivity->user->first_name : 'N/A' }} {{ $logActivity->user ? $logActivity->user->last_name : 'N/A' }}</td>
                                            <td>{{ $logActivity->url }}</td>
                                            <td>{{ $logActivity->ip }}</td>
                                            <td>{{ $logActivity->browser }}</td>
                                            <td>{{ $logActivity->platform }}</td>
                                            <td>{{ $logActivity->log_name }}</td>
                                            <td>{{ $logActivity->event }}</td>
                                            <td>{{ $logActivity->description }}</td>
                                            <td>{{ $logActivity->location }}</td>
                                            <td>{{ date("d-M-Y",strtotime($logActivity->created_at)) }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer">
                            <!-- Add pagination links -->
                            {{ $logActivityData->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
