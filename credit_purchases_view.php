<?php
include("session.php");
include("dbcon.php");
  //****SELECTINg FROM stock******

$id = $_GET['id'];

$invoice_number = $_GET['invoice_number'];

$select_sql = "SELECT * FROM stock where store_id = '$store_id' and id = '$id' ";
  
$select_query = mysqli_query($con,$select_sql);

  while($row = mysqli_fetch_array($select_query)):
?>
<body>  
    <form method="POST" action="credit_purchases.php?invoice_number=<?php echo $invoice_number?>">
          <table id="table" style="width: 500px; margin: auto;">
              <td><input type="hidden" name="id" value="<?php echo $row['id']?>"></td>

                 <tr id="row">
                     <td>Jina la Dawa:</td>
                     <td><input type="text" name="med_name"  id="med_name" size="10" value="<?php echo $row['medicine_name']?>" required ></td>
                     <td>Aina ya Dawa:</td>
                     <td>
                        <input type="text" name="category" id="category" size="10" value="<?php echo $row['category']?>"  required></td>
                     <td>Jumla idadi:</td>
                     <td>
                        <input type="number" style="width: 95px;" name="quantity" readonly  value="<?php echo $row['quantity']?>">
                         <select style="width: 95px; height: 28px; border-color: #000080" name="sell_type" > 
                             <option value="<?php echo $row['sell_type']?>" ><?php echo $row['sell_type']?></option>
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
                     <td><input type="number" name="used_quantity" readonly id="used_quantity"  value="<?php echo $row['used_quantity']?>" ></td>
                     <td>Idadi iliyobaki:</td>
                     <td><input type="number" name="act_remain_quantity"  id="act_remain_quantity" value="<?php echo $row['act_remain_quantity']?>" ></td>
                     <td>Tarehe ku Expire:</td>
                     <td><input type="date" name="exp_date" id="exp_date" size="5" value="<?php echo $row['expire_date']?>"  required></td>
                 </tr>
                 <tr>
                     <td>Bei kununulia:</td>
                     <td><input type="number" name="actual_price" id="actual_price" value="<?php echo $row['actual_price']?>" ></td>
                     <td>Bei kuuza:</td>
                     <td><input type="number" name="selling_price" id="selling_price"   value="<?php echo $row['selling_price']?>" ></td>
                     <td>faida</td>
                     <td><input type="text" name="profit_price" id="profit_price" value="<?php echo $row['profit_price']?>"  readonly></td>
                 </tr>
                 <tr>
                     <td>Msambazaji:</td>
                     <td><input type="text" name="company" id="company" size="10" value="<?php echo $row['company']?>"></td>
                     <td>Tarehe ya kupokea Dawa:</td>
                     <td><input type="date"  name="received_date" id="received_date" size="5"  required>  </td>
                     <td>Tarehe ya kulipa:</td>
                     <td><input type="date" name="date_to_pay" id="date_to_pay" required></td>
                 </tr>
                 <tr>
                     <td>Namba ya risiti:</td>
                     <td><input type="text" name="receipt_number" id="receipt_number"  required></td>
                     <td>Namba ya bachi:</td>
                     <td><input type="text" name="batch_number" id="batch_number" required ></td>
                     <td>Idadi iliyopokelewa:</td>
                     <td><input type="number" name="received_quantity"  id="received_quantity" required></td>
                 </tr>
                 <tr>
    <td>Kiasi cha ushuru:</td>
    <td><input type="number" name="tax_amount" id="tax_amount" value="0" required></td>
    <td>Gharama Kupakia:</td>
    <td><input type="number" name="cost_kupakia" id="cost_kupakia" value="0" required></td>    
    <td>Gharama Kushusha:</td>
    <td><input type="number" name="cost_kushusha" id="cost_kushusha" value="0" required></td>
</tr>
<tr>
    <td>Gharama usafiri:</td>
    <td><input type="number" name="transport_cost" id="transport_cost" value="0" required></td>    
    <td>Gharama Kupanga:</td>
    <td><input type="number" name="cost_kupanga" id="cost_kupanga" value="0" required></td>
    <td>Gharama ya Dawa:</td>
    <td><input type="number" name="products_cost" id="products_cost" readonly></td>
</tr>
<tr>
    <td>Jumla ya gharama:</td>
    <td><input type="number" name="total_cost" id="total_cost" readonly></td>
    <td>Faida inayotarajiwa:</td>
    <td><input type="number" name="expected_profit" id="expected_profit" readonly></td>
</tr>
             <?php endwhile; ?>
                 <tr>
                    <td align="center" colspan=6> <input type="submit" name="update" class="btn btn-success btn-md" style="width: 225px" value="Hifadhi"> </td>
                 </tr>
           </table> 
     </form>
</body>

<script type="text/javascript">
    $(document).ready(function(){//***AUTO CALCULATION****

        $(document).on('keyup','#med_name', 

        function(){
             var med_name_cap = $("#med_name").val();
              
              $("#med_name").val(med_name_cap.charAt(0).toUpperCase()+med_name_cap.slice(1));
      
        });


      $(document).on('keyup','#category', 

        function(){
             var category_cap = $("#category").val();
              
              $("#category").val(category_cap.charAt(0).toUpperCase()+category_cap.slice(1));
      
        });


      $(document).on('keyup','#actual_price', 

        function(){
             var act_price = $("#actual_price").val();
      var sell_price = $("#selling_price").val();
      var pro_price = parseInt(sell_price) - parseInt(act_price);
	var percentage = Math.round((parseInt(pro_price)/parseInt(act_price))*100);
	var output = pro_price.toString().concat("(")+percentage.toString().concat("%)");
        $("#profit_price").val(output);
        });

       $(document).on('keyup','#selling_price', 
        function(){
      var act_price = $("#actual_price").val();
      var sell_price = $("#selling_price").val();
      var pro_price = parseInt(sell_price) - parseInt(act_price);
	var percentage = Math.round((parseInt(pro_price)/parseInt(act_price))*100);
	var output = pro_price.toString().concat("(")+percentage.toString().concat("%)");
        $("#profit_price").val(output);
            });
});
    
  </script>
  <script type="text/javascript">
    $(document).ready(function() {
        // Function to calculate products_cost, total_cost, and expected_profit
        function calculateCosts() {
            // Get values from input fields
            var taxAmount = parseFloat($("#tax_amount").val()) || 0;
            var costKupakia = parseFloat($("#cost_kupakia").val()) || 0;
            var costKushusha = parseFloat($("#cost_kushusha").val()) || 0;
            var transportCost = parseFloat($("#transport_cost").val()) || 0;
            var costKupanga = parseFloat($("#cost_kupanga").val()) || 0;
            var actualPrice = parseFloat($("#actual_price").val()) || 0;
            var receivedQuantity = parseFloat($("#received_quantity").val()) || 0;
            var sellingPrice = parseFloat($("#selling_price").val()) || 0;

            // Calculate products_cost
            var productsCost = actualPrice * receivedQuantity;
            $("#products_cost").val(productsCost.toFixed(2));

            // Calculate total_cost
            var totalCost = taxAmount + costKupakia + costKushusha + transportCost + costKupanga + productsCost;
            $("#total_cost").val(totalCost.toFixed(2));

            // Calculate expected_profit
            var expectedProfit = (sellingPrice * receivedQuantity) - totalCost;
            $("#expected_profit").val(expectedProfit.toFixed(2));
        }

        // Attach event listeners to input fields
        $("#tax_amount, #cost_kupakia, #cost_kushusha, #transport_cost, #cost_kupanga, #actual_price, #received_quantity, #selling_price").on("keyup change", function() {
            calculateCosts();
        });

        // Initial calculation on page load
        calculateCosts();
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

