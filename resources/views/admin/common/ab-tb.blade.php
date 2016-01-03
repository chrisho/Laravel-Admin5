<a class="btn-sm btn-info" href="{{route($proute . '/edit', ['id'=>$id])}}" title="修改"><i class="fa fa-edit"> 修改</i></a> 
{{$other}}
<a class="btn-sm btn-danger delete" onclick="deleteConfirm('{{route($proute . '/delete', ['id'=>$id])}}');" title="删除"><i class="fa fa-remove"> 删除</i></a>
