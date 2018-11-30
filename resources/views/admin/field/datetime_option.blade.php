<table class="table-striped table">
    <tr>
        <td>日期格式：</td>
        <td>
            <input type="text" step="1" name="option[format]" class="form-control input-sm" value="{{ $option->format }}">
            <p class="input-info">Laydate支持的格式，<a href="https://www.layui.com/laydate/" target="_blank">查看</a></p>
        </td>
    </tr>
    <tr>
        <td>人类时间：</td>
        <td>
            <label class="radio-inline">
                <input type="radio" name="option[human_flag]"@if($option->human_flag == '1') checked="checked" @endif value="1"> 是
            </label>
            <label class="radio-inline">
                <input type="radio" name="option[human_flag]"@if($option->human_flag == '0') checked="checked" @endif value="0"> 否
            </label>
        </td>
    </tr>
</table>