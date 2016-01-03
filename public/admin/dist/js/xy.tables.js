
var oTable;
var check_num = 0;

function initTable() {
    var options = {
        stateSave: true,
        destroy: true,
        displayLength: 10,
        dom: "<'row'<'col-sm-9'><'col-sm-3'f>>" +
		"<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-3 fg-toolbar'><'col-sm-9'p>>",
        language: {
            "processing": "正在加载中......",
            "lengthMenu": "每页显示 _MENU_ 条记录",
            "zeroRecords": "对不起，查询不到相关数据！",
            "emptyTable": "表中无数据存在！",
            "info": "当前显示 _START_ 到 _END_ 条，共 _TOTAL_ 条记录",
            "infoFiltered": "表中共为 _MAX_ 条记录",
            "search": "搜索",
            "paginate": {
                "first": "首页",
                "previous": "上一页",
                "next": "下一页",
                "last": "末页"
            }
        },
        drawCallback: function ( settings ) {          
            check_num=0;
            var div = $('<div></div>');
            var inp = $('<input />');
            inp.addClass('span3');
            inp.attr('type','text');
            
            div.attr('id','div');
            div.append("跳转到第&nbsp;");
            div.append(inp);
            div.append('&nbsp;页');
            
            if ( $('.fg-toolbar').html() == "")  {
                $('.fg-toolbar').append(div);
            }
                
            if (oTable === undefined) {
                oTable = $(".data-table-ajax").DataTable();
            }
            inp.keyup(function(e){
                if ($(this).val() && $(this).val() > 0) {
                    var redirectpage = $(this).val() - 1;
                    oTable.page(redirectpage).draw(false);
                }
            });
            if($('#checked_all').val()){// <input id="checked_all"/> 复选框选中值
                 var all = $('#checked_all').val().split(',');
                 $.each(all,function(k,y){
                      $('input[input_id='+y+']').prop("checked", true);
                 })
            }
        }
    };
    
    if (arguments.length > 0) {
        if(arguments[0] !== false){          
             options.serverSide = true;
             options.ajax = arguments[0];
        }

        if (arguments.length > 1 && arguments[1] !== false) {
            
            options.columnDefs = [{
                    orderable: false, //禁用排序
                    targets: [0]   //指定的列
                }];
        }
    }
    
    $('.data-table-ajax').addClass('table-hover');
    return $('.data-table-ajax').DataTable(options);
}

function initTable2() {
    var options = {
        "bJQueryUI": true,
        "length": 10,
        "bStateSave": false,
        "destroy": true,
        "sPaginationType": "full_numbers",
        "sDom": "<'row'<'col-sm-9'><'col-sm-3'f>>" +
		"<'row'<'col-sm-12'tr>>" +
		//"<'row'<'col-sm-5' ><'col-sm-7'p>>",
                "<'F'p>",
        "oLanguage": {
            "sProcessing": "正在加载中......",
            "sLengthMenu": "每页显示 _MENU_ 条记录",
            "sZeroRecords": "对不起，查询不到相关数据！",
            "sEmptyTable": "表中无数据存在！",
            "sInfo": "当前显示 _START_ 到 _END_ 条，共 _TOTAL_ 条记录",
            "sInfoFiltered": "表中共为 _MAX_ 条记录",
            "sSearch": "搜索",
            "oPaginate": {
                "sFirst": "首页",
                "sPrevious": "上一页",
                "sNext": "下一页",
                "sLast": "末页"
            }
        },
        
        "fnServerData" : function(sSource, aDataSet, fnCallback) {
            $.ajax({  
                "dataType" : 'json',  
                "type" : "get",  
                "url" : sSource,  
                "data" : aDataSet,  
                "success" : fnCallback  
            });  
         },  
         
        "fnDrawCallback": function (oSetting) {          
            check_num=0;
         // alert(oSetting.aoData.toSource());
            var div = $('<div></div>');
            var inp = $('<input />');
            inp.addClass('span3');
            inp.attr('type','text');
            
            div.attr('id','div');
            div.css('float','left');
            div.css('margin-top','-28px');
            div.append("跳转到第&nbsp;");
            div.append(inp);
            $('#div').remove();
            div.append('&nbsp;页');
            
            $('.fg-toolbar').append(div);
            if (oTable === undefined) {
                oTable = $(".data-table-ajax").dataTable();
            }
          
            inp.keyup(function(e){
                if ($(this).val() && $(this).val() > 0) {
                    var redirectpage = $(this).val() - 1;
                    oTable.fnPageChange(redirectpage, true);
                }
            });
          if($('#checked_all').val()){// <input id="checked_all"/> 复选框选中值
               var all = $('#checked_all').val().split(',');
               $.each(all,function(k,y){
                    $('input[input_id='+y+']').prop("checked", true);
               })
          }
      }
    };

    if (arguments.length > 0) {
        if(arguments[0] !== false){          
             options.bServerSide = true;
             options.sAjaxSource = arguments[0];
        }

        if (arguments.length > 1 && arguments[1] !== false) {
            
            options.columnDefs = [{
                    orderable: false, //禁用排序
                    targets: [0]   //指定的列
                }];
        }
       
        if (arguments.length > 3 && arguments[3] !== false) {
            options.fnRowCallback =arguments[3];
        }
        if (arguments.length > 4 && arguments[4] !== false) {
            var column = $(".data-table-ajax").attr('column');
         
            var num = 0;
            var sorting = 'desc';
            num = column.split(",")[0];
            sorting = column.split(",")[1];     
            options.aaSorting = [[num,sorting]];       //默认排序  参数column="列,desc"
                   
           
        }
        if (arguments.length > 2 && arguments[2] !== false) {
             options.initComplete = function () { 
             var api = this.api();
           
             $('select[data-type="search"]').each(function(){
                 var select = $(this);
                  var id =  select.attr('id');
                  var column = api.column(id);
                   var val = $.fn.dataTable.util.escapeRegex(
                              $(this).val()
                          );  
                    column.search(val?val:'',true,false).draw();
                  
                  $(this).on('change',function(){
                      var val = $.fn.dataTable.util.escapeRegex(
                              $(this).val()
                          );  
                      column.search(val?val:'',true,false).draw();
                  });
              
                  if(select.attr('data-option') == undefined || select.attr('data-option') == 'true') {
                     column.data().unique().sort().each(function(d,j){
                        select.append('<option value="'+d+'">'+d+'</option>' );
                     });
                  } 
                  
                 
             });
             
           /* api.columns().indexes().flatten().each( function ( i ) {
                var column = api.column( i );
                var select = $('<select><option value=""></option></select>')
                    .appendTo( $(column.footer()).empty() )
                    .on( 'change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );
                        column
                            .search( val ? val : '', true, false )
                            .draw();
                    } );
                column.data().unique().sort().each( function ( d, j ) {
                 
                    select.append( '<option value="'+d+'">'+d+'</option>' )
                } );
            } );*/
            }
        }
          if (arguments.length > 5 && arguments[5] !== false) {
             options.initComplete = function () { 
             var api = this.api();
             
             $('select[data-type="search"]').each(function(){
              
                  $(this).on('change',function(){
           
                  });
             });
    
            }
        }
        
       if (arguments.length > 6 && arguments[6] !== false) {
             options.aoColumns = arguments[6].aoColumns;
             var url = arguments[6].url;
             var token = arguments[6].token;
             var inputallocation = arguments[6].inputallocation;
             var selectallocation = arguments[6].selectallocation;
            options.fnDrawCallback = function (oSetting) {      
            $('.data-table-ajax tbody td.inputTd').editable(url,inputallocation);
            $('.data-table-ajax tbody td.selectTd').editable(url,selectallocation);
            check_num=0;
            var div = $('<div></div>');
            var inp = $('<input />');
            inp.addClass('span3');
            inp.attr('type','text');
            
            div.attr('id','div');
            div.css('float','left');
            div.css('margin-top','-28px');
            div.append("跳转到第&nbsp;");
            div.append(inp);
            $('#div').remove();
            div.append('&nbsp;页');
            
            $('.fg-toolbar').append(div);
            if (oTable === undefined) {
                oTable = $(".data-table-ajax").dataTable();
            }
          
            inp.keyup(function(e){
                if ($(this).val() && $(this).val() > 0) {
                    var redirectpage = $(this).val() - 1;
                    oTable.fnPageChange(redirectpage, true);
                }
            });

        }
  
        }
    }
    $('.data-table-ajax').addClass('table-hover');
    return  $('.data-table-ajax').DataTable(options);
}
$(document).ready(function () {

    $("span.icon input:checkbox, th input:checkbox").click(function () {
        var checkedStatus = this.checked;
        var checkbox = $(this).parents('.widget-box').find('tr td:first-child input:checkbox');
        checkbox.each(function () {
            this.checked = checkedStatus;
            if (checkedStatus == this.checked) {
                $(this).closest('.checker > span').removeClass('checked');
            }
            if (this.checked) {
                $(this).closest('.checker > span').addClass('checked');
            }
        });
    });

});


function RefreshTable(tableId, urlData)
{
  $.getJSON(urlData, null, function( json )
  {
    table = $(tableId).dataTable();
    oSettings = table.fnSettings();

    table.fnClearTable(this);
    //table.fnDraw();
  });
}


