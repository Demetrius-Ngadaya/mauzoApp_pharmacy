<?php
include('dbcon.php');
$invoice_number = isset($_GET['invoice_number']) ? $_GET['invoice_number'] : '';
?>
<!-- Delete User Modal for User <?php echo $id; ?> -->
<div class="modal fade" id="deleteUserModal<?php echo $id; ?>" tabindex="-1" role="dialog" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteUserModalLabel">Futa Mtumiaji</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Je, una uhakika unataka kumfuta mtumiaji huyu?</p>
        <form method="post" action="delete_user.php?invoice_number=<?php echo $invoice_number; ?>">
          <input type="hidden" name="id" value="<?php echo $id; ?>">
          <div class="modal-footer">
            <button type="submit" name="delete" class="btn btn-danger">Futa</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Kata</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>