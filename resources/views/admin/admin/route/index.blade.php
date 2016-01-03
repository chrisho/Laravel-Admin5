@extends('admin.default')

@section('content')
<script>var routes_id = new Array();</script>
<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">                
            <div class="box-header with-border">
                <h5 class="box-title"><i class="fa fa-registered"></i> {{$route->id ? "修改路由": "添加路由"}}</h5>
            </div>
            <div class="box-body nopadding" id="addMenu">
                <form action="{{$route->id ? route('admin/route/edit') : route('admin/route/add')}}" method="post" class="form-horizontal" 
                      id="form" autocomplete="off">
                    <input type="hidden" name="id" value="{{$route->id}}" />
                    {{csrf_field()}}
                    <div class="form-group">
                        <label class="col-md-2 control-label">名称</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="name" 
                                   id="name" placeholder="" value="{{$route->name}}" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">上级</label>
                        <div class="col-md-10">
                            <select  class="form-control select2" name="parent_id" 
                                     id="parent_id">
                                <option value="0">一级目录</option>      
                                @foreach ($routes as $r)
                                <option value="{{$r->id}}" {{$route->parent_id == $r->id ? 'selected' :''}}>&nbsp;|- {{$r->name}}</option>
                                @if ($route->groups)
                                @foreach($r->groups as $group)
                                <option value="{{$group->id}}" {{$route->parent_id == $group->id ? 'selected' :''}}>&nbsp;&nbsp;|-|- {{$group->name}}</option>
                                @endforeach
                                @endif
                                @endforeach                           
                            </select>
                            <span class="help-block">为一级目录时必填父级名
                                称，其他则不生效</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">二级域名/路由接收地址</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" 
                                   name="route_name" id="route_name" placeholder="" value="{{$route->route_name}}"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">指向控制器</label>
                        <div class="col-md-10">                               

                            <input type="text"  class="form-control" name="action" 
                                   id="action"  placeholder="" value="{{$route->action}}" />
                            <span class="help-block">二级域名时不填
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">静态路由</label>
                        <div class="col-md-10">                               
                            <input type="text"  class="form-control" name="other_route" 
                                   id="action"  placeholder="" value="{{$route->other_route}}" />
                            <p class="help-block">如果不设静态路由就不填写</p>
                        </div>
                    </div>

                    <div class="box-footer">
                        <button type="submit" class="btn btn-success">保存
                        </button>
                    </div>
                </form>
            </div>
        </div>


        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <?php $curr = current($routes->toArray()); ?>
                @foreach($routes as $parent)
                <li class="{{$curr['id'] == $parent->id  ? 'active': ''}}"><a href="#tab{{$parent->id}}" data-toggle="tab" value="0">{{$parent->name}}</a></li>
                @endforeach
            </ul> 
            <div class="tab-content">
                @foreach($routes as $route)       
                <div id="tab{{$route->id}}" class="tab-pane {{ $curr['id'] == $route->id ? 'active': ''}}">
                    <form id="route_form_{{$route->id}}" action="{{route('admin/route/edit')}}" class="form-horizontal" method="post">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        <input type="hidden" value="{{$route->id}}"  name="id"/>
                        <input type="hidden" value="{{$route->parent_id}}" name="parent_id"/>
                        <input type="hidden" value="{{$route->action}}" name="action"/>
                        <div class="form-group">
                            <label class="col-md-2 control-label">名称：</label>  
                            <div class="col-md-10">
                                <input type="text" class=" form-control" name="name" id="name" placeholder="" value="{{$route->name}}"/>
                            </div>           
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">二级域名：</label>  
                            <div class="col-md-10">
                                <input type="text" class=" form-control"  name="route_name" id="route_name" placeholder="" value="{{$route->route_name}}"/>
                            </div>
                        </div>
                        <div class="form-group">                                       
                            <label class="col-md-2 control-label">指向域名：</label> 
                            <div class="col-md-10">         
                                <select class="form-control select2" name="priority" id="priority">
                                    <option value="">不指向</option>      
                                    @foreach ($routes as $r)
                                    <option value="{{$r->route_name}}" {{$route->priority == $r->route_name ? 'selected' :''}}>&nbsp;|- {{$r->name}}</option>

                                    @endforeach                           
                                </select> 
                            </div>                            
                        </div>
                        <div class="form-group">
                            <div class="col-md-2"></div>
                            <div class="col-md-10">
                                <input type="submit" class="btn btn-success" style="margin-top:-10px;" value="保存"/> 
                                <input type="button" class="btn btn-danger delete" data="{{$route->id}}" style="margin-top:-10px;" value="删除"/>
                            </div>
                        </div>

                    </form> 
                    <table class="table table-bordered table-hover">       
                        @foreach($route->menus as $child)   
                        <tr>                            
                            <td>{{$child->name}}</td>
                            <td>{{$child->route_name}}</td>
                            <td>{{$child->other_route?$child->other_route:'无'}}</td>
                            <td>{{$child->action}}</td>
                            <td> 
                                {!!adminbuttons($child->id, 'admin/route', 1)!!}
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div>
                <script>
                    routes_id.push('{{$route->id}}');
                </script>
                @endforeach 
            </div>
        </div>

    </div>

</div>
@stop


@section('script')
<script>
    $(function () {
        var rule = {
            name: {
                required: true,
            },
            route_name: {
                required: true,
            },
        };
        xy_ajaxform(rule);
        $('.delete').click(function () {
            var id = $(this).attr('data');
            deleteConfirm('{{route("admin/route/delete")."?id="}}' + id);
        });
        var rule2 = {
            name: {
                required: true,
            },
            route_name: {
                required: true,
            }
        }
         for (var i = 0; i < routes_id.length; i++) {
            xy_ajaxform(rule2, 'route_form_' + routes_id[i]);
         }
    });

</script>
@stop