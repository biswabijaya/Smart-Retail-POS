<!-- Logout Modal-->
<div class="modal fade" id="add-voucher" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add Voucher</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post">
          <div class="form-group">
            <div class="form-row">
              <div class="col-md-8">
                <label>Name</label>
                <input class="form-control" list="name" name="name" maxlength="20" autocomplete="off" placeholder="Enter Name" required>
                <datalist id="name">
                  <?php
                    if($find = mysqli_query($mysqli, "SELECT DISTINCT name From expenses order by name asc"))
                	    while($arr = mysqli_fetch_array($find))
                        echo '<option value="'.$arr['name'].'">';
                  ?>
                </datalist>
              </div>
              <div class="col-md-4">
                <label>Store/Outlet</label>
                <select class="form-control"  id="storecode"  name="storecode" required>
                  <?php
                    if($find = mysqli_query($mysqli, "SELECT * From stores order by name asc"))
                	    while($arr = mysqli_fetch_array($find))
                        echo '<option value="'.$arr['id'].'"> '.$arr['id'].' </option>';
                  ?>
                </select>
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="form-row">
              <div class="col-md-6">
                <label>Category</label>
                <input class="form-control" id="category" list="catlist" name="category" maxlength="15" autocomplete="off" placeholder="Category" required>
                <datalist id="catlist">
                  <?php
                    if($find = mysqli_query($mysqli, "SELECT DISTINCT category From vouchers order by category asc"))
                	    while($arr = mysqli_fetch_array($find))
                        echo '<option value="'.$arr['category'].'">';
                  ?>
                </datalist>

              </div>
              <div class="col-md-6">
                <label>Sub Category</label>
                <input class="form-control" id="subcategory" name="subcategory" maxlength="15" autocomplete="off" placeholder="Subcategory" required>
                <?php
                  if($findcat = mysqli_query($mysqli, "SELECT DISTINCT category From vouchers order by category asc"))
                    while($arrcat = mysqli_fetch_array($findcat)){
                      $cat=$arrcat['category'];
                      echo '<datalist id="'.$cat.'">';
                      if($findsubcat = mysqli_query($mysqli, "SELECT DISTINCT subcategory From vouchers where category='$cat' "))
                        while($arrsubcat = mysqli_fetch_array($findsubcat))
                          echo '<option value="'.$arrsubcat['subcategory'].'">';
                      echo '</datalist>';
                    }
                ?>
              </div>
            </div>
          </div>
          <hr>
          <div class="form-group">
            <div class="form-row">
              <div class="col-md-6">
                <label>Date Of Issue</label>
                <input class="form-control" name="date" type="date" min="2018-10-01" max="<?php echo date('Y-m-d'); ?>"  value="<?php echo date('Y-m-d'); ?>"  required>
              </div>
              <div class="col-md-6">
                <label>Amount</label>
                <input class="form-control" name="amount" type="number" min="1" placeholder="Enter Amount" required>
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="form-row">
              <div class="col-md-12">
                <label>Voucher Details</label>
                <input class="form-control" name="details" type="text" maxlength="200" autocomplete="off" placeholder="Enter Details" required>
              </div>
            </div>
          </div>
          <button class="btn btn-primary btn-block" type="submit" name="voucher" value="add">Add</button>
        </form>
      </div>
    </div>
  </div>
</div>
