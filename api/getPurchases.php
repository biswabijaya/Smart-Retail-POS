<?php
include 'db.php';

if(!isset($_GET['fromdate']) or !isset($_GET['todate'])){
  echo '<form method="get">
    <input type="date" name="fromdate" value="">
    <input type="date" name="todate" value="">
    <input type="submit" value="submit">
  </form>';
} else {
printTableData($_GET['fromdate'],$_GET['todate']);
}


function printTableData($fromdate, $todate){
  $json = array(); // declre array
  if($result = mysqli_query(getMysqli(), "SELECT * From purchases where date between '$fromdate' and '$todate'"))
    while($res = mysqli_fetch_assoc($result))
      $json[]=$res;
  echo json_encode($json, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
}
?>


<!-- Adi: i need this and that, adi provide vars -->
