@extends('admin.default')

@section('content')
<form action="{{route('admin/role/edit')}}" method="post" class="form-horizontal" id="form" autocomplete="off">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <div class="box-title"><i class="fa fa-users"></i> 修改角色</div>
                    <div class="pull-right">
                        <a class='btn-default btn-sm' href='{{route('admin/role')}}'><i class='fa fa-reply'></i> 返回</a>
                    </div>
                </div>
                <div class="box-body nopadding">
                    <input type="hidden" name="id" value="{{$role->id}}" />
                    {{csrf_field()}}
                    <div class="form-group">
                        <label class="col-md-2 control-label">英文标识</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" placeholder="Role" name="name" id="name" value="{{$role->name}}"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">中文名称</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" placeholder="角色" name="display_name"  id="display_name" value="{{$role->display_name}}"/>
                        </div>
                    </div>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-success">保存</button>
                    </div>
                </div>
            </div>

            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    @foreach ($menus as $k=>$s)

                    <li class="{{$k==0?'active':''}}">
                        <a href="#tab{{$s->id}}" data-toggle="tab">{{$s->name}}</a>
                    </li>

                    @endforeach 
                </ul>
                <div class="tab-content">
                    @foreach ($menus as $k=>$s) 

                    <div id="tab{{$s->id}}" class="tab-pane {{$k==0?'active':''}}">
                        <div class="box-body table-responsive no-padding">
                            <div class="box-header"> 
                                <label class="control-label checkbox-parnet">
                                    <input type="checkbox" data-id="{{$s->id}}" class="minimal p{{$s->id}}" {{in_array($s->id, $menu_role) ? "checked" : ""}}/>                                
                                    <h5 class="box-title"><i class="fa {{$s->action}}"></i> {{$s->name}}</h5>
                                </label>
                            </div>
                            <div class="widget-content nopadding">
                                <table class="table table-hover table-bordered with-check table{{$s->id}}">
                                    <tbody>
                                        @foreach($s->menus as $c)                        
                                        <tr>                            
                                            <td><label class="control-label"><input type="checkbox" name="menu_id[]" value="{{$c->id}}" class="minimal cc" {{in_array($c->id, $menu_role) ? "checked" : ""}}> {{$c->name}}</label></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>        

                    </div>

                    @endforeach
                </div>
            </div>

        </div>

    </div>
</div>
</form>            
@stop

@section('script')
<script>
    $(function () {
        var rule = {
            name: {
                required: true,
                minlength: 3,
            },
            display_name: {
                required: true,
            },
        };
        xy_ajaxform(rule);
        
        var checksSelect = function(id, status) {
            var checkbox = $('.table' + id).find('tr td:first-child input:checkbox');
            checkbox.each(function () {
                if (status == "true") {
                    $(this).iCheck("check")
                } else {
                    $(this).iCheck("uncheck");
                }
            });
        }
        $(".checkbox-parnet").click(function () {
            var checkedStatus = $(this).children('div').attr('aria-checked');
            var id = $(this).find('input').attr('data-id');
            
            checksSelect(id, checkedStatus);
            
        });
        $(".tab-content .box-header .iCheck-helper").click(function () {
            var checkedStatus = $(this).parent().attr('aria-checked');
            var id = $(this).prev().attr('data-id');
            
            checksSelect(id, checkedStatus);
        });
    });
</script>
@stop