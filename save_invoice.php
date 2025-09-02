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
        $check_sql = "SELECT invoice_number FROM sales WHERE  invoice_number = ? UNION SELECT invoice_number FROM on_hold WHERE invoice_number = ?";
        $stmt = $con->prepare($check_sql);
        $stmt->bind_param("ss", $invoice_number, $invoice_number);
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

// Process POST request for saving sales data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate input data
    if (empty($_POST['invoice_number']) || empty($_POST['paid_amount'])) {
        echo json_encode(["status" => "error", "message" => "Invalid input data"]);
        exit();
    }

    // Assign POST data to variables
    $invoice_number = $_POST['invoice_number'];
    $paid_amount = $_POST['paid_amount'];
    $date = $_POST['date'];
    $transfer_status = 'hamisha';
    $created_by = $_SESSION['user_session'];

    // Fetch items from `on_hold` table
    $select_on_hold = "SELECT * FROM on_hold WHERE store_id = '$store_id' and invoice_number = '$invoice_number'";
    $select_on_hold_query = mysqli_query($con, $select_on_hold);

    if (mysqli_num_rows($select_on_hold_query) > 0) {
        while ($row = mysqli_fetch_array($select_on_hold_query)) {
            // Process each item
            $medicine_name = $row['medicine_name'];
            $category = $row['category'];
            $quantity = $row['qty'];
            $amount = $row['amount'];
            $profit_amount = $row['profit_amount'];
            $payment_method = $row['payment_method'];
            $status = $row['hali_ya_malipo'];

            // Handle NULL or empty values for phone_number and date_to_pay
            $phone_number = !empty($row['phone_number']) ? $row['phone_number'] : NULL;
            $date_to_pay = !empty($row['date_to_pay']) ? $row['date_to_pay'] : NULL;

            // Fetch medicine ID from `stock` table
            $select_stock = "SELECT id, act_remain_quantity FROM stock WHERE store_id = '$store_id' and medicine_name = '$medicine_name' AND category = '$category'";
            $select_stock_query = mysqli_query($con, $select_stock);
            $stock_row = mysqli_fetch_array($select_stock_query);
            $medicine_id = $stock_row['id'];
            $remain_quantity = $stock_row['act_remain_quantity'];
   

               // Insert transfer record
            $insert_sql = "INSERT INTO transfers (
                medicine_id, invoice_number, medicines, category, quantity, total_amount, total_profit, 
                payment_method, phone_number, date_to_pay, customer_name, created_by, date, hali_ya_malipo, store_id, transfer_status
            ) VALUES (
                '$medicine_id', '$invoice_number', '$medicine_name', '$category', '$quantity', '$amount', '$profit_amount', 
                '$payment_method', " . ($phone_number ? "'$phone_number'" : "NULL") . ", " . ($date_to_pay ? "'$date_to_pay'" : "NULL") . ", '$paid_amount', '$created_by', '$date', '$status', '$store_id', '$transfer_status'
            )";
            $insert_query = mysqli_query($con, $insert_sql);
            // Insert sales record
            $insert_sql = "INSERT INTO sales (
                medicine_id, invoice_number, medicines, category, quantity, total_amount, total_profit, 
                payment_method, phone_number, date_to_pay, customer_name, created_by, date, hali_ya_malipo, store_id, transfer_status
            ) VALUES (
                '$medicine_id', '$invoice_number', '$medicine_name', '$category', '$quantity', '$amount', '$profit_amount', 
                '$payment_method', " . ($phone_number ? "'$phone_number'" : "NULL") . ", " . ($date_to_pay ? "'$date_to_pay'" : "NULL") . ", '$paid_amount', '$created_by', '$date', '$status', '$store_id', '$transfer_status'
            )";
            $insert_query = mysqli_query($con, $insert_sql);

            if ($insert_query) {
                // Update stock
                $new_remain_quantity = $remain_quantity - $quantity;
                $update_stock = "UPDATE stock SET act_remain_quantity = '$new_remain_quantity' WHERE store_id = '$store_id' and id = '$medicine_id'";
                $update_stock_query = mysqli_query($con, $update_stock);

                if (!$update_stock_query) {
                    echo json_encode(["status" => "error", "message" => "Failed to update stock for medicine: $medicine_name."]);
                    exit();
                }
            } else {
                echo json_encode(["status" => "error", "message" => "Failed to insert sales data for medicine: $medicine_name."]);
                exit();
            }
        }

        // DELETE records from on_hold table after successful sales insertion
        $delete_on_hold = "DELETE FROM on_hold WHERE store_id = '$store_id' and invoice_number = '$invoice_number'";
        $delete_on_hold_query = mysqli_query($con, $delete_on_hold);

        if (!$delete_on_hold_query) {
            echo json_encode(["status" => "error", "message" => "Sales saved but failed to clear on_hold records."]);
            exit();
        }

        // Generate a new invoice number for the next sale
        $new_invoice_number = generate_unique_invoice_number($con);

        // Return success response with the current and new invoice numbers
        echo json_encode([
            "status" => "success",
            "message" => "Mauzo yako yamehifadhiwa", // Success message in Swahili
            "invoice_number" => $invoice_number, // Current invoice number
            "new_invoice_number" => $new_invoice_number // New invoice number
        ]);
        exit();
    } else {
        echo json_encode(["status" => "error", "message" => "No items found in on_hold table for the given invoice."]);
        exit();
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method"]);
    exit();
}
?>