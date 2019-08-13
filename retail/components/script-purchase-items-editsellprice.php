<?php

//initialize session usertype and user id
$doneby=$_SESSION['id'];
$usertype=$_SESSION['usertype'];

 if (isset($_POST['action']) && $_POST['action']=="purchaseitemupdate") {

  $itemid=$_POST['itemid'];
  $purchaseid=$_POST['id'];

  $p_sellprice=$_POST['sellprice'];

  $updateitem = mysqli_query($mysqli, "UPDATE purchaseditems SET sellprice='$p_sellprice' where id=$itemid");
  header("Location: purchase-items-editsellprice.php?id=$purchaseid&msg=UpdateSuccess");

}

?>
