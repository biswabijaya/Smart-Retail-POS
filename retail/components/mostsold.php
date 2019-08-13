<?php
$fromdate=$todate=$today=date("Y-m-d");
$establisheddate='2018-08-24';

?>
<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        Most Sold Report Filter
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-6">
            <label>Choose Type</label>
              <select class="form-control" name="type" onchange="changetype();" id="type">
                <option value="monthly">Monthly</option>
                <option value="yearly">Yearly</option>
              </select>
          </div>
          <div class="col-md-6">
            <div id="monthly" class="typehiddable">
              <label>Monthly Report</label>
              <select class="form-control" name="month" id="month" onchange="getReport()">
                <option value="">Choose</option>
                <?php
                  $date1 = strtotime($establisheddate);
                  $date2 = strtotime($today);

                  while ($date2 >= $date1) {
                    $date=date('Y-m-01', $date2);
                    echo '<option value="'.$date.'">'.date('M-Y', $date2).'</option>';
                    $date2 = strtotime('-1 month', $date2);
                  }
                 ?>

              </select>
            </div>
            <div id="yearly" class="typehiddable" style="display:none;">
              <label>Yearly Report</label>
                <select class="form-control" name="year" id="year" onchange="getReport()">
                  <option value="">Choose</option>
                  <?php
                    $date1 = strtotime($establisheddate);
                    $date2 = strtotime($today);

                    while (date('Y', $date2) >= date('Y', $date1)) {
                      $date=date('Y-m-01', $date2);
                      echo '<option value="'.$date.'">'.date('Y', $date2).'</option>';
                      $date2 = strtotime('-1 year', $date2);
                    }
                   ?>

                </select>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    function changetype() {
      var data = $("#type").val();
      $(".typehiddable").slideUp();
      $("#"+data).slideDown();
      $(".typename").html(ucFirst(data));
      $("#reportbody").empty();
    }

    function getReport() {
      $("#reportbody").empty();
      var type = $("#type").val();
      type = type.substring(0, type.length -2);
      var date = $("#"+type).val();

      $.ajax({
        url: 'api/getMostSold.php',
        type: 'GET',
        data:{
          type: type,
          date: date
        },
        dataType:'html',   //expect html to be returned
        success: function(response){
          if (response==0) {
            $("#reportbody").html('<center>No Report Found Please <button class="btn btn-sm btn-success" id="generate" onclick="generateReport();">Click Here</button> to Generate</center>');
          } else {
            $("#reportbody").html(response);
          }
        }
      });
    }

    function generateReport() {
      var type = $("#type").val();
      type = type.substring(0, type.length -2);
      var date = $("#"+type).val();


      if (confirm("Confirm Generating Report")) {

        $("#reportbody").html('<center>Generating Please Wait</center>');

        $.ajax({
          url: 'api/generateMostSold.php',
          type: 'POST',
          data:{
            type: type,
            date: date
          },
          dataType:'html',   //expect html to be returned
          success: function(response){
            if (response==1) {
              getReport();
            } else {
              alert(response);
            }
          }
        });

      } else {
        alert("Thank You");
      }

    }

    function reGenerateReport() {
      var type = $("#type").val();
      type = type.substring(0, type.length -2);
      var date = $("#"+type).val();


      if (confirm("Confirm Re-Generating Report")) {

        $("#reportbody").html('<center>Generating Please Wait</center>');

        $.ajax({
          url: 'api/reGenerateMostSold.php',
          type: 'POST',
          data:{
            type: type,
            date: date
          },
          dataType:'html',   //expect html to be returned
          success: function(response){
            if (response==1) {
              getReport();
            } else {
              alert(response);
            }
          }
        });

      } else {
        alert("Thank You");
      }

    }

  </script>

</div>
<div class="row mt-3">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <span class="typename">Monthly</span> Report
      </div>
      <div class="card-body">
        <div id="reportbody">

        </div>
      </div>
    </div>
  </div>
</div>
