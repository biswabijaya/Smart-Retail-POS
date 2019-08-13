<?php

//initialize session usertype and user id
$doneby=$_SESSION['id'];
$usertype=$_SESSION['usertype'];

//Add Product
if (isset($_POST['product']) && $_POST['product']=="add") {
  $name = mysqli_real_escape_string($mysqli, $_POST['name']);
  $brand = mysqli_real_escape_string($mysqli, $_POST['brand']);
  $category = mysqli_real_escape_string($mysqli, $_POST['category']);
  $subcategory = mysqli_real_escape_string($mysqli, $_POST['subcategory']);


  $mrp = mysqli_real_escape_string($mysqli, $_POST['mrp']);
  $buyprice = mysqli_real_escape_string($mysqli, $_POST['buyprice']);
  $sellprice = mysqli_real_escape_string($mysqli, $_POST['sellprice']);

  $sku = mysqli_real_escape_string($mysqli, $_POST['sku']);
  $type = mysqli_real_escape_string($mysqli, $_POST['type']);

  $unit = mysqli_real_escape_string($mysqli, $_POST['unit']);

    if ($addproduct = mysqli_query($mysqli, "INSERT INTO products (name,brand,category,subcategory,mrp,buyprice,sellprice,sku,type,unit) VALUES('$name','$brand','$category','$subcategory','$mrp','$buyprice','$sellprice','$sku','$type','$unit')")){
      $insertrecord = mysqli_query($mysqli, "INSERT INTO actionrecords (nameorid,module,action,status,usertype,doneby) VALUES('$name','Product','Add','Success','$usertype','$doneby')");
      $updateproductcode = mysqli_query($mysqli, "UPDATE counter set value=value+1 where name='productcode' ");
      header("Location: $page.php?msg=ProductAddSuccess");
  } else {
      $insertrecord = mysqli_query($mysqli, "INSERT INTO actionrecords (nameorid,module,action,status,usertype,doneby) VALUES('$name','Product','Add','NotSuccess','$usertype','$doneby')");
      header("Location: $page.php?msg=ProductAddNotSuccess");
  }
}

?>
