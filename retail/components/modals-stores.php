<!-- Logout Modal-->
<div class="modal fade" id="add-store" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add Store</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post">
          <div class="form-group">
            <div class="form-row">
              <div class="col-md-7">
                <label>Name</label>
                <input class="form-control" type="text" name="name" maxlength="20" autocomplete="off" placeholder="Store Name" required>
              </div>
              <div class="col-md-5">
                <label>Type</label>
                <select class="form-control" name="type" required>
                  <option>outlet</option>
                  <option>warehouse</option>
                <select>
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="form-row">
              <div class="col-md-6">
                <label>Contact No</label>
                <input class="form-control" name="cno" autocomplete="off" type="number" required>
              </div>
              <div class="col-md-6">
                <label>Manager</label>
                <select class="form-control" name="maager" required>
                  <option value="0">Set Later</option>
                  <?php
                    if($find = mysqli_query($mysqli, "SELECT * From staffs where usertype='manager'"))
                    while($arr = mysqli_fetch_array($find)){
                      echo '<option value="'.$arr['id'].'">'.$arr['name'].'</option>';
                  }
                  ?>
                <select>
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="form-row">
              <div class="col-md-4">
                <label>Locality</label>
                <input class="form-control" name="locality" maxlength="20" autocomplete="off" type="text" required>
              </div>
              <div class="col-md-4">
                <label>City</label>
                <input class="form-control" name="city" maxlength="20" autocomplete="off" type="text" required>
              </div>
              <div class="col-md-4">
                <label>Pincode</label>
                <input class="form-control" name="pincode" autocomplete="off" type="number" min="100000" max="999999"required>
              </div>
            </div>
          </div>
          <button class="btn btn-primary btn-block" type="submit" name="staff" value="add">Add</button>
        </form>
      </div>
    </div>
  </div>
</div>
