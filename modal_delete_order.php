<div class="modal fade" id="delete_order<?php echo $id; ?>" tabindex="-1" role="dialog" aria-labelledby="deleteOrderModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteOrderModalLabel">Unafuta oda ya mteja</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Je unauhakika unataka kuifuta hii oda?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Hapana kata</button>
        <a href="delete_order.php?id=<?php echo $id; ?>" class="btn btn-danger">Ndio futa</a>
      </div>
    </div>
  </div>
</div>