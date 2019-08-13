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
  if($result = mysqli_query($mysqli, "DELETE From Fluctuationreport where fromdate='$fromdate' and todate='$todate'")){
    $notfound=1;
  }

  $notgenerated=1;

  if ($notfound) {
    if($result = mysqli_query($mysqli, "SELECT storecode,productid,round(min(sellprice)) as min, round(max(sellprice)) as max, round(avg(sellprice)) as avg From sales, solditems where sales.id=solditems.salesid and (sales.date between '$fromdate' and '$todate') group by productid ORDER BY avg DESC")){
      while($res = mysqli_fetch_array($result)){
        $storecode=$res['storecode'];
        $productid=$res['productid'];

        $min=$res['min'];
        $max=$res['max'];
        $avg=$res['avg'];
        $median=$avg;
        $mean=($max+$min)/2;

        $profitimpact= $median-$mean;

        if ($profitimpact==0) {
          continue;
        }

        if ($insertrecord = mysqli_query($mysqli, "INSERT INTO `fluctuationreport` ( `storecode`, `fromdate`, `todate`, `productid`, `min`, `max`, `avg`, `profitimpact`) VALUES ('$storecode', '$fromdate', '$todate', '$productid', '$min', '$max', '$avg', '$profitimpact')")) {
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
