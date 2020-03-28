<?php
include 'db.php';

function printTableSchema(){
  $js = array(); // declre array
  if($result = mysqli_query(getMysqli(), "SELECT @a:=@a+1 sr, ORDINAL_POSITION as tid , TABLE_NAME as tablename, COLUMN_NAME as columnname FROM INFORMATION_SCHEMA.COLUMNS,(SELECT @a:= 0) AS a WHERE TABLE_SCHEMA = 'u493086877_shop'"))
    while($res = mysqli_fetch_array($result))
      $js[]=$res;
  echo json_encode($js, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
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
