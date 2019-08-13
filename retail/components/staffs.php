<!-- Breadcrumbs-->
<ol class="breadcrumb">
  <li>Management &nbsp; :</li>
  <li> &nbsp; <a href="products.php">Products</a></li>
  <li> &nbsp; <a href="outlets.php">Outlets</a></li>
  <li> &nbsp; <a href="warehouse.php">Warehouse</a></li>
  <li> &nbsp; Staffs</li>
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
            <th>Id</th>
            <th>Name</th>
            <th>Contact</th>
            <th>Usertype</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tfoot>
          <tr>
            <th><a data-toggle="modal" data-target="#add-staff" class="text-success">Add Staff</a></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
          </tr>
        </tfoot>
        <tbody>
          <?php
          if($result = mysqli_query($mysqli, "SELECT * From staffs"))
        	while($res = mysqli_fetch_array($result)){

            //status print
            if ($res['status']==1) {
              $status="Active";
            } else {
              $status="Inactive";
            }

            echo '<tr>';
            echo '<td><p class="mb-0" data-toggle="tooltip" data-placement="top" title="Joined: '.$res['doj'].'">'.$res['id'].'</p></td>';
            echo '<td><p class="mb-0" data-toggle="tooltip" data-placement="top" title="Aadhar: '.$res['aadhar'].'">'.$res['name'].'</p></td>';
            echo '<td><p class="mb-0" data-toggle="tooltip" data-placement="top" title="Address: '.$res['address'].'">'.$res['cno'].'</p></td>';
            echo '<td><p class="mb-0">'.$res['usertype'].'</p></td>';
            echo '<td><p class="mb-0" data-toggle="tooltip" data-placement="top" title="'.$res['dol'].'">'.$status.'</p></td>';
            echo '<td><p>';
            echo '<a href="edit-staff.php?id='.$res['id'].'" data-toggle="tooltip" data-placement="top" title="Edit Staff"><i class="fa fa-pencil" style="color:red;"></i></a>&nbsp;';
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
