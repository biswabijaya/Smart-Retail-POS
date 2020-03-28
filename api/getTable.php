<?php
include 'db.php';

function printTableSchema(){
  $json = array(); // declre array
  if($result = mysqli_query(getMysqli(), "SELECT TABLE_NAME, COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = 'u493086877_shop'"))
    while($res = mysqli_fetch_assoc($result))
      $json[]=$res;
  echo json_encode($json, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
}

function printTableData($table='products'){
  $json = array(); // declre array
  if($result = mysqli_query(getMysqli(), "SELECT * From $table"))
    while($res = mysqli_fetch_assoc($result))
      $json[]=$res;
  echo json_encode($json, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
}
echo "<pre>";
printTableSchema();
echo "</pre><hr><pre>";
printTableData();
echo "</pre>";
?>
