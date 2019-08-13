<!-- Logout Modal-->
<div class="modal fade" id="add-supplier" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add Supplier</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post">
          <div class="form-group">
            <div class="form-row">
              <div class="col-md-6">
                <label>Name</label>
                <input class="form-control" type="text" name="name" maxlength="30" autocomplete="off" placeholder="Supplier Name" required>
              </div>
              <div class="col-md-6">
                <label>Contact No</label>
                <input class="form-control" type="number" name="cno" min="6000000000" max="10000000000" autocomplete="off" placeholder="+91 XXXXX XXXXX" required>
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="form-row">
              <div class="col-md-12">
                <label>Address</label>
                <input class="form-control" type="text" name="address" maxlength="100" autocomplete="off" placeholder="Locality, City, Pincode" required>
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="form-row">
              <div class="col-md-4">
                <label>Joining Date</label>
                <input class="form-control" name="doj" autocomplete="off" type="date" required>
              </div>
              <div class="col-md-8">
                <label>GSTIN</label>
                <input class="form-control" type="text" name="gstin" maxlength="15" autocomplete="off" placeholder="00 XXXX0000X 0X0" required>
              </div>
            </div>
          </div>
          <button class="btn btn-primary btn-block" type="submit" name="supplier" value="add">Add</button>
        </form>
      </div>
    </div>
  </div>
</div>
