<!-- Breadcrumbs-->
<ol class="breadcrumb">
  <li class="breadcrumb-item">
    <a href="dashboard.php">Shanti Fresh</a>
  </li>
  <li class="breadcrumb-item active">Store Management </li>
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
            <th>Store Code</th>
            <th>Name</th>
            <th>Type</th>
            <th>Manager</th>
            <th>Locality</th>
            <th>City</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tfoot>
          <tr>
            <th><a data-toggle="modal" data-target="#add-store" class="text-success">Add Store</a></th>
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
          if($result = mysqli_query($mysqli, "SELECT * From stores"))
        	while($res = mysqli_fetch_array($result)){

            //initialisation
            $storeid=$res['id'];
            $$managerid=$res['manager'];
            $textcolor="";
            $managername="Not Set";

            //status print
            if ($res['status']==1) {
              $status="Active";
            } else {
              $status="Inactive";
            }

            //find manager name
            if($find = mysqli_query($mysqli, "SELECT * From staffs where id=$managerid"))
          	while($arr = mysqli_fetch_array($find)){
              $$managername=$arr['name'];
            }

            //store sales calculation
            $salestoday=$salesthismonth=$salesthisyear=0;


            echo '<tr>';
            echo '<td><p class="mb-0">'.$res['id'].'</p></td>';
            echo '<td><p class="mb-0">'.$res['name'].'</p></td>';
            echo '<td><p class="mb-0">'.$res['type'].'</p></td>';
            echo '<td><p class="mb-0" data-toggle="tooltip" data-placement="top" title="Staff ID: '.$$managerid.'">'.$managername.'</p></td>';
            echo '<td><p class="mb-0" data-toggle="tooltip" data-placement="top" title="PIN: '.$res['pin'].'">'.$res['locality'].'</p></td>';
            echo '<td><p class="mb-0" data-toggle="tooltip" data-placement="top" title="Contact: '.$res['cno'].'">'.$res['city'].'</p></td>';
            echo '<td><p class="mb-0">'.$status.'</p></td>';
            echo '<td><p>';
            echo '<a href="store.php?id='.$res['id'].'&action=view" data-toggle="tooltip" data-placement="top" title="View store Details"><i class="fa fa-search" style="color:green;"></i></a>&nbsp;';
            echo '<a href="store.php?id='.$res['id'].'&action=edit" data-toggle="tooltip" data-placement="top" title="Edit store Data"><i class="fa fa-pencil" style="color:purple;"></i></a>&nbsp;';
            echo '<a href="report-store.php?id='.$res['id'].'" data-toggle="tooltip" data-placement="top" title="Detailed Store Report"><i class="fa fa-shopping-cart" style="color:orange;"></i></a>&nbsp;';
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
