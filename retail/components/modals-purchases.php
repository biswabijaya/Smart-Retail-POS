<!-- Purchase Modal-->
<div class="modal fade" id="add-purchase" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Create Purchase</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post">
          <div class="form-group">
            <div class="form-row">
              <div class="col-md-7">
                <label>Supplier</label>
                <select class="form-control" name="supplierid">
                  <?php
                  if($find = mysqli_query($mysqli, "SELECT * From suppliers order by name asc"))
                    while($arr = mysqli_fetch_array($find))
                      echo '<option value="'.$arr['id'].'">'.$arr['name'].'</option>';
                  ?>
                </select>
              </div>
              <div class="col-md-5">
                <label>Date</label>
                <input class="form-control" name="date" type="date" value="<?php echo date('Y-m-d'); ?>" required>
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="form-row">
              <div class="col-md-5">
                <label> Type </label>
                <select id="type" class="form-control" name="type">
                  <option value="Prepaid">Prepaid</option>
                  <option value="Postpaid">Postpaid</option>
                </select>
              </div>
              <div class="col-md-7">
                <label> Purchase Ref. / Bill No. </label>
                <input class="form-control" id="billno" name="billno" type="text" value=" " required>
              </div>
            </div>
          </div>
          <button class="btn btn-primary btn-block" type="submit" name="purchases" value="add">Add</button>
        </form>
      </div>
    </div>
  </div>
</div>
