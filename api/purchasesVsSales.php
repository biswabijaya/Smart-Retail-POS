<?php
include 'db.php';

if(!isset($_GET['fromdate']) or !isset($_GET['fromdate'])){
  echo '<form method="get">
    <input class="form-control" type="date" name="fromdate" value="">
    <input class="form-control" type="date" name="todate" value="">
    <input class="" type="submit" value="submit">
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

      if($result1 = mysqli_query(getMysqli(), "SELECT id,date,status From purchases where date='$date' order by id asc"))
        while($res1 = mysqli_fetch_assoc($result1)){
          $purchaseid=$res1['id'];$purchases++;
          $itemcount=$amount=0;
          if($result2 = mysqli_query(getMysqli(), "SELECT count(productid) as itemcount, sum(quantity*buyprice) as amount From purchaseditems where purchaseid=$purchaseid"))
            while($res2 = mysqli_fetch_assoc($result2)){
              $itemcount=$res2['itemcount'];
              $amount=$res2['amount'];
            }
            $purchaseditems+=$itemcount;
            $purchasedamount+=$amount;
        }
        if($result1 = mysqli_query(getMysqli(), "SELECT id,date,status From sales where date='$date' order by id asc"))
          while($res1 = mysqli_fetch_assoc($result1)){
            $salesid=$res1['id']; $sales++;
            $itemcount=$amount=0;
            if($result2 = mysqli_query(getMysqli(), "SELECT count(productid) as itemcount, sum(quantity*sellprice) as amount From solditems where salesid=$salesid"))
              while($res2 = mysqli_fetch_assoc($result2)){
                $itemcount=$res2['itemcount'];
                $amount=$res2['amount'];
              }
              $solditems+=$itemcount;
              $soldamount+=$amount;
          }

      $data = array (
        'date' => $date,
        'purchases' => $purchases,
        'purchaseditems' => $purchaseditems,
        'purchasedamount' => $purchasedamount,
        'sales' => $sales,
        'solditems' => $solditems,
        'soldamount' => $soldamount,
      );
      $json[]=$data;
      $date = date ("Y-m-d", strtotime("+1 day", strtotime($date)));
    } while (strtotime($date) <= strtotime($todate));

  echo json_encode($json, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
}
?>
