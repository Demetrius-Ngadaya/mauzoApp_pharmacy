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

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">	
                           							
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Admin</a></li>
              <li class="breadcrumb-item active">Matumizi</li>
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
                <h3 class="card-title">
                 <b>  Mauzo yaliyofanyika mwezi wa saba  mbaka wa tisa </b> </h3>
              </div>
              <!-- /.card-header -->
             
              <div class="card-body">
						
						<div class="card-body table-responsive">
            <div class="hero-unit-table">   
            <div class="table-responsive">
    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
        <thead>
            <tr class="table-success">
                <th>S/N</th>
                <th>Tarehe</th>
                <th>Dawa</th>
                <th>Idadi</th>
                <th>Jumla kiasi cha fedha</th>
                <th>Jumla ya faida</th>  
                <th>Invoice</th>                                       
            </tr>
        </thead>
        <tbody>
            <?php
            // Get the current year
            include("dbcon.php");

            // Get the current year
            $currentYear = date("Y");
            
            // Construct the SQL query to retrieve sales data from July to September
            $select_sql = "SELECT * FROM sales 
                           WHERE Date >= '$currentYear-07-01' AND Date <= '$currentYear-09-30'";
            
            // Execute the SQL query
            $select_query = mysqli_query($con, $select_sql);

            // Execute the SQL query
            $select_query = mysqli_query($con, $select_sql);

            // Check if there are results
            if (mysqli_num_rows($select_query) > 0) {
                $serialNumber = 1; // Initialize serial number counter
                // Output the sales data
                while ($row = mysqli_fetch_assoc($select_query)) {
                    // Output each row of sales data
                    echo "<tr>";
                    echo "<td>" . $serialNumber++ . "</td>"; // Serial number column
                    echo "<td>" . $row['Date'] . "</td>";
                    echo "<td>" . $row['medicines'] . "</td>";
                    echo "<td>" . $row['quantity'] . "</td>";
                    echo "<td>" . $row['total_amount'] . "</td>";
                    echo "<td>" . $row['total_profit'] . "</td>";
                    echo "<td>" . $row['invoice_number'] . "</td>";
                    echo "</tr>";
                }
            } else {
                // If there are no sales recorded for the specified period, display a message
                echo '<tr><td colspan="7">No sales recorded from January to March.</td></tr>';
            }
            ?>
        </tbody>
    </table>
</div>

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
<?php include ('script.php');?>
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
<!-- page script -->
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
