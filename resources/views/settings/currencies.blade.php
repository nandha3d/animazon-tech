@extends('layouts.admin')

@section('page-title')
    {{ __('Currency Management') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item">{{ __('Settings') }}</li>
    <li class="breadcrumb-item">{{ __('Currency Management') }}</li>
@endsection

@section('action-button')
    <div class="all-button-box row d-flex justify-content-end">
        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
            <button type="button" class="btn btn-primary float-end" id="updateRatesBtn">
                <i class="ti ti-refresh"></i> {{ __('Update Exchange Rates') }}
            </button>
        </div>
    </div>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0">{{ __('Manage Currencies') }}</h5>
                    <p class="text-muted mb-0">{{ __('Auto-detected currency is used based on user location. Manage which currencies are available for users to select.') }}</p>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped hover">
                            <thead>
                                <tr>
                                    <th>{{ __('Code') }}</th>
                                    <th>{{ __('Name') }}</th>
                                    <th>{{ __('Symbol') }}</th>
                                    <th>{{ __('Exchange Rate') }} (vs USD)</th>
                                    <th>{{ __('Last Updated') }}</th>
                                    <th>{{ __('Default') }}</th>
                                    <th>{{ __('Active') }}</th>
                                    <th>{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($currencies as $currency)
                                    <tr>
                                        <td>
                                            <span class="badge bg-info">{{ $currency->code }}</span>
                                        </td>
                                        <td>{{ $currency->name }}</td>
                                        <td>
                                            <span class="h5 mb-0">{{ $currency->symbol }}</span>
                                        </td>
                                        <td>
                                            <code>{{ number_format($currency->exchange_rate, 6) }}</code>
                                        </td>
                                        <td>
                                            <small class="text-muted">
                                                {{ $currency->last_updated ? $currency->last_updated->format('M d, H:i') : 'N/A' }}
                                            </small>
                                        </td>
                                        <td>
                                            <input type="radio" name="default_currency" value="{{ $currency->id }}" 
                                                {{ $currency->is_default ? 'checked' : '' }}
                                                class="default-currency-radio"
                                                data-currency-id="{{ $currency->id }}">
                                        </td>
                                        <td>
                                            <div class="form-check form-switch">
                                                <input 
                                                    type="checkbox" 
                                                    class="form-check-input currency-toggle" 
                                                    data-currency-id="{{ $currency->id }}"
                                                    {{ $currency->active ? 'checked' : '' }}
                                                    style="width: 40px; height: 20px;">
                                            </div>
                                        </td>
                                        <td>
                                            <a href="javascript:void(0)" class="btn btn-sm btn-info" 
                                                onclick="editCurrency({{ $currency->id }})">
                                                <i class="ti ti-edit"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center text-muted py-4">
                                            {{ __('No currencies found') }}
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Card -->
    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <i class="ti ti-currency-dollar h2 text-primary mb-2"></i>
                    <h4>{{ $currencies->where('active', true)->count() }}</h4>
                    <p class="text-muted">{{ __('Active Currencies') }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <i class="ti ti-check-circle h2 text-success mb-2"></i>
                    <h4>{{ $defaultCurrency->code ?? 'USD' }}</h4>
                    <p class="text-muted">{{ __('Default Currency') }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <i class="ti ti-clock h2 text-warning mb-2"></i>
                    <h4>{{ $currencies->first()?->last_updated?->diffForHumans() ?? 'N/A' }}</h4>
                    <p class="text-muted">{{ __('Rates Updated') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Information Card -->
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light">
                    <h6 class="mb-0">{{ __('About Currency Management') }}</h6>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <strong>{{ __('Auto-Detection:') }}</strong> 
                            {{ __('User currency is automatically detected based on their IP location.') }}
                        </li>
                        <li class="mb-2">
                            <strong>{{ __('Manual Override:') }}</strong> 
                            {{ __('Users can manually select a different currency from the calculator.') }}
                        </li>
                        <li class="mb-2">
                            <strong>{{ __('Exchange Rates:') }}</strong> 
                            {{ __('Rates are fetched from Frankfurter API and cached for 1 hour.') }}
                        </li>
                        <li class="mb-2">
                            <strong>{{ __('Active Toggle:') }}</strong> 
                            {{ __('Only active currencies appear in user dropdown selectors.') }}
                        </li>
                        <li class="mb-2">
                            <strong>{{ __('Default Currency:') }}</strong> 
                            {{ __('Used as fallback when user currency cannot be detected.') }}
                        </li>
                        <li>
                            <strong>{{ __('Auto Update:') }}</strong> 
                            {{ __('Run "php artisan currency:update" daily via scheduler to keep rates fresh.') }}
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .table-hover tbody tr:hover {
        background-color: #f5f5f5;
    }
    
    .currency-toggle {
        cursor: pointer;
    }
    
    .default-currency-radio {
        cursor: pointer;
    }
</style>

<script>
    // Handle currency toggle
    document.querySelectorAll('.currency-toggle').forEach(toggle => {
        toggle.addEventListener('change', function() {
            const currencyId = this.dataset.currencyId;
            const isActive = this.checked;
            
            fetch(`/admin/currencies/${currencyId}/toggle`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ active: isActive })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Show success message
                    showAlert('Currency ' + (isActive ? 'activated' : 'deactivated'), 'success');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                this.checked = !isActive; // Revert toggle
                showAlert('Failed to update currency', 'danger');
            });
        });
    });

    // Handle default currency selection
    document.querySelectorAll('.default-currency-radio').forEach(radio => {
        radio.addEventListener('change', function() {
            if (this.checked) {
                const currencyId = this.dataset.currencyId;
                
                fetch(`/admin/currencies/${currencyId}/default`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showAlert('Default currency updated', 'success');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showAlert('Failed to update default currency', 'danger');
                });
            }
        });
    });

    // Handle update rates button
    document.getElementById('updateRatesBtn').addEventListener('click', function() {
        this.disabled = true;
        this.innerHTML = '<i class="ti ti-loader animate-spin"></i> {{ __("Updating...") }}';
        
        fetch('{{ route("currencies.update-rates") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showAlert(data.message, 'success');
                // Reload page to show updated rates
                setTimeout(() => location.reload(), 1500);
            } else {
                showAlert(data.message || 'Failed to update rates', 'danger');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('Failed to update exchange rates', 'danger');
        })
        .finally(() => {
            this.disabled = false;
            this.innerHTML = '<i class="ti ti-refresh"></i> {{ __("Update Exchange Rates") }}';
        });
    });

    function editCurrency(currencyId) {
        alert('Edit functionality coming soon');
    }

    function showAlert(message, type = 'info') {
        // Create alert element
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
        alertDiv.setAttribute('role', 'alert');
        alertDiv.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        `;
        
        // Insert at top of container
        const container = document.querySelector('.container-fluid');
        container.insertBefore(alertDiv, container.firstChild);
        
        // Auto-remove after 5 seconds
        setTimeout(() => {
            alertDiv.remove();
        }, 5000);
    }
</script>

@endsection
