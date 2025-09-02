<?php
require('fpdf/fpdf.php');
include("dbcon.php");

class PDF extends FPDF
{
    // Page header
    function Header()
    {
        $this->SetFont('Arial', 'B', 12);
        // $this->Cell(0, 10, 'D_TECH PHARMACY', 0, 1, 'C');
        $this->Ln(5);
        $this->Cell(0, 10, 'Taharifa ya stock', 0, 1, 'C');
        $this->Ln(5);
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(10, 10, 'No', 1);
        $this->Cell(42, 10, 'Jina la Dawa', 1);
        $this->Cell(30, 10, 'Aina ya Dawa', 1);
        $this->Cell(30, 10, 'Bei ya kuuzia', 1);
        $this->Cell(30, 10, 'Idadi iliyobaki', 1);
        $this->Ln();
    }

    // Page footer
    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Page ' . $this->PageNo(), 0, 0, 'C');
    }
}

// Instantiate PDF object
$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 10);

$sql = "SELECT * FROM stock ORDER BY id";
$result = mysqli_query($con, $sql);

$serial_number = 1;

while ($row = mysqli_fetch_array($result)) {
    $pdf->Cell(10, 10, $serial_number, 1);
    $pdf->Cell(42, 10, $row['medicine_name'], 1);
    $pdf->Cell(30, 10, $row['category'], 1);
    $pdf->Cell(30, 10, $row['selling_price'], 1);
    $pdf->Cell(30, 10, $row['act_remain_quantity'], 1);
    $pdf->Ln();
    $serial_number++;
}

$pdf->Output('D', 'taharifa_za_stoo.pdf');
exit;
?>
