<div class="modal fade" id="createOrderModal" tabindex="-1" role="dialog" aria-labelledby="createOrderModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="createOrderModalLabel">Andika oda mpya ya mteja</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="create_order.php" method="POST">
          <div class="form-group">
            <label for="customer_name">Jina la mteja</label>
            <input type="text" class="form-control" id="customer_name" name="customer_name" required>
          </div>
          <div class="form-group">
            <label for="category">Aina ya Dawa</label>
            <select class="form-control" id="category" name="category" required>
              <?php
              include('dbcon.php');
              $query = mysqli_query($con, "SELECT DISTINCT category FROM stock where store_id = '$store_id'") or die(mysqli_error($con));
              while ($row = mysqli_fetch_array($query)) {
                  echo '<option value="' . $row['category'] . '">' . $row['category'] . '</option>';
              }
              ?>
            </select>
          </div>
          <div class="form-group">
            <label for="order_medicine_name">Jina la Dawa</label>
            <select class="form-control" id="order_medicine_name" name="order_medicine_name" required>
              <!-- Options will be populated dynamically using JavaScript -->
            </select>
          </div>
          <div class="form-group">
            <label for="order_quantity">Idadi</label>
            <input type="number" class="form-control" id="order_quantity" name="order_quantity" required>
          </div>
          <div class="form-group">
            <label for="order_total_amount">Jumla kiasi cha fedha</label>
            <input type="text" class="form-control" id="order_total_amount" name="order_total_amount" readonly>
          </div>
          <div class="form-group">
            <label for="order_total_profit">Jumla ya faia</label>
            <input type="text" class="form-control" id="order_total_profit" name="order_total_profit" readonly>
          </div>
          <div class="form-group">
            <label for="order_payment_method">Njia ya malipo</label>
            <select class="form-control" id="order_payment_method" name="order_payment_method" required>
              <option value="cash">Cash</option>
              <option value="credit">Mkopo</option>
            </select>
          </div>
          <div class="form-group" id="date_to_pay_field" style="display: none;">
            <label for="date_to_pay">Siku ya kulipa</label>
            <input type="date" class="form-control" id="date_to_pay" name="date_to_pay">
          </div>
          <div class="form-group">
            <label for="customer_phone">Namba ya sim ya mteja</label>
            <input type="text" class="form-control" id="customer_phone" name="customer_phone" required>
          </div>
          <input type="hidden" name="invoice_number" value="<?php echo $invoice_number; ?>">
          <input type="hidden" name="order_status" value="incomplete">
          <input type="hidden" name="store_order_quantity" value="0">
          <input type="hidden" name="order_recorder" value="<?php echo $mtumiaji; ?>">
          <button type="submit" class="btn btn-primary">Hifadhi oda</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  $(document).ready(function () {
    // Populate medicine names based on selected category
    $('#category').change(function () {
      var category = $(this).val();
      $.ajax({
        url: 'get_medicines.php',
        type: 'POST',
        data: { category: category },
        success: function (response) {
          $('#order_medicine_name').html(response);
        }
      });
    });

    // Calculate total amount and profit when medicine or quantity changes
    $('#order_medicine_name, #order_quantity').change(function () {
      var medicine_id = $('#order_medicine_name').val();
      var quantity = $('#order_quantity').val();

      if (medicine_id && quantity) {
        $.ajax({
          url: 'get_medicine_price.php',
          type: 'POST',
          data: { medicine_id: medicine_id },
          success: function (response) {
            var data = JSON.parse(response);
            var total_amount = quantity * data.price;
            var total_profit = quantity * data.profit_price;
            $('#order_total_amount').val(total_amount);
            $('#order_total_profit').val(total_profit);
          }
        });
      }
    });

    // Show/hide date_to_pay field based on payment method
    $('#order_payment_method').change(function () {
      if ($(this).val() == 'credit') {
        $('#date_to_pay_field').show();
      } else {
        $('#date_to_pay_field').hide();
      }
    });
  });
</script>