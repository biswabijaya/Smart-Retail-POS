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
      $purchases = $sales = array();
      if($result1 = mysqli_query(getMysqli(), "SELECT purchaseid,staffid,supplierid,type,date,mrp,quantity,buyprice,sellprice,status From purchases t1, purchaseditems t2 where t1.id=t2.purchaseid and t1.date='$date' order by t2.purchaseid asc"))
        while($res1 = mysqli_fetch_assoc($result1)){
            $purchases[]=$res1;
        }
      if($result1 = mysqli_query(getMysqli(), "SELECT salesid,staffid,storecode,cno,date,quantity,mrp,sellprice,status From sales t1, solditems t2 where t1.id=t2.salesid and t1.date='$date' order by t2.salesid asc"))
      while($res1 = mysqli_fetch_assoc($result1)){
          $sales[]=$res1;
      }

      $data = array (
        'date' => $res['id'],
        'purchases' => $purchases,
        'sales' => $sales,
      );
      $json[]=$res;
      $date = date ("Y-m-d", strtotime("+1 day", strtotime($date)));
    } while (strtotime($date) <= strtotime($end_date));

  echo json_encode($json, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
}
?>
