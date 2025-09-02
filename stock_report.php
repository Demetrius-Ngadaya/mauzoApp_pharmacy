<?php
include("session.php");

// Pagination settings
$records_per_page = isset($_GET['records_per_page']) ? (int)$_GET['records_per_page'] : 10;
if($records_per_page <= 0) $records_per_page = 10;

// Current page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if($page <= 0) $page = 1;

// Calculate offset
$offset = ($page - 1) * $records_per_page;

// Initialize filter variables
$created_by = isset($_POST['created_by']) ? $_POST['created_by'] : (isset($_GET['created_by']) ? $_GET['created_by'] : '');
$medicine_name = isset($_POST['medicine_name']) ? $_POST['medicine_name'] : (isset($_GET['medicine_name']) ? $_GET['medicine_name'] : '');
$company = isset($_POST['company']) ? $_POST['company'] : (isset($_GET['company']) ? $_GET['company'] : '');
$category = isset($_POST['category']) ? $_POST['category'] : (isset($_GET['category']) ? $_GET['category'] : '');
$store_location = isset($_POST['store_location']) ? $_POST['store_location'] : (isset($_GET['store_location']) ? $_GET['store_location'] : '');
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
    .pagination-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin: 15px 0;
    }
    .records-per-page {
        display: flex;
        align-items: center;
    }
    .records-per-page select {
        margin: 0 10px;
        padding: 5px;
    }
    .pagination {
        margin: 0;
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
  </script>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Navbar -->
  

<?php include("navbar.php"); ?>   
<?php include('indexSideBar.php') ?>
  <!-- /.navbar -->

  

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

              <!-- /.card-header -->
              <section class="content">
                <div class="container-fluid">
                  <div class="row">
                    <div class="col-12">
                      <div class="card">
                        <div class="card-header">
                        <div class="card-header">
                <h3 class="card-title"><b>Ripoti ya Dawa</b></h3>
              </div>
                          <center>
                          <form action="stock_report.php?invoice_number=<?php echo $_GET['invoice_number']?>" method="POST" class="form-inline">
                            <div class="form-group">
                              <label for="created_by" class="sr-only">Aliye ingiza Dawa:</label>
                              <input type="text" id="created_by" name="created_by" class="form-control" placeholder="Aliye ingiza Dawa" autocomplete="off" value="<?php echo htmlspecialchars($created_by); ?>">
                            </div>
                            <div class="form-group">
                              <label for="customer_name" class="sr-only">Msambazaji:</label>
                              <input type="text" id="company" name="company" class="form-control" placeholder="Msambazaji" autocomplete="off" value="<?php echo htmlspecialchars($company); ?>">
                            </div>
                            <div class="form-group">
                              <label for="medicine" class="sr-only">Dawa:</label>
                              <input type="text" id="medicine_name" name="medicine_name" class="form-control" placeholder="Dawa" autocomplete="off" value="<?php echo htmlspecialchars($medicine_name); ?>">
                            </div>
                            <div class="form-group">
                              <label for="category" class="sr-only">Aina ya Dawa:</label>
                              <input type="text" id="category" name="category" class="form-control" placeholder="Aina ya Dawa" autocomplete="off" value="<?php echo htmlspecialchars($category); ?>">
                            </div>
                            <div class="form-group">
                              <label for="store_location" class="sr-only">Kituo/Tawi:</label>
                              <input type="text" id="store_location" name="store_location" class="form-control" placeholder="Jina la Kituo/Tawi" autocomplete="off">
                          </div>
                            <div class="form-group">
                              <button class="btn btn-info" type="submit" name="submit"><i class="icon icon-search icon-large"></i> Tafuta</button>
                            </div>
                          </form>
                          </center>

                          <div style="overflow-x:auto; overflow-y: auto;">
                            <!-- Add records per page selector -->
                            <div class="pagination-container">
                                <div class="records-per-page">
                                    <span>Onesha:</span>
                                    <select onchange="changeRecordsPerPage(this.value)">
                                        <option value="10" <?php echo $records_per_page == 10 ? 'selected' : ''; ?>>10</option>
                                        <option value="25" <?php echo $records_per_page == 25 ? 'selected' : ''; ?>>25</option>
                                        <option value="50" <?php echo $records_per_page == 50 ? 'selected' : ''; ?>>50</option>
                                        <option value="100" <?php echo $records_per_page == 100 ? 'selected' : ''; ?>>100</option>
                                    </select>
                                    <span>rekodi kwa kila ukurasa</span>
                                </div>
                            </div>

                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                <tr class="table-success">
                                        <th width="3%">#</th>
                                        <th width="6%">Dawa</th>
                                        <th width="2%">Kituo/Tawi</th>
                                        <!-- <th width="2%">Aina ya Dawa</th> -->
                                        <th width="2%">Msambazaji</th>
                                        <th width="2%">Idadi iliyosajiriwa</th>
                                        <th width="2%">Idadi iliyouzwa</th>
                                        <th width="2%">Idadi iliyobaki</th>
                                        <th width="2%">Tarehe iliyosajiliwa</th>
                                        <th width="2%">Bei ya kununuliwa</th>
                                        <th width="2%">Bei ya kuuzia</th>
                                        <th width="2%">Faida</th>
                                        <th width="2%">Thamani kwa bei kununulia</th>
                                        <th width="2%">Thamani kwa bei kuuzia</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    include("dbcon.php");
                                    error_reporting(1);

                                    // Initialize totals
                                    $total_quantity = 0;
                                    $total_sold = 0;
                                    $total_remain = 0;
                                    $total_act_price = 0;
                                    $total_sell_price = 0;
                                    $total_profit = 0;
                                    $product_value_by_act_price = 0;
                                    $product_value_by_selling_price = 0;

                                    // Build the SQL query
// Build the main SQL query
// Build the main SQL query
$select_sql = "SELECT stock.*, stores.location  
               FROM stock
               JOIN stores ON stock.store_id = stores.id
               WHERE 1=1";  // Changed from WHERE stock.store_id = '$store_id'

if (!empty($created_by)) {
    $select_sql .= " AND created_by LIKE '%$created_by%'";
}
if (!empty($company)) {
    $select_sql .= " AND company LIKE '%$company%'";
}
if (!empty($medicine_name)) {
    $select_sql .= " AND medicine_name LIKE '%$medicine_name%'";
}
if (!empty($category)) {
    $select_sql .= " AND category LIKE '%$category%'";
}
if (!empty($store_location)) {
    $select_sql .= " AND stores.location LIKE '%$store_location%'";
}

// Add ORDER BY and LIMIT (only once)
$select_sql .= " ORDER BY stock.id DESC LIMIT $offset, $records_per_page";

// Count total records 
$count_sql = "SELECT COUNT(*) as total  
              FROM stock 
              JOIN stores ON stock.store_id = stores.id 
              WHERE 1=1";  // Changed from WHERE stock.store_id = '$store_id'

if (!empty($created_by)) {
    $count_sql .= " AND created_by LIKE '%$created_by%'";
}
if (!empty($company)) {
    $count_sql .= " AND company LIKE '%$company%'";
}
if (!empty($medicine_name)) {
    $count_sql .= " AND medicine_name LIKE '%$medicine_name%'";
}
if (!empty($category)) {
    $count_sql .= " AND category LIKE '%$category%'";
}
if (!empty($store_location)) {
    $count_sql .= " AND stores.location LIKE '%$store_location%'";
}

$count_query = mysqli_query($con, $count_sql);
$total_records = mysqli_fetch_assoc($count_query)['total'];
$total_pages = ceil($total_records / $records_per_page);

$select_query = mysqli_query($con, $select_sql);
$serial_number = $offset + 1;
                                    while($row = mysqli_fetch_array($select_query)) :
                                        $quantity = $row['quantity'];
                                        $used_quantity = $row['used_quantity'];
                                        $remain_quantity = $row['act_remain_quantity'];
                                        $actual_price = $row['actual_price'];
                                        $selling_price = $row['selling_price'];
                                        $profit_price = $row['profit_price'];
                                        // $store_id = $_SESSION['store_id'];
                                        $value_act_price = $actual_price * $remain_quantity;
                                        $value_sell_price = $selling_price * $remain_quantity;
                                        
                                        // Update totals
                                        $total_quantity += $quantity;
                                        $total_sold += $used_quantity;
                                        $total_remain += $remain_quantity;
                                        $total_act_price += $actual_price;
                                        $total_sell_price += $selling_price;
                                        $total_profit += $profit_price;
                                        $product_value_by_act_price += $value_act_price;
                                        $product_value_by_selling_price += $value_sell_price;
                                    ?>
                                    <tr>
                                        <td><?php echo $serial_number++; ?></td>
                                        <td><?php echo htmlspecialchars($row['medicine_name']); ?></td>
                                        <td><?php echo htmlspecialchars($row['location']); ?></td>
                                        <td><?php echo htmlspecialchars($row['company']); ?></td>
                                        <td><?php echo $quantity."&nbsp;&nbsp;(<strong><i>".htmlspecialchars($row['sell_type'])."</i></strong>)"; ?></td>
                                        <td><?php echo $used_quantity; ?></td>
                                        <td><?php echo $remain_quantity; ?></td>
                                        <td><?php echo date("d-m-Y", strtotime($row['register_date'])); ?></td>
                                        <td><?php echo number_format($actual_price); ?></td>
                                        <td><?php echo number_format($selling_price); ?></td>
                                        <td><?php echo $profit_price; ?></td>
                                        <td><?php echo number_format($value_act_price); ?></td>
                                        <td><?php echo number_format($value_sell_price); ?></td>
                                    </tr>
                                    <?php endwhile; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="4">Jumla Mkuu:</th>
                                        <th><?php echo number_format($total_quantity); ?></th>
                                        <th><?php echo number_format($total_sold); ?></th>
                                        <th><?php echo number_format($total_remain); ?></th>
                                        <th colspan="4"></th>
                                        <th><?php echo number_format($product_value_by_act_price); ?></th>
                                        <th><?php echo number_format($product_value_by_selling_price); ?></th>
                                    </tr>
                                </tfoot>
                            </table>

                            <!-- Pagination links -->
                            <div class="pagination-container">
                                <div>
                                    <?php
                                    $query_string = $_SERVER['QUERY_STRING'];
                                    $query_array = explode('&', $query_string);
                                    $new_query_array = array();
                                    foreach($query_array as $key => $string) {
                                        if(!strstr($string, "page=") && !strstr($string, "records_per_page=")) {
                                            $new_query_array[] = $string;
                                        }
                                    }
                                    $query_string = implode('&', $new_query_array);
                                    
                                    // Add the current filters to pagination links
                                    $filter_params = '';
                                    if (!empty($created_by)) $filter_params .= '&created_by='.urlencode($created_by);
                                    if (!empty($medicine_name)) $filter_params .= '&medicine_name='.urlencode($medicine_name);
                                    if (!empty($company)) $filter_params .= '&company='.urlencode($company);
                                    if (!empty($category)) $filter_params .= '&category='.urlencode($category);
                                    if (!empty($store_location)) $filter_params .= '&stores.location='.urlencode($store_location);
                                    
                                    // Previous page link
                                    if($page > 1) {
                                        echo '<a href="?'.$query_string.$filter_params.'&page='.($page - 1).'&records_per_page='.$records_per_page.'" class="btn btn-primary">Previous</a> ';
                                    }
                                    
                                    // Page numbers
                                    $visible_pages = 5;
                                    $start_page = max(1, $page - floor($visible_pages/2));
                                    $end_page = min($total_pages, $start_page + $visible_pages - 1);
                                    
                                    if($start_page > 1) {
                                        echo '<a href="?'.$query_string.$filter_params.'&page=1&records_per_page='.$records_per_page.'" class="btn btn-default">1</a> ';
                                        if($start_page > 2) echo '<span>...</span> ';
                                    }
                                    
                                    for($i = $start_page; $i <= $end_page; $i++) {
                                        if($i == $page) {
                                            echo '<a href="?'.$query_string.$filter_params.'&page='.$i.'&records_per_page='.$records_per_page.'" class="btn btn-primary active">'.$i.'</a> ';
                                        } else {
                                            echo '<a href="?'.$query_string.$filter_params.'&page='.$i.'&records_per_page='.$records_per_page.'" class="btn btn-default">'.$i.'</a> ';
                                        }
                                    }
                                    
                                    if($end_page < $total_pages) {
                                        if($end_page < $total_pages - 1) echo '<span>...</span> ';
                                        echo '<a href="?'.$query_string.$filter_params.'&page='.$total_pages.'&records_per_page='.$records_per_page.'" class="btn btn-default">'.$total_pages.'</a> ';
                                    }
                                    
                                    // Next page link
                                    if($page < $total_pages) {
                                        echo '<a href="?'.$query_string.$filter_params.'&page='.($page + 1).'&records_per_page='.$records_per_page.'" class="btn btn-primary">Next</a> ';
                                    }
                                    ?>
                                </div>
                                <div>
                                    Jumla ya rekodi: <?php echo $total_records; ?>
                                </div>
                            </div>

                            <center>
                                <div class="export-buttons">
                                    <a href="export_stock_excel.php?created_by=<?php echo urlencode($created_by); ?>&medicine_name=<?php echo urlencode($medicine_name); ?>&company=<?php echo urlencode($company); ?>&category=<?php echo urlencode($category); ?>&store_location=<?php echo urlencode($store_location); ?>" class="btn btn-success">Pakua katika Excel</a>
                                    <a href="export_stock_pdf.php?created_by=<?php echo urlencode($created_by); ?>&medicine_name=<?php echo urlencode($medicine_name); ?>&company=<?php echo urlencode($company); ?>&category=<?php echo urlencode($category); ?>&store_location=<?php echo urlencode($store_location); ?>" class="btn btn-danger">Pakua katika PDF</a>
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
<script>
    function changeRecordsPerPage(value) {
        const urlParams = new URLSearchParams(window.location.search);
        urlParams.set('records_per_page', value);
        urlParams.set('page', 1); // Reset to first page when changing records per page
        
        // Preserve filter parameters
        <?php if(!empty($created_by)): ?>
            urlParams.set('created_by', '<?php echo urlencode($created_by); ?>');
        <?php endif; ?>
        <?php if(!empty($medicine_name)): ?>
            urlParams.set('medicine_name', '<?php echo urlencode($medicine_name); ?>');
        <?php endif; ?>
        <?php if(!empty($company)): ?>
            urlParams.set('company', '<?php echo urlencode($company); ?>');
        <?php endif; ?>
        <?php if(!empty($category)): ?>
            urlParams.set('category', '<?php echo urlencode($category); ?>');
        <?php endif; ?>
        
        window.location.search = urlParams.toString();
    }
</script>
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