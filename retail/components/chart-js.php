<script>

//businessTrendSetup
btapiurl='http://smartretailpos.pe.hu/api/purchasesVsSales.php';
setTimeout(BTputListen, 1000);
setTimeout(getBusunessTrendData, 1500);

var data = [];
var date = [];
var bal = [];
var sales = [];
var purchases = [];
var purchasedamount = [];
var soldamount = [];
var purchasedtotal = 0;
var soldtotal = 0;
var balance = 0;

var busunessTrendCtx = document.getElementById('busunessTrendCanvas').getContext('2d');
var btchart = new Chart(busunessTrendCtx, {
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
                    },
                    {
                      label: 'Balance',
                      hidden: true,
                      borderColor: chartColors.grey,
                      backgroundColor: chartColors.grey,
                      data: bal
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
        position: 'top'
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
            labelString: 'Business Trend'
          }
        }]
      }
    }

});

function getBusunessTrendData() {
  var data = [];
  var date = [];
  var bal = [];
  var sales = [];
  var purchases = [];
  var purchasedamount = [];
  var soldamount = [];
  var purchasedtotal = 0;
  var soldtotal = 0;
  var balance = 0;
  $.ajax({
    url:btapiurl,
    type:'get',
    data: {
      fromdate:localStorage.getItem("btfilter-fromdate"),
      todate:localStorage.getItem("btfilter-todate")
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

      btchart.data.labels = date;
      btchart.data.datasets[0].data = purchasedamount;
      btchart.data.datasets[1].data = soldamount;
      btchart.data.datasets[2].data = purchases;
      btchart.data.datasets[3].data = sales;
      btchart.data.datasets[4].data = bal;

      btchart.options.title.text='TP: '+toINR(purchasedtotal)+' | TS: '+toINR(soldtotal)+ ' | Balance: '+toINR(balance);
      btchart.update();
      Toast.fire({
        title: "Chart Loaded!",
        icon: "success"
      });
    }
  });
}

function BTlisten(event){
  localStorage.setItem('btfilter-'+event.name, event.value);
}

function BTputListen(){
  if(!localStorage.getItem("btfilter-fromdate")) {
    localStorage.setItem('btfilter-fromdate', '<?php echo date('Y-m-d', strtotime('-7 days'));?>');
  } else{
    $('#fromdate').val(localStorage.getItem('btfilter-fromdate'));
  }

  if(!localStorage.getItem("btfilter-todate")) {
    localStorage.setItem('btfilter-todate', '<?php echo date("Y-m-d"); ?>');
  } else{
    $('#todate').val(localStorage.getItem('btfilter-todate'));
  }
}



$( "#busunessTrendCanvas" ).mousedown(function(e){
    if( e.button == 2 )
  changeBusunessTrendDate();
});


function changeBusunessTrendDate() {
  fromdate=localStorage.getItem("btfilter-fromdate");
  todate=localStorage.getItem("btfilter-todate");
  Pop.fire({
    title:'Business Trend Range',
    html:
      '<div class="row"><div class="col"><label class="control-label">From Date</label><input type="date" name="fromdate" id="fromdate" onchange="BTlisten(this);" class="form-control" value="'+fromdate+'"></div>' +
      '<div class="col"><label class="control-label">To Date</label><input type="date" name="todate" id="todate" onchange="BTlisten(this);" class="form-control" value="'+todate+'"></div>'+
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
      getBusunessTrendData();
    } else if (result.dismiss === Swal.DismissReason.cancel) {
      Toast.fire({
        title: "Action Cancelled!",
        icon: "error"
      });
    }
  });
}


//priceTrendSetup
ptapiurl='https://smartretailpos.pe.hu/api/productsPriceTrend.php';
setTimeout(PTputListen, 1000);
setTimeout(getPriceTrendData, 1500);
var psku = pname = '';

var productOptionsDom;
$.ajax({
  url:ptapiurl,
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
var ptchart = new Chart(priceTrendCtx, {
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
        text:  'Price Trend'
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
    url:ptapiurl,
    type:'get',
    data: {
      fromdate:localStorage.getItem("ptfilter-fromdate"),
      todate:localStorage.getItem("ptfilter-todate"),
      sku:localStorage.getItem("ptfilter-productSku")
    },
    dataType:'json',
    success: function(response){
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

      ptchart.data.labels = date;
      ptchart.data.datasets[0].data = buyprice;
      ptchart.data.datasets[1].data = sellprice;
      ptchart.data.datasets[2].data = mrp;
      ptchart.data.datasets[3].data = quantity;
      ptchart.data.datasets[4].data = profitpercent;
      ptchart.data.datasets[4].data = totalprofit;

      ptchart.options.title.text='Price Trend - '+localStorage.getItem("ptfilter-productSku")+' - '+localStorage.getItem("ptfilter-fromdate")+' -'+localStorage.getItem("ptfilter-todate");
      ptchart.update();
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
    localStorage.setItem('ptfilter-fromdate', '<?php echo date('Y-m-d', strtotime('-60 days'));?>');
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

$( "#priceTrendCanvas" ).mousedown(function(e){
    if( e.button == 2 )
  changePriceTrendDate();
});


function changePriceTrendDate() {
    fromdate=localStorage.getItem("ptfilter-fromdate");
    todate=localStorage.getItem("ptfilter-todate");
    productSku=localStorage.getItem("ptfilter-productSku");

  Pop.fire({
    title:'Price Trend Filter',
    html:
      '<div class="row">'+
      '<div class="col"><label class="control-label">Choose Product</label><input list="productlist" name="productSku" id="productSku" onchange="PTlisten(this);" class="form-control" value="'+productSku+'"><datalist id="productlist">'+
      productOptionsDom+
      '</datalist></div></div><div class="row">'+
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
