<?php
include 'shopdb.php';

if (isset($_SESSION['id'])) {
  header("Location: dashboard.php");
}


  $error="none";
  $errormsg="none";

  if (isset($_GET['msg'])) {
    $error="pass";
    $errormsg=$_GET['msg'];
  }

  if (isset($_POST['login']) && $_POST['login']=="Login" ){

    $error="id";
    $errormsg="Invalid ID";

  	$userid=$id = mysqli_real_escape_string($mysqli, $_POST['id']);
  	$pass = mysqli_real_escape_string($mysqli, $_POST['pass']);

  	if($result = mysqli_query($mysqli, "SELECT * From staffs Where id=$userid and status>=1")){
  	while($res = mysqli_fetch_array($result))
  	{ $error="pass";
      $errormsg="Invalid Password";
  		if (password_verify($pass, $res['pass']))
  		{
        $_SESSION['id'] = $res['id'];
        $_SESSION['username']=$res['name'];
        $_SESSION['usertype']=$res['usertype'];
        header('Location: sales.php');

    	}
  	}
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>Shanti Fresh</title>
  <!-- Bootstrap core CSS-->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom fonts for this template-->
  <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <!-- Custom styles for this template-->
  <link href="css/sb-admin.css" rel="stylesheet">
</head>

<body class="bg-dark">
  <div class="container">
    <div class="card card-login mx-auto mt-5">
      <div class="card-header">Login</div>
      <div class="card-body">
        <form method="post">
          <div class="form-group">
            <label>User ID</label>
            <input class="form-control" name="id" autocomplete="off" maxlength="4" type="text" placeholder="Enter Staff ID">
          </div>
          <div class="form-group">
            <label>Password</label>
            <input class="form-control" name="pass" autocomplete="off" type="password" placeholder="Enter Password">
          </div>
          <div class="form-group">
            <div class="form-check">
              <label class="form-check-label">
                <input class="form-check-input" type="checkbox"> Remember Password</label>
            </div>
          </div>
          <button class="btn btn-primary btn-block" name="login" value="Login" type="submit">Login</button>
        </form>
        <br>
        <div class="text-center">
          <a class="d-block small" href="forgot-password.php">Forgot Password?</a>
        </div>
      </div>
    </div>
  </div>
  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
</body>

</html>
