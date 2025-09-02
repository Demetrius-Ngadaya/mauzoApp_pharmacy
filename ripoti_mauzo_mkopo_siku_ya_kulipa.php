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

  <?php include("navbar.php"); ?>   
<?php include('indexSideBar.php') ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid"> 
        <div class="row mb-2">
          <div class="col-sm-6">	
            <b>Ripoti mauzo kwa mkopo tokana na siku ya kulipa</b>						
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="nav-item">
              <strong>Admin/Ripoti</strong>
      </li>
      <!-- <li class="nav-item">
      <a href="logout.php" class="nav-link">
                &nbsp;&nbsp;&nbsp;<i class="fa fa-power-off"></i>
                <strong>  &nbsp;&nbsp;Ondoka</strong>
                </a>
      </li> -->
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
                <center>
                <div> 
                <a href="ripoti _mauzo_ya_mkopo.php?invoice_number=<?php echo $_GET['invoice_number']?>">Kwa siku ya kuuza </a> &nbsp;&nbsp;&nbsp;&nbsp;
                <a href="ripoti_mauzo_mkopo_siku_ya_kulipa.php?invoice_number=<?php echo $_GET['invoice_number']?>">Kwa siku ya kulipa mkopo</a>&nbsp;&nbsp;&nbsp;&nbsp;
                <a href="ripoti_mauzo_mkopo_madeni_yaliyolipwa.php?invoice_number=<?php echo $_GET['invoice_number']?>">Kwa mkopo uliolipwa</a>&nbsp;&nbsp;&nbsp;&nbsp;
                <a href="general_ripoti_mauzo_mkopo.php?invoice_number=<?php echo $_GET['invoice_number']?>">Ripoti ya mauzo kwa mkopo </a>&nbsp;&nbsp;&nbsp;&nbsp;

                </div>
                </center>
              </div>
              <!-- /.card-header -->
              <section class="content">
                <div class="container-fluid">
                  <div class="row">
                    <div class="col-12">
                      <div class="card">
                        <div class="card-header">
                          <center>
                          <form action="ripoti_mauzo_mkopo_siku_ya_kulipa.php?invoice_number=<?php echo $_GET['invoice_number']?>" method="POST" class="form-inline">

      <div class="form-group">
        <label for="d1" class="sr-only">Kuanzia tarehe:</label>
        <input type="date" id="d1" name="d1" class="form-control" placeholder="Kuanzia Tarehe" autocomplete="off">
      </div>
      <div class="form-group">
        <label for="d2" class="sr-only">Mbaka tarehe:</label>
        <input type="date" id="d2" name="d2" class="form-control" placeholder="Mbaka Tarehe" autocomplete="off">
      </div>
      <div class="form-group">
        <label for="created_by" class="sr-only">Aliyeuza:</label>
        <input type="text" id="created_by" name="created_by" class="form-control" placeholder="Aliyeuza" autocomplete="off">
      </div>
      <div class="form-group">
        <label for="customer_name" class="sr-only">Mteja:</label>
        <input type="text" id="customer_name" name="customer_name" class="form-control" placeholder="Mteja" autocomplete="off">
      </div>
      <div class="form-group">
        <label for="medicine" class="sr-only">Jina la Dawa:</label>
        <input type="text" id="medicine" name="medicine" class="form-control" placeholder="Jina la Dawa" autocomplete="off">
      </div>
      <div class="form-group">
        <label for="category" class="sr-only">Aina ya Dawa:</label>
        <input type="text" id="category" name="category" class="form-control" placeholder="Aina ya Dawa" autocomplete="off">
      </div>
      <div class="form-group">
        <label for="hali_ya_malipo" class="sr-only">Hali ya malipo:</label>
        <input type="text" id="hali_ya_malipo" name="hali_ya_malipo" class="form-control" placeholder="Hali ya malipo" autocomplete="off">
      </div>
      <div class="form-group">
        <label for="payment_method" class="sr-only">Njia ya malipo:</label>
        <input type="text" id="payment_method" name="payment_method" class="form-control" placeholder="Njia ya malipo" autocomplete="off">
      </div>
      <!-- <div class="form-group">
        <label for="payment_method" class="sr-only">Kituo/Tawi:</label>
        <input type="text" id="payment_method" name="payment_method" class="form-control" placeholder="Kituo/Tawi" autocomplete="off">
      </div> -->
      <div class="form-group">
        <button class="btn btn-info" type="submit" name="submit"><i class="icon icon-search icon-large"></i> Tafuta</button>
      </div>
    </form>
                          </center>
                          <div style="overflow-x:auto; overflow-y: auto;">
                            <table class="table table-bordered table-striped table-hover">
                              <thead>
                              <tr class="table-success">
                                  <th>Tarehe ya kununua</th>
                                  <th>Dawa</th>
                                  <th>Idadi</th>
                                  <th>Kiasi</th>
                                  <th>Faida</th>
                                  <th>Aliyeuza</th>
                                  <th>Mteja</th>
                                  <th>Namba ya risiti</th>
                                  <th>Njia ya malipo</th>
                                  <th>Hali ya malipo</th>
                                  <th>Simu ya mteja</th>
                                  <th>Siku ya kulipa</th>
                                  <th>Siku aliyolipa</th>
                                  <th>Aliyerekodi malipo ya mkopo</th>
                                  <th>Kituo/Tawi</th>
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
                                $store_location = $_POST['store_location'];
     
                                $select_sql = "SELECT sales.*, stores.location FROM sales 
                              JOIN stores ON sales.store_id = stores.id  WHERE (date_to_pay BETWEEN '$d1' AND '$d2') AND (payment_method='credit') AND (hali_ya_malipo='not paid') ";
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
                                if (!empty($store_location)) {
                                  $select_sql .= " AND stores.location LIKE '%$store_location%'";
                                }
                                $select_sql .= " ORDER BY date_to_pay DESC";
                                
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
                                  <td><?php echo $row['phone_number']?></td>
                                  <td><?php echo $row['date_to_pay']?></td>
                                  <td><?php echo $row['date_to_pay']?></td>
                                  <td><?php echo $row['credit_payment_recorder']?></td>
                                  <td><?php echo $row['location']?></td>
                                </tr>
                              </tbody>
                              <?php endwhile;?>
                              <tfoot>
                                <tr>
                                  <th colspan="2">Jumla Mkuu:</th>
                                  <th><?php echo $total_quantity; ?></th>
                                  <th><?php echo $total_amount . ' Tsh'; ?></th>
                                  <th><?php echo $total_profit . ' Tsh'; ?></th>
                                  <th colspan="2"></th>
                                </tr>
                              </tfoot>
                              <?php } else {
                                $date = date('Y-m-d');
                                $select_sql =  "SELECT sales.*, stores.location FROM sales 
                              JOIN stores ON sales.store_id = stores.id WHERE date_to_pay = '$date' AND payment_method ='credit' AND hali_ya_malipo='not paid' ";
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
                                  <td><?php echo $row['customer_name']?></td>
                                  <td><?php echo $row['invoice_number']?></td>
                                  <td><?php echo $row['payment_method']?></td>
                                  <td><?php echo $row['hali_ya_malipo']?></td>
                                  <td><?php echo $row['phone_number']?></td>
                                  <td><?php echo $row['date_to_pay']?>&nbsp;&nbsp;(<font size='4' color='green;'>Today</font>)</td>
                                  <td><?php echo $row['paid_date']?></td>
                                  <td><?php echo $row['credit_payment_recorder']?></td>
                                  <td><?php echo $row['location']?></td>
                              </tbody>
                              <?php endwhile;?>
                              <tfoot>
                                <tr>
                                  <th colspan="2">Jumla Kuu:</th>
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
                                <a href="export_excel.php?d1=<?php echo $d1; ?>&d2=<?php echo $d2; ?>&created_by=<?php echo $created_by; ?>&medicine=<?php echo $medicine; ?>&category=<?php echo $category; ?>&store_location=<?php echo $store_location; ?>" class="btn btn-success">Pakua katika Excel</a>
                                <a href="export_pdf.php?d1=<?php echo $d1; ?>&d2=<?php echo $d2; ?>&created_by=<?php echo $created_by; ?>&medicine=<?php echo $medicine; ?>&category=<?php echo $category; ?>&store_location=<?php echo $store_location; ?>" class="btn btn-danger">Pakua katika PDF</a>
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
<script src="./dist/js/adminlte.min.js"></script>
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
</body>
</html>
