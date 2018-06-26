@extends('admin.right')

@section('rmenu')
@if(App::make('com')->ifCan('art-add'))
<a href="{{ url('/console/art/add',$catid) }}" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-plus"></span> 添加文章</a>
@endif

@endsection


@section('content')
<!-- 选出栏目 -->
<div class="clearfix">
	<form action="" class="form-inline" method="get">
		<select name="catid" id="catid" class="form-control">
			<option value="">请选择栏目</option>
			{!! $cate !!}
		</select>
		开始时间：
		<input type="text" name="starttime" class="form-control" value="{{ $starttime }}" id="laydate">
		结束时间：
		<input type="text" name="endtime" class="form-control" value="{{ $endtime }}" value="" id="laydate2">
		<input type="text" name="q" value="{{ $key }}" class="form-control" placeholder="请输入文章标题关键字..">
		<button class="btn btn-xs btn-info">查找</button>
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
				@endif @if($a->ispos == 1)
				<span class="text-success">荐</span>
				@endif
			</td>
			<td>{{ $a->cate->name }}</td>
			<td>{{ $a->publish_at }}</td>
			<td>
				@if(App::make('com')->ifCan('art-edit'))
				<a href="{{ url('/console/art/edit',$a->id) }}" class="btn btn-xs btn-info glyphicon glyphicon-edit"></a>
				@endif
				@if(App::make('com')->ifCan('art-del'))
				<a href="{{ url('/console/art/del',$a->id) }}" class="confirm btn btn-xs btn-danger glyphicon glyphicon-trash"></a>
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
<div class="pages clearfix">
	{!! $list->appends(['catid' =>$catid,'q'=>$key,'starttime'=>$starttime,'endtime'=>$endtime])->links() !!}
</div>
<!-- 选中当前栏目 -->
<script>
	$(function(){
		$('.btn_listrorder').click(function(){
			$('.form_status').attr({'action':"{{ url('console/art/sort') }}",'method':'post'}).submit();
		});
		$('.btn_del').click(function(){
			if (!confirm("确实要删除吗?")){
				return false;
			}else{
				$('.form_status').attr({'action':"{{ url('console/art/alldel') }}",'method':'post'}).submit();
			}
		});
		$(".checkall").bind('change',function(){
			if($(this).is(":checked"))
			{
				$(".check_s").each(function(s){
					$(".check_s").eq(s).prop("checked",true);
				});
			}
			else
			{
				$(".check_s").each(function(s){
					$(".check_s").eq(s).prop("checked",false);
				});
			}
		});
		$('#catid option[value=' + {{ $catid }} + ']').prop('selected','selected');
	})
	laydate({
        elem: '#laydate',
        format: 'YYYY-MM-DD hh:mm:ss', // 分隔符可以任意定义，该例子表示只显示年月
        istime: true,
    });
    laydate({
        elem: '#laydate2',
        format: 'YYYY-MM-DD hh:mm:ss', // 分隔符可以任意定义，该例子表示只显示年月
        istime: true,
    });
</script>
@endsection