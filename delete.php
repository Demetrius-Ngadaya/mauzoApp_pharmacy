<?php
include("dbcon.php");

include("session.php");
$deleted_by = $_SESSION['user_session']; 
$deleted_date = date('Y-m-d'); // Correct date format for MySQL

$id = $_GET['id'];

// Fetch the product details from the stock table
$fetch_sql = "SELECT * FROM stock WHERE store_id = '$store_id' and id = '$id'";
$fetch_query = mysqli_query($con, $fetch_sql);

if ($fetch_query && mysqli_num_rows($fetch_query) > 0) {
    $row = mysqli_fetch_assoc($fetch_query);

    // Insert the fetched details into the deleted_products table
    $insert_sql = "INSERT INTO deleted_products (
        medicine_name, category, quantity, used_quantity, remain_quantity, act_remain_quantity, 
        register_date, expire_date, stock_alert, company, sell_type, actual_price, 
        selling_price, profit_price, created_by, deleted_by, deleted_date, status, store_id
    ) VALUES (
        '{$row['medicine_name']}', '{$row['category']}', '{$row['quantity']}', '{$row['used_quantity']}', 
        '{$row['remain_quantity']}', '{$row['act_remain_quantity']}', '{$row['register_date']}', 
        '{$row['expire_date']}', '{$row['stock_alert']}', '{$row['company']}', '{$row['sell_type']}', 
        '{$row['actual_price']}', '{$row['selling_price']}', '{$row['profit_price']}', 
        '{$row['created_by']}', '$deleted_by', '$deleted_date', '{$row['status']},', '$store_id'
    )";

    $insert_query = mysqli_query($con, $insert_sql);

    if ($insert_query) {
        // Delete the product from the stock table
        $delete_sql = "DELETE FROM stock WHERE store_id = '$store_id' and id = '$id'";
        $delete_query = mysqli_query($con, $delete_sql);

        if ($delete_query) {
            echo json_encode(["status" => "success", "message" => "Product deleted successfully!"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error deleting product: " . mysqli_error($con)]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Error saving product details to deleted_products table: " . mysqli_error($con)]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Product not found!"]);
}

exit();
?>