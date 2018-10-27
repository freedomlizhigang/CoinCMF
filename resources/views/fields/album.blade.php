<tr>
    <td class="td_left">{{ $title }}：</td>
    <td>
        <!-- 缩略图 -->
        <div id="album_img" class="wu-example">
            <!--用来存放文件信息-->
            <div id="album_list_{{ $field }}" class="uploader-list">
                @if(isset($slot) && $slot != '')
                @foreach(explode(',',$slot) as $s)
                <div class="file-item">
                    <div class="file-panel"><span class="cancel">×</span></div>
                    <img src="{{ $s }}" width="108" height="90" alt="">
                    <div class="info"></div>
                </div>
                @endforeach
                @endif
            </div>
            <div class="clearfix">
                <div id="album_btn_{{ $field }}" class="btn btn-sm btn-success">上传图片</div>
            </div>
        </div>
        <p class="input-info">图片类型jpg/jpeg/gif/png，宽{{ optional($option)->width }}*高{{ optional($option)->height }}px，单个大小不超过{{ optional($option)->sizes }}M，最多{{ optional($option)->nums }}张</p>
        <textarea class="hidden" id="album_{{ $field }}" name="data[{{ $field }}]" >{{ isset($slot) ? $slot : '' }}</textarea>
        <script>
            // 缩略图
            var $list_album_{{ $field }} = $("#album_list_{{ $field }}");
            var album_src_{{ $field }} = [
                @if(isset($slot) && $slot != '')
                @foreach(explode(',',$slot) as $s)
                    '{{ $s }}'
                    @if (!$loop->last)
                        ,
                    @endif
                @endforeach
                @endif
            ];
            var album_{{ $field }} = WebUploader.create({
                // 自动上传
                auto: true,
                // 控制数量
                fileNumLimit:"{{ optional($option)->nums }}",
                // 文件接收服务端。
                server : "{{ url('api/common/upload') }}",
                // 选择文件的按钮。可选。
                pick: '#album_btn_{{ $field }}',
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
                chunked: true,
                formData:{
                    thumb : 1,
                    thumbWidth:"{{ optional($option)->width }}",
                    thumbHeight:"{{ optional($option)->height }}"
                },
                thumb: {
                    width: 108,
                    height: 90,
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
            // 成功以后加入input中
            album_{{ $field }}.on('uploadSuccess',function(file,req){
                // console.log(req);
                album_src_{{ $field }}.push(req.url);
                console.log(album_src_{{ $field }});
                $('#album_{{ $field }}').text(album_src_{{ $field }});
            });
            $('#album_list_{{ $field }}').delegate('.file-panel', 'click', function() {
                // 找出来索引
                var thisIndex = $(this).parent('.file-item').index();
                // 删除src
                album_src_{{ $field }}.splice(thisIndex, 1);
                $('#album_{{ $field }}').text(album_src_{{ $field }});
                // 从预览里删除
                $("#album_list_{{ $field }} > .file-item").eq(thisIndex).remove();
                // console.log(album_src_{{ $field }});
            })
            // 当有文件被添加进队列的时候
            album_{{ $field }}.on( 'fileQueued', function( file ) {
                var $li = $(
                        '<div id="' + file.id + '" class="file-item">' +
                            '<img>' +
                            '<div class="info">' + file.name + '</div>' +
                        '</div>'
                        ),
                    $btns = $('<div class="file-panel"><span class="cancel">×</span></div>').appendTo( $li ),
                    $img = $li.find('img');
                // $list_album_{{ $field }}为容器jQuery实例
                $list_album_{{ $field }}.append( $li );
                // 绑定删除
                $li.delegate('.cancel', 'click', function() {
                    // 找出来索引
                    var thisIndex = file.id.substr(8);
                    // 删除src
                    album_src_{{ $field }}.splice(thisIndex, 1);
                    $('#album_{{ $field }}').text(album_src_{{ $field }});
                    // 从预览里删除
                    $("#" + file.id).remove();
                    // console.log(thisIndex);
                    album_{{ $field }}.removeFile(file);
                })
                // 创建缩略图
                // 如果为非图片文件，可以不用调用此方法。
                // thumbnailWidth x thumbnailHeight 为 100 x 100
                album_{{ $field }}.makeThumb( file, function( error, src ) {
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