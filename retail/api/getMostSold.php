<?php
include("../shopdb.php");
if (isset($_GET['type']) and isset($_GET['date'])) {

  $type=$_GET['type'];
  $date=$_GET['date'];

  if ($type=='month') {
    $fromdate=date('Y-m-01', strtotime($date));
    $todate=date('Y-m-t', strtotime($date));
  } else if ($type=='year'){
    $fromdate=date('Y-01-01', strtotime($date));
    $todate=date('Y-12-31', strtotime($date));
  }

  $notfound=1;
  if($result = mysqli_query($mysqli, "SELECT * From mostsoldreport where fromdate='$fromdate' and todate='$todate'"))
  while($res = mysqli_fetch_array($result)){
    $notfound=0; $todatetime=$res['todate']." 23:59:59"; $generatedon=$res['timestamp'];
  }

} else {
  $notfound=1;
}

if ($notfound) {
  echo '0'; exit();
}


?>

<?php if (strtotime($todatetime) > (strtotime($generatedon)+120000)): ?>
  <br>
  <center>New Report may be Found Please <button class="btn btn-sm btn-success" id="generate" onclick="reGenerateReport();">Click Here</button> to Re-Generate</center>

  <br>
<?php endif; ?>

<div class="table-responsive">
  <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
    <thead>
      <tr>
        <th>Rank</th>
        <th>Name</th>
        <th>SKU</th>
        <th>Brand</th>
        <th>Quantity</th>
        <th>Store</th>
      </tr>
    </thead>
    <tbody>
      <?php
        $rank=1;
          if($result = mysqli_query($mysqli, "SELECT productid,name,sku,brand,category,subcategory,quantity,storecode,unit From mostsoldreport,products where (mostsoldreport.fromdate='$fromdate' and mostsoldreport.todate='$todate') and (products.id=mostsoldreport.productid)"))
          while($res = mysqli_fetch_array($result)){
            echo '<tr>';
            echo '<td><p class="mb-0">'.$rank++.'</p></td>';
            echo '<td><p class="mb-0">'.$res['name'].'</p></td>';
            echo '<td><p class="mb-0">'.$res['sku'].'</p></td>';
            echo '<td><p class="mb-0" data-toggle="tooltip" data-placement="top" title="'.$res['category'].'/'.$res['subcategory'].'">'.$res['brand'].'</p></td>';
            echo '<td><p class="mb-0"><b>'.utf8_encode(money_format('%!i',$res['quantity'])).' '.$res['unit'].'</b></p></td>';
            echo '<td><p class="mb-0">'.$res['storecode'].'</p></td>';
            echo '</tr>';
          }
      ?>
    </tbody>
  </table>
</div>
