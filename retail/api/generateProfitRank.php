<?php
include("../shopdb.php");
if (isset($_POST['type']) and isset($_POST['date'])) {

  $type=$_POST['type'];
  $date=$_POST['date'];

  if ($type=='month') {
    $fromdate=date('Y-m-01', strtotime($date));
    $todate=date('Y-m-t', strtotime($date));
  } else if ($type=='year'){
    $fromdate=date('Y-01-01', strtotime($date));
    $todate=date('Y-12-31', strtotime($date));
  }
  $err="";
  //check if report is Found

  $notfound=1;
  if($result = mysqli_query($mysqli, "SELECT * From profitrankreport where fromdate='$fromdate' and todate='$todate'"))
  while($res = mysqli_fetch_array($result)){
    $notfound=0; $err.= " Found";
  }

  $notgenerated=1;

  if ($notfound) {
    if($result = mysqli_query($mysqli, "SELECT storecode,salesid,productid,round(sum(quantity)) as qty, round(avg(sellprice)) as avgsp, round(sum(quantity))*round(avg(sellprice)) as estimatedtotal , round(sum(quantity*sellprice)) as actualtotal From sales, solditems where sales.id=solditems.salesid and (sales.date between '$fromdate' and '$todate') group by productid ORDER BY actualtotal DESC")){
      while($res = mysqli_fetch_array($result)){
        $storecode=$res['storecode'];
        $sellprice=$res['avgsp'];;
        $quantity=$res['qty'];
        $productid=$res['productid'];

        // get buy price
        if($result1 = mysqli_query($mysqli, "SELECT ceil(avg(buyprice)) as avgbp From purchases, purchaseditems where purchases.id=purchaseditems.purchaseid and purchaseditems.productid=$productid and (purchases.date between '2018-07-01' and '$todate')"))
          while($res1 = mysqli_fetch_array($result1)){
            $buyprice=$res1['avgbp'];
          }

        $pps=$grossprofit=($sellprice-$buyprice);

        $totalestimatedprofit=$grossprofit*$quantity;

        $margin=$grossprofit*100/$sellprice;
        $markup=$grossprofit*100/$buyprice;

        if ($insertrecord = mysqli_query($mysqli, "INSERT INTO `profitrankreport` ( `storecode`, `fromdate`, `todate`, `productid`, `quantity`, `avgsp`, `avgbp`, `pps`, `margin`, `markup`, `estprofit`) VALUES ('$storecode', '$fromdate', '$todate', '$productid', '$quantity', '$sellprice', '$buyprice', '$pps', '$margin', '$markup', '$totalestimatedprofit')")) {
          $err.= " insert success";
        } else {
          $err.= " insert not success";
        }
      }
      $notgenerated=0;
    }
  }

} else {
  $notgenerated=1;
}

if ($notgenerated) {
  echo $fromdate.'-'.$todate.'-'.$notfound.'-'.$notgenerated.'-'.$err;
} else {
  echo '1';
}


?>
