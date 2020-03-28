<?php
include 'db.php';

function printTables($table='products'){
  $json = array(); // declre array
  if($result = mysqli_query(getMysqli(), "SELECT COLUMN_NAME
  FROM INFORMATION_SCHEMA.COLUMNS
  WHERE TABLE_SCHEMA = 'u493086877_shop' AND TABLE_NAME = '$table';"))
    while($res = mysqli_fetch_assoc($result))
      $json[]=$res;
  echo json_encode($json, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
}

printTables();
?>
