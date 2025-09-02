<?php
include("session.php");
include("dbcon.php");


$product_ids = explode(',', $_GET['ids']);
$invoice_number = $_GET['invoice_number'];
?>

<body>  
    <form method="POST" action="purchases.php?invoice_number=<?php echo $invoice_number?>">
        <?php 
        $counter = 1;
        foreach ($product_ids as $product_id): 
            $select_sql = "SELECT * FROM stock where store_id = '$store_id' AND id = '$product_id'";
            $select_query = mysqli_query($con, $select_sql);
            $row = mysqli_fetch_array($select_query);
        ?>
        <div class="product-form" style="margin-bottom: 30px; border-bottom: 1px solid #ccc; padding-bottom: 20px;">
            <h4 style="color: #007bff;">Dawa <?php echo $counter; $counter++; ?></h4>
            <table id="table" style="width: 100%; margin: auto;">
                <input type="hidden" name="id[]" value="<?php echo $row['id']?>">

                <tr id="row">
                    <td>Jina la Dawa:</td>
                    <td><input type="text" class="form-control" name="med_name[]" id="med_name_<?php echo $row['id']; ?>" value="<?php echo $row['medicine_name']?>" required></td>
                    <td>Aina ya Dawa:</td>
                    <td><input type="text" class="form-control" name="category[]" id="category_<?php echo $row['id']; ?>" value="<?php echo $row['category']?>" required></td>
                </tr>
                
                <tr>
                    <td>Jumla idadi:</td>
                    <td>
                        <input type="number" class="form-control" name="quantity[]" readonly value="<?php echo $row['quantity']?>">
                    </td>
                    <td>Kipimo:</td>
                    <td>
                        <select class="form-control" name="sell_type[]"> 
                            <option value="<?php echo $row['sell_type']?>" selected><?php echo $row['sell_type']?></option>
                            <option value="pc">pc</option>
                            <option value="chupa">chupa</option>
                            <option value="kreti">kreti</option>
                            <option value="kotoni">kotoni</option>
                            <option value="roll">roll</option>
                            <option value="box">box</option>
                            <option value="kg">kg</option>	
                            <option value="bags">bags</option>
                            <option value="mm">mm</option>
                            <option value="Kopo">Kopo</option>
                            <option value="Lita">Lita</option>
                            <option value="Sewa">Sewa</option>
                            <option value="pkt">pkt</option>
                            <option value="trip">trip</option>
                            <option value="1/4kg">1/4kg</option>	
                            <option value="ndoo">ndoo</option>	
                            <option value="m">m</option>
                            <option value="nr">nr</option>	
                            <option value="kopo">kopo</option>
                            <option value="gln">gln</option>
                            <option value="m3">m3</option>
                            <option value="nr">nr</option>
                        </select>
                    </td>
                </tr>
                
                <tr>
                    <td>Idadi iliyouzwa:</td>
                    <td><input type="number" class="form-control" name="used_quantity[]" readonly id="used_quantity_<?php echo $row['id']; ?>" value="<?php echo $row['used_quantity']?>"></td>
                    <td>Idadi iliyobaki:</td>
                    <td><input type="number" class="form-control" name="act_remain_quantity[]" id="act_remain_quantity_<?php echo $row['id']; ?>" value="<?php echo $row['act_remain_quantity']?>"></td>
                </tr>
                
                <tr>
                    <td>Tarehe ku Expire:</td>
                    <td><input type="date" class="form-control" name="exp_date[]" id="exp_date_<?php echo $row['id']; ?>" value="<?php echo $row['expire_date']?>" required></td>
                    <td>Bei kununulia:</td>
                    <td><input type="number" class="form-control" name="actual_price[]" id="actual_price_<?php echo $row['id']; ?>" value="<?php echo $row['actual_price']?>"></td>
                </tr>
                
                <tr>
                    <td>Bei kuuza:</td>
                    <td><input type="number" class="form-control" name="selling_price[]" id="selling_price_<?php echo $row['id']; ?>" value="<?php echo $row['selling_price']?>"></td>
                    <td>Faida:</td>
                    <td><input type="text" class="form-control" name="profit_price[]" id="profit_price_<?php echo $row['id']; ?>" value="<?php echo $row['profit_price']?>" readonly></td>
                </tr>
                
                <tr>
                    <td>Msambazaji:</td>
                    <td><input type="text" class="form-control" name="company[]" id="company_<?php echo $row['id']; ?>" value="<?php echo $row['company']?>"></td>
                    <td>Tarehe ya kupokea:</td>
                    <td><input type="date" class="form-control" name="received_date[]" id="received_date_<?php echo $row['id']; ?>" required></td>
                </tr>
                
                <tr>
                    <td>Namba ya risiti:</td>
                    <td><input type="text" class="form-control" name="receipt_number[]" id="receipt_number_<?php echo $row['id']; ?>" required></td>
                    <td>Namba ya bachi:</td>
                    <td><input type="text" class="form-control" name="batch_number[]" id="batch_number_<?php echo $row['id']; ?>" required></td>
                </tr>
                
                <tr>
                    <td>Idadi iliyopokelewa:</td>
                    <td><input type="number" class="form-control" name="received_quantity[]" id="received_quantity_<?php echo $row['id']; ?>" required></td>
                    <td>Kiasi cha ushuru (kwa moja):</td>
                    <td><input type="number" class="form-control" name="tax_amount[]" id="tax_amount_<?php echo $row['id']; ?>" value="0" required></td>
                </tr>
                
                <tr>
                    <td>Gharama Kupakia (kwa moja):</td>
                    <td><input type="number" class="form-control" name="cost_kupakia[]" id="cost_kupakia_<?php echo $row['id']; ?>" value="0" required></td>
                    <td>Gharama Kushusha (kwa moja):</td>
                    <td><input type="number" class="form-control" name="cost_kushusha[]" id="cost_kushusha_<?php echo $row['id']; ?>" value="0" required></td>
                </tr>
                
                <tr>
                    <td>Gharama usafiri (kwa moja):</td>
                    <td><input type="number" class="form-control" name="transport_cost[]" id="transport_cost_<?php echo $row['id']; ?>" value="0" required></td>
                    <td>Gharama Kupanga (kwa moja):</td>
                    <td><input type="number" class="form-control" name="cost_kupanga[]" id="cost_kupanga_<?php echo $row['id']; ?>" value="0" required></td>
                </tr>
                
                <tr>
                    <td>Gharama ya Dawa:</td>
                    <td><input type="number" class="form-control" name="products_cost[]" id="products_cost_<?php echo $row['id']; ?>" readonly></td>
                    <td>Jumla ya gharama:</td>
                    <td><input type="number" class="form-control" name="total_cost[]" id="total_cost_<?php echo $row['id']; ?>" readonly></td>
                </tr>
                
                <tr>
                    <td>Faida inayotarajiwa:</td>
                    <td colspan="3"><input type="number" class="form-control" name="expected_profit[]" id="expected_profit_<?php echo $row['id']; ?>" readonly></td>
                </tr>
                
            </table>
        </div>
        <?php endforeach; ?>
    </form>
</body>

<script type="text/javascript">
$(document).ready(function(){
    // Function to calculate costs
    function calculateCosts(productId) {
        var receivedQty = parseFloat($("#received_quantity_" + productId).val()) || 0;
        
        // Get the per-unit costs (not multiplied by quantity)
        var taxAmount = parseFloat($("#tax_amount_" + productId).val()) || 0;
        var costKupakia = parseFloat($("#cost_kupakia_" + productId).val()) || 0;
        var costKushusha = parseFloat($("#cost_kushusha_" + productId).val()) || 0;
        var transportCost = parseFloat($("#transport_cost_" + productId).val()) || 0;
        var costKupanga = parseFloat($("#cost_kupanga_" + productId).val()) || 0;
        var actualPrice = parseFloat($("#actual_price_" + productId).val()) || 0;
        var sellingPrice = parseFloat($("#selling_price_" + productId).val()) || 0;
        
        // Calculate products_cost per single product (actual price)
        var productsCost = actualPrice;
        $("#products_cost_" + productId).val(productsCost.toFixed(2));
        
        // Calculate total_cost per product (sum of all per-unit costs multiplied  plus product cost)
        var totalCost = (taxAmount + costKupakia + costKushusha + transportCost + costKupanga)  + productsCost;
        $("#total_cost_" + productId).val(totalCost.toFixed(2));
        
        // Calculate expected_profit
        // var expectedProfit = (sellingPrice * receivedQty) - totalCost;
        var expectedProfit = sellingPrice - totalCost;
        $("#expected_profit_" + productId).val(expectedProfit.toFixed(2));
        
        // Calculate profit percentage
        var profitPrice = sellingPrice - actualPrice;
        var percentage = actualPrice > 0 ? Math.round((profitPrice/actualPrice)*100) : 0;
        var output = profitPrice.toFixed(2).toString().concat(" (")+percentage.toString().concat("%)");
        $("#profit_price_" + productId).val(output);
    }
    
    // Function to update costs (keep per-unit costs as is)
    function updateCostsByQuantity(productId) {
        // Get the original per-unit costs
        var originalTax = parseFloat($("#tax_amount_" + productId).data('original-per-unit')) || 0;
        var originalKupakia = parseFloat($("#cost_kupakia_" + productId).data('original-per-unit')) || 0;
        var originalKushusha = parseFloat($("#cost_kushusha_" + productId).data('original-per-unit')) || 0;
        var originalTransport = parseFloat($("#transport_cost_" + productId).data('original-per-unit')) || 0;
        var originalKupanga = parseFloat($("#cost_kupanga_" + productId).data('original-per-unit')) || 0;
        
        // Keep the per-unit costs as is (don't multiply by quantity)
        $("#tax_amount_" + productId).val(originalTax.toFixed(2));
        $("#cost_kupakia_" + productId).val(originalKupakia.toFixed(2));
        $("#cost_kushusha_" + productId).val(originalKushusha.toFixed(2));
        $("#transport_cost_" + productId).val(originalTransport.toFixed(2));
        $("#cost_kupanga_" + productId).val(originalKupanga.toFixed(2));
        
        // Recalculate all costs
        calculateCosts(productId);
    }
    
    // Initialize calculations for all product forms
    function initializeCalculations() {
        <?php foreach ($product_ids as $product_id): ?>
            // Set up event listeners for each product form
            $("#received_quantity_<?php echo $product_id; ?>").on("keyup change", function() {
                updateCostsByQuantity("<?php echo $product_id; ?>");
            });
            
            $("#actual_price_<?php echo $product_id; ?>, #selling_price_<?php echo $product_id; ?>").on("keyup change", function() {
                calculateCosts("<?php echo $product_id; ?>");
            });
            
            // Capitalize first letter of medicine name and category
            $("#med_name_<?php echo $product_id; ?>").on("keyup", function() {
                var medName = $(this).val();
                if (medName.length > 0) {
                    $(this).val(medName.charAt(0).toUpperCase() + medName.slice(1));
                }
            });
            
            $("#category_<?php echo $product_id; ?>").on("keyup", function() {
                var category = $(this).val();
                if (category.length > 0) {
                    $(this).val(category.charAt(0).toUpperCase() + category.slice(1));
                }
            });
            
            // Initial calculation
            updateCostsByQuantity("<?php echo $product_id; ?>");
        <?php endforeach; ?>
    }
    
    // Initialize all calculations when page loads
    initializeCalculations();
});
</script>