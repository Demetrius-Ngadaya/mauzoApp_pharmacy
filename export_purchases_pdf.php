<?php
include("session.php");

require('fpdf/fpdf.php');
include("dbcon.php");

// Get all filter parameters from URL
$invoice_number = isset($_GET['invoice_number']) ? $_GET['invoice_number'] : '';
$d1 = isset($_GET['d1']) ? $_GET['d1'] : '';
$d2 = isset($_GET['d2']) ? $_GET['d2'] : '';
$created_by = isset($_GET['created_by']) ? $_GET['created_by'] : '';
$company_filter = isset($_GET['company']) ? $_GET['company'] : '';
$medicine_name = isset($_GET['medicine_name']) ? $_GET['medicine_name'] : '';
$category = isset($_GET['category']) ? $_GET['category'] : '';
$status = isset($_GET['status']) ? $_GET['status'] : '';
$store_location = isset($_GET['store_location']) ? $_GET['store_location'] : '';

// Build the query with filters
$select_sql = "SELECT purchases_report.*, stores.location 
               FROM purchases_report 
               LEFT JOIN stores ON purchases_report.store_id = stores.id 
               WHERE 1=1";

if (!empty($d1) && !empty($d2)) {
    $select_sql .= " AND received_date BETWEEN '$d1' AND '$d2'";
}
if (!empty($created_by)) {
    $select_sql .= " AND created_by LIKE '%$created_by%'";
}
if (!empty($company_filter)) {
    $select_sql .= " AND company LIKE '%$company_filter%'";
}
if (!empty($medicine_name)) {
    $select_sql .= " AND medicine_name LIKE '%$medicine_name%'";
}
if (!empty($category)) {
    $select_sql .= " AND category LIKE '%$category%'";
}
if (!empty($status)) {
    $select_sql .= " AND status LIKE '%$status%'";
}
if (!empty($store_location)) {
    $select_sql .= " AND stores.location LIKE '%$store_location%'";
}


$select_sql .= " ORDER BY received_date DESC";
$query = mysqli_query($con, $select_sql);

// Create PDF
$pdf = new FPDF('L','mm','A4');
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);

// Company Name
$pdf->Cell(0,10,'PP TIMBER',0,1,'C');
$pdf->SetFont('Arial','B',14);

// Report Title
$pdf->Cell(0,10,'Ripoti ya Manunuzi ya Dawa',0,1,'C');
$pdf->SetFont('Arial','',10);

// Download date
$pdf->Cell(0,10,'Tarehe ya kupakua: '.date('d-m-Y H:i:s'),0,1,'L');

// Applied filters
$filters = [];
if (!empty($d1) && !empty($d2)) $filters[] = "Muda: $d1 mpaka $d2";
if (!empty($created_by)) $filters[] = "Mrekodi: $created_by";
if (!empty($company_filter)) $filters[] = "Msambazaji: $company_filter";
if (!empty($medicine_name)) $filters[] = "Dawa: $medicine_name";
if (!empty($category)) $filters[] = "Aina: $category";
if (!empty($status)) $filters[] = "Hali: $status";
if (!empty($store_location)) $filters[] = "Mahali: $store_location";


if (!empty($filters)) {
    $pdf->Cell(0,10,'Vichujio: '.implode(", ", $filters),0,1,'L');
}

// Add some space
$pdf->Ln(5);

// Table headers
$pdf->SetFont('Arial','B',10);
$pdf->Cell(10,10,'#',1,0,'C');
$pdf->Cell(25,10,'Tarehe',1,0,'C');
$pdf->Cell(30,10,'Dawa',1,0,'C');
$pdf->Cell(25,10,'Tawi/Kituo',1,0,'C');
$pdf->Cell(20,10,'Zamani',1,0,'C');
$pdf->Cell(20,10,'Mpya',1,0,'C');
$pdf->Cell(20,10,'Bei',1,0,'C');
$pdf->Cell(25,10,'Jumla',1,0,'C');
$pdf->Cell(25,10,'Faida',1,0,'C');
$pdf->Cell(30,10,'Msambazaji',1,0,'C');
$pdf->Cell(25,10,'Mrekodi',1,0,'C');
$pdf->Cell(20,10,'Hali',1,1,'C');
// $pdf->Cell(25,10,'Mahali',1,1,'C');


// Table data
$pdf->SetFont('Arial','',8);
$counter = 1;
$total_sum = 0;

while($row = mysqli_fetch_array($query)) {
    $total = $row['received_quantity'] * $row['actual_price'];
    $total_sum += $total;
    
    $pdf->Cell(10,8,$counter++,1,0,'C');
    $pdf->Cell(25,8,$row['received_date'],1,0,'C');
    $pdf->Cell(30,8,$row['medicine_name'],1,0,'L');
    $pdf->Cell(25,8,$row['location'],1,0,'L');
    $pdf->Cell(20,8,$row['old_quantity'],1,0,'R');
    $pdf->Cell(20,8,$row['received_quantity'],1,0,'R');
    $pdf->Cell(20,8,number_format($row['actual_price']),1,0,'R');
    $pdf->Cell(25,8,number_format($total),1,0,'R');
    $pdf->Cell(25,8,number_format($row['expected_profit']),1,0,'R');
    $pdf->Cell(30,8,$row['company'],1,0,'L');
    $pdf->Cell(25,8,$row['created_by'],1,0,'L');
    $pdf->Cell(20,8,$row['status'],1,1,'L');
    // $pdf->Cell(25,8,$row['location'],1,1,'L');
}

// Total row
$pdf->SetFont('Arial','B',10);
$pdf->Cell(200,8,'JUMLA YA PESA ',1,0,'R'); 
$pdf->Cell(25,8,number_format($total_sum).' Tsh',1,0,'R');
$pdf->Cell(45,8,'',1,1,'C');

// Output PDF
$pdf->Output('D', 'manunuzi_report_'.date('Y-m-d').'.pdf');
?>