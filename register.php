<?php
session_start();
if (!isset($_SESSION['user_session'])) {
    header("location:index.php");
}
include("dbcon.php");

if (isset($_POST['submit'])) {
    $invoice_number = $_GET['invoice_number'];
    $med_name = $_POST['med_name'];
    $category = $_POST['category'];
    $quantity = $_POST['quantity'];
    $used_quantity = 0;
    $reg_date = date('Y-m-d', strtotime($_POST['reg_date']));
    $exp_date = "2050-03-29";
    $stock_alert = $_POST['stock_alert'];
    $company = $_POST['company'];
    $sell_type = $_POST['sell_type'];
    $actual_price = $_POST['actual_price'];
    $selling_price = $_POST['selling_price'];
    $profit_price = $_POST['profit_price'];
    $created_by = $_POST['created_by'];
    $status = "Available";
    $store_id = $_SESSION['store_id'];

    // Check if the product already exists
    $query = "SELECT * FROM stock WHERE store_id = '$store_id' AND medicine_name = ? AND category = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("ss", $med_name, $category);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['error_message'] = "Dawa uliyoingiza tayari ipo!";
        header("Location: hariri_bidhaa.php?invoice_number=$invoice_number");
        exit();
    }

    $sql = "INSERT INTO stock 
                 (medicine_name, category,act_remain_quantity,quantity,remain_quantity,used_quantity,register_date,expire_date,stock_alert,sell_type,actual_price,selling_price,company, profit_price,  created_by, status, store_id)
            VALUES ('$med_name', '$category', '$quantity','$quantity','$quantity','$used_quantity','$reg_date', '$exp_date', '$stock_alert', '$sell_type', '$actual_price','$selling_price','$company','$profit_price','$created_by', '$status', '$store_id')";

    if (mysqli_query($con, $sql)) {
        $_SESSION['success_message'] = "Dawa imeongezwa kikamilifu!";
    } else {
        $_SESSION['error_message'] = "Failed to register product!";
    }
    header("Location: hariri_bidhaa.php?invoice_number=$invoice_number");
}
?>