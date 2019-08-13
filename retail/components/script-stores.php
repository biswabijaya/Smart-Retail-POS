<?php

//initialize session usertype and user id
$doneby=$_SESSION['id'];
$usertype=$_SESSION['usertype'];

//Add staff
if (isset($_POST['staffs']) && $_POST['staffs']=="add") {
  $name = mysqli_real_escape_string($mysqli, $_POST['name']);
  $cno = mysqli_real_escape_string($mysqli, $_POST['cno']);
  $type = mysqli_real_escape_string($mysqli, $_POST['type']);
  $locality = mysqli_real_escape_string($mysqli, $_POST['locality']);
  $city = mysqli_real_escape_string($mysqli, $_POST['city']);
  $pincode = mysqli_real_escape_string($mysqli, $_POST['pincode']);
  $manager = mysqli_real_escape_string($mysqli, $_POST['manager']);

  if ($addstaff = mysqli_query($mysqli, "INSERT INTO stores (name,cno,type,locality,city,pincode,manager) VALUES('$name','$cno','$type','$locality','$city','$pincode','$manager')")){
      $insertrecord = mysqli_query($mysqli, "INSERT INTO actionrecords (nameorid,module,action,status,usertype,doneby) VALUES('$name','Staff','Add','Success','$usertype','$doneby')");
      header("Location: $page.php?msg=StoreAddSuccess");
  } else {
      $insertrecord = mysqli_query($mysqli, "INSERT INTO actionrecords (nameorid,module,action,status,usertype,doneby) VALUES('$name','Staff','Add','NotSuccess','$usertype','$doneby')");
      header("Location: $page.php?msg=StoreAddNotSuccess");
  }
}

?>
