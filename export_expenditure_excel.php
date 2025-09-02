<?php
include("session.php");

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

// Set headers for Excel download
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=expenditure_report_".date('Y-m-d').".xls");
header("Pragma: no-cache");
header("Expires: 0");

// Excel content starts here
echo "<table border='0' width='100%'>";
// Company header row
echo "<tr>
        <td colspan='5' style='text-align:center; font-size:18px; font-weight:bold;'>
            PP TIMBER
        </td>
      </tr>";
// Report title row
echo "<tr>
        <td colspan='5' style='text-align:center; font-size:16px; font-weight:bold;'>
            RIPOTI YA MATUMIZI
        </td>
      </tr>";
// Date range row
echo "<tr>
        <td colspan='5' style='text-align:center;'>
            Kuanzia: ".date('d-m-Y', strtotime($d1))." Mpaka: ".date('d-m-Y', strtotime($d2))."
        </td>
      </tr>";
// Generated date row
echo "<tr>
        <td colspan='5' style='text-align:center;'>
            Tarehe ya kutolea: ".date('d-m-Y')."
        </td>
      </tr>";
// Empty row for spacing
echo "<tr><td colspan='5'>&nbsp;</td></tr>";

// Start the data table
echo "<table border='1' width='100%'>";
echo "<tr>
        <th>Tarehe</th>
        <th>Jina la tumizi</th>
        <th>Maelezo</th>
        <th>Kiasi cha pesa (Tsh)</th>
        <th>Aliyeandika</th>
      </tr>";

// Initialize totals
$total_amount = 0;

while($row = mysqli_fetch_assoc($select_query)) {
    // Convert amount to proper type
    $amount = (float)$row['expenditure_amount'];
    $total_amount += $amount;
    
    echo "<tr>
            <td>".date('d-m-Y', strtotime($row['created_at']))."</td>
            <td>".htmlspecialchars($row['expenditure_name'])."</td>
            <td>".htmlspecialchars($row['expenditure_description'])."</td>
            <td>".number_format($amount, 2)."</td>
            <td>".htmlspecialchars($row['created_by'])."</td>
          </tr>";
}

// Add totals row
echo "<tr>
        <th colspan='3'>Jumla Mkuu:</th>
        <th>".number_format($total_amount, 2)." Tsh</th>
        <th></th>
      </tr>";

echo "</table>";

// Close database connection
mysqli_close($con);
?>