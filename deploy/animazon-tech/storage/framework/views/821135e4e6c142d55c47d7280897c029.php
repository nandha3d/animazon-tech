<?php $__env->startSection('page_content'); ?>
<section class="py-16 bg-animazon-black text-animazon-white min-h-screen">
    <div class="container mx-auto px-4 lg:px-8">

        
        <div class="text-center max-w-3xl mx-auto mb-12">
            <a href="<?php echo e(url('/pricing')); ?>" class="inline-flex items-center gap-1 text-animazon-muted hover:text-primary text-sm mb-4 transition-colors">
                <i class="ti ti-arrow-left"></i> All Categories
            </a>
            <div class="flex items-center justify-center gap-3 mb-4">
                <div class="w-14 h-14 rounded-2xl bg-primary/10 flex items-center justify-center text-primary text-3xl">
                    <i class="<?php echo e($projectType->icon); ?>"></i>
                </div>
            </div>
            <h1 class="text-3xl md:text-5xl font-bold text-animazon-white mb-4">
                <?php echo e($projectType->name); ?>

            </h1>
            <p class="text-lg text-animazon-muted"><?php echo e($projectType->description); ?></p>
        </div>

        
        <div class="max-w-md mx-auto mb-14">
            <label for="countrySelect" class="block text-sm font-medium text-animazon-muted mb-2">
                <i class="ti ti-map-pin mr-1"></i> Your Country
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
            // Define desired display order keywords
            $displayOrder = ['E-Commerce', 'Business', 'Corporate', 'Web Application', 'SaaS', 'Landing', 'Custom'];
            
            // Define accent colors per card type
            $cardAccents = [
                'E-Commerce' => ['color' => 'cyan',   'glow' => '0 0 30px rgba(0,200,255,0.15), 0 0 60px rgba(0,200,255,0.05)'],
                'Business'   => ['color' => 'orange', 'glow' => '0 0 30px rgba(255,150,50,0.15), 0 0 60px rgba(255,150,50,0.05)'],
                'Corporate'  => ['color' => 'orange', 'glow' => '0 0 30px rgba(255,150,50,0.15), 0 0 60px rgba(255,150,50,0.05)'],
                'Web App'    => ['color' => 'green',  'glow' => '0 0 30px rgba(50,220,100,0.15), 0 0 60px rgba(50,220,100,0.05)'],
                'SaaS'       => ['color' => 'green',  'glow' => '0 0 30px rgba(50,220,100,0.15), 0 0 60px rgba(50,220,100,0.05)'],
                'Landing'    => ['color' => 'blue',   'glow' => '0 0 30px rgba(80,130,255,0.15), 0 0 60px rgba(80,130,255,0.05)'],
                'Custom'     => ['color' => 'secondary', 'glow' => '0 0 30px rgba(255,97,34,0.15), 0 0 60px rgba(255,97,34,0.05)'],
            ];

            // Sort children by display order
            $ordered = collect();
            foreach ($displayOrder as $keyword) {
                $match = $projectType->children->first(fn($c) => str_contains($c->name, $keyword) && !$ordered->contains('id', $c->id));
                if ($match) $ordered->push($match);
            }
            // Add any remaining
            foreach ($projectType->children as $c) {
                if (!$ordered->contains('id', $c->id)) $ordered->push($c);
            }

            function getCardAccent($name, $accents) {
                foreach ($accents as $key => $val) {
                    if (str_contains($name, $key)) return $val;
                }
                return ['color' => 'primary', 'glow' => '0 0 30px rgba(0,193,222,0.15), 0 0 60px rgba(0,193,222,0.05)'];
            }
        ?>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 max-w-5xl mx-auto">
            <?php $__currentLoopData = $ordered; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sub): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $accent = getCardAccent($sub->name, $cardAccents);
                    $accentColor = $accent['color'];
                    $glowShadow = $accent['glow'];
                ?>

                <?php if($sub->base_cost > 0): ?>
                    <a href="<?php echo e(route('cost-calculator.show', $sub->slug ?? $sub->id)); ?>?country=US"
                       class="service-card group bg-animazon-navy/50 border border-animazon-border/30 hover:border-<?php echo e($accentColor); ?>-500/50 rounded-2xl p-6 flex flex-col justify-between transition-all duration-300 hover:-translate-y-2 cursor-pointer"
                       style="box-shadow: <?php echo e($glowShadow); ?>;">

                        
                        <div>
                            <div class="w-12 h-12 rounded-xl bg-<?php echo e($accentColor); ?>-500/10 flex items-center justify-center text-<?php echo e($accentColor); ?>-400 text-xl mb-4 group-hover:bg-<?php echo e($accentColor); ?>-500 group-hover:text-white transition-all">
                                <i class="<?php echo e($sub->icon); ?>"></i>
                            </div>
                            <h3 class="text-lg font-bold text-animazon-white mb-2 group-hover:text-<?php echo e($accentColor); ?>-400 transition-colors">
                                <?php echo e($sub->name); ?>

                            </h3>
                            <p class="text-animazon-muted text-xs leading-relaxed mb-4">
                                <?php echo e($sub->description); ?>

                            </p>
                        </div>

                        
                        <div class="mt-auto pt-4 border-t border-animazon-border/20 flex items-center justify-between">
                            <div>
                                <span class="block text-[10px] uppercase tracking-wider text-animazon-muted">Starting from</span>
                                <span class="text-xl font-bold text-<?php echo e($accentColor); ?>-400 currency-price"
                                      data-usd="<?php echo e($sub->base_cost); ?>">
                                    $<?php echo e(number_format($sub->base_cost, 0)); ?>

                                </span>
                            </div>
                            <span class="w-9 h-9 rounded-full bg-<?php echo e($accentColor); ?>-500/10 flex items-center justify-center text-<?php echo e($accentColor); ?>-400 group-hover:bg-<?php echo e($accentColor); ?>-500 group-hover:text-white transition-all">
                                <i class="ti ti-arrow-right text-sm"></i>
                            </span>
                        </div>
                    </a>
                <?php else: ?>
                    
                    <a href="<?php echo e(route('cost-calculator.show', $sub->slug ?? $sub->id)); ?>?country=US"
                       class="service-card group bg-animazon-navy/50 border border-dashed border-animazon-border/40 hover:border-secondary/50 rounded-2xl p-6 flex flex-col justify-between transition-all duration-300 hover:-translate-y-2 cursor-pointer"
                       style="box-shadow: <?php echo e($glowShadow); ?>;">
                        <div>
                            <div class="w-12 h-12 rounded-xl bg-secondary/10 flex items-center justify-center text-secondary text-xl mb-4 group-hover:bg-secondary group-hover:text-white transition-all">
                                <i class="<?php echo e($sub->icon); ?>"></i>
                            </div>
                            <h3 class="text-lg font-bold text-animazon-white mb-2 group-hover:text-secondary transition-colors">
                                <?php echo e($sub->name); ?>

                            </h3>
                            <p class="text-animazon-muted text-xs leading-relaxed mb-4">
                                <?php echo e($sub->description); ?>

                            </p>
                        </div>
                        <div class="mt-auto pt-4 border-t border-animazon-border/20 flex items-center justify-between">
                            <span class="text-sm font-semibold text-secondary">Custom Request</span>
                            <span class="w-9 h-9 rounded-full bg-secondary/10 flex items-center justify-center text-secondary group-hover:bg-secondary group-hover:text-white transition-all">
                                <i class="ti ti-arrow-right text-sm"></i>
                            </span>
                        </div>
                    </a>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <div class="mt-12 text-center">
            <a href="<?php echo e(url('/pricing')); ?>" class="inline-block px-6 py-3 rounded-xl bg-animazon-navy border border-animazon-border/30 text-animazon-muted hover:text-animazon-white hover:border-animazon-border transition-all">
                <i class="ti ti-arrow-left mr-2"></i> Back to Categories
            </a>
        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page_scripts'); ?>
<script>
    const currencyMap = <?php echo json_encode($currencies, 15, 512) ?>;

    function updateCurrency(countryCode) {
        const c = currencyMap[countryCode];
        if (!c) return;
        const isIndia = (countryCode === 'IN');
        const margin = isIndia ? 1 : 2;

        document.querySelectorAll('.currency-price').forEach(el => {
            const usd = parseFloat(el.dataset.usd);
            const val = usd * margin * c.rate;
            el.textContent = c.symbol + formatNum(val, c.code);
        });

        // Update card links with country
        document.querySelectorAll('a[href*="/pricing/"]').forEach(card => {
            const href = card.getAttribute('href');
            if (href && href.includes('/pricing/')) {
                const baseUrl = href.split('?')[0];
                card.setAttribute('href', baseUrl + '?country=' + countryCode);
            }
        });

        localStorage.setItem('animazon_country', countryCode);
    }

    function formatNum(n, code) {
        return n.toLocaleString('en-US', {maximumFractionDigits: 0});
    }

    document.addEventListener('DOMContentLoaded', () => {
        const saved = localStorage.getItem('animazon_country');
        if (saved && document.getElementById('countrySelect')) {
            document.getElementById('countrySelect').value = saved;
            updateCurrency(saved);
        }
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.landing', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\PROJECTS\WEBSITES\animazon-tech\resources\views/cost-calculator/public-category.blade.php ENDPATH**/ ?>