<html>
    <head>
        <title>Item Price Trend</title>
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
<?php
if (isset($_GET['sku'])) {
  echo 'sku='.$_GET['sku'].';';
  echo ' $("#sku").val('.$_GET['sku'].');';
} else {
  echo 'sku=1;';
}

?>

var psku = pname = '';
$.ajax({
  url:'http://smartretailpos.pe.hu/api/productsPriceTrend.php',
  type:'get',
  data:{
    empty:' ',
  },
  datatype: 'html',
  success: function(response){
    $('#selectdata').html(response);
  }
});


$.ajax({
  url:'http://smartretailpos.pe.hu/api/productsPriceTrend.php',
  type:'get',
  data:{
    sku:sku,
  },
  dataType:'json',
  success: function(response){
    var data = [];

    var sellprice = [];
    var mrp = [];
    var date = [];
    var quantity = [];
    var buyprice = [];
    var profitpercent = [];
    var totalprofit = [];
    var data = [];

    data=response;

    data.forEach(function (item){
      pname = item.name; psku = item.sku;
      item.purchases.forEach(function(purchase){
        buyprice.push(purchase.buyprice);
        sellprice.push(purchase.sellprice);
        mrp.push(purchase.mrp);
        date.push(purchase.date);
        quantity.push(purchase.quantity);
        profitpercent.push(Math.round((purchase.sellprice-purchase.buyprice)*100/purchase.buyprice));
        totalprofit.push(Math.round((purchase.sellprice-purchase.buyprice)*purchase.quantity));
      });
    });

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
                          label: 'Purchase Price',
                          borderColor: chartColors.green,
                          backgroundColor: chartColors.green,
                          data: buyprice
                        },
                        {
                          label: 'Sale Price',
                          borderColor: chartColors.red,
                          backgroundColor: chartColors.red,
                          data: sellprice
                        },
                        {
                          label: 'MRP',
                          hidden: true,
                          borderColor: chartColors.blue,
                          backgroundColor: chartColors.blue,
                          data: mrp
                        },
                        {
                          label: 'Purchase Quantity',
                          hidden: true,
                          borderDash: [5, 5],
                          borderColor: chartColors.grey,
                          backgroundColor: chartColors.grey,
                          data: quantity
                        },
                        {
                          label: 'Profit Percent',
                          hidden: true,
                          borderDash: [5, 2],
                          borderColor: chartColors.orange,
                          backgroundColor: chartColors.orange,
                          data: profitpercent
                        },
                        {
                          label: 'Net Profit',
                          hidden: true,
                          borderDash: [5, 3],
                          borderColor: chartColors.purple,
                          backgroundColor: chartColors.purple,
                          data: totalprofit
                        }
                      ]
        },

        // Configuration options go here
        options: {
          responsive: true,
          title: {
            display: true,
            text: psku+' - '+pname+' Price Trend'
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
            }],
            yAxes: [{
              display: true,
              scaleLabel: {
                display: true,
                labelString: 'Amount in INR'
              }
            }]
          }
        }

    });
  }
});

</script>
</html>
