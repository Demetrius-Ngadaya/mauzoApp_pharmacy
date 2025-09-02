<?php
include("session.php");
require('fpdf/fpdf.php');
include("dbcon.php");
error_reporting(1);

// Get search filters from URL
$d1 = isset($_GET['d1']) ? $_GET['d1'] : '';
$d2 = isset($_GET['d2']) ? $_GET['d2'] : '';
$deleted_by = isset($_GET['deleted_by']) ? $_GET['deleted_by'] : '';
$medicine_name = isset($_GET['medicine_name']) ? $_GET['medicine_name'] : '';
$category = isset($_GET['category']) ? $_GET['category'] : '';

// Build the query with filters
$query = "SELECT * FROM deleted_products WHERE 1=1";

if (!empty($d1) && !empty($d2)) {
    $query .= " AND deleted_date BETWEEN '$d1' AND '$d2'";
}

if (!empty($deleted_by)) {
    $query .= " AND deleted_by LIKE '%$deleted_by%'";
}

if (!empty($medicine_name)) {
    $query .= " AND medicine_name LIKE '%$medicine_name%'";
}

if (!empty($category)) {
    $query .= " AND category LIKE '%$category%'";
}

$query .= " ORDER BY deleted_date DESC";

$result = mysqli_query($con, $query);

// Create PDF instance (Landscape mode)
$pdf = new FPDF('L', 'mm', 'A4');
$pdf->AddPage();

// Set document information
$pdf->SetTitle('Ripoti ya Dawa Zilizofutwa');
$pdf->SetAuthor('MauzoApp');
$pdf->SetCreator('MauzoApp');

// Header
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, 'PP TIMBER', 0, 1, 'C');
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(0, 10, 'RIPOTI YA Dawa ZILIZOFUTWA', 0, 1, 'C');

// Date range and filters
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(0, 7, 'Muda: '.(!empty($d1) && !empty($d2) ? "Tarehe $d1 mpaka $d2" : "Siku yote"), 0, 1);

$filters = [];
if (!empty($deleted_by)) $filters[] = "Aliyefuta: $deleted_by";
if (!empty($medicine_name)) $filters[] = "Dawa: $medicine_name";
if (!empty($category)) $filters[] = "Aina: $category";

if (!empty($filters)) {
    $pdf->Cell(0, 7, 'Vichujio: '.implode(", ", $filters), 0, 1);
}

$pdf->Ln(5);

// Table header
$pdf->SetFont('Arial', 'B', 10);
$pdf->SetFillColor(230, 230, 230);
$pdf->Cell(10, 8, '#', 1, 0, 'C', true);
$pdf->Cell(25, 8, 'Tarehe', 1, 0, 'C', true);
$pdf->Cell(35, 8, 'Dawa', 1, 0, 'C', true);
$pdf->Cell(25, 8, 'Aina', 1, 0, 'C', true);
$pdf->Cell(20, 8, 'Iliyopo', 1, 0, 'C', true);
$pdf->Cell(20, 8, 'Iliyouzwa', 1, 0, 'C', true);
$pdf->Cell(25, 8, 'Bei ya Nunua', 1, 0, 'C', true);
$pdf->Cell(25, 8, 'Bei ya Kuuza', 1, 0, 'C', true);
$pdf->Cell(25, 8, 'Tarehe Expire', 1, 0, 'C', true);
$pdf->Cell(20, 8, 'Faida', 1, 0, 'C', true);
$pdf->Cell(30, 8, 'Msambazaji', 1, 0, 'C', true);
$pdf->Cell(25, 8, 'Aliyefuta', 1, 1, 'C', true);

// Table data
$pdf->SetFont('Arial', '', 9);
$serial_number = 1;
$total_profit = 0;

while($row = mysqli_fetch_array($result)) {
    // Extract numeric value from profit_price if it contains percentage
    $profit_value = is_numeric($row['profit_price']) ? $row['profit_price'] : floatval(preg_replace('/[^0-9.]/', '', $row['profit_price']));
    $total_profit += $profit_value;
    
    $pdf->Cell(10, 7, $serial_number++, 1, 0, 'C');
    $pdf->Cell(25, 7, $row['deleted_date'], 1, 0, 'C');
    $pdf->Cell(35, 7, $row['medicine_name'], 1, 0, 'L');
    $pdf->Cell(25, 7, $row['category'], 1, 0, 'L');
    $pdf->Cell(20, 7, $row['act_remain_quantity'], 1, 0, 'C');
    $pdf->Cell(20, 7, $row['used_quantity'], 1, 0, 'C');
    $pdf->Cell(25, 7, number_format($row['actual_price'], 2), 1, 0, 'R');
    $pdf->Cell(25, 7, number_format($row['selling_price'], 2), 1, 0, 'R');
    $pdf->Cell(25, 7, $row['expire_date'], 1, 0, 'C');
    $pdf->Cell(20, 7, $row['profit_price'], 1, 0, 'R'); // Original format
    $pdf->Cell(30, 7, $row['company'], 1, 0, 'L');
    $pdf->Cell(25, 7, $row['deleted_by'], 1, 1, 'L');
}

// Total row
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(205, 7, 'JUMLA', 1, 0, 'R');
$pdf->Cell(20, 7, number_format($total_profit, 2), 1, 1, 'R');

// Footer
$pdf->SetY(-15);
$pdf->SetFont('Arial', 'I', 8);
$pdf->Cell(0, 10, 'Imetolewa: '.date('d/m/Y H:i:s'), 0, 0, 'R');

// Output PDF
$pdf->Output('D', 'deleted_products_report_'.date('Y-m-d').'.pdf');
exit;
?>