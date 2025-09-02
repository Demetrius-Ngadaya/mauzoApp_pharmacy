<?php
include("session.php");
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



<?php include('cashierNavBar.php') ?>


  <!-- Content Wrapper -->
  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#createOrderModal">Andika oda mpya ya mteja</button>							
            <?php
            if (isset($_SESSION['error_message'])) {
                echo '<div id="message" style="color: red; text-align: center;">' . $_SESSION['error_message'] . '</div>';
                unset($_SESSION['error_message']);
            }

            if (isset($_SESSION['success_message'])) {
                echo '<div id="message" style="color: green; text-align: center;">' . $_SESSION['success_message'] . '</div>';
                unset($_SESSION['success_message']);
            }
            ?>
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
              <div class="card-header">
                <h3 class="card-title"><b>Orodha ya oda za wateja zisizokamilika</b></h3>
              </div>
                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                  <thead>
                    <tr class="table-success">
                      <th>Jina la mteja</th>
                      <th>Namba ya simu</th>
                      <th>Jina ka Dawa</th>
                      <th>Idadi</th>
                      <th>Kiasi </th>
                      <th>Njia ya malipo</th>
                      <th>Kitendo</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    include('dbcon.php');
                    $query = mysqli_query($con, "SELECT * FROM customer_order WHERE store_id = '$store_id' AND order_status = 'incomplete'") or die(mysqli_error($con));
                    while ($row = mysqli_fetch_array($query)) {
                        $id = $row['id'];
                    ?>
                    <tr class="warning">
                      <td><?php echo $row['customer_name']; ?></td>
                      <td><?php echo $row['customer_phone']; ?></td>
                      <td><?php echo $row['order_medicine_name']; ?></td>
                      <td><?php echo $row['order_quantity']; ?></td>
                      <td><?php echo number_format($row['order_total_amount']) ; ?></td>
                      <td><?php echo $row['order_payment_method']; ?></td>
                      <td width="160">
                        <a href="#" class="btn btn-success edit-order" data-toggle="modal" data-target="#editOrderModal" data-id="<?php echo $id; ?>">
                          <i class="icon-pencil icon-large"></i>&nbsp;Badili
                        </a>
                        <a href="#delete_order<?php echo $id; ?>" role="button" data-toggle="modal" class="btn btn-danger">
                          <i class="icon-trash icon-large"></i>&nbsp;Futa
                        </a>
                      </td>
                      <?php include('modal_delete_order.php'); ?>
                    </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
            </div>
            <?php include('modal_create_order.php'); ?>
          </div>
        </div>
      </div>
    </section>
  </div>
  <footer class="main-footer">
    <strong>Copyright &copy; 2023-2024 D_TECH.</strong> All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <strong>Designed and Developed by <a href="https://wa.me/message/JYOOWVES6MT7M1">D_TECH</a>.</strong>
    </div>
  </footer>
  <aside class="control-sidebar control-sidebar-dark"></aside>
</div>

<!-- Edit Order Modal -->
<div class="modal fade" id="editOrderModal" tabindex="-1" role="dialog" aria-labelledby="editOrderModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editOrderModalLabel">Badilisha taharifa ya oda</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="update_order.php" method="POST" id="editOrderForm">
          <div class="form-group">
            <label for="edit_customer_name">Jina la mteja</label>
            <input type="text" class="form-control" id="edit_customer_name" name="customer_name" required>
          </div>
          <div class="form-group">
            <label for="edit_customer_phone">Namba ya sim ya mteja</label>
            <input type="text" class="form-control" id="edit_customer_phone" name="customer_phone" required>
          </div>
          <div class="form-group">
            <label for="edit_category">Aina ya Dawa</label>
            <select class="form-control" id="edit_category" name="category" required>
              <?php
              include('dbcon.php');
              $query = mysqli_query($con, "SELECT DISTINCT category FROM stock WHERE store_id = '$store_id'") or die(mysqli_error($con));
              while ($row = mysqli_fetch_array($query)) {
                  echo '<option value="' . $row['category'] . '">' . $row['category'] . '</option>';
              }
              ?>
            </select>
          </div>
          <div class="form-group">
            <label for="edit_order_medicine_name">Jina la Dawa</label>
            <select class="form-control" id="edit_order_medicine_name" name="order_medicine_name" required>
              <!-- Options will be populated dynamically using JavaScript -->
            </select>
          </div>
          <div class="form-group">
            <label for="edit_order_quantity">Idadi</label>
            <input type="number" class="form-control" id="edit_order_quantity" name="order_quantity" required>
          </div>
          <div class="form-group">
            <label for="edit_order_total_amount">Jumla kiasi cha fedha</label>
            <input type="text" class="form-control" id="edit_order_total_amount" name="order_total_amount" readonly>
          </div>
          <div class="form-group">
            <label for="edit_order_total_profit">Jumla faida</label>
            <input type="text" class="form-control" id="edit_order_total_profit" name="order_total_profit" readonly>
          </div>
          <div class="form-group">
            <label for="edit_order_payment_method">Njia ya malipo</label>
            <select class="form-control" id="edit_order_payment_method" name="order_payment_method" required>
              <option value="cash">Cash</option>
              <option value="credit">Mkopo</option>
            </select>
          </div>
          <div class="form-group" id="edit_date_to_pay_field" style="display: none;">
            <label for="edit_date_to_pay">Siku ya kulipa</label>
            <input type="date" class="form-control" id="edit_date_to_pay" name="date_to_pay">
          </div>
          <input type="hidden" id="edit_order_id" name="id">
          <button type="submit" class="btn btn-primary">Hifadhi mabadiliko</button>
        </form>
      </div>
    </div>
  </div>
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
  $(document).ready(function () {
    // Handle Edit Button Click
    $('.edit-order').click(function () {
      var order_id = $(this).data('id');

      // Fetch order data via AJAX
      $.ajax({
        url: 'fetch_order.php',
        type: 'POST',
        data: { id: order_id },
        success: function (response) {
          console.log(response); // Debug: Check the response in the browser console
          var data = JSON.parse(response);

          // Populate the modal fields
          $('#edit_customer_name').val(data.customer_name);
          $('#edit_category').val(data.category);
          $('#edit_order_quantity').val(data.order_quantity);
          $('#edit_order_total_amount').val(data.order_total_amount);
          $('#edit_order_total_profit').val(data.order_total_profit);
          $('#edit_order_payment_method').val(data.order_payment_method);
          $('#edit_customer_phone').val(data.customer_phone);
          $('#edit_order_id').val(data.id);

          // Fetch medicines for the selected category
          fetchMedicines(data.category, data.order_medicine_name);

          // Show/hide date_to_pay field
          if (data.order_payment_method == 'credit') {
            $('#edit_date_to_pay_field').show();
            $('#edit_date_to_pay').val(data.date_to_pay);
          } else {
            $('#edit_date_to_pay_field').hide();
          }
        },
        error: function (xhr, status, error) {
          console.error("AJAX Error: " + status + error); // Debug: Log any AJAX errors
        }
      });
    });

    // Fetch medicines for the selected category
    function fetchMedicines(category, selectedMedicine) {
      $.ajax({
        url: 'get_medicines.php',
        type: 'POST',
        data: { category: category },
        success: function (response) {
          $('#edit_order_medicine_name').html(response);
          if (selectedMedicine) {
            $('#edit_order_medicine_name').val(selectedMedicine);
          }
        }
      });
    }

    // Calculate total amount and profit when medicine or quantity changes
    $('#edit_order_medicine_name, #edit_order_quantity').change(function () {
      var medicine_id = $('#edit_order_medicine_name').val();
      var quantity = $('#edit_order_quantity').val();

      if (medicine_id && quantity) {
        $.ajax({
          url: 'get_medicine_price.php',
          type: 'POST',
          data: { medicine_id: medicine_id },
          success: function (response) {
            console.log(response); // Debug: Check the response in the browser console
            var data = JSON.parse(response);
            var total_amount = quantity * data.price;
            var total_profit = quantity * data.profit_price;
            $('#edit_order_total_amount').val(total_amount.toFixed(2)); // Format to 2 decimal places
            $('#edit_order_total_profit').val(total_profit.toFixed(2)); // Format to 2 decimal places
          },
          error: function (xhr, status, error) {
            console.error("AJAX Error: " + status + error); // Debug: Log any AJAX errors
          }
        });
      }
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