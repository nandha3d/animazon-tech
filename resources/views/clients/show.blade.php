@extends('layouts.admin')
@php
    $profile=\App\Models\Utility::get_file('uploads/avatar/');
@endphp
@section('page-title')
    {{__('Manage Client')}}
@endsection
@push('script-page')
@endpush
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item"><a href="{{route('clients.index')}}">{{__('Client')}}</a></li>
    <li class="breadcrumb-item">  {{ ucwords($client->name).__("'s Detail") }}</li>
@endsection
@section('action-btn')

@endsection

@section('content')

    {{-- Customer link status --}}
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body d-flex flex-wrap align-items-center justify-content-between gap-3">
                    <div>
                        <h5 class="mb-1">{{ $client->name }}</h5>
                        <small class="text-muted">{{ $client->email }}</small>
                    </div>
                    <div>
                        @if ($customer)
                            <span class="badge bg-success p-2 px-3 rounded">
                                <i class="ti ti-link"></i> {{ __('Linked as Customer') }}: {{ $customer->name }}
                            </span>
                        @else
                            @can('create customer')
                                {!! Form::open(['method' => 'POST', 'route' => ['clients.convert.customer', $client->id]]) !!}
                                <button type="submit" class="btn btn-sm btn-primary">
                                    <i class="ti ti-users"></i> {{ __('Make Customer') }}
                                </button>
                                {!! Form::close() !!}
                            @endcan
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Summary tiles --}}
    <div class="row">
        <div class="col-sm-3">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-auto mb-3 mb-sm-0">
                            <small class="text-muted">{{__('Estimates')}}</small>
                            <h3 class="m-0">{{ $costEstimates->count() }}</h3>
                        </div>
                        <div class="col-auto">
                            <div class="theme-avtar bg-info">
                                <i class="ti ti-coin"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-auto mb-3 mb-sm-0">
                            <small class="text-muted">{{__('Projects')}}</small>
                            <h3 class="m-0">{{ $clientProjects->count() }}</h3>
                        </div>
                        <div class="col-auto">
                            <div class="theme-avtar bg-primary">
                                <i class="ti ti-briefcase"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-auto mb-3 mb-sm-0">
                            <small class="text-muted">{{__('Invoices')}}</small>
                            <h3 class="m-0">{{ $clientInvoices->count() }}</h3>
                        </div>
                        <div class="col-auto">
                            <div class="theme-avtar bg-warning">
                                <i class="ti ti-file-invoice"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-auto mb-3 mb-sm-0">
                            <small class="text-muted">{{__('Contracts')}}</small>
                            <h3 class="m-0">{{ $cnt_contract['cnt_total'] }}</h3>
                        </div>
                        <div class="col-auto">
                            <div class="theme-avtar bg-danger">
                                <i class="ti ti-file-text"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        {{-- Estimates --}}
        <div class="col-md-6 mb-4">
            <div class="card mb-0 h-100">
                <div class="card-header">
                    <h5>{{ __('Cost Estimates') }} ({{ $costEstimates->count() }})</h5>
                </div>
                <div class="card-body activity-scroll">
                    @if ($costEstimates->count() > 0)
                        <ul class="list-group list-group-flush">
                            @foreach ($costEstimates as $est)
                                <li class="list-group-item px-0">
                                    <div class="row align-items-center justify-content-between">
                                        <div class="col-sm-auto mb-2 mb-sm-0">
                                            <h6 class="m-0">{{ $est->project_name }}</h6>
                                            <small class="text-muted">{{ $est->currency_code }} {{ number_format($est->grand_total, 2) }}</small>
                                        </div>
                                        <div class="col-sm-auto d-flex align-items-center gap-2">
                                            <span class="badge bg-secondary p-2 px-3 rounded">{{ ucfirst($est->status) }}</span>
                                            <a href="{{ route('cost-estimate.view', $est->id) }}" target="_blank" class="btn btn-sm bg-warning">
                                                <i class="ti ti-eye text-white"></i>
                                            </a>
                                            @can('create invoice')
                                                @if (!$est->invoice_id)
                                                    <a href="{{ route('invoice.from.cost.estimate', $est->id) }}"
                                                        onclick="return confirm('{{ __('Generate an invoice from this estimate?') }}')"
                                                        class="btn btn-sm btn-primary" title="{{ __('Generate Invoice') }}">
                                                        <i class="ti ti-file-plus"></i>
                                                    </a>
                                                @endif
                                            @endcan
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="py-5">
                            <h6 class="h6 text-center">{{ __('No Estimate Found.') }}</h6>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Projects --}}
        <div class="col-md-6 mb-4">
            <div class="card mb-0 h-100">
                <div class="card-header">
                    <h5>{{ __('Projects') }} ({{ $clientProjects->count() }})</h5>
                </div>
                <div class="card-body activity-scroll">
                    @if ($clientProjects->count() > 0)
                        <ul class="list-group list-group-flush">
                            @foreach ($clientProjects as $project)
                                <li class="list-group-item px-0">
                                    <div class="row align-items-center justify-content-between">
                                        <div class="col-sm-auto mb-2 mb-sm-0">
                                            <h6 class="m-0">{{ $project->project_name }}</h6>
                                            <small class="text-muted">{{ __('Budget') }}: {{ \Auth::user()->priceFormat($project->budget) }}</small>
                                        </div>
                                        <div class="col-sm-auto">
                                            <span class="badge bg-{{ \App\Models\Project::$status_color[$project->status] ?? 'secondary' }} p-2 px-3 rounded">
                                                {{ __(\App\Models\Project::$project_status[$project->status] ?? $project->status) }}
                                            </span>
                                            @can('view project')
                                                <a href="{{ route('projects.show', $project->id) }}" class="btn btn-sm bg-warning">
                                                    <i class="ti ti-eye text-white"></i>
                                                </a>
                                            @endcan
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="py-5">
                            <h6 class="h6 text-center">{{ __('No Project Found.') }}</h6>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Invoices --}}
        <div class="col-md-6 mb-4">
            <div class="card mb-0 h-100">
                <div class="card-header">
                    <h5>{{ __('Invoices') }} ({{ $clientInvoices->count() }})</h5>
                </div>
                <div class="card-body activity-scroll">
                    @if ($clientInvoices->count() > 0)
                        <ul class="list-group list-group-flush">
                            @foreach ($clientInvoices as $inv)
                                <li class="list-group-item px-0">
                                    <div class="row align-items-center justify-content-between">
                                        <div class="col-sm-auto mb-2 mb-sm-0">
                                            <h6 class="m-0">{{ \Auth::user()->invoiceNumberFormat($inv->invoice_id) }}</h6>
                                            <small class="text-muted">{{ \Auth::user()->priceFormat($inv->getTotal()) }}</small>
                                        </div>
                                        <div class="col-sm-auto d-flex align-items-center gap-2">
                                            <span class="badge bg-{{ ['secondary','warning','danger','info','primary'][$inv->status] ?? 'secondary' }} p-2 px-3 rounded">
                                                {{ __(\App\Models\Invoice::$statues[$inv->status]) }}
                                            </span>
                                            @can('show invoice')
                                                <a href="{{ route('invoice.show', \Crypt::encrypt($inv->id)) }}" class="btn btn-sm bg-warning">
                                                    <i class="ti ti-eye text-white"></i>
                                                </a>
                                            @endcan
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="py-5">
                            <h6 class="h6 text-center">{{ __('No Invoice Found.') }}</h6>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Website / Credential Vault --}}
        <div class="col-md-6 mb-4">
            <div class="card mb-0 h-100">
                <div class="card-header">
                    <div class="d-flex align-items-center justify-content-between">
                        <h5>{{ __('Websites & Credentials') }} ({{ $assets->count() }})</h5>
                        @can('create client asset')
                            <a href="{{ route('client-assets.create', $client->id) }}" class="btn btn-sm btn-primary" title="{{ __('Add Website') }}">
                                <i class="ti ti-plus"></i>
                            </a>
                        @endcan
                    </div>
                </div>
                <div class="card-body activity-scroll">
                    @if ($assets->count() > 0)
                        <ul class="list-group list-group-flush">
                            @foreach ($assets as $asset)
                                <li class="list-group-item px-0">
                                    <div class="row align-items-center justify-content-between">
                                        <div class="col-sm-auto mb-2 mb-sm-0">
                                            <h6 class="m-0">{{ $asset->label }}</h6>
                                            <small class="text-muted">{{ $asset->website_url }}</small>
                                        </div>
                                        <div class="col-sm-auto">
                                            @if ($asset->admin_url)
                                                <a href="{{ $asset->admin_url }}" target="_blank" rel="noopener" class="btn btn-sm btn-primary">
                                                    <i class="ti ti-login"></i>
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                        @can('manage client asset')
                            <div class="text-end mt-2">
                                <a href="{{ route('client-assets.index', $client->id) }}" class="btn btn-sm btn-outline-primary">
                                    {{ __('Manage All') }}
                                </a>
                            </div>
                        @endcan
                    @else
                        <div class="py-5">
                            <h6 class="h6 text-center">{{ __('No Website Added Yet.') }}</h6>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Maintenance Plans (recurring retainer billing — website, software, 3D animation, etc) --}}
        <div class="col-md-6 mb-4">
            <div class="card mb-0 h-100">
                <div class="card-header">
                    <div class="d-flex align-items-center justify-content-between">
                        <h5>{{ __('Maintenance Plans') }} ({{ $maintenancePlans->count() }})</h5>
                        @can('create client maintenance')
                            <a href="{{ route('client-maintenance.create', $client->id) }}" class="btn btn-sm btn-primary" title="{{ __('Add Maintenance Plan') }}">
                                <i class="ti ti-plus"></i>
                            </a>
                        @endcan
                    </div>
                </div>
                <div class="card-body activity-scroll">
                    @if ($maintenancePlans->count() > 0)
                        <ul class="list-group list-group-flush">
                            @foreach ($maintenancePlans as $plan)
                                <li class="list-group-item px-0">
                                    <div class="row align-items-center justify-content-between">
                                        <div class="col-sm-auto mb-2 mb-sm-0">
                                            <h6 class="m-0">{{ $plan->service_type }}</h6>
                                            <small class="text-muted">
                                                {{ \Auth::user()->priceFormat($plan->amount) }} / {{ $plan->cycleLabel() }}
                                                @if ($plan->next_due_date)
                                                    — {{ __('due') }} {{ $plan->next_due_date->format('Y-m-d') }}
                                                @endif
                                            </small>
                                        </div>
                                        <div class="col-sm-auto d-flex align-items-center gap-2">
                                            @if ($plan->status == 'active' && $plan->isOverdue())
                                                <span class="badge bg-danger p-2 px-3 rounded">{{ __('Overdue') }}</span>
                                            @elseif ($plan->status == 'active')
                                                <span class="badge bg-success p-2 px-3 rounded">{{ __('Active') }}</span>
                                            @else
                                                <span class="badge bg-secondary p-2 px-3 rounded">{{ ucfirst($plan->status) }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                        @can('manage client maintenance')
                            <div class="text-end mt-2">
                                <a href="{{ route('client-maintenance.index', $client->id) }}" class="btn btn-sm btn-outline-primary">
                                    {{ __('Manage All') }}
                                </a>
                            </div>
                        @endcan
                    @else
                        <div class="py-5">
                            <h6 class="h6 text-center">{{ __('No Maintenance Plan Added Yet.') }}</h6>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Contracts --}}
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h5>{{ __('Contracts') }} ({{ $contracts->count() }})</h5>
                </div>
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table datatable">
                            <thead>
                            <tr>
                                <th>{{__('Subject')}}</th>
                                <th>{{__('Type')}}</th>
                                <th>{{__('Value')}}</th>
                                <th>{{__('Start Date')}}</th>
                                <th>{{__('End Date')}}</th>
                                <th>{{__('Status')}}</th>
                                @can('view contract')
                                    <th width="100px">{{__('Action')}}</th>
                                @endcan
                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($contracts as $contract)
                                <tr>
                                    <td>{{ $contract->subject }}</td>
                                    <td>{{ $contract->type }}</td>
                                    <td>{{ \Auth::user()->priceFormat($contract->value) }}</td>
                                    <td>{{ \Auth::user()->dateFormat($contract->start_date) }}</td>
                                    <td>{{ \Auth::user()->dateFormat($contract->end_date) }}</td>
                                    <td>{{ ucfirst($contract->status) }}</td>
                                    @can('view contract')
                                        <td>
                                            <a href="{{ route('contract.show', $contract->id) }}" class="btn btn-sm bg-warning">
                                                <i class="ti ti-eye text-white"></i>
                                            </a>
                                        </td>
                                    @endcan
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted">{{ __('No Contract Found.') }}</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
