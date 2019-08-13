<!-- Product Modal-->
<div class="modal fade" id="add-product" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add Product</h5>
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
                <input class="form-control" list="name" name="name" maxlength="20" autocomplete="off" placeholder="Ex: CHK MSLA 5 G" required>
                <datalist id="name">
                  <?php
                    if($find = mysqli_query($mysqli, "SELECT DISTINCT name From products order by name asc"))
                	    while($arr = mysqli_fetch_array($find))
                        echo '<option value="'.$arr['name'].'">';
                  ?>
                </datalist>
              </div>
              <div class="col-md-4">
                <label>Brand</label>
                <input class="form-control" list="brand" name="brand" maxlength="15" autocomplete="off" placeholder="Product Brand" required>
                <datalist id="brand">
                  <?php
                    if($find = mysqli_query($mysqli, "SELECT DISTINCT brand From products order by brand asc"))
                	    while($arr = mysqli_fetch_array($find))
                        echo '<option value="'.$arr['brand'].'">';
                  ?>
                </datalist>
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
                    if($find = mysqli_query($mysqli, "SELECT DISTINCT category From products order by category asc"))
                	    while($arr = mysqli_fetch_array($find))
                        echo '<option value="'.$arr['category'].'">';
                  ?>
                </datalist>

              </div>
              <div class="col-md-6">
                <label>Sub Category</label>
                <input class="form-control" id="subcategory" name="subcategory" maxlength="15" autocomplete="off" placeholder="Subcategory" required>
                <?php
                  if($findcat = mysqli_query($mysqli, "SELECT DISTINCT category From products order by category asc"))
                    while($arrcat = mysqli_fetch_array($findcat)){
                      $cat=$arrcat['category'];
                      echo '<datalist id="'.$cat.'">';
                      if($findsubcat = mysqli_query($mysqli, "SELECT DISTINCT subcategory From products where category='$cat' "))
                        while($arrsubcat = mysqli_fetch_array($findsubcat))
                          echo '<option value="'.$arrsubcat['subcategory'].'">';
                      echo '</datalist>';
                    }
                ?>
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="form-row">
              <div class="col-md-4">
                <label> Barcode </label>
                <select id="barcode" class="form-control" name="">
                  <option value="No">No</option>
                  <option value="Yes">Yes</option>
                </select>
              </div>
              <div class="col-md-8">
                <label> SKU / Product Code / Barcode </label>
                <?php
                  if($find = mysqli_query($mysqli, "SELECT value From counter where name='productcode'"))
                    while($arr = mysqli_fetch_array($find))
                      $productcode=$arr['value'];
                ?>
                <input class="form-control" id="sku" name="sku" type="number" value="<?php echo $productcode; ?>" readonly>
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="form-row">
              <div class="col-md-3">
                <label>Type</label>
                <select class="form-control" name="type" required>
                  <option>Open</option>
                  <option>Packed</option>
                </select>
              </div>
              <div class="col-md-4">
                <label>GST Rate</label>
                <select class="form-control" name="gst" required>
                  <option>0</option>
                  <option>5</option>
                  <option>12</option>
                  <option>18</option>
                  <option>28</option>
                </select>
              </div>
              <div class="col-md-5">
                <label>HSN Code ( <a href="hsn.php" target="_blank">Find HSN</a> )</label>
                <input class="form-control" type="number" name="hsn" placeholder="XX or XXXX" required>
              </div>
            </div>
          </div>
          <hr><center> <h5> Fill Default Details </h5></center>
          <div class="form-group">
            <div class="form-row">
              <div class="col-md-6">
                <label>Buy Price (Excluding GST)</label>
                <input class="form-control" type="number" name="buyrate" min="0.01"  step="0.01" placeholder="0.00" required>
              </div>
              <div class="col-md-3">
                <label>MRP</label>
                <input class="form-control" type="number" name="mrp" min="1"  step="0.01" placeholder="0.00" required>
              </div>
              <div class="col-md-3">
                <label>Unit</label>
                <select class="form-control" name="unit" required>
                  <option>pkt</option>
                  <option value="pc">piece</option>
                  <option>kg</option>
                  <option>gram</option>
                  <option>mg</option>
                  <option>liter</option>
                  <option>ml</option>
                  <option>dozen</option>
                </select>
              </div>
            </div>
          </div>
          <hr> <center> <h5> Fill Optional Details </h5></center>
          <div class="form-group">
            <div class="form-row">

              <div class="col-md-6">
                <label>Supplier</label>
                <select class="form-control" name="supplier" required>
                  <option value="0">Set Later</option>
                  <?php
                    if($find = mysqli_query($mysqli, "SELECT * From suppliers order by name asc"))
                      while($arr = mysqli_fetch_array($find))
                        echo '<option value="'.$arr['id'].'">'.$arr['name'].'</option>';
                  ?>
                </select>
              </div>
              <div class="col-md-6">
                <label>Comment</label>
                <input class="form-control" name="comment" maxlength="100" autocomplete="off" placeholder="Comment" required>
              </div>
            </div>
          </div>
          <button class="btn btn-primary btn-block" type="submit" name="product" value="add">Add</button>
        </form>
      </div>
    </div>
  </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript">
$("#category").bind("change", function() {
  if ($("#category").val() == "None") { }
  <?php
    if($find = mysqli_query($mysqli, "SELECT DISTINCT category From products order by category asc"))
      while($arr = mysqli_fetch_array($find))
        echo 'else if ($("#category").val() == "'.$arr['category'].'") { $("#subcategory").attr("list", "'.$arr['category'].'");}';
  ?>
   else {}
});

$("#barcode").bind("change", function() {
  if ($("#barcode").val() == "Yes") {
    $("#sku").attr({value:"", readonly:false});
  } else if ($("#barcode").val() == "No") {
    $("#sku").attr({value:"<?php echo $productcode; ?>", readonly:true});
  } else {}
});

$('#add-product').on('keyup keypress', function(e) {
  var keyCode = e.keyCode || e.which;
  if (keyCode === 13) {
    e.preventDefault();
    return false;
  }
});
</script>
