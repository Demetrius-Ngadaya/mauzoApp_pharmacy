<?php
include("session.php");
include('dbcon.php');

// Determine work mode based on time of day
$current_hour = date('H');
if ($current_hour >= 6 && $current_hour < 16) {
    $work_mode = 'kufungua'; // Morning (6 AM to 6 PM)
} else {
    $work_mode = 'kufunga'; // Evening (6 PM to 6 AM)
}
// Get existing records if any
$today = date('Y-m-d');
$query = mysqli_query($con, "SELECT * FROM uwakala WHERE DATE(created_at) = '$today' AND work_mode = '$work_mode'") 
         or die(mysqli_error($con));

$existing_records = [];
while ($row = mysqli_fetch_array($query)) {
    $existing_records[$row['jina_laini']] = $row;
}

// Define the lines
$lines = ['Mix By Yas', 'Airtel Money', 'Halo Pesa', 'M-Pesa', 'T-PESA', 'Azam pesa'];

// Initialize message variables
$message = '';
$message_type = '';

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_data'])) {
    // Get user ID from session (adjust based on your session structure)
    $created_by = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 1; // Default to 1 if not set
    $created_at = date('Y-m-d H:i:s');
    
    // Calculate totals
    $grant_total = 0;
    $success = true;
    
    foreach ($lines as $line) {
        // Create a sanitized field name (replace spaces with underscores)
        $sanitized_line = str_replace(' ', '_', $line);
        
        // Sanitize input values with proper checks
        if ($work_mode == 'kufungua') {
            $kiasi_kufungua = isset($_POST[$sanitized_line . '_kiasi_kufungua']) ? floatval($_POST[$sanitized_line . '_kiasi_kufungua']) : 0;
            $kiasi_lipa_account = isset($_POST[$sanitized_line . '_kiasi_lipa_account']) ? floatval($_POST[$sanitized_line . '_kiasi_lipa_account']) : 0;
            $kiasi_cash = isset($_POST[$sanitized_line . '_kiasi_cash']) ? floatval($_POST[$sanitized_line . '_kiasi_cash']) : 0;
            $jumla = $kiasi_kufungua + $kiasi_lipa_account + $kiasi_cash;
            
            // Check if record exists
            $record_exists = isset($existing_records[$line]);
            
            if ($record_exists) {
                $record_id = $existing_records[$line]['id'];
                $update_query = "UPDATE uwakala SET 
                                kiasi_kufungua = '$kiasi_kufungua', 
                                kiasi_lipa_account = '$kiasi_lipa_account', 
                                kiasi_cash = '$kiasi_cash', 
                                jumla = '$jumla',
                                updated_at = '$created_at',
                                updated_by = '$created_by'
                                WHERE id = '$record_id'";
                if (!mysqli_query($con, $update_query)) {
                    $success = false;
                    $message = "Hitilafu imetokea wakati wa kuboresha rekodi: " . mysqli_error($con);
                    $message_type = 'error';
                }
            } else {
                $insert_query = "INSERT INTO uwakala (work_mode, jina_laini, kiasi_kufungua, kiasi_lipa_account, kiasi_cash, jumla, created_by, created_at)
                                VALUES ('$work_mode', '$line', '$kiasi_kufungua', '$kiasi_lipa_account', '$kiasi_cash', '$jumla', '$created_by', '$created_at')";
                if (!mysqli_query($con, $insert_query)) {
                    $success = false;
                    $message = "Hitilafu imetokea wakati wa kuingiza rekodi: " . mysqli_error($con);
                    $message_type = 'error';
                }
            }
            
            $grant_total += $jumla;
        } else {
            $kiasi_kufunga = isset($_POST[$sanitized_line . '_kiasi_kufunga']) ? floatval($_POST[$sanitized_line . '_kiasi_kufunga']) : 0;
            $kiasi_lipa_account = isset($_POST[$sanitized_line . '_kiasi_lipa_account']) ? floatval($_POST[$sanitized_line . '_kiasi_lipa_account']) : 0;
            $kiasi_cash = isset($_POST[$sanitized_line . '_kiasi_cash']) ? floatval($_POST[$sanitized_line . '_kiasi_cash']) : 0;
            $jumla = $kiasi_kufunga + $kiasi_lipa_account + $kiasi_cash;
            
            // Check if record exists
            $record_exists = isset($existing_records[$line]);
            
            if ($record_exists) {
                $record_id = $existing_records[$line]['id'];
                $update_query = "UPDATE uwakala SET 
                                kiasi_kufunga = '$kiasi_kufunga', 
                                kiasi_lipa_account = '$kiasi_lipa_account', 
                                kiasi_cash = '$kiasi_cash', 
                                jumla = '$jumla',
                                updated_at = '$created_at',
                                updated_by = '$created_by'
                                WHERE id = '$record_id'";
                if (!mysqli_query($con, $update_query)) {
                    $success = false;
                    $message = "Hitilafu imetokea wakati wa kuboresha rekodi: " . mysqli_error($con);
                    $message_type = 'error';
                }
            } else {
                $insert_query = "INSERT INTO uwakala (work_mode, jina_laini, kiasi_kufunga, kiasi_lipa_account, kiasi_cash, jumla, created_by, created_at)
                                VALUES ('$work_mode', '$line', '$kiasi_kufunga', '$kiasi_lipa_account', '$kiasi_cash', '$jumla', '$created_by', '$created_at')";
                if (!mysqli_query($con, $insert_query)) {
                    $success = false;
                    $message = "Hitilafu imetokea wakati wa kuingiza rekodi: " . mysqli_error($con);
                    $message_type = 'error';
                }
            }
            
            $grant_total += $jumla;
        }
    }
    
    if ($success) {
        $message = "Taarifa za $work_mode zimehifadhiwa kikamilifu!";
        $message_type = 'success';
        
        // Refresh existing records after saving
        $query = mysqli_query($con, "SELECT * FROM uwakala WHERE DATE(created_at) = '$today' AND work_mode = '$work_mode'") 
                 or die(mysqli_error($con));
        $existing_records = [];
        while ($row = mysqli_fetch_array($query)) {
            $existing_records[$row['jina_laini']] = $row;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>MauzoApp - Uwakala Management</title>
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
  <style>
    .table-total {
        font-weight: bold;
        background-color: #f8f9fa;
    }
    .work-mode-banner {
        padding: 10px;
        text-align: center;
        font-weight: bold;
        margin-bottom: 20px;
    }
    .kufungua-banner {
        background-color: #d4edda;
        color: #155724;
    }
    .kufunga-banner {
        background-color: #f8d7da;
        color: #721c24;
    }
    .alert-success {
        background-color: #d4edda;
        border-color: #c3e6cb;
        color: #155724;
    }
    .alert-error {
        background-color: #f8d7da;
        border-color: #f5c6cb;
        color: #721c24;
    }
  </style>
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
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Usimamizi wa Uwakala</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Uwakala Management</li>
            </ol>
          </div>
        </div>
      </div>
    </section>
    <section class="content">
      <div class="container-fluid">
        <!-- Message Display -->
        <?php if (!empty($message)): ?>
          <div class="alert alert-<?php echo $message_type == 'success' ? 'success' : 'danger'; ?> alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h5><i class="icon fas fa-<?php echo $message_type == 'success' ? 'check' : 'exclamation-triangle'; ?>"></i> 
                <?php echo $message_type == 'success' ? 'Imefanikiwa!' : 'Hitilafu!'; ?>
            </h5>
            <?php echo $message; ?>
          </div>
        <?php endif; ?>
        
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-body">
                <div class="work-mode-banner <?php echo $work_mode == 'kufungua' ? 'kufungua-banner' : 'kufunga-banner'; ?>">
                  <h4>Hali ya Kazi: <?php echo strtoupper($work_mode); ?></h4>
                  <p><?php echo $work_mode == 'kufungua' ? 'Wakati wa kufungua biashara (asubuhi)' : 'Wakati wa kufunga biashara (jioni)'; ?></p>
                </div>
                
                <form method="POST" action="" id="uwakalaForm">
                  <input type="hidden" name="save_data" value="1">
                  <table class="table table-bordered table-striped">
                    <thead>
                      <tr class="table-success">
                        <th>Jina la Laini</th>
                        <?php if ($work_mode == 'kufungua'): ?>
                          <th>Kiasi Kufungua (TZS)</th>
                        <?php else: ?>
                          <th>Kiasi Kufunga (TZS)</th>
                        <?php endif; ?>
                        <th>Kiasi Lipa Account (TZS)</th>
                        <th>Kiasi Cash (TZS)</th>
                        <th>Jumla (TZS)</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $grant_total = 0;
                      foreach ($lines as $line):
                        $record = isset($existing_records[$line]) ? $existing_records[$line] : null;
                        // Create a sanitized field name (replace spaces with underscores)
                        $sanitized_line = str_replace(' ', '_', $line);
                      ?>
                      <tr>
                        <td><?php echo $line; ?></td>
                        <?php if ($work_mode == 'kufungua'): ?>
                          <td>
                            <input type="number" step="0.01" min="0" class="form-control kufungua-input" 
                                   name="<?php echo $sanitized_line; ?>_kiasi_kufungua" 
                                   value="<?php echo $record ? $record['kiasi_kufungua'] : 0; ?>" 
                                   required>
                          </td>
                        <?php else: ?>
                          <td>
                            <input type="number" step="0.01" min="0" class="form-control kufunga-input" 
                                   name="<?php echo $sanitized_line; ?>_kiasi_kufunga" 
                                   value="<?php echo $record ? $record['kiasi_kufunga'] : 0; ?>" 
                                   required>
                          </td>
                        <?php endif; ?>
                        <td>
                          <input type="number" step="0.01" min="0" class="form-control lipa-account-input" 
                                 name="<?php echo $sanitized_line; ?>_kiasi_lipa_account" 
                                 value="<?php echo $record ? $record['kiasi_lipa_account'] : 0; ?>" 
                                 required>
                        </td>
                        <td>
                          <input type="number" step="0.01" min="0" class="form-control cash-input" 
                                 name="<?php echo $sanitized_line; ?>_kiasi_cash" 
                                 value="<?php echo $record ? $record['kiasi_cash'] : 0; ?>" 
                                 required>
                        </td>
                        <td class="line-total">
                          <?php 
                          if ($record) {
                              echo number_format($record['jumla'], 2);
                              $grant_total += $record['jumla'];
                          } else {
                              echo "0.00";
                          }
                          ?>
                        </td>
                      </tr>
                      <?php endforeach; ?>
                      <tr class="table-total">
                        <td colspan="4" class="text-right"><strong>Jumla Kuu:</strong></td>
                        <td id="grant-total"><?php echo number_format($grant_total, 2); ?></td>
                      </tr>
                    </tbody>
                  </table>
                  
                  <div class="form-group">
                    <button type="button" id="saveButton" class="btn btn-primary btn-lg">
                      <i class="fas fa-save"></i> Hifadhi Taarifa za <?php echo $work_mode; ?>
                    </button>
                  </div>
                </form>
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

<!-- Confirmation Modal -->
<div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="confirmationModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="confirmationModalLabel">Thibitisha Usasishaji</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Je, una uhakika unataka kuhifadhi taarifa za <?php echo $work_mode; ?>?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Ghairi</button>
        <button type="button" class="btn btn-primary" id="confirmSave">Ndio, Hifadhi</button>
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
  $(document).ready(function() {
    // Function to calculate line total and grant total
    function calculateTotals() {
      let grantTotal = 0;
      
      $('tbody tr').each(function() {
        if (!$(this).hasClass('table-total')) {
          let kufungua = 0;
          let kufunga = 0;
          let lipaAccount = 0;
          let cash = 0;
          
          // Get values based on work mode
          if ($('.kufungua-input').length > 0) {
            kufungua = parseFloat($(this).find('.kufungua-input').val()) || 0;
          } else {
            kufunga = parseFloat($(this).find('.kufunga-input').val()) || 0;
          }
          
          lipaAccount = parseFloat($(this).find('.lipa-account-input').val()) || 0;
          cash = parseFloat($(this).find('.cash-input').val()) || 0;
          
          // Calculate line total
          const lineTotal = kufungua + kufunga + lipaAccount + cash;
          $(this).find('.line-total').text(lineTotal.toFixed(2));
          
          grantTotal += lineTotal;
        }
      });
      
      // Update grant total
      $('#grant-total').text(grantTotal.toFixed(2));
    }
    
    // Calculate totals when input values change
    $('.kufungua-input, .kufunga-input, .lipa-account-input, .cash-input').on('input', calculateTotals);
    
    // Initial calculation
    calculateTotals();
    
    // Confirmation dialog
    $('#saveButton').click(function() {
      $('#confirmationModal').modal('show');
    });
    
    $('#confirmSave').click(function() {
      $('#confirmationModal').modal('hide');
      $('#uwakalaForm').submit();
    });
    
    // Auto-hide success message after 5 seconds
    setTimeout(function() {
      $('.alert').fadeOut('slow');
    }, 5000);
  });
</script>
</body>
</html>