<?php
$fromdate=date("Y-m-d");
$todate=date("Y-m-d");
$today=date("Y-m-d");
$establisheddate='2018-08-24';
$reporttype="dr";

if (isset($_GET['fromdate'])) {
  $fromdate=$_GET['fromdate'];
}

if (isset($_GET['todate'])) {
  $todate=$_GET['todate'];
}

if (isset($_GET['reporttype'])) {
  $reporttype=$_GET['reporttype'];
}

$cash_opening=0;

?>
<div class="row">
  <div class="col-md-6">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            Report Filter
          </div>
          <div class="card-body">
            <form method="get">
              <div class="row">
                <div class="col-md-6">
                  <label>From Date</label>
                  <input type="date" class="form-control" name="fromdate" min="2018-08-24" max="<?php echo date("Y-m-d"); ?>" value="<?php echo $fromdate; ?>">
                </div>
                <div class="col-md-6">
                  <label>To Date</label>
                  <input type="date" class="form-control" name="todate" min="2018-08-24" max="<?php echo date("Y-m-d"); ?>" value="<?php echo $todate; ?>">
                  <input type="hidden" name="view" value="revenue-analysis">
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col-md-10">
                  <label>Revenue Analysis Type</label>
                  <select class="form-control" name="reporttype">
                    <option <?php if ($reporttype=="dr") echo "selected";  ?> value="dr">Date Range</option>
                    <option <?php if ($reporttype=="td") echo "selected";  ?> value="td">Beginning Till Date</option>
                    <option <?php if ($reporttype=="cw") echo "selected";  ?> value="cw">Current Worth & Profit Estimator</option>
                  </select>
                </div>
                <div class="col-md-2">
                  <label>Refresh</label>
                  <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-refresh" aria-hidden="true"></i></button>
                </div>
              </div>

            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <?php
      // Analysis part
      if ($reporttype=="dr") {
        //1 - Current Date Range : total sell, total buy, disc, paid, rem, profit
          $calc_dr_soldat=$calc_dr_buyat=$calc_dr_disc=$calc_dr_inv=$calc_dr_rem=$calc_dr_profit=0; $sql_fromdate=$fromdate; $sql_todate=$todate;
          //sell, buy
          if($query = mysqli_query($mysqli, "SELECT salesid,productid,quantity,sellprice,mfd From sales t1, solditems t2 where t1.id=t2.salesid and (t1.date between '$fromdate' and '$todate')"))
            while($find = mysqli_fetch_array($query)){
              $buyprice=$sellprice=0;
              $mfd=$find['mfd'];
              $sellprice=$find['sellprice'];
              $productid=$find['productid'];

              if($query1 = mysqli_query($mysqli, "SELECT buyprice FROM purchaseditems where productid=$productid and sellprice=$sellprice and mfd='$mfd'"))
                while($find1 = mysqli_fetch_array($query1)){
                  $buyprice=$find1['buyprice'];
                }
              $calc_dr_soldat=$calc_dr_soldat+($find['quantity']*$sellprice);//total selling price
              $calc_dr_buyat=$calc_dr_buyat+($find['quantity']*$buyprice);//total buyiing price
          }
          //disc
          if($query = mysqli_query($mysqli, "SELECT SUM(discvalue) as amt From sales where (date between '$sql_fromdate' and '$sql_todate')"))
            while($find = mysqli_fetch_array($query)){
              $calc_dr_disc=$find['amt'];//total discount given
          }
          //paid
          if($query = mysqli_query($mysqli, "SELECT SUM(amount) as amt From salepayments t1, sales t2 where t2.id=t1.salesid and (t2.date between '$sql_fromdate' and '$sql_todate')"))
            while($find = mysqli_fetch_array($query)){
              $calc_dr_inv=$find['amt'];//total amount paid
          }
          //calculate rem, profit
          $calc_dr_rem=($calc_dr_soldat-$calc_dr_disc)-$calc_dr_inv; //total remaining to collect
          $calc_dr_profit=($calc_dr_soldat-$calc_dr_disc)-$calc_dr_buyat; //total profit
      } else {
        //2- Till Date Range : total sell, total buy, disc, paid, rem, profit
          $calc_td_soldat=$calc_td_buyat=$calc_td_disc=$calc_td_inv=$calc_td_rem=$calc_td_profit=0; $sql_fromdate=$establisheddate; $sql_todate=$today;
          //sell, buy
          if($query = mysqli_query($mysqli, "SELECT salesid,productid,quantity,sellprice,mfd From sales t1, solditems t2 where t1.id=t2.salesid and (t1.date between '$sql_fromdate' and '$sql_todate')"))
            while($find = mysqli_fetch_array($query)){
              $buyprice=$sellprice=0;
              $mfd=$find['mfd'];
              $sellprice=$find['sellprice'];
              $productid=$find['productid'];

              if($query1 = mysqli_query($mysqli, "SELECT buyprice FROM purchaseditems where productid=$productid and sellprice=$sellprice and mfd='$mfd'"))
                while($find1 = mysqli_fetch_array($query1)){
                  $buyprice=$find1['buyprice'];
                }
              $calc_td_soldat=$calc_td_soldat+($find['quantity']*$sellprice);//total selling price
              $calc_td_buyat=$calc_td_buyat+($find['quantity']*$buyprice);//total buyiing price
          }
          $calc_td_soldat=round($calc_td_soldat);
          $calc_td_buyat=round($calc_td_buyat);

          //disc
          if($query = mysqli_query($mysqli, "SELECT SUM(discvalue) as amt From sales where (date between '$sql_fromdate' and '$sql_todate')"))
            while($find = mysqli_fetch_array($query)){
              $calc_td_disc=$find['amt'];//total discount given
          }
          //paid
          if($query = mysqli_query($mysqli, "SELECT SUM(amount) as amt From salepayments t1, sales t2 where t2.id=t1.salesid and (t2.date between '$sql_fromdate' and '$sql_todate')"))
            while($find = mysqli_fetch_array($query)){
              $calc_td_inv=$find['amt'];//total amount paid
          }
          //calculate rem, profit
          $calc_td_rem=($calc_td_soldat-$calc_td_disc)-$calc_td_inv; //total remaining to collect
          $calc_td_profit=($calc_td_soldat-$calc_td_disc)-$calc_td_buyat; //total profit
      }
      if ($reporttype=="cw") {
        //3- Current Worth : total sell, total buy, profit
          $calc_cw_soldat=$calc_cw_buyat=$calc_cw_disc=$calc_cw_profit=0;
          //sell, buy
          if($query = mysqli_query($mysqli, "SELECT SUM(quantity*buyprice) as buyamt, SUM(quantity*sellprice) as sellamt From purchases t1, purchaseditems t2 where t1.id=t2.purchaseid and (t1.date between '2018-07-01' and '$today')"))
            while($find = mysqli_fetch_array($query)){

              $calc_cw_soldat=round($find['sellamt']);//total selling price
              $calc_cw_buyat=round($find['buyamt']);//total buying price
          }
          $calc_cw_soldat-=$calc_td_soldat;//current stock selling price if all stock sold
          $calc_cw_buyat-=$calc_td_buyat;//current stock buying price
          $calc_cw_profit=round($calc_cw_soldat-$calc_cw_buyat);//Max profit that can be earned
      }
    ?>

    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            Revenue Analysis
          </div>
          <div class="card-body">
            <?php if ($reporttype=="dr"): ?>
              <table class="table table-hover table-borderless table-responsive-lg">
                <tr class="text-center table-active">
                  <th colspan="2">From <?php echo $fromdate; ?> to <?php echo $todate; ?></td>
                </tr>
                <tr>
                  <td>Total Stock Worth</td>
                  <th><?php echo money_format('%n', $calc_dr_soldat); ?></th>
                </tr>
                <tr>
                  <td>Was Sold at</td>
                  <th><?php echo money_format('%n', ($calc_dr_soldat-$calc_dr_disc)); ?></th>
                </tr>
                <tr>
                  <td>With a Discount of</td>
                  <th><?php echo money_format('%n', $calc_dr_disc); ?></th>
                </tr>
                <tr>
                  <td>Which was Brought at</td>
                  <th><?php echo money_format('%n', $calc_dr_buyat); ?></th>
                </tr>
                <tr>
                  <td>With a Pur. Discount of</td>
                  <th><?php echo money_format('%n', $calc_dr_disc_pur); ?></th>
                </tr>
                <tr>
                  <td>The Amount Collected, </td>
                  <th><?php echo money_format('%n', $calc_dr_inv); ?></th>
                </tr>
                <tr>
                  <td>has a Remaining to collect of</td>
                  <th><?php echo money_format('%n', $calc_dr_rem); ?></th>
                </tr>
                <tr class="table-dark">
                  <td>Giving a net profit of</td>
                  <th><?php echo money_format('%n', $calc_dr_profit); ?></th>
                </tr>
                <tr class="table-active">
                  <td>Out of which expenses were</td>
                  <?php
                  if($query = mysqli_query($mysqli, "SELECT sum(amount) as amt FROM vouchers where (date between '$fromdate' and '$todate')"))
                    while($find = mysqli_fetch_array($query)){
                     $expense_total=$find['amt'];
                    }
                  ?>
                  <th><?php echo money_format('%n', $expense_total); ?></th>
                </tr>
                <tr class="table-success">
                  <td>And Finally in hand was</td>
                  <th><?php echo money_format('%n', ($calc_dr_profit-$expense_total)); ?></th>
                </tr>
              </table>
            <?php endif; ?>

            <?php if ($reporttype=="td"): ?>
              <table class="table table-hover table-borderless table-responsive-lg">
                <tr class="text-center table-active">
                  <th colspan="2">From Beginning Till Date</td>
                </tr>
                <tr>
                  <td>Total Stock Worth</td>
                  <th><?php echo money_format('%n', $calc_td_soldat); ?></th>
                </tr>
                <tr>
                  <td>Was Sold at</td>
                  <th><?php echo money_format('%n', ($calc_td_soldat-$calc_td_disc)); ?></th>
                </tr>
                <tr>
                  <td>With a Discount of</td>
                  <th><?php echo money_format('%n', $calc_td_disc); ?></th>
                </tr>
                <tr>
                  <td>Which was Brought at</td>
                  <th><?php echo money_format('%n', $calc_td_buyat); ?></th>
                </tr>
                <tr>
                  <td>With a Pur. Discount of</td>
                  <th><?php echo money_format('%n', $calc_td_disc_pur); ?></th>
                </tr>
                <tr>
                  <td>The Amount Collected, </td>
                  <th><?php echo money_format('%n', $calc_td_inv); ?></th>
                </tr>
                <tr>
                  <td>has a Remaining to collect of</td>
                  <th><?php echo money_format('%n', $calc_td_rem); ?></th>
                </tr>
                <tr class="table-dark">
                  <td>Giving a net profit of</td>
                  <th><?php echo money_format('%n', $calc_td_profit); ?></th>
                </tr>
              </table>
            <?php endif; ?>

            <?php if ($reporttype=="cw"): ?>
              <table class="table table-hover table-borderless table-responsive-lg">
                <tr class="text-center table-active">
                  <th colspan="2">Shop Worth And Loss/Profit Estimate</td>
                </tr>
                <tr>
                  <td>If Current Stock Worth </td>
                  <th><input id="worth" name="worth" type="number" value="<?php echo round($calc_cw_soldat); ?>" ></th>
                </tr>
                <tr>
                  <td>is Sold at</td>
                  <th><input id="sell" name="sell" type="number" value="<?php echo round($calc_cw_soldat); ?>" ></th>
                </tr>
                <tr>
                  <td>With a Discount % of </td>
                  <th><input id="discper" onchange="calculateOnDiscPer();" name="discper" type="number" min="0" max="20" value="0"></th>
                </tr>
                <tr>
                  <td>or Flat Discount of Rs </td>
                  <th><input id="discflat" onchange="calculateOnDiscFlat();" name="discflat" type="number" min="0" max="<?php echo $calc_cw_buyat; ?>" value="0"></th>
                </tr>
                <tr>
                  <td>Which was Brought at</td>
                  <th><input id="buy" name="buy" type="number" value="<?php echo round($calc_cw_buyat); ?>" ></th>
                </tr>
                <tr class="table-active">
                  <td>A <span id="pl1">Profit</span> Will be made is</td>
                  <th><input id="profit" name="profit" type="number" value="<?php echo round($calc_cw_profit); ?>" ></th>
                </tr>
                <tr class="table-active">
                  <td>With a <span id="pl2">Profit</span> Margin of</td>
                  <th><input id="profitper" name="profitper" min="0" step="0.1" type="number" value="<?php echo round (($calc_cw_profit/$calc_cw_buyat)*100) ?>" >%</th>
                </tr>
              </table>
              <script>
                var worth= parseInt($('#worth').val());
                var buy= parseInt($('#buy').val());

                function calculateOnDiscPer(){
                  var discper= parseInt($('#discper').val());
                  var discflat= worth*discper/100;
                  discflat=Math.round(discflat);
                  var sell= worth-discflat;
                  var profit= sell-buy;
                  var profitper=profit/buy*100;
                  profitper=Math.round(profitper * 10) / 10;

                  $('#discflat').val(discflat);
                  $('#sell').val(sell);
                  $('#profit').val(profit);
                  $('#profitper').val(profitper);
                  if (profit>0) {
                    $('#pl1').text("Profit");$('#pl2').text("Profit");
                  } else {
                    $('#pl1').text("Loss");$('#pl2').text("Loss");
                  }
                }

                function calculateOnDiscFlat(){
                  var discflat= parseInt($('#discflat').val());
                  var sell= worth-discflat;
                  var profit= sell-buy;
                  var profitper=profit/buy*100;
                  var discper= worth*discper/100;
                  //round discper
                  discper=Math.round(discper * 10) / 10;

                  $('#discper').val(discper);
                  $('#sell').val(sell);
                  $('#profit').val(profit);
                  $('#profitper').val(profitper);
                  if (profit>0) {
                    $('#pl1').text(profit);$('#pl2').text("Profit");
                  } else {
                    $('#pl1').text(profit);$('#pl2').text("Loss");
                  }
                }
              </script>
            <?php endif; ?>


          </div>
        </div>
      </div>
    </div>
  </div>
</div>
