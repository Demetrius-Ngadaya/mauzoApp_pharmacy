<?php
include("session.php");
include("dbcon.php");

$store_id = $_SESSION['store_id'];
$transfer_ids = explode(',', $_GET['ids']);

echo '<form id="receiveTransferForm">';
echo '<div class="row">';
echo '<div class="col-md-12">';
echo '<div class="table-responsive">';
echo '<table class="table table-bordered" style="font-size: 14px;">'; // Smaller font for better fit
echo '<thead>';
echo '<tr class="table-success">';
echo '<th style="min-width: 150px;">Dawa</th>';
echo '<th style="min-width: 100px;">Aina</th>';
echo '<th style="min-width: 80px;">Idadi</th>';
echo '<th style="min-width: 80px;">Bei Nunu</th>';
echo '<th style="min-width: 120px;">Msambazaji</th>';
echo '<th style="min-width: 80px;">Jumla</th>';
echo '<th style="min-width: 80px;">Iliyouzwa</th>';
echo '<th style="min-width: 80px;">Iliyobaki</th>';
echo '<th style="min-width: 100px;">Tarehe Expire</th>';
echo '<th style="min-width: 80px;">Bei Kuuza</th>';
echo '<th style="min-width: 80px;">Ushuru</th>';
echo '<th style="min-width: 100px;">Gharama Kupakia</th>';
echo '<th style="min-width: 100px;">Gharama Kushusha</th>';
echo '<th style="min-width: 100px;">Gharama Usafiri</th>';
echo '<th style="min-width: 100px;">Gharama Kupanga</th>';
echo '<th style="min-width: 100px;">Gharama Dawa</th>';
echo '<th style="min-width: 100px;">Jumla Gharama</th>';
echo '</tr>';
echo '</thead>';
echo '<tbody>';

foreach ($transfer_ids as $index => $transfer_id) {
    // Get transfer details
    $transfer_query = "SELECT t.*, s.name as sending_store_name 
                      FROM transfers t
                      JOIN stores s ON t.store_id = s.id
                      WHERE t.id = '$transfer_id' AND t.receiving_store_id = '$store_id'";
    $transfer_result = mysqli_query($con, $transfer_query);
    $transfer = mysqli_fetch_assoc($transfer_result);
    
    // Get stock details if exists
    $stock_query = "SELECT * FROM stock 
                   WHERE store_id = '$store_id' 
                   AND medicine_name = '".$transfer['medicines']."' 
                   AND category = '".$transfer['category']."'";
    $stock_result = mysqli_query($con, $stock_query);
    $stock = mysqli_num_rows($stock_result) > 0 ? mysqli_fetch_assoc($stock_result) : null;
    
    $price_per_unit = $transfer['total_amount'] / $transfer['quantity'];
    
    echo '<tr>';
    echo '<input type="hidden" name="transfer_ids[]" value="'.$transfer['id'].'">';
    echo '<input type="hidden" name="medicine_ids[]" value="'.($stock ? $stock['id'] : '').'">';
    
    // Dawa
    echo '<td><input type="text" class="form-control form-control-sm" name="med_name[]" value="'.$transfer['medicines'].'" readonly style="min-width: 150px;"></td>';
    
    // Aina
    echo '<td><input type="text" class="form-control form-control-sm" name="category[]" value="'.$transfer['category'].'" readonly style="min-width: 100px;"></td>';
    
    // Idadi iliyopokelewa
    echo '<td><input type="number" class="form-control form-control-sm received_quantity" id="received_quantity_'.$index.'" 
          name="received_quantity[]" value="'.$transfer['quantity'].'" min="1" required style="min-width: 80px;"></td>';
    
    // Bei kununulia
    echo '<td><input type="number" step="0.01" class="form-control form-control-sm" id="actual_price_'.$index.'" 
          name="actual_price[]" value="'.number_format($price_per_unit, 2, '.', '').'" readonly style="min-width: 80px;"></td>';
    
    // Msambazaji
    echo '<td><input type="text" class="form-control form-control-sm" name="company[]" value="'.$transfer['sending_store_name'].'" required style="min-width: 120px;"></td>';
    
    // Jumla idadi (if exists in stock)
    echo '<td><input type="number" class="form-control form-control-sm" name="quantity[]" 
          value="'.($stock ? $stock['quantity'] + $transfer['quantity'] : $transfer['quantity']).'" readonly style="min-width: 80px;"></td>';
    
    // Idadi iliyouzwa
    echo '<td><input type="number" class="form-control form-control-sm" name="used_quantity[]" 
          value="'.($stock ? $stock['used_quantity'] : 0).'" readonly style="min-width: 80px;"></td>';
    
    // Idadi iliyobaki
    echo '<td><input type="number" class="form-control form-control-sm" name="act_remain_quantity[]" 
          value="'.($stock ? $stock['act_remain_quantity'] + $transfer['quantity'] : $transfer['quantity']).'" readonly style="min-width: 80px;"></td>';
    
    // Tarehe ku Expire
    echo '<td><input type="date" class="form-control form-control-sm" name="exp_date[]" required style="min-width: 100px;"></td>';
    
    // Bei kuuza
    echo '<td><input type="number" step="0.01" class="form-control form-control-sm" id="selling_price_'.$index.'" 
          name="selling_price[]" value="'.($stock ? $stock['selling_price'] : $price_per_unit).'" required style="min-width: 80px;"></td>';
    
    // Ushuru
    echo '<td><input type="number" step="0.01" class="form-control form-control-sm tax_amount" id="tax_amount_'.$index.'" 
          name="tax_amount[]" value="0" required style="min-width: 80px;"></td>';
    
    // Gharama ya kupakia
    echo '<td><input type="number" step="0.01" class="form-control form-control-sm cost_kupakia" id="cost_kupakia_'.$index.'" 
          name="cost_kupakia[]" value="0" required style="min-width: 100px;"></td>';
    
    // Gharama ya kushusha
    echo '<td><input type="number" step="0.01" class="form-control form-control-sm cost_kushusha" id="cost_kushusha_'.$index.'" 
          name="cost_kushusha[]" value="0" required style="min-width: 100px;"></td>';
    
    // Gharama ya usafiri
    echo '<td><input type="number" step="0.01" class="form-control form-control-sm transport_cost" id="transport_cost_'.$index.'" 
          name="transport_cost[]" value="0" required style="min-width: 100px;"></td>';
    
    // Gharama ya kupanga
    echo '<td><input type="number" step="0.01" class="form-control form-control-sm cost_kupanga" id="cost_kupanga_'.$index.'" 
          name="cost_kupanga[]" value="0" required style="min-width: 100px;"></td>';
    
    // Gharama ya Dawa
    echo '<td><input type="number" step="0.01" class="form-control form-control-sm" id="products_cost_'.$index.'" 
          name="products_cost[]" value="'.number_format($transfer['total_amount'], 2, '.', '').'" readonly style="min-width: 100px;"></td>';
    
    // Jumla ya gharama
    echo '<td><input type="number" step="0.01" class="form-control form-control-sm" id="total_cost_'.$index.'" 
          name="total_cost[]" value="'.number_format($transfer['total_amount'], 2, '.', '').'" readonly style="min-width: 100px;"></td>';
    
    echo '</tr>';
}

echo '</tbody>';
echo '</table>';
echo '</div>';
echo '</div>';
echo '</div>';
echo '</form>';

// Add JavaScript to handle quantity changes and cost calculations
echo '<script>
$(document).ready(function() {
    $(".received_quantity").on("change", function() {
        var row = $(this).closest("tr");
        var quantity = parseFloat($(this).val());
        var price = parseFloat(row.find("[id^=\'actual_price_\']").val());
        var taxRate = parseFloat(row.find("[id^=\'tax_amount_\']").data("original-per-unit")) || 0;
        var kupakiaRate = parseFloat(row.find("[id^=\'cost_kupakia_\']").data("original-per-unit")) || 0;
        var kushushaRate = parseFloat(row.find("[id^=\'cost_kushusha_\']").data("original-per-unit")) || 0;
        var transportRate = parseFloat(row.find("[id^=\'transport_cost_\']").data("original-per-unit")) || 0;
        var kupangaRate = parseFloat(row.find("[id^=\'cost_kupanga_\']").data("original-per-unit")) || 0;
        
        var taxAmount = quantity * taxRate;
        var kupakiaCost = quantity * kupakiaRate;
        var kushushaCost = quantity * kushushaRate;
        var transportCost = quantity * transportRate;
        var kupangaCost = quantity * kupangaRate;
        var productCost = quantity * price;
        var totalCost = productCost + taxAmount + kupakiaCost + kushushaCost + transportCost + kupangaCost;
        
        row.find("[id^=\'tax_amount_\']").val(taxAmount.toFixed(2));
        row.find("[id^=\'cost_kupakia_\']").val(kupakiaCost.toFixed(2));
        row.find("[id^=\'cost_kushusha_\']").val(kushushaCost.toFixed(2));
        row.find("[id^=\'transport_cost_\']").val(transportCost.toFixed(2));
        row.find("[id^=\'cost_kupanga_\']").val(kupangaCost.toFixed(2));
        row.find("[id^=\'products_cost_\']").val(productCost.toFixed(2));
        row.find("[id^=\'total_cost_\']").val(totalCost.toFixed(2));
    });
});
</script>';
?>