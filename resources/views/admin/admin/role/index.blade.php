@extends('admin.default')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box pox-primary">                
                <div class="box-header with-border">
                    <h5 class="box-title"><i class="fa fa-users"></i> 角色权限</h5>
                    <div class='pull-right'>
                        <a class='btn btn-info btn-xs' href='{{route('admin/role/add')}}'><i class='fa fa-plus'></i> 添加角色</a>
                    </div>
                </div>
                <div class="box-body nopadding">
                    <table class="table table-hover table-bordered data-table-ajax">
                        <thead>
                            <tr>
                                <th>角色</th>
                                <th>中文名称</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @stop

    @section('script')    
    <script>
    $(function(){
        initTable('{{route("admin/role/data")}}');
    });
    </script>
    @stop