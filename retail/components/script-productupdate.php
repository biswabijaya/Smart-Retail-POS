<?php

//initialize session usertype and user id
$doneby=$_SESSION['id'];
$usertype=$_SESSION['usertype'];

//Add Product
if (isset($_POST['product']) && $_POST['product']=="update") {
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

    if ($updateproduct = mysqli_query($mysqli, "UPDATE products SET name='$name',brand='$brand',category='$category',subcategory='$subcategory',sku='$sku',type='$type',hsn='$hsn',gst='$gst',buyrate='$buyrate',mrp='$mrp',unit='$unit',supplier='$supplier',comment='$comment' where sku='$sku'")){
      $insertrecord = mysqli_query($mysqli, "INSERT INTO actionrecords (nameorid,module,action,status,usertype,doneby) VALUES('$name','Product','Update','Success','$usertype','$doneby')");
      header("Location: $page.php?sku=$sku&action=view&msg=ProductUpdateSuccess");
  } else {
      $insertrecord = mysqli_query($mysqli, "INSERT INTO actionrecords (nameorid,module,action,status,usertype,doneby) VALUES('$name','Product','Update','NotSuccess','$usertype','$doneby')");
      header("Location: $page.php?sku=$sku&action=edit&msg=ProductUpdateNotSuccess");
  }
}

?>
