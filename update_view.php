<?php
include("session.php");
include("dbcon.php");

//****SELECTING FROM stock******
$id = $_GET['id'];
$invoice_number = $_GET['invoice_number'];

$select_sql = "SELECT * FROM stock WHERE id = '$id' AND store_id = '$store_id' ";
$select_query = mysqli_query($con, $select_sql);

while ($row = mysqli_fetch_array($select_query)):
    $sell_type = $row['sell_type'];
    $old_quantity = $row['act_remain_quantity'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Stock</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .form-container {
            max-width: 1200px; /* Increased width to accommodate three columns */
            margin: 20px auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .form-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr); /* Three columns */
            gap: 15px; /* Space between columns */
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .form-group input,
        .form-group select {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .form-group input[type="submit"] {
            background-color: #28a745;
            color: white;
            border: none;
            cursor: pointer;
            padding: 10px;
            font-size: 16px;
            grid-column: span 3; /* Make the submit button span all three columns */
        }
        .form-group input[type="submit"]:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <form method="POST" action="update.php?invoice_number=<?php echo $invoice_number ?>">
            <input type="hidden" name="id" value="<?php echo $row['id'] ?>">
            <input type="hidden" name="old_quantity" value="<?php echo $old_quantity; ?>">

            <div class="form-grid">
                <!-- Column 1 -->
                <div class="form-group">
                    <label for="med_name">Jina la Dawa:</label>
                    <input type="text" name="med_name" id="med_name" value="<?php echo $row['medicine_name'] ?>" required>
                </div>

                <div class="form-group">
                    <label for="category">Aina ya Dawa:</label>
                    <input type="text" name="category" id="category" value="<?php echo $row['category'] ?>" required>
                </div>

                <div class="form-group">
                    <label for="quantity">Idadi:</label>
                    <input type="number" name="quantity" id="quantity" value="<?php echo $row['quantity'] ?>" readonly >
                </div>

                <!-- Column 2 -->
                <div class="form-group">
                    <label for="sell_type">Aina ya Kuuza:</label>
                    <select name="sell_type" id="sell_type">
                        <?php
                        $options = ["pc", "kreti", "kotoni", "kg", "bags", "mm", "Kopo","tabs", "Lita", "Sewa", "pkt", "trip", "1/4kg", "ndoo", "m", "nr", "kopo", "gln", "m3", "nr"];
                        foreach ($options as $option) {
                            $selected = ($option == $sell_type) ? 'selected' : '';
                            echo "<option value='$option' $selected>$option</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="used_quantity">Idadi Iliyouzwa:</label>
                    <input type="number" name="used_quantity" id="used_quantity" value="<?php echo $row['used_quantity'] ?>" readonly>
                </div>

                <div class="form-group">
                    <label for="act_remain_quantity">Idadi Iliyobaki:</label>
                    <input type="number" name="act_remain_quantity" id="act_remain_quantity" value="<?php echo $row['act_remain_quantity'] ?>">
                </div>

                <!-- Column 3 -->
                <div class="form-group">
                    <label for="reg_date">Tarehe ya Kuingiza Dawa:</label>
                    <input type="date" name="reg_date" id="reg_date" value="<?php echo $row['register_date'] ?>" required>
                </div>

                <div class="form-group">
                    <label for="exp_date">Tarehe ya Ku Expire:</label>
                    <input type="date" name="exp_date" id="exp_date" value="<?php echo $row['expire_date'] ?>" required>
                </div>

                <div class="form-group">
                    <label for="company">Msambazaji:</label>
                    <input type="text" name="company" id="company" value="<?php echo $row['company'] ?>">
                </div>

                <!-- Additional Fields -->
                <div class="form-group">
                    <label for="actual_price">Bei Halisi:</label>
                    <input type="number" name="actual_price" id="actual_price" value="<?php echo $row['actual_price'] ?>">
                </div>

                <div class="form-group">
                    <label for="selling_price">Bei ya Kuuzia:</label>
                    <input type="number" name="selling_price" id="selling_price" value="<?php echo $row['selling_price'] ?>">
                </div>

                <div class="form-group">
                    <label for="profit_price">Faida Yake:</label>
                    <input type="text" name="profit_price" id="profit_price" value="<?php echo $row['profit_price'] ?>" readonly>
                </div>

                <div class="form-group">
                    <label for="status">Hali:</label>
                    <select name="status" id="status">
                        <option disabled><?php echo $row['status'] ?></option>
                        <option value="Available">Available</option>
                        <option value="Not Available">Not Available</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="stock_alert">Stock Alert:</label>
                    <input type="number" name="stock_alert" id="stock_alert" value="<?php echo $row['stock_alert'] ?>">
                </div>

                <div class="form-group">
                    <label for="edit_reason">Sababu ya Kuhariri:</label>
                    <input type="text" name="edit_reason" id="edit_reason" required>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="form-group">
                <input type="submit" name="update" class="btn btn-success btn-md" value="Hifadhi Mabadiliko">
            </div>
        </form>
    </div>
</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // Capitalize first letter of medicine name and category
    $('#med_name, #category').on('keyup', function() {
        var value = $(this).val();
        $(this).val(value.charAt(0).toUpperCase() + value.slice(1));
    });

    // Calculate profit when actual_price or selling_price changes
    $('#actual_price, #selling_price').on('keyup', function() {
        var act_price = parseFloat($('#actual_price').val()) || 0;
        var sell_price = parseFloat($('#selling_price').val()) || 0;
        var pro_price = sell_price - act_price;
        
        // Calculate percentage profit (handle division by zero)
        var percentage = 0;
        if (act_price > 0) {
            percentage = Math.round((pro_price / act_price) * 100);
        }
        
        var output = pro_price.toString().concat(" (").concat(percentage.toString()).concat("%)");
        $('#profit_price').val(output);
    });

    // Trigger calculation on page load if values exist
    if ($('#actual_price').val() && $('#selling_price').val()) {
        $('#actual_price').trigger('keyup');
    }
});
$(document).ready(function() {
  // Toggle sidebar on small screens
  $('[data-widget="pushmenu"]').click(function() {
    $('body').toggleClass('sidebar-open');
  });
  
  // Fix sidebar height on load
  function fixSidebarHeight() {
    $('.sidebar').css('height', $(window).height() - $('.brand-link').outerHeight());
  }
  
  $(window).resize(fixSidebarHeight);
  fixSidebarHeight();
});

</script>
</html>
<?php endwhile; ?>