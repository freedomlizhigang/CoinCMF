@extends('admin.right')

@section('rmenu')
	@if(App::make('com')->ifCan('wxtag-add'))
	<div data-url="{{ url('/console/wxtag/add') }}" data-title="添加标签组" data-toggle='modal' data-target='#myModal' class="btn btn-xs btn-default btn_modal"><span class="glyphicon glyphicon-plus"></span> 添加标签组</div>
	@endif
	@if(App::make('com')->ifCan('wxtag-sync'))
	<a href="{{ url('/console/wxtag/sync') }}" class="btn btn-xs btn-default confirm" data-msg="除新安装程序或更换绑定的微信公众号外，不要轻易“同步标签”。"><span class="glyphicon glyphicon-refresh"></span> 同步标签组</a>
	@endif
@endsection

@section('content')
<table class="table table-striped table-hover">
	<tr class="active">
		<th width="50">ID</th>
		<th>标签组</th>
		<th width="100">操作</th>
	</tr>
	@foreach($list as $m)
	<tr>
		<td>{{ $m->id }}</td>
		<td>{{ $m->name }}</td>
		<td>
			@if(App::make('com')->ifCan('wxtag-edit'))
			<div data-url="{{ url('/console/wxtag/edit',$m->id) }}" data-title="修改" data-toggle='modal' data-target='#myModal' class="btn btn-xs btn-info glyphicon glyphicon-edit btn_modal"></div>
			@endif
			@if(App::make('com')->ifCan('wxtag-del'))
			<a href="{{ url('/console/wxtag/del',$m->id) }}" class="btn btn-xs btn-danger glyphicon glyphicon-trash confirm"></a>
			@endif
		</td>
	</tr>
	@endforeach
</table>
@endsection