@extends('layouts.admin')

@section('page-title')
    {{ __('Amazon Affiliate Portal') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item">{{ __('Affiliate Portal') }}</li>
@endsection

@section('action-btn')
    <div class="float-end">
        <a href="#" data-size="md" data-url="{{ route('affiliate-links.create') }}" data-ajax-popup="true" data-bs-toggle="tooltip" title="{{ __('Create Shortlink') }}" data-title="{{ __('Create Amazon Affiliate Shortlink') }}" class="btn btn-sm btn-primary">
            <i class="ti ti-plus"></i> {{ __('Create New Link') }}
        </a>
    </div>
@endsection

@section('content')
    <!-- Dashboard Analytics Cards -->
    <div class="row mb-4">
        <div class="col-lg-3 col-6">
            <div class="card bg-primary text-white mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 text-uppercase mb-1" style="font-size: 0.75rem;">{{ __('Total Clicks') }}</h6>
                            <h3 class="mb-0 text-white font-weight-bold">{{ number_format($totalClicks) }}</h3>
                        </div>
                        <i class="ti ti-click fs-1 text-white-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="card bg-success text-white mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 text-uppercase mb-1" style="font-size: 0.75rem;">{{ __('Android App Launches') }}</h6>
                            <h3 class="mb-0 text-white font-weight-bold">{{ number_format($androidClicks) }}</h3>
                        </div>
                        <i class="ti ti-brand-android fs-1 text-white-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="card bg-info text-white mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 text-uppercase mb-1" style="font-size: 0.75rem;">{{ __('iOS App Launches') }}</h6>
                            <h3 class="mb-0 text-white font-weight-bold">{{ number_format($iosClicks) }}</h3>
                        </div>
                        <i class="ti ti-brand-apple fs-1 text-white-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="card bg-warning text-dark mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-dark-50 text-uppercase mb-1" style="font-size: 0.75rem;">{{ __('Desktop Visitors') }}</h6>
                            <h3 class="mb-0 text-dark font-weight-bold">{{ number_format($desktopClicks) }}</h3>
                        </div>
                        <i class="ti ti-device-laptop fs-1 text-dark-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Link Converter Widget -->
    <div class="row mb-4">
        <div class="col-xl-12">
            <div class="card border-primary">
                <div class="card-header bg-light-primary border-0">
                    <h5 class="mb-0 text-primary"><i class="ti ti-link"></i> {{ __('Instant Amazon Link Converter') }}</h5>
                    <small class="text-muted">{{ __('Paste any raw Amazon product URL below. It automatically extracts the ASIN and generates an instant animazon.in/{ASIN} deeplink with your store ID attached.') }}</small>
                </div>
                <div class="card-body">
                    {{ Form::open(['route' => 'affiliate-links.store', 'method' => 'POST', 'class' => 'row g-3']) }}
                    <div class="col-md-7">
                        <input type="text" name="raw_url" class="form-control" placeholder="Paste Amazon URL e.g. https://www.amazon.in/dp/B08N5WRWNW..." required>
                    </div>
                    <div class="col-md-3">
                        <select name="affiliate_tag" class="form-select">
                            @foreach($storeIds as $s)
                                <option value="{{ $s->store_id }}" {{ $s->is_default ? 'selected' : '' }}>
                                    {{ $s->store_id }} ({{ $s->channel_name }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 d-grid">
                        <button type="submit" class="btn btn-primary"><i class="ti ti-bolt"></i> {{ __('Convert Link') }}</button>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Main Navigation Tabs -->
    <div class="row">
        <div class="col-xl-12">
            <ul class="nav nav-tabs mb-3" id="affiliateTabs" role="tablist">
                <li class="nav-item">
                    <button class="nav-link active" id="links-tab" data-bs-toggle="tab" data-bs-target="#links" type="button"><i class="ti ti-list"></i> {{ __('All Shortlinks') }}</button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" id="storeids-tab" data-bs-toggle="tab" data-bs-target="#storeids" type="button"><i class="ti ti-tag"></i> {{ __('Store IDs & Channels') }}</button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" id="analytics-tab" data-bs-toggle="tab" data-bs-target="#analytics" type="button"><i class="ti ti-chart-bar"></i> {{ __('Click Logs & Devices') }}</button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" id="api-tab" data-bs-toggle="tab" data-bs-target="#api" type="button"><i class="ti ti-code"></i> {{ __('REST API Integration') }}</button>
                </li>
            </ul>

            <div class="tab-content" id="affiliateTabsContent">
                <!-- TAB 1: ALL SHORTLINKS -->
                <div class="tab-pane fade show active" id="links" role="tabpanel">
                    <div class="card">
                        <div class="card-body table-border-style">
                            <div class="table-responsive">
                                <table class="table datatable">
                                    <thead>
                                        <tr>
                                            <th>{{ __('Product Title') }}</th>
                                            <th>{{ __('Code / ASIN') }}</th>
                                            <th>{{ __('Shortlink (Direct Root Level)') }}</th>
                                            <th>{{ __('Store Tag') }}</th>
                                            <th>{{ __('Clicks (App / Web)') }}</th>
                                            <th>{{ __('Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($links as $link)
                                            @php
                                                $fullShortUrl = url('/' . $link->code);
                                            @endphp
                                            <tr>
                                                <td class="font-weight-bold">{{ $link->title }}</td>
                                                <td><code>{{ $link->code }}</code></td>
                                                <td>
                                                    <div class="input-group input-group-sm" style="max-width: 320px;">
                                                        <input type="text" class="form-control" id="link-{{ $link->id }}" value="{{ $fullShortUrl }}" readonly>
                                                        <button class="btn btn-outline-primary" type="button" onclick="navigator.clipboard.writeText('{{ $fullShortUrl }}'); toastr.success('Shortlink copied!');">
                                                            <i class="ti ti-copy"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                                <td><span class="badge bg-success">{{ $link->affiliate_tag }}</span></td>
                                                <td>
                                                    <span class="badge bg-primary" data-bs-toggle="tooltip" title="Total Clicks">{{ number_format($link->clicks) }}</span>
                                                    <small class="text-muted ms-1">(📱 {{ $link->android_clicks + $link->ios_clicks }} / 💻 {{ $link->desktop_clicks }})</small>
                                                </td>
                                                <td class="Action">
                                                    <a href="#" class="btn btn-sm bg-info text-white" data-url="{{ route('affiliate-links.edit', $link->id) }}" data-ajax-popup="true" data-size="md" data-bs-toggle="tooltip" title="{{ __('Edit') }}">
                                                        <i class="ti ti-pencil"></i>
                                                    </a>
                                                    {!! Form::open(['method' => 'DELETE', 'route' => ['affiliate-links.destroy', $link->id], 'class' => 'd-inline']) !!}
                                                    <button type="submit" class="btn btn-sm bg-danger text-white" onclick="return confirm('Delete shortlink?');">
                                                        <i class="ti ti-trash"></i>
                                                    </button>
                                                    {!! Form::close() !!}
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center py-4 text-muted">{{ __('No affiliate shortlinks created yet.') }}</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TAB 2: STORE IDs & CHANNELS -->
                <div class="tab-pane fade" id="storeids" role="tabpanel">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0">{{ __('Add New Amazon Store ID') }}</h5>
                                </div>
                                <div class="card-body">
                                    {{ Form::open(['route' => 'affiliate.store-ids.store', 'method' => 'POST']) }}
                                    <div class="form-group mb-3">
                                        <label class="form-label">{{ __('Store ID / Associate Tag') }}</label>
                                        <input type="text" name="store_id" class="form-control" placeholder="e.g. ramyadevikola-21" required>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="form-label">{{ __('Channel Name') }}</label>
                                        <input type="text" name="channel_name" class="form-control" placeholder="e.g. YouTube Main Channel, Instagram" required>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="form-label">{{ __('Notes (Optional)') }}</label>
                                        <textarea name="notes" class="form-control" rows="2" placeholder="Primary tag used in video descriptions"></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100"><i class="ti ti-plus"></i> {{ __('Save Store ID') }}</button>
                                    {{ Form::close() }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0">{{ __('Active Amazon Store IDs') }}</h5>
                                </div>
                                <div class="card-body table-border-style">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>{{ __('Store ID Tag') }}</th>
                                                    <th>{{ __('Channel') }}</th>
                                                    <th>{{ __('Default') }}</th>
                                                    <th>{{ __('Action') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($storeIds as $st)
                                                    <tr>
                                                        <td class="font-weight-bold"><code>{{ $st->store_id }}</code></td>
                                                        <td>{{ $st->channel_name }}</td>
                                                        <td>
                                                            @if($st->is_default)
                                                                <span class="badge bg-success">{{ __('Default') }}</span>
                                                            @else
                                                                <a href="{{ route('affiliate.store-ids.default', $st->id) }}" class="btn btn-xs btn-outline-secondary">{{ __('Set Default') }}</a>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if(!$st->is_default)
                                                                {!! Form::open(['method' => 'DELETE', 'route' => ['affiliate.store-ids.destroy', $st->id], 'class' => 'd-inline']) !!}
                                                                <button type="submit" class="btn btn-sm bg-danger text-white" onclick="return confirm('Delete this store ID?');"><i class="ti ti-trash"></i></button>
                                                                {!! Form::close() !!}
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TAB 3: CLICK LOGS & ANALYTICS -->
                <div class="tab-pane fade" id="analytics" role="tabpanel">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">{{ __('Realtime Visitor & App Launch Logs') }}</h5>
                        </div>
                        <div class="card-body table-border-style">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>{{ __('Time') }}</th>
                                            <th>{{ __('Code / ASIN') }}</th>
                                            <th>{{ __('Store Tag') }}</th>
                                            <th>{{ __('Device / OS') }}</th>
                                            <th>{{ __('IP Address') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($recentLogs as $log)
                                            <tr>
                                                <td><small class="text-muted">{{ $log->created_at->diffForHumans() }}</small></td>
                                                <td><code>{{ $log->code }}</code></td>
                                                <td><span class="badge bg-secondary">{{ $log->store_id }}</span></td>
                                                <td>
                                                    @if($log->device_type === 'android')
                                                        <span class="badge bg-success"><i class="ti ti-brand-android"></i> Android App</span>
                                                    @elseif($log->device_type === 'ios')
                                                        <span class="badge bg-info"><i class="ti ti-brand-apple"></i> iOS App</span>
                                                    @else
                                                        <span class="badge bg-warning text-dark"><i class="ti ti-device-laptop"></i> Desktop</span>
                                                    @endif
                                                </td>
                                                <td><small>{{ $log->ip_address }}</small></td>
                                            </tr>
                                        @empty
                                            <tr><td colspan="5" class="text-center text-muted py-3">{{ __('No clicks logged yet.') }}</td></tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TAB 4: REST API INTEGRATION GUIDE -->
                <div class="tab-pane fade" id="api" role="tabpanel">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">{{ __('Affiliate REST API Integration') }}</h5>
                            <small class="text-muted">{{ __('Use these endpoints to programmatically shorten links or integrate with YouTube upload bots and tools.') }}</small>
                        </div>
                        <div class="card-body">
                            <h6>1. Shorten Link / ASIN Endpoint</h6>
                            <p class="mb-2"><strong>POST</strong> <code>{{ url('/api/v1/affiliate/shorten') }}</code></p>
                            <pre class="bg-dark text-white p-3 rounded">curl -X POST "{{ url('/api/v1/affiliate/shorten') }}" \
  -H "Content-Type: application/json" \
  -d '{
    "url": "https://www.amazon.in/dp/B08N5WRWNW",
    "custom_slug": "boat-airdopes",
    "store_id": "ramyadevikola-21"
  }'</pre>
                            
                            <h6 class="mt-4">JSON Response Example:</h6>
                            <pre class="bg-light p-3 rounded"><code>{
  "status": "success",
  "short_link": "{{ url('/') }}/boat-airdopes",
  "code": "boat-airdopes",
  "asin": "B08N5WRWNW",
  "store_id": "ramyadevikola-21",
  "amazon_url": "https://www.amazon.in/dp/B08N5WRWNW?tag=ramyadevikola-21"
}</code></pre>

                            <h6 class="mt-4">2. Analytics Endpoint</h6>
                            <p class="mb-2"><strong>GET</strong> <code>{{ url('/api/v1/affiliate/stats') }}</code></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
