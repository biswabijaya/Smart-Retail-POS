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
      if($result1 = mysqli_query(getMysqli(), "SELECT id,date,status From purchases where date='$date' order by id asc"))
        while($res1 = mysqli_fetch_assoc($result1)){
          $purchaseid=$res1['id'];
          $purchaseditems= array();
          if($result2 = mysqli_query(getMysqli(), "SELECT productid,quantity,buyprice From purchaseditems where purchaseid=$purchaseid order by productid asc"))
            while($res2 = mysqli_fetch_assoc($result2)){
                $purchaseditems[]=$res2;
            }
            $purchasesdata = array (
              'purchaseid' => $res1['id'],
              'status' => $res1['status'],
              'items' => $purchaseditems
            );
            $purchases[]=$purchasesdata;
        }
        if($result1 = mysqli_query(getMysqli(), "SELECT id,date,status From sales where date='$date' order by id asc"))
          while($res1 = mysqli_fetch_assoc($result1)){
            $salesid=$res1['id'];
            $solditems= array();
            if($result2 = mysqli_query(getMysqli(), "SELECT productid,quantity,sellprice From solditems where salesid=$salesid order by productid asc"))
              while($res2 = mysqli_fetch_assoc($result2)){
                  $solditems[]=$res2;
              }
              $salesdata = array (
                'salesid' => $res1['id'],
                'status' => $res1['status'],
                'items' => $solditems
              );
              $sales[]=$salesdata;
          }

      $data = array (
        'date' => $date,
        'purchases' => $purchases,
        'sales' => $sales,
      );
      $json[]=$data;
      $date = date ("Y-m-d", strtotime("+1 day", strtotime($date)));
    } while (strtotime($date) <= strtotime($todate));

  echo json_encode($json, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
}
?>
