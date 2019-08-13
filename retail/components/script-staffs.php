<?php

//initialize session usertype and user id
$doneby=$_SESSION['id'];
$usertype=$_SESSION['usertype'];

//Add staff
if (isset($_POST['staffs']) && $_POST['staffs']=="add") {
  $name = mysqli_real_escape_string($mysqli, $_POST['name']);
  $cno = mysqli_real_escape_string($mysqli, $_POST['cno']);
  $address = mysqli_real_escape_string($mysqli, $_POST['address']);
  $aadhar = mysqli_real_escape_string($mysqli, $_POST['aadhar']);
  $utype = mysqli_real_escape_string($mysqli, $_POST['usertype']);
  $doj = mysqli_real_escape_string($mysqli, $_POST['doj']);

  if ($addstaff = mysqli_query($mysqli, "INSERT INTO suppliers (name,cno,address,aadhar,utype,doj) VALUES('$name','$cno','$address','$aadhar','$utype','$doj')")){
      $insertrecord = mysqli_query($mysqli, "INSERT INTO actionrecords (nameorid,module,action,status,usertype,doneby) VALUES('$name','Staff','Add','Success','$usertype','$doneby')");
      header("Location: $page.php?msg=StaffAddSuccess");
  } else {
      $insertrecord = mysqli_query($mysqli, "INSERT INTO actionrecords (nameorid,module,action,status,usertype,doneby) VALUES('$name','Staff','Add','NotSuccess','$usertype','$doneby')");
      header("Location: $page.php?msg=StaffAddNotSuccess");
  }
}

?>
