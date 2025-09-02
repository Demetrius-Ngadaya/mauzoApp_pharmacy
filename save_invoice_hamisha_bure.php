<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include database connection
include "dbcon.php";
include("session.php");

$store_id = $_SESSION['store_id'];

// Function to generate a unique invoice number
function generate_unique_invoice_number($con) {
    do {
        $chars = "09302909209300923";
        srand((double)microtime() * 1000000);
        $i = 1; 
        $pass = '';

        while ($i <= 7) {
            $num  = rand() % 10;
            $tmp  = substr($chars, $num, 1);
            $pass = $pass . $tmp;
            $i++;
        }
        $invoice_number = "CA-" . $pass;

        // Check for existing invoice number
        $check_sql = "SELECT invoice_number FROM sales WHERE invoice_number = ? 
                      UNION SELECT invoice_number FROM on_hold WHERE invoice_number = ?
                      UNION SELECT invoice_number FROM transfers WHERE invoice_number = ?";
        $stmt = $con->prepare($check_sql);
        $stmt->bind_param("sss", $invoice_number, $invoice_number, $invoice_number);
        $stmt->execute();
        $result = $stmt->get_result();
    } while ($result->num_rows > 0);

    return $invoice_number;
}

// Handle request to generate a new invoice number
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === "generate_invoice_number") {
    $new_invoice_number = generate_unique_invoice_number($con);
    echo json_encode([
        "status" => "success",
        "new_invoice_number" => $new_invoice_number
    ]);
    exit();
}

// Process POST request for saving transfer data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate input data
    if (empty($_POST['invoice_number']) || empty($_POST['receiving_store_id'])) {
        echo json_encode(["status" => "error", "message" => "Hakikisha umechagua kituo/tawi na namba ya ankara"]);
        exit();
    }

    // Assign POST data to variables
    $invoice_number = $_POST['invoice_number'];
    $receiving_store_id = $_POST['receiving_store_id'];
    $date = $_POST['date'];
    $transfer_status = 'hamisha'; // Status for sent transfers
    $created_by = $_SESSION['user_session'];
    $transfer_date = date('Y-m-d H:i:s'); // Current date and time
    
    // Get store names for records
    $sending_store_query = mysqli_query($con, "SELECT name FROM stores WHERE id = '$store_id'");
    $sending_store = mysqli_fetch_array($sending_store_query);
    
    $receiving_store_query = mysqli_query($con, "SELECT name FROM stores WHERE id = '$receiving_store_id'");
    $receiving_store = mysqli_fetch_array($receiving_store_query);
    
    $customer_name = $receiving_store['name'];

    // Start transaction
    mysqli_begin_transaction($con);

    try {
        // Fetch items from `on_hold` table
        $select_on_hold = "SELECT * FROM on_hold WHERE store_id = '$store_id' AND invoice_number = '$invoice_number'";
        $select_on_hold_query = mysqli_query($con, $select_on_hold);

        if (mysqli_num_rows($select_on_hold_query) === 0) {
            throw new Exception("Hakuna Dawa zilizochaguliwa kwa uhamisho.");
        }

        while ($row = mysqli_fetch_array($select_on_hold_query)) {
            // Process each item
            $medicine_name = $row['medicine_name'];
            $category = $row['category'];
            $quantity = $row['qty'];
            $amount = $row['amount'];
            $profit_amount = $row['profit_amount'];
            $payment_method = 'Bure';
            $status = $row['hali_ya_malipo'];

            // Handle NULL or empty values
            $phone_number = !empty($row['phone_number']) ? $row['phone_number'] : NULL;
            $date_to_pay = !empty($row['date_to_pay']) ? $row['date_to_pay'] : NULL;

            // Fetch medicine ID from `stock` table
            $select_stock = "SELECT id, act_remain_quantity FROM stock 
                            WHERE store_id = '$store_id' AND medicine_name = '$medicine_name' 
                            AND category = '$category'";
            $select_stock_query = mysqli_query($con, $select_stock);
            
            if (mysqli_num_rows($select_stock_query) === 0) {
                throw new Exception("Dawa $medicine_name haipo kwenye hesabu yako.");
            }
            
            $stock_row = mysqli_fetch_array($select_stock_query);
            $medicine_id = $stock_row['id'];
            $remain_quantity = $stock_row['act_remain_quantity'];

            // Check if sufficient stock exists
            if ($remain_quantity < $quantity) {
                throw new Exception("Hakuna vya kutosha $medicine_name (Inabaki: $remain_quantity, Unahitaji: $quantity)");
            }

            // Insert transfer record
            $insert_transfer_sql = "INSERT INTO transfers (
                medicine_id, invoice_number, medicines, category, quantity, 
                total_amount, total_profit, payment_method, phone_number, 
                date_to_pay, customer_name, created_by, date, hali_ya_malipo, 
                store_id, receiving_store_id, transfering_store_id, transfer_status, transfer_date
            ) VALUES (
                '$medicine_id', '$invoice_number', '$medicine_name', '$category', '$quantity', 
                '$amount', '$profit_amount', '$payment_method', " . 
                ($phone_number ? "'$phone_number'" : "NULL") . ", " . 
                ($date_to_pay ? "'$date_to_pay'" : "NULL") . ", 
                '$customer_name', '$created_by', '$date', '$status', 
                '$store_id', '$receiving_store_id', '$store_id', '$transfer_status', '$transfer_date'
            )";
            
            $insert_transfer_query = mysqli_query($con, $insert_transfer_sql);
            
            if (!$insert_transfer_query) {
                throw new Exception("Imeshindikana kuhifadhi rekodi ya uhamisho kwa $medicine_name.");
            }

            // Update stock in sending store
            $new_remain_quantity = $remain_quantity - $quantity;
            $update_stock = "UPDATE stock SET act_remain_quantity = '$new_remain_quantity' 
                            WHERE id = '$medicine_id' AND store_id = '$store_id'";
            $update_stock_query = mysqli_query($con, $update_stock);
            
            if (!$update_stock_query) {
                throw new Exception("Imeshindikana kusasisha hesabu ya $medicine_name.");
            }
        }

        // Delete records from on_hold table
        $delete_on_hold = "DELETE FROM on_hold WHERE store_id = '$store_id' AND invoice_number = '$invoice_number'";
        $delete_on_hold_query = mysqli_query($con, $delete_on_hold);
        
        if (!$delete_on_hold_query) {
            throw new Exception("Imeshindikana kufuta rekodi za awali.");
        }

        // Commit transaction
        mysqli_commit($con);

        // Generate a new invoice number for the next sale
        $new_invoice_number = generate_unique_invoice_number($con);

        // Return success response
        echo json_encode([
            "status" => "success",
            "message" => "Mizani imetumwa kikamilifu kwa " . $receiving_store['name'],
            "invoice_number" => $invoice_number,
            "new_invoice_number" => $new_invoice_number
        ]);
        exit();

    } catch (Exception $e) {
        // Rollback transaction on error
        mysqli_rollback($con);
        echo json_encode([
            "status" => "error",
            "message" => $e->getMessage()
        ]);
        exit();
    }
} else {
    echo json_encode(["status" => "error", "message" => "Njia ya maombi si sahihi"]);
    exit();
}
?>