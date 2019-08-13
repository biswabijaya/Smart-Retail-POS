<!-- Breadcrumbs-->
<ol class="breadcrumb">
  <li class="breadcrumb-item">
    <a href="dashboard.php">Shanti Fresh</a>
  </li>
  <li class="breadcrumb-item">
    <a href="sales.php">All Sales</a>
  </li>
  <li class="breadcrumb-item active">Sales ID - <?php $salesid=$_GET['id']; echo $salesid; ?></li>
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
          <input type="hidden" name="id" value="<?php echo $salesid; ?>">
          <input type="hidden" name="action" value="salesitemadd">
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
          <input type="hidden" name="id" value="<?php echo $salesid; ?>">
          <input type="hidden" name="action" value="salesitemadd">
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
        $purchasestock=$salestock=0;
        if($result = mysqli_query($mysqli, "SELECT * From solditems where id=$itemid"))
        while($res = mysqli_fetch_array($result)){

          $salesid=$res['salesid'];
          $productid=$res['productid'];
          $p_mrp=$res['mrp'];
          $p_sellprice=$res['sellprice'];
          $p_qty=$res['quantity'];


          //Detail Finds
          if($find = mysqli_query($mysqli, "SELECT * From products where id=$productid "))
            while($arr = mysqli_fetch_array($find)){
              $p_name = $arr['name'];
              $p_brand = $arr['brand'];
              $p_type = $arr['type'];
              $p_unit= $arr['unit'];
          }
        }

        //prchase stock
        if($find = mysqli_query($mysqli, "SELECT * From purchaseditems where productid=$productid"))
        while($arr = mysqli_fetch_array($find))
        $purchasestock+=$arr['quantity'];

        //sale stock
        if($find = mysqli_query($mysqli, "SELECT * From solditems where productid=$productid"))
        while($arr = mysqli_fetch_array($find))
        $salestock+=$arr['quantity'];

        //net stock
        $stock=$purchasestock-$salestock;
        $stock=number_format($stock, 2);

        ?>
        <form method="post">
          <input type="hidden" name="salesid" value="<?php echo $salesid; ?>">
          <input type="hidden" name="itemid" value="<?php echo $itemid; ?>">
          <div class="row">
            <div class="col-md-6">
              <label>Select Item</label>
              <select class="form-control" name="purchaseditemid" required>
                <?php
                $tbuy=$tsold=0;
                if($result = mysqli_query($mysqli, "SELECT * From purchaseditems where productid=$productid group by sellprice, mfd, expd order by id desc"))
                while($res = mysqli_fetch_array($result)){
                  $purid=$res['id'];
                  $pr_mrp=$res['mrp'];
                  $pr_sellprice=$res['sellprice'];
                  $pr_mfd=$res['mfd'];
                  $pr_expd=$res['expd'];

                  $buy=$sold=0;

                  //Purchase Finds
                  if($find = mysqli_query($mysqli, "SELECT * From purchaseditems where productid=$productid and sellprice=$pr_sellprice"))
                    while($arr = mysqli_fetch_array($find)){
                      if($pr_mfd==$arr['mfd'] and $pr_expd==$arr['expd'])
                      $buy+=$arr['quantity'];
                  }

                  //Sold Finds
                  if($find = mysqli_query($mysqli, "SELECT * From solditems where productid=$productid and sellprice=$pr_sellprice"))
                    while($arr = mysqli_fetch_array($find)){
                      if($pr_mfd==$arr['mfd'] and $pr_expd==$arr['expd'])
                      $sold+=$arr['quantity'];
                  }

                  $tbuy+=$buy;
                  $tsold+=$sold;


                  //Detail Finds
                  if($find = mysqli_query($mysqli, "SELECT * From products where id=$productid "))
                    while($arr = mysqli_fetch_array($find)){
                      $pr_name = $arr['name'];
                      $pr_brand = $arr['brand'];
                      $pr_type = $arr['type'];
                      $pr_hsn= $arr['hsn'];
                      $pr_gst= $arr['gst'];
                      $pr_unit= $arr['unit'];
                  }

                  $datediff = round((time() - strtotime("$pr_expd")) / (60 * 60 * 24));

                  if ($buy==$sold and $datediff>7) {
                    continue;
                  }
                  echo '<option value="'.$purid.'"> '.$pr_name.' - '.$pr_type.' | ₹'.$pr_sellprice.' | '.$pr_mfd.' - '.$pr_expd.' | Rem:  '.($buy-$sold).' </option>';
                }

                $stock=$tbuy-$tsold+$p_qty;
                $stock=number_format($stock, 2);
                ?>

              </select>
            </div>

            <div class="col-md-2">
              <label>In Stock (in <?php echo $p_unit; ?>)</label>
                <input class="form-control" type="number" value="<?php echo $stock; ?>" disabled>
            </div>

            <div class="col-md-2">
              <label>Sell Qty (in <?php echo $p_unit; ?>)</label>
              <?php if ($p_type=='Packed') {  ?>
                <input class="form-control" type="number" step="1.0" name="quantity" max="<?php echo $stock; ?>" value="<?php echo $p_qty; ?>" required>
              <?php } else { ?>
                <input class="form-control" type="number" step="0.01" name="quantity" max="<?php echo $stock; ?>" value="<?php echo $p_qty; ?>" required>
              <?php }  ?>

            </div>

            <div class="col-md-2 pt-2">
              <br>
              <button class="btn btn-primary btn-md" type="submit" name="action" value="salesitemupdate">Update</buton>
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
        Choose Item and Quantity (Optional)
      </div>
      <div class="card-body">
        <?php
        $productid=$_GET['productid'];
        $purchasestock=$salestock=0;
        if($result = mysqli_query($mysqli, "SELECT * From solditems where salesid=$salesid and productid=$productid"))
        while($res = mysqli_fetch_array($result)){

          $itemid=$res['id'];
          $productid=$res['productid'];
          $p_mrp=$res['mrp'];
          $p_sellprice=$res['sellprice'];
          $p_qty=$res['quantity'];


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

        //prchase stock
        if($find = mysqli_query($mysqli, "SELECT * From purchaseditems where productid=$productid"))
        while($arr = mysqli_fetch_array($find))
        $purchasestock+=$arr['quantity'];

        //sale stock
        if($find = mysqli_query($mysqli, "SELECT * From solditems where productid=$productid"))
        while($arr = mysqli_fetch_array($find))
        $salestock+=$arr['quantity'];

        //net stock
        $stock=$purchasestock-$salestock;
        $stock=number_format($stock, 2);

        ?>
        <form method="post">
          <input type="hidden" name="salesid" value="<?php echo $salesid; ?>">
          <input type="hidden" name="itemid" value="<?php echo $itemid; ?>">
          <div class="row">

            <div class="col-md-6">
              <label>Select Item</label>
              <select class="form-control" name="purchaseditemid" required>
                <?php
                $tbuy=$tsold=0;
                if($result = mysqli_query($mysqli, "SELECT * From purchaseditems where productid=$productid group by sellprice, mfd, expd order by id desc"))
                while($res = mysqli_fetch_array($result)){
                  $purid=$res['id'];
                  $pr_mrp=$res['mrp'];
                  $pr_sellprice=$res['sellprice'];
                  $pr_mfd=$res['mfd'];
                  $pr_expd=$res['expd'];

                  $buy=$sold=0;

                  //Purchase Finds
                  if($find = mysqli_query($mysqli, "SELECT * From purchaseditems where productid=$productid and sellprice=$pr_sellprice "))
                    while($arr = mysqli_fetch_array($find)){
                      if($pr_mfd==$arr['mfd'] and $pr_expd==$arr['expd'])
                      $buy+=$arr['quantity'];
                  }

                  //Sold Finds
                  if($find = mysqli_query($mysqli, "SELECT * From solditems where productid=$productid and sellprice=$pr_sellprice"))
                    while($arr = mysqli_fetch_array($find)){
                      if($pr_mfd==$arr['mfd'] and $pr_expd==$arr['expd'])
                      $sold+=$arr['quantity'];
                  }

                  $tbuy+=$buy;
                  $tsold+=$sold;


                  //Detail Finds
                  if($find = mysqli_query($mysqli, "SELECT * From products where id=$productid "))
                    while($arr = mysqli_fetch_array($find)){
                      $pr_name = $arr['name'];
                      $pr_brand = $arr['brand'];
                      $pr_type = $arr['type'];
                      $pr_hsn= $arr['hsn'];
                      $pr_gst= $arr['gst'];
                      $pr_unit= $arr['unit'];
                  }

                  $print=" ";
                  if ($pr_sellprice==$p_sellprice) {
                    $print="selected";
                  }

                  $datediff = round((time() - strtotime("$pr_expd")) / (60 * 60 * 24));

                  if ($buy==$sold and $datediff>7) {
                    continue;
                  }

                  echo '<option value="'.$purid.'" '.$print.'>'.$pr_name.' - '.$pr_type.' | ₹'.$pr_sellprice.' | '.$pr_mfd.' - '.$pr_expd.' | Rem:  '.($buy-$sold).'</option>';
                }

                $stock=$tbuy-$tsold+$p_qty;
                $stock=number_format($stock, 2);
                ?>

              </select>
            </div>

            <div class="col-md-2">
              <label>In Stock (in <?php echo $p_unit; ?>)</label>
                <input class="form-control" type="number" value="<?php echo $stock; ?>" disabled>
            </div>

            <div class="col-md-2">
              <label>Sell Qty (in <?php echo $p_unit; ?>)</label>
              <?php if ($p_type=='Packed') {  ?>
                <input class="form-control" type="number" step="1.0" name="quantity" max="<?php echo $stock; ?>" value="<?php echo $p_qty; ?>" required>
              <?php } else { ?>
                <input class="form-control" type="number" step="0.01" name="quantity" max="<?php echo $stock; ?>" value="<?php echo $p_qty; ?>" required>
              <?php }  ?>

            </div>

            <div class="col-md-2 pt-2">
              <br>
              <button class="btn btn-primary btn-md" type="submit" name="action" value="salesitemupdate">Update</buton>
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
    <i class="fa fa-table"></i> Sales Item Listing</div>
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
            <th>Sell </th>
            <th>Total</th>
            <th>Unit</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $c=0;
          $tqty=0;
          $tsell=0;
          if($result = mysqli_query($mysqli, "SELECT * From solditems where salesid=$salesid"))
        	while($res = mysqli_fetch_array($result)){

            //initialisation
            $salesid=$res['salesid'];
            $productid=$res['productid'];



            $mrp=$res['mrp'];
            $sellprice=$res['sellprice'];
            $quantity=$res['quantity'];
            $tqty+=$quantity;
            $tsell+=$quantity*$sellprice;


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
            echo '<td><p><b>'.$quantity.'</b></p></td>';
            echo '<td><p>'.$mrp.'</p></td>';
            echo '<td><p>'.$sellprice.'</p></td>';
            echo '<td><p><b>'.($quantity*$sellprice).'</b></p></td>';
            echo '<td><p>'.$unit.'</p></td>';

            echo '<td><p>';
            echo '<a href="sale-items.php?id='.$salesid.'&itemid='.$res['id'].'&action=edititem" data-toggle="tooltip" data-placement="top" title="Edit Item"><i class="fa fa-pencil" style="color:green;"></i></a>';
            echo '&nbsp;&nbsp;&nbsp;';
            echo '<a href="sale-items.php?id='.$salesid.'&itemid='.$res['id'].'&action=deleteitem" data-toggle="tooltip" data-placement="top" title="Remove Item"><i class="fa fa-remove" style="color:red;"></i></a>';
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
            <th><?php echo $tsell; ?></th>
            <th></th>
            <th><a href="sale-items.php?id=<?php echo $salesid; ?>&action=submit" data-toggle="tooltip" data-placement="top" title="Submit and Pay">Pay</a></th>
          </tr>
        </tfoot>


      </table>
    </div>
  </div>
  <div class="card-footer small text-muted">Updated few minutes ago.</div>
</div>
