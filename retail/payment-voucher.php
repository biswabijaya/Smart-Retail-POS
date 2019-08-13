<?php
include 'shopdb.php';

if (!isset($_SESSION['id'])) {
  header("Location: index.php");
}

if (!isset($_GET['id'])) {
  header("Location: expenses.php?msg=IDNotFound");
} else {
  $id=$_GET['id'];
  $date=date("Y-m-d");
  if($result = mysqli_query($mysqli, "SELECT * From vouchers where id=$id"))
  while($res = mysqli_fetch_array($result))
    $amount=$res['amount'];
}

$doneby=$_SESSION['id'];
$usertype=$_SESSION['usertype'];

if (isset($_POST['submit']) and $_POST['submit']=='pay') {

  $amount=$_POST['amount'];
  $mode=$_POST['mode'];
  $modedetails=$_POST['modedetails'];
  $date=$_POST['date'];
  $payto=$_POST['payto'];

  if ($vchpayment = mysqli_query($mysqli, "INSERT INTO `expense` (`payid`, `amount`, `mode`, `modedetails`, `type`, `paidto`, `paidby`, `date`) VALUES ('$id', '$amount', '$mode', '$modedetails', 'voucher', '$payto', '$doneby', '$date')")) {
    header("Location: expenses.php?msg=PaymentSuccess");
  }else {
    header("Location: expenses.php?msg=PaymentNotSuccess");
  }
}






?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>Voucher Payment </title>
  <!-- Bootstrap core CSS-->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom fonts for this template-->
  <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <!-- Custom styles for this template-->
  <link href="css/sb-admin.css" rel="stylesheet">
</head>

<body class="bg-dark">
  <div class="container">

    <div class="card card-login mx-auto mt-5">
      <div class="card-header">
        <div class="row">
          <div class="col-8">
            Expense ID - <?php echo $id; ?>
          </div>
          <div class="col-4">

          </div>
        </div>
      </div>
      <div class="card-body">
        <form method="post" id="paymentform">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Date</label>
                <input class="form-control" type="date" name="date" min="2018-10-01" max="<?php echo $date; ?>" value="<?php echo $date; ?>" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Pay Amount </label>
                <input class="form-control" id="amount" name="amount" type="number" value="<?php echo $amount; ?>" readonly>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label>Pay To </label>
                <input class="form-control" id="payto" name="payto" type="text" maxlength="38" placeholder="Enter Name" autofocus>
              </div>
            </div>
          </div>
          <hr>
          <div class="form-group">
            <label>Payment Mode</label >
            <select class="form-control" name="mode" id="cashmode" onchange="genmodedetails();">
              <option>Cash</option>
              <option>Credit Card</option>
              <option>Debit Card</option>
              <option>Cheque/DD</option>
              <option>IMPS/NEFT</option>
              <option value="UPI">UPI/BHIM/TEZ/PhonePe</option>
              <option>Paytm</option>
            </select>
          </div>

            <div class="row" id="cash">
              <div class="col-md-6">
                <div class="form-group">
                  <label> Cash Paid </label>
                  <input class="form-control" id="cashpaid" type="number" onkeyup="cashfunc();" type="number" placeholder="Enter Here" >
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Return Cash</label>
                  <input class="form-control" id="cashreturn" type="number" min="0" <?php if ($_GET['type']=="purchasepayments") echo 'onchange="cashprint2()"'; else echo 'onchange="cashprint()"'; ?> onchange="cashprint();"  readonly>
                </div>
              </div>
              <?php if ($_GET['type']=="purchasepayments") { ?>
                <div class="col-md-12">
                  <div class="form-group">
                    <label>Payment Source</label>
                    <select class="form-control" id="cashsource" <?php echo 'onchange="cashprint2()"'; ?> >
                      <option value=" ">Not Specified</option>
                      <option>COUNTER</option>
                    </select>
                  </div>
                </div>
              <?php } ?>
            </div>

            <div class="row" id="creditcard" style="display: none;">
              <div class="col-md-6">
                <div class="form-group">
                  <label> Last 4 Digit </label>
                  <input class="form-control" id="creditcardno" type="text" maxlength="4" onkeyup="creditcardprint();" type="number" placeholder="Enter Here" >
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label> Card Type </label>
                  <select class="form-control" id="creditcardtype" onchange="credicardprint();" required>
                    <option>RUPAY</option>
                    <option>VISA</option>
                    <option>MASTER</option>
                    <option>MAESTRO</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="row" id="debitcard" style="display: none;">
              <div class="col-md-6">
                <div class="form-group">
                  <label> Last 4 Digit </label>
                  <input class="form-control" id="debitcardno" type="text" maxlength="4" onkeyup="debitcardprint();" type="number" placeholder="Enter Here" >
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label> Card Type </label>
                  <select class="form-control" id="debitcardtype" onchange="debitcardprint();" required>
                    <option>RUPAY</option>
                    <option>VISA</option>
                    <option>MASTER</option>
                    <option>MAESTRO</option>
                  </select>
                </div>
              </div>
            </div>

            <div class="row" id="paytm" style="display: none;">
              <div class="col-md-12">
                <div class="form-group">
                  <label> Txn Id. </label>
                  <input class="form-control" id="txnid" min="20000000000" onkeyup="paytmprint();" type="number" placeholder="Enter Here" >
                </div>
              </div>
            </div>

            <div class="row" id="impsneft" style="display: none;">
              <div class="col-md-12">
                <div class="form-group">
                  <label> UTR No. </label>
                  <input class="form-control" id="utr" min="20000000000" onkeyup="impsneftprint();" type="number" placeholder="Enter Here" >
                </div>
              </div>
            </div>

            <div class="row" id="upi" style="display: none;">
              <div class="col-md-12">
                <div class="form-group">
                  <label> UTR No. </label>
                  <input class="form-control" id="upiutr" min="20000000000" onkeyup="upiprint();" type="number" placeholder="Enter Here" >
                </div>
              </div>
            </div>

            <div class="row" id="cheque" style="display: none;">
              <div class="col-md-12">
                <div class="form-group">
                  <label>Choose Bank</label>
                  <select class="form-control" id="bank" onchange="chequeprint();">
                    <option value="NONE">---Select Bank---</option>
                    <option value="AIRM">Airtel Payments Bank</option>
                    <option value="ALLB">Allahabad Bank</option>
                    <option value="ANDH">Andhra Bank</option>
                    <option value="AXIS">Axis Bank</option>
                    <option value="BANB">Bandhan Bank</option>
                    <option value="BASS">Bassien Catholic Co-Operative Bank</option>
                    <option value="BNPP">BNP Paribas</option>
                    <option value="BOBK">Bank of Bahrain and Kuwait</option>
                    <option value="BOBB">Bank of Baroda</option>
                    <option value="BOBC">Bank of Baroda Corporate</option>
                    <option value="BOBR">Bank of Baroda Retail</option>
                    <option value="BOI">Bank of India</option>
                    <option value="BOM">Bank of Maharashtra</option>
                    <option value="CNB">Canara Bank</option>
                    <option value="CSB">Catholic Syrian Bank</option>
                    <option value="CBI">Central Bank</option>
                    <option value="CITI">Citibank</option>
                    <option value="CUNB">City Union Bank</option>
                    <option value="CORP">Corporation Bank</option>
                    <option value="COSMO">Cosmos Co-op Bank</option>
                    <option value="DBS">digibank by DBS</option>
                    <option value="DCB">DCB BANK LTD</option>
                    <option value="DENA">Dena Bank</option>
                    <option value="DEUT">Deutsche Bank</option>
                    <option value="DHAN">Dhanalakshmi Bank</option>
                    <option value="FEDB">Federal Bank</option>
                    <option value="HDFC">HDFC Bank</option>
                    <option value="ICICI">ICICI Bank</option>
                    <option value="IDBI">IDBI Bank</option>
                    <option value="IDFC">IDFC Bank</option>
                    <option value="INDIAN">Indian Bank</option>
                    <option value="INDUS">IndusInd Bank</option>
                    <option value="IOB">Indian Overseas Bank</option>
                    <option value="JNTP">JANATA SAHAKARI BANK LTD PUNE</option>
                    <option value="JNKB">J And K Bank</option>
                    <option value="KNTK">Karnataka Bank</option>
                    <option value="KRVS">Karur Vysya Bank</option>
                    <option value="LVBR">Lakshmi Vilas Bank - Retail</option>
                    <option value="LVBC">Lakshmi Vilas Bank - Corporate</option>
                    <option value="OBC">Oriental Bank of Commerce</option>
                    <option value="PNB">Punjab National Bank</option>
                    <option value="PNBC">Punjab National Bank Corporate</option>
                    <option value="PNSB">Punjab &amp; Sind Bank</option>
                    <option value="PNMHC">Punjab &amp; Maharashtra Co-op Bank</option>
                    <option value="RBL">RBL Bank – Net Banking</option>
                    <option value="RBS">RBS</option>
                    <option value="SSWAT">Saraswat Co-op Bank</option>
                    <option value="SMCB">Shamrao Vithal Co-op Bank</option>
                    <option value="STINB">The South Indian Bank</option>
                    <option value="STANC">Standard Chartered Bank</option>
                    <option value="SNDCT">Syndicate Bank</option>
                    <option value="TMBNK">Tamilnad Mercantile Bank Limited</option>
                    <option value="TNMVNK">Tamil Nadu Merchantile Bank</option>
                    <option value="TNSC">TNSC Bank</option>
                    <option value="UCO">UCO Bank</option>
                    <option value="UBIN">Union Bank of India</option>
                    <option value="UNBI">United Bank of India</option>
                    <option value="VIJBN">Vijaya Bank</option>
                    <option value="YESB">Yes Bank</option></select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label> Cheque No. </label>
                  <input class="form-control" id="chequeno" onkeyup="chequeprint();" type="number" placeholder="Enter Here" >
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label> Status </label>
                  <select class="form-control" id="chequestatus" onchange="chequeprint();">
                    <option>UNCLEARED</option>
                    <option>CLEARED</option>
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label> Issue Date </label>
                  <input class="form-control" id="issuedate" onchange="chequeprint();" type="date" >
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label> Clearing Date </label>
                  <input class="form-control" id="clearingdate" onchange="chequeprint();" type="date" >
                </div>
              </div>
            </div>
          <div class="form-group">
            <label>Payment Details (Optional)</label>
            <input class="form-control" id="modedetails" name="modedetails" type="text" value=" " readonly>
          </div>
          <hr style="margin-top: 20px; margin-bottom: 20px;">
          <input type="hidden" name="submit" value="pay">
          <button  id="paybutton" class="btn btn-primary btn-block" onclick="pay()" >Pay</button>
        </form>
      </div>
    </div>
  </div>



  <script>

  function sms (){
    if ($('#sendsms').val()=="Yes") {
      $("#cno").prop('disabled', false); $("#cno").prop('required', true);
    } else {
      $("#cno").prop('disabled', true); $("#cno").prop('required', false);
    }
  }

  function genmodedetails(){
    var mode = $('#cashmode').val();

    $('#cash').hide();
    $('#creditcard').hide();
    $('#debitcard').hide();
    $('#impsneft').hide();
    $('#upi').hide();
    $('#paytm').hide();
    $('#cheque').hide();

    if (mode=="Cash") {
      $('#cash').slideDown("slow");
    } else if (mode=="Credit Card") {
      $('#creditcard').slideDown( "slow" );
    } else if (mode=="Debit Card") {
      $('#debitcard').slideDown( "slow" );
    } else if (mode=="IMPS/NEFT") {
      $('#impsneft').slideDown( "slow" );
    } else if (mode=="UPI") {
      $('#upi').slideDown( "slow" );
    } else if (mode=="Cheque/DD") {
      $('#cheque').slideDown( "slow" );
    } else if (mode=="Paytm") {
      $('#paytm').slideDown( "slow" );
    }
  }

    function cashfunc(){
      document.getElementById('cashreturn').value = document.getElementById('cashpaid').value - document.getElementById('amount').value ;
      <?php if ($_GET['type']=="purchasepayments") echo 'cashprint2()'; else echo 'cashprint()'; ?>;
    }


    //cashfunc
    function cashprint(){
      var m =" CASH |";
      var p =" Paid: ";
      var r =" Returned: ";

      var k1 = " COUNTER ";
      var k2 = " MULTIMODE ";

      var pval= document.getElementById('cashpaid').value;
      var rval= document.getElementById('cashreturn').value;

      if (rval<0) {
        document.getElementById('modedetails').value = m + p + pval + r + '0' + k2;
      } else {
        document.getElementById('modedetails').value = m + p + pval + r + rval ;
      }
    }

    //cashfunc
    function cashprint2(){
      var m =" CASH |";
      var p =" Paid: ";
      var r =" Refunded: ";

      var k2 = " MULTIMODE ";

      var pval= document.getElementById('cashpaid').value;
      var rval= document.getElementById('cashreturn').value;
      var sval= document.getElementById('cashsource').value;

      if (rval<0) {
        document.getElementById('modedetails').value = m + p + pval + r + '0' + k2 + ' Source: ' + sval;
      } else {
        document.getElementById('modedetails').value = m + p + pval + r + rval + ' Source: ' + sval ;
      }
    }

    //creditcardfunc
    function creditcardprint(){
      var m ="CREDIT CARD |";
      var p =" TYPE: ";
      var r =" NO.: ";
      var pval= document.getElementById('creditcardtype').value;
      var rval= document.getElementById('creditcardno').value;
      document.getElementById('modedetails').value = m + p + pval + r + rval  ;
    }

    //debitcardfunc
    function debitcardprint(){
      var m =" DEBIT CARD |";
      var p =" TYPE: ";
      var r =" NO.: ";
      var pval= document.getElementById('debitcardtype').value;
      var rval= document.getElementById('debitcardno').value;
      document.getElementById('modedetails').value = m + p + pval + r + rval ;
    }

    //chequefunc
    function chequeprint(){
      var m =" CHEQUE/DD |";
      var p =" Bank: ";
      var r =" NO.: ";
      var i =" ISSUED: ";
      var c =" CLEAR: ";
      var cs =" Status: ";
      var pval= document.getElementById('bank').value;
      var rval= document.getElementById('chequeno').value;
      var ival= document.getElementById('issuedate').value;
      var cval= document.getElementById('clearingdate').value;
      var csval= document.getElementById('chequestatus').value;
      document.getElementById('modedetails').value = m + p + pval + r + rval + i + ival + c + cval + cs + csval ;
    }

    //impsneftfunc
    function impsneftprint(){
      var m =" IMPS/NEFT |";
      var p =" UTR: ";
      var pval= document.getElementById('utr').value;
      document.getElementById('modedetails').value = m + p + pval ;
    }

    //upiprint
    function upiprint(){
      var m =" UPI |";
      var p =" UTR: ";
      var pval= document.getElementById('upiutr').value;
      document.getElementById('modedetails').value = m + p + pval ;
    }

    //paytmfunc
    function paytmprint(){
      var m =" Paytm |";
      var p =" TxnID: ";
      var pval= document.getElementById('txnid').value;
      document.getElementById('modedetails').value = m + p + pval ;
    }

    //payfunction
    function pay(){
      $('#paybutton').hide();
      alert('Payment Success ! Press Ok to go back.');
      $('#paymentform').submit();
    }


  </script>
  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
</body>

</html>
