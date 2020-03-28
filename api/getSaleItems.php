<?php
include 'db.php';

if (!isset($_GET['salesid'])) {
  echo '<form method="get">
  <select name="salesid"><option>all</option>';
  if($result = mysqli_query(getMysqli(), "SELECT * From sales order by id desc"))
    while($res = mysqli_fetch_array($result))
        echo'<option value="'.$res['id'].'"> '.$res['id'].' - '.$res['cno'].' - '.$res['date'].'</option>';
  echo'</select>    <input type="submit" name="submit" value="submit">
  </form>';
} else {
  echo "<pre>";
  printTableData($_GET['saleid']);
  echo "</pre>";
}

function printTableData($saleid=1){
  $json = array(); // declre array
  if($result = mysqli_query(getMysqli(), "SELECT * From solditems where salesid=$saleid"))
    while($res = mysqli_fetch_assoc($result))
      $json[]=$res;
  echo json_encode($json, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
}
?>
