<!-- Breadcrumbs-->
<ol class="breadcrumb">
  <li class="breadcrumb-item">
    <a href="dashboard.php">Smart Retail POS</a>
  </li>
  <li class="breadcrumb-item "> <a href="products.php"> Product Inventory & Stock </a></li>
  <li class="breadcrumb-item active">
    See MFD Expiery
  </li>
</ol>
<!-- Example DataTables Card-->
<div class="card mb-3">
  <div class="card-header">
    <i class="fa fa-table"></i> Product Inventory - MRP, Rates and GST Shown here is based on Default Input</div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th>Name</th>
            <th>Brand</th>
            <th>Cat.</th>
            <th>Sub-Cat.</th>
            <th>STK</th>
            <th>MFD</th>
            <th>EXP</th>
            <th>Supplier</th>
            <th>Action</th>
          </tr>
        </thead>
        <tfoot>
          <tr>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
          </tr>
        </tfoot>
        <tbody>
          <?php
          if($result = mysqli_query($mysqli, "SELECT * From products order by name ASC"))
        	while($res = mysqli_fetch_array($result)){



            //initialisation
            $productid=$res['id'];
            $supplierid=$res['supplier'];
            $mrp=$res['mrp'];
            $stock=$discamount=$purchasestock=$salestock=0;
            $diskpreicon=$diskpposticon="";
            $discfromdate=date("Y-m-01");
            $disctodate=date("Y-m-d");


            //prchase stock
            if($find = mysqli_query($mysqli, "SELECT * From purchaseditems where productid=$productid"))
          	while($arr = mysqli_fetch_array($find))
            $purchasestock+=$arr['quantity'];

            //sale stock
            if($find = mysqli_query($mysqli, "SELECT * From solditems where productid=$productid"))
          	while($arr = mysqli_fetch_array($find))
            $salestock+=$arr['quantity'];

            //net stock
            $stock=$purchasestock-$salestock;


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

            echo '<tr>';
            echo '<td><p class="'.$textcolor.'" data-toggle="tooltip" data-placement="top" title="SKU: '.$res['sku'].'">'.$res['name'].'</p></td>';
            echo '<td><p class="'.$textcolor.'" data-toggle="tooltip" data-placement="top" title="HSN: '.$res['hsn'].'">'.$res['brand'].'</p></td>';
            echo '<td><p class="'.$textcolor.'">'.$res['category'].'</p></td>';
            echo '<td><p class="'.$textcolor.'">'.$res['subcategory'].'</p></td>';
            echo '<td><p class="'.$textcolor.'">'.$stock.'</p></td>';
            echo '<td><p class="'.$textcolor.'">dd/mm/yy</p></td>';
            echo '<td><p class="'.$textcolor.'">dd/mm/yy</p></td>';
            echo '<td><p class="'.$textcolor.'" data-toggle="tooltip" data-placement="top" title="ID: '.$supplierid.'">'.$supplier.'</p></td>';
            echo '<td><p>';
            echo '<a target="_blank"  href="product.php?id='.$res['id'].'&action=view" data-toggle="tooltip" data-placement="top" title="View Details"><i class="fa fa-search" style="color:green;"></i></a>&nbsp;';
            echo '<a target="_blank"  href="product.php?id='.$res['id'].'&action=edit" data-toggle="tooltip" data-placement="top" title="Edit Product"><i class="fa fa-pencil" style="color:purple;"></i></a>&nbsp;';
            echo '<a target="_blank"  href="report-product.php?id='.$res['id'].'" data-toggle="tooltip" data-placement="top" title="Purchase Sales Report"><i class="fa fa-exchange" style="color:blue;"></i></a>&nbsp;';
            echo '</p></td>';
            echo '</tr>';

          }

           ?>
        </tbody>
      </table>
    </div>
  </div>
  <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
</div>
