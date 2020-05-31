<script>
    function startPreloader() {
      $body.addClass("loading");
      console.log('startPreloader called');
    }

    function stopPreloader() {
      $body.removeClass("loading");
      console.log('stopPreloader called');
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
        startPreloader();
        Toast.fire({
          title: "Loading Products Data",
          icon: "success"
        });
        setTimeout(initProducts,2000);
    }

    function initTable(id) {
      Toast.fire({
        title: "Table Creation Initiated!",
        icon: "success"
      });
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
          [10, 25, 50, 100, -1],
          ["Show 10 Products", "Show 25 Products", "Show 50 Products", "Show 100 Products", "Show All Products"]
        ],
        "language": {
          "search": "_INPUT_",
          "searchPlaceholder": "Search Product",
        },
        "oLanguage": {
          "sLengthMenu": "_MENU_",
        },
        "order": [1, 'desc'],
        "columns": [
        { "title": "Icon" },
        { "title": "SKU" },
        { "title": "Name" },
        { "title": "Brand" },
        { "title": "Category" },
        { "title": "Subcategory" },
        { "title": "MRP" },
        { "title": "GST" },
        { "title": "Unit" },
        { "title": "Action" }
        ],
        "info": false,
        "dom": '<"top"Bf>rt<"bottom"lip><"clear">',
        "buttons": [{
          extend: 'pdf',
          title: 'Shanti Fresh Products '+$('#fromdate').val()+'-'+$('#todate').val(),
          filename: 'Shanti_Fresh_Products'+$('#fromdate').val()+'_'+$('#todate').val()
        }, {
          extend: 'excel',
          title: 'Shanti Fresh Products '+$('#fromdate').val()+'-'+$('#todate').val(),
          filename: 'Shanti_Fresh_Products'+$('#fromdate').val()+'_'+$('#todate').val()
        }, {
          extend: 'csv',
          filename: 'Shanti_Fresh Products'+$('#fromdate').val()+'_'+$('#todate').val()
        }]
      });

      $(".dataTables_wrapper .top").attr("class","top row mt-2 mb-1");
      $(".dataTables_wrapper .dt-buttons").attr("class","col-7 col-md-6 dt-buttons m-0 text-left");
      $(".dataTables_wrapper .dataTables_filter").attr("class","col dataTables_filter m-0 text-right");


      $(".dataTables_wrapper .bottom").attr("class","bottom row my-1");
      $(".dataTables_wrapper .dataTables_length").attr("class","col-12 col-sm-3 col-lg-4 mt-1 pt-1 dataTables_length text-center");
      $(".dataTables_wrapper .dataTables_paginate").attr("class","col-12 col-sm-9 col-lg-8 dataTables_paginate paging_full_numbers text-right");

      $(".dataTables_wrapper .pagination").css("margin","0px");
      Toast.fire({
        title: "Table Creation Complete",
        icon: "success"
      });
    }

    function initProducts() {
      ipurl='data/json/index.php?get=products';
      iprequestType="GET";
      ipreponseType="html";
      ipdata={
        get:'products'
      };

      if(!localStorage.getItem("products-url")) {
        $.ajax({
          url:ipurl,
          type:iprequestType,
          data:ipdata,
          dataType:ipreponseType,
          success: function(ipresp){
            localStorage.setItem('products-url', ipresp);
            loadProducts();
          }
        });
      } else {
        loadProducts();
        $.ajax({
          url:ipurl,
          type:iprequestType,
          data:ipdata,
          dataType:ipreponseType,
          success: function(ipresp){
            if (localStorage.getItem("products-url")!=ipresp) {
              localStorage.setItem('products-url', ipresp);
              loadProducts();
            }
          }
        });
      }
    }

    function loadProducts() {

      lpurl='data/json/'+localStorage.getItem("products-url");
      lprequestType="GET";
      lpreponseType="JSON";

      if(!localStorage.getItem("products-data")) {
        Toast.fire({
          title: "Products Data Searching!",
          icon: "success"
        });
        $.ajax({
          url:lpurl,
          type:lprequestType,
          data:{
            get:'data'
          },
          dataType:lpreponseType,
          success: function(lpresp){
            Toast.fire({
              title: "Products Data Found!",
              icon: "success"
            });
            localStorage.setItem('products-data', JSON.stringify(lpresp));
            dataJSON=JSON.parse(localStorage.getItem('products-data'));
            $('#products').empty().append(printData(dataJSON));
            $('[data-toggle=tooltip]').tooltip();initTable('products');
            stopPreloader();
          }
        });
      } else {
        Toast.fire({
          title: "Products Data Found!",
          icon: "success"
        });
        dataJSON=JSON.parse(localStorage.getItem('products-data'));
        $('#products').empty().append(printData(dataJSON));
        $('[data-toggle=tooltip]').tooltip();initTable('products');
        $.ajax({
          url:lpurl,
          type:lprequestType,
          data:{
            get:'data'
          },
          dataType:lpreponseType,
          success: function(lpresp){
            Toast.fire({
              title: "Products Data being Rechecked!",
              icon: "success"
            });
            localStorage.setItem('lptemp', JSON.stringify(lpresp));
            if (memorySizeOf(localStorage.getItem("products-data"))!=memorySizeOf(localStorage.getItem("lptemp"))) {
              Toast.fire({
                title: "New Data Found!",
                icon: "success"
              });
              localStorage.setItem('products-data', JSON.stringify(lpresp));
              $('#products').empty().append(printData(JSON.parse(localStorage.getItem('products-data'))));
              $('[data-toggle=tooltip]').tooltip();initTable('products');
            } else {
              Toast.fire({
                title: "No New Data Found!",
                icon: "success"
              });
            }
            localStorage.removeItem('lptemp');
            stopPreloader();
          }
        });
      }
    }



    function printData(data) {
      Toast.fire({
        title: "Data Print Initiated!",
        icon: "success"
      });
      print='<tbody>';
      for (var i of Object.keys(data)) {
        print+='<tr class="tr'+i+'">';
        print+='<td class="icon'+i+'"><img src="../app/account/assets/images/products/'+data[i]['icon']+'" style="width: 34px; height: 34px; border-radius: 50%;"></td>';
        print+='<td class="sku'+i+'">'+data[i]['sku']+'</td>';
        print+='<td class="name'+i+'"    data-toggle="tooltip" title="SF Name:    '+data[i]['name']+'">'+trimString(data[i]['name'],15)+'</td>';
        print+='<td class="brand'+i+'"   data-toggle="tooltip" title="SF Brand:   '+data[i]['brand']+'">'+trimString(data[i]['brand'],10)+'</td>';
        print+='<td class="cat'+i+'"     data-toggle="tooltip" title="SF Cat.:    '+data[i]['category']+'">'+trimString(data[i]['category'],10)+'</td>';
        print+='<td class="subcat'+i+'"  data-toggle="tooltip" title="SF SubCat.: '+data[i]['subcategory']+'">'+trimString(data[i]['subcategory'],15)+'</td>';
        print+='<td class="mrp'+i+'">'+data[i]['mrp']+'</td>';
        print+='<td class="gst'+i+'">'+data[i]['gst']+'</td>';
        print+='<td class="unit'+i+'">'+data[i]['unit']+'</td>';

        print+='<td>';
        print+='<span class="dropleft">';
        print+='  <button class="btn btn-sm btn-primary" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
        print+='    <i class="fa fa-cog"></i>';
        print+='  </button>';
        print+='  <div class="dropdown-menu bg-primary">';
        print+='    <a class="dropdown-item" href="javascript:void(0)" onclick="editExpieryDate('+i+')">Amazon</a>';
        print+='    <a class="dropdown-item" href="javascript:void(0)" onclick="editSellPrice('+i+')">BigBasket</a>';
        print+='  </div>';
        print+='</span>';
        print+='<button class="btn btn-sm btn-info" onclick="payProduct('+i+')"  data-toggle="tooltip" title="Pay Product - Rs '+(Math.round(data[i]['total']-data[i]['disc'])-Math.round(data[i]['paid']))+'"><i class="fa fa-money"></i></button>&nbsp;';
        print+='</td>';
        print+='</tr>';
      }
      print+='</tbody>';
      Toast.fire({
        title: "Data Print Complete!",
        icon: "success"
      });
      return print;
    }

    function sayLoud(i) {
      // var data = JSON.parse(localStorage.getItem('products-data'));
      // var picon = 'question';
      // if(data[i]['total']==0){
      //   picon="question";
      //   msg="Supplier Created Product";
      // } else if(data[i]['total']==(data[i]['paid']+data[i]['disc'])){
      //   picon="success";
      //   msg="Supplier Product Settled";
      // }  else if(data[i]['total']!=0){
      //   picon="warning";
      //   msg="Supplier Processed Product";
      // } else {
      //   picon="error";
      //   msg="Supplier Product not Settled";
      // }
      //
      // Pop.fire({
      //   icon: picon,
      //   title: 'Bill - '+i,
      //   html: "<br> Bill = "+i+"<br>Store = "+data[i]['store']+"<br>Biller = "+data[i]['sid']+"<br>"+supplier+" = "+data[i]['supplierid']+"<br><br>Total = ₹"+moneyFormat(data[i]['total'])+"<br> Discount = ₹"+moneyFormat(parseFloat(data[i]['disc']))+"<br> Net Payble = ₹"+moneyFormat(data[i]['total']-parseFloat(data[i]['disc']))+"<br>Paid = ₹"+moneyFormat(data[i]['paid']),
      // });
    }

    $("#products").on("dblclick", "td", function() {
      alert($( this ).text());
    });

    function moneyFormat(x) {
        return x.toString().split('.')[0].length > 3 ? x.toString().substring(0,x.toString().split('.')[0].length-3).replace(/\B(?=(\d{2})+(?!\d))/g, ",") + "," + x.toString().substring(x.toString().split('.')[0].length-3): x.toString();
    }

    function trimString(str, len) {
      if (str.length<=len) {
        return str;
      } else {
        str=str.substring(0, len);
        if (str.indexOf(' ') >= 0){
          return str.substring(0, (str + ' ').lastIndexOf(' ', len))+'...';
        } else {
          return str+'...';
        }
      }
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

    //init app
    setTimeout(init,1000);

</script>
