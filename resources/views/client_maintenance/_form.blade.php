{{-- Shared maintenance-plan field set. $plan is null on create. --}}
@php $p = $plan ?? null; @endphp
<datalist id="serviceTypeSuggestions">
    @foreach ($suggestions as $s)
        <option value="{{ $s }}">
    @endforeach
</datalist>
<div class="row">
    <div class="col-md-6 form-group">
        {{ Form::label('service_type', __('Service Type'), ['class' => 'form-label']) }}<x-required></x-required>
        <input type="text" list="serviceTypeSuggestions" name="service_type" class="form-control"
            value="{{ $p->service_type ?? old('service_type') }}" placeholder="{{ __('e.g. Website Maintenance, 3D Animation Retainer') }}" required>
    </div>
    <div class="col-md-6 form-group">
        {{ Form::label('title', __('Title / Label'), ['class' => 'form-label']) }}
        {{ Form::text('title', $p->title ?? null, ['class' => 'form-control', 'placeholder' => __('e.g. Monthly retainer')]) }}
    </div>
    <div class="col-md-4 form-group">
        {{ Form::label('amount', __('Amount'), ['class' => 'form-label']) }}<x-required></x-required>
        {{ Form::number('amount', $p->amount ?? null, ['class' => 'form-control', 'step' => '0.01', 'required' => 'required']) }}
    </div>
    <div class="col-md-4 form-group">
        {{ Form::label('billing_cycle', __('Billing Cycle'), ['class' => 'form-label']) }}<x-required></x-required>
        <select name="billing_cycle" class="form-control select" required>
            @foreach ($cycles as $key => $c)
                <option value="{{ $key }}" @selected(($p->billing_cycle ?? '') == $key)>{{ __($c['label']) }}</option>
            @endforeach
        </select>
    </div>
    @if ($p)
        <div class="col-md-4 form-group">
            {{ Form::label('status', __('Status'), ['class' => 'form-label']) }}
            <select name="status" class="form-control select">
                <option value="active" @selected($p->status == 'active')>{{ __('Active') }}</option>
                <option value="paused" @selected($p->status == 'paused')>{{ __('Paused') }}</option>
                <option value="cancelled" @selected($p->status == 'cancelled')>{{ __('Cancelled') }}</option>
            </select>
        </div>
    @endif
    <div class="col-md-4 form-group">
        {{ Form::label('start_date', __('Start Date'), ['class' => 'form-label']) }}
        {{ Form::date('start_date', isset($p->start_date) ? $p->start_date->format('Y-m-d') : null, ['class' => 'form-control']) }}
    </div>
    <div class="col-md-4 form-group">
        {{ Form::label('next_due_date', __('Next Due Date'), ['class' => 'form-label']) }}
        {{ Form::date('next_due_date', isset($p->next_due_date) ? $p->next_due_date->format('Y-m-d') : null, ['class' => 'form-control']) }}
        <div class="text-xs mt-1 text-muted">{{ __('Leave blank to default to the start date.') }}</div>
    </div>
</div>
<div class="row">
    <div class="col-12 form-group">
        {{ Form::label('notes', __('Notes'), ['class' => 'form-label']) }}
        {{ Form::textarea('notes', $p->notes ?? null, ['class' => 'form-control', 'rows' => 3]) }}
    </div>
</div>
