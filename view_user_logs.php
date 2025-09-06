<?php
include("session.php");
include('dbcon.php');
include("user_logs.php");

// Check if user has permission to view logs
if ($_SESSION['user_role'] !== 'admin') {
    header("location:access_denied.php");
    exit();
}

// Get invoice number from URL or generate a new one
$invoice_number = isset($_GET['invoice_number']) ? $_GET['invoice_number'] : generate_unique_invoice_number($con);

// Initialize variables for filtering
$search_user = isset($_GET['search_user']) ? $_GET['search_user'] : '';
$search_store = isset($_GET['search_store']) ? $_GET['search_store'] : '';
$search_login_start = isset($_GET['search_login_start']) ? $_GET['search_login_start'] : '';
$search_login_end = isset($_GET['search_login_end']) ? $_GET['search_login_end'] : '';
$search_logout_start = isset($_GET['search_logout_start']) ? $_GET['search_logout_start'] : '';
$search_logout_end = isset($_GET['search_logout_end']) ? $_GET['search_logout_end'] : '';

// Initialize UserLogger
$userLogger = new UserLogger($con);

// Build the base query with filters
$query = "SELECT ul.*, u.user_name, s.name as store_name 
          FROM user_logs ul 
          JOIN users u ON ul.user_id = u.id 
          LEFT JOIN stores s ON ul.store_id = s.id 
          WHERE 1=1";

$params = array();
$types = '';

// Apply filters
if (!empty($search_user)) {
    $query .= " AND u.user_name LIKE ?";
    $params[] = "%$search_user%";
    $types .= 's';
}

if (!empty($search_store)) {
    $query .= " AND s.name LIKE ?";
    $params[] = "%$search_store%";
    $types .= 's';
}

if (!empty($search_login_start)) {
    $query .= " AND ul.log_in_time >= ?";
    $params[] = $search_login_start;
    $types .= 's';
}

if (!empty($search_login_end)) {
    $query .= " AND ul.log_in_time <= ?";
    $params[] = $search_login_end . ' 23:59:59';
    $types .= 's';
}

if (!empty($search_logout_start)) {
    $query .= " AND ul.log_out_time >= ?";
    $params[] = $search_logout_start;
    $types .= 's';
}

if (!empty($search_logout_end)) {
    $query .= " AND ul.log_out_time <= ?";
    $params[] = $search_logout_end . ' 23:59:59';
    $types .= 's';
}

$query .= " ORDER BY ul.log_in_time DESC";

// Get total count for pagination
$count_query = $query;
$count_stmt = $con->prepare($count_query);
if (!empty($params)) {
    $count_stmt->bind_param($types, ...$params);
}
$count_stmt->execute();
$count_result = $count_stmt->get_result();
$total_records = $count_result->num_rows;
$count_stmt->close();

// Pagination setup
$per_page_options = array(10, 25, 50, 100, 250, 500, 'All');
$default_per_page = 25;
$per_page = isset($_GET['per_page']) && in_array($_GET['per_page'], $per_page_options) ? $_GET['per_page'] : $default_per_page;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;

if ($per_page != 'All') {
    $offset = ($page - 1) * $per_page;
    $query .= " LIMIT $offset, $per_page";
    $total_pages = ceil($total_records / $per_page);
} else {
    $total_pages = 1;
}

// Execute the main query
$stmt = $con->prepare($query);
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();
$logs = array();
while ($row = $result->fetch_assoc()) {
    $logs[] = $row;
}
$stmt->close();

// Handle export functionality
if (isset($_GET['export'])) {
    $export_type = $_GET['export'];
    
    if ($export_type == 'excel') {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="user_logs_' . date('Y-m-d') . '.xls"');
        
        $output = "<table border='1'>";
        $output .= "<tr>
                    <th>#</th>
                    <th>User</th>
                    <th>Store</th>
                    <th>Login Time</th>
                    <th>Logout Time</th>
                    <th>Duration</th>
                   </tr>";
        
        $counter = 1;
        foreach ($logs as $log) {
            $duration = '';
            if ($log['log_out_time']) {
                $login = new DateTime($log['log_in_time']);
                $logout = new DateTime($log['log_out_time']);
                $interval = $login->diff($logout);
                $duration = $interval->format('%h hours %i minutes');
            }
            
            $output .= "<tr>
                        <td>" . $counter . "</td>
                        <td>" . htmlspecialchars($log['user_name']) . "</td>
                        <td>" . ($log['store_name'] ? htmlspecialchars($log['store_name']) : 'No Store Assigned') . "</td>
                        <td>" . date('Y-m-d H:i:s', strtotime($log['log_in_time'])) . "</td>
                        <td>" . ($log['log_out_time'] ? date('Y-m-d H:i:s', strtotime($log['log_out_time'])) : 'Still logged in') . "</td>
                        <td>" . $duration . "</td>
                       </tr>";
            $counter++;
        }
        
        $output .= "</table>";
        echo $output;
        exit();
    } elseif ($export_type == 'pdf') {
        // PDF export would require a library like TCPDF or Dompdf
        // This is a basic implementation concept
        require_once('./tcpdf/tcpdf.php');
        
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('MauzoApp');
        $pdf->SetTitle('User Logs Report');
        $pdf->AddPage();
        
        $html = "<h1>User Login/Logout Logs</h1>";
        $html .= "<table border='1' cellpadding='4'>";
        $html .= "<tr>
                    <th>#</th>
                    <th>User</th>
                    <th>Store</th>
                    <th>Login Time</th>
                    <th>Logout Time</th>
                    <th>Duration</th>
                 </tr>";
        
        $counter = 1;
        foreach ($logs as $log) {
            $duration = '';
            if ($log['log_out_time']) {
                $login = new DateTime($log['log_in_time']);
                $logout = new DateTime($log['log_out_time']);
                $interval = $login->diff($logout);
                $duration = $interval->format('%h hours %i minutes');
            }
            
            $html .= "<tr>
                        <td>" . $counter . "</td>
                        <td>" . htmlspecialchars($log['user_name']) . "</td>
                        <td>" . ($log['store_name'] ? htmlspecialchars($log['store_name']) : 'No Store Assigned') . "</td>
                        <td>" . date('Y-m-d H:i:s', strtotime($log['log_in_time'])) . "</td>
                        <td>" . ($log['log_out_time'] ? date('Y-m-d H:i:s', strtotime($log['log_out_time'])) : 'Still logged in') . "</td>
                        <td>" . $duration . "</td>
                     </tr>";
            $counter++;
        }
        
        $html .= "</table>";
        
        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->Output('user_logs_' . date('Y-m-d') . '.pdf', 'D');
        exit();
    }
}

function generate_unique_invoice_number($con) {
    do {
        $chars = "09302909209300923";
        srand((double)microtime() * 1000000);
        $i = 1;
        $pass = '';

        while ($i <= 7) {
            $num  = rand() % 10;
            $tmp  = substr($chars, $num, 1);
            $pass = $pass . $tmp;
            $i++;
        }
        $invoice_number = "CA-" . $pass;

        // Check both 'sales' and 'on_hold' tables for existing invoice number
        $check_sql = "SELECT invoice_number FROM sales WHERE invoice_number = ? UNION SELECT invoice_number FROM on_hold WHERE invoice_number = ?";
        $stmt = $con->prepare($check_sql);
        $stmt->bind_param("ss", $invoice_number, $invoice_number);
        $stmt->execute();
        $result = $stmt->get_result();
    } while ($result->num_rows > 0);
    
    return $invoice_number;
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>MauzoApp - User Login Logs</title>
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
  <!-- Datepicker -->
  <link rel="stylesheet" href="./plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <!-- Navbar -->
  <?php include("navbar.php"); ?>   
  <!-- Sidebar -->
  <?php include('indexSideBar.php') ?>

  <!-- Content Wrapper -->
  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>User Login/Logout Logs</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="adminDashboard.php?invoice_number=<?php echo $invoice_number; ?>">Home</a></li>
              <li class="breadcrumb-item active">User Logs</li>
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
                <h3 class="card-title">User Login/Logout History</h3>
                
                <div class="card-tools">
                  <div class="btn-group">
                    <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
                      <i class="fas fa-download"></i> Export
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                      <a class="dropdown-item" href="?<?php echo http_build_query(array_merge($_GET, ['export' => 'excel'])); ?>">Export to Excel</a>
                      <!-- <a class="dropdown-item" href="?<?php echo http_build_query(array_merge($_GET, ['export' => 'pdf'])); ?>">Export to PDF</a> -->
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-body">
                <!-- Search and Filter Form -->
                <form method="GET" action="">
                  <input type="hidden" name="invoice_number" value="<?php echo $invoice_number; ?>">
                  
                  <div class="row mb-3">
                    <div class="col-md-3">
                      <div class="form-group">
                        <label>Search User</label>
                        <input type="text" name="search_user" class="form-control" placeholder="User name" value="<?php echo htmlspecialchars($search_user); ?>">
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label>Search Store</label>
                        <input type="text" name="search_store" class="form-control" placeholder="Store name" value="<?php echo htmlspecialchars($search_store); ?>">
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label>Login Time From</label>
                        <input type="date" name="search_login_start" class="form-control" value="<?php echo htmlspecialchars($search_login_start); ?>">
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label>Login Time To</label>
                        <input type="date" name="search_login_end" class="form-control" value="<?php echo htmlspecialchars($search_login_end); ?>">
                      </div>
                    </div>
                  </div>
                  
                  <div class="row mb-3">
                    <div class="col-md-3">
                      <div class="form-group">
                        <label>Logout Time From</label>
                        <input type="date" name="search_logout_start" class="form-control" value="<?php echo htmlspecialchars($search_logout_start); ?>">
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label>Logout Time To</label>
                        <input type="date" name="search_logout_end" class="form-control" value="<?php echo htmlspecialchars($search_logout_end); ?>">
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label>Records Per Page</label>
                        <select name="per_page" class="form-control" onchange="this.form.submit()">
                          <?php foreach ($per_page_options as $option): ?>
                            <option value="<?php echo $option; ?>" <?php echo $per_page == $option ? 'selected' : ''; ?>>
                              <?php echo $option; ?>
                            </option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-3" style="display: flex; align-items: flex-end;">
                      <button type="submit" class="btn btn-primary mr-2">Apply Filters</button>
                      <a href="view_user_logs.php?invoice_number=<?php echo $invoice_number; ?>" class="btn btn-default">Reset</a>
                    </div>
                  </div>
                </form>
                
                <table class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>User</th>
                      <th>Store</th>
                      <th>Login Time</th>
                      <th>Logout Time</th>
                      <th>Duration</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                    $serial = ($page - 1) * (is_numeric($per_page) ? $per_page : 0) + 1;
                    foreach ($logs as $log): 
                    ?>
                    <tr>
                      <td><?php echo $serial++; ?></td>
                      <td><?php echo htmlspecialchars($log['user_name']); ?></td>
                      <td><?php echo $log['store_name'] ? htmlspecialchars($log['store_name']) : 'No Store Assigned'; ?></td>
                      <td><?php echo date('Y-m-d H:i:s', strtotime($log['log_in_time'])); ?></td>
                      <td>
                        <?php 
                        if ($log['log_out_time']) {
                            echo date('Y-m-d H:i:s', strtotime($log['log_out_time']));
                        } else {
                            echo '<span class="badge badge-warning">Still logged in</span>';
                        }
                        ?>
                      </td>
                      <td>
                        <?php
                        if ($log['log_out_time']) {
                            $login = new DateTime($log['log_in_time']);
                            $logout = new DateTime($log['log_out_time']);
                            $interval = $login->diff($logout);
                            echo $interval->format('%h hours %i minutes');
                        } else {
                            echo '-';
                        }
                        ?>
                      </td>
                    </tr>
                    <?php endforeach; ?>
                    
                    <?php if (empty($logs)): ?>
                    <tr>
                      <td colspan="6" class="text-center">No records found</td>
                    </tr>
                    <?php endif; ?>
                  </tbody>
                </table>
                
                <!-- Pagination -->
                <?php if ($per_page != 'All' && $total_pages > 1): ?>
                <div class="row mt-3">
                  <div class="col-sm-12 col-md-5">
                    <div class="dataTables_info">
                      Showing <?php echo (($page - 1) * $per_page) + 1; ?> to 
                      <?php echo min($page * $per_page, $total_records); ?> of 
                      <?php echo $total_records; ?> entries
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-7">
                    <div class="dataTables_paginate paging_simple_numbers">
                      <ul class="pagination">
                        <?php if ($page > 1): ?>
                        <li class="paginate_button page-item previous">
                          <a href="?<?php echo http_build_query(array_merge($_GET, ['page' => $page - 1])); ?>" class="page-link">Previous</a>
                        </li>
                        <?php endif; ?>
                        
                        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <li class="paginate_button page-item <?php echo $i == $page ? 'active' : ''; ?>">
                          <a href="?<?php echo http_build_query(array_merge($_GET, ['page' => $i])); ?>" class="page-link"><?php echo $i; ?></a>
                        </li>
                        <?php endfor; ?>
                        
                        <?php if ($page < $total_pages): ?>
                        <li class="paginate_button page-item next">
                          <a href="?<?php echo http_build_query(array_merge($_GET, ['page' => $page + 1])); ?>" class="page-link">Next</a>
                        </li>
                        <?php endif; ?>
                      </ul>
                    </div>
                  </div>
                </div>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

  <!-- Footer -->
  <?php include("footer.php"); ?>
  <aside class="control-sidebar control-sidebar-dark"></aside>
</div>

<!-- Scripts -->
<script src="./plugins/jquery/jquery.min.js"></script>
<script src="./plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="./plugins/datatables/jquery.dataTables.min.js"></script>
<script src="./plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="./plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="./plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="./plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<script src="./dist/js/adminlte.min.js"></script>
<script src="./dist/js/demo.js"></script>
<script>
  $(function () {
    // Initialize datepicker
    $('input[type="date"]').datepicker({
      format: 'yyyy-mm-dd',
      autoclose: true
    });
    
    // Initialize DataTable
    $('.table').DataTable({
      "paging": false,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": false,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>
</body>
</html>