<tr>
    <td class="td_left">{{ $title }}：</td>
    <td>
        <input type="number" step="{{ $option->step }}" min="{{ $option->min }}" max="{{ $option->max }}" name="data[{{ $field }}]" class="form-control input-sm" value="">
        <p class="input-info">
            @if($required_flag)
            <span class="color_red">*</span>
            @endif
            {{ $tips }}
        </p>
    </td>
</tr>