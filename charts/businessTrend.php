<html>
    <head>
        <title>Business Trend</title>
        <meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=Edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">

    </head>
    <body>
      <div class="container">
        <br><br>
        <div class="row">
          <div class="col-md-4">
            <br><br><br><br>
            <div id="selectdata">

            </div>
          </div>
          <div class="col-md-8">
            <canvas id="myChart" height="200"></canvas>
          </div>
        </div>
      </div>
    </body>
    <script src="https://www.chartjs.org/dist/2.9.3/Chart.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" ></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" ></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

<script>
var psku = pname = '';
$.ajax({
  url:'http://smartretailpos.pe.hu/api/purchasesVsSales.php',
  type:'get',
  data:{
    empty:' ',
  },
  datatype: 'html',
  success: function(response){
    $('#selectdata').html(response);
  }
});

var data = [];
var date = [];
var sales = [];
var purchases = [];
var purchasedamount = [];
var soldamount = [];

chartColors = {
  red: 'rgb(255, 99, 132)',
  orange: 'rgb(255, 159, 64)',
  yellow: 'rgb(255, 205, 86)',
  green: 'rgb(75, 192, 192)',
  blue: 'rgb(54, 162, 235)',
  purple: 'rgb(153, 102, 255)',
  grey: 'rgb(201, 203, 207)'
};

var ctx = document.getElementById('myChart');
var chart = new Chart(ctx, {
// The type of chart we want to create
type: 'line',
// The data for our dataset
    data: {
        labels: date ,
        datasets: [
                    {
                      label: 'Purchase Amount',
                      borderColor: chartColors.green,
                      backgroundColor: chartColors.green,
                      data: purchasedamount
                    },
                    {
                      label: 'Sales Amount',
                      borderColor: chartColors.red,
                      backgroundColor: chartColors.red,
                      data: soldamount
                    },
                    {
                      label: 'Purchases Count',
                      hidden: true,
                      borderDash: [5, 5],
                      borderColor: chartColors.green,
                      backgroundColor: chartColors.green,
                      data: purchases
                    },
                    {
                      label: 'Sales Count',
                      hidden: true,
                      borderDash: [5, 5],
                      borderColor: chartColors.red,
                      backgroundColor: chartColors.red,
                      data: sales
                    }
                  ]
    },

    // Configuration options go here
    options: {
      responsive: true,
      title: {
        display: true,
        text: 'Business Trend'
      },
      legend:{
        position: 'left'
      },
      tooltips: {
        mode: 'index',
        intersect: false,
      },
      hover: {
        mode: 'nearest',
        intersect: true
      },
      elements: {
        line: {
          fill: false
        }
      },
      scales: {
        xAxes: [{
          display: true,
          scaleLabel: {
            display: true,
            labelString: 'Dates in (YYYY-MM-DD)'
          }
        }]
      }
    }

});


<?php
if (isset($_GET['fromdate']) and isset($_GET['todate'])) {
  ?>
  $.ajax({
    url:'http://smartretailpos.pe.hu/api/purchasesVsSales.php',
    type:'get',
    data:{
      fromdate:'<?php echo $_GET['fromdate']; ?>',
      todate:'<?php echo $_GET['todate']; ?>',
    },
    dataType:'json',
    success: function(response){


      data=response;

      data.forEach(function (item){
        date.push(item.date);
        purchases.push(item.purchases);
        purchasedamount.push(item.purchasedamount);
        sales.push(item.sales);
        soldamount.push(item.soldamount);
      });

      chart.data.datasets[0].data = purchasedamount;
      chart.data.datasets[1].data = soldamount;
      chart.data.datasets[2].data = purchases;
      chart.data.datasets[3].data = sales;
      chart.update();
            
    }
  });
  <?php
}
?>


</script>
</html>
