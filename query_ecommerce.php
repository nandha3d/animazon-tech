<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== CATEGORIES (parent_id = NULL) ===\n";
$cats = \App\Models\ProjectType::whereNull('parent_id')->where('active', true)->orderBy('name')->get();
foreach ($cats as $c) {
    echo "ID={$c->id} | {$c->name} | icon={$c->icon}\n";
}

echo "\n=== WEBSITE SUB-SERVICES ===\n";
// Find Website category
$website = \App\Models\ProjectType::whereNull('parent_id')->where('active', true)->where('name', 'like', '%Website%')->first();
if ($website) {
    $subs = \App\Models\ProjectType::where('parent_id', $website->id)->where('active', true)->orderBy('name')->get();
    foreach ($subs as $s) {
        echo "ID={$s->id} | {$s->name} | base_cost={$s->base_cost}\n";
    }

    // Get questions for e-commerce sub services
    foreach ($subs as $s) {
        if (str_contains(strtolower($s->name), 'e-commerce') || str_contains(strtolower($s->name), 'ecommerce')) {
            echo "\n=== E-COMMERCE QUESTIONS (project_type_id={$s->id}) ===\n";
            $questions = \App\Models\CostCalculatorQuestion::where('project_type_id', $s->id)
                ->where('active', true)
                ->with(['answers' => function($q) { $q->where('active', true)->orderBy('order'); }])
                ->orderBy('order')
                ->get();
            foreach ($questions as $q) {
                echo "\nQ{$q->id}: [{$q->category}] {$q->question} (type={$q->type}, required={$q->required})\n";
                foreach ($q->answers as $a) {
                    echo "  A{$a->id}: {$a->answer_text} | multiplier={$a->cost_multiplier} | additional={$a->additional_cost} | included={$a->is_included} | enterprise={$a->is_enterprise}\n";
                    if ($a->explanation) echo "         explanation: {$a->explanation}\n";
                    if ($a->insight) echo "         insight: {$a->insight}\n";
                }
            }
        }
    }
}
