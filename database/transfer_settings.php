<?php
$sqlitePath = __DIR__ . '/database.sqlite';

$sqlite = new PDO('sqlite:' . $sqlitePath);
$sqlite->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$mysql = new PDO('mysql:host=127.0.0.1;port=3306;dbname=u362580417_animazon', 'root', 'admin');
$mysql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$settingsToCopy = [
    'portfolios',
    'home_hero',
    'site_logo',
    'company_logo_dark',
    'company_logo_light',
    'company_favicon',
    'mission_vision',
    'title_text',
    'footer_text',
    'color',
    'cust_theme_bg',
    'cust_darklayout'
];

$placeholders = implode(',', array_fill(0, count($settingsToCopy), '?'));
$stmt = $sqlite->prepare("SELECT * FROM settings WHERE name IN ($placeholders)");
$stmt->execute($settingsToCopy);
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

$count = 0;
foreach ($rows as $row) {
    // MySQL replace or insert
    $name = $row['name'];
    $value = $row['value'];
    // In MySQL, settings table usually has id, name, value, created_by, created_at, updated_at
    // But let's check its schema in mysql first, or just do an update or insert
    
    // Check if exists
    $check = $mysql->prepare("SELECT COUNT(*) FROM settings WHERE name = ?");
    $check->execute([$name]);
    $exists = $check->fetchColumn() > 0;
    
    if ($exists) {
        $update = $mysql->prepare("UPDATE settings SET value = ? WHERE name = ?");
        $update->execute([$value, $name]);
    } else {
        $insert = $mysql->prepare("INSERT INTO settings (name, value, created_by) VALUES (?, ?, 1)");
        $insert->execute([$name, $value]);
    }
    $count++;
}

echo "Settings transfer complete. Copied $count rows.\n";
