<?php

include("dbcon.php");

session_start();
$store_id = $_SESSION['store_id'];
// Check if the user is logged in
if(!isset($_SESSION['user_session'])){
    header("location:index.php");
    exit();
}

// Sanitize inputs
$medicine_name = mysqli_real_escape_string($con, $_POST['medicine_name']);
$expire_date = mysqli_real_escape_string($con, $_POST['expire_date']);

// Query to fetch the available quantity and actual price of the product
$query = "SELECT act_remain_quantity, selling_price 
          FROM stock 
          WHERE store_id = '$store_id'
          AND medicine_name = '$medicine_name' 
          AND expire_date = '$expire_date' 
          AND store_id = '$store_id'
          AND status = 'Available'";

// Execute the query
$result = mysqli_query($con, $query);

// Initialize response data
$response = array();

// Check if any record was found
if(mysqli_num_rows($result) > 0){
    while($row = mysqli_fetch_assoc($result)){
        $response['available_quantity'] = $row['act_remain_quantity']; // Available quantity
        $response['selling_price'] = $row['selling_price']; // Actual price of the product
    }
} else {
    // If no record found, set default values
    $response['available_quantity'] = 0;
    $response['selling_price'] = 0;
}

// Return the data as a JSON object
echo json_encode($response);

?>
