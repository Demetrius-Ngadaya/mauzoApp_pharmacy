<?php
include("session.php");
include("dbcon.php");
error_reporting(1);

// Pagination variables
$records_per_page = isset($_GET['per_page']) ? $_GET['per_page'] : 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;

// Search filters - get from both POST and GET
$d1 = isset($_POST['d1']) ? $_POST['d1'] : (isset($_GET['d1']) ? $_GET['d1'] : '');
$d2 = isset($_POST['d2']) ? $_POST['d2'] : (isset($_GET['d2']) ? $_GET['d2'] : '');
$deleted_by = isset($_POST['deleted_by']) ? $_POST['deleted_by'] : (isset($_GET['deleted_by']) ? $_GET['deleted_by'] : '');
$medicine_name = isset($_POST['medicine_name']) ? $_POST['medicine_name'] : (isset($_GET['medicine_name']) ? $_GET['medicine_name'] : '');
$category = isset($_POST['category']) ? $_POST['category'] : (isset($_GET['category']) ? $_GET['category'] : '');
$invoice_number = isset($_GET['invoice_number']) ? $_GET['invoice_number'] : '';

// Build base query - shows all products by default
$query = "SELECT * FROM deleted_products WHERE 1=1";
$count_query = "SELECT COUNT(*) as total FROM deleted_products WHERE 1=1";

// Add filters if they exist
if (!empty($d1) && !empty($d2)) {
    $query .= " AND deleted_date BETWEEN '$d1' AND '$d2'";
    $count_query .= " AND deleted_date BETWEEN '$d1' AND '$d2'";
}

if (!empty($deleted_by)) {
    $query .= " AND deleted_by LIKE '%$deleted_by%'";
    $count_query .= " AND deleted_by LIKE '%$deleted_by%'";
}

if (!empty($medicine_name)) {
    $query .= " AND medicine_name LIKE '%$medicine_name%'";
    $count_query .= " AND medicine_name LIKE '%$medicine_name%'";
}

if (!empty($category)) {
    $query .= " AND category LIKE '%$category%'";
    $count_query .= " AND category LIKE '%$category%'";
}

// Get total records
$count_result = mysqli_query($con, $count_query);
$total_records = mysqli_fetch_assoc($count_result)['total'];

// Handle "All" records option
if ($records_per_page === 'all') {
    $records_per_page = $total_records;
    $start_from = 0;
    $total_pages = 1;
} else {
    $records_per_page = (int)$records_per_page;
    $start_from = ($page - 1) * $records_per_page;
    $total_pages = ceil($total_records / $records_per_page);
}

// Add sorting and pagination
$query .= " ORDER BY deleted_date DESC LIMIT $start_from, $records_per_page";

// Get the data
$result = mysqli_query($con, $query);

// Build URL parameters
$url_params = [];
if (!empty($d1)) $url_params['d1'] = $d1;
if (!empty($d2)) $url_params['d2'] = $d2;
if (!empty($deleted_by)) $url_params['deleted_by'] = $deleted_by;
if (!empty($medicine_name)) $url_params['medicine_name'] = $medicine_name;
if (!empty($category)) $url_params['category'] = $category;
if (!empty($invoice_number)) $url_params['invoice_number'] = $invoice_number;

$url_param_string = http_build_query($url_params);
?>
<!DOCTYPE html>
<html> 
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>MauzoApp</title>
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
    .pagination-container {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-top: 20px;
    }
    .per-page-selector {
      width: 100px;
      display: inline-block;
    }
    .table-responsive {
      display: block;
      width: 100%;
      overflow-x: auto;
      -webkit-overflow-scrolling: touch;
    }
    .table {
      width: 100%;
      max-width: 100%;
      margin-bottom: 1rem;
      background-color: transparent;
      border-collapse: collapse;
      table-layout: auto;
    }
    .table th, .table td {
      padding: 0.75rem;
      vertical-align: top;
      border-top: 1px solid #dee2e6;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }
    .table thead th {
      vertical-align: bottom;
      border-bottom: 2px solid #dee2e6;
    }
    .table-bordered {
      border: 1px solid #dee2e6;
    }
    .table-bordered th, .table-bordered td {
      border: 1px solid #dee2e6;
    }
    .table-striped tbody tr:nth-of-type(odd) {
      background-color: rgba(0, 0, 0, 0.05);
    }
    .table-hover tbody tr:hover {
      background-color: rgba(0, 0, 0, 0.075);
    }
    .no-records {
      padding: 20px;
      text-align: center;
      background-color: #f8f9fa;
      border-radius: 5px;
      margin: 20px 0;
      font-size: 1.1em;
      color: #6c757d;
    }
    @media (max-width: 768px) {
      .form-inline .form-group {
        flex: 1 1 100%;
      }
      .pagination-container {
        flex-direction: column;
        align-items: flex-start;
      }
      .pagination {
        margin: 10px 0;
      }
    }
  </style>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Navbar -->
  <?php include("navbar.php"); ?>   
  <?php include('indexSideBar.php') ?>
  <!-- Content -->
  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid"> 
        <div class="row mb-2">
          <div class="col-sm-6"></div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Admin</a></li>
              <li class="breadcrumb-item active">Dawa zilizo futwa</li>
            </ol>
          </div>
        </div>
      </div>
    </section>

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title"><b>Ripoti ya Dawa zilizo futwa</b></h3>
              </div>
              
              <div class="card-body">
                <form action="deleted_products_report.php?invoice_number=<?= $invoice_number ?>" method="POST" class="form-inline">
                  <div class="form-group">
                    <input type="date" id="d1" name="d1" class="form-control" placeholder="Kuanzia Tarehe" value="<?= $d1 ?>">
                  </div>
                  <div class="form-group">
                    <input type="date" id="d2" name="d2" class="form-control" placeholder="Mbaka Tarehe" value="<?= $d2 ?>">
                  </div>
                  <div class="form-group">
                    <input type="text" id="deleted_by" name="deleted_by" class="form-control" placeholder="Aliye futa" value="<?= $deleted_by ?>">
                  </div>
                  <div class="form-group">
                    <input type="text" id="medicine_name" name="medicine_name" class="form-control" placeholder="Jina la Dawa" value="<?= $medicine_name ?>">
                  </div>
                  <div class="form-group">
                    <input type="text" id="category" name="category" class="form-control" placeholder="Aina ya Dawa" value="<?= $category ?>">
                  </div>
                  <div class="form-group">
                    <button class="btn btn-info" type="submit" name="submit"><i class="icon icon-search icon-large"></i> Tafuta</button>
                  </div>
                </form>

                <div class="table-responsive mt-3">
                  <table class="table table-bordered table-striped table-hover">
                    <thead>
                      <tr class="table-success">
                        <th>#</th>
                        <th>Tarehe</th>
                        <th>Dawa</th>
                        <th>Aina ya Dawa</th>
                        <th>Idadi iliyopo</th>
                        <th>Idadi iliyouzwa</th>
                        <th>Bei ya kununua</th>
                        <th>Bei ya kuuza</th>
                        <th>Tarehe ku expire</th>
                        <th>Faida</th>
                        <th>Msambazaji</th>
                        <th>Aliyefuta</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php if(mysqli_num_rows($result) > 0): ?>
                        <?php $serial_number = $start_from + 1; ?>
                        <?php while($row = mysqli_fetch_array($result)): ?>
                          <tr>
                            <td><?= $serial_number++ ?></td>
                            <td><?= htmlspecialchars($row['deleted_date']) ?></td>
                            <td title="<?= htmlspecialchars($row['medicine_name']) ?>"><?= htmlspecialchars($row['medicine_name']) ?></td>
                            <td><?= htmlspecialchars($row['category']) ?></td>
                            <td><?= htmlspecialchars($row['act_remain_quantity']) ?></td>
                            <td><?= htmlspecialchars($row['used_quantity']) ?></td>
                            <td><?= htmlspecialchars($row['actual_price']) ?></td>
                            <td><?= number_format($row['selling_price']) ?></td>
                            <td><?= htmlspecialchars($row['expire_date']) ?></td>
                            <td><?= htmlspecialchars($row['profit_price']) ?></td>
                            <td><?= htmlspecialchars($row['company']) ?></td>
                            <td><?= htmlspecialchars($row['deleted_by']) ?></td>
                          </tr>
                        <?php endwhile; ?>
                      <?php else: ?>
                        <tr>
                          <td colspan="12" class="text-center py-4">
                            <div class="no-records">
                              <i class="fas fa-info-circle fa-2x mb-2"></i>
                              <h4>Hakuna taharifa yeyote</h4>
                              <p>Haikupatikana rekodi zozote zilizo sawa na vichujio vyako</p>
                            </div>
                          </td>
                        </tr>
                      <?php endif; ?>
                    </tbody>
                  </table>
                </div>

                <div class="pagination-container mt-3">
                  <div>
                    <select id="per_page" class="form-control per-page-selector">
                      <option value="10" <?= $records_per_page == 10 ? 'selected' : '' ?>>10</option>
                      <option value="25" <?= $records_per_page == 25 ? 'selected' : '' ?>>25</option>
                      <option value="50" <?= $records_per_page == 50 ? 'selected' : '' ?>>50</option>
                      <option value="100" <?= $records_per_page == 100 ? 'selected' : '' ?>>100</option>
                      <option value="all" <?= $records_per_page === 'all' ? 'selected' : '' ?>>All</option>
                    </select> rekodi kwa kila ukurasa
                  </div>
                  
                  <?php if ($records_per_page !== 'all'): ?>
                  <nav aria-label="Page navigation">
                    <ul class="pagination">
                      <?php if($page > 1): ?>
                        <li class="page-item">
                          <a class="page-link" href="deleted_products_report.php?<?= $url_param_string ?>&page=<?= $page-1 ?>&per_page=<?= $records_per_page ?>">
                            <span aria-hidden="true">&laquo;</span>
                          </a>
                        </li>
                      <?php endif; ?>
                      
                      <?php 
                      $visible_pages = 5;
                      $half = floor($visible_pages / 2);
                      $start_page = max(1, $page - $half);
                      $end_page = min($total_pages, $start_page + $visible_pages - 1);
                      
                      if($start_page > 1) {
                        echo '<li class="page-item"><a class="page-link" href="deleted_products_report.php?'.$url_param_string.'&page=1&per_page='.$records_per_page.'">1</a></li>';
                        if($start_page > 2) echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                      }
                      
                      for($i = $start_page; $i <= $end_page; $i++): ?>
                        <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                          <a class="page-link" href="deleted_products_report.php?<?= $url_param_string ?>&page=<?= $i ?>&per_page=<?= $records_per_page ?>"><?= $i ?></a>
                        </li>
                      <?php endfor; 
                      
                      if($end_page < $total_pages) {
                        if($end_page < $total_pages - 1) echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                        echo '<li class="page-item"><a class="page-link" href="deleted_products_report.php?'.$url_param_string.'&page='.$total_pages.'&per_page='.$records_per_page.'">'.$total_pages.'</a></li>';
                      }
                      ?>
                      
                      <?php if($page < $total_pages): ?>
                        <li class="page-item">
                          <a class="page-link" href="deleted_products_report.php?<?= $url_param_string ?>&page=<?= $page+1 ?>&per_page=<?= $records_per_page ?>">
                            <span aria-hidden="true">&raquo;</span>
                          </a>
                        </li>
                      <?php endif; ?>
                    </ul>
                  </nav>
                  <?php endif; ?>
                  
                  <div>
                    <?php if ($records_per_page === 'all'): ?>
                      Onyesha rekodi zote <?= $total_records ?>
                    <?php else: ?>
                      Onyesha <?= ($start_from + 1) ?> - <?= min($start_from + $records_per_page, $total_records) ?> ya <?= $total_records ?> rekodi
                    <?php endif; ?>
                  </div>
                </div>

                <div class="export-buttons text-center mt-3">
                  <a href="export_deleted_products_excel.php?<?= $url_param_string ?>" class="btn btn-success">Pakua katika Excel</a>
                  <a href="export_deleted_products_pdf.php?<?= $url_param_string ?>" class="btn btn-danger">Pakua katika PDF</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</div>

<!-- JS -->
<script src="./plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="./dist/js/adminlte.min.js"></script>
<script src="js/jquery-1.7.2.min.js"></script>
<script src="js/jquery_ui.js"></script>
<script src="js/bootstrap.js"></script>
<script src="src/facebox.js"></script>
<script src="js/tcal.js"></script>

<script>
jQuery(document).ready(function($) {
  $("a[id*=popup]").facebox({
    loadingImage: 'src/img/loading.gif',
    closeImage: 'src/img/closelabel.png'
  });
  
  // Change records per page
  $('#per_page').change(function() {
    var perPage = $(this).val();
    window.location.href = 'deleted_products_report.php?<?= $url_param_string ?>&per_page=' + perPage;
  });
});

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