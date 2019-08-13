<?php

$fromdate=$todate=date('Y-m-d');

$pagelink=$page.".php";
$urllink="?report=true";


$customsql=" ";

$type=$staffid=$supplierid='None';

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
 if (isset($_GET['type']) And $_GET['type']!="None") {
  $type=$_GET['type'];
  $urllink.="&type=".$type;
  $customsql.=" and type='".$type."'";
 }

 //initialize Biller
 if (isset($_GET['staffid']) And $_GET['staffid']!="None") {
  $staffid=$_GET['staffid'];
  $urllink.="&staffid=".$staffid;
  $customsql.=" and staffid='".$staffid."'";
 }

 //initialize Customer
 if (isset($_GET['supplierid']) And $_GET['supplierid']!="None") {
  $supplierid=$_GET['supplierid'];
  $urllink.="&supplierid=".$supplierid;
  $customsql.=" and supplierid='".$supplierid."'";
 }


 ?>

<div class="row">
  <div class="col-md-12">
    <div class="card bg-light mb-3">
      <div class="card-header">
        Filter Module
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-2">
            <label>Staff ID</label>
            <select id="staffid" class="form-control" name="staffid" onchange="showPage1()" <?php if ($_SESSION['usertype']=='admin') echo "required"; else echo "disabled";  ?>>
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
            <label>Seller</label>
            <select id="supplierid" class="form-control" name="supplierid" onchange="showPage2()">
              <option>None</option>
              <?php
              if($result = mysqli_query($mysqli, "SELECT * From suppliers order by name ASC"))
              while($res = mysqli_fetch_array($result)){
                $print=" ";
                if ($res['id']==$supplierid) $print="selected";
                echo '<option value="'.$res['id'].'" '.$print.' >'.$res['name'].'</option>';
              }
              ?>
            </select>
          </div>
          <div class="col-md-2">
            <label>Type</label>
            <select id="type" class="form-control" name="type" onchange="showPage3()">
              <option>None</option>
              <option>Prepaid</option>
              <option>Postpaid</option>
            </select>
          </div>
          <div class="col-md-2">
            <label>From Date</label>
            <input type="date" class="form-control" min="2018-08-14" max="<?php echo date("Y-m-d"); ?>" name="fromdate"  onchange="window.location.href = '<?php echo $pagelink; echo $urllink; ?>&fromdate=' + this.value ;"value="<?php echo $fromdate; ?>">
          </div>
          <div class="col-md-2">
            <label>To Date</label>
            <input type="date" class="form-control" min="2018-08-15" max="<?php echo date("Y-m-d"); ?>" name="todate" onchange="window.location.href = '<?php echo $pagelink; echo $urllink; ?>&todate=' + this.value ;" value="<?php echo $todate; ?>">
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<script>


  function showPage1() {
    var sel = document.getElementById('staffid');
    var option = sel.options[sel.selectedIndex].value;
    window.location.href = "<?php echo $pagelink; echo $urllink; ?>&staffid=" + option ;
  }

  function showPage2() {
    var sel = document.getElementById('supplierid');
    var option = sel.options[sel.selectedIndex].value;
    window.location.href = "<?php echo $pagelink; echo $urllink; ?>&supplierid=" + option ;
  }

  function showPage3() {
    var sel = document.getElementById('type');
    var option = sel.options[sel.selectedIndex].value;
    window.location.href = "<?php echo $pagelink; echo $urllink; ?>&type=" + option ;
  }
</script>
