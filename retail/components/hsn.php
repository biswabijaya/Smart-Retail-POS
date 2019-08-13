<!-- Breadcrumbs-->
<ol class="breadcrumb">
  <li>Free HSN Search Database </li>
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
            <th>HSN Code</th>
            <th>Descriptiov</th>
            <th>SGST</th>
            <th>CGST</th>
            <th>IGST</th>
            <th>Condition</th>
          </tr>
        </thead>
        <tfoot>
          <tr>
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
          $textcolor=" ";
          if($result = mysqli_query($mysqli, "SELECT * From hsn"))
        	while($res = mysqli_fetch_array($result)){

            echo '<tr>';
            echo '<td><p class="'.$textcolor.'">'.$res['hsncode'].'</p></td>';
            echo '<td><p class="'.$textcolor.'">'.$res['description'].'</p></td>';
            echo '<td><p class="'.$textcolor.'">'.($res['rate']/2).'</p></td>';
            echo '<td><p class="'.$textcolor.'">'.($res['rate']/2).'</p></td>';
            echo '<td><p class="'.$textcolor.'">'.$res['rate'].'</p></td>';
            echo '<td><p class="'.$textcolor.'">'.$res['condition'].'</p></td>';
            echo '</tr>';

          }

           ?>
        </tbody>
      </table>
    </div>
  </div>
  <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
</div>
