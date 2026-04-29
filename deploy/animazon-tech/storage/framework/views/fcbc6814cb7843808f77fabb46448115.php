<?php $__env->startSection('page_content'); ?>
<section class="py-16 bg-animazon-black text-animazon-white min-h-screen relative overflow-hidden">
    
    <div class="absolute -top-[20%] -right-[10%] w-[600px] h-[600px] bg-primary/5 rounded-full blur-[120px] pointer-events-none"></div>
    <div class="absolute -bottom-[10%] -left-[10%] w-[400px] h-[400px] bg-secondary/5 rounded-full blur-[100px] pointer-events-none"></div>

    <div class="container mx-auto px-4 lg:px-8 relative z-10">

        
        <div class="text-center max-w-3xl mx-auto mb-12">
            <span class="inline-block px-4 py-1 rounded-full bg-primary/20 text-primary text-sm font-bold mb-4 tracking-wider uppercase">Project Estimate</span>
            <h1 class="text-3xl md:text-5xl font-bold text-animazon-white mb-4">
                Get an Instant <span class="text-gradient">Project Estimate</span>
            </h1>
            <p class="text-lg text-animazon-muted leading-relaxed">
                Select your service category, answer a few questions, and receive a realistic cost estimate — in your local currency.
            </p>
        </div>

        
        <div class="max-w-md mx-auto mb-16">
            <label for="countrySelect" class="block text-sm font-medium text-animazon-muted mb-2">
                <i class="ti ti-map-pin mr-1"></i> Your Country <span id="autoDetectBadge" class="hidden text-[10px] bg-green-500/20 text-green-400 px-2 py-0.5 rounded-full ml-2">Auto-detected</span>
            </label>
            <select id="countrySelect"
                    class="w-full bg-animazon-navy border border-animazon-border rounded-xl px-4 py-3 text-animazon-white focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all appearance-none cursor-pointer"
                    onchange="updateCurrency(this.value)">
                <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $code => $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($code); ?>" <?php echo e($code === 'US' ? 'selected' : ''); ?>>
                        <?php echo e($name); ?> (<?php echo e($currencies[$code]['symbol']); ?> <?php echo e($currencies[$code]['code']); ?>)
                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>

        
        <?php
            // Define the desired display order + unique accent colors per category
            $categoryStyles = [
                'Website'      => ['accent' => 'orange',  'icon_fallback' => 'ti ti-world',             'gradient' => 'from-orange-500/20 to-orange-500/5', 'glow' => '0 0 30px rgba(255,150,50,0.15), 0 0 60px rgba(255,150,50,0.05)'],
                'Web'          => ['accent' => 'orange',  'icon_fallback' => 'ti ti-world',             'gradient' => 'from-orange-500/20 to-orange-500/5', 'glow' => '0 0 30px rgba(255,150,50,0.15), 0 0 60px rgba(255,150,50,0.05)'],
                '3D Animation' => ['accent' => 'cyan',    'icon_fallback' => 'ti ti-3d-cube-sphere',    'gradient' => 'from-cyan-500/20 to-cyan-500/5',    'glow' => '0 0 30px rgba(0,200,255,0.15), 0 0 60px rgba(0,200,255,0.05)'],
                'App'          => ['accent' => 'green',   'icon_fallback' => 'ti ti-device-mobile',     'gradient' => 'from-green-500/20 to-green-500/5',  'glow' => '0 0 30px rgba(50,220,100,0.15), 0 0 60px rgba(50,220,100,0.05)'],
                'Mobile'       => ['accent' => 'green',   'icon_fallback' => 'ti ti-device-mobile',     'gradient' => 'from-green-500/20 to-green-500/5',  'glow' => '0 0 30px rgba(50,220,100,0.15), 0 0 60px rgba(50,220,100,0.05)'],
                'Game'         => ['accent' => 'purple',  'icon_fallback' => 'ti ti-device-gamepad-2',  'gradient' => 'from-purple-500/20 to-purple-500/5', 'glow' => '0 0 30px rgba(160,80,255,0.15), 0 0 60px rgba(160,80,255,0.05)'],
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
        ?>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 max-w-7xl mx-auto">
            <?php $__currentLoopData = $orderedCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
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

                    // Define relevant placeholder image URL based on category
                    $imageUrl = asset('assets/images/pricing/webapp1.jpg');
                    if (str_contains($category->name, '3D') || str_contains($category->name, 'Animation')) {
                        $imageUrl = asset('assets/images/pricing/3d.png');
                    } elseif (str_contains($category->name, 'App') || str_contains($category->name, 'Mobile')) {
                        $imageUrl = asset('assets/images/pricing/mobileapp.jpg');
                    } elseif (str_contains($category->name, 'Game')) {
                        $imageUrl = asset('assets/images/pricing/gaming.jpg');
                    }
                ?>

                <a href="<?php echo e(route('cost-calculator.show', $category->slug ?? $category->id)); ?>"
                   class="group relative flex flex-col items-stretch rounded-3xl border border-animazon-border/30 bg-animazon-navy/50 backdrop-blur-sm overflow-hidden transition-all duration-500 hover:-translate-y-3 hover:border-<?php echo e($accent); ?>-500/60"
                   style="box-shadow: <?php echo e($style['glow'] ?? '0 0 30px rgba(0,193,222,0.1)'); ?>; min-height: 520px;">

                    
                    <div class="w-full relative overflow-hidden bg-animazon-navy" style="height: 230px;">
                        <img src="<?php echo e($imageUrl); ?>" alt="<?php echo e($category->name); ?>" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        
                        <div class="absolute inset-0 bg-gradient-to-t from-animazon-navy/80 via-transparent to-transparent"></div>

                        
                        <div class="absolute top-4 right-4 z-20 w-11 h-11 rounded-full bg-animazon-navy/80 backdrop-blur-md border border-<?php echo e($accent); ?>-500/30 flex items-center justify-center group-hover:bg-<?php echo e($accent); ?>-500 group-hover:border-<?php echo e($accent); ?>-400 transition-colors duration-300">
                            <i class="<?php echo e($category->icon ?: $style['icon_fallback']); ?> text-<?php echo e($accent); ?>-400 group-hover:text-white text-xl transition-colors duration-300"></i>
                        </div>

                        
                        <div class="absolute top-4 left-4 z-20">
                            <span class="px-3 py-1.5 rounded-full bg-animazon-navy/70 backdrop-blur-md border border-<?php echo e($accent); ?>-500/20 text-<?php echo e($accent); ?>-400 text-[11px] font-bold tracking-wider"><?php echo e($serviceCount); ?> <?php echo e($serviceCount === 1 ? 'SERVICE' : 'SERVICES'); ?></span>
                        </div>
                    </div>

                    
                    <div class="h-1 w-full bg-gradient-to-r from-<?php echo e($accent); ?>-400 via-<?php echo e($accent); ?>-500 to-<?php echo e($accent); ?>-600 flex-shrink-0 group-hover:h-1.5 transition-all duration-300"></div>

                    
                    <div class="flex-1 p-6 flex flex-col text-center items-center">
                        <h2 class="text-2xl font-bold text-animazon-white group-hover:text-<?php echo e($accent); ?>-400 transition-colors duration-300 leading-tight mb-3"><?php echo e($category->name); ?></h2>

                        <p class="text-animazon-muted text-sm leading-relaxed mb-6 flex-1"><?php echo e(str_replace('ÔÇö', '—', $category->description)); ?></p>

                        <?php if($minPrice): ?>
                            
                            <div class="mb-5">
                                <span class="text-[11px] text-animazon-muted uppercase tracking-widest font-semibold block mb-2">Starting from</span>
                                <div class="inline-flex items-center gap-1 px-4 py-2.5 rounded-xl bg-gradient-to-r from-<?php echo e($accent); ?>-500/15 to-<?php echo e($accent); ?>-600/10 border border-<?php echo e($accent); ?>-500/25">
                                    <span class="text-2xl font-extrabold text-<?php echo e($accent); ?>-400 tracking-tight" data-usd-min="<?php echo e($minPrice); ?>">$<?php echo e(number_format($minPrice, 0)); ?></span>
                                </div>
                            </div>
                        <?php endif; ?>

                        
                        <div class="mt-auto w-full">
                            <div class="w-full py-3 rounded-xl bg-gradient-to-r from-<?php echo e($accent); ?>-500/20 to-<?php echo e($accent); ?>-600/10 border border-<?php echo e($accent); ?>-500/30 text-<?php echo e($accent); ?>-400 font-bold text-sm text-center tracking-wide group-hover:from-<?php echo e($accent); ?>-500 group-hover:to-<?php echo e($accent); ?>-600 group-hover:text-white group-hover:border-<?php echo e($accent); ?>-400 transition-all duration-300">
                                <i class="ti ti-calculator mr-1"></i> Get Estimate
                            </div>
                        </div>
                    </div>

                    
                    <div class="absolute inset-0 bg-gradient-to-t from-<?php echo e($accent); ?>-500/8 via-<?php echo e($accent); ?>-500/0 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 pointer-events-none rounded-3xl"></div>
                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        
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
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page_scripts'); ?>
<script>
    const currencies = <?php echo json_encode($currencies, 15, 512) ?>;

    function updateCurrency(countryCode) {
        localStorage.setItem('animazon_country', countryCode);
        // Update price range displays
        document.querySelectorAll('[data-usd-min]').forEach(el => {
            const min = parseFloat(el.dataset.usdMin);
            const cur = currencies[countryCode] || currencies['US'];
            const isIndia = countryCode === 'IN';
            const margin = isIndia ? 1 : 2;
            el.textContent = cur.symbol + formatNum(min * margin * cur.rate);
        });
    }

    function formatNum(n) {
        return Math.round(n).toLocaleString('en-IN', {maximumFractionDigits: 0});
    }

    document.addEventListener('DOMContentLoaded', () => {
        const sel = document.getElementById('countrySelect');
        const saved = localStorage.getItem('animazon_country');

        if (saved) {
            sel.value = saved;
            updateCurrency(saved);
        } else {
            // Auto-detect country by IP
            fetch('<?php echo e(route("cost-calculator.detect-country")); ?>')
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.landing', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\PROJECTS\WEBSITES\animazon-tech\resources\views/cost-calculator/public-index.blade.php ENDPATH**/ ?>