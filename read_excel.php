<?php
require 'vendor/autoload.php';

$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Xlsx');
$spreadsheet = $reader->load('E-Commerce Feature Matrix.xlsx');

foreach ($spreadsheet->getSheetNames() as $sheetName) {
    echo "=== SHEET: $sheetName ===" . PHP_EOL;
    $sheet = $spreadsheet->getSheetByName($sheetName);
    $data = $sheet->toArray(null, true, true, true);
    foreach ($data as $rowNum => $row) {
        $line = "$rowNum: ";
        foreach ($row as $col => $val) {
            if ($val !== null && $val !== '') {
                $line .= "$col=$val | ";
            }
        }
        if (trim($line, ': ') !== "$rowNum:") {
            echo $line . PHP_EOL;
        }
    }
    echo PHP_EOL;
}
