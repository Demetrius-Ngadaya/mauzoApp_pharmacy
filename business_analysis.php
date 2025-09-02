<?php
include("session.php");
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>MauzoApp</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="./plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="./plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="./plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="./dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">


</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper"> 


    <?php include("navbar.php"); ?>   
    <?php include('indexSideBar.php') ?>
  
  

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">	

          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <!-- <li class="breadcrumb-item"><a href="#">Admin</a></li>
              <li class="breadcrumb-item active">Dashboard</li> -->
            </ol>
          </div>
        </div>
      </div>
      
      <!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
             
            <div class="card">
              <div class="card-header">

   

   

              <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>  
                    
                 
                <?php
include("dbcon.php");

// Get the current date
$currentDate = date("Y-m-d");

// Construct the SQL query to calculate the total sales for today's sales
$select_sql = "SELECT SUM(total_amount) AS total_profit FROM sales WHERE date = '$currentDate'";

// Execute the SQL query
$select_query = mysqli_query($con, $select_sql);

// Check if there are results
if ($row = mysqli_fetch_assoc($select_query)) {
    // Display the total profit
    echo 'Tsh ' . number_format($row['total_profit']);
} else {
    // If there are no sales recorded for today, display a message
    echo 'No sales recorded for today.';
}
?>


                </h3>
                


                <p>mauzo leo</p>
              </div>
              
              <a href="today_sales.php?invoice_number=<?php echo $_GET['invoice_number']?>" class="small-box-footer">Tazama mauzo <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3> 
              
                <?php
include("dbcon.php");

// Get the current date
$currentDate = date("Y-m-d");

// Construct the SQL query to calculate the total profit for today's sales
$select_sql = "SELECT SUM(total_profit) AS total_profit FROM sales WHERE store_id = '$store_id' AND date = '$currentDate'";

// Execute the SQL query
$select_query = mysqli_query($con, $select_sql);

// Check if there are results
if ($row = mysqli_fetch_assoc($select_query)) {
    // Display the total profit
    echo 'Tsh ' . number_format($row['total_profit']);
} else {
    // If there are no sales recorded for today, display a message
    echo 'No sales recorded for today.';
}
?>

              
              </h3>   
                 
                <p>faida kwa leo</p>
              </div>
             
              <a href="profit_today.php?invoice_number=<?php echo $_GET['invoice_number']?>" class="small-box-footer">Tazama faida <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3> 
                    
                 
                <?php
include("dbcon.php");

// Get the current date
$currentDate = date("Y-m-d");

// Construct the SQL query to calculate the total sales for today's sales
$select_sql = "SELECT COUNT(total_amount) AS total_profit FROM sales WHERE store_id = '$store_id' AND date = '$currentDate'";

// Execute the SQL query
$select_query = mysqli_query($con, $select_sql);

// Check if there are results
if ($row = mysqli_fetch_assoc($select_query)) {
    // Display the total profit
    echo ' ' . number_format($row['total_profit']);
} else {
    // If there are no sales recorded for today, display a message
    echo 'No sales recorded for today.';
}
?>

                </h3>

                <p>Dawa zilizouzwa leo</p>
              </div>
              <a href="today_sales.php?invoice_number=<?php echo $_GET['invoice_number']?>" class="small-box-footer">Tazama zaidi<i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3> 

                
                <?php
include("dbcon.php");

// Get the current date
$currentDate = date("Y-m-d");

// Construct the SQL query to calculate the total sales for today's sales
$select_sql = "SELECT SUM(expenditure_amount) AS expenditure_amount FROM expenditure WHERE store_id = '$store_id' AND created_at = '$currentDate'";

// Execute the SQL query
$select_query = mysqli_query($con, $select_sql);

// Check if there are results
if ($row = mysqli_fetch_assoc($select_query)) {
    // Display the total profit
    echo 'Tsh ' . number_format($row['expenditure_amount']);
} else {
    // If there are no sales recorded for today, display a message
    echo 'No sales recorded for today.';
}
?>


                    </h3>

                <p>Matumizi leo</p>
              </div>
              <a href="today_expenditure.php?invoice_number=<?php echo $_GET['invoice_number']?>" class="small-box-footer">Tazama matumizi <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->
        <!-- Main row -->
        <div class="row">
          <!-- Left col -->
          
          <!-- /.Left col -->
         
        </div>
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>





    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>  
                    
                 
             
                <?php
include("dbcon.php");

// Get the current week's starting and ending dates
$currentWeekStart = date('Y-m-d', strtotime('monday this week'));
$currentWeekEnd = date('Y-m-d', strtotime('sunday this week'));

// Construct the SQL query to calculate the total sales for the current week
$select_sql = "SELECT SUM(total_amount) AS total_profit FROM sales WHERE store_id = '$store_id' AND Date BETWEEN '$currentWeekStart' AND '$currentWeekEnd'";

// Execute the SQL query
$select_query = mysqli_query($con, $select_sql);

// Check if there are results
if ($row = mysqli_fetch_array($select_query)) {
    // Display the total profit
    echo 'Tsh ' . number_format($row['total_profit']);
} else {
    // If there are no sales recorded for the current week, display a message
    echo 'No sales recorded for the current week.';
}
?>
                </h3>
                


                <p>Sales this week</p>
              </div>
              <a href="sales_this_week.php?invoice_number=<?php echo $_GET['invoice_number']?>" class="small-box-footer">Tazama mauzo <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3> 
              
                <?php
include("dbcon.php");

// Get the current week's starting and ending dates
$currentWeekStart = date('Y-m-d', strtotime('monday this week'));
$currentWeekEnd = date('Y-m-d', strtotime('sunday this week'));

// Construct the SQL query to calculate the total sales for the current week
$select_sql = "SELECT SUM(total_profit) AS total_profit FROM sales WHERE store_id = '$store_id' AND Date BETWEEN '$currentWeekStart' AND '$currentWeekEnd'";

// Execute the SQL query
$select_query = mysqli_query($con, $select_sql);

// Check if there are results
if ($row = mysqli_fetch_array($select_query)) {
    // Display the total profit
    echo 'Tsh ' . number_format($row['total_profit']);
} else {
    // If there are no sales recorded for the current week, display a message
    echo 'No sales recorded for the current week.';
}
?>      
              </h3>   
                 
                <p>Profit this week</p>
              </div>
              <a href="sales_this_week.php?invoice_number=<?php echo $_GET['invoice_number']?>" class="small-box-footer">Tazama faida <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3> 
                    
                 
                <?php
include("dbcon.php");

// Get the current year and month in the format YYYY-MM
$currentYearMonth = date("Y-m");

// Construct the SQL query to calculate the total profit for the current month
$select_sql = "SELECT COUNT(total_amount) AS total_amount FROM sales WHERE store_id = '$store_id' AND DATE_FORMAT(Date, '%Y-%m') = '$currentYearMonth'";

// Execute the SQL query
$select_query = mysqli_query($con, $select_sql);

// Check if there are results
if ($row = mysqli_fetch_array($select_query)) {
    // Display the total profit
    echo '' . number_format($row['total_amount']);
} else {
    // If there are no sales recorded for the current month, display a message
    echo 'No sales recorded for the current month.';
}
?>
                </h3>

                <p>Quantity sold this week</p>
              </div>
              <a href="sales_this_week.php?invoice_number=<?php echo $_GET['invoice_number']?>" class="small-box-footer">Tazama mauzo <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3> 

                <?php
include("dbcon.php");

// Get the current week's starting and ending dates
$currentWeekStart = date('Y-m-d', strtotime('monday this week'));
$currentWeekEnd = date('Y-m-d', strtotime('sunday this week'));

// Construct the SQL query to calculate the total profit for the current week
$select_sql = "SELECT SUM(expenditure_amount) AS expenditure_amount FROM expenditure WHERE store_id = '$store_id' AND  created_at  BETWEEN '$currentWeekStart' AND '$currentWeekEnd'";

// Execute the SQL query
$select_query = mysqli_query($con, $select_sql);

// Check if there are results
if ($row = mysqli_fetch_array($select_query)) {
    // Display the total profit
    echo 'Tsh ' . number_format($row['expenditure_amount']);
} else {
    // If there are no sales recorded for the current week, display a message
    echo 'No sales recorded for the current week.';
}
?>

                    </h3>

                <p>Expenditure this week</p>
              </div>
              <a href="this_week_expenditure.php?invoice_number=<?php echo $_GET['invoice_number']?>" class="small-box-footer">Tazama matumizi<i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->
        <!-- Main row -->
        <div class="row">
          <!-- Left col -->
          
          <!-- /.Left col -->
         
        </div>
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>









    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>  
                    
                 
             
                <?php
include("dbcon.php");

// Get the current year and month in the format YYYY-MM
$currentYearMonth = date("Y-m");

// Construct the SQL query to calculate the total profit for the current month
$select_sql = "SELECT SUM(total_amount) AS total_amount FROM sales WHERE store_id = '$store_id' AND  DATE_FORMAT(Date, '%Y-%m') = '$currentYearMonth'";

// Execute the SQL query
$select_query = mysqli_query($con, $select_sql);

// Check if there are results
if ($row = mysqli_fetch_array($select_query)) {
    // Display the total profit
    echo 'Tsh ' . number_format($row['total_amount']);
} else {
    // If there are no sales recorded for the current month, display a message
    echo 'No sales recorded for the current month.';
}
?>
                </h3> 
                


                <p>Mauzo mwezi huu</p>
              </div>
              <a href="sales_this_month.php?invoice_number=<?php echo $_GET['invoice_number']?>" class="small-box-footer">Tazama mauzo <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3> 
              
                <?php
include("dbcon.php");
// Get the current year and month in the format YYYY-MM
$currentYearMonth = date("Y-m");

// Construct the SQL query to calculate the total profit for the current month
$select_sql = "SELECT SUM(total_profit) AS total_profit FROM sales WHERE store_id = '$store_id' AND DATE_FORMAT(Date, '%Y-%m') = '$currentYearMonth'";

// Execute the SQL query
$select_query = mysqli_query($con, $select_sql);

// Check if there are results
if ($row = mysqli_fetch_array($select_query)) {
    // Display the total profit
    echo 'Tsh ' . number_format($row['total_profit']);
} else {
    // If there are no sales recorded for the current week, display a message
    echo 'No sales recorded for the current week.';
}
?>      
              </h3>   
                 
                <p>Profit this month</p>
              </div>
              <a href="sales_this_month.php?invoice_number=<?php echo $_GET['invoice_number']?>" class="small-box-footer">Tazama faida <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3> 
                    
                <?php
include("dbcon.php");

// Get the current year and month in the format YYYY-MM
$currentYearMonth = date("Y-m");

// Construct the SQL query to calculate the total profit for the current month
$select_sql = "SELECT COUNT(total_amount) AS total_amount FROM sales WHERE store_id = '$store_id' AND DATE_FORMAT(Date, '%Y-%m') = '$currentYearMonth'";

// Execute the SQL query
$select_query = mysqli_query($con, $select_sql);

// Check if there are results
if ($row = mysqli_fetch_array($select_query)) {
    // Display the total profit
    echo '' . number_format($row['total_amount']);
} else {
    // If there are no sales recorded for the current month, display a message
    echo 'No sales recorded for the current month.';
}
?>
                </h3>

                <p>Quantity sold this month</p>
              </div>
              <a href="sales_this_week.php?invoice_number=<?php echo $_GET['invoice_number']?>" class="small-box-footer">Tazama mauzo <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3> 

               
                <?php
include("dbcon.php");

// Get the current year and month
$currentYear = date("Y");
$currentMonth = date("m");

// Construct the SQL query to calculate the total expenditure for the current month
$select_sql = "SELECT SUM(expenditure_amount) AS expenditure_amount FROM expenditure WHERE store_id = '$store_id' AND YEAR(created_at) = '$currentYear' AND MONTH(created_at) = '$currentMonth'";

// Execute the SQL query
$select_query = mysqli_query($con, $select_sql);

// Check if there are results
if ($row = mysqli_fetch_assoc($select_query)) {
    // Display the total expenditure for the current month
    echo 'Tsh ' . number_format($row['expenditure_amount']);
} else {
    // If there are no expenditures recorded for the current month, display a message
    echo 'No expenditure recorded for the current month.';
}
?>

                    </h3>

                <p>Expenditures this months</p>
              </div>
              <a href="this_month_expenditure.php?invoice_number=<?php echo $_GET['invoice_number']?>" class="small-box-footer">Tazama matumizi<i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->
        <!-- Main row -->
        <div class="row">
          <!-- Left col -->
          
          <!-- /.Left col -->
         
        </div>
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>






    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>  
                    
                 
             
                <?php
include("dbcon.php");

// Get the current year
$currentYear = date("Y");

// Construct the SQL query to calculate the total profit for sales from January to March
$select_sql = "SELECT SUM(total_amount) AS total_amount FROM sales 
               WHERE Date >= '$currentYear-01-01' AND Date <= '$currentYear-03-31'";

// Execute the SQL query
$select_query = mysqli_query($con, $select_sql);

// Check if there are results
if ($row = mysqli_fetch_array($select_query)) {
    // Display the total profit
    echo 'Tsh ' . number_format($row['total_amount']);
} else {
    // If there are no sales recorded for the specified period, display a message
    echo 'Hakuna mauzo yaliyofanyika  mwezi wa kwanza mbaka wa tatu';
}
?>

                </h3>
                


                <p>Sales 1-3</p>
              </div>
              <a href="sales_1-3.php?invoice_number=<?php echo $_GET['invoice_number']?>" class="small-box-footer">Tazama mauzo <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3> 
              
                     <?php
include("dbcon.php");

// Get the current year
$currentYear = date("Y");

// Construct the SQL query to calculate the total profit for sales from January to March
$select_sql = "SELECT SUM(total_profit) AS total_profit FROM sales
               WHERE Date >= '$currentYear-01-01' AND Date <= '$currentYear-03-31'";

// Execute the SQL query
$select_query = mysqli_query($con, $select_sql);

// Check if there are results
if ($row = mysqli_fetch_array($select_query)) {
    // Display the total profit
    echo 'Tsh ' . number_format($row['total_profit']);
} else {
    // If there are no sales recorded for the specified period, display a message
    echo 'Hakuna mauzo yaliyofanyika  mwezi wa kwanza mbaka wa tatu';
}
?>      </h3>   
                 
                <p>Sales 1-3</p>
              </div>
              <a href="sales_1-3.php?invoice_number=<?php echo $_GET['invoice_number']?>" class="small-box-footer">Tazama faida <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3> 
                    
                 
                <?php
include("dbcon.php");

// Get the current year
$currentYear = date("Y");

// Construct the SQL query to calculate the total profit for sales from January to March
$select_sql = "SELECT COUNT(total_profit) AS total_profit FROM sales
               WHERE Date >= '$currentYear-01-01' AND Date <= '$currentYear-03-31'";

// Execute the SQL query
$select_query = mysqli_query($con, $select_sql);

// Check if there are results
if ($row = mysqli_fetch_array($select_query)) {
    // Display the total profit
    echo ' ' . number_format($row['total_profit']);
} else {
    // If there are no sales recorded for the specified period, display a message
    echo 'Hakuna mauzo yaliyofanyika  mwezi wa kwanza mbaka wa tatu';
}
?>              </h3>

                <p>Quantity sold 1-3</p>
              </div>
              <a href="sales_1-3.php?invoice_number=<?php echo $_GET['invoice_number']?>" class="small-box-footer">Tazama mauzo <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3> 

                <?php
include("dbcon.php");

// Get the current year
$currentYear = date("Y");

// Construct the SQL query to calculate the total expenditure for January to March
$select_sql = "SELECT SUM(expenditure_amount) AS expenditure_amount FROM expenditure 
               WHERE created_at >= '$currentYear-01-01' AND created_at <= '$currentYear-03-31'";

// Execute the SQL query
$select_query = mysqli_query($con, $select_sql);

// Check if there are results
if ($row = mysqli_fetch_array($select_query)) {
    // Display the total expenditure
    echo 'Tsh ' . number_format($row['expenditure_amount']);
} else {
    // If there are no expenditures recorded for the specified period, display a message
    echo 'No expenditure recorded from January to March.';
}
?>

                    </h3>

                <p>Expenditures 1-3</p>
              </div>
              <a href="expenditure_1-3.phpWall putty" class="small-box-footer">Tazama matumizi<i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->
        <!-- Main row -->
        <div class="row">
          <!-- Left col -->
          
          <!-- /.Left col -->
         
        </div>
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>









    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>  
                    
                 
                <?php
include("dbcon.php");

// Get the current year
$currentYear = date("Y");

// Construct the SQL query to calculate the total profit for sales from April to June
$select_sql = "SELECT SUM(total_amount) AS total_amount FROM sales 
               WHERE Date >= '$currentYear-04-01' AND Date <= '$currentYear-06-30'";

// Execute the SQL query
$select_query = mysqli_query($con, $select_sql);

// Check if there are results
if ($row = mysqli_fetch_array($select_query)) {
    // Display the total profit
    echo 'Tsh ' . number_format($row['total_amount']);
} else {
    // If there are no sales recorded for the specified period, display a message
    echo 'No sales recorded from April to June.';
}
?>
            </h3> 
                


                <p>Sales 4-6</p>
              </div>
              <a href="sales_4-6.php?invoice_number=<?php echo $_GET['invoice_number']?>" class="small-box-footer">Tazama mauzo <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3> 
                <?php
include("dbcon.php");

// Get the current year
$currentYear = date("Y");

// Construct the SQL query to calculate the total profit for sales from April to June
$select_sql = "SELECT SUM(total_profit) AS total_profit FROM sales 
               WHERE Date >= '$currentYear-04-01' AND Date <= '$currentYear-06-30'";

// Execute the SQL query
$select_query = mysqli_query($con, $select_sql);

// Check if there are results
if ($row = mysqli_fetch_array($select_query)) {
    // Display the total profit
    echo 'Tsh ' . number_format($row['total_profit']);
} else {
    // If there are no sales recorded for the specified period, display a message
    echo 'No sales recorded from April to June.';
}
?>

              </h3>   
                 
                <p>Profit 4-6</p>
              </div>
              <a href="sales_4-6.php?invoice_number=<?php echo $_GET['invoice_number']?>" class="small-box-footer">Tazama faida <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3> 
                    
                <?php
include("dbcon.php");

// Get the current year
$currentYear = date("Y");

// Construct the SQL query to calculate the total profit for sales from April to June
$select_sql = "SELECT COUNT(total_profit) AS total_profit FROM sales 
               WHERE Date >= '$currentYear-04-01' AND Date <= '$currentYear-06-30'";

// Execute the SQL query
$select_query = mysqli_query($con, $select_sql);

// Check if there are results
if ($row = mysqli_fetch_array($select_query)) {
    // Display the total profit
    echo ' ' . number_format($row['total_profit']);
} else {
    // If there are no sales recorded for the specified period, display a message
    echo 'No sales recorded from April to June.';
}
?>

                </h3>

                <p>Quantity sold 4-6</p>
              </div>
              <a href="sales_4-6.php?invoice_number=<?php echo $_GET['invoice_number']?>" class="small-box-footer">Tazama mauzo <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3> 

               
                <?php
include("dbcon.php");

// Get the current year
$currentYear = date("Y");

// Construct the SQL query to calculate the total expenditure for April to June
$select_sql = "SELECT SUM(expenditure_amount) AS expenditure_amount FROM expenditure 
               WHERE created_at >= '$currentYear-04-01' AND created_at <= '$currentYear-06-30'";

// Execute the SQL query
$select_query = mysqli_query($con, $select_sql);

// Check if there are results
if ($row = mysqli_fetch_array($select_query)) {
    // Display the total expenditure
    echo 'Tsh ' . number_format($row['expenditure_amount']);
} else {
    // If there are no expenditures recorded for the specified period, display a message
    echo 'No expenditures recorded from April to June.';
}
?>

                    </h3>

                <p>Expenditures 4-6</p>
              </div>
              <a href="expenditure_4-6.php?invoice_number=<?php echo $_GET['invoice_number']?>" class="small-box-footer">Tazama matumizi<i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->
        <!-- Main row -->
        <div class="row">
          <!-- Left col -->
          
          <!-- /.Left col -->
         
        </div>
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>




    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>  
                    
                 
                <?php
include("dbcon.php");

// Get the current year
$currentYear = date("Y");

// Construct the SQL query to calculate the total sales for the period from July to September
$select_sql = "SELECT SUM(total_amount) AS total_sales FROM sales 
               WHERE Date >= '$currentYear-07-01' AND Date <= '$currentYear-09-30'";

// Execute the SQL query
$select_query = mysqli_query($con, $select_sql);

// Check if there are results
if ($row = mysqli_fetch_array($select_query)) {
    // Display the total sales
    echo 'Tsh ' . number_format($row['total_sales']);
} else {
    // If there are no sales recorded for the specified period, display a message
    echo 'No sales recorded from July to September.';
}
?>
          </h3>
                


                <p>Sales 7-9</p>
              </div>
              <a href="sales_7-9.php?invoice_number=<?php echo $_GET['invoice_number']?>" class="small-box-footer">Tazama mauzo <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3> 
              
                 <?php
include("dbcon.php");

// Get the current year
$currentYear = date("Y");

// Construct the SQL query to calculate the total s the period from July to September
$select_sql = "SELECT SUM(total_profit) AS total_profit FROM sales 
               WHERE Date >= '$currentYear-07-01' AND Date <= '$currentYear-09-30'";

// Execute the SQL query
$select_query = mysqli_query($con, $select_sql);

// Check if there are results
if ($row = mysqli_fetch_array($select_query)) {
    // Display the total sales
    echo 'Tsh ' . number_format($row['total_profit']);
} else {
    // If there are no sales recorded for the specified period, display a message
    echo 'No sales recorded from July to September.';
}
?>
         
              </h3>   
                 
                <p>Profit 7-9</p>
              </div>
              <a href="sales_7-9.php?invoice_number=<?php echo $_GET['invoice_number']?>" class="small-box-footer">Tazama faida <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3> 
                    
                 
                <?php
include("dbcon.php");

// Get the current year
$currentYear = date("Y");

// Construct the SQL query to calculate the total s the period from July to September
$select_sql = "SELECT COUNT(total_profit) AS total_profit FROM sales 
               WHERE Date >= '$currentYear-07-01' AND Date <= '$currentYear-09-30'";

// Execute the SQL query
$select_query = mysqli_query($con, $select_sql);

// Check if there are results
if ($row = mysqli_fetch_array($select_query)) {
    // Display the total sales
    echo 'Tsh ' . number_format($row['total_profit']);
} else {
    // If there are no sales recorded for the specified period, display a message
    echo 'No sales recorded from July to September.';
}
?>
    
                </h3>

                <p>quantity sold 7-9</p>
              </div>
              <a href="sales_7-9.php?invoice_number=<?php echo $_GET['invoice_number']?>" class="small-box-footer">Tazama mauzo <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3> 
                <?php
include("dbcon.php");

// Get the current year
$currentYear = date("Y");

// Construct the SQL query to calculate the total expenditure for the period from July to September
$select_sql = "SELECT SUM(expenditure_amount) AS expenditure_amount FROM expenditure 
               WHERE created_at >= '$currentYear-07-01' AND created_at <= '$currentYear-09-30'";

// Execute the SQL query
$select_query = mysqli_query($con, $select_sql);

// Check if there are results
if ($row = mysqli_fetch_array($select_query)) {
    // Display the total expenditure
    echo 'Tsh ' . number_format($row['expenditure_amount']);
} else {
    // If there are no expenditure recorded for the specified period, display a message
    echo 'No expenditure recorded from July to September.';
}
?>


                    </h3>

                <p>Expenditures 7-9</p>
              </div>
              <a href="expenditure_7-9.php?invoice_number=<?php echo $_GET['invoice_number']?>" class="small-box-footer">Tazama matumizi<i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->
        <!-- Main row -->
        <div class="row">
          <!-- Left col -->
          
          <!-- /.Left col -->
         
        </div>
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>









    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>  
                    
                 
             
                
                <?php
include("dbcon.php");

// Get the current year
$currentYear = date("Y");

// Construct the SQL query to calculate the total sales for the period from July to September
$select_sql = "SELECT SUM(total_amount) AS total_sales FROM sales 
               WHERE Date >= '$currentYear-10-01' AND Date <= '$currentYear-12-31'";

// Execute the SQL query
$select_query = mysqli_query($con, $select_sql);

// Check if there are results
if ($row = mysqli_fetch_array($select_query)) {
    // Display the total sales
    echo 'Tsh ' . number_format($row['total_sales']);
} else {
    // If there are no sales recorded for the specified period, display a message
    echo 'No sales recorded from July to September.';
}
?>
                </h3> 
                


                <p>Sales  10-12</p>
              </div>
              <a href="sales_this_month.php?invoice_number=<?php echo $_GET['invoice_number']?>" class="small-box-footer">Tazama mauzo <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3> 
              
                <?php
include("dbcon.php");

// Get the current year
$currentYear = date("Y");

// Construct the SQL query to calculate the total sales for the period from July to September
$select_sql = "SELECT SUM(total_profit) AS total_profit FROM sales
               WHERE Date >= '$currentYear-10-01' AND Date <= '$currentYear-12-31'";

// Execute the SQL query
$select_query = mysqli_query($con, $select_sql);

// Check if there are results
if ($row = mysqli_fetch_array($select_query)) {
    // Display the total sales
    echo 'Tsh ' . number_format($row['total_profit']);
} else {
    // If there are no sales recorded for the specified period, display a message
    echo 'No sales recorded from July to September.';
}
?>
        
              </h3>   
                 
                <p>Profit 10-12</p>
              </div>
              <a href="sales_10-12.php?invoice_number=<?php echo $_GET['invoice_number']?>" class="small-box-footer">Tazama faida <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3> 
                    
                <?php
include("dbcon.php");

// Get the current year
$currentYear = date("Y");

// Construct the SQL query to calculate the total sales for the period from July to September
$select_sql = "SELECT COUNT(total_profit) AS total_profit FROM sales
               WHERE Date >= '$currentYear-10-01' AND Date <= '$currentYear-12-31'";

// Execute the SQL query
$select_query = mysqli_query($con, $select_sql);

// Check if there are results
if ($row = mysqli_fetch_array($select_query)) {
    // Display the total sales
    echo 'Tsh ' . number_format($row['total_profit']);
} else {
    // If there are no sales recorded for the specified period, display a message
    echo 'No sales recorded from July to September.';
}
?>
                </h3>

                <p>quantity sold 10-12</p>
              </div>
              <a href="sales_10-12.php?invoice_number=<?php echo $_GET['invoice_number']?>" class="small-box-footer">Tazama mauzo <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3> 

               
                    
                <?php
include("dbcon.php");

// Get the current year
$currentYear = date("Y");

// Construct the SQL query to calculate the total expenditure for the period from July to September
$select_sql = "SELECT SUM(expenditure_amount) AS expenditure_amount FROM expenditure 
               WHERE created_at >= '$currentYear-10-01' AND created_at <= '$currentYear-12-31'";

// Execute the SQL query
$select_query = mysqli_query($con, $select_sql);

// Check if there are results
if ($row = mysqli_fetch_array($select_query)) {
    // Display the total expenditure
    echo 'Tsh ' . number_format($row['expenditure_amount']);
} else {
    // If there are no expenditure recorded for the specified period, display a message
    echo 'No expenditure recorded from July to September.';
}
?>
                    </h3>

                <p>Expenditures 10-12</p>
              </div>
              <a href="expenditure_10-12.php?invoice_number=<?php echo $_GET['invoice_number']?>" class="small-box-footer">Tazama matumizi<i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->
        <!-- Main row -->
        <div class="row">
          <!-- Left col -->
          
          <!-- /.Left col -->
         
        </div>
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>





    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>  
                    
                 
             
                
                <?php
include("dbcon.php");

// Get the current year
$currentYear = date("Y");

// Construct the SQL query to calculate the total sales for the period from July to September
$select_sql = "SELECT SUM(total_amount) AS total_sales FROM sales 
               WHERE Date >= '$currentYear-01-01' AND Date <= '$currentYear-06-31'";

// Execute the SQL query
$select_query = mysqli_query($con, $select_sql);

// Check if there are results
if ($row = mysqli_fetch_array($select_query)) {
    // Display the total sales
    echo 'Tsh ' . number_format($row['total_sales']);
} else {
    // If there are no sales recorded for the specified period, display a message
    echo 'No sales recorded from July to September.';
}
?>
                </h3> 
                


                <p>Sales  1-6</p>
              </div>
              <a href="sales_1-6.php?invoice_number=<?php echo $_GET['invoice_number']?>" class="small-box-footer">Tazama mauzo <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3> 
              
                <?php
include("dbcon.php");

// Get the current year
$currentYear = date("Y");

// Construct the SQL query to calculate the total sales for the period from July to September
$select_sql = "SELECT SUM(total_profit) AS total_profit FROM sales
               WHERE Date >= '$currentYear-01-01' AND Date <= '$currentYear-06-30'";

// Execute the SQL query
$select_query = mysqli_query($con, $select_sql);

// Check if there are results
if ($row = mysqli_fetch_array($select_query)) {
    // Display the total sales
    echo 'Tsh ' . number_format($row['total_profit']);
} else {
    // If there are no sales recorded for the specified period, display a message
    echo 'No sales recorded from July to September.';
}
?>
        
              </h3>   
                 
                <p>Profit 1-6</p>
              </div>
              <a href="sales_1-6.php?invoice_number=<?php echo $_GET['invoice_number']?>" class="small-box-footer">Tazama faida <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3> 
                    
                <?php
include("dbcon.php");

// Get the current year
$currentYear = date("Y");

// Construct the SQL query to calculate the total sales for the period from July to September
$select_sql = "SELECT COUNT(total_profit) AS total_profit FROM sales
               WHERE Date >= '$currentYear-01-01' AND Date <= '$currentYear-06-31'";

// Execute the SQL query
$select_query = mysqli_query($con, $select_sql);

// Check if there are results
if ($row = mysqli_fetch_array($select_query)) {
    // Display the total sales
    echo 'Tsh ' . number_format($row['total_profit']);
} else {
    // If there are no sales recorded for the specified period, display a message
    echo 'No sales recorded from July to September.';
}
?>
                </h3>

                <p>quantity sold 1-6</p>
              </div>
              <a href="sales_1-6.php?invoice_number=<?php echo $_GET['invoice_number']?>" class="small-box-footer">Tazama mauzo <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3> 

               
                    
                <?php
include("dbcon.php");

// Get the current year
$currentYear = date("Y");

// Construct the SQL query to calculate the total expenditure for the period from July to September
$select_sql = "SELECT SUM(expenditure_amount) AS expenditure_amount FROM expenditure 
               WHERE created_at >= '$currentYear-01-01' AND created_at <= '$currentYear-06-31'";

// Execute the SQL query
$select_query = mysqli_query($con, $select_sql);

// Check if there are results
if ($row = mysqli_fetch_array($select_query)) {
    // Display the total expenditure
    echo 'Tsh ' . number_format($row['expenditure_amount']);
} else {
    // If there are no expenditure recorded for the specified period, display a message
    echo 'No expenditure recorded from July to September.';
}
?>
                    </h3>

                <p>Expenditures 1-6</p>
              </div>
              <a href="expenditure_1-6.php?invoice_number=<?php echo $_GET['invoice_number']?>" class="small-box-footer">Tazama matumizi<i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->
        <!-- Main row -->
        <div class="row">
          <!-- Left col -->
          
          <!-- /.Left col -->
         
        </div>
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>





    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>  
                    
                 
             
                
                <?php
include("dbcon.php");

// Get the current year
$currentYear = date("Y");

// Construct the SQL query to calculate the total sales for the period from July to September
$select_sql = "SELECT SUM(total_amount) AS total_sales FROM sales 
               WHERE Date >= '$currentYear-07-01' AND Date <= '$currentYear-12-31'";

// Execute the SQL query
$select_query = mysqli_query($con, $select_sql);

// Check if there are results
if ($row = mysqli_fetch_array($select_query)) {
    // Display the total sales
    echo 'Tsh ' . number_format($row['total_sales']);
} else {
    // If there are no sales recorded for the specified period, display a message
    echo 'No sales recorded from July to September.';
}
?>
                </h3> 
                


                <p>Sales  7-12</p>
              </div>
              <a href="sales_10-12.php?invoice_number=<?php echo $_GET['invoice_number']?>" class="small-box-footer">Tazama mauzo <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3> 
              
                <?php
include("dbcon.php");

// Get the current year
$currentYear = date("Y");

// Construct the SQL query to calculate the total sales for the period from July to September
$select_sql = "SELECT SUM(total_profit) AS total_profit FROM sales
               WHERE Date >= '$currentYear-07-01' AND Date <= '$currentYear-12-31'";

// Execute the SQL query
$select_query = mysqli_query($con, $select_sql);

// Check if there are results
if ($row = mysqli_fetch_array($select_query)) {
    // Display the total sales
    echo 'Tsh ' . number_format($row['total_profit']);
} else {
    // If there are no sales recorded for the specified period, display a message
    echo 'No sales recorded from July to September.';
}
?>
        
              </h3>   
                 
                <p>Profit 7-12</p>
              </div>
              <a href="sales_10-12.php?invoice_number=<?php echo $_GET['invoice_number']?>" class="small-box-footer">Tazama faida <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3> 
                    
                <?php
include("dbcon.php");

// Get the current year
$currentYear = date("Y");

// Construct the SQL query to calculate the total sales for the period from July to September
$select_sql = "SELECT COUNT(total_profit) AS total_profit FROM sales
               WHERE Date >= '$currentYear-07-01' AND Date <= '$currentYear-12-31'";

// Execute the SQL query
$select_query = mysqli_query($con, $select_sql);

// Check if there are results
if ($row = mysqli_fetch_array($select_query)) {
    // Display the total sales
    echo '' . number_format($row['total_profit']);
} else {
    // If there are no sales recorded for the specified period, display a message
    echo 'No sales recorded from July to September.';
}
?>
                </h3>

                <p>quantity sold 7-12</p>
              </div>
              <a href="sales_07-12.php?invoice_number=<?php echo $_GET['invoice_number']?>" class="small-box-footer">Tazama mauzo <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3> 

               
                    
                <?php
include("dbcon.php");

// Get the current year
$currentYear = date("Y");

// Construct the SQL query to calculate the total expenditure for the period from July to September
$select_sql = "SELECT SUM(expenditure_amount) AS expenditure_amount FROM expenditure 
               WHERE created_at >= '$currentYear-07-01' AND created_at <= '$currentYear-12-31'";

// Execute the SQL query
$select_query = mysqli_query($con, $select_sql);

// Check if there are results
if ($row = mysqli_fetch_array($select_query)) {
    // Display the total expenditure
    echo 'Tsh ' . number_format($row['expenditure_amount']);
} else {
    // If there are no expenditure recorded for the specified period, display a message
    echo 'No expenditure recorded from July to September.';
}
?>
                    </h3>

                <p>Expenditures 7-12</p>
              </div>
              <a href="expenditure_7-12.php?invoice_number=<?php echo $_GET['invoice_number']?>" class="small-box-footer">Tazama matumizi<i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->
        <!-- Main row -->
        <div class="row">
          <!-- Left col -->
          
          <!-- /.Left col -->
         
        </div>
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>



    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>  
                    
                 
             
                
                <?php
include("dbcon.php");

// Get the current year
$currentYear = date("Y");

// Construct the SQL query to calculate the total sales for the period from July to September
$select_sql = "SELECT SUM(total_amount) AS total_sales FROM sales 
               WHERE Date >= '$currentYear-01-01' AND Date <= '$currentYear-12-30'";

// Execute the SQL query
$select_query = mysqli_query($con, $select_sql);

// Check if there are results
if ($row = mysqli_fetch_array($select_query)) {
    // Display the total sales
    echo 'Tsh ' . number_format($row['total_sales']);
} else {
    // If there are no sales recorded for the specified period, display a message
    echo 'No sales recorded from July to September.';
}
?>
                </h3> 
                


                <p>Sales 1-12</p>
              </div>
              <a href="sales_1-12.php?invoice_number=<?php echo $_GET['invoice_number']?>" class="small-box-footer">Tazama mauzo <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3> 
              
                <?php
include("dbcon.php");

// Get the current year
$currentYear = date("Y");

// Construct the SQL query to calculate the total sales for the period from July to September
$select_sql = "SELECT SUM(total_profit) AS total_profit FROM sales
               WHERE Date >= '$currentYear-01-01' AND Date <= '$currentYear-12-31'";

// Execute the SQL query
$select_query = mysqli_query($con, $select_sql);

// Check if there are results
if ($row = mysqli_fetch_array($select_query)) {
    // Display the total sales
    echo 'Tsh ' . number_format($row['total_profit']);
} else {
    // If there are no sales recorded for the specified period, display a message
    echo 'No sales recorded from July to September.';
}
?>
        
              </h3>   
                 
                <p>Profit 1-12</p>
              </div>
              <a href="sales_1-12.php?invoice_number=<?php echo $_GET['invoice_number']?>" class="small-box-footer">Tazama faida <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3> 
                    
                <?php
include("dbcon.php");

// Get the current year
$currentYear = date("Y");

// Construct the SQL query to calculate the total sales for the period from July to September
$select_sql = "SELECT COUNT(total_profit) AS total_profit FROM sales
               WHERE Date >= '$currentYear-01-01' AND Date <= '$currentYear-12-31'";

// Execute the SQL query
$select_query = mysqli_query($con, $select_sql);

// Check if there are results
if ($row = mysqli_fetch_array($select_query)) {
    // Display the total sales
    echo 'Tsh ' . number_format($row['total_profit']);
} else {
    // If there are no sales recorded for the specified period, display a message
    echo 'No sales recorded from July to September.';
}
?>
                </h3>

                <p>quantity sold 1-12</p>
              </div>
              <a href="sales_1-12.php?invoice_number=<?php echo $_GET['invoice_number']?>" class="small-box-footer">Tazama mauzo <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3> 

               
                    
                <?php
include("dbcon.php");

// Get the current year
$currentYear = date("Y");

// Construct the SQL query to calculate the total expenditure for the period from July to September
$select_sql = "SELECT SUM(expenditure_amount) AS expenditure_amount FROM expenditure 
               WHERE created_at >= '$currentYear-01-01' AND created_at <= '$currentYear-12-31'";

// Execute the SQL query
$select_query = mysqli_query($con, $select_sql);

// Check if there are results
if ($row = mysqli_fetch_array($select_query)) {
    // Display the total expenditure
    echo 'Tsh ' . number_format($row['expenditure_amount']);
} else {
    // If there are no expenditure recorded for the specified period, display a message
    echo 'No expenditure recorded from July to September.';
}
?>
                    </h3>

                <p>Expenditures 1-12</p>
              </div>
              <a href="expenditure_1-12.php?invoice_number=<?php echo $_GET['invoice_number']?>" class="small-box-footer">Tazama matumizi<i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->
        <!-- Main row -->
        <div class="row">
          <!-- Left col -->
          
          <!-- /.Left col -->
         
        </div>
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>







    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>  
                    
                 
             
                
                <?php
include("dbcon.php");


// Construct the SQL query to calculate the total sales for the period from July to September
$select_sql = "SELECT SUM(total_amount) AS total_sales FROM sales";

// Execute the SQL query
$select_query = mysqli_query($con, $select_sql);

// Check if there are results
if ($row = mysqli_fetch_array($select_query)) {
    // Display the total sales
    echo 'Tsh ' .number_format( $row['total_sales']);
} else {
    // If there are no sales recorded for the specified period, display a message
    echo 'No sales recorded from July to September.';
}
?>
                </h3> 
                


                <p>All sales</p>
              </div>
              <a href="all_sales.php?invoice_number=<?php echo $_GET['invoice_number']?>" class="small-box-footer">Tazama mauzo <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3> 
              
                <?php
include("dbcon.php");


// Construct the SQL query to calculate the total sales for the period from July to September
$select_sql = "SELECT SUM(total_profit) AS total_profit FROM sales";

// Execute the SQL query
$select_query = mysqli_query($con, $select_sql);

// Check if there are results
if ($row = mysqli_fetch_array($select_query)) {
    // Display the total sales
    echo 'Tsh ' . number_format($row['total_profit']);
} else {
    // If there are no sales recorded for the specified period, display a message
    echo 'No sales recorded from July to September.';
}
?>
        
              </h3>   
                 
                <p>All profits</p>
              </div>
              <a href="all_sales.php?invoice_number=<?php echo $_GET['invoice_number']?>" class="small-box-footer">Tazama faida <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3> 
                    
                <?php
include("dbcon.php");


// Construct the SQL query to calculate the total all sales 
$select_sql = "SELECT COUNT(total_profit) AS total_profit FROM sales";

// Execute the SQL query
$select_query = mysqli_query($con, $select_sql);

// Check if there are results
if ($row = mysqli_fetch_array($select_query)) {
    // Display the total sales
    echo 'Tsh ' . number_format($row['total_profit']);
} else {
    // If there are no sales recorded for the specified period, display a message
    echo 'No sales recorded from July to September.';
}
?>
                </h3>

                <p>All quantity sold</p>
              </div>
              <a href="all_sales.php?invoice_number=<?php echo $_GET['invoice_number']?>" class="small-box-footer">Tazama mauzo <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3> 

               
                <?php
include("dbcon.php");

// Construct the SQL query to calculate the total expenditure for all periods
$select_sql = "SELECT SUM(expenditure_amount) AS expenditure_amount FROM expenditure";

// Execute the SQL query
$select_query = mysqli_query($con, $select_sql);

// Check if there are results
if ($row = mysqli_fetch_array($select_query)) {
    // Display the total expenditure
    echo 'Tsh ' . number_format($row['expenditure_amount']);
} else {
    // If there are no expenditures recorded, display a message
    echo 'No expenditure recorded.';
}
?>

                    </h3>

                <p>All expenditures</p>
              </div>
              <a href="expenditure_10-12.php?invoice_number=<?php echo $_GET['invoice_number']?>" class="small-box-footer">Tazama matumizi<i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->
        <!-- Main row -->
        <div class="row">
          <!-- Left col -->
          
          <!-- /.Left col -->
         
        </div>
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>






      </div>
              <!-- /.card-body -->
            </div>
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <?php include("footer.php"); ?>


  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->
<!-- jQuery -->
<script src="./plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="./plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables -->
<script src="./plugins/datatables/jquery.dataTables.min.js"></script>
<script src="./plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="./plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="./plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<!-- AdminLTE App -->
<script src="./dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="./dist/js/demo.js"></script>


<!-- loading circular progrss javascript on footer before clossing body -->
<script>
  $(window).on('load', function() {
    $('#spinner').hide();
    $('#content').show();
  });

  $(document).ready(function() {
  // Toggle sidebar on small screens
  $('[data-widget="pushmenu"]').click(function() {
    $('body').toggleClass('sidebar-open');
  });
  
  // Fix sidebar height on load
  function fixSidebarHeight() {
    $('.sidebar').css('height', $(window).height() - $('.brand-link').outerHeight());
  }
  
  $(window).resize(fixSidebarHeight);
  fixSidebarHeight();
});

</script>

</body>
</html>