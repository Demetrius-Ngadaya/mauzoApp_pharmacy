<?php
include("session.php");
?>
<?php include('indexHeader.php') ?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>MauzApp</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
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


    <script src="js/jquery-1.7.2.min.js"></script>
    <script src="js/jquery_ui.js"></script>
    <script type="text/javascript" src="js/bootstrap.js"></script>
    <script type="text/javascript" src="src/facebox.js"></script>



    <script type="text/javascript">
      jQuery(document).ready(function($) {
    $("a[id*=popup]").facebox({
      loadingImage : 'src/img/loading.gif',
      closeImage   : 'src/img/closelabel.png'
    })
  }) 
    </script>
    <script type="text/javascript" src="js/tcal.js"></script>
    <script type="text/javascript">

      function Clickheretoprint()
{ 
  var disp_setting="toolbar=yes,location=no,directories=yes,menubar=yes,"; 
      disp_setting+="scrollbars=yes,width=700, height=400, left=100, top=25"; 
  var content_vlue = document.getElementById("content").innerHTML; 
  
  var docprint=window.open("","",disp_setting); 
   docprint.document.open(); 
   docprint.document.write('</head><body onLoad="self.print()" style="width: 700px; font-size:11px; font-family:arial; font-weight:normal;">');          
   docprint.document.write(content_vlue); 
   docprint.document.close(); 
   docprint.focus(); 
}

      
    </script>


     
</head>
<body class="hold-transition sidebar-mini">
   
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">         
          <div class="col-sm-6">
           
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
  

    </aside>
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
   <center> <form action="sales_report.php?invoice_number=<?php echo $_GET['invoice_number']?>" method="POST">
  <strong>Kuanzia Tarehe : <input type="date" style="width: 223px; padding:14px;" name="d1" class="tcal" autocomplete="off" value="" /> Mbaka Tarehe: <input type="date" style="width: 223px; padding:14px;" name="d2" autocomplete="off" class="tcal" value="" />
   <button class="btn btn-info" style="width: 123px; height:50px; margin-top:-8px;margin-left:8px;" type="submit" name="submit"><i class="icon icon-search icon-large"></i> Tafuta</button>
  </strong>
  </form></center>
  
  <center>
  </center>
  
              <div style="overflow-x:auto; overflow-y: auto;">
  
  
       <table class="table table-bordered table-striped table-hover">
  
       <thead>
       <tr style="background-color: #383838; color: #FFFFFF;" >
              <th>Tarehe</th>
             <th>Dawa</th>
             <th>Idadi</th>
              <th>Jumla kiasi cha fedha</th>
              <th>Jumla ya faida</th>  
              <th>Invoice</th>
            <!--  <th>Action</th>-->
            </tr></thead>
  
          <?php
  
              include("dbcon.php");
              error_reporting(1);
              if(isset($_POST['submit'])){
              $d1=$_POST['d1'];
              $d2=$_POST['d2'];
              $select_sql = "SELECT * FROM sales where Date BETWEEN '$d1' and '$d2' order by Date desc";
              $select_query = mysqli_query($con,$select_sql);
              while($row = mysqli_fetch_array($select_query)) :
           ?>
            <tbody>
            <tr>
              <td><?php echo $row['Date']?></td>
              <td><?php echo $row['medicines']?></td>
              <td><?php echo $row['quantity']?></td>
              <td><?php echo $row['total_amount']?></td>
              <td><?php echo $row['total_profit']?></td>
              <td><?php echo $row['invoice_number']?></td>
              
              <!-- HAPA KULIKUWA NA BUTTON YA KU DOWNLOAD NIMEIFUTA -->
  
                                       <?php endwhile;?>
  
            </tr>
            </tbody>
  
            <th colspan="3">Jumla mkuu:</th>
                <th>
                  <?php
  
                  $select_sql = "SELECT sum(total_amount) from sales where Date BETWEEN '$d1' and '$d2'";
  
                  $select_query = mysqli_query($con, $select_sql);
  
                  while($row = mysqli_fetch_array($select_query)){
  
                     echo $row['sum(total_amount)'].' Tsh';
  
                }
  
                  ?>
                </th>
                <th colspan="2">
                  <?php
  
                  $select_sql = "SELECT sum(total_profit) from sales where Date BETWEEN '$d1' and '$d2'";
  
                  $select_query = mysqli_query($con, $select_sql);
  
                  while($row = mysqli_fetch_array($select_query)){
  
                     echo $row['sum(total_profit)'].' Tsh';
                }
                  ?>
                            <?php }else{
  
  
  
  
                            $select_sql = "SELECT * FROM sales where Date = '$date'";
                            $select_query = mysqli_query($con,$select_sql);
                            while($row = mysqli_fetch_array($select_query)) :
  
  
                              ?>
  
                               <tbody>
            <tr> 
              <td><?php echo $row['Date']?>&nbsp;&nbsp;(<font size='2' color='#009688;'>Leo</font>)</td>
              <td><?php $invoice_number =  $row['invoice_number'];
  
                   echo $invoice_number;
  
                   ?></td>
            
             <td><?php echo $row['medicines']?></td>
             <td><?php echo $row['quantity']?></td>
  
              <td><?php echo $row['total_amount']?></td>
              <td><?php echo $row['total_profit']?></td>
              <td><a href="download.php?invoice_number=<?php echo $invoice_number?>"><button class="btn btn-success btn-md"><span class="icon-download-alt"></span> Download</button></a>
          </td>
         <?php endwhile;?>
  
            </tr>
            </tbody>
  
             <th colspan="3">Jumla Kuu:</th>
                <th>
                  <?php
  
                  $select_sql = "SELECT sum(total_amount) from sales where Date = '$date'";
  
                  $select_query = mysqli_query($con, $select_sql);
  
                  while($row = mysqli_fetch_array($select_query)){
  
                     echo $row['sum(total_amount)'].' Tsh';
  
                }
  
                  ?>
                </th>
                <th colspan="3">
                  <?php
  
                  $select_sql = "SELECT sum(total_profit) from sales where Date = '$date'";
  
                  $select_query = mysqli_query($con, $select_sql);
  
                  while($row = mysqli_fetch_array($select_query)){
  
                     echo $row['sum(total_profit)'];
                }
                  ?>
  
                            <?php } ?>
                </th>
  
        </table>
  
     </div>
    </div>
  </div>
  </body>
  
  </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
</div>
<!-- ./wrapper -->
<script src="./plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->

<!-- THE SCRIPT BELOW MAKES Sidebar MENU TO BE NAVIGETABLE -->
<script src="./dist/js/adminlte.min.js"></script>
</body>
</html>

