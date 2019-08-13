<?php
   include 'components/filtersort-'.$page.'.php';
?>

<div class="card mb-3">
  <div class="card-header">
   <b><a data-toggle="modal" data-target="#add-purchase" class="text-success">New Purchase</a></b>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th>Sr.</th>
            <th>Date</th>
            <th>Pur. ID</th>
            <th>Staff ID</th>
            <th>Supplier</th>
            <th>Items</th>
            <th>Amount</th>
            <th>Paid</th>
            <th>St.</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $crow=$tqtyt=$tbuyt=$tpayble=0;
          if($result = mysqli_query($mysqli, "SELECT * From purchases where (date between '$fromdate' and '$todate') $customsql order by id DESC"))
        	while($res = mysqli_fetch_array($result)){

            //initialisation
            $purchaseid=$res['id'];
            $staffid=$res['staffid'];
            $supplierid=$res['supplierid'];
            $billno=$res['billno'];
            $date=$res['date'];
            $status=$res['status'];

            $tqty=$tbuy=$payble=0;
            if($find = mysqli_query($mysqli, "SELECT * From purchaseditems where purchaseid=$purchaseid"))
          	while($arr = mysqli_fetch_array($find)){
              $tqty++;
              $tbuy+=$arr['quantity']*$arr['buyprice'];
            }

            if($find = mysqli_query($mysqli, "SELECT * From purchasepayments where purchaseid=$purchaseid"))
            while($arr = mysqli_fetch_array($find)){
              $payble+=$arr['amount'];
            }

            //Name Finds
            if($find = mysqli_query($mysqli, "SELECT * From suppliers where id=$supplierid "))
              while($arr = mysqli_fetch_array($find)){
                $suppliername=$arr['name'];
            }
            if($find = mysqli_query($mysqli, "SELECT * From staffs where id=$staffid "))
              while($arr = mysqli_fetch_array($find)){
                $staffname=$arr['name'];
            }

            $tqtyt+=$tqty;
            $tbuyt+=$tbuy;

            echo '<tr>';
            echo '<td><p class="mb-0">'.++$crow.'</p></td>';
            echo '<td><p class="mb-0">'.$date.'</p></td>';
            echo '<td><p class="mb-0">'.$purchaseid.'</p></td>';
            echo '<td><p class="mb-0">'.$staffname.'</p></td>';
            echo '<td><p class="mb-0">'.$suppliername.'</p></td>';
            echo '<td><p class="mb-0">'.money_format('%!i', $tqty).'</p></td>';
            echo '<td><p class="mb-0">'.money_format('%!i', $tbuy).'</p></td>';
            echo '<td><p data-toggle="tooltip" data-placement="top" title="Discount:'.($tbuy-$payble).'">'.money_format('%!i', $payble).'</p></td>';
            if ($res['status']==0) {
              echo '<td><p class="text-danger">Not Submitted</p></td>';
            } else if ($res['status']==1) {
              echo '<td><p class="text-warning">Submitted</p></td>';
            } else if ($res['status']==2) {
              echo '<td><p class="text-success">Paid</p></td>';
            }
            echo '<td><p class="mb-0">';
            
            if(file_exists("assets/images/purchasebills/$purchaseid.jpg")){
              echo '<a target="_blank"  href="assets/images/purchasebills?name='.$purchaseid.'&format=jpg&width=500&height=750" data-toggle="tooltip" data-placement="top" title="View Bill"><i class="fa fa-list-alt" style="color:indigo;"></i></a>&nbsp;';
            } else {
              echo '<a target="_blank"  href="assets/images/purchasebills?name='.$purchaseid.'&format=jpg&width=500&height=750" data-toggle="tooltip" data-placement="top" title="Upload Bill"><i class="fa fa-list-alt" style="color:darkred;"></i></a>&nbsp;';
            }
            
            if ($res['status']==0) {
              echo '<a target="_blank"  href="purchase-items.php?id='.$res['id'].'&action=add" data-toggle="tooltip" data-placement="top" title="Add/Edit Items"><i class="fa fa-pencil" style="color:green;"></i></a>&nbsp;';
              echo '<a target="_blank"  href="purchases.php?id='.$res['id'].'&action=cancelpurchase" data-toggle="tooltip" data-placement="top" title="Cancel Purchase"><i class="fa fa-remove" style="color:red;"></i></a>';
            } else if ($res['status']==1) {
              echo '<a target="_blank"  href="payment.php?id='.$res['id'].'&type=purchasepayments" data-toggle="tooltip" data-placement="top" title="Enter Payment Details"><i class="fa fa-money" style="color:purple;"></i></a>';
            }
            if ($_SESSION['usertype']=='admin') {
              if ($res['status']>=1) {
                echo '<a target="_blank"  href="purchase-items-editsellprice.php?id='.$res['id'].'" data-toggle="tooltip" data-placement="top" title="Edit Sell Price"><i class="fa fa-pencil" style="color:orange;"></i></a>&nbsp;';
              }
              echo '<a target="_blank"  href="purchase-items-editmfd.php?id='.$res['id'].'" data-toggle="tooltip" data-placement="top" title="Edit MFD EXP"><i class="fa fa-clock-o" style="color:green;"></i></a>&nbsp;';

              echo '<a target="_blank"  href="purchase-bill.php?id='.$res['id'].'" data-toggle="tooltip" data-placement="top" title="View/Print Bill"><i class="fa fa-search" style="color:blue;"></i></a>&nbsp;';
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
            <th><a data-toggle="modal" data-target="#add-purchase" class="text-success">New Purchase</a></th>
            <th></th>
            <th></th>
            <th></th>
            <th> <b><?php echo money_format('%!i', $tqtyt); ?></b> </th>
            <th> <b><?php echo money_format('%!i', $tbuyt); ?></b> </th>
            <th> <b><?php echo money_format('%!i', $tpayble); ?></b> </th>
            <th></th>
            <th></th>
          </tr>
        </tfoot>


      </table>
    </div>
  </div>
  <div class="card-footer small text-muted">Updated few minutes ago.</div>
</div>



<div class="row mb-4">
  <div class="col-md-4">
    <div class="card bg-light">
      <div class="card-header">
        Billed Amount
      </div>
      <div class="card-body">
          <input type="readonly" class="form-control" name="action" value="<?php echo money_format('%!i', $tbuyt); ?>">
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card bg-light">
      <div class="card-header">
        Unpaid/Rounded
      </div>
      <div class="card-body">
          <input type="readonly" class="form-control" name="action" value="<?php echo money_format('%!i', $tbuyt-$tpayble); ?>">
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card bg-light">
      <div class="card-header">
        Paid Amount
      </div>
      <div class="card-body">
          <input type="readonly" class="form-control" name="action" value="<?php echo money_format('%!i', $tpayble); ?>">
      </div>
    </div>
  </div>
</div>
