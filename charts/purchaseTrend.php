<html>
    <head>
        <title>Item Price Trend</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    </head>
    <body>
      <div class="container">
        <br><br>
        <div class="row">
          <div class="col-md-5">
            <br><br><br><br>
            <div id="selectdata">

            </div>
          </div>
          <div class="col-md-7">
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
} else {
  echo 'sku=1;';
}

?>
var psku = pname = '';
$.ajax({
  url:'http://smartretailpos.pe.hu/api/products.php',
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
                          borderColor: chartColors.blue,
                          backgroundColor: chartColors.blue,
                          data: mrp
                        },
                        {
                          label: 'Purchase Quantity',
                          borderDash: [5, 5],
                          borderColor: chartColors.grey,
                          backgroundColor: chartColors.grey,
                          data: quantity
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
