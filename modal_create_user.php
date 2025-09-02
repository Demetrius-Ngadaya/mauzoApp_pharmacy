<?php
include('dbcon.php');
$invoice_number = isset($_GET['invoice_number']) ? $_GET['invoice_number'] : '';
$stores = mysqli_query($con, "SELECT * FROM stores") or die(mysqli_error($con));
?>
<!-- Create User Modal -->
<div class="modal fade" id="createUserModal" tabindex="-1" role="dialog" aria-labelledby="createUserModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="createUserModalLabel">Ongeza Mtumiaji Mpya</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="createUserForm" action="create_user.php?invoice_number=<?php echo $invoice_number; ?>" method="POST">
          <div class="form-group">
            <label for="user_name">Jina la Mtumiaji</label>
            <input type="text" class="form-control" id="user_name" name="user_name" required>
          </div>
          <div class="form-group">
            <label for="role">Wajibu</label>
            <select class="form-control" id="role" name="role" required>
              <option value="admin">Admin</option>
              <option value="cashier">Cashier</option>
            </select>
          </div>
           <div class="form-group">
    <label for="can_access_all_stores">Ruhusa za vituo/matawi</label>
    <select class="form-control" id="can_access_all_stores" name="can_access_all_stores" onchange="toggleStoreSelection(this)">
        <option value="0">Tawi/Kituo Fulani</option>
        <option value="1">Matawi yote</option>
    </select>
</div>
<div class="form-group" id="storeSelectionGroup">
    <label for="store_id">Tawi/Kituo</label>
    <select class="form-control" id="store_id" name="store_id">
        <option value="">--Chagua Tawi/Kituo--</option>
        <?php while($store = mysqli_fetch_array($stores)): ?>
            <option value="<?php echo $store['id']; ?>"><?php echo $store['name']; ?></option>
        <?php endwhile; ?>
    </select>
</div>
          <div class="form-group">
            <label for="password">Neno la Siri</label>
            <input type="password" class="form-control" id="password" name="password" required>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Funga</button>
            <button type="submit" class="btn btn-primary">Hifadhi</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<script>
function toggleStoreSelection(select) {
    const storeSelectionGroup = document.getElementById('storeSelectionGroup');
    if (select.value === '1') {
        storeSelectionGroup.style.display = 'none';
    } else {
        storeSelectionGroup.style.display = 'block';
    }
}
</script>