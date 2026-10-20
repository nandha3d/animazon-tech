{{ Form::open(['route' => 'affiliate-links.store', 'method' => 'post']) }}
<div class="modal-body">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group mb-3">
                <label class="form-label">{{ __('Paste Raw Amazon URL') }}</label>
                <input type="text" name="raw_url" class="form-control" placeholder="https://www.amazon.in/dp/B08N5WRWNW...">
                <small class="text-muted">Auto-extracts ASIN automatically!</small>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group mb-3">
                {{ Form::label('asin', __('Or Enter Amazon ASIN'), ['class' => 'form-label']) }}
                {{ Form::text('asin', null, ['class' => 'form-control', 'placeholder' => 'e.g. B08N5WRWNW']) }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group mb-3">
                {{ Form::label('code', __('Custom Shortcode / Slug'), ['class' => 'form-label']) }}
                {{ Form::text('code', null, ['class' => 'form-control', 'placeholder' => 'e.g. boat-airdopes (Optional)']) }}
                <small class="text-muted">Blank uses ASIN directly (animazon.in/B08N5WRWNW)</small>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group mb-3">
                {{ Form::label('title', __('Product Title / Name'), ['class' => 'form-label']) }}
                {{ Form::text('title', null, ['class' => 'form-control', 'placeholder' => 'e.g. boAt Airdopes 141']) }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group mb-3">
                {{ Form::label('affiliate_tag', __('Amazon Store ID Tag'), ['class' => 'form-label']) }}
                <select name="affiliate_tag" class="form-select">
                    @foreach($storeIds as $s)
                        <option value="{{ $s->store_id }}" {{ $s->store_id === $defaultTag ? 'selected' : '' }}>
                            {{ $s->store_id }} ({{ $s->channel_name }})
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <input type="button" value="{{ __('Cancel') }}" class="btn btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{ __('Create Link') }}" class="btn btn-primary">
</div>
{{ Form::close() }}
