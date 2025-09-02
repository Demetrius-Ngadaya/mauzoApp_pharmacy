<?php
include('dbcon.php');

if (isset($_POST['category'])) {
    $category = $_POST['category'];
    $query = mysqli_query($con, "SELECT * FROM stock WHERE store_id = '$store_id' and category = '$category'") or die(mysqli_error($con));
    $output = '';
    while ($row = mysqli_fetch_array($query)) {
        $output .= '<option value="' . $row['id'] . '">' . $row['medicine_name'] . '</option>';
    }
    echo $output;
}
?>