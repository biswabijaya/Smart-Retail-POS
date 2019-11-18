<?php
include '../retail/shopdb.php';

if (((isset($_GET['sku']) and isset($_GET['action'])) and $_GET['action']=="fetchproduct" )) {
   echo getProduct($_GET['sku']);
}

if ((isset($_GET['action'])) and $_GET['action']=="fetchproducts" ) {
   echo getProducts();
}

function getProduct($sku=0){
  echo '{"Data":[';
  if($query = mysqli_query($mysqli,"SELECT * FROM products WHERE sku = '$sku' ")){
    while ($row = mysqli_fetch_array($query)) {
        echo json_encode($row);
    }
  }
  echo ']}';
}

function getProducts(){
  $first=true;
  echo '{"Data":[';
    if($query = mysqli_query($mysqli,"SELECT * FROM products order by category asc, subcategory asc, name asc ")){
      while ($row = mysqli_fetch_array($query)) {
        if($first) {
            $first = false;
        } else {
            echo ',';
        }
      echo json_encode($row);
    }
  }
  echo ']}';
}
?>
