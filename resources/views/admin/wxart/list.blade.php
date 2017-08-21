@extends('admin.right')

@section('rmenu')
	@if(App::make('com')->ifCan('wxart-addart'))
	<a href="{{ url('/console/wxart/addart',['mid'=>$mid]) }}" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-plus"></span> 添加文章</a>
	@endif
@endsection


@section('content')
<form action="" class="form-inline form_submit" method="get">
{{ csrf_field() }}
<table class="table table-striped table-hover mt10">
	<tr class="active">
		<th width="30"><input type="checkbox" class="checkall"></th>
		<th width="80">排序</th>
		<th width="50">ID</th>
		<th>标题</th>
		<th width="180">修改时间</th>
		<th width="120">操作</th>
	</tr>
	@foreach($list as $a)
	<tr>
		<td><input type="checkbox" name="sids[]" class="check_s" value="{{ $a->id }}"></td>
		<td><input type="text" min="0" name="sort[{{$a->id}}]" value="{{ $a->sort }}" class="form-control input-xs"></td>
		<td>{{ $a->id }}</td>
		<td>{{ $a->title }}</td>
		<td>{{ $a->updated_at }}</td>
		<td>
			@if(App::make('com')->ifCan('wxart-edit'))
			<a href="{{ url('/console/wxart/editart',$a->id) }}" class="btn btn-xs btn-info glyphicon glyphicon-edit"></a> 
			@endif
			@if(App::make('com')->ifCan('wxart-del'))
			<a href="{{ url('/console/wxart/delart',$a->id) }}" class="confirm btn btn-xs btn-danger glyphicon glyphicon-trash"></a>
			@endif
		</td>
	</tr>
	@endforeach
</table>
</form>
<div class="pull-left" data-toggle="buttons">
	<div class="btn-group">
		<label class="btn btn-xs btn-primary"><input type="checkbox" autocomplete="off" class="checkall">全选</label>
	</div>
	
	@if(App::make('com')->ifCan('wxart-sort'))
	<span class="btn btn-xs btn-warning btn_sort">排序</span>
	@endif

</div>
<!-- 分页，appends是给分页添加参数 -->
<div class="pages clearfix">
	{!! $list->links() !!}
</div>
<script>
	$(function(){
		$('.btn_sort').click(function(){
			$('.form_submit').attr({'action':"{{ url('/console/wxart/sort') }}",'method':'post'}).submit();
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
	});
</script>
@endsection