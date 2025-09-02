<?php
include("session.php");

// Get invoice_number from URL if it exists
$invoice_number = isset($_GET['invoice_number']) ? $_GET['invoice_number'] : '';

// Pagination settings
$records_per_page = isset($_GET['records_per_page']) ? (int)$_GET['records_per_page'] : 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start_from = ($page-1) * $records_per_page;

// Initialize search variables
$d1 = isset($_GET['d1']) ? $_GET['d1'] : '';
$d2 = isset($_GET['d2']) ? $_GET['d2'] : '';
$created_by = isset($_GET['created_by']) ? $_GET['created_by'] : '';
$company = isset($_GET['company']) ? $_GET['company'] : '';
$medicine_name = isset($_GET['medicine_name']) ? $_GET['medicine_name'] : '';
$category = isset($_GET['category']) ? $_GET['category'] : '';
$status = isset($_GET['status']) ? $_GET['status'] : '';
$store_location = isset($_GET['store_location']) ? $_GET['store_location'] : '';

// Check if search form was submitted
$search_submitted = isset($_GET['submit']);

// Function to generate URL with all parameters
function generateUrl($params = array()) {
    global $invoice_number, $store_location;
    $url = "purchases_report.php?";
    $existing_params = $_GET;
    $existing_params['store_location'] = $store_location;

    // Remove pagination parameters from existing params
    // Remove pagination and submit params
    unset($existing_params['page']);
    unset($existing_params['records_per_page']);
    unset($existing_params['submit']);
    
    // Preserve invoice_number if it exists
    if (!empty($invoice_number)) {
        $existing_params['invoice_number'] = $invoice_number;
    }
    // Explicitly include store_location if not already in the URL
    if (!isset($existing_params['store_location'])) {
        $existing_params['store_location'] = $store_location;
    }
     if (!empty($invoice_number)) {
        $existing_params['invoice_number'] = $invoice_number;
    }
    // Merge existing params with new params (new params override existing ones)
    $all_params = array_merge($existing_params, $params);
    
    // Merge and build URL
    $all_params = array_merge($existing_params, $params);
    foreach ($all_params as $key => $value) {
        $url .= "$key=" . urlencode($value) . "&";
    }

    return rtrim($url, "&");
}

include("dbcon.php");

// Build the base query - show all records by default
$select_sql = "SELECT purchases_report.*, stores.location FROM purchases_report 
               LEFT JOIN stores ON purchases_report.store_id = stores.id 
               WHERE 1=1";
$count_sql = "SELECT COUNT(*) as total FROM purchases_report 
              LEFT JOIN stores ON purchases_report.store_id = stores.id 
              WHERE 1=1";


// Apply date filters only if dates are provided and search was submitted
if ($search_submitted && !empty($d1) && !empty($d2)) {
    $select_sql .= " AND received_date BETWEEN '$d1' AND '$d2'";
    $count_sql .= " AND received_date BETWEEN '$d1' AND '$d2'";
}

// Apply other filters only if search was submitted
if ($search_submitted) {
    if (!empty($created_by)) {
        $select_sql .= " AND created_by LIKE '%$created_by%'";
        $count_sql .= " AND created_by LIKE '%$created_by%'";
    }
    if (!empty($company)) {
        $select_sql .= " AND company LIKE '%$company%'";
        $count_sql .= " AND company LIKE '%$company%'";
    }
    if (!empty($medicine_name)) {
        $select_sql .= " AND medicine_name LIKE '%$medicine_name%'";
        $count_sql .= " AND medicine_name LIKE '%$medicine_name%'";
    }
    if (!empty($category)) {
        $select_sql .= " AND category LIKE '%$category%'";
        $count_sql .= " AND category LIKE '%$category%'";
    }
    if (!empty($status)) {
        $select_sql .= " AND status LIKE '%$status%'";
        $count_sql .= " AND status LIKE '%$status%'";
    }
    if (!empty($store_location)) {
    $select_sql .= " AND stores.location LIKE '%$store_location%'";
    $count_sql .= " AND stores.location LIKE '%$store_location%'";
}
}

$select_sql .= " ORDER BY received_date DESC";

// Get total records count
$count_query = mysqli_query($con, $count_sql);
$total_records = mysqli_fetch_assoc($count_query)['total'];

// Add pagination to the query if not showing all records
if ($records_per_page != -1) {
    $select_sql .= " LIMIT $start_from, $records_per_page";
}

$select_query = mysqli_query($con, $select_sql);
$num_rows = mysqli_num_rows($select_query);

// Calculate total pages
if ($records_per_page == -1) {
    $total_pages = 1;
} else {
    $total_pages = ceil($total_records / $records_per_page);
}
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
    
    function changeRecordsPerPage() {
      var recordsPerPage = document.getElementById("records_per_page").value;
      var url = window.location.href.split('?')[0] + "?";
      var params = new URLSearchParams(window.location.search);
      
      // Update records_per_page parameter
      params.set('records_per_page', recordsPerPage);
      params.set('page', '1'); // Reset to first page
      
      window.location.href = url + params.toString();
    }
  </script>
  <style>
    .empty-state {
      text-align: center;
      padding: 20px;
      background-color: #f8f9fa;
      border-radius: 5px;
      margin: 20px 0;
    }
    .empty-state i {
      font-size: 50px;
      color: #6c757d;
      margin-bottom: 15px;
    }
    .empty-state p {
      margin-bottom: 5px;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
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
    .pagination-info {
      margin-top: 10px;
      font-size: 14px;
      color: #6c757d;
    }
    .table-responsive {
      overflow-x: auto;
      -webkit-overflow-scrolling: touch;
    }
    .table th, .table td {
      white-space: nowrap;
    }
  </style>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
   <a href="#" class="nav-link">Nyumbani</a>
   
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
              <!-- <li class="breadcrumb-item"><a href="#">Admin</a></li>
              <li class="breadcrumb-item active">Matumizi</li> -->
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
                <h3 class="card-title"><b>Ripoti ya Manunuzi</b></h3>
              </div>
              <!-- /.card-header -->
              <section class="content">
                <div class="container-fluid">
                  <div class="row">
                    <div class="col-12">
                      <div class="card">
                        <div class="card-header">
                          <center>
                            <!-- Changed form method to GET -->
                            <form action="<?php echo generateUrl(); ?>" method="GET" class="form-inline mb-4">
                              <input type="hidden" name="records_per_page" value="<?php echo $records_per_page; ?>">
                              <?php if (!empty($invoice_number)) : ?>
                                <input type="hidden" name="invoice_number" value="<?php echo $invoice_number; ?>">
                              <?php endif; ?>
                              <div class="form-group mb-4">
                                <label for="d1"><strong>Kuanzia Tarehe:</strong></label>
                                <input type="date" id="d1" name="d1" class="form-control ml-2" autocomplete="off" value="<?php echo $d1; ?>">
                              </div>
                              <div class="form-group ml-3 mb-4">
                                <label for="d2"><strong>Mbaka Tarehe:</strong></label>
                                <input type="date" id="d2" name="d2" class="form-control ml-2" autocomplete="off" value="<?php echo $d2; ?>">
                              </div>
                              <div class="form-group ml-3 mb-4">
                                 <label for="created_by" class="sr-only">Purchase Recorder:</label>
                                 <input type="text" id="created_by" name="created_by" class="form-control" placeholder="Aliyerekodi" autocomplete="off" value="<?php echo $created_by; ?>">
                               </div>
                               <div class="form-group ml-3 mb-4">
                                  <label for="customer_name" class="sr-only">Company:</label>
                                  <input type="text" id="company" name="company" class="form-control" placeholder="Jina la mkulima" autocomplete="off" value="<?php echo $company; ?>">
                               </div>
                               <div class="form-group ml-3 mb-4">
                                  <label for="medicine" class="sr-only">Medicine name:</label>
                                  <input type="text" id="medicine_name" name="medicine_name" class="form-control" placeholder="Jina la Dawa" autocomplete="off" value="<?php echo $medicine_name; ?>">
                               </div>
                               <div class="form-group ml-3 mb-4">
                                   <label for="category" class="sr-only">Medicine category:</label>
                                   <input type="text" id="category" name="category" class="form-control" placeholder="Aina ya Dawa" autocomplete="off" value="<?php echo $category; ?>">
                               </div>
                               <div class="form-group ml-3 mb-4">
                                    <label for="status" class="sr-only">Payment status:</label>
                                    <input type="text" id="status" name="status" class="form-control" placeholder="Hali ya malipo" autocomplete="off" value="<?php echo $status; ?>">
                               </div>
                               <div class="form-group ml-3 mb-4">
  <label for="store_location" class="sr-only">Mahali:</label>
  <input type="text" id="store_location" name="store_location" class="form-control" placeholder="Mahali/Tawi" autocomplete="off" value="<?php echo isset($_GET['store_location']) ? $_GET['store_location'] : ''; ?>">
</div>
                               <div class="form-group ml-3 mb-4">
                                    <button class="btn btn-info" type="submit" name="submit"><i class="icon icon-search icon-large"></i> Tafuta</button>
                                    <?php if ($search_submitted) : ?>
                                    <a href="purchases_report.php<?php echo !empty($invoice_number) ? '?invoice_number='.urlencode($invoice_number) : ''; ?>" class="btn btn-secondary ml-2">Ondoa Vichujio</a>
                                    <?php endif; ?>
                               </div>
                            </form>
                          </center>
                          
                          <!-- Records per page selector -->
                          <div class="records-per-page">
                            <label for="records_per_page">Rekodi kwa kila ukurasa:</label>
                            <select id="records_per_page" class="form-control form-control-sm" style="width: 80px;" onchange="changeRecordsPerPage()">
                              <option value="10" <?php echo $records_per_page == 10 ? 'selected' : ''; ?>>10</option>
                              <option value="25" <?php echo $records_per_page == 25 ? 'selected' : ''; ?>>25</option>
                              <option value="50" <?php echo $records_per_page == 50 ? 'selected' : ''; ?>>50</option>
                              <option value="100" <?php echo $records_per_page == 100 ? 'selected' : ''; ?>>100</option>
                              <option value="-1" <?php echo $records_per_page == -1 ? 'selected' : ''; ?>>Zote</option>
                            </select>
                          </div>
                          
                          <div class="table-responsive">
                            <?php if ($num_rows > 0) : ?>
                            <table class="table table-bordered table-striped table-hover">
                              <thead>
                              <tr class="table-success">
                                <th>#</th>
                                <th>Tarehe ya iliyopokelewa</th>
                                <th>Dawa</th>
                               <th>Tawi/Mahali</th>
                                <th>Idadi ya zamani</th>
                                <th>Idadi iliyopokelewa</th>
                                <th>Bei kwa Dawa</th>
                                <th>Jumla </th>
                                <th>Faida inayotarajiwa</th>
                                <th>Msambazaji</th>
                                <th>Aliyerekodi</th>
                                <th>Hali ya malipo</th>
                              </tr>
                              </thead>
                              <tbody>
                                <?php 
                                $counter = ($page - 1) * $records_per_page + 1;
                                while($row = mysqli_fetch_array($select_query)) : ?>
                                <tr> 
                                  <td><?php echo $counter++; ?></td>
                                  <td><?php echo $row['received_date'] ?></td>
                                  <td><?php echo $row['medicine_name'] ?></td>
                                  <td><?php echo $row['location'] ?></td>
                                  <td><?php echo $row['old_quantity'] ?></td>
                                  <td><?php echo $row['received_quantity'] ?></td>
                                  <td><?php echo number_format($row['actual_price']) ?></td> 
                                  <td><?php echo number_format($row['received_quantity'] * $row['actual_price']) ?></td> 
                                  <td><?php echo number_format($row['expected_profit']) ?></td>
                                  <td><?php echo $row['company'] ?></td>
                                  <td><?php echo $row['created_by'] ?></td>
                                  <td><?php echo $row['status'] ?></td>
                                </tr>
                                <?php endwhile; ?>
                              </tbody>
                              <tfoot>
                                <tr>
                                  <th colspan="7">Jumla:</th>
                                  <th>
                                    <?php
                                    $sum_sql = "SELECT SUM(received_quantity * actual_price) as total_sum FROM purchases_report 
            LEFT JOIN stores ON purchases_report.store_id = stores.id 
            WHERE 1=1";
                                    
                                    if ($search_submitted && !empty($d1) && !empty($d2)) {
                                        $sum_sql .= " AND received_date BETWEEN '$d1' AND '$d2'";
                                    }
                                    
                                    if ($search_submitted) {
                                        if (!empty($created_by)) {
                                            $sum_sql .= " AND created_by LIKE '%$created_by%'";
                                        }
                                        if (!empty($company)) {
                                            $sum_sql .= " AND company LIKE '%$company%'";
                                        }
                                        if (!empty($medicine_name)) {
                                            $sum_sql .= " AND medicine_name LIKE '%$medicine_name%'";
                                        }
                                        if (!empty($category)) {
                                            $sum_sql .= " AND category LIKE '%$category%'";
                                        }
                                        if (!empty($status)) {
                                            $sum_sql .= " AND status LIKE '%$status%'";
                                        }
                                        if (!empty($store_location)) {
    $sum_sql .= " AND stores.location LIKE '%$store_location%'";
}

                                    }
                                    
                                    $sum_query = mysqli_query($con, $sum_sql);
                                    $sum_row = mysqli_fetch_assoc($sum_query);
                                    echo number_format($sum_row['total_sum']).' Tsh';
                                    ?>
                                  </th>
                                  <th colspan="4"></th>
                                </tr>
                              </tfoot>
                            </table>
                            
                            <!-- Pagination -->
                            <div class="row">
                              <div class="col-md-6">
                                <div class="pagination-info">
                                  Onyesho <?php echo ($start_from + 1); ?> hadi <?php echo min($start_from + $records_per_page, $total_records); ?> ya <?php echo $total_records; ?> rekodi
                                </div>
                              </div>
                              <div class="col-md-6">
                                <nav aria-label="Page navigation">
                                  <ul class="pagination justify-content-end">
                                    <?php if ($page > 1) : ?>
                                      <li class="page-item">
                                        <a class="page-link" href="<?php echo generateUrl(array('page' => $page-1)); ?>" aria-label="Previous">
                                          <span aria-hidden="true">&laquo;</span>
                                        </a>
                                      </li>
                                    <?php endif; ?>
                                    
                                    <?php 
                                    // Show page numbers
                                    $visible_pages = 5;
                                    $half = floor($visible_pages / 2);
                                    $start_page = max(1, $page - $half);
                                    $end_page = min($total_pages, $start_page + $visible_pages - 1);
                                    
                                    if ($start_page > 1) {
                                      echo '<li class="page-item"><a class="page-link" href="'.generateUrl(array('page' => 1)).'">1</a></li>';
                                      if ($start_page > 2) {
                                        echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                                      }
                                    }
                                    
                                    for ($i = $start_page; $i <= $end_page; $i++) {
                                      $active = ($i == $page) ? 'active' : '';
                                      echo '<li class="page-item '.$active.'"><a class="page-link" href="'.generateUrl(array('page' => $i)).'">'.$i.'</a></li>';
                                    }
                                    
                                    if ($end_page < $total_pages) {
                                      if ($end_page < $total_pages - 1) {
                                        echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                                      }
                                      echo '<li class="page-item"><a class="page-link" href="'.generateUrl(array('page' => $total_pages)).'">'.$total_pages.'</a></li>';
                                    }
                                    ?>
                                    
                                    <?php if ($page < $total_pages) : ?>
                                      <li class="page-item">
                                        <a class="page-link" href="<?php echo generateUrl(array('page' => $page+1)); ?>" aria-label="Next">
                                          <span aria-hidden="true">&raquo;</span>
                                        </a>
                                      </li>
                                    <?php endif; ?>
                                  </ul>
                                </nav>
                              </div>
                            </div>
                            
                            <center>
                              <div class="export-buttons">
<a href="export_purchases_excel.php?<?php echo http_build_query($_GET); ?>" class="btn btn-success">Pakua katika Excel</a>
<a href="export_purchases_pdf.php?<?php echo http_build_query($_GET); ?>" class="btn btn-danger">Pakua katika PDF</a>

                              </div>
                            </center>
                            
                            <?php else : ?>
                              <div class="empty-state">
                                <i class="fas fa-database"></i>
                                <h4>Hakuna taharifa yeyote</h4>
                                <p>Hakuna rekodi zilizopatikana kwa mujibu wa vichujio vilivyowekwa</p>
                                <p>Badilisha vichujio na ujaribu tena</p>
                              </div>
                            <?php endif; ?>
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