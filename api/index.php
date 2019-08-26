<?php
include '../retail/shopdb.php';

if (isset($_POST['pno'])) {
  echo 0;
} else {
  $pno=$_POST['pno'];
}

  if ($pno)
  	if($result = mysqli_query($mysqli, "SELECT * From staffs Where pno=$userid and status>=1"))
    	while($res = mysqli_fetch_array($result))
    	 echo 1;


?>
