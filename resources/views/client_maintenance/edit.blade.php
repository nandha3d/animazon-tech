@extends('layouts.admin')
@section('page-title')
    {{ __('Edit Maintenance Plan') }}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('clients.index') }}">{{ __('Client') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('clients.show', $client->id) }}">{{ $client->name }}</a></li>
    <li class="breadcrumb-item">{{ __('Edit') }}</li>
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    {!! Form::model($plan, ['route' => ['client-maintenance.update', $plan->id], 'method' => 'PUT']) !!}
                    @include('client_maintenance._form', ['plan' => $plan])
                    <div class="text-end">
                        <a href="{{ route('client-maintenance.index', $client->id) }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
                        {{ Form::submit(__('Update'), ['class' => 'btn btn-primary']) }}
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
