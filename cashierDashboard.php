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
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">


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
              <li class="breadcrumb-item"><a href="#">Cashier</a></li>
              <li class="breadcrumb-item active">Medicines</li>
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
             
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                 <b>List of available medicines</b> </h3>
              </div>
              <!-- /.card-header -->
             
              <div class="card-body">
              <?php include ('modal_expenditure.php');?>
						
						<div class="card-body table-responsive">
            <div class="hero-unit-table">   
                            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
             <tr style="background-color: #383838; color: #FFFFFF;">             
             <th width="3%">Medicine</th>
             <th width="1%">category</th>
             <th width="5%">Registered quantity</th>
             <th width="1%">Sold quantity</th>
             <th  width="1%">Remain quantity</th>
             <th width="1%">Registered quantity</th>

             <th width="2%">Selling price</th>
             <!-- <th width = "3%">Hali</th> -->
             </tr>
           </thead>
           <tbody>
    <?php include("dbcon.php"); ?>
   <?php  
    // Modify your SQL query to retrieve records with LIMIT and OFFSET
$sql = "SELECT id, bar_code, medicine_name, category, quantity, used_quantity, remain_quantity, act_remain_quantity, register_date, expire_date, company, sell_type, actual_price, selling_price, profit_price, status FROM stock where store_id = '$store_id' ORDER BY id";
  $result = mysqli_query($con, $sql); ?>
    <!-- Use a while loop to make a table row for every DB row -->
    <?php
// Initialize a counter variable
// naondoa serial number sababu hazijiongezi tokana na pagination $serialNumber = 1;

// Use a while loop to fetch and display data from the database
while ($row = mysqli_fetch_array($result)) :
?>
    <tr style="">
        
        <!-- Each table column is echoed into a td cell -->
        <td><?php echo $row['medicine_name']; ?></td>
        <td><?php echo $row['category']; ?></td>
        <td><?php echo $row['quantity']."&nbsp;&nbsp;(<strong><i>".$row['sell_type']."</i></strong>)"; ?></td>
        <td><?php echo $row['used_quantity']; ?></td>
        <td><?php echo $row['act_remain_quantity']; ?></td>
        <td><?php echo date("d-m-Y", strtotime($row['register_date'])); ?></td>
        <td><?php echo $row['selling_price']; ?></td>
        <!-- <td>
            <?php
            $status = $row['status'];
            if ($status == 'ipo') {
                echo '<span class="label label-success">'.$status.'</span>';
            } else {
                echo '<span class="label label-danger">'.$status.'</span>';
            }
            ?>
        </td> -->
    </tr>
<?php
// Increment the serial number counter

endwhile;
?>

</tbody>

</table>
                        </div>
              <!-- /.card-body -->
            </div>
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>

    
    <!-- kuanzia hapa ni for navigation -->
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->


  <?php include("footer.php"); ?>


  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->
<?php include ('script.php');?>
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
<!-- AdminLTE for demo purposes -->
<script src="./dist/js/demo.js"></script>
<!-- page script -->
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
