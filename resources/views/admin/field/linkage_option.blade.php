<table class="table-striped table">
    <tr>
        <td>分类ID：</td>
        <td>
            <input type="number" step="1" name="option[menu_id]" class="form-control input-sm" value="{{ $option->menu_id }}">
            <p class="input-info">分类的ID</p>
        </td>
    </tr>
    <tr>
        <td>选项类型：</td>
        <td>
            <label class="radio-inline">
                <input type="radio" name="option[select_type]"@if($option->select_type == 'radio') checked="checked" @endif checked="checked" value="radio"> radio
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