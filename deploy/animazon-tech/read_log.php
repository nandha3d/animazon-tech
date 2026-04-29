<?php
$log = file_get_contents('storage/logs/laravel.log');
echo substr($log, max(0, strlen($log) - 4000));
