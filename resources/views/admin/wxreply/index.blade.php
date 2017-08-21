@extends('admin.right')

@section('rmenu')

<a href="{{ url('/console/reply/index').'?type=keyword' }}" class="btn btn-xs btn-default @if($type == 'keyword') active @endif"><span class="glyphicon glyphicon-eye-open"></span> 关键字</a>
<a href="{{ url('/console/reply/index').'?type=subscribe' }}" class="btn btn-xs btn-default @if($type == 'subscribe') active @endif"><span class="glyphicon glyphicon-eye-open"></span> 关注</a>

@if(App::make('com')->ifCan('reply-add'))
<a href="{{ url('/console/reply/add') }}" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-plus"></span> 添加回复</a>
@endif

@endsection


@section('content')
<table class="table table-striped table-hover mt10">
	<tr class="active">
		<th width="50">id</th>
		<th width="200">标题</th>
		<th width="200">关键字</th>
		<th>回复内容</th>
		<th width="180">修改时间</th>
		<th width="100">操作</th>
	</tr>
	@foreach($list as $a)
	<tr>
		<td>{{ $a->id }}</td>
		<td>{{ $a->title }}</td>
		<td>{{ $a->keyword }}</td>
		<td>
			<span class="text-danger pull-left mr10">{{ $a->typename }}</span>
			@if($a->replytype == 'image' && $a->files != '')
			<img src="{{ $a->files }}" alt="" width="100" class="img-responsive pull-left mr15">
			@endif
			@if($a->replytype != 'text')
			<p class="text-primary">素材名称：{{ isset($a->mater) ? $a->mater->name : '' }}</p>
			@endif
			{!! $a->content !!}
		</td>
		<td>{{ $a->updated_at }}</td>
		<td>
			@if(App::make('com')->ifCan('reply-del'))
			<a href="{{ url('/console/reply/edit',['id'=>$a->id]) }}" class='btn btn-xs btn-info glyphicon glyphicon-edit btn_modal'></a>
			@endif
			@if(App::make('com')->ifCan('reply-del'))
			<a href="{{ url('/console/reply/del',$a->id) }}" class="confirm btn btn-xs btn-danger glyphicon glyphicon-trash"></a>
			@endif
		</td>
	</tr>
	@endforeach
</table>
<!-- 分页，appends是给分页添加参数 -->
<div class="pages clearfix">
	{!! $list->appends(['type' =>$type])->links() !!}
</div>
@endsection