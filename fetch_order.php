<?php
include('dbcon.php');

if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $query = mysqli_query($con, "SELECT * FROM customer_order WHERE store_id = '$store_id' and id = '$id'") or die(mysqli_error($con));
    $row = mysqli_fetch_array($query);

    if ($row) {
        $data = array(
            'id' => $row['id'],
            'customer_name' => $row['customer_name'],
            'category' => $row['category'],
            'medicine_id' => $row['medicine_id'],
            'order_medicine_name' => $row['order_medicine_name'],
            'order_quantity' => $row['order_quantity'],
            'order_total_amount' => $row['order_total_amount'],
            'order_total_profit' => $row['order_total_profit'],
            'order_payment_method' => $row['order_payment_method'],
            'date_to_pay' => $row['date_to_pay'],
            'customer_phone' => $row['customer_phone']
        );
        echo json_encode($data);
    } else {
        echo json_encode(array('error' => 'Order not found'));
    }
}
?>