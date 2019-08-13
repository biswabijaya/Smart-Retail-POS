
<!-- Breadcrumbs-->
<ol class="breadcrumb">
  <li class="breadcrumb-item">
    <a href="dashboard.php">Shanti Fresh</a>
  </li>
  <li class="breadcrumb-item">
    <a href="dashboard.php">Products</a>
  </li>
  <li class="breadcrumb-item active">Report -
    <?php
    if($result = mysqli_query($mysqli, "SELECT * From products where id=$id"))
    while($res = mysqli_fetch_array($result)){
      echo $res['name']."  -  [".$res['brand']."]  -  ".$res['category']."/".$res['subcategory'];
    }
    ?>
  </li>
</ol>

<div class="row">
  <div class="col-md-6">
    <div class="card bg-light mx-auto mt-3">
      <div class="card-header">Purchased</div>
      <div class="card-body">
        <div class="table-responsive">

            <table class="table">
              <thead>
                <th>Sr.</th>
                <th>Pur. ID</th>
                <th>By/From</th>
                <th>QTY</th>
                <th>Action</th>
              </thead>
              <tbody>
                <?php
                $c=$ptotal=0;
                if($result = mysqli_query($mysqli, "SELECT purchaseid,staffid,supplierid,type,date,mrp,quantity,buyprice,sellprice,status From purchases t1, purchaseditems t2 where t1.id=t2.purchaseid and t2.productid=$id order by t2.purchaseid desc"))
                while($res = mysqli_fetch_array($result)){

                  $purchaseid=$res['purchaseid'];
                  $staffid=$res['staffid'];
                  $supplierid=$res['supplierid'];
                  $buyprice=$res['buyprice'];
                  $sellprice=$res['sellprice'];
                  $mrp=$res['mrp'];

                  //Name Finds
                  if($find = mysqli_query($mysqli, "SELECT * From suppliers where id=$supplierid "))
                    while($arr = mysqli_fetch_array($find)){
                      $suppliername=$arr['name'];
                  }
                  if($find = mysqli_query($mysqli, "SELECT * From staffs where id=$staffid "))
                    while($arr = mysqli_fetch_array($find)){
                      $staffname=$arr['name'];
                  }

                  if ($res['status']==0) {
                    $status="Draft";
                  } else if ($res['status']==1) {
                    $status="Unpaid";
                  } else if ($res['status']==2) {
                    $status="Paid";
                  }
                  echo '<tr>';
                  echo '<td><p data-toggle="tooltip" data-placement="top" title="'.$status.'">'.++$c.'</p></td>';
                  echo '<td><p data-toggle="tooltip" data-placement="top" title="'.$res['date'].'">'.$res['purchaseid'].'</p></td>';
                  echo '<td><p data-toggle="tooltip" data-placement="top" title="'.$suppliername.'">'.$staffname.'</p></td>';
                  echo '<td><p data-toggle="tooltip" data-placement="top" title="Buy:'.$res['buyprice'].' | Sell:'.$res['sellprice'].'">'.$res['quantity'].'</p></td>';
                  echo '<td><p>';
                  echo '<a href="purchase-bill.php?id='.$res['purchaseid'].'&action=view" data-toggle="tooltip" data-placement="top" title="View Items"><i class="fa fa-search" style="color:blue;"></i></a>&nbsp;';
                  echo '</p></td>';
                  echo '</tr>';
                  $ptotal+=$res['quantity'];
                }
                ?>
              </tbody>
              <tfoot>
                <th>Sr.</th>
                <th>Pur. ID</th>
                <th>By/From</th>
                <th><?php echo $ptotal; ?></th>
                <th>Action</th>
              </tfoot>
            </table>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="card bg-light mx-auto mt-3">
      <div class="card-header">Sold</div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table">
            <thead>
              <th>Sr.</th>
              <th>Sell. ID</th>
              <th>By/To</th>
              <th>QTY</th>
              <th>Action</th>
            </thead>
            <tbody>
              <?php
              $c=$stotal=0;
              if($result = mysqli_query($mysqli, "SELECT salesid,staffid,storecode,cno,date,quantity,mrp,sellprice,status From sales t1, solditems t2 where t1.id=t2.salesid and t2.productid=$id order by t2.salesid desc"))
              while($res = mysqli_fetch_array($result)){

                $salesid=$res['salesid'];
                $staffid=$res['staffid'];
                $cno=$res['cno'];
                $mrp=$res['mrp'];

                //Name Finds
                if($find = mysqli_query($mysqli, "SELECT * From staffs where id=$staffid "))
                  while($arr = mysqli_fetch_array($find)){
                    $staffname=$arr['name'];
                }

                if ($res['status']==0) {
                  $status="Draft";
                } else if ($res['status']==1) {
                  $status="Unpaid";
                } else if ($res['status']==2) {
                  $status="Paid";
                }
                echo '<tr>';
                echo '<td><p data-toggle="tooltip" data-placement="top" title="'.$status.'">'.++$c.'</p></td>';
                echo '<td><p data-toggle="tooltip" data-placement="top" title="'.$res['date'].'">'.$res['salesid'].'</p></td>';
                echo '<td><p data-toggle="tooltip" data-placement="top" title="'.$cno.'">'.$staffname.'</p></td>';
                echo '<td><p data-toggle="tooltip" data-placement="top" title="MRP:'.$res['mrp'].' | Sell:'.$res['sellprice'].'">'.$res['quantity'].'</p></td>';
                echo '<td><p>';
                echo '<a href="invoice.php?id='.$res['salesid'].'&action=view" data-toggle="tooltip" data-placement="top" title="View Invoice"><i class="fa fa-search" style="color:blue;"></i></a>&nbsp;';
                echo '</p></td>';
                echo '</tr>';
                $stotal+=$res['quantity'];
              }
              ?>
            </tbody>
            <tfoot>
              <th>Sr.</th>
              <th>Sell. ID</th>
              <th>By/To</th>
              <th><?php echo $stotal; ?></th>
              <th>Action</th>
            </tfoot>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="col-md-12">
  <div class="card bg-light mx-auto mt-3">
    <div class="card-header">Overall</div>
    <div class="card-body">
      <div class="table-responsive">

          <table class="table">
            <thead>
              <th>Buy</th>
              <th>Sell</th>
              <th>Rem</th>
              <th>MRP</th>
              <th>Invested</th>
              <th>Sales</th>
              <th>Profit</th>
            </thead>
            <tbody>
              <tr>
                <td><?php echo $ptotal; ?></td>
                <td><?php echo $stotal; ?></td>
                <td><?php echo number_format(($ptotal-$stotal), 2); ?></td>
                <td><?php echo $mrp; ?></td>
                <td><?php echo $buyprice*$ptotal; ?></td>
                <td><?php echo $sellprice*$stotal; ?></td>
                <td><?php echo ($sellprice*$stotal)-($buyprice*$ptotal); ?></td>
              </tr>
            </tbody>
            <tfoot>
              <th>Buy</th>
              <th>Sell</th>
              <th>Rem</th>
              <th>MRP</th>
              <th>Invested</th>
              <th>Sales</th>
              <th>Profit</th>
            </tfoot>
          </table>
      </div>
    </div>
  </div>
</div>
<br>
