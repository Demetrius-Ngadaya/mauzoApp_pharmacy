<?php
session_start();
include('dbcon.php');

if(isset($_POST['store_name']) && isset($_POST['store_location'])) {
    $name = $_POST['store_name'];
    $location = $_POST['store_location'];
    $invoice_number = isset($_GET['invoice_number']) ? $_GET['invoice_number'] : '';
    
    $query = "INSERT INTO stores (name, location, created_at) VALUES ('$name', '$location', NOW())";
    $result = mysqli_query($con, $query);
    
    if($result) {
        $_SESSION['success_message'] = "Tawi/kituo kimeongezwa kikamilifu!";
    } else {
        $_SESSION['error_message'] = "Hitilafu ilitokea: " . mysqli_error($con);
    }
    
    header("Location: store_management.php?invoice_number=$invoice_number");
    exit();
} else {
    $_SESSION['error_message'] = "Tafadhali jaza sehemu zote!";
    header("Location: store_management.php?invoice_number=$invoice_number");
    exit();
}
?>