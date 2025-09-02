<?php
session_start();
include('dbcon.php');
$store_id = $_SESSION['store_id'];
if (isset($_POST['customer_name'])) {
    $id = $_POST['id'];
    $customer_name = $_POST['customer_name'];
    $category = $_POST['category'];
    $order_medicine_name = $_POST['order_medicine_name'];
    $order_quantity = $_POST['order_quantity'];
    $order_total_amount = $_POST['order_total_amount'];
    $order_total_profit = $_POST['order_total_profit'];
    $order_payment_method = $_POST['order_payment_method'];
    $date_to_pay = $_POST['date_to_pay'];
    $customer_phone = $_POST['customer_phone'];

    $query = mysqli_query($con, "UPDATE customer_order SET customer_name = '$customer_name', category = '$category', order_medicine_name = '$order_medicine_name', order_quantity = '$order_quantity', order_total_amount = '$order_total_amount', order_total_profit = '$order_total_profit', order_payment_method = '$order_payment_method', date_to_pay = '$date_to_pay', customer_phone = '$customer_phone' WHERE store_id = '$store_id' and id = '$id'") or die(mysqli_error($con));

    if ($query) {
        $_SESSION['success_message'] = "Order updated successfully!";
    } else {
        $_SESSION['error_message'] = "Failed to update order!";
    }
    header("location: customer_order.php?invoice_number=" . $_GET['invoice_number']);
}
?>