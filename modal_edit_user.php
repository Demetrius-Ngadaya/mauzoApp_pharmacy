<?php
include('dbcon.php');
$invoice_number = isset($_GET['invoice_number']) ? $_GET['invoice_number'] : '';
$stores = mysqli_query($con, "SELECT * FROM stores") or die(mysqli_error($con));
?>
<div class="modal fade" id="editUserModal<?php echo $id; ?>" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editUserModalLabel">Badili Mtumiaji</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Funga">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" action="edit_user.php?invoice_number=<?php echo $invoice_number; ?>">
          <input type="hidden" name="id" value="<?php echo $id; ?>">
          <div class="form-group">
            <label for="user_name">Jina la mtumiaji:</label>
            <input type="text" name="user_name" value="<?php echo htmlspecialchars($user_name); ?>" class="form-control" required>
          </div>
          <div class="form-group">
            <label for="role">Wajibu:</label>
            <select name="role" class="form-control" required>
              <option value="cashier" <?php echo ($role == 'cashier') ? 'selected' : ''; ?>>Cashier</option>
              <option value="admin" <?php echo ($role == 'admin') ? 'selected' : ''; ?>>Admin</option>
            </select>
          </div>
          <div class="form-group">
            <label for="can_access_all_stores">Ruhusa za Maduka</label>
            <select class="form-control" id="can_access_all_stores_<?php echo $id; ?>" name="can_access_all_stores" onchange="toggleStoreSelection<?php echo $id; ?>(this)">
              <option value="0" <?php echo ($can_access_all_stores == 0) ? 'selected' : ''; ?>>Tawi/Kituo Fulani</option>
              <option value="1" <?php echo ($can_access_all_stores == 1) ? 'selected' : ''; ?>>Matawi yote</option>
            </select>
          </div>
          <div class="form-group" id="storeSelectionGroup_<?php echo $id; ?>" style="<?php echo ($can_access_all_stores == 1) ? 'display: none;' : ''; ?>">
            <label for="store_id">Tawi/Kituo:</label>
            <select name="store_id" class="form-control">
              <option value="">--Chagua Tawi/Kituo--</option>
              <?php while($store = mysqli_fetch_array($stores)): ?>
                <option value="<?php echo $store['id']; ?>" <?php echo ($store['id'] == $store_id) ? 'selected' : ''; ?>>
                  <?php echo $store['name']; ?>
                </option>
              <?php endwhile; ?>
            </select>
          </div>
          <div class="form-group">
            <label for="password">Neno la siri</label>
            <input type="password" name="password" class="form-control">
            <small>Kama hutaki kubadilisha neno la siri, acha wazi.</small>
          </div>
          <div class="modal-footer">
            <button type="submit" name="edit" class="btn btn-primary">Hifadhi</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Funga</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
// Scoped function per modal to handle display logic
function toggleStoreSelection<?php echo $id; ?>(select) {
  const storeGroup = document.getElementById('storeSelectionGroup_<?php echo $id; ?>');
  if (select.value === '1') {
    storeGroup.style.display = 'none';
  } else {
    storeGroup.style.display = 'block';
  }
}
</script>
