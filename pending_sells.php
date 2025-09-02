<?php include('session.php') ?>

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
                                                    <!-- <th>Ai na ya Dawa</th> -->
                                                    <th>Idadi</th>
                                                    <th>Kiasi</th>
                                                    <th>Aina ya malipo</th>
                                                    <th>Kitendo</th>
                                                    <!-- <th>Aliyeuza</th>                                      -->
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php
include("dbcon.php");
$currentYear = date("Y");            
    
// Modified SQL query to filter only records not in sales table
$select_sql = "SELECT oh.* FROM on_hold oh
               LEFT JOIN sales s ON oh.medicine_name = s.medicines 
                               AND oh.invoice_number = s.invoice_number
               WHERE s.medicines IS NULL AND oh.store_id = '$store_id'";

$select_query = mysqli_query($con, $select_sql);

if (mysqli_num_rows($select_query) > 0) {
    $serialNumber = 1;
    while ($row = mysqli_fetch_assoc($select_query)) {
        echo "<tr>";
        echo "<td>" . $serialNumber++ . "</td>";
        echo "<td>" . $row['date'] . "</td>";
        echo "<td>" . $row['medicine_name'] . "</td>";
        echo "<td>" . $row['qty'] . "</td>";
        echo "<td>" . $row['amount'] . "</td>";
        echo "<td>" . $row['payment_method'] . "</td>";
        echo '<td>
            <a href="home.php?invoice_number='.$row['invoice_number'].'" class="btn btn-primary btn-sm">
                <i class="fas fa-shopping-cart"></i> Malizia mauzo
            </a>
        </td>';
        echo "</tr>";
    }
} else {
    echo '<tr><td colspan="8">Hakuna mauzo yasiyo kamilika.</td></tr>';
}
?>
</tbody>
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
