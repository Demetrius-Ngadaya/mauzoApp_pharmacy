<?php
session_start();
include('dbcon.php');

if (isset($_POST['delete'])) {
    $id = $_POST['id'];
    $invoice_number = isset($_GET['invoice_number']) ? $_GET['invoice_number'] : '';

    // Delete user
    $delete_query = "DELETE FROM users WHERE id = ?";
    $stmt = $con->prepare($delete_query);
    $stmt->bind_param("i", $id);
    $stmt->execute();

    // Set success message
    $_SESSION['success_message'] = "Mtumiaji amefutwa kikamilifu!";

    // Redirect to the same page to reflect changes
    header("Location: user_management.php?invoice_number=$invoice_number");
    exit(); // Ensure no further code is executed after the redirect
}
?>