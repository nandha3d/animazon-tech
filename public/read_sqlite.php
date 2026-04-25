<?php
$db = new PDO('sqlite:' . __DIR__ . '/../database/database.sqlite');
$stmt = $db->query("SELECT value FROM settings WHERE name='portfolios'");
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if ($row) {
    echo $row['value'];
} else {
    // Try landing_page_settings
    $stmt = $db->query("SELECT value FROM landing_page_settings WHERE name='portfolios'");
    if ($stmt) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        echo $row ? $row['value'] : 'Not found';
    } else {
        echo 'Not found';
    }
}
