<?php
include("session.php");
include('dbcon.php');

// Get all users with their store information
$user_query = mysqli_query($con, "SELECT u.*, s.id as store_id, s.name as store_name 
                                 FROM users u 
                                 LEFT JOIN stores s ON u.store_id = s.id") 
                                 or die(mysqli_error($con));
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>MauzoApp - User Management</title>
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
                      <button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#createUserModal">Ongeza mtumiaji mpya</button>							
                      <div id="message"></div> <!-- Message container -->
                    </div>
                    <div class="col-sm-6">
                      <ol class="breadcrumb float-sm-right"></ol>
                    </div>
                  </div>
                  <h5 class=""><center><b>Orodha ya watumiaji wa mfumo</b></center></h5>
                </div>
                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                  <thead>
                    <tr class="table-success">
                      <th>Jina la mtumiaji</th>
                      <th>Wajibu</th>
                      <th>Tawi/Kituo</th>
                      <th>Ruhusa</th>
                      <th>Kitendo</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    while ($row = mysqli_fetch_array($user_query)) {
                      $id = $row['id'];
                      $user_name = $row['user_name'];
                      $role = $row['role'];
                      $store_id = $row['store_id'];
                      $store_name = $row['store_name'] ?? 'N/A';
                      $can_access_all_stores = $row['can_access_all_stores'] ?? 0;
                    ?>
                    <tr class="warning">
                      <td><?php echo $user_name; ?></td> 
                      <td><?php echo $role; ?></td>
                      <td><?php echo ($can_access_all_stores == 1) ? 'Matawi yote' : $store_name; ?></td>
                      <td><?php echo ($can_access_all_stores == 1) ? 'Matawi yote' : 'Tawi Fulani'; ?></td>
                      <td width="160">
                        <a href="#editUserModal<?php echo $id; ?>" class="btn btn-success" data-toggle="modal">
                          <i class="icon-pencil icon-large"></i>&nbsp;Badili
                        </a>
                        <a href="#deleteUserModal<?php echo $id; ?>" role="button" data-toggle="modal" class="btn btn-danger">
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

<!-- Include Create User Modal -->
<?php include('modal_create_user.php'); ?>

<!-- Include Edit and Delete Modals -->
<?php
// Reset the pointer for the query to use it again for modals
mysqli_data_seek($user_query, 0);
while ($row = mysqli_fetch_array($user_query)) {
    $id = $row['id'];
    $user_name = $row['user_name'];
    $role = $row['role'];
    $store_id = $row['store_id'];
    $can_access_all_stores = $row['can_access_all_stores'] ?? 0;
    include('modal_edit_user.php'); // Include edit modal for each user
    include('modal_delete_user.php'); // Include delete modal for each user
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