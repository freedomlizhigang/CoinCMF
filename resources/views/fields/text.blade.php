<tr>
    <td class="td_left">{{ $title }}：</td>
    <td>
        <input type="text" name="data[{{ $field }}]" class="form-control input-md" value="">
        <p class="input-info">
            @if($required_flag)
            <span class="color_red">*</span>
            @endif
            {{ $tips }}
        </p>
    </td>
</tr>