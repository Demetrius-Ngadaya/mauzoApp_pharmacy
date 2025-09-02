<?php
include("session.php");
include("dbcon.php");

// Get filter parameters from URL
$created_by = isset($_GET['created_by']) ? mysqli_real_escape_string($con, $_GET['created_by']) : '';
$medicine_name = isset($_GET['medicine_name']) ? mysqli_real_escape_string($con, $_GET['medicine_name']) : '';
$company = isset($_GET['company']) ? mysqli_real_escape_string($con, $_GET['company']) : '';
$category = isset($_GET['category']) ? mysqli_real_escape_string($con, $_GET['category']) : '';
$store_location = isset($_GET['store_location']) ? mysqli_real_escape_string($con, $_GET['store_location']) : '';

// Build the SQL query with filters
$select_sql = "SELECT stock.*, stores.location  
               FROM stock
               JOIN stores ON stock.store_id = stores.id
               WHERE 1=1"; 

if (!empty($created_by)) {
    $select_sql .= " AND created_by LIKE '%$created_by%'";
}
if (!empty($company)) {
    $select_sql .= " AND company LIKE '%$company%'";
}
if (!empty($medicine_name)) {
    $select_sql .= " AND medicine_name LIKE '%$medicine_name%'";
}
if (!empty($category)) {
    $select_sql .= " AND category LIKE '%$category%'";
}
if (!empty($store_location)) {
    $select_sql .= " AND stores.location LIKE '%$store_location%'";
}
$select_query = mysqli_query($con, $select_sql);

if(!$select_query) {
    die("Database query failed: " . mysqli_error($con));
}

// Set headers for Excel download
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=stock_report_".date('Y-m-d').".xls");
header("Pragma: no-cache");
header("Expires: 0");

// Excel content starts here
echo "<table border='0' width='100%'>";
// Company header row
echo "<tr>
        <td colspan='13' style='text-align:center; font-size:18px; font-weight:bold;'>
            PP TIMBER
        </td>
      </tr>";
// Report title row
echo "<tr>
        <td colspan='13' style='text-align:center; font-size:16px; font-weight:bold;'>
            TAARIFA YA STOCK
        </td>
      </tr>";
// Date row
echo "<tr>
        <td colspan='13' style='text-align:center;'>
            Tarehe: ".date('d-m-Y')."
        </td>
      </tr>";
// Empty row for spacing
echo "<tr><td colspan='13'>&nbsp;</td></tr>";

// Start the data table
echo "<table border='1' width='100%'>";
echo "<tr>
        <th>#</th>
        <th>Dawa</th>
        <th>Kituo/Tawi</th>
        <th>Msambazaji</th>
        <th>Idadi iliyosajiriwa</th>
        <th>Idadi iliyouzwa</th>
        <th>Idadi iliyobaki</th>
        <th>Tarehe iliyosajiliwa</th>
        <th>Bei ya kununuliwa</th>
        <th>Bei ya kuuzia</th>
        <th>Faida</th>
        <th>Thamani kwa bei kununulia</th>
        <th>Thamani kwa bei kuuzia</th>
      </tr>";

// Initialize totals
$total_quantity = 0;
$total_sold = 0;
$total_remain = 0;
$total_act_price = 0;
$total_sell_price = 0;
$total_profit = 0;
$product_value_by_act_price = 0;
$product_value_by_selling_price = 0;

$serial_number = 1;
while($row = mysqli_fetch_assoc($select_query)) {
    // Convert all numeric values to proper types
    $quantity = (int)$row['quantity'];
    $used_quantity = (int)$row['used_quantity'];
    $remain_quantity = (int)$row['act_remain_quantity'];
    $actual_price = (float)$row['actual_price'];
    $selling_price = (float)$row['selling_price'];
    $profit_price = (float)$row['profit_price'];
    
    // Calculate values with type safety
    $value_act_price = $actual_price * $remain_quantity;
    $value_sell_price = $selling_price * $remain_quantity;
    
    // Update totals
    $total_quantity += $quantity;
    $total_sold += $used_quantity;
    $total_remain += $remain_quantity;
    $total_act_price += $actual_price;
    $total_sell_price += $selling_price;
    $total_profit += $profit_price;
    $product_value_by_act_price += $value_act_price;
    $product_value_by_selling_price += $value_sell_price;
    
    echo "<tr>
            <td>".$serial_number++."</td>
            <td>".htmlspecialchars($row['medicine_name'])."</td>
            <td>".htmlspecialchars($row['location'])."</td>
            <td>".htmlspecialchars($row['company'])."</td>
            <td>".$quantity." (".htmlspecialchars($row['sell_type']).")</td>
            <td>".$used_quantity."</td>
            <td>".$remain_quantity."</td>
            <td>".date("d-m-Y", strtotime($row['register_date']))."</td>
            <td>".number_format($actual_price, 2)."</td>
            <td>".number_format($selling_price, 2)."</td>
            <td>".number_format($profit_price, 2)."</td>
            <td>".number_format($value_act_price, 2)."</td>
            <td>".number_format($value_sell_price, 2)."</td>
          </tr>";
}

// Add totals row
echo "<tr>
        <th colspan='4'>Jumla Mkuu:</th>
        <th>".number_format($total_quantity)."</th>
        <th>".number_format($total_sold)."</th>
        <th>".number_format($total_remain)."</th>
        <th colspan='4'></th>
        <th>".number_format($product_value_by_act_price, 2)."</th>
        <th>".number_format($product_value_by_selling_price, 2)."</th>
      </tr>";

echo "</table>";

// Close database connection
mysqli_close($con);
?>