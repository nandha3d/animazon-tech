<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\CostEstimateAnswer;
use App\Models\CostEstimate;

$answers = CostEstimateAnswer::with(['answer', 'estimate'])->get();
$fixed = 0;

foreach ($answers as $ans) {
    if ($ans->answer && $ans->estimate) {
        $base = $ans->estimate->base_cost;
        $mult = $ans->answer->cost_multiplier;
        $add = $ans->answer->additional_cost;

        $wrong_val = ($base * $mult) + $add;
        $right_val = ($base * ($mult - 1)) + $add;

        if (abs($ans->cost_contribution - $wrong_val) < 0.01) {
            $ans->cost_contribution = $right_val;
            $ans->save();
            $fixed++;
        }
    }
}

echo "Fixed $fixed corrupted cost_contribution entries.\n";
