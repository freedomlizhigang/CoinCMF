@extends('admin.right')

@if(App::make('com')->ifCan('model-add'))
@section('rmenu')
	<div data-url="{{ url('/console/model/add') }}" data-title="添加模型" data-toggle='modal' data-target='#myModal' class="btn btn-xs btn-default btn_modal"><span class="iconfont icon-add"></span> 添加模型</div>
@endsection
@endif

@section('content')
<table class="table table-striped table-hover">
	<tr class="active">
		<th width="50">ID</th>
		<th width="150">模型名称</th>
		<th>数据表</th>
		<th width="80">状态</th>
		<th width="120">操作</th>
	</tr>
	@foreach($list as $m)
	<tr>
		<td>{{ $m->id }}</td>
		<td>
			<p class="text-primary">{{ $m->title }}</p>
			<p class="text-success">{{ $m->describe }}</p>
		</td>
		<td class="text-muted">{{ $m->tablename }}</td>
		<td>
			@if($m->status == 1)
			<span class="text-success">正常</span>
			@else
			<span class="color_red">禁用</span>
			@endif
		</td>
		<td>
			@if(App::make('com')->ifCan('field-index'))
			<a href="{{ url('/console/field/index',$m->id) }}" title="字段管理" class="btn btn-xs btn-primary iconfont icon-list"></a>
			@endif
			@if(App::make('com')->ifCan('model-edit'))
			<div data-url="{{ url('/console/model/edit',$m->id) }}" data-title="修改" data-toggle='modal' data-target='#myModal' class="btn btn-xs btn-info iconfont icon-translate btn_modal"></div>
			@endif
			@if(App::make('com')->ifCan('model-del'))
			<a href="{{ url('/console/model/del',$m->id) }}" class="btn btn-xs btn-danger iconfont icon-delete confirm"></a>
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