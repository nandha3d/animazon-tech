@extends('layouts.admin')
@section('page-title')
    {{ __('Maintenance Plans') }}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('clients.index') }}">{{ __('Client') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('clients.show', $client->id) }}">{{ $client->name }}</a></li>
    <li class="breadcrumb-item">{{ __('Maintenance') }}</li>
@endsection
@section('action-btn')
    <div class="float-end">
        @can('create client maintenance')
            <a href="{{ route('client-maintenance.create', $client->id) }}" class="btn btn-sm btn-primary" title="{{ __('Add Maintenance Plan') }}">
                <i class="ti ti-plus"></i>
            </a>
        @endcan
    </div>
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5>{{ __('Maintenance Plans for') }} {{ $client->name }}</h5>
                </div>
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>{{ __('Service') }}</th>
                                    <th>{{ __('Amount') }}</th>
                                    <th>{{ __('Cycle') }}</th>
                                    <th>{{ __('Next Due') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th class="text-end">{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($plans as $plan)
                                    <tr>
                                        <td>
                                            <strong>{{ $plan->service_type }}</strong>
                                            @if ($plan->title)
                                                <br><small class="text-muted">{{ $plan->title }}</small>
                                            @endif
                                        </td>
                                        <td>{{ \Auth::user()->priceFormat($plan->amount) }}</td>
                                        <td>{{ $plan->cycleLabel() }}</td>
                                        <td>
                                            @if ($plan->next_due_date)
                                                {{ $plan->next_due_date->format('Y-m-d') }}
                                                @if ($plan->isOverdue())
                                                    <span class="badge bg-danger p-1 px-2 rounded">{{ __('Overdue') }}</span>
                                                @endif
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($plan->status == 'active')
                                                <span class="badge bg-success p-2 px-3 rounded">{{ __('Active') }}</span>
                                            @elseif ($plan->status == 'paused')
                                                <span class="badge bg-warning p-2 px-3 rounded">{{ __('Paused') }}</span>
                                            @else
                                                <span class="badge bg-secondary p-2 px-3 rounded">{{ __('Cancelled') }}</span>
                                            @endif
                                        </td>
                                        <td class="text-end">
                                            @can('edit client maintenance')
                                                @if ($plan->status == 'active')
                                                    {!! Form::open(['method' => 'POST', 'route' => ['client-maintenance.renew', $plan->id], 'class' => 'd-inline']) !!}
                                                    <button type="submit" class="btn btn-sm btn-success"
                                                        onclick="return confirm('{{ __('Generate invoice for this cycle and advance the due date?') }}')"
                                                        title="{{ __('Renew / Bill this cycle') }}">
                                                        <i class="ti ti-refresh"></i>
                                                    </button>
                                                    {!! Form::close() !!}
                                                @endif
                                                <a href="{{ route('client-maintenance.edit', $plan->id) }}" class="btn btn-sm btn-info">
                                                    <i class="ti ti-pencil text-white"></i>
                                                </a>
                                            @endcan
                                            @can('delete client maintenance')
                                                {!! Form::open(['method' => 'DELETE', 'route' => ['client-maintenance.destroy', $plan->id], 'id' => 'del-plan-' . $plan->id, 'class' => 'd-inline']) !!}
                                                <a href="#" class="btn btn-sm btn-danger bs-pass-para"><i class="ti ti-trash text-white"></i></a>
                                                {!! Form::close() !!}
                                            @endcan
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted">{{ __('No maintenance plans yet.') }}</td>
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
