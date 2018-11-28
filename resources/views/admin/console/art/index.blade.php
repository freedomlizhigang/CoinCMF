@extends('admin.right')

@section('rmenu')
	@if(App::make('com')->ifCan('art-add'))
	<a href="{{ url('/console/art/add',$catid) }}" class="layui-btn layui-btn-xs layui-btn-primary"><i class="layui-icon">&#xe654;</i>添加文章</a>
	@endif
@endsection

@section('content')
<!-- 选出栏目 -->
<div class="clearfix">
	<form action="" class="layui-form" method="get">
		<div class="layui-inline">
			<select name="catid" id="catid">
				<option value="">请选择栏目</option>
				{!! $cate !!}
			</select>
		</div>
		<div class="layui-inline">
			<select name="push_flag" id="push_flag">
				<option value="">是否推荐</option>
				<option value="1"@if($push_flag == 1) selected="selected"@endif>推荐</option>
				<option value="0"@if($push_flag == 0) selected="selected"@endif>普通</option>
			</select>
		</div>
		<div class="layui-inline">
			<label class="layui-form-label">开始时间：</label>
			<div class="layui-input-inline">
				<input type="text" name="starttime" value="{{ $starttime }}" id="laydate" class="layui-input">
			</div>
		</div>
		<div class="layui-inline">
			<label class="layui-form-label">结束时间：</label>
			<div class="layui-input-inline">
				<input type="text" name="endtime" value="{{ $endtime }}" value="" id="laydate2" class="layui-input">
			</div>
		</div>
		<div class="layui-inline">
			<input type="text" name="q" value="{{ $key }}" placeholder="请输入文章标题关键字.." class="layui-input">
		</div>
		<button class="layui-btn layui-btn-normal">查找</button>
	</form>
</div>
<form action="{{ url('/console/art/alldel') }}" class="form-inline form_status" method="get">
	{{ csrf_field() }}
	<table class="table table-striped table-hover mt10">
		<tr class="active">
			<th width="30">
				<input type="checkbox" class="checkall"></th>
			<th width="60">排序</th>
			<th width="50">ID</th>
			<th>标题</th>
			<th width="100">栏目</th>
			<th width="100">点击量</th>
			<th width="180">发布时间</th>
			<th width="100">操作</th>
		</tr>
		@foreach($list as $a)
		<tr>
			<td>
				<input type="checkbox" name="sids[]" class="check_s" value="{{ $a->id }}"></td>
			<td>
				<input type="text" name="sort[{{ $a->id }}]" class="form-control input-xs" value="{{ $a->sort }}"></td>
			<td>{{ $a->id }}</td>
			<td>
				<a href="{{ url('/post',$a->url) }}" target="_blank">{{ $a->title }}</a>
				@if($a->thumb != '')
				<span class="color_red">图</span>
				@endif
				@if($a->push_flag == 1)
				<span class="text-success">荐</span>
				@endif
			</td>
			<td>{{ $a->cate->name }}</td>
			<td>{{ $a->hits }}</td>
			<td>{{ $a->publish_at }}</td>
			<td>
				@if(App::make('com')->ifCan('art-edit'))
				<a href="{{ url('/console/art/edit',$a->id) }}" class="btn btn-xs btn-info iconfont icon-translate"></a>
				@endif
				@if(App::make('com')->ifCan('art-del'))
				<a href="{{ url('/console/art/del',$a->id) }}" class="confirm btn btn-xs btn-danger iconfont icon-delete"></a>
				@endif
			</td>
		</tr>
		@endforeach
	</table>
	<!-- 添加进专题功能 -->
	<div class="special_div pull-left clearfix" data-toggle="buttons">
		<div class="btn-group">
			<label class="btn btn-xs btn-primary"><input type="checkbox" autocomplete="off" class="checkall">全选</label>
		</div>
		@if(App::make('com')->ifCan('art-sort'))
		<button type="submit" name="dosubmit" class="btn btn-xs btn-warning btn_listrorder" data-status="0">排序</button>
		@endif

		@if(App::make('com')->ifCan('art-alldel'))
		<span class="btn btn-xs btn-danger btn_del">批量删除</span>
		@endif
	</div>
</form>
<!-- 分页，appends是给分页添加参数 -->
<div class="pages clearfix pull-right">
	{!! $list->appends(['catid' =>$catid,'q'=>$key,'push_flag'=>$push_flag,'starttime'=>$starttime,'endtime'=>$endtime])->links() !!}
</div>
<!-- 选中当前栏目 -->
<script>
	$(function(){
		$('#catid option[value=' + {{ $catid }} + ']').prop('selected','selected');
	});
</script>
@endsection