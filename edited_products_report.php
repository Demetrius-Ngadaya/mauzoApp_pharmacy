<?php
include("session.php");
include("dbcon.php");
error_reporting(1);

// Get invoice number from URL if it exists
$invoice_number = isset($_GET['invoice_number']) ? htmlspecialchars($_GET['invoice_number']) : '';

// Pagination variables
$records_per_page = isset($_GET['per_page']) ? $_GET['per_page'] : 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;

// Sanitize and get search filters from both POST and GET
$d1 = isset($_POST['d1']) ? htmlspecialchars($_POST['d1']) : (isset($_GET['d1']) ? htmlspecialchars($_GET['d1']) : '');
$d2 = isset($_POST['d2']) ? htmlspecialchars($_POST['d2']) : (isset($_GET['d2']) ? htmlspecialchars($_GET['d2']) : '');
$edited_by = isset($_POST['edited_by']) ? htmlspecialchars($_POST['edited_by']) : (isset($_GET['edited_by']) ? htmlspecialchars($_GET['edited_by']) : '');
$medicine_name = isset($_POST['medicine_name']) ? htmlspecialchars($_POST['medicine_name']) : (isset($_GET['medicine_name']) ? htmlspecialchars($_GET['medicine_name']) : '');
$category = isset($_POST['category']) ? htmlspecialchars($_POST['category']) : (isset($_GET['category']) ? htmlspecialchars($_GET['category']) : '');

// Check if any filter has been applied
$filter_applied = !empty($d1) || !empty($d2) || !empty($edited_by) || !empty($medicine_name) || !empty($category);

// Build base query - show all products by default
$query = "SELECT * FROM edited_products WHERE 1=1";
$count_query = "SELECT COUNT(*) as total FROM edited_products WHERE 1=1";

// Add filters only if they exist
if (!empty($d1) && !empty($d2)) {
    $query .= " AND edited_date BETWEEN ? AND ?";
    $count_query .= " AND edited_date BETWEEN ? AND ?";
} elseif (!empty($d1)) {
    $query .= " AND edited_date >= ?";
    $count_query .= " AND edited_date >= ?";
} elseif (!empty($d2)) {
    $query .= " AND edited_date <= ?";
    $count_query .= " AND edited_date <= ?";
}

if (!empty($edited_by)) {
    $query .= " AND edited_by LIKE ?";
    $count_query .= " AND edited_by LIKE ?";
}

if (!empty($medicine_name)) {
    $query .= " AND medicine_name LIKE ?";
    $count_query .= " AND medicine_name LIKE ?";
}

if (!empty($category)) {
    $query .= " AND category LIKE ?";
    $count_query .= " AND category LIKE ?";
}

// Prepare and execute count query
$stmt_count = mysqli_prepare($con, $count_query);
if ($stmt_count === false) {
    die("Error preparing count query: " . mysqli_error($con));
}

// Bind parameters for count query
$param_types = "";
$param_values = [];

if (!empty($d1) && !empty($d2)) {
    $param_types .= "ss";
    $param_values[] = $d1;
    $param_values[] = $d2;
} elseif (!empty($d1)) {
    $param_types .= "s";
    $param_values[] = $d1;
} elseif (!empty($d2)) {
    $param_types .= "s";
    $param_values[] = $d2;
}

if (!empty($edited_by)) {
    $param_types .= "s";
    $param_values[] = "%$edited_by%";
}

if (!empty($medicine_name)) {
    $param_types .= "s";
    $param_values[] = "%$medicine_name%";
}

if (!empty($category)) {
    $param_types .= "s";
    $param_values[] = "%$category%";
}

if (!empty($param_types)) {
    mysqli_stmt_bind_param($stmt_count, $param_types, ...$param_values);
}

if (!mysqli_stmt_execute($stmt_count)) {
    die("Error executing count query: " . mysqli_stmt_error($stmt_count));
}

$count_result = mysqli_stmt_get_result($stmt_count);
$total_records = mysqli_fetch_assoc($count_result)['total'];
mysqli_stmt_close($stmt_count);

// Handle records per page and pagination
if ($records_per_page === 'all') {
    $records_per_page = $total_records;
    $start_from = 0;
    $total_pages = 1;
} else {
    // Ensure records_per_page is a positive integer
    $records_per_page = max(1, (int)$records_per_page);
    $start_from = ($page - 1) * $records_per_page;
    $total_pages = $total_records > 0 ? ceil($total_records / $records_per_page) : 1;
}

// Prepare and execute main query
$query .= " ORDER BY edited_date DESC";
if ($records_per_page !== $total_records) {
    $query .= " LIMIT ?, ?";
}

$stmt = mysqli_prepare($con, $query);
if ($stmt === false) {
    die("Error preparing query: " . mysqli_error($con));
}

// Bind parameters for main query
$param_types = "";
$param_values = [];

if (!empty($d1) && !empty($d2)) {
    $param_types .= "ss";
    $param_values[] = $d1;
    $param_values[] = $d2;
} elseif (!empty($d1)) {
    $param_types .= "s";
    $param_values[] = $d1;
} elseif (!empty($d2)) {
    $param_types .= "s";
    $param_values[] = $d2;
}

if (!empty($edited_by)) {
    $param_types .= "s";
    $param_values[] = "%$edited_by%";
}

if (!empty($medicine_name)) {
    $param_types .= "s";
    $param_values[] = "%$medicine_name%";
}

if (!empty($category)) {
    $param_types .= "s";
    $param_values[] = "%$category%";
}

if ($records_per_page !== $total_records) {
    $param_types .= "ii";
    $param_values[] = $start_from;
    $param_values[] = $records_per_page;
}

if (!empty($param_types)) {
    mysqli_stmt_bind_param($stmt, $param_types, ...$param_values);
}

if (!mysqli_stmt_execute($stmt)) {
    die("Error executing query: " . mysqli_stmt_error($stmt));
}

$result = mysqli_stmt_get_result($stmt);

// Build URL parameters
$url_params = [];
if (!empty($d1)) $url_params['d1'] = $d1;
if (!empty($d2)) $url_params['d2'] = $d2;
if (!empty($edited_by)) $url_params['edited_by'] = $edited_by;
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
  <title>MauzoApp - Ripoti ya Dawa Zilizohaririwa</title>
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
    .form-container {
      background-color: #f8f9fa;
      padding: 20px;
      border-radius: 5px;
      margin-bottom: 20px;
    }
    .form-inline .form-group {
      margin-right: 10px;
      margin-bottom: 10px;
    }
    .table-responsive {
      overflow-x: auto;
    }
    .no-records {
      text-align: center;
      padding: 50px;
      background-color: #f8f9fa;
      border-radius: 5px;
    }
    .pagination-container {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-top: 20px;
    }
    @media (max-width: 768px) {
      .form-inline .form-group {
        width: 100%;
        margin-right: 0;
      }
      .pagination-container {
        flex-direction: column;
      }
    }
    
  </style>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
<?php include("navbar.php"); ?>
<?php include('indexSideBar.php') ?>
  <!-- Content -->
<div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Ripoti ya Dawa Zilizohaririwa</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Admin</a></li>
              <li class="breadcrumb-item active">Dawa Zilizohaririwa</li>
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
                <h3 class="card-title">Tafuta Rekodi</h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
              </div>
              
              <div class="card-body">
                <form action="edited_products_report.php?invoice_number=<?= $invoice_number ?>" method="POST" class="form-inline">
                  <div class="form-group">
                    <label for="d1" class="mr-2">Kuanzia:</label>
                    <input type="date" id="d1" name="d1" class="form-control" value="<?= $d1 ?>">
                  </div>
                  <div class="form-group">
                    <label for="d2" class="mr-2">Hadi:</label>
                    <input type="date" id="d2" name="d2" class="form-control" value="<?= $d2 ?>">
                  </div>
                  <div class="form-group">
                    <label for="edited_by" class="mr-2">Aliyehariri:</label>
                    <input type="text" id="edited_by" name="edited_by" class="form-control" placeholder="Jina la mhariri" value="<?= $edited_by ?>">
                  </div>
                  <div class="form-group">
                    <label for="medicine_name" class="mr-2">Dawa:</label>
                    <input type="text" id="medicine_name" name="medicine_name" class="form-control" placeholder="Jina la Dawa" value="<?= $medicine_name ?>">
                  </div>
                  <div class="form-group">
                    <label for="category" class="mr-2">Aina:</label>
                    <input type="text" id="category" name="category" class="form-control" placeholder="Aina ya Dawa" value="<?= $category ?>">
                  </div>
                  <div class="form-group">
                    <button type="submit" name="submit" class="btn btn-primary">
                      <i class="fas fa-search"></i> Tafuta
                    </button>
                    <?php if ($filter_applied): ?>
                      <a href="edited_products_report.php?invoice_number=<?= $invoice_number ?>" class="btn btn-secondary ml-2">
                        <i class="fas fa-times"></i> Ondoa Vichujio
                      </a>
                    <?php endif; ?>
                  </div>
                </form>
              </div>
            </div>

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Rekodi Zilizopatikana</h3>
              </div>
              <div class="card-body">
                <?php if(mysqli_num_rows($result) > 0): ?>
                  <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                      <thead>
                      <tr class="table-success">
                          <th>#</th>
                          <th>Tarehe</th>
                          <th>Dawa</th>
                          <th>Aina</th>
                          <th>Idadi Ya Zamani</th>
                          <th>Idadi Mpya</th>
                          <th>Mhariri</th>
                          <th>Sababu</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php $serial_number = $start_from + 1; ?>
                        <?php while($row = mysqli_fetch_assoc($result)): ?>
                          <tr>
                            <td><?= $serial_number++ ?></td>
                            <td><?= htmlspecialchars($row['edited_date']) ?></td>
                            <td><?= htmlspecialchars($row['medicine_name']) ?></td>
                            <td><?= htmlspecialchars($row['category']) ?></td>
                            <td><?= htmlspecialchars($row['old_quantity']) ?></td>
                            <td><?= htmlspecialchars($row['act_remain_quantity']) ?></td>
                            <td><?= htmlspecialchars($row['edited_by']) ?></td>
                            <td><?= htmlspecialchars($row['edit_reason']) ?></td>
                          </tr>
                        <?php endwhile; ?>
                      </tbody>
                    </table>
                  </div>

                  <div class="pagination-container">
                    <div class="form-inline">
                      <label for="per_page" class="mr-2">Rekodi kwa ukurasa:</label>
                      <select id="per_page" class="form-control form-control-sm">
                        <option value="10" <?= $records_per_page == 10 ? 'selected' : '' ?>>10</option>
                        <option value="25" <?= $records_per_page == 25 ? 'selected' : '' ?>>25</option>
                        <option value="50" <?= $records_per_page == 50 ? 'selected' : '' ?>>50</option>
                        <option value="100" <?= $records_per_page == 100 ? 'selected' : '' ?>>100</option>
                        <option value="all" <?= $records_per_page === 'all' ? 'selected' : '' ?>>Zote</option>
                      </select>
                    </div>
                    
                    <?php if ($records_per_page !== 'all' && $total_pages > 1): ?>
                    <nav aria-label="Page navigation">
                      <ul class="pagination pagination-sm">
                        <?php if($page > 1): ?>
                          <li class="page-item">
                            <a class="page-link" href="edited_products_report.php?<?= $url_param_string ?>&page=<?= $page-1 ?>&per_page=<?= $records_per_page ?>">
                              &laquo;
                            </a>
                          </li>
                        <?php endif; ?>
                        
                        <?php 
                        $visible_pages = 5;
                        $half = floor($visible_pages / 2);
                        $start_page = max(1, $page - $half);
                        $end_page = min($total_pages, $start_page + $visible_pages - 1);
                        
                        if($start_page > 1) {
                          echo '<li class="page-item"><a class="page-link" href="edited_products_report.php?'.$url_param_string.'&page=1&per_page='.$records_per_page.'">1</a></li>';
                          if($start_page > 2) echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                        }
                        
                        for($i = $start_page; $i <= $end_page; $i++): ?>
                          <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                            <a class="page-link" href="edited_products_report.php?<?= $url_param_string ?>&page=<?= $i ?>&per_page=<?= $records_per_page ?>">
                              <?= $i ?>
                            </a>
                          </li>
                        <?php endfor; 
                        
                        if($end_page < $total_pages) {
                          if($end_page < $total_pages - 1) echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                          echo '<li class="page-item"><a class="page-link" href="edited_products_report.php?'.$url_param_string.'&page='.$total_pages.'&per_page='.$records_per_page.'">'.$total_pages.'</a></li>';
                        }
                        ?>
                        
                        <?php if($page < $total_pages): ?>
                          <li class="page-item">
                            <a class="page-link" href="edited_products_report.php?<?= $url_param_string ?>&page=<?= $page+1 ?>&per_page=<?= $records_per_page ?>">
                              &raquo;
                            </a>
                          </li>
                        <?php endif; ?>
                      </ul>
                    </nav>
                    <?php endif; ?>
                    
                    <div class="text-muted">
                      <?php if ($records_per_page === 'all'): ?>
                        Zote <?= $total_records ?> rekodi
                      <?php else: ?>
                        Rekodi <?= ($start_from + 1) ?> - <?= min($start_from + $records_per_page, $total_records) ?> ya <?= $total_records ?>
                      <?php endif; ?>
                    </div>
                  </div>

                  <div class="text-center mt-3">
                    <a href="export_edited_products_excel.php?<?= $url_param_string ?>" class="btn btn-success">
                      <i class="fas fa-file-excel"></i> Pakua Excel
                    </a>
                    <a href="export_edited_products_pdf.php?<?= $url_param_string ?>" class="btn btn-danger ml-2">
                      <i class="fas fa-file-pdf"></i> Pakua PDF
                    </a>
                  </div>
                <?php else: ?>
                  <div class="no-records">
                    <i class="fas fa-info-circle fa-3x mb-3 text-muted"></i>
                    <h4>Hakuna rekodi zilizopatikana</h4>
                    <p class="text-muted">
                      <?php if ($filter_applied): ?>
                        Hakuna rekodi zilizo sawa na vichujio vyako. 
                        <a href="edited_products_report.php?invoice_number=<?= $invoice_number ?>" class="text-primary">Ondoa vichujio</a> 
                        au jaribu vichujio tofauti.
                      <?php else: ?>
                        Hakuna rekodi za Dawa zilizohaririwa kwa sasa.
                      <?php endif; ?>
                    </p>
                  </div>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</div>

<!-- JavaScript -->
<script src="./plugins/jquery/jquery.min.js"></script>
<script src="./plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="./dist/js/adminlte.min.js"></script>

<script>
$(document).ready(function() {
  // Change records per page
  $('#per_page').change(function() {
    var perPage = $(this).val();
    window.location.href = 'edited_products_report.php?<?= $url_param_string ?>&per_page=' + perPage;
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
<?php
mysqli_stmt_close($stmt);
mysqli_close($con);
?>