<?php
include("session.php");

// Get invoice number from URL
$invoice_number = isset($_GET['invoice_number']) ? $_GET['invoice_number'] : '';
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
    .pagination {
      justify-content: center;
      margin-top: 20px;
    }
    .pagination li {
      margin: 0 5px;
    }
    .pagination li a {
      padding: 5px 10px;
      border: 1px solid #ddd;
    }
    .pagination li.active a {
      background-color: #007bff;
      color: white;
      border-color: #007bff;
    }
    .records-per-page {
      display: flex;
      align-items: center;
      margin-bottom: 15px;
    }
    .records-per-page label {
      margin-right: 10px;
      margin-bottom: 0;
    }
    .records-per-page select {
      width: auto;
    }
    /* Prevent text wrapping */
    .table td, .table th {
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }
    /* Make table horizontally scrollable */
    .table-responsive {
      overflow-x: auto;
      -webkit-overflow-scrolling: touch;
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
              <div class="card-header">
                <h3 class="card-title"><b>Ripoti ya mauzo</b></h3>
              </div>
              <!-- /.card-header -->
              <section class="content">
                <div class="container-fluid">
                  <div class="row">
                    <div class="col-12">
                      <div class="card">
                        <div class="card-header">
                          <center>
                          <form action="sales_report.php?invoice_number=<?php echo $invoice_number; ?>" method="POST" class="form-inline">
                            <div class="form-group">
                              <label for="d1" class="sr-only">Kuanzia Tarehe:</label>
                              <input type="date" id="d1" name="d1" class="form-control" placeholder="Kuanzia Tarehe" autocomplete="off">
                            </div>
                            <div class="form-group">
                              <label for="d2" class="sr-only">Mbaka Tarehe:</label>
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
                              <label for="medicine" class="sr-only">Dawa:</label>
                              <input type="text" id="medicine" name="medicine" class="form-control" placeholder="Dawa" autocomplete="off">
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
                            <div class="form-group">
                              <button class="btn btn-info" type="submit" name="submit"><i class="icon icon-search icon-large"></i> Tafuta</button>
                            </div>
                            <div class="form-group">
                               <label for="store_location" class="sr-only">Kituo/Tawi:</label>
                              <input type="text" id="store_location" name="store_location" class="form-control" placeholder="Mahali pa duka" autocomplete="off">
                          </div>
                          </form>
                          </center>
                          <div class="table-responsive">
                            <!-- Records per page selector -->
                            <div class="records-per-page">
                              <label for="records_per_page">Rekodi kwa kila ukurasa:</label>
                              <select id="records_per_page" class="form-control">
                                <option value="10" <?php echo (isset($_GET['per_page'])) && $_GET['per_page'] == 10 ? 'selected' : ''; ?>>10</option>
                                <option value="25" <?php echo (isset($_GET['per_page'])) && $_GET['per_page'] == 25 ? 'selected' : ''; ?>>25</option>
                                <option value="50" <?php echo (isset($_GET['per_page'])) && $_GET['per_page'] == 50 ? 'selected' : ''; ?>>50</option>
                                <option value="100" <?php echo (isset($_GET['per_page'])) && $_GET['per_page'] == 100 ? 'selected' : ''; ?>>100</option>
                                <option value="999999" <?php echo (isset($_GET['per_page']) )&& $_GET['per_page'] == 999999 ? 'selected' : ''; ?>>All</option>
                              </select>
                            </div>
                            
                            <table class="table table-bordered table-striped table-hover">
                              <thead>
                                <tr class="table-success">
                                  <th>#</th>
                                  <th>Tarehe</th>
                                  <th>Dawa</th>
                                  <th>Idadi</th>
                                  <th>Kiasi</th>
                                  <th>Faida</th>
                                  <th>Aliyeuza</th>
                                  <th>Mteja</th>
                                  <th>Njia ya malipo</th>
                                  <th>Hali ya malipo</th>
                                  <th>Tawi/Kituo</th>
                                </tr>
                              </thead>
                              <?php
                              include("dbcon.php");
                              error_reporting(1);

                              // Initialize totals
                              $total_quantity = 0;
                              $total_amount = 0;
                              $total_profit = 0;

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
                                $url = 'sales_report.php?';
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

                              // Initialize SQL query to show all sales by default
                              
                              $select_sql = "SELECT sales.*, stores.location FROM sales 
                              JOIN stores ON sales.store_id = stores.id 
                              WHERE 1=1";


                              
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

                                
                                // Store search parameters in session to maintain them across pagination
                                $_SESSION['search_params'] = $_POST;

                                if (!empty($d1) && !empty($d2)) {
                                  $select_sql .= " AND Date BETWEEN '$d1' AND '$d2'";
                                }
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

                              } elseif (isset($_SESSION['search_params'])) {
                                // Use session parameters if they exist
                                $d1 = $_SESSION['search_params']['d1'];
                                $d2 = $_SESSION['search_params']['d2'];
                                $created_by = $_SESSION['search_params']['created_by'];
                                $customer_name = $_SESSION['search_params']['customer_name'];
                                $medicine = $_SESSION['search_params']['medicine'];
                                $category = $_SESSION['search_params']['category'];
                                $hali_ya_malipo = $_SESSION['search_params']['hali_ya_malipo'];
                                $payment_method = $_SESSION['search_params']['payment_method'];
                                $store_location = $_SESSION['search_params']['store_location'];

                                if (!empty($d1) && !empty($d2)) {
                                  $select_sql .= " AND Date BETWEEN '$d1' AND '$d2'";
                                }
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
                              }
                              
                              $select_sql .= " ORDER BY Date DESC";
                              
                              // Count total results for pagination
                              $count_query = mysqli_query($con, $select_sql);
                              $total_results = mysqli_num_rows($count_query);
                              $total_pages = ceil($total_results / $results_per_page);
                              
                              // Add limit for pagination if not showing all records
                              if ($results_per_page != 999999) {
                                $select_sql .= " LIMIT $offset, $results_per_page";
                              }
                              
                              $select_query = mysqli_query($con, $select_sql);
                              
                              // Initialize serial number
                              $serial_number = $offset + 1;
                              
                              while($row = mysqli_fetch_array($select_query)) :
                                $total_quantity += $row['quantity'];
                                $total_amount += $row['total_amount'];
                                $total_profit += $row['total_profit'];
                              ?>
                              <tbody>
                                <tr>
                                  <td><?php echo $serial_number++; ?></td>
                                  <td><?php echo $row['Date']?><?php echo (date('Y-m-d')) == $row['Date'] ? '&nbsp;&nbsp;(<font size="2" color="#009688;">Leo</font>)' : ''; ?></td>
                                  <td><?php echo $row['medicines']?></td>
                                  <td><?php echo $row['quantity']?></td>
                                  <td><?php echo number_format($row['total_amount'])?></td>
                                  <td><?php echo number_format($row['total_profit'])?></td>
                                  <td><?php echo $row['created_by']?></td>
                                  <td><?php echo $row['customer_name']?></td>
                                  <td><?php echo $row['payment_method']?></td>
                                  <td><?php echo $row['hali_ya_malipo']?></td>
                                  <td><?php echo $row['location']?></td>
                                </tr>
                              </tbody>
                              <?php endwhile;?>
                              <tfoot>
                                <tr>
                                  <th colspan="3">Jumla Kuu:</th>
                                  <th><?php echo number_format($total_quantity); ?></th>
                                  <th><?php echo number_format($total_amount) . ' Tsh'; ?></th>
                                  <th><?php echo number_format($total_profit ). ' Tsh'; ?></th>
                                  <th colspan="4"></th>
                                </tr>
                              </tfoot>
                            </table>
                            
                            <!-- Pagination links -->
                            <?php if(isset($total_pages) && $total_pages > 1 && $results_per_page != 999999): ?>
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
                            <?php endif; ?>
                            
                            <center>
                              <div class="export-buttons">
                                <a href="export_sales_excel.php?d1=<?php echo isset($d1) ? $d1 : ''; ?>&store_location=<?php echo isset($store_location) ? $store_location : ''; ?>
 &d2=<?php echo isset($d2) ? $d2 : ''; ?>&created_by=<?php echo isset($created_by) ? $created_by : ''; ?>&medicine=<?php echo isset($medicine) ? $medicine : ''; ?>&category=<?php echo isset($category) ? $category : ''; ?>" class="btn btn-success">Pakua katika Excel</a>
                                <a href="export_sales_pdf.php?d1=<?php echo isset($d1) ? $d1 : ''; ?> &store_location=<?php echo isset($store_location) ? $store_location : ''; ?>
 &d2=<?php echo isset($d2) ? $d2 : ''; ?>&created_by=<?php echo isset($created_by) ? $created_by : ''; ?>&medicine=<?php echo isset($medicine) ? $medicine : ''; ?>&category=<?php echo isset($category) ? $category : ''; ?>" class="btn btn-danger">Pakua katika PDF</a>
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