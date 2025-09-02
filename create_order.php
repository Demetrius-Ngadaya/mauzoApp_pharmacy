<?php
session_start();
include('dbcon.php');

if (isset($_POST['customer_name'])) {
    $customer_name = $_POST['customer_name'];
    $category = $_POST['category'];
    $order_medicine_name = $_POST['order_medicine_name'];
    $order_quantity = $_POST['order_quantity'];
    $order_total_amount = $_POST['order_total_amount'];
    $order_total_profit = $_POST['order_total_profit'];
    $order_payment_method = $_POST['order_payment_method'];
    $date_to_pay = $_POST['date_to_pay'];
    $customer_phone = $_POST['customer_phone'];
    $invoice_number = $_POST['invoice_number'];
    $order_status = $_POST['order_status'];
    $store_order_quantity = $_POST['store_order_quantity'];
    $order_recorder = $_POST['order_recorder'];

    $query = mysqli_query($con, "INSERT INTO customer_order (customer_name, category, order_medicine_name, order_quantity, order_total_amount, order_total_profit, order_payment_method, date_to_pay, customer_phone, invoice_number, order_status, store_order_quantity, order_recorder, store_id) 
    VALUES ('$customer_name', '$category', '$order_medicine_name', '$order_quantity', '$order_total_amount', '$order_total_profit', '$order_payment_method', '$date_to_pay', '$customer_phone', '$invoice_number', '$order_status', '$store_order_quantity', '$order_recorder', '$store_id')") or die(mysqli_error($con));

    if ($query) {
        $_SESSION['success_message'] = "Order created successfully!";
    } else {
        $_SESSION['error_message'] = "Failed to create order!";
    }
    header("location: customer_order.php?invoice_number=$invoice_number");
}
?>