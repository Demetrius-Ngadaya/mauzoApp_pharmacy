<?php
include("session.php");
include("dbcon.php");

// Check if invoice_number is provided
if (!isset($_GET['invoice_number'])) {
    die("Invoice number is missing.");
}

$invoice_number = $_GET['invoice_number'];

// Safely fetch the date from the URL or use the current date as a fallback
$date = isset($_GET['date']) ? $_GET['date'] : date("Y/m/d");

// Fetch sales data for the given invoice number
$select_sql = "SELECT * FROM sales WHERE store_id = '$store_id' AND invoice_number = '$invoice_number'";
$select_query = mysqli_query($con, $select_sql);

if (mysqli_num_rows($select_query) > 0) {
    $row = mysqli_fetch_array($select_query);
    $paid_amount = $row['customer_name'];
} else {
    die("No sales data found for the given invoice number.");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Print Risiti</title>
    <style>
        .content {
            font-family: Arial, sans-serif;
            font-size: 16px;
            line-height: 1.6;
            margin: 0;
            padding: 0;
        }
        .header {
            text-align: center;
            font-size: 22px;
            font-weight: bold;
            margin: 0;
            padding: 0;
        }
        .header img {
            max-width: 140px;
            height: auto;
            margin-bottom: 10px;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }
        .contact {
            text-align: center;
            font-size: 16px;
            margin-bottom: 20px;
        }
        .item, .total, .paid, .change, .seller {
            margin-bottom: 10px;
            font-weight: bold;
        }
        .item div {
            margin-bottom: 5px;
        }
    </style>
    <script>
        window.onload = function() {
            window.print(); // Automatically trigger the print dialog
            window.onafterprint = function() {
                window.close(); // Close the print window after printing
            };
        };
    </script>
</head>
<body>
    <div class="content">
        <div class="header">
            <strong>D_TECH SHOP</strong><br>
            S.L.P 196, IFAKARA<br>
            SIM: 0655551379<br>
            TIN: 131-913-184, VRN: 40-025450-R
        </div>
        <h3>Jina la mteja: <?php echo $paid_amount; ?> &nbsp;&nbsp;  Tarehe: <?php echo $date; ?> &nbsp;&nbsp; 
        
        <table border="1" width="100%">
            <thead>
                <tr>
                    <th>Jina la Dawa</th>
                    <th>Idadi</th>
                    <th>Bei</th>
                    <th>Jumla ndogo</th>
                    <th>Njia ya malipo</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $select_sql = "SELECT * FROM sales WHERE store_id = '$store_id' AND invoice_number = '$invoice_number'";
                $select_query = mysqli_query($con, $select_sql);
                while ($row = mysqli_fetch_array($select_query)) :
                ?>
                    <tr>
                        <td><?php echo $row['medicines']; ?></td>
                        <td><?php echo $row['quantity']; ?></td>
                        <td><?php echo number_format($row['total_amount'] / $row['quantity']); ?></td>
                        <td><?php echo number_format($row['total_amount']); ?></td>
                        <td><?php echo $row['payment_method']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>