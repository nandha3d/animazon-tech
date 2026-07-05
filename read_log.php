<?php
$logFile = 'storage/logs/laravel.log';
if (!file_exists($logFile)) {
    echo "Log file does not exist.\n";
    exit;
}
$log = file_get_contents($logFile);
$lines = explode("\n", $log);
$count = 0;
for ($i = count($lines) - 1; $i >= 0; $i--) {
    $line = trim($lines[$i]);
    if (empty($line)) continue;
    $data = json_decode($line, true);
    if ($data && isset($data['message'])) {
        echo "LOG DATE: " . ($data['datetime'] ?? 'N/A') . "\n";
        echo "MESSAGE: " . $data['message'] . "\n";
        if (isset($data['exception'])) {
            echo "EXCEPTION: " . substr($data['exception'], 0, 800) . "\n";
        }
        echo "----------------------------------------\n";
        $count++;
        if ($count >= 5) break;
    } else {
        if (preg_match('/^\[202\d-\d\d-\d\d/', $line)) {
            echo "TEXT LOG: " . substr($line, 0, 1000) . "\n";
            echo "----------------------------------------\n";
            $count++;
            if ($count >= 5) break;
        }
    }
}
