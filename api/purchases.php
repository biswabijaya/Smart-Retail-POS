<?php
include 'db.php';

if(!isset($_GET['fromdate']['todate'])){
  echo '<form method="get">
    <input type="date" name="fromdate" value="">
    <input type="date" name="todate" value="">
    <input type="submit" value="submit">
  </form>';
} else {
printTableData($_GET['purchase']);
}


function printTableData($fromdate,$todate){
  $json = array(); // declre array
  if($result = mysqli_query(getMysqli(), "SELECT * From purchases where date {BETWEEN} 'fromdate' and 'todate'"))
    while($res = mysqli_fetch_assoc($result))
      $json[]=$res;
  echo json_encode($json, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
}
?>
