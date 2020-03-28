<?php
include 'db.php';

function printTables(){
  $json = array(); // declre array
  if($result = mysqli_query(getMysqli(), "DESCRIBE my_table"))
    while($res = mysqli_fetch_assoc($result))
      $json[]=$res;
  echo json_encode($json, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
}

printTables();
?>
