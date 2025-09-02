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
              <li class="breadcrumb-item active">Expenditure report</li>
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

              <!-- /.card-header -->
              <section class="content">
                <div class="container-fluid">
                <div class="card-header">
                <h3 class="card-title"><b>Expenditure report</b></h3>
              </div>
                  <div class="row">
                    <div class="col-12">
                      <div class="card">
                        <div class="card-header">
                          <center>
                            <form action="cashier_expenditure_report.php?invoice_number=<?php echo $_GET['invoice_number']?>" method="POST" class="form-inline mb-4">
                              <div class="form-group mb-4">
                                <label for="d1"><strong>Date from:</strong></label>
                                <input type="date" id="d1" name="d1" class="form-control ml-2" autocomplete="off" required>
                              </div>
                              <div class="form-group ml-3 mb-4">
                                <label for="d2"><strong>Date to:</strong></label>
                                <input type="date" id="d2" name="d2" class="form-control ml-2" autocomplete="off" required>
                              </div>
                              <div class="form-group ml-3 mb-4">
                                <label for="created_by"><strong>Expenditure recorder:</strong></label>
                                <input type="text" id="created_by" name="created_by" class="form-control ml-2" autocomplete="off">
                              </div>
                              <div class="form-group ml-3">
                                <label for="expenditure_name"><strong>Expenditure name:</strong></label>
                                <input type="text" id="expenditure_name" name="expenditure_name" class="form-control ml-2" autocomplete="off">
                              </div>
                              <div class="form-group ml-3">
                                <label for="expenditure_description"><strong>Expenditure description:</strong></label>
                                <input type="text" id="expenditure_description" name="expenditure_description" class="form-control ml-2" autocomplete="off">
                              </div>
                              <div class="form-group ml-3">
                                <button class="btn btn-info" type="submit" name="submit"><i class="icon icon-search icon-large"></i> Tafuta</button>
                              </div>
                            </form>
                          </center>
                          <div style="overflow-x:auto; overflow-y: auto;">
                            <table class="table table-bordered table-striped table-hover">
                              <thead>
                              <tr class="table-success">
                                  <th>Date</th>
                                  <th>Expenditure name</th>
                                  <th>Description</th>
                                  <th>Amount</th>
                                  <th>Expenditure recorder</th>
                                </tr>
                              </thead>
                              <?php
                              include("dbcon.php");
                              error_reporting(1);
                              if(isset($_POST['submit'])){
                                $d1 = $_POST['d1'];
                                $d2 = $_POST['d2'];
                                $created_by = $_POST['created_by'];
                                $expenditure_name = $_POST['expenditure_name'];
                                $expenditure_description = $_POST['expenditure_description'];
                                
                                $select_sql = "SELECT * FROM expenditure WHERE created_at BETWEEN '$d1' AND '$d2'";
                                
                                if (!empty($created_by)) {
                                  $select_sql .= " AND created_by LIKE '%$created_by%'";
                                }
                                if (!empty($expenditure_name)) {
                                  $select_sql .= " AND expenditure_name LIKE '%$expenditure_name%'";
                                }
                                if (!empty($expenditure_description)) {
                                  $select_sql .= " AND expenditure_description LIKE '%$expenditure_description%'";
                                }
                                
                                $select_sql .= " ORDER BY created_at DESC";
                                
                                $select_query = mysqli_query($con, $select_sql);
                                
                                while($row = mysqli_fetch_array($select_query)) :
                              ?>
                              <tbody>
                                <tr> 
                                            <td><?php echo $row['created_at']; ?></td> 
                                            <td><?php echo $row['expenditure_name']; ?></td> 
                                            <td><?php echo $row['expenditure_description']; ?></td>
                                            <td><?php echo $row['expenditure_amount']; ?></td> 
                                            <td><?php echo $row['created_by']; ?></td>
                                </tr>
                              </tbody>
                              <?php endwhile;?>
                              <tfoot>
                                <tr>
                                  <th colspan="3">Jumla Kuu:</th>
                                  <th>
                                    <?php
                                    $select_sql = "SELECT SUM(expenditure_amount) FROM expenditure WHERE created_at BETWEEN '$d1' AND '$d2'";
                                    if (!empty($created_by)) {
                                      $select_sql .= " AND created_by LIKE '%$created_by%'";
                                    }
                                    if (!empty($expenditure_name)) {
                                      $select_sql .= " AND expenditure_name LIKE '%$expenditure_name%'";
                                    }
                                    if (!empty($expenditure_description)) {
                                      $select_sql .= " AND expenditure_description LIKE '%$expenditure_description%'";
                                    }
                                    $select_query = mysqli_query($con, $select_sql);
                                    while($row = mysqli_fetch_array($select_query)){
                                      echo $row['SUM(expenditure_amount)'].' Tsh';
                                    }
                                    ?>
                                  </th>
                                </tr>
                              </tfoot>
                              <?php } else {
                                $date = date('Y-m-d');
                                $select_sql = "SELECT * FROM expenditure WHERE created_at = '$date'";
                                $select_query = mysqli_query($con, $select_sql);
                                while($row = mysqli_fetch_array($select_query)) :
                              ?>
                              <tbody>
                                <tr> 
                                            <td><?php echo $row['created_at']; ?></td> 
                                            <td><?php echo $row['expenditure_name']; ?></td> 
                                            <td><?php echo $row['expenditure_description']; ?></td>
                                            <td><?php echo $row['expenditure_amount']; ?></td> 
                                            <td><?php echo $row['created_by']; ?></td>
                                </tr>
                              </tbody>
                              <?php endwhile;?>
                              <tfoot>
                                <tr>
                                  <th colspan="3">Grand total:</th>
                                  <th>
                                    <?php
                                    $select_sql = "SELECT SUM(expenditure_amount) FROM expenditure WHERE created_at = '$date'";
                                    $select_query = mysqli_query($con, $select_sql);
                                    while($row = mysqli_fetch_array($select_query)){
                                      echo $row['SUM(expenditure_amount)'].' Tsh';
                                    }
                                    ?>
                                  </th>
                                </tr>
                              </tfoot>
                              <?php } ?>
                            </table>
                            <center>
                              <div class="export-buttons">
                                <a href="export_excel.php?d1=<?php echo $d1; ?>&d2=<?php echo $d2; ?>&created_by=<?php echo $created_by; ?>&expenditure_name=<?php echo $expenditure_name; ?>&expenditure_description=<?php echo $expenditure_description; ?>" class="btn btn-success">Export in Excel</a>
                                <a href="export_pdf.php?d1=<?php echo $d1; ?>&d2=<?php echo $d2; ?>&created_by=<?php echo $created_by; ?>&expenditure_name=<?php echo $expenditure_name; ?>&expenditure_description=<?php echo $expenditure_description; ?>" class="btn btn-danger">Export in PDF</a>
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
