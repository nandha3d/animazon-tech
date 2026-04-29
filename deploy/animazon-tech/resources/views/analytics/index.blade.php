@extends('layouts.admin')
@section('page-title')
    {{__('Analytics')}}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item">{{__('Analytics')}}</li>
@endsection
@section('content')
    @if(isset($error))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <span class="alert-icon"><i class="ti ti-alert-triangle"></i></span>
            <span class="alert-text">
                {{ $error }}
            </span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @else
        <div class="row">
            <div class="col-lg-6 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="row align-items-center justify-content-between">
                            <div class="col-auto mb-3 mb-sm-0">
                                <div class="d-flex align-items-center">
                                    <div class="theme-avtar bg-primary">
                                        <i class="ti ti-users"></i>
                                    </div>
                                    <div class="ms-3">
                                        <small class="text-muted">{{__('Last 30 Days')}}</small>
                                        <h6 class="m-0">{{__('Total Visitors')}}</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto text-end">
                                <h4 class="m-0">{{ number_format($totalVisitors) }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="row align-items-center justify-content-between">
                            <div class="col-auto mb-3 mb-sm-0">
                                <div class="d-flex align-items-center">
                                    <div class="theme-avtar bg-info">
                                        <i class="ti ti-eye"></i>
                                    </div>
                                    <div class="ms-3">
                                        <small class="text-muted">{{__('Last 30 Days')}}</small>
                                        <h6 class="m-0">{{__('Total Page Views')}}</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto text-end">
                                <h4 class="m-0">{{ number_format($totalPageViews) }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Most Visited Pages -->
            <div class="col-lg-6 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mt-1 mb-0">{{__('Most Visited Pages')}}</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>{{__('Page URL')}}</th>
                                    <th>{{__('Title')}}</th>
                                    <th>{{__('Page Views')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($mostVisitedPages as $page)
                                    <tr>
                                        <td>{{ Str::limit($page['fullPageUrl'], 30) }}</td>
                                        <td>{{ Str::limit($page['pageTitle'], 30) }}</td>
                                        <td>{{ number_format($page['screenPageViews']) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center">{{__('No data available')}}</td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Top Referrers -->
            <div class="col-lg-6 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mt-1 mb-0">{{__('Top Referrers')}}</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>{{__('Source')}}</th>
                                    <th>{{__('Page Views')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($topReferrers as $referrer)
                                    <tr>
                                        <td>{{ $referrer['pageReferrer'] }}</td>
                                        <td>{{ number_format($referrer['screenPageViews']) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="text-center">{{__('No data available')}}</td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Top Browsers -->
            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mt-1 mb-0">{{__('Top Browsers')}}</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>{{__('Browser')}}</th>
                                    <th>{{__('Sessions')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($topBrowsers as $browser)
                                    <tr>
                                        <td>{{ $browser['browser'] }}</td>
                                        <td>{{ number_format($browser['sessions']) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="text-center">{{__('No data available')}}</td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
