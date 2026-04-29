@props(['currencies' => null, 'selected' => null, 'label' => 'Select Currency', 'id' => 'currencySelect'])

@if (!$currencies)
    @php
        $currencies = \App\Models\Currency::where('active', true)->orderBy('name')->get();
    @endphp
@endif

@if (!$selected)
    @php
        $selected = get_user_currency()->code ?? 'USD';
    @endphp
@endif

<div class="currency-selector">
    <label for="{{ $id }}" class="form-label">{{ $label }}</label>
    <select id="{{ $id }}" name="currency_code" class="form-select" {{ $attributes }}>
        @foreach($currencies as $currency)
            <option value="{{ $currency->code }}" @selected($selected === $currency->code)>
                {{ $currency->symbol }} {{ $currency->code }} - {{ $currency->name }}
            </option>
        @endforeach
    </select>
</div>

<style>
.currency-selector {
    margin-bottom: 1rem;
}

.currency-selector .form-select {
    max-width: 100%;
    border: 1px solid #dee2e6;
    padding: 0.5rem 0.75rem;
}

.currency-selector .form-select:focus {
    border-color: #80bdff;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}
</style>
