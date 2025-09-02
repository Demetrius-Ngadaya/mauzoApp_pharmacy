<?php
session_start();
include('dbcon.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = mysqli_query($con, "DELETE FROM customer_order WHERE store_id = '$store_id' and id = '$id'") or die(mysqli_error($con));

    if ($query) {
        $_SESSION['success_message'] = "Order deleted successfully!";
    } else {
        $_SESSION['error_message'] = "Failed to delete order!";
    }
    header("location: customer_order.php?invoice_number=" . $_GET['invoice_number']);
}
?>