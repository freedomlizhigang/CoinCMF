@extends('admin.right')

@section('rmenu')
	@if(App::make('com')->ifCan('wxbroadcast-add'))
	<a href="{{ url('/console/wxbroadcast/add') }}" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-plus"></span> 群发消息</a>
	@endif
@endsection


@section('content')
<table class="table table-striped table-hover mt10">
	<tr class="active">
		<th width="320">标题</th>
		<th width="100">类型</th>
		<th>接收人</th>
		<th width="180">发送时间</th>
		<th width="80">操作</th>
	</tr>
	@foreach($list as $a)
	<tr>
		<td>{{ $a->title }}</td>
		<td>{{ $a->typename }}</td>
		<td>{{ $a->openid_name }}</td>
		<td>{{ $a->created_at }}</td>
		<td>
			@if(App::make('com')->ifCan('wxbroadcast-show'))
			<div data-url="{{ url('/console/wxbroadcast/show',['id'=>$a->id]) }}" class='btn btn-xs btn-info glyphicon glyphicon-eye-close btn_status'></div>
			@endif
			@if(App::make('com')->ifCan('wxbroadcast-del'))
			<a href="{{ url('/console/wxbroadcast/del',$a->id) }}" class="confirm btn btn-xs btn-danger glyphicon glyphicon-trash"></a>
			@endif
		</td>
	</tr>
	@endforeach
</table>
<!-- 分页，appends是给分页添加参数 -->
<div class="pages clearfix">
	{!! $list->links() !!}
</div>
<script>
	$(function(){
		$('.btn_status').click(function(){
			var urlThis = $(this).attr('data-url');
			$.get(urlThis,function(d){
				$('#success_alert').text(d).fadeIn('fast').delay(1000).fadeOut();
			})
		});
	})
</script>
@endsection