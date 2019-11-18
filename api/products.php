<?php
include 'db.php';

if (((isset($_GET['sku']) and isset($_GET['action'])) and $_GET['action']=="fetchproduct" )) {
   echo getProduct($_GET['sku']);
}

if ((isset($_GET['action'])) and $_GET['action']=="fetchproducts" ) {
   echo getProducts();
}

function getProduct($sku=0){
  if($result = mysqli_query(getMysqli(), "SELECT * From products where sku='$sku'"))
    while($res = mysqli_fetch_array($result))
      $json[]=$res;
}

function getProducts(){
  $json = array();
  if($result = mysqli_query(getMysqli(), "SELECT * From products order by category ASC, subcategory, name ASC"))
    while($res = mysqli_fetch_array($result))
      $json[]=$res;

  echo json_encode($json, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
}


?>
