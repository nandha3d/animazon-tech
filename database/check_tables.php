<?php
$db = new SQLite3(__DIR__ . '/database.sqlite');
$tables = ['settings', 'landing_page_settings', 'product_services', 'product_service_categories'];
foreach($tables as $table) {
    $r = $db->query("SELECT count(*) as c FROM $table");
    if($r) {
        $row = $r->fetchArray();
        echo "Table: $table, rows: " . $row['c'] . PHP_EOL;
    }
}
