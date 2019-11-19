<!-- Breadcrumbs-->
<ol class="breadcrumb">
  <li class="breadcrumb-item">
    <a href="dashboard.php">Smart Retail POS</a>
  </li>
  <li class="breadcrumb-item">
    <a href="purchases.php">All Purchases</a>
  </li>
  <li class="breadcrumb-item active">Purchase ID - <?php $purchaseid=$_GET['id']; echo $purchaseid; ?></li>
</ol>

<div class="row">
  <div class="col-md-1"></div>
  <div class="col-md-5">
    <div class="card bg-light mb-3">
      <div class="card-header">
        Add By Name
      </div>
      <div class="card-body">
        <form method="post">
          <input type="hidden" name="id" value="<?php echo $purchaseid; ?>">
          <input type="hidden" name="action" value="purchaseitemadd">
          <input class="form-control" list="name" name="sku" maxlength="20" autocomplete="off" placeholder="Ex: CHK MSLA 5 G" required>
          <datalist id="name">
            <?php
              if($find = mysqli_query($mysqli, "SELECT DISTINCT name From products order by name asc"))
                while($arr = mysqli_fetch_array($find))
                  echo '<option value="'.$arr['name'].'">';
            ?>
          </datalist>
        </form>
      </div>
    </div>
  </div>

  <div class="col-md-5">
    <div class="card bg-light mb-3">
      <div class="card-header">
        Add By Barcode
      </div>
      <div class="card-body">
        <form method="post">
          <input type="hidden" name="id" value="<?php echo $purchaseid; ?>">
          <input type="hidden" name="action" value="purchaseitemadd">
          <input class="form-control" name="sku" placeholder="Scan Barcode / Enter Product Code" autofocus>
        </form>
      </div>
    </div>
  </div>

</div>

<?php if (isset($_GET['itemid']) and isset($_GET['action']) and $_GET['action']=='edititem') { ?>

<hr>

<div class="row">
  <div class="col-md-12">
    <div class="card text-white bg-dark mb-3">
      <div class="card-header">
        Edit Added Item
      </div>
      <div class="card-body">
        <?php
        $itemid=$_GET['itemid'];
        if($result = mysqli_query($mysqli, "SELECT * From purchaseditems where id=$itemid"))
        while($res = mysqli_fetch_array($result)){
          $productid=$res['productid'];
          $p_mrp=$res['mrp'];
          $p_sellprice=$res['sellprice'];
          $p_buyprice=$res['buyprice'];
          $p_qty=$res['quantity'];
          $p_mfd=$res['mfd'];
          $p_expd=$res['expd'];


          //Detail Finds
          if($find = mysqli_query($mysqli, "SELECT * From products where id=$productid "))
            while($arr = mysqli_fetch_array($find)){
              $p_name = $arr['name'];
              $p_brand = $arr['brand'];
              $p_type = $arr['type'];
              $p_hsn= $arr['hsn'];
              $p_gst= $arr['gst'];
              $p_unit= $arr['unit'];
          }


        }
        ?>
        <form method="post">
          <input type="hidden" name="id" value="<?php echo $purchaseid; ?>">
          <input type="hidden" name="itemid" value="<?php echo $itemid; ?>">
          <input type="hidden" name="productid" value="<?php echo $productid; ?>">
          <input type="hidden" name="action" value="purchaseitemupdate">
          <div class="row">

            <div class="col-md-2">
              <label>Name</label>
              <input class="form-control" type="text" name="name" value="<?php echo $p_name; ?>" disabled>
            </div>

            <div class="col-md-2">
              <label>Type</label>
              <input class="form-control" type="text" name="type" value="<?php echo $p_type; ?>" disabled>
            </div>

            <div class="col-md-2">
            <label>HSN</label>
              <input class="form-control" type="text" name="hsn" value="<?php echo $p_hsn; ?>" required>
            </div>

            <div class="col-md-2">
              <label>GST</label>
              <input class="form-control" type="text" name="gst" value="<?php echo $p_gst; ?>" required>
            </div>

            <div class="col-md-2">
              <label>MRP</label>
              <input class="form-control" type="number"  step="0.01" name="mrp" value="<?php echo $p_mrp; ?>" required>
            </div>

            <div class="col-md-2">
              <label>Buy </label>
              <input class="form-control" type="number"  step="0.01" name="buyprice" value="<?php echo $p_buyprice; ?>" required>
            </div>

            <div class="col-md-2">
              <label>Sell </label>
              <input class="form-control" type="number"  step="0.01" name="sellprice" value="<?php echo $p_sellprice; ?>" required>
            </div>

            <div class="col-md-2">
              <label>Qty</label>
              <input class="form-control" type="number" step="0.01" name="quantity" value="<?php echo $p_qty; ?>" required>
            </div>

            <div class="col-md-2">
              <label>Unit</label>
              <input class="form-control" type="text" name="unit" value="<?php echo $p_unit; ?>" disabled>
            </div>

            <div class="col-md-2">
              <label>MFD</label>
              <input class="form-control" type="date" name="mfd" value="<?php echo $p_mfd; ?>" required>
            </div>

            <div class="col-md-2">
              <label>EXP</label>
              <input class="form-control" type="date" name="expd" value="<?php echo $p_expd; ?>" required>
            </div>

            <div class="col-md-1">
              <label>&nbsp;</label>
              <button class="btn btn-primary" type="submit" name="action" value="purchaseitemupdate">Update</buton>
            </div>


          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?php } ?>


<?php if (isset($_GET['productid']) and isset($_GET['msg']) and $_GET['msg']=='ItemAddSuccess') { ?>

<hr>

<div class="row">
  <div class="col-md-12">
    <div class="card text-white bg-dark mb-3">
      <div class="card-header">
        Edit Added Product
      </div>
      <div class="card-body">
        <?php
        $productid=$_GET['productid'];
        if($result = mysqli_query($mysqli, "SELECT * From purchaseditems where purchaseid=$purchaseid and productid=$productid"))
        while($res = mysqli_fetch_array($result)){

          $productid=$res['productid'];
          $itemid=$res['id'];
          $p_mrp=$res['mrp'];
          $p_sellprice=$res['sellprice'];
          $p_buyprice=$res['buyprice'];
          $p_qty=$res['quantity'];
          $p_mfd=$res['mfd'];
          $p_expd=$res['expd'];


          //Detail Finds
          if($find = mysqli_query($mysqli, "SELECT * From products where id=$productid "))
            while($arr = mysqli_fetch_array($find)){
              $p_name = $arr['name'];
              $p_brand = $arr['brand'];
              $p_type = $arr['type'];
              $p_hsn= $arr['hsn'];
              $p_gst= $arr['gst'];
              $p_unit= $arr['unit'];
          }


        }
        ?>
        <form method="post">
          <input type="hidden" name="id" value="<?php echo $purchaseid; ?>">
          <input type="hidden" name="itemid" value="<?php echo $itemid; ?>">
          <input type="hidden" name="productid" value="<?php echo $productid; ?>">
          <input type="hidden" name="action" value="purchaseitemupdate">
          <div class="row">

            <div class="col-md-2">
              <label>Name</label>
              <input class="form-control" type="text" name="name" value="<?php echo $p_name; ?>" disabled>
            </div>

            <div class="col-md-2">
              <label>Type</label>
              <input class="form-control" type="text" name="type" value="<?php echo $p_type; ?>" disabled>
            </div>

            <div class="col-md-2">
            <label>HSN</label>
              <input class="form-control" type="text" name="hsn" value="<?php echo $p_hsn; ?>" required>
            </div>

            <div class="col-md-2">
              <label>GST</label>
              <input class="form-control" type="text" name="gst" value="<?php echo $p_gst; ?>" required>
            </div>

            <div class="col-md-2">
              <label>MRP</label>
              <input class="form-control" type="number"  step="0.01" name="mrp" value="<?php echo $p_mrp; ?>" required>
            </div>

            <div class="col-md-2">
              <label>Buy </label>
              <input class="form-control" type="number"  step="0.01" name="buyprice" value="<?php echo $p_buyprice; ?>" required>
            </div>

            <div class="col-md-2">
              <label>Sell </label>
              <input class="form-control" type="number"  step="0.01" name="sellprice" value="<?php echo $p_sellprice; ?>" required>
            </div>

            <div class="col-md-2">
              <label>Qty</label>
              <input class="form-control" type="number" step="0.01" name="quantity" value="<?php echo $p_qty; ?>" required>
            </div>

            <div class="col-md-2">
              <label>Unit</label>
              <input class="form-control" type="text" name="unit" value="<?php echo $p_unit; ?>" disabled>
            </div>

            <div class="col-md-2">
              <label>MFD</label>
              <input class="form-control" type="date" name="mfd" value="<?php echo $p_mfd; ?>" required>
            </div>

            <div class="col-md-2">
              <label>EXP</label>
              <input class="form-control" type="date" name="expd" value="<?php echo $p_expd; ?>" required>
            </div>

            <div class="col-md-1">
              <label>&nbsp;</label>
              <button class="btn btn-primary" type="submit" name="action" value="purchaseitemupdate">Update</buton>
            </div>


          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?php } ?>

<hr>

<div class="card mb-3">
  <div class="card-header">
    <i class="fa fa-table"></i> Purchase Item Listing</div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th>Sr.</th>
            <th>Name</th>
            <th>Type</th>
            <th>HSN</th>
            <th>GST</th>
            <th>Qty</th>
            <th>MRP</th>
            <th>Buy </th>
            <th>Total</th>
            <th>Sell </th>
            <th>Unit</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $c=0;
          $tqty=0;
          $tbuy=0;
          if($result = mysqli_query($mysqli, "SELECT * From purchaseditems where purchaseid=$purchaseid order by id asc"))
        	while($res = mysqli_fetch_array($result)){

            //initialisation
            $purchaseid=$res['purchaseid'];
            $productid=$res['productid'];



            $mrp=$res['mrp'];
            $sellprice=$res['sellprice'];
            $buyprice=$res['buyprice'];
            $quantity=$res['quantity'];
            $tqty+=$quantity;
            $tbuy+=$quantity*$buyprice;


            //Detail Finds
            if($find = mysqli_query($mysqli, "SELECT * From products where id=$productid "))
              while($arr = mysqli_fetch_array($find)){
                $name = $arr['name'];
                $brand = $arr['brand'];
                $type = $arr['type'];
                $hsn= $arr['hsn'];
                $gst= $arr['gst'];
                $unit= $arr['unit'];
            }


            echo '<tr>';
            echo '<td><p>'.(++$c).'</p></td>';
            echo '<td><p data-toggle="tooltip" data-placement="top" title="'.$brand.'">'.$name.'</p></td>';
            echo '<td><p>'.$type.'</p></td>';
            echo '<td><p>'.$hsn.'</p></td>';
            echo '<td><p>'.$gst.'</p></td>';
            echo '<td><p>'.$quantity.'</p></td>';
            echo '<td><p>'.$mrp.'</p></td>';
            echo '<td><p>'.$buyprice.'</p></td>';
            echo '<td><p>'.($quantity*$buyprice).'</p></td>';
            echo '<td><p>'.$sellprice.'</p></td>';
            echo '<td><p>'.$unit.'</p></td>';

            echo '<td><p>';
            echo '<a href="purchase-items.php?id='.$purchaseid.'&itemid='.$res['id'].'&action=edititem" data-toggle="tooltip" data-placement="top" title="Edit Items"><i class="fa fa-pencil" style="color:green;"></i></a>&nbsp;';
            echo '<a href="purchase-items.php?id='.$purchaseid.'&itemid='.$res['id'].'&action=deleteitem" data-toggle="tooltip" data-placement="top" title="Delete Item"><i class="fa fa-remove" style="color:red;"></i></a>&nbsp;';
            echo '</p></td>';
            echo '</tr>';

          }

           ?>
        </tbody>
        <tfoot>
          <tr>
            <th>Total</th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th><?php echo $tqty; ?></th>
            <th></th>
            <th></th>
            <th><?php echo $tbuy; ?></th>
            <th></th>
            <th></th>
            <th><a href="purchase-items.php?id=<?php echo $purchaseid; ?>&action=submit" data-toggle="tooltip" data-placement="top" title="Submit and Pay">Submit</a></th>
          </tr>
        </tfoot>


      </table>
    </div>
  </div>
  <div class="card-footer small text-muted">Updated few minutes ago.</div>
</div>
