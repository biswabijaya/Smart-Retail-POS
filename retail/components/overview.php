<?php
$fromdate=date("Y-m-d");
$todate=date("Y-m-d");
$today=date("Y-m-d");
$establisheddate='2018-08-24';
$reporttype="Summary";

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
            Detailed Report
          </div>
          <div class="card-body">
            <form>
              <div class="row">
                <div class="col-md-10">
                  <label>Report Type</label>
                  <select class="form-control" name="reporttype">
                    <option>Summary</option>
                    <option <?php if ($reporttype=="Detailed") echo "selected";  ?> >Detailed</option>
                  </select>
                </div>
                <div class="col-md-2">
                  <label>Refresh</label>
                  <input type="hidden" name="fromdate" value="<?php echo $fromdate; ?>"><input type="hidden" name="todate" value="<?php echo $todate; ?>">
                  <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-refresh" aria-hidden="true"></i></button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <?php if ($reporttype=="Detailed"): ?>
          <div class="accordion" id="OverviewAccordion">
            <?php
            $counter=0;
            $accarea="true";$accbtn="";$accdata="show";
            $pttotal_amt=$sttotal_amt=0;

              if($result = mysqli_query($mysqli, "SELECT id,view,category,subcategory,brand,name From products order by category desc, subcategory desc, name asc")){
                while($res = mysqli_fetch_array($result)){
                  $counter++;
                  $productid=$res['id'];

                  //print data here

                  echo '<div class="card">';
                    echo '<div class="card-header px-2" id="acc-head-'.$counter.'">';
                      echo '<p class="mb-0">';
                        echo '<button class="btn px-1 btn-link '.$accbtn.'" type="button" data-toggle="collapse" data-target="#acc-collap-'.$counter.'" aria-expanded="'.$accarea.'" aria-controls="acc-collap-'.$counter.'">';
                          echo '<span><i class="fa fa-chevron-circle-down" aria-hidden="true"></i></span>';
                        echo '</button>';

                        if ($res['view']) {
                          echo ' <span class="badge badge-pill badge-success" style="font-size:10px;">'.$res['category'].'</span> ';
                          echo '<span class="badge badge-pill badge-success" style="font-size:10px;">'.$res['subcategory'].'</span> ';
                          echo '<span class="badge badge-pill badge-success" style="font-size:10px;">'.$res['brand'].'</span>';
                        } else {
                          echo '<span class="badge badge-pill badge-danger" style="font-size:10px;">'.$res['category'].'</span> ';
                          echo '<span class="badge badge-pill badge-danger" style="font-size:10px;">'.$res['subcategory'].'</span> ';
                          echo '<span class="badge badge-pill badge-danger" style="font-size:10px;">'.$res['brand'].'</span>';
                        }

                        echo '<span style="font-size:12px;"> - '.$res['name'].'</span>';
                      echo '</p>';
                    echo '</div>';
                    echo '<div id="acc-collap-'.$counter.'" class="collapse '.$accdata.'" aria-labelledby="acc-head-'.$counter.'" data-parent="#OverviewAccordion">';
                      echo '<div class="card-body">';
                        echo '<div class="row">';
                          echo '<div class="col-md-6">';
                            echo '<table class="table table-hover table-borderless table-light table-responsive-lg">';
                              echo '<thead>';
                                echo '<tr>';
                                  echo '<th scope="col">#</th>';
                                  echo '<th scope="col">Pur ID</th>';
                                  echo '<th scope="col">Qty</th>';
                                  echo '<th scope="col">Amt</th>';
                                echo '</tr>';
                              echo '</thead>';
                              echo '<tbody>';
                                $date=$fromdate; $c=1; $tloop=0;$ttotal_qty=$ttotal_amt=0;
                                while (strtotime($date) <= strtotime($todate)){
                                  $loop=0;$total_qty=$total_amt=0;
                                  if($query = mysqli_query($mysqli, "SELECT purchaseid,staffid,supplierid,type,date,mrp,quantity,buyprice,sellprice,status From purchases t1, purchaseditems t2 where t1.id=t2.purchaseid and (t2.productid=$productid and date ='$date') order by date asc"))
                                    while($find = mysqli_fetch_array($query)){
                                      if($find['status']==1){$trstatus="table-warning";}
                                      else if($find['status']==0){$trstatus="table-danger";}
                                      else $trstatus=" ";
                                      echo '<tr class="'.$trstatus.'">';
                                        echo '<td scope="row">'.$c++.'</td>';
                                        echo '<td>'.$find['purchaseid'].'</td>';
                                        echo '<td>'.$find['quantity'].'</td>';
                                        echo '<td>'.($find['quantity']*$find['buyprice']).'</td>';
                                      echo '</tr>';
                                      $loop++;
                                      $total_qty+=$find['quantity'];
                                      $total_amt=$total_amt+($find['quantity']*$find['buyprice']);
                                  }
                                  if($loop>0){
                                    echo '<tr class="table-active">';
                                      echo '<td colspan="2">'.$date.' ('.$loop.')</td>';
                                      echo '<td>'.$total_qty.'</td>';
                                      echo '<th>'.$total_amt.'</th>';
                                    echo '</tr>';
                                    $tloop+=$loop;
                                    $ttotal_qty+=$total_qty;
                                    $ttotal_amt+=$total_amt;
                                  }

                                  $date = date ("Y-m-d", strtotime("+1 day", strtotime($date)));
                                }
                                if($tloop>0){
                                  echo '<tr class="table-dark">';
                                    echo '<td colspan="2">Total ('.$tloop.') = </td>';
                                    echo '<td>'.$ttotal_qty.'</td>';
                                    echo '<th style="color:red;">'.$ttotal_amt.'</th>';
                                  echo '</tr>';
                                }
                                $pttotal_amt+=$ttotal_amt;
                              echo '</tbody>';
                            echo '</table>';
                          echo '</div>';
                          echo '<div class="col-md-6">';
                            echo '<table class="table table-hover table-borderless table-light table-responsive-lg">';
                              echo '<thead>';
                                echo '<tr>';
                                  echo '<th scope="col">#</th>';
                                  echo '<th scope="col">Sale ID</th>';
                                  echo '<th scope="col">Qty</th>';
                                  echo '<th scope="col">Amt</th>';
                                echo '</tr>';
                              echo '</thead>';
                              echo '<tbody>';
                                $date=$fromdate; $c=1; $tloop=0;$ttotal_qty=$ttotal_amt=0;
                                while (strtotime($date) <= strtotime($todate)){
                                  $loop=0;$total_qty=$total_amt=0;
                                  if($query = mysqli_query($mysqli, "SELECT t2.salesid,t1.staffid,t1.storecode,t1.cno,t1.date,t2.quantity,t2.mrp,t2.sellprice,t1.status,t3.buyprice From sales t1, solditems t2,purchaseditems t3 where t1.id=t2.salesid and t2.productid=$productid and t3.productid=t2.productid and t3.mfd=t2.mfd and t1.date ='2019-01-07' order by t1.date asc"))
                                    while($find = mysqli_fetch_array($query)){
                                      if($find['status']==1){$trstatus="table-warning";}
                                      else if($find['status']==0){$trstatus="table-danger";}
                                      else $trstatus=" ";
                                      echo '<tr class="'.$trstatus.'">';
                                        echo '<td scope="row">'.$c++.'</td>';
                                        echo '<td>'.$find['salesid'].'</td>';
                                        echo '<td>'.$find['quantity'].'</td>';
                                        echo '<td>'.($find['quantity']*$find['sellprice']).'</td>';
                                      echo '</tr>';
                                      $loop++;
                                      $total_qty+=$find['quantity'];
                                      $total_amt=$total_amt+($find['quantity']*$find['sellprice']);
                                  }
                                  if($loop>0){
                                    echo '<tr class="table-active">';
                                      echo '<td colspan="2">'.$date.'</td>';
                                      echo '<td>'.$total_qty.'</td>';
                                      echo '<th>'.$total_amt.'</th>';
                                    echo '</tr>';
                                    $tloop+=$loop;
                                    $ttotal_qty+=$total_qty;
                                    $ttotal_amt+=$total_amt;
                                  }

                                  $date = date ("Y-m-d", strtotime("+1 day", strtotime($date)));
                                }
                                if($tloop>0){
                                  echo '<tr class="table-dark">';
                                    echo '<td colspan="2">Total ('.$tloop.') = </td>';
                                    echo '<td>'.$ttotal_qty.'</td>';
                                    echo '<th style="color:green;">'.$ttotal_amt.'</th>';
                                  echo '</tr>';
                                }
                                $sttotal_amt+=$ttotal_amt;
                              echo '</tbody>';
                            echo '</table>';
                          echo '</div>';
                        echo '</div>';
                      echo '</div>';
                    echo '</div>';
                  echo '</div>';


                  $accarea="false";
                  $accdata="";
                  $accbtn="collapsed";
                }
              }
            ?>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <?php
      //purchases part
      $calc_ppaid_sum=$calc_punpaid_sum=$calc_punbilled_sum=$calc_pdiscounted=$calc_sreceived_sum=$calc_sunpaid_sum=$calc_sunbilled_sum=$calc_sdiscounted=0;
        if($query = mysqli_query($mysqli, "SELECT Sum(quantity*buyprice) as purchasesamount  From purchases t1, purchaseditems t2 where t1.id=t2.purchaseid and (date between '$fromdate' and '$todate') AND STATUS=2"))
          while($find = mysqli_fetch_array($query)){
            $calc_ppaid_sum=$find['purchasesamount'];
          }

        if($query = mysqli_query($mysqli, "SELECT Sum(quantity*buyprice) as purchasesamount From purchases t1, purchaseditems t2 where t1.id=t2.purchaseid and (date between '$fromdate' and '$todate') AND STATUS=1"))
          while($find = mysqli_fetch_array($query)){
            $calc_punpaid_sum=$find['purchasesamount'];
          }

        if($query = mysqli_query($mysqli, "SELECT Sum(quantity*buyprice) as purchasesamount From purchases t1, purchaseditems t2 where t1.id=t2.purchaseid and (date between '$fromdate' and '$todate') AND STATUS=0"))
          while($find = mysqli_fetch_array($query)){
            $calc_punbilled_sum=$find['purchasesamount'];
          }

        if($query = mysqli_query($mysqli, "SELECT SUM(discvalue) as pdiscount FROM purchases where (date between '$fromdate' and '$todate')"))
          while($find = mysqli_fetch_array($query))
            $calc_pdiscounted=$find['discount'];

        if($query = mysqli_query($mysqli, "SELECT sum(amount) as amtsum FROM purchasepayments WHERE (time between '$fromdate 00:00:00' and '$todate 23:59:59')"))
          while($find = mysqli_fetch_array($query))
            $calc_pinvoiced=$find['amtsum'];

      //sales part

        if($query = mysqli_query($mysqli, "SELECT Sum(quantity*sellprice) as salesamount  From sales t1, solditems t2 where t1.id=t2.salesid and (date between '$fromdate' and '$todate') AND STATUS=2"))
          while($find = mysqli_fetch_array($query)){
            $calc_sreceived_sum=$find['salesamount'];
          }

        if($query = mysqli_query($mysqli, "SELECT Sum(quantity*sellprice) as salesamount From sales t1, solditems t2 where t1.id=t2.salesid and (date between '$fromdate' and '$todate') AND STATUS=1"))
          while($find = mysqli_fetch_array($query)){
            $calc_sunpaid_sum=$find['salesamount'];
          }

        if($query = mysqli_query($mysqli, "SELECT Sum(quantity*sellprice) as salesamount From sales t1, solditems t2 where t1.id=t2.salesid and (date between '$fromdate' and '$todate') AND STATUS=0"))
          while($find = mysqli_fetch_array($query)){
            $calc_sunbilled_sum=$find['salesamount'];
          }

        if($query = mysqli_query($mysqli, "SELECT SUM(discvalue) as sdiscount FROM sales where (date between '$fromdate' and '$todate')"))
          while($find = mysqli_fetch_array($query))
            $calc_sdiscounted=$find['sdiscount'];

        if($query = mysqli_query($mysqli, "SELECT sum(amount) as amtsum FROM salepayments WHERE (time between '$fromdate 00:00:00' and '$todate 23:59:59')"))
          while($find = mysqli_fetch_array($query))
            $calc_sinvoiced=$find['amtsum'];

      //purchase payments calculation
        $calc_pcreditcard=$calc_pcheque=$calc_pbank=$calc_pcash=$calc_pcash_counter=0;
        if($query = mysqli_query($mysqli, "SELECT sum(amount) as amtsum FROM purchasepayments WHERE (mode='Credit Card' or mode='Debit Card') and (time between '$fromdate 00:00:00' and '$todate 23:59:59')"))
          while($find = mysqli_fetch_array($query))
            $calc_pcreditcard=$find['amtsum'];
        if($query = mysqli_query($mysqli, "SELECT sum(amount) as amtsum FROM purchasepayments WHERE mode='Cheque/DD' and (time between '$fromdate 00:00:00' and '$todate 23:59:59')"))
          while($find = mysqli_fetch_array($query))
            $calc_pcheque=$find['amtsum'];
        if($query = mysqli_query($mysqli, "SELECT sum(amount) as amtsum FROM purchasepayments WHERE (mode='IMPS/NEFT' or mode='UPI') and (time between '$fromdate 00:00:00' and '$todate 23:59:59')"))
          while($find = mysqli_fetch_array($query))
            $calc_pbank=$find['amtsum'];

        if($query = mysqli_query($mysqli, "SELECT sum(amount) as amtsum FROM purchasepayments WHERE mode='cash' and (time between '$fromdate 00:00:00' and '$todate 23:59:59')"))
          while($find = mysqli_fetch_array($query))
            $calc_pcash=$find['amtsum'];
        if($query = mysqli_query($mysqli, "SELECT sum(amount) as amtsum FROM purchasepayments WHERE modedetails LIKE '%COUNTER%' and (time between '$fromdate 00:00:00' and '$todate 23:59:59')"))
          while($find = mysqli_fetch_array($query))
            $calc_pcash_counter=$find['amtsum'];


      //sale payments calculation
        $calc_screditcard=$calc_scheque=$calc_sbank=$calc_scash=0;
        if($query = mysqli_query($mysqli, "SELECT sum(amount) as amtsum FROM salepayments WHERE (mode='Credit Card' or mode='Debit Card') and (time between '$fromdate 00:00:00' and '$todate 23:59:59')"))
          while($find = mysqli_fetch_array($query))
            $calc_screditcard=$find['amtsum'];
        if($query = mysqli_query($mysqli, "SELECT sum(amount) as amtsum FROM salepayments WHERE mode='Cheque/DD' and (time between '$fromdate 00:00:00' and '$todate 23:59:59')"))
          while($find = mysqli_fetch_array($query))
            $calc_scheque=$find['amtsum'];
        if($query = mysqli_query($mysqli, "SELECT sum(amount) as amtsum FROM salepayments WHERE (mode='IMPS/NEFT' or mode='UPI') and (time between '$fromdate 00:00:00' and '$todate 23:59:59')"))
          while($find = mysqli_fetch_array($query))
            $calc_sbank=$find['amtsum'];

        if($query = mysqli_query($mysqli, "SELECT sum(amount) as amtsum FROM salepayments WHERE mode='cash' and (time between '$fromdate 00:00:00' and '$todate 23:59:59')"))
          while($find = mysqli_fetch_array($query))
            $calc_scash=$find['amtsum'];

      // expense record
        if($query = mysqli_query($mysqli, "SELECT sum(amount) as amtsum FROM expense WHERE mode='cash' and (time between '$fromdate 00:00:00' and '$todate 23:59:59')"))
          while($find = mysqli_fetch_array($query))
            $paid_expenses_cash=$find['amtsum'];

        if($query = mysqli_query($mysqli, "SELECT sum(amount) as amtsum FROM expense WHERE (time between '$fromdate 00:00:00' and '$todate 23:59:59')"))
          while($find = mysqli_fetch_array($query))
            $paid_expenses=$find['amtsum'];
/*
      // Analysis part

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

      //3- Current Worth : total sell, total buy, profit
        $calc_cw_soldat=$calc_cw_buyat=$calc_cw_disc=$calc_cw_inv=$calc_cw_rem=$calc_cw_profit=0; $sql_fromdate=$establisheddate; $sql_todate=$today;
        //sell, buy
        if($query = mysqli_query($mysqli, "SELECT purchaseid,productid,quantity,buyprice,sellprice,mfd From purchases t1, purchaseditems t2 where t1.id=t2.purchaseid and (t1.date between '$sql_fromdate' and '$sql_todate')"))
          while($find = mysqli_fetch_array($query)){
            $buyprice=$sellprice=0;
            $mfd=$find['mfd'];
            $sellprice=$find['sellprice'];
            $buyprice=$find['buyprice'];
            $productid=$find['productid'];

            $calc_cw_soldat=$calc_cw_soldat+($find['quantity']*$sellprice);
            $calc_cw_buyat=$calc_cw_buyat+($find['quantity']*$buyprice);//total buyiing price
        }
        $calc_cw_soldat-=-$calc_td_soldat;//current stock selling price if all stock sold
        $calc_cw_buyat-=-$calc_td_buyat;//current stock buying price
        $calc_cw_profit=$calc_cw_soldat-$calc_cw_buyat;//Max profit that can be earned
*/
    ?>

    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            Summary
          </div>
          <div class="card-body">
            <form>
              <div class="row">
                <div class="col-md-5">
                  <label>From Date</label>
                  <input type="date" class="form-control" name="fromdate" min="2018-08-24" max="<?php echo date("Y-m-d"); ?>" value="<?php echo $fromdate; ?>">
                </div>
                <div class="col-md-5">
                  <label>To Date</label>
                  <input type="date" class="form-control" name="todate" min="2018-08-24" max="<?php echo date("Y-m-d"); ?>" value="<?php echo $todate; ?>">
                </div>
                <div class="col-md-2">
                  <label>Refresh</label>
                  <input type="hidden" name="reporttype" value="<?php echo $reporttype; ?>">
                  <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-refresh" aria-hidden="true"></i></button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="col-md-12"><hr></div>
      <div class="col-md-6">
        <center> Purchases Data </center>
        <table class="table table-hover table-borderless table-light table-responsive-lg">
          <tr>
            <td>Paid</td>
            <th><?php echo $calc_ppaid_sum; ?></th>
          </tr>
          <tr class="table-active">
            <td>Invoiced</td>
            <th><?php echo $calc_pinvoiced; ?></th>
          </tr>
          <tr>
            <td>UnPaid</td>
            <th><?php echo $calc_punpaid_sum; ?></th>
          </tr>
          <tr>
            <td>UnBilled</td>
            <th><?php echo $calc_punbilled_sum; ?></th>
          </tr>
          <tr class="table-active">
            <td>Calc. Total</td>
            <th><?php echo ($calc_ppaid_sum+$calc_punpaid_sum+$calc_punbilled_sum); ?></th>
          </tr>
          <tr class="table-active">
            <td>Discounted </td>
            <th><?php echo $calc_pdiscounted; ?></th>
          </tr>
          <tr class="table-dark">
            <td>Net Output</td>
            <th style="color:red;"><?php echo (($calc_ppaid_sum+$calc_punpaid_sum+$calc_punbilled_sum)-$calc_pdiscounted); ?></th>
          </tr>
          <tr class="text-center">
            <td colspan="2">Transaction Details</td>
          </tr>
          <tr>
            <td>CASH</td>
            <th><?php echo $calc_pcash; ?></th>
          </tr>
          <tr class="table-active">
            <td>Counter</td>
            <th><?php echo $calc_pcash_counter; ?></th>
          </tr>
          <tr>
            <td>IMPS/NEFT</td>
            <th><?php echo $calc_pbank; ?></th>
          </tr>
          <tr>
            <td>Cheque/DD</td>
            <th><?php echo $calc_pcheque; ?></th>
          </tr>
          <tr>
            <td>Deb/Cr Card</td>
            <th><?php echo $calc_pcreditcard; ?></th>
          </tr>
          <tr>
            <td>Rem/Rounded</td>
            <th><?php echo ((($calc_ppaid_sum+$calc_punpaid_sum+$calc_punbilled_sum)-$calc_pdiscounted)-($calc_pcash+$calc_pbank+$calc_pcheque+$calc_pcreditcard)); ?></th>
          </tr>
        </table>
      </div>
      <div class="col-md-6">
        <center> Sales Data </center>
        <table class="table table-hover table-borderless table-light table-responsive-lg">
          <tr>
            <td>Sell Paid</td>
            <th><?php echo $calc_sreceived_sum; ?></th>
          </tr>
          <tr class="table-active">
            <td>Invoiced</td>
            <th><?php echo $calc_sinvoiced; ?></th>
          </tr>
          <tr>
            <td>UnPaid</td>
            <th><?php echo $calc_sunpaid_sum; ?></th>
          </tr>
          <tr>
            <td>UnBilled</td>
            <th><?php echo $calc_sunbilled_sum; ?></th>
          </tr>
          <tr class="table-active">
            <td>Calc. Total</td>
            <th><?php echo ($calc_sreceived_sum+$calc_sunpaid_sum+$calc_sunbilled_sum); ?></th>
          </tr>
          <tr class="table-active">
            <td>Discounted </td>
            <th><?php echo $calc_sdiscounted; ?></th>
          </tr>
          <tr class="table-dark">
            <td>Net Input</td>
            <th style="color:green;"><?php echo (($calc_sreceived_sum+$calc_sunpaid_sum+$calc_sunbilled_sum)-$calc_sdiscounted); ?></th>
          </tr>
          <tr>
            <td colspan="2">Transaction Details</td>
          </tr>
          <tr>
            <td>CASH</td>
            <th><?php echo $calc_scash; ?></th>
          </tr>
          <tr>
            <td >Counter</td>
            <th><?php echo $calc_scash; ?></th>
          </tr>
          <tr>
            <td>IMPS/NEFT</td>
            <th><?php echo $calc_sbank; ?></th>
          </tr>
          <tr>
            <td>Cheque/DD</td>
            <th><?php echo $calc_scheque; ?></th>
          </tr>
          <tr>
            <td>Deb/Cr Card</td>
            <th><?php echo $calc_screditcard; ?></th>
          </tr>
          <tr>
            <td>Rem/Rounded</td>
            <th><?php echo ((($calc_sreceived_sum+$calc_sunpaid_sum+$calc_sunbilled_sum)-$calc_sdiscounted)-($calc_scash+$calc_sbank+$calc_scheque+$calc_screditcard)); ?></th>
          </tr>
        </table>
      </div>
      <div class="col-md-12"><hr></div>
      <div class="col-md-7">
        <center>Expense Heads</center>
        <table class="table table-hover table-borderless table-light table-responsive-lg">
            <?php
            if($query = mysqli_query($mysqli, "SELECT sum(amount) as amt,category,subcategory FROM vouchers  where (date between '$fromdate' and '$todate') group by category,subcategory order by category asc, subcategory asc"))
              while($find = mysqli_fetch_array($query)){
                echo '<tr>';
                echo '<td>'.$find['category'].'</td>';
                echo '<td>'.$find['subcategory'].'</td>';
                echo '<td>'.$find['amt'].'</td>';
                echo '</tr>';
              }

            ?>
        </table>
      </div>
      <div class="col-md-5">
        <center>Expense Transactions</center>
          <table class="table table-hover table-borderless table-light table-responsive-lg">
              <?php
              if($query = mysqli_query($mysqli, "SELECT t1.mode, sum(t2.amount) as amt FROM expense t1, vouchers t2 where t1.payid=t2.id and (t2.date between '$fromdate' and '$todate') GROUP by mode asc"))
                while($find = mysqli_fetch_array($query)){
                  echo '<tr>';
                  echo '<td>'.$find['mode'].'</td>';
                  echo '<td>'.$find['amt'].'</td>';
                  echo '</tr>';
                }
              ?>
              <tr>
                <td>Total</td>
                <th class="text-active">
                  <?php
                  if($query = mysqli_query($mysqli, "SELECT sum(amount) as amt FROM vouchers where (date between '$fromdate' and '$todate')"))
                    while($find = mysqli_fetch_array($query)){
                      echo $expense_total=$find['amt'];
                    }
                  ?>
                </th>
              </tr>
              <tr>
                <td>Paid</td>
                <th class="text-active">
                  <?php
                  if($query = mysqli_query($mysqli, "SELECT sum(t2.amount) as amt FROM expense t1, vouchers t2 where t1.payid=t2.id and (t2.date between '$fromdate' and '$todate')"))
                    while($find = mysqli_fetch_array($query)){
                      echo $expense_paid=$find['amt'];
                    }
                  ?>
                </th>
              </tr>
              <tr>
                <td>UnPaid</td>
                <th class="text-active">
                  <?php echo ($expense_total-$expense_paid); ?>
                </th>
              </tr>
          </table>
      </div>
      <div class="col-md-12"><hr></div>
      <div class="col-md-12">
        <center>Balance Ledger (Expense Excluded)</center>
        <table class="table table-hover table-borderless table-light table-responsive-lg">
          <tr>
            <th>Heads</th>
            <th>Opening</th>
            <th>Closing</th>
          </tr>
          <tr>
            <td>Cash Counter</td>
            <th class="text-warning"><?php echo ($cash_opening); ?></th>
            <th class="<?php if(($cash_opening+$calc_scash-$calc_pcash)<0) echo "text-danger"; else echo "text-success"; ?>"><?php echo ($cash_opening+$calc_scash-$calc_pcash); ?></th>
          </tr>
          <tr>
            <td>Bank</td>
            <th class="text-warning"> </th>
            <th> </th>
          </tr>
        </table>
      </div>
    </div>
  </div>
</div>
