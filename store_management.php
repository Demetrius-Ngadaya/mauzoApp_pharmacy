<?php
include("session.php");
// Get invoice number from query parameter
$invoice_number = isset($_GET['invoice_number']) ? $_GET['invoice_number'] : '';
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>MauzoApp - Store Management</title>
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
       
      </div>
    </section>
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-body">
                <div class="card-header">
                  <div class="row mb-2">
                    <div class="col-sm-6">
                      <button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#createStoreModal">Ongeza Tawi/kituo kipya</button>							
                      <div id="message"></div> <!-- Message container -->
                    </div>
                    <div class="col-sm-6">
                      <ol class="breadcrumb float-sm-right"></ol>
                    </div>
                  </div>
                  <h5 class=""><center><b>Orodha ya matawi/vituo</b></center></h5>
                </div>
                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                  <thead>
                    <tr class="table-success">
                      <th>Jina la Tawi/kituo</th>
                      <th>Mahali</th>
                      <th>Tarehe ya kuanzishwa</th>
                      <th>Kitendo</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    include('dbcon.php');
                    $query = mysqli_query($con, "SELECT * FROM stores") or die(mysqli_error($con));
                    while ($row = mysqli_fetch_array($query)) {
                      $id = $row['id'];
                      $name = $row['name'];
                      $location = $row['location'];
                      $created_at = $row['created_at'];
                    ?>
                    <tr class="warning">
                      <td><?php echo $name; ?></td> 
                      <td><?php echo $location; ?></td> 
                      <td><?php echo date('d/m/Y', strtotime($created_at)); ?></td> 
                      <td width="160">
                        <a href="#editStoreModal<?php echo $id; ?>" class="btn btn-success" data-toggle="modal">
                          <i class="icon-pencil icon-large"></i>&nbsp;Badili
                        </a>
                        <a href="#deleteStoreModal<?php echo $id; ?>" role="button" data-toggle="modal" class="btn btn-danger">
                          <i class="icon-trash icon-large"></i>&nbsp;Futa
                        </a>
                      </td>
                    </tr>
                    <?php } ?> 
                  </tbody>
                </table>
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

<!-- Create Store Modal -->
<div class="modal fade" id="createStoreModal" tabindex="-1" role="dialog" aria-labelledby="createStoreModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="createStoreModalLabel">Ongeza Tawi/kituo kipya</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="save_store.php?invoice_number=<?php echo $invoice_number; ?>" method="post">
        <div class="modal-body">
          <div class="form-group">
            <label for="store_name">Jina la Kituo/tawi</label>
            <input type="text" class="form-control" id="store_name" name="store_name" required>
          </div>
          <div class="form-group">
            <label for="store_location">Mahali</label>
            <input type="text" class="form-control" id="store_location" name="store_location" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Funga</button>
          <button type="submit" class="btn btn-primary">Hifadhi</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Edit and Delete Modals -->
<?php
$query = mysqli_query($con, "SELECT * FROM stores") or die(mysqli_error($con));
while ($row = mysqli_fetch_array($query)) {
    $id = $row['id'];
    $name = $row['name'];
    $location = $row['location'];
    $created_at = $row['created_at'];
    
    // Edit Store Modal for each store
    ?>
    <div class="modal fade" id="editStoreModal<?php echo $id; ?>" tabindex="-1" role="dialog" aria-labelledby="editStoreModalLabel<?php echo $id; ?>" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="editStoreModalLabel<?php echo $id; ?>">Badili Taarifa za Tawi/kituo</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form action="update_store.php?invoice_number=<?php echo $invoice_number; ?>" method="post">
            <div class="modal-body">
              <input type="hidden" name="store_id" value="<?php echo $id; ?>">
              <div class="form-group">
                <label for="store_name<?php echo $id; ?>">Jina la Tawi/kituo</label>
                <input type="text" class="form-control" id="store_name<?php echo $id; ?>" name="store_name" value="<?php echo $name; ?>" required>
              </div>
              <div class="form-group">
                <label for="store_location<?php echo $id; ?>">Mahali</label>
                <input type="text" class="form-control" id="store_location<?php echo $id; ?>" name="store_location" value="<?php echo $location; ?>" required>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Funga</button>
              <button type="submit" class="btn btn-primary">Hifadhi Mabadiliko</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    
    <!-- Delete Store Modal for each store -->
    <div class="modal fade" id="deleteStoreModal<?php echo $id; ?>" tabindex="-1" role="dialog" aria-labelledby="deleteStoreModalLabel<?php echo $id; ?>" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="deleteStoreModalLabel<?php echo $id; ?>">Futa Tawi/kituo</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form action="delete_store.php?invoice_number=<?php echo $invoice_number; ?>" method="post">
            <div class="modal-body">
              <p>Je, una uhakika unataka kufuta kituo/tawi hili: <strong><?php echo $name; ?></strong>?</p>
              <input type="hidden" name="store_id" value="<?php echo $id; ?>">
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Ghairi</button>
              <button type="submit" class="btn btn-danger">Futa</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <?php
}
?>

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
    $("#dataTables-example").DataTable({ "responsive": true, "autoWidth": false });

    // Hide message after 5 seconds
    setTimeout(function(){
      $('#message').fadeOut('slow');
    }, 5000);
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