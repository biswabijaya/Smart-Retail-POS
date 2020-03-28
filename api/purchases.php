<?php
include 'db.php';

if(!isset($_GET['date'])){
  echo '<form method="get">
    <input type="date" name="date" value="">
    <input type="submit" value="submit">
  </form>';
} else {
echo "<pre>";
printTableData($_GET['purchase']);
echo "</pre>";
}


function printTableData($date){
  $json = array(); // declre array
  if($result = mysqli_query(getMysqli(), "SELECT * From purchases where date = '$date'"))
    while($res = mysqli_fetch_assoc($result))
      $json[]=$res;
  echo json_encode($json, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
}
?>
