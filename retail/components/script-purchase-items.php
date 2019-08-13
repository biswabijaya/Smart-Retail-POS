<?php

//initialize session usertype and user id
$doneby=$_SESSION['id'];
$usertype=$_SESSION['usertype'];

//Add Purchase
if (isset($_POST['action']) && $_POST['action']=="purchaseitemadd") {
  $purchaseid = mysqli_real_escape_string($mysqli, $_POST['id']);
  $sku = mysqli_real_escape_string($mysqli, $_POST['sku']);

  $itemfound=0;

  //Detail Finds
  if($find = mysqli_query($mysqli, "SELECT * From products where sku='$sku' or name='$sku' "))
    while($arr = mysqli_fetch_array($find)){
      $productid = $arr['id'];
      $mrp=$arr['mrp'];
      $sellprice=$arr['mrp'];
      $buyprice=$arr['buyrate'];
      $itemfound=1;
  }

  //check for item presence in product list
  if ($itemfound==1) {
    $found=0;

    //check for item presence in purchase-item list
    if($find = mysqli_query($mysqli, "SELECT * From purchaseditems where purchaseid=$purchaseid and productid=$productid "))
      while($arr = mysqli_fetch_array($find)){
        $updateitemid=$arr['id'];
          $found=1;
    }

    if ($found!=0) {
      if ($updateitemquantity = mysqli_query($mysqli, "UPDATE purchaseditems SET quantity=quantity+1 where id=$updateitemid")){
        $insertrecord = mysqli_query($mysqli, "INSERT INTO actionrecords (nameorid,module,action,status,usertype,doneby) VALUES('$purchaseid','Purchase-Item','Add','Success','$usertype','$doneby')");
        header("Location: purchase-items.php?id=$purchaseid&productid=$productid&msg=ItemAddSuccess");
      } else {
        $insertrecord = mysqli_query($mysqli, "INSERT INTO actionrecords (nameorid,module,action,status,usertype,doneby) VALUES('$purchaseid','Purchase-Item','Add','NotSuccess','$usertype','$doneby')");
        header("Location: purchase-items.php?id=$purchaseid&msg=ItemAddNotSuccess");
      }
    } else {
      if ($additem = mysqli_query($mysqli, "INSERT INTO purchaseditems (purchaseid, productid, mrp, buyprice, sellprice) VALUES('$purchaseid', '$productid', '$mrp', '$buyprice', '$sellprice')")){
        $insertrecord = mysqli_query($mysqli, "INSERT INTO actionrecords (nameorid,module,action,status,usertype,doneby) VALUES('$purchaseid','Purchase-Item','Add','Success','$usertype','$doneby')");
        header("Location: purchase-items.php?id=$purchaseid&productid=$productid&msg=ItemAddSuccess");
      } else {
        $insertrecord = mysqli_query($mysqli, "INSERT INTO actionrecords (nameorid,module,action,status,usertype,doneby) VALUES('$purchaseid','Purchase-Item','Add','NotSuccess','$usertype','$doneby')");
        header("Location: purchase-items.php?id=$purchaseid&msg=ItemAddNotSuccess");
      }
    }
  }
  else {
    $insertrecord = mysqli_query($mysqli, "INSERT INTO actionrecords (nameorid,module,action,status,usertype,doneby) VALUES('$purchaseid','Purchase-Item','Add','NotSuccess','$usertype','$doneby')");
    header("Location: purchase-items.php?id=$purchaseid&msg=ItemAddNotFound");
  }
} else if (isset($_POST['action']) && $_POST['action']=="purchaseitemupdate") {

  $itemid=$_POST['itemid'];
  $productid=$_POST['productid'];
  $purchaseid=$_POST['id'];

  $p_mrp=$_POST['mrp'];
  $p_sellprice=$_POST['sellprice'];
  $p_buyprice=$_POST['buyprice'];
  $p_qty=$_POST['quantity'];

  $p_hsn= $_POST['hsn'];
  $p_gst= $_POST['gst'];

  $p_mfd=$_POST['mfd'];
  $p_expd=$_POST['expd'];

  $updateitem = mysqli_query($mysqli, "UPDATE purchaseditems SET mfd='$p_mfd',expd='$p_expd', mrp='$p_mrp', buyprice='$p_buyprice', sellprice='$p_sellprice',  quantity='$p_qty'  where id=$itemid");
  $updateitemproduct = mysqli_query($mysqli, "UPDATE products SET hsn='$p_hsn', gst='$p_gst' where id=$productid");

  header("Location: purchase-items.php?id=$purchaseid&msg=UpdateSuccess");

} else if (isset($_GET['action']) && $_GET['action']=="deleteitem") {
  $itemid=$_GET['itemid'];
  $purchaseid=$_GET['id'];

  if ($deleteitem = mysqli_query($mysqli, "DELETE FROM purchaseditems where id=$itemid")){
    $insertrecord = mysqli_query($mysqli, "INSERT INTO actionrecords (nameorid,module,action,status,usertype,doneby) VALUES('$purchaseid','Purchase-Item','Delete','Success','$usertype','$doneby')");
    header("Location: purchase-items.php?id=$purchaseid&msg=ItemDeleteSuccess");
  } else {
    $insertrecord = mysqli_query($mysqli, "INSERT INTO actionrecords (nameorid,module,action,status,usertype,doneby) VALUES('$purchaseid','Purchase-Item','Delete','NotSuccess','$usertype','$doneby')");
    header("Location: purchase-items.php?id=$purchaseid&msg=ItemDeleteNotSuccess");
  }
} else if (isset($_GET['action']) && $_GET['action']=="submit") {
  $purchaseid=$_GET['id'];

  if ($updateitem = mysqli_query($mysqli, "UPDATE purchases set status=1 where id=$purchaseid")){
    header("Location: purchase-items.php?id=$purchaseid&msg=PurchaseSubmitSuccess");
  } else {
    header("Location: purchase-items.php?id=$purchaseid&msg=PurchaseSubmitNotSuccess");
  }
}

?>
