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
      // Add a new method to calculate centered X position
      function GetCenteredX($content_width) {
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

// Initialize totals
$total_sales = 0;
$total_cost = 0;
$total_gross_profit = 0;
$total_expenditure = 0;
$total_operational_profit = 0;

// Get all dates in range
$date_sql = "SELECT DISTINCT Date as transaction_date FROM sales 
            WHERE Date BETWEEN '$d1' AND '$d2'";
if (!empty($created_by)) {
    $date_sql .= " AND created_by LIKE '%$created_by%'";
}
if (!empty($customer_name)) {
    $date_sql .= " AND customer_name LIKE '%$customer_name%'";
}
if (!empty($medicine)) {
    $date_sql .= " AND medicines LIKE '%$medicine%'";
}
if (!empty($category)) {
    $date_sql .= " AND category LIKE '%$category%'";
}

$date_sql .= " UNION SELECT DISTINCT created_at as transaction_date FROM expenditure
              WHERE created_at BETWEEN '$d1' AND '$d2'
              ORDER BY transaction_date";

$date_query = mysqli_query($con, $date_sql);

// Create PDF
$pdf = new PDF('L');
$pdf->AddPage();

// Logo parameters
$logo_radius = 15;
$left_logo_x = 25;
$right_logo_x = $pdf->GetPageWidth() - 25;
$logo_y = 20;
// Add circular logo on left
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

// Company name and title between logos
$pdf->SetFont('Arial', 'B', 16);
$pdf->SetXY($left_logo_x + $logo_radius + 5, 10);
$pdf->Cell(0, 10, 'PP TIMBER', 0, 1, 'C');

$pdf->SetFont('Arial', '', 12);
$pdf->SetXY($left_logo_x + $logo_radius + 5, 20);
$pdf->Cell(0, 10, 'Ripoti ya Faida ya Uendeshaji', 0, 1, 'C');

$pdf->SetXY($left_logo_x + $logo_radius + 5, 30);
$pdf->Cell(0, 10, 'Kuanzia: '.date('d/m/Y', strtotime($d1)).' - Mpaka: '.date('d/m/Y', strtotime($d2)), 0, 1, 'C');
$pdf->Ln(15);

// Calculate table width and centered position
$table_width = 40 * 6; // 6 columns at 40mm each
$table_start_x = $pdf->GetCenteredX($table_width);

// Set X position for the table
$pdf->SetX($table_start_x);

// Table header
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(40, 10, 'Tarehe', 1, 0, 'C');
$pdf->Cell(40, 10, 'Mauzo (Sales)', 1, 0, 'C');
$pdf->Cell(40, 10, 'Gharama (Cost)', 1, 0, 'C');
$pdf->Cell(40, 10, 'Faida ya Jumla', 1, 0, 'C');
$pdf->Cell(40, 10, 'Matumizi', 1, 0, 'C');
$pdf->Cell(40, 10, 'Faida ya Uendeshaji', 1, 1, 'C');

$pdf->SetFont('Arial', '', 10);

// Process each date
while($date_row = mysqli_fetch_assoc($date_query)) {
    $current_date = $date_row['transaction_date'];
    
    // Get sales
    $sales_sql = "SELECT SUM(total_amount) as total_sales FROM sales WHERE Date = '$current_date'";
    if (!empty($created_by)) $sales_sql .= " AND created_by LIKE '%$created_by%'";
    if (!empty($customer_name)) $sales_sql .= " AND customer_name LIKE '%$customer_name%'";
    if (!empty($medicine)) $sales_sql .= " AND medicines LIKE '%$medicine%'";
    if (!empty($category)) $sales_sql .= " AND category LIKE '%$category%'";
    
    $sales_result = mysqli_query($con, $sales_sql);
    $sales_data = mysqli_fetch_assoc($sales_result);
    $daily_sales = $sales_data['total_sales'] ?? 0;
    $total_sales += $daily_sales;
    
    // Get cost
    $cost_sql = "SELECT SUM(s.quantity * latest_purchase.total_cost) as total_cost
                FROM sales s
                JOIN (
                    SELECT pr1.medicine_id, pr1.total_cost
                    FROM purchases_report pr1
                    WHERE pr1.id = (
                        SELECT MAX(pr2.id)
                        FROM purchases_report pr2
                        WHERE pr2.medicine_id = pr1.medicine_id
                    )
                ) latest_purchase ON s.medicine_id = latest_purchase.medicine_id
                WHERE s.Date = '$current_date'";
    $cost_result = mysqli_query($con, $cost_sql);
    $cost_data = mysqli_fetch_assoc($cost_result);
    $daily_cost = $cost_data['total_cost'] ?? 0;
    $total_cost += $daily_cost;
    
    // Calculate profits
    $daily_gross_profit = $daily_sales - $daily_cost;
    $total_gross_profit += $daily_gross_profit;
    
    // Get expenditure
    $exp_sql = "SELECT SUM(expenditure_amount) as total_exp FROM expenditure WHERE created_at = '$current_date'";
    $exp_result = mysqli_query($con, $exp_sql);
    $exp_data = mysqli_fetch_assoc($exp_result);
    $daily_exp = $exp_data['total_exp'] ?? 0;
    $total_expenditure += $daily_exp;
    
    $daily_operational_profit = $daily_gross_profit - $daily_exp;
    $total_operational_profit += $daily_operational_profit;
    $pdf->SetX($table_start_x);
    
    // Add row to PDF
    $pdf->Cell(40, 10, $current_date, 1, 0, 'L');
    $pdf->Cell(40, 10, number_format($daily_sales, 2).' Tsh', 1, 0, 'R');
    $pdf->Cell(40, 10, number_format($daily_cost, 2).' Tsh', 1, 0, 'R');
    $pdf->Cell(40, 10, number_format($daily_gross_profit, 2).' Tsh', 1, 0, 'R');
    $pdf->Cell(40, 10, number_format($daily_exp, 2).' Tsh', 1, 0, 'R');
    $pdf->Cell(40, 10, number_format($daily_operational_profit, 2).' Tsh', 1, 1, 'R');
}

// Set X position for totals row to keep it centered
$pdf->SetX($table_start_x);

// Add totals row
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(40, 10, 'Jumla Mkuu:', 1, 0, 'L');
$pdf->Cell(40, 10, number_format($total_sales, 2).' Tsh', 1, 0, 'R');
$pdf->Cell(40, 10, number_format($total_cost, 2).' Tsh', 1, 0, 'R');
$pdf->Cell(40, 10, number_format($total_gross_profit, 2).' Tsh', 1, 0, 'R');
$pdf->Cell(40, 10, number_format($total_expenditure, 2).' Tsh', 1, 0, 'R');
$pdf->Cell(40, 10, number_format($total_operational_profit, 2).' Tsh', 1, 1, 'R');

// Output PDF
$pdf->Output('Ripoti_Faida_Uendeshaji_'.$d1.'_'.$d2.'.pdf', 'D');
?>