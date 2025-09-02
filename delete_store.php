<?php
session_start();
include('dbcon.php');

if(isset($_POST['store_id'])) {
    $id = $_POST['store_id'];
    $invoice_number = isset($_GET['invoice_number']) ? $_GET['invoice_number'] : '';
    
    $query = "DELETE FROM stores WHERE id='$id'";
    $result = mysqli_query($con, $query);
    
    if($result) {
        $_SESSION['success_message'] = "Tawi/kituo limefutwa kikamilifu!";
    } else {
        $_SESSION['error_message'] = "Hitilafu ilitokea: " . mysqli_error($con);
    }
    
    header("Location: store_management.php?invoice_number=$invoice_number");
    exit();
} else {
    $_SESSION['error_message'] = "Tawi/kituo halikupatikana!";
    header("Location: store_management.php?invoice_number=$invoice_number");
    exit();
}
?>