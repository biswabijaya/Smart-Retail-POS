<?php
include 'db.php';

if(!isset($_GET['table'])){
  echo '<br><a href="getTable.php?table=actionrecords" >actionrecords </a>
<br><a href="getTable.php?table=adminntf" >adminntf</a>
<br><a href="getTable.php?table=counter" >counter</a>
<br><a href="getTable.php?table=expense" >expense</a>
<br><a href="getTable.php?table=fluctuationreport" >fluctuationreport</a>
<br><a href="getTable.php?table=gsthsn" >gsthsn</a>
<br><a href="getTable.php?table=highvaluereport" >highvaluereport</a>
<br><a href="getTable.php?table=hsn" >hsn</a>
<br><a href="getTable.php?table=locations" >locations</a>
<br><a href="getTable.php?table=mostsoldreport" >mostsoldreport</a>
<br><a href="getTable.php?table=ordertracking" >ordertracking</a>
<br><a href="getTable.php?table=pages" >pages</a>
<br><a href="getTable.php?table=pictures" >pictures</a>
<br><a href="getTable.php?table=pimages" >pimages</a>
<br><a href="getTable.php?table=pinfs" >pinfs</a>
<br><a href="getTable.php?table=previews" >previews</a>
<br><a href="getTable.php?table=prodiscounts" >prodiscounts</a>
<br><a href="getTable.php?table=products" >products</a>
<br><a href="getTable.php?table=profitrankreport" >profitrankreport</a>
<br><a href="getTable.php?table=ptags" >ptags</a>
<br><a href="getTable.php?table=purchaseditems" >purchaseditems</a>
<br><a href="getTable.php?table=purchasepayments" >purchasepayments</a>
<br><a href="getTable.php?table=purchases" >purchases</a>
<br><a href="getTable.php?table=pvariants" >pvariants</a>
<br><a href="getTable.php?table=salepayments" >salepayments</a>';
} else {
echo "<pre>";
printTableData($_GET['table']);
echo "</pre>";
}

function printTableData($table='products'){
  $json = array(); // declre array
  if($result = mysqli_query(getMysqli(), "SELECT * From $table"))
    while($res = mysqli_fetch_assoc($result))
      $json[]=$res;
  echo json_encode($json, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
}
?>
