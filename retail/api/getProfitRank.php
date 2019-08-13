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
  if($result = mysqli_query($mysqli, "SELECT * From profitrankreport where fromdate='$fromdate' and todate='$todate'"))
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
        <th>Quantity</th>
        <th>Avg(BP)</th>
        <th>Avg(SP)</th>
        <th>PPS</th>
        <th>Margin</th>
        <th>Markup</th>
        <th>Est.(Profit)</th>
        <th>Store</th>
      </tr>
    </thead>
    <tbody>
      <?php
        $rank=1;
        if($result = mysqli_query($mysqli, "SELECT productid,name,sku,brand,category,subcategory,quantity,storecode,unit,avgsp,avgbp,pps,margin,markup,estprofit From profitrankreport,products where (profitrankreport.fromdate='$fromdate' and profitrankreport.todate='$todate') and (products.id=profitrankreport.productid) order by estprofit desc"))
        while($res = mysqli_fetch_array($result)){
          echo '<tr>';
          echo '<td><p class="mb-0">'.$rank++.'</p></td>';
          echo '<td><p class="mb-0" data-toggle="tooltip" title="SKU: '.$res['sku'].'">'.$res['name'].'</p></td>';
          echo '<td><p class="mb-0"><b>'.money_format('%!i',$res['quantity']).' '.$res['unit'].'</b></p></td>';
          echo '<td><p class="mb-0">'.money_format('%!i',$res['avgbp']).'</p></td>';
          echo '<td><p class="mb-0">'.money_format('%!i',$res['avgsp']).'</p></td>';
          if ($res['pps']>0) {
            echo '<td><p class="mb-0"><b class="text-success">Rs '.money_format('%!i',$res['pps']).'</b></p></td>';
          } else {
            echo '<td><p class="mb-0"><b class="text-danger">Rs '.money_format('%!i',$res['pps']).'</b></p></td>';
          }

          echo '<td><p class="mb-0">'.$res['margin'].'%</p></td>';
          echo '<td><p class="mb-0">'.$res['markup'].'%</p></td>';
          echo '<td><p class="mb-0"><b>'.money_format('%!i', $res['estprofit']).'</b></p></td>';
          echo '<td><p class="mb-0">'.$res['storecode'].'</p></td>';
          echo '</tr>';
        }
      ?>
    </tbody>
  </table>
</div>
