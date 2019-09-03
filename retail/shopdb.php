<?php
if(!isset($_SESSION)) { session_start(); }

//set timezone
date_default_timezone_set('Asia/Kolkata');
setlocale(LC_MONETARY, 'en_IN');

$cno = $_POST["phoneNum"];
$databaseHost = 'localhost';
$databaseName = 'u704461052_shop';
$databaseUsername = 'u704461052_user';
$databasePassword = 'mko0<LP_';
$mysql_qry = "select * from pos where mobileno like '$mobileno'";

$mysqli =  mysqli_connect($databaseHost, $databaseUsername, $databasePassword, $databaseName);
$result = mysqli_query($mysqli,$mysql_qry);
if($mysqli_num_rows($result) > 0) {
  echo "Login success";
}
else {
  echo "Login not success";
}



$_SESSION['DIR']="";
$active=" ";
?>
