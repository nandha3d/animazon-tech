@extends('layouts.landing')

@section('page_title', 'Project Estimate Document')

@section('content')
<div class="bg-animazon-bg min-h-screen py-16">
    <div class="container mx-auto px-4 max-w-4xl">
        
        <div class="bg-animazon-navy border border-animazon-border rounded-3xl p-8 md:p-12 shadow-2xl relative overflow-hidden">
            <!-- Decorative Elements -->
            <div class="absolute top-0 right-0 w-64 h-64 bg-primary/10 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>
            
            <!-- Header -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center border-b border-animazon-border pb-8 mb-8 relative z-10">
                <div>
                    <img src="{{ \App\Models\Utility::get_file('uploads/logo/logo-dark.png') }}" alt="Animazon Logo" class="h-12 mb-4">
                    <h1 class="text-3xl font-bold text-animazon-white">Project Estimate</h1>
                    <p class="text-animazon-muted">Estimate #EST-{{ str_pad($estimate->id, 5, '0', STR_PAD_LEFT) }}</p>
                </div>
                <div class="mt-6 md:mt-0 text-left md:text-right">
                    <p class="text-animazon-white font-medium">{{ $settings['company_name'] ?? 'Animazon' }}</p>
                    <p class="text-animazon-muted text-sm">{{ $settings['company_address'] ?? '' }}</p>
                    <p class="text-animazon-muted text-sm">{{ $settings['company_city'] ?? '' }} {{ $settings['company_country'] ?? '' }}</p>
                    <p class="text-primary text-sm mt-2 font-medium">{{ env('ESTIMATE_NOTIFY_EMAIL', 'info@animazon.in') }}</p>
                </div>
            </div>

            <!-- Client Info -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8 relative z-10">
                <div class="bg-animazon-bg/50 rounded-2xl p-6 border border-animazon-border/50">
                    <h3 class="text-sm uppercase tracking-wider text-animazon-muted font-semibold mb-4">Prepared For</h3>
                    <p class="text-animazon-white font-bold text-lg">{{ $estimate->visitor_name }}</p>
                    <p class="text-animazon-muted">{{ $estimate->visitor_email }}</p>
                    @if($estimate->visitor_phone)
                    <p class="text-animazon-muted">{{ $estimate->visitor_phone }}</p>
                    @endif
                </div>
                <div class="bg-animazon-bg/50 rounded-2xl p-6 border border-animazon-border/50">
                    <h3 class="text-sm uppercase tracking-wider text-animazon-muted font-semibold mb-4">Project Details</h3>
                    <p class="text-animazon-white font-bold text-lg">{{ $estimate->projectType->name ?? 'Project' }}</p>
                    <p class="text-animazon-muted">Created: {{ $estimate->created_at->format('M d, Y') }}</p>
                    <p class="text-animazon-muted">Valid Until: {{ $estimate->created_at->addDays(30)->format('M d, Y') }}</p>
                </div>
            </div>

            <!-- Line Items -->
            <div class="mb-10 relative z-10">
                <h3 class="text-xl font-bold text-animazon-white mb-6">Requirements Breakdown</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-animazon-border text-animazon-muted text-sm uppercase tracking-wider">
                                <th class="pb-3 font-medium">Requirement / Question</th>
                                <th class="pb-3 font-medium text-right">Selection</th>
                            </tr>
                        </thead>
                        <tbody class="text-animazon-white">
                            @foreach($estimate->answers as $ans)
                            <tr class="border-b border-animazon-border/50 hover:bg-animazon-bg/30 transition-colors">
                                <td class="py-4 pr-4">{{ $ans->question->question ?? 'Question' }}</td>
                                <td class="py-4 text-right text-primary font-medium">
                                    {{ $ans->answer_id ? ($ans->answerDef->answer ?? 'Selected') : $ans->answer_value }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Summary & Totals -->
            <div class="flex flex-col md:flex-row justify-between items-start pt-6 border-t border-animazon-border relative z-10">
                <div class="mb-8 md:mb-0 max-w-md">
                    <h4 class="text-animazon-white font-semibold mb-2">Notes</h4>
                    <p class="text-sm text-animazon-muted">{{ $estimate->notes ?: 'No additional notes provided.' }}</p>
                    
                    <div class="mt-6 flex items-center gap-4 text-sm text-animazon-muted">
                        <div class="flex items-center gap-2"><i class="ti ti-calendar text-primary"></i> Timeline: ~{{ $estimate->timeline_weeks }} Weeks</div>
                        <div class="flex items-center gap-2"><i class="ti ti-users text-primary"></i> Team: {{ $estimate->team_size }} Experts</div>
                    </div>
                </div>

                <div class="w-full md:w-auto bg-primary/10 rounded-2xl p-6 border border-primary/20 min-w-[300px]">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-animazon-muted">Estimated Base</span>
                        <span class="text-animazon-white">{{ $estimate->currency_code }} {{ number_format($estimate->base_cost, 2) }}</span>
                    </div>
                    <div class="flex justify-between items-center pt-4 border-t border-primary/20 mt-2">
                        <span class="text-lg font-bold text-animazon-white">Estimated Total</span>
                        <span class="text-2xl font-black text-primary">{{ $estimate->currency_code }} {{ number_format($estimate->grand_total, 2) }}</span>
                    </div>
                    <p class="text-xs text-animazon-muted mt-4 text-center">This is an approximate estimate and not a final binding quote.</p>
                </div>
            </div>

            <!-- Print Button -->
            <div class="mt-12 text-center relative z-10 hidden-print">
                <button onclick="window.print()" class="bg-animazon-white text-animazon-bg font-bold py-3 px-8 rounded-full hover:bg-gray-200 transition-colors inline-flex items-center gap-2 shadow-lg">
                    <i class="ti ti-printer"></i> Print / Save as PDF
                </button>
            </div>
        </div>
        
    </div>
</div>

<style>
    @media print {
        .hidden-print, header, footer { display: none !important; }
        .bg-animazon-navy { background-color: #ffffff !important; color: #000 !important; border: 1px solid #ddd; }
        .text-animazon-white { color: #000 !important; }
        .text-animazon-muted { color: #555 !important; }
        body { background: white; }
    }
</style>
@endsection
