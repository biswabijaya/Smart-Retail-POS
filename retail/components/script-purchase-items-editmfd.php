<?php

//initialize session usertype and user id
$doneby=$_SESSION['id'];
$usertype=$_SESSION['usertype'];

 if (isset($_POST['action']) && $_POST['action']=="purchaseitemupdate") {

  $itemid=$_POST['itemid'];
  $purchaseid=$_POST['id'];

  $p_mfd=$_POST['mfd'];
  $p_expd=$_POST['expd'];

  $updateitem = mysqli_query($mysqli, "UPDATE purchaseditems SET mfd='$p_mfd',expd='$p_mfd' where id=$itemid");
  header("Location: purchase-items-editmfd.php?id=$purchaseid&msg=UpdateSuccess");

}

?>
