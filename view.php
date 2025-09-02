<?php
include("session.php");

// Pagination settings
$records_per_page = isset($_GET['records_per_page']) ? (int)$_GET['records_per_page'] : 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;
$start_from = ($page-1) * $records_per_page;

// Get invoice_number from URL if it exists
$invoice_number = isset($_GET['invoice_number']) ? $_GET['invoice_number'] : '';

// Include database connection
include("dbcon.php");

// Get total number of records
$count_sql = "SELECT stores.location, COUNT(*) as total FROM stock 
JOIN stores ON stock.store_id = stores.id
WHERE store_id = $store_id ";
$count_result = mysqli_query($con, $count_sql);
$total_records = mysqli_fetch_assoc($count_result)['total'];

// Calculate total pages
$total_pages = ceil($total_records / $records_per_page);

// Get paginated data
$sql = "SELECT stock.id, bar_code, medicine_name, category, quantity, used_quantity, remain_quantity, 
               act_remain_quantity, register_date, expire_date, company, sell_type, actual_price, 
               selling_price, profit_price, status, stores.location
        FROM stock
        JOIN stores ON stock.store_id = stores.id
        WHERE stock.store_id = $store_id
        ORDER BY stock.id
        LIMIT $start_from, $records_per_page";

$result = mysqli_query($con, $sql);
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
  <style>
    .pagination {
      margin: 10px 0;
      display: inline-block;
    }
    .pagination a {
      color: #333;
      padding: 5px 10px;
      text-decoration: none;
      border: 1px solid #ddd;
      margin: 0 2px;
    }
    .pagination a.active {
      background-color: #007bff;
      color: white;
      border: 1px solid #007bff;
    }
    .pagination a:hover:not(.active) {
      background-color: #ddd;
    }
    .records-per-page {
      display: inline-block;
      margin-left: 10px;
    }
    .search-box {
      margin-bottom: 15px;
    }
  </style>
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
              <!-- breadcrumb items if needed -->
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
              
            </div>
            <div class="card">
              <div class="card-header">
                <h3 class="card-title"><b>Orodha ya Dawa zote zilizopo stoo</b></h3>
                
                <!-- Records per page selector -->
                <div class="float-right">
                  <select id="records_per_page" class="form-control form-control-sm records-per-page">
                    <option value="10" <?php echo $records_per_page == 10 ? 'selected' : ''; ?>>10</option>
                    <option value="25" <?php echo $records_per_page == 25 ? 'selected' : ''; ?>>25</option>
                    <option value="50" <?php echo $records_per_page == 50 ? 'selected' : ''; ?>>50</option>
                    <option value="100" <?php echo $records_per_page == 100 ? 'selected' : ''; ?>>100</option>
                    <option value="999999" <?php echo $records_per_page == 999999 ? 'selected' : ''; ?>>Zote</option>
                  </select>
                </div>
                
                <!-- Global search box -->
                <div class="float-right mr-2">
                  <div class="input-group input-group-sm search-box" style="width: 200px;">
                    <input type="text" id="globalSearch" class="form-control" placeholder="Tafuta...">
                    <div class="input-group-append">
                      <span class="input-group-text"><i class="fas fa-search"></i></span>
                    </div>
                  </div>
                </div>
              </div>
              
              <?php include ('modal_expenditure.php');?>
              
              <div class="card-body table-responsive">
                <div class="hero-unit-table">   
                  <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                      <tr class="table-success">          
                        <th width="3%">#</th>
                        <th width="3%">Dawa</th>
                        <th width="1%">Aina ya Dawa</th>
                        <th width="5%">Idadi iliyosajiriwa</th>
                        <th width="1%">Idadi iliyouzwa</th>
                        <th width="1%">Idadi iliyobaki</th>
                        <th width="1%">Tarehe iliyosajiliwa</th>
                        <th width="2%">Bei ya kununuliwa</th>
                        <th width="2%">Bei ya kuuzia</th>
                        <th width="2%">Faida</th>
                        <th width="2%">Tawi/kituo</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php 
                      $serial = $start_from + 1;
                      while ($row = mysqli_fetch_array($result)) :
                      ?>
                      <tr>
                        <td><?php echo $serial++; ?></td>
                        <td><?php echo htmlspecialchars($row['medicine_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['category']); ?></td>
                        <td><?php echo htmlspecialchars($row['quantity'])."&nbsp;&nbsp;(<strong><i>".htmlspecialchars($row['sell_type'])."</i></strong>)"; ?></td>
                        <td><?php echo htmlspecialchars($row['used_quantity']); ?></td>
                        <td><?php echo htmlspecialchars($row['act_remain_quantity']); ?></td>
                        <td><?php echo date("d-m-Y", strtotime($row['register_date'])); ?></td>
                        <td><?php echo number_format($row['actual_price']); ?></td>
                        <td><?php echo number_format($row['selling_price']); ?></td>
                        <td><?php echo $row['profit_price']; ?></td>
                        <td><?php echo $row['location']; ?></td>
                      </tr>
                      <?php endwhile; ?>
                    </tbody>
                  </table>
                  
                  <!-- Pagination -->
                  <div class="text-center">
                    <div class="pagination">
                      <?php if($page > 1): ?>
                        <a href="?invoice_number=<?php echo $invoice_number; ?>&page=1&records_per_page=<?php echo $records_per_page; ?>">Kwanza</a>
                        <a href="?invoice_number=<?php echo $invoice_number; ?>&page=<?php echo $page-1; ?>&records_per_page=<?php echo $records_per_page; ?>">Nyuma</a>
                      <?php endif; ?>
                      
                      <?php 
                      // Show limited page numbers around current page
                      $visible_pages = 5;
                      $start_page = max(1, $page - floor($visible_pages/2));
                      $end_page = min($total_pages, $start_page + $visible_pages - 1);
                      
                      if($start_page > 1) {
                          echo '<a href="?invoice_number='.$invoice_number.'&page=1&records_per_page='.$records_per_page.'">1</a>';
                          if($start_page > 2) echo '<span>...</span>';
                      }
                      
                      for($i = $start_page; $i <= $end_page; $i++): ?>
                          <a href="?invoice_number=<?php echo $invoice_number; ?>&page=<?php echo $i; ?>&records_per_page=<?php echo $records_per_page; ?>" <?php echo $i == $page ? 'class="active"' : ''; ?>>
                              <?php echo $i; ?>
                          </a>
                      <?php endfor; ?>
                      
                      <?php if($end_page < $total_pages): ?>
                          <?php if($end_page < $total_pages - 1) echo '<span>...</span>'; ?>
                          <a href="?invoice_number=<?php echo $invoice_number; ?>&page=<?php echo $total_pages; ?>&records_per_page=<?php echo $records_per_page; ?>">
                              <?php echo $total_pages; ?>
                          </a>
                      <?php endif; ?>
                      
                      <?php if($page < $total_pages): ?>
                        <a href="?invoice_number=<?php echo $invoice_number; ?>&page=<?php echo $page+1; ?>&records_per_page=<?php echo $records_per_page; ?>">Mbele</a>
                        <a href="?invoice_number=<?php echo $invoice_number; ?>&page=<?php echo $total_pages; ?>&records_per_page=<?php echo $records_per_page; ?>">Mwisho</a>
                      <?php endif; ?>
                    </div>
                    
                    <div class="mt-2">
                      Onyesha ukurasa <?php echo $page; ?> kati ya <?php echo $total_pages; ?> | Jumla ya Dawa: <?php echo $total_records; ?>
                    </div>
                  </div>
                  
                  <div class="export-buttons mt-3">
                    <a href="export_product_pdf.php" class="btn btn-danger">Pakua bei za Dawa</a>
                    <a href="export_stock_level.php" class="btn btn-danger">Pakua taharifa ya stoo</a>
                  </div>  
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
  
  <?php include("footer.php"); ?>
</div>

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

<script>
$(document).ready(function() {
  // Records per page change handler
  $('#records_per_page').change(function() {
    var records = $(this).val();
    window.location.href = '?invoice_number=<?php echo $invoice_number; ?>&records_per_page=' + records;
  });
  
  // Global search function
  $("#globalSearch").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#dataTables-example tbody tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
  
  // Initialize DataTable with Swahili language
  $('#dataTables-example').DataTable({
    "paging": false, // We use our custom pagination
    "searching": false, // We use our custom search
    "info": false,
    "language": {
      "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Swahili.json"
    }
  });
  
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