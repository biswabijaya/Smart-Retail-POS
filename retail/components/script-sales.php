<?php

//initialize session usertype and user id
$doneby=$_SESSION['id'];
$usertype=$_SESSION['usertype'];

//Add Purchase
if (isset($_POST['sales']) && $_POST['sales']=="add") {
  $staffid = mysqli_real_escape_string($mysqli, $_POST['staffid']);
  $storecode = mysqli_real_escape_string($mysqli, $_POST['storecode']);
  $cno = mysqli_real_escape_string($mysqli, $_POST['cno']);
  $date = mysqli_real_escape_string($mysqli, $_POST['date']);

    if ($addpurchase = mysqli_query($mysqli, "INSERT INTO sales (staffid, storecode, cno, date) VALUES('$staffid', '$storecode', '$cno', '$date')")){
      $insertrecord = mysqli_query($mysqli, "INSERT INTO actionrecords (nameorid,module,action,status,usertype,doneby) VALUES('$storecode','Sales','Add','Success','$usertype','$doneby')");
      header("Location: $page.php?msg=SaleAddSuccess");
  } else {
      $insertrecord = mysqli_query($mysqli, "INSERT INTO actionrecords (nameorid,module,action,status,usertype,doneby) VALUES('$storecode','Sales','Add','NotSuccess','$usertype','$doneby')");
      header("Location: $page.php?msg=SaleAAddNotSuccess");
  }
} 

?>
