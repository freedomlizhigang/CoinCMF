<table class="table-striped table">
    <tr>
        <td>最大值：</td>
        <td>
            <input type="number" step="0.01" name="option[max]" class="form-control input-sm" value="{{ $option->max }}">
            <p class="input-info">小数点位数</p>
        </td>
    </tr>
    <tr>
        <td>最小值：</td>
        <td>
            <input type="number" step="0.01" name="option[min]" class="form-control input-sm" value="{{ $option->min }}">
            <p class="input-info">小数点位数</p>
        </td>
    </tr>
    <tr>
        <td>步长：</td>
        <td>
            <input type="number" step="0.01" name="option[step]" class="form-control input-sm" value="{{ $option->step }}">
            <p class="input-info">小数点位数</p>
        </td>
    </tr>
</table>