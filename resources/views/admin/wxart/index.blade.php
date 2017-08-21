@extends('admin.right')

@section('rmenu')
	@if(App::make('com')->ifCan('wxart-add'))
	<a href="{{ url('/console/wxart/add') }}" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-plus"></span> 添加图文消息</a>
	@endif
@endsection


@section('content')
<table class="table table-striped table-hover mt10">
	<tr class="active">
		<th width="50">ID</th>
		<th>标题</th>
		<th>MediaId</th>
		<th width="180">修改时间</th>
		<th width="120">操作</th>
	</tr>
	@foreach($list as $a)
	<tr>
		<td>{{ $a->id }}</td>
		<td>{{ $a->name }}</td>
		<td>{{ $a->media_id }}</td>
		<td>{{ $a->updated_at }}</td>
		<td>
			@if(App::make('com')->ifCan('wxart-list'))
			<a href="{{ url('/console/wxart/list',$a->id) }}" class="btn btn-xs btn-success glyphicon glyphicon-eye-open"></a> 
			@endif
			@if(App::make('com')->ifCan('wxart-edit'))
			<a href="{{ url('/console/wxart/edit',$a->id) }}" class="btn btn-xs btn-info glyphicon glyphicon-edit"></a> 
			@endif
			@if(App::make('com')->ifCan('wxart-del'))
			<a href="{{ url('/console/wxart/del',$a->id) }}" class="confirm btn btn-xs btn-danger glyphicon glyphicon-trash"></a>
			@endif
		</td>
	</tr>
	@endforeach
</table>
<!-- 分页，appends是给分页添加参数 -->
<div class="pages clearfix">
	{!! $list->links() !!}
</div>
@endsection