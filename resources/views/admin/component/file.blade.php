<!-- 缩略图 -->
<div id="uploader" class="wu-example">
    <!--用来存放文件信息-->
    <div id="thelist" class="uploader-list">
    	@if($slot != '')
    	<div class="file-item">
			{{ $slot }}
		</div>
    	@endif
    </div>
    <div class="clearfix mt10">
        <div id="thumb_btn" class="btn btn-sm btn-success">选择文件</div>
        <div id="ctlBtn" class="btn btn-sm btn-warning">取消文件</div>
    </div>
</div>
<p class="input-info">素材不要过大，请遵循微信的规则</p>
<input type="hidden" id="thumb" value="{{ $slot }}" name="data[{{ $filed_name }}]" >
<script>
    $(function(){
        // 兼容弹出框
        $("#thumb_btn").mouseenter(function(){
            thumb_uploader.refresh();
        });
    });
    // 缩略图
    var $list_thumb = $("#thelist");
    var $btn_ctl = $('#ctlBtn');
    var thumb_uploader = WebUploader.create({
        // 自动上传
        auto: true,
        // 控制数量
        fileNumLimit:1,
        // 文件接收服务端。
        server : "{{ url('api/common/upload') }}",
        // 选择文件的按钮。可选。
        pick: '#thumb_btn',
        // inputime 字段名，检查上传字段用的，十分重要
        fileVal:'imgFile',
        // 开起分片上传。
        chunked: true,
    });
    // 重新上传
    $btn_ctl.on( 'click', function() {
        var allFiles = thumb_uploader.getFiles();
        if (allFiles.length != 0) {
            thumb_uploader.removeFile(allFiles);
        }
        $list_thumb.empty();
        $('#thumb').val('');
    });
    // 成功以后加入input中
    thumb_uploader.on('uploadSuccess',function(file,req){
        // console.log(req);
        $('#thumb').val(req.url);
    });
    // 当有文件被添加进队列的时候
    thumb_uploader.on( 'fileQueued', function( file ) {
        $list_thumb.append( '<div id="' + file.id + '" class="item">' +
            '<h4 class="info">' + file.name + '</h4>' + '</div>' );
    });
</script>