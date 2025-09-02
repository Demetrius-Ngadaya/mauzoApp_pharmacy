<?php
include("session.php");

// Pagination settings
$records_per_page = isset($_GET['records_per_page']) ? (int)$_GET['records_per_page'] : 10;
if (!in_array($records_per_page, [10, 25, 50, 100, 999999])) {
    $records_per_page = 10;
}

// Get current page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) {
    $page = 1;
}

// Initialize variables from GET or POST
$d1 = isset($_REQUEST['d1']) ? $_REQUEST['d1'] : '';
$d2 = isset($_REQUEST['d2']) ? $_REQUEST['d2'] : '';
$created_by = isset($_REQUEST['created_by']) ? $_REQUEST['created_by'] : '';
$customer_name = isset($_REQUEST['customer_name']) ? $_REQUEST['customer_name'] : '';
$medicine = isset($_REQUEST['medicine']) ? $_REQUEST['medicine'] : '';
$category = isset($_REQUEST['category']) ? $_REQUEST['category'] : '';
$invoice_number = isset($_GET['invoice_number']) ? $_GET['invoice_number'] : '';

// Build base URL for pagination
$base_url = "gross_profit_report.php?invoice_number=$invoice_number";
$filter_params = [
    'd1' => $d1,
    'd2' => $d2,
    'created_by' => $created_by,
    'customer_name' => $customer_name,
    'medicine' => $medicine,
    'category' => $category
];
$query_string = http_build_query(array_filter($filter_params));
$base_url .= $query_string ? '&' . $query_string : '';
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
      width: 10%;
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
    /* Prevent text wrapping */
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
      flex-wrap: wrap;
    }
    .records-per-page {
      display: flex;
      align-items: center;
      margin-bottom: 10px;
    }
    .records-per-page select {
      margin: 0 10px;
    }
    .pagination {
      flex-wrap: wrap;
      margin-bottom: 10px;
    }
    .page-item.active .page-link {
      z-index: 1;
      color: #fff;
      background-color: #007bff;
      border-color: #007bff;
    }
    .page-link {
      position: relative;
      display: block;
      padding: 0.5rem 0.75rem;
      margin-left: -1px;
      line-height: 1.25;
      color: #007bff;
      background-color: #fff;
      border: 1px solid #dee2e6;
    }
    .records-count {
      margin-bottom: 10px;
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
        var records = $(this).val();
        window.location.href = '<?php echo $base_url; ?>&records_per_page=' + records + '&page=1';
      });
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
                <h3 class="card-title"><b>Ripoti ya Faida kwa Dawa</b></h3>
              </div>
              <div class="card-body">
                <form action="gross_profit_report.php?invoice_number=<?php echo $invoice_number ?>" method="POST" class="form-inline">
                  <div class="form-group">
                    <label for="d1" class="sr-only">Kuanzia Tarehe:</label>
                    <input type="date" id="d1" name="d1" class="form-control" placeholder="Kuanzia Tarehe" autocomplete="off" value="<?php echo $d1 ?>">
                  </div>
                  <div class="form-group">
                    <label for="d2" class="sr-only">Mbaka Tarehe:</label>
                    <input type="date" id="d2" name="d2" class="form-control" placeholder="Mbaka Tarehe" autocomplete="off" value="<?php echo $d2 ?>">
                  </div>
                  <div class="form-group">
                    <label for="created_by" class="sr-only">Aliyeuza:</label>
                    <input type="text" id="created_by" name="created_by" class="form-control" placeholder="Aliyeuza" autocomplete="off" value="<?php echo $created_by ?>">
                  </div>
                  <div class="form-group">
                    <label for="customer_name" class="sr-only">Mteja:</label>
                    <input type="text" id="customer_name" name="customer_name" class="form-control" placeholder="Mteja" autocomplete="off" value="<?php echo $customer_name ?>">
                  </div>
                  <div class="form-group">
                    <label for="medicine" class="sr-only">Dawa:</label>
                    <input type="text" id="medicine" name="medicine" class="form-control" placeholder="Dawa" autocomplete="off" value="<?php echo $medicine ?>">
                  </div>
                  <div class="form-group">
                    <label for="category" class="sr-only">Aina ya Dawa:</label>
                    <input type="text" id="category" name="category" class="form-control" placeholder="Aina ya Dawa" autocomplete="off" value="<?php echo $category ?>">
                  </div>
                  <div class="form-group">
                    <button class="btn btn-info" type="submit" name="submit"><i class="icon icon-search icon-large"></i> Tafuta</button>
                  </div>
                </form>
                
                <!-- Records per page selector -->
                <div class="records-per-page">
                  <label for="records_per_page">Rekodi kwa kila ukurasa:</label>
                  <select id="records_per_page" class="form-control">
                    <option value="10" <?php echo $records_per_page == 10 ? 'selected' : ''; ?>>10</option>
                    <option value="25" <?php echo $records_per_page == 25 ? 'selected' : ''; ?>>25</option>
                    <option value="50" <?php echo $records_per_page == 50 ? 'selected' : ''; ?>>50</option>
                    <option value="100" <?php echo $records_per_page == 100 ? 'selected' : ''; ?>>100</option>
                    <option value="999999" <?php echo $records_per_page == 999999 ? 'selected' : ''; ?>>Zote</option>
                  </select>
                </div>
                
                <div class="table-responsive">
                  <table class="table table-bordered table-striped table-hover">
                    <thead>
                      <tr class="table-success">
                        <th>#</th>
                        <th>Jina la Dawa</th>
                        <th>Aina ya Dawa</th>
                        <th>Mauzo kwa Dawa</th>
                        <th>Gharama kwa Dawa</th>
                        <th>Faida kwa Dawa</th>
                        <th>Jumla Ndogo Mauzo</th>
                        <th>Jumla Ndogo Gharama</th>
                        <th>Jumla Ndogo Faida</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php
                    include("dbcon.php");
                    error_reporting(1);

                    // Initialize totals
                    $total_gross_sales = 0;
                    $total_gross_cost = 0;
                    $total_gross_profit = 0;
                    $has_records = false;
                    $total_records = 0;
                    $total_pages = 1;

                    // Check if form is submitted or default view
                    $is_search = isset($_POST['submit']) || isset($_GET['d1']) || isset($_GET['d2']) || 
                                isset($_GET['created_by']) || isset($_GET['customer_name']) || 
                                isset($_GET['medicine']) || isset($_GET['category']);

                    // First get cost data in a separate query
                    $cost_query = "SELECT 
                        pr.medicine_name,
                        SUM(pr.total_cost) as total_cost
                    FROM purchases_report pr
                    WHERE 1=1";
                    
                    $cost_query .= " GROUP BY pr.medicine_name";
                    
                    $cost_result = mysqli_query($con, $cost_query);
                    $cost_data = [];
                    while($row = mysqli_fetch_assoc($cost_result)) {
                        $cost_data[$row['medicine_name']] = $row['total_cost'];
                    }

                    // Build sales query with filters
                    $select_sql = "SELECT 
                        s.medicines,
                        s.category,
                        SUM(s.quantity) as total_quantity,
                        SUM(s.total_amount) as total_sales
                    FROM sales s
                    WHERE 1=1";
                    
                    if (!empty($d1)) {
                      $select_sql .= " AND s.Date >= '$d1'";
                    }
                    if (!empty($d2)) {
                      $select_sql .= " AND s.Date <= '$d2'";
                    }
                    if (!empty($created_by)) {
                      $select_sql .= " AND s.created_by LIKE '%$created_by%'";
                    }
                    if (!empty($customer_name)) {
                      $select_sql .= " AND s.customer_name LIKE '%$customer_name%'";
                    }
                    if (!empty($medicine)) {
                      $select_sql .= " AND s.medicines LIKE '%$medicine%'";
                    }
                    if (!empty($category)) {
                      $select_sql .= " AND s.category LIKE '%$category%'";
                    }
                    
                    $select_sql .= " GROUP BY s.medicines, s.category";
                    $select_sql .= " ORDER BY s.medicines ASC";
                    
                    // Get total records count for pagination
                    $count_sql = "SELECT COUNT(DISTINCT CONCAT(s.medicines, s.category)) as total FROM sales s WHERE 1=1";
                    if (!empty($d1)) {
                      $count_sql .= " AND s.Date >= '$d1'";
                    }
                    if (!empty($d2)) {
                      $count_sql .= " AND s.Date <= '$d2'";
                    }
                    if (!empty($created_by)) {
                      $count_sql .= " AND s.created_by LIKE '%$created_by%'";
                    }
                    if (!empty($customer_name)) {
                      $count_sql .= " AND s.customer_name LIKE '%$customer_name%'";
                    }
                    if (!empty($medicine)) {
                      $count_sql .= " AND s.medicines LIKE '%$medicine%'";
                    }
                    if (!empty($category)) {
                      $count_sql .= " AND s.category LIKE '%$category%'";
                    }
                    
                    $count_query = mysqli_query($con, $count_sql);
                    $count_row = mysqli_fetch_assoc($count_query);
                    $total_records = $count_row['total'];
                    
                    // Calculate total pages
                    $total_pages = $records_per_page > 0 ? ceil($total_records / $records_per_page) : 1;
                    if ($page > $total_pages && $total_pages > 0) {
                        $page = $total_pages;
                    }
                    
                    // Add pagination to query
                    $offset = ($page - 1) * $records_per_page;
                    if ($records_per_page > 0 && $records_per_page != 999999) {
                        $select_sql .= " LIMIT $offset, $records_per_page";
                    }
                    
                    $select_query = mysqli_query($con, $select_sql);
                    
                    if(mysqli_num_rows($select_query) > 0) {
                        $has_records = true;
                        $serial_number = $offset + 1;
                        while($row = mysqli_fetch_array($select_query)) {
                            $unit_price = ($row['total_quantity'] > 0) ? $row['total_sales'] / $row['total_quantity'] : 0;
                            
                            // Get cost from pre-fetched data
                            $total_cost = $cost_data[$row['medicines']] ?? 0;
                            $unit_cost = ($row['total_quantity'] > 0 && $total_cost > 0) ? $total_cost / $row['total_quantity'] : 0;
                            
                            $unit_profit = $unit_price - $unit_cost;
                            
                            $subtotal_sales = $row['total_sales'];
                            $subtotal_cost = $unit_cost * $row['total_quantity'];
                            $subtotal_profit = $unit_profit * $row['total_quantity'];
                            
                            $total_gross_sales += $subtotal_sales;
                            $total_gross_cost += $subtotal_cost;
                            $total_gross_profit += $subtotal_profit;
                      ?>
                      <tr>
                        <td><?php echo $serial_number++; ?></td>
                        <td><?php echo htmlspecialchars($row['medicines']); ?></td>
                        <td><?php echo htmlspecialchars($row['category']); ?></td>
                        <td><?php echo number_format($unit_price, 2); ?></td>
                        <td><?php echo number_format($unit_cost, 2); ?></td>
                        <td><?php echo number_format($unit_profit, 2); ?></td>
                        <td><?php echo number_format($subtotal_sales, 2); ?></td>
                        <td><?php echo number_format($subtotal_cost, 2); ?></td>
                        <td><?php echo number_format($subtotal_profit, 2); ?></td>
                      </tr>
                      <?php }
                    } else {
                      ?>
                      <tr>
                        <td colspan="9" class="no-data">Hakuna taharifa</td>
                      </tr>
                      <?php
                    } ?>
                    </tbody>
                    
                    <?php if($has_records) { ?>
                    <tfoot>
                      <tr>
                        <th colspan="6">Jumla Mkuu:</th>
                        <th><?php echo number_format($total_gross_sales, 2) . ' Tsh'; ?></th>
                        <th><?php echo number_format($total_gross_cost, 2) . ' Tsh'; ?></th>
                        <th><?php echo number_format($total_gross_profit, 2) . ' Tsh'; ?></th>
                      </tr>
                    </tfoot>
                    <?php } ?>
                  </table>
                </div>
                
                <!-- Pagination -->
                <?php if ($has_records && $total_pages > 1 && $records_per_page != 999999) { ?>
                <div class="pagination-container">
                  <div class="records-count">
                    <?php 
                    $start_record = $offset + 1;
                    $end_record = min($offset + $records_per_page, $total_records);
                    echo "Onyesha $start_record - $end_record ya $total_records rekodi";
                    ?>
                  </div>
                  
                  <nav aria-label="Page navigation">
                    <ul class="pagination">
                      <?php if ($page > 1): ?>
                        <li class="page-item">
                          <a class="page-link" href="<?php echo $base_url; ?>&records_per_page=<?php echo $records_per_page; ?>&page=1" aria-label="First">
                            <span aria-hidden="true">&laquo;&laquo;</span>
                          </a>
                        </li>
                        <li class="page-item">
                          <a class="page-link" href="<?php echo $base_url; ?>&records_per_page=<?php echo $records_per_page; ?>&page=<?php echo $page - 1; ?>" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                          </a>
                        </li>
                      <?php endif; ?>
                      
                      <?php 
                      // Always show first page if not in initial range
                      if ($page > 3) {
                          echo '<li class="page-item"><a class="page-link" href="'.$base_url.'&records_per_page='.$records_per_page.'&page=1">1</a></li>';
                          if ($page > 4) {
                              echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                          }
                      }
                      
                      // Show pages around current page
                      $start = max(1, $page - 2);
                      $end = min($total_pages, $page + 2);
                      
                      for ($i = $start; $i <= $end; $i++) {
                          if ($i == $page) {
                              echo '<li class="page-item active"><span class="page-link">'.$i.'</span></li>';
                          } else {
                              echo '<li class="page-item"><a class="page-link" href="'.$base_url.'&records_per_page='.$records_per_page.'&page='.$i.'">'.$i.'</a></li>';
                          }
                      }
                      
                      // Always show last page if not in current range
                      if ($page < $total_pages - 2) {
                          if ($page < $total_pages - 3) {
                              echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                          }
                          echo '<li class="page-item"><a class="page-link" href="'.$base_url.'&records_per_page='.$records_per_page.'&page='.$total_pages.'">'.$total_pages.'</a></li>';
                      }
                      ?>
                      
                      <?php if ($page < $total_pages): ?>
                        <li class="page-item">
                          <a class="page-link" href="<?php echo $base_url; ?>&records_per_page=<?php echo $records_per_page; ?>&page=<?php echo $page + 1; ?>" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                          </a>
                        </li>
                        <li class="page-item">
                          <a class="page-link" href="<?php echo $base_url; ?>&records_per_page=<?php echo $records_per_page; ?>&page=<?php echo $total_pages; ?>" aria-label="Last">
                            <span aria-hidden="true">&raquo;&raquo;</span>
                          </a>
                        </li>
                      <?php endif; ?>
                    </ul>
                  </nav>
                </div>
                <?php } ?>
                
                <center>
                  <div class="export-buttons">
                    <?php
                    $export_params = [
                        'd1' => $d1,
                        'd2' => $d2,
                        'created_by' => $created_by,
                        'medicine' => $medicine,
                        'category' => $category,
                        'customer_name' => $customer_name
                    ];
                    $query_string = http_build_query(array_filter($export_params));
                    ?>
                    <a href="export_gross_profit_excel.php?<?php echo $query_string; ?>" class="btn btn-success">
                        <i class="fas fa-file-excel"></i> Pakua katika Excel
                    </a>
                    <a href="export_gross_profit_pdf.php?<?php echo $query_string; ?>" class="btn btn-danger">
                        <i class="fas fa-file-pdf"></i> Pakua katika PDF
                    </a>
                    <button onclick="window.print()" class="btn btn-primary">
                        <i class="fas fa-print"></i> Print
                    </button>
                  </div>
                </center>
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