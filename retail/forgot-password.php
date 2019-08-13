<?php
include 'shopdb.php';

if (isset($_SESSION['id'])) {
  header("Location: dashboard.php");
}

if (isset($_POST['submit']) and $_POST['submit']=='step1') {

  $userid=$_SESSION['userid']=$_POST['userid'];
  $found="false";
  $error="| ID Not Found | Retry";

  if($result = mysqli_query($mysqli, "SELECT * From staffs Where id=$userid"))
  while($res = mysqli_fetch_array($result)){
    $cno=$_SESSION['cno']=$res['cno'];
    $found="true";
    $error=" ";
  }

  $otp=$_SESSION['otp']= rand(100000,999999);
  $otpid=$_SESSION['otpid']= rand(10,99);

  $url  ='http://message.websoftservices.com/api/sendmultiplesms.php';
  $url .='?username=sandeepanaacademy';
  $url .='&password=makemysms@123';
  $url .='&sender=SFRESH';
  $url .='&mobile='.$cno.'';
  $url .='&type=1&product=1';
  $url .='&message=OTP%20for%20Password%20Reset%20is%20'.$otp.'';
  $url .='%20With%20OTP%20KEY%20-%20'.$otpid.'';


  $curl = curl_init();
  curl_setopt_array($curl, array(
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => $url,
    CURLOPT_USERAGENT => 'Sandeepana Academy'
  ));
  // Send the request & save response to $resp
  $data = curl_exec($curl);
  // Close request to clear up some resources
  curl_close($curl);

} else if (isset($_POST['submit']) and $_POST['submit']=='step2'){
    $userid=$_SESSION['userid'];
    $pass = $_POST ['pass'];
    $pass = password_hash($pass, PASSWORD_DEFAULT);
    $otp1=(int)$_POST['otp'];
    $otp2=$_SESSION['otp'];
    $found="true";

      if ($otp1==$otp2){
        if ($result1 = mysqli_query($mysqli, "UPDATE staffs SET pass='$pass' WHERE id=$userid"))
          header("Location: logout.php?msg=PasswordResetSuccess");
      } else $error = "| Wrong OTP | Rety ";

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
  <title>Shanti Fresh | Password Reset</title>
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
      <div class="card-header">Password Reset <?php echo $error; ?></div>
      <div class="card-body">
        <form method="post">
          <div class="form-group">
            <label>Staff ID</label>
            <input class="form-control" name="userid" autocomplete="off" maxlength="4" type="text" <?php if (isset($found) and $found=='true') echo 'value="'.$_SESSION['userid'].'" disabled'; else echo 'placeholder="Enter Here"';  ?> >
          </div>

          <?php if (isset($found) and $found=='true') {?>
            <div class="form-group">
              <label>Contact No.</label>
              <input class="form-control" name="cno" type="text" value="<?php echo $_SESSION['cno']; ?>" disabled>
            </div>

            <div class="form-group">
              <label>OTP KEY - <?php echo $_SESSION['otpid']; ?> (<a onclick="lockoutSubmit(this)" data-toggle="tooltip" data-placement="top" data-original-title="Click here if OTP is not received within 3 Minutes" class="text-success" href="javascript:history.go(0)">Resend</a>)</label>
              <input class="form-control" type="text" maxlength="6" name="otp" placeholder="Enter OTP Received" >
            </div>
            <div class="form-group">
              <label>New Password</label>
              <input class="form-control" type="password" autocomplete="off" maxlength="10" name="pass" placeholder="Enter Password within 10 letters" >
            </div>
          <?php } ?>

          <?php
          if (!isset($found) or $found=='false') {
            echo '<button class="btn btn-primary btn-block" name="submit" value="step1" type="submit">Verify ID & Send OTP</button>';
          } else {
            echo '<button class="btn btn-primary btn-block" name="submit" value="step2" type="submit">Confirm</button>';
          }

          ?>

        </form>
        <br>
        <div class="text-center">
          <a class="d-block small" href="index.php">Back to Login</a>
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
