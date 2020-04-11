<html>
    <head>
        <title>Business Trend</title>
        <meta charset="utf-8">
      	<meta http-equiv="X-UA-Compatible" content="IE=Edge">
      	<meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@9/dist/sweetalert2.min.css" id="theme-styles">

        <style media="screen">
          .modalspin {
            display:    none;
            position:   fixed;
            z-index:    1000;
            top:        0;
            left:       0;
            height:     100%;
            width:      100%;
            background: rgba( 255, 255, 255, .8 )
                        url('https://i.stack.imgur.com/FhHRx.gif')
                        50% 50%
                        no-repeat;
          }

          /* When the body has the loading class, we turn
           the scrollbar off with overflow:hidden */
          body.loading .modalspin {
            overflow: hidden;
          }

          /* Anytime the body has the loading class, our
           modal element will be visible */
          body.loading .modalspin {
            display: block;
          }
        </style>
    </head>
    <body>
      <div class="container">
        <br><br>
        <div class="row">
          <div class="col-md-8 offset-md-2">
            <canvas id="priceTrendCanvas" height="200"></canvas>
          </div>
        </div>
      </div>
      <div class="modalspin"><!-- Place at bottom of page --></div>
    </body>
    <script src="https://www.chartjs.org/dist/2.9.3/Chart.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" ></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" ></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9/dist/sweetalert2.min.js"></script>

  <script>
  //SwalSetup
  const Pop = Swal.mixin({
    customClass: {
      confirmButton: 'btn-sm btn btn-success bg-success-dark-gradient',
      cancelButton: 'btn-sm btn btn-danger bg-danger-dark-gradient',
    },
    showClass: {
      popup: 'animated fadeInDown faster'
    },
    hideClass: {
      popup: 'animated fadeOutUp faster'
    },
    buttonsStyling: true
  });

  const Toast = Swal.mixin({
    toast: true,
    position: 'top',
    showConfirmButton: false,
    timer: 1000,
    timerProgressBar: true,
    onOpen: (toast) => {
      toast.addEventListener('mouseenter', Swal.stopTimer)
      toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
  });
  </script>

  <script>
  //ChatSetup
  chartColors = {
    red: 'rgb(255, 99, 132)',
    orange: 'rgb(255, 159, 64)',
    yellow: 'rgb(255, 205, 86)',
    green: 'rgb(75, 192, 192)',
    blue: 'rgb(54, 162, 235)',
    purple: 'rgb(153, 102, 255)',
    grey: 'rgb(201, 203, 207)'
  };
  </script>
<script>

//businessTrendSetup
apiurl='http://smartretailpos.pe.hu/api/productsPriceTrend.php';
setTimeout(PTputListen, 1000);
setTimeout(getPriceTrendData, 1500);
var psku = pname = '';

var productOptionsDom;
$.ajax({
  url:apiurl,
  type:'get',
  data:{
    productOptions:'Dom',
  },
  datatype: 'html',
  success: function(response){
    productOptionsDom=response;
  }
});


var data = [];
var date = [];
var sellprice = [];
var mrp = [];
var date = [];
var quantity = [];
var buyprice = [];
var profitpercent = [];
var totalprofit = [];

var priceTrendCtx = document.getElementById('priceTrendCanvas').getContext('2d');
var chart = new Chart(priceTrendCtx, {
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

function getPriceTrendData() {
  var data = [];
  var date = [];
  var sellprice = [];
  var mrp = [];
  var date = [];
  var quantity = [];
  var buyprice = [];
  var profitpercent = [];
  var totalprofit = [];

  $.ajax({
    url:apiurl,
    type:'get',
    data: {
      fromdate:localStorage.getItem("ptfilter-fromdate"),
      todate:localStorage.getItem("ptfilter-todate")
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
        purchasedtotal+=parseInt(item.purchasedamount);
        soldtotal+=parseInt(item.soldamount);
        balance+=parseInt(item.soldamount)-parseInt(item.purchasedamount);
        bal.push(balance);
      });

      chart.data.labels = date;
      chart.data.datasets[0].data = purchasedamount;
      chart.data.datasets[1].data = soldamount;
      chart.data.datasets[2].data = purchases;
      chart.data.datasets[3].data = sales;
      chart.data.datasets[4].data = bal;

      chart.options.title.text='TP: '+toINR(purchasedtotal)+' | TS: '+toINR(soldtotal)+ ' | Balance: '+toINR(balance);
      chart.update();
      Toast.fire({
        title: "Chart Loaded!",
        icon: "success"
      });
    }
  });
}

function PTlisten(event){
  localStorage.setItem('ptfilter-'+event.name, event.value);
}

function PTputListen(){
  if(!localStorage.getItem("ptfilter-fromdate")) {
    localStorage.setItem('ptfilter-fromdate', '<?php echo date("Y-m-d"); ?>');
  } else{
    $('#fromdate').val(localStorage.getItem('ptfilter-fromdate'));
  }

  if(!localStorage.getItem("ptfilter-todate")) {
    localStorage.setItem('ptfilter-todate', '<?php echo date("Y-m-d"); ?>');
  } else{
    $('#todate').val(localStorage.getItem('ptfilter-todate'));
  }

  if(!localStorage.getItem("ptfilter-productSku")) {
    localStorage.setItem('ptfilter-productSku', '10035');
  } else{
    $('#productSku').val(localStorage.getItem('ptfilter-productSku'));
  }
}

function toINR(num) {
  input = num;
  var n1, n2;
  num = num + '' || '';
  n1 = num.split('.');
  n2 = n1[1] || null;
  n1 = n1[0].replace(/(\d)(?=(\d\d)+\d$)/g, "$1,");
  num = n2 ? n1 + '.' + n2 : n1;
  return num;
}

$body=$("body");

$(document).on({
    ajaxStart: function() { $body.addClass("loading");    },
     ajaxStop: function() { $body.removeClass("loading"); }
});


$( "#priceTrendCanvas" ).click(function() {
  changePriceTrendDate();
});


function changePriceTrendDate() {
  fromdate=localStorage.getItem("ptfilter-fromdate");
  todate=localStorage.getItem("ptfilter-todate");
  productSku=localStorage.getItem("ptfilter-productSku");
  Pop.fire({
    title:'Business Trend Range',
    html:
      '<div class="row">'+
      '<div class="col"><label class="control-label">Choose Product</label><select name="productSku" id="productSku" onchange="PTlisten(this);" class="form-control" value="'+productSku+'">'+
      productOptionsDom+
      '</select></div></div><div class="row">'+
      '<div class="col"><label class="control-label">From Date</label><input type="date" name="fromdate" id="fromdate" onchange="PTlisten(this);" class="form-control" value="'+fromdate+'"></div>' +
      '<div class="col"><label class="control-label">To Date</label><input type="date" name="todate" id="todate" onchange="PTlisten(this);" class="form-control" value="'+todate+'"></div>'+
      '</div>',
    icon: "question",
    confirmButtonText: "Update",
    showCancelButton: true,
    reverseButtons: true,
    cancelButtonText: "Cancel",
    showLoaderOnConfirm: true,
    preConfirm: function(result){
        return new Promise(function(resolve, reject) {
            setTimeout(function(){
                //if statment only for test purposes filled with 2==1
                if(2 == 1){
                    Pop.fire("Oops", "Sorry something strange happend!", "error");
                }else{
                    resolve();
                }
            }, 1000);
        });
    },
    allowOutsideClick: false
  }).then((result) => {
    if (result.value) {
      getPriceTrendData();
    } else if (result.dismiss === Swal.DismissReason.cancel) {
      Toast.fire({
        title: "Action Cancelled!",
        icon: "error"
      });
    }
  });
}
</script>


</html>
