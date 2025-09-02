<?php
include("session.php");
include('dbcon.php');

// Get invoice number from query parameter
$invoice_number = isset($_GET['invoice_number']) ? $_GET['invoice_number'] : '';

// Check if export is requested
$export_type = isset($_GET['export']) ? $_GET['export'] : '';

// Initialize filter variables
$filter_work_mode = isset($_GET['work_mode']) ? $_GET['work_mode'] : '';
$filter_jina_laini = isset($_GET['jina_laini']) ? $_GET['jina_laini'] : '';
$filter_created_by = isset($_GET['created_by']) ? $_GET['created_by'] : '';
$filter_date_created_from = isset($_GET['date_created_from']) ? $_GET['date_created_from'] : '';
$filter_date_created_to = isset($_GET['date_created_to']) ? $_GET['date_created_to'] : '';
$filter_date_updated_from = isset($_GET['date_updated_from']) ? $_GET['date_updated_from'] : '';
$filter_date_updated_to = isset($_GET['date_updated_to']) ? $_GET['date_updated_to'] : '';

// Build WHERE clause for filtering
$where_conditions = [];
$query_params = [];

if (!empty($filter_work_mode)) {
    $where_conditions[] = "work_mode = ?";
    $query_params[] = $filter_work_mode;
}

if (!empty($filter_jina_laini)) {
    $where_conditions[] = "jina_laini = ?";
    $query_params[] = $filter_jina_laini;
}

if (!empty($filter_created_by)) {
    $where_conditions[] = "created_by = ?";
    $query_params[] = $filter_created_by;
}

if (!empty($filter_date_created_from)) {
    $where_conditions[] = "DATE(created_at) >= ?";
    $query_params[] = $filter_date_created_from;
}

if (!empty($filter_date_created_to)) {
    $where_conditions[] = "DATE(created_at) <= ?";
    $query_params[] = $filter_date_created_to;
}

if (!empty($filter_date_updated_from)) {
    $where_conditions[] = "DATE(updated_at) >= ?";
    $query_params[] = $filter_date_updated_from;
}

if (!empty($filter_date_updated_to)) {
    $where_conditions[] = "DATE(updated_at) <= ?";
    $query_params[] = $filter_date_updated_to;
}

$where_clause = '';
if (!empty($where_conditions)) {
    $where_clause = 'WHERE ' . implode(' AND ', $where_conditions);
}

// Handle Excel Export
if ($export_type === 'excel') {
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="uwakala_report_'.date('Y-m-d').'.xls"');
    header('Cache-Control: max-age=0');
    
    $export_query = "SELECT * FROM uwakala $where_clause ORDER BY created_at DESC";
    $export_stmt = mysqli_prepare($con, $export_query);
    
    if (!empty($query_params)) {
        $types = str_repeat('s', count($query_params));
        mysqli_stmt_bind_param($export_stmt, $types, ...$query_params);
    }
    
    mysqli_stmt_execute($export_stmt);
    $export_result = mysqli_stmt_get_result($export_stmt);
    
    echo "ID\tHali ya Kazi\tJina la Laini\tKiasi Kufungua\tKiasi Kufunga\tKiasi Lipa Account\tKiasi Cash\tJumla\tImeundwa na\tTarehe ya Uundaji\tImesasishwa na\tTarehe ya Usasishaji\n";
    
    while ($row = mysqli_fetch_assoc($export_result)) {
        echo $row['id'] . "\t";
        echo $row['work_mode'] . "\t";
        echo $row['jina_laini'] . "\t";
        echo $row['kiasi_kufungua'] . "\t";
        echo $row['kiasi_kufunga'] . "\t";
        echo $row['kiasi_lipa_account'] . "\t";
        echo $row['kiasi_cash'] . "\t";
        echo $row['jumla'] . "\t";
        echo $row['created_by'] . "\t";
        echo $row['created_at'] . "\t";
        echo ($row['updated_by'] ? $row['updated_by'] : 'N/A') . "\t";
        echo ($row['updated_at'] ? $row['updated_at'] : 'N/A') . "\n";
    }
    
    exit();
}

// Handle PDF Export
if ($export_type === 'pdf') {
    require_once('./tcpdf/tcpdf.php');
    
    $pdf = new TCPDF('L', 'mm', 'A4', true, 'UTF-8', false);
    $pdf->SetCreator('MauzoApp');
    $pdf->SetAuthor('MauzoApp');
    $pdf->SetTitle('Ripoti ya Uwakala');
    $pdf->SetHeaderData('', 0, 'Ripoti ya Uwakala', 'MauzoApp - ' . date('Y-m-d'));
    $pdf->setHeaderFont(Array('helvetica', '', 10));
    $pdf->setFooterFont(Array('helvetica', '', 8));
    $pdf->SetDefaultMonospacedFont('courier');
    $pdf->SetMargins(15, 15, 15);
    $pdf->SetHeaderMargin(5);
    $pdf->SetFooterMargin(10);
    $pdf->SetAutoPageBreak(TRUE, 15);
    $pdf->SetFont('helvetica', '', 8);
    $pdf->AddPage();
    
    $export_query = "SELECT * FROM uwakala $where_clause ORDER BY created_at DESC";
    $export_stmt = mysqli_prepare($con, $export_query);
    
    if (!empty($query_params)) {
        $types = str_repeat('s', count($query_params));
        mysqli_stmt_bind_param($export_stmt, $types, ...$query_params);
    }
    
    mysqli_stmt_execute($export_stmt);
    $export_result = mysqli_stmt_get_result($export_stmt);
    
    $html = '<h2>Ripoti ya Uwakala</h2>';
    $html .= '<p><strong>Muda wa Uchambuzi:</strong> ' . date('Y-m-d H:i:s') . '</p>';
    
    if (!empty($where_conditions)) {
        $html .= '<p><strong>Vichujio:</strong> ';
        $filters = [];
        if (!empty($filter_work_mode)) $filters[] = "Hali ya Kazi: $filter_work_mode";
        if (!empty($filter_jina_laini)) $filters[] = "Laini: $filter_jina_laini";
        if (!empty($filter_created_by)) $filters[] = "Mtumiaji: $filter_created_by";
        if (!empty($filter_date_created_from)) $filters[] = "Tarehe ya Kuanzia: $filter_date_created_from";
        if (!empty($filter_date_created_to)) $filters[] = "Tarehe ya Mpaka: $filter_date_created_to";
        $html .= implode(', ', $filters) . '</p>';
    }
    
    $html .= '<table border="1" cellpadding="4">';
    $html .= '<tr style="background-color:#f2f2f2;">';
    $html .= '<th>ID</th><th>Hali ya Kazi</th><th>Jina la Laini</th><th>Kiasi Kufungua</th><th>Kiasi Kufunga</th>';
    $html .= '<th>Kiasi Lipa Account</th><th>Kiasi Cash</th><th>Jumla</th><th>Imeundwa na</th><th>Tarehe ya Uundaji</th>';
    $html .= '<th>Imesasishwa na</th><th>Tarehe ya Usasishaji</th>';
    $html .= '</tr>';
    
    $grant_total_kufungua = 0;
    $grant_total_kufunga = 0;
    $grant_total_lipa_account = 0;
    $grant_total_cash = 0;
    $grant_total_jumla = 0;
    
    while ($row = mysqli_fetch_assoc($export_result)) {
        $html .= '<tr>';
        $html .= '<td>' . $row['id'] . '</td>';
        $html .= '<td>' . $row['work_mode'] . '</td>';
        $html .= '<td>' . $row['jina_laini'] . '</td>';
        $html .= '<td>' . number_format($row['kiasi_kufungua'], 2) . '</td>';
        $html .= '<td>' . number_format($row['kiasi_kufunga'], 2) . '</td>';
        $html .= '<td>' . number_format($row['kiasi_lipa_account'], 2) . '</td>';
        $html .= '<td>' . number_format($row['kiasi_cash'], 2) . '</td>';
        $html .= '<td>' . number_format($row['jumla'], 2) . '</td>';
        $html .= '<td>' . $row['created_by'] . '</td>';
        $html .= '<td>' . date('d/m/Y H:i', strtotime($row['created_at'])) . '</td>';
        $html .= '<td>' . ($row['updated_by'] ? $row['updated_by'] : 'N/A') . '</td>';
        $html .= '<td>' . ($row['updated_at'] ? date('d/m/Y H:i', strtotime($row['updated_at'])) : 'N/A') . '</td>';
        $html .= '</tr>';
        
        $grant_total_kufungua += $row['kiasi_kufungua'];
        $grant_total_kufunga += $row['kiasi_kufunga'];
        $grant_total_lipa_account += $row['kiasi_lipa_account'];
        $grant_total_cash += $row['kiasi_cash'];
        $grant_total_jumla += $row['jumla'];
    }
    
    $html .= '<tr style="background-color:#f8f9fa;font-weight:bold;">';
    $html .= '<td colspan="3">Jumla Kuu</td>';
    $html .= '<td>' . number_format($grant_total_kufungua, 2) . '</td>';
    $html .= '<td>' . number_format($grant_total_kufunga, 2) . '</td>';
    $html .= '<td>' . number_format($grant_total_lipa_account, 2) . '</td>';
    $html .= '<td>' . number_format($grant_total_cash, 2) . '</td>';
    $html .= '<td>' . number_format($grant_total_jumla, 2) . '</td>';
    $html .= '<td colspan="4"></td>';
    $html .= '</tr>';
    
    $html .= '</table>';
    
    $pdf->writeHTML($html, true, false, true, false, '');
    $pdf->Output('uwakala_report_'.date('Y-m-d').'.pdf', 'D');
    exit();
}

// Pagination settings for normal view
$records_per_page = isset($_GET['records_per_page']) ? (int)$_GET['records_per_page'] : 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start_from = ($page - 1) * $records_per_page;

// Get total records count
$count_query = "SELECT COUNT(*) as total FROM uwakala $where_clause";
$count_stmt = mysqli_prepare($con, $count_query);

if (!empty($query_params)) {
    $types = str_repeat('s', count($query_params));
    mysqli_stmt_bind_param($count_stmt, $types, ...$query_params);
}

mysqli_stmt_execute($count_stmt);
$count_result = mysqli_stmt_get_result($count_stmt);
$total_records = mysqli_fetch_assoc($count_result)['total'];
$total_pages = ceil($total_records / $records_per_page);

// Get records with pagination
$data_query = "SELECT * FROM uwakala $where_clause ORDER BY created_at DESC LIMIT ?, ?";
$query_params_pagination = $query_params;
$query_params_pagination[] = $start_from;
$query_params_pagination[] = $records_per_page;

$data_stmt = mysqli_prepare($con, $data_query);
$types = str_repeat('s', count($query_params)) . 'ii';
mysqli_stmt_bind_param($data_stmt, $types, ...$query_params_pagination);
mysqli_stmt_execute($data_stmt);
$result = mysqli_stmt_get_result($data_stmt);

// Calculate grant totals
$grant_total_kufungua = 0;
$grant_total_kufunga = 0;
$grant_total_lipa_account = 0;
$grant_total_cash = 0;
$grant_total_jumla = 0;

while ($row = mysqli_fetch_assoc($result)) {
    $grant_total_kufungua += $row['kiasi_kufungua'];
    $grant_total_kufunga += $row['kiasi_kufunga'];
    $grant_total_lipa_account += $row['kiasi_lipa_account'];
    $grant_total_cash += $row['kiasi_cash'];
    $grant_total_jumla += $row['jumla'];
}

// Reset result pointer for display
mysqli_data_seek($result, 0);

// Get unique values for filter dropdowns
$work_modes = mysqli_query($con, "SELECT DISTINCT work_mode FROM uwakala ORDER BY work_mode");
$jina_laini_values = mysqli_query($con, "SELECT DISTINCT jina_laini FROM uwakala ORDER BY jina_laini");
$created_by_values = mysqli_query($con, "SELECT DISTINCT created_by FROM uwakala ORDER BY created_by");
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>MauzoApp - Uwakala Reports</title>
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
    .table-total {
        font-weight: bold;
        background-color: #f8f9fa;
    }
    .filter-form {
        background-color: #f8f9fa;
        padding: 15px;
        border-radius: 5px;
        margin-bottom: 20px;
    }
    .export-buttons {
        margin-bottom: 15px;
    }
  </style>
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
            <h1>Ripoti ya Uwakala</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Ripoti ya Uwakala</li>
            </ol>
          </div>
        </div>
      </div>
    </section>
    <section class="content">
      <div class="container-fluid">
        <!-- Filter Form -->
        <div class="card filter-form">
          <div class="card-header">
            <h3 class="card-title">Chagua Filter</h3>
          </div>
          <div class="card-body">
            <form method="GET" action="">
              <input type="hidden" name="invoice_number" value="<?php echo $invoice_number; ?>">
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label>Hali ya Kazi</label>
                    <select name="work_mode" class="form-control">
                      <option value="">Chagua Hali ya Kazi</option>
                      <?php 
                      $work_modes_display = mysqli_query($con, "SELECT DISTINCT work_mode FROM uwakala ORDER BY work_mode");
                      while ($mode = mysqli_fetch_assoc($work_modes_display)): ?>
                        <option value="<?php echo $mode['work_mode']; ?>" <?php echo $filter_work_mode == $mode['work_mode'] ? 'selected' : ''; ?>>
                          <?php echo ucfirst($mode['work_mode']); ?>
                        </option>
                      <?php endwhile; ?>
                    </select>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label>Jina la Laini</label>
                    <select name="jina_laini" class="form-control">
                      <option value="">Chagua Laini</option>
                      <?php 
                      $jina_laini_display = mysqli_query($con, "SELECT DISTINCT jina_laini FROM uwakala ORDER BY jina_laini");
                      while ($laini = mysqli_fetch_assoc($jina_laini_display)): ?>
                        <option value="<?php echo $laini['jina_laini']; ?>" <?php echo $filter_jina_laini == $laini['jina_laini'] ? 'selected' : ''; ?>>
                          <?php echo $laini['jina_laini']; ?>
                        </option>
                      <?php endwhile; ?>
                    </select>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label>Imeundwa na</label>
                    <select name="created_by" class="form-control">
                      <option value="">Chagua Mtumiaji</option>
                      <?php 
                      $created_by_display = mysqli_query($con, "SELECT DISTINCT created_by FROM uwakala ORDER BY created_by");
                      while ($user = mysqli_fetch_assoc($created_by_display)): ?>
                        <option value="<?php echo $user['created_by']; ?>" <?php echo $filter_created_by == $user['created_by'] ? 'selected' : ''; ?>>
                          <?php echo $user['created_by']; ?>
                        </option>
                      <?php endwhile; ?>
                    </select>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label>Rekodi kwa Ukurasa</label>
                    <select name="records_per_page" class="form-control" onchange="this.form.submit()">
                      <option value="10" <?php echo $records_per_page == 10 ? 'selected' : ''; ?>>10</option>
                      <option value="25" <?php echo $records_per_page == 25 ? 'selected' : ''; ?>>25</option>
                      <option value="50" <?php echo $records_per_page == 50 ? 'selected' : ''; ?>>50</option>
                      <option value="100" <?php echo $records_per_page == 100 ? 'selected' : ''; ?>>100</option>
                      <option value="250" <?php echo $records_per_page == 250 ? 'selected' : ''; ?>>250</option>
                      <option value="<?php echo $total_records; ?>" <?php echo $records_per_page == $total_records ? 'selected' : ''; ?>>Zote (<?php echo $total_records; ?>)</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label>Tarehe ya Kuanzia (Uundaji)</label>
                    <input type="date" name="date_created_from" class="form-control" value="<?php echo $filter_date_created_from; ?>">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label>Tarehe ya Mpaka (Uundaji)</label>
                    <input type="date" name="date_created_to" class="form-control" value="<?php echo $filter_date_created_to; ?>">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label>Tarehe ya Kuanzia (Usasishaji)</label>
                    <input type="date" name="date_updated_from" class="form-control" value="<?php echo $filter_date_updated_from; ?>">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label>Tarehe ya Mpaka (Usasishaji)</label>
                    <input type="date" name="date_updated_to" class="form-control" value="<?php echo $filter_date_updated_to; ?>">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <button type="submit" class="btn btn-primary">Tafuta</button>
                  <a href="report_uwakala_management.php?invoice_number=<?php echo $invoice_number; ?>" class="btn btn-secondary">Safisha Filter</a>
                  
                  <!-- Export Buttons -->
                  <div class="btn-group export-buttons">
                    <a href="?<?php echo http_build_query(array_merge($_GET, ['export' => 'excel'])); ?>" class="btn btn-success">
                      <i class="fas fa-file-excel"></i> Pakua Excel
                    </a>
                    <!-- <a href="?<?php echo http_build_query(array_merge($_GET, ['export' => 'pdf'])); ?>" class="btn btn-danger">
                      <i class="fas fa-file-pdf"></i> Pakua PDF
                    </a> -->
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>

        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-body">
                <table class="table table-bordered table-striped">
                  <thead>
                    <tr class="table-success">
                      <th>ID</th>
                      <th>Hali ya Kazi</th>
                      <th>Jina la Laini</th>
                      <th>Kiasi Kufungua</th>
                      <th>Kiasi Kufunga</th>
                      <th>Kiasi Lipa Account</th>
                      <th>Kiasi Cash</th>
                      <th>Jumla</th>
                      <th>Imeundwa na</th>
                      <th>Tarehe ya Uundaji</th>
                      <th>Imesasishwa na</th>
                      <th>Tarehe ya Usasishaji</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                      <td><?php echo $row['id']; ?></td>
                      <td><?php echo ucfirst($row['work_mode']); ?></td>
                      <td><?php echo $row['jina_laini']; ?></td>
                      <td><?php echo number_format($row['kiasi_kufungua'], 2); ?></td>
                      <td><?php echo number_format($row['kiasi_kufunga'], 2); ?></td>
                      <td><?php echo number_format($row['kiasi_lipa_account'], 2); ?></td>
                      <td><?php echo number_format($row['kiasi_cash'], 2); ?></td>
                      <td><?php echo number_format($row['jumla'], 2); ?></td>
                      <td><?php echo $row['created_by']; ?></td>
                      <td><?php echo date('d/m/Y H:i', strtotime($row['created_at'])); ?></td>
                      <td><?php echo $row['updated_by'] ? $row['updated_by'] : 'N/A'; ?></td>
                      <td><?php echo $row['updated_at'] ? date('d/m/Y H:i', strtotime($row['updated_at'])) : 'N/A'; ?></td>
                    </tr>
                    <?php endwhile; ?>
                  </tbody>
                  <tfoot>
                    <tr class="table-total">
                      <td colspan="3"><strong>Jumla Kuu:</strong></td>
                      <td><strong><?php echo number_format($grant_total_kufungua, 2); ?></strong></td>
                      <td><strong><?php echo number_format($grant_total_kufunga, 2); ?></strong></td>
                      <td><strong><?php echo number_format($grant_total_lipa_account, 2); ?></strong></td>
                      <td><strong><?php echo number_format($grant_total_cash, 2); ?></strong></td>
                      <td><strong><?php echo number_format($grant_total_jumla, 2); ?></strong></td>
                      <td colspan="4"></td>
                    </tr>
                  </tfoot>
                </table>

                <!-- Pagination -->
                <div class="row">
                  <div class="col-md-6">
                    <p>Onesha <?php echo min($start_from + 1, $total_records); ?> hadi <?php echo min($start_from + $records_per_page, $total_records); ?> ya <?php echo $total_records; ?> rekodi</p>
                  </div>
                  <div class="col-md-6">
                    <nav aria-label="Page navigation">
                      <ul class="pagination justify-content-end">
                        <?php if ($page > 1): ?>
                          <li class="page-item">
                            <a class="page-link" href="?<?php echo http_build_query(array_merge($_GET, ['page' => $page - 1])); ?>">Awali</a>
                          </li>
                        <?php endif; ?>

                        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                          <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>">
                            <a class="page-link" href="?<?php echo http_build_query(array_merge($_GET, ['page' => $i])); ?>"><?php echo $i; ?></a>
                          </li>
                        <?php endfor; ?>

                        <?php if ($page < $total_pages): ?>
                          <li class="page-item">
                            <a class="page-link" href="?<?php echo http_build_query(array_merge($_GET, ['page' => $page + 1])); ?>">Ijayo</a>
                          </li>
                        <?php endif; ?>
                      </ul>
                    </nav>
                  </div>
                </div>
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
<script src="./dist/js/adminlte.min.js"></script>
<script src="./dist/js/demo.js"></script>
<script>
  $(document).ready(function() {
    // Initialize DataTables
    $('.table').DataTable({
      "paging": false,
      "searching": false,
      "ordering": true,
      "info": false,
      "autoWidth": false,
      "responsive": true
    });
  });
</script>
</body>
</html>