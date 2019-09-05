<?php
include '../retail/shopdb.php';

if (((isset($_GET['sku']) and isset($_GET['action'])) and $_GET['action']=="fetchproduct" )) {
  // code to find maching data from database
}
if (((isset($_GET['sku']) and isset($_GET['action'])) and $_GET['action']=="fetchproduct" )) {
   echo getUserDataJson($_GET['sku']);
}

function getProductDAtaJson($sku=0){
  if($query = mysqli_query($mysqli,"SELECT * FROM staffs WHERE sku = $sku")){
    if ($row = mysqli_fetch_array($query)) {
      json_encode($row);
    }
  }
?>
