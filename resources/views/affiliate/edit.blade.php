{{ Form::model($link, ['route' => ['affiliate-links.update', $link->id], 'method' => 'PUT']) }}
<div class="modal-body">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group mb-3">
                {{ Form::label('title', __('Product Title / Name'), ['class' => 'form-label']) }}
                {{ Form::text('title', null, ['class' => 'form-control', 'required' => 'required']) }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group mb-3">
                {{ Form::label('code', __('Short Code / Slug'), ['class' => 'form-label']) }}
                {{ Form::text('code', null, ['class' => 'form-control', 'required' => 'required']) }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group mb-3">
                {{ Form::label('asin', __('Amazon ASIN'), ['class' => 'form-label']) }}
                {{ Form::text('asin', null, ['class' => 'form-control']) }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group mb-3">
                {{ Form::label('target_url', __('Direct Target URL'), ['class' => 'form-label']) }}
                {{ Form::url('target_url', null, ['class' => 'form-control']) }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group mb-3">
                {{ Form::label('affiliate_tag', __('Amazon Store ID Tag'), ['class' => 'form-label']) }}
                <select name="affiliate_tag" class="form-select">
                    @foreach($storeIds as $s)
                        <option value="{{ $s->store_id }}" {{ $link->affiliate_tag == $s->store_id ? 'selected' : '' }}>
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
    <input type="submit" value="{{ __('Update Link') }}" class="btn btn-primary">
</div>
{{ Form::close() }}
