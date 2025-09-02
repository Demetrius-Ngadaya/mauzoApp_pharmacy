<?php
require('fpdf/fpdf.php');
include("dbcon.php");
include("session.php");
$search_params = isset($_SESSION['search_params']) ? $_SESSION['search_params'] : [];
// Get filter parameters from URL
// Get parameters from session instead of GET
$d1 = isset($search_params['d1']) ? $search_params['d1'] : '';
$d2 = isset($search_params['d2']) ? $search_params['d2'] : '';
$created_by = isset($search_params['created_by']) ? $search_params['created_by'] : '';
$medicine = isset($search_params['medicine']) ? $search_params['medicine'] : '';
$category = isset($search_params['category']) ? $search_params['category'] : '';
$store_location = isset($search_params['store_location']) ? $search_params['store_location'] : '';
$hali_ya_malipo = isset($search_params['hali_ya_malipo']) ? $search_params['hali_ya_malipo'] : '';
$payment_method = isset($search_params['payment_method']) ? $search_params['payment_method'] : '';


// Create PDF
$pdf = new FPDF('L', 'mm', 'A4');
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);

// Company Header
$pdf->Cell(0, 10, 'PP TIMBER', 0, 1, 'C');
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(0, 10, 'RIPOTI YA MAUZO', 0, 1, 'C');

// Date range and filters
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(0, 8, 'Kutoka: ' . ($d1 ? date('d/m/Y', strtotime($d1)) : '') . ' - Mpaka: ' . ($d2 ? date('d/m/Y', strtotime($d2)) : ''), 0, 1, 'L');

// Show applied filters
$filters = [];
if (!empty($created_by)) $filters[] = "Muuzaji: $created_by";
if (!empty($medicine)) $filters[] = "Dawa: $medicine";
if (!empty($category)) $filters[] = "Aina: $category";
if (!empty($store_location)) $filters[] = "Mahali: $store_location";

if (!empty($filters)) {
    $pdf->Cell(0, 8, 'Filters: ' . implode(', ', $filters), 0, 1, 'L');
}

// Generate date
$pdf->Cell(0, 8, 'Tarehe ya ripoti: ' . date('d/m/Y H:i:s'), 0, 1, 'L');
$pdf->Ln(5);

// Table header
$pdf->SetFont('Arial', 'B', 10);
$pdf->SetFillColor(200, 220, 255);
$pdf->Cell(10, 10, '#', 1, 0, 'C', true);
$pdf->Cell(25, 10, 'Tarehe', 1, 0, 'C', true);
$pdf->Cell(40, 10, 'Dawa', 1, 0, 'C', true);
$pdf->Cell(15, 10, 'Idadi', 1, 0, 'C', true);
$pdf->Cell(25, 10, 'Kiasi', 1, 0, 'C', true);
$pdf->Cell(25, 10, 'Faida', 1, 0, 'C', true);
$pdf->Cell(30, 10, 'Aliyeuza', 1, 0, 'C', true);
$pdf->Cell(30, 10, 'Mteja', 1, 0, 'C', true);
$pdf->Cell(30, 10, 'Njia ya malipo', 1, 0, 'C', true);
$pdf->Cell(30, 10, 'Hali ya malipo', 1, 0, 'C', true);
$pdf->Cell(30, 10, 'Tawi', 1, 1, 'C', true);


// Query data
$select_sql = "SELECT sales.*, stores.location FROM sales 
  JOIN stores ON sales.store_id = stores.id 
  WHERE 1=1";

if (!empty($d1) && !empty($d2)) {
    $select_sql .= " AND Date BETWEEN '$d1' AND '$d2'";
}
if (!empty($created_by)) {
    $select_sql .= " AND created_by LIKE '%$created_by%'";
}
if (!empty($medicine)) {
    $select_sql .= " AND medicines LIKE '%$medicine%'";
}
if (!empty($category)) {
    $select_sql .= " AND category LIKE '%$category%'";
}
if (!empty($store_location)) {
    $select_sql .= " AND stores.location LIKE '%$store_location%'";
}

$select_sql .= " ORDER BY Date DESC";

$select_query = mysqli_query($con, $select_sql);

// Initialize totals
$total_quantity = 0;
$total_amount = 0;
$total_profit = 0;

// Table rows
$pdf->SetFont('Arial', '', 8);
$counter = 1;
while($row = mysqli_fetch_array($select_query)) {
    $pdf->Cell(10, 8, $counter++, 1, 0, 'C');
    $pdf->Cell(25, 8, date('d/m/Y', strtotime($row['Date'])), 1, 0, 'C');
    $pdf->Cell(40, 8, $row['medicines'], 1, 0, 'L');
    $pdf->Cell(15, 8, $row['quantity'], 1, 0, 'R');
    $pdf->Cell(25, 8, number_format($row['total_amount']), 1, 0, 'R');
    $pdf->Cell(25, 8, number_format($row['total_profit']), 1, 0, 'R');
    $pdf->Cell(30, 8, $row['created_by'], 1, 0, 'L');
    $pdf->Cell(30, 8, $row['customer_name'], 1, 0, 'L');
    $pdf->Cell(30, 8, $row['payment_method'], 1, 0, 'L');
    $pdf->Cell(30, 8, $row['hali_ya_malipo'], 1, 0, 'L');
    $pdf->Cell(30, 8, $row['location'], 1, 1, 'L');

    
    $total_quantity += $row['quantity'];
    $total_amount += $row['total_amount'];
    $total_profit += $row['total_profit'];
}

// Totals row
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(80, 8, 'Jumla Mkuu:', 1, 0, 'R');
$pdf->Cell(15, 8, number_format($total_quantity), 1, 0, 'R');
$pdf->Cell(25, 8, number_format($total_amount), 1, 0, 'R');
$pdf->Cell(25, 8, number_format($total_profit), 1, 0, 'R');
$pdf->Cell(120, 8, '', 1, 1, 'L');

// Set headers for download
header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="Ripoti_ya_mauzo_'.date('Ymd_His').'.pdf"');

// Output PDF directly for download
$pdf->Output('D', 'Ripoti_ya_mauzo_'.date('Ymd_His').'.pdf');
?>