{{ Form::open(array('route' => 'portfolio_store', 'method'=>'post', 'enctype' => "multipart/form-data", 'class'=>'needs-validation', 'novalidate')) }}
    <div class="modal-body">
        <div class="row">
            <!-- Basic Info -->
            <div class="col-md-6">
                <div class="form-group">
                    {{ Form::label('title', __('Title'), ['class' => 'form-label']) }}<x-required></x-required>
                    {{ Form::text('title', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => __('Enter project title')]) }}
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    {{ Form::label('category', __('Category'), ['class' => 'form-label']) }}<x-required></x-required>
                    {{ Form::select('category', [
                        'Web Apps' => 'Web Apps',
                        'Mobile Apps' => 'Mobile Apps',
                        '3D Animation' => '3D Animation',
                        'Games' => 'Games',
                        'Websites' => 'Websites',
                    ], null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => __('Select Category')]) }}
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    {{ Form::label('description', __('Description'), ['class' => 'form-label']) }}
                    {{ Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => __('Brief description of this project'), 'rows' => 2]) }}
                </div>
            </div>

            <!-- Portfolio Type Selection -->
            <div class="col-md-12 border-top pt-3 mt-3">
                <div class="form-group">
                    {{ Form::label('type', __('Portfolio Type'), ['class' => 'form-label']) }}<x-required></x-required>
                    <div class="d-flex gap-2 flex-wrap mt-2">
                        @foreach([
                            'website' => ['icon' => 'ti-world', 'label' => 'Website', 'color' => 'warning'],
                            'video' => ['icon' => 'ti-brand-youtube', 'label' => 'Video', 'color' => 'danger'],
                            '3d' => ['icon' => 'ti-box', 'label' => '3D Work', 'color' => 'info'],
                            'application' => ['icon' => 'ti-device-mobile', 'label' => 'Application', 'color' => 'success'],
                        ] as $typeValue => $typeConfig)
                            <label class="portfolio-type-btn">
                                <input type="radio" name="type" value="{{ $typeValue }}" class="d-none portfolio-type-radio" {{ $typeValue == 'website' ? 'checked' : '' }}>
                                <span class="btn btn-outline-{{ $typeConfig['color'] }} btn-sm portfolio-type-label">
                                    <i class="ti {{ $typeConfig['icon'] }} me-1"></i>{{ $typeConfig['label'] }}
                                </span>
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Common Fields -->
            <div class="col-md-6 portfolio-field portfolio-field-common">
                <div class="form-group">
                    {{ Form::label('completion_date', __('Completion Date'), ['class' => 'form-label']) }}
                    {{ Form::date('completion_date', null, ['class' => 'form-control']) }}
                </div>
            </div>
            <div class="col-md-6 portfolio-field portfolio-field-common">
                <div class="form-group">
                    {{ Form::label('project_price', __('Project Price (₹)'), ['class' => 'form-label']) }}
                    {{ Form::text('project_price', null, ['class' => 'form-control', 'placeholder' => __('15,000')]) }}
                </div>
            </div>
            <div class="col-md-6 portfolio-field portfolio-field-common">
                <div class="form-group">
                    {{ Form::label('client_name', __('Client Name'), ['class' => 'form-label']) }}
                    {{ Form::text('client_name', null, ['class' => 'form-control']) }}
                </div>
            </div>
            <div class="col-md-6 portfolio-field portfolio-field-common">
                <div class="form-group">
                    {{ Form::label('badge_text', __('Badge Text'), ['class' => 'form-label']) }}
                    {{ Form::text('badge_text', null, ['class' => 'form-control', 'placeholder' => __('Featured, New, etc.')]) }}
                </div>
            </div>
            <div class="col-md-12 portfolio-field portfolio-field-common">
                <div class="form-group">
                    {{ Form::label('tech_stack', __('Technology Stack'), ['class' => 'form-label']) }}
                    {{ Form::text('tech_stack', null, ['class' => 'form-control', 'placeholder' => __('WordPress, React, Node.js (comma separated)')]) }}
                </div>
            </div>
            <div class="col-md-6 portfolio-field portfolio-field-common">
                <div class="form-group">
                    {{ Form::label('github_url', __('GitHub URL'), ['class' => 'form-label']) }}
                    {{ Form::url('github_url', null, ['class' => 'form-control', 'placeholder' => __('https://github.com/...')]) }}
                </div>
            </div>
            <div class="col-md-6 portfolio-field portfolio-field-common">
                <div class="form-group mt-4">
                    <div class="form-check form-switch">
                        <input type="checkbox" class="form-check-input" id="featured" name="featured" value="1">
                        <label class="form-check-label" for="featured">{{ __('Mark as Featured Project') }}</label>
                    </div>
                </div>
            </div>

            <div class="col-md-12 portfolio-field portfolio-field-common border-top pt-3 mt-3">
                <div class="form-group">
                    {{ Form::label('image', __('Cover Image / Thumbnail'), ['class' => 'form-label']) }}
                    <input type="file" name="image" class="form-control" accept="image/*">
                    <small class="text-muted">{{ __('Upload a cover image (1200x800px recommended). For videos, YouTube thumbnail is auto-fetched if left blank.') }}</small>
                </div>
            </div>

            <!-- Website Fields -->
            <div class="col-md-6 portfolio-field portfolio-field-website d-none border-top pt-3 mt-3">
                <div class="form-group">
                    {{ Form::label('website_url', __('Website URL'), ['class' => 'form-label']) }}<x-required></x-required>
                    {{ Form::url('website_url', null, ['class' => 'form-control', 'placeholder' => __('https://example.com')]) }}
                </div>
            </div>
            <div class="col-md-6 portfolio-field portfolio-field-website d-none border-top pt-3 mt-3">
                <div class="form-group">
                    {{ Form::label('demo_url', __('Demo URL'), ['class' => 'form-label']) }}
                    {{ Form::url('demo_url', null, ['class' => 'form-control', 'placeholder' => __('https://demo.example.com')]) }}
                </div>
            </div>

            <!-- Video Fields -->
            <div class="col-md-12 portfolio-field portfolio-field-video d-none border-top pt-3 mt-3">
                <div class="form-group">
                    {{ Form::label('video_url', __('YouTube Video URL'), ['class' => 'form-label']) }}<x-required></x-required>
                    {{ Form::url('video_url', null, ['class' => 'form-control', 'placeholder' => __('https://www.youtube.com/watch?v=...')]) }}
                </div>
            </div>
            <div class="col-md-12 portfolio-field portfolio-field-video d-none">
                <div class="form-group">
                    {{ Form::label('youtube_playlist_url', __('YouTube Playlist URL'), ['class' => 'form-label']) }}
                    {{ Form::url('youtube_playlist_url', null, ['class' => 'form-control']) }}
                </div>
            </div>
            <div class="col-md-6 portfolio-field portfolio-field-video d-none">
                <div class="form-group">
                    {{ Form::label('video_duration', __('Video Duration'), ['class' => 'form-label']) }}
                    {{ Form::text('video_duration', null, ['class' => 'form-control', 'placeholder' => __('5:30')]) }}
                </div>
            </div>
            <div class="col-md-6 portfolio-field portfolio-field-video d-none">
                <div class="form-group">
                    {{ Form::label('video_views', __('Total Views'), ['class' => 'form-label']) }}
                    {{ Form::text('video_views', null, ['class' => 'form-control', 'placeholder' => __('10,000')]) }}
                </div>
            </div>

            <!-- 3D Fields -->
            <div class="col-md-4 portfolio-field portfolio-field-3d d-none border-top pt-3 mt-3">
                <div class="form-group">
                    {{ Form::label('software_used', __('Software Used'), ['class' => 'form-label']) }}
                    {{ Form::text('software_used', null, ['class' => 'form-control', 'placeholder' => __('Blender, Maya')]) }}
                </div>
            </div>
            <div class="col-md-4 portfolio-field portfolio-field-3d d-none border-top pt-3 mt-3">
                <div class="form-group">
                    {{ Form::label('render_engine', __('Render Engine'), ['class' => 'form-label']) }}
                    {{ Form::text('render_engine', null, ['class' => 'form-control', 'placeholder' => __('Cycles, V-Ray')]) }}
                </div>
            </div>
            <div class="col-md-4 portfolio-field portfolio-field-3d d-none border-top pt-3 mt-3">
                <div class="form-group">
                    {{ Form::label('poly_count', __('Polygon Count'), ['class' => 'form-label']) }}
                    {{ Form::text('poly_count', null, ['class' => 'form-control', 'placeholder' => __('50,000')]) }}
                </div>
            </div>

            <!-- Application Fields -->
            <div class="col-md-4 portfolio-field portfolio-field-application d-none border-top pt-3 mt-3">
                <div class="form-group">
                    {{ Form::label('app_platform', __('Platform'), ['class' => 'form-label']) }}
                    {{ Form::select('app_platform', [
                        'ios' => 'iOS',
                        'android' => 'Android',
                        'web' => 'Web App',
                        'desktop' => 'Desktop',
                        'cross-platform' => 'Cross-Platform',
                    ], null, ['class' => 'form-control', 'placeholder' => __('Select Platform')]) }}
                </div>
            </div>
            <div class="col-md-4 portfolio-field portfolio-field-application d-none border-top pt-3 mt-3">
                <div class="form-group">
                    {{ Form::label('app_version', __('Version'), ['class' => 'form-label']) }}
                    {{ Form::text('app_version', null, ['class' => 'form-control', 'placeholder' => __('1.0.0')]) }}
                </div>
            </div>
            <div class="col-md-4 portfolio-field portfolio-field-application d-none border-top pt-3 mt-3">
                <div class="form-group">
                    {{ Form::label('app_size', __('App Size'), ['class' => 'form-label']) }}
                    {{ Form::text('app_size', null, ['class' => 'form-control', 'placeholder' => __('45 MB')]) }}
                </div>
            </div>
            <div class="col-md-4 portfolio-field portfolio-field-application d-none">
                <div class="form-group">
                    {{ Form::label('app_store_url', __('App Store URL'), ['class' => 'form-label']) }}
                    {{ Form::url('app_store_url', null, ['class' => 'form-control']) }}
                </div>
            </div>
            <div class="col-md-4 portfolio-field portfolio-field-application d-none">
                <div class="form-group">
                    {{ Form::label('play_store_url', __('Play Store URL'), ['class' => 'form-label']) }}
                    {{ Form::url('play_store_url', null, ['class' => 'form-control']) }}
                </div>
            </div>
            <div class="col-md-4 portfolio-field portfolio-field-application d-none">
                <div class="form-group">
                    {{ Form::label('download_url', __('Direct Download URL'), ['class' => 'form-label']) }}
                    {{ Form::url('download_url', null, ['class' => 'form-control']) }}
                </div>
            </div>
            <div class="col-md-12 portfolio-field portfolio-field-application d-none">
                <div class="form-group">
                    {{ Form::label('mobile_screenshots', __('App Gallery / Screenshots'), ['class' => 'form-label']) }}
                    <input type="file" name="mobile_screenshots[]" class="form-control" accept="image/*" multiple>
                    <small class="text-muted">{{ __('Upload multiple screenshots to create a carousel slider for the application.') }}</small>
                </div>
            </div>

        </div>
    </div>
    <div class="modal-footer">
        <input type="button" value="{{__('Cancel')}}" class="btn btn-light" data-bs-dismiss="modal">
        <input type="submit" value="{{__('Create')}}" class="btn btn-primary">
    </div>
{{ Form::close() }}

<style>
    .portfolio-type-btn input:checked + .portfolio-type-label {
        color: #fff !important;
    }
    .portfolio-type-btn input[value="website"]:checked + .portfolio-type-label { background-color: var(--bs-warning); border-color: var(--bs-warning); }
    .portfolio-type-btn input[value="video"]:checked + .portfolio-type-label { background-color: var(--bs-danger); border-color: var(--bs-danger); }
    .portfolio-type-btn input[value="3d"]:checked + .portfolio-type-label { background-color: var(--bs-info); border-color: var(--bs-info); }
    .portfolio-type-btn input[value="application"]:checked + .portfolio-type-label { background-color: var(--bs-success); border-color: var(--bs-success); }
</style>

<script>
    $(document).ready(function() {
        function toggleFields(type) {
            // Always show common and image upload
            $('.portfolio-field').addClass('d-none');
            $('.portfolio-field-common').removeClass('d-none');
            // Show type-specific fields
            $('.portfolio-field-' + type).removeClass('d-none');
        }

        // Initial state
        toggleFields($('.portfolio-type-radio:checked').val() || 'website');

        // On type change
        $('.portfolio-type-radio').on('change', function() {
            toggleFields($(this).val());
        });
    });
</script>
