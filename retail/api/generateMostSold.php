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
  if($result = mysqli_query($mysqli, "SELECT * From mostsoldreport where fromdate='$fromdate' and todate='$todate'"))
  while($res = mysqli_fetch_array($result)){
    $notfound=0; $err.= " Found";
  }

  $notgenerated=1;

  if ($notfound) { $err.= " Not Found";
    if($result = mysqli_query($mysqli, "SELECT storecode,productid,SUM(quantity) as quantity FROM sales,solditems WHERE solditems.salesid=sales.id and ( sales.date BETWEEN '$fromdate' AND '$todate') group by productid order by quantity desc")){
      while($res = mysqli_fetch_array($result)){
        $storecode=$res['storecode'];
        $productid=$res['productid'];
        $quantity=$res['quantity'];
        $err.= " loop success";
        if ($insertrecord = mysqli_query($mysqli, "INSERT INTO `mostsoldreport` ( `storecode`, `fromdate`, `todate`, `productid`, `quantity`) VALUES ('$storecode', '$fromdate', '$todate', '$productid', '$quantity')")) {
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
