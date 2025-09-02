<?php
include("session.php");
include("dbcon.php");

// Calculate total number of products
$total_products_sql = "SELECT COUNT(*) AS total_products FROM stock where store_id = '$store_id'";
$total_products_result = mysqli_query($con, $total_products_sql);
$total_products_row = mysqli_fetch_assoc($total_products_result);
$total_products = $total_products_row['total_products'];

// Calculate total act_remain_quantity
$total_quantity_sql = "SELECT SUM(act_remain_quantity) AS total_quantity FROM stock where store_id = '$store_id'";
$total_quantity_result = mysqli_query($con, $total_quantity_sql);
$total_quantity_row = mysqli_fetch_assoc($total_quantity_result);
$total_quantity = $total_quantity_row['total_quantity'];

$records_per_page = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) {
    $page = 1;
}
$offset = ($page - 1) * $records_per_page;

// Get total records count
$total_sql = "SELECT COUNT(*) AS total FROM stock where store_id = '$store_id'";
$total_result = mysqli_query($con, $total_sql);
$total_row = mysqli_fetch_assoc($total_result);
$total_records = $total_row['total'];
$total_pages = ceil($total_records / $records_per_page);

// Fetch records with LIMIT and OFFSET
$sql = "SELECT id, medicine_name, category, quantity, used_quantity, remain_quantity, act_remain_quantity, actual_price, selling_price, profit_price, register_date, expire_date, edited_by, edited_date
        FROM stock where store_id = '$store_id'
        ORDER BY id DESC
        LIMIT $records_per_page OFFSET $offset";
$result = mysqli_query($con, $sql);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>MauzApp</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="src/facebox.css">
    <link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="./plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="./plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="./plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="./dist/css/adminlte.min.css">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <script type="text/javascript" src="../src/facebox.js"></script>
    <script src="js/jquery-1.7.2.min.js"></script>
    <script src="js/jquery_ui.js"></script>
    <script type="text/javascript" src="js/bootstrap.js"></script>
    <script type="text/javascript" src="src/facebox.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="./plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="./dist/js/adminlte.min.js"></script>
    <style>
        @media (max-width: 576px) {
            .modal-dialog {
                margin: 10px;
            }
            .modal-content {
                margin: 0 auto;
            }
            .modal-body {
                padding: 15px;
            }
            .form-group {
                margin-bottom: 10px;
            }
        }
    </style>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">




<?php include("navbar.php"); ?>   
<?php include('indexSideBar.php') ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <p>Orodha ya Dawa zote</p>
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
                        <script type="text/javascript">
                            setTimeout(function() {
                                var messageDiv = document.getElementById('message');
                                if (messageDiv) {
                                    messageDiv.style.display = 'none';
                                }
                            }, 5000);
                        </script>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <!-- <button class="btn btn-success btn-md" data-toggle="modal" data-target="#createProductModal">
                                        <span class="icon-plus-sign icon-large"></span> Ingiza Dawa mpya
                                    </button> -->
                                    Orodha ya Dawa zote (Hariri au futa Dawa)
                                </h3>
                            </div>
                            <div class="card-body">
                            <form method="POST">
          <!-- <div style="overflow-x:auto; overflow-y: auto; height: auto;"> -->
            <div style="height: auto;">
          <table id="table" class="table table-bordered table-striped table-hover table-responsive">
          <thead>
          <tr class="table-success">
             <th width="3%">S/N</th>
             <th width="3%">Jina la Dawa</th>
             <th width="1%">Aina ya Dawa</th>
             <!-- <th width="1%">Msambazaji</th> -->
             <!-- <th width="5%">Idadi iliyosajiriwa</th> -->
             <th width="1%">Idadi iliyouzwa</th>
             <th  width="1%">Idadi iliyobaki</th>
             <!-- <th width="1%">Tarehe iliyosajiriwa</th> -->
             <th width="2%">Bei kununua</th>
             <th width="2%">Bei kuuza</th>
             <th width="2%">Faida</th>
             <th width="2%">Aliyehariri</th>
             <th width="2%">Tarehe ya kuhariri</th>
             <!-- th width = "3%">Hali</th -->
             <th width = "5">Badili</th>
             <th width = "5">Futa</th>
             </tr>
           </thead>
           <tbody>
    <?php include("dbcon.php"); ?>
   <?php  
    // Modify your SQL query to retrieve records with LIMIT and OFFSET
$sql = "SELECT id, bar_code, medicine_name, category, quantity, used_quantity, remain_quantity, act_remain_quantity, register_date, expire_date, company, sell_type, actual_price, selling_price, profit_price, edited_by, edited_date, status FROM stock where store_id = '$store_id' ORDER BY id ";
  $result = mysqli_query($con, $sql); ?>
    <!-- Use a while loop to make a table row for every DB row -->
    <?php
// Initialize a counter variable
$serialNumber = 1;

// Use a while loop to fetch and display data from the database
while ($row = mysqli_fetch_array($result)) :
?>
    <tr style="">
        <!-- Display the serial number in a table cell -->
        <td><?php echo $serialNumber; ?></td>
        <!-- Each table column is echoed into a td cell -->
        <td><?php echo $row['medicine_name']; ?></td>
        <td><?php echo $row['category']; ?></td>
        <!-- <td><?php echo $row['company']; ?></td> -->
        <!-- <td><?php echo $row['quantity']."&nbsp;&nbsp;(<strong><i>".$row['sell_type']."</i></strong>)"; ?></td> -->
        <td><?php echo $row['used_quantity']; ?></td>
        <td><?php echo $row['act_remain_quantity']; ?></td>
        <!-- <td><?php echo date("d-m-Y", strtotime($row['register_date'])); ?></td> -->
        <td><?php echo number_format($row['actual_price']); ?></td>
        <td><?php echo number_format($row['selling_price']); ?></td>
        <td><?php echo $row['profit_price']; ?></td>
        <td><?php echo $row['edited_by']; ?></td>
        <td><?php echo $row['edited_date']; ?></td>
        <!-- td>
            <?php
            $status = $row['status'];
            if ($status == 'Available') {
                echo '<span class="label label-success">'.$status.'</span>';
            } else {
                echo '<span class="label label-danger">'.$status.'</span>';
            }
            ?>
        </td -->
        <td>
        <button class="btn btn-info edit-product" data-id="<?php echo $row['id']; ?>&invoice_number=<?php echo $_GET['invoice_number']?>" data-toggle="modal" data-target="#editProductModal">
        <span class="icon-edit"></span>
    </button>
        </td>
        <td>
            <button class="btn btn-danger delete" id="<?php echo $row['id']?>"><span class="icon-trash"></span></button>
        </td>
    </tr>
<?php
// Increment the serial number counter
$serialNumber++;
endwhile;
?>
<!-- Edit Product Modal -->
<div class="modal fade" id="editProductModal" tabindex="-1" role="dialog" aria-labelledby="editProductModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title text-white" id="editProductModalLabel">Hariri Dawa</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="overflow-y: auto; max-height: 70vh;">
        <!-- Form for editing product will be loaded here -->
        <div id="editProductFormContainer" class="container-fluid">
          <!-- Loading spinner while the form is being loaded -->
          <div class="text-center">
            <div class="spinner-border text-primary" role="status">
              <span class="sr-only">Inafungua...</span>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <!-- <button type="button" class="btn btn-primary" id="saveChanges">Save changes</button> -->
      </div>
    </div>
  </div>
</div>
</tbody>

           </table>  
         </div>
      </form> 
<!-- Display Total Quantity -->
<!-- Display Total Number of Products and Total Quantity -->
<div class="total-info">
    <strong>Jumla ya majina ya Dawa zote ni: <?php echo number_format($total_products); ?></strong><br>
    <strong>Jumla Idadi ya Dawa zote ni: <?php echo number_format($total_quantity); ?></strong>
</div>

<!-- Bootstrap Pagination -->
<nav aria-label="Page navigation">
    <ul class="pagination justify-content-center">
        <?php if ($page > 1) : ?>
            <li class="page-item">
                <a class="page-link" href="?page=<?php echo $page - 1; ?>&invoice_number=<?php echo $invoice_number; ?>" aria-label="Previous">
                </a>
            </li>
        <?php endif; ?>   
    </ul>
</nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Create Product Modal -->
    <div class="modal fade" id="createProductModal" tabindex="-1" role="dialog" aria-labelledby="createProductModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white" id="createProductModalLabel">Ingiza Dawa Mpya</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="createProductForm" method="POST" action="register.php?invoice_number=<?php echo $_GET['invoice_number']; ?>">
                        <!-- Form fields here (same as create_product.php) -->
                        <?php include ('create_product.php');?>
                         
  	  	 </form><br>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Funga</button>
                    <!-- <button type="submit" form="createProductForm" class="btn btn-primary">Hifadhi</button> -->
                </div>
            </div>
        </div>
    </div>
</div>
   



<script type="text/javascript">
function med_name1() {//***Search For Medicine *****
  var input, filter, table, tr, td, i;
  input = document.getElementById("name_med1");
  filter = input.value.toUpperCase();
  table = document.getElementById("table0");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0];
    if (td) {
      if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }       
  }
}


function quanti() {//***Search For quantity *****
  var input, filter, table, tr, td, i;
  input = document.getElementById("med_quantity");
  filter = input.value.toUpperCase();
  table = document.getElementById("table0");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[1];
    if (td) {
      if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }       
  }
}

function exp_date() {//***Search For expireDate *****
  var input, filter, table, tr, td, i;
  input = document.getElementById("med_exp_date");
  filter = input.value.toUpperCase();
  table = document.getElementById("table0");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[6];
    if (td) {
      if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }       
  }
}

function stat_search() {//***Search For Status*****
  var input, filter, table, tr, td, i;
  input = document.getElementById("med_status");
  filter = input.value.toUpperCase();
  table = document.getElementById("table0");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[11];
    if (td) {
      if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }       
  }
}

$(".delete").click(function() {
    var element = $(this);
    var del_id = element.attr("id");

    if (confirm("Je una uhakika unataka kuifuta Dawa hii?? Haitoweza kurudi tena")) {
        $.ajax({
            type: "GET",
            url: "delete.php",
            data: { id: del_id },
            dataType: "json", // Expect JSON response
            success: function(response) {
                if (response.status === "success") {
                    alert(response.message); // Show success message
                    location.reload(true); // Reload the page
                } else {
                    alert(response.message); // Show error message
                }
            },
            error: function(xhr, status, error) {
                alert("AJAX Error: " + error); // Show AJAX error
            }
        });
    }
    return false;
});//***Showing Alert When Deleting********
</script>
<script src="./plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<!-- THE SCRIPT BELOW MAKES Sidebar MENU TO BE NAVIGETABLE -->
<script src="./dist/js/adminlte.min.js"></script>
<script>
$(document).ready(function() {
    // Handle click event of the edit button
    $('.edit-product').on('click', function() {
        var productId = $(this).data('id');
        var invoiceNumber = "<?php echo $_GET['invoice_number']; ?>";

        // Load the edit form into the modal
        $('#editProductFormContainer').load('update_view.php?id=' + productId + '&invoice_number=' + invoiceNumber, function() {
            // This callback function executes after the content is loaded
            // Re-attach any event handlers here if needed
        });
    });

    // Ensure the modal backdrop is removed when the modal is closed
    $('#editProductModal').on('hidden.bs.modal', function() {
        $('.modal-backdrop').remove();
    });
});
</script>
<script>
    // Handle click event of the import button
    $('#importButton').click(function() {
        // Trigger click event of the hidden file input
        $('#excelFileInput').click();
    });

    // Handle change event of the file input
    $('#excelFileInput').change(function() {
        var file = this.files[0];
        
        // Perform file upload and import logic here
        // You can use AJAX to upload the file to the server
        // and then process it on the server-side
        uploadExcelFile(file);
    });

    // Function to upload the Excel file to the server
    function uploadExcelFile(file) {
        var formData = new FormData();
        formData.append('excelFile', file);
        
        $.ajax({
            url: 'import_xls.php', // Replace 'import.php' with the server-side script URL
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                // Handle success response
                alert('Faili limeingia kikamilifu!');
            },
            error: function(xhr, status, error) {
                // Handle error response
                console.error(xhr.responseText);
                alert('Tafadhari rudia tena faili lako halijaingia!!.');
            }
        });
    }
</script>

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
  $(document).ready(function() {
    $('#table').DataTable({
        "paging": true,
        "lengthChange": false,
        "pageLength": 10 // Ensure only 10 rows per page
    });
});

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
</script>
<script>
$(document).ready(function() {
    // Capitalize first letter of medicine name and category
    $('#med_name, #category').on('keyup', function() {
        var value = $(this).val();
        $(this).val(value.charAt(0).toUpperCase() + value.slice(1));
    });

    // Calculate profit
    $('#actual_price, #selling_price').on('keyup', function() {
        var act_price = parseFloat($('#actual_price').val()) || 0;
        var sell_price = parseFloat($('#selling_price').val()) || 0;
        var pro_price = sell_price - act_price;
        var percentage = Math.round((pro_price / act_price) * 100);
        var output = pro_price.toString().concat("(").concat(percentage.toString()).concat("%)");
        $('#profit_price').val(output);
    });
});
</script>
<script>
$(document).ready(function() {
    // Ensure the modal backdrop is removed when the modal is closed
    $('#createProductModal').on('hidden.bs.modal', function () {
        $('.modal-backdrop').remove(); // Remove the backdrop
    });

    // Capitalize first letter of medicine name and category
    $('#med_name, #category').on('keyup', function() {
        var value = $(this).val();
        $(this).val(value.charAt(0).toUpperCase() + value.slice(1));
    });

    // Calculate profit
    $('#actual_price, #selling_price').on('keyup', function() {
        var act_price = parseFloat($('#actual_price').val()) || 0;
        var sell_price = parseFloat($('#selling_price').val()) || 0;
        var pro_price = sell_price - act_price;
        var percentage = Math.round((pro_price / act_price) * 100);
        var output = pro_price.toString().concat("(").concat(percentage.toString()).concat("%)");
        $('#profit_price').val(output);
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
