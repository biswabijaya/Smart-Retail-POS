<!-- Breadcrumbs-->
<ol class="breadcrumb">
  <li class="breadcrumb-item">
    <a href="dashboard.php">Shanti Fresh</a>
  </li>
  <li class="breadcrumb-item active">Supplier Management</li>
</ol>
<!-- Example DataTables Card-->
<div class="card mb-3">
  <div class="card-header">
    <i class="fa fa-table"></i> Distributer Details and Report</div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Contact</th>
            <th>Supply Items</th>
            <th>Supplied</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tfoot>
          <tr>
            <th><a data-toggle="modal" data-target="#add-supplier" class="text-success">Add Supplier</a></th>
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
          if($result = mysqli_query($mysqli, "SELECT * From suppliers order by name asc"))
        	while($res = mysqli_fetch_array($result)){

            //initialisation
            $supplierid=$res['id'];
            $textcolor="";
            $parray = array();
            $procount=$qtycount=0;

            //status print
            if ($res['status']==1) {
              $status="Active";
            } else {
              $status="Inactive";
            }

            //purchase calculation
            if($find = mysqli_query($mysqli, "SELECT * From products where supplier=$supplierid"))
          	while($arr = mysqli_fetch_array($find)){
              $productid=$arr['id'];
              $parray[$procount][$qtycount]=$arr['name'];
              $qtycount++;
              if($find1 = mysqli_query($mysqli, "SELECT * From purchases where supplierid=$supplierid "))
            	while($arr1 = mysqli_fetch_array($find1)){
                $purchaseid=$arr1['id'];
                if($find2 = mysqli_query($mysqli, "SELECT * From purchaseditems where purchaseid=$purchaseid and productid=$productid "))
              	while($arr2 = mysqli_fetch_array($find2)){
                $parray[$procount][$qtycount]+=$arr2['quantity'];
              }
            }$procount++;$qtycount=0;
          }

          for ($i=0; $i < $procount ; $i++) {
            $qtycount+=$parray[$i][1];
          }

            echo '<tr>';
            echo '<td><p class="mb-0" data-toggle="tooltip" data-placement="top" title="Joined: '.$res['doj'].'">'.$res['id'].'</p></td>';
            echo '<td><p class="mb-0" data-toggle="tooltip" data-placement="top" title="GSTIN: '.$res['gstin'].'">'.$res['name'].'</p></td>';
            echo '<td><p class="mb-0" data-toggle="tooltip" data-placement="top" title="Address: '.$res['sddress'].'">'.$res['cno'].'</p></td>';
            echo '<td><p class="mb-0">'.$procount.'</p></td>';
            echo '<td><p class="mb-0">'.$qtycount.'</p></td>';
            echo '<td><p class="mb-0" data-toggle="tooltip" data-placement="top" title="'.$res['dol'].'">'.$status.'</p></td>';
            echo '<td><p>';
            echo '<a href="supplier.php?id='.$res['id'].'&action=view" data-toggle="tooltip" data-placement="top" title="View Supplier Details"><i class="fa fa-search" style="color:green;"></i></a>&nbsp;';
            echo '<a href="supplier.php?id='.$res['id'].'&action=edit" data-toggle="tooltip" data-placement="top" title="Edit Supplier Data"><i class="fa fa-pencil" style="color:purple;"></i></a>&nbsp;';
            echo '<a href="report-supplier.php?id='.$res['id'].'" data-toggle="tooltip" data-placement="top" title="Detailed Purchase Report"><i class="fa fa-shopping-cart" style="color:orange;"></i></a>&nbsp;';
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
