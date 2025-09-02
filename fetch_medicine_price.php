<?php
include('dbcon.php');

if (isset($_POST['medicine_id'])) {
    $medicineId = $_POST['medicine_id'];
    $query = mysqli_query($con, "SELECT selling_price FROM stock WHERE store_id = '$store_id' and id = '$medicineId'") or die(mysqli_error($con));
    $row = mysqli_fetch_array($query);
    echo $row['selling_price'];
}
?>