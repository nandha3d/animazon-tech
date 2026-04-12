@extends('layouts.admin')

@section('page-title')
    {{ __('Estimate Details') }}
@endsection

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ __('Estimate') }} #{{ $estimate->id }}</h5>
                    <span class="badge bg-{{ $estimate->status === 'accepted' ? 'success' : ($estimate->status === 'rejected' ? 'danger' : 'warning') }}">
                        {{ ucfirst($estimate->status) }}
                    </span>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-muted">{{ __('Project Name') }}</h6>
                            <h5>{{ $estimate->project_name }}</h5>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">{{ __('Project Type') }}</h6>
                            <h5>{{ $estimate->projectType->name }}</h5>
                        </div>
                    </div>

                    @if($estimate->client)
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h6 class="text-muted">{{ __('Client') }}</h6>
                                <h5>{{ $estimate->client->name ?? 'N/A' }}</h5>
                            </div>
                            <div class="col-md-6">
                                <h6 class="text-muted">{{ __('Email') }}</h6>
                                <p>{{ $estimate->client->email ?? 'N/A' }}</p>
                            </div>
                        </div>
                    @endif

                    <hr>

                    <h6 class="font-weight-bold mb-3">{{ __('Selected Options') }}</h6>
                    <div class="table-responsive">
                        <table class="table table-sm table-borderless">
                            <tbody>
                                @foreach($estimate->answers as $answer)
                                    <tr>
                                        <td class="text-muted">{{ $answer->question->question }}</td>
                                        <td>
                                            @if($answer->answer)
                                                {{ $answer->answer->answer_text }}
                                            @else
                                                {{ $answer->answer_value }}
                                            @endif
                                        </td>
                                        <td class="text-right">
                                            {{ currency_symbol() }}{{ number_format($answer->cost_contribution, 2) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @if($estimate->notes)
                        <div class="alert alert-info mt-3">
                            <h6 class="alert-heading">{{ __('Notes') }}</h6>
                            {{ $estimate->notes }}
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">{{ __('Cost Summary') }}</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <p class="text-muted mb-1">{{ __('Base Cost') }}:</p>
                        <h6>{{ currency_symbol() }}{{ number_format($estimate->base_cost, 2) }}</h6>
                    </div>

                    <div class="mb-3">
                        <p class="text-muted mb-1">{{ __('Total Cost') }}:</p>
                        <h5 class="text-primary">{{ currency_symbol() }}{{ number_format($estimate->total_cost, 2) }}</h5>
                    </div>

                    <hr>

                    <div class="mb-3">
                        <p class="text-muted mb-1">{{ __('Tax') }} ({{ $estimate->tax_percentage }}%):</p>
                        <h6>{{ currency_symbol() }}{{ number_format($estimate->tax_amount, 2) }}</h6>
                    </div>

                    <div class="bg-light p-3 rounded mb-3">
                        <p class="text-muted mb-1">{{ __('Grand Total') }}:</p>
                        <h4 class="text-success mb-0">{{ currency_symbol() }}{{ number_format($estimate->grand_total, 2) }}</h4>
                    </div>

                    @if($estimate->timeline_weeks)
                        <div class="mb-3">
                            <p class="text-muted mb-1">{{ __('Estimated Timeline') }}:</p>
                            <h6>{{ $estimate->timeline_weeks }} {{ __('weeks') }}</h6>
                        </div>
                    @endif

                    @if($estimate->team_size)
                        <div class="mb-3">
                            <p class="text-muted mb-1">{{ __('Estimated Team Size') }}:</p>
                            <h6>{{ $estimate->team_size }} {{ __('members') }}</h6>
                        </div>
                    @endif

                    <hr>

                    <div class="mb-3 text-muted small">
                        <p>{{ __('Created') }}: {{ $estimate->created_at->format('M d, Y H:i') }}</p>
                        @if($estimate->sent_at)
                            <p>{{ __('Sent') }}: {{ $estimate->sent_at->format('M d, Y H:i') }}</p>
                        @endif
                    </div>

                    @if($estimate->status === 'draft')
                        <div class="d-grid gap-2">
                            <button type="button" class="btn btn-warning" id="sendEstimateBtn">
                                <i class="ti ti-send"></i> {{ __('Send to Client') }}
                            </button>
                            <a href="#" class="btn btn-secondary">{{ __('Edit') }}</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('sendEstimateBtn')?.addEventListener('click', function() {
        if(confirm('{{ __('Send this estimate to the client?') }}')) {
            fetch('{{ route('cost-estimates.send', $estimate->id) }}', {
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
</script>
@endsection
