
<?php

   include("dbcon.php");

session_start();

if(!isset($_SESSION['user_session'])){

    header("location:index.php");
}
   @$product=mysqli_real_escape_string($con,$_POST['product']);

   $query="SELECT * from stock where product = '$bar_code' and status= 'Available'
   ";

   $result =mysqli_query($con,$query);

   $data= array();


   while($row = mysqli_fetch_array($result)){


   	$data [] = $row["medicine_name"].",".$row['expire_date'].",(".$row['sell_type'].")";

   }
     echo json_encode($data);

?>