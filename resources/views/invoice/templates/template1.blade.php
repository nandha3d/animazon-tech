@php
    $settings_data = \App\Models\Utility::settingsById($invoice->created_by);
    $invDisplayNum = '#INVO' . sprintf('%04d', $invoice->invoice_id);
    $logoUrl = asset('storage/uploads/logo/logo-dark.png');
    if (!file_exists(public_path('storage/uploads/logo/logo-dark.png'))) {
        $logoUrl = $img ?? asset('uploads/logo/logo-dark.png');
    }
@endphp

<!DOCTYPE html>
<html lang="en" dir="{{ ($settings_data['SITE_RTL'] ?? 'off') == 'on' ? 'rtl' : '' }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $invDisplayNum }} - Invoice</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style type="text/css">
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }

        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #f8fafc;
            color: #0f172a;
            font-size: 12px;
            line-height: 1.45;
            padding: 15px 0;
        }

        .pdf-page-container {
            max-width: 780px;
            margin: 0 auto;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 26px 32px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            position: relative;
        }

        /* Top Accent Strip */
        .pdf-top-bar {
            height: 4px;
            background: linear-gradient(90deg, #0284c7, #06b6d4, #3b82f6, #6366f1);
            border-radius: 6px 6px 0 0;
            margin: -26px -32px 20px -32px;
        }

        /* Header Section */
        .pdf-header {
            display: table;
            width: 100%;
            margin-bottom: 20px;
            padding-bottom: 16px;
            border-bottom: 1px solid #e2e8f0;
        }

        .pdf-header-left {
            display: table-cell;
            vertical-align: middle;
            width: 55%;
        }

        .pdf-header-right {
            display: table-cell;
            vertical-align: middle;
            width: 45%;
            text-align: right;
        }

        .pdf-logo {
            max-height: 44px;
            width: auto;
            display: block;
            margin-bottom: 6px;
        }

        .brand-subtitle {
            font-size: 11px;
            color: #64748b;
            font-weight: 500;
        }

        .doc-title {
            font-family: 'Outfit', sans-serif;
            font-size: 26px;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: -0.5px;
            margin-bottom: 4px;
        }

        .doc-inv-num {
            font-family: 'Outfit', sans-serif;
            font-size: 15px;
            font-weight: 700;
            color: #0284c7;
        }

        /* Metadata & Status Bar */
        .pdf-meta-grid {
            display: table;
            width: 100%;
            margin-bottom: 18px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 10px 14px;
        }

        .pdf-meta-cell {
            display: table-cell;
            vertical-align: middle;
            width: 25%;
        }

        .meta-label {
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #64748b;
            font-weight: 700;
            margin-bottom: 2px;
        }

        .meta-val {
            font-size: 12px;
            font-weight: 700;
            color: #0f172a;
        }

        .status-badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 6px;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-unpaid {
            background: #fef3c7;
            color: #b45309;
            border: 1px solid #fde68a;
        }

        .status-paid {
            background: #dcfce7;
            color: #15803d;
            border: 1px solid #bbf7d0;
        }

        /* Parties Info Box (Billed To vs Provider) */
        .pdf-parties-table {
            width: 100%;
            margin-bottom: 20px;
            border-collapse: separate;
            border-spacing: 12px 0;
        }

        .party-box {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 12px 14px;
            vertical-align: top;
            width: 50%;
        }

        .party-tag {
            font-size: 9.5px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #0284c7;
            font-weight: 700;
            margin-bottom: 4px;
        }

        .party-name {
            font-size: 13px;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 4px;
        }

        .party-desc {
            font-size: 11px;
            color: #475569;
            line-height: 1.4;
        }

        /* Items Table */
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 18px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            overflow: hidden;
        }

        .items-table thead th {
            background: #0f172a;
            color: #ffffff;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            padding: 8px 12px;
            border-bottom: 1px solid #0f172a;
        }

        .items-table tbody tr {
            border-bottom: 1px solid #f1f5f9;
        }

        .items-table tbody tr:nth-child(even) {
            background: #f8fafc;
        }

        .items-table td {
            padding: 8px 12px;
            vertical-align: middle;
            color: #1e293b;
            font-size: 11px;
        }

        .item-idx {
            font-weight: 700;
            color: #64748b;
            font-size: 10px;
        }

        .item-title {
            font-weight: 700;
            color: #0f172a;
            font-size: 11.5px;
            margin-bottom: 2px;
        }

        .item-subtext {
            font-size: 10px;
            color: #64748b;
            line-height: 1.3;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .amount-cell {
            font-family: 'Outfit', sans-serif;
            font-weight: 700;
            font-size: 12px;
            color: #0f172a;
            text-align: right;
        }

        /* Bottom Bento Grid (Settlement & Summary) */
        .bottom-section {
            display: table;
            width: 100%;
            margin-top: 4px;
        }

        .bottom-left {
            display: table-cell;
            width: 55%;
            vertical-align: top;
            padding-right: 14px;
        }

        .bottom-right {
            display: table-cell;
            width: 45%;
            vertical-align: top;
        }

        .settlement-card {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 10px 12px;
        }

        .settlement-header {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: #0284c7;
            margin-bottom: 8px;
            display: table;
            width: 100%;
        }

        .settlement-header-title {
            display: table-cell;
            vertical-align: middle;
            text-align: left;
        }

        .settlement-header-badge {
            display: table-cell;
            vertical-align: middle;
            text-align: right;
        }

        .settlement-table {
            display: table;
            width: 100%;
        }

        .settlement-qr {
            display: table-cell;
            vertical-align: middle;
            width: 82px;
            background: #ffffff;
            padding: 6px;
            border-radius: 6px;
            border: 1px solid #e2e8f0;
            text-align: center;
        }

        .settlement-info {
            display: table-cell;
            vertical-align: middle;
            padding-left: 12px;
            font-size: 10.5px;
            color: #475569;
            line-height: 1.4;
        }

        .settlement-info strong {
            color: #0f172a;
        }

        /* Financial Summary Box */
        .calc-box {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 10px 14px;
        }

        .calc-row {
            display: table;
            width: 100%;
            font-size: 11px;
            color: #64748b;
            padding: 3px 0;
        }

        .calc-row-label {
            display: table-cell;
            text-align: left;
        }

        .calc-row-val {
            display: table-cell;
            text-align: right;
            font-weight: 600;
            color: #0f172a;
        }

        .calc-total-row {
            display: table;
            width: 100%;
            margin-top: 6px;
            padding-top: 6px;
            border-top: 2px solid #0f172a;
            font-size: 13px;
        }

        .calc-total-label {
            display: table-cell;
            text-align: left;
            font-family: 'Outfit', sans-serif;
            font-weight: 800;
            color: #0f172a;
            text-transform: uppercase;
        }

        .calc-total-amount {
            display: table-cell;
            text-align: right;
            font-family: 'Outfit', sans-serif;
            font-size: 18px;
            font-weight: 800;
            color: #0284c7;
        }

        /* Footer */
        .pdf-footer {
            margin-top: 14px;
            padding-top: 10px;
            border-top: 1px solid #f1f5f9;
            text-align: center;
            font-size: 9.5px;
            color: #94a3b8;
        }
    </style>
</head>

<body>

<div class="pdf-page-container" id="boxes">
    <div class="pdf-top-bar"></div>

    <!-- Header Section -->
    <div class="pdf-header">
        <div class="pdf-header-left">
            <img class="pdf-logo" src="{{ $logoUrl }}" alt="Animazon Logo" onerror="this.onerror=null; this.src='{{ asset('uploads/logo/logo-dark.png') }}';">
            <div class="brand-subtitle">Animazon Web Studio • Web Development, AI Video & High-Impact Digital Solutions</div>
        </div>
        <div class="pdf-header-right">
            <div class="doc-title">{{ __('INVOICE') }}</div>
            <div class="doc-inv-num">{{ $invDisplayNum }}</div>
            @if(!empty($invoice->ref_number))
                <div style="font-size:10px; color:#64748b; margin-top:2px;">Ref: {{ $invoice->ref_number }}</div>
            @endif
        </div>
    </div>

    <!-- Metadata Grid -->
    <div class="pdf-meta-grid">
        <div class="pdf-meta-cell">
            <div class="meta-label">{{ __('Invoice Number') }}</div>
            <div class="meta-val">{{ $invDisplayNum }}</div>
        </div>
        <div class="pdf-meta-cell">
            <div class="meta-label">{{ __('Issue Date') }}</div>
            <div class="meta-val">{{ Utility::dateFormat($settings, $invoice->issue_date) }}</div>
        </div>
        <div class="pdf-meta-cell">
            <div class="meta-label">{{ __('Due Date') }}</div>
            <div class="meta-val">{{ Utility::dateFormat($settings, $invoice->due_date) }}</div>
        </div>
        <div class="pdf-meta-cell text-right">
            <div class="meta-label">{{ __('Payment Status') }}</div>
            <div>
                @if ($invoice->status == 4)
                    <span class="status-badge status-paid">{{ __('Paid in Full') }}</span>
                @else
                    <span class="status-badge status-unpaid">{{ __('Payment Pending') }}</span>
                @endif
            </div>
        </div>
    </div>

    <!-- Billed To & Issued By Bento Grid -->
    <table class="pdf-parties-table">
        <tr>
            <td class="party-box">
                <div class="party-tag">{{ __('Billed To (Client)') }}</div>
                <div class="party-name">
                    {{ !empty($customer->name) ? $customer->name : (!empty($customer->billing_name) ? $customer->billing_name : 'Client') }}
                </div>
                <div class="party-desc">
                    @if(!empty($customer->email))
                        <div>{{ $customer->email }}</div>
                    @endif
                    @if(!empty($customer->contact) || !empty($customer->billing_phone))
                        <div>{{ $customer->contact ?: $customer->billing_phone }}</div>
                    @endif
                    @if(!empty($customer->billing_address))
                        <div>{{ $customer->billing_address }}, {{ $customer->billing_city }} {{ $customer->billing_state }} {{ $customer->billing_zip }}</div>
                    @endif
                </div>
            </td>
            <td class="party-box">
                <div class="party-tag">{{ __('Issued By') }}</div>
                <div class="party-name">Animazon Web Studio</div>
                <div class="party-desc">
                    <div>info@animazon.in • www.animazon.in</div>
                    <div>+91 80894 05950</div>
                    <div>155, Narayana Valasu, Nasiyanur Road, Above Bake Mart, Erode, TN - 638011</div>
                </div>
            </td>
        </tr>
    </table>

    <!-- Itemized Work Table -->
    <table class="items-table">
        <thead>
            <tr>
                <th style="width: 32px; text-align: center;">#</th>
                <th>{{ __('Description & Deliverables') }}</th>
                <th style="width: 60px; text-align: center;">{{ __('Qty') }}</th>
                <th style="width: 100px; text-align: right;">{{ __('Rate') }}</th>
                <th style="width: 110px; text-align: right;">{{ __('Amount') }}</th>
            </tr>
        </thead>
        <tbody>
            @if(isset($invoice->itemData) && count($invoice->itemData) > 0)
                @foreach($invoice->itemData as $key => $item)
                    @php
                        $itemTotal = ($item->price * $item->quantity) - $item->discount;
                    @endphp
                    <tr>
                        <td class="text-center item-idx">{{ str_pad($key + 1, 2, '0', STR_PAD_LEFT) }}</td>
                        <td>
                            <div class="item-title">{{ $item->name }}</div>
                            @if(!empty($item->description) && $item->name !== $item->description)
                                <div class="item-subtext">{{ $item->description }}</div>
                            @endif
                        </td>
                        <td class="text-center" style="font-weight:600;">{{ $item->quantity }}</td>
                        <td class="text-right">₹{{ number_format((float)$item->price, 2, '.', ',') }}</td>
                        <td class="amount-cell">₹{{ number_format((float)$itemTotal, 2, '.', ',') }}</td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>

    <!-- Bottom Settlement & Summary Section -->
    <div class="bottom-section">
        <!-- Direct Bank Settlement & QR Code -->
        <div class="bottom-left">
            <div class="settlement-card">
                <div class="settlement-header">
                    <span class="settlement-header-title">{{ __('Bank Details & Direct Settlement') }}</span>
                    <span class="settlement-header-badge" style="font-size: 8px; font-weight: 700; background: #e0f2fe; color: #0284c7; border: 1px solid #7dd3fc; padding: 1px 6px; border-radius: 4px; text-transform: uppercase;">Verified Account</span>
                </div>
                <div class="settlement-table">
                    <div class="settlement-qr">
                        @php
                            $dueAmount = number_format((float)$invoice->getDue(), 2, '.', '');
                            $invCleanNum = 'INVO' . sprintf('%04d', $invoice->invoice_id);
                            $upiLink = "upi://pay?pa=nandhu3d@oksbi" .
                                      "&pn=" . rawurlencode("Animazon Web Studio") .
                                      "&am=" . $dueAmount .
                                      "&cu=INR" .
                                      "&tn=" . rawurlencode("Invoice " . $invCleanNum);
                        @endphp
                        {!! DNS2D::getBarcodeHTML($upiLink, "QRCODE", 2.3, 2.3, '#0f172a') !!}
                        <div style="font-size: 7.5px; font-weight: 800; color: #0f172a; margin-top: 4px; letter-spacing: 0.3px;">
                            SCAN VIA UPI
                        </div>
                        <div style="font-size: 6.5px; color: #64748b; margin-top: 1px;">
                            GPay • PhonePe • Paytm
                        </div>
                    </div>
                    <div class="settlement-info">
                        <div>Bank: <strong>INDIAN BANK</strong></div>
                        <div>A/C Name: <strong>G.Nandhakumar</strong></div>
                        <div>A/C No: <strong style="color: #0284c7;">975099385</strong></div>
                        <div>IFSC: <strong>IDIB000P106</strong></div>
                        <div>Branch: <strong>Perundurai Road</strong></div>
                        <div>GPay / UPI ID: <strong style="color: #0284c7;">nandhu3d@oksbi</strong></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Calculation Summary Box -->
        <div class="bottom-right">
            <div class="calc-box">
                <div class="calc-row">
                    <div class="calc-row-label">{{ __('Sub Total') }}:</div>
                    <div class="calc-row-val">₹{{ number_format((float)$invoice->getSubTotal(), 2, '.', ',') }}</div>
                </div>
                @if($invoice->getTotalDiscount() > 0)
                    <div class="calc-row">
                        <div class="calc-row-label">{{ __('Discount') }}:</div>
                        <div class="calc-row-val" style="color:#16a34a;">- ₹{{ number_format((float)$invoice->getTotalDiscount(), 2, '.', ',') }}</div>
                    </div>
                @endif
                @if($invoice->getTotalTax() > 0)
                    <div class="calc-row">
                        <div class="calc-row-label">{{ __('Taxes') }}:</div>
                        <div class="calc-row-val">+ ₹{{ number_format((float)$invoice->getTotalTax(), 2, '.', ',') }}</div>
                    </div>
                @endif
                @if($invoice->getDue() < $invoice->getTotal() && $invoice->getDue() > 0)
                    <div class="calc-row">
                        <div class="calc-row-label">{{ __('Amount Paid') }}:</div>
                        <div class="calc-row-val" style="color:#16a34a;">- ₹{{ number_format((float)($invoice->getTotal() - $invoice->getDue()), 2, '.', ',') }}</div>
                    </div>
                    <div class="calc-row">
                        <div class="calc-row-label">{{ __('Balance Due') }}:</div>
                        <div class="calc-row-val" style="color:#b45309;">₹{{ number_format((float)$invoice->getDue(), 2, '.', ',') }}</div>
                    </div>
                @endif

                <div class="calc-total-row">
                    <div class="calc-total-label">{{ __('Total Payable') }}:</div>
                    <div class="calc-total-amount">₹{{ number_format((float)$invoice->getTotal(), 2, '.', ',') }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="pdf-footer">
        Thank you for choosing Animazon Web Studio! Payments can be settled via UPI, Net Banking or Online Payment.
    </div>

</div>

@if(!isset($preview))
    @include('invoice.script')
@endif

</body>
</html>
