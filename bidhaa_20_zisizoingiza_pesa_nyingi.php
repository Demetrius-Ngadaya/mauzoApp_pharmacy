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
  <!-- Navbar -->
  
  <?php include("navbar.php"); ?>
  <?php include('indexSideBar.php') ?>
  
  <!-- /.navbar --> 

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
  <a href="index.php" class="brand-link">   
      <H1><span class="brand-text font-weight-light"> MauzoApp</span></H1>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar Menu -->
      
      <?php include('indexSideBar.php') ?>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">	
                           							
          </div>
          <div class="col-sm-6">
            <!-- <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Admin</a></li>
              <li class="breadcrumb-item active">Matumizi</li>
            </ol> -->
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

              <!-- /.card-header -->
             
              <div class="card-body">
              <div class="card-header">
                <h3 class="card-title">
                 <b>Dawa dhaifu zilizoingiza kipato cha chini. </b> </h3>
              </div>
						<div class="card-body table-responsive">
            <div class="hero-unit-table">   
                            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                    <tr class="table-success">
                                    <th>S/N</th>
                                    <th>Dawa</th>
                                    <th>Idadi</th>
                                    <th>Kiasi</th>
                                    <th>Faida</th>                                
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
include("dbcon.php");

// Get the current week's starting and ending dates
$currentWeekStart = date('Y-m-d', strtotime('monday this week'));
$currentWeekEnd = date('Y-m-d', strtotime('sunday this week'));

// Construct the SQL query to retrieve the total sales from sales table for all medicines sold where in stock table quantity - act_remain_quantity <= 50
$select_sql = "SELECT 
                    stock.id,
                    stock.medicine_name,
                    SUM(sales.quantity) AS total_quantity,
                    SUM(sales.total_amount) AS total_amount,
                    SUM(sales.total_profit) AS total_profit
                FROM sales 
                JOIN stock ON sales.medicine_id = stock.id 
                WHERE sales.store_id = '$store_id'
                GROUP BY stock.id, stock.medicine_name
                ORDER BY total_amount ASC
                LIMIT 20";
 

// Execute the SQL query
$select_query = mysqli_query($con, $select_sql);

// Check if there are results
if (mysqli_num_rows($select_query) > 0) {
     // Initialize a counter variable
     $serial = 1;
    // Output the sales data
    while ($row = mysqli_fetch_assoc($select_query)) {
        // Output each row of sales data
        echo "<tr>";
        // Output the serial number
        echo "<td>" . $serial . "</td>";
        echo "<td>" . $row['medicine_name'] . "</td>";
        echo "<td>" . $row['total_quantity'] . "</td>";
        echo "<td>" . number_format($row['total_amount']) . "</td>";
        echo "<td>" . number_format( $row['total_profit']) . "</td>";
        echo "</tr>";
        
        // Increment the counter
        $serial++;
    }
} else {
    // If there are no sales recorded for today, display a message
    echo '<tr><td colspan="6">There is no bottom 20 medicines for generating the least revenue.</td></tr>';
}
?>

                                </tbody>
                            </table>
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
<script src="./plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="./plugins/datatables/jquery.dataTables.min.js"></script>
<script src="./plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="./plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="./plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="./dist/js/adminlte.min.js"></script>
<script src="./dist/js/demo.js"></script>
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true,
      "autoWidth": false,
    });
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
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
