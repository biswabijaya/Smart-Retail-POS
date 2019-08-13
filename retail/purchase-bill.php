<?php
include 'shopdb.php';
if (!isset($_GET['id'])) {
   header("Location: error.php?msg=invnotfound");
 }else {
   $id=$_GET['id'];
 }

 if($result = mysqli_query($mysqli, "SELECT * From purchases where id=$id "))
 while($res = mysqli_fetch_array($result)){
   //initialisation
   $purchaseid=$res['id'];
   $staffid=$res['staffid'];
   $supplierid=$res['supplierid'];
   $billno=$res['billno'];
   $type=$res['type'];
   $date=$res['date'];
 }

 //Name Finds
 if($find = mysqli_query($mysqli, "SELECT * From suppliers where id=$supplierid "))
   while($arr = mysqli_fetch_array($find)){
     $suppliername=$arr['name'];
 }
 if($find = mysqli_query($mysqli, "SELECT * From staffs where id=$staffid "))
   while($arr = mysqli_fetch_array($find)){
     $staffname=$arr['name'];
 }

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />

	<title>INVOICE ID - <?php echo $id ?> </title>

	<link rel='stylesheet' type='text/css' href='print/css/style.css' />
	<link rel='stylesheet' type='text/css' href='print/css/print.css' media="print" />
	<script type='text/javascript' src='print/js/jquery-1.3.2.min.js'></script>
	<script type='text/javascript' src='print/js/example.js'></script>

</head>

<body>

	<div id="page-wrap" style="width: 700px; margin: 0 auto; ">

		<textarea id="header">INVOICE</textarea>

		<div id="identity">

            <div id="address">
              Store Address
            </div>

            <div id="logo">
              <div id="logohelp">
                <input id="imageloc" type="text" size="50" value="" /><br />
                (max width: 540px, max height: 100px)
              </div>
              <img id="image" src="print/images/logo.png" alt="logo" />
            </div>

		</div>

		<div style="clear:both"></div>

		<div id="customer">

            <div id="customer-title">Bill No. - <?php echo $billno; ?> </div>

            <table id="meta">
                <tr>
                    <td class="meta-head">Invoice #</td>
                    <td><div><?php echo $id; ?></div></td>
                </tr>
                <tr>
                    <td class="meta-head">Date</td>
                    <td><div><?php echo $date; ?></div></td>
                </tr>
                <tr>
                    <td class="meta-head">Supplier </td>
                    <td><div><?php echo $suppliername; ?></div></td>
                </tr>
                <tr>
                    <td class="meta-head">Staff</td>
                    <td><div><?php echo $staffname; ?></div></td>
                </tr>

            </table>

		</div>

		<table id="items">

		  <thead>
		    <th>Sr. No.</th>
		    <th>Description</th>
		    <th>Unit Price</th>
        <th>Qty</th>
        <th>Net Price</th>
        <th>Tax Type</th>
        <th>Tax Rate</th>
        <th>Tax Amount</th>
        <th>Total Amount</th>
		  </thead>

      <tbody>
        <?php $c=$tgst=$tbuy=$tqty=0;
        if($result = mysqli_query($mysqli, "SELECT * From purchaseditems where purchaseid=$id"))
        while($res = mysqli_fetch_array($result)){

          $productid=$res['productid'];
          $mrp=$res['mrp'];
          $buyprice=$res['buyprice'];
          $sellprice=$res['sellprice'];
          $quantity=$res['quantity'];
          $tqty+=$quantity;
          $tbuy+=$quantity*$buyprice;

          //Detail Finds
          if($find = mysqli_query($mysqli, "SELECT * From products where id=$productid "))
            while($arr = mysqli_fetch_array($find)){
              $name = $arr['name'];
              $brand = $arr['brand'];
              $type = $arr['type'];
              $hsn= $arr['hsn'];
              $gst= $arr['gst'];
              $unit= $arr['unit'];
          }

          echo '<tr>';
          echo '<td>'.++$c.'</td>';
  		    echo '<td><a href="https://shantifresh.com/shop/report-product.php?id='.$productid.'">'.$name.'</a> | MRP : '.$mrp.' | Sell : '.$sellprice.'</td>';
  		    echo '<td>'.($buyprice*(100-$gst)/100).'</td>';
  		    echo '<td>'.$quantity.'</td>';
          echo '<td>'.(($buyprice*$quantity)*(100-$gst)/100).'</td>';
          echo '<td>(CGST+SGST)</td>';
          echo '<td>('.($gst/2).'% +'.($gst/2).'%)</td>';
          echo '<td>('.($buyprice*$quantity*$gst/200).'+'.($buyprice*$quantity*$gst/200).')</td>';
          echo '<td>'.$buyprice*$quantity.'</td>';
          echo '</tr>';

          $tgst+=$buyprice*$quantity*$gst/100;
        }
        ?>
		  </tbody>

      <thead>
		    <th><?php echo $c; ?></th>
		    <th> </th>
		    <th> </th>
        <th> </th>
        <th> </th>
        <th> </th>
        <th> </th>
        <th><?php echo $tgst; ?></th>
        <th><?php echo $tbuy; ?></th>
		  </thead>

		</table>

    <br><br>
      <center>
        <h4>Payment Details</h4>
      </center>


      <table id="items" style="padding-top: 5px;">

  		  <thead>
  		    <th>Sr. No.</th>
  		    <th>Mode</th>
  		    <th>Mode Details</th>
          <th>Amount</th>
  		  </thead>

        <tbody>
          <?php $c=0;
          if($result = mysqli_query($mysqli, "SELECT * From purchasepayments where purchaseid=$id"))
          while($res = mysqli_fetch_array($result)){

            echo '<tr>';
            echo '<td>'.++$c.'</td>';
            echo '<td>'.$res['mode'].'</td>';
            echo '<td>'.$res['modedetails'].'</td>';
            echo '<td>'.$res['amount'].'</td>';
            echo '</tr>';
          }
          ?>
  		  </tbody>

  		</table>
    <br><br>
		<div id="terms">
		  <h5>Thank You</h5>
		  <div>This is a computer generated invoice no signature required.</div>
		</div>

	</div>

</body>

</html>
