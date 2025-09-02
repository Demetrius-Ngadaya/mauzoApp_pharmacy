<?php
include('dbcon.php');

if (isset($_POST['medicine_id'])) {
    $medicine_id = $_POST['medicine_id'];
    $query = mysqli_query($con, "SELECT selling_price, profit_price FROM stock WHERE store_id = '$store_id' and id = '$medicine_id'") or die(mysqli_error($con));
    $row = mysqli_fetch_array($query);

    if ($row) {
        $data = array(
            'price' => $row['selling_price'],
            'profit_price' => $row['profit_price']
        );
        echo json_encode($data);
    } else {
        echo json_encode(array('price' => 0, 'profit_price' => 0));
    }
}
?>