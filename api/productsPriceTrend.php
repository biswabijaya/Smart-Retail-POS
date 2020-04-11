<?php
include 'db.php';

header("Access-Control-Allow-Origin: http://localhost:8000");
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header("Access-Control-Allow-Headers: Content-Type, Authorization");

if(isset($_GET['productOptions'])){
  if($result = mysqli_query(getMysqli(), "SELECT * From products order by category ASC, subcategory, name ASC"))
    while($res = mysqli_fetch_array($result))
        echo'<option value="'.$res['sku'].'"> '.$res['category'].' - '.$res['subcategory'].' - '.$res['name'].'</option>';
} else if (!isset($_GET['sku'])) {
  echo '<form method="get">
  <select class="form-control" name="sku"><option>all</option>';
  if($result = mysqli_query(getMysqli(), "SELECT * From products order by category ASC, subcategory, name ASC"))
    while($res = mysqli_fetch_array($result))
        echo'<option value="'.$res['sku'].'"> '.$res['category'].' - '.$res['subcategory'].' - '.$res['name'].'</option>';
  echo'</select> <br>   <input class="form-control" type="submit" value="submit">
  </form>';
} else if(isset($_GET['sku'])){
  if ($_GET['sku']=='all') {
    getProducts();
  } else {
    getProduct($_GET['sku']);
  }
}
function getProduct($sku=0){
  $json = array(); // declre array
  $custom='';
  if(isset($_GET['fromdate']) and isset($_GET['todate'])){
    $custom=" and t1.date (between '".$_GET['fromdate']."' and '".$_GET['todate']."')";
  } else if (isset($_GET['fromdate'])) {
    $custom=" and t1.date > '".$_GET['fromdate']."'";
  } else if (isset($_GET['todate'])) {
    $custom=" and t1.date < '".$_GET['todate']."'";
  }
  echo "SELECT purchaseid,staffid,supplierid,type,date,mrp,quantity,buyprice,sellprice,status From purchases t1, purchaseditems t2 where t1.id=t2.purchaseid and  t2.productid=$id $custom order by t2.purchaseid asc";
  if($result = mysqli_query(getMysqli(), "SELECT id,sku,category,subcategory,name,icon,brand,unit,status,type From products where sku='$sku'"))
    while($res = mysqli_fetch_assoc($result)){
      $id=$res['id'];
      $purchases = $sales = array();
      if($result1 = mysqli_query(getMysqli(), "SELECT purchaseid,staffid,supplierid,type,date,mrp,quantity,buyprice,sellprice,status From purchases t1, purchaseditems t2 where t1.id=t2.purchaseid and t2.productid=$id $custom order by t2.purchaseid asc"))
        while($res1 = mysqli_fetch_assoc($result1)){
            $purchases[]=$res1;
        }
      if($result1 = mysqli_query(getMysqli(), "SELECT salesid,staffid,storecode,cno,date,quantity,mrp,sellprice,status From sales t1, solditems t2 where t1.id=t2.salesid and t2.productid=$id  $custom order by t2.salesid asc"))
      while($res1 = mysqli_fetch_assoc($result1)){
          $sales[]=$res1;
      }

      $data = array (
        'id' => $res['id'],
        'sku' => $res['sku'],
        'icon' => $res['icon'],
        'name' => $res['name'],
        'category' => $res['category'],
        'subcategory' => $res['subcategory'],
        'brand' => $res['brand'],
        'type' => $res['type'],
        'unit' => $res['unit'],
        'status' => $res['status'],
        'purchases' => $purchases,
        'sales' => $sales,
      );
      $json[]=$data;
    }
  echo json_encode($json, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
}

function getProducts(){
  $json = array(); // declre array
  $custom='';
  if(isset($_GET['fromdate']) and isset($_GET['todate'])){
    $custom=" and t1.date (between '".$_GET['fromdate']."' and '".$_GET['todate']."')";
  } else if (isset($_GET['fromdate'])) {
    $custom=" and t1.date > '".$_GET['fromdate']."'";
  } else if (isset($_GET['todate'])) {
    $custom=" and t1.date < '".$_GET['todate']."'";
  }
  if($result = mysqli_query(getMysqli(), "SELECT id,sku,category,subcategory,name,icon,brand,unit,status,type From products order by category ASC, subcategory, name ASC"))
    while($res = mysqli_fetch_assoc($result)){
      $id=$res['id'];
      $purchases = $sales = array();
      if($result1 = mysqli_query(getMysqli(), "SELECT purchaseid,staffid,supplierid,type,date,mrp,quantity,buyprice,sellprice,status From purchases t1, purchaseditems t2 where t1.id=t2.purchaseid and  t2.productid=$id $custom order by t2.purchaseid asc"))
        while($res1 = mysqli_fetch_assoc($result1)){
            $purchases[]=$res1;
        }
      if($result1 = mysqli_query(getMysqli(), "SELECT salesid,staffid,storecode,cno,date,quantity,mrp,sellprice,status From sales t1, solditems t2 where t1.id=t2.salesid and t2.productid=$id $custom order by t2.salesid asc"))
      while($res1 = mysqli_fetch_assoc($result1)){
          $sales[]=$res1;
      }
      $data = array (
        'id' => $res['id'],
        'sku' => $res['sku'],
        'icon' => $res['icon'],
        'name' => $res['name'],
        'category' => $res['category'],
        'subcategory' => $res['subcategory'],
        'brand' => $res['brand'],
        'type' => $res['type'],
        'unit' => $res['unit'],
        'status' => $res['status'],
        'purchases' => $purchases,
        'sales' => $sales,
      );
      $json[]=$data;
    }
  echo json_encode($json, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
}

?>
