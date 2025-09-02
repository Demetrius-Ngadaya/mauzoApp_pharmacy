<?php
include("dbcon.php");
require('fpdf/fpdf.php');

class PDF extends FPDF {
    // Improved circle/arc implementation for FPDF
    function Arc($x, $y, $rx, $ry, $startAngle=0, $endAngle=360) {
        // Approximation of arc using small lines
        $startAngle = deg2rad($startAngle);
        $endAngle = deg2rad($endAngle);
        
        $angleStep = 0.05; // Smaller step = smoother circle
        $angle = $startAngle;
        
        $this->MoveTo(
            $x + $rx * cos($angle),
            $y + $ry * sin($angle)
        );
        
        while ($angle < $endAngle) {
            $angle += $angleStep;
            if ($angle > $endAngle) {
                $angle = $endAngle;
            }
            $this->LineTo(
                $x + $rx * cos($angle),
                $y + $ry * sin($angle)
            );
        }
    }
    
    // Helper functions for Arc()
    function MoveTo($x, $y) {
        $this->_out(sprintf('%.2F %.2F m', $x*$this->k, ($this->h-$y)*$this->k));
    }
    
    function LineTo($x, $y) {
        $this->_out(sprintf('%.2F %.2F l', $x*$this->k, ($this->h-$y)*$this->k));
    }

    // Custom function to draw a circle
    function DrawCircle($x, $y, $r) {
        $this->Arc($x, $y, $r, $r, 0, 360);
        $this->_out('s'); // stroke the path
    }

    // Function to create circular logo effect
    function CircularImage($x, $y, $r, $file) {
        // First draw the square image
        $this->Image($file, $x-$r, $y-$r, $r*2, $r*2, 'PNG');
        
        // Then create circular mask with white fill
        $this->SetDrawColor(255, 255, 255);
        $this->SetFillColor(255, 255, 255);
        $this->DrawCircle($x, $y, $r);
        $this->_out('f'); // fill the path
        
        // Finally draw the border
        $this->SetDrawColor(0, 0, 0);
        $this->DrawCircle($x, $y, $r);
    }
    
    // Function to center content
    function CenterContent($content_width) {
        return ($this->GetPageWidth() - $content_width) / 2;
    }
}

// Get filter parameters
$d1 = isset($_GET['d1']) ? $_GET['d1'] : date('Y-m-d');
$d2 = isset($_GET['d2']) ? $_GET['d2'] : date('Y-m-d');
$created_by = isset($_GET['created_by']) ? urldecode($_GET['created_by']) : '';
$medicine = isset($_GET['medicine']) ? urldecode($_GET['medicine']) : '';
$category = isset($_GET['category']) ? urldecode($_GET['category']) : '';
$customer_name = isset($_GET['customer_name']) ? urldecode($_GET['customer_name']) : '';

// Initialize the SQL query for product profit report
$select_sql = "SELECT 
    s.medicines,
    s.category,
    SUM(s.quantity) as total_quantity,
    SUM(s.total_amount) as total_sales,
    (SELECT SUM(quantity * total_cost) FROM purchases_report WHERE medicine_name = s.medicines) as total_cost
FROM sales s
WHERE s.Date BETWEEN '$d1' AND '$d2'";

// Append additional filters if they are provided
if (!empty($created_by)) {
    $select_sql .= " AND s.created_by LIKE '%$created_by%'";
}
if (!empty($medicine)) {
    $select_sql .= " AND s.medicines LIKE '%$medicine%'";
}
if (!empty($category)) {
    $select_sql .= " AND s.category LIKE '%$category%'";
}
if (!empty($customer_name)) {
    $select_sql .= " AND s.customer_name LIKE '%$customer_name%'";
}

$select_sql .= " GROUP BY s.medicines, s.category";
$select_sql .= " ORDER BY s.medicines ASC";
$select_query = mysqli_query($con, $select_sql);

// Create PDF
$pdf = new PDF('L');
$pdf->AddPage();

// Logo parameters
$logo_radius = 15;
$left_logo_x = 25;
$right_logo_x = $pdf->GetPageWidth() - 25;
$logo_y = 20;

// Add circular logo on left
// if (file_exists('images/logo2.png')) {
//     $pdf->CircularImage($left_logo_x, $logo_y, $logo_radius, 'images/logo2.png');
// } else {
//     $pdf->SetFont('Arial', 'B', 12);
//     $pdf->Text($left_logo_x-$logo_radius, $logo_y, 'LOGO');
// }

// Add circular TechNet logo on right
// if (file_exists('images/technet.png')) {
//     $pdf->CircularImage($right_logo_x, $logo_y, $logo_radius, 'images/technet.png');
// } else {
//     $pdf->SetFont('Arial', 'B', 12);
//     $pdf->Text($right_logo_x-$logo_radius, $logo_y, 'TECHNET');
// }

// Calculate centered positions
$company_name_width = 100; // Approximate width of company name
$report_title_width = 80;  // Approximate width of report title
$date_range_width = 120;   // Approximate width of date range

// Company name centered
$pdf->SetFont('Arial', 'B', 16);
$pdf->SetXY($pdf->CenterContent($company_name_width), 10);
$pdf->Cell($company_name_width, 10, 'PP TIMBER', 0, 1, 'C');

// Report title centered
$pdf->SetFont('Arial', '', 12);
$pdf->SetXY($pdf->CenterContent($report_title_width), 20);
$pdf->Cell($report_title_width, 10, 'Ripoti ya Faida (Gross Profit Report)', 0, 1, 'C');

// Date range centered
$pdf->SetXY($pdf->CenterContent($date_range_width), 30);
$pdf->Cell($date_range_width, 10, 'Kuanzia: '.date('d/m/Y', strtotime($d1)).' - Mpaka: '.date('d/m/Y', strtotime($d2)), 0, 1, 'C');
$pdf->Ln(15);

// Calculate table width and centered position
$table_width = 50 + 30 + (25 * 3) + (30 * 3); // Sum of all column widths
$table_start_x = $pdf->CenterContent($table_width);

// Set X position for the table
$pdf->SetX($table_start_x);

// Add a table header
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(50, 10, 'Jina la Dawa', 1, 0, 'C');
$pdf->Cell(30, 10, 'Aina ya Dawa', 1, 0, 'C');
$pdf->Cell(25, 10, 'Mauzo/Unit', 1, 0, 'C');
$pdf->Cell(25, 10, 'Gharama/Unit', 1, 0, 'C');
$pdf->Cell(25, 10, 'Faida/Unit', 1, 0, 'C');
$pdf->Cell(30, 10, 'Jumla Mauzo', 1, 0, 'C');
$pdf->Cell(30, 10, 'Jumla Gharama', 1, 0, 'C');
$pdf->Cell(30, 10, 'Jumla Faida', 1, 1, 'C');

$pdf->SetFont('Arial', '', 10);

// Initialize totals
$total_gross_sales = 0;
$total_gross_cost = 0;
$total_gross_profit = 0;

// Check if there are any records
if(mysqli_num_rows($select_query) > 0) {
    // Add data from the database
    while ($row = mysqli_fetch_array($select_query)) {
        $unit_price = ($row['total_quantity'] > 0) ? $row['total_sales'] / $row['total_quantity'] : 0;
        $unit_cost = ($row['total_quantity'] > 0 && $row['total_cost'] > 0) ? $row['total_cost'] / $row['total_quantity'] : 0;
        $unit_profit = $unit_price - $unit_cost;
        
        $subtotal_sales = $row['total_sales'];
        $subtotal_cost = $unit_cost * $row['total_quantity'];
        $subtotal_profit = $unit_profit * $row['total_quantity'];
        
        $total_gross_sales += $subtotal_sales;
        $total_gross_cost += $subtotal_cost;
        $total_gross_profit += $subtotal_profit;
        
        $pdf->SetX($table_start_x);
        $pdf->Cell(50, 10, $row['medicines'], 1, 0, 'L');
        $pdf->Cell(30, 10, $row['category'], 1, 0, 'L');
        $pdf->Cell(25, 10, number_format($unit_price, 2), 1, 0, 'R');
        $pdf->Cell(25, 10, number_format($unit_cost, 2), 1, 0, 'R');
        $pdf->Cell(25, 10, number_format($unit_profit, 2), 1, 0, 'R');
        $pdf->Cell(30, 10, number_format($subtotal_sales, 2), 1, 0, 'R');
        $pdf->Cell(30, 10, number_format($subtotal_cost, 2), 1, 0, 'R');
        $pdf->Cell(30, 10, number_format($subtotal_profit, 2), 1, 1, 'R');
    }
} else {
    // No records found - centered message
    $pdf->SetX($table_start_x);
    $pdf->Cell($table_width, 10, 'Hakuna taharifa zilizopatikana', 1, 1, 'C');
}

// Add totals row if there are records
if(mysqli_num_rows($select_query) > 0) {
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->SetX($table_start_x);
    $pdf->Cell(155, 10, 'Jumla Mkuu:', 1, 0, 'R');
    $pdf->Cell(30, 10, number_format($total_gross_sales, 2), 1, 0, 'R');
    $pdf->Cell(30, 10, number_format($total_gross_cost, 2), 1, 0, 'R');
    $pdf->Cell(30, 10, number_format($total_gross_profit, 2), 1, 1, 'R');
}

// Output PDF
$pdf->Output('Ripoti_Faida_Dawa_'.$d1.'_'.$d2.'.pdf', 'D');
?>