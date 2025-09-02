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
      width: 8%;
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
    .no-data {
      text-align: center;
      font-weight: bold;
      padding: 20px;
      background-color: #f8f9fa;
    }
    /* Prevent text wrapping and ensure single line display */
    .table-responsive {
      overflow-x: auto;
      -webkit-overflow-scrolling: touch;
    }
    .table {
      width: 100%;
      margin-bottom: 1rem;
      color: #212529;
    }
    .table td, .table th {
      white-space: nowrap;
      padding: 0.75rem;
      vertical-align: top;
      border-top: 1px solid #dee2e6;
    }
    .table thead th {
      vertical-align: bottom;
      border-bottom: 2px solid #dee2e6;
    }
    .table-bordered {
      border: 1px solid #dee2e6;
    }
    .table-bordered th,
    .table-bordered td {
      border: 1px solid #dee2e6;
    }
    /* Pagination styles */
    .pagination-container {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-top: 20px;
    }
    .pagination {
      margin: 0;
    }
    .page-item.active .page-link {
      background-color: #007bff;
      border-color: #007bff;
    }
    .page-link {
      color: #007bff;
    }
    /* Records per page selector */
    .records-per-page {
      display: flex;
      align-items: center;
    }
    .records-per-page label {
      margin-right: 10px;
      margin-bottom: 0;
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
      });
      
      // Handle records per page change
      $('#records_per_page').change(function() {
        var recordsPerPage = $(this).val();
        var url = new URL(window.location.href);
        url.searchParams.set('per_page', recordsPerPage);
        url.searchParams.set('page', 1); // Reset to first page
        window.location.href = url.toString();
      });
    });
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
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Admin</a></li>
              <li class="breadcrumb-item active">Faida ya Dawa</li>
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
              <div class="card-header">
                <h3 class="card-title"><b>Ripoti ya Faida ya Uendeshaji</b></h3>
              </div>
              <div class="card-body">
                <form action="operational_profit_report.php?invoice_number=<?php echo $_GET['invoice_number']?>" method="POST" class="form-inline">
                  <div class="form-group">
                    <label for="d1" class="sr-only">Kuanzia Tarehe:</label>
                    <input type="date" id="d1" name="d1" class="form-control" placeholder="Kuanzia Tarehe" autocomplete="off">
                  </div>
                  <div class="form-group">
                    <label for="d2" class="sr-only">Mpaka Tarehe:</label>
                    <input type="date" id="d2" name="d2" class="form-control" placeholder="Mpaka Tarehe" autocomplete="off">
                  </div>
                  <div class="form-group">
                    <button class="btn btn-info" type="submit" name="submit"><i class="icon icon-search icon-large"></i> Tafuta</button>
                  </div>
                </form>
                
                <!-- Records per page selector -->
                <div class="records-per-page">
                  <label for="records_per_page">Rekodi kwa kila ukurasa:</label>
                  <select id="records_per_page" class="form-control">
                    <option value="10" <?php echo (isset($_GET['per_page']) && $_GET['per_page'] == 10) ? 'selected' : ''; ?>>10</option>
                    <option value="25" <?php echo (!isset($_GET['per_page']) || (isset($_GET['per_page']) && $_GET['per_page'] == 25)) ? 'selected' : ''; ?>>25</option>
                    <option value="50" <?php echo (isset($_GET['per_page']) && $_GET['per_page'] == 50) ? 'selected' : ''; ?>>50</option>
                    <option value="100" <?php echo (isset($_GET['per_page']) && $_GET['per_page'] == 100) ? 'selected' : ''; ?>>100</option>
                    <option value="999999" <?php echo (isset($_GET['per_page']) && $_GET['per_page'] == 999999) ? 'selected' : ''; ?>>Zote</option>
                  </select>
                </div>
                
                <div class="table-responsive">
                  <table class="table table-bordered">
                    <thead>
                      <tr class="table-success">
                        <th>S/N</th>
                        <th>Tarehe</th>
                        <th>Mauzo (Sales)</th>
                        <th>Gharama (Cost)</th>
                        <th>Faida ya Jumla (G/Profit)</th>
                        <th>Matumizi (Expenditure)</th>
                        <th>Faida ya Uendeshaji (Operational Profit)</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php
                    include("dbcon.php");
                    $total_sales = 0;
                    $total_cost = 0;
                    $total_gross_profit = 0;
                    $total_expenditure = 0;
                    $total_operational_profit = 0;
                    $has_records = false;

                    // Pagination variables
                    $results_per_page = isset($_GET['per_page']) ? (int)$_GET['per_page'] : 25;
                    if ($results_per_page == 999999) {
                      $results_per_page = 999999; // Show all records
                    }
                    $current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                    if ($current_page < 1) $current_page = 1;
                    $offset = ($current_page - 1) * $results_per_page;

                    // Function to build URL with all parameters
                    function buildUrl($params) {
                      global $invoice_number;
                      $url = 'operational_profit_report.php?';
                      $query = $_GET;
                      foreach ($params as $key => $value) {
                        $query[$key] = $value;
                      }
                      // Maintain invoice_number in URL
                      if (!empty($invoice_number)) {
                        $query['invoice_number'] = $invoice_number;
                      }
                      return $url . http_build_query($query);
                    }

                    if(isset($_POST['submit'])){
                        $d1 = $_POST['d1'];
                        $d2 = $_POST['d2'];
                        $created_by = $_POST['created_by'] ?? '';
                        $customer_name = $_POST['customer_name'] ?? '';
                        $medicine = $_POST['medicine'] ?? '';
                        $category = $_POST['category'] ?? '';
                        
                        // Store search parameters in session
                        $_SESSION['search_params'] = $_POST;
                        
                        // Get all dates in range with either sales or expenditure
                        $date_sql = "SELECT DISTINCT Date as transaction_date FROM sales 
                                    WHERE Date BETWEEN '$d1' AND '$d2'";
                        
                        if (!empty($created_by)) {
                            $date_sql .= " AND created_by LIKE '%$created_by%'";
                        }
                        if (!empty($customer_name)) {
                            $date_sql .= " AND customer_name LIKE '%$customer_name%'";
                        }
                        if (!empty($medicine)) {
                            $date_sql .= " AND medicines LIKE '%$medicine%'";
                        }
                        if (!empty($category)) {
                            $date_sql .= " AND category LIKE '%$category%'";
                        }
                        
                        $date_sql .= " UNION SELECT DISTINCT created_at as transaction_date FROM expenditure
                                    WHERE created_at BETWEEN '$d1' AND '$d2'
                                    ORDER BY transaction_date";
                        
                        // Count total results for pagination
                        $count_query = mysqli_query($con, "SELECT COUNT(*) as total FROM ($date_sql) as temp");
                        $count_data = mysqli_fetch_assoc($count_query);
                        $total_results = $count_data['total'];
                        $total_pages = ceil($total_results / $results_per_page);
                        
                        // Add limit for pagination if not showing all records
                        if ($results_per_page != 999999) {
                          $date_sql .= " LIMIT $offset, $results_per_page";
                        }
                        
                        $date_query = mysqli_query($con, $date_sql);
                        $num_rows = mysqli_num_rows($date_query);
                        
                        if($num_rows > 0) {
                            $has_records = true;
                            $serial_number = $offset + 1;
                            while($date_row = mysqli_fetch_assoc($date_query)) {
                                $current_date = $date_row['transaction_date'];
                                
                                // Get sales
                                $sales_sql = "SELECT SUM(total_amount) as total_sales FROM sales WHERE Date = '$current_date'";
                                if (!empty($created_by)) $sales_sql .= " AND created_by LIKE '%$created_by%'";
                                if (!empty($customer_name)) $sales_sql .= " AND customer_name LIKE '%$customer_name%'";
                                if (!empty($medicine)) $sales_sql .= " AND medicines LIKE '%$medicine%'";
                                if (!empty($category)) $sales_sql .= " AND category LIKE '%$category%'";
                                
                                $sales_result = mysqli_query($con, $sales_sql);
                                $sales_data = mysqli_fetch_assoc($sales_result);
                                $daily_sales = $sales_data['total_sales'] ?? 0;
                                $total_sales += $daily_sales;
                                
                                // Get cost
                                $cost_sql = "SELECT SUM(s.quantity * latest_purchase.total_cost) as total_cost
                                            FROM sales s
                                            JOIN (
                                                SELECT pr1.medicine_id, pr1.total_cost
                                                FROM purchases_report pr1
                                                WHERE pr1.id = (
                                                    SELECT MAX(pr2.id)
                                                    FROM purchases_report pr2
                                                    WHERE pr2.medicine_id = pr1.medicine_id
                                                )
                                            ) latest_purchase ON s.medicine_id = latest_purchase.medicine_id
                                            WHERE s.Date = '$current_date'";
                                $cost_result = mysqli_query($con, $cost_sql);
                                $cost_data = mysqli_fetch_assoc($cost_result);
                                $daily_cost = $cost_data['total_cost'] ?? 0;
                                $total_cost += $daily_cost;
                                
                                // Calculate profits
                                $daily_gross_profit = $daily_sales - $daily_cost;
                                $total_gross_profit += $daily_gross_profit;
                                
                                // Get expenditure
                                $exp_sql = "SELECT SUM(expenditure_amount) as total_exp FROM expenditure WHERE created_at = '$current_date'";
                                $exp_result = mysqli_query($con, $exp_sql);
                                $exp_data = mysqli_fetch_assoc($exp_result);
                                $daily_exp = $exp_data['total_exp'] ?? 0;
                                $total_expenditure += $daily_exp;
                                
                                $daily_operational_profit = $daily_gross_profit - $daily_exp;
                                $total_operational_profit += $daily_operational_profit;
                                ?>
                                <tr>
                                  <td><?php echo $serial_number++; ?></td>
                                    <td><?= $current_date ?></td>
                                    <td><?= number_format($daily_sales, 2) ?> Tsh</td>
                                    <td><?= number_format($daily_cost, 2) ?> Tsh</td>
                                    <td><?= number_format($daily_gross_profit, 2) ?> Tsh</td>
                                    <td><?= number_format($daily_exp, 2) ?> Tsh</td>
                                    <td><?= number_format($daily_operational_profit, 2) ?> Tsh</td>
                                </tr>
                                <?php
                            }
                        } else {
                            ?>
                            <tr>
                                <td colspan="6" class="no-data">Hakuna taharifa</td>
                            </tr>
                            <?php
                        }
                    } else {
                        // Check if we have search parameters in session
                        if (isset($_SESSION['search_params'])) {
                          $d1 = $_SESSION['search_params']['d1'];
                          $d2 = $_SESSION['search_params']['d2'];
                          $created_by = $_SESSION['search_params']['created_by'] ?? '';
                          $customer_name = $_SESSION['search_params']['customer_name'] ?? '';
                          $medicine = $_SESSION['search_params']['medicine'] ?? '';
                          $category = $_SESSION['search_params']['category'] ?? '';
                          
                          // Get all dates in range with either sales or expenditure
                          $date_sql = "SELECT DISTINCT Date as transaction_date FROM sales 
                                      WHERE Date BETWEEN '$d1' AND '$d2'";
                          
                          if (!empty($created_by)) {
                              $date_sql .= " AND created_by LIKE '%$created_by%'";
                          }
                          if (!empty($customer_name)) {
                              $date_sql .= " AND customer_name LIKE '%$customer_name%'";
                          }
                          if (!empty($medicine)) {
                              $date_sql .= " AND medicines LIKE '%$medicine%'";
                          }
                          if (!empty($category)) {
                              $date_sql .= " AND category LIKE '%$category%'";
                          }
                          
                          $date_sql .= " UNION SELECT DISTINCT created_at as transaction_date FROM expenditure
                                      WHERE created_at BETWEEN '$d1' AND '$d2'
                                      ORDER BY transaction_date";
                          
                          // Count total results for pagination
                          $count_query = mysqli_query($con, "SELECT COUNT(*) as total FROM ($date_sql) as temp");
                          $count_data = mysqli_fetch_assoc($count_query);
                          $total_results = $count_data['total'];
                          $total_pages = ceil($total_results / $results_per_page);
                          
                          // Add limit for pagination if not showing all records
                          if ($results_per_page != 999999) {
                            $date_sql .= " LIMIT $offset, $results_per_page";
                          }
                          
                          $date_query = mysqli_query($con, $date_sql);
                          $num_rows = mysqli_num_rows($date_query);
                          
                          if($num_rows > 0) {
                              $has_records = true;
                              $serial_number = $offset + 1;
                              while($date_row = mysqli_fetch_assoc($date_query)) {
                                  $current_date = $date_row['transaction_date'];
                                  
                                  // Get sales
                                  $sales_sql = "SELECT SUM(total_amount) as total_sales FROM sales WHERE Date = '$current_date'";
                                  if (!empty($created_by)) $sales_sql .= " AND created_by LIKE '%$created_by%'";
                                  if (!empty($customer_name)) $sales_sql .= " AND customer_name LIKE '%$customer_name%'";
                                  if (!empty($medicine)) $sales_sql .= " AND medicines LIKE '%$medicine%'";
                                  if (!empty($category)) $sales_sql .= " AND category LIKE '%$category%'";
                                  
                                  $sales_result = mysqli_query($con, $sales_sql);
                                  $sales_data = mysqli_fetch_assoc($sales_result);
                                  $daily_sales = $sales_data['total_sales'] ?? 0;
                                  $total_sales += $daily_sales;
                                  
                                  // Get cost
                                  $cost_sql = "SELECT SUM(s.quantity * latest_purchase.total_cost) as total_cost
                                              FROM sales s
                                              JOIN (
                                                  SELECT pr1.medicine_id, pr1.total_cost
                                                  FROM purchases_report pr1
                                                  WHERE pr1.id = (
                                                      SELECT MAX(pr2.id)
                                                      FROM purchases_report pr2
                                                      WHERE pr2.medicine_id = pr1.medicine_id
                                                  )
                                              ) latest_purchase ON s.medicine_id = latest_purchase.medicine_id
                                              WHERE s.Date = '$current_date'";
                                  $cost_result = mysqli_query($con, $cost_sql);
                                  $cost_data = mysqli_fetch_assoc($cost_result);
                                  $daily_cost = $cost_data['total_cost'] ?? 0;
                                  $total_cost += $daily_cost;
                                  
                                  // Calculate profits
                                  $daily_gross_profit = $daily_sales - $daily_cost;
                                  $total_gross_profit += $daily_gross_profit;
                                  
                                  // Get expenditure
                                  $exp_sql = "SELECT SUM(expenditure_amount) as total_exp FROM expenditure WHERE created_at = '$current_date'";
                                  $exp_result = mysqli_query($con, $exp_sql);
                                  $exp_data = mysqli_fetch_assoc($exp_result);
                                  $daily_exp = $exp_data['total_exp'] ?? 0;
                                  $total_expenditure += $daily_exp;
                                  
                                  $daily_operational_profit = $daily_gross_profit - $daily_exp;
                                  $total_operational_profit += $daily_operational_profit;
                                  ?>
                                  <tr>
                                      <td><?php echo $serial_number++; ?></td>
                                      <td><?= $current_date ?></td>
                                      <td><?= number_format($daily_sales, 2) ?> Tsh</td>
                                      <td><?= number_format($daily_cost, 2) ?> Tsh</td>
                                      <td><?= number_format($daily_gross_profit, 2) ?> Tsh</td>
                                      <td><?= number_format($daily_exp, 2) ?> Tsh</td>
                                      <td><?= number_format($daily_operational_profit, 2) ?> Tsh</td>
                                  </tr>
                                  <?php
                              }
                          } else {
                              ?>
                              <tr>
                                  <td colspan="6" class="no-data">Hakuna taharifa</td>
                              </tr>
                              <?php
                          }
                        } else {
                          // Default to all data when page first loads
                          $date_sql = "SELECT DISTINCT Date as transaction_date FROM sales 
                                      UNION 
                                      SELECT DISTINCT created_at as transaction_date FROM expenditure
                                      ORDER BY transaction_date DESC";
                          
                          // Count total results for pagination
                          $count_query = mysqli_query($con, "SELECT COUNT(*) as total FROM ($date_sql) as temp");
                          $count_data = mysqli_fetch_assoc($count_query);
                          $total_results = $count_data['total'];
                          $total_pages = ceil($total_results / $results_per_page);
                          
                          // Add limit for pagination if not showing all records
                          if ($results_per_page != 999999) {
                            $date_sql .= " LIMIT $offset, $results_per_page";
                          }
                          
                          $date_query = mysqli_query($con, $date_sql);
                          $num_rows = mysqli_num_rows($date_query);
                          
                          if($num_rows > 0) {
                              $has_records = true;
                              $serial_number = $offset + 1;
                              while($date_row = mysqli_fetch_assoc($date_query)) {
                                  $current_date = $date_row['transaction_date'];
                                  
                                  // Get sales
                                  $sales_sql = "SELECT SUM(total_amount) as total_sales FROM sales WHERE Date = '$current_date'";
                                  $sales_result = mysqli_query($con, $sales_sql);
                                  $sales_data = mysqli_fetch_assoc($sales_result);
                                  $daily_sales = $sales_data['total_sales'] ?? 0;
                                  $total_sales += $daily_sales;
                                  
                                  // Get cost
                                  $cost_sql = "SELECT SUM(s.quantity * latest_purchase.total_cost) as total_cost
                                              FROM sales s
                                              JOIN (
                                                  SELECT pr1.medicine_id, pr1.total_cost
                                                  FROM purchases_report pr1
                                                  WHERE pr1.id = (
                                                      SELECT MAX(pr2.id)
                                                      FROM purchases_report pr2
                                                      WHERE pr2.medicine_id = pr1.medicine_id
                                                  )
                                              ) latest_purchase ON s.medicine_id = latest_purchase.medicine_id
                                              WHERE s.Date = '$current_date'";
                                  $cost_result = mysqli_query($con, $cost_sql);
                                  $cost_data = mysqli_fetch_assoc($cost_result);
                                  $daily_cost = $cost_data['total_cost'] ?? 0;
                                  $total_cost += $daily_cost;
                                  
                                  // Calculate profits
                                  $daily_gross_profit = $daily_sales - $daily_cost;
                                  $total_gross_profit += $daily_gross_profit;
                                  
                                  // Get expenditure
                                  $exp_sql = "SELECT SUM(expenditure_amount) as total_exp FROM expenditure WHERE created_at = '$current_date'";
                                  $exp_result = mysqli_query($con, $exp_sql);
                                  $exp_data = mysqli_fetch_assoc($exp_result);
                                  $daily_exp = $exp_data['total_exp'] ?? 0;
                                  $total_expenditure += $daily_exp;
                                  
                                  $daily_operational_profit = $daily_gross_profit - $daily_exp;
                                  $total_operational_profit += $daily_operational_profit;
                                  ?>
                                  <tr>
                                      <td><?php echo $serial_number++; ?></td>
                                      <td><?= $current_date ?></td>
                                      <td><?= number_format($daily_sales, 2) ?> Tsh</td>
                                      <td><?= number_format($daily_cost, 2) ?> Tsh</td>
                                      <td><?= number_format($daily_gross_profit, 2) ?> Tsh</td>
                                      <td><?= number_format($daily_exp, 2) ?> Tsh</td>
                                      <td><?= number_format($daily_operational_profit, 2) ?> Tsh</td>
                                  </tr>
                                  <?php
                              }
                          } else {
                              ?>
                              <tr>
                                  <td colspan="6" class="no-data">Hakuna taharifa</td>
                              </tr>
                              <?php
                          }
                        }
                    }
                    ?>
                    </tbody>
                    <?php if($has_records) { ?>
                    <tfoot class="font-weight-bold">
                        <tr>
                            <td colspan="2" >Jumla Mkuu:</td>
                            <td><?= number_format($total_sales, 2) ?> Tsh</td>
                            <td><?= number_format($total_cost, 2) ?> Tsh</td>
                            <td><?= number_format($total_gross_profit, 2) ?> Tsh</td>
                            <td><?= number_format($total_expenditure, 2) ?> Tsh</td>
                            <td><?= number_format($total_operational_profit, 2) ?> Tsh</td>
                        </tr>
                    </tfoot>
                    <?php } ?>
                  </table>
                </div>
                
                <!-- Pagination -->
                <?php if(isset($total_pages) && $total_pages > 1 && $results_per_page != 999999): ?>
                <div class="pagination-container">
                  <div></div> <!-- Empty div for alignment -->
                  <nav aria-label="Page navigation">
                    <ul class="pagination">
                      <?php if($current_page > 1): ?>
                        <li class="page-item">
                          <a class="page-link" href="<?php echo buildUrl(['page' => $current_page - 1]); ?>">Previous</a>
                        </li>
                      <?php endif; ?>
                      
                      <?php 
                      // Show page numbers with ellipsis
                      $start_page = max(1, $current_page - 2);
                      $end_page = min($total_pages, $current_page + 2);
                      
                      if ($start_page > 1): ?>
                        <li class="page-item">
                          <a class="page-link" href="<?php echo buildUrl(['page' => 1]); ?>">1</a>
                        </li>
                        <?php if ($start_page > 2): ?>
                          <li class="page-item disabled"><span class="page-link">...</span></li>
                        <?php endif; ?>
                      <?php endif; ?>
                      
                      <?php for($i = $start_page; $i <= $end_page; $i++): ?>
                        <li class="page-item <?php echo ($i == $current_page) ? 'active' : ''; ?>">
                          <a class="page-link" href="<?php echo buildUrl(['page' => $i]); ?>"><?php echo $i; ?></a>
                        </li>
                      <?php endfor; ?>
                      
                      <?php if ($end_page < $total_pages): ?>
                        <?php if ($end_page < $total_pages - 1): ?>
                          <li class="page-item disabled"><span class="page-link">...</span></li>
                        <?php endif; ?>
                        <li class="page-item">
                          <a class="page-link" href="<?php echo buildUrl(['page' => $total_pages]); ?>"><?php echo $total_pages; ?></a>
                        </li>
                      <?php endif; ?>
                      
                      <?php if($current_page < $total_pages): ?>
                        <li class="page-item">
                          <a class="page-link" href="<?php echo buildUrl(['page' => $current_page + 1]); ?>">Next</a>
                        </li>
                      <?php endif; ?>
                    </ul>
                  </nav>
                  <div class="records-count">
                    <?php 
                    $start_record = $offset + 1;
                    $end_record = min($offset + $results_per_page, $total_results);
                    echo "Showing $start_record - $end_record of $total_results records";
                    ?>
                  </div>
                </div>
                <?php endif; ?>
                
                <div class="text-center mt-3">
                  <?php
                  // Build the query string for export parameters
                  $export_params = [
                    'd1' => isset($d1) ? $d1 : '',
                    'd2' => isset($d2) ? $d2 : '',
                    'created_by' => isset($created_by) ? $created_by : '',
                    'medicine' => isset($medicine) ? $medicine : '',
                    'category' => isset($category) ? $category : '',
                    'customer_name' => isset($customer_name) ? $customer_name : ''
                  ];
                  $query_string = http_build_query($export_params);
                  ?>
                  
                  <a href="export_operational_profit_excel.php?<?php echo $query_string; ?>" class="btn btn-success">
                    <i class="fas fa-file-excel"></i> Pakua katika Excel
                  </a>
                  
                  <a href="export_operational_profit_pdf.php?<?php echo $query_string; ?>" class="btn btn-danger">
                    <i class="fas fa-file-pdf"></i> Pakua katika PDF
                  </a>
                  
                  <button onclick="window.print()" class="btn btn-primary">
                    <i class="fas fa-print"></i> Print
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
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