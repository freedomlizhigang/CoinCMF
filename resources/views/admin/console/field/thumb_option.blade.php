<table class="table-striped table">
    <tr>
        <td>类型：</td>
        <td>
            <input type="text" name="option[types]" class="form-control input-sm" value="{{ optional($option)->types }}">
            <p class="input-info">允许的类型，英文竖线分隔</p>
        </td>
    </tr>
    <tr>
        <td>大小：</td>
        <td>
            <input type="number" step="1" name="option[sizes]" class="form-control input-sm" value="{{ optional($option)->sizes }}">
            <p class="input-info">单个文件大小，单位M</p>
        </td>
    </tr>
    <tr>
        <td>压缩宽度：</td>
        <td>
            <input type="number" step="1" name="option[width]" class="form-control input-sm" value="{{ optional($option)->width }}">
            <p class="input-info">图片宽度，默认为 0 不修改</p>
        </td>
    </tr>
    <tr>
        <td>压缩高度：</td>
        <td>
            <input type="number" step="1" name="option[height]" class="form-control input-sm" value="{{ optional($option)->height }}">
            <p class="input-info">图片高度，默认为 0 不修改</p>
        </td>
    </tr>
</table>