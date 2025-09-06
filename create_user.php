<?php
session_start();
include('dbcon.php');

$invoice_number = isset($_GET['invoice_number']) ? $_GET['invoice_number'] : '';

if (isset($_POST['user_name']) && isset($_POST['role']) && isset($_POST['password'])) {
    $user_name = $_POST['user_name'];
    $role = $_POST['role'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Handle permission and store selection
    $can_access_all_stores = isset($_POST['can_access_all_stores']) && $_POST['can_access_all_stores'] == '1' ? 1 : 0;
    $store_id = ($can_access_all_stores == 1 || empty($_POST['store_id'])) ? 0 : (int)$_POST['store_id'];

    // Check if the username already exists
    $check_query = "SELECT * FROM users WHERE user_name = ?";
    $stmt = $con->prepare($check_query);
    $stmt->bind_param("s", $user_name);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['error_message'] = "Jina la mtumiaji limechukuliwa";
        header("Location: user_management.php?invoice_number=$invoice_number");
        exit();
    } else {
        // Insert new user
        $insert_query = "INSERT INTO users (user_name, role, password, store_id, can_access_all_stores) VALUES (?, ?, ?, ?, ?)";
        $stmt = $con->prepare($insert_query);
        $stmt->bind_param("sssii", $user_name, $role, $password, $store_id, $can_access_all_stores);

        if ($stmt->execute()) {
            $_SESSION['success_message'] = "Mtumiaji ameongezwa kikamilifu!";
        } else {
            $_SESSION['error_message'] = "Imeshindikana kuongeza mtumiaji.";
        }

        header("Location: user_management.php?invoice_number=$invoice_number");
        exit();
    }
} else {
    $_SESSION['error_message'] = "Sehemu zote zinatakiwa kujazwa.";
    header("Location: user_management.php?invoice_number=$invoice_number");
    exit();
}
?>
