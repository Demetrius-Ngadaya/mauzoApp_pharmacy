
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
    <form method="POST" action="purchases.php?invoice_number=<?php echo $invoice_number?>">
          <table id="table" style="width: 500px; margin: auto;">
              <td><input type="hidden" name="id" value="<?php echo $row['id']?>"></td>

                 <tr id="row">
                     <td>Jina la Dawa:</td>
                     <td><input type="text" name="med_name"  id="med_name" size="10" value="<?php echo $row['medicine_name']?>" required ></td>
                     <td>Aina ya Dawa:</td>
                     <td>
                        <input type="text" name="category" id="category" size="10" value="<?php echo $row['category']?>"  required></td>
                     <td>Jumla ya idadi:</td>
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
                     <td>Tarehe ya ku expire:</td>
                     <td><input type="date" name="exp_date" id="exp_date" size="5" value="<?php echo $row['expire_date']?>"  required></td>
                 </tr>
                 <tr>
                     <td>Bei ya kununua:</td>
                     <td><input type="number" name="actual_price" id="actual_price" value="<?php echo $row['actual_price']?>" ></td>
                     <td>Bei ya kuuza:</td>
                     <td><input type="number" name="selling_price" id="selling_price"   value="<?php echo $row['selling_price']?>" ></td>
                     <td>Faida</td>
                     <td><input type="text" name="profit_price" id="profit_price" value="<?php echo $row['profit_price']?>"  readonly></td>
                 </tr>
                 <tr>
                     <td>Msambazaji:</td>
                     <td><input type="text" name="company" id="company" size="10" value="<?php echo $row['company']?>"></td>
                     <td>Tarehe iliyopokelewa:</td>
                     <td><input type="date"  name="received_date" id="received_date" size="5"  required>  </td>
                     <td>Hali ya malipo:</td>
                     <td><input type="text" name ="purchases_status" id="purchases_status" value="paid" readonly></td>
                 </tr>
                 <tr>
                     <td>Namba ya risiti:</td>
                     <td><input type="text" name="receipt_number" id="receipt_number"  required></td>
                     <td>Namba ya bachi:</td>
                     <td><input type="text" name="batch_number" id="batch_number" required ></td>
                     <td>Idadi iliyopokelewa:</td>
                     <td><input type="number" name="received_quantity"  id="received_quantity" required></td>
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
</html>

