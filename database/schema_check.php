<?php
$db = new SQLite3(__DIR__ . '/database.sqlite');
echo $db->querySingle("SELECT sql FROM sqlite_master WHERE type='table' AND name='cost_estimates'");
