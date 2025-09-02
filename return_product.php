<?php
include("session.php");
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
  <style>
    .pagination {
      margin-top: 20px;
    }
    .pagination .page-link {
      color: #007bff;
      border: 1px solid #007bff;
    }
    .pagination .page-item.active .page-link {
      background-color: #007bff;
      color: white;
    }
    .pagination .page-item.disabled .page-link {
      color: #6c757d;
      pointer-events: none;
    }
    .pagination .form-group {
      margin-top: 10px;
    }
  </style>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Navbar -->
 


  <?php include("navbar.php"); ?>   
<?php include('indexSideBar.php') ?>
  <!-- Content Wrapper -->
  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid"> 
        <div class="row mb-2">
          <div class="col-sm-6"></div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right"></ol>
          </div>
        </div>
      </div>
    </section>

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">

              <div class="card-body">
                <div style="overflow-x:auto; overflow-y: auto;">
                  <div class="row">
                    <div class="col-md-6">
                      <form method="POST" class="form-inline"></form>
                    </div>
                    <div class="col-md-6">
                      <form method="POST" class="form-inline"></form>
                    </div>
                  </div>
                  <div class="card-header">
                <h3 class="card-title"><b>Rudisha Dawa dukani zilizouzwa kwa makosa au zenye shida</b></h3>
              </div>
                  <?php
                  include("dbcon.php");
                  error_reporting(1);

                  if (isset($_POST['return_to_stock'])) {
                    $sale_id = $_POST['sale_id'];

                    $select_sale_sql = "SELECT * FROM sales WHERE store_id = '$store_id' AND id = ?";
                    $stmt_select_sale = mysqli_prepare($con, $select_sale_sql);
                    mysqli_stmt_bind_param($stmt_select_sale, "i", $sale_id);
                    mysqli_stmt_execute($stmt_select_sale);
                    $result_sale = mysqli_stmt_get_result($stmt_select_sale);
                    $sale_row = mysqli_fetch_assoc($result_sale);

                    $quantity = $sale_row['quantity'];
                    $medicine_id = $sale_row['medicine_id'];

                    $delete_sql = "DELETE FROM sales WHERE store_id = '$store_id' AND  id = ?";
                    $stmt_delete = mysqli_prepare($con, $delete_sql);
                    mysqli_stmt_bind_param($stmt_delete, "i", $sale_id);
                    mysqli_stmt_execute($stmt_delete);

                    $select_stock_sql = "SELECT act_remain_quantity, remain_quantity, used_quantity FROM stock WHERE store_id = '$store_id' AND id = ?";
                    $stmt_select_stock = mysqli_prepare($con, $select_stock_sql);
                    if (!$stmt_select_stock) {
                        die("Prepare failed: " . mysqli_error($con)); 
                    }
                    mysqli_stmt_bind_param($stmt_select_stock, "i", $medicine_id);
                    mysqli_stmt_execute($stmt_select_stock);
                    $result_stock = mysqli_stmt_get_result($stmt_select_stock);
                    
                    if (!$result_stock) {
                        die("Select query failed: " . mysqli_error($con)); 
                    }
                    
                    $stock_row = mysqli_fetch_assoc($result_stock);
                    $current_act_remain_quantity = $stock_row['act_remain_quantity'];
                    $current_remain_quantity = $stock_row['remain_quantity'];
                    $current_used_quantity = $stock_row['used_quantity'];
                    
                    // Debugging: Check the values of quantities
                    error_log("Current Remain Quantity: $current_remain_quantity");
                    error_log("Current act Remain Quantity: $current_act_remain_quantity");
                    error_log("Current Used Quantity: $current_used_quantity");
                    error_log("Quantity to be updated: $quantity");
                    
                    $new_remain_quantity = $current_remain_quantity + (int)$quantity;
                    $new_act_remain_quantity = $current_act_remain_quantity + (int)$quantity;
                    $new_used_quantity = $current_used_quantity - (int)$quantity;
                    
                    // Debugging: Log the new values
                    error_log("New Remain Quantity: $new_remain_quantity");
                    error_log("New act Remain Quantity: $new_act_remain_quantity");
                    error_log("New Used Quantity: $new_used_quantity");
                    
                    $update_stock_sql = "UPDATE stock SET act_remain_quantity = ?, remain_quantity = ?, used_quantity = ? WHERE store_id = '$store_id' AND  id = ?";
                    $stmt_update_stock = mysqli_prepare($con, $update_stock_sql);
                    
                    if (!$stmt_update_stock) {
                        die("Prepare failed: " . mysqli_error($con)); 
                    }
                    
                    mysqli_stmt_bind_param($stmt_update_stock, "iiii", $new_remain_quantity, $new_act_remain_quantity, $new_used_quantity, $medicine_id);
                    mysqli_stmt_execute($stmt_update_stock);
                    
                    // if (mysqli_stmt_affected_rows($stmt_update_stock) === 0) {
                    //     die("Update failed or no rows affected: " . mysqli_error($con)); 
                    // }
                  }                    

                  if (isset($_POST['save_to_broken'])) {
                    // Start a transaction
                    mysqli_begin_transaction($con);
        
                    try {
                        $sale_id = $_POST['sale_id'];
        
                        // 1. Retrieve the sale record using prepared statements
                        $select_sale_sql = "SELECT * FROM sales WHERE  store_id = '$store_id' AND id = ?";
                        $stmt_select_sale = mysqli_prepare($con, $select_sale_sql);
                        mysqli_stmt_bind_param($stmt_select_sale, "i", $sale_id);
                        mysqli_stmt_execute($stmt_select_sale);
                        $result_sale = mysqli_stmt_get_result($stmt_select_sale);
                        $sale_row = mysqli_fetch_assoc($result_sale);
        
                        if (!$sale_row) {
                            throw new Exception("Sale record not found.");
                        }
        
                        // Extract necessary fields
                        $id = $sale_row['id'];
                        $returned_invoice = $sale_row['invoice_number'];
                        $returned_medicines = $sale_row['medicines'];
                        $returned_quantity = (int)$sale_row['quantity'];
                        $returned_amount = $sale_row['total_amount'];
                        $profit_lost = $sale_row['total_profit'];
                        $sold_by = $sale_row['created_by'];
                        $sold_date = $sale_row['Date'];
                        $returned_by = $_SESSION['user_session'];
                        $returned_date = date("Y-m-d H:i:s");
                        $medicine_id = (int)$sale_row['medicine_id']; // Ensure this field exists
        
                        // 2. Insert into broken_products using prepared statements
                        $insert_broken_sql = "INSERT INTO broken_products (id, returned_invoice, returned_medicines, returned_quantity, returned_amount, profit_lost, sold_by, sold_date, returned_by, returned_date, store_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                        $stmt_insert_broken = mysqli_prepare($con, $insert_broken_sql);
                        mysqli_stmt_bind_param($stmt_insert_broken, "issiiisssss", $id, $returned_invoice, $returned_medicines, $returned_quantity, $returned_amount, $profit_lost, $sold_by, $sold_date, $returned_by, $returned_date, $store_id);
                        
                        if (!mysqli_stmt_execute($stmt_insert_broken)) {
                            throw new Exception("Failed to insert into broken_products: " . mysqli_error($con));
                        }
        
                        // 3. Update the stock table
                        // Retrieve current stock values
                        $select_stock_sql = "SELECT act_remain_quantity, remain_quantity, used_quantity, quantity FROM stock WHERE store_id = '$store_id' AND  id = ?";
                        $stmt_select_stock = mysqli_prepare($con, $select_stock_sql);
                        mysqli_stmt_bind_param($stmt_select_stock, "i", $medicine_id);
                        mysqli_stmt_execute($stmt_select_stock);
                        $result_stock = mysqli_stmt_get_result($stmt_select_stock);
                        $stock_row = mysqli_fetch_assoc($result_stock);
        
                        if (!$stock_row) {
                            throw new Exception("Stock record not found for medicine_id: $medicine_id");
                        }
        
                        $current_act_remain_quantity = (int)$stock_row['act_remain_quantity'];
                        $current_remain_quantity = (int)$stock_row['remain_quantity'];
                        $current_used_quantity = (int)$stock_row['used_quantity'];
                        $current_quantity = (int)$stock_row['quantity'];
        
                        // Calculate new stock values
                        // $new_act_remain_quantity = $current_act_remain_quantity - $returned_quantity;
                        $new_used_quantity = $current_used_quantity - $returned_quantity;
                        $new_quantity = $current_quantity - $returned_quantity;
        
                        // Validate that quantities do not go negative
                        if ( $new_used_quantity < 0 || $new_quantity < 0) {
                            throw new Exception("Stock quantities cannot be negative.");
                        }
        
                        // Update the stock table
                        $update_stock_sql = "UPDATE stock SET  used_quantity = ?, quantity = ? WHERE store_id = '$store_id' AND  id = ?";
                        $stmt_update_stock = mysqli_prepare($con, $update_stock_sql);
                        mysqli_stmt_bind_param($stmt_update_stock, "iii", $new_used_quantity, $new_quantity, $medicine_id);
                        
                        if (!mysqli_stmt_execute($stmt_update_stock)) {
                            throw new Exception("Failed to update stock: " . mysqli_error($con));
                        }
        
                        // 4. Delete the sale record
                        $delete_sql = "DELETE FROM sales WHERE store_id = '$store_id' AND  id = ?";
                        $stmt_delete = mysqli_prepare($con, $delete_sql);
                        mysqli_stmt_bind_param($stmt_delete, "i", $sale_id);
                        
                        if (!mysqli_stmt_execute($stmt_delete)) {
                            throw new Exception("Failed to delete sale record: " . mysqli_error($con));
                        }
        
                        // Commit the transaction 
                        mysqli_commit($con);
        
                        // Optionally, you can set a success message here
                        echo "<div class='alert alert-success'>Dawa imetolewa kikamilifu kwenye  rekodi ya mauzo na stoo .</div>";
        
                    } catch (Exception $e) {
                        // An error occurred, rollback the transaction
                        mysqli_rollback($con);
                        // Display the error message
                        echo "<div class='alert alert-danger'>Error: " . $e->getMessage() . "</div>";
                    }
                }

                $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                $records_per_page = isset($_GET['records_per_page']) ? (int)$_GET['records_per_page'] : 10;
                $offset = ($page - 1) * $records_per_page;
                
                $select_sql = "SELECT * FROM sales WHERE store_id = '$store_id' ORDER BY Date DESC LIMIT $offset, $records_per_page";
                $select_query = mysqli_query($con, $select_sql);
                
                // Count total records
                $count_sql = "SELECT COUNT(*) AS total_records FROM sales WHERE store_id = '$store_id'";
                $count_result = mysqli_query($con, $count_sql);
                $row = mysqli_fetch_assoc($count_result);
                $total_records = $row['total_records'];
                
                $total_pages = ceil($total_records / $records_per_page);
                
                  ?>


                  <table class="table table-bordered table-striped table-hover">
                    <thead>
                      <tr style="background-color: #383838; color: #FFFFFF;">
                        <th>Tarehe iliyouzwa</th>
                        <th>Dawa</th>
                        <th>Idadi</th>
                        <th>Jumla kiasi </th>
                        <!-- <th>Jumla faida</th> -->
                        <th>Namba ya risiti</th>
                        <th>Nzima</th>
                        <th>Mbovu</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php while($row = mysqli_fetch_array($select_query)) : ?>
                      <tr>
                        <td><?php echo $row['Date']?></td>
                        <td><?php echo $row['medicines']?></td>
                        <td><?php echo $row['quantity']?></td>
                        <td><?php echo number_format($row['total_amount'])?></td>
                        <!-- <td><?php echo number_format($row['total_profit'])?></td> -->
                        <td><?php echo $row['invoice_number']?></td>
                        <td>
                          <form method="POST">
                            <input type="hidden" name="sale_id" value="<?php echo $row['id']; ?>">
                            <input type="hidden" name="invoice_number" value="<?php echo $row['invoice_number']; ?>">
                            <button type="submit" name="return_to_stock" class="btn btn-success btn-sm">stoo</button>
                          </form>
                        </td>
                        <td>
                          <form method="POST">
                            <input type="hidden" name="sale_id" value="<?php echo $row['id']; ?>">
                            <input type="hidden" name="invoice_number" value="<?php echo $row['invoice_number']; ?>">
                            <button type="submit" name="save_to_broken" class="btn btn-danger btn-sm">Itoe</button>
                          </form>
                        </td>
                      </tr>
                      <?php endwhile; ?>
                    </tbody>
                  </table>

                  <div class="pagination">
    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center">
            <li class="page-item <?php if ($page == 1) echo 'disabled'; ?>">
                <a class="page-link" href="?page=<?php echo $page - 1; ?>&records_per_page=<?php echo $records_per_page; ?>&invoice_number=<?php echo isset($_GET['invoice_number']) ? $_GET['invoice_number'] : ''; ?>" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
                    <a class="page-link" href="?page=<?php echo $i; ?>&records_per_page=<?php echo $records_per_page; ?>&invoice_number=<?php echo isset($_GET['invoice_number']) ? $_GET['invoice_number'] : ''; ?>"><?php echo $i; ?></a>
                </li>
            <?php endfor; ?>
            <li class="page-item <?php if ($page == $total_pages) echo 'disabled'; ?>">
                <a class="page-link" href="?page=<?php echo $page + 1; ?>&records_per_page=<?php echo $records_per_page; ?>&invoice_number=<?php echo isset($_GET['invoice_number']) ? $_GET['invoice_number'] : ''; ?>" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
    </nav>

    <!-- Dropdown for selecting records per page -->
    <div class="form-group">
        <label for="recordsPerPage">Idadi ya taharifa kwa ukurasa:</label>
        <select id="recordsPerPage" class="form-control" onchange="changeRecordsPerPage(this)">
            <option value="10" <?php if ($records_per_page == 10) echo 'selected'; ?>>10</option>
            <option value="20" <?php if ($records_per_page == 20) echo 'selected'; ?>>20</option>
            <option value="50" <?php if ($records_per_page == 50) echo 'selected'; ?>>50</option>
        </select>
    </div>
</div>

<script>
function changeRecordsPerPage(select) {
    var recordsPerPage = select.value;
    var invoiceNumber = "<?php echo isset($_GET['invoice_number']) ? $_GET['invoice_number'] : ''; ?>"; // Retrieve invoice number
    window.location.href = "?page=1&records_per_page=" + recordsPerPage + "&invoice_number=" + invoiceNumber;
}
</script>


                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

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
  $(function () {
    $("#example1").DataTable({
      "responsive": true,
      "autoWidth": false,
    });
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
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