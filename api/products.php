<?php
include '../retail/shopdb.php';

if (((isset($_GET['sku']) and isset($_GET['action'])) and $_GET['action']=="fetchproduct" )) {
   echo getProduct($_GET['sku']);
}

if ((isset($_GET['action'])) and $_GET['action']=="fetchproducts" ) {
   echo getProducts();
}

function getProduct($sku=0){
  if($query = mysqli_query(getMysqli(),"SELECT * FROM products WHERE sku = '$sku' ")){
    while ($row = mysqli_fetch_array($query,MYSQL_ASSOC)) {
        echo json_encode($row, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    }
  }
}

function getProducts(){
  $json = array();
  if($query = mysqli_query(getMysqli(),"SELECT * FROM products order by category asc, subcategory asc, name asc ")){
    while ($row = mysqli_fetch_array($query,MYSQL_ASSOC)) {
      $json[]=$row;
    }
  }
  echo json_encode($json, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
}
?>
