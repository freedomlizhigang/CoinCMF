@extends('admin.right')


@section('content')

<div class="clearfix">
	<form action="" class="form-inline" method="get">
		<input type="text" name="q" class="form-control input-sm" placeholder="请输入用户名、邮箱、电话查询..">
		<button class="btn btn-xs btn-info">搜索</button>
	</form>
</div>

<table class="table table-striped table-hover mt10">
	<tr class="active">
		<th width="50">ID</th>
		<th width="80">会员等级</th>
		<th width="100">会员名</th>
		<th width="100">昵称</th>
		<th width="100">邮箱</th>
		<th width="100">电话</th>
		<th>修改状态</th>
		<th>操作</th>
	</tr>
	@foreach($list as $m)
	<tr>
		<td>{{ $m->id }}</td>
		<td>{{ $m->groupname }}</td>
		<td>{{ $m->username }}</td>
		<td>{{ $m->nickname }}</td>
		<td>{{ $m->email }}</td>
		<td>{{ $m->phone }}</td>
		<td>
			@if($m->status == 0)
			<span class="color_red">禁用</span> -> <a href="{{ url('/console/user/status',['id'=>$m->id,'status'=>1]) }}" class="text-success">正常</a>
			@else
			<span class="text-success">正常</span> -> <a href="{{ url('/console/user/status',['id'=>$m->id,'status'=>0]) }}" class="color_red">禁用</a>
			@endif
		</td>
		<td>
			@if(App::make('com')->ifCan('user-edit'))
			<div data-url="{{ url('/console/user/edit',$m->id) }}" data-title="改密码" title="改密码" data-toggle='modal' data-target='#myModal' class="btn btn-xs btn-danger glyphicon glyphicon-eye-close btn_modal"></div>
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