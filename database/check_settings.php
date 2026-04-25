<?php
$db = new SQLite3(__DIR__ . '/database.sqlite');
$r = $db->query("SELECT name FROM settings");
while($row = $r->fetchArray()) {
    echo $row['name'] . "\n";
}
