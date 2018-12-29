<form action="javascript:ajax_submit();" method="post" id="form_ajax">
{{ csrf_field() }}
<div class="art_box">
    <h4 class="text-center">{{ $info->title }}</h4>
    <div class="alert alert-info mt20">{{ $info->publish_at }} - {{ optional($info->cate)->name }} - {{ optional($info->admin)->realname }}</div>
    <div class="art_con">
       {!! $info->content !!}
    </div>
    <div class="alert alert-warning">
        <h5>审核过程</h5>
        <ul class="mt10">
            @foreach($workflowlog as $k => $w)
            <li>{{ $k }} - {{ optional($w->admin)->realname }}：{{ $w->mark }}，{{ $w->created_at }}</li>
            @endforeach
        </ul>
    </div>
</div>
@if(App::make('com')->ifCan('art-status') && $info->status != 99 && $info->status != 0)
<div class="modal-footer">
    <div onclick='ajax_submit_form("form_ajax","{{ url('/console/art/status',['id'=>$info->id,'result'=>0]) }}")' name="dosubmit" class="btn btn-default pull-left">退稿</div>
    <div onclick='ajax_submit_form("form_ajax","{{ url('/console/art/status',['id'=>$info->id,'result'=>1]) }}")' name="dosubmit" class="btn btn-success">通过</div>
</div>
@endif
</form>