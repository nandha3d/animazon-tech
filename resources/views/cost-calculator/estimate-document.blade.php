@extends('layouts.landing')

@section('page_title', 'Project Estimate & Agreement')

@section('page_content')
@php
    $companyName = $settings['company_name'] ?? 'Animazon';
    $companyAddress = $settings['company_address'] ?? '';
    $companyCity = $settings['company_city'] ?? '';
    $companyState = $settings['company_state'] ?? '';
    $companyCountry = $settings['company_country'] ?? '';
    $companyPhone = $settings['company_telephone'] ?? '';
    $companyEmail = env('ESTIMATE_NOTIFY_EMAIL', $settings['company_email'] ?? 'info@animazon.in');
    $logo = asset('storage/uploads/logo');
    $companyLogo = $settings['company_logo_light'] ?? 'logo-light.png';
    $estimateNumber = 'EST-' . str_pad($estimate->id, 5, '0', STR_PAD_LEFT);
    $validUntil = $estimate->created_at->addDays(30);
    $isExpired = now()->greaterThan($validUntil);
    $isAccepted = $estimate->status === 'Accepted';
    $advancePercent = 30;
    $advanceAmount = round(($estimate->grand_total * $advancePercent) / 100, 2);
    $currencyCode = $estimate->currency_code ?? 'USD';

    // Convert advance to INR for Razorpay (Razorpay only accepts INR)
    $currencyMap = \App\Http\Controllers\CostCalculatorController::CURRENCY_MAP;
    $inrRate = $currencyMap['IN']['rate'] ?? 83.50;
    $clientRate = 1;
    foreach ($currencyMap as $key => $val) {
        if ($val['code'] === $currencyCode) { $clientRate = $val['rate']; break; }
    }
    $grandTotalUsd = $estimate->grand_total / $clientRate;
    $advanceInr = round(($grandTotalUsd * $inrRate * $advancePercent) / 100, 2);
    $advanceInrPaise = round($advanceInr * 100);
@endphp

<div class="bg-animazon-black min-h-screen py-10 md:py-16">
    <div class="container mx-auto px-4 max-w-4xl">

        {{-- Admin-only action bar (hidden from client visitors) --}}
        @auth
            @can('create invoice')
                <div class="mb-6 flex flex-wrap items-center justify-between gap-3 bg-white/5 border border-white/10 rounded-2xl p-4">
                    <span class="text-white/70 text-sm">
                        <i class="ti ti-shield-lock mr-1"></i>{{ __('Admin actions') }}
                    </span>
                    <div class="flex items-center gap-2">
                        @if(!empty($estimate->invoice_id))
                            <a href="{{ route('invoice.edit', \Crypt::encrypt($estimate->invoice_id)) }}"
                               class="inline-flex items-center gap-1 px-4 py-2 rounded-xl bg-blue-500 hover:bg-blue-600 text-white text-sm font-semibold">
                                <i class="ti ti-file-invoice"></i> {{ __('View Invoice') }}
                            </a>
                        @else
                            <a href="{{ route('invoice.from.cost.estimate', $estimate->id) }}"
                               onclick="return confirm('{{ __('Generate an invoice from this estimate?') }}')"
                               class="inline-flex items-center gap-1 px-4 py-2 rounded-xl bg-green-500 hover:bg-green-600 text-white text-sm font-semibold">
                                <i class="ti ti-file-plus"></i> {{ __('Generate Invoice') }}
                            </a>
                        @endif
                    </div>
                </div>
            @endcan
        @endauth

        {{-- Status Banner --}}
        @if(session('success'))
        <div class="mb-6 bg-green-500/20 border border-green-500/50 rounded-2xl p-4 text-center text-green-400 font-semibold">
            <i class="ti ti-check mr-2"></i>{{ session('success') }}
        </div>
        @endif
        @if(session('error'))
        <div class="mb-6 bg-red-500/20 border border-red-500/50 rounded-2xl p-4 text-center text-red-400 font-semibold">
            <i class="ti ti-alert-circle mr-2"></i>{{ session('error') }}
        </div>
        @endif

        <div class="bg-animazon-navy border border-animazon-border rounded-3xl p-6 md:p-12 shadow-2xl relative overflow-hidden">
            {{-- Decorative --}}
            <div class="absolute top-0 right-0 w-64 h-64 bg-primary/10 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>
            <div class="absolute bottom-0 left-0 w-48 h-48 bg-secondary/5 rounded-full blur-3xl translate-y-1/2 -translate-x-1/2"></div>

            {{-- ═══════════ HEADER ═══════════ --}}
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center border-b border-animazon-border pb-8 mb-8 relative z-10">
                <div>
                    <img src="{{ $logo . '/' . $companyLogo }}" alt="{{ $companyName }}" class="h-12 mb-4">
                    <h1 class="text-2xl md:text-3xl font-bold text-animazon-white">Project Estimate & Agreement</h1>
                    <p class="text-animazon-muted">{{ $estimateNumber }}</p>
                    @if($isAccepted)
                        <span class="inline-flex items-center gap-1 mt-2 px-3 py-1 rounded-full bg-green-500/20 text-green-400 text-xs font-bold"><i class="ti ti-check"></i> Accepted & Paid</span>
                    @elseif($isExpired)
                        <span class="inline-flex items-center gap-1 mt-2 px-3 py-1 rounded-full bg-red-500/20 text-red-400 text-xs font-bold"><i class="ti ti-clock"></i> Expired</span>
                    @else
                        <span class="inline-flex items-center gap-1 mt-2 px-3 py-1 rounded-full bg-yellow-500/20 text-yellow-400 text-xs font-bold"><i class="ti ti-clock"></i> Awaiting Acceptance</span>
                    @endif
                </div>
                <div class="mt-6 md:mt-0 text-left md:text-right">
                    <p class="text-animazon-white font-medium">{{ $companyName }}</p>
                    @if($companyAddress)<p class="text-animazon-muted text-sm">{{ $companyAddress }}</p>@endif
                    @if($companyCity || $companyState)<p class="text-animazon-muted text-sm">{{ $companyCity }} {{ $companyState }} {{ $companyCountry }}</p>@endif
                    @if($companyPhone)<p class="text-animazon-muted text-sm">{{ $companyPhone }}</p>@endif
                    <p class="text-primary text-sm mt-2 font-medium">{{ $companyEmail }}</p>
                </div>
            </div>

            {{-- ═══════════ PARTIES ═══════════ --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8 relative z-10">
                <div class="bg-animazon-black/50 rounded-2xl p-6 border border-animazon-border/50">
                    <h3 class="text-xs uppercase tracking-wider text-animazon-muted font-semibold mb-3">Prepared For (Client)</h3>
                    <p class="text-animazon-white font-bold text-lg">{{ $estimate->visitor_name }}</p>
                    <p class="text-animazon-muted text-sm">{{ $estimate->visitor_email }}</p>
                    @if($estimate->visitor_phone)<p class="text-animazon-muted text-sm">{{ $estimate->visitor_phone }}</p>@endif
                </div>
                <div class="bg-animazon-black/50 rounded-2xl p-6 border border-animazon-border/50">
                    <h3 class="text-xs uppercase tracking-wider text-animazon-muted font-semibold mb-3">Project Details</h3>
                    <p class="text-animazon-white font-bold text-lg">{{ $estimate->projectType->name ?? 'Project' }}</p>
                    <p class="text-animazon-muted text-sm">Created: {{ $estimate->created_at->format('M d, Y') }}</p>
                    <p class="text-animazon-muted text-sm">Valid Until: {{ $validUntil->format('M d, Y') }}</p>
                    <div class="flex items-center gap-4 mt-3 text-xs text-animazon-muted">
                        <span class="flex items-center gap-1"><i class="ti ti-calendar text-primary"></i> ~{{ $estimate->timeline_weeks }} Weeks</span>
                        <span class="flex items-center gap-1"><i class="ti ti-users text-primary"></i> {{ $estimate->team_size }} Experts</span>
                    </div>
                </div>
            </div>

            {{-- ═══════════ SCOPE / REQUIREMENTS ═══════════ --}}
            <div class="mb-8 relative z-10">
                <h3 class="text-xl font-bold text-animazon-white mb-1">1. Scope of Work & Requirements</h3>
                <p class="text-animazon-muted text-sm mb-5">The following selections define the project scope as agreed:</p>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-animazon-border text-animazon-muted text-xs uppercase tracking-wider">
                                <th class="pb-3 font-medium">Requirement</th>
                                <th class="pb-3 font-medium">Your Selection</th>
                                <th class="pb-3 font-medium text-right">Cost Impact</th>
                            </tr>
                        </thead>
                        <tbody class="text-animazon-white text-sm">
                            <tr class="border-b border-animazon-border/30 hover:bg-animazon-black/20 transition-colors">
                                <td class="py-3 pr-4 text-animazon-muted">Base Project Cost ({{ $estimate->category->name ?? 'Standard Setup' }})</td>
                                <td class="py-3 pr-4 font-medium">Core Development</td>
                                <td class="py-3 text-right text-primary font-medium whitespace-nowrap">
                                    {{ $currencyCode }} {{ number_format($estimate->base_cost * $clientRate * $internationalMultiplier, 2) }}
                                </td>
                            </tr>
                            @foreach($estimate->answers as $ans)
                            <tr class="border-b border-animazon-border/30 hover:bg-animazon-black/20 transition-colors">
                                <td class="py-3 pr-4 text-animazon-muted">{{ $ans->question->question ?? 'Question' }}</td>
                                <td class="py-3 pr-4 font-medium">
                                    {{ $ans->answer_id ? ($ans->answer->answer_text ?? 'Selected') : $ans->answer_value }}
                                </td>
                                <td class="py-3 text-right text-primary font-medium whitespace-nowrap">
                                    @php
                                        $incremental = $ans->cost_contribution;
                                        
                                        // Auto-fix past corrupted estimates where base_cost was added to every answer
                                        if ($ans->answer && abs($incremental - (($estimate->base_cost * $ans->answer->cost_multiplier) + $ans->answer->additional_cost)) < 0.01) {
                                            $incremental = ($estimate->base_cost * ($ans->answer->cost_multiplier - 1)) + $ans->answer->additional_cost;
                                        }

                                        $itemCostLocal = $incremental * $clientRate * $internationalMultiplier;
                                    @endphp
                                    @if($incremental > 0)
                                        {{ $currencyCode }} {{ number_format($itemCostLocal, 2) }}
                                    @elseif($incremental < 0)
                                        -{{ $currencyCode }} {{ number_format(abs($itemCostLocal), 2) }}
                                    @else
                                        Included
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="border-t border-animazon-border">
                                <td colspan="2" class="py-3 text-animazon-white font-bold">Total Estimated Cost</td>
                                <td class="py-3 text-right text-primary font-bold text-lg">{{ $currencyCode }} {{ number_format($estimate->grand_total, 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            {{-- ═══════════ PRICING ═══════════ --}}
            <div class="mb-8 relative z-10">
                <h3 class="text-xl font-bold text-animazon-white mb-4">2. Pricing & Payment Schedule</h3>
                <div class="bg-primary/5 rounded-2xl p-6 border border-primary/20">
                    <div class="flex justify-between items-center mb-2 text-sm">
                        <span class="text-animazon-muted">Base Estimate</span>
                        <span class="text-animazon-white">{{ $currencyCode }} {{ number_format($estimate->base_cost * $clientRate * $internationalMultiplier, 2) }}</span>
                    </div>
                    @if($estimate->tax_amount > 0)
                    <div class="flex justify-between items-center mb-2 text-sm">
                        <span class="text-animazon-muted">Tax ({{ $estimate->tax_percentage }}%)</span>
                        <span class="text-animazon-white">{{ $currencyCode }} {{ number_format($estimate->tax_amount, 2) }}</span>
                    </div>
                    @endif
                    <div class="flex justify-between items-center pt-4 border-t border-primary/20 mt-2">
                        <span class="text-lg font-bold text-animazon-white">Grand Total</span>
                        <span class="text-2xl font-black text-primary">{{ $currencyCode }} {{ number_format($estimate->grand_total, 2) }}</span>
                    </div>

                    <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-3 text-center text-xs">
                        <div class="bg-animazon-black/40 rounded-xl p-3 border border-animazon-border/30">
                            <p class="text-animazon-muted mb-1">Advance ({{ $advancePercent }}%)</p>
                            <p class="text-primary font-bold text-base">₹{{ number_format($advanceInr, 0) }}</p>
                            <p class="text-animazon-muted mt-1">Due on acceptance</p>
                        </div>
                        <div class="bg-animazon-black/40 rounded-xl p-3 border border-animazon-border/30">
                            <p class="text-animazon-muted mb-1">Milestone (40%)</p>
                            <p class="text-animazon-white font-bold text-base">{{ $currencyCode }} {{ number_format($estimate->grand_total * 0.40, 2) }}</p>
                            <p class="text-animazon-muted mt-1">Mid-project delivery</p>
                        </div>
                        <div class="bg-animazon-black/40 rounded-xl p-3 border border-animazon-border/30">
                            <p class="text-animazon-muted mb-1">Final (30%)</p>
                            <p class="text-animazon-white font-bold text-base">{{ $currencyCode }} {{ number_format($estimate->grand_total * 0.30, 2) }}</p>
                            <p class="text-animazon-muted mt-1">On project completion</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ═══════════ NOTES ═══════════ --}}
            @if($estimate->notes)
            <div class="mb-8 relative z-10">
                <h3 class="text-xl font-bold text-animazon-white mb-3">3. Client Notes</h3>
                <div class="bg-animazon-black/50 rounded-xl p-5 border border-animazon-border/30 text-sm text-animazon-muted leading-relaxed">
                    {{ $estimate->notes }}
                </div>
            </div>
            @endif

            {{-- ═══════════ TERMS & CONDITIONS ═══════════ --}}
            <div class="mb-8 relative z-10">
                <h3 class="text-xl font-bold text-animazon-white mb-4">{{ $estimate->notes ? '4' : '3' }}. Terms & Conditions</h3>
                <div class="space-y-5 text-sm text-animazon-muted leading-relaxed bg-animazon-black/30 rounded-2xl p-6 border border-animazon-border/30">

                    <div>
                        <h4 class="text-animazon-white font-semibold mb-1">A. Project Scope & Change Requests</h4>
                        <p>This agreement covers only the scope described in Section 1 above. Any additional features, modifications, or changes to the agreed scope shall be treated as a "Change Request" and will be quoted separately. {{ $companyName }} reserves the right to adjust timelines and costs upon mutual written agreement for any Change Requests.</p>
                    </div>

                    <div>
                        <h4 class="text-animazon-white font-semibold mb-1">B. Payment Terms</h4>
                        <p>Payment shall be made in three milestones: (i) {{ $advancePercent }}% non-refundable advance upon acceptance of this agreement; (ii) 40% upon delivery of the mid-project milestone (design approval / beta version); (iii) 30% upon final delivery and sign-off. Payments not received within 7 business days of the due date may result in project suspension. All prices are exclusive of applicable taxes unless stated otherwise.</p>
                    </div>

                    <div>
                        <h4 class="text-animazon-white font-semibold mb-1">C. Timeline & Delivery</h4>
                        <p>The estimated timeline of approximately {{ $estimate->timeline_weeks }} weeks commences from the date the advance payment is received and all required project assets (content, branding guidelines, credentials) are provided by the Client. Delays in providing assets may extend the timeline proportionally. {{ $companyName }} will provide regular progress updates.</p>
                    </div>

                    <div>
                        <h4 class="text-animazon-white font-semibold mb-1">D. Revisions & Feedback</h4>
                        <p>This project includes up to 3 (three) rounds of design/functional revisions per milestone. Additional revisions beyond this limit will be billed at the prevailing hourly rate. Revision requests must be consolidated and submitted in writing within 5 business days of each deliverable.</p>
                    </div>

                    <div>
                        <h4 class="text-animazon-white font-semibold mb-1">E. Intellectual Property</h4>
                        <p>Upon receipt of full and final payment, all custom-developed source code, design assets, and deliverables created specifically for this project shall be transferred to the Client. {{ $companyName }} retains the right to use the project in its portfolio for promotional purposes unless explicitly prohibited in writing. Third-party licenses, stock assets, and pre-existing frameworks remain subject to their respective license terms.</p>
                    </div>

                    <div>
                        <h4 class="text-animazon-white font-semibold mb-1">F. Confidentiality</h4>
                        <p>Both parties agree to keep all project-related information, business strategies, technical specifications, and proprietary data strictly confidential. This obligation survives the termination of this agreement and shall remain in effect for a period of 2 (two) years.</p>
                    </div>

                    <div>
                        <h4 class="text-animazon-white font-semibold mb-1">G. Warranty & Support</h4>
                        <p>{{ $companyName }} provides a 30-day bug-fix warranty from the date of final delivery. This warranty covers functional defects in the delivered software/website that deviate from the agreed specifications. It does not cover issues arising from third-party services, hosting environments, unauthorized modifications, or content changes made by the Client. Extended maintenance and support packages are available separately.</p>
                    </div>

                    <div>
                        <h4 class="text-animazon-white font-semibold mb-1">H. Hosting & Third-Party Services</h4>
                        <p>Unless explicitly included in the scope, hosting, domain registration, SSL certificates, third-party API subscriptions, and email services are the responsibility of the Client. {{ $companyName }} can assist with procurement and setup at additional cost upon request.</p>
                    </div>

                    <div>
                        <h4 class="text-animazon-white font-semibold mb-1">I. Limitation of Liability</h4>
                        <p>{{ $companyName }}'s total liability under this agreement shall not exceed the total project cost stated herein. {{ $companyName }} shall not be liable for any indirect, incidental, consequential, or punitive damages, including but not limited to loss of profits, data, or business opportunities arising from the use or inability to use the delivered project.</p>
                    </div>

                    <div>
                        <h4 class="text-animazon-white font-semibold mb-1">J. Termination</h4>
                        <p>Either party may terminate this agreement with 15 days' written notice. In the event of termination: (a) by the Client — all payments made up to the point of termination are non-refundable, and the Client shall pay for all work completed; (b) by {{ $companyName }} — all completed deliverables up to the termination date shall be handed over to the Client, and any advance payment for undelivered work will be refunded proportionally.</p>
                    </div>

                    <div>
                        <h4 class="text-animazon-white font-semibold mb-1">K. Force Majeure</h4>
                        <p>Neither party shall be held liable for delays or failure to perform obligations due to circumstances beyond reasonable control, including natural disasters, pandemics, government actions, internet outages, or other force majeure events.</p>
                    </div>

                    <div>
                        <h4 class="text-animazon-white font-semibold mb-1">L. Governing Law & Disputes</h4>
                        <p>This agreement shall be governed by and construed in accordance with the laws of India. Any disputes shall first be resolved through good-faith negotiation. If unresolved, disputes shall be subject to the exclusive jurisdiction of the courts in {{ $companyCity ?: 'the registered office location' }}.</p>
                    </div>
                </div>
            </div>

            {{-- ═══════════ ACCEPTANCE & PAYMENT ═══════════ --}}
            <div class="relative z-10 hidden-print">
                @if($isAccepted)
                    <div class="bg-green-500/10 border border-green-500/30 rounded-2xl p-6 text-center">
                        <i class="ti ti-circle-check text-green-400 text-4xl"></i>
                        <p class="text-green-400 font-bold text-lg mt-2">Agreement Accepted & Advance Paid</p>
                        <p class="text-animazon-muted text-sm mt-1">Accepted on {{ $estimate->accepted_at ? $estimate->accepted_at->format('M d, Y \a\t h:i A') : 'N/A' }}</p>
                    </div>
                @elseif($isExpired)
                    <div class="bg-red-500/10 border border-red-500/30 rounded-2xl p-6 text-center">
                        <i class="ti ti-clock-x text-red-400 text-4xl"></i>
                        <p class="text-red-400 font-bold text-lg mt-2">This Estimate Has Expired</p>
                        <p class="text-animazon-muted text-sm mt-1">Please contact us at <a href="mailto:{{ $companyEmail }}" class="text-primary">{{ $companyEmail }}</a> for a revised quote.</p>
                    </div>
                @else
                    <div class="bg-primary/5 border border-primary/20 rounded-2xl p-6 text-center">
                        <p class="text-animazon-muted text-xs mb-2">By clicking "Accept & Pay", you agree to the terms and conditions outlined above.</p>
                        <p class="text-animazon-white font-bold text-lg mb-1">Advance Payment: <span class="text-primary">₹{{ number_format($advanceInr, 0) }}</span></p>
                        <p class="text-animazon-muted text-xs mb-5">({{ $advancePercent }}% of {{ $currencyCode }} {{ number_format($estimate->grand_total, 2) }})</p>

                        @if(isset($razorpayKey) && $razorpayKey)
                            <button id="rzpPayBtn" class="inline-flex items-center gap-2 bg-gradient-to-r from-primary to-secondary text-white font-bold py-3 px-10 rounded-full hover:opacity-90 transition-all shadow-lg shadow-primary/25 text-lg">
                                <i class="ti ti-shield-check"></i> Accept & Pay ₹{{ number_format($advanceInr, 0) }} Advance
                            </button>
                        @else
                            <button onclick="alert('Payment Gateway Error: Razorpay Key is not configured on the server. Please contact support.')" class="inline-flex items-center gap-2 bg-animazon-black border border-red-500/50 text-red-400 font-bold py-3 px-10 rounded-full hover:bg-red-500/10 transition-all text-lg">
                                <i class="ti ti-alert-triangle"></i> Payment Gateway Offline
                            </button>
                        @endif
                        <p class="text-animazon-muted text-xs mt-3"><i class="ti ti-lock mr-1"></i>Secured by Razorpay. 256-bit SSL encrypted.</p>
                    </div>
                @endif
            </div>

            {{-- Print Button --}}
            <div class="mt-8 text-center relative z-10 hidden-print">
                <button onclick="window.print()" class="inline-flex items-center gap-2 bg-animazon-black border border-animazon-border/50 text-animazon-white font-semibold py-2 px-6 rounded-full hover:bg-animazon-black/80 transition-colors text-sm">
                    <i class="ti ti-printer"></i> Print / Save as PDF
                </button>
            </div>
        </div>

    </div>
</div>

<style>
    @media print {
        .hidden-print, nav, footer, .animazon-footer { display: none !important; }
        body { background: white !important; }
        .bg-animazon-navy { background-color: #ffffff !important; color: #000 !important; border: 1px solid #ddd; }
        .bg-animazon-black { background-color: #ffffff !important; }
        .text-animazon-white, .text-primary { color: #000 !important; }
        .text-animazon-muted { color: #555 !important; }
        .bg-primary\/5, .bg-animazon-black\/50, .bg-animazon-black\/30, .bg-animazon-black\/40 { background: #f9f9f9 !important; }
        .border-primary\/20, .border-animazon-border, .border-animazon-border\/30, .border-animazon-border\/50 { border-color: #ddd !important; }
    }
</style>

<!-- Razorpay Key Status: {{ $razorpayKey ? 'Loaded' : 'NOT FOUND' }} -->
@if(!$isAccepted && !$isExpired && isset($razorpayKey) && $razorpayKey)
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
    document.getElementById('rzpPayBtn').addEventListener('click', function () {
        var options = {
            key: "{{ $razorpayKey }}",
            amount: {{ $advanceInrPaise }},
            currency: "INR",
            name: "{{ $companyName }}",
            description: "{{ $advancePercent }}% Advance — {{ $estimateNumber }}",
            image: "{{ $logo . '/' . $companyLogo }}",
            handler: function (response) {
                // Submit payment to server
                var form = document.createElement('form');
                form.method = 'POST';
                form.action = "{{ route('cost-estimate.accept', $estimate->id) }}";

                var csrf = document.createElement('input');
                csrf.type = 'hidden'; csrf.name = '_token'; csrf.value = "{{ csrf_token() }}";
                form.appendChild(csrf);

                var payId = document.createElement('input');
                payId.type = 'hidden'; payId.name = 'razorpay_payment_id'; payId.value = response.razorpay_payment_id;
                form.appendChild(payId);

                var amt = document.createElement('input');
                amt.type = 'hidden'; amt.name = 'amount'; amt.value = "{{ $advanceInr }}";
                form.appendChild(amt);

                document.body.appendChild(form);
                form.submit();
            },
            prefill: {
                name: "{{ $estimate->visitor_name }}",
                email: "{{ $estimate->visitor_email }}",
                contact: "{{ $estimate->visitor_phone ?? '' }}"
            },
            theme: {
                color: "#00c1de"
            },
            modal: {
                ondismiss: function () {
                    console.log('Payment modal closed');
                }
            }
        };
        var rzp = new Razorpay(options);
        rzp.open();
    });
</script>
@endif
@endsection
