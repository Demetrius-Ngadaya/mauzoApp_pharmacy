<?php
session_start();
if (!isset($_SESSION['user_session'])) {
    header("location:index.php");
}
?>
<html>
<head>
    <title>MauzApp</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Handle "Hifadhi Mauzo" button click
            $("#saveSales").click(function(e) {
                e.preventDefault(); // Prevent form submission
                $.ajax({
                    type: "POST",
                    url: "save_invoiceCashier.php",
                    data: $("form").serialize(), // Serialize all form data
                    success: function(response) {
                        console.log("Server response:", response); // Debugging line
                        try {
                            var data = JSON.parse(response); // Parse the JSON response
                            if (data.status === "success") {
                                alert("Mauzo yamehifadhiwa kikamilifu!");
                                // Redirect to cashierPOS.php after successful sale
                                window.location.href = "cashierPOS.php?invoice_number=" + data.new_invoice_number;
                            } else {
                                alert("Hitilafu: " + data.message);
                            }
                        } catch (e) {
                            console.error("Error parsing JSON:", e); // Debugging line
                            alert("Hitilafu: Samahani, kuna tatizo la kiufundi.");
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log("AJAX error:", error); // Debugging line
                        alert("Hitilafu: " + error);
                    }
                });
            });

            // Handle "Print Risiti" button click
            $("#printReceipt").click(function(e) {
                e.preventDefault(); // Prevent form submission
                $.ajax({
                    type: "POST",
                    url: "save_invoiceCashier.php",
                    data: $("form").serialize(), // Serialize all form data
                    success: function(response) {
                        console.log("Server response:", response); // Debugging line
                        try {
                            var data = JSON.parse(response); // Parse the JSON response
                            if (data.status === "success") {
                                // Open the print receipt window
                                window.open("print_receipt.php?invoice_number=" + data.invoice_number, "_blank");
                                // Redirect to cashierPOS.php with the new invoice number
                                window.location.href = "cashierPOS.php?invoice_number=" + data.new_invoice_number;
                            } else {
                                alert("Hitilafu: " + data.message);
                            }
                        } catch (e) {
                            console.error("Error parsing JSON:", e); // Debugging line
                            alert("Hitilafu: Samahani, kuna tatizo la kiufundi.");
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log("AJAX error:", error); // Debugging line
                        alert("Hitilafu: " + error);
                    }
                });
            });

            // Handle "Close" button click
            $("#closeForm").click(function() {
                if (window.opener) {
                    // If the window was opened by another window, close it
                    window.close();
                } else {
                    // If the window was not opened by another window, generate a new invoice number and redirect to cashierPOS.php
                    $.ajax({
                        type: "POST",
                        url: "save_invoiceCashier.php",
                        data: { action: "generate_invoice_number" }, // Request to generate a new invoice number
                        success: function(response) {
                            console.log("Server response:", response); // Debugging line
                            try {
                                var data = JSON.parse(response); // Parse the JSON response
                                if (data.status === "success") {
                                    // Redirect to cashierPOS.php with the new invoice number
                                    window.location.href = "cashierPOS.php?invoice_number=" + data.new_invoice_number;
                                } else {
                                    alert("Hitilafu: " + data.message);
                                }
                            } catch (e) {
                                console.error("Error parsing JSON:", e); // Debugging line
                                alert("Hitilafu: Samahani, kuna tatizo la kiufundi.");
                            }
                        },
                        error: function(xhr, status, error) {
                            console.log("AJAX error:", error); // Debugging line
                            alert("Hitilafu: " + error);
                        }
                    });
                }
            });
        });
    </script>
</head>
<body>
<div class="checkout">
    <form method="post" action="preview.php?invoice_number=<?php echo $_GET['invoice_number']; ?>">
        <center>
            <h3>Majina ya mteja</h3>
            <input type="hidden" name="invoice_number" value="<?php echo $_GET['invoice_number']; ?>">
            <input type="hidden" name="medicine_name" value="<?php echo $_GET['medicine_name']; ?>">
            <input type="hidden" name="category" value="<?php echo $_GET['category']; ?>">
            <input type="hidden" name="quantity" value="<?php echo $_GET['quantity']; ?>">
            <input type="hidden" name="grand_total" value="<?php echo $_GET['total']; ?>">
            <input type="hidden" name="grand_profit" value="<?php echo $_GET['profit']; ?>">
            <input type="hidden" name="date" value="<?php echo date("Y/m/d"); ?>">
            <input type="text" name="paid_amount" placeholder="Jina la mteja" style="width: 300px; height:30px; margin-bottom: 15px;" required/><br>
            <button id="saveSales" class="btn btn-success">Hifadhi Mauzo</button>
            <button id="printReceipt" class="btn btn-primary">Print Risiti</button>
            <button id="closeForm" class="btn btn-danger">Funga</button>
        </center>
    </form>
</div>
</body>
</html>