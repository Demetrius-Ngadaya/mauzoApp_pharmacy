<?php
include("session.php");
include("dbcon.php");

// Get invoice_number from URL if it exists
$invoice_number = isset($_GET['invoice_number']) ? $_GET['invoice_number'] : '';

// Pagination settings
$records_per_page = isset($_GET['records_per_page']) ? (int)$_GET['records_per_page'] : 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start_from = ($page-1) * $records_per_page;

// Initialize search variables with empty defaults
$d1 = isset($_POST['d1']) ? $_POST['d1'] : '';
$d2 = isset($_POST['d2']) ? $_POST['d2'] : '';
$created_by = isset($_POST['created_by']) ? $_POST['created_by'] : '';
$expenditure_name = isset($_POST['expenditure_name']) ? $_POST['expenditure_name'] : '';
$expenditure_description = isset($_POST['expenditure_description']) ? $_POST['expenditure_description'] : '';

// Build the base query to show all records by default
$select_sql = "SELECT * FROM expenditure";
$count_sql = "SELECT COUNT(*) as total FROM expenditure";
$sum_sql = "SELECT SUM(expenditure_amount) as total_sum FROM expenditure";

// Add filters only if they are provided
$conditions = array();

if (!empty($d1) ) {
    $conditions[] = "created_at >= '$d1'";
}

if (!empty($d2)) {
    $conditions[] = "created_at <= '$d2'";
}

if (!empty($created_by)) {
    $conditions[] = "created_by LIKE '%$created_by%'";
}

if (!empty($expenditure_name)) {
    $conditions[] = "expenditure_name LIKE '%$expenditure_name%'";
}

if (!empty($expenditure_description)) {
    $conditions[] = "expenditure_description LIKE '%$expenditure_description%'";
}

if (!empty($conditions)) {
    $where_clause = implode(' AND ', $conditions);
    $select_sql .= " WHERE $where_clause";
    $count_sql .= " WHERE $where_clause";
    $sum_sql .= " WHERE $where_clause";
}

$select_sql .= " ORDER BY created_at DESC";

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

// Function to generate URL with all parameters
function generateUrl($params = array()) {
    global $invoice_number, $d1, $d2, $created_by, $expenditure_name, $expenditure_description;
    $url = "expenditure_report.php?";
    if (!empty($invoice_number)) {
        $url .= "invoice_number=" . urlencode($invoice_number) . "&";
    }
    $url .= "d1=" . urlencode($d1) . "&";
    $url .= "d2=" . urlencode($d2) . "&";
    $url .= "created_by=" . urlencode($created_by) . "&";
    $url .= "expenditure_name=" . urlencode($expenditure_name) . "&";
    $url .= "expenditure_description=" . urlencode($expenditure_description);
    
    foreach ($params as $key => $value) {
        $url .= "&$key=" . urlencode($value);
    }
    return $url;
}
?>
<!DOCTYPE html>
<html> 
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>MauzoApp</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="./plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="./plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="./plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="./dist/css/adminlte.min.css">
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
    
    function changeRecordsPerPage() {
      var recordsPerPage = document.getElementById("records_per_page").value;
      var url = "<?php echo generateUrl(); ?>";
      url += "&records_per_page=" + recordsPerPage;
      url += "&page=1"; // Reset to first page
      window.location.href = url;
    }
    
    function resetFilters() {
        var url = "expenditure_report.php";
        <?php if (!empty($invoice_number)): ?>
            url += "?invoice_number=<?php echo urlencode($invoice_number); ?>";
        <?php endif; ?>
        window.location.href = url;
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
    }
    .table td, .table th {
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
      max-width: 200px;
    }
    .form-inline .form-group {
      margin-right: 10px;
      margin-bottom: 10px;
    }
    .reset-btn {
      margin-left: 10px;
    }
  </style>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <?php include("navbar.php"); ?>   
  <?php include('indexSideBar.php') ?>

  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid"> 
        <div class="row mb-2">
          <div class="col-sm-6"></div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Admin</a></li>
              <li class="breadcrumb-item active">Ripoti ya Matumizi</li>
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
                <h3 class="card-title"><b>Ripoti ya Matumizi</b></h3>
              </div>
              
              <div class="card-body">
                <form action="<?php echo generateUrl(); ?>" method="POST" class="form-inline mb-4">
                  <div class="form-group">
                    <label for="d1" class="mr-2"><strong>Kuanzia:</strong></label>
                    <input type="date" id="d1" name="d1" class="form-control" value="<?php echo $d1; ?>">
                  </div>
                  <div class="form-group ml-3">
                    <label for="d2" class="mr-2"><strong>Hadi:</strong></label>
                    <input type="date" id="d2" name="d2" class="form-control" value="<?php echo $d2; ?>">
                  </div>
                  <div class="form-group ml-3">
                    <label for="created_by" class="mr-2"><strong>Aliyeandika:</strong></label>
                    <input type="text" id="created_by" name="created_by" class="form-control" value="<?php echo $created_by; ?>">
                  </div>
                  <div class="form-group ml-3">
                    <label for="expenditure_name" class="mr-2"><strong>Jina la Matumizi:</strong></label>
                    <input type="text" id="expenditure_name" name="expenditure_name" class="form-control" value="<?php echo $expenditure_name; ?>">
                  </div>
                  <div class="form-group ml-3">
                    <label for="expenditure_description" class="mr-2"><strong>Maelezo:</strong></label>
                    <input type="text" id="expenditure_description" name="expenditure_description" class="form-control" value="<?php echo $expenditure_description; ?>">
                  </div>
                  <div class="form-group ml-3">
                    <button class="btn btn-info" type="submit" name="submit">
                      <i class="fas fa-search"></i> Tafuta
                    </button>
                    <button type="button" class="btn btn-secondary reset-btn" onclick="resetFilters()">
                      <i class="fas fa-sync-alt"></i> Safisha
                    </button>
                  </div>
                </form>
                
                <!-- Records per page selector -->
                <div class="records-per-page">
                  <label for="records_per_page"><strong>Rekodi kwa kila ukurasa:</strong></label>
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
                        <th>Tarehe</th>
                        <th>Jina la Matumizi</th>
                        <th>Maelezo</th>
                        <th>Kiasi (Tsh)</th>
                        <th>Aliyeandika</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php 
                      $counter = ($page - 1) * $records_per_page + 1;
                      while($row = mysqli_fetch_array($select_query)) : ?>
                      <tr> 
                        <td><?php echo $counter++; ?></td>
                        <td><?php echo date('d/m/Y', strtotime($row['created_at'])); ?></td> 
                        <td><?php echo htmlspecialchars($row['expenditure_name']); ?></td> 
                        <td><?php echo htmlspecialchars($row['expenditure_description']); ?></td>
                        <td class="text-right"><?php echo number_format($row['expenditure_amount']); ?></td> 
                        <td><?php echo htmlspecialchars($row['created_by']); ?></td>
                      </tr>
                      <?php endwhile; ?>
                    </tbody>
                    <tfoot>
                      <tr>
                        <th colspan="4" class="text-right">Jumla Kuu:</th>
                        <th class="text-right">
                          <?php
                          $sum_query = mysqli_query($con, $sum_sql);
                          $sum_row = mysqli_fetch_assoc($sum_query);
                          echo number_format($sum_row['total_sum']).' Tsh';
                          ?>
                        </th>
                        <th></th>
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
                              <a class="page-link" href="<?php echo generateUrl(array('page' => $page-1, 'records_per_page' => $records_per_page)); ?>" aria-label="Previous">
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
                            echo '<li class="page-item"><a class="page-link" href="'.generateUrl(array('page' => 1, 'records_per_page' => $records_per_page)).'">1</a></li>';
                            if ($start_page > 2) {
                              echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                            }
                          }
                          
                          for ($i = $start_page; $i <= $end_page; $i++) {
                            $active = ($i == $page) ? 'active' : '';
                            echo '<li class="page-item '.$active.'"><a class="page-link" href="'.generateUrl(array('page' => $i, 'records_per_page' => $records_per_page)).'">'.$i.'</a></li>';
                          }
                          
                          if ($end_page < $total_pages) {
                            if ($end_page < $total_pages - 1) {
                              echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                            }
                            echo '<li class="page-item"><a class="page-link" href="'.generateUrl(array('page' => $total_pages, 'records_per_page' => $records_per_page)).'">'.$total_pages.'</a></li>';
                          }
                          ?>
                          
                          <?php if ($page < $total_pages) : ?>
                            <li class="page-item">
                              <a class="page-link" href="<?php echo generateUrl(array('page' => $page+1, 'records_per_page' => $records_per_page)); ?>" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                              </a>
                            </li>
                          <?php endif; ?>
                        </ul>
                      </nav>
                    </div>
                  </div>
                  
                  <div class="text-center mt-3">
                    <div class="btn-group">
                      <a href="export_expenditure_excel.php?<?php 
                        echo "d1=".urlencode($d1)."&d2=".urlencode($d2)."&created_by=".urlencode($created_by);
                        echo "&expenditure_name=".urlencode($expenditure_name)."&expenditure_description=".urlencode($expenditure_description);
                      ?>" class="btn btn-success">
                        <i class="fas fa-file-excel"></i> Pakua Excel
                      </a>
                      <a href="export_expenditure_pdf.php?<?php 
                        echo "d1=".urlencode($d1)."&d2=".urlencode($d2)."&created_by=".urlencode($created_by);
                        echo "&expenditure_name=".urlencode($expenditure_name)."&expenditure_description=".urlencode($expenditure_description);
                      ?>" class="btn btn-danger">
                        <i class="fas fa-file-pdf"></i> Pakua PDF
                      </a>
                      <button class="btn btn-primary" onclick="Clickheretoprint()">
                        <i class="fas fa-print"></i> Print
                      </button>
                    </div>
                  </div>
                  
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
  </div>
</div>

<script src="./plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
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