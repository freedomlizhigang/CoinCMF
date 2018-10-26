<tr>
    <td class="td_left">{{ $title }}：</td>
    <td>
        <!-- 判断是单选，多选、下拉、框选 -->
        @if($option->select_type == 'radio')
            @foreach(app('tag')->type($option->menu_id) as $o)
                <label class="radio-inline">
                    <input type="radio" name="data[{{ $field }}]" value="{{ $option->out_type == 'val' ? $o->id : $o->name }}"> {{ $o->name }}
                </label>
            @endforeach
        @endif
        @if($option->select_type == 'checkbox')
            @foreach(app('tag')->type($option->menu_id) as $o)
                <label class="checkbox-inline">
                    <input type="checkbox" name="data[{{ $field }}][]" value="{{ $option->out_type == 'val' ? $o->id : $o->name }}"> {{ $o->name }}
                </label>
            @endforeach
        @endif
        @if($option->select_type == 'select')
            <select name="data[{{ $field }}]" class="form-control input-sm">
                <option value="">{{ $title }}</option>
                @foreach(app('tag')->type($option->menu_id) as $o)
                    <option value="{{ $option->out_type == 'val' ? $o->id : $o->name }}">{{ $o->name }}</option>
                @endforeach
            </select>
        @endif
        @if($option->select_type == 'multiple')
            <select name="data[{{ $field }}][]" multiple="multiple" class="form-control input-sm">
                <option value="">{{ $title }}</option>
                @foreach(app('tag')->type($option->menu_id) as $o)
                    <option value="{{ $option->out_type == 'val' ? $o->id : $o->name }}">{{ $o->name }}</option>
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