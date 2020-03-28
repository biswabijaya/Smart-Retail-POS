<?php
include 'db.php';

if (!isset($_GET['sku'])) {
  echo '<form method="get">
  <select name="sku"><option>all</option>';
  if($result = mysqli_query(getMysqli(), "SELECT * From products order by category ASC, subcategory, name ASC"))
    while($res = mysqli_fetch_array($result))
        echo'<option value="'.$res['sku'].'"> '.$res['category'].' - '.$res['subcategory'].' - '.$res['name'].'</option>';
  echo'</select>    <input type="submit" value="submit">
  </form>';
} else {
  if ($_GET['sku']=='all') {
    echo "<pre>";
    getProducts();
    echo "</pre>";
  } else {
    echo "<pre>";
    getProduct($_GET['sku']);
    echo "</pre>";
  }
}

function getProduct($sku=0){
  $json = array(); // declre array
  if($result = mysqli_query(getMysqli(), "SELECT id,sku,category,subcategory,name From products where sku='$sku'"))
    while($res = mysqli_fetch_assoc($result)){
      $id=$res['id'];
      $purchases = array();
      if($result1 = mysqli_query(getMysqli(), "SELECT purchaseid,staffid,supplierid,type,date,mrp,quantity,buyprice,sellprice,status From purchases t1, purchaseditems t2 where t1.id=t2.purchaseid and t2.productid=$id order by t2.purchaseid desc"))
        while($res1 = mysqli_fetch_assoc($result1)){
            $purchases[]=$res1;
        }

      $sales = array();
      if($result1 = mysqli_query(getMysqli(), "SELECT salesid,staffid,storecode,cno,date,quantity,mrp,sellprice,status From sales t1, solditems t2 where t1.id=t2.salesid and t2.productid=$id order by t2.salesid desc"))
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
  if($result = mysqli_query(getMysqli(), "SELECT id,sku,category,subcategory,name From products order by category ASC, subcategory, name ASC"))
    while($res = mysqli_fetch_assoc($result)){
      $id=$res['id'];
      $purchases = array();
      if($result1 = mysqli_query(getMysqli(), "SELECT purchaseid,staffid,supplierid,type,date,mrp,quantity,buyprice,sellprice,status From purchases t1, purchaseditems t2 where t1.id=t2.purchaseid and t2.productid=$id order by t2.purchaseid desc"))
        while($res1 = mysqli_fetch_assoc($result1)){
            $purchases[]=$res1;
        }

      $sales = array();
      if($result1 = mysqli_query(getMysqli(), "SELECT salesid,staffid,storecode,cno,date,quantity,mrp,sellprice,status From sales t1, solditems t2 where t1.id=t2.salesid and t2.productid=$id order by t2.salesid desc"))
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
