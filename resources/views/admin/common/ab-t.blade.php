<a class="tip" href="{{route($proute . '/edit', ['id'=>$id])}}" title="修改"><i class="fa fa-edit"></i></a> 
{{$other}}
<a class="tip" onclick="deleteConfirm('{{route($proute . '/delete', ['id'=>$id])}}');" title="删除"><i class="fa fa-remove"></i></a>
