<?php
include 'db.php';

header("Access-Control-Allow-Origin: http://localhost:8000");
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header("Access-Control-Allow-Headers: Content-Type, Authorization");


if (!isset($_GET['sku'])) {
  echo '<form method="get">
  <select name="sku"><option>all</option>';
  if($result = mysqli_query(getMysqli(), "SELECT * From products order by category ASC, subcategory, name ASC"))
    while($res = mysqli_fetch_array($result))
        echo'<option value="'.$res['sku'].'"> '.$res['category'].' - '.$res['subcategory'].' - '.$res['name'].'</option>';
  echo'</select>    <input type="submit" value="submit">
  </form>';
} else {
  if ($_GET['sku']=='all') {
    getProducts();
  } else {
    getProduct($_GET['sku']);
  }
}

function getProduct($sku=0){
  $json = array(); // declre array
  if($result = mysqli_query(getMysqli(), "SELECT * From products where sku='$sku'"))
    while($res = mysqli_fetch_assoc($result))
      $json[]=$res;
  echo json_encode($json, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
}

function getProducts(){
  $json = array();
  if($result = mysqli_query(getMysqli(), "SELECT * From products order by category ASC, subcategory, name ASC"))
    while($res = mysqli_fetch_assoc($result))
      $json[]=$res;
  echo json_encode($json, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
}


?>
