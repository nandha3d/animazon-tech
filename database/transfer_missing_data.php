<?php
$sqlite = new PDO('sqlite:' . __DIR__ . '/database.sqlite');
$sqlite->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$mysql = new PDO('mysql:host=127.0.0.1;port=3306;dbname=u362580417_animazon', 'root', 'admin');
$mysql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$tablesToCopy = [
    'designations', 'employees', 'orders', 'credit_notes', 'debit_notes', 
    'time_trackers', 'chart_of_accounts', 'chart_of_account_sub_types', 
    'form_field_responses', 'track_photos', 'currencies'
];

foreach ($tablesToCopy as $table) {
    echo "Copying $table...\n";
    $mysql->exec("SET FOREIGN_KEY_CHECKS=0");
    $mysql->exec("TRUNCATE TABLE `$table`");
    $mysql->exec("SET FOREIGN_KEY_CHECKS=1");

    $rows = $sqlite->query("SELECT * FROM `$table`")->fetchAll(PDO::FETCH_ASSOC);
    if (empty($rows)) {
        echo "  Empty.\n";
        continue;
    }

    // SQLite schema sometimes has columns that don't match exactly or missing ones.
    // Let's dynamically get the intersection of columns.
    $sqliteCols = array_keys($rows[0]);
    $mysqlCols = $mysql->query("DESCRIBE `$table`")->fetchAll(PDO::FETCH_COLUMN);
    $intersect = array_intersect($sqliteCols, $mysqlCols);

    $colList = implode("`, `", $intersect);
    $placeholders = implode(", ", array_fill(0, count($intersect), "?"));
    
    $insertStmt = $mysql->prepare("INSERT INTO `$table` (`$colList`) VALUES ($placeholders)");

    $count = 0;
    foreach ($rows as $row) {
        $insertData = [];
        foreach ($intersect as $col) {
            $insertData[] = $row[$col];
        }
        try {
            $insertStmt->execute($insertData);
            $count++;
        } catch (Exception $e) {
            echo "  Error: " . $e->getMessage() . "\n";
        }
    }
    echo "  Copied $count rows.\n";
}
echo "Done.\n";
