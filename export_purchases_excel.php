<?php
include("session.php");
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

// Set headers for Excel download
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=manunuzi_report_".date('Y-m-d').".xls");
header("Pragma: no-cache");
header("Expires: 0");

// Start Excel content
echo "<table border='1'>";
echo "<tr><th colspan='12' style='font-size:16px;'>PP TIMBER</th></tr>";
echo "<tr><th colspan='12' style='font-size:14px;'>Ripoti ya Manunuzi ya Dawa</th></tr>";
echo "<tr><th colspan='12'>Tarehe ya kupakua: ".date('d-m-Y H:i:s')."</th></tr>";

// Display applied filters if any
$filters = [];
if (!empty($d1) && !empty($d2)) $filters[] = "Muda: $d1 mpaka $d2";
if (!empty($created_by)) $filters[] = "Mrekodi: $created_by";
if (!empty($company_filter)) $filters[] = "Msambazaji: $company_filter";
if (!empty($medicine_name)) $filters[] = "Dawa: $medicine_name";
if (!empty($category)) $filters[] = "Aina: $category";
if (!empty($status)) $filters[] = "Hali: $status";
if (!empty($store_location)) $filters[] = "Tawi/Kituo: $store_location";

if (!empty($filters)) {
    echo "<tr><th colspan='12'>Vichujio: ".implode(", ", $filters)."</th></tr>";
}

// Table headers
echo "<tr>
    <th>#</th>
    <th>Tarehe ya kupokea</th>
    <th>Dawa</th>
    <th>Tawi/Kituo</th>
    <th>Idadi ya zamani</th>
    <th>Idadi iliyopokelewa</th>
    <th>Bei</th>
    <th>Jumla</th>
    <th>Faida</th>
    <th>Msambazaji</th>
    <th>Mrekodi</th>
    <th>Hali</th>
</tr>";

// Table data
$counter = 1;
$total_sum = 0;
while($row = mysqli_fetch_array($query)) {
    $total = $row['received_quantity'] * $row['actual_price'];
    $total_sum += $total;
    
    echo "<tr>
        <td>".$counter++."</td>
        <td>".$row['received_date']."</td>
        <td>".$row['medicine_name']."</td>
        <td>".$row['location']."</td>
        <td>".$row['old_quantity']."</td>
        <td>".$row['received_quantity']."</td>
        <td>".number_format($row['actual_price'])."</td>
        <td>".number_format($total)."</td>
        <td>".number_format($row['expected_profit'])."</td>
        <td>".$row['company']."</td>
        <td>".$row['created_by']."</td>
        <td>".$row['status']."</td>
    </tr>";
}

// Total row
echo "<tr>
    <th colspan='7'>JUMLA</th>
    <th>".number_format($total_sum)." Tsh</th>
    <th colspan='4'></th>
</tr>";

echo "</table>";
?>