<?php
session_start();

if(!isset($_SESSION['user_session'])){
    header("location:../index.php");
}

// Pagination settings
$records_per_page = isset($_GET['records_per_page']) ? (int)$_GET['records_per_page'] : 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start_from = ($page-1) * $records_per_page;

// Get invoice_number from URL
$invoice_number = isset($_GET['invoice_number']) ? $_GET['invoice_number'] : '';

// Include database connection
include('../dbcon.php');
?>
<!DOCTYPE html>
<html>
<head>
    <title>SPMS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="../css/bootstrap-responsive.css">
    <link rel="stylesheet" type="text/css" href="../src/facebox.css">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <script type="text/javascript" src="../js/jquery-1.7.2.min.js"></script>
    <script type="text/javascript" src="../js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../src/facebox.js"></script>
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            // POP_UP FORMS
            $("a[id*=popup").facebox({
                loadingImage: '../src/img/loading.gif',
                closeImage: '../src/img/closelabel.png'
            });
            
            // Records per page change handler
            $('#records_per_page').change(function() {
                var records = $(this).val();
                window.location.href = '?invoice_number=<?php echo $invoice_number; ?>&records_per_page=' + records;
            });
        });
    </script>
</head>
<body>
    <div class="navbar navbar-inverse navbar-fixed-top">
        <div class="navbar-inner">
            <div class="container-fluid">
                <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <a class="brand" href="#"><b>Simple Pharmacy System</b></a>
                <div class="nav-collapse">
                    <ul class="nav pull-right">
                        <li>
                            <?php 
                            $quantity = "5";
                            $select_sql1 = "SELECT * FROM stock where remain_quantity <= '$quantity' and status='Available'";
                            $result1 = mysqli_query($con,$select_sql1);
                            $row2 = $result1->num_rows;

                            if($row2 == 0){
                                echo ' <a  href="#" class="notification label-inverse" >
                                    <span class="icon-exclamation-sign icon-large"></span></a>';
                            }else{
                                echo ' <a  href="../qty_alert.php" class="notification label-inverse" id="popup">
                                    <span class="icon-exclamation-sign icon-large"></span>
                                    <span class="badge">'.$row2.'</span></a>';
                            }
                            ?> 
                        </li>
                        <li>
                            <?php
                            $date = date('d-m-Y');    
                            $inc_date = date("Y-m-d", strtotime("+6 month", strtotime($date))); 
                            $select_sql = "SELECT  * FROM stock WHERE expire_date <= '$inc_date' and status='Available' ";
                            $result =  mysqli_query($con,$select_sql); 
                            $row1 = $result->num_rows;

                            if($row1 == 0){
                                echo ' <a  href="#" class="notification label-inverse" >
                                    <span class="icon-bell icon-large"></span></a>';
                            }else{
                                echo ' <a  href="../ex_alert.php" class="notification label-inverse" id="popup">
                                    <span class="icon-bell icon-large"></span>
                                    <span class="badge">'.$row1.'</span></a>';
                            }
                            ?>
                        </li>
                        <li><a href="../home.php?invoice_number=<?php echo $invoice_number; ?>"><span class="icon-home"></span> Home</a></li>
                        <li><a href="../sales_report.php?invoice_number=<?php echo $invoice_number; ?>"><span class="icon-bar-chart"></span> Sales Report</a></li>
                        <li><a href="../backup.php?invoice_number=<?php echo $invoice_number; ?>"><span class="icon-folder-open"></span> Backup</a></li>
                        <li><a href="../logout.php" class="link"><font color='red'><span class="icon-off"></span></font> Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="contentheader">
                <h1>Products</h1>
            </div><br>
            
            <!-- Global Search -->
            <div class="col-md-12">
                <input type="text" id="searchInput" class="form-control" placeholder="Search in all columns...">
            </div><br><br>
            
            <!-- Records per page selector -->
            <div class="col-md-2">
                <select id="records_per_page" class="form-control">
                    <option value="10" <?php echo $records_per_page == 10 ? 'selected' : ''; ?>>10</option>
                    <option value="25" <?php echo $records_per_page == 25 ? 'selected' : ''; ?>>25</option>
                    <option value="50" <?php echo $records_per_page == 50 ? 'selected' : ''; ?>>50</option>
                    <option value="100" <?php echo $records_per_page == 100 ? 'selected' : ''; ?>>100</option>
                    <option value="999999" <?php echo $records_per_page == 999999 ? 'selected' : ''; ?>>All</option>
                </select>
            </div>
            
            <!-- Column-specific filters -->
            <input type="text" id="name_med1" size="4" onkeyup="med_name1()" placeholder="Filter using BarCode" title="Type BarCode">
            <input type="text" size="4" id="med_quantity" onkeyup="quanti()" placeholder="Filter using Medicine Name" title="Type Medicine Name">
            <input type="text" size="4" id="med_exp_date" onkeyup="exp_date()" placeholder="Filter using Registered Date" title="Type in registered date">
            <input type="text" size="4" id="med_status" onkeyup="stat_search()" placeholder="Filter using Profit Margin" title="Type in profit amount">
            
            <!-- Action buttons -->
            <a href="index.php?invoice_number=<?php echo $invoice_number; ?>" id="popup">
                <button class="btn btn-success btn-md" name="submit"><span class="icon-plus-sign icon-large"></span> Add New Medicine</button>
            </a>
            
            <form action="import_xls.php?invoice_number=<?php echo $invoice_number; ?>" method="post" name="frmExcelImport" id="frmExcelImport" enctype="multipart/form-data">
                <div>
                    <input type="file" name="file" id="file" accept=".xls,.xlsx" required>
                </div>
                <button class="btn btn-primary btn-md" name="submit"><span class="icon-download icon-large"></span> Import Excel file</button>
                <div id="response" class="<?php if(!empty($type)) { echo $type . " display-block"; } ?>">
                    <?php if(!empty($message)) { echo $message; } ?>
                </div>
            </form>
        </div>
    </div>

    <?php
    // Get total number of records
    $count_sql = "SELECT COUNT(*) as total FROM stock";
    $count_result = mysqli_query($con, $count_sql);
    $total_records = mysqli_fetch_assoc($count_result)['total'];

    // Calculate total pages
    $total_pages = ceil($total_records / $records_per_page);

    // Get paginated data
    $sql = "SELECT id, bar_code, medicine_name, category, quantity, used_quantity, remain_quantity, 
            act_remain_quantity, register_date, expire_date, company, sell_type, actual_price, 
            selling_price, profit_price, status 
            FROM stock 
            ORDER BY id DESC 
            LIMIT $start_from, $records_per_page";
    $result = mysqli_query($con, $sql);
    ?>

    <div style="text-align:center;">
        Total Medicines : <font color="green" style="font:bold 22px 'Aleo';">[<?php echo $total_records; ?>]</font>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-12">
                <form method="POST">
                    <div style="height: auto;">
                        <table id="table0" class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr style="background-color: #383838; color: #FFFFFF;">
                                    <th width="2%">#</th>
                                    <th width="3%">Code</th>
                                    <th width="3%">Medicine</th>
                                    <th width="1%">Category</th>
                                    <th width="5%">Registered Qty</th>
                                    <th width="1%">Sold Qty</th>
                                    <th width="1%">Remain Qty</th>
                                    <th width="1%">Registered</th>
                                    <th style="background-color: #c53f3f;" width="1%">Expiry</th>
                                    <th width="1%">Remark</th>     
                                    <th width="2%">Acutal Price</th>
                                    <th width="2%">Selling Price</th>
                                    <th width="2%">Profit</th>
                                    <th width="3%">Status</th>
                                    <th width="5%">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $serial = $start_from + 1;
                                while($row = mysqli_fetch_array($result)) : ?>
                                <tr>
                                    <td><?php echo $serial++; ?></td>
                                    <td><?php echo $row['bar_code']; ?></td>
                                    <td><?php echo $row['medicine_name']; ?></td>
                                    <td><?php echo $row['category']; ?></td>
                                    <td><?php echo $row['quantity']."&nbsp;&nbsp;(<strong><i>".$row['sell_type']."</i></strong>)"; ?></td>              
                                    <td><?php echo $row['used_quantity']; ?></td>
                                    <td><?php echo $row['remain_quantity']; ?></td>
                                    <td><?php echo date("d-m-Y", strtotime($row['register_date'])); ?></td>
                                    <td><?php echo date("d-m-Y", strtotime($row['expire_date'])); ?></td>
                                    <td><?php echo $row['company']; ?></td>
                                    <td><?php echo $row['actual_price']; ?></td>
                                    <td><?php echo $row['selling_price']; ?></td>
                                    <td><?php echo $row['profit_price']; ?></td>
                                    <td>
                                        <?php 
                                        $status = $row['status'];
                                        if($status == 'Available'){
                                            echo '<span class="label label-success">'.$status.'</span>';
                                        }else{
                                            echo '<span class="label label-danger">'.$status.'</span>';
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <a id="popup" href="update_view.php?id=<?php echo $row['id']; ?>&invoice_number=<?php echo $invoice_number; ?>">
                                            <button class="btn btn-info"><span class="icon-edit"></span></button>
                                        </a>
                                        <button class="btn btn-danger delete" id="<?php echo $row['id']; ?>">
                                            <span class="icon-trash"></span>&nbsp;
                                        </button>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </form>
                
                <!-- Pagination -->
                <div class="pagination">
                    <ul class="pagination">
                        <?php if($page > 1): ?>
                            <li><a href="?invoice_number=<?php echo $invoice_number; ?>&page=1&records_per_page=<?php echo $records_per_page; ?>">First</a></li>
                            <li><a href="?invoice_number=<?php echo $invoice_number; ?>&page=<?php echo $page-1; ?>&records_per_page=<?php echo $records_per_page; ?>">Prev</a></li>
                        <?php endif; ?>
                        
                        <?php 
                        // Show page numbers
                        $visible_pages = 5;
                        $start_page = max(1, $page - floor($visible_pages/2));
                        $end_page = min($total_pages, $start_page + $visible_pages - 1);
                        
                        for($i = $start_page; $i <= $end_page; $i++): ?>
                            <li class="<?php echo $i == $page ? 'active' : ''; ?>">
                                <a href="?invoice_number=<?php echo $invoice_number; ?>&page=<?php echo $i; ?>&records_per_page=<?php echo $records_per_page; ?>">
                                    <?php echo $i; ?>
                                </a>
                            </li>
                        <?php endfor; ?>
                        
                        <?php if($page < $total_pages): ?>
                            <li><a href="?invoice_number=<?php echo $invoice_number; ?>&page=<?php echo $page+1; ?>&records_per_page=<?php echo $records_per_page; ?>">Next</a></li>
                            <li><a href="?invoice_number=<?php echo $invoice_number; ?>&page=<?php echo $total_pages; ?>&records_per_page=<?php echo $records_per_page; ?>">Last</a></li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
    // Global search function
    $(document).ready(function(){
        $("#searchInput").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#table0 tbody tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });

    // Column-specific search functions
    function med_name1() {
        var input, filter, table, tr, td, i;
        input = document.getElementById("name_med1");
        filter = input.value.toUpperCase();
        table = document.getElementById("table0");
        tr = table.getElementsByTagName("tr");
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[1]; // Column index 1 for barcode
            if (td) {
                if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }       
        }
    }

    function quanti() {
        var input, filter, table, tr, td, i;
        input = document.getElementById("med_quantity");
        filter = input.value.toUpperCase();
        table = document.getElementById("table0");
        tr = table.getElementsByTagName("tr");
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[2]; // Column index 2 for medicine name
            if (td) {
                if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }       
        }
    }

    function exp_date() {
        var input, filter, table, tr, td, i;
        input = document.getElementById("med_exp_date");
        filter = input.value.toUpperCase();
        table = document.getElementById("table0");
        tr = table.getElementsByTagName("tr");
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[7]; // Column index 7 for registered date
            if (td) {
                if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }       
        }
    }

    function stat_search() {
        var input, filter, table, tr, td, i;
        input = document.getElementById("med_status");
        filter = input.value.toUpperCase();
        table = document.getElementById("table0");
        tr = table.getElementsByTagName("tr");
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[12]; // Column index 12 for profit
            if (td) {
                if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }       
        }
    }

    // Delete function
    $(".delete").click(function(){
        var element = $(this);
        var del_id = element.attr("id");
        var info = 'id='+del_id;

        if(confirm("Delete This Product!! Are You Sure??")){
            $.ajax({
                type: "GET",
                url: 'delete.php',
                data: info,
                success: function(){
                    location.reload(true);
                },
                error: function(){
                    alert("error");
                }
            });
        }
        return false;
    });
    </script>
</body>
</html>