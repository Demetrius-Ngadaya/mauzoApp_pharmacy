
<?php

include("session.php");
include("dbcon.php");


   $invoice_number = $_GET['invoice_number'];

   if(isset($_POST['update'])){

$id = $_POST['id'];
$med_name = $_POST['med_name'];  
$category = $_POST['category'];    
$quantity =  $_POST['used_quantity'] + $_POST['received_quantity'] + $_POST['act_remain_quantity'];
$used_qty = $_POST['used_quantity'];
$remain_quantity = $_POST['received_quantity'] + $_POST['act_remain_quantity'] ;  
$act_remain_quantity = $_POST['received_quantity'] + $_POST['act_remain_quantity'];  
$exp_date= strtotime($_POST['exp_date']); 
$new_exp_date = date('Y-m-d',$exp_date);
$company =  $_POST['company']; 
$received_date =  $_POST['received_date']; 
$date_to_pay =  $_POST['date_to_pay']; 
$receipt_number =  $_POST['receipt_number']; 
$batch_number =  $_POST['batch_number']; 
$old_quantity = $_POST['act_remain_quantity']; 
$received_quantity =  $_POST['received_quantity']; 
$sell_type = $_POST['sell_type'];
$actual_price = $_POST['actual_price'];  
$selling_price = $_POST['selling_price'];
$profit_price = $_POST['profit_price'];
$credit_amount = $_POST['received_quantity'] * $_POST['actual_price'];
$created_by = $_SESSION['user_session']; 
$purchases_status = 'credit';
$status = 'Available'; 
$tax_amount = $_POST['tax_amount'];
$cost_kupakia = $_POST['cost_kupakia'];
$cost_kushusha = $_POST['cost_kushusha'];
$transport_cost = $_POST['transport_cost'];
$cost_kupanga = $_POST['cost_kupanga']; 
$products_cost = $_POST['products_cost'];
$total_cost = $_POST['total_cost'];      
$expected_profit = $_POST['expected_profit'];
$medicine_id = $_POST['id'];

  // HAPA UNAWEZA KUWEKA KITU CHOCHOTE KIFUNGUKE MDA WA KU LOAD
  $sql=" UPDATE stock SET medicine_name='$med_name',category='$category',quantity='$quantity', used_quantity='$used_qty', remain_quantity= '$act_remain_quantity',act_remain_quantity='$act_remain_quantity',expire_date='$new_exp_date',company='$company',sell_type='$sell_type',actual_price='$actual_price',selling_price='$selling_price',profit_price='$profit_price',status='$status' WHERE  store_id = '$store_id' and id = '$id' ";

   $result =mysqli_query($con,$sql); 
   
   $sql = "INSERT INTO purchases_report (
    medicine_name, category, old_quantity, received_quantity, receipt_number, batch_number, 
    date_to_pay, received_date, expire_date, company, sell_type, actual_price, selling_price, 
    profit_price, credit_amount, created_by, status, tax_amount, cost_kupakia, cost_kushusha, 
    transport_cost, cost_kupanga, products_cost, total_cost, expected_profit,medicine_id, store_id
) VALUES (
    '$med_name', '$category', '$old_quantity', '$received_quantity', '$receipt_number', '$batch_number', 
    '$date_to_pay', '$received_date', '$new_exp_date', '$company', '$sell_type', '$actual_price', 
    '$selling_price', '$profit_price', '$credit_amount', '$created_by', '$purchases_status', 
    '$tax_amount', '$cost_kupakia', '$cost_kushusha', '$transport_cost', '$cost_kupanga', 
    '$products_cost', '$total_cost', '$expected_profit','$medicine_id', '$store_id'
)";
  
     $result =mysqli_query($con,$sql);
     if ($result) {
      $_SESSION['success_message'] = "Manunuzi ya mkopo yamerekodiwa kikamilifu!";
      header("Location: record_credit_purchases.php?invoice_number=$invoice_number");
  } else {
      echo "<div style='color: red; text-align: center;'>Imeshindikana kurekodi manunuzi ya Dawa!</div>";
  }
 
}
 
?>