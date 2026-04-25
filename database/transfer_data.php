<?php
$sqlitePath = __DIR__ . '/database.sqlite';

$sqlite = new PDO('sqlite:' . $sqlitePath);
$sqlite->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$mysql = new PDO('mysql:host=127.0.0.1;port=3306;dbname=u362580417_animazon', 'root', 'admin');
$mysql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// 1. Ensure cost_estimates table exists in MySQL
$costEstimatesSql = "CREATE TABLE IF NOT EXISTS `cost_estimates` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `client_id` int DEFAULT NULL,
  `project_type_id` int NOT NULL,
  `project_name` varchar(191) NOT NULL,
  `visitor_name` varchar(191) DEFAULT NULL,
  `visitor_email` varchar(191) DEFAULT NULL,
  `visitor_phone` varchar(191) DEFAULT NULL,
  `base_cost` decimal(15,2) NOT NULL DEFAULT '0.00',
  `total_cost` decimal(15,2) NOT NULL DEFAULT '0.00',
  `tax_percentage` decimal(5,2) NOT NULL DEFAULT '0.00',
  `tax_amount` decimal(15,2) NOT NULL DEFAULT '0.00',
  `grand_total` decimal(15,2) NOT NULL DEFAULT '0.00',
  `timeline_weeks` int DEFAULT NULL,
  `team_size` int DEFAULT NULL,
  `status` enum('draft','sent','accepted','rejected') NOT NULL DEFAULT 'draft',
  `notes` text,
  `sent_at` datetime DEFAULT NULL,
  `accepted_at` datetime DEFAULT NULL,
  `rejected_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `currency_code` varchar(3) NOT NULL DEFAULT 'USD',
  `document_path` varchar(191) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
$mysql->exec($costEstimatesSql);

// 2. Ensure cost_estimate_answers table exists in MySQL
$costEstimateAnswersSql = "CREATE TABLE IF NOT EXISTS `cost_estimate_answers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `cost_estimate_id` bigint unsigned NOT NULL,
  `question_id` int NOT NULL,
  `answer_id` int NOT NULL,
  `custom_value` varchar(191) DEFAULT NULL,
  `cost_impact` decimal(15,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
$mysql->exec($costEstimateAnswersSql);

$tablesToCopy = [
    'landing_page_settings',
    'product_service_categories',
    'product_services',
    'cost_calculator_questions',
    'cost_calculator_answers',
    'cost_estimates',
    'cost_estimate_answers'
];

foreach ($tablesToCopy as $table) {
    echo "Copying table $table...\n";
    
    // Truncate MySQL table
    try {
        $mysql->exec("SET FOREIGN_KEY_CHECKS=0");
        $mysql->exec("TRUNCATE TABLE `$table`");
        $mysql->exec("SET FOREIGN_KEY_CHECKS=1");
    } catch (Exception $e) {
        echo "Error truncating $table: " . $e->getMessage() . "\n";
    }

    // Get rows from SQLite
    $stmt = $sqlite->query("SELECT * FROM `$table`");
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($rows)) {
        echo "  Table is empty.\n";
        continue;
    }

    $columns = array_keys($rows[0]);
    $colList = implode("`, `", $columns);
    $placeholders = implode(", ", array_fill(0, count($columns), "?"));

    $insertSql = "INSERT INTO `$table` (`$colList`) VALUES ($placeholders)";
    $insertStmt = $mysql->prepare($insertSql);

    $count = 0;
    foreach ($rows as $row) {
        try {
            $insertStmt->execute(array_values($row));
            $count++;
        } catch (Exception $e) {
            echo "Error inserting row into $table: " . $e->getMessage() . "\n";
        }
    }
    
    echo "  Copied $count rows.\n";
}

echo "Data transfer complete.\n";
