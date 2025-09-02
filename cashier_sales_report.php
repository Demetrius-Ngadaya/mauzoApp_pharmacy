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
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  
  <style>
    .form-group {
      margin-bottom: 1rem;
    }
    .form-control {
      width: 100%;
      padding: .375rem .75rem;
      border-radius: .25rem;
    }
    .form-container {
      margin: 20px;
    }
    .form-inline {
      display: flex;
      flex-wrap: wrap;
      justify-content: space-between;
    }
    .form-inline .form-group {
      flex: 1 1 45%;
      margin: 5px;
    }
    .form-inline .form-group input {
      width: 100%;
    }
    .btn {
      margin-top: 25px;
    }
  </style>
  <script src="js/jquery-1.7.2.min.js"></script>
  <script src="js/jquery_ui.js"></script>
  <script type="text/javascript" src="js/bootstrap.js"></script>
  <script type="text/javascript" src="src/facebox.js"></script>

  <script type="text/javascript">
    jQuery(document).ready(function($) {
      $("a[id*=popup]").facebox({
        loadingImage : 'src/img/loading.gif',
        closeImage   : 'src/img/closelabel.png'
      })
    }) 
  </script>
  <script type="text/javascript" src="js/tcal.js"></script>
  <script type="text/javascript">
    function Clickheretoprint() { 
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
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Navbar -->
  
  <!-- /.navbar -->



  <?php include('cashierNavBar.php') ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid"> 
        <div class="row mb-2">
          <div class="col-sm-6">							
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Cashier</a></li>
              <li class="breadcrumb-item active">Sales report</li>
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
              <div class="card-header">
                <h3 class="card-title"><b>Sales report</b></h3>
              </div>
              <!-- /.card-header -->
              <section class="content">
              <div class="card-header">
                <h3 class="card-title"><b>Sales report</b></h3>
              </div>
                <div class="container-fluid">
                  <div class="row">
                    <div class="col-12">
                      <div class="card">
                        <div class="card-header">
                          <center>
                          <form action="cashier_sales_report.php?invoice_number=<?php echo $_GET['invoice_number']?>" method="POST" class="form-inline">
      <div class="form-group">
        <label for="d1" class="sr-only">Date from:</label>
        <input type="date" id="d1" name="d1" class="form-control" placeholder="Kuanzia Tarehe" autocomplete="off">
      </div>
      <div class="form-group">
        <label for="d2" class="sr-only">Date to:</label>
        <input type="date" id="d2" name="d2" class="form-control" placeholder="Mbaka Tarehe" autocomplete="off">
      </div>
      <div class="form-group">
        <label for="created_by" class="sr-only">Seller name:</label>
        <input type="text" id="created_by" name="created_by" class="form-control" placeholder="Seller name" autocomplete="off">
      </div>
      <div class="form-group">
        <label for="customer_name" class="sr-only">Customer:</label>
        <input type="text" id="customer_name" name="customer_name" class="form-control" placeholder="Customer" autocomplete="off">
      </div>
      <div class="form-group">
        <label for="medicine" class="sr-only">Medicine:</label>
        <input type="text" id="medicine" name="medicine" class="form-control" placeholder="Medicine" autocomplete="off">
      </div>
      <div class="form-group">
        <label for="category" class="sr-only">Medicine category:</label>
        <input type="text" id="category" name="category" class="form-control" placeholder="Medicine category" autocomplete="off">
      </div>
      <div class="form-group">
        <label for="hali_ya_malipo" class="sr-only">Payment status:</label>
        <input type="text" id="hali_ya_malipo" name="hali_ya_malipo" class="form-control" placeholder="Payment status" autocomplete="off">
      </div>
      <div class="form-group">
        <label for="payment_method" class="sr-only">Payment method:</label>
        <input type="text" id="payment_method" name="payment_method" class="form-control" placeholder="Payment method" autocomplete="off">
      </div>
      <div class="form-group">
        <button class="btn btn-info" type="submit" name="submit"><i class="icon icon-search icon-large"></i> Search</button>
      </div>
    </form>
                          </center>
                          <div style="overflow-x:auto; overflow-y: auto;">
                            <table class="table table-bordered table-striped table-hover">
                              <thead>
                                <tr style="background-color: #383838; color: #FFFFFF;">
                                  <th>Date</th>
                                  <th>Medicine</th>
                                  <th>Quantity</th>
                                  <th>amount</th>
                                  <th>Profit</th>
                                  <th>Sold by</th>
                                  <th>Customer</th>
                                  <th>Order number</th>
                                  <th>Payment method</th>
                                  <th>Payment status</th>
                                </tr>
                              </thead>
                              <?php
                              include("dbcon.php");
                              error_reporting(1);

                              // Initialize totals
                              $total_quantity = 0;
                              $total_amount = 0;
                              $total_profit = 0;

                              if(isset($_POST['submit'])){
                                $d1 = $_POST['d1'];
                                $d2 = $_POST['d2'];
                                $created_by = $_POST['created_by'];
                                $customer_name = $_POST['customer_name'];
                                $medicine = $_POST['medicine'];
                                $category = $_POST['category'];
                                $hali_ya_malipo = $_POST['hali_ya_malipo'];
                                $payment_method = $_POST['payment_method'];
                                
                                $select_sql = "SELECT * FROM sales WHERE Date BETWEEN '$d1' AND '$d2'";
                                
                                if (!empty($created_by)) {
                                  $select_sql .= " AND created_by LIKE '%$created_by%'";
                                }
                                if (!empty($customer_name)) {
                                  $select_sql .= " AND customer_name LIKE '%$customer_name%'";
                                }
                                if (!empty($medicine)) {
                                  $select_sql .= " AND medicines LIKE '%$medicine%'";
                                }
                                if (!empty($hali_ya_malipo)) {
                                  $select_sql .= " AND hali_ya_malipo LIKE '%$hali_ya_malipo%'";
                                }
                                if (!empty($payment_method)) {
                                  $select_sql .= " AND payment_method LIKE '%$payment_method%'";
                                }
                                if (!empty($category)) {
                                  $select_sql .= " AND category LIKE '%$category%'";
                                }
                                $select_sql .= " ORDER BY Date DESC";
                                
                                $select_query = mysqli_query($con, $select_sql);
                                
                                while($row = mysqli_fetch_array($select_query)) :
                                  $total_quantity += $row['quantity'];
                                  $total_amount += $row['total_amount'];
                                  $total_profit += $row['total_profit'];
                              ?>
                              <tbody>
                                <tr>
                                  <td><?php echo $row['Date']?></td>
                                  <td><?php echo $row['medicines']?></td>
                                  <td><?php echo $row['quantity']?></td>
                                  <td><?php echo $row['total_amount']?></td>
                                  <td><?php echo $row['total_profit']?></td>
                                  <td><?php echo $row['created_by']?></td>
                                  <td><?php echo $row['customer_name']?></td> <!-- New column -->
                                  <td><?php echo $row['invoice_number']?></td>
                                  <td><?php echo $row['payment_method']?></td>
                                  <td><?php echo $row['hali_ya_malipo']?></td>
                                </tr>
                              </tbody>
                              <?php endwhile;?>
                              <tfoot>
                                <tr>
                                  <th colspan="2">Grand total:</th>
                                  <th><?php echo $total_quantity; ?></th>
                                  <th><?php echo $total_amount . ' Tsh'; ?></th>
                                  <th><?php echo $total_profit . ' Tsh'; ?></th>
                                  <th colspan="2"></th>
                                </tr>
                              </tfoot>
                              <?php } else {
                                $date = date('Y-m-d');
                                $select_sql = "SELECT * FROM sales WHERE Date = '$date'";
                                $select_query = mysqli_query($con, $select_sql);
                                
                                while($row = mysqli_fetch_array($select_query)) :
                                  $total_quantity += $row['quantity'];
                                  $total_amount += $row['total_amount'];
                                  $total_profit += $row['total_profit'];
                              ?>
                              <tbody>
                                <tr> 
                                  <td><?php echo $row['Date']?>&nbsp;&nbsp;(<font size='2' color='#009688;'>Leo</font>)</td>
                                  <td><?php echo $row['medicines']?></td>
                                  <td><?php echo $row['quantity']?></td>
                                  <td><?php echo $row['total_amount']?></td>
                                  <td><?php echo $row['total_profit']?></td>
                                  <td><?php echo $row['created_by']?></td>
                                  <td><?php echo $row['customer_name']?></td>
                                  <td><?php echo $row['invoice_number']?></td>
                                  <td><?php echo $row['payment_method']?></td>
                                  <td><?php echo $row['hali_ya_malipo']?></td>
                                </tr>
                              </tbody>
                              <?php endwhile;?>
                              <tfoot>
                                <tr>
                                  <th colspan="2">Grand total:</th>
                                  <th><?php echo $total_quantity; ?></th>
                                  <th><?php echo $total_amount . ' Tsh'; ?></th>
                                  <th><?php echo $total_profit . ' Tsh'; ?></th>
                                  <th colspan="2"></th>
                                </tr>
                              </tfoot>
                              <?php } ?>
                            </table>
                            <center>
                              <div class="export-buttons">
                                <a href="export_excel.php?d1=<?php echo $d1; ?>&d2=<?php echo $d2; ?>&created_by=<?php echo $created_by; ?>&medicine=<?php echo $medicine; ?>&category=<?php echo $category; ?>" class="btn btn-success">Export in Excel</a>
                                <a href="export_pdf.php?d1=<?php echo $d1; ?>&d2=<?php echo $d2; ?>&created_by=<?php echo $created_by; ?>&medicine=<?php echo $medicine; ?>&category=<?php echo $category; ?>" class="btn btn-danger">Export in PDF</a>
                              </div>
                            </center>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </section>
              <!-- /.content -->
            </div>
          </div>
        </div>
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
</div>
<!-- ./wrapper -->
<script src="./plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
 <script>
  
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
<script src="./dist/js/adminlte.min.js"></script>
</body>
</html>
