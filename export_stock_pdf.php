<?php
// Ensure no output is sent before PDF generation
ob_start();
include("dbcon.php");
require('fpdf/fpdf.php');

class PDF extends FPDF {
    // Improved circle/arc implementation for FPDF
    function Arc($x, $y, $rx, $ry, $startAngle=0, $endAngle=360) {
        $startAngle = deg2rad($startAngle);
        $endAngle = deg2rad($endAngle);
        $angleStep = 0.05;
        $angle = $startAngle;
        
        $this->MoveTo($x + $rx * cos($angle), $y + $ry * sin($angle));
        while ($angle < $endAngle) {
            $angle += $angleStep;
            if ($angle > $endAngle) $angle = $endAngle;
            $this->LineTo($x + $rx * cos($angle), $y + $ry * sin($angle));
        }
    }
    
    function MoveTo($x, $y) {
        $this->_out(sprintf('%.2F %.2F m', $x*$this->k, ($this->h-$y)*$this->k));
    }
    
    function LineTo($x, $y) {
        $this->_out(sprintf('%.2F %.2F l', $x*$this->k, ($this->h-$y)*$this->k));
    }

    function DrawCircle($x, $y, $r) {
        $this->Arc($x, $y, $r, $r, 0, 360);
        $this->_out('s');
    }

    function CircularImage($x, $y, $r, $file) {
        $this->Image($file, $x-$r, $y-$r, $r*2, $r*2, 'PNG');
        $this->SetDrawColor(255, 255, 255);
        $this->SetFillColor(255, 255, 255);
        $this->DrawCircle($x, $y, $r);
        $this->_out('f');
        $this->SetDrawColor(0, 0, 0);
        $this->DrawCircle($x, $y, $r);
    }
    
    function GetCenteredX($content_width) {
        return max(20, ($this->GetPageWidth() - $content_width) / 2); // Increased minimum margin
    }
    
    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Ukurasa '.$this->PageNo().'/{nb}', 0, 0, 'C');
    }
}

// Get filter parameters
$created_by = isset($_GET['created_by']) ? urldecode($_GET['created_by']) : '';
$medicine_name = isset($_GET['medicine_name']) ? urldecode($_GET['medicine_name']) : '';
$company = isset($_GET['company']) ? urldecode($_GET['company']) : '';
$category = isset($_GET['category']) ? urldecode($_GET['category']) : '';
$store_location = isset($_GET['store_location']) ? urldecode($_GET['store_location']) : '';

// Initialize totals with proper numeric types
$totals = [
    'quantity' => 0,
    'sold' => 0,
    'remain' => 0,
    'value_act' => 0.0,
    'value_sell' => 0.0
];

// Create PDF in landscape mode
$pdf = new PDF('L');
$pdf->AliasNbPages();
$pdf->AddPage();

// Logo and header setup with better positioning
$logo_radius = 15;
$left_logo_x = 30;  // Increased from 15 for better margin
$right_logo_x = $pdf->GetPageWidth() - 30;  // Increased from 15 for better margin
$logo_y = 20;  // Slightly lowered from 15

if (file_exists('images/logo2.png')) {
    $pdf->CircularImage($left_logo_x, $logo_y, $logo_radius, 'images/logo2.png');
} else {
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Text($left_logo_x-$logo_radius, $logo_y, 'LOGO');
}

if (file_exists('images/technet.png')) {
    $pdf->CircularImage($right_logo_x, $logo_y, $logo_radius, 'images/technet.png');
} else {
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Text($right_logo_x-$logo_radius, $logo_y, 'TECHNET');
}

// Company name and title with better positioning
$pdf->SetFont('Arial', 'B', 14);
$pdf->SetXY(0, $logo_y + 15);  // Positioned below logos
$pdf->Cell(0, 10, 'PP TIMBER', 0, 1, 'C');

$pdf->SetFont('Arial', '', 12);
$pdf->SetXY(0, $logo_y + 25);  // Positioned below company name
$pdf->Cell(0, 10, 'Ripoti ya Dawa', 0, 1, 'C');

// Filter information
$filter_text = implode(' ', array_filter([
    $created_by ? 'Aliyeingiza: '.$created_by : '',
    $medicine_name ? 'Dawa: '.$medicine_name : '',
    $company ? 'Msambazaji: '.$company : '',
    $category ? 'Aina: '.$category : ''
]));

if ($filter_text) {
    $pdf->SetFont('Arial', '', 10);
    $pdf->SetXY(0, $logo_y + 35);  // Positioned below title
    $pdf->Cell(0, 10, 'Filtari: '.$filter_text, 0, 1, 'C');
}

$pdf->Ln(15);  // Increased spacing before table

// Build query
$select_sql = "SELECT stock.*, stores.location  
               FROM stock
               JOIN stores ON stock.store_id = stores.id
               WHERE 1=1";
if ($created_by) $select_sql .= " AND created_by LIKE '%$created_by%'";
if ($company) $select_sql .= " AND company LIKE '%$company%'";
if ($medicine_name) $select_sql .= " AND medicine_name LIKE '%$medicine_name%'";
if ($category) $select_sql .= " AND category LIKE '%$category%'";
if ($store_location) $select_sql .= " AND location LIKE '%$store_location%'";

$select_query = mysqli_query($con, $select_sql);

// Table setup - optimized column widths
$col_widths = [8, 25, 20, 20, 20, 15, 15, 15, 18, 18, 15, 22, 22];
$headers = [
    '#', 'Dawa', 'Tawi', 'Msambazaji', 
    'Iliyosajiriwa', 'Iliyouzwa', 'Iliyobaki',
    'Tarehe', 'Bei Nunu', 'Bei Uzia', 'Faida',
    'Thamani Nunu', 'Thamani Uzia'
];

$table_width = array_sum($col_widths);
$table_start_x = $pdf->GetCenteredX($table_width);

// Header row
$pdf->SetFont('Arial', 'B', 9);
$pdf->SetFillColor(56, 56, 56);
$pdf->SetTextColor(255, 255, 255);
$pdf->SetX($table_start_x);

foreach ($headers as $i => $header) {
    $pdf->Cell($col_widths[$i], 7, $header, 1, 0, 'C', true);
}
$pdf->Ln();

// Table data
$pdf->SetFont('Arial', '', 8);
$pdf->SetTextColor(0, 0, 0);
$serial_number = 1;

while ($row = mysqli_fetch_assoc($select_query)) {
    $pdf->SetX($table_start_x);
    
    // Ensure numeric values with proper type casting
    $quantity = (int)$row['quantity'];
    $used_quantity = (int)$row['used_quantity'];
    $remain_quantity = (int)$row['act_remain_quantity'];
    $actual_price = (float)$row['actual_price'];
    $selling_price = (float)$row['selling_price'];
    $profit_price = (float)$row['profit_price'];
    
    // Calculate monetary values
    $value_act = $actual_price * $remain_quantity;
    $value_sell = $selling_price * $remain_quantity;
    
    // Prepare row data
    $data = [
        $serial_number++,
        $row['medicine_name'],
        $row['location'],
        $row['company'],
        $quantity." (".$row['sell_type'].")", // Keep as string
        $used_quantity, // Display as integer
        $remain_quantity, // Display as integer
        date("d-m-Y", strtotime($row['register_date'])),
        number_format($actual_price, 2), // Format with 2 decimals
        number_format($selling_price, 2),
        number_format($profit_price, 2),
        number_format($value_act, 2),
        number_format($value_sell, 2)
    ];
    
    // Update totals with numeric values
    $totals['quantity'] += $quantity;
    $totals['sold'] += $used_quantity;
    $totals['remain'] += $remain_quantity;
    $totals['value_act'] += $value_act;
    $totals['value_sell'] += $value_sell;
    
    // Add row to PDF
    foreach ($data as $i => $value) {
        $pdf->Cell($col_widths[$i], 6, $value, 1, 0, $i < 4 ? 'L' : ($i > 6 ? 'R' : 'C'));
    }
    $pdf->Ln();
    
    // Page break check
    if ($pdf->GetY() > 190) {
        $pdf->AddPage('L');
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetFillColor(56, 56, 56);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->SetX($table_start_x);
        
        foreach ($headers as $i => $header) {
            $pdf->Cell($col_widths[$i], 7, $header, 1, 0, 'C', true);
        }
        $pdf->Ln();
        $pdf->SetFont('Arial', '', 8);
        $pdf->SetTextColor(0, 0, 0);
    }
}

// Totals row
$pdf->SetX($table_start_x);
$pdf->SetFont('Arial', 'B', 9);
$pdf->SetFillColor(220, 220, 220);

$pdf->Cell(array_sum(array_slice($col_widths, 0, 4)), 6, 'Jumla Mkuu:', 1, 0, 'R', true);
$pdf->Cell($col_widths[4], 6, $totals['quantity'], 1, 0, 'C', true);
$pdf->Cell($col_widths[5], 6, $totals['sold'], 1, 0, 'C', true);
$pdf->Cell($col_widths[6], 6, $totals['remain'], 1, 0, 'C', true);
$pdf->Cell($col_widths[7], 6, '', 1, 0, 'C', true);
$pdf->Cell($col_widths[8], 6, '', 1, 0, 'C', true);
$pdf->Cell($col_widths[9], 6, '', 1, 0, 'C', true);
$pdf->Cell($col_widths[10], 6, '', 1, 0, 'C', true);
$pdf->Cell($col_widths[11], 6, number_format($totals['value_act'], 2), 1, 0, 'R', true);
$pdf->Cell($col_widths[12], 6, number_format($totals['value_sell'], 2), 1, 1, 'R', true);

// Footer
$pdf->SetFont('Arial', 'I', 8);
$pdf->Cell(0, 10, 'Imetolewa: '.date('d/m/Y H:i:s'), 0, 1, 'R');

// Clean output and send PDF
ob_end_clean();
$pdf->Output('Ripoti_Dawa_'.date('Ymd_His').'.pdf', 'D');
?>