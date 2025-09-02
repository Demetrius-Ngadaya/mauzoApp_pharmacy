<?php 
include("session.php");
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
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">

  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <!-- Bootstrap JS -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="./dist/js/adminlte.min.js"></script>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Navbar -->
  
  <!-- /.navbar -->

<?php include("navbar.php"); ?>   
<?php include('indexSideBar.php') ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid"> 
        <div class="row mb-2">
          <div class="col-sm-6">	
            <b>Orodha ya Dawa ulizonunua</b>						
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              Admin/Ripoti
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
                <center>
                <div> 
                <form action="reject_purchases.php?invoice_number=<?php echo $_GET['invoice_number']?>" method="POST" class="form-inline">

<div class="form-group">
  <label for="d1" class="sr-only">From:</label>
  <input type="date" id="d1" name="d1" class="form-control" placeholder="Kuanzia Tarehe" autocomplete="off">
</div>
<div class="form-group">
  <label for="d2" class="sr-only">To:</label>
  <input type="date" id="d2" name="d2" class="form-control" placeholder="Mbaka Tarehe" autocomplete="off">
</div>
<div class="form-group">
  <label for="created_by" class="sr-only">Recorder:</label>
  <input type="text" id="created_by" name="created_by" class="form-control" placeholder="Jina la aliyerekodi" autocomplete="off">
</div>
<div class="form-group">
  <label for="medicine_name" class="sr-only">Dawa:</label>
  <input type="text" id="medicine_name" name="medicine_name" class="form-control" placeholder="Jina la Dawa" autocomplete="off">
</div>
<div class="form-group">
  <label for="category" class="sr-only">Aina ya Dawa:</label>
  <input type="text" id="category" name="category" class="form-control" placeholder="Aina ya Dawa" autocomplete="off">
</div>
<div class="form-group">
  <label for="status" class="sr-only">Hali ya malipo:</label>
  <input type="text" id="status" name="status" class="form-control" placeholder="Hali ya malipo" autocomplete="off">
</div>
<div class="form-group">
  <label for="company" class="sr-only">Company:</label>
  <input type="text" id="company" name="company" class="form-control" placeholder="Msambazaji" autocomplete="off">
</div>
<div class="form-group">
  <button class="btn btn-info" type="submit" name="submit"><i class="icon icon-search icon-large"></i> Tafuta</button>
</div>
</form>
                </div>
                </center>
              </div>
              <!-- /.card-header -->
              <section class="content">
                <div class="container-fluid">
                  <div class="row">
                    <div class="col-12">
                      <div class="card">
                        <div class="card-header">
                          <center>
                          
                          </center>
                          <div style="overflow-x:auto; overflow-y: auto;">
                            <table class="table table-bordered table-striped table-hover">
                              <thead>
                              <tr class="table-success">
                                  <th>Tarehe ya kupokea</th>
                                  <th>Dawa</th>
                                  <th>Aina ya Dawa</th>
                                  <th>Idadi ya zamani</th>
                                  <th>Idadi iliyopokelewa</th>
                                  <th>Bei kwa Dawa</th>
                                  <th>Bei jumla </th>
                                  <th>Tarehe ya kulipa </th>
                                  <th>Tarehe iliyolipwa </th>
                                  <!-- th>Namba ya risiti</th -->
                                  <!-- <th>Namba ya bachi</th> -->
                                  <th>Msambazaji</th>
                                  <th>aliyerekodi</th>
                                  <th>Hali ya malipo</th>
                                  <th>Kitendo</th> <!-- New column for Reject button -->
                                </tr>
                              </thead>
                              <?php
                              include("dbcon.php");
                              error_reporting(1);

                              // Initialize totals
                              $total_quantity = 0;
                              $total_amount = 0;

                              if (isset($_POST['submit'])) {
                                $d1 = $_POST['d1'];
                                $d2 = $_POST['d2'];
                                $created_by = $_POST['created_by'];
                                $company = $_POST['company'];
                                $medicine_name = $_POST['medicine_name'];
                                $category = $_POST['category'];
                                $status = $_POST['status'];

                                $select_sql = "SELECT * FROM purchases_report WHERE store_id = '$store_id' AND  (received_date BETWEEN '$d1' AND '$d2')  ";
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
                                  if (!empty($status)) {
                                    $select_sql .= " AND status LIKE '%$status%'";
                                  }
                                $select_sql .= " ORDER BY received_date DESC";
                                
                                $select_query = mysqli_query($con, $select_sql);
                                
                                while ($row = mysqli_fetch_array($select_query)) :
                                  $total_quantity += $row['received_quantity'];
                                  $total_amount += $row['credit_amount'];
                              ?>
                              <tbody>
                                <tr>
                                <td><?php echo $row['received_date']?></td>
                                  <td><?php echo $row['medicine_name']?></td>
                                  <td><?php echo $row['category']?></td>
                                  <td><?php echo $row['old_quantity']?></td>
                                  <td><?php echo $row['received_quantity']?></td>
                                  <td><?php echo number_format($row['actual_price'])?></td>
                                  <td><?php echo number_format($row['credit_amount'])?></td> <!-- New column -->
                                  <td><?php echo $row['date_to_pay']?></td> <!-- New column -->
                                  <td><?php echo $row['paid_date']?></td> <!-- New column -->
                                  <td><?php echo $row['company']?></td>
                                  <td><?php echo $row['created_by']?></td>
                                  <td><?php echo $row['status']?></td>
                                  <td>
                                    <button class="btn btn-danger reject-btn" data-purchase-id="<?php echo $row['id']; ?>" data-medicine-id="<?php echo $row['medicine_id']; ?>">Reject</button>
                                  </td>
                                </tr>
                              </tbody>
                              <?php endwhile;?>
                              <tfoot>
                                <tr>
                                  <th colspan="6"> Total quantity: <?php echo number_format( $total_quantity); ?></th>
                                  <th colspan="5">Total credit: <?php echo number_format($total_amount) . ' Tsh'; ?></th>
                                </tr>
                              </tfoot>
                              <?php } else {
                                $date = date('Y-m-d');
                                $select_sql = "SELECT * FROM purchases_report WHERE store_id = '$store_id' AND  received_date = '$date'  AND status !='cash' ";
                                $select_query = mysqli_query($con, $select_sql);
                                
                                while ($row = mysqli_fetch_array($select_query)) :
                                  $total_quantity += $row['received_quantity'];
                                  $total_amount += $row['credit_amount'];
                              ?>
                              <tbody>
                                <tr> 
                                  <td><?php echo $row['received_date']?>&nbsp;&nbsp;(<font size='2' color='#009688;'>Today</font>)</td>
                                  <td><?php echo $row['medicine_name']?></td>
                                  <td><?php echo $row['category']?></td>
                                  <td><?php echo $row['old_quantity']?></td>
                                  <td><?php echo $row['received_quantity']?></td>
                                  <td><?php echo $row['actual_price']?></td>
                                  <td><?php echo $row['credit_amount']?></td> <!-- New column -->
                                  <td><?php echo $row['date_to_pay']?></td> <!-- New column -->
                                  <td><?php echo $row['paid_date']?></td> <!-- New column -->
                                  <!-- td><?php echo $row['receipt_number']?></td -->
                                  <!-- td><?php echo $row['batch_number']?></td -->
                                  <td><?php echo $row['company']?></td>
                                  <td><?php echo $row['created_by']?></td>
                                  <td><?php echo $row['status']?></td>
                                  <td>
                                    <button class="btn btn-danger reject-btn" data-purchase-id="<?php echo $row['id']; ?>" data-medicine-id="<?php echo $row['medicine_id']; ?>">Reject</button>
                                  </td>
                                </tr>
                              </tbody>
                              <?php endwhile;?>
                              <tfoot>
                                <tr>
                                <th colspan="6"> Total quantity: <?php echo $total_quantity; ?></th>
                                <th colspan="5">Total credit: <?php echo $total_amount . ' Tsh'; ?></th>
                                </tr>
                              </tfoot>
                              <?php } ?>
                            </table>
                            <center>
                              <div class="export-buttons">
                              <a href="export_excel.php?d1=<?php echo $d1; ?>&d2=<?php echo $d2; ?>&created_by=<?php echo $created_by; ?>&medicine=<?php echo $medicine; ?>&category=<?php echo $category; ?>" class="btn btn-success">Pakua katika Excel</a>
                                <a href="export_ripoti_mkopo1_pdf.php?d1=<?php echo $d1; ?>&d2=<?php echo $d2; ?>&created_by=<?php echo $created_by; ?>&medicine=<?php echo $medicine; ?>&category=<?php echo $category; ?>" class="btn btn-danger">Pakua katika PDF</a>
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

<!-- Reject Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1" role="dialog" aria-labelledby="rejectModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="rejectModalLabel">Reject Product</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="rejectForm" method="POST" action="reject_product.php">
          <input type="hidden" name="purchase_id" id="purchase_id">
          <input type="hidden" name="medicine_id" id="medicine_id">
          <div class="form-group">
            <label for="rejected_quantity">Rejected Quantity</label>
            <input type="number" class="form-control" id="rejected_quantity" name="rejected_quantity" required>
          </div>
          <div class="form-group">
            <label for="rejected_reason">Reason for Rejection</label>
            <textarea class="form-control" id="rejected_reason" name="rejected_reason" required></textarea>
          </div>
          <button type="submit" class="btn btn-danger">Reject</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  $(document).ready(function() {
    // Handle click event of the Reject button
    $('.reject-btn').click(function() {
      var purchaseId = $(this).data('purchase-id');
      var medicineId = $(this).data('medicine-id');
      $('#purchase_id').val(purchaseId);
      $('#medicine_id').val(medicineId);
      $('#rejectModal').modal('show'); // Show the modal
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