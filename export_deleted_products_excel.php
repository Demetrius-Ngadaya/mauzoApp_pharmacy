<?php
include("session.php");
include("dbcon.php");
error_reporting(1);

// Get search filters from URL
$d1 = isset($_GET['d1']) ? $_GET['d1'] : '';
$d2 = isset($_GET['d2']) ? $_GET['d2'] : '';
$deleted_by = isset($_GET['deleted_by']) ? $_GET['deleted_by'] : '';
$medicine_name = isset($_GET['medicine_name']) ? $_GET['medicine_name'] : '';
$category = isset($_GET['category']) ? $_GET['category'] : '';

// Build the query with filters
$query = "SELECT * FROM deleted_products WHERE 1=1";

if (!empty($d1) && !empty($d2)) {
    $query .= " AND deleted_date BETWEEN '$d1' AND '$d2'";
}

if (!empty($deleted_by)) {
    $query .= " AND deleted_by LIKE '%$deleted_by%'";
}

if (!empty($medicine_name)) {
    $query .= " AND medicine_name LIKE '%$medicine_name%'";
}

if (!empty($category)) {
    $query .= " AND category LIKE '%$category%'";
}

$query .= " ORDER BY deleted_date DESC";

$result = mysqli_query($con, $query);

// Set headers for Excel download
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=deleted_products_report_".date('Y-m-d').".xls");
header("Pragma: no-cache");
header("Expires: 0");

// Function to extract numeric value from string
function extractNumericValue($value) {
    if (is_numeric($value)) {
        return (float)$value;
    }
    // Extract numbers from strings like "300(11%)"
    preg_match('/\d+/', $value, $matches);
    return isset($matches[0]) ? (float)$matches[0] : 0;
}

// Start Excel data with headers
echo "<table border='1'>";

// Company Header
echo "<tr><td colspan='12' style='font-size:16px; font-weight:bold; text-align:center; background-color:#f2f2f2;'>PP TIMBER</td></tr>";

// Report Title
echo "<tr><td colspan='12' style='font-size:14px; font-weight:bold; text-align:center;'>RIPOTI YA Dawa ZILIZOFUTWA</td></tr>";

// Date Range
if (!empty($d1) && !empty($d2)) {
    echo "<tr><td colspan='12' style='font-weight:bold;'>Muda: Tarehe $d1 mpaka $d2</td></tr>";
} else {
    echo "<tr><td colspan='12' style='font-weight:bold;'>Muda: Siku yote</td></tr>";
}

// Applied Filters
$filters = [];
if (!empty($deleted_by)) $filters[] = "Aliyefuta: $deleted_by";
if (!empty($medicine_name)) $filters[] = "Dawa: $medicine_name";
if (!empty($category)) $filters[] = "Aina: $category";

if (!empty($filters)) {
    echo "<tr><td colspan='12' style='font-weight:bold;'>Vichujio: " . implode(", ", $filters) . "</td></tr>";
}

// Empty row for spacing
echo "<tr><td colspan='12'></td></tr>";

// Table headers
echo "<tr style='background-color:#e6e6e6;'>
        <th>#</th>
        <th>Tarehe</th>
        <th>Dawa</th>
        <th>Aina ya Dawa</th>
        <th>Idadi iliyopo</th>
        <th>Idadi iliyouzwa</th>
        <th>Bei ya kununua</th>
        <th>Bei ya kuuza</th>
        <th>Tarehe ku expire</th>
        <th>Faida</th>
        <th>Msambazaji</th>
        <th>Aliyefuta</th>
      </tr>";

// Table data
$serial_number = 1;
$total_profit = 0;
while($row = mysqli_fetch_array($result)) {
    $profit_value = extractNumericValue($row['profit_price']);
    $total_profit += $profit_value;
    
    echo "<tr>
            <td>".$serial_number++."</td>
            <td>".$row['deleted_date']."</td>
            <td>".$row['medicine_name']."</td>
            <td>".$row['category']."</td>
            <td>".$row['act_remain_quantity']."</td>
            <td>".$row['used_quantity']."</td>
            <td>".number_format($row['actual_price'], 2)."</td>
            <td>".number_format($row['selling_price'], 2)."</td>
            <td>".$row['expire_date']."</td>
            <td>".$row['profit_price']."</td> <!-- Display original value -->
            <td>".$row['company']."</td>
            <td>".$row['deleted_by']."</td>
          </tr>";
}

// Total row - use the calculated numeric total
echo "<tr style='font-weight:bold; background-color:#f2f2f2;'>
        <td colspan='9'>JUMLA</td>
        <td>".number_format($total_profit, 2)."</td>
        <td colspan='2'></td>
      </tr>";

// Export date footer
echo "<tr><td colspan='12' style='text-align:right; font-style:italic;'>Imetolewa: ".date('d/m/Y H:i:s')."</td></tr>";

echo "</table>";
exit;
?>