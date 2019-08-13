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
  if($result = mysqli_query($mysqli, "SELECT * From highvaluereport where fromdate='$fromdate' and todate='$todate'"))
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
        $estimatedtotal=$res['estimatedtotal'];
        $actualtotal=$res['actualtotal'];

        if ($insertrecord = mysqli_query($mysqli, "INSERT INTO `highvaluereport` ( `storecode`, `fromdate`, `todate`, `productid`, `quantity`, `avgsp`, `estimatedtotal`, `actualtotal`) VALUES ('$storecode', '$fromdate', '$todate', '$productid', '$quantity', '$sellprice', '$estimatedtotal', '$actualtotal')")) {
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
