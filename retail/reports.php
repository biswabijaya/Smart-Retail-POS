<?php
include 'shopdb.php';

if (!isset($_SESSION['usertype'])) {
   header("Location: index.php");
 }

//default initialisations
$page="reports";
$active=$page.".php";

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Reports</title>

  <link rel="icon" type="image/png" href="favicon.png">

  <?php include'components/inc-css.php'; ?>
</head>

<body class="fixed-nav sticky-footer bg-dark" id="page-top">
  <!-- Navigation-->
  <?php include'components/nav-admin.php'; ?>

  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a class="<?php if (!isset($_GET['view'])) echo "text-muted"; else echo "active"; ?>" href="<?php echo $page; ?>.php">Overview</a>
        </li>
        <li class="breadcrumb-item ">
          <a href="<?php echo $page; ?>.php?view=revenue-analysis" class="<?php if (isset($_GET['view']) and $_GET['view']=='revenue-analysis') echo "text-muted"; else echo "active"; ?>">Revenue Analysis</a>
        </li>
        <li class="breadcrumb-item ">
          <a href="<?php echo $page; ?>.php?view=mostsold" class="<?php if (isset($_GET['view']) and $_GET['view']=='mostsold') echo "text-muted"; else echo "active"; ?>">Most Sold</a>
        </li>
        <li class="breadcrumb-item ">
          <a href="<?php echo $page; ?>.php?view=profitrank" class="<?php if (isset($_GET['view']) and $_GET['view']=='profitrank') echo "text-muted"; else echo "active"; ?>">Profit Rank</a>
        </li>
        <li class="breadcrumb-item ">
          <a href="<?php echo $page; ?>.php?view=highvalue" class="<?php if (isset($_GET['view']) and $_GET['view']=='highvalue') echo "text-muted"; else echo "active"; ?>">High value Sales</a>
        </li>
        <li class="breadcrumb-item ">
          <a href="<?php echo $page; ?>.php?view=fluctuations" class="<?php if (isset($_GET['view']) and $_GET['view']=='fluctuations') echo "text-muted"; else echo "active"; ?>">Fluctuations</a>
        </li>
        <li class="breadcrumb-item ">
          <a href="<?php echo $page; ?>.php?view=topurchase" class="<?php if (isset($_GET['view']) and $_GET['view']=='topurchase') echo "text-muted"; else echo "active"; ?>">To Purchase</a>
        </li>
        <li class="breadcrumb-item ">
          <a href="<?php echo $page; ?>.php?view=expiring" class="<?php if (isset($_GET['view']) and $_GET['view']=='expiring') echo "text-muted"; else echo "active"; ?>">Expiring Soon</a>
        </li>
        <li class="breadcrumb-item ">
          <a href="<?php echo $page; ?>.php?view=demandsupply" class="<?php if (isset($_GET['view']) and $_GET['view']=='demandsupply') echo "text-muted"; else echo "active"; ?>">Demand Supply</a>
        </li>
      </ol>

      <?php
      if (!isset($_GET['view'])){
        include 'components/overview.php';
      } else {
        include 'components/'.$_GET['view'].'.php';
      }
      ?>

    <!-- /.container-fluid-->
    <!-- /.content-wrapper-->
    <?php include'components/footer.php'; ?>

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fa fa-angle-up"></i>
    </a>

    <?php include'components/footer.php'; ?>


    <?php include'components/inc-js.php'; ?>
  </div>
</body>

</html>
