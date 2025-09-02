
<?php
include("session.php");
?>
<!DOCTYPE html>
<html>
<head>
	<title>MauzoApp risiti</title>
<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="css/bootstrap-responsive.css">
  <link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="css/tcal.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/tcal.js"></script>
    <script type="text/javascript">

      function Clickheretoprint()
{ 
  var disp_setting="toolbar=yes,location=no,directories=yes,menubar=yes,"; 
      disp_setting+="scrollbars=yes,width=700, height=400, left=100, top=25"; 
  var content_vlue = document.getElementById("content").innerHTML; 
  
  var docprint=window.open("","",disp_setting); 
   docprint.document.open(); 
   docprint.document.write('</head><body onLoad="self.print()" style="width: 700px; font-size:11px; font-family:arial; font-weight:normal;">');          
   docprint.document.write(content_vlue); 
   docprint.document.close(); 
   docprint.focus(); 
}

      
    </script>
    <style>
        .content {
            font-family: Arial, sans-serif;
            font-size: 16px;
            line-height: 1.6;
            margin: 0;
            padding: 0;
        }
        .header {
            text-align: center;
            font-size: 22px;
            font-weight: bold;
            margin: 0;
            padding: 0;
        }
        .header img {
            max-width: 140px; /* Adjust this value as needed */
            height: auto;
            margin-bottom: 10px;
            display: block; /* Ensures proper vertical alignment */
            margin-left: auto;
            margin-right: auto;
        }
        .contact {
            text-align: center;
            font-size: 16px;
            margin-bottom: 20px;
        }
        .item, .total, .paid, .change, .seller {
            margin-bottom: 10px;
            font-weight: bold;
        }
        .item div {
            margin-bottom: 5px;
        }
    </style>
</head>
<body>

  <div class="container">
    <div id="content">
        <div class="header">
            <!-- <img src="images/logo.JPEG" alt="D_TECH PHARMACY"> -->
            <br>
<center>
<strong>
         D_TECH SHOP
            <br>
            S.L.P 196, IFAKARA
            <br>
            SIM: 0655551379
            <br>
            TIN: 131-913-184, VRN: 40-025450-R
</strong>
</center>
        </div>

	<?php 
  
  $invoice_number = $_GET['invoice_number'];
  $date           = $_POST['date'];
  $paid_amount   = $_POST['paid_amount'];
	?>

  <form method="POST" action="save_invoice.php">
  	<table class="table table-bordered table-hover" border="1"  style="font-family: arial; font-size: 22px;text-align:left;" width="100%">
      <tr>
<h3>Jina la mteja:<?php echo $paid_amount?>. &nbsp; Tarehe:<?php echo $date?>.&nbsp;    </h3>    
      </tr>
		<thead>
			<tr>
        <th>Jina la Dawa </th>
				<th> Idadi</th>  
				<th> Bai </th>
				<th> Jumla ndogo </th>
				<th> Njia ya malipo</th>
			</tr>
		</thead>
    <tbody>
      <?php

         include("dbcon.php");

         $select_sql = "SELECT * FROM on_hold where store_id = '$store_id' and  invoice_number = '$invoice_number'";

         $select_query =mysqli_query($con,$select_sql);

          while($row =mysqli_fetch_array($select_query)):
      ?>
        <tr class="record">
        <td><h3><?php echo $row['medicine_name'];?></h3>
          <input type="hidden" name="medicine_name[]" value="<?php echo $row['medicine_name']?>"></td>
          <input type="hidden" name="ex_date" value="<?php echo $row['expire_date']?>">
          <input type="hidden" name="ex_date" value="<?php echo $row['category']?>">
          <input type="hidden" name="created_by" value="<?php echo $created_by; ?>">
        <td><h3><?php echo $row['qty']." (".$row['type'].")"; ?></h3>
          <input type="hidden" name="qty[]" value="<?php echo $row['qty']."(".$row['type'].")"; ?>">
        </td>
        <td>
        <?php
        echo "<h3>".number_format($row['discount'])."<h3>";
        ?>
        </td>
        <td>
        <?php
        
        echo "<h3>".number_format($row['amount'])."<h3>";
        ?>
        </td>
        <td>
        <?php
        echo "<h3>".$row['payment_method']."<h3>";

        ?>
        </td>
        </tr>
      <?php endwhile;?>
  
        <tr>
          <td colspan="3" style=" text-align:right;"><strong style="font-size: 22px;">Jumla kuu: &nbsp;</strong></td>
          <td colspan="2"><strong style="font-size: 22px;">
          <?php

          $select_sql = "SELECT sum(amount) from on_hold where store_id = '$store_id' and invoice_number = '$invoice_number'";

          $select_sql = mysqli_query($con,$select_sql);

          while($row = mysqli_fetch_array($select_sql)){

            $amount =  $row['sum(amount)'];

            echo '<h3>'.number_format($amount).'</h3>';

          }
          
          ?>
          </strong></td>
        </tr>

         <!-- <tr>
          <td colspan="3" style=" text-align:right;"><strong style="font-size: 22px;">Kiasi kilicholipwa: &nbsp;</strong></td>
          <td colspan="2"><strong style="font-size: 22px;">
          <?php

          echo '<h3>'.'Tsh '.$paid_amount.'</h3>';


          ?>
          </strong></td>
        </tr> -->

        <tr>
          <td colspan="5" style=" text-align:center;">Jina la muuzaji:      
          <?php

          echo ($created_by);
          
          ?>
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Aliyepokea pesa ................  
          </td>
        </tr>
    </tbody>
  </table><br/>
  
  </div>

  <input type="hidden" name="paid_amount" value="<?php echo $paid_amount?>">
  <input type="hidden" name="invoice_number" value="<?php echo $invoice_number?>">
  <input type="hidden" name="date" value="<?php echo $date?>">
  <input type="submit" name="submit" class="btn btn-success btn-large" value="Hifadhi mauzo" >
  <a href="javascript:Clickheretoprint()" class="btn btn-danger btn-md" style="float: right;"><i class="icon icon-print"></i> Printi risiti</a>

  </form>
  <a href="hamisha_kwa_kuuza.php?invoice_number=<?php echo $_GET['invoice_number']?>"><button class="btn btn-default"><i class="icon-arrow-left"></i>Rudi nyuma</button></a>
  
  </body>
  </html>