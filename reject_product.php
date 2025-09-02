<?php
include("session.php");
include("dbcon.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $purchase_id = $_POST['purchase_id'];
    $medicine_id = $_POST['medicine_id'];
    $rejected_quantity = $_POST['rejected_quantity'];
    $rejected_reason = $_POST['rejected_reason'];
    $recorded_by = $_SESSION['user_session'];
    $store_id = $_SESSION['store_id'];

    // Fetch purchase details
    $purchase_sql = "SELECT * FROM purchases_report WHERE store_id = '$store_id' AND  id = '$purchase_id'";
    $purchase_result = mysqli_query($con, $purchase_sql);
    $purchase_row = mysqli_fetch_assoc($purchase_result);

    // Calculate new values
    $quantity_after_rejects = $purchase_row['received_quantity'] - $rejected_quantity;
    $new_products_cost = $quantity_after_rejects * $purchase_row['actual_price'];
    $new_total_cost = $purchase_row['tax_amount'] + $purchase_row['cost_kupakia'] + $purchase_row['cost_kushusha'] + $purchase_row['transport_cost'] + $purchase_row['cost_kupanga'] + $new_products_cost;
    $new_expected_profit = ($purchase_row['selling_price'] * $quantity_after_rejects) - $new_total_cost;

    // Insert into rejected_products table
    $insert_sql = "INSERT INTO rejected_products (
        medicine_name, category, old_quantity, receipt_number, batch_number, date_to_pay, received_date, 
        expire_date, company, sell_type, actual_price, selling_price, profit_price, credit_amount, 
        created_by, status, tax_amount, cost_kupakia, cost_kushusha, transport_cost, cost_kupanga, 
        medicine_id, old_products_cost, old_expected_profit, old_received_quantity, rejected_quantity, 
        rejected_reason, quantity_after_rejects, new_total_cost, new_products_cost, new_expected_profit, store_id
    ) VALUES (
        '{$purchase_row['medicine_name']}', '{$purchase_row['category']}', '{$purchase_row['old_quantity']}', 
        '{$purchase_row['receipt_number']}', '{$purchase_row['batch_number']}', '{$purchase_row['date_to_pay']}', 
        '{$purchase_row['received_date']}', '{$purchase_row['expire_date']}', '{$purchase_row['company']}', 
        '{$purchase_row['sell_type']}', '{$purchase_row['actual_price']}', '{$purchase_row['selling_price']}', 
        '{$purchase_row['profit_price']}', '{$purchase_row['credit_amount']}', '$recorded_by', 
        '{$purchase_row['status']}', '{$purchase_row['tax_amount']}', '{$purchase_row['cost_kupakia']}', 
        '{$purchase_row['cost_kushusha']}', '{$purchase_row['transport_cost']}', '{$purchase_row['cost_kupanga']}', 
        '$medicine_id', '{$purchase_row['products_cost']}', '{$purchase_row['expected_profit']}', 
        '{$purchase_row['received_quantity']}', '$rejected_quantity', '$rejected_reason', '$quantity_after_rejects', 
        '$new_total_cost', '$new_products_cost', '$new_expected_profit, '$store_id'
    )";
    mysqli_query($con, $insert_sql);

    // Update act_remain_quantity in stock table
    $update_stock_sql = "UPDATE stock SET act_remain_quantity = act_remain_quantity - $rejected_quantity WHERE store_id = '$store_id' AND id = '$medicine_id'";
    mysqli_query($con, $update_stock_sql);

    // Update purchases_report table
    $update_purchase_sql = "UPDATE purchases_report SET 
        received_quantity = '$quantity_after_rejects', 
        products_cost = '$new_products_cost', 
        total_cost = '$new_total_cost', 
        expected_profit = '$new_expected_profit' 
        WHERE store_id = '$store_id' AND id = '$purchase_id'";
    mysqli_query($con, $update_purchase_sql);

    $_SESSION['success_message'] = "Product rejected successfully!";
    header("Location: reject_purchases.php?invoice_number={$_GET['invoice_number']}");
    exit();
}
?>