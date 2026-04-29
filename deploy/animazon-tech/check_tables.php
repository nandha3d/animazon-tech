<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$cats = App\Models\ProjectType::whereNull('parent_id')->with('children')->get();
foreach($cats as $c) {
    echo $c->name . ' (' . $c->children->count() . " sub-services)\n";
    foreach($c->children as $s) {
        $qCount = App\Models\CostCalculatorQuestion::where('project_type_id', $s->id)->count();
        echo "  - {$s->name} (\${$s->base_cost}) - {$qCount} questions\n";
    }
}
