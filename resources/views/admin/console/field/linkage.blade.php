<table class="table-striped table">
    <tr>
        <td>分类ID：</td>
        <td>
            <input type="number" step="1" name="option[menu_id]" class="form-control input-sm" value="0">
            <p class="input-info">分类的ID</p>
        </td>
    </tr>
    <tr>
        <td>选项类型：</td>
        <td>
            <label class="radio-inline">
                <input type="radio" name="option[select_type]" checked="checked" value="radio"> radio
            </label>
            <label class="radio-inline">
                <input type="radio" name="option[select_type]" value="checkbox"> checkbox
            </label>
            <label class="radio-inline">
                <input type="radio" name="option[select_type]" value="select"> select
            </label>
            <label class="radio-inline">
                <input type="radio" name="option[select_type]" value="multiple"> multiple
            </label>
        </td>
    </tr>
    <tr>
        <td>存储格式：</td>
        <td>
            <label class="radio-inline">
                <input type="radio" name="option[out_type]" checked="checked" value="val"> 值
            </label>
            <label class="radio-inline">
                <input type="radio" name="option[out_type]" value="item"> 选项
            </label>
        </td>
    </tr>
</table>