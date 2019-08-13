<?php
if (isset($_GET['sku'])) {
  $sqlcol='sku';
  $sqlcoldata=$_GET['sku'];

} else if (isset($_GET['id'])) {
  $sqlcol='id';
  $sqlcoldata=$_GET['id'];
}

if($result = mysqli_query($mysqli, "SELECT * From products where $sqlcol = $sqlcoldata"))
while($res = mysqli_fetch_array($result)){
  $productid=$res['id'];

  if($resul = mysqli_query($mysqli, "SELECT * From purchaseditems where productid=$productid"))
  while($re = mysqli_fetch_array($resul)){
    $buyrate = $re['buyprice'];
    $salerate = $re['saleprice'];
  }

  $name = $res['name'];
  $brand = $res['brand'];
  $category = $res['category'];
  $subcategory = $res['subcategory'];

  $sku = $res['sku'];
  $type = $res['type'];
  $hsn = $res['hsn'];
  $gst = $res['gst'];

  $mrp = $res['mrp'];
  $unit = $res['unit'];

  $supplier = $res['supplier'];
  $comment = $res['comment'];
}
 ?>

<div class="card card-register mx-auto mt-5">
  <div class="card-header">Register a Product</div>
  <div class="card-body">
    <form method="post">
      <div class="form-group">
        <div class="form-row">
          <div class="col-md-8">
            <label>Name</label>
            <input class="form-control" list="name" name="name" maxlength="20" autocomplete="off" value="<?php echo $name; ?>" <?php echo $action; ?> >
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
            <input class="form-control" list="brand" name="brand" maxlength="15" autocomplete="off" value="<?php echo $brand; ?>" <?php echo $action; ?> >
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
            <input class="form-control" id="category" list="catlist" name="category" maxlength="15" autocomplete="off" value="<?php echo $category; ?>" <?php echo $action; ?> >
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
            <input class="form-control" id="subcategory" name="subcategory" maxlength="15" autocomplete="off" value="<?php echo $subcategory; ?>" <?php echo $action; ?> >
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
            <select id="barcode" class="form-control" <?php echo $action; ?> >
              <option value="No">No</option>
              <option value="Yes" <?php if ($sku>10000000) echo "selected"; ?> >Yes</option>
            </select>
          </div>
          <div class="col-md-8">
            <label> SKU / Product Code / Barcode EAN-13 </label>
            <input class="form-control" id="sku" name="sku" max="9999999999999" type="number" value="<?php echo $sku; ?>" <?php echo $action; ?> >
          </div>
        </div>
      </div>
      <div class="form-group">
        <div class="form-row">
          <div class="col-md-3">
            <label>Type</label>
            <select class="form-control" name="type" <?php echo $action; ?> >
              <option <?php if ($type=="Open") echo "selected"; ?> >Open</option>
              <option <?php if ($type=="Packed") echo "selected"; ?> >Packed</option>
            </select>
          </div>
          <div class="col-md-4">
            <label>GST Rate</label>
            <select class="form-control" name="gst" <?php echo $action; ?> >
              <option <?php if ($gst==0) echo "selected"; ?> >0</option>
              <option <?php if ($gst==5) echo "selected"; ?> >5</option>
              <option <?php if ($gst==12) echo "selected"; ?> >12</option>
              <option <?php if ($gst==18) echo "selected"; ?> >18</option>
              <option <?php if ($gst==28) echo "selected"; ?> >28</option>
            </select>
          </div>
          <div class="col-md-5">
            <label>HSN Code ( <a href="hsn.php" target="_blank">Find HSN</a> )</label>
            <input class="form-control" type="number" max="99999999" name="hsn" value="<?php echo $hsn; ?>" <?php echo $action; ?> >
          </div>
        </div>
      </div>
      <hr><center> <h5> Fill Default Details </h5></center>
      <div class="form-group">
        <div class="form-row">
          <div class="col-md-3">
            <label>Buy Price (With GST)</label>
            <input class="form-control" type="number" name="buyrate" min="0.01" step="0.01" value="<?php echo $buyrate; ?>" <?php echo $action; ?> >
          </div>
          <div class="col-md-3">
            <label>Sell Price (With GST)</label>
            <input class="form-control" type="number" name="salerate" min="0.01" step="0.01" value="<?php echo $salerate; ?>" <?php echo $action; ?> >
          </div>
          <div class="col-md-3">
            <label>MRP</label>
            <input class="form-control" type="number" name="mrp" min="0.01"  step="0.01" value="<?php echo $mrp; ?>" <?php echo $action; ?> >
          </div>
          <div class="col-md-3">
            <label>Unit</label>
            <select class="form-control" name="unit" <?php echo $action; ?> >
              <option <?php if ($unit=='pkt') echo "selected"; ?> >pkt</option>
              <option <?php if ($unit=='pc') echo "selected"; ?> >piece</option>
              <option <?php if ($unit=='kg') echo "selected"; ?> >kg</option>
              <option <?php if ($unit=='gram') echo "selected"; ?> >gram</option>
              <option <?php if ($unit=='mg') echo "selected"; ?> >mg</option>
              <option <?php if ($unit=='liter') echo "selected"; ?> >liter</option>
              <option <?php if ($unit=='ml') echo "selected"; ?> >ml</option>
              <option <?php if ($unit=='dozen') echo "selected"; ?> >dozen</option>
            </select>
          </div>
        </div>
      </div>
      <hr> <center> <h5> Fill Optional Details </h5></center>
      <div class="form-group">
        <div class="form-row">

          <div class="col-md-6">
            <label>Supplier</label>
            <select class="form-control" name="supplier" <?php echo $action; ?> >
              <option value="0">set-later</option>
              <?php
                if($find = mysqli_query($mysqli, "SELECT * From suppliers order by name asc"))
                  while($arr = mysqli_fetch_array($find)){
                    if ($seller==$arr['id']) $print="selected";
                    else $print="";
                      echo '<option value="'.$arr['id'].'" '.$print.'>'.$arr['name'].'</option>';
                  }

              ?>
            </select>
          </div>
          <div class="col-md-6">
            <label>Comment</label>
            <input class="form-control" name="comment" maxlength="100" autocomplete="off" value="<?php echo $comment; ?>" <?php echo $action; ?> >
          </div>
        </div>
      </div>
      <?php if ($_GET['action']=='edit'){
        echo '<button class="btn btn-primary btn-block" type="submit" name="product" value="update">Update</button>';
      } else if ($_SESSION['usertype']=='admin') {
        echo '<a href="product.php?sku='.$sku.'&action=edit" class="btn btn-primary btn-block" href="index.php">Edit</a>';
      }

      ?>

    </form>
    <div class="text-center">
      <a class="d-block small mt-3" href="index.php">Go Back to Home</a>
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
