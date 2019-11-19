<!-- Breadcrumbs-->
<ol class="breadcrumb">
  <li class="breadcrumb-item">
    <a href="dashboard.php">Smart Retail POS</a>
  </li>
  <li class="breadcrumb-item active">Sales </li>
</ol>

<?php
   include 'components/filtersort-'.$page.'.php';
?>
<!-- Example DataTables Card-->
<div class="card mb-3">
  <div class="card-header">
    <div class="row">
      <div class="col-md-4">
        <div class="text-left">
          <b><a data-toggle="modal" data-target="#add-sales" class="text-success">New Order</a></b>
        </div>
      </div>
      <?php if ($_SESSION['usertype']=='admin'): ?>
        <div class="col-md-8">
          <div class="text-right">
            <label class="custom-label">
              <div class="custom-toggle">
                <input class="custom-toggle-state" type="checkbox" id="summarytoogle" onchange="detailstoogle();" unchecked >
                <div class="custom-toggle-inner">
                   <div class="custom-indicator"></div>
                </div>
                <div class="custom-active-bg"></div>
              </div>
              <div class="custom-label-text">Summary</div>
            </label>
          </div>
        </div>
      <?php endif; ?>
    </div>
  </div>
  <div id="details" class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered" id="dataTable1" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th>Sr.</th>
            <th>Sale-Date</th>
            <th>Inv</th>
            <th>Store</th>
            <th>Biller</th>
            <th>Customer</th>
            <th>Items</th>
            <th>Total</th>
            <th>Paid</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $crow=$tqty=$tsale=$tpayble=$discounted=0;
          if($result = mysqli_query($mysqli, "SELECT * From sales where (date between '$fromdate' and '$todate') $customsql order by id DESC"))
        	while($res = mysqli_fetch_array($result)){

            $payble=0;

            //initialisation
            $saleid=$res['id'];
            $staffid=$res['staffid'];
            $storecode=$res['storecode'];
            $cno=$res['cno'];
            $date=$res['date'];
            $itemcount=0;
            $billprice=0;
            $paid=0;

            $discounted+=$res['discvalue'];

            if($find = mysqli_query($mysqli, "SELECT * From salepayments where salesid=$saleid"))
            while($arr = mysqli_fetch_array($find)){
              $payble+=$arr['amount'];
            }

            if($find = mysqli_query($mysqli, "SELECT * From solditems where salesid=$saleid"))
          	while($arr = mysqli_fetch_array($find)){
              $itemcount++;
              $billprice+=$arr['sellprice']*$arr['quantity'];
            }

            if($find = mysqli_query($mysqli, "SELECT * From salepayments where salesid=$saleid"))
          	while($arr = mysqli_fetch_array($find)){
              $paid=1;
            }


            if($find = mysqli_query($mysqli, "SELECT * From staffs where id=$staffid"))
          	while($arr = mysqli_fetch_array($find))
              $staffname=$arr['name'];

            if($find = mysqli_query($mysqli, "SELECT * From stores where id=$storecode"))
          	while($arr = mysqli_fetch_array($find))
              $storename=$arr['name'];

            $tqty+=$itemcount;
            $tsale+=$billprice;

            echo '<tr>';
            echo '<td><p>'.++$crow.'</p></td>';
            echo '<td><p>'.$date.'</p></td>';
            echo '<td><p>'.$saleid.'</p></td>';
            echo '<td><p data-toggle="tooltip" data-placement="top" title="'.$storename.'">'.$storecode.'</p></td>';
            echo '<td><p data-toggle="tooltip" data-placement="top" title="'.$staffname.'">'.$staffid.'</p></td>';
            echo '<td><p data-toggle="tooltip" data-placement="top">'.$cno.'</p></td>';
            echo '<td><p>'.money_format('%!i', $itemcount).'</p></td>';
            echo '<td><p>'.money_format('%!i', $billprice).'</p></td>';
            echo '<td><p data-toggle="tooltip" data-placement="top" title="Discount:'.($billprice-$payble).'">'.money_format('%!i', $payble).'</p></td>';
            if ($res['status']==0) {
              echo '<td><p class="text-danger">Not Submited</p></td>';
            } else if ($res['status']==1) {
              echo '<td><p class="text-success">Unpaid</p></td>';
            } else if ($res['status']==2) {
              if (($billprice-$payble+1)<0) {
                echo '<td><p class="text-warning">OverPaid</p></td>';
              } else {
                echo '<td><p class="text-success">Paid</p></td>';
              }
            }


            echo '<td><p>';
            if ($res['status']==0) {
              echo '<a target="_blank"  href="sale-items.php?id='.$res['id'].'&action=add" data-toggle="tooltip" data-placement="top" title="Add/Edit Items"><i class="fa fa-pencil" style="color:green;"></i></a>';
              echo '&nbsp;&nbsp;&nbsp;';
              echo '<a target="_blank"  href="sales.php?id='.$res['id'].'&action=cancelorder" data-toggle="tooltip" data-placement="top" title="Cancel Order"><i class="fa fa-remove" style="color:red;"></i></a>';
            } else if ($res['status']==1) {
              echo '<a target="_blank"  href="payment.php?id='.$res['id'].'&type=salepayments" data-toggle="tooltip" data-placement="top" title="Pay Order"><i class="fa fa-money" style="color:purple;"></i></a>';
              echo '&nbsp;&nbsp;&nbsp;';
            } else if ($res['status']==2) {
              echo '<a target="_blank"  href="invoice.php?id='.$res['id'].'&action=view" data-toggle="tooltip" data-placement="top" title="View/Print Invoice"><i class="fa fa-search" style="color:purple;"></i></a>&nbsp;';
            }
            echo '</p></td>';
            echo '</tr>';

            $tpayble+=$payble;

          }

           ?>
        </tbody>
        <tfoot>
          <tr>
            <th></th>
            <th><a data-toggle="modal" data-target="#add-sales" class="text-success">New Order</a></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th> <b><?php echo money_format('%!i', $tqty); $atqty=$tqty;?></b> </th>
            <th> <b><?php echo money_format('%!i', $tsale); $atsale=$tsale;?></b> </th>
            <th> <b><?php echo money_format('%!i', $tpayble); $atpayble=$tpayble; $adiscounted=$discounted;?></b> </th>
            <th></th>
            <th></th>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>
  <div id="summary" class="card-body" style="display:none;">
    <div class="table-responsive">
      <table class="table table-bordered" id="dataTable2" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th>Date</th>
            <th>Inv Count</th>
            <th>Billed</th>
            <th>Discounted</th>
            <th>Unpaid</th>
            <th>Paid</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $date = $fromdate;  $end_date = $todate;

          while (strtotime($date) <= strtotime($end_date)) {
            $crow=$tqty=$tsale=$tpayble=$discounted=0;
            if($result = mysqli_query($mysqli, "SELECT * From sales where date='$date' $customsql order by id DESC"))
          	while($res = mysqli_fetch_array($result)){

              $payble=0;

              //initialisation
              $saleid=$res['id'];
              $staffid=$res['staffid'];
              $storecode=$res['storecode'];
              $cno=$res['cno'];
              $date=$res['date'];
              $itemcount=0;
              $billprice=0;
              $paid=0;

              $discounted+=$res['discvalue'];

              if($find = mysqli_query($mysqli, "SELECT * From salepayments where salesid=$saleid"))
              while($arr = mysqli_fetch_array($find)){
                $payble+=$arr['amount'];
              }

              if($find = mysqli_query($mysqli, "SELECT * From solditems where salesid=$saleid"))
            	while($arr = mysqli_fetch_array($find)){
                $itemcount++;
                $billprice+=$arr['sellprice']*$arr['quantity'];
              }

              if($find = mysqli_query($mysqli, "SELECT * From salepayments where salesid=$saleid"))
            	while($arr = mysqli_fetch_array($find)){
                $paid=1;
              }


              if($find = mysqli_query($mysqli, "SELECT * From staffs where id=$staffid"))
            	while($arr = mysqli_fetch_array($find))
                $staffname=$arr['name'];

              if($find = mysqli_query($mysqli, "SELECT * From stores where id=$storecode"))
            	while($arr = mysqli_fetch_array($find))
                $storename=$arr['name'];

              $tqty+=$itemcount;
              $tsale+=$billprice;
              $tpayble+=$payble;
              $crow++;

            }
            echo '<tr>';
            echo '<td><p>'.$date.'</p></td>';
            echo '<td><p>'.$crow.'</p></td>';
            echo '<td><p>'.money_format('%!i', $tsale).'</p></td>';
            echo '<td><p>'.money_format('%!i', $discounted).'</p></td>';
            echo '<td><p>'.money_format('%!i', $tsale-$tpayble-$discounted).'</p></td>';
            echo '<td><p>'.money_format('%!i', $tpayble).'</p></td>';
            echo '</tr>';
            $date = date ("Y-m-d", strtotime("+1 day", strtotime($date)));
          }
           ?>
        </tbody>
      </table>
    </div>
  </div>
  <div class="card-footer small text-muted">Updated few minutes ago.</div>
</div>


<div class="row mb-4">
  <div class="col-md-3">
    <div class="card bg-light">
      <div class="card-header">
        Billed Amount
      </div>
      <div class="card-body">
          <input type="readonly" class="form-control" name="action" value="<?php echo money_format('%!i', $atsale); ?>">
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card bg-light">
      <div class="card-header">
        Discounted Amount
      </div>
      <div class="card-body">
          <input type="readonly" class="form-control" name="action" value="<?php echo money_format('%!i', $adiscounted); ?>">
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card bg-light">
      <div class="card-header">
        Unpaid/Rounded
      </div>
      <div class="card-body">
          <input type="readonly" class="form-control" name="action" value="<?php echo money_format('%!i', $atsale-$atpayble-$adiscounted); ?>">
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card bg-light">
      <div class="card-header">
        Paid Amount
      </div>
      <div class="card-body">
          <input type="readonly" class="form-control" name="action" value="<?php echo money_format('%!i', $atpayble); ?>">
      </div>
    </div>
  </div>
</div>
