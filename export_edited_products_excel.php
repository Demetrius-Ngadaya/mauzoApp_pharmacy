<?php
include("session.php");

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
    $filter_text .= (!empty($filter_text) ? ", " : "") . "Aliyehariri: $edited_by";
}

if (!empty($medicine_name)) {
    $query .= " AND medicine_name LIKE '%$medicine_name%'";
    $filter_text .= (!empty($filter_text) ? ", " : "") . "Dawa: $medicine_name";
}

if (!empty($category)) {
    $query .= " AND category LIKE '%$category%'";
    $filter_text .= (!empty($filter_text) ? ", " : "") . "Aina: $category";
}

$query .= " ORDER BY edited_date DESC";
$result = mysqli_query($con, $query);

// Set headers for Excel download
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=REAL_INVESTMENT_Dawa_zilizohaririwa_".date('Y-m-d').".xls");

// Excel content
echo "<h2>PP TIMBER</h2>";
echo "<h3>RIPOTI YA Dawa ZILIZOHARIRIWA</h3>";

if (!empty($filter_text)) {
    echo "<p><strong>Vichujio:</strong> $filter_text</p>";
}

echo "<p><strong>Tarehe ya Utoaji:</strong> ".date('d/m/Y H:i:s')."</p>";

echo "<table border='1'>";
echo "<tr>
        <th>#</th>
        <th>Tarehe</th>
        <th>Dawa</th>
        <th>Aina</th>
        <th>Idadi Kabla</th>
        <th>Idadi Baada</th>
        <th>Aliyehariri</th>
        <th>Sababu</th>
      </tr>";

$count = 1;
while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>
            <td>".$count++."</td>
            <td>".htmlspecialchars($row['edited_date'])."</td>
            <td>".htmlspecialchars($row['medicine_name'])."</td>
            <td>".htmlspecialchars($row['category'])."</td>
            <td>".htmlspecialchars($row['old_quantity'])."</td>
            <td>".htmlspecialchars($row['act_remain_quantity'])."</td>
            <td>".htmlspecialchars($row['edited_by'])."</td>
            <td>".htmlspecialchars($row['edit_reason'])."</td>
          </tr>";
}

echo "</table>";
exit;
?>