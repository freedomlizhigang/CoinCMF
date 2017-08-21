@extends('admin.right')

@if(App::make('com')->ifCan('wxmenu-add'))
@section('rmenu')
	<div data-url="{{ url('/console/wxmenu/add') }}" data-title="添加自定义菜单" data-toggle='modal' data-target='#myModal' class="btn btn-default btn-xs btn_modal"><span class="glyphicon glyphicon-plus"></span> 添加自定义菜单</div>
@endsection
@endif

@section('content')

<table class="table table-striped table-hover">
	<tr class="active">
		<td width="60">排序</td>
		<td width="60">ID</td>
		<td>菜单名称</td>
		<td>类型</td>
		<td width="80">操作</td>
	</tr>
	@foreach($list as $l)
	<tr>
		<td>{{ $l->sort }}</td>
		<td>{{ $l->id }}</td>
		<td>{{ $l->name }} <div data-url="{{ url('/console/wxmenu/add',['pid'=>$l->id]) }}" class='glyphicon glyphicon-plus curp add_submenu btn_modal' data-title='添加自定义菜单' data-toggle='modal' data-target='#myModal'></div></td>
		<td>{{ $l->typename }}</td>
        <td>
        	<div data-url="{{ url('/console/wxmenu/edit',['id'=>$l->id]) }}" class='btn btn-xs btn-info glyphicon glyphicon-edit btn_modal' data-title='修改菜单' data-toggle='modal' data-target='#myModal'></div>
        	<a href="{{ url('/console/wxmenu/del',['id'=>$l->id]) }}" class='btn btn-xs btn-danger glyphicon glyphicon-trash confirm'></a>
    	</td>
	</tr>
	@foreach($l->sub as $ll)
	<tr>
		<td>{{ $ll->sort }}</td>
		<td>{{ $ll->id }}</td>
		<td> |- {{ $ll->name }}</td>
		<td>{{ $ll->typename }}</td>
        <td>
        	<div data-url="{{ url('/console/wxmenu/edit',['id'=>$ll->id]) }}" class='btn btn-xs btn-info glyphicon glyphicon-edit btn_modal' data-title='修改菜单' data-toggle='modal' data-target='#myModal'></div>
        	<a href="{{ url('/console/wxmenu/del',['id'=>$ll->id]) }}" class='btn btn-xs btn-danger glyphicon glyphicon-trash confirm'></a>
    	</td>
	</tr>
	@endforeach
	@endforeach
</table>
@endsection