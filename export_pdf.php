<?php
// Include database connection file
include("dbcon.php");

// Include FPDF library
require('fpdf/fpdf.php');

// Fetch data between specified dates and other filters
$d1 = $_GET['d1'];
$d2 = $_GET['d2'];
$created_by = isset($_GET['created_by']) ? $_GET['created_by'] : '';
$medicine = isset($_GET['medicine']) ? $_GET['medicine'] : '';
$category = isset($_GET['category']) ? $_GET['category'] : '';

// Initialize the SQL query
$select_sql = "SELECT * FROM sales WHERE Date BETWEEN '$d1' AND '$d2'";

// Append additional filters if they are provided
if (!empty($created_by)) {
    $select_sql .= " AND created_by LIKE '%$created_by%'";
}
if (!empty($medicine)) {
    $select_sql .= " AND medicines LIKE '%$medicine%'";
}
if (!empty($category)) {
    $select_sql .= " AND category LIKE '%$category%'";
}

$select_sql .= " ORDER BY Date DESC";
$select_query = mysqli_query($con, $select_sql);

// Initialize FPDF
$pdf = new FPDF();
$pdf->AddPage();

// Set font for the entire document
$pdf->SetFont('Arial', '', 12);

// Add a title
$pdf->Cell(0, 10, 'PP TIMBER', 0, 1, 'C');
$pdf->Cell(0, 10, 'Ripoti ya mauzo', 0, 1, 'C');

// Add a line break
$pdf->Ln(10);

// Add a table header
$pdf->Cell(10, 10, 'No', 1, 0, 'C');  // Serial number column
$pdf->Cell(30, 10, 'Tarehe', 1, 0, 'C');
$pdf->Cell(40, 10, 'Mbao', 1, 0, 'C');
$pdf->Cell(30, 10, 'Idadi', 1, 0, 'C');
$pdf->Cell(30, 10, 'Pesa', 1, 0, 'C');
$pdf->Cell(30, 10, 'Faida', 1, 0, 'C');
$pdf->Cell(38, 10, 'Aliyeuza', 1, 0, 'C');
$pdf->Cell(30, 10, 'Invoice', 1, 1, 'C');

// Initialize the serial number
$serial_number = 1;

// Add data from the database
while ($row = mysqli_fetch_array($select_query)) {
    $pdf->Cell(10, 10, $serial_number++, 1, 0, 'C');  // Print serial number and increment it
    $pdf->Cell(30, 10, $row['Date'], 1, 0, 'C');
    $pdf->Cell(40, 10, $row['medicines'], 1, 0, 'C');
    $pdf->Cell(30, 10, $row['quantity'], 1, 0, 'C');
    $pdf->Cell(30, 10, number_format($row['total_amount'], 2), 1, 0, 'C'); // Format amount
    $pdf->Cell(30, 10, number_format($row['total_profit'], 2), 1, 0, 'C'); // Format profit
    $pdf->Cell(38, 10, $row['created_by'], 1, 0, 'C');
    $pdf->Cell(30, 10, $row['invoice_number'], 1, 1, 'C');
}

// Fetch the sum of total_amount and total_profit
$sum_sql = "SELECT SUM(total_amount) AS total_amount_sum, SUM(total_profit) AS total_profit_sum FROM sales WHERE Date BETWEEN '$d1' AND '$d2'";
if (!empty($created_by)) {
    $sum_sql .= " AND created_by LIKE '%$created_by%'";
}
if (!empty($medicine)) {
    $sum_sql .= " AND medicines LIKE '%$medicine%'";
}
if (!empty($category)) {
    $sum_sql .= " AND category LIKE '%$category%'";
}
$sum_query = mysqli_query($con, $sum_sql);
$sum_row = mysqli_fetch_array($sum_query);

$total_amount_sum = $sum_row['total_amount_sum'];
$total_profit_sum = $sum_row['total_profit_sum'];

// Add a line break before the summary
$pdf->Ln(10);

// Add summary for total_amount and total_profit
$pdf->Cell(0, 10, 'Jumla Kuu:', 0, 1, 'C');
$pdf->Cell(0, 10, 'Jumla ya pesa: ' . number_format($total_amount_sum, 2) . ' Tsh', 0, 1, 'C');
$pdf->Cell(0, 10, 'Jumla ya faida: ' . number_format($total_profit_sum, 2) . ' Tsh', 0, 1, 'C');

// Output PDF
$pdf->Output('ripoti ya mauzo.pdf', 'D');
?>
