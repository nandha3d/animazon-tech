<?php
$sqlite = new PDO('sqlite:' . __DIR__ . '/database.sqlite');
$mysql = new PDO('mysql:host=127.0.0.1;port=3306;dbname=u362580417_animazon', 'root', 'admin');

$sqliteMigrations = $sqlite->query("SELECT migration FROM migrations")->fetchAll(PDO::FETCH_COLUMN);
$mysqlMigrations = $mysql->query("SELECT migration FROM migrations")->fetchAll(PDO::FETCH_COLUMN);

$missingInMysql = array_diff($sqliteMigrations, $mysqlMigrations);

$stmt = $mysql->prepare("INSERT INTO migrations (migration, batch) VALUES (?, 1)");
$count = 0;
foreach ($missingInMysql as $mig) {
    try {
        $stmt->execute([$mig]);
        $count++;
    } catch (Exception $e) {
        // ignore
    }
}

echo "Synced $count migrations to MySQL.\n";
