@extends('admin.default')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="box box-info">                
            <div class="box-header with-border">
                <h5 class="box-title"><i class="fa fa-navicon"></i> {{isset($menu->id) ? "修改菜单" : "添加菜单"}}</h5>                
                <div class="pull-right">
                    <a class="btn btn-primary btn-xs" href="{{route("admin/menu")}}"><i class="fa fa-plus"></i> 添加</a>
                </div>
            </div>
            <div class="box-body">                    
                <form action="{{isset($menu->id) ? route('admin/menu/edit') : route('admin/menu/add')}}" class="form-horizontal" method="post" id="form" autocomplete="off">
                    {{ csrf_field() }}
                    @if ($menu->id) 
                    <input type="hidden" name="id" value="{{ $menu->id }}" />
                    @endif
                    <div class="form-group">
                        <label class="col-sm-2 control-label">名称</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="name" id="name" placeholder="" value="{{$menu->name}}" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">上级</label>
                        <div class="col-sm-10">
                            <select name="parent_id" id="parent_id" class="form-control select2">
                                <option value="0">一级目录</option> 
                                @foreach ($menus as $s)
                                <option value="{{$s->id}}" {{$menu->parent_id == $s->id ? 'selected' : ''}} >{{$s->name}}</option>
                                @endforeach                         
                            </select>
                            <p class="help-inline">为一级目录时必填父级名称，其他则不生效</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">一级名称/路由接收地址</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="route" id="route" placeholder="" value="{{$menu->route}}"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">指向控制器/图标CSS</label>
                        <div class="col-sm-10">
                            <input type="text"  class="form-control" name="action" id="action"  placeholder="" value="{{$menu->action}}" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">排序</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="order_by" id="order_by" placeholder="" value="{{$menu->order_by}}" />
                            <span class="help-inline">默认为： 0</span>
                        </div>
                    </div>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-success">保存</button>
                    </div>
                </form>
            </div>
        </div>



        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                @foreach ($menus as $k=>$s)
                <li class="{{isset($menu->id)?($s->id == $menu->id || $menu->parent_id == $s->id?'active':''):($k==0?'active':'')}}">
                    <a href="#tab{{$s->id}}" data-toggle="tab">{{$s->name}}</a>
                </li>
                @endforeach 
            </ul>

            <div class="tab-content">
                @foreach ($menus as $k=>$s) 
                <div id="tab{{$s->id}}" class="tab-pane {{isset($menu->id)?($s->id == $menu->id || $menu->parent_id == $s->id?'active':''):($k==0?'active':'')}}">
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover table-bordered">           
                            <thead>
                                <tr>            
                                    <th> {{$s->name}} </th>
                                    <th> {{$s->route}} </th>
                                    <th> {{$s->action}} </th>
                                    <th> {{$s->order_by}} </th>
                                    <th>                                         
                                        {!!adminbuttons($s->id, 'admin/menu', 1)!!}
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($s->menus as $c)                        
                                <tr>                            
                                    <td> {{$c->name}} </td>
                                    <td> {{$c->route}} </td>
                                    <td> {{$c->action}} </td>
                                    <td> {{$c->order_by}} </td>
                                    <td> 
                                        {!!adminbuttons($c->id, 'admin/menu', 1)!!}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@stop


@section('script')
<script>
    $(function () {
        var role = {
            name: {
                required: true,
            },
            route: {
                required: true,
            },
            action: {
                required: function () {
                    if ($('#parent_id').val() == 0)
                    {
                        return false;
                    }
                    return true;
                }
            }
        };
        xy_ajaxform(role);

        $('.delete').click(function () {
            var id = $(this).attr('data');
            deleteConfirm('{{route("admin/menu/delete")."?id="}}' + id);
        });
    });

</script>
@stop