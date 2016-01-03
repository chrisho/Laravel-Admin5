@extends('admin.default')

@section('content')
<style>
    .error-page > .error-content {
        padding-top: 40px;
    }    
</style>
<div class="error-page">
    <h2 class="headline text-yellow"> 404</h2>
    <div class="error-content">
        <h3><i class="fa fa-warning text-yellow"></i> Oops! {{$str|'找不到相关记录'}}。</h3>
    </div><!-- /.error-content -->
</div><!-- /.error-page -->
@stop
