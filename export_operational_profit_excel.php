<?php
include("dbcon.php");

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

// Set headers for Excel download
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=\"Ripoti_Faida_Uendeshaji_".$d1."_".$d2.".xls\"");
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
            <th colspan="6" style="text-align: center; font-size: 16px; font-weight: bold;">PP TIMBER</th>
        </tr>
        <tr>
            <th colspan="6" style="text-align: center; font-size: 14px;">Ripoti ya Faida ya Uendeshaji</th>
        </tr>
        <tr>
            <th colspan="6" style="text-align: center;">Kuanzia: <?= date('d/m/Y', strtotime($d1)) ?> - Mpaka: <?= date('d/m/Y', strtotime($d2)) ?></th>
        </tr>
        <tr>
            <th style="background-color: #383838; color: #FFFFFF;">Tarehe</th>
            <th style="background-color: #383838; color: #FFFFFF;">Mauzo (Sales)</th>
            <th style="background-color: #383838; color: #FFFFFF;">Gharama (Cost)</th>
            <th style="background-color: #383838; color: #FFFFFF;">Faida ya Jumla</th>
            <th style="background-color: #383838; color: #FFFFFF;">Matumizi</th>
            <th style="background-color: #383838; color: #FFFFFF;">Faida ya Uendeshaji</th>
        </tr>
        
        <?php
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
        ?>
        <tr>
            <td><?= $current_date ?></td>
            <td style="text-align: right;"><?= number_format($daily_sales, 2) ?> Tsh</td>
            <td style="text-align: right;"><?= number_format($daily_cost, 2) ?> Tsh</td>
            <td style="text-align: right;"><?= number_format($daily_gross_profit, 2) ?> Tsh</td>
            <td style="text-align: right;"><?= number_format($daily_exp, 2) ?> Tsh</td>
            <td style="text-align: right;"><?= number_format($daily_operational_profit, 2) ?> Tsh</td>
        </tr>
        <?php } ?>
        
        <tr style="font-weight: bold;">
            <td>Jumla Mkuu:</td>
            <td style="text-align: right;"><?= number_format($total_sales, 2) ?> Tsh</td>
            <td style="text-align: right;"><?= number_format($total_cost, 2) ?> Tsh</td>
            <td style="text-align: right;"><?= number_format($total_gross_profit, 2) ?> Tsh</td>
            <td style="text-align: right;"><?= number_format($total_expenditure, 2) ?> Tsh</td>
            <td style="text-align: right;"><?= number_format($total_operational_profit, 2) ?> Tsh</td>
        </tr>
    </table>
</body>
</html>