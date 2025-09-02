<?php
// Include database connection file
include("dbcon.php");

// Fetch data between specified dates and other filters
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
if (!empty($customer_name)) {
    $select_sql .= " AND s.customer_name LIKE '%$customer_name%'";
}
if (!empty($medicine)) {
    $select_sql .= " AND s.medicines LIKE '%$medicine%'";
}
if (!empty($category)) {
    $select_sql .= " AND s.category LIKE '%$category%'";
}

$select_sql .= " GROUP BY s.medicines, s.category";
$select_sql .= " ORDER BY s.medicines ASC";
$select_query = mysqli_query($con, $select_sql);

// Set headers for Excel download
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=\"Ripoti ya Faida kwa Dawa.xls\"");
header("Pragma: no-cache");
header("Expires: 0");
?>

<html>
<head>
    <meta charset="UTF-8">
</head>
<body>
    <table border="1">
        <tr>
            <th colspan="8" style="text-align: center; font-size: 16px; font-weight: bold;">Ripoti ya Faida kwa Dawa</th>
        </tr>
        <tr>
            <th colspan="8" style="text-align: center;">Kuanzia: <?php echo date('d/m/Y', strtotime($d1)); ?> - Mpaka: <?php echo date('d/m/Y', strtotime($d2)); ?></th>
        </tr>
        <tr>
            <th style="background-color: #383838; color: #FFFFFF;">Jina la Dawa</th>
            <th style="background-color: #383838; color: #FFFFFF;">Aina ya Dawa</th>
            <th style="background-color: #383838; color: #FFFFFF;">Mauzo kwa Dawa</th>
            <th style="background-color: #383838; color: #FFFFFF;">Gharama kwa Dawa</th>
            <th style="background-color: #383838; color: #FFFFFF;">Faida kwa Dawa</th>
            <th style="background-color: #383838; color: #FFFFFF;">Jumla Ndogo Mauzo</th>
            <th style="background-color: #383838; color: #FFFFFF;">Jumla Ndogo Gharama</th>
            <th style="background-color: #383838; color: #FFFFFF;">Jumla Ndogo Faida</th>
        </tr>
        
        <?php
        // Initialize totals
        $total_gross_sales = 0;
        $total_gross_cost = 0;
        $total_gross_profit = 0;
        
        while($row = mysqli_fetch_array($select_query)) :
            $unit_price = ($row['total_quantity'] > 0) ? $row['total_sales'] / $row['total_quantity'] : 0;
            $unit_cost = ($row['total_quantity'] > 0 && $row['total_cost'] > 0) ? $row['total_cost'] / $row['total_quantity'] : 0;
            $unit_profit = $unit_price - $unit_cost;
            
            $subtotal_sales = $row['total_sales'];
            $subtotal_cost = $unit_cost * $row['total_quantity'];
            $subtotal_profit = $unit_profit * $row['total_quantity'];
            
            $total_gross_sales += $subtotal_sales;
            $total_gross_cost += $subtotal_cost;
            $total_gross_profit += $subtotal_profit;
        ?>
        <tr>
            <td><?php echo $row['medicines']; ?></td>
            <td><?php echo $row['category']; ?></td>
            <td style="text-align: right;"><?php echo number_format($unit_price, 2); ?></td>
            <td style="text-align: right;"><?php echo number_format($unit_cost, 2); ?></td>
            <td style="text-align: right;"><?php echo number_format($unit_profit, 2); ?></td>
            <td style="text-align: right;"><?php echo number_format($subtotal_sales, 2); ?></td>
            <td style="text-align: right;"><?php echo number_format($subtotal_cost, 2); ?></td>
            <td style="text-align: right;"><?php echo number_format($subtotal_profit, 2); ?></td>
        </tr>
        <?php endwhile; ?>
        
        <tr style="font-weight: bold;">
            <td colspan="5" style="text-align: right;">Jumla Mkuu:</td>
            <td style="text-align: right;"><?php echo number_format($total_gross_sales, 2); ?></td>
            <td style="text-align: right;"><?php echo number_format($total_gross_cost, 2); ?></td>
            <td style="text-align: right;"><?php echo number_format($total_gross_profit, 2); ?></td>
        </tr>
    </table>
</body>
</html>