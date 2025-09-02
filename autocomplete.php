<?php
include("dbcon.php");
session_start();
$store_id = $_SESSION['store_id'];

if(!isset($_SESSION['user_session'])){
    header("location:index.php");
}

// Get the search term (changed from drug_result to term)
$term = isset($_POST['term']) ? mysqli_real_escape_string($con, $_POST['term']) : '';

$query = "SELECT DISTINCT medicine_name, expire_date, sell_type 
          FROM stock 
          WHERE store_id = '$store_id' AND medicine_name LIKE '%".$term."%' 
          AND status = 'Available'
          ORDER BY medicine_name ASC";

$result = mysqli_query($con, $query);

if(!$result) {
    // Handle query error
    die("Query failed: " . mysqli_error($con));
}

$data = array();
while($row = mysqli_fetch_assoc($result)) {
    // Format the data for display
    $data[] = array(
        'label' => $row["medicine_name"] . " (" . $row['sell_type'] . ") - " . $row['expire_date'],
        'value' => $row["medicine_name"] . "," . $row['expire_date'],
        'sell_type' => $row['sell_type']
    );
}

echo json_encode($data);
?>