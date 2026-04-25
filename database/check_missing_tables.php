<?php
$sqlite = new PDO('sqlite:' . __DIR__ . '/database.sqlite');
$mysql = new PDO('mysql:host=127.0.0.1;port=3306;dbname=u362580417_animazon', 'root', 'admin');

$sqliteTables = $sqlite->query("SELECT name FROM sqlite_master WHERE type='table'")->fetchAll(PDO::FETCH_COLUMN);
$mysqlTables = $mysql->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);

$missingInMysql = array_diff($sqliteTables, $mysqlTables);

echo "Tables in SQLite but not in MySQL:\n";
print_r($missingInMysql);
