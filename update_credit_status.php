<?php
include("session.php");
include("dbcon.php");

// Check if sale ID and invoice number are provided
if (isset($_POST['id']) && isset($_POST['invoice_number'])) {
    $id = $_POST['id'];
    $invoice_number = $_POST['invoice_number'];
    $current_user = $_SESSION['user_session'];
    $currentDate = date('y,m,d'); // Get current date

 // Update the sales table to mark as paid and set the paid_date
 $update_sql = "UPDATE purchases_report SET status = 'paid', paid_date = '$currentDate' , credit_payment_recorder='$current_user' WHERE store_id = '$store_id' AND id = '$id'";
    
 if (mysqli_query($con, $update_sql)) {
    // Redirect to the previous page with success message
    $_SESSION['success'] = "Sale marked as paid successfully.";
        // Redirect back to the original page with the invoice number in the URL
        header("Location: credit_purchases_products.php?invoice_number=" . urlencode($invoice_number));
        exit(); // Always call exit after header
    } else {
           // Redirect with an error message if the query fails
        $_SESSION['error'] = "Error: Could not mark as paid.";
        header("Location: tunaowadai.php?invoice_number=" . urlencode($invoice_number));
    }
} else {
    // Handle case where sale ID or invoice number is not provided
    echo "credit product ID or invoice number not provided.";
}
?>
