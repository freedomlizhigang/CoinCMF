@extends('admin.right')

@if(App::make('com')->ifCan('field-add'))
@section('rmenu')
	<div data-url="{{ url('/console/field/add',$id) }}" data-title="添加字段" data-toggle='modal' data-target='#myModal' class="btn btn-xs btn-default btn_modal"><span class="iconfont icon-add"></span> 添加字段</div>
@endsection
@endif

@section('content')
<table class="table table-striped table-hover">
	<tr class="active">
		<th width="50">排序</th>
		<th width="150">名称</th>
		<th width="150">别名</th>
		<th>类型</th>
		<th width="80">状态</th>
		<th width="120">操作</th>
	</tr>
	@foreach($list as $m)
	<tr>
		<td>{{ $m->sort }}</td>
		<td>
			<p class="text-success">{{ $m->field_name }}</p>
		</td>
		<td>
			<p class="text-primary">{{ $m->title }}</p>
		</td>
		<td>
			{{ $m->type }}</td>
		<td>
			@if($m->status == 1)
			<span class="text-success">正常</span>
			@else
			<span class="color_red">禁用</span>
			@endif
		</td>
		<td>
			@if(App::make('com')->ifCan('field-edit'))
			<div data-url="{{ url('/console/field/edit',$m->id) }}" data-title="修改" data-toggle='modal' data-target='#myModal' class="btn btn-xs btn-info iconfont icon-translate btn_modal"></div>
			@endif
			@if(App::make('com')->ifCan('field-del'))
			<a href="{{ url('/console/field/del',$m->id) }}" class="btn btn-xs btn-danger iconfont icon-delete confirm"></a>
			@endif
		</td>
	</tr>
	@endforeach
</table>
@endsection