<?php
$productsfilter=" id>0 ";
//selling non selling filter
if (!isset($_GET['notselling'])) {
  $print_notselling="hide";
} else {
  $print_notselling=$_GET['notselling'];
}

if (!isset($_GET['selling'])) {
  $print_selling="show";
} else {
  $print_selling=$_GET['selling'];
  if ($_GET['selling']=="hide")
    $productsfilter.=" and view=0";
}


?>
<!-- Breadcrumbs-->
<ol class="breadcrumb">
  <li class="breadcrumb-item">
    <a href="dashboard.php">Smart Retail POS</a>
  </li>
  <li class="breadcrumb-item active">Stock</li>
  <li class="breadcrumb-item">
    <a href="products-pricing.php">Prices</a>
  </li>
  <li class="breadcrumb-item">
    <a href="products-expiring.php">Expiring Soon</a>
  </li>
</ol>
<!-- Example DataTables Card-->
<div class="card mb-3">
  <div class="card-header">
    <div class="row">
      <div class="col-md-4">
        <div class="text-left">
          <strong><a data-toggle="modal" data-target="#add-product" class="text-success">Add New Product</a></strong>
        </div>
      </div>
      <div class="col-md-8">
        <div class="text-right">
          <label class="custom-label">
            <div class="custom-toggle">
              <input class="custom-toggle-state" type="checkbox" id="notsellingtoogle" onchange="tooglenotselling();" <?php echo $notselling ?> >
              <div class="custom-toggle-inner">
                 <div class="custom-indicator"></div>
              </div>
              <div class="custom-active-bg"></div>
            </div>
            <div class="custom-label-text">Not-Selling</div>
          </label>
          &nbsp;&nbsp;&nbsp;
          <label class="custom-label">
            <div class="custom-toggle">
              <input class="custom-toggle-state" type="checkbox" id="sellingtoogle" onchange="toogleselling();" <?php echo $selling ?> >
              <div class="custom-toggle-inner">
                 <div class="custom-indicator"></div>
              </div>
              <div class="custom-active-bg"></div>
            </div>
            <div class="custom-label-text">Selling</div>
          </label>
        </div>
      </div>
    </div>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th>Name</th>
            <th>Brand</th>
            <th>Cat.</th>
            <th>Sub-Cat.</th>
            <th>STK</th>
            <th>HSN</th>
            <th>GST</th>
            <th>Supplier</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
          if($result = mysqli_query($mysqli, "SELECT * From products where $productsfilter order by name ASC"))
        	while($res = mysqli_fetch_array($result)){

            //initialisation
            $productid=$res['id'];
            $supplierid=$res['supplier'];
            $mrp=$res['mrp'];
            $stock=$discamount=0;
            $purchasestock=$salestock=0;
            $diskpreicon=$diskpposticon="";
            $discfromdate=date("Y-m-01");
            $disctodate=date("Y-m-d");


            //prchase stock
            if($find = mysqli_query($mysqli, "SELECT quantity From purchaseditems where productid=$productid"))
          	while($arr = mysqli_fetch_array($find))
            $purchasestock+=$arr['quantity'];

            //sale stock
            if($find = mysqli_query($mysqli, "SELECT quantity From solditems where productid=$productid"))
          	while($arr = mysqli_fetch_array($find))
            $salestock+=$arr['quantity'];

            //net stock
            $stock=$purchasestock-$salestock;
            $stock=number_format($stock, 2);

            if ($stock<=0) {
              $stock=0;
            }


            //text formatting based on stock
            if ($stock==0) {
              $textcolor="text-danger";
            } else if ($stock<=5) {
              $textcolor="text-warning";
            } else if ($stock<=10) {
              $textcolor="text-info";
            } else {
              $textcolor=" ";
            }

            //Supplier
            if ($supplierid==0) {
              $supplier="Not Set";
            } else {
              if($find = mysqli_query($mysqli, "SELECT * From suppliers where id=$supplierid"))
          	    while($arr = mysqli_fetch_array($find))
                  $supplier=$arr['name'];
            }

            //Discounts
            if($find = mysqli_query($mysqli, "SELECT * From prodiscounts where productid=$productid and (todate between '$discfromdate' and '$disctodate') "))
              while($arr = mysqli_fetch_array($find)){
                if ($arr['disctype']==1) {
                  $diskpreicon="₹";
                  $diskvalue=$arr['value'];
                  $diskpposticon=" OFF";
                  $discamount=$diskvalue;
                }else if ($arr['disctype']==2) {
                  $diskpreicon="";
                  $diskvalue=$arr['value'];
                  $diskpposticon="% OFF";
                  $discamount=$mrp*$diskvalue/100;
                }
              }


            //calculations
              //Buy Rate & Sale Price
              $gst=$res['gst'];
              $buyrate=$res['buyrate'];
              $saleprice=$mrp-$discamount;

              //GST
              $outputgst=$buyrate*$gst/100;
              $inputgst=$saleprice*$gst/100;
              $netgst=$inputgst-$outputgst;

              //Sale Rate & Buy Price
              $salerate=$saleprice-$inputgst;
              $buyprice=$buyrate+$outputgst;

              if ($res['view']==1) {
                $status="selling";
              } else {
                $status="not-selling";
              }

            if ($res['view']) {
              if (isset($_GET['selling']) and ($_GET['selling']=='hide')) {
                continue;
              }
            } else {
              if (!isset($_GET['notselling']) or ($_GET['notselling']=='hide')) {
                continue;
              }
            }


            echo '<tr class="'.$status.'">';
            echo '<td class="pl-0"><p class="mb-0 '.$textcolor.'" data-toggle="tooltip" data-placement="top" title="SKU: '.$res['sku'].'">'.$res['name'].'</p></td>';
            echo '<td class="pl-0"><p class="mb-0 '.$textcolor.'" data-toggle="tooltip" data-placement="top" title="HSN: '.$res['hsn'].'">'.$res['brand'].'</p></td>';
            echo '<td class="pl-0"><p class="mb-0 '.$textcolor.'">'.$res['category'].'</p></td>';
            echo '<td class="pl-0"><p class="mb-0 '.$textcolor.'">'.$res['subcategory'].'</p></td>';
            echo '<td class="pl-0"><p class="mb-0 '.$textcolor.'">'.$stock.'</p></td>';
            echo '<td class="pl-0"><p class="mb-0 '.$textcolor.'">'.$res['hsn'].'</p></td>';
            echo '<td class="pl-0"><p class="mb-0 '.$textcolor.'">'.$res['gst'].'</p></td>';
            echo '<td class="pl-0"><p class="mb-0 '.$textcolor.'" data-toggle="tooltip" data-placement="top" title="ID: '.$supplierid.'" >'.$supplier.'</p></td>';
            echo '<td class="px-0"><p class="mb-0 ">';
            echo '<a target="_blank"  href="product.php?id='.$res['id'].'&action=view" data-toggle="tooltip" data-placement="top" title="View Details"><i class="fa fa-search" style="color:green;"></i></a>&nbsp;';
            echo '<a target="_blank"  href="product.php?id='.$res['id'].'&action=edit" data-toggle="tooltip" data-placement="top" title="Edit Product"><i class="fa fa-pencil" style="color:purple;"></i></a>&nbsp;';
            echo '<a target="_blank"  href="report-product.php?id='.$res['id'].'" data-toggle="tooltip" data-placement="top" title="Purchase Sales Report"><i class="fa fa-exchange" style="color:blue;"></i></a>&nbsp;';

            if ($_SESSION['usertype']=='admin' or $_SESSION['usertype']=='manager') {
              if ($res['view']==1) {
                echo '<a href="products.php?id='.$res['id'].'&setview=0&notselling='.$print_notselling.'&selling='.$print_selling.'" data-toggle="tooltip" data-placement="top" title="Not Selling"><i class="fa fa-eye-slash" style="color:black;"></i></a>';
              } else {
                echo '<a href="products.php?id='.$res['id'].'&setview=1&notselling='.$print_notselling.'&selling='.$print_selling.'" data-toggle="tooltip" data-placement="top" title="Selling"><i class="fa fa-eye" style="color:black;"></i></a>';
              }
            }
            echo '</p></td>';
            echo '</tr>';

          }

           ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
