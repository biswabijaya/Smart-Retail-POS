<?php

//initialize session usertype and user id
$doneby=$_SESSION['id'];
$usertype=$_SESSION['usertype'];

//Add sale
if (isset($_POST['action']) && $_POST['action']=="salesitemadd") {
  $salesid = mysqli_real_escape_string($mysqli, $_POST['id']);
  $sku = mysqli_real_escape_string($mysqli, $_POST['sku']);

  $itemfound=0;
  $salestock=$purchasestock=0;

  //Detail Finds
  if($find = mysqli_query($mysqli, "SELECT * From products where sku='$sku' or name='$sku' "))
    while($arr = mysqli_fetch_array($find)){
      $productid = $arr['id'];
      $itemfound=1;
  }

  $maxquantity=0;

  if($find = mysqli_query($mysqli, "SELECT * From purchaseditems where productid=$productid "))
    while($arr = mysqli_fetch_array($find)){
      $mrp = $arr['mrp'];
      $sellprice = $arr['sellprice'];
      $maxquantity+=$arr['quantity'];
      $p_mfd=$arr['mfd'];
      $p_expd=$arr['expd'];
  }


  //check for item presence in product list
  if ($itemfound==1) {
    $found=0;

    //check for item presence in sale-item list
    if($find = mysqli_query($mysqli, "SELECT * From solditems where salesid=$salesid and productid=$productid "))
      while($arr = mysqli_fetch_array($find)){
        $updateitemid=$arr['id'];
          $found=1;
    }
    
    //prchase stock
    if($find = mysqli_query($mysqli, "SELECT * From purchaseditems where productid=$productid"))
    while($arr = mysqli_fetch_array($find))
    $purchasestock+=$arr['quantity'];

    //sale stock
    if($find = mysqli_query($mysqli, "SELECT * From solditems where productid=$productid"))
    while($arr = mysqli_fetch_array($find))
    $salestock+=$arr['quantity'];

    //net stock
    $stock=$purchasestock-$salestock;

    if ($found!=0 and $stock>0) {
      if ($updateitemquantity = mysqli_query($mysqli, "UPDATE solditems SET quantity=quantity+1 where id=$updateitemid")){
        header("Location: sale-items.php?id=$salesid&productid=$productid&msg=ItemAddSuccess");
      } else {
        header("Location: sale-items.php?id=$salesid&msg=ItemAddNotSuccess");
      }
    } else if ($stock>0) {
      if ($additem = mysqli_query($mysqli, "INSERT INTO solditems (salesid, productid, mrp, sellprice, mfd, expd) VALUES('$salesid', '$productid', '$mrp', '$sellprice', '$p_mfd', '$p_expd')")){
        header("Location: sale-items.php?id=$salesid&productid=$productid&msg=ItemAddSuccess");
      } else {
        header("Location: sale-items.php?id=$salesid&msg=ItemAddNotSuccess");
      }
    } else {
        header("Location: sale-items.php?id=$salesid&msg=ItemNotAvailableInStock");
    }
  }
  else {
    header("Location: sale-items.php?id=$salesid&msg=ItemAddNotFound");
  }
} else if (isset($_POST['action']) && $_POST['action']=="salesitemupdate") {

  $itemid=$_POST['itemid'];
  $salesid=$_POST['salesid'];

  $p_qty=$_POST['quantity'];
  $p_id=$_POST['purchaseditemid'];

  //Purchase Finds
  if($find = mysqli_query($mysqli, "SELECT * From purchaseditems where id=$p_id "))
    while($arr = mysqli_fetch_array($find)){
      $p_sellprice=$arr['sellprice'];
      $p_mfd=$arr['mfd'];
      $p_expd=$arr['expd'];
  }

  $updateitem = mysqli_query($mysqli, "UPDATE solditems SET quantity='$p_qty',sellprice='$p_sellprice',mfd='$p_mfd',expd='$p_expd'  where id=$itemid");
  header("Location: sale-items.php?id=$salesid&msg=UpdateSuccess");

} else if (isset($_GET['action']) && $_GET['action']=="deleteitem") {
  $itemid=$_GET['itemid'];
  $salesid=$_GET['id'];

  if ($deleteitem = mysqli_query($mysqli, "DELETE FROM solditems where id=$itemid")){
    header("Location: sale-items.php?id=$salesid&msg=ItemDeleteSuccess");
  } else {
    header("Location: sale-items.php?id=$salesid&msg=ItemDeleteNotSuccess");
  }
} else if (isset($_GET['action']) && $_GET['action']=="submit") {
  $salesid=$_GET['id'];

  if ($updateitem = mysqli_query($mysqli, "UPDATE sales set status=1 where id=$salesid")){
    header("Location: payment.php?id=$salesid&type=salepayments&msg=SaleSubmitSuccess");
  } else {
    header("Location: purchase-items.php?id=$salesid&msg=SaleSubmitNotSuccess");
  }
}

?>
