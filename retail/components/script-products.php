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

  $sku = mysqli_real_escape_string($mysqli, $_POST['sku']);
  $type = mysqli_real_escape_string($mysqli, $_POST['type']);
  $hsn = mysqli_real_escape_string($mysqli, $_POST['hsn']);
  $gst = mysqli_real_escape_string($mysqli, $_POST['gst']);

  $mrp = mysqli_real_escape_string($mysqli, $_POST['mrp']);
  $buyrate = mysqli_real_escape_string($mysqli, $_POST['buyrate']);
  $unit = mysqli_real_escape_string($mysqli, $_POST['unit']);

  $supplier = mysqli_real_escape_string($mysqli, $_POST['supplier']);
  $comment = mysqli_real_escape_string($mysqli, $_POST['comment']);

    if ($addproduct = mysqli_query($mysqli, "INSERT INTO products (name,brand,category,subcategory,sku,type,hsn,gst,buyrate,mrp,unit,supplier,comment) VALUES('$name','$brand','$category','$subcategory','$sku','$type','$hsn','$gst','$buyrate','$mrp','$unit','$supplier','$comment')")){
      $insertrecord = mysqli_query($mysqli, "INSERT INTO actionrecords (nameorid,module,action,status,usertype,doneby) VALUES('$name','Product','Add','Success','$usertype','$doneby')");
      $updateproductcode = mysqli_query($mysqli, "UPDATE counter set value=value+1 where name='productcode' ");
      header("Location: $page.php?msg=ProductAddSuccess");
  } else {
      $insertrecord = mysqli_query($mysqli, "INSERT INTO actionrecords (nameorid,module,action,status,usertype,doneby) VALUES('$name','Product','Add','NotSuccess','$usertype','$doneby')");
      header("Location: $page.php?msg=ProductAddNotSuccess");
  }
}

?>
