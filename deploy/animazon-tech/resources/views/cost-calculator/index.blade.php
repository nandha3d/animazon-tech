@extends('layouts.admin')

@section('page-title')
    {{ __('Project Cost Calculator') }}
@endsection

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center py-5">
                    <h2 class="mb-2">{{ __('Project Cost Estimation') }}</h2>
                    <p class="text-muted">{{ __('Select your project type to get a detailed cost estimate') }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        @forelse($projectTypes as $type)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100 border-0 shadow-sm hover-shadow transition-all cursor-pointer" 
                     onclick="location.href='{{ route('cost-calculator.show', $type->id) }}'"
                     style="cursor: pointer;">
                    <div class="card-body text-center">
                        @if($type->icon)
                            <div class="mb-3">
                                <i class="{{ $type->icon }} fa-3x text-primary"></i>
                            </div>
                        @endif
                        <h5 class="card-title mb-2">{{ $type->name }}</h5>
                        <p class="text-muted small">{{ $type->description }}</p>
                        @if($type->base_cost)
                            <p class="text-success font-weight-bold">
                                {{ __('Starting from') }}: 
                                {{ currency_symbol() }}{{ number_format($type->base_cost, 2) }}
                            </p>
                        @endif
                    </div>
                    <div class="card-footer bg-light border-0 text-center">
                        <small class="text-muted">{{ __('Click to start') }} →</small>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-md-12">
                <div class="alert alert-info">
                    {{ __('No project types available') }}
                </div>
            </div>
        @endforelse
    </div>
</div>

<style>
    .hover-shadow:hover {
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
        transform: translateY(-2px);
    }
    
    .transition-all {
        transition: all 0.3s ease;
    }
</style>
@endsection
