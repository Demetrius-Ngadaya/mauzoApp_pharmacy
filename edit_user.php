<?php
session_start();
include('dbcon.php');

if (isset($_POST['edit'])) {
    $id = $_POST['id'];
    $user_name = $_POST['user_name'];
    $role = $_POST['role'];

    // ✅ Get actual value instead of using isset()
    $can_access_all_stores = isset($_POST['can_access_all_stores']) && $_POST['can_access_all_stores'] == '1' ? 1 : 0;

    // ✅ Handle store_id properly
    $store_id = ($can_access_all_stores == 1 || empty($_POST['store_id'])) ? NULL : (int)$_POST['store_id'];

    $password = $_POST['password'];
    $invoice_number = isset($_GET['invoice_number']) ? $_GET['invoice_number'] : '';

    if (!empty($password)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $update_query = "UPDATE users SET user_name = ?, role = ?, password = ?, store_id = ?, can_access_all_stores = ? WHERE id = ?";
        $stmt = $con->prepare($update_query);
        $stmt->bind_param("sssiii", $user_name, $role, $hashed_password, $store_id, $can_access_all_stores, $id);
    } else {
        $update_query = "UPDATE users SET user_name = ?, role = ?, store_id = ?, can_access_all_stores = ? WHERE id = ?";
        $stmt = $con->prepare($update_query);
        $stmt->bind_param("ssiii", $user_name, $role, $store_id, $can_access_all_stores, $id);
    }

    $stmt->execute();

    $_SESSION['success_message'] = "Mtumiaji amebadilishwa kikamilifu!";
    header("Location: user_management.php?invoice_number=$invoice_number");
    exit();
}
?>
