@extends('layouts.landing')

@section('page_content')
<section class="py-16 bg-animazon-black text-animazon-white min-h-screen relative overflow-hidden">
    {{-- Background glow accents --}}
    <div class="absolute -top-[20%] -right-[10%] w-[600px] h-[600px] bg-primary/5 rounded-full blur-[120px] pointer-events-none"></div>
    <div class="absolute -bottom-[10%] -left-[10%] w-[400px] h-[400px] bg-secondary/5 rounded-full blur-[100px] pointer-events-none"></div>

    <div class="container mx-auto px-4 lg:px-8 relative z-10">

        {{-- Header --}}
        <div class="text-center max-w-3xl mx-auto mb-12">
            <span class="inline-block px-4 py-1 rounded-full bg-primary/20 text-primary text-sm font-bold mb-4 tracking-wider uppercase">Project Estimate</span>
            <h1 class="text-3xl md:text-5xl font-bold text-animazon-white mb-4">
                Get an Instant <span class="text-gradient">Project Estimate</span>
            </h1>
            <p class="text-lg text-animazon-muted leading-relaxed">
                Select your service category, answer a few questions, and receive a realistic cost estimate — in your local currency.
            </p>
        </div>

        {{-- Country Selector --}}
        <div class="max-w-md mx-auto mb-16">
            <label for="countrySelect" class="block text-sm font-medium text-animazon-muted mb-2">
                <i class="ti ti-map-pin mr-1"></i> Your Country <span id="autoDetectBadge" class="hidden text-[10px] bg-green-500/20 text-green-400 px-2 py-0.5 rounded-full ml-2">Auto-detected</span>
            </label>
            <select id="countrySelect"
                    class="w-full bg-animazon-navy border border-animazon-border rounded-xl px-4 py-3 text-animazon-white focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all appearance-none cursor-pointer"
                    onchange="updateCurrency(this.value)">
                @foreach($countries as $code => $name)
                    <option value="{{ $code }}" {{ $code === 'US' ? 'selected' : '' }}>
                        {{ $name }} ({{ $currencies[$code]['symbol'] }} {{ $currencies[$code]['code'] }})
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Categories — Visually Rich Horizontal Cards --}}
        @php
            // Define the desired display order + unique accent colors per category
            $categoryStyles = [
                'Website'      => ['accent' => 'orange',  'icon_fallback' => 'ti ti-world',             'gradient' => 'from-orange-500/20 to-orange-500/5'],
                'Web'          => ['accent' => 'orange',  'icon_fallback' => 'ti ti-world',             'gradient' => 'from-orange-500/20 to-orange-500/5'],
                '3D Animation' => ['accent' => 'cyan',    'icon_fallback' => 'ti ti-3d-cube-sphere',    'gradient' => 'from-cyan-500/20 to-cyan-500/5'],
                'App'          => ['accent' => 'green',   'icon_fallback' => 'ti ti-device-mobile',     'gradient' => 'from-green-500/20 to-green-500/5'],
                'Mobile'       => ['accent' => 'green',   'icon_fallback' => 'ti ti-device-mobile',     'gradient' => 'from-green-500/20 to-green-500/5'],
                'Game'         => ['accent' => 'purple',  'icon_fallback' => 'ti ti-device-gamepad-2',  'gradient' => 'from-purple-500/20 to-purple-500/5'],
            ];

            $orderedNames = ['Website', 'Web', '3D Animation', 'App', 'Mobile', 'Game'];
            $orderedCategories = collect();
            foreach ($orderedNames as $name) {
                $match = $categories->first(fn($c) => str_contains($c->name, $name));
                if ($match && !$orderedCategories->contains('id', $match->id)) {
                    $orderedCategories->push($match);
                }
            }
            foreach ($categories as $c) {
                if (!$orderedCategories->contains('id', $c->id)) {
                    $orderedCategories->push($c);
                }
            }
        @endphp

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 max-w-6xl mx-auto">
            @foreach($orderedCategories as $category)
                @php
                    $minPrice = $category->children->where('base_cost', '>', 0)->min('base_cost');
                    $maxPrice = $category->children->where('base_cost', '>', 0)->max('base_cost');
                    $serviceCount = $category->children->count();

                    // Match accent style
                    $style = null;
                    foreach ($categoryStyles as $key => $s) {
                        if (str_contains($category->name, $key)) { $style = $s; break; }
                    }
                    $style = $style ?? ['accent' => 'primary', 'icon_fallback' => 'ti ti-star', 'gradient' => 'from-primary/20 to-primary/5'];
                    $accent = $style['accent'];
                @endphp

                <a href="{{ url('/pricing/' . $category->id) }}"
                   class="group relative flex flex-col sm:flex-row items-stretch rounded-2xl border border-animazon-border/30 bg-animazon-navy/40 backdrop-blur-sm overflow-hidden transition-all duration-500 hover:-translate-y-1 hover:border-{{ $accent }}-500/50 hover:shadow-[0_0_40px_rgba(0,0,0,0.3)]">

                    {{-- Left accent bar --}}
                    <div class="hidden sm:block w-1.5 bg-gradient-to-b from-{{ $accent }}-400 to-{{ $accent }}-600 flex-shrink-0 rounded-l-2xl group-hover:w-2 transition-all duration-300"></div>

                    {{-- Icon column --}}
                    <div class="flex-shrink-0 flex items-center justify-center p-6 sm:p-8 bg-gradient-to-br {{ $style['gradient'] }}">
                        <div class="w-16 h-16 rounded-2xl bg-{{ $accent }}-500/15 border border-{{ $accent }}-500/30 flex items-center justify-center group-hover:bg-{{ $accent }}-500 group-hover:border-{{ $accent }}-400 group-hover:shadow-[0_0_25px_rgba(0,0,0,0.2)] transition-all duration-500">
                            <i class="{{ $category->icon ?: $style['icon_fallback'] }} text-{{ $accent }}-400 text-2xl group-hover:text-white group-hover:scale-110 transition-all duration-300"></i>
                        </div>
                    </div>

                    {{-- Content --}}
                    <div class="flex-1 min-w-0 p-6 flex flex-col justify-center">
                        <div class="flex items-center gap-3 mb-2">
                            <h2 class="text-xl font-bold text-animazon-white group-hover:text-{{ $accent }}-400 transition-colors duration-300">{{ $category->name }}</h2>
                            <span class="px-2.5 py-0.5 rounded-full bg-{{ $accent }}-500/15 text-{{ $accent }}-400 text-[11px] font-bold tracking-wide">{{ $serviceCount }} {{ $serviceCount === 1 ? 'SERVICE' : 'SERVICES' }}</span>
                        </div>
                        <p class="text-animazon-muted text-sm leading-relaxed mb-3">{{ $category->description }}</p>
                        @if($minPrice && $maxPrice)
                            <div class="flex items-center gap-2">
                                <span class="text-xs text-animazon-muted">Starting from</span>
                                <span class="text-sm font-bold text-{{ $accent }}-400" data-usd-min="{{ $minPrice }}" data-usd-max="{{ $maxPrice }}">${{ number_format($minPrice, 0) }} — ${{ number_format($maxPrice, 0) }}</span>
                            </div>
                        @endif
                    </div>

                    {{-- Arrow / CTA --}}
                    <div class="flex-shrink-0 flex items-center pr-6 sm:pr-8">
                        <div class="w-10 h-10 rounded-full bg-{{ $accent }}-500/10 border border-{{ $accent }}-500/20 flex items-center justify-center group-hover:bg-{{ $accent }}-500 group-hover:border-{{ $accent }}-400 transition-all duration-300">
                            <i class="ti ti-arrow-right text-{{ $accent }}-400 group-hover:text-white group-hover:translate-x-0.5 transition-all duration-300"></i>
                        </div>
                    </div>

                    {{-- Hover glow overlay --}}
                    <div class="absolute inset-0 bg-gradient-to-r from-{{ $accent }}-500/0 via-{{ $accent }}-500/0 to-{{ $accent }}-500/5 opacity-0 group-hover:opacity-100 transition-opacity duration-500 pointer-events-none rounded-2xl"></div>
                </a>
            @endforeach
        </div>

        {{-- Trust indicators --}}
        <div class="mt-24 grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6 text-center max-w-5xl mx-auto">
            <div class="p-5 bg-animazon-navy/30 border border-animazon-border/20 rounded-2xl hover:border-primary/30 transition-all duration-300 group">
                <div class="text-3xl font-bold text-primary mb-2 group-hover:scale-110 transition-transform">100%</div>
                <p class="text-animazon-white font-semibold text-sm">Transparent Pricing</p>
                <p class="text-animazon-muted text-xs mt-1">No hidden fees or surprises</p>
            </div>
            <div class="p-5 bg-animazon-navy/30 border border-animazon-border/20 rounded-2xl hover:border-primary/30 transition-all duration-300 group">
                <div class="text-3xl font-bold text-secondary mb-2 group-hover:scale-110 transition-transform"><i class="ti ti-rocket"></i></div>
                <p class="text-animazon-white font-semibold text-sm">Instant Estimates</p>
                <p class="text-animazon-muted text-xs mt-1">Interactive wizard in real-time</p>
            </div>
            <div class="p-5 bg-animazon-navy/30 border border-animazon-border/20 rounded-2xl hover:border-primary/30 transition-all duration-300 group">
                <div class="text-3xl font-bold text-primary mb-2 group-hover:scale-110 transition-transform">24hr</div>
                <p class="text-animazon-white font-semibold text-sm">Rapid Response</p>
                <p class="text-animazon-muted text-xs mt-1">Full proposal in a day</p>
            </div>
            <div class="p-5 bg-animazon-navy/30 border border-animazon-border/20 rounded-2xl hover:border-primary/30 transition-all duration-300 group">
                <div class="text-3xl font-bold text-primary mb-2 group-hover:scale-110 transition-transform"><i class="ti ti-shield-check"></i></div>
                <p class="text-animazon-white font-semibold text-sm">Dev Cost Only</p>
                <p class="text-animazon-muted text-xs mt-1">No 3rd-party fees included</p>
            </div>
        </div>

    </div>
</section>
@endsection

@section('page_scripts')
<script>
    const currencies = @json($currencies);

    function updateCurrency(countryCode) {
        localStorage.setItem('animazon_country', countryCode);
        // Update price range displays
        document.querySelectorAll('[data-usd-min]').forEach(el => {
            const min = parseFloat(el.dataset.usdMin);
            const max = parseFloat(el.dataset.usdMax);
            const cur = currencies[countryCode] || currencies['US'];
            const isIndia = countryCode === 'IN';
            const margin = isIndia ? 1 : 2;
            el.textContent = cur.symbol + formatNum(min * margin * cur.rate) + ' — ' + cur.symbol + formatNum(max * margin * cur.rate);
        });
    }

    function formatNum(n) {
        if (n >= 1000000) return (n/1000000).toFixed(1) + 'M';
        if (n >= 100000) return (n/1000).toFixed(0) + 'K';
        if (n >= 10000) return (n/1000).toFixed(1) + 'K';
        return n.toLocaleString('en', {maximumFractionDigits: 0});
    }

    document.addEventListener('DOMContentLoaded', () => {
        const sel = document.getElementById('countrySelect');
        const saved = localStorage.getItem('animazon_country');

        if (saved) {
            sel.value = saved;
            updateCurrency(saved);
        } else {
            // Auto-detect country by IP
            fetch('{{ route("cost-calculator.detect-country") }}')
                .then(r => r.json())
                .then(data => {
                    if (data.country_code) {
                        sel.value = data.country_code;
                        localStorage.setItem('animazon_country', data.country_code);
                        updateCurrency(data.country_code);
                        if (data.source === 'ip_api') {
                            document.getElementById('autoDetectBadge')?.classList.remove('hidden');
                        }
                    }
                })
                .catch(() => {});
        }
    });
</script>
@endsection
