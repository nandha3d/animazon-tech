<?php
$pdo = new PDO('mysql:host=127.0.0.1;port=3306;dbname=u362580417_animazon', 'root', 'admin');

echo "=== Portfolio / Landing Page Settings ===\n";
$r = $pdo->query("SELECT name, value FROM landing_page_settings WHERE name LIKE '%portfolio%' OR name LIKE '%discover%' OR name LIKE '%feature%'");
while($row = $r->fetch(PDO::FETCH_ASSOC)) {
    echo $row['name'] . ': ' . substr($row['value'], 0, 150) . "...\n";
}
