<table class="table-striped table">
    <tr>
        <td>选项列表：</td>
        <td>
            <!-- 把选项输出出来，这里有点坑，应该有好点的办法 -->
            @php $str = '';@endphp
            @foreach($option->values as $v)
                @foreach($v as $k => $s)
                    @php $str .=$k.'|'.$s.PHP_EOL; @endphp
                @endforeach
            @endforeach
            <textarea name="option[values]" class="form-control" rows="6">{{ $str }}</textarea>
            <p class="input-info">多个项，回车分行</p>
        </td>
    </tr>
    <tr>
        <td>选项类型：</td>
        <td>
            <label class="radio-inline">
                <input type="radio" name="option[select_type]"@if($option->select_type == 'radio') checked="checked" @endif value="radio"> radio
            </label>
            <label class="radio-inline">
                <input type="radio" name="option[select_type]"@if($option->select_type == 'checkbox') checked="checked" @endif value="checkbox"> checkbox
            </label>
            <label class="radio-inline">
                <input type="radio" name="option[select_type]"@if($option->select_type == 'select') checked="checked" @endif value="select"> select
            </label>
            <label class="radio-inline">
                <input type="radio" name="option[select_type]"@if($option->select_type == 'multiple') checked="checked" @endif value="multiple"> multiple
            </label>
        </td>
    </tr>
    <tr>
        <td>存储格式：</td>
        <td>
            <label class="radio-inline">
                <input type="radio" name="option[out_type]"@if($option->out_type == 'val') checked="checked" @endif value="val"> 值
            </label>
            <label class="radio-inline">
                <input type="radio" name="option[out_type]"@if($option->out_type == 'item') checked="checked" @endif value="item"> 选项
            </label>
        </td>
    </tr>
</table>