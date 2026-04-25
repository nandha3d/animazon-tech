<?php
/**
 * Update E-Commerce pricing data in the database.
 * 
 * Changes:
 * 1. Rename "Custom Laravel + Vue/React" → "Custom Stack"
 * 2. Split "Shared / VPS Hosting Setup" into two separate options
 * 3. Add /year context to hosting/AMC explanations
 */

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

echo "=== E-Commerce Pricing Updates ===\n\n";

// --- 1. Rename "Custom Laravel + Vue/React" to "Custom Stack" ---
echo "1. Updating Platform label...\n";
$updated = DB::table('cost_calculator_answers')
    ->where('id', 68)
    ->update([
        'answer_text' => 'Custom Stack',
        'explanation' => 'Fully custom — total control over every feature',
        'insight' => '💡 Custom builds have zero recurring platform fees. Best for unique logic.',
    ]);
echo "   Answer #68 updated: {$updated} row(s)\n";

// --- 2. Update Hosting Options ---
echo "\n2. Updating Hosting options...\n";

// Rename existing "Shared / VPS Hosting Setup" to just "Shared Hosting Setup"
$updated = DB::table('cost_calculator_answers')
    ->where('id', 76)
    ->update([
        'answer_text' => 'Shared Hosting Setup',
        'additional_cost' => 40.00,
        'explanation' => 'Standard shared hosting — ideal for small to medium traffic (cost per year)',
        'insight' => '💡 Shared hosting is the most affordable option. Renews annually.',
    ]);
echo "   Answer #76 (Shared Hosting): {$updated} row(s)\n";

// Check if VPS answer already exists for this question
$existingVps = DB::table('cost_calculator_answers')
    ->where('question_id', 20)
    ->where('answer_text', 'like', '%VPS%')
    ->where('id', '!=', 76)
    ->first();

if (!$existingVps) {
    // Get the current max order for question 20
    $maxOrder = DB::table('cost_calculator_answers')
        ->where('question_id', 20)
        ->max('order');

    // Insert new VPS option after Shared Hosting
    // We need to shift orders: Shared=current, VPS=after shared, Cloud=after VPS, Enterprise=after Cloud
    // First, get all current answers for Q20 ordered
    $currentAnswers = DB::table('cost_calculator_answers')
        ->where('question_id', 20)
        ->orderBy('order')
        ->get();
    
    echo "   Current Q20 answers:\n";
    foreach ($currentAnswers as $a) {
        echo "     #{$a->id}: {$a->answer_text} (order={$a->order})\n";
    }

    // Shift Cloud & Enterprise orders up by 1 to make room for VPS
    DB::table('cost_calculator_answers')
        ->where('question_id', 20)
        ->where('id', 77) // Cloud & AMC Standard
        ->update(['order' => 4]);
    
    DB::table('cost_calculator_answers')
        ->where('question_id', 20)
        ->where('id', 78) // Enterprise AMC
        ->update(['order' => 5]);

    // Insert VPS as order 3 (after Shared which should be order 2)
    $vpsId = DB::table('cost_calculator_answers')->insertGetId([
        'question_id' => 20,
        'answer_text' => 'VPS Hosting Setup',
        'cost_multiplier' => 1.00,
        'additional_cost' => 80.00,
        'explanation' => 'Dedicated VPS server — better performance for growing stores (cost per year)',
        'insight' => '💡 VPS gives you dedicated resources. Best for stores with 500+ daily visitors.',
        'order' => 3,
        'active' => 1,
        'is_included' => 0,
        'is_enterprise' => 0,
        'created_at' => now(),
        'updated_at' => now(),
    ]);
    echo "   VPS answer inserted with ID: {$vpsId}\n";
} else {
    echo "   VPS option already exists (ID: {$existingVps->id}), updating...\n";
    DB::table('cost_calculator_answers')
        ->where('id', $existingVps->id)
        ->update([
            'additional_cost' => 80.00,
            'explanation' => 'Dedicated VPS server — better performance for growing stores (cost per year)',
            'insight' => '💡 VPS gives you dedicated resources. Best for stores with 500+ daily visitors.',
        ]);
}

// Update Cloud & AMC explanation to mention /year
$updated = DB::table('cost_calculator_answers')
    ->where('id', 77)
    ->update([
        'explanation' => 'Cloud setup + basic AMC maintenance (cost per year)',
        'insight' => '💡 Best value for keeping your store secure. Includes bug fixes & security patches.',
    ]);
echo "   Answer #77 (Cloud & AMC): {$updated} row(s)\n";

// Update Enterprise AMC explanation to mention /year
$updated = DB::table('cost_calculator_answers')
    ->where('id', 78)
    ->update([
        'explanation' => 'Priority updates and feature additions (cost per year)',
        'insight' => '💡 Dedicated developer for 10 hours/month. Includes priority support.',
    ]);
echo "   Answer #78 (Enterprise AMC): {$updated} row(s)\n";

// Update No Hosting explanation
$updated = DB::table('cost_calculator_answers')
    ->where('id', 75)
    ->update([
        'explanation' => 'You handle hosting yourself — we hand over the complete source code',
    ]);
echo "   Answer #75 (No Hosting): {$updated} row(s)\n";

// --- 3. Verify final state ---
echo "\n=== Final E-Commerce Q&A State ===\n";
$questions = DB::table('cost_calculator_questions')
    ->where('project_type_id', 7)
    ->where('active', 1)
    ->orderBy('order')
    ->get();

foreach ($questions as $q) {
    echo "\nQ{$q->id}: [{$q->category}] {$q->question}\n";
    $answers = DB::table('cost_calculator_answers')
        ->where('question_id', $q->id)
        ->where('active', 1)
        ->orderBy('order')
        ->get();
    foreach ($answers as $a) {
        echo "  A{$a->id}: {$a->answer_text} | mult={$a->cost_multiplier} | add=\${$a->additional_cost}\n";
        echo "         {$a->explanation}\n";
    }
}

echo "\n✅ Done!\n";
