<?php

//initialize session usertype and user id
$doneby=$_SESSION['id'];
$usertype=$_SESSION['usertype'];

//Add Voucher
if (isset($_POST['voucher']) && $_POST['voucher']=="add") {
  $name = mysqli_real_escape_string($mysqli, $_POST['name']);
  $storecode = mysqli_real_escape_string($mysqli, $_POST['storecode']);
  $category = mysqli_real_escape_string($mysqli, $_POST['category']);
  $subcategory = mysqli_real_escape_string($mysqli, $_POST['subcategory']);

  $staffid = $doneby;

  $amount = mysqli_real_escape_string($mysqli, $_POST['amount']);
  $date = mysqli_real_escape_string($mysqli, $_POST['date']);
  $details = mysqli_real_escape_string($mysqli, $_POST['details']);

    if ($addVoucher = mysqli_query($mysqli, "INSERT INTO vouchers (name,storecode,category,subcategory,staffid,amount,date,details) VALUES('$name','$storecode','$category','$subcategory','$staffid','$amount','$date','$details')")){
      $insertrecord = mysqli_query($mysqli, "INSERT INTO actionrecords (nameorid,module,action,status,usertype,doneby) VALUES('$name','Voucher','Add','Success','$usertype','$doneby')");
      header("Location: $page.php?msg=VoucherAddSuccess");
  } else {
      $insertrecord = mysqli_query($mysqli, "INSERT INTO actionrecords (nameorid,module,action,status,usertype,doneby) VALUES('$name','Voucher','Add','NotSuccess','$usertype','$doneby')");
      header("Location: $page.php?msg=VoucherAddNotSuccess");
  }
}

?>
