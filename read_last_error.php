<?php
$lines = file('storage/logs/laravel.log');
$errorLines = array_slice($lines, -500); // get last 500 lines
$output = '';
foreach ($errorLines as $line) {
    if (strpos($line, 'local.ERROR') !== false) {
        $output = ''; // reset output to show from last error
    }
    $output .= $line;
}
file_put_contents('last_error.txt', $output);
