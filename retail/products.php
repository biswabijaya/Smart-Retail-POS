<?php
include 'shopdb.php';

if (!isset($_SESSION['usertype'])) {
   header("Location: index.php");
 }

//default initialisations
$page="products";
$active=$page.'.php';
include 'components/script-'.$page.'.php';

//defaults
$selling="checked"; $sell="show";
$notselling=" "; $notsell="hide";

if (isset($_GET['selling']) and ($_GET['selling']=='hide')) {
  $selling=" "; $sell="hide";
}

if (isset($_GET['notselling']) and ($_GET['notselling']=='show')) {
  $notselling="checked"; $notsell="show";
}

if (isset($_GET['setview']) and isset($_GET['id'])) {
  $prodid=$_GET['id'];
  $view=$_GET['setview'];

  if($update = mysqli_query($mysqli, "UPDATE products set view=$view where id=$prodid")){
    header("Location: products.php?notselling=$notsell&selling=$sell&msg=UpdateSuccess");
  } else {
    header("Location: products.php?notselling=$notsell&selling=$sell&msg=UpdateNotSuccess");
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Products Inventory</title>

  <link rel="icon" type="image/png" href="favicon.png">

  <?php include'components/inc-css.php'; ?>
</head>

<body class="fixed-nav sticky-footer bg-dark sidenav-toggled" id="page-top">
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
    <script type="text/javascript">
      function toogleselling() {
        if($('#sellingtoogle').is(":checked")){
          $("#dataTable").fadeOut();
          location.href = 'products.php?notselling=<?php echo $notsell ?>&selling=show';
        } else if($('#sellingtoogle').is(":not(:checked)")){
          $("#dataTable").fadeOut();
          location.href = 'products.php?notselling=<?php echo $notsell ?>&selling=hide';
        }
      }

      function tooglenotselling() {
        if($('#notsellingtoogle').is(":checked")){
          $("#dataTable").fadeOut();
          location.href = 'products.php?notselling=show&selling=<?php echo $sell ?>';
        } else if($('#notsellingtoogle').is(":not(:checked)")){
          $("#dataTable").fadeOut();
          location.href = 'products.php?notselling=hide&selling=<?php echo $sell ?>';
        }
      }
    </script>
  </div>
</body>

</html>
