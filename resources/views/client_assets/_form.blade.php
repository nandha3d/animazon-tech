{{-- Shared asset field set. $asset may be null on create. --}}
@php $a = $asset ?? null; @endphp
<div class="row">
    <div class="col-md-6 form-group">
        {{ Form::label('label', __('Label'), ['class' => 'form-label']) }}<span class="text-danger">*</span>
        {{ Form::text('label', $a->label ?? null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => __('e.g. Main Website')]) }}
    </div>
    <div class="col-md-6 form-group">
        {{ Form::label('website_url', __('Website URL'), ['class' => 'form-label']) }}
        {{ Form::text('website_url', $a->website_url ?? null, ['class' => 'form-control', 'placeholder' => 'https://example.com']) }}
    </div>
</div>

<hr>
<h6>{{ __('Admin Login') }}</h6>
<div class="row">
    <div class="col-md-4 form-group">
        {{ Form::label('admin_url', __('Admin URL'), ['class' => 'form-label']) }}
        {{ Form::text('admin_url', $a->admin_url ?? null, ['class' => 'form-control', 'placeholder' => 'https://example.com/wp-admin']) }}
    </div>
    <div class="col-md-4 form-group">
        {{ Form::label('admin_username', __('Username'), ['class' => 'form-label']) }}
        {{ Form::text('admin_username', $a->admin_username ?? null, ['class' => 'form-control']) }}
    </div>
    <div class="col-md-4 form-group">
        {{ Form::label('admin_password', __('Password'), ['class' => 'form-label']) }}
        {{ Form::password('admin_password', ['class' => 'form-control', 'autocomplete' => 'new-password', 'placeholder' => isset($a) ? __('Leave blank to keep current') : '']) }}
    </div>
</div>

<hr>
<h6>{{ __('Hosting / cPanel') }}</h6>
<div class="row">
    <div class="col-md-3 form-group">
        {{ Form::label('hosting_provider', __('Hosting Provider'), ['class' => 'form-label']) }}
        {{ Form::text('hosting_provider', $a->hosting_provider ?? null, ['class' => 'form-control']) }}
    </div>
    <div class="col-md-3 form-group">
        {{ Form::label('cpanel_url', __('cPanel URL'), ['class' => 'form-label']) }}
        {{ Form::text('cpanel_url', $a->cpanel_url ?? null, ['class' => 'form-control']) }}
    </div>
    <div class="col-md-3 form-group">
        {{ Form::label('cpanel_username', __('cPanel Username'), ['class' => 'form-label']) }}
        {{ Form::text('cpanel_username', $a->cpanel_username ?? null, ['class' => 'form-control']) }}
    </div>
    <div class="col-md-3 form-group">
        {{ Form::label('cpanel_password', __('cPanel Password'), ['class' => 'form-label']) }}
        {{ Form::password('cpanel_password', ['class' => 'form-control', 'autocomplete' => 'new-password', 'placeholder' => isset($a) ? __('Leave blank to keep current') : '']) }}
    </div>
</div>

<hr>
<h6>{{ __('FTP / SSH / Database') }}</h6>
<div class="row">
    <div class="col-md-3 form-group">
        {{ Form::label('ftp_host', __('FTP Host'), ['class' => 'form-label']) }}
        {{ Form::text('ftp_host', $a->ftp_host ?? null, ['class' => 'form-control']) }}
    </div>
    <div class="col-md-3 form-group">
        {{ Form::label('ftp_username', __('FTP Username'), ['class' => 'form-label']) }}
        {{ Form::text('ftp_username', $a->ftp_username ?? null, ['class' => 'form-control']) }}
    </div>
    <div class="col-md-3 form-group">
        {{ Form::label('ftp_password', __('FTP Password'), ['class' => 'form-label']) }}
        {{ Form::password('ftp_password', ['class' => 'form-control', 'autocomplete' => 'new-password', 'placeholder' => isset($a) ? __('Leave blank to keep current') : '']) }}
    </div>
    <div class="col-md-3 form-group">
        {{ Form::label('ssh_host', __('SSH Host'), ['class' => 'form-label']) }}
        {{ Form::text('ssh_host', $a->ssh_host ?? null, ['class' => 'form-control']) }}
    </div>
    <div class="col-md-3 form-group">
        {{ Form::label('db_name', __('Database Name'), ['class' => 'form-label']) }}
        {{ Form::text('db_name', $a->db_name ?? null, ['class' => 'form-control']) }}
    </div>
</div>

<hr>
<h6>{{ __('Domain / Renewals') }}</h6>
<div class="row">
    <div class="col-md-3 form-group">
        {{ Form::label('domain_registrar', __('Domain Registrar'), ['class' => 'form-label']) }}
        {{ Form::text('domain_registrar', $a->domain_registrar ?? null, ['class' => 'form-control']) }}
    </div>
    <div class="col-md-3 form-group">
        {{ Form::label('ssl_expiry', __('SSL Expiry'), ['class' => 'form-label']) }}
        {{ Form::date('ssl_expiry', isset($a->ssl_expiry) ? $a->ssl_expiry->format('Y-m-d') : null, ['class' => 'form-control']) }}
    </div>
    <div class="col-md-3 form-group">
        {{ Form::label('hosting_renewal', __('Hosting Renewal'), ['class' => 'form-label']) }}
        {{ Form::date('hosting_renewal', isset($a->hosting_renewal) ? $a->hosting_renewal->format('Y-m-d') : null, ['class' => 'form-control']) }}
    </div>
    <div class="col-md-3 form-group">
        {{ Form::label('hosting_amount', __('Hosting Charges'), ['class' => 'form-label']) }}
        {{ Form::number('hosting_amount', $a->hosting_amount ?? null, ['class' => 'form-control', 'step' => '0.01', 'placeholder' => __('Renewal cost')]) }}
    </div>
    <div class="col-md-3 form-group">
        {{ Form::label('domain_renewal', __('Domain Renewal'), ['class' => 'form-label']) }}
        {{ Form::date('domain_renewal', isset($a->domain_renewal) ? $a->domain_renewal->format('Y-m-d') : null, ['class' => 'form-control']) }}
    </div>
</div>

<div class="row">
    <div class="col-12 form-group">
        {{ Form::label('notes', __('Notes'), ['class' => 'form-label']) }}
        {{ Form::textarea('notes', $a->notes ?? null, ['class' => 'form-control', 'rows' => 3]) }}
    </div>
</div>
