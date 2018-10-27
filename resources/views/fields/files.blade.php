<tr>
    <td class="td_left">{{ $title }}：</td>
    <td>
        <!-- 缩略图 -->
        <div id="uploader" class="wu-example">
            <!--用来存放文件信息-->
            <div id="thelist_{{ $field }}" class="uploader-list">
                @if(isset($slot) && $slot != '')
                @foreach($slot as $s)
                <div class="file-item">
                    @foreach($s as $name => $url)
                    <p>{{ $name }}<span class="remove_btn iconfont icon-delete"></span></p>
                    <input type="hidden" name="{{ $field }}[name][]" value="{{ $name }}">
                    <input type="hidden" name="{{ $field }}[url][]" value="{{ $url }}">
                    @endforeach
                </div>
                @endforeach
                @endif
            </div>
            <div class="clearfix mt10">
                <div id="thumb_btn_{{ $field }}" class="btn btn-sm btn-success">选择文件</div>
                <div id="ctlBtn" class="btn btn-sm btn-warning">取消文件</div>
            </div>
        </div>
        <p class="input-info">素材不要过大，请遵循微信的规则</p>
        <style>
            .remove_btn { background: #F0AD4E; color: #fff; padding: 3px; cursor: pointer; }
        </style>
        <script>
            $(function(){
                // 兼容弹出框
                $("#thumb_btn_{{ $field }}").mouseenter(function(){
                    thumb_uploader_{{ $field }}.refresh();
                });
            });
            // 缩略图
            var $list_thumb_{{ $field }} = $("#thelist_{{ $field }}");
            var $btn_ctl_{{ $field }} = $('#ctlBtn');
            var thumb_uploader_{{ $field }} = WebUploader.create({
                // 自动上传
                auto: true,
                // 控制数量
                fileNumLimit:"{{ $option->nums }}",
                // 文件接收服务端。
                server : "{{ url('api/common/upload') }}",
                // 选择文件的按钮。可选。
                pick: '#thumb_btn_{{ $field }}',
                // inputime 字段名，检查上传字段用的，十分重要
                fileVal:'imgFile',
                // 开起分片上传。
                chunked: true,
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
            $("#thelist_{{ $field }}").delegate('.remove_btn', 'click', function() {
                // 找出来索引
                var thisIndex = $(this).parent('p').parent('.file-item').index();
                // 从预览里删除
                $("#thelist_{{ $field }} > .file-item").eq(thisIndex).remove();
            });
            // 成功以后加入input中
            thumb_uploader_{{ $field }}.on('uploadSuccess',function(file,req){
                console.log(req);

                var $li = $('<div id="' + file.id + '" class="file-item"><p>' + file.name + '<span class="remove_btn ml10 iconfont icon-close"></span></p><input type="hidden" name="{{ $field }}[name][]" value="' + file.name + '"><input type="hidden" name="{{ $field }}[url][]" value="' + req.url + '"></div>');
                $list_thumb_{{ $field }}.append($li);
                // 绑定删除
                $li.delegate('.remove_btn', 'click', function() {
                    // 找出来索引
                    var thisIndex = $(this).parent('p').parent('.file-item').index();
                    // 从预览里删除
                    $("#thelist_{{ $field }} > .file-item").eq(thisIndex).remove();
                })
                // 关闭上传的状态
                // alert('上传成功');
            });
            // 当有文件被添加进队列的时候
            thumb_uploader_{{ $field }}.on('fileQueued', function( file ) {
                // 弹出开始上传的按钮
                console.log('starting')
            });
            // 上传出错的提示信息
            thumb_uploader_{{ $field }}.on('error', function( error ) {
                alert('请检查是否有重复文件，或者超出最大可上传数量！');
            });
        </script>
    </td>
</tr>