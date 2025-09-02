<?php
session_start();

if (!isset($_SESSION['user_session'])) {
    header("location:index.php");
}
$mtumiaji = $_SESSION['user_session'];
$store_id = $_SESSION['store_id'];
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
                        <!-- Content Header -->
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <!-- <li class="breadcrumb-item"><a href="#">Admin</a></li>
                            <li class="breadcrumb-item active">Matumizi</li> -->
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">

                            <!-- /.card-header -->
                            <div class="card-body">
                            <div class="card-header">
                                <h3 class="card-title"><b>Jumla ya mauzo yote</b></h3>
                            </div>
                                <div class="card-body table-responsive">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                            <thead>
                                                <tr class="table-success">
                                                    <th>S/N</th>
                                                    <th>Tarehe</th>
                                                    <th>Dawa</th>
                                                    <th>Idadi</th>
                                                    <th>Kiasi</th>
                                                    <th>Jumla faida</th>  
                                                    <th>Namba ya risiti</th>    
                                                    <th>Aliyeuza</th>                                     
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                // Include database connection
                                                include("dbcon.php");

                                                // Get the current year
                                                $currentYear = date("Y");            
                                                
                                                // Construct the SQL query to retrieve all sales
                                                $select_sql = "SELECT * FROM sales WHERE store_id = '$store_id'";
                                                
                                                // Execute the SQL query
                                                $select_query = mysqli_query($con, $select_sql);

                                                // Initialize variables for total amount and profit
                                                $total_amount = 0;
                                                $total_profit = 0;
                                                $serialNumber = 1; // Initialize serial number counter

                                                // Check if there are results
                                                if (mysqli_num_rows($select_query) > 0) {
                                                    // Output the sales data
                                                    while ($row = mysqli_fetch_assoc($select_query)) {
                                                        // Calculate total amount
                                                        $total_amount += $row['total_amount'];
                                                        // Calculate total profit
                                                        $total_profit += $row['total_profit'];

                                                        // Output each row of sales data
                                                        echo "<tr>";
                                                        echo "<td>" . $serialNumber++ . "</td>"; // Serial number column
                                                        echo "<td>" . $row['Date'] . "</td>";
                                                        echo "<td>" . $row['medicines'] . "</td>";
                                                        echo "<td>" . $row['quantity'] . "</td>";
                                                        echo "<td>" . number_format($row['total_amount']) . "</td>";
                                                        echo "<td>" . number_format($row['total_profit']) . "</td>";
                                                        echo "<td>" . $row['invoice_number'] . "</td>";
                                                        echo "<td>" . $row['created_by'] . "</td>";
                                                        echo "</tr>";
                                                    }
                                                } else {
                                                    // If there are no sales recorded for the specified period, display a message
                                                    echo '<tr><td colspan="8">No sales done.</td></tr>';
                                                }
                                                ?>
                                            </tbody>
                                            <tfoot>
                                                <tr class="table-success">
                                                    <th colspan="4">Jumla kuu</th>
                                                    <th><?php echo number_format($total_amount); ?></th>
                                                    <th><?php echo number_format($total_profit); ?></th>
                                                    <th colspan="2"></th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                                <!-- /.card-body -->
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
      <?php  include("footer.php"); ?>

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
    <!-- page script -->
    <script>
        $(function () {
            $("#dataTables-example").DataTable({
                "responsive": true,
                "autoWidth": false,
                "ordering": false // Disable initial ordering if not needed
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
