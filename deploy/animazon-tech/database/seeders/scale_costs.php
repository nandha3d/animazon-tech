<?php
$file = __DIR__ . '/CostCalculatorSeeder.php';
$content = file_get_contents($file);

// Scale base_cost
$content = preg_replace_callback("/'base_cost'\s*=>\s*([\d\.]+)/", function($matches) {
    $val = (float)$matches[1];
    if ($val == 0 || $val <= 150) return $matches[0]; 
    $newVal = round($val / 83.5);
    return "'base_cost' => " . $newVal;
}, $content);

// Scale additional_cost in $this->q arrays
$content = preg_replace_callback("/(\[\s*[^,]+\s*,\s*[\d\.]+\s*,\s*)([\d\.]+)(\s*,.*\])/", function($matches) {
    $cost = (float)$matches[2];
    if ($cost > 190) { 
        $newCost = round($cost / 83.5);
        return $matches[1] . $newCost . $matches[3];
    }
    return $matches[0];
}, $content);

file_put_contents($file, $content);
echo "Cost scaling complete.\n";
