<?php
include("session.php");
include("dbcon.php");
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
    .search-box {
      margin-bottom: 20px;
    }
    .search-box input {
      width: 300px;
      padding: 8px;
      border: 1px solid #ddd;
      border-radius: 4px;
    }
  </style>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Navbar -->
  <?php include('cashierNavBar.php') ?>
  
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid"> 
        <div class="row mb-2">
          <div class="col-sm-6">					
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <!-- Breadcrumb items -->
            </ol>
          </div>
        </div>
      </div>
      
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-body">
                <div class="card-header">
                  <h3 class="card-title"><b>Orodha ya Dawa zote zilizopo stoo</b></h3>
                </div>
                
                <?php include ('modal_expenditure.php');?>
                
                <div class="card-body table-responsive">
                  <!-- Search Box -->
                  <div class="search-box">
    <form method="GET" action="">
        <!-- Preserve all existing GET parameters as hidden fields -->
        <?php foreach($_GET as $key => $value): ?>
            <?php if($key != 'search' && $key != 'page'): ?>
                <input type="hidden" name="<?php echo htmlspecialchars($key); ?>" value="<?php echo htmlspecialchars($value); ?>">
            <?php endif; ?>
        <?php endforeach; ?>
        
        <input type="text" name="search" placeholder="Tafuta Dawa..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
        <button type="submit" class="btn btn-primary">Tafuta</button>
        <?php if(isset($_GET['search'])): ?>
            <a href="?<?php echo http_build_query(array_diff_key($_GET, ['search' => '', 'page' => ''])); ?>" class="btn btn-default">Ondoa utafutaji</a>
        <?php endif; ?>
    </form>
</div>
                  
                  <div class="hero-unit-table">   
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                      <thead>
                      <tr class="table-success">   
                          <th width="1%">#</th>        
                          <th width="3%">Dawa</th>
                          <th width="1%">Aina ya Dawa</th>
                          <th width="1%">Idadi iliyobaki</th>
                          <th width="2%">Bei ya kuuzia</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php  
                        // Get search term if exists
                        $search = isset($_GET['search']) ? trim($_GET['search']) : '';
                        
                        // Get current page number from URL, default to 1 if not set
                        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                        $perPage = isset($_GET['per_page']) ? (int)$_GET['per_page'] : 10;
                        
                        // Base SQL query
                        $sql = "SELECT id, medicine_name, category, act_remain_quantity, selling_price FROM stock where store_id = '$store_id'";
                        
                        // Add search condition if search term exists
                        if (!empty($search)) {
                          $sql .= " WHERE medicine_name LIKE '%" . mysqli_real_escape_string($con, $search) . "%' 
                                    OR category LIKE '%" . mysqli_real_escape_string($con, $search) . "%'";
                        }
                        
                        $sql .= " ORDER BY medicine_name";
                        
                        // Get total number of records
                        $totalQuery = str_replace("SELECT id, medicine_name, category, act_remain_quantity, selling_price", 
                                                  "SELECT COUNT(*) as total", $sql);
                        $totalResult = mysqli_query($con, $totalQuery);
                        $totalRow = mysqli_fetch_assoc($totalResult);
                        $totalRecords = $totalRow['total'];
                        
                        // Calculate total pages - if "All" is selected, show just 1 page
                        $totalPages = ($perPage == -1) ? 1 : ceil($totalRecords / $perPage);
                        
                        // Calculate offset for pagination
                        $offset = ($page - 1) * $perPage;
                        
                        // Add LIMIT clause only if not showing all records
                        if ($perPage != -1) {
                            $sql .= " LIMIT $perPage OFFSET $offset";
                        }
                        
                        $result = mysqli_query($con, $sql); 
                        
                        // Calculate starting serial number
                        $serialNumber = ($page - 1) * (($perPage == -1) ? $totalRecords : $perPage) + 1;
                        
                        // Display records
                        while ($row = mysqli_fetch_array($result)) : 
                        ?>
                          <tr>
                            <td><?php echo $serialNumber++; ?></td>
                            <td><?php echo htmlspecialchars($row['medicine_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['category']); ?></td>
                            <td><?php echo htmlspecialchars($row['act_remain_quantity']); ?></td>
                            <td><?php echo number_format($row['selling_price']); ?></td>
                          </tr>
                        <?php endwhile; ?>
                        
                        <?php if(mysqli_num_rows($result) == 0): ?>
                          <tr>
                            <td colspan="5" class="text-center">Hakuna Dawa zilizopatikana</td>
                          </tr>
                        <?php endif; ?>
                      </tbody>
                    </table>
                    
                    <!-- Pagination controls - only show if not showing all records and more than one page exists -->
                    <?php if ($perPage != -1 && $totalPages > 1): ?>
                    <div class="row">
                      <div class="col-sm-12 col-md-5">
                        <div class="dataTables_info" id="example1_info" role="status" aria-live="polite">
                          Onyesha <?php echo ($offset + 1); ?> hadi <?php echo min($offset + $perPage, $totalRecords); ?> ya <?php echo $totalRecords; ?> ingizo
                        </div>
                      </div>
                      <div class="col-sm-12 col-md-7">
                        <div class="dataTables_paginate paging_simple_numbers" id="example1_paginate">
                          <ul class="pagination">
                            <?php if ($page > 1): ?>
                              <li class="paginate_button page-item previous" id="example1_previous">
                                <a href="?<?php echo buildQueryString(array('page' => $page - 1)); ?>" aria-controls="example1" data-dt-idx="0" tabindex="0" class="page-link">Previous</a>
                              </li>
                            <?php endif; ?>
                            
                            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                              <li class="paginate_button page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                                <a href="?<?php echo buildQueryString(array('page' => $i)); ?>" aria-controls="example1" data-dt-idx="<?php echo $i; ?>" tabindex="0" class="page-link"><?php echo $i; ?></a>
                              </li>
                            <?php endfor; ?>
                            
                            <?php if ($page < $totalPages): ?>
                              <li class="paginate_button page-item next" id="example1_next">
                                <a href="?<?php echo buildQueryString(array('page' => $page + 1)); ?>" aria-controls="example1" data-dt-idx="<?php echo $totalPages + 1; ?>" tabindex="0" class="page-link">Next</a>
                              </li>
                            <?php endif; ?>
                          </ul>
                        </div>
                      </div>
                    </div>
                    <?php elseif ($perPage == -1): ?>
                    <div class="row">
                      <div class="col-sm-12 col-md-5">
                        <div class="dataTables_info" id="example1_info" role="status" aria-live="polite">
                          Onyesha zote <?php echo $totalRecords; ?> ingizo
                        </div>
                      </div>
                    </div>
                    <?php endif; ?>
                    
                    <!-- Page length selector -->
                    <div class="row">
                      <div class="col-sm-12 col-md-6">
                        <div class="dataTables_length" id="example1_length">
                          <label>Onyesha 
                            <select name="example1_length" aria-controls="example1" class="custom-select custom-select-sm form-control form-control-sm" onchange="changePerPage(this.value)">
                              <option value="10" <?php echo ($perPage == 10) ? 'selected' : ''; ?>>10</option>
                              <option value="25" <?php echo ($perPage == 25) ? 'selected' : ''; ?>>25</option>
                              <option value="50" <?php echo ($perPage == 50) ? 'selected' : ''; ?>>50</option>
                              <option value="100" <?php echo ($perPage == 100) ? 'selected' : ''; ?>>100</option>
                              <option value="-1" <?php echo ($perPage == -1) ? 'selected' : ''; ?>>Zote</option>
                            </select> ingizo
                          </label>
                        </div>
                      </div>
                    </div>
                    
                    <div class="export-buttons">
                      <a href="cashier_export_stock_level.php" class="btn btn-danger">Pakua taharifa ya stoo</a>
                    </div>  
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

<!-- Helper function to build query string -->
<?php
function buildQueryString($newParams = array()) {
  $params = $_GET;
  foreach ($newParams as $key => $value) {
    $params[$key] = $value;
  }
  return http_build_query($params);
}
?>

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
function changePerPage(value) {
  var url = new URL(window.location.href);
  url.searchParams.set('per_page', value);
  url.searchParams.set('page', 1); // Reset to first page when changing items per page
  window.location.href = url.toString();
}

// Initialize DataTable with searching disabled (since we have our own search)
$(function () {
  $("#dataTables-example").DataTable({
    "responsive": true,
    "autoWidth": false,
    "paging": false, // Disable DataTables pagination since we have custom pagination
    "searching": false, // Disable DataTables search since we have our own
    "ordering": true,
    "info": false
  });
});
</script>
</body>
</html>