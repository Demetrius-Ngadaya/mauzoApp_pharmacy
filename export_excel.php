<?php
// Include database connection file
include("dbcon.php");

// Fetch data between specified dates
$d1 = $_GET['d1'];
$d2 = $_GET['d2'];

// Fetch data from the database
$select_sql = "SELECT * FROM sales WHERE Date BETWEEN '$d1' AND '$d2' ORDER BY Date DESC";
$select_query = mysqli_query($con, $select_sql);

// Export data to Excel
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename="ripoti ya mauzo.xls"');
?>

<table border="1">
    <tr>
        <th>Tarehe</th>
        <th>Dawa</th>
        <th>Idadi</th>
        <th>Jumla kiasi cha fedha</th>
        <th>Jumla ya faida</th>
        <th>Aliyeuza</th>
        <th>Invoice</th>
    </tr>
    <?php while ($row = mysqli_fetch_array($select_query)) : ?>
        <tr>
            <td><?php echo $row['Date']; ?></td>
            <td><?php echo $row['medicines']; ?></td>
            <td><?php echo $row['quantity']; ?></td>
            <td><?php echo $row['total_amount']; ?></td>
            <td><?php echo $row['total_profit']; ?></td>
            <td><?php echo $row['created_by']; ?></td>
            <td><?php echo $row['invoice_number']; ?></td>
        </tr>
    <?php endwhile; ?>
</table>
