<?php
include 'db.php';

if(!isset($_GET['date'])){
  echo '<form method="get">
    <input type="date" name="date" value="">
    <input type="submit" name="submit" value="submit">
  </form>';
} else {
echo "<pre>";
printTableData($_GET['table']);
echo "</pre>";
}

function printTableData($date=date('Y-m-d')){
  $json = array(); // declre array
  if($result = mysqli_query(getMysqli(), "SELECT * From sales where date = '$date'"))
    while($res = mysqli_fetch_assoc($result))
      $json[]=$res;
  echo json_encode($json, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
}
?>
