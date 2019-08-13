<!-- Breadcrumbs-->
<ol class="breadcrumb">
  <li>Management &nbsp; :</li>
  <li> &nbsp; Products</li>
  <li> &nbsp; <a href="outlets.php">Outlets</a></li>
  <li> &nbsp; <a href="warehouse.php">Warehouse</a></li>
  <li> &nbsp; <a href="staffs.php">Staffs</a></li>
  <li> &nbsp; <a href="hsn.php">HSN</a></li>
  <li> &nbsp; <a href="offers.php">Offers</a></li>
</ol>
<!-- Example DataTables Card-->
<div class="card mb-3">
  <div class="card-header">
    <i class="fa fa-table"></i> Product Inventory Listing</div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th>Name</th>
            <th>Brand</th>
            <th>Category</th>
            <th>Sub-Cat</th>
            <th>Stock</th>
            <th>MRP</th>
            <th>Sell Price</th>
            <th>Action</th>
          </tr>
        </thead>
        <tfoot>
          <tr>
            <th><a data-toggle="modal" data-target="#add-product" class="text-success">Add Product</a></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
          </tr>
        </tfoot>
        <tbody>
          <?php
          if($result = mysqli_query($mysqli, "SELECT * From products"))
        	while($res = mysqli_fetch_array($result)){

            $productid=$res['id'];
            $purchasestock=0;
            $salestock=0;

            if($find = mysqli_query($mysqli, "SELECT * From purchaseditems where productid=$productid"))
          	while($arr = mysqli_fetch_array($find))
            $purchasestock+=$arr['quantity'];

            if($find = mysqli_query($mysqli, "SELECT * From solditems where productid=$productid"))
          	while($arr = mysqli_fetch_array($find))
            $salestock+=$arr['quantity'];

            $stock=($purchasestock-$salestock);

            if ($stock<=3) {
              $textcolor="text-danger";
            } else if ($stock<=7) {
              $textcolor="text-warning";
            } else {
              $textcolor=" ";
            }


            echo '<tr>';
            echo '<td><p class="'.$textcolor.'">'.$res['name'].'</p></td>';
            echo '<td><p class="'.$textcolor.'">'.$res['brand'].'</p></td>';
            echo '<td><p class="'.$textcolor.'">'.$res['category'].'</p></td>';
            echo '<td><p class="'.$textcolor.'">'.$res['subcategory'].'</p></td>';
            echo '<td><p class="'.$textcolor.'">'.$stock.'</p></td>';
            echo '<td><p class="'.$textcolor.'">'.money_format('%!i', $res['mrp']).'/'.$res['unit'].'</p></td>';
            echo '<td><p class="'.$textcolor.'" data-toggle="tooltip" data-placement="top" title="Buy: '.money_format('%!i', $res['buyprice']).'">'.money_format('%!i', $res['sellprice']).'/'.$res['unit'].'</p></td>';
            echo '<td><p>';
            echo '<a href="edit-product?id='.$res['id'].'" data-toggle="tooltip" data-placement="top" title="Edit Product"><i class="fa fa-pencil" style="color:red;"></i></a>&nbsp;';
            echo '<a href="buy-product?id='.$res['id'].'" data-toggle="tooltip" data-placement="top" title="'.$purchasestock.'"><i class="fa fa-arrow-down" style="color:orange;"></i></a>&nbsp;';
            echo '<a href="sell-product?id='.$res['id'].'" data-toggle="tooltip" data-placement="top" title="'.$salestock.'"><i class="fa fa-arrow-up" style="color:green;"></i></a>';
            echo '</p></td>';
            echo '</tr>';

          }

           ?>
        </tbody>
      </table>
    </div>
  </div>
  <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
</div>
