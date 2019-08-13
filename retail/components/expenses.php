<!-- Breadcrumbs-->
<ol class="breadcrumb">
  <li class="breadcrumb-item">
    <a href="dashboard.php">Shanti Fresh</a>
  </li>
  <li class="breadcrumb-item active">Vouchers</li>
</ol>

<?php
   include 'components/filtersort-'.$page.'.php';
?>
<!-- Example DataTables Card-->
<div class="card mb-3">
  <div class="card-header">
    <i class="fa fa-table"></i>Expense Vouchers</div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th>ID</th>
            <th>Issue-Date</th>
            <th>Staff</th>
            <th>Store</th>
            <th>Name</th>
            <th>Category</th>
            <th>Subcat.</th>
            <th>Amount</th>
            <th>Mode</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $vouchered=$unpaid=$paid=0;
          if($result = mysqli_query($mysqli, "SELECT * From vouchers where (date between '$fromdate' and '$todate') $customsql order by id ASC"))
        	while($res = mysqli_fetch_array($result)){

            //initialisation
            $voucherid=$res['id'];
            $staffid=$res['staffid'];
            $storecode=$res['storecode'];
            $name=$res['name'];
            $category=$res['category'];
            $subcategory=$res['subcategory'];
            $vouchered+=$amount=$res['amount'];
            $details=$res['details'];
            $date=$res['date'];

            $paidamount=0;
            $paidto=" ";
            $mode="-";
            $modedetails="Unpaid";
            $textcolor="text-danger";


            //get payment status
            if($find = mysqli_query($mysqli, "SELECT * From expense where payid=$voucherid"))
            while($arr = mysqli_fetch_array($find)){
              $paidamount=$arr['amount'];
              $paidto=$arr['paidto'];
              $textcolor="text-success";
              $mode=$arr['mode'];
              $modedetails=$arr['modedetails'];
            }

            //mode filter
            if (isset($_GET['mode'])) {
              if ($mode!=$_GET['mode']) {
                continue;
              }
            }

            //mode filter
            if (($_SESSION['usertype']!='admin') and ($staffid!=$_SESSION['id'])) {
                continue;
            }


            //get store name
            if($find = mysqli_query($mysqli, "SELECT * From stores where id=$storecode"))
          	while($arr = mysqli_fetch_array($find))
              $storename=$arr['name'];


            //get staff name
            if($find = mysqli_query($mysqli, "SELECT * From staffs where id=$staffid"))
          	while($arr = mysqli_fetch_array($find))
              $staffname=$arr['name'];

            echo '<tr>';
            echo '<td><p>'.$voucherid.'</p></td>';
            echo '<td><p>'.$date.'</p></td>';
            echo '<td><p data-toggle="tooltip" data-placement="top" title="'.$staffname.'">'.$staffid.'</p></td>';
            echo '<td><p data-toggle="tooltip" data-placement="top" title="'.$storename.'">'.$storecode.'</p></td>';
            echo '<td><p data-toggle="tooltip" data-placement="top" title="'.$details.'">'.$name.'</p></td>';
            echo '<td><p>'.$category.'</p></td>';
            echo '<td><p>'.$subcategory.'</p></td>';
            echo '<td><p class="'.$textcolor.'" data-toggle="tooltip" data-placement="top" title="Paid to - '.$paidto.'">'.money_format('%!i', $amount).'</p></td>';
            echo '<td><p class="'.$textcolor.'" data-toggle="tooltip" data-placement="top" title="'.$modedetails.'">'.$mode.'</p></td>';

            echo '<td><p>';
            if ($_SESSION['usertype']=='admin') {
              if ($paidamount==0) {
                echo '<a target="_blank" href="payment-voucher.php?id='.$res['id'].'" data-toggle="tooltip" data-placement="top" title="Pay Voucher"><i class="fa fa-money" style="color:purple;"></i></a>';
                echo '&nbsp;&nbsp;&nbsp;';
                $unpaid+=$amount;
              }
              echo '<a target="_blank"  href="edit-voucher.php?id='.$res['id'].'" data-toggle="tooltip" data-placement="top" title="Edit Voucher"><i class="fa fa-edit" style="color:orange;"></i></a>';
              echo '&nbsp;&nbsp;&nbsp;';
            }
            echo '<a target="_blank"  href="invoice.php?id='.$res['id'].'&action=view" data-toggle="tooltip" data-placement="top" title="View/Print Invoice"><i class="fa fa-search" style="color:green;"></i></a>';

            echo '</p></td>';
            echo '</tr>';

          }
          $paid=$vouchered-$unpaid;
           ?>
        </tbody>
        <tfoot>
          <tr>
            <th></th>
            <th><a data-toggle="modal" data-target="#add-voucher" class="text-success">Add Voucher</a></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
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
        Vouchered Amount
      </div>
      <div class="card-body">
          <input type="readonly" class="form-control" name="action" value="<?php echo money_format('%!i', $vouchered); ?>">
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card bg-light">
      <div class="card-header">
        Unpaid Amount
      </div>
      <div class="card-body">
          <input type="readonly" class="form-control" name="action" value="<?php echo money_format('%!i', $unpaid); ?>">
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card bg-light">
      <div class="card-header">
        Paid Amount
      </div>
      <div class="card-body">
          <input type="readonly" class="form-control" name="action" value="<?php echo money_format('%!i', $paid); ?>">
      </div>
    </div>
  </div>
</div>
