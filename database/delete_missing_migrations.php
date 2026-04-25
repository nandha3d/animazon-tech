<?php
$mysql = new PDO('mysql:host=127.0.0.1;port=3306;dbname=u362580417_animazon', 'root', 'admin');
$tables = ['designations', 'employees', 'orders', 'credit_notes', 'debit_notes', 'time_trackers', 'chart_of_accounts', 'chart_of_account_sub_types', 'form_field_responses', 'track_photos', 'currencies'];

$deleted = 0;
foreach($tables as $t) {
    $stmt = $mysql->prepare("DELETE FROM migrations WHERE migration LIKE ?");
    $stmt->execute(["%create_{$t}_table"]);
    $deleted += $stmt->rowCount();
}
echo "Deleted $deleted migration records.\n";
