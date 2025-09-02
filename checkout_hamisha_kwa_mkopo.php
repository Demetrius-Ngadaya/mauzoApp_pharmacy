<?php
session_start();
$store_id = $_SESSION['store_id'];
if (!isset($_SESSION['user_session'])) {
    header("location:index.php");
}

// Get current store name
include "dbcon.php";
$current_store_query = mysqli_query($con, "SELECT name FROM stores WHERE id = '$store_id'");
$current_store = mysqli_fetch_array($current_store_query);
?>
<html>
<head>
    <title>MauzApp - Hamisha Dawa</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .store-info {
            background-color: #f8f9fa;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            text-align: center;
            font-weight: bold;
        }
    </style>
    <script>
        $(document).ready(function() {
            // Handle "Hifadhi Mauzo" button click
            $("#saveSales").click(function(e) {
                e.preventDefault();
                
                // Validate store selection
                if ($("#receiving_store_id").val() === "") {
                    alert("Tafadhali chagua kituo/tawi unachohamishia");
                    return;
                }
                
                $.ajax({
                    type: "POST",
                    url: "save_invoice_hamisha_kwa_mkopo.php",
                    data: $("form").serialize(),
                    success: function(response) {
                        console.log("Server response:", response);
                        try {
                            var data = JSON.parse(response);
                            if (data.status === "success") {
                                alert("Taharifa zimetumwa kikamilifu!");
                                window.location.href = "hamisha_kwa_mkopo.php?invoice_number=" + data.new_invoice_number;
                            } else {
                                alert("Hitilafu: " + data.message);
                            }
                        } catch (e) {
                            console.error("Error parsing JSON:", e);
                            alert("Hitilafu: Samahani, kuna tatizo la kiufundi.");
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log("AJAX error:", error);
                        alert("Hitilafu: " + error);
                    }
                });
            });

            // Handle "Print Risiti" button click
            $("#printReceipt").click(function(e) {
                e.preventDefault();
                
                if ($("#receiving_store_id").val() === "") {
                    alert("Tafadhali chagua kituo/tawi unachohamishia");
                    return;
                }
                
                $.ajax({
                    type: "POST",
                    url: "save_invoice_hamisha_kwa_mkopo.php",
                    data: $("form").serialize(),
                    success: function(response) {
                        console.log("Server response:", response);
                        try {
                            var data = JSON.parse(response);
                            if (data.status === "success") {
                                window.open("print_receipt.php?invoice_number=" + data.invoice_number, "_blank");
                                window.location.href = "hamisha_kwa_mkopo.php?invoice_number=" + data.new_invoice_number;
                            } else {
                                alert("Hitilafu: " + data.message);
                            }
                        } catch (e) {
                            console.error("Error parsing JSON:", e);
                            alert("Hitilafu: Samahani, kuna tatizo la kiufundi.");
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log("AJAX error:", error);
                        alert("Hitilafu: " + error);
                    }
                });
            });

            // Handle "Close" button click
            $("#closeForm").click(function() {
                if (window.opener) {
                    window.close();
                } else {
                    $.ajax({
                        type: "POST",
                        url: "save_invoice_hamisha_kwa_mkopo.php",
                        data: { action: "generate_invoice_number" },
                        success: function(response) {
                            console.log("Server response:", response);
                            try {
                                var data = JSON.parse(response);
                                if (data.status === "success") {
                                    window.location.href = "hamisha_kwa_mkopo.php?invoice_number=" + data.new_invoice_number;
                                } else {
                                    alert("Hitilafu: " + data.message);
                                }
                            } catch (e) {
                                console.error("Error parsing JSON:", e);
                                alert("Hitilafu: Samahani, kuna tatizo la kiufundi.");
                            }
                        },
                        error: function(xhr, status, error) {
                            console.log("AJAX error:", error);
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
            <div class="store-info">
                Unahamisha kutoka: <?php echo $current_store['name']; ?>
            </div>
            <h5>Chagua kituo unachohamishia</h5>
            <input type="hidden" name="invoice_number" value="<?php echo $_GET['invoice_number']; ?>">
            <input type="hidden" name="medicine_name" value="<?php echo $_GET['medicine_name']; ?>">
            <input type="hidden" name="category" value="<?php echo $_GET['category']; ?>">
            <input type="hidden" name="quantity" value="<?php echo $_GET['quantity']; ?>">
            <input type="hidden" name="grand_total" value="<?php echo $_GET['total']; ?>">
            <input type="hidden" name="grand_profit" value="<?php echo $_GET['profit']; ?>">
            <input type="hidden" name="date" value="<?php echo date("Y/m/d"); ?>">
            
            <select id="receiving_store_id" name="receiving_store_id" style="width: 300px; height:30px; margin-bottom: 15px;" required>
                <option value="">Chagua kituo/tawi</option>
                <?php
                $store_query = mysqli_query($con, "SELECT * FROM stores WHERE id != '$store_id'");
                while ($store = mysqli_fetch_array($store_query)) {
                    echo '<option value="'.$store['id'].'">'.$store['name'].'</option>';
                }
                ?>
            </select><br>
            
            <button id="saveSales" class="btn btn-success">Hifadhi taharifa</button>
            <button id="printReceipt" class="btn btn-primary">Print Risiti</button>
            <button id="closeForm" class="btn btn-danger">Kata</button>
        </center>
    </form>
</div>
</body>
</html>