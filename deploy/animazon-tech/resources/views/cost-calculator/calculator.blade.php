@extends('layouts.admin')

@section('page-title')
    {{ __('Cost Calculator') }} - {{ $projectType->name }}
@endsection

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="{{ $projectType->icon ?? 'ti ti-calculator' }}"></i>
                        {{ $projectType->name }} {{ __('Cost Calculator') }}
                    </h5>
                </div>
                <div class="card-body">
                    <!-- Currency Selector -->
                    <div class="mb-4 pb-3 border-bottom">
                        <label class="form-label font-weight-bold">{{ __('Select Currency') }}</label>
                        <select id="currencySelect" class="form-select">
                            <option value="">{{ __('Detecting...') }}</option>
                        </select>
                        <small class="text-muted d-block mt-1">{{ __('Currency is auto-detected based on your location. You can change it here.') }}</small>
                    </div>

                    <form id="costCalculatorForm">
                        @csrf
                        <input type="hidden" name="project_type_id" value="{{ $projectType->id }}">
                        <input type="hidden" name="currency_code" id="currencyCode" value="USD">

                        @forelse($questions as $question)
                            <div class="mb-4 pb-3 border-bottom">
                                <label class="form-label font-weight-bold">
                                    {{ $question->question }}
                                    @if($question->required)
                                        <span class="text-danger">*</span>
                                    @endif
                                </label>

                                @if($question->description)
                                    <small class="text-muted d-block mb-2">{{ $question->description }}</small>
                                @endif

                                @if($question->type === 'single_select')
                                    <div>
                                        @foreach($question->answers->sortBy('order') as $answer)
                                            <div class="form-check mb-2">
                                                <input 
                                                    class="form-check-input answer-input" 
                                                    type="radio" 
                                                    id="answer_{{ $answer->id }}" 
                                                    name="answers[{{ $question->id }}]" 
                                                    value="{{ $answer->id }}"
                                                    @if($question->required) required @endif>
                                                <label class="form-check-label" for="answer_{{ $answer->id }}">
                                                    {{ $answer->answer_text }}
                                                    @if($answer->additional_cost || $answer->cost_multiplier != 1)
                                                        <span class="badge bg-info">
                                                            @if($answer->additional_cost)
                                                                +{{ currency_symbol() }}{{ number_format($answer->additional_cost, 2) }}
                                                            @endif
                                                            @if($answer->cost_multiplier != 1)
                                                                (x{{ $answer->cost_multiplier }})
                                                            @endif
                                                        </span>
                                                    @endif
                                                </label>
                                                @if($answer->explanation)
                                                    <small class="text-muted d-block ms-4">{{ $answer->explanation }}</small>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>

                                @elseif($question->type === 'multi_select')
                                    <div>
                                        @foreach($question->answers->sortBy('order') as $answer)
                                            <div class="form-check mb-2">
                                                <input 
                                                    class="form-check-input answer-input" 
                                                    type="checkbox" 
                                                    id="answer_{{ $answer->id }}" 
                                                    name="answers[{{ $question->id }}][]" 
                                                    value="{{ $answer->id }}">
                                                <label class="form-check-label" for="answer_{{ $answer->id }}">
                                                    {{ $answer->answer_text }}
                                                    @if($answer->additional_cost || $answer->cost_multiplier != 1)
                                                        <span class="badge bg-info">
                                                            @if($answer->additional_cost)
                                                                +{{ currency_symbol() }}{{ number_format($answer->additional_cost, 2) }}
                                                            @endif
                                                            @if($answer->cost_multiplier != 1)
                                                                (x{{ $answer->cost_multiplier }})
                                                            @endif
                                                        </span>
                                                    @endif
                                                </label>
                                                @if($answer->explanation)
                                                    <small class="text-muted d-block ms-4">{{ $answer->explanation }}</small>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>

                                @elseif($question->type === 'input')
                                    <input 
                                        type="text" 
                                        class="form-control answer-input" 
                                        name="answers[{{ $question->id }}]"
                                        @if($question->required) required @endif>
                                @endif
                            </div>
                        @empty
                            <div class="alert alert-warning">
                                {{ __('No questions available for this project type') }}
                            </div>
                        @endforelse

                        <div class="mt-4">
                            <button type="button" class="btn btn-primary" id="calculateBtn">
                                <i class="ti ti-calculator"></i> {{ __('Calculate Cost') }}
                            </button>
                            <a href="{{ route('cost-calculator.show') }}" class="btn btn-secondary">
                                {{ __('Back') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm" id="resultCard" style="display: none;">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">{{ __('Cost Estimation') }}</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <p class="text-muted mb-1">{{ __('Base Cost') }}:</p>
                        <h6><span id="currencySymbol">$</span><span id="baseCost">0.00</span></h6>
                    </div>

                    <div class="mb-3">
                        <p class="text-muted mb-1">{{ __('Total Cost') }}:</p>
                        <h5 class="text-primary"><span id="currencySymbol2">$</span><span id="totalCost">0.00</span></h5>
                    </div>

                    <hr>

                    <div class="mb-3">
                        <p class="text-muted mb-1">{{ __('Tax') }} (<span id="taxPercent">0</span>%):</p>
                        <h6><span id="currencySymbol3">$</span><span id="taxAmount">0.00</span></h6>
                    </div>

                    <div class="bg-light p-3 rounded mb-3">
                        <p class="text-muted mb-1">{{ __('Grand Total') }}:</p>
                        <h4 class="text-success mb-0">
                            <span id="currencySymbol4">$</span><span id="grandTotal">0.00</span>
                            <small class="text-muted d-block mt-1">≈ $<span id="grandTotalUSD">0.00</span> USD</small>
                        </h4>
                    </div>

                    <div class="mb-3">
                        <p class="text-muted mb-1">{{ __('Estimated Timeline') }}:</p>
                        <h6><span id="timeline">0</span> {{ __('weeks') }}</h6>
                    </div>

                    <div class="mb-3">
                        <p class="text-muted mb-1">{{ __('Estimated Team Size') }}:</p>
                        <h6><span id="teamSize">0</span> {{ __('members') }}</h6>
                    </div>

                    <button type="button" class="btn btn-success w-100" id="saveEstimateBtn" style="display: none;">
                        <i class="ti ti-save"></i> {{ __('Save Estimate') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Estimate Form Modal -->
<div class="modal fade" id="saveEstimateModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('Save Estimate') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="saveEstimateForm">
                <div class="modal-body">
                    <input type="hidden" name="project_type_id" value="{{ $projectType->id }}">
                    <input type="hidden" name="total_cost" id="saveTotalCost">
                    <input type="hidden" name="tax_percentage" id="saveTaxPercentage">
                    <input type="hidden" name="tax_amount" id="saveTaxAmount">
                    <input type="hidden" name="grand_total" id="saveGrandTotal">
                    <input type="hidden" name="timeline_weeks" id="saveTimeline">
                    <input type="hidden" name="team_size" id="saveTeamSize">
                    <input type="hidden" name="answers" id="saveAnswers">

                    <div class="mb-3">
                        <label class="form-label">{{ __('Project Name') }} *</label>
                        <input type="text" class="form-control" name="project_name" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">{{ __('Client') }}</label>
                        <select class="form-control select2" name="client_id">
                            <option value="">{{ __('Select Client') }}</option>
                            <!-- Populate with customers from backend -->
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">{{ __('Notes') }}</label>
                        <textarea class="form-control" name="notes" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Close') }}</button>
                    <button type="submit" class="btn btn-primary">{{ __('Save Estimate') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    let currenciesList = [];
    let selectedCurrency = null;

    // Load currencies on page load
    document.addEventListener('DOMContentLoaded', function() {
        loadCurrencies();
        detectUserCurrency();
    });

    // Load available currencies
    function loadCurrencies() {
        fetch('{{ route("currencies.current") }}', {
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            selectedCurrency = data;
            updateCurrencyDisplay(data.symbol);
            document.getElementById('currencyCode').value = data.code;
            
            // Load all available currencies for dropdown
            fetch('/api/currencies', {
                method: 'GET'
            })
            .then(response => response.json())
            .then(currencies => {
                currenciesList = currencies;
                populateCurrencyDropdown(data.code);
            })
            .catch(() => {
                // Fallback - populate with common currencies
                populateCurrencyDropdown(data.code);
            });
        });
    }

    // Detect user currency from geolocation
    function detectUserCurrency() {
        // The server-side detection is automatic via router middleware
        // This is just for display purposes
        console.log('User currency auto-detected');
    }

    // Populate currency dropdown
    function populateCurrencyDropdown(selectedCode) {
        const select = document.getElementById('currencySelect');
        
        // If we have the full list from API, use it
        if (currenciesList.length > 0) {
            select.innerHTML = '';
            currenciesList.forEach(currency => {
                const option = document.createElement('option');
                option.value = currency.code;
                option.textContent = `${currency.symbol} ${currency.code} - ${currency.name}`;
                option.selected = currency.code === selectedCode;
                select.appendChild(option);
            });
        } else {
            // Fallback hardcoded list
            const currencies = [
                { code: 'USD', name: 'US Dollar', symbol: '$' },
                { code: 'INR', name: 'Indian Rupee', symbol: '₹' },
                { code: 'EUR', name: 'Euro', symbol: '€' },
                { code: 'GBP', name: 'British Pound', symbol: '£' },
                { code: 'CAD', name: 'Canadian Dollar', symbol: 'C$' },
                { code: 'AUD', name: 'Australian Dollar', symbol: 'A$' },
                { code: 'JPY', name: 'Japanese Yen', symbol: '¥' },
                { code: 'SGD', name: 'Singapore Dollar', symbol: 'S$' },
                { code: 'HKD', name: 'Hong Kong Dollar', symbol: 'HK$' },
                { code: 'THB', name: 'Thai Baht', symbol: '฿' },
                { code: 'CNY', name: 'Chinese Yuan', symbol: '¥' },
                { code: 'CHF', name: 'Swiss Franc', symbol: 'CHF' },
                { code: 'SEK', name: 'Swedish Krona', symbol: 'kr' },
                { code: 'NOK', name: 'Norwegian Krone', symbol: 'kr' },
                { code: 'PKR', name: 'Pakistani Rupee', symbol: '₨' },
                { code: 'BDT', name: 'Bangladeshi Taka', symbol: '৳' },
                { code: 'ZAR', name: 'South African Rand', symbol: 'R' },
                { code: 'BRL', name: 'Brazilian Real', symbol: 'R$' },
                { code: 'MXN', name: 'Mexican Peso', symbol: '$' }
            ];
            
            select.innerHTML = '';
            currencies.forEach(currency => {
                const option = document.createElement('option');
                option.value = currency.code;
                option.textContent = `${currency.symbol} ${currency.code} - ${currency.name}`;
                option.selected = currency.code === selectedCode;
                select.appendChild(option);
            });
        }
    }

    // Handle currency change
    document.getElementById('currencySelect').addEventListener('change', function() {
        const currencyCode = this.value;
        if (currencyCode) {
            document.getElementById('currencyCode').value = currencyCode;
            
            // Save user preference
            fetch('{{ route('currencies.switch') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ currency_code: currencyCode })
            })
            .then(response => response.json())
            .then(data => {
                // Update currency symbol display
                const selectedOption = this.options[this.selectedIndex];
                const symbol = selectedOption.textContent.match(/^(.{1,3})\s/)[1];
                updateCurrencyDisplay(symbol);
                
                // Re-calculate if there's already a result
                if (document.getElementById('resultCard').style.display !== 'none') {
                    calculateCost();
                }
            });
        }
    });

    // Update currency symbol in all displays
    function updateCurrencyDisplay(symbol) {
        document.getElementById('currencySymbol').textContent = symbol;
        document.getElementById('currencySymbol2').textContent = symbol;
        document.getElementById('currencySymbol3').textContent = symbol;
        document.getElementById('currencySymbol4').textContent = symbol;
        selectedCurrency = { symbol: symbol };
    }

    // Calculate cost with currency conversion
    function calculateCost() {
        const form = document.getElementById('costCalculatorForm');
        const formData = new FormData(form);

        fetch('{{ route('cost-calculator.calculate') }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                // Display converted amounts
                document.getElementById('baseCost').textContent = number_format(data.grand_total_converted > 0 ? data.base_cost * (data.grand_total_converted / data.grand_total) : data.base_cost);
                document.getElementById('totalCost').textContent = number_format(data.grand_total_converted > 0 ? data.total_cost * (data.grand_total_converted / data.grand_total) : data.total_cost);
                document.getElementById('taxAmount').textContent = number_format(data.grand_total_converted > 0 ? data.tax_amount * (data.grand_total_converted / data.grand_total) : data.tax_amount);
                document.getElementById('taxPercent').textContent = data.tax_percentage;
                document.getElementById('grandTotal').textContent = number_format(data.grand_total_converted);
                document.getElementById('grandTotalUSD').textContent = number_format(data.grand_total);
                document.getElementById('timeline').textContent = data.timeline_weeks;
                document.getElementById('teamSize').textContent = data.team_size;

                // Store for saving
                document.getElementById('saveTotalCost').value = data.total_cost;
                document.getElementById('saveTaxPercentage').value = data.tax_percentage;
                document.getElementById('saveTaxAmount').value = data.tax_amount;
                document.getElementById('saveGrandTotal').value = data.grand_total;
                document.getElementById('saveTimeline').value = data.timeline_weeks;
                document.getElementById('saveTeamSize').value = data.team_size;
                document.getElementById('saveAnswers').value = JSON.stringify(Object.fromEntries(formData));

                document.getElementById('resultCard').style.display = 'block';
                document.getElementById('saveEstimateBtn').style.display = 'block';
            }
        });
    }

    // Format number with 2 decimals
    function number_format(number) {
        return parseFloat(number).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    document.getElementById('calculateBtn').addEventListener('click', calculateCost);

    document.getElementById('saveEstimateBtn').addEventListener('click', function() {
        new bootstrap.Modal(document.getElementById('saveEstimateModal')).show();
    });

    document.getElementById('saveEstimateForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        formData.append('currency_code', document.getElementById('currencyCode').value);
        formData.append('answers', document.getElementById('saveAnswers').value);

        fetch('{{ route('cost-estimates.store') }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                window.location.href = data.redirect;
            }
        });
    });
</script>
@endsection
