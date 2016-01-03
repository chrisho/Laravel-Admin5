function xy_ajaxform(rule)
{
    var element = 'form'; // 默认
    if (arguments.length == 2) {
        element = arguments[1];
    }
    $("#" + element).validate({
        rules: rule,
        errorClass: "help-inline",
        errorElement: "p",
        highlight: function(element, errorClass, validClass) {
            $(element).parents('.form-group').removeClass('has-success');
            $(element).parents('.form-group').addClass('has-error');
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).parents('.form-group').removeClass('has-error');
            $(element).parents('.form-group').addClass('has-success');
        },
        submitHandler: function(form) {
            $(form).find('input,select,textarea').blur();
            $.progressModal();
            $(form).ajaxSubmit({
                success: function(responseText, statusText) {
                    if ($('#' + element).attr('data')=='html') {                        
                        $.tipsModal(responseText);
                        setTimeout(function() {
                            if ($('#' + element).attr('go')) {
                                location.href = $('#' + element).attr('go');
                            } else {
                                location.reload();
                            }
                        }, 2000);
                    }
                    else {
                        var json = jQuery.parseJSON(responseText);
                        $.tipsModal(json.text);                              
                        setTimeout(function() {
                            if (json.url) {
                                location.href = json.url;
                            } else if ($('#' + element).attr('go')) {
                                location.href = $('#' + element).attr('go');
                            } else {
                                location.reload();
                            }
                        }, 2000);
                    }
                },
                error: function(a, b, c, d) {
                    $.hideModal();
                    try {
                        var r = jQuery.parseJSON(a.responseText);
                        var s,i=0;
                        for (var j in r) {                     
                            var e = $("#"+j), er = j + "-error";
                            e.parents('.form-group').removeClass('has-success');
                            e.parents('.form-group').addClass('has-error');
                            
                            var msg = r[j].toString().replace(new RegExp(j), "");       
                            e.attr("aria-describedby", er);
                            if(e.next("p").length > 0){
                                $("#"+er).html(msg);
                            } else {
                                e.after("<p id=\""+j+"-error\" class=\"help-inline\">" + msg + "</p>");
                            }
                            $("#"+er).show();
                            if (i==0) {
                                s = e; i++;
                            }
                        } 
                        $("html,body").animate({scrollTop: e.offset().top - 50}, 200);
                        
                    } catch (e) {                        
                        $.tipsModal(a.responseText);
                    }
                    //$.tipsModal(a.responseText);  
                }
            });
        }
    });
}

$(function() {
    if ($('select').not('.unselect').length > 0) {
        $('select').not('.unselect,.picker__select--year,.picker__select--month').select2({
            formatNoMatches: function() {
                return '';
            },
            dropdownCssClass: 'select2-hidden'
        });
    }
});


var deleteUrl = "";
function deleteConfirm(url)
{  
    deleteUrl = url;
    $.confirmModal('确认删除吗？', delCallback);
}

var delCallback = function () 
{   
    xy_ajaxData({
        url:deleteUrl,
        type:'get',
        callback: function(text){
            $.tipsModal(text);
            if (oTable != undefined) {                
                oTable.draw(false);
                setTimeout(function(){
                    $.hideModal();
                },1000)
            } else {
                setTimeout(function(){
                    location.reload();
                },1000)
            }
        }
    });
}
/**
 * 
 * @param  data  传过去的参数
 * @param  url   地址
 * @param  type 提交的方式
 * @param  dataType 返回的数据类型
 * @param  callback 成功的回调函数
 *
 */


function xy_ajaxData(data){
   var data = eval(data);
   if (data['data']== undefined) {
       data['data'] = '';
   }
   if (data['dataType'] == undefined) {
       data['dataType'] = 'text';
   }
   if (data['callback'] == undefined) {
       data['callback'] = function(text){
           $.tipsModal(text);
            setTimeout(function(){
                location.reload();
            },1000)
       };
   }
   if (data['type'] == undefined) {
       data['type'] = 'post'
   }
 
    $.progressModal();
    $.ajax({
        url:data['url'],
        type:data['type'],
        data:data['data'],
        dataType:data['dataType'],
        success: data['callback'],
        error: function (XMLHttpRequest, textStatus, errorThrown){
             var err = XMLHttpRequest.responseText;             
             $.tipsModal(XMLHttpRequest.responseText);
        }
    });
}


function editOrderby(orderby,url) {
    var id = $(orderby).attr('data-id');
    var val = $(orderby).html();
    var input = $("<input />");
    input.attr('type', 'text');
    input.val(val);
    input.attr('data-id', id);
    input.attr('class','span12')
    $(orderby).html(input);
    input.focus();
    input.bind('blur', function(){
        if (val != $(this).val()) {
           xy_ajaxData({
                url:url,
                data:'value='+$(this).val()+'&id='+id,
                type:'get',
                dataType:'html',
                callback:function(){
                   $.hideModal();
                }
            });   
           
        } 
         $(orderby).html($(this).val());
    });
    
    input.bind('keydown',function(e){
        if (e.keyCode == 13){
            if (val != $(this).val()) {
                xy_ajaxData({
                     url:url,
                     data:'value='+$(this).val()+'&id='+id,
                     type:'get',
                     dataType:'html',
                     callback:function(){
                        $.hideModal();
                     }
                 });   

             } 
          $(orderby).html($(this).val());
        }
    });
   
    
}

function editProd(prid,url) {
    var id = $(prid).attr('data-id');
    var val = $(prid).html();
    var input = $("<input />");
    input.attr('type', 'text');
    input.val(val);
    input.attr('data-id', id);
    input.attr('class','span12')
    $(prid).html(input);
    input.focus();
    input.bind('blur', function(){
        if (val != $(this).val() && $(this).val()!='') {
           xy_ajaxData({
                url:url,
                data:'value='+$(this).val()+'&id='+id,
                type:'get',
                dataType:'html',
                callback:function(){
                   $.hideModal();
                }
            });   
           
        } 
        if ($(this).val()=='') {
             $(prid).html(val);
        } else {
             $(prid).html($(this).val());
        }
        
    });
    
    input.bind('keydown',function(e){
        if (e.keyCode == 13){
            if (val != $(this).val()  && $(this).val()!='') {
                xy_ajaxData({
                     url:url,
                     data:'value='+$(this).val()+'&id='+id,
                     type:'get',
                     dataType:'html',
                     callback:function(){
                        $.hideModal();
                     }
                 });   

             } 
            if ($(this).val()=='') {
                $(prid).html(val);
           } else {
                $(prid).html($(this).val());
           }
        }
    });
   
    
}
 
 function editField(field){
        var obj = $(field);
          var id = obj.attr('data-id');
          var value = obj.attr('data-value');
          
          xy_ajaxData({
                url: obj.attr('data-url'),
                data:'value='+value+'&id='+id,
                callback:function(html){
                    if (html == 1) {
                        obj.removeClass();
                        obj.addClass('icon-ok btn-info btn btn-mini');
                        obj.attr('data-id',id);
                        obj.attr('data-value',0)
                      }
                    if (html == 0) {
                        obj.removeClass();
                        obj.addClass('icon-remove btn-danger btn btn-mini');
                        obj.attr('data-id',id);
                        obj.attr('data-value',1)
                      }
                      
                      $.hideModal();
                },
                dataType:'html',
                type:'get'
            });   
       
        return false;
    }   