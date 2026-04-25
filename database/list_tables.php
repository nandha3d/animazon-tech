<?php
$db = new SQLite3(__DIR__ . '/database.sqlite');
$r = $db->query("SELECT name FROM sqlite_master WHERE type='table' ORDER BY name");
while($row = $r->fetchArray()) {
    echo $row[0] . PHP_EOL;
}
