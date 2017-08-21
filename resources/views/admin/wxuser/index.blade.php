@extends('admin.right')

@section('rmenu')
	@if(App::make('com')->ifCan('wxuser-sync'))
	<a href="{{ url('/console/wxuser/sync') }}" class="btn btn-xs btn-default confirm" data-msg='除新安装程序或更换绑定的微信公众号外，不要轻易“同步用户”。'><span class="glyphicon glyphicon-refresh"></span> 同步用户</a>
	@endif
@endsection

@section('content')
<!-- 筛选 -->
<div class="clearfix">
	<form action="" class="form-inline" method="get">
		<select name="gid" id="gid" class="form-control">
			<option value="">用户标签</option>
			@foreach($tlist as $g)
			<option value="{{ $g->id }}" @if($gid == $g->id) selected="selected" @endif>{{ $g->name }}</option>
			@endforeach
		</select>
		<input type="text" name="q" value="{{ $key }}" class="form-control" placeholder="请输入昵称..">
		<button class="btn btn-xs btn-info">查找</button>
	</form>
</div>
<form action="" class="form-inline form_submit" method="get">
{{ csrf_field() }}
<table class="table table-striped table-hover mt10">
	<tr class="active">
		<th width="30"><input type="checkbox" class="checkall"></th>
		<th width="50">ID</th>
		<th width="400">用户</th>
		<th>标签</th>
		<th width="80">关注状态</th>
		<th width="150">关注时间</th>
	</tr>
	@foreach($list as $m)
	<tr>
		<td><input type="checkbox" name="sids[]" class="check_s" value="{{ $m->openid }}"></td>
		<td>{{ $m->id }}</td>
		<td>
			<img src="{{ $m->headimgurl }}" class="img-rounded pull-left mr10" width="50" alt="">
			<p class="text-success">{!! $m->nickname !!} {{ is_null($m->mark) ? '' : '- '.$m->mark }}</p>
			<p>{{ $m->openid }}</p>
		</td>
		<td>
			@foreach($m->tag as $mt)
			<span class="mr5">{{ $mt->name }}</span>
			@endforeach
		</td>
		<td>
			@if($m->subscribe )
			<span class='text-primary'>是</span>
			@else
			<span class='text-danger'>否</span>
			@endif
		</td>
		<td>{{ date('Y-m-d H:i:s',$m->subscribe_time) }}</td>
	</tr>
	@endforeach
</table>
<input type="hidden" name="gid" class="gid" value="0">
</form>
<div class="pull-left" data-toggle="buttons">
	<div class="btn-group">
		<label class="btn btn-xs btn-primary"><input type="checkbox" autocomplete="off" class="checkall">全选</label>
	</div>
	
	@if(App::make('com')->ifCan('wxuser-block'))
	<span class="btn btn-xs btn-warning btn_block" data-gid="1">拉黑</span>
	@endif

	@if(App::make('com')->ifCan('wxuser-block'))
	<span class="btn btn-xs btn-success btn_block" data-gid="0">移出黑名单</span>
	@endif

	@if(App::make('com')->ifCan('wxuser-tags'))
	<span class="btn btn-xs btn-info btn_tags" data-toggle="modal" data-target="#myModal_tag">打标签</span>
	@endif

</div>
<!-- 分页，appends是给分页添加参数 -->
<div class="pages pull-right clearfix">
{!! $list->appends(['gid'=>$gid,'q'=>$key])->links() !!}
</div>


<!-- 标签页面 -->
<div class="modal bs-example-modal-lg fade" id="myModal_tag" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">选择标签</h4>
      </div>
      <div class="modal-body">
        <iframe src="" id="tag_select" name="tag_select" height="400px" frameborder="0" width="100%" scrolling="auto" allowtransparency="true"></iframe>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
        <button type="button" class="btn btn-info btn_tag_select">提交</button>
      </div>
    </div>
  </div>
</div>

<script>
	$(function(){
		// 拉黑，取消拉黑
		$('.btn_block').click(function(){
			$('.gid').val($(this).attr('data-gid'));
			$('.form_submit').attr({'action':"{{ url('/console/wxuser/block') }}",'method':'post'}).submit();
		});

		// 选标签
        $('.btn_tags').click(function(){
            var url = "{{ url('console/wxuser/tags') }}";
            $('#tag_select').attr("src",url);
            return;
        });
        // 提交
        $('.btn_tag_select').click(function(){
            var iframe = $(window.frames["tag_select"].document);
            var tid = '';
            iframe.find('input:checked').each(function(){
                var n = $(this);
                tid += ',' + n.val();
            });
            // 找到分组ID
            $('.gid').val(tid);
            $('.form_submit').attr({'action':"{{ url('/console/wxuser/tags') }}",'method':'post'}).submit();
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