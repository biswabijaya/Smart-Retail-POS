<?php
include 'db.php';

if (!isset($_GET['sku'])) {
  echo '<form method="get">
  <select name="sku"><option>all</option>';
  if($result = mysqli_query(getMysqli(), "SELECT * From products order by category ASC, subcategory, name ASC"))
    while($res = mysqli_fetch_array($result))
        echo'<option value="'.$res['sku'].'"> '.$res['category'].' - '.$res['subcategory'].' - '.$res['name'].'</option>';
  echo'</select>    <input type="submit" name="submit" value="submit">
  </form>';
} else {
  if ($_GET['sku']=='all') {
    echo '<pre>'.getProducts().'</pre>';
  } else {
    echo '<pre>'.getProduct($_GET['sku']).'</pre>';
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
