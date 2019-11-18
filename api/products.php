<?php
include '../retail/shopdb.php';

if (((isset($_GET['sku']) and isset($_GET['action'])) and $_GET['action']=="fetchproduct" )) {
   echo getProductDataJson($_GET['sku']);
}

function getProductDataJson($sku=0){
  if($query = mysqli_query($mysqli,"SELECT * FROM staffs WHERE sku = $sku")){
    if ($row = mysqli_fetch_array($query)) {
      json_encode($row);
    }
  }
?>
