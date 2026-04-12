{{ Form::open(array('route' => 'portfolio_store', 'method'=>'post', 'enctype' => "multipart/form-data", 'class'=>'needs-validation', 'novalidate')) }}
    <div class="modal-body">
        <div class="row">
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
            <div class="col-md-12">
                <div class="form-group">
                    {{ Form::label('type', __('Portfolio Type'), ['class' => 'form-label']) }}<x-required></x-required>
                    <div class="d-flex gap-2 flex-wrap mt-2">
                        @foreach([
                            'image' => ['icon' => 'ti-photo', 'label' => 'Image', 'color' => 'primary'],
                            'video' => ['icon' => 'ti-brand-youtube', 'label' => 'Video', 'color' => 'danger'],
                            'game' => ['icon' => 'ti-device-gamepad-2', 'label' => 'Game', 'color' => 'info'],
                            'website' => ['icon' => 'ti-world', 'label' => 'Website', 'color' => 'warning'],
                            'mobile_app' => ['icon' => 'ti-device-mobile', 'label' => 'Mobile App', 'color' => 'success'],
                        ] as $typeValue => $typeConfig)
                            <label class="portfolio-type-btn">
                                <input type="radio" name="type" value="{{ $typeValue }}" class="d-none portfolio-type-radio" {{ $typeValue == 'image' ? 'checked' : '' }}>
                                <span class="btn btn-outline-{{ $typeConfig['color'] }} btn-sm portfolio-type-label">
                                    <i class="ti {{ $typeConfig['icon'] }} me-1"></i>{{ $typeConfig['label'] }}
                                </span>
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Image Upload (shown for all types as cover image) --}}
            <div class="col-md-12 portfolio-field portfolio-field-image">
                <div class="form-group">
                    {{ Form::label('image', __('Cover Image'), ['class' => 'form-label']) }}
                    <input type="file" name="image" class="form-control" accept="image/*">
                    <small class="text-muted">{{ __('Upload a cover/preview image for this portfolio item.') }}</small>
                </div>
            </div>

            {{-- Video URL --}}
            <div class="col-md-12 portfolio-field portfolio-field-video d-none">
                <div class="form-group">
                    {{ Form::label('video_url', __('YouTube Video URL'), ['class' => 'form-label']) }}<x-required></x-required>
                    {{ Form::text('video_url', null, ['class' => 'form-control', 'placeholder' => __('https://www.youtube.com/watch?v=...')]) }}
                </div>
            </div>

            {{-- Game Embed URL --}}
            <div class="col-md-12 portfolio-field portfolio-field-game d-none">
                <div class="form-group">
                    {{ Form::label('game_url', __('Game Embed URL'), ['class' => 'form-label']) }}<x-required></x-required>
                    {{ Form::text('game_url', null, ['class' => 'form-control', 'placeholder' => __('https://itch.io/embed/... or game iframe URL')]) }}
                    <small class="text-muted">{{ __('Paste the embed URL from itch.io, GameJolt, or any game hosting platform.') }}</small>
                </div>
            </div>

            {{-- Website URL --}}
            <div class="col-md-12 portfolio-field portfolio-field-website d-none">
                <div class="form-group">
                    {{ Form::label('website_url', __('Website URL'), ['class' => 'form-label']) }}<x-required></x-required>
                    {{ Form::text('website_url', null, ['class' => 'form-control', 'placeholder' => __('https://example.com')]) }}
                    <small class="text-muted">{{ __('The live website URL to preview in an embedded frame.') }}</small>
                </div>
            </div>

            {{-- Mobile App Screenshots --}}
            <div class="col-md-12 portfolio-field portfolio-field-mobile_app d-none">
                <div class="form-group">
                    {{ Form::label('mobile_screenshots', __('Mobile App Screenshots'), ['class' => 'form-label']) }}<x-required></x-required>
                    <input type="file" name="mobile_screenshots[]" class="form-control" accept="image/*" multiple>
                    <small class="text-muted">{{ __('Upload multiple screenshots of your mobile app. They will be displayed in a phone simulator.') }}</small>
                </div>
            </div>
            <div class="col-md-12 portfolio-field portfolio-field-mobile_app d-none">
                <div class="form-group">
                    {{ Form::label('mobile_app_url', __('App Store / Play Store URL (optional)'), ['class' => 'form-label']) }}
                    {{ Form::text('mobile_app_url', null, ['class' => 'form-control', 'placeholder' => __('https://play.google.com/store/apps/...')]) }}
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
    .portfolio-type-btn input[value="image"]:checked + .portfolio-type-label { background-color: var(--bs-primary); border-color: var(--bs-primary); }
    .portfolio-type-btn input[value="video"]:checked + .portfolio-type-label { background-color: var(--bs-danger); border-color: var(--bs-danger); }
    .portfolio-type-btn input[value="game"]:checked + .portfolio-type-label { background-color: var(--bs-info); border-color: var(--bs-info); }
    .portfolio-type-btn input[value="website"]:checked + .portfolio-type-label { background-color: var(--bs-warning); border-color: var(--bs-warning); }
    .portfolio-type-btn input[value="mobile_app"]:checked + .portfolio-type-label { background-color: var(--bs-success); border-color: var(--bs-success); }
</style>

<script>
    $(document).ready(function() {
        function toggleFields(type) {
            // Always show image upload
            $('.portfolio-field').addClass('d-none');
            $('.portfolio-field-image').removeClass('d-none');
            // Show type-specific fields
            $('.portfolio-field-' + type).removeClass('d-none');
        }

        // Initial state
        toggleFields($('.portfolio-type-radio:checked').val() || 'image');

        // On type change
        $('.portfolio-type-radio').on('change', function() {
            toggleFields($(this).val());
        });
    });
</script>
