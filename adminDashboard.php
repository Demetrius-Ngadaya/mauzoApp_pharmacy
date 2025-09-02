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
  <script src="js/chart.min.js"></script>
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
        <div class="row mb-0">
          <div class="col-sm-6">						
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
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

              <!-- /.card-header -->             
              <div class="card-body">
              <!-- First row -->
              <div class="card-header">
                <h3 class="card-title">
                 <b>
                 Grafu zinazoonyesha ripoti za kuanzia januari hadi Disemba kwa mwaka huu</b> </h3>
              </div>
                 <div class="row">
                   <!-- Sales Graph -->
                     <div class="col-md-6">
                         <div class="card">
                           <div class="card-header">
                            <h3 class="card-title">Grafu ikionesha jumla ya idadi ya Dawa zilizouzwa</h3>
                            </div>
                         <div class="card-body">
                         <canvas id="totalSalesChart" width="400" height="200"></canvas>
                         <?php
                         include("dbcon.php");
                        // Initialize arrays to store total sales for each month
                        $totalSales = [];
$totalProfit = [];
$totalAmount = [];

// Loop through each month
for ($i = 1; $i <= 12; $i++) {
    // Get the year and month in YYYY-MM format
    $currentDate = date("Y") . '-' . str_pad($i, 2, '0', STR_PAD_LEFT);

    // Construct the SQL query to calculate the total sales, profit, and amount for the current month
    $select_sql = "SELECT 
                        COALESCE(SUM(quantity), 0) AS total_sales, 
                        COALESCE(SUM(total_profit), 0) AS total_profit,
                        COALESCE(SUM(total_amount), 0) AS total_amount
                   FROM sales 
                   WHERE DATE_FORMAT(date, '%Y-%m') = '$currentDate'";

    // Execute the SQL query
    $select_query = mysqli_query($con, $select_sql);

    // Fetch the total sales, profit, and amount for the current month
    $row = mysqli_fetch_assoc($select_query);

    // Add the total sales, profit, and amount to the arrays
    $totalSales[] = $row['total_sales'];
    $totalProfit[] = $row['total_profit'];
    $totalAmount[] = $row['total_amount'];
}
?>

        
            </div>
        </div>
    </div>
    <!-- Profit Graph -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Grafu ikionesha faida</h3>
            </div>
            <div class="card-body">
                <canvas id="profitChart" width="400" height="200"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Second row -->
<div class="row mt-4">
    <!-- Total Sales Graph -->
    <div class="col-md-6">


      <div class="card">
            <div class="card-header">
                <h3 class="card-title">Grafu ikionesha mauzo</h3>
            </div>
            <div class="card-body">
                <canvas id="salesChart" width="400" height="200"></canvas>
            </div>
        </div>
    </div>
    <!-- Expenditure Graph -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Grafu ikionesha matumuzi</h3>
            </div>
            <div class="card-body">
               <!-- Canvas element to render the line graph -->
<canvas id="expenditureChart" width="400" height="400"></canvas>

<?php
// Include database connection
include("dbcon.php");

// Get the current year
$currentYear = date("Y");

// Construct the SQL query to retrieve total expenditure amount grouped by month for the current year
$select_sql = "SELECT DATE_FORMAT(created_at, '%Y-%m') AS Month, SUM(expenditure_amount) AS TotalExpenditure
               FROM expenditure
               WHERE YEAR(created_at) = '$currentYear'
               GROUP BY DATE_FORMAT(created_at, '%Y-%m')";

// Execute the SQL query
$select_query = mysqli_query($con, $select_sql);

// Initialize arrays to store labels (months) and data (total amounts) for the chart
$months = [];
$totalExpenditure = [];

// Fetch data from the query results
while ($row = mysqli_fetch_assoc($select_query)) {
    $months[] = $row['Month'];
    $totalExpenditure[] = $row['TotalExpenditure'];
}
?>

            </div>
        </div>
    </div>
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
</script>
<!-- total sales js -->
<script>
    // Retrieve PHP array from PHP to JavaScript
    var totalSales = <?php echo json_encode($totalSales); ?>;

    // Get the canvas element
    var ctx = document.getElementById('totalSalesChart').getContext('2d');

    // Create a new area chart instance
    var totalSalesChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
            datasets: [{
                label: 'Idadi ya Dawa zilizouzwa',
                data: totalSales,
                fill: true,
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            },
            tooltips: {
                callbacks: {
                    label: function(tooltipItem, data) {
                        var label = data.datasets[tooltipItem.datasetIndex].label || '';
                        var value = tooltipItem.yLabel;
                        return label + ': ' + value;
                    }
                }
            }
        }
    });
</script>
<script>
    // Retrieve PHP arrays from PHP to JavaScript
    var months = <?php echo json_encode($months); ?>;
    var totalExpenditure = <?php echo json_encode($totalExpenditure); ?>;

    // Get the canvas element
    var ctx = document.getElementById('expenditureChart').getContext('2d');

    // Create a new bar chart instance
    var salesChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: months,
            datasets: [{
                label: 'Total amout of money', 
                data: totalExpenditure,
                backgroundColor: 'red',
                borderColor: 'red',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
</script>
<!-- profit graph -->
<script>
    // Retrieve PHP array from PHP to JavaScript
    var totalProfit = <?php echo json_encode($totalProfit); ?>;

    // Get the canvas element
    var ctxProfit = document.getElementById('profitChart').getContext('2d');

    // Create a new bar chart instance
    var profitChart = new Chart(ctxProfit, {
        type: 'bar',
        data: {
            labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
            datasets: [{
                label: 'Total profit',
                data: totalProfit,
                backgroundColor: 'rgba(75, 192, 192, 0.5)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
</script>
<!-- total sales amount graph -->
<script>
    // Retrieve PHP array from PHP to JavaScript
    var totalAmount = <?php echo json_encode($totalAmount); ?>;

    // Get the canvas element
    var ctxSales = document.getElementById('salesChart').getContext('2d');

    // Create a new pie chart instance
    var salesChart = new Chart(ctxSales, {
        type: 'pie',
        data: {
            labels: ['Januari', 'Februari', 'Machi', 'Apri', 'Mei', 'Juni', 'Julai', 'Agosti', 'Septemba', 'Oktoba', 'Novemba', 'Disemba'],
            datasets: [{
                label: 'Total sells',
                data: totalAmount,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.5)',
                    'rgba(54, 162, 235, 0.5)',
                    'rgba(255, 206, 86, 0.5)',
                    'rgba(75, 192, 192, 0.5)',
                    'rgba(153, 102, 255, 0.5)',
                    'rgba(255, 159, 64, 0.5)',
                    'rgba(255, 99, 132, 0.5)',
                    'rgba(54, 162, 235, 0.5)',
                    'rgba(255, 206, 86, 0.5)',
                    'rgba(75, 192, 192, 0.5)',
                    'rgba(153, 102, 255, 0.5)',
                    'rgba(255, 159, 64, 0.5)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)',
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true
        }
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
