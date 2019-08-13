<?php
$fromdate=$todate=$today=date("Y-m-d");
$establisheddate='2018-08-24';

$date=date('Y-m-d');

  $fromdate=date('Y-m-01', strtotime($date));
  $todate=date('Y-m-t', strtotime($date));
  $prevfromdate=date('Y-m-01', strtotime("-1 month", strtotime($date)));
  $prevtodate=date('Y-m-t', strtotime("-1 month", strtotime($date)));
  $daysRemaining = (int)date('t', $date) - (int)date('j', $date);


?>
<div class="row mt-3">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <span class="typename">To Purchase List - AI Based Prection Algorithm </span>
      </div>
      <div class="card-body">
        <div id="reportbody">
          <div class="table-responsive">
            <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>Rank</th>
                  <th>Name</th>
                  <th>SKU</th>
                  <th>Brand</th>
                  <th>Current Stock</th>
                  <th>Current Demand</th>
                  <th>To Buy</th>
                  <th>Unit</th>
                  <th>Store</th>
                </tr>
              </thead>
              <tbody>
                <?php $c=1;
                    if($result = mysqli_query($mysqli, "SELECT productid,name,sku,brand,category,subcategory,quantity,storecode,unit From mostsoldreport,products where (mostsoldreport.fromdate='$prevfromdate' and mostsoldreport.todate='$prevtodate') and (products.id=mostsoldreport.productid)"))
                    while($res = mysqli_fetch_array($result)){

                      $pid=$res['productid'];
                      $qty=$res['quantity'];
                      $pqty=$sqty=$tobuyqty=$expbuyqty=$currpqty=0;

                      if($results = mysqli_query($mysqli, "SELECT SUM(quantity) as quantity FROM sales,solditems WHERE  solditems.salesid=sales.id and ( sales.date BETWEEN '2018-01-01' AND '$todate') and productid=$pid"))
                      while($ress = mysqli_fetch_array($results)){
                        $tsqty=$ress['quantity'];
                      }

                      if($results = mysqli_query($mysqli, "SELECT SUM(quantity) as quantity FROM purchases,purchaseditems WHERE purchaseditems.purchaseid=purchases.id and ( purchases.date BETWEEN '2018-01-01' AND '$todate') and productid=$pid"))
                      while($ress = mysqli_fetch_array($results)){
                        $tpqty=$ress['quantity'];
                      }


                      echo '<tr>';
                      echo '<td><p class="mb-0">'.$c++.'</p></td>';
                      echo '<td><p class="mb-0">'.$res['name'].'</p></td>';
                      echo '<td><p class="mb-0">'.$res['sku'].'</p></td>';
                      echo '<td><p class="mb-0" data-toggle="tooltip" data-placement="top" title="'.$res['category'].'/'.$res['subcategory'].'">'.$res['brand'].'</p></td>';
                      echo '<td><p class="mb-0"><b>'.utf8_encode(money_format('%!i',$currpqty)).'</b></p></td>';
                      echo '<td><p class="mb-0"><b>'.utf8_encode(money_format('%!i',$demand)).'</b></p></td>';
                      echo '<td><p class="mb-0 text-success"><b>'.utf8_encode(money_format('%!i',$tobuyqty)).'</b></p></td>';
                      echo '<td><p class="mb-0">'.$res['unit'].'</p></td>';
                      echo '<td><p class="mb-0">'.$res['storecode'].'</p></td>';
                      echo '</tr>';
                    }
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
