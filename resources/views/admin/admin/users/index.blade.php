@extends('admin.default')

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box box-default">                
            <div class="box-header with-border">
                <h2 class="box-title">管理员</h2>
                <div class="pull-right">
                    <a class="btn btn-primary btn-xs" href="{{route("admin/users/add")}}"><i class="fa fa-plus"></i> 添加</a>
                </div>
            </div>
            <div class="box-body">
                <table class="table table-bordered data-table-ajax">
                    <thead>
                        <tr>
                            <th>用户名</th>
                            <th>真实姓名</th>
                            <th>邮箱</th>
                            <th>最后登录时间</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@stop

@section('script')
<script>
    $(function(){
        initTable('{{route("admin/users/data")}}');
    });
</script>
@stop