<?php
include("dbcon.php");
include("session.php");
$search_params = isset($_SESSION['search_params']) ? $_SESSION['search_params'] : [];
header('Content-Type: application/vnd.ms-excel; charset=UTF-8');
// Get filter parameters from URL
// Get parameters from session instead of GET
$d1 = isset($search_params['d1']) ? $search_params['d1'] : '';
$d2 = isset($search_params['d2']) ? $search_params['d2'] : '';
$created_by = isset($search_params['created_by']) ? $search_params['created_by'] : '';
$medicine = isset($search_params['medicine']) ? $search_params['medicine'] : '';
$category = isset($search_params['category']) ? $search_params['category'] : '';
$store_location = isset($search_params['store_location']) ? $search_params['store_location'] : '';
$hali_ya_malipo = isset($search_params['hali_ya_malipo']) ? $search_params['hali_ya_malipo'] : '';
$payment_method = isset($search_params['payment_method']) ? $search_params['payment_method'] : '';

// Query data
$select_sql = "SELECT sales.*, stores.location FROM sales 
  JOIN stores ON sales.store_id = stores.id 
  WHERE 1=1";

if (!empty($d1) && !empty($d2)) {
    $select_sql .= " AND Date BETWEEN '$d1' AND '$d2'";
}
if (!empty($created_by)) {
    $select_sql .= " AND created_by LIKE '%$created_by%'";
}
if (!empty($medicine)) {
    $select_sql .= " AND medicines LIKE '%$medicine%'";
}
if (!empty($category)) {
    $select_sql .= " AND category LIKE '%$category%'";
}
if (!empty($store_location)) {
    $select_sql .= " AND stores.location LIKE '%$store_location%'";
}
$select_sql .= " ORDER BY Date DESC";

$select_query = mysqli_query($con, $select_sql);

// Initialize totals
$total_quantity = 0;
$total_amount = 0;
$total_profit = 0;

// Set headers for Excel download
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=Ripoti_ya_mauzo_".date('Ymd_His').".xls");
header("Pragma: no-cache");
header("Expires: 0");

// Start Excel output
echo '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel">';
echo '<head>';
echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8">';
echo '<style>
    .header { font-weight:bold; background-color:#c9daf8; text-align:center; }
    .total { font-weight:bold; background-color:#e6e6e6; }
    .text-left { text-align:left; }
    .text-right { text-align:right; }
    .text-center { text-align:center; }
    .border { border:1px solid #000; }
</style>';
echo '</head>';
echo '<body>';

// Company Header
echo '<table border="0" cellspacing="0" cellpadding="5" width="100%">';
echo '<tr><td colspan="10" style="font-size:16pt; font-weight:bold; text-align:center;">PP TIMBER</td></tr>';
echo '<tr><td colspan="10" style="font-size:14pt; font-weight:bold; text-align:center;">RIPOTI YA MAUZO</td></tr>';

// Date range and filters
echo '<tr><td colspan="10">Kutoka: '.($d1 ? date('d/m/Y', strtotime($d1)) : '').' - Mpaka: '.($d2 ? date('d/m/Y', strtotime($d2)) : '').'</td></tr>';

// Show applied filters
$filters = [];
if (!empty($created_by)) $filters[] = "Muuzaji: $created_by";
if (!empty($medicine)) $filters[] = "Dawa: $medicine";
if (!empty($category)) $filters[] = "Aina: $category";

if (!empty($filters)) {
    echo '<tr><td colspan="10">Filters: '.implode(', ', $filters).'</td></tr>';
}

// Report date
echo '<tr><td colspan="10">Tarehe ya ripoti: '.date('d/m/Y H:i:s').'</td></tr>';
echo '<tr><td colspan="10">&nbsp;</td></tr>';
echo '</table>';

// Table header
echo '<table border="1" cellspacing="0" cellpadding="5" width="100%">';
echo '<tr class="header">';
echo '<th width="5%" class="text-center border">#</th>';
echo '<th width="10%" class="text-center border">Tarehe</th>';
echo '<th width="15%" class="text-center border">Dawa</th>';
echo '<th width="7%" class="text-center border">Idadi</th>';
echo '<th width="10%" class="text-center border">Kiasi</th>';
echo '<th width="10%" class="text-center border">Faida</th>';
echo '<th width="12%" class="text-center border">Aliyeuza</th>';
echo '<th width="12%" class="text-center border">Mteja</th>';
echo '<th width="12%" class="text-center border">Njia ya malipo</th>';
echo '<th width="12%" class="text-center border">Hali ya malipo</th>';
echo '<th width="12%" class="text-center border">Kituo/Tawi</th>';

echo '</tr>';

// Table data
$counter = 1;
while($row = mysqli_fetch_array($select_query)) {
    echo '<tr>';
    echo '<td class="text-center border">'.$counter++.'</td>';
    echo '<td class="text-center border">'.date('d/m/Y', strtotime($row['Date'])).'</td>';
    echo '<td class="text-left border">'.$row['medicines'].'</td>';
    echo '<td class="text-right border">'.$row['quantity'].'</td>';
    echo '<td class="text-right border">'.number_format($row['total_amount']).'</td>';
    echo '<td class="text-right border">'.number_format($row['total_profit']).'</td>';
    echo '<td class="text-left border">'.$row['created_by'].'</td>';
    echo '<td class="text-left border">'.$row['customer_name'].'</td>';
    echo '<td class="text-left border">'.$row['payment_method'].'</td>';
    echo '<td class="text-left border">'.$row['hali_ya_malipo'].'</td>';
    echo '<td class="text-left border">'.$row['location'].'</td>';

    echo '</tr>';
    
    $total_quantity += $row['quantity'];
    $total_amount += $row['total_amount'];
    $total_profit += $row['total_profit'];
}

// Totals row
echo '<tr class="total">';
echo '<td colspan="3" class="text-right border">Jumla Mkuu:</td>';
echo '<td class="text-right border">'.number_format($total_quantity).'</td>';
echo '<td class="text-right border">'.number_format($total_amount).'</td>';
echo '<td class="text-right border">'.number_format($total_profit).'</td>';
echo '<td colspan="4" class="border">&nbsp;</td>';
echo '</tr>';

echo '</table>';
echo '</body>';
echo '</html>';
?>