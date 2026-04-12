@extends('layouts.admin')
@section('page-title')
    {{ __('Landing Page') }}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item">{{ __('Landing Page') }}</li>
@endsection

@php
    $lang = \App\Models\Utility::getValByName('default_language');
    $logo = \App\Models\Utility::get_file('uploads/logo');
    $logo_light = \App\Models\Utility::getValByName('logo_light');
    $logo_dark = \App\Models\Utility::getValByName('logo_dark');
    $company_favicon = \App\Models\Utility::getValByName('company_favicon');
    $setting = \App\Models\Utility::colorset();
    $mode_setting = \App\Models\Utility::mode_layout();
    $color = !empty($setting['color']) ? $setting['color'] : 'theme-3';
    $SITE_RTL = isset($setting['SITE_RTL']) ? $setting['SITE_RTL'] : 'off';
    $meta_image = \App\Models\Utility::get_file('uploads/meta/');

@endphp


@push('script-page')
    <script>
        function summernote() {
            if ($(".summernote-simple").length) {
                $('.summernote-simple').summernote({
                    toolbar: [
                        ['style', ['style']],
                        ['font', ['bold', 'italic', 'underline', 'strikethrough']],
                        ['list', ['ul', 'ol', 'paragraph']],
                        ['insert', ['link', 'unlink']],
                    ],
                    height: 250,
                });
            }
        }
    </script>
    <script>
        if(window.innerWidth <= 500)
        {
            $('p').removeClass('text-sm');
        }
    </script>
@endpush

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item">{{ __('Landing Page') }}</li>
@endsection


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
                    {{--  Start for all settings tab --}}


                    {{ Form::open(array('route' => 'footer.store', 'method'=>'post', 'enctype' => "multipart/form-data", 'class'=>'needs-validation', 'novalidate')) }}
                        <div class="card">
                            <div class="card-header">
                                <div class="row align-items-center">
                                    <div class="col-10">
                                        <h5>{{ __('Footer') }}</h5>
                                    </div>
                                    <div class="col switch-width text-end">
                                        <div class="form-group mb-0">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" data-toggle="switchbutton" data-onstyle="primary" name="footer_status"
                                                    id="footer_status" {{ $settings['footer_status'] == 'on' ? 'checked="checked"' : '' }}>
                                                <label class="custom-control-label" for="footer_status"></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {{ Form::label('footer_address', __('Address'), ['class' => 'form-label']) }}
                                            {{ Form::text('footer_address', $settings['footer_address'], ['class' => 'form-control', 'placeholder' => __('Enter Address')]) }}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {{ Form::label('footer_email', __('Email'), ['class' => 'form-label']) }}
                                            {{ Form::email('footer_email', $settings['footer_email'], ['class' => 'form-control', 'placeholder' => __('Enter Email')]) }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-end">
                                <input class="btn btn-print-invoice btn-primary m-r-10" type="submit"
                                    value="{{ __('Save Changes') }}">
                            </div>
                        </div>
                    {{ Form::close() }}


                    {{--  End for all settings tab --}}
                </div>
            </div>
        </div>
    </div>
@endsection
