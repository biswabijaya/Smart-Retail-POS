<?php
include 'shopdb.php';

if (!isset($_SESSION['id']) and $_SESSION['usertype']!='admin') {
  header("Location: index.php");
}

if (!isset($_GET['id'])) {
  header("Location: index.php");
} else {
  $id=$_GET['id'];
}

$page="report-product";
$active="products.php";

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Purchase Sale Report</title>

  <link rel="icon" type="image/png" href="favicon.png">

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

    <?php include'components/footer.php'; ?>


    <?php include'components/inc-js.php'; ?>
  </div>
</body>

</html>
