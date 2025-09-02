<?php
session_start();
$store_id = $_SESSION['store_id'];
include("dbcon.php");
if (!isset($_SESSION['user_session'])) {
    header("location:index.php");
    exit();
}

$invoice_number = $_GET['invoice_number'];
$response = [];

if (isset($_POST['id'])) { // Check if we have array data
    // Initialize arrays
    $ids = $_POST['id'];
    $count = count($ids);
    
    // Begin transaction for atomic operations
    mysqli_begin_transaction($con);
    
    try {
        for ($i = 0; $i < $count; $i++) {
            // Validate required fields
            if (empty($_POST['med_name'][$i]) || empty($_POST['received_quantity'][$i])) {
                throw new Exception("Sehemu muhimu hazijajazwa kwa Dawa " . ($i+1));
            }
            
            // Prepare data
            $id = mysqli_real_escape_string($con, $_POST['id'][$i]);
            $med_name = mysqli_real_escape_string($con, $_POST['med_name'][$i]);
            $category = mysqli_real_escape_string($con, $_POST['category'][$i]);
            $used_quantity = intval($_POST['used_quantity'][$i]);
            $received_quantity = intval($_POST['received_quantity'][$i]);
            $act_remain_quantity = intval($_POST['act_remain_quantity'][$i]) + $received_quantity;
            $quantity = intval($_POST['quantity'][$i]) + $received_quantity;
            $exp_date = date('Y-m-d', strtotime($_POST['exp_date'][$i]));
            $company = mysqli_real_escape_string($con, $_POST['company'][$i]);
            $received_date = date('Y-m-d', strtotime($_POST['received_date'][$i]));
            $receipt_number = mysqli_real_escape_string($con, $_POST['receipt_number'][$i]);
            $batch_number = mysqli_real_escape_string($con, $_POST['batch_number'][$i]);
            $sell_type = mysqli_real_escape_string($con, $_POST['sell_type'][$i]);
            $actual_price = floatval($_POST['actual_price'][$i]);
            $selling_price = floatval($_POST['selling_price'][$i]);
            $profit_price = mysqli_real_escape_string($con, $_POST['profit_price'][$i]);
            $credit_amount = $received_quantity * $actual_price;
            $tax_amount = floatval($_POST['tax_amount'][$i]);
            $cost_kupakia = floatval($_POST['cost_kupakia'][$i]);
            $cost_kushusha = floatval($_POST['cost_kushusha'][$i]);
            $transport_cost = floatval($_POST['transport_cost'][$i]);
            $cost_kupanga = floatval($_POST['cost_kupanga'][$i]);
            $products_cost = floatval($_POST['products_cost'][$i]);
            $total_cost = floatval($_POST['total_cost'][$i]);
            $expected_profit = floatval($_POST['expected_profit'][$i]);
            $created_by = $_SESSION['user_session'];
            $store_id = $_SESSION['store_id'];
            // Update stock table
            $sql = "UPDATE stock SET 
                medicine_name='$med_name', category='$category', quantity='$quantity', 
                used_quantity='$used_quantity', remain_quantity='$act_remain_quantity', 
                act_remain_quantity='$act_remain_quantity', expire_date='$exp_date', 
                company='$company', sell_type='$sell_type', actual_price='$actual_price', 
                selling_price='$selling_price', profit_price='$profit_price', status='Available' 
                WHERE store_id = '$store_id' AND  id='$id'";
            
            if (!mysqli_query($con, $sql)) {
                throw new Exception("Hitilafu wakati wa kusasisha hesabu: " . mysqli_error($con));
            }
            
            // Insert into purchases_report
            $sql = "INSERT INTO purchases_report (
                medicine_name, category, old_quantity, received_quantity, receipt_number, batch_number,
                received_date, expire_date, company, sell_type, actual_price, selling_price, 
                profit_price, credit_amount, created_by, status, tax_amount, cost_kupakia, cost_kushusha, 
                transport_cost, cost_kupanga, products_cost, total_cost, expected_profit, medicine_id, store_id
            ) VALUES (
                '$med_name', '$category', '$act_remain_quantity', '$received_quantity', 
                '$receipt_number', '$batch_number', '$received_date', '$exp_date', 
                '$company', '$sell_type', '$actual_price', '$selling_price', 
                '$profit_price', '$credit_amount', '$created_by', 'cash', 
                '$tax_amount', '$cost_kupakia', '$cost_kushusha', '$transport_cost', 
                '$cost_kupanga', '$products_cost', '$total_cost', '$expected_profit', '$id', '$store_id'
            )";
            
            if (!mysqli_query($con, $sql)) {
                throw new Exception("Hitilafu wakati wa kurekodi manunuzi: " . mysqli_error($con));
            }
        }
        
        // Commit transaction if all queries succeeded
        mysqli_commit($con);
        // $_SESSION['success_message'] = "Manunuzi ya Dawa yamerekodiwa kikamilifu!";
        
        // Return JSON response for AJAX
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            header('Content-Type: application/json');
            echo json_encode(['success' => true]);
            exit();
        } else {
            header("Location: record_purchases.php?invoice_number=$invoice_number");
            exit();
        }
        
    } catch (Exception $e) {
        // Rollback transaction on error
        mysqli_rollback($con);
        
        // Return error response
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            header('Content-Type: application/json');
            echo json_encode(['error' => $e->getMessage()]);
            exit();
        } else {
            $_SESSION['error_message'] = $e->getMessage();
            header("Location: record_purchases.php?invoice_number=$invoice_number");
            exit();
        }
    }
} else {
    // No data received
    $error = "Hakuna data iliyopokelewa kwa ajili ya kuhifadhi.";
    
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        header('Content-Type: application/json');
        echo json_encode(['error' => $error]);
        exit();
    } else {
        $_SESSION['error_message'] = $error;
        header("Location: record_purchases.php?invoice_number=$invoice_number");
        exit();
    }
}
// After all processing is done in purchases.php
if ($success) {
    echo json_encode([
        'success' => true,
        'message' => 'Manunuzi yamehifadhiwa kikamilifu'
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => $error_message
    ]);
}
exit;
?>