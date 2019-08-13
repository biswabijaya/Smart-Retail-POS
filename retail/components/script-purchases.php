<?php

//initialize session usertype and user id
$doneby=$_SESSION['id'];
$usertype=$_SESSION['usertype'];

//Add Purchase
if (isset($_POST['purchases']) && $_POST['purchases']=="add") {
  $type = mysqli_real_escape_string($mysqli, $_POST['type']);
  $staffid = $doneby;
  $billno = mysqli_real_escape_string($mysqli, $_POST['billno']);
  $supplierid = mysqli_real_escape_string($mysqli, $_POST['supplierid']);
  $date = mysqli_real_escape_string($mysqli, $_POST['date']);

    if ($addpurchase = mysqli_query($mysqli, "INSERT INTO purchases (type, billno, staffid, supplierid, date) VALUES('$type', '$billno', '$staffid', '$supplierid', '$date')")){
      $insertrecord = mysqli_query($mysqli, "INSERT INTO actionrecords (nameorid,module,action,status,usertype,doneby) VALUES('$name','Purchase','Add','Success','$usertype','$doneby')");
      header("Location: $page.php?msg=PurchaseAddSuccess");
  } else {
      $insertrecord = mysqli_query($mysqli, "INSERT INTO actionrecords (nameorid,module,action,status,usertype,doneby) VALUES('$name','Purchase','Add','NotSuccess','$usertype','$doneby')");
      header("Location: $page.php?msg=PurchaseAddNotSuccess");
  }
} else if (isset($_GET['action']) && $_GET['action']=="cancelpurchase") {
  $purchaseid=$_GET['id'];
  if ($deleteitem = mysqli_query($mysqli, "Delete from purchases where id=$purchaseid")){
    header("Location: $page.php?&msg=PurchaseDeleteSuccess");
  } else {
    header("Location: $page.php?&msg=PurchaseDeleteNotSuccess");
  }
}

?>
