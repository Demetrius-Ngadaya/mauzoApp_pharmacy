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
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>MauzoApp</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="./plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="./plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="./plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="./dist/css/adminlte.min.css">
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <style>
    /* Table cell styling to prevent wrapping */
    .table td {
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
      max-width: 200px; /* Adjust as needed */
    }
    
    /* Action buttons styling */
    .action-buttons {
      white-space: nowrap;
    }
    
    /* Pagination styling */
    .pagination-container {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-top: 15px;
    }
    .pagination {
      margin: 0;
    }
    .pagination a {
      color: #333;
      padding: 6px 12px;
      text-decoration: none;
      border: 1px solid #ddd;
      margin: 0 3px;
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
    }
    .search-box {
      margin-bottom: 15px;
    }
    .table-info {
      margin-bottom: 10px;
      font-size: 14px;
    }
    
    /* Make table horizontally scrollable on small screens */
    .table-responsive {
      overflow-x: auto;
      -webkit-overflow-scrolling: touch;
    }
    
    /* Ensure buttons stay on one line */
    .btn {
      white-space: nowrap;
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
          <div class="col-sm-6">
            <button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
              Andika tumizi
            </button>
          </div>
        </div>
      </div>
      <div class="col-sm-6">
            <button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
              Andika tumizi
            </button>
            <?php if (isset($success_message)): ?>
              <div id="success-message" class="alert alert-success text-center" style="margin: 30px auto; width: 50%;">
                <?php echo $success_message; ?>
              </div>
            <?php endif; ?>
          </div>
    </section>

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title"><b>Matumizi yaliyofanyika</b></h3>
                
                <div class="card-tools">
                  <div class="input-group input-group-sm" style="width: 250px;">
                    <input type="text" id="globalSearch" class="form-control float-right" placeholder="Tafuta...">
                    <div class="input-group-append">
                      <button type="submit" class="btn btn-default">
                        <i class="fas fa-search"></i>
                      </button>
                    </div>
                  </div>
                </div>
              </div>
              
              <?php include ('modal_expenditure.php');?>
              
              <div class="card-body">
                <div class="row mb-3">
                  <div class="col-md-6">
                    <div class="table-info">
                      Onyesha <select id="records_per_page" class="form-control form-control-sm records-per-page" style="width: auto; display: inline-block;">
                        <option value="10" <?= $records_per_page == 10 ? 'selected' : '' ?>>10</option>
                        <option value="25" <?= $records_per_page == 25 ? 'selected' : '' ?>>25</option>
                        <option value="50" <?= $records_per_page == 50 ? 'selected' : '' ?>>50</option>
                        <option value="100" <?= $records_per_page == 100 ? 'selected' : '' ?>>100</option>
                        <option value="999999" <?= $records_per_page == 999999 ? 'selected' : '' ?>>Zote</option>
                      </select> kwa ukurasa
                    </div>
                  </div>
                </div>
                
                <div class="table-responsive">
                  <table class="table table-striped table-bordered" id="expenditureTable" style="width:100%">
                    <thead>
                      <tr class="table-success">
                        <th width="5%">#</th>
                        <th>Jina la tumizi</th>
                        <th>Kiasi cha pesa</th>
                        <th>Maelezo</th>
                        <th>Tarehe</th>
                        <th>Aliyeandika</th>
                        <th class="action-buttons">Kitendo</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php 
                      include ('dbcon.php');
                      $count_query = mysqli_query($con,"SELECT COUNT(*) as total FROM expenditure where store_id = '$store_id'");
                      $total_records = mysqli_fetch_assoc($count_query)['total'];
                      
                      $query = mysqli_query($con,"SELECT * FROM expenditure where store_id = '$store_id' ORDER BY created_at DESC LIMIT $start_from, $records_per_page");
                      $serial = $start_from + 1;
                      
                      while ($row = mysqli_fetch_array($query)) {
                        $id = $row['expenditure_id'];
                      ?>
                      <tr>
                        <td><?= $serial++ ?></td>
                        <td><?= htmlspecialchars($row['expenditure_name']) ?></td>
                        <td><?= number_format($row['expenditure_amount']) ?></td>
                        <td><?= htmlspecialchars($row['expenditure_description']) ?></td>
                        <td><?= htmlspecialchars($row['created_at']) ?></td>
                        <td><?= htmlspecialchars($row['created_by']) ?></td>
                        <td class="action-buttons">
                          <a href="#" role="button" class="btn btn-danger btn-sm delete-btn" data-id="<?= $id ?>" data-invoice="<?= $invoice_number ?>">
                            <i class="fas fa-trash"></i> Futa
                          </a>
                          <a href="edit_expenditure.php?id=<?= $id ?>&invoice_number=<?= $invoice_number ?>" class="btn btn-success btn-sm">
                            <i class="fas fa-edit"></i> Badilisha
                          </a>
                        </td>
                      </tr>
                      <?php } ?>
                    </tbody>
                  </table>
                </div>
                
                <div class="pagination-container">
                  <div>
                    Jumla ya rekodi: <strong><?= $total_records ?></strong>
                  </div>
                  <div>
                    <div class="pagination">
                      <?php 
                      $total_pages = ceil($total_records / $records_per_page);
                      
                      if($page > 1): ?>
                        <a href="?invoice_number=<?= $invoice_number ?>&page=1&records_per_page=<?= $records_per_page ?>">
                          <i class="fas fa-angle-double-left"></i>
                        </a>
                        <a href="?invoice_number=<?= $invoice_number ?>&page=<?= $page-1 ?>&records_per_page=<?= $records_per_page ?>">
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
                        <a href="?invoice_number=<?= $invoice_number ?>&page=<?= $page+1 ?>&records_per_page=<?= $records_per_page ?>">
                          <i class="fas fa-angle-right"></i>
                        </a>
                        <a href="?invoice_number=<?= $invoice_number ?>&page=<?= $total_pages ?>&records_per_page=<?= $records_per_page ?>">
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
  
  <!-- Confirmation Modal for Delete -->
  <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="deleteConfirmationModalLabel">Thibitisha kufuta</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          Je unauhakika unataka kufuta taarifa hii?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Hapana kata</button>
          <a id="deleteButton" href="#" class="btn btn-danger">Ndiyo ,futa</a>
        </div>
      </div>
    </div>
  </div>

  <?php include("footer.php"); ?>
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
  $("#globalSearch").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#expenditureTable tbody tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
  
  // Initialize DataTable with disabled paging and searching
  $('#expenditureTable').DataTable({
    "paging": false,
    "searching": false,
    "info": false,
    "ordering": true,
    "scrollX": true,
    "language": {
      "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Swahili.json"
    }
  });
  
  // Delete confirmation modal
  $('.delete-btn').on('click', function(e) {
    e.preventDefault();
    var id = $(this).data('id'); 
    var invoice = $(this).data('invoice');
    var deleteUrl = 'delete_expenditure.php?id=' + id + '&invoice_number=' + invoice;
    $('#deleteButton').attr('href', deleteUrl);
    $('#deleteConfirmationModal').modal('show');
  });
  
  // Remove success message after 7 seconds
  <?php if (isset($success_message)): ?>
    setTimeout(function(){
      $('#success-message').fadeOut('slow', function(){
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