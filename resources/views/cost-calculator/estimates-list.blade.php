@extends('layouts.admin')

@section('page-title')
    {{ __('Cost Estimates') }}
@endsection

@section('action-button')
    <div class="all-button-box row d-flex justify-content-end">
        <div class="col-xl-2 col-lg-2 col-md-4 col-sm-6 col-6 pe-2">
            @can('manage-settings')
                <a href="{{ route('currencies.manage') }}" class="btn btn-xs btn-info btn-icon-only width-auto" title="{{ __('Manage Currencies') }}">
                    <i class="ti ti-currency-dollar"></i> {{ __('Currencies') }}
                </a>
            @endcan
        </div>
        <div class="col-xl-2 col-lg-2 col-md-4 col-sm-6 col-6">
            <a href="{{ route('cost-calculator.show') }}" class="btn btn-xs btn-white btn-icon-only width-auto">
                <i class="ti ti-plus"></i> {{ __('New Estimate') }}
            </a>
        </div>
    </div>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0">{{ __('All Estimates') }}</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped dataTable">
                            <thead>
                                <tr>
                                    <th>{{ __('ID') }}</th>
                                    <th>{{ __('Project Name') }}</th>
                                    <th>{{ __('Type') }}</th>
                                    <th>{{ __('Client') }}</th>
                                    <th>{{ __('Grand Total') }}</th>
                                    <th>{{ __('Currency') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Created') }}</th>
                                    <th>{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($estimates as $estimate)
                                    <tr>
                                        <td>#{{ $estimate->id }}</td>
                                        <td>{{ $estimate->project_name }}</td>
                                        <td>
                                            <span class="badge bg-primary">{{ $estimate->projectType->name }}</span>
                                        </td>
                                        <td>
                                            @if($estimate->client)
                                                {{ $estimate->client->name }}
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            @php
                                                $currency = \App\Models\Currency::where('code', $estimate->currency_code ?? 'USD')->first();
                                            @endphp
                                            {{ $currency ? $currency->symbol : '$' }}{{ number_format($estimate->grand_total, 2) }}
                                        </td>
                                        <td>
                                            <span class="badge bg-secondary">{{ $estimate->currency_code ?? 'USD' }}</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $estimate->status === 'accepted' ? 'success' : ($estimate->status === 'rejected' ? 'danger' : ($estimate->status === 'sent' ? 'info' : 'warning')) }}">
                                                {{ ucfirst($estimate->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <small>{{ $estimate->created_at->format('M d, Y') }}</small>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('cost-estimates.show', $estimate->id) }}" class="btn btn-sm btn-primary" title="{{ __('View') }}">
                                                    <i class="ti ti-eye"></i>
                                                </a>
                                                @if($estimate->status === 'draft')
                                                    <button type="button" class="btn btn-sm btn-warning send-estimate" data-id="{{ $estimate->id }}" title="{{ __('Send') }}">
                                                        <i class="ti ti-send"></i>
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center text-muted py-4">
                                            {{ __('No estimates found. ') }}
                                            <a href="{{ route('cost-calculator.show') }}">{{ __('Create one now') }}</a>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            @if(method_exists($estimates, 'links'))
                <div class="mt-3">
                    {{ $estimates->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

<script>
    document.querySelectorAll('.send-estimate').forEach(btn => {
        btn.addEventListener('click', function() {
            const estimateId = this.dataset.id;
            if(confirm('{{ __('Send this estimate to the client?') }}')) {
                fetch(`/cost-estimates/${estimateId}/send`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    alert(data.message);
                    location.reload();
                });
            }
        });
    });
</script>
@endsection
