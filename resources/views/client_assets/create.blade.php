@extends('layouts.admin')
@section('page-title')
    {{ __('Add Website / Asset') }}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('clients.index') }}">{{ __('Client') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('client-assets.index', $client->id) }}">{{ $client->name }}</a></li>
    <li class="breadcrumb-item">{{ __('Add') }}</li>
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    {!! Form::open(['route' => ['client-assets.store', $client->id], 'method' => 'POST']) !!}
                    @include('client_assets._form', ['asset' => null])
                    <div class="text-end">
                        <a href="{{ route('client-assets.index', $client->id) }}"
                            class="btn btn-secondary">{{ __('Cancel') }}</a>
                        {{ Form::submit(__('Save'), ['class' => 'btn btn-primary']) }}
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
