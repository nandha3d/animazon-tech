<?php
while (true) {
    echo "Running migrate...\n";
    $output = shell_exec("php artisan migrate --force 2>&1");
    if (strpos($output, "already exists") !== false && preg_match("/Table '([^']+)' already exists/", $output, $matches)) {
        $table = $matches[1];
        echo "Found existing table: $table\n";
        // Find the migration file for this table
        $files = glob("database/migrations/*_{$table}_table.php");
        if (empty($files)) {
            // Attempt another pattern
            $files = glob("database/migrations/*create_{$table}_table.php");
        }
        if ($table === 'permissions') {
            $files = glob("database/migrations/*create_permission_tables.php");
        }
        if (!empty($files)) {
            $migration = str_replace(".php", "", basename($files[0]));
            echo "Marking $migration as run.\n";
            shell_exec("php artisan tinker --execute=\"DB::table('migrations')->insert(['migration' => '$migration', 'batch' => 99]);\"");
        } else {
            echo "Could not find migration for $table\n";
            file_put_contents("migrate_error.log", $output);
            break;
        }
    } else {
        echo $output;
        break;
    }
}
