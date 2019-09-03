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

$_SESSION['DIR']="";
$active=" ";
?>
