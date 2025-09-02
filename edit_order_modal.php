<!-- Edit Order Modal -->
<div class="modal fade" id="editOrderModal" tabindex="-1" role="dialog" aria-labelledby="editOrderModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editOrderModalLabel">Edit Order</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="update_order.php" method="POST" id="editOrderForm">
          <div class="form-group">
            <label for="edit_customer_name">Customer Name</label>
            <input type="text" class="form-control" id="edit_customer_name" name="customer_name" required>
          </div>
          <div class="form-group">
            <label for="edit_category">Category</label>
            <select class="form-control" id="edit_category" name="category" required>
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
            <label for="edit_order_medicine_name">Medicine Name</label>
            <select class="form-control" id="edit_order_medicine_name" name="order_medicine_name" required>
              <!-- Options will be populated dynamically using JavaScript -->
            </select>
          </div>
          <div class="form-group">
            <label for="edit_order_quantity">Quantity</label>
            <input type="number" class="form-control" id="edit_order_quantity" name="order_quantity" required>
          </div>
          <div class="form-group">
            <label for="edit_order_total_amount">Total Amount</label>
            <input type="text" class="form-control" id="edit_order_total_amount" name="order_total_amount" readonly>
          </div>
          <div class="form-group">
            <label for="edit_order_total_profit">Total Profit</label>
            <input type="text" class="form-control" id="edit_order_total_profit" name="order_total_profit" readonly>
          </div>
          <div class="form-group">
            <label for="edit_order_payment_method">Payment Method</label>
            <select class="form-control" id="edit_order_payment_method" name="order_payment_method" required>
              <option value="cash">Cash</option>
              <option value="credit">Credit</option>
            </select>
          </div>
          <div class="form-group" id="edit_date_to_pay_field" style="display: none;">
            <label for="edit_date_to_pay">Date to Pay</label>
            <input type="date" class="form-control" id="edit_date_to_pay" name="date_to_pay">
          </div>
          <div class="form-group">
            <label for="edit_customer_phone">Customer Phone</label>
            <input type="text" class="form-control" id="edit_customer_phone" name="customer_phone" required>
          </div>
          <input type="hidden" id="edit_order_id" name="id">
          <button type="submit" class="btn btn-primary">Update Order</button>
        </form>
      </div>
    </div>
  </div>
</div>