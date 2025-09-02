<?php
session_start();
include('dbcon.php');

if(isset($_POST['store_id']) && isset($_POST['store_name']) && isset($_POST['store_location'])) {
    $id = $_POST['store_id'];
    $name = $_POST['store_name'];
    $location = $_POST['store_location'];
    $invoice_number = isset($_GET['invoice_number']) ? $_GET['invoice_number'] : '';
    
    $query = "UPDATE stores SET name='$name', location='$location' WHERE id='$id'";
    $result = mysqli_query($con, $query);
    
    if($result) {
        $_SESSION['success_message'] = "Taarifa za tawi/kituo zimebadilishwa kikamilifu!";
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