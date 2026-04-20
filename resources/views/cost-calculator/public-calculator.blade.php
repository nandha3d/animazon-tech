@extends('layouts.landing')

@section('page_content')
<section class="py-12 bg-animazon-black text-animazon-white min-h-screen">
    <div class="container mx-auto px-4 lg:px-8">

        {{-- Breadcrumb + Service Nav --}}
        <div class="flex flex-wrap items-center gap-2 text-sm mb-8">
            <a href="{{ url('/pricing') }}" class="text-animazon-muted hover:text-primary transition-colors flex items-center gap-1">
                <i class="ti ti-arrow-left"></i> All Services
            </a>
            <span class="text-animazon-border">/</span>
            <span class="text-animazon-muted">{{ $projectType->parent->name ?? '' }}</span>
            <span class="text-animazon-border">/</span>
            <span class="text-primary font-semibold">{{ $projectType->name }}</span>
        </div>

        {{-- Service siblings tabs --}}
        <div class="flex flex-wrap gap-2 mb-8 pb-4 border-b border-animazon-border/30">
            @foreach($siblings as $sib)
                <a href="{{ url('/pricing/' . $sib->id . '?country=' . request('country', 'US')) }}"
                   class="px-4 py-2 rounded-lg text-sm font-medium transition-all
                          {{ $sib->id == $projectType->id
                              ? 'bg-primary text-white'
                              : 'bg-animazon-navy text-animazon-muted hover:text-animazon-white hover:bg-animazon-navy/80 border border-animazon-border/30' }}">
                    {{ $sib->name }}
                </a>
            @endforeach
        </div>

        {{-- Main Grid: Questions + Sidebar --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            {{-- Left: Questions Panel --}}
            <div class="lg:col-span-2">
                {{-- Service Title --}}
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-12 h-12 rounded-xl bg-primary/10 border border-primary/30 flex items-center justify-center text-primary text-xl">
                        <i class="{{ $projectType->icon }}"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl md:text-3xl font-bold text-animazon-white">{{ $projectType->name }}</h1>
                        <p class="text-animazon-muted text-sm">{{ $projectType->description }}</p>
                    </div>
                </div>

                {{-- Progress Bar --}}
                <div class="mb-6">
                    <div class="flex justify-between items-center text-xs text-animazon-muted mb-2">
                        <span id="stepLabel">Step 1 of {{ count($questions) }}</span>
                        <span id="progressPct" class="font-mono text-primary">{{ count($questions) > 0 ? round(100 / (count($questions) + 1)) : 0 }}%</span>
                    </div>
                    <div class="w-full h-2 bg-animazon-navy rounded-full overflow-hidden shadow-inner shadow-black/50">
                        <div id="progressBar" class="h-full rounded-full bg-gradient-to-r from-primary to-secondary transition-all duration-500 shadow-[0_0_10px_theme('colors.primary')]"
                             style="width: {{ count($questions) > 0 ? round(100 / (count($questions) + 1)) : 0 }}%"></div>
                    </div>
                </div>

                {{-- Questions --}}
                <div id="questionsContainer">
                    @foreach($questions as $index => $question)
                        <div class="question-step bg-animazon-navy border border-animazon-border/30 rounded-2xl p-6 md:p-8 {{ $index > 0 ? 'hidden' : '' }}"
                             data-step="{{ $index }}"
                             data-question-id="{{ $question->id }}"
                             data-question-type="{{ $question->type }}">

                            <div class="mb-6">
                                @if($question->category)
                                    <span class="inline-block px-3 py-0.5 rounded-full bg-primary/20 text-primary text-xs font-bold uppercase mb-3">{{ $question->category }}</span>
                                @endif
                                <h2 class="text-xl md:text-2xl font-bold text-animazon-white">
                                    {{ $question->question }}
                                    @if($question->required)<span class="text-secondary">*</span>@endif
                                </h2>
                                @if($question->description)
                                    <p class="text-animazon-muted text-sm mt-2">{{ $question->description }}</p>
                                @endif
                            </div>

                            <div class="space-y-3">
                                @foreach($question->answers as $answer)
                                    <label class="answer-option group block cursor-pointer border border-animazon-border/30 rounded-xl p-4 hover:border-primary/50 transition-all duration-200"
                                           data-answer-id="{{ $answer->id }}"
                                           data-multiplier="{{ $answer->cost_multiplier }}"
                                           data-additional="{{ $answer->additional_cost }}"
                                           data-answer-text="{{ $answer->answer_text }}"
                                           data-is-enterprise="{{ $answer->is_enterprise ? 'true' : 'false' }}">
                                        <div class="flex items-start gap-3">
                                            @if($question->type === 'multi_select')
                                                <input type="checkbox"
                                                       name="q_{{ $question->id }}[]"
                                                       value="{{ $answer->id }}"
                                                       class="mt-1 w-4 h-4 rounded border-animazon-border text-primary focus:ring-primary bg-animazon-black">
                                            @elseif($question->type === 'input')
                                                <div class="flex flex-col gap-2">
                                                    <input type="number" 
                                                           name="q_{{ $question->id }}" 
                                                           min="1" 
                                                           value="1"
                                                           data-answer-id="{{ $answer->id }}"
                                                           class="w-24 bg-animazon-black border border-animazon-border/50 rounded-lg px-3 py-2 text-animazon-white focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">
                                                </div>
                                            @else
                                                <input type="radio"
                                                       name="q_{{ $question->id }}"
                                                       value="{{ $answer->id }}"
                                                       class="mt-1 w-4 h-4 border-animazon-border text-primary focus:ring-primary bg-animazon-black">
                                            @endif
                                            <div class="flex-1 <?php echo ($question->type === 'input') ? 'mt-2' : ''; ?>">
                                                <div class="flex items-center justify-between">
                                                    <div class="flex items-center gap-2">
                                                        <span class="font-semibold text-animazon-white group-hover:text-primary transition-colors">
                                                            {{ $answer->answer_text }}
                                                        </span>
                                                        @if($answer->is_included)
                                                            <span class="bg-primary/20 text-primary text-[10px] px-2 py-0.5 rounded uppercase tracking-wider font-bold">Included</span>
                                                        @endif
                                                        @if($answer->is_enterprise)
                                                            <span class="bg-secondary/20 text-secondary text-[10px] px-2 py-0.5 rounded uppercase tracking-wider font-bold"><i class="ti ti-building"></i> Custom Quote</span>
                                                        @endif
                                                    </div>
                                                    @if(!$answer->is_included && !$answer->is_enterprise)
                                                        @if($answer->cost_multiplier != 1.0)
                                                            <span class="text-xs text-primary/80 font-mono">×{{ $answer->cost_multiplier }}</span>
                                                        @endif

                                                        @if($answer->additional_cost > 0)
                                                            <span class="text-xs text-secondary font-mono additional-cost-tag"
                                                                  data-usd="{{ $answer->additional_cost }}">
                                                                +${{ number_format($answer->additional_cost, 0) }}
                                                            </span>
                                                        @endif
                                                    @endif
                                                </div>
                                                @if($answer->explanation)
                                                    <p class="text-animazon-muted text-xs mt-1">{{ $answer->explanation }}</p>
                                                @endif
                                                {{-- Contextual Insight --}}
                                                @if($answer->insight)
                                                    <div class="mt-2 bg-blue-50 border border-blue-200 rounded-lg px-3 py-2 text-xs text-blue-900 font-medium leading-relaxed insight-box hidden">
                                                        <i class="ti ti-bulb mr-1 text-amber-500 text-sm"></i> {{ $answer->insight }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endforeach

                    {{-- Submission Step (hidden by default) --}}
                    <div class="question-step hidden bg-animazon-navy border border-animazon-border/30 rounded-2xl p-6 md:p-8"
                         data-step="{{ count($questions) }}" id="submitStep">
                        @if($projectType->base_cost == 0)
                            <div class="mb-6 bg-primary/10 border border-primary/30 p-5 rounded-xl">
                                <span class="inline-block px-3 py-0.5 rounded-full bg-secondary/20 text-secondary text-xs font-bold uppercase mb-3">CUSTOM PROJECT</span>
                                <h2 class="text-xl md:text-2xl font-bold text-animazon-white mb-2"><i class="ti ti-star"></i> Custom Project Estimation</h2>
                                <p class="text-sm text-animazon-white mb-2">Our custom development rate is <strong><span id="customRateText">$15/hr</span></strong>.</p>
                                <p class="text-sm text-animazon-muted">Please provide a detailed project description below. Our team will review your requirements and get back to you with a comprehensive proposal and estimated hours within <strong>24 hours</strong>.</p>
                            </div>
                        @else
                            <div class="mb-6">
                                <span class="inline-block px-3 py-0.5 rounded-full bg-secondary/20 text-secondary text-xs font-bold uppercase mb-3">ALMOST DONE</span>
                                <h2 class="text-xl md:text-2xl font-bold text-animazon-white">Get Your Detailed Estimate</h2>
                                <p class="text-animazon-muted text-sm mt-2">Enter your details and we'll send you a complete proposal within 24 hours.</p>
                            </div>
                        @endif
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-animazon-muted mb-1">Your Name *</label>
                                <input type="text" id="visitorName" required
                                       class="w-full bg-animazon-black border border-animazon-border/50 rounded-xl px-4 py-3 text-animazon-white focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all"
                                       placeholder="John Doe">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-animazon-muted mb-1">Email Address *</label>
                                <input type="email" id="visitorEmail" required
                                       class="w-full bg-animazon-black border border-animazon-border/50 rounded-xl px-4 py-3 text-animazon-white focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all"
                                       placeholder="john@company.com">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-animazon-muted mb-1">Phone (optional)</label>
                                <input type="tel" id="visitorPhone"
                                       class="w-full bg-animazon-black border border-animazon-border/50 rounded-xl px-4 py-3 text-animazon-white focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all"
                                       placeholder="+1 555 000 0000">
                            </div>
                            <div>
                                @if($projectType->base_cost == 0)
                                    <label class="block text-sm font-medium text-animazon-muted mb-1">Project Description *</label>
                                    <textarea id="visitorNotes" rows="4" required
                                              class="w-full bg-animazon-black border border-animazon-border/50 rounded-xl px-4 py-3 text-animazon-white focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all resize-none"
                                              placeholder="Please describe your project requirements in detail..."></textarea>
                                @else
                                    <label class="block text-sm font-medium text-animazon-muted mb-1">Additional Notes</label>
                                    <textarea id="visitorNotes" rows="3"
                                              class="w-full bg-animazon-black border border-animazon-border/50 rounded-xl px-4 py-3 text-animazon-white focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all resize-none"
                                              placeholder="Tell us more about your project..."></textarea>
                                @endif
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-animazon-muted mb-1">Project Reference Document (Optional)</label>
                                <input type="file" id="visitorDocument" accept=".pdf,.doc,.docx,.zip,.jpeg,.png,.jpg"
                                       class="w-full bg-animazon-black border border-animazon-border/50 rounded-xl px-4 py-3 text-animazon-white focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary/20 file:text-primary hover:file:bg-primary/30">
                            </div>

                            {{-- Terms & Conditions --}}
                            <div class="mt-4 p-4 bg-animazon-black/50 border border-animazon-border/20 rounded-xl">
                                <label class="flex items-start gap-3 cursor-pointer group">
                                    <input type="checkbox" id="agreeTerms"
                                           class="mt-0.5 w-5 h-5 rounded border-animazon-border text-primary focus:ring-primary bg-animazon-black flex-shrink-0">
                                    <span class="text-sm text-animazon-muted group-hover:text-animazon-white transition-colors">
                                        I agree to the 
                                        <a href="{{ route('terms') }}" target="_blank" class="text-primary hover:underline font-semibold">Terms & Conditions</a>
                                        including the scope, payment, revision, and cancellation policies.
                                        <span class="text-secondary">*</span>
                                    </span>
                                </label>
                                <p id="termsError" class="hidden text-xs text-red-400 mt-2 ml-8">
                                    <i class="ti ti-alert-circle mr-1"></i> You must agree to the Terms & Conditions before submitting.
                                </p>
                            </div>

                            {{-- Honeypot Anti-Spam --}}
                            <div id="honeypotWrapper" class="hidden">
                                @honeypot
                            </div>
                        </div>
                    </div>

                    {{-- Success Message (hidden) --}}
                    <div id="successMessage" class="hidden bg-animazon-navy border border-primary/30 rounded-2xl p-8 md:p-12 text-center">
                        <div class="w-20 h-20 bg-primary/20 rounded-full flex items-center justify-center mx-auto mb-6">
                            <i class="ti ti-check text-4xl text-primary"></i>
                        </div>
                        <h2 class="text-2xl font-bold text-animazon-white mb-3">Estimate Submitted!</h2>
                        <p class="text-animazon-muted mb-6">Thank you! We'll review your requirements and get back to you within 24 hours with a detailed proposal.</p>
                        <a href="{{ url('/pricing') }}" class="btn-primary-custom">
                            <i class="ti ti-arrow-left mr-2"></i> Back to Services
                        </a>
                    </div>
                </div>

                {{-- Navigation Buttons --}}
                <div id="navButtons" class="flex justify-between mt-6">
                    <button id="prevBtn" onclick="prevStep()"
                            class="px-6 py-3 rounded-xl bg-animazon-navy border border-animazon-border/30 text-animazon-muted hover:text-animazon-white hover:border-animazon-border transition-all flex items-center gap-2 hidden">
                        <i class="ti ti-arrow-left"></i> Previous
                    </button>
                    <div class="ml-auto flex gap-3">
                        <a href="{{ url('/pricing') }}" id="backToServices"
                           class="px-6 py-3 rounded-xl bg-animazon-navy border border-animazon-border/30 text-animazon-muted hover:text-animazon-white hover:border-animazon-border transition-all flex items-center gap-2">
                            <i class="ti ti-arrow-left"></i> All Services
                        </a>
                        <button id="nextBtn" onclick="nextStep()"
                                class="px-6 py-3 rounded-xl bg-primary text-white font-semibold hover:opacity-90 transition-all flex items-center gap-2">
                            Next <i class="ti ti-arrow-right"></i>
                        </button>
                        <button id="submitBtn" onclick="submitEstimate()"
                                class="px-6 py-3 rounded-xl bg-secondary text-white font-semibold hover:opacity-90 transition-all flex items-center gap-2 hidden">
                            <i class="ti ti-send mr-1"></i> Submit Estimate
                        </button>
                    </div>
                </div>
            </div>

            {{-- Right: Live Estimate Sidebar --}}
            <div class="lg:col-span-1">
                <div class="sticky top-24 bg-animazon-navy border border-animazon-border/30 rounded-2xl p-6 space-y-5">
                    <div class="flex items-center justify-between">
                        <h3 class="font-bold text-animazon-white text-lg">Live Estimate</h3>
                        <span class="text-xs text-primary flex items-center gap-1">
                            <span class="w-2 h-2 bg-primary rounded-full animate-pulse"></span> Updating
                        </span>
                    </div>

                    {{-- Country Selector in Sidebar --}}
                    <div>
                        <label class="block text-xs text-animazon-muted mb-1">
                            <i class="ti ti-map-pin mr-1"></i>Currency
                        </label>
                        <select id="sidebarCountrySelect"
                                class="w-full bg-animazon-black border border-animazon-border/50 rounded-lg px-3 py-2 text-sm text-animazon-white focus:border-primary outline-none transition-all appearance-none cursor-pointer"
                                onchange="changeCurrency(this.value)">
                            @foreach($countries as $code => $name)
                                <option value="{{ $code }}" {{ $code === request('country', 'US') ? 'selected' : '' }}>
                                    {{ $currencies[$code]['symbol'] }} {{ $currencies[$code]['code'] }} — {{ $name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Project Info --}}
                    <div class="flex items-center gap-3 bg-animazon-black/50 rounded-xl p-3">
                        <div class="w-9 h-9 rounded-lg bg-primary/10 flex items-center justify-center text-primary">
                            <i class="{{ $projectType->icon }}"></i>
                        </div>
                        <div>
                            <p class="text-[10px] uppercase tracking-wider text-animazon-muted">Project Type</p>
                            <p class="text-sm font-bold text-animazon-white">{{ $projectType->name }}</p>
                        </div>
                    </div>

                    {{-- Cost Breakdown --}}
                    <div class="space-y-2 text-sm">
                        @if($projectType->base_cost == 0)
                            <div class="flex justify-between">
                                <span class="text-animazon-muted">Hourly Rate</span>
                                <span class="text-animazon-white font-semibold" id="sidebarHourlyRate" data-usd="15">
                                    $15/hr
                                </span>
                            </div>
                        @else
                            <div class="flex justify-between">
                                <span class="text-animazon-muted">Base Cost</span>
                                <span class="text-animazon-white font-semibold" id="sidebarBaseCost"
                                      data-usd="{{ $projectType->base_cost }}">
                                    ${{ number_format($projectType->base_cost, 0) }}
                                </span>
                            </div>
                        @endif
                        <div id="breakdownList" class="space-y-1">
                            {{-- Dynamically filled --}}
                        </div>
                    </div>

                    @if($projectType->base_cost > 0)
                        <p id="answerHint" class="text-animazon-muted text-xs italic">Answer questions to see cost breakdown</p>

                        {{-- Total --}}
                        <div class="bg-animazon-black/50 rounded-xl p-4 text-center">
                            <p class="text-[10px] uppercase tracking-wider text-animazon-muted mb-1">ESTIMATED TOTAL</p>
                            <p class="text-3xl font-bold text-primary" id="sidebarTotal"
                               data-usd="{{ $projectType->base_cost }}">
                                ${{ number_format($projectType->base_cost, 0) }}
                            </p>
                            <p class="text-[10px] text-animazon-muted mt-1" id="currencyLabel">USD</p>
                        </div>
                    @else
                        <div class="bg-primary/10 rounded-xl p-4 text-center border border-primary/20">
                            <p class="text-xs text-primary mb-1">Custom Requirement</p>
                            <p class="text-sm text-animazon-muted">Estimated after consultation</p>
                        </div>
                    @endif

                    {{-- Timeline & Team --}}
                    <div class="grid grid-cols-2 gap-3">
                        <div class="bg-animazon-black/50 rounded-xl p-3 text-center">
                            <i class="ti ti-calendar text-primary text-lg"></i>
                            <p class="text-lg font-bold text-animazon-white mt-1" id="sidebarWeeks">—</p>
                            <p class="text-[10px] text-animazon-muted">Weeks</p>
                        </div>
                        <div class="bg-animazon-black/50 rounded-xl p-3 text-center">
                            <i class="ti ti-users text-primary text-lg"></i>
                            <p class="text-lg font-bold text-animazon-white mt-1" id="sidebarTeam">—</p>
                            <p class="text-[10px] text-animazon-muted">Team Size</p>
                        </div>
                    </div>

                    <p class="text-[10px] text-animazon-muted leading-relaxed">
                        * This is an estimate based on typical project requirements. Final pricing may vary after detailed consultation. No hosting included.
                    </p>
                </div>
            </div>

        </div>
    </div>
</section>
@endsection

@section('page_scripts')
<script>
    // ─── State ───────────────────────────────────────────────────
    const projectTypeId = {{ $projectType->id }};
    const baseCostUsd = {{ $projectType->base_cost }};
    const totalSteps = {{ count($questions) }};
    const currencyMap = @json($currencies);

    let currentStep = 0;
    let selectedAnswers = {};
    let hasEnterprise = false;
    let currentCountry = '{{ request("country", "US") }}';

    // Restore from localStorage
    const saved = localStorage.getItem('animazon_country');
    if (saved && currencyMap[saved]) {
        currentCountry = saved;
        const sel = document.getElementById('sidebarCountrySelect');
        if (sel) sel.value = currentCountry;
    }

    // ─── Currency ────────────────────────────────────────────────
    function getCurrency() {
        return currencyMap[currentCountry] || currencyMap['US'];
    }

    function formatPrice(usd) {
        const c = getCurrency();
        const local = usd * c.rate;
        const noDecimal = ['JPY','KRW','NGN','PKR','BDT','LKR','KES','PHP','THB','INR','EGP'];
        const dec = noDecimal.includes(c.code) ? 0 : 0;
        return c.symbol + local.toLocaleString('en-US', { minimumFractionDigits: dec, maximumFractionDigits: dec });
    }

    const isCustom = {{ $projectType->base_cost == 0 ? 'true' : 'false' }};

    function changeCurrency(countryCode) {
        currentCountry = countryCode;
        localStorage.setItem('animazon_country', countryCode);

        const c = getCurrency();

        // Always update sidebar base cost and total
        if (!isCustom) {
            document.getElementById('sidebarBaseCost').textContent = formatPrice(baseCostUsd);
            document.getElementById('currencyLabel').textContent = c.code;
        } else {
            // Render the hourly rate!
            let hrDisplay = "";
            if (c.code === 'INR') {
                hrDisplay = "₹1,200/hr";
            } else {
                hrDisplay = c.symbol + Math.round(15 * c.rate).toLocaleString('en-US') + '/hr';
            }
            const customRateExt = document.getElementById('customRateText');
            if (customRateExt) customRateExt.textContent = hrDisplay;
            const sidebarRate = document.getElementById('sidebarHourlyRate');
            if (sidebarRate) sidebarRate.textContent = hrDisplay;
        }

        // Update additional cost tags on answer options
        document.querySelectorAll('.additional-cost-tag').forEach(el => {
            const usd = parseFloat(el.dataset.usd);
            el.textContent = '+' + formatPrice(usd);
        });

        // If answers exist, do a full recalculate (which updates total)
        if (Object.keys(selectedAnswers).length > 0) {
            recalculate();
        } else {
            // No answers yet — total = base cost
            document.getElementById('sidebarTotal').textContent = formatPrice(baseCostUsd);
            document.getElementById('sidebarTotal').dataset.usd = baseCostUsd;
        }
    }

    // ─── Navigation ──────────────────────────────────────────────
    function showStep(step) {
        document.querySelectorAll('.question-step').forEach(el => el.classList.add('hidden'));
        const target = document.querySelector(`.question-step[data-step="${step}"]`);
        if (target) target.classList.remove('hidden');

        // Update progress
        const pct = Math.round(((step + 1) / (totalSteps + 1)) * 100);
        document.getElementById('progressBar').style.width = pct + '%';
        document.getElementById('progressPct').textContent = pct + '%';

        if (step < totalSteps) {
            document.getElementById('stepLabel').textContent = `Step ${step + 1} of ${totalSteps}`;
        } else {
            document.getElementById('stepLabel').textContent = 'Final Step';
        }

        // Button visibility
        document.getElementById('prevBtn').classList.toggle('hidden', step === 0);
        document.getElementById('backToServices').classList.toggle('hidden', step > 0);
        document.getElementById('nextBtn').classList.toggle('hidden', step >= totalSteps);
        document.getElementById('submitBtn').classList.toggle('hidden', step < totalSteps);
    }

    function nextStep() {
        if (currentStep < totalSteps) {
            currentStep++;
            showStep(currentStep);
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
    }

    function prevStep() {
        if (currentStep > 0) {
            currentStep--;
            showStep(currentStep);
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
    }

    // ─── Answer Selection ────────────────────────────────────────
    // ─── Answer Selection ────────────────────────────────────────
    document.querySelectorAll('.answer-option input').forEach(input => {
        const handler = function () {
            const step = this.closest('.question-step');
            const qId = step.dataset.questionId;
            const qType = step.dataset.questionType;

            if (qType === 'multi_select') {
                const checked = step.querySelectorAll('input[type="checkbox"]:checked');
                selectedAnswers[qId] = Array.from(checked).map(c => c.value);
            } else if (qType === 'input') {
                const numInput = step.querySelector(`input[type="number"]`);
                if (numInput && numInput.value) {
                    selectedAnswers[qId] = { value: numInput.value, answerId: numInput.dataset.answerId };
                    step.querySelectorAll('.answer-option').forEach(opt =>
                        opt.classList.remove('!border-primary', 'bg-primary/5'));
                    numInput.closest('.answer-option').classList.add('!border-primary', 'bg-primary/5');
                } else {
                    delete selectedAnswers[qId];
                    step.querySelectorAll('.answer-option').forEach(opt =>
                        opt.classList.remove('!border-primary', 'bg-primary/5'));
                }
            } else {
                selectedAnswers[qId] = this.value;
                // Highlight selected
                step.querySelectorAll('.answer-option').forEach(opt =>
                    opt.classList.remove('!border-primary', 'bg-primary/5'));
                this.closest('.answer-option').classList.add('!border-primary', 'bg-primary/5');
            }

            // Also highlight checkboxes
            if (qType === 'multi_select') {
                step.querySelectorAll('.answer-option').forEach(opt => {
                    const cb = opt.querySelector('input[type="checkbox"]');
                    if (cb) {
                        opt.classList.toggle('!border-primary', cb.checked);
                        opt.classList.toggle('bg-primary/5', cb.checked);
                    }
                });
            }

            // Check if any enterprise option is selected across all steps
            hasEnterprise = Array.from(document.querySelectorAll('.answer-option.bg-primary\\/5, .answer-option.\\!border-primary')).some(opt => opt.dataset.isEnterprise === 'true');

            // Show/hide insight boxes based on selection
            step.querySelectorAll('.answer-option').forEach(opt => {
                const insightBox = opt.querySelector('.insight-box');
                if (!insightBox) return;
                const isSelected = opt.classList.contains('!border-primary') || opt.classList.contains('bg-primary/5');
                insightBox.classList.toggle('hidden', !isSelected);
            });

            recalculate();
        };

        input.addEventListener('change', handler);
        if (input.type === 'number') {
            input.addEventListener('input', handler);
        }
    });

    // ─── Recalculate ─────────────────────────────────────────────
    function recalculate() {
        if (Object.keys(selectedAnswers).length === 0) return;

        fetch('{{ url("/pricing/calculate") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
            body: JSON.stringify({
                project_type_id: projectTypeId,
                answers: selectedAnswers,
                country_code: currentCountry,
            }),
        })
        .then(r => r.json())
        .then(data => {
            if (!data.success) return;

            const c = getCurrency();

            // Update sidebar
            document.getElementById('sidebarBaseCost').textContent = formatPrice(data.base_cost_usd);
            
            if (hasEnterprise || isCustom) {
                document.getElementById('sidebarTotal').textContent = 'Custom Quote';
                document.getElementById('currencyLabel').textContent = 'Consultation Required';
                document.getElementById('sidebarWeeks').textContent = '—';
                document.getElementById('sidebarTeam').textContent = '—';
                
                // Also update the final step title
                const submitHeadline = document.querySelector('#submitStep h2');
                if(submitHeadline) submitHeadline.textContent = 'Request Custom Quote';
            } else {
                document.getElementById('sidebarTotal').textContent = formatPrice(data.total_cost_usd);
                document.getElementById('currencyLabel').textContent = c.code;
                document.getElementById('sidebarWeeks').textContent = data.timeline_weeks;
                document.getElementById('sidebarTeam').textContent = data.team_size;
                
                const submitHeadline = document.querySelector('#submitStep h2');
                if(submitHeadline) submitHeadline.textContent = 'Get Your Detailed Estimate';
            }
            document.getElementById('sidebarTotal').dataset.usd = data.total_cost_usd;

            // Build breakdown
            const list = document.getElementById('breakdownList');
            list.innerHTML = '';
            document.getElementById('answerHint').classList.add('hidden');

            data.cost_breakdown.forEach(item => {
                const div = document.createElement('div');
                div.className = 'flex justify-between text-xs py-1 border-b border-animazon-border/20';
                let detail = '';
                if (item.multiplier !== 1.0) detail = `×${item.multiplier}`;
                if (item.additional_cost > 0) detail = `+${formatPrice(item.additional_cost)}`;
                div.innerHTML = `
                    <span class="text-animazon-muted truncate mr-2">${item.answer}</span>
                    <span class="text-primary whitespace-nowrap">${detail}</span>
                `;
                list.appendChild(div);
            });
        })
        .catch(err => console.error('Calc error:', err));
    }

    // ─── Submit ──────────────────────────────────────────────────
    function submitEstimate() {
        const name = document.getElementById('visitorName').value.trim();
        const email = document.getElementById('visitorEmail').value.trim();
        const notes = document.getElementById('visitorNotes').value.trim();
        const isCustom = {{ $projectType->base_cost == 0 ? 'true' : 'false' }};

        if (!name || !email) {
            alert('Please enter your name and email address.');
            return;
        }

        if (isCustom && !notes) {
            alert('Please provide a detailed project description.');
            return;
        }

        // T&C validation
        const agreeBox = document.getElementById('agreeTerms');
        const termsErr = document.getElementById('termsError');
        if (!agreeBox.checked) {
            termsErr.classList.remove('hidden');
            agreeBox.closest('label').classList.add('!border-red-500/50');
            agreeBox.focus();
            return;
        }
        termsErr.classList.add('hidden');
        agreeBox.closest('label').classList.remove('!border-red-500/50');

        const btn = document.getElementById('submitBtn');
        btn.disabled = true;
        btn.innerHTML = '<i class="ti ti-loader animate-spin mr-1"></i> Submitting...';

        const totalUsd = parseFloat(document.getElementById('sidebarTotal').dataset.usd) || baseCostUsd;
        const c = getCurrency();

        const formData = new FormData();
        formData.append('project_type_id', projectTypeId);
        formData.append('visitor_name', name);
        formData.append('visitor_email', email);
        formData.append('visitor_phone', document.getElementById('visitorPhone').value.trim());
        formData.append('notes', document.getElementById('visitorNotes').value.trim());
        formData.append('total_cost', totalUsd);
        formData.append('grand_total', totalUsd);
        formData.append('currency_code', c.code);
        formData.append('country_code', currentCountry);
        
        if (document.getElementById('sidebarWeeks')) {
            formData.append('timeline_weeks', parseInt(document.getElementById('sidebarWeeks').textContent) || '');
        }
        if (document.getElementById('sidebarTeam')) {
            formData.append('team_size', parseInt(document.getElementById('sidebarTeam').textContent) || '');
        }

        // Handle Object to nested FormData Array
        Object.keys(selectedAnswers).forEach(key => {
            if (Array.isArray(selectedAnswers[key])) {
                selectedAnswers[key].forEach(val => formData.append(`answers[${key}][]`, val));
            } else {
                formData.append(`answers[${key}]`, selectedAnswers[key]);
            }
        });

        // Add File
        const docInput = document.getElementById('visitorDocument');
        if (docInput && docInput.files.length > 0) {
            formData.append('document', docInput.files[0]);
        }

        // T&C agreement
        formData.append('agree_terms', '1');

        // Append honeypot fields explicitly
        const honeypotInputs = document.querySelectorAll('#honeypotWrapper input');
        honeypotInputs.forEach(input => {
            formData.append(input.name, input.value);
        });

        fetch('{{ url("/pricing/submit") }}', {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: formData,
        })
        .then(async r => {
            const data = await r.json();
            if (!r.ok) { throw new Error(data.message || 'Validation failed'); }
            return data;
        })
        .then(data => {
            if (data.success) {
                document.getElementById('questionsContainer').querySelectorAll('.question-step').forEach(el => el.classList.add('hidden'));
                document.getElementById('successMessage').classList.remove('hidden');
                document.getElementById('navButtons').classList.add('hidden');
            } else {
                alert(data.message || 'Something went wrong. Please try again.');
                btn.disabled = false;
                btn.innerHTML = '<i class="ti ti-send mr-1"></i> Submit Estimate';
            }
        })
        .catch(() => {
            alert('Network error. Please try again.');
            btn.disabled = false;
            btn.innerHTML = '<i class="ti ti-send mr-1"></i> Submit Estimate';
        });
    }

    // ─── Init ────────────────────────────────────────────────────
    document.addEventListener('DOMContentLoaded', () => {
        showStep(0);
        changeCurrency(currentCountry);
    });
</script>
@endsection
