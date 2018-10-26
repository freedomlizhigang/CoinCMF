<tr>
    <td class="td_left">{{ $title }}：</td>
    <td>
        <!-- 加载编辑器的容器 -->
        <script id="{{ $field }}" name="data[{{ $field }}]" class="data_content" type="text/plain">
            {!! isset($slot) ? $slot : '' !!}
        </script>
        <script>
            // 实例化编辑器
            var ue = UE.getEditor('{{ $field }}',{
                autoHeight: false,
                initialFrameWidth : '100%',
                initialFrameHeight: 400,
                serverUrl:"{{ url('api/common/ueditor_upload') }}"
            });
        </script>
    </td>
</tr>