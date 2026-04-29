@extends('layouts.admin')
@section('page-title')
    {{ __('Landing Page') }}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item">{{__('Landing Page')}}</li>
@endsection

@php
    $settings = \Modules\LandingPage\Entities\LandingPageSetting::landingPageSetting();
    $logo=\App\Models\Utility::get_file('uploads/landing_page_image');
@endphp

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="row">
                <div class="col-xl-3">
                    <div class="card sticky-top" style="top:30px">
                        <div class="list-group list-group-flush" id="useradd-sidenav">
                            @include('landingpage::layouts.tab')
                        </div>
                    </div>
                </div>

                <div class="col-xl-9">
                    {{ Form::open(array('route' => 'portfolio.store', 'method'=>'post', 'enctype' => "multipart/form-data", 'class'=>'needs-validation', 'novalidate')) }}
                        <div class="card">
                            <div class="card-header">
                                <div class="row align-items-center">
                                    <div class="col-6">
                                        <h5 class="mb-2">{{ __('Portfolio Settings') }}</h5>
                                    </div>
                                    <div class="col switch-width text-end">
                                        <div class="form-group mb-0">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" data-toggle="switchbutton" data-onstyle="primary" name="portfolio_status"
                                                    id="portfolio_status" {{ $settings['portfolio_status'] == 'on' ? 'checked="checked"' : '' }}>
                                                <label class="custom-control-label" for="portfolio_status"></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {{ Form::label('portfolio_title', __('Title'), ['class' => 'form-label']) }}
                                            {{ Form::text('portfolio_title', $settings['portfolio_title'], ['class' => 'form-control', 'placeholder' => __('Enter Title')]) }}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {{ Form::label('portfolio_heading', __('Heading'), ['class' => 'form-label']) }}
                                            {{ Form::text('portfolio_heading', $settings['portfolio_heading'], ['class' => 'form-control', 'placeholder' => __('Enter Heading')]) }}
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            {{ Form::label('portfolio_description', __('Description'), ['class' => 'form-label']) }}
                                            {{ Form::textarea('portfolio_description', $settings['portfolio_description'], ['class' => 'form-control', 'placeholder' => __('Enter Description'), 'rows' => 2]) }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-end">
                                <button class="btn btn-print-invoice btn-primary m-r-10" type="submit" >{{ __('Save Changes') }}</button>
                            </div>
                        </div>
                    {{ Form::close() }}

                    <div class="card">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col-lg-9 col-md-9 col-sm-9">
                                    <h5>{{ __('Portfolio Items') }}</h5>
                                    <small class="text-muted">{{ __('Manage your portfolio showcases — images, videos, games, websites, and mobile apps.') }}</small>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-3 justify-content-end d-flex">
                                    <a data-size="lg" data-url="{{ route('portfolio_create') }}" data-ajax-popup="true" data-bs-toggle="tooltip" data-title="{{__('Create Portfolio Item')}}" title="{{__('Create')}}" class="btn btn-sm btn-primary">
                                        <i class="ti ti-plus text-light"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>{{__('No')}}</th>
                                            <th>{{__('Preview')}}</th>
                                            <th>{{__('Title')}}</th>
                                            <th>{{__('Category')}}</th>
                                            <th>{{__('Type')}}</th>
                                            <th>{{__('Action')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                       @if (is_array($portfolios) || is_object($portfolios))
                                           @php $no = 1 @endphp
                                            @foreach ($portfolios as $key => $value)
                                                @php
                                                    $typeBadges = [
                                                        'website' => 'bg-warning',
                                                        'video' => 'bg-danger',
                                                        '3d' => 'bg-info',
                                                        'application' => 'bg-success',
                                                    ];
                                                    $typeLabels = [
                                                        'website' => 'Website',
                                                        'video' => 'Video',
                                                        '3d' => '3D Work',
                                                        'application' => 'Application',
                                                    ];
                                                    $badgeClass = $typeBadges[$value['type']] ?? 'bg-secondary';
                                                    $typeLabel = $typeLabels[$value['type']] ?? ucfirst($value['type']);
                                                @endphp
                                                <tr>
                                                    <td>{{ $no++ }}</td>
                                                    <td>
                                                        @if(!empty($value['image']))
                                                            <img src="{{ $logo . '/' . $value['image'] }}" alt="Preview" class="rounded" style="width: 60px; height: 40px; object-fit: cover;">
                                                        @elseif($value['type'] == 'video' && !empty($value['video_url']))
                                                            @php
                                                                $vid = '';
                                                                if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $value['video_url'], $m)) {
                                                                    $vid = $m[1];
                                                                }
                                                            @endphp
                                                            @if($vid)
                                                                <img src="https://img.youtube.com/vi/{{ $vid }}/default.jpg" alt="Video" class="rounded" style="width: 60px; height: 40px; object-fit: cover;">
                                                            @else
                                                                <span class="badge bg-light text-dark"><i class="ti ti-video"></i></span>
                                                            @endif
                                                        @elseif($value['type'] == 'website' && !empty($value['website_url']))
                                                            <img src="https://s0.wordpress.com/mshots/v1/{{ urlencode($value['website_url']) }}?w=200" alt="Website" class="rounded" style="width: 60px; height: 40px; object-fit: cover;">
                                                        @else
                                                            <span class="badge bg-light text-dark"><i class="ti ti-photo-off"></i></span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $value['title'] ?? '—' }}</td>
                                                    <td>{{ $value['category'] }}</td>
                                                    <td><span class="badge {{ $badgeClass }} p-2 px-3">{{ $typeLabel }}</span></td>
                                                    <td>
                                                        <span>
                                                            <div class="action-btn me-2">
                                                                <a href="#" class="mx-3 btn btn-sm align-items-center bg-info" data-url="{{ route('portfolio_edit', $key) }}" data-ajax-popup="true" data-title="{{__('Edit Portfolio')}}" data-size="lg" data-bs-toggle="tooltip" title="{{__('Edit')}}">
                                                                    <i class="ti ti-pencil text-white"></i>
                                                                </a>
                                                            </div>
                                                            <div class="action-btn">
                                                                {!! Form::open(['method' => 'GET', 'route' => ['portfolio_delete', $key], 'id'=>'delete-form-'.$key]) !!}
                                                                <a href="#" class="mx-3 btn btn-sm align-items-center bs-pass-para bg-danger" data-bs-toggle="tooltip" title="{{__('Delete')}}" data-confirm="{{__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')}}" data-confirm-yes="document.getElementById('delete-form-{{$key}}').submit();">
                                                                    <i class="ti ti-trash text-white"></i>
                                                                </a>
                                                                {!! Form::close() !!}
                                                            </div>
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                       @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
