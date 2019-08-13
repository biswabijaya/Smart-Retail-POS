<?php

include 'shopdb.php';

if (!isset($_SESSION['usertype'])) {
   header("Location: index.php");
 }

//default initialisations
$page="product";
$action="disabled";
$title="Product";
$active=$page.'s.php';

if (isset($_GET['action']) and $_GET['action']=="edit") {
  $action="required";
  include 'components/script-productupdate.php';
  $title.=" Edit";
} else {
  $title.=" View";
}

$title.=" Page";

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title><?php echo $title; ?></title>

  <link rel="icon" type="image/png" href="favicon.png">

  <?php include'components/inc-css.php'; ?>
</head>

<body class="bg-dark">
  <div class="container">
    <?php include'components/'.$page.'.php'; ?>
  </div>
  <?php include'components/inc-js.php'; ?>
</body>

</html>
