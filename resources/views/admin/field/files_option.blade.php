<table class="table-striped table">
    <tr>
        <td>数量：</td>
        <td>
            <input type="number" step="1" name="option[nums]" class="form-control input-sm" value="{{ $option->nums }}">
            <p class="input-info">最大可上传数量</p>
        </td>
    </tr>
    <tr>
        <td>类型：</td>
        <td>
            <input type="text" name="option[types]" class="form-control input-sm" value="{{ $option->types }}">
            <p class="input-info">允许的类型，英文竖线分隔</p>
        </td>
    </tr>
    <tr>
        <td>大小：</td>
        <td>
            <input type="number" step="1" name="option[sizes]" class="form-control input-sm" value="{{ $option->sizes }}">
            <p class="input-info">单个文件大小，单位M</p>
        </td>
    </tr>
</table>