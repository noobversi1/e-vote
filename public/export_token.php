<?php
require '../vendor/autoload.php';
include_once '../config/database.php';
include_once '../objects/Token.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$database = new Database();
$db = $database->getConnection();

$token = new Token($db);

// Mengambil data token
$query = "SELECT * FROM token";
$stmt = $db->prepare($query);
$stmt->execute();
$tokens = $stmt->fetchAll(PDO::FETCH_ASSOC);

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setCellValue('A1', 'Token');
$sheet->setCellValue('B1', 'Status');

$row = 2;
foreach ($tokens as $token) {
    $sheet->setCellValue('A' . $row, $token['token']);
    $sheet->setCellValue('B' . $row, $token['status'] ? 'Digunakan' : 'Belum Digunakan');
    $row++;
}

$writer = new Xlsx($spreadsheet);
$filename = 'tokens.xlsx';
$writer->save($filename);

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="' . $filename . '"');
header('Cache-Control: max-age=0');
$writer->save('php://output');
exit();
