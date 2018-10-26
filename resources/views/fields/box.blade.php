<tr>
    <td class="td_left">{{ $title }}：</td>
    <td>
        <!-- 判断是单选，多选、下拉、框选 -->
        @if($option->select_type == 'radio')
            @foreach($option->values as $o)
                @foreach($o as $k => $v)
                <label class="radio-inline">
                    <input type="radio" name="data[{{ $field }}]" value="{{ $option->out_type == 'val' ? $k : $v }}"> {{ $v }}
                </label>
                @endforeach
            @endforeach
        @endif
        @if($option->select_type == 'checkbox')
            @foreach($option->values as $o)
                @foreach($o as $k => $v)
                <label class="checkbox-inline">
                    <input type="checkbox" name="data[{{ $field }}][]" value="{{ $option->out_type == 'val' ? $k : $v }}"> {{ $v }}
                </label>
                @endforeach
            @endforeach
        @endif
        @if($option->select_type == 'select')
            <select name="data[{{ $field }}]" class="form-control input-sm">
                <option value="">{{ $title }}</option>
                @foreach($option->values as $o)
                    @foreach($o as $k => $v)
                    <option value="{{ $option->out_type == 'val' ? $k : $v }}">{{ $v }}</option>
                    @endforeach
                @endforeach
            </select>
        @endif
        @if($option->select_type == 'multiple')
            <select name="data[{{ $field }}][]" multiple="multiple" class="form-control input-sm">
                <option value="">{{ $title }}</option>
                @foreach($option->values as $o)
                    @foreach($o as $k => $v)
                    <option value="{{ $option->out_type == 'val' ? $k : $v }}">{{ $v }}</option>
                    @endforeach
                @endforeach
            </select>
        @endif
        <p class="input-info">
            @if($required_flag)
            <span class="color_red">*</span>
            @endif
            {{ $tips }}
        </p>
    </td>
</tr>