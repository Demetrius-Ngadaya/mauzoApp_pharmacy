<?php
include('dbcon.php'); // Include database connection

if (isset($_POST['category'])) {
    $category = $_POST['category'];
    $query = mysqli_query($con, "SELECT id, medicine_name FROM stock WHERE store_id = '$store_id' and category = '$category'") or die(mysqli_error($con));
    
    $output = '<option value="">Select Medicine</option>';
    while ($row = mysqli_fetch_array($query)) {
        $output .= '<option value="'.$row['id'].'">'.$row['medicine_name'].'</option>';
    }
    echo $output;
} else {
    echo '<option value="">No medicines found</option>';
}
?>