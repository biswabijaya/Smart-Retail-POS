<script>
    function startPreloader() {
      $body.addClass("loading");
    }

    function stopPreloader() {
      $body.removeClass("loading");
    }

    function initNav() {
        if(!localStorage.getItem("sidebar")) {
            localStorage.setItem("sidebar",1);
        } else {
            if(localStorage.getItem("sidebar")==0)
            $("#sidenavToggler").click();
        }

        $('#sidenavToggler').click(function(){
            if(localStorage.getItem("sidebar")==0)
                localStorage.setItem("sidebar",1);
            else
                localStorage.setItem("sidebar",0);
        });
    }

    function init() {
        initNav();
        initSalesPage();
    }

    function initNewSale(){
        initNewSaleFilter();
    }

    function filterSales() {
      startPreloader();
      initSales();
    }

    var table;

    function initSalesPage(){
        surl='components/sales.php';
        $.ajax({
          url:surl,
          type:'GET',
          data:{get:'data'},
          dataType:"html",
          success: function(sresp){
            $('#salesBody').empty().append(sresp);
            initSalesFilter();
          }
        });
    }

    function initSalesFilter(){
        furl='components/filtersort-sales.php';
        $.ajax({
          url:furl,
          type:'GET',
          data:{get:'data'},
          dataType:"html",
          success: function(fresp){
            $('#salesFilter').empty().append(fresp);
            initStaffs();
            initStores();
            initCustomers();
            initSales();
          }
        });
    }

    function initNewSaleFilter(){
        furl='components/filtersort-newsale.php';
        $.ajax({
          url:furl,
          type:'GET',
          data:{get:'data'},
          dataType:"html",
          success: function(fresp){
            $('#salesFilter').empty().append(fresp);
            initCustomers();
          }
        });
    }

    function detailstoogle() {
      if($('#summarytoogle').is(":checked")){
        $("#details").slideUp("slow");
        $("#summary").slideDown("slow");
      } else if($('#summarytoogle').is(":not(:checked)")){
        $("#summary").slideUp("slow");
        $("#details").slideDown("slow");
      }
    }

    function initTable(id) {
      if ( $.fn.dataTable.isDataTable('#'+id) ) {
        table.destroy();
      }
      table = $('#'+id).DataTable({
        "orderCellsTop": true,
        "fixedHeader": true,
        "responsive": true,
        "processing" : true,
        "pagingType": "full_numbers",
        "lengthMenu": [
          [5, 10, 50, -1],
          ["Show 5 Orders", "Show 10 Orders", "Show 50 Orders", "Show All Orders"]
        ],
        "language": {
          "search": "_INPUT_",
          "searchPlaceholder": "Search Order",
        },
        "oLanguage": {
          "sLengthMenu": "_MENU_",
        },
        "order": [1, 'desc'],
        "columns": [
        { "title": "SaleDate" },
        { "title": "Invoice" },
        { "title": "Customer" },
        { "title": "Store" },
        { "title": "Biller" },
        { "title": "Items" },
        { "title": "Total" },
        { "title": "Paid" },
        { "title": "Status" },
        { "title": "Action" }
        ],
        "info": false,
        "dom": '<"top"Bf>rt<"bottom"lip><"clear">',
        "buttons": [{
          extend: 'pdf',
          title: 'Shanti Fresh Sales '+$('#fromdate').val()+'-'+$('#todate').val(),
          filename: 'Shanti_Fresh_Sales'+$('#fromdate').val()+'_'+$('#todate').val()
        }, {
          extend: 'excel',
          title: 'Shanti Fresh Sales '+$('#fromdate').val()+'-'+$('#todate').val(),
          filename: 'Shanti_Fresh_Sales'+$('#fromdate').val()+'_'+$('#todate').val()
        }, {
          extend: 'csv',
          filename: 'Shanti_Fresh Sales'+$('#fromdate').val()+'_'+$('#todate').val()
        }]
      });

      $(".dataTables_wrapper .top").attr("class","top row mt-2 mb-1");
      $(".dataTables_wrapper .dt-buttons").attr("class","col-7 col-md-6 dt-buttons m-0 text-left");
      $(".dataTables_wrapper .dataTables_filter").attr("class","col dataTables_filter m-0 text-right");


      $(".dataTables_wrapper .bottom").attr("class","bottom row my-1");
      $(".dataTables_wrapper .dataTables_length").attr("class","col-12 col-sm-3 col-lg-6 mt-1 pt-1 dataTables_length text-center");
      $(".dataTables_wrapper .dataTables_paginate").attr("class","col dataTables_paginate paging_full_numbers text-right");

      $(".dataTables_wrapper .pagination").css("margin","0px");

    }

    function initSales() {
      url='data/sales.php';
      requestType="GET";
      reponseType="JSON";

      if(!localStorage.getItem("sales-data")) {
        $.ajax({
          url:'data/sales.php',
          type:requestType,
          data:{
            fromdate:$('#fromdate').val(),
            todate:$('#todate').val(),
            storecode:$('#storecode').val(),
            staffid:$('#staffid').val(),
            status:$('#status').val(),
            cno:$('#cno').val()
          },
          dataType:reponseType,
          success: function(response){
            localStorage.setItem('sales-data', JSON.stringify(response));
            dataJSON=JSON.parse(localStorage.getItem('sales-data'));
            $('#sales').empty().append(printData(dataJSON));
            $('[data-toggle=tooltip]').tooltip();initTable('sales');
            for(var key in dataJSON[0]){
              $('#sortOptions').append('<button>'+key+'</button>&nbsp;');
            }
            stopPreloader();
          }
        });
      } else {
        dataJSON=JSON.parse(localStorage.getItem('sales-data'));
        $('#sales').empty().append(printData(dataJSON));
        $('[data-toggle=tooltip]').tooltip();initTable('sales');
        for(var key in dataJSON[0]){
          $('#sortOptions').append('<button onclick="sortBy(\''+key+'\')">'+key+'</button>&nbsp;');
        }

        $.ajax({
          url:url,
          type:requestType,
          data:{
            fromdate:$('#fromdate').val(),
            todate:$('#todate').val(),
            storecode:$('#storecode').val(),
            staffid:$('#staffid').val(),
            status:$('#status').val(),
            cno:$('#cno').val()
          },
          dataType:reponseType,
          success: function(response){
            localStorage.setItem('temp', JSON.stringify(response));
            //console.log(memorySizeOf(localStorage.getItem("temp")));
            //console.log(memorySizeOf(localStorage.getItem("sales-data")));
            if (memorySizeOf(localStorage.getItem("sales-data"))!=memorySizeOf(localStorage.getItem("temp"))) {
              console.log('New Data Updated');
              Toast.fire({
                icon:'success',
                title: 'New Data Updated',
              });
              localStorage.setItem('sales-data', JSON.stringify(response));
              $('#sales').empty().append(printData(JSON.parse(localStorage.getItem('sales-data'))));
              $('[data-toggle=tooltip]').tooltip();initTable('sales');
            }
            localStorage.removeItem('temp');
            stopPreloader();
          }
        });
      }
    }

    function moneyFormat(x) {
        return x.toString().split('.')[0].length > 3 ? x.toString().substring(0,x.toString().split('.')[0].length-3).replace(/\B(?=(\d{2})+(?!\d))/g, ",") + "," + x.toString().substring(x.toString().split('.')[0].length-3): x.toString();
    }

    function printData(data) {
      print='<tbody>';

      total=disc=paid=0;
      for (var i of Object.keys(data)) {
        if(data[i]['total']==0){
          color="maroon";
          msg="ShantiFresh Created Order";
        }  else if(data[i]['total']==(data[i]['paid']+parseFloat(data[i]['disc']))){
          color="darkgreen";
          msg="ShantiFresh Order Settled";
        } else if(data[i]['total']>0){
          color="darkgoldenrod";
          msg="ShantiFresh Processed Order";
        } else {
          color="darkblue";
          msg="ShantiFresh Order not Settled";
        }

        if (data[i]['status']==0) {
          status='<td><p class="text-info">New</p></td>';
          trcolor="table-info";
        } else if (data[i]['status']==1) {
          status='<td><p class="text-danger">Unpaid</p></td>';
          trcolor="table-danger";
        } else if (data[i]['status']==2) {
          if (Math.round(data[i]['total']-data[i]['disc'])<Math.round(data[i]['paid'])) {
            status='<td><p class="text-warning">OverPaid</p></td>';
            trcolor="table-warning";
          } else if (Math.round(data[i]['total']-data[i]['disc'])>Math.round(data[i]['paid'])) {
            status='<td><p class="text-warning">Semi-paid</p></td>';
            trcolor="table-warning";
          } else {
            status='<td><p class="text-success">Paid</p></td>';
            trcolor="table-success";
          }
        }

        print+='<tr class="'+trcolor+'">';
        print+='<td><p>'+data[i]['date']+'</p></td>';
        print+='<td><p>'+i+'</p></td>';
        print+='<td><p data-toggle="tooltip">'+data[i]['cno']+'</p></td>';
        print+='<td><p data-toggle="tooltip" title="'+/*store[data[i]['store']]['name']+*/'">'+data[i]['store']+'</p></td>';
        print+='<td><p data-toggle="tooltip" title="Staff: '+/*staff[data[i]['sid']]['name']+*/'">'+data[i]['sid']+'</p></td>';

        print+='<td><p>'+data[i]['items']+'</p></td>';
        print+='<td><p onclick="sayLoud('+i+')">'+money_format(data[i]['total'])+'</p></td>';
        print+='<td><p data-toggle="tooltip" title="Discount:'+(data[i]['disc'])+'">'+money_format(data[i]['paid'])+'</p></td>';
        print+=status;

        print+='<td><p>';
        if (data[i]['status']==0) {
          print+='<button class="btn btn-sm btn-warning" onclick="editOrder('+i+')" data-toggle="tooltip" title="Edit Order"><i class="fa fa-pencil"></i></button>&nbsp;';
          print+='<button class="btn btn-sm btn-danger" onclick="cancelOrder('+i+')" data-toggle="tooltip" title="Cancel Order"><i class="fa fa-remove"></i></button>&nbsp;';
        } else if (data[i]['status']==1) {
          print+='<button class="btn btn-sm btn-danger" onclick="refreshOrder('+i+')"  data-toggle="tooltip" title="Refresh Order to Activate Edit"><i class="fa fa-refresh"></i></button>&nbsp;';
          print+='<button class="btn btn-sm btn-info" onclick="payOrder('+i+')"  data-toggle="tooltip" title="Pay Order Rs '+Math.round(data[i]['total']-data[i]['disc'])+'"><i class="fa fa-money"></i></button>&nbsp;';
        } else if (data[i]['status']==2) {
          print+='<button class="btn btn-sm btn-success" onclick="printOrder('+i+')"  data-toggle="tooltip" title="View/Print Order"><i class="fa fa-search"></i></button>&nbsp;';
          if (Math.round(data[i]['total']-data[i]['disc'])<Math.round(data[i]['paid'])) {
            status='<td><p class="text-warning">OverPaid</p></td>';
            trcolor="table-warning";
            print+='<button class="btn btn-sm btn-primary" onclick="refreshPayment('+i+')"  data-toggle="tooltip" title="Refresh Payment to Clear Payment Details"><i class="fa fa-refresh"></i></button>';
          } else if (Math.round(data[i]['total']-data[i]['disc'])>Math.round(data[i]['paid'])) {
            status='<td><p class="text-warning">Semi-paid</p></td>';
            trcolor="table-warning";
            print+='<button class="btn btn-sm btn-info" onclick="payOrder('+i+')"  data-toggle="tooltip" title="Pay Order - Rs '+(Math.round(data[i]['total']-data[i]['disc'])-Math.round(data[i]['paid']))+'"><i class="fa fa-money"></i></button>&nbsp;';

          }
          print+='<button class="btn btn-sm btn-primary" onclick="refreshPayment('+i+')"  data-toggle="tooltip" title="Refresh Payment to Clear Payment Details"><i class="fa fa-refresh"></i></button>';

        }

        print+='</p></td>';
        print+='</tr>';

        total+=data[i]['total'];
        disc+=data[i]['disc'];
        paid+=data[i]['paid'];
      }

      $('#billed').val(total);
      $('#disc').val(disc);
      $('#unpaid').val(total-(disc+paid));
      $('#paid').val(paid);

      print+='</tbody>';

      return print;
    }

    function sayLoud(i) {
      var data = JSON.parse(localStorage.getItem('sales-data'));
      var picon = 'question';
      if(data[i]['total']==0){
        picon="question";
        msg="ShantiFresh Created Order";
      } else if(data[i]['total']==(data[i]['paid']+data[i]['disc'])){
        picon="success";
        msg="ShantiFresh Order Settled";
      }  else if(data[i]['total']!=0){
        picon="warning";
        msg="ShantiFresh Processed Order";
      } else {
        picon="error";
        msg="ShantiFresh Order not Settled";
      }

      Pop.fire({
        icon: picon,
        title: 'Invoice - '+i,
        html: "<br> Invoice = "+i+"<br>Store = "+data[i]['store']+"<br>Biller = "+data[i]['sid']+"<br>"+customer+" = "+data[i]['cno']+"<br><br>Total = ₹"+moneyFormat(data[i]['total'])+"<br> Discount = ₹"+moneyFormat(parseFloat(data[i]['disc']))+"<br> Net Payble = ₹"+moneyFormat(data[i]['total']-parseFloat(data[i]['disc']))+"<br>Paid = ₹"+moneyFormat(data[i]['paid']),
      });
    }


    function money_format(num) {
      return num;
    }


    function memorySizeOf(obj) {
        var bytes = 0;

        function sizeOf(obj) {
            if(obj !== null && obj !== undefined) {
                switch(typeof obj) {
                case 'number':
                    bytes += 8;
                    break;
                case 'string':
                    bytes += obj.length * 2;
                    break;
                case 'boolean':
                    bytes += 4;
                    break;
                case 'object':
                    var objClass = Object.prototype.toString.call(obj).slice(8, -1);
                    if(objClass === 'Object' || objClass === 'Array') {
                        for(var key in obj) {
                            if(!obj.hasOwnProperty(key)) continue;
                            sizeOf(obj[key]);
                        }
                    } else bytes += obj.toString().length * 2;
                    break;
                }
            }
            return bytes;
        };

        function formatByteSize(bytes) {
            if(bytes < 1024) return bytes + " bytes";
            else if(bytes < 1048576) return(bytes / 1024).toFixed(3) + " KiB";
            else if(bytes < 1073741824) return(bytes / 1048576).toFixed(3) + " MiB";
            else return(bytes / 1073741824).toFixed(3) + " GiB";
        };

        return formatByteSize(sizeOf(obj));
    };

    function openOrder(i) {
      Toast.fire({
        title: "Open Order Under Construction!",
        icon: "error"
      });
    }

    function editOrder(i) {
      var data = JSON.parse(localStorage.getItem('sales-data'));
      if(parseInt(data[i]['cno'])>6000 && parseInt(data[i]['cno'])<10000){
        customer="Grozip";
      } else {
        customer="Customer";
      }
      Pop.fire({
        title: "Confirm Editing "+customer+" Order?",
        html: "<br> Invoice = "+i+"<br>Store = "+data[i]['store']+"<br>Biller = "+data[i]['sid']+"<br>"+customer+" = "+data[i]['cno']+"<br><br>Total = ₹"+moneyFormat(data[i]['total'])+"<br> Discount = ₹"+moneyFormat(parseFloat(data[i]['disc']))+"<br> Net Payble = ₹"+moneyFormat(data[i]['total']-parseFloat(data[i]['disc']))+"<br>Paid = ₹"+moneyFormat(data[i]['paid']),
        icon: "question",
        confirmButtonText: "Yes, Proceed",
        showCancelButton: true,
        reverseButtons: true,
        cancelButtonText: "No, Cancel!",
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
          window.open('https://shantifresh.com/shop/sale-items.php?action=add&id='+i, "_blank");
          Toast.fire({
            title: "Edit Request Generated!",
            icon: "success"
          });
        } else if ( result.dismiss === Swal.DismissReason.cancel ) {
          Toast.fire({
            title: "Request Dismissed!",
            icon: "error"
          });
        }
      });
    }

    function cancelOrder(i) {
      var data = JSON.parse(localStorage.getItem('sales-data'));
      if(parseInt(data[i]['cno'])>6000 && parseInt(data[i]['cno'])<10000){
        customer="Grozip Order";
      } else {
        customer="Customer";
      }
      Pop.fire({
        title: "Confirm Cancelling "+customer+" Order?",
        html: "<br> Invoice = "+i+"<br>Store = "+data[i]['store']+"<br>Biller = "+data[i]['sid']+"<br>"+customer+" = "+data[i]['cno']+"<br><br>Total = ₹"+moneyFormat(data[i]['total'])+"<br> Discount = ₹"+moneyFormat(parseFloat(data[i]['disc']))+"<br> Net Payble = ₹"+moneyFormat(data[i]['total']-parseFloat(data[i]['disc']))+"<br>Paid = ₹"+moneyFormat(data[i]['paid']),
        icon: "warning",
        confirmButtonText: "Yes, Cancel it!",
        showCancelButton: true,
        reverseButtons: true,
        cancelButtonText: "No, Don't Cancel!",
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
          $.ajax({
            url:'sales.php',
            type:'get',
            data:{
              id:i,
              action:'cancel'
            },
            dataType:'html',
            success: function(response){
              if(response==1){
                Toast.fire({
                  title: "Order Cancellation Success",
                  icon: "success",
                });
                setTimeout(initSales,1000);
              } else {
                console.log(response);
                Toast.fire({
                  title: "BackEnd Error Occured",
                  icon: "error",
                });
                setTimeout(initSales,1000);
              }
            }
          });
        } else if ( result.dismiss === Swal.DismissReason.cancel ) {
          Toast.fire({
            title: "Request Dismissed!",
            icon: "error"
          });
        }
      });
    }

    function refreshPayment(i) {
      var data = JSON.parse(localStorage.getItem('sales-data'));
      if(parseInt(data[i]['cno'])>6000 && parseInt(data[i]['cno'])<10000){
        customer="Grozip Order";
      } else {
        customer="Customer";
      }
      Pop.fire({
        title: "Confirm Refresh "+customer+" Payment?",
        html: "<br> Invoice = "+i+"<br>Store = "+data[i]['store']+"<br>Biller = "+data[i]['sid']+"<br>"+customer+" = "+data[i]['cno']+"<br><br>Total = ₹"+moneyFormat(data[i]['total'])+"<br> Discount = ₹"+moneyFormat(parseFloat(data[i]['disc']))+"<br> Net Payble = ₹"+moneyFormat(data[i]['total']-parseFloat(data[i]['disc']))+"<br>Paid = ₹"+moneyFormat(data[i]['paid']),
        icon: "warning",
        confirmButtonText: "Yes, Refresh it!",
        showCancelButton: true,
        reverseButtons: true,
        cancelButtonText: "No, Don't Refresh!",
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
          $.ajax({
            url:'sales.php',
            type:'get',
            data:{
              id:i,
              action:'refreshPayment'
            },
            dataType:'html',
            success: function(response){
              if(response==1){
                Toast.fire({
                  title: "Order Payment Refreshed",
                  icon: "success",
                });
                localStorage.setItem("sales-data",'{}');
                setTimeout(initSales,2000);
              } else {
                console.log(response);
                Toast.fire({
                  title: "BackEnd Error Occured",
                  icon: "error",
                });
              }
            }
          });
        } else if ( result.dismiss === Swal.DismissReason.cancel ) {
          Toast.fire({
            title: "Request Dismissed!",
            icon: "error"
          });
        }
      });
    }

    function refreshOrder(i) {
      var data = JSON.parse(localStorage.getItem('sales-data'));
      if(parseInt(data[i]['cno'])>6000 && parseInt(data[i]['cno'])<10000){
        customer="Grozip Order";
      } else {
        customer="Customer";
      }
      Pop.fire({
        title: "Confirm Refresh "+customer+" Order?",
        html: "<br> Invoice = "+i+"<br>Store = "+data[i]['store']+"<br>Biller = "+data[i]['sid']+"<br>"+customer+" = "+data[i]['cno']+"<br><br>Total = ₹"+moneyFormat(data[i]['total'])+"<br> Discount = ₹"+moneyFormat(parseFloat(data[i]['disc']))+"<br> Net Payble = ₹"+moneyFormat(data[i]['total']-parseFloat(data[i]['disc']))+"<br>Paid = ₹"+moneyFormat(data[i]['paid']),
        icon: "warning",
        confirmButtonText: "Yes, Refresh it!",
        showCancelButton: true,
        reverseButtons: true,
        cancelButtonText: "No, Don't Refresh!",
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
          $.ajax({
            url:'sales.php',
            type:'get',
            data:{
              id:i,
              action:'refreshOrder'
            },
            dataType:'html',
            success: function(response){
              if(response==1){
                Toast.fire({
                  title: "Order Payment Refreshed",
                  icon: "success",
                });
                localStorage.setItem("sales-data",'{}');
                setTimeout(initSales,2000);
              } else {
                console.log(response);
                Toast.fire({
                  title: "BackEnd Error Occured",
                  icon: "error",
                });
              }
            }
          });
        } else if ( result.dismiss === Swal.DismissReason.cancel ) {
          Toast.fire({
            title: "Request Dismissed!",
            icon: "error"
          });
        }
      });
    }

    function payOrder(i) {
      var data = JSON.parse(localStorage.getItem('sales-data'));
      if(parseInt(data[i]['cno'])>6000 && parseInt(data[i]['cno'])<10000){
        customer="Grozip Order";
      } else {
        customer="Customer";
      }
      Pop.fire({
        title: "Confirm Paying "+customer+" Order?",
        html: "<br> Invoice = "+i+"<br>Store = "+data[i]['store']+"<br>Biller = "+data[i]['sid']+"<br>"+customer+" = "+data[i]['cno']+"<br><br>Total = ₹"+moneyFormat(data[i]['total'])+"<br> Discount = ₹"+moneyFormat(parseFloat(data[i]['disc']))+"<br> Net Payble = ₹"+moneyFormat(data[i]['total']-parseFloat(data[i]['disc']))+"<br>Paid = ₹"+moneyFormat(data[i]['paid']),
        icon: "question",
        confirmButtonText: "Yes, Pay it!",
        showCancelButton: true,
        reverseButtons: true,
        cancelButtonText: "No, Don't Pay!",
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
          startPreloader();
          paymentWindow(i);
          Toast.fire({
            title: "Payment request of ₹"+moneyFormat(data[i]['total']-data[i]['disc'])+" for INV-"+i+" Generated!",
            icon: "success"
          });
        } else if ( result.dismiss === Swal.DismissReason.cancel ) {
          Toast.fire({
            title: "Request Dismissed!",
            icon: "error"
          });
        }
      });
    }

    function paymentWindow(id){
      localStorage.setItem('payment-amount',0);
      myWindow=window.open('https://shantifresh.com/shop/secure-payment.php?type=salepayments&id='+id,'','width='+screen.width/1.5+',height='+screen.height/1.5+',top='+screen.height/4.5+',left='+screen.width/4.5+',toolbar=no,scrollbars=no,location=no,resizable=yes');

      // Add this event listener; the function will be called when the window closes
      myWindow.onbeforeunload = function(){
        setTimeout(function(){
          checkPayment(id);
        },2000);
      };
      myWindow.focus();
    }

    function checkPayment(i) {
      var amount = localStorage.getItem('payment-amount');
      if (amount>0) {
        Toast.fire({
          title: "Payment of ₹"+moneyFormat(amount)+" on INV-"+i+" Success",
          icon: "success"
        });
        localStorage.setItem("sales-data",'{}');
        setTimeout(initSales,1000);
      } else {
        Toast.fire({
          title: "Payment for INV-"+i+" Failed",
          icon: "error"
        });
        stopPreloader();
      }
    }

    function printOrder(i) {
      var data = JSON.parse(localStorage.getItem('sales-data'));
      if(parseInt(data[i]['cno'])>6000 && parseInt(data[i]['cno'])<10000){
        customer="Grozip Order";
      } else {
        customer="Customer";
      }
      Pop.fire({
        title: "Confirm Printing "+customer+" Order?",
        html: "<br> Invoice = "+i+"<br>Store = "+data[i]['store']+"<br>Biller = "+data[i]['sid']+"<br>"+customer+" = "+data[i]['cno']+"<br><br>Total = ₹"+moneyFormat(data[i]['total'])+"<br> Discount = ₹"+moneyFormat(parseFloat(data[i]['disc']))+"<br> Net Payble = ₹"+moneyFormat(data[i]['total']-parseFloat(data[i]['disc']))+"<br>Paid = ₹"+moneyFormat(data[i]['paid']),
        icon: "question",
        confirmButtonText: "Yes, Print it!",
        showCancelButton: true,
        reverseButtons: true,
        cancelButtonText: "No, Don't Print!",
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
          window.open('https://shantifresh.com/shop/invoice.php?action=view&id='+i, "_blank");
          Toast.fire({
            title: "Print Request Generated!",
            icon: "success"
          });
        } else if ( result.dismiss === Swal.DismissReason.cancel ) {
          Toast.fire({
            title: "Request Dismissed!",
            icon: "error"
          });
        }
      });
    }

    function sendSMS(i) {
      var name=$("#u"+id).attr('uname');
      var cno=$("#u"+id).attr('ucno');

      Pop.fire({
        title: "Confirm Sending?",
        text: "Promo SMS To "+name+" ("+cno+")",
        icon: "info",
        confirmButtonText: "Yes, Send it!",
        showCancelButton: true,
        reverseButtons: true,
        cancelButtonText: "No, cancel !",
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
          $.ajax({
            url:'<?php echo $page;?>',
            type:'post',
            data:{
              id:id,
              action:'change',
              variable:'promosms',
              value:ymd()
            },
            dataType:'html',
            success: function(response){
              refreshRow(id);
              Toast.fire({
                text: "Promo SMS sent to "+name+" ("+cno+")",
                icon: "success",
              });
            }
          });
        } else if ( result.dismiss === Swal.DismissReason.cancel ) {
          Toast.fire({
            title: "Promo SMS Not Sent!",
            icon: "error"
          });
        }
      });
    }

    function edit(i) {

    }

    function sortBy(key) {
      $('#sales').empty().append(printData(_.sortBy(JSON.parse(localStorage.getItem('sales-data')), key)));
    }

    //init app
    setTimeout(init,1000);

    //async functions

    //init staffs
    function initStaffs() {
      //console.log('initStaffs called');
      isurl='data/json/index.php?get=staffs';
      isrequestType="GET";
      isreponseType="html";
      isdata={
        get:'staffs'
      };

      if(!localStorage.getItem("staffs-url")) {
        $.ajax({
          url:isurl,
          type:isrequestType,
          data:isdata,
          dataType:isreponseType,
          success: function(isresp){
            localStorage.setItem('staffs-url', isresp);
            loadStaffs();
            //console.log('init staff loaded-'+isresp);
          }
        });
      } else {
        loadStaffs();
        $.ajax({
          url:isurl,
          type:isrequestType,
          data:isdata,
          dataType:isreponseType,
          success: function(isresp){
            //console.log('init staff recheck-'+isresp);
            //console.log('isresp-'+isresp);
            //console.log('staffs-url'+localStorage.getItem("staffs-url"));
            if (localStorage.getItem("staffs-url")!=isresp) {
              //console.log('Staffs URL Updated');
              localStorage.setItem('staffs-url', isresp);
              loadStaffs();
            }
          }
        });
      }
    }

    function loadStaffs() {
     //console.log('loadStaffs called');
      lsurl='data/json/'+localStorage.getItem("staffs-url");
      lsrequestType="GET";
      lsreponseType="JSON";
      lsdata={
        get:"data"
      };

      if(!localStorage.getItem("staffs-data")) {
        $.ajax({
          url:lsurl,
          type:lsrequestType,
          data:lsdata,
          dataType:lsreponseType,
          success: function(lsresp){
            localStorage.setItem('staffs-data', JSON.stringify(lsresp));
            printStaffs();
            //console.log('load staff loaded');
          }
        });
      } else {
          printStaffs();
          $.ajax({
            url:lsurl,
            type:lsrequestType,
            data:lsdata,
            dataType:lsreponseType,
            success: function(lsresp){
              //console.log('load staff recheck');
              localStorage.setItem('lstemp', JSON.stringify(lsresp));
              //console.log('lstemp-'+memorySizeOf(localStorage.getItem("lstemp")));
              //console.log('staffs-data'+memorySizeOf(localStorage.getItem("staffs-data")));
              if (memorySizeOf(localStorage.getItem("staffs-data"))!=memorySizeOf(localStorage.getItem("lstemp"))) {
                //console.log('Staff Data Updated');
                localStorage.setItem('staffs-data', JSON.stringify(lsresp));
                printStaffs();
              }
              localStorage.removeItem('lstemp');
            }
          });
      }
    }

    //init stores
    function initStores() {
      //console.log('initStores called');
      irurl='data/json/index.php?get=stores';
      irrequestType="GET";
      irreponseType="html";
      irdata={
        get:'stores'
      };

      if(!localStorage.getItem("stores-url")) {
        $.ajax({
          url:irurl,
          type:irrequestType,
          data:irdata,
          dataType:irreponseType,
          success: function(irresp){
            localStorage.setItem('stores-url', irresp);
            loadStores();
            //console.log('init store loaded-'+irresp);
          }
        });
      } else {
        loadStores();
        $.ajax({
          url:irurl,
          type:irrequestType,
          data:irdata,
          dataType:irreponseType,
          success: function(irresp){
            //console.log('init store rechek'+irresp);
            //console.log('irresp-'+irresp);
            //console.log('stores-url'+localStorage.getItem("stores-url"));
            if (localStorage.getItem("stores-url")!=irresp) {
              //console.log('Store URL Updated');
              localStorage.setItem('stores-url', irresp);
              loadStores();
            }
          }
        });
      }
    }

    function loadStores() {
     //console.log('loadStores called');
      lrurl='data/json/'+localStorage.getItem("stores-url");
      lrrequestType="GET";
      lrreponseType="JSON";
      lrdata={
        get:"data"
      };

      if(!localStorage.getItem("stores-data")) {
        $.ajax({
          url:lrurl,
          type:lrrequestType,
          data:lrdata,
          dataType:lrreponseType,
          success: function(lrresp){
            localStorage.setItem('stores-data', JSON.stringify(lrresp));
            printStores();
            //console.log('load store loaded');
          }
        });
      } else {
          printStores();
        $.ajax({
          url:lrurl,
          type:lrrequestType,
          data:lrdata,
          dataType:lrreponseType,
          success: function(lrresp){
            //console.log('load store rechek');
            localStorage.setItem('lrtemp', JSON.stringify(lrresp));
            //console.log('lrtemp-'+memorySizeOf(localStorage.getItem("lrtemp")));
            //console.log('stores-data-'+memorySizeOf(localStorage.getItem("stores-data")));
            if (memorySizeOf(localStorage.getItem("stores-data"))!=memorySizeOf(localStorage.getItem("lrtemp"))) {
              //console.log('Staff Data Updated');
              localStorage.setItem('stores-data', JSON.stringify(lrresp));
              printStores();
            }
            localStorage.removeItem('lrtemp');
          }
        });
      }
    }

    //init staffs
    function initCustomers() {
      //console.log('initCustomers called');
      icurl='data/json/index.php?get=customers-virtual';
      icrequestType="GET";
      icreponseType="html";
      icdata={
        get:'customers'
      };

      if(!localStorage.getItem("cs-url")) {
        $.ajax({
          url:icurl,
          type:icrequestType,
          data:icdata,
          dataType:icreponseType,
          success: function(icresp){
            localStorage.setItem('cs-url', icresp);
            loadCustomers();
            //console.log('init customers loaded-'+icresp);
          }
        });
      } else {
        loadCustomers();
        $.ajax({
          url:icurl,
          type:icrequestType,
          data:icdata,
          dataType:icreponseType,
          success: function(icresp){
            //console.log('init customers recheck'+icresp);
            //console.log('icresp'+icresp);
            //console.log('cs-url'+localStorage.getItem("cs-url"));
            if (localStorage.getItem("cs-url")!=icresp) {
              //console.log('Customers URL Updated');
              localStorage.setItem('cs-url', icresp);
              loadCustomers();
            }
          }
        });
      }
    }

    function loadCustomers() {
     //console.log('loadCustomers called');
      lcurl='data/json/'+localStorage.getItem("cs-url");
      lcrequestType="GET";
      lcreponseType="JSON";
      lcdata={
        get:"data"
      };

      if(!localStorage.getItem("cs-data")) {
        $.ajax({
          url:lcurl,
          type:lcrequestType,
          data:lcdata,
          dataType:lcreponseType,
          success: function(lcresp){
            localStorage.setItem('cs-data', JSON.stringify(lcresp));
            printCustomers();
            //console.log('load customers loaded');
          }
        });
      } else {
        printCustomers();
        $.ajax({
          url:lcurl,
          type:lcrequestType,
          data:lcdata,
          dataType:lcreponseType,
          success: function(lcresp){
            //console.log('load customers recheck');
            localStorage.setItem('lcsptemp', JSON.stringify(lcresp));
            //console.log('lcsptemp-'+memorySizeOf(localStorage.getItem("lcsptemp")));
            //console.log('cs-data-'+memorySizeOf(localStorage.getItem("cs-data")));
            if (memorySizeOf(localStorage.getItem("cs-data"))!=memorySizeOf(localStorage.getItem("lcsptemp"))) {
              //console.log('Customers Data Updated');
              localStorage.setItem('cs-data', JSON.stringify(lcresp));
              printCustomers();
            }
            localStorage.removeItem('lcsptemp');
          }
        });
      }
    }

    //staff print
    function printStaffs() {
      //console.log('printStaffs called');
      psdata = JSON.parse(localStorage.getItem('staffs-data'));
      $('#staffid').empty().append('<option val="Choose">Choose</option>');
      for (var i of Object.keys(psdata)) {
        $('#staffid').append('<option val="'+i+'">'+i+'-'+psdata[i]['name']+'</option>');
      }
    }

    //store print
    function printStores() {
      //console.log('printStores called');
      prdata = JSON.parse(localStorage.getItem('stores-data'));
      $('#storecode').empty().append('<option val="Choose">Choose</option>');
      for (var i of Object.keys(prdata)) {
        $('#storecode').append('<option val="'+i+'">'+i+'-'+prdata[i]['name']+'</option>');
      }
    }

    //customers print
    function printCustomers() {
      //console.log('printCustomers called');
      pcdata = JSON.parse(localStorage.getItem('cs-data'));
      $('#cnodatalist').empty().append('<option val="Choose" selected>Choose</option>');
      for (var i of Object.keys(pcdata)) {
        $('#cnodatalist').append('<option value="'+i+'"> Sales - ('+pcdata[i]['sales']+')'+'</option>');
      }
    }
</script>
