<!-- Purchase Modal-->
<div class="modal fade" id="add-sales" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">New Sale</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post">
          <div class="form-group">
            <div class="form-row">
              <div class="col-md-6">
                <label>Store Code</label>
                <input class="form-control" name="storecode" type="number" value="101" readonly>
              </div>
              <div class="col-md-6">
                <label>Biller ID</label>
                <input class="form-control" name="staffid" type="number" value="<?php echo $_SESSION['id']; ?>" readonly>
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="form-row">
              <div class="col-md-6">
                <label>Customer No.</label>
                <input class="form-control"  type="text" maxlength="10" name="cno" placeholder="+91 XXXXX XXXXX" autofocus>
              </div>
              <div class="col-md-6">
                <label>Date</label>
                <input class="form-control" name="date" type="date" value="<?php echo date('Y-m-d'); ?>" readonly>
              </div>
            </div>
          </div>
          <button class="btn btn-primary btn-block" type="submit" name="sales" value="add">Add</button>
        </form>
      </div>
    </div>
  </div>
</div>
