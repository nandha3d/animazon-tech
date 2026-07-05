@extends('layouts.admin')
@section('page-title')
    {{ __('Websites & Credentials') }}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('clients.index') }}">{{ __('Client') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('clients.show', $client->id) }}">{{ $client->name }}</a></li>
    <li class="breadcrumb-item">{{ __('Websites & Credentials') }}</li>
@endsection
@section('action-btn')
    <div class="float-end">
        @can('create client asset')
            <a href="{{ route('client-assets.create', $client->id) }}" class="btn btn-sm btn-primary"
                data-bs-toggle="tooltip" title="{{ __('Add Website / Asset') }}">
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
                    <h5>{{ __('Managed Websites for') }} {{ $client->name }}</h5>
                </div>
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>{{ __('Label') }}</th>
                                    <th>{{ __('Website') }}</th>
                                    <th>{{ __('Admin Login') }}</th>
                                    <th>{{ __('SSL / Renewals') }}</th>
                                    <th class="text-end">{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($assets as $asset)
                                    <tr>
                                        <td>{{ $asset->label }}</td>
                                        <td>
                                            @if ($asset->website_url)
                                                <a href="{{ $asset->website_url }}" target="_blank" rel="noopener"
                                                    class="btn btn-sm btn-outline-primary">
                                                    <i class="ti ti-external-link"></i> {{ __('Open') }}
                                                </a>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($asset->admin_username)
                                                <div class="d-flex align-items-center gap-1">
                                                    <code>{{ $asset->admin_username }}</code>
                                                    <button type="button" class="btn btn-xs btn-light copy-text"
                                                        data-copy="{{ $asset->admin_username }}"
                                                        title="{{ __('Copy username') }}"><i class="ti ti-copy"></i></button>
                                                    @can('show client asset')
                                                        <button type="button" class="btn btn-xs btn-light reveal-secret"
                                                            data-url="{{ route('client-assets.reveal', [$asset->id, 'admin_password']) }}"
                                                            title="{{ __('Copy password') }}"><i class="ti ti-key"></i></button>
                                                    @endcan
                                                    @if ($asset->admin_url)
                                                        <a href="{{ $asset->admin_url }}" target="_blank" rel="noopener"
                                                            class="btn btn-xs btn-primary" title="{{ __('Open Admin') }}">
                                                            <i class="ti ti-login"></i></a>
                                                    @endif
                                                </div>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($asset->ssl_expiry)
                                                <small>{{ __('SSL') }}: {{ $asset->ssl_expiry->format('Y-m-d') }}</small><br>
                                            @endif
                                            @if ($asset->hosting_renewal)
                                                <small>{{ __('Host') }}: {{ $asset->hosting_renewal->format('Y-m-d') }}
                                                    @if ($asset->hosting_amount)
                                                        ({{ \Auth::user()->priceFormat($asset->hosting_amount) }})
                                                    @endif
                                                </small><br>
                                            @endif
                                            @if ($asset->domain_renewal)
                                                <small>{{ __('Domain') }}: {{ $asset->domain_renewal->format('Y-m-d') }}</small>
                                            @endif
                                        </td>
                                        <td class="text-end">
                                            @can('edit client asset')
                                                <a href="{{ route('client-assets.edit', $asset->id) }}"
                                                    class="btn btn-sm btn-info"><i class="ti ti-pencil text-white"></i></a>
                                            @endcan
                                            @can('delete client asset')
                                                {!! Form::open(['method' => 'DELETE', 'route' => ['client-assets.destroy', $asset->id], 'id' => 'del-asset-' . $asset->id, 'class' => 'd-inline']) !!}
                                                <a href="#" class="btn btn-sm btn-danger bs-pass-para"><i
                                                        class="ti ti-trash text-white"></i></a>
                                                {!! Form::close() !!}
                                            @endcan
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">{{ __('No websites added yet.') }}</td>
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
@push('script-page')
    <script>
        function assetCopy(text) {
            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(text);
            } else {
                var t = document.createElement('textarea');
                t.value = text;
                t.style.position = 'fixed';
                document.body.appendChild(t);
                t.focus();
                t.select();
                document.execCommand('copy');
                document.body.removeChild(t);
            }
            if (typeof show_toastr === 'function') show_toastr('{{ __('Copied') }}', '{{ __('Copied to clipboard') }}', 'success');
        }
        $(document).on('click', '.copy-text', function() {
            assetCopy($(this).data('copy'));
        });
        $(document).on('click', '.reveal-secret', function() {
            $.get($(this).data('url'), function(res) {
                if (res && typeof res.value !== 'undefined') {
                    assetCopy(res.value);
                }
            }).fail(function() {
                if (typeof show_toastr === 'function') show_toastr('{{ __('Error') }}', '{{ __('Unable to fetch secret') }}', 'error');
            });
        });
    </script>
@endpush
