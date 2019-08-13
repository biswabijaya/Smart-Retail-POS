<?php

//initialize session usertype and user id
$doneby=$_SESSION['id'];
$usertype=$_SESSION['usertype'];

//Add Product
if (isset($_POST['supplier']) && $_POST['supplier']=="add") {
  $name = mysqli_real_escape_string($mysqli, $_POST['name']);
  $cno = mysqli_real_escape_string($mysqli, $_POST['cno']);
  $address = mysqli_real_escape_string($mysqli, $_POST['address']);
  $gstin = mysqli_real_escape_string($mysqli, $_POST['gstin']);
  $doj = mysqli_real_escape_string($mysqli, $_POST['doj']);


    if ($addsupplier = mysqli_query($mysqli, "INSERT INTO suppliers (name,cno,address,gstin,doj) VALUES('$name','$cno','$address','$gstin','$doj')")){
      $insertrecord = mysqli_query($mysqli, "INSERT INTO actionrecords (nameorid,module,action,status,usertype,doneby) VALUES('$name','Supplier','Add','Success','$usertype','$doneby')");
      header("Location: $page.php?msg=SupplierAddSuccess");
  } else {
      $insertrecord = mysqli_query($mysqli, "INSERT INTO actionrecords (nameorid,module,action,status,usertype,doneby) VALUES('$name','Supplier','Add','NotSuccess','$usertype','$doneby')");
      header("Location: $page.php?msg=SupplierAddNotSuccess");
  }
}

?>
