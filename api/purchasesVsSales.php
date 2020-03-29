<?php
include 'db.php';

if(!isset($_GET['fromdate']) or !isset($_GET['fromdate'])){
  echo '<form method="get">
    <input class="form-control" type="date" name="fromdate" value="">
    <br><input class="form-control" type="date" name="todate" value="">
    <br><input class="form-control" type="submit" value="submit">
  </form>';
} else {
  printTableData($_GET['fromdate'],$_GET['todate']);
}


function printTableData($fromdate,$todate){
  $json = array(); // declre array
  $date=$fromdate;

    do{
      $purchases = $sales = 0;
      $purchaseditems=$purchasedamount=0;
      $solditems=$soldamount=0;

      if($result1 = mysqli_query(getMysqli(), "SELECT count(distinct purchaseid) as count, count(productid) as itemcount,date,sum(quantity*buyprice) as amount From purchases t1, purchaseditems t2 where t1.id=t2.purchaseid and t1.date='$date'"))
        while($res1 = mysqli_fetch_assoc($result1)){
          $purchases=$res1['count'];
          $purchaseditems=$res1['itemcount'];
          $purchasedamount=$res1['amount'];
        }
      if($result1 = mysqli_query(getMysqli(), "SELECT count(distinct salesid) as count, count(productid) as itemcount,date,sum(quantity*sellprice) as amount From sales t1, solditems t2 where t1.id=t2.salesid and t1.date='$date'"))
        while($res1 = mysqli_fetch_assoc($result1)){
          $sales=$res1['count'];
          $solditems=$res1['itemcount'];
          $soldamount=$res1['amount'];
        }

      $data = array (
        'date' => $date,
        'purchases' => $purchases,
        'purchaseditems' => $purchaseditems,
        'purchasedamount' => round($purchasedamount),
        'sales' => $sales,
        'solditems' => $solditems,
        'soldamount' => round($soldamount),
      );
      $json[]=$data;
      $date = date ("Y-m-d", strtotime("+1 day", strtotime($date)));
    } while (strtotime($date) <= strtotime($todate));

  echo json_encode($json, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
}
?>
