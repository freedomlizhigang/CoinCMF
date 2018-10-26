<tr>
    <td class="td_left">{{ $title }}：</td>
    <td>
        <input type="text" name="data[{{ $field }}]" class="form-control input-md" id="{{ $field }}" value="{{ date('Y-m-d H:i:s') }}">
        <p class="input-info">
            @if($required_flag)
            <span class="color_red">*</span>
            @endif
            {{ $tips }}
        </p>
    </td>
</tr>
<script>
    laydate({
        elem: '#{{ $field }}',
        format: "{{ $option->format }}", // 分隔符可以任意定义，该例子表示只显示年月
        istime: true,
    });
</script>