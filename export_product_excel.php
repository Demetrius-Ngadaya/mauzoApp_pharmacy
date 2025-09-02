<?php
require 'vendor/autoload.php';
include("dbcon.php");

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

$sheet->setCellValue('A1', 'Dawa');
$sheet->setCellValue('B1', 'Aina ya Dawa');
$sheet->setCellValue('C1', 'Msambazaji');
$sheet->setCellValue('D1', 'Idadi iliyosajiriwa');
$sheet->setCellValue('E1', 'Idadi iliyouzwa');
$sheet->setCellValue('F1', 'Idadi iliyobaki');
$sheet->setCellValue('G1', 'Tarehe iliyosajiliwa');
$sheet->setCellValue('H1', 'Tarehe mwisho wa matumizi');
$sheet->setCellValue('I1', 'Bei ya kununuliwa');
$sheet->setCellValue('J1', 'Bei ya kuuzia');
$sheet->setCellValue('K1', 'Faida');

$sql = "SELECT * FROM stock ORDER BY id";
$result = mysqli_query($con, $sql);

$rowCount = 2;
while ($row = mysqli_fetch_array($result)) {
    $sheet->setCellValue('A' . $rowCount, $row['medicine_name']);
    $sheet->setCellValue('B' . $rowCount, $row['category']);
    $sheet->setCellValue('C' . $rowCount, $row['company']);
    $sheet->setCellValue('D' . $rowCount, $row['quantity']);
    $sheet->setCellValue('E' . $rowCount, $row['used_quantity']);
    $sheet->setCellValue('F' . $rowCount, $row['act_remain_quantity']);
    $sheet->setCellValue('G' . $rowCount, date("d-m-Y", strtotime($row['register_date'])));
    $sheet->setCellValue('H' . $rowCount, date("d-m-Y", strtotime($row['expire_date'])));
    $sheet->setCellValue('I' . $rowCount, $row['actual_price']);
    $sheet->setCellValue('J' . $rowCount, $row['selling_price']);
    $sheet->setCellValue('K' . $rowCount, $row['profit_price']);
    $rowCount++;
}

$writer = new Xlsx($spreadsheet);
$filename = 'stock_data.xlsx';

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'. $filename .'"');
header('Cache-Control: max-age=0');

$writer->save('php://output');
exit;
?>
