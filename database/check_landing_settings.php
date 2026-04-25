<?php
$db = new SQLite3(__DIR__ . '/database.sqlite');
$r = $db->query("SELECT name FROM landing_page_settings");
while($row = $r->fetchArray()) {
    echo $row['name'] . "\n";
}
