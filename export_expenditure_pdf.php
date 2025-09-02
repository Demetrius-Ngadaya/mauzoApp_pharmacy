<?php
include("session.php");

require('fpdf/fpdf.php');
include("dbcon.php");

// Get filter parameters from URL
$d1 = isset($_GET['d1']) ? mysqli_real_escape_string($con, $_GET['d1']) : date('Y-m-d');
$d2 = isset($_GET['d2']) ? mysqli_real_escape_string($con, $_GET['d2']) : date('Y-m-d');
$created_by = isset($_GET['created_by']) ? mysqli_real_escape_string($con, $_GET['created_by']) : '';
$expenditure_name = isset($_GET['expenditure_name']) ? mysqli_real_escape_string($con, $_GET['expenditure_name']) : '';
$expenditure_description = isset($_GET['expenditure_description']) ? mysqli_real_escape_string($con, $_GET['expenditure_description']) : '';

// Build the SQL query with filters
$select_sql = "SELECT * FROM expenditure WHERE created_at BETWEEN '$d1' AND '$d2'";

if (!empty($created_by)) {
    $select_sql .= " AND created_by LIKE '%$created_by%'";
}
if (!empty($expenditure_name)) {
    $select_sql .= " AND expenditure_name LIKE '%$expenditure_name%'";
}
if (!empty($expenditure_description)) {
    $select_sql .= " AND expenditure_description LIKE '%$expenditure_description%'";
}

$select_sql .= " ORDER BY created_at DESC";
$select_query = mysqli_query($con, $select_sql);

if(!$select_query) {
    die("Database query failed: " . mysqli_error($con));
}

// Calculate total amount
$total_sql = str_replace('*', 'SUM(expenditure_amount) as total_amount', $select_sql);
$total_query = mysqli_query($con, $total_sql);
$total_row = mysqli_fetch_assoc($total_query);
$total_amount = $total_row['total_amount'] ?? 0;

// Extend FPDF class with custom functions
class PDF extends FPDF {
    function GetMultiCellHeight($w, $h, $txt, $border=null, $align='J') {
        // Calculate MultiCell height
        $nb = $this->NbLines($w, $txt);
        $height = $nb * $h;
        if ($border) {
            $height += $this->bMargin * 2;
        }
        return $height;
    }
    
    function NbLines($w, $txt) {
        // Compute the number of lines a MultiCell of width w will take
        $cw = &$this->CurrentFont['cw'];
        if($w==0)
            $w=$this->w-$this->rMargin-$this->x;
        $wmax = ($w-2*$this->cMargin)*1000/$this->FontSize;
        $s = str_replace("\r",'',(string)$txt);
        $nb = strlen($s);
        if($nb>0 and $s[$nb-1]=="\n")
            $nb--;
        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $nl = 1;
        while($i<$nb) {
            $c = $s[$i];
            if($c=="\n") {
                $i++;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
                continue;
            }
            if($c==' ')
                $sep = $i;
            $l += $cw[$c];
            if($l>$wmax) {
                if($sep==-1) {
                    if($i==$j)
                        $i++;
                } else
                    $i = $sep+1;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
            } else
                $i++;
        }
        return $nl;
    }
}

// Create PDF instance
$pdf = new PDF();
$pdf->AddPage();

// Set document properties
$pdf->SetTitle('Ripoti ya Matumizi');
$pdf->SetAuthor('PP TIMBER');

// Header
$pdf->SetFont('Arial','B',16);
$pdf->Cell(0,10,'PP TIMBER',0,1,'C');
$pdf->SetFont('Arial','B',14);
$pdf->Cell(0,10,'RIPOTI YA MATUMIZI',0,1,'C');

// Report info
$pdf->SetFont('Arial','',10);
$pdf->Cell(0,7,'Tarehe: '.date('d-m-Y'),0,1,'R');
$pdf->Cell(0,7,'Muda: '.date('d-m-Y', strtotime($d1)).' mpaka '.date('d-m-Y', strtotime($d2)),0,1,'L');
$pdf->Ln(10);

// Table header - adjust column widths
$pdf->SetFont('Arial','B',10);
$pdf->SetFillColor(200,220,255);
$pdf->Cell(19,7,'Tarehe',1,0,'C',true); // Reduced width
$pdf->Cell(30,7,'Jina la Tumizi',1,0,'C',true); // Reduced width
$pdf->Cell(80,7,'Maelezo',1,0,'C',true); // Widest column
$pdf->Cell(25,7,'Kiasi (Tsh)',1,0,'C',true); // Reduced width
$pdf->Cell(30,7,'Aliyeandika',1,1,'C',true); // Reduced width

// Table data - with MultiCell for description to handle wrapping
$pdf->SetFont('Arial','',9);
while($row = mysqli_fetch_assoc($select_query)) {
    // Get the height needed for this row
    $descriptionHeight = $pdf->GetMultiCellHeight(80, 5, $row['expenditure_description']);
    $rowHeight = max(6, $descriptionHeight); // Minimum height of 6
    
    // Date
    $pdf->Cell(19,$rowHeight,date('d-m-Y', strtotime($row['created_at'])),1,0,'L');
    
    // Name
    $pdf->Cell(30,$rowHeight,$row['expenditure_name'],1,0,'L');
    
    // Description - using MultiCell for text wrapping
    $x = $pdf->GetX();
    $y = $pdf->GetY();
    $pdf->MultiCell(80,5,$row['expenditure_description'],1,'L');
    $pdf->SetXY($x + 80, $y);
    
    // Amount
    $pdf->Cell(25,$rowHeight,number_format($row['expenditure_amount'],2),1,0,'R');
    
    // Created by
    $pdf->Cell(30,$rowHeight,$row['created_by'],1,1,'L');
}

// Total row - adjust widths to match new column widths
$pdf->SetFont('Arial','B',10);
$pdf->Cell(125,7,'Jumla Mkuu:',1,0,'R',true); // 15+30+80 = 125
$pdf->Cell(29,7,number_format($total_amount,1).' Tsh',1,0,'R',true);
$pdf->Cell(30,7,'',1,1,'C',true);

// Close database connection
mysqli_close($con);

// Output PDF
$pdf->Output('D','expenditure_report_'.date('Y-m-d').'.pdf');
?>