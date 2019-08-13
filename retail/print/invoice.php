<?php
include '../config/db.php';
if (!isset($_SESSION['usertype'])) {
   header("Location: ../account");
 }
$address="Campus I";
$txnid=$_GET['id'];
if($result = mysqli_query($mysqli, "SELECT * From payments WHERE txnid=$txnid")) {
  while($res = mysqli_fetch_array($result))
  {
    $studentid=$res['studentid'];
    $amount=$res['amount'];
    $mode=$res['mode'];
    $remark=$res['remark'];
    $reason=$res['reason'];
    $date=$res['date'];
    $date=date("F d,Y", strtotime($date));
    $collector=$res['collector'];

    if($result1 = mysqli_query($mysqli, "SELECT * From pmode WHERE id='$mode'"))
      while($res1 = mysqli_fetch_array($result1))
        $mode=$res1['name'];

    if($result1 = mysqli_query($mysqli, "SELECT * From students WHERE studentid='$studentid'"))
      while($res1 = mysqli_fetch_array($result1))
        {$name=$res1['name']; $cno=$res1['cno'];}

  }
}else {
  header("Location: ../account");
}


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />

	<title>Print Collection Receipt</title>

	<link rel='stylesheet' type='text/css' href='css/style.css' />
	<link rel='stylesheet' type='text/css' href='css/print.css' media="print" />
	<script type='text/javascript' src='js/jquery-1.3.2.min.js'></script>
	<script type='text/javascript' src='js/example.js'></script>

</head>

<body>

	<div id="page-wrap" style="width: 700px; margin: 0 auto; ">

		<textarea id="header">INVOICE</textarea>

		<div id="identity">

            <div id="address">
              SNDP ID :  <b><?php echo $studentid; ?></b> <br>
              Contact : <?php echo $cno; ?>


            </div>

            <div id="logo">
              <div id="logohelp">
                <input id="imageloc" type="text" size="50" value="" /><br />
                (max width: 540px, max height: 100px)
              </div>
              <img id="image" src="images/logo.png" alt="logo" />
            </div>

		</div>

		<div style="clear:both"></div>

		<div id="customer">

            <div id="customer-title"> <?php echo $name; ?> </div>

            <table id="meta">
                <tr>
                    <td class="meta-head">Invoice #</td>
                    <td><div><?php echo $txnid; ?></div></td>
                </tr>
                <tr>

                    <td class="meta-head">Date</td>
                    <td><div><?php echo $date; ?></div></td>
                </tr>

            </table>

		</div>

		<table id="items">

		  <tr>
		      <th>Reason</th>
          <th>Payment Mode</th>
		      <th>Description</th>
		      <th>Collector ID</th>
		      <th>Amount</th>
		  </tr>

		  <tr class="item-row">
		      <td><?php echo $reason; ?></td>
          <td><?php echo $mode; ?></td>
          <td><?php echo $remark; ?></td>
          <td><?php echo $collector; ?></td>
          <td><?php echo $amount; ?></td>
		  </tr>


		</table>
    <br><br>
		<div id="terms">
		  <h5>Thank You</h5>
		  <div>This is a computer generated invoice no signature required.</div>
		</div>

	</div>

</body>

</html>
