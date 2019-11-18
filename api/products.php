<?php
include '../retail/shopdb.php';

if (((isset($_GET['sku']) and isset($_GET['action'])) and $_GET['action']=="fetchproduct" )) {
   echo getProduct($_GET['sku']);
}

if ((isset($_GET['action'])) and $_GET['action']=="fetchproducts" ) {
   echo getProducts();
}

function getProduct($sku=0){
  if($query = mysqli_query($mysqli,"SELECT * FROM products WHERE sku = '$sku' ")){
    if ($row = mysqli_fetch_array($query)) {
      json_encode($row);
    }
  }

function getProducts(){
  if($query = mysqli_query($mysqli,"SELECT * FROM products order by category asc, subcategory asc, name asc ")){
    if ($row = mysqli_fetch_array($query)) {
      json_encode($row);
    }
  }

?>
