@extends('admin.right')

@section('rmenu')

<a href="{{ url('/console/mater/index').'?type=image' }}" class="btn btn-xs btn-default @if($type == 'image') active @endif"><span class="glyphicon glyphicon-eye-open"></span> 图片</a>
<a href="{{ url('/console/mater/index').'?type=voice' }}" class="btn btn-xs btn-default @if($type == 'voice') active @endif"><span class="glyphicon glyphicon-eye-open"></span> 声音</a>
<a href="{{ url('/console/mater/index').'?type=video' }}" class="btn btn-xs btn-default @if($type == 'video') active @endif"><span class="glyphicon glyphicon-eye-open"></span> 视频</a>
<a href="{{ url('/console/mater/index').'?type=thumb' }}" class="btn btn-xs btn-default @if($type == 'thumb') active @endif"><span class="glyphicon glyphicon-eye-open"></span> 缩略图</a>

@if(App::make('com')->ifCan('mater-add'))
<a href="{{ url('/console/mater/add') }}" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-plus"></span> 添加素材</a>
@endif

@endsection


@section('content')
<!-- 选出栏目 -->
<table class="table table-striped table-hover mt10">
	<tr class="active">
		<th width="50">id</th>
		<th>标题</th>
		<th>缩略图</th>
		<th>链接</th>
		<th width="150">修改时间</th>
		<th width="100">操作</th>
	</tr>
	@foreach($list as $a)
	<tr>
		<td>{{ $a->id }}</td>
		<td>{{ $a->name }}</td>
		<td>
			<img src="{{ $a->content['localpath'] }}" alt="" width="100" class="pull-left mr15 img-responsive">
			<p class="text-primary"><strong>MEDIA_ID：</strong>{{ $a->media_id }}</p>
		</td>
		<td></td>
		<td>{{ $a->updated_at }}</td>
		<td>
			@if(App::make('com')->ifCan('mater-del'))
			<a href="{{ url('/console/mater/del',$a->id) }}" class="confirm btn btn-xs btn-danger glyphicon glyphicon-trash"></a>
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