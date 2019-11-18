<?php
if(!isset($_SESSION)) { session_start(); }

//set timezone
date_default_timezone_set('Asia/Kolkata');
setlocale(LC_MONETARY, 'en_IN');

$databaseHost = 'localhost';
$databaseName = 'u704461052_shop';
$databaseUsername = 'u704461052_user';
$databasePassword = 'mko0<LP_';

$mysqli =  mysqli_connect($databaseHost, $databaseUsername, $databasePassword, $databaseName);


DEFINE ('DB_USER', 'u704461052_user');
DEFINE ('DB_PASSWORD', 'mko0<LP_');
DEFINE ('DB_HOST', 'localhost');
DEFINE ('DB_NAME', 'u704461052_shop');

function getMysqli() {
  $dbc = mysqli_connect (DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

  if (!$dbc) {
    trigger_error ('Could not connect to MySQL: ' . mysqli_connect_error() );
  } else {
    return $dbc;
  }
}

$_SESSION['DIR']="";
$active=" ";
?>
