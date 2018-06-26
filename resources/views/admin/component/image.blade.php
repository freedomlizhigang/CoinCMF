<!-- 缩略图 -->
<div id="uploader_{{ $tagid }}" class="wu-example">
    <!--用来存放文件信息-->
    <div id="thelist-{{ $tagid }}" class="uploader-list-{{ $tagid }}">
    	@if($slot != '')
    	<div class="file-item-{{ $tagid }}">
			<img src="{{ $slot }}" width="110" height="110" alt="">
		</div>
    	@endif
    </div>
    <div class="clearfix">
        <div id="thumb_btn_{{ $tagid }}" class="btn btn-sm btn-success">选择文件</div>
        <div id="ctlBtn_{{ $tagid }}" class="btn btn-sm btn-warning">取消文件</div>
    </div>
</div>
<p class="input-info">图片类型jpg/jpeg/gif/png，大小不超过2M</p>
<input type="hidden" id="thumb_{{ $tagid }}" value="{{ $slot }}" name="data[{{ $filed_name }}]" >
<script>
    $(function(){
        // 兼容弹出框
        $("#thumb_btn-{{ $tagid }}").mouseenter(function(){
            thumb_uploader_{{ $tagid }}.refresh();
        });
    });
    // 缩略图
    var $list_thumb_{{ $tagid }} = $("#thelist-{{ $tagid }}");
    var $btn_ctl_{{ $tagid }} = $('#ctlBtn_{{ $tagid }}');
    var thumb_uploader_{{ $tagid }} = WebUploader.create({
        // 自动上传
        auto: true,
        // 控制数量
        fileNumLimit:1,
        // 文件接收服务端。
        server : "{{ url('api/common/upload') }}",
        // 选择文件的按钮。可选。
        pick: '#thumb_btn_{{ $tagid }}',
        // 不压缩image, 默认如果是jpeg，文件上传前会压缩一把再上传！
        // resize: false,
        compress: false,
        // inputime 字段名，检查上传字段用的，十分重要
        fileVal:'imgFile',
        // 只允许选择图片文件。
        accept: {
           title: 'Images',
           extensions: 'gif,jpg,jpeg,bmp,png',
           mimeTypes: 'image/*'
        },
        // 开起分片上传。
        // chunked: true,
        // formData:{
        //     thumb : 1,
        //     thumbWidth:375,
        //     thumbHeight:375
        // },
        thumb: {
            quality: 70,
            allowMagnify: true,
            crop: true,
            preserveHeaders: false,
            // 为空的话则保留原有图片格式。
            // 否则强制转换成指定的类型。
            // IE 8下面 base64 大小不能超过 32K 否则预览失败，而非 jpeg 编码的图片很可
            // 能会超过 32k, 所以这里设置成预览的时候都是 image/jpeg
            type: ''
        }
    });
    // 重新上传
    $btn_ctl_{{ $tagid }}.on( 'click', function() {
        var allFiles = thumb_uploader_{{ $tagid }}.getFiles();
        if (allFiles.length != 0) {
            thumb_uploader_{{ $tagid }}.removeFile(allFiles);
        }
        $list_thumb_{{ $tagid }}.empty();
        $('#thumb_{{ $tagid }}').val('');
    });
    // 成功以后加入input中
    thumb_uploader_{{ $tagid }}.on('uploadSuccess',function(file,req){
        // console.log(req);
        $('#thumb_{{ $tagid }}').val(req.url);
    });
    // 当有文件被添加进队列的时候
    thumb_uploader_{{ $tagid }}.on( 'fileQueued', function( file ) {
        var $li = $(
                '<div id="' + file.id + '" class="file-item-{{ $tagid }}">' +
                    '<img>' +
                    '<div class="info">' + file.name + '</div>' +
                '</div>'
                ),
            $img = $li.find('img');
        // $list_thumb为容器jQuery实例
        $list_thumb_{{ $tagid }}.append( $li );
        // 创建缩略图
        // 如果为非图片文件，可以不用调用此方法。
        // thumbnailWidth x thumbnailHeight 为 100 x 100
        thumb_uploader_{{ $tagid }}.makeThumb( file, function( error, src ) {
            if ( error ) {
                $img.replaceWith('<span>不能预览</span>');
                return;
            }

            $img.attr( 'src', src );
        }, '', '' );
    });
</script>