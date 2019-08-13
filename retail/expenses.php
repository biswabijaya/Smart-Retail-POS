<?php
include 'shopdb.php';

if (!isset($_SESSION['usertype'])) {
   header("Location: index.php");
 }

//default initialisations
$page="expenses";
$active=$page.'.php';
include 'components/script-'.$page.'.php';


?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Expenses</title>

  <link rel="icon" type="image/png" href="favicon.png">

  <?php 
  if (isset($_GET['msg']) and $_GET['msg']=="PaymentSuccess")
  echo "<script>window.close();</script>";
  ?>
  <?php include'components/inc-css.php'; ?>
</head>

<body class="fixed-nav sticky-footer bg-dark" id="page-top">
  <!-- Navigation-->
  <?php include'components/nav-admin.php'; ?>

  <div class="content-wrapper">
    <div class="container-fluid">
    <?php
       include 'components/'.$page.'.php';
    ?>
    </div>

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fa fa-angle-up"></i>
    </a>

    <?php include'components/modals-'.$page.'.php'; ?>
    <?php include'components/footer.php'; ?>


    <?php include'components/inc-js.php'; ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
$("#category").bind("change", function() {
  if ($("#category").val() == "None") { }
  <?php
    if($find = mysqli_query($mysqli, "SELECT DISTINCT category From vouchers order by category asc"))
      while($arr = mysqli_fetch_array($find))
        echo 'else if ($("#category").val() == "'.$arr['category'].'") { $("#subcategory").attr("list", "'.$arr['category'].'");}';
  ?>
   else {}
});
</script>
  </div>
</body>

</html>
