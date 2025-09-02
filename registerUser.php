
<?php
include("session.php");
include("dbcon.php");


if(isset($_POST['submit'])){//***INSERTING NEW  MEDICEINES******
// $invoice_number = $_GET['invoice_number'];
// 	   echo "<h1>....LOADING</h1>";
$user_name= $_POST['user_name'];
$password= $_POST['password'];  


// Check if the product already exists
$query = "SELECT * FROM users WHERE user_name = ? AND role = ?";
$stmt = $con->prepare($query);
$stmt->bind_param("ss", $user_name, $category);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows > 0) {
    // If the product exists, redirect back with an error message
    $_SESSION['error_message'] = "Mtumiaji  tayari yupo!";
    header("Location: user_management.php?invoice_number=$invoice_number");
    exit();
}
 $sql="INSERT INTO users(user_name,password) 
 VALUES ('$user_name','$password')";

$result =mysqli_query($con,$sql);
if ($result) {
 $_SESSION['success_message'] = "Mtumiaji ameongezwa kikamilifu!";
 header("Location: user_management.php?invoice_number=$invoice_number");
} else {
 echo "<div style='color: red; text-align: center;'>Failed to register product!</div>";
}

}
 

?>