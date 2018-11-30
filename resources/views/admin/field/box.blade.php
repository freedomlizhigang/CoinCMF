<table class="table-striped table">
    <tr>
        <td>选项列表：</td>
        <td>
            <textarea name="option[values]" class="form-control" rows="6">选项名称1|选项值1</textarea>
            <p class="input-info">多个项，回车分行</p>
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