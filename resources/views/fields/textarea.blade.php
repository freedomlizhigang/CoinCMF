<tr>
    <td class="td_left">{{ $title }}：</td>
    <td>
        <textarea name="data[{{ $field }}]" class="form-control" rows="5"></textarea>
        <p class="input-info">
            @if($required_flag)
            <span class="color_red">*</span>
            @endif
            {{ $tips }}
        </p>
    </td>
</tr>