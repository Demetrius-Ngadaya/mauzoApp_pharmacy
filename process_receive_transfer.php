<?php
session_start();
$store_id = $_SESSION['store_id'];
include("dbcon.php");

if (!isset($_SESSION['user_session'])) {
    header("location:index.php");
    exit();
}

$response = ['success' => false, 'message' => ''];

if (isset($_POST['transfer_ids'])) {
    // Begin transaction
    mysqli_begin_transaction($con);

    try {
        $transfer_ids = $_POST['transfer_ids'];
        $medicine_ids = $_POST['medicine_ids'];
        $med_names = $_POST['med_name'];
        $categories = $_POST['category'];
        $received_quantities = $_POST['received_quantity'];
        $actual_prices = $_POST['actual_price'];
        $companies = $_POST['company'];
        $quantities = $_POST['quantity'];
        $used_quantities = $_POST['used_quantity'];
        $act_remain_quantities = $_POST['act_remain_quantity'];
        $exp_dates = $_POST['exp_date'];
        $selling_prices = $_POST['selling_price'];
        $tax_amounts = $_POST['tax_amount'];
        $cost_kupakias = $_POST['cost_kupakia'];
        $cost_kushushas = $_POST['cost_kushusha'];
        $transport_costs = $_POST['transport_cost'];
        $cost_kupangas = $_POST['cost_kupanga'];
        $products_costs = $_POST['products_cost'];
        $total_costs = $_POST['total_cost'];

        for ($i = 0; $i < count($transfer_ids); $i++) {
            $transfer_id = mysqli_real_escape_string($con, $transfer_ids[$i]);
            $medicine_id = mysqli_real_escape_string($con, $medicine_ids[$i]);
            $med_name = mysqli_real_escape_string($con, $med_names[$i]);
            $category = mysqli_real_escape_string($con, $categories[$i]);
            $received_quantity = intval($received_quantities[$i]);
            $actual_price = floatval($actual_prices[$i]);
            $company = mysqli_real_escape_string($con, $companies[$i]);
            $quantity = intval($quantities[$i]);
            $used_quantity = intval($used_quantities[$i]);
            $act_remain_quantity = intval($act_remain_quantities[$i]);

            // Handle expiration date with default value
            $exp_date = !empty($exp_dates[$i]) ? mysqli_real_escape_string($con, $exp_dates[$i]) : '2060-03-01';

            // Validate date format
            if (!DateTime::createFromFormat('Y-m-d', $exp_date)) {
                throw new Exception("Tarehe ya kumalizika sio sahihi kwa Dawa: $med_name. Tafadhali tumia muundo wa YYYY-MM-DD");
            }

            $selling_price = floatval($selling_prices[$i]);
            $tax_amount = floatval($tax_amounts[$i]);
            $cost_kupakia = floatval($cost_kupakias[$i]);
            $cost_kushusha = floatval($cost_kushushas[$i]);
            $transport_cost = floatval($transport_costs[$i]);
            $cost_kupanga = floatval($cost_kupangas[$i]);
            $products_cost = floatval($products_costs[$i]);
            $total_cost = floatval($total_costs[$i]);
            $created_by = $_SESSION['user_session'];

            // Calculate profit price
            $profit_price = $selling_price - $actual_price;

            if (!empty($medicine_id)) {
                // Update existing stock
                $update_stock = "UPDATE stock SET 
                                quantity = '$quantity',
                                remain_quantity = '$act_remain_quantity',
                                act_remain_quantity = '$act_remain_quantity',
                                expire_date = '$exp_date',
                                company = '$company',
                                selling_price = '$selling_price',
                                actual_price = '$actual_price',
                                profit_price = '$profit_price'
                                WHERE id = '$medicine_id' AND store_id = '$store_id'";
                if (!mysqli_query($con, $update_stock)) {
                    throw new Exception("Hitilafu wakati wa kusasisha hesabu: " . mysqli_error($con));
                }
            } else {
                // Insert new stock record
                $insert_stock = "INSERT INTO stock (
                    store_id, medicine_name, category, quantity, remain_quantity,
                    act_remain_quantity, used_quantity, expire_date, stock_alert,
                    company, sell_type, selling_price, actual_price, profit_price, created_by,
                    status, register_date
                ) VALUES (
                    '$store_id', '$med_name', '$category', 
                    '$quantity', '$act_remain_quantity', '$act_remain_quantity', '$used_quantity', 
                    '$exp_date', '20', '$company','pc', '$selling_price', 
                    '$actual_price', '$profit_price', '$created_by' ,'Available', NOW()
                )";
                if (!mysqli_query($con, $insert_stock)) {
                    throw new Exception("Hitilafu wakati wa kuingiza data mpya: " . mysqli_error($con));
                }
                $medicine_id = mysqli_insert_id($con);
            }

            // Update transfer status to 'pokelewa'
            $update_transfer = "UPDATE transfers SET 
                               transfer_status = 'pokelewa',
                               received_by = '$created_by',
                               received_date = NOW()
                               WHERE id = '$transfer_id'";
            if (!mysqli_query($con, $update_transfer)) {
                throw new Exception("Hitilafu wakati wa kusasisha status ya transfer: " . mysqli_error($con));
            }

            // Get status and date_to_pay from transfer
            $transfer_result = mysqli_query($con, "SELECT hali_ya_malipo, date_to_pay FROM transfers WHERE id = '$transfer_id' LIMIT 1");
            if (!$transfer_result || mysqli_num_rows($transfer_result) == 0) {
                throw new Exception("Hakuna taarifa ya transfer iliyopatikana kwa ID: $transfer_id");
            }
            $transfer_row = mysqli_fetch_assoc($transfer_result);
            $transfer_status = mysqli_real_escape_string($con, $transfer_row['hali_ya_malipo']);
            $date_to_pay = mysqli_real_escape_string($con, $transfer_row['date_to_pay']);

            // Record in purchases_report
            $credit_amount = $received_quantity * $actual_price;
            $expected_profit = $received_quantity * $profit_price;

            $insert_purchase = "INSERT INTO purchases_report (
                medicine_name, category, old_quantity, received_quantity, 
                receipt_number, batch_number, received_date, expire_date, 
                company, actual_price, selling_price, profit_price, 
                credit_amount, created_by, status, date_to_pay, tax_amount, 
                cost_kupakia, cost_kushusha, transport_cost, cost_kupanga, 
                products_cost, total_cost, expected_profit, medicine_id, 
                store_id, sell_type
            ) VALUES (
                '$med_name', '$category', 
                '".($act_remain_quantity - $received_quantity)."', '$received_quantity', 
                'TRANSFER', '', NOW(), '$exp_date', 
                '$company', '$actual_price', '$selling_price', '$profit_price', 
                '$credit_amount', '$created_by', '$transfer_status', '$date_to_pay', '$tax_amount', 
                '$cost_kupakia', '$cost_kushusha', '$transport_cost', '$cost_kupanga', 
                '$products_cost', '$total_cost', '$expected_profit', '$medicine_id', 
                '$store_id', 'pc'
            )";
            if (!mysqli_query($con, $insert_purchase)) {
                throw new Exception("Hitilafu wakati wa kurekodi taarifa za ununuzi: " . mysqli_error($con));
            }
        }

        // Commit transaction
        mysqli_commit($con);

        $response = [
            'success' => true,
            'message' => 'Dawa zimepokelewa kikamilifu na hesabu zimesasishwa'
        ];
    } catch (Exception $e) {
        // Rollback transaction on error
        mysqli_rollback($con);

        $response = [
            'success' => false,
            'message' => 'Hitilafu: ' . $e->getMessage()
        ];
    }
} else {
    $response = [
        'success' => false,
        'message' => 'Hakuna data iliyopokelewa'
    ];
}

header('Content-Type: application/json');
echo json_encode($response);
exit();
?>
