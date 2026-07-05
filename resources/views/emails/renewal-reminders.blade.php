<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ __('Upcoming renewals & maintenance billing') }}</title>
</head>
<body style="font-family: Arial, Helvetica, sans-serif; color:#2b2b2b; background:#f5f6fa; margin:0; padding:24px;">
    <div style="max-width:640px; margin:0 auto; background:#fff; border-radius:8px; padding:24px;">
        <h2 style="margin-top:0;">{{ __('Upcoming renewals & maintenance billing') }}</h2>
        <p>{{ __('Hi') }} {{ $company->name }},</p>
        <p>{{ __('Here is what is due within the next') }} {{ $days }} {{ __('days (or already overdue):') }}</p>

        @if (!empty($items))
            <h3 style="margin-bottom:8px;">{{ __('Website Renewals') }}</h3>
            <table width="100%" cellpadding="8" cellspacing="0" style="border-collapse:collapse; margin-bottom:20px;">
                <thead>
                    <tr style="background:#f0f1f5; text-align:left;">
                        <th style="border-bottom:1px solid #e2e4ea;">{{ __('Client') }}</th>
                        <th style="border-bottom:1px solid #e2e4ea;">{{ __('Website') }}</th>
                        <th style="border-bottom:1px solid #e2e4ea;">{{ __('Type') }}</th>
                        <th style="border-bottom:1px solid #e2e4ea;">{{ __('Date') }}</th>
                        <th style="border-bottom:1px solid #e2e4ea;">{{ __('Charges') }}</th>
                        <th style="border-bottom:1px solid #e2e4ea;">{{ __('Status') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $it)
                        <tr>
                            <td style="border-bottom:1px solid #f0f1f5;">{{ $it['client'] ?? '-' }}</td>
                            <td style="border-bottom:1px solid #f0f1f5;">{{ $it['label'] }}</td>
                            <td style="border-bottom:1px solid #f0f1f5;">{{ $it['kind'] }}</td>
                            <td style="border-bottom:1px solid #f0f1f5;">{{ $it['date'] }}</td>
                            <td style="border-bottom:1px solid #f0f1f5;">{{ !empty($it['amount']) ? number_format($it['amount'], 2) : '-' }}</td>
                            <td style="border-bottom:1px solid #f0f1f5;">
                                @if ($it['overdue'])
                                    <span style="color:#d9534f; font-weight:bold;">{{ __('Overdue') }} {{ abs($it['days_left']) }} {{ __('days') }}</span>
                                @else
                                    <span style="color:#e0a800;">{{ __('in') }} {{ $it['days_left'] }} {{ __('days') }}</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

        @if (!empty($maintenanceItems))
            <h3 style="margin-bottom:8px;">{{ __('Maintenance / Retainer Billing') }}</h3>
            <table width="100%" cellpadding="8" cellspacing="0" style="border-collapse:collapse;">
                <thead>
                    <tr style="background:#f0f1f5; text-align:left;">
                        <th style="border-bottom:1px solid #e2e4ea;">{{ __('Client') }}</th>
                        <th style="border-bottom:1px solid #e2e4ea;">{{ __('Service') }}</th>
                        <th style="border-bottom:1px solid #e2e4ea;">{{ __('Amount') }}</th>
                        <th style="border-bottom:1px solid #e2e4ea;">{{ __('Due Date') }}</th>
                        <th style="border-bottom:1px solid #e2e4ea;">{{ __('Status') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($maintenanceItems as $it)
                        <tr>
                            <td style="border-bottom:1px solid #f0f1f5;">{{ $it['client'] ?? '-' }}</td>
                            <td style="border-bottom:1px solid #f0f1f5;">{{ $it['service'] }}{{ $it['title'] ? ' — ' . $it['title'] : '' }}</td>
                            <td style="border-bottom:1px solid #f0f1f5;">{{ number_format($it['amount'], 2) }}</td>
                            <td style="border-bottom:1px solid #f0f1f5;">{{ $it['date'] }}</td>
                            <td style="border-bottom:1px solid #f0f1f5;">
                                @if ($it['overdue'])
                                    <span style="color:#d9534f; font-weight:bold;">{{ __('Overdue') }} {{ abs($it['days_left']) }} {{ __('days') }}</span>
                                @else
                                    <span style="color:#0d8f56;">{{ __('in') }} {{ $it['days_left'] }} {{ __('days') }}</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

        <p style="margin-top:20px; font-size:12px; color:#8a8f99;">
            {{ __('This is an automated reminder from your dashboard.') }}
        </p>
    </div>
</body>
</html>
