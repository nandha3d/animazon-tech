@extends('layouts.landing')

@section('page_content')
<section class="py-16 bg-animazon-black text-animazon-white min-h-screen">
    <div class="container mx-auto px-4 lg:px-8">

        {{-- Header --}}
        <div class="text-center max-w-3xl mx-auto mb-12">
            <span class="inline-block px-4 py-1 rounded-full bg-primary/20 text-primary text-sm font-bold mb-4 animate-pulse">PROJECT ESTIMATE</span>
            <h1 class="text-3xl md:text-5xl font-bold text-animazon-white mb-4">
                Get an Instant <span class="text-gradient">Project Estimate</span>
            </h1>
            <p class="text-lg text-animazon-muted">
                Select your service category, answer a few questions, and receive a realistic cost estimate — in your local currency.
            </p>
        </div>

        {{-- Country Selector --}}
        <div class="max-w-md mx-auto mb-14">
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

        {{-- Categories Grid with Images --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-5xl mx-auto">
            @foreach($categories as $category)
                @php
                    $fallbackImages = [
                        '3D Animation' => 'https://images.unsplash.com/photo-1633356122544-f134324a6cee?w=600&h=340&fit=crop',
                        'Website' => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=600&h=340&fit=crop',
                        'App' => 'https://images.unsplash.com/photo-1512941937669-90a1b58e7e9c?w=600&h=340&fit=crop',
                        'Game' => 'https://images.unsplash.com/photo-1535223289827-42f1e9919769?w=600&h=340&fit=crop',
                    ];
                    $imgSrc = $category->image_path ? asset($category->image_path) : '';
                    if (!$imgSrc) {
                        foreach ($fallbackImages as $key => $url) {
                            if (str_contains($category->name, $key)) { $imgSrc = $url; break; }
                        }
                    }
                    // Get price range from children
                    $minPrice = $category->children->where('base_cost', '>', 0)->min('base_cost');
                    $maxPrice = $category->children->where('base_cost', '>', 0)->max('base_cost');
                @endphp
                <a href="{{ url('/pricing/' . $category->id) }}"
                   class="group block bg-animazon-navy/50 border border-animazon-border/30 hover:border-primary/50 transition-all duration-500 rounded-3xl overflow-hidden hover:-translate-y-3 cursor-pointer shadow-lg hover:shadow-primary/20 hover:bg-animazon-navy">

                    {{-- Image Section --}}
                    <div class="relative h-44 overflow-hidden">
                        <img src="{{ $imgSrc }}"
                             alt="{{ $category->name }}"
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                             loading="lazy"
                             onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="w-full h-full bg-gradient-to-br from-primary/30 to-secondary/30 items-center justify-center text-6xl text-white/40 hidden">
                            <i class="{{ $category->icon }}"></i>
                        </div>
                        <div class="absolute inset-0 bg-gradient-to-t from-animazon-navy via-transparent to-transparent"></div>
                        <div class="absolute top-3 right-3 bg-animazon-black/60 backdrop-blur-sm rounded-full px-3 py-1 text-xs font-bold text-primary">
                            {{ $category->children->count() }} Services
                        </div>
                    </div>

                    {{-- Content --}}
                    <div class="p-6">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-10 h-10 rounded-xl bg-primary/10 flex items-center justify-center text-primary text-xl group-hover:bg-primary group-hover:text-white transition-all">
                                <i class="{{ $category->icon }}"></i>
                            </div>
                            <h2 class="text-xl font-bold text-animazon-white group-hover:text-primary transition-colors">{{ $category->name }}</h2>
                        </div>
                        <p class="text-animazon-muted text-sm leading-relaxed mb-4">{{ $category->description }}</p>

                        {{-- Price Range --}}
                        @if($minPrice && $maxPrice)
                            <div class="flex items-center justify-between">
                                <span class="text-xs text-animazon-muted">
                                    Starting from <span class="text-primary font-bold text-sm" data-usd-min="{{ $minPrice }}" data-usd-max="{{ $maxPrice }}">
                                        ${{ number_format($minPrice, 0) }} — ${{ number_format($maxPrice, 0) }}
                                    </span>
                                </span>
                                <span class="inline-flex items-center text-primary text-sm font-bold group-hover:gap-2 transition-all">
                                    Explore <i class="ti ti-arrow-right ml-1"></i>
                                </span>
                            </div>
                        @else
                            <span class="inline-flex items-center text-primary text-sm font-bold group-hover:gap-2 transition-all">
                                View Services <i class="ti ti-arrow-right ml-1"></i>
                            </span>
                        @endif
                    </div>
                </a>
            @endforeach
        </div>

        {{-- Trust indicators --}}
        <div class="mt-24 grid grid-cols-1 md:grid-cols-4 gap-6 text-center max-w-5xl mx-auto">
            <div class="p-5 bg-animazon-navy/30 border border-animazon-border/20 rounded-2xl hover:border-primary/30 transition-all">
                <div class="text-3xl font-bold text-primary mb-2">100%</div>
                <p class="text-animazon-white font-semibold text-sm">Transparent Pricing</p>
                <p class="text-animazon-muted text-xs mt-1">No hidden fees or surprises</p>
            </div>
            <div class="p-5 bg-animazon-navy/30 border border-animazon-border/20 rounded-2xl hover:border-primary/30 transition-all">
                <div class="text-3xl font-bold text-secondary mb-2"><i class="ti ti-rocket"></i></div>
                <p class="text-animazon-white font-semibold text-sm">Instant Estimates</p>
                <p class="text-animazon-muted text-xs mt-1">Interactive wizard in real-time</p>
            </div>
            <div class="p-5 bg-animazon-navy/30 border border-animazon-border/20 rounded-2xl hover:border-primary/30 transition-all">
                <div class="text-3xl font-bold text-primary mb-2">24hr</div>
                <p class="text-animazon-white font-semibold text-sm">Rapid Response</p>
                <p class="text-animazon-muted text-xs mt-1">Full proposal in a day</p>
            </div>
            <div class="p-5 bg-animazon-navy/30 border border-animazon-border/20 rounded-2xl hover:border-primary/30 transition-all">
                <div class="text-3xl font-bold text-primary mb-2"><i class="ti ti-shield-check"></i></div>
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
