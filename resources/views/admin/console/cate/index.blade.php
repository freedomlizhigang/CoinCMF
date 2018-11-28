@extends('admin.right')


@section('rmenu')
	@if(App::make('com')->ifCan('cate-add'))
	<a href="{{ url('/console/cate/add/0') }}" class="layui-btn layui-btn-xs layui-btn-primary"><i class="layui-icon">&#xe654;</i>添加栏目</a>
	@endif
	@if(App::make('com')->ifCan('cate-cache'))
	<a href="{{ url('/console/cate/cache') }}" class="layui-btn layui-btn-xs layui-btn-primary"><i class="layui-icon">&#xe666;</i>更新缓存</a>
	@endif
@endsection


@section('content')

<table class="table table-striped table-hover">
	<thead>
		<tr class="active">
			<td width="60">排序</td>
			<td width="60">ID</td>
			<td>菜单名称</td>
			<td width="100">类型</td>
			<td width="100">显示</td>
			<td width="120">操作</td>
		</tr>
	</thead>
	<tbody>
	{!! $treeHtml !!}
	</tbody>
</table>
@endsection