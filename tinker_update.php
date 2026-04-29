\ = [
    61 => ['answer_text' => 'Up to 10 products (Free)', 'additional_cost' => 0, 'is_included' => 1, 'is_enterprise' => 0, 'insight' => '💡 10 products are included completely free of cost.'],
    62 => ['answer_text' => 'Up to 15 products', 'additional_cost' => 18, 'is_included' => 0, 'is_enterprise' => 0, 'insight' => null],
    63 => ['answer_text' => 'Up to 25 products', 'additional_cost' => 30, 'is_included' => 0, 'is_enterprise' => 0, 'insight' => null],
    64 => ['answer_text' => 'Up to 50 products', 'additional_cost' => 60, 'is_included' => 0, 'is_enterprise' => 0, 'insight' => null],
    65 => ['answer_text' => '100+ products', 'additional_cost' => 120, 'is_included' => 0, 'is_enterprise' => 0, 'insight' => null],
    68 => ['cost_multiplier' => 1.00, 'additional_cost' => 120]
];
foreach (\ as \ => \) {
    \ = \App\Models\CostCalculatorAnswer::find(\);
    if (\) {
        \->update(\);
    }
}
echo 'SUCCESS';
