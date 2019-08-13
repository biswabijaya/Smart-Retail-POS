<?php

$fromdate=$todate=date('Y-m-d');

$pagelink=$page.".php";
$urllink="?report=true";


$customsql=$customsql2=" ";

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
 }

 //initialize Category
 if (isset($_GET['category']) And $_GET['category']!="None") {
  $category=$_GET['category'];
  $urllink.="&category=".$category;
  $customsql.=" and category='".$category."'";
  $customsql2.=" Where category='".$category."'";
 }

 //initialize Subcategory
 if (isset($_GET['subcategory']) And $_GET['subcategory']!="None") {
  $subcategory=$_GET['subcategory'];
  $urllink.="&subcategory=".$subcategory;
  $customsql.=" and subcategory='".$subcategory."'";
 }

 //initialize Payment Mode
 if (isset($_GET['mode']) And $_GET['mode']!="None") {
  $mode=$_GET['mode'];
  $urllink.="&mode=".$mode;
 }


 ?>

<div class="row">
  <div class="col-md-7">
    <div class="card bg-light mb-3">
      <div class="card-header">
        Filter Module
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-3">
            <label>Store</label>
            <select id="storecode" class="form-control" name="storecode" onchange="store()">
              <option>None</option>
              <?php
              if($result = mysqli_query($mysqli, "SELECT storecode From vouchers group by storecode order by storecode ASC"))
              while($res = mysqli_fetch_array($result)){
                $print=" ";
                if ($res['storecode']==$storecode) $print="selected";
                echo '<option '.$print.'>'.$res['storecode'].'</option>';
              }
              ?>
            </select>
          </div>
          <div class="col-md-3">
            <label>Staff Id</label>
            <select id="staffid" class="form-control" name="staffid" onchange="staffid()" <?php if ($_SESSION['usertype']=='admin') echo "required"; else echo "disabled";  ?>>
              <option>None</option>
              <?php
              if($result = mysqli_query($mysqli, "SELECT staffid From vouchers group by staffid order by staffid ASC"))
              while($res = mysqli_fetch_array($result)){
                $print=" ";
                if ($res['staffid']==$staffid) $print="selected";
                echo '<option '.$print.'>'.$res['staffid'].'</option>';
              }
              ?>
            </select>
          </div>
          <div class="col-md-3">
            <label>Category</label>
            <select id="category" class="form-control" name="category" onchange="category()" >
              <option>None</option>
              <?php
              if($result = mysqli_query($mysqli, "SELECT category From vouchers group by category order by category ASC"))
              while($res = mysqli_fetch_array($result)){
                $print=" ";
                if ($res['category']==$category) $print="selected";
                echo '<option '.$print.'>'.$res['category'].'</option>';
              }
              ?>
            </select>
          </div>
          <div class="col-md-3">
            <label>Subcategory</label>
            <select id="subcategory" class="form-control" name="subcategory" onchange="subcategory()">
              <option>None</option>
              <?php
              if($result = mysqli_query($mysqli, "SELECT subcategory From vouchers $customsql2 group by subcategory order by subcategory ASC"))
              while($res = mysqli_fetch_array($result)){
                $print=" ";
                if ($res['subcategory']==$subcategory) $print="selected";
                echo '<option '.$print.'>'.$res['subcategory'].'</option>';
              }
              ?>
            </select>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-5">
    <div class="card bg-light mb-3">
      <div class="card-header">
        Sort Module
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-4">
            <label>Mode</label>
            <select id="mode" class="form-control" name="mode" onchange="mode()" >
              <option>None</option>
              <?php
              if($result = mysqli_query($mysqli, "SELECT mode From expense group by mode order by mode ASC"))
              while($res = mysqli_fetch_array($result)){
                $print=" ";
                if ($res['mode']==$mode) $print="selected";
                echo '<option '.$print.'>'.$res['mode'].'</option>';
              }
              ?>
            </select>
          </div>
          <div class="col-md-4">
            <label>From Date</label>
            <input type="date" class="form-control" min="2018-10-01" max="<?php echo date("Y-m-d"); ?>" name="fromdate"  onchange="window.location.href = '<?php echo $pagelink; echo $urllink; ?>&fromdate=' + this.value ;"value="<?php echo $fromdate; ?>">
          </div>
          <div class="col-md-4">
            <label>To Date</label>
            <input type="date" class="form-control" min="2018-08-24" max="<?php echo date("Y-m-d"); ?>" name="todate" onchange="window.location.href = '<?php echo $pagelink; echo $urllink; ?>&todate=' + this.value ;" value="<?php echo $todate; ?>">
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<script>
  function storecode() {
    var sel = document.getElementById('storecode');
    var option = sel.options[sel.selectedIndex].value;
    window.location.href = "<?php echo $pagelink; echo $urllink; ?>&storecode=" + option ;
  }

  function staffid() {
    var sel = document.getElementById('staffid');
    var option = sel.options[sel.selectedIndex].value;
    window.location.href = "<?php echo $pagelink; echo $urllink; ?>&staffid=" + option ;
  }

  function category() {
    var sel = document.getElementById('category');
    var option = sel.options[sel.selectedIndex].value;
    window.location.href = "<?php echo $pagelink; echo $urllink; ?>&category=" + option ;
  }

  function subcategory() {
    var sel = document.getElementById('subcategory');
    var option = sel.options[sel.selectedIndex].value;
    window.location.href = "<?php echo $pagelink; echo $urllink; ?>&subcategory=" + option ;
  }

  function mode() {
    var sel = document.getElementById('mode');
    var option = sel.options[sel.selectedIndex].value;
    window.location.href = "<?php echo $pagelink; echo $urllink; ?>&mode=" + option ;
  }
</script>
