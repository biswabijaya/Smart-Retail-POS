<?php

$fromdate=$todate=date('Y-m-d');

$pagelink=$page.".php";
$urllink="?report=true";


$customsql=" ";

$storecode=$staffid=$cno='None';

//initialize fromdate
 if (isset($_GET['fromdate'])){
   $fromdate =$_GET['fromdate'];
   $urllink.="&fromdate=".$fromdate;
 }
//initialize todate
 if (isset($_GET['todate'])){
   $todate=$_GET['todate'];
   $urllink.="&todate=".$todate;
 }

 //initialize Store
 if (isset($_GET['storecode']) And $_GET['storecode']!="None") {
  $storecode=$_GET['storecode'];
  $urllink.="&storecode=".$storecode;
  $customsql.=" and storecode='".$storecode."'";
 }

 //initialize Biller
 if (isset($_GET['staffid']) And $_GET['staffid']!="None") {
  $staffid=$_GET['staffid'];
  $urllink.="&staffid=".$staffid;
  $customsql.=" and staffid='".$staffid."'";
 }

 //initialize Customer
 if (isset($_GET['cno']) And $_GET['cno']!="None") {
  $cno=$_GET['cno'];
  $urllink.="&cno=".$cno;
  $customsql.=" and cno='".$cno."'";
 }


 ?>

<div class="row">
  <div class="col-md-12">
    <div class="card bg-light mb-3">
      <div class="card-body">
        <div class="row">
          <div class="col-md-2">
            <label>Store</label>
            <select id="storecode" class="form-control" name="storecode" onchange="showPage1()">
              <option>None</option>
              <?php
              if($result = mysqli_query($mysqli, "SELECT storecode From sales group by storecode order by storecode ASC"))
              while($res = mysqli_fetch_array($result)){
                $print=" ";
                if ($res['storecode']==$storecode) $print="selected";
                echo '<option '.$print.'>'.$res['storecode'].'</option>';
              }
              ?>
            </select>
          </div>
          <div class="col-md-2">
            <label>Biller</label>
            <select id="staffid" class="form-control" name="staffid" onchange="showPage2()" <?php if ($_SESSION['usertype']=='admin') echo "required"; else echo "disabled";  ?>>
              <option>None</option>
              <?php
              if($result = mysqli_query($mysqli, "SELECT staffid From sales group by staffid order by staffid ASC"))
              while($res = mysqli_fetch_array($result)){
                $print=" ";
                if ($res['staffid']==$staffid) $print="selected";
                echo '<option '.$print.'>'.$res['staffid'].'</option>';
              }
              ?>
            </select>
          </div>
          <div class="col-md-4">
            <label>Customer</label>
            <select id="cno" class="form-control" name="cno" onchange="showPage3()">
              <option>None</option>
              <?php
              if($result = mysqli_query($mysqli, "SELECT cno From sales group by cno order by cno ASC"))
              while($res = mysqli_fetch_array($result)){
                $print=" ";
                if ($res['cno']==$cno) $print="selected";
                echo '<option '.$print.'>'.$res['cno'].'</option>';
              }
              ?>
            </select>
          </div>
          <div class="col-md-2">
            <label>From Date</label>
            <input type="date" class="form-control" min="2018-08-24" max="<?php echo date("Y-m-d"); ?>" name="fromdate"  onchange="window.location.href = '<?php echo $pagelink; echo $urllink; ?>&fromdate=' + this.value ;"value="<?php echo $fromdate; ?>">
          </div>
          <div class="col-md-2">
            <label>To Date</label>
            <input type="date" class="form-control" min="2018-08-24" max="<?php echo date("Y-m-d"); ?>" name="todate" onchange="window.location.href = '<?php echo $pagelink; echo $urllink; ?>&todate=' + this.value ;" value="<?php echo $todate; ?>">
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<script>
  function showPage1() {
    var sel = document.getElementById('storecode');
    var option = sel.options[sel.selectedIndex].value;
    window.location.href = "<?php echo $pagelink; echo $urllink; ?>&storecode=" + option ;
  }

  function showPage2() {
    var sel = document.getElementById('staffid');
    var option = sel.options[sel.selectedIndex].value;
    window.location.href = "<?php echo $pagelink; echo $urllink; ?>&staffid=" + option ;
  }

  function showPage3() {
    var sel = document.getElementById('cno');
    var option = sel.options[sel.selectedIndex].value;
    window.location.href = "<?php echo $pagelink; echo $urllink; ?>&cno=" + option ;
  }
</script>
