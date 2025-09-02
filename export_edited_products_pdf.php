<?php
include("session.php");

require('fpdf/fpdf.php');
include("dbcon.php");
error_reporting(0);

// Get filter parameters
$d1 = $_GET['d1'] ?? '';
$d2 = $_GET['d2'] ?? '';
$edited_by = $_GET['edited_by'] ?? '';
$medicine_name = $_GET['medicine_name'] ?? '';
$category = $_GET['category'] ?? '';

// Build query with filters
$query = "SELECT * FROM edited_products WHERE 1=1";

$filter_text = "";
if (!empty($d1) && !empty($d2)) {
    $query .= " AND edited_date BETWEEN '$d1' AND '$d2'";
    $filter_text = "Kutoka $d1 mpaka $d2";
} elseif (!empty($d1)) {
    $query .= " AND edited_date >= '$d1'";
    $filter_text = "Kuanzia $d1";
} elseif (!empty($d2)) {
    $query .= " AND edited_date <= '$d2'";
    $filter_text = "Mpaka $d2";
}

if (!empty($edited_by)) {
    $query .= " AND edited_by LIKE '%$edited_by%'";
    $filter_text .= (!empty($filter_text)) ? "\nAliyehariri: $edited_by" : "Aliyehariri: $edited_by";
}

if (!empty($medicine_name)) {
    $query .= " AND medicine_name LIKE '%$medicine_name%'";
    $filter_text .= (!empty($filter_text) )? "\nDawa: $medicine_name" : "Dawa: $medicine_name";
}

if (!empty($category)) {
    $query .= " AND category LIKE '%$category%'";
    $filter_text .= (!empty($filter_text)) ? "\nAina: $category" : "Aina: $category";
}

$query .= " ORDER BY edited_date DESC";
$result = mysqli_query($con, $query);

// Create PDF
$pdf = new FPDF('L','mm','A4');
$pdf->AddPage();

// Company Header
$pdf->SetFont('Arial','B',16);
$pdf->Cell(0,10,'PP TIMBER',0,1,'C');
$pdf->SetFont('Arial','B',14);
$pdf->Cell(0,10,'RIPOTI YA Dawa ZILIZOHARIRIWA',0,1,'C');

// Filter information
$pdf->SetFont('Arial','',10);
if (!empty($filter_text)) {
    $pdf->MultiCell(0,8,$filter_text,0,'L');
}
$pdf->Cell(0,8,'Tarehe ya Utoaji: '.date('d/m/Y H:i:s'),0,1,'L');
$pdf->Ln(5);

// Table header
$pdf->SetFont('Arial','B',10);
$pdf->Cell(10,7,'#',1,0,'C');
$pdf->Cell(30,7,'Tarehe',1,0,'C');
$pdf->Cell(50,7,'Dawa',1,0,'C');
$pdf->Cell(30,7,'Aina',1,0,'C');
$pdf->Cell(25,7,'Idadi Kabla',1,0,'C');
$pdf->Cell(25,7,'Idadi Baada',1,0,'C');
$pdf->Cell(40,7,'Aliyehariri',1,0,'C');
$pdf->Cell(40,7,'Sababu',1,1,'C');

// Table data
$pdf->SetFont('Arial','',9);
$count = 1;
while ($row = mysqli_fetch_assoc($result)) {
    $pdf->Cell(10,7,$count++,1,0,'C');
    $pdf->Cell(30,7,$row['edited_date'],1,0,'C');
    $pdf->Cell(50,7,$row['medicine_name'],1,0,'L');
    $pdf->Cell(30,7,$row['category'],1,0,'L');
    $pdf->Cell(25,7,$row['old_quantity'],1,0,'R');
    $pdf->Cell(25,7,$row['act_remain_quantity'],1,0,'R');
    $pdf->Cell(40,7,$row['edited_by'],1,0,'L');
    $pdf->Cell(40,7,$row['edit_reason'],1,1,'L');
}

// Output PDF
$pdf->Output('D','REAL_INVESTMENT_Dawa_zilizohaririwa_'.date('Y-m-d').'.pdf');
exit;
?>