<?php
include("session.php");

// Pagination settings
$records_per_page = isset($_GET['records_per_page']) ? (int)$_GET['records_per_page'] : 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;
$start_from = ($page-1) * $records_per_page;

// Get invoice_number from URL
$invoice_number = isset($_GET['invoice_number']) ? $_GET['invoice_number'] : '';

// Check if success message is set
if (isset($_SESSION['success_message'])) {
    $success_message = $_SESSION['success_message'];
    unset($_SESSION['success_message']);
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>MauzoApp - Orodha ya Dawa</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link rel="stylesheet" href="./plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="./plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="./plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="./dist/css/adminlte.min.css">
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <style>
    /* Table styling */
    .table-responsive {
      overflow-x: auto;
    }
    .table td, .table th {
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
      vertical-align: middle;
    }
    .checkbox-cell {
      width: 30px;
      text-align: center;
    }
    
    /* Pagination styling */
    .pagination-container {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-top: 15px;
      flex-wrap: wrap;
    }
    .pagination {
      margin: 5px 0;
      display: inline-block;
    }
    .pagination a {
      color: #333;
      padding: 6px 12px;
      text-decoration: none;
      border: 1px solid #ddd;
      margin: 0 2px;
      border-radius: 3px;
    }
    .pagination a.active {
      background-color: #007bff;
      color: white;
      border-color: #007bff;
    }
    .pagination a:hover:not(.active) {
      background-color: #f1f1f1;
    }
    .records-per-page {
      display: inline-block;
      margin: 5px 10px;
    }
    
    /* Search box styling */
    .search-container {
      margin-bottom: 15px;
    }
    
    /* Button styling */
    .btn-action {
      padding: 3px 8px;
      font-size: 12px;
      margin: 2px;
    }
    
    /* Message styling */
    .alert-message {
      margin: 10px auto;
      width: 80%;
      text-align: center;
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
      .pagination-container {
        flex-direction: column;
        align-items: flex-start;
      }
      .records-per-page {
        margin: 5px 0;
      }
      .btn-action {
        display: block;
        width: 100%;
        margin: 5px 0;
      }
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
          <div class="col-sm-12">  
            <h3>Orodha ya Dawa zote</h3>
            <?php if (isset($success_message)): ?>
              <div class="alert alert-success alert-message">
                <?= $success_message ?>
              </div>
            <?php endif; ?>
            <?php if (isset($_SESSION['error_message'])): ?>
              <div class="alert alert-danger alert-message">
                <?= $_SESSION['error_message'] ?>
              </div>
              <?php unset($_SESSION['error_message']); ?>
            <?php endif; ?>
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
                <div class="row">
                  <div class="col-md-6">
                    <div class="input-group">
                      <input type="text" class="form-control" id="globalSearch" placeholder="Tafuta Dawa...">
                      <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="button" id="searchBtn">
                          <i class="fas fa-search"></i>
                        </button>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6 text-right">
                    <button class="btn btn-primary" id="recordPurchasesBtn">
                      <i class="fas fa-shopping-cart"></i> Rekodi Manunuzi
                    </button>
                    <select id="records_per_page" class="form-control form-control-sm records-per-page">
                      <option value="10" <?= $records_per_page == 10 ? 'selected' : '' ?>>10/ukurasa</option>
                      <option value="25" <?= $records_per_page == 25 ? 'selected' : '' ?>>25/ukurasa</option>
                      <option value="50" <?= $records_per_page == 50 ? 'selected' : '' ?>>50/ukurasa</option>
                      <option value="100" <?= $records_per_page == 100 ? 'selected' : '' ?>>100/ukurasa</option>
                      <option value="999999" <?= $records_per_page == 999999 ? 'selected' : '' ?>>Zote</option>
                    </select>
                  </div>
                </div>
              </div>
              
              <div class="card-body">
                <form method="POST" id="productsForm">
                  <div class="table-responsive">
                    <table id="productsTable" class="table table-bordered table-striped table-hover">
                      <thead>
                        <tr class="table-success">
                          <th class="checkbox-cell">Chagua</th>
                          <th>#</th>
                          <th>Dawa</th>
                          <th>Kituo/Tawi</th>
                          <th>Msambazaji</th>
                          <th>Iliyouzwa</th>
                          <th>Imebaki</th>
                          <th>Bei Nunu</th>
                          <th>Bei Uzi</th>
                          <th>Faida</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php 
                        include("dbcon.php");
      // For the count query:
                        $count_query = mysqli_query($con, "SELECT COUNT(*) as total FROM stock WHERE store_id = '$store_id'");
                        $total_records = mysqli_fetch_assoc($count_query)['total'];
                        
// For the main data query:

include("dbcon.php");

// Get store_id from session
$store_id = $_SESSION['store_id'];

// Count total records for this store
$count_query = mysqli_query($con, "SELECT COUNT(*) as total FROM stock WHERE store_id = '$store_id'");
$total_records = mysqli_fetch_assoc($count_query)['total'];

// Get paginated records for this store
$sql = "SELECT s.id, s.medicine_name, s.category, s.company, s.used_quantity, 
        s.act_remain_quantity, s.actual_price, s.selling_price, s.profit_price,
        st.location
        FROM stock s
        JOIN stores st ON s.store_id = st.id
        WHERE s.store_id = '$store_id' 
        ORDER BY s.id DESC 
        LIMIT $start_from, $records_per_page";
$result = mysqli_query($con, $sql);
$serial = $start_from + 1;

while ($row = mysqli_fetch_array($result)) :
?>
                          <tr>
                            <td class="checkbox-cell"><input type="checkbox" name="selected_products[]" value="<?= $row['id'] ?>"></td>
                            <td><?= $serial++ ?></td>
                            <td><?= htmlspecialchars($row['medicine_name']) ?></td>
                            <td><?= htmlspecialchars($row['location']) ?></td>
                            <td><?= htmlspecialchars($row['company']) ?></td>
                            <td><?= $row['used_quantity'] ?></td>
                            <td><?= $row['act_remain_quantity'] ?></td>
                            <td><?= number_format($row['actual_price']) ?></td>
                            <td><?= number_format($row['selling_price']) ?></td>
                            <td><?= $row['profit_price'] ?></td>
                          </tr>
                        <?php endwhile; ?>
                      </tbody>
                    </table>
                  </div>
                </form>
                
                <div class="pagination-container">
                  <div class="showing-records">
                    Onyesha <?= ($start_from + 1) ?> hadi <?= min($start_from + $records_per_page, $total_records) ?> ya <?= $total_records ?> rekodi
                  </div>
                  <div>
                    <div class="pagination">
                      <?php 
                      $total_pages = ceil($total_records / $records_per_page);
                      
                      if($page > 1): ?>
                        <a href="?invoice_number=<?= $invoice_number ?>&page=1&records_per_page=<?= $records_per_page ?>" title="Kwenda kwenye ukurasa wa kwanza">
                          <i class="fas fa-angle-double-left"></i>
                        </a>
                        <a href="?invoice_number=<?= $invoice_number ?>&page=<?= $page-1 ?>&records_per_page=<?= $records_per_page ?>" title="Kwenda kwenye ukurasa uliopita">
                          <i class="fas fa-angle-left"></i>
                        </a>
                      <?php endif; ?>
                      
                      <?php 
                      $visible_pages = 5;
                      $start_page = max(1, $page - floor($visible_pages/2));
                      $end_page = min($total_pages, $start_page + $visible_pages - 1);
                      
                      if($start_page > 1) {
                          echo '<a href="?invoice_number='.$invoice_number.'&page=1&records_per_page='.$records_per_page.'">1</a>';
                          if($start_page > 2) echo '<span>...</span>';
                      }
                      
                      for($i = $start_page; $i <= $end_page; $i++): ?>
                        <a href="?invoice_number=<?= $invoice_number ?>&page=<?= $i ?>&records_per_page=<?= $records_per_page ?>" <?= $i == $page ? 'class="active"' : '' ?>>
                          <?= $i ?>
                        </a>
                      <?php endfor; ?>
                      
                      <?php if($end_page < $total_pages): ?>
                        <?php if($end_page < $total_pages - 1) echo '<span>...</span>'; ?>
                        <a href="?invoice_number=<?= $invoice_number ?>&page=<?= $total_pages ?>&records_per_page=<?= $records_per_page ?>">
                          <?= $total_pages ?>
                        </a>
                      <?php endif; ?>
                      
                      <?php if($page < $total_pages): ?>
                        <a href="?invoice_number=<?= $invoice_number ?>&page=<?= $page+1 ?>&records_per_page=<?= $records_per_page ?>" title="Kwenda kwenye ukurasa ujao">
                          <i class="fas fa-angle-right"></i>
                        </a>
                        <a href="?invoice_number=<?= $invoice_number ?>&page=<?= $total_pages ?>&records_per_page=<?= $records_per_page ?>" title="Kwenda kwenye ukurasa wa mwisho">
                          <i class="fas fa-angle-double-right"></i>
                        </a>
                      <?php endif; ?>
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

<!-- Cost Entry Modal -->
<div class="modal fade" id="costEntryModal" tabindex="-1" role="dialog" aria-labelledby="costEntryModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title text-white" id="costEntryModalLabel"><i>Ingiza gharama za jumla</i></h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="costEntryForm">
          <div class="form-group">
            <label for="total_received_quantity">Jumla ya idadi zilizopokelewa:</label>
            <input type="number" class="form-control" id="total_received_quantity" value="0" required>
          </div>
          <div class="form-group">
            <label for="total_tax_amount">Jumla ya ushuru:</label>
            <input type="number" class="form-control" id="total_tax_amount" value="0" required>
          </div>
          <div class="form-group">
            <label for="total_cost_kupakia">Jumla ya gharama ya kupakia:</label>
            <input type="number" class="form-control" id="total_cost_kupakia" value="0" required>
          </div>
          <div class="form-group">
            <label for="total_cost_kushusha">Jumla ya gharama ya kushusha:</label>
            <input type="number" class="form-control" id="total_cost_kushusha" value="0" required>
          </div>
          <div class="form-group">
            <label for="total_transport_cost">Jumla ya gharama ya usafiri:</label>
            <input type="number" class="form-control" id="total_transport_cost" value="0" required>
          </div>
          <div class="form-group">
            <label for="total_cost_kupanga">Jumla ya gharama ya kupanga:</label>
            <input type="number" class="form-control" id="total_cost_kupanga" value="0" required>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Funga</button>
        <button type="button" class="btn btn-primary" id="proceedToProducts">Endelea  </button>
      </div>
    </div>
  </div>
</div>

<!-- Edit Product Modal -->
<div class="modal fade" id="editProductModal" tabindex="-1" role="dialog" aria-labelledby="editProductModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title text-white" id="editProductModalLabel"><i>Ingiza manunuzi ya Dawa</i></h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="overflow-y: auto; max-height: 70vh;">
        <div id="editProductFormContainer" class="container-fluid">
          <!-- Forms will be loaded here -->
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Funga</button>
        <button type="button" class="btn btn-primary" id="saveAllPurchases">Hifadhi Yote</button>
      </div>
    </div>
  </div>
</div>

<script src="./plugins/jquery/jquery.min.js"></script>
<script src="./plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="./plugins/datatables/jquery.dataTables.min.js"></script>
<script src="./plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="./dist/js/adminlte.min.js"></script>

<script>
$(document).ready(function() {
  // Records per page change handler
  $('#records_per_page').change(function() {
    var records = $(this).val();
    window.location.href = '?invoice_number=<?= $invoice_number ?>&records_per_page=' + records;
  });
  
  // Global search function
  $("#globalSearch, #searchBtn").on("keyup click", function() {
    var value = $("#globalSearch").val().toLowerCase();
    $("#productsTable tbody tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
  
  // Initialize DataTable with disabled paging and searching
  $('#productsTable').DataTable({
    "paging": false,
    "searching": false,
    "info": false,
    "ordering": true,
    "scrollX": true,
    "language": {
      "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Swahili.json"
    }
  });
  
  // Handle click event of the record purchases button
  $('#recordPurchasesBtn').on('click', function() {
      var selectedProducts = $('input[name="selected_products[]"]:checked').map(function() {
          return $(this).val();
      }).get();
      
      if (selectedProducts.length === 0) {
          Swal.fire({
              icon: 'warning',
              title: 'Hakuna Dawa Zilizochaguliwa',
              text: 'Tafadhali chagua angalau Dawa moja kwa kuingiza alama ya cheki',
              confirmButtonText: 'Sawa'
          });
          return;
      }
      
      window.selectedProductIds = selectedProducts;
      $('#costEntryModal').modal('show');
  });
  
  // Handle proceed to products button
  $('#proceedToProducts').on('click', function() {
      var totalQuantity = parseFloat($('#total_received_quantity').val()) || 0;
      var totalTax = parseFloat($('#total_tax_amount').val()) || 0;
      var totalKupakia = parseFloat($('#total_cost_kupakia').val()) || 0;
      var totalKushusha = parseFloat($('#total_cost_kushusha').val()) || 0;
      var totalTransport = parseFloat($('#total_transport_cost').val()) || 0;
      var totalKupanga = parseFloat($('#total_cost_kupanga').val()) || 0;
      
      if (totalQuantity <= 0) {
          Swal.fire({
              icon: 'error',
              title: 'Kiasi Kisichokubalika',
              text: 'Tafadhali ingiza kiasi halali cha Dawa zilizopokelewa',
              confirmButtonText: 'Sawa'
          });
          return;
      }
      
      var perUnitTax = totalTax / totalQuantity;
      var perUnitKupakia = totalKupakia / totalQuantity;
      var perUnitKushusha = totalKushusha / totalQuantity;
      var perUnitTransport = totalTransport / totalQuantity;
      var perUnitKupanga = totalKupanga / totalQuantity;
      
      window.perUnitCosts = {
          tax: perUnitTax,
          kupakia: perUnitKupakia,
          kushusha: perUnitKushusha,
          transport: perUnitTransport,
          kupanga: perUnitKupanga,
          totalQuantity: totalQuantity
      };
      
      $('#costEntryModal').modal('hide');
      
      var invoiceNumber = "<?= $invoice_number ?>";
      var productIds = window.selectedProductIds.join(',');
      
      $('#editProductFormContainer').load('update_view_record_purchases.php?ids=' + productIds + 
          '&invoice_number=' + invoiceNumber, function() {
          $('[id^="tax_amount_"]').val(window.perUnitCosts.tax.toFixed(2));
          $('[id^="cost_kupakia_"]').val(window.perUnitCosts.kupakia.toFixed(2));
          $('[id^="cost_kushusha_"]').val(window.perUnitCosts.kushusha.toFixed(2));
          $('[id^="transport_cost_"]').val(window.perUnitCosts.transport.toFixed(2));
          $('[id^="cost_kupanga_"]').val(window.perUnitCosts.kupanga.toFixed(2));
          
          $('[id^="tax_amount_"]').data('original-per-unit', window.perUnitCosts.tax);
          $('[id^="cost_kupakia_"]').data('original-per-unit', window.perUnitCosts.kupakia);
          $('[id^="cost_kushusha_"]').data('original-per-unit', window.perUnitCosts.kushusha);
          $('[id^="transport_cost_"]').data('original-per-unit', window.perUnitCosts.transport);
          $('[id^="cost_kupanga_"]').data('original-per-unit', window.perUnitCosts.kupanga);
          
          var productCount = window.selectedProductIds.length;
          var defaultQuantity = Math.floor(window.perUnitCosts.totalQuantity / productCount);
          var remainder = window.perUnitCosts.totalQuantity % productCount;
          
          $('[id^="received_quantity_"]').each(function(index) {
              var qty = defaultQuantity;
              if (index < remainder) {
                  qty += 1;
              }
              $(this).val(qty);
          });
          
          $('[id^="received_quantity_"]').trigger('change');
      });
      
      $('#editProductModal').modal('show');
  });
  
  // Save all purchases
  $('#saveAllPurchases').on('click', function() {
      var formData = $('#editProductFormContainer form').serialize();
      var invoiceNumber = "<?= $invoice_number ?>";
      var $saveButton = $(this);
      $saveButton.html('<i class="fa fa-spinner fa-spin"></i> Inahifadhi...');
      $saveButton.prop('disabled', true);
      
      $.ajax({
          url: 'purchases.php?invoice_number=' + invoiceNumber,
          type: 'POST',
          data: formData,
          dataType: 'json',
          success: function(response) {
              if (response.success) {
                  Swal.fire({
                      icon: 'success',
                      title: 'Imefanikiwa',
                      text: response.message || 'Manunuzi yamehifadhiwa kikamilifu',
                      confirmButtonText: 'Sawa'
                  }).then((result) => {
                      $('#editProductModal').modal('hide');
                      location.reload();
                  });
              } else {
                  Swal.fire({
                      icon: 'error',
                      title: 'Hitilafu',
                      text: response.message || 'Imeshindikana kuhifadhi manunuzi',
                      confirmButtonText: 'Sawa'
                  });
              }
          },
          error: function(xhr, status, error) {
              Swal.fire({
                  icon: 'error',
                  title: 'Hitilafu ya Mtandao',
                  text: 'Imeshindikana kuwasiliana na seva: ' + error,
                  confirmButtonText: 'Sawa'
              });
          },
          complete: function() {
              $saveButton.html('Hifadhi Yote');
              $saveButton.prop('disabled', false);
          }
      });
  });

  // Remove success message after 7 seconds
  <?php if (isset($success_message)): ?>
    setTimeout(function(){
      $('.alert-message').fadeOut('slow', function(){
        $(this).remove();
      });
    }, 7000);
  <?php endif; ?>
  
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