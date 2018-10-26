<tr>
    <td class="td_left">{{ $title }}：</td>
    <td>
        <!-- 缩略图 -->
        <div id="uploader" class="wu-example">
            <!--用来存放文件信息-->
            <div id="thelist_{{ $field }}" class="uploader-list">
                @if(isset($slot) && $slot != '')
                <div class="file-item">
                    <img src="{{ $slot }}" width="110" height="110" alt="">
                </div>
                @endif
            </div>
            <div class="clearfix">
                <div id="thumb_btn_{{ $field }}" class="btn btn-sm btn-success">选择文件</div>
                <div id="ctlBtn_{{ $field }}" class="btn btn-sm btn-warning">取消文件</div>
            </div>
        </div>
        <p class="input-info">图片类型jpg/jpeg/gif/png，大小不超过2M</p>
        <input type="hidden" id="thumb_{{ $field }}" value="{{ isset($slot) ? $slot : '' }}" name="data[{{ $field }}]" >
        <script>
            $(function(){
                // 兼容弹出框
                $("#thumb_btn_{{ $field }}").mouseenter(function(){
                    thumb_uploader_{{ $field }}.refresh();
                });
            });
            // 缩略图
            var $list_thumb_{{ $field }} = $("#thelist_{{ $field }}");
            var $btn_ctl_{{ $field }} = $('#ctlBtn_{{ $field }}');
            var thumb_uploader_{{ $field }} = WebUploader.create({
                // 自动上传
                auto: true,
                // 控制数量
                fileNumLimit:1,
                // 文件接收服务端。
                server : "{{ url('api/common/upload') }}",
                // 选择文件的按钮。可选。
                pick: '#thumb_btn_{{ $field }}',
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
                formData:{
                    thumb : 1,
                    thumbWidth:"{{ optional($option)->width }}",
                    thumbHeight:"{{ optional($option)->height }}"
                },
                thumb: {
                    width: 110,
                    height: 110,
                    quality: 70,
                    allowMagnify: true,
                    crop: true,
                    preserveHeaders: false,
                }
            });
            // 重新上传
            $btn_ctl_{{ $field }}.on( 'click', function() {
                var allFiles = thumb_uploader_{{ $field }}.getFiles();
                if (allFiles.length != 0) {
                    thumb_uploader_{{ $field }}.removeFile(allFiles);
                }
                $list_thumb_{{ $field }}.empty();
                $('#thumb_{{ $field }}').val('');
            });
            // 成功以后加入input中
            thumb_uploader_{{ $field }}.on('uploadSuccess',function(file,req){
                // console.log(req);
                $('#thumb_{{ $field }}').val(req.url);
                alert('上传成功');
            });
            // 当有文件被添加进队列的时候
            thumb_uploader_{{ $field }}.on( 'fileQueued', function( file ) {
                var $li = $(
                        '<div id="' + file.id + '" class="file-item">' +
                            '<img>' +
                            '<div class="info">' + file.name + '</div>' +
                        '</div>'
                        ),
                    $img = $li.find('img');
                // $list_thumb_{{ $field }}为容器jQuery实例
                $list_thumb_{{ $field }}.append( $li );
                // 创建缩略图
                // 如果为非图片文件，可以不用调用此方法。
                // thumbnailWidth x thumbnailHeight 为 100 x 100
                thumb_uploader_{{ $field }}.makeThumb( file, function( error, src ) {
                    if ( error ) {
                        $img.replaceWith('<span>不能预览</span>');
                        return;
                    }
                    $img.attr( 'src', src );
                }, '', '' );
            });
        </script>
    </td>
</tr>