<?php
include 'db.php';

if (((isset($_GET['cno']) and isset($_GET['action'])) and $_GET['action']=="loginuser" )) {
  $cno = $_GET['cno']; $id = 0;
  if($query = mysqli_query(getMysqli(),"SELECT * FROM staffs WHERE cno = $cno")){
    while($row = mysqli_fetch_array($query)){
      $id = $row['id'];
    }
  }
  echo $id;
}

if (((isset($_GET['cno']) and isset($_GET['action'])) and $_GET['action']=="getdata" )) {
   echo getUserDataJson($_GET['cno']);
}
else echo 0;


function getUserDataJson($cno=0){
  if($query = mysqli_query(getMysqli(),"SELECT * FROM staffs WHERE cno = $cno")){
    while ($row = mysqli_fetch_assoc($query)) {
    echo  json_encode($row);
    }
  }
}
?>
