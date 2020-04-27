<?php
include 'db.php';

if(!isset($_GET['fromdate']) or !isset($_GET['fromdate'])){
  echo '<form id="form" method="get">
          <div class="form-group">
            <label class="control-label">From Date</label>
            <input class="form-control" type="date" name="fromdate" id="fromdate" onchange="listen(this);" value="'.date("Y-m-d").'">
          </div>
          <div class="form-group">
            <label class="control-label">To Date</label>
            <input class="form-control" type="date" name="todate" id="todate" onchange="listen(this);" value="'.date("Y-m-d").'">
          </div>
        </form>';
} else {
  printTableData($_GET['fromdate'],$_GET['todate']);
}


function printTableData($fromdate,$todate){
  $json = array(); // declre array
  $date=$fromdate;

    do{
      $purchases = $sales = 0;
      $purchasedamount=0;
      $soldamount=0;

      if($result1 = mysqli_query(getMysqli(), "SELECT count(distinct purchaseid) as count,date,sum(quantity*buyprice) as amount From purchases t1, purchaseditems t2 where t1.id=t2.purchaseid and t1.date='$date'"))
        while($res1 = mysqli_fetch_assoc($result1)){
          $purchases=$res1['count'];
          $purchasedamount=$res1['amount'];
        }
      if($result1 = mysqli_query(getMysqli(), "SELECT count(distinct salesid) as count,date,sum(quantity*sellprice) as amount From sales t1, solditems t2 where t1.id=t2.salesid and t1.date='$date'"))
        while($res1 = mysqli_fetch_assoc($result1)){
          $sales=$res1['count'];
          $soldamount=$res1['amount'];
        }

      $data = array (
        'date' => $date,
        'purchases' => $purchases,
        'purchasedamount' => round($purchasedamount),
        'sales' => $sales,
        'soldamount' => round($soldamount),
      );
      $json[]=$data;
      $date = date ("Y-m-d", strtotime("+1 day", strtotime($date)));
    } while (strtotime($date) <= strtotime($todate));

  echo json_encode($json, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
}
?>
