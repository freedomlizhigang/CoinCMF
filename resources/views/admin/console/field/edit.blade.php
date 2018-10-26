<form action="javascript:ajax_submit();" method="post" id="form_ajax">
    {{ csrf_field() }}

    <table class="table table-striped">
        <tr>
            <td class="td_left">字段类型：</td>
            <td>
                @switch($info->type)
                    @case('linkage')
                        联动菜单
                        @break

                    @case('files')
                        文件
                        @break

                    @case('box')
                        选项
                        @break

                    @case('datetime')
                        时间
                        @break

                    @case('album')
                        多图
                        @break

                    @case('thumb')
                        单图
                        @break

                    @case('password')
                        密码
                        @break

                    @case('number')
                        数字
                        @break

                    @case('ueditor')
                        富文本
                        @break

                    @case('textarea')
                        多行文本
                        @break

                    @case('id')
                        id
                        @break

                    @default
                        单行文本
                @endswitch
            </td>
        </tr>
        <tr>
            <td class="td_left">字段名称：</td>
            <td>
                {{ $info->field_name }}
            </td>
        </tr>
        <tr>
            <td class="td_left">字段别名：</td>
            <td>
                <input type="text" name="data[title]" class="form-control input-sm" value="{{ old('data.title',$info->title) }}">
                <p class="input-info"><span class="color_red">*</span>字段备注，最多50字符</p>
            </td>
        </tr>
        <tr>
            <td class="td_left">字段提示：</td>
            <td>
                <input type="text" name="data[tips]" class="form-control" value="{{ old('data.tips',$info->tips) }}">
                <p class="input-info">最多255字符</p>
            </td>
        </tr>
        <tr>
            <td class="td_left">验证规则：</td>
            <td>
                <input type="text" name="data[validation]" class="form-control" value="{{ old('data.validation',$info->validation) }}">
                <p class="input-info">最多255字符，参考Laravel手册写法</p>
            </td>
        </tr>
        <tr>
            <td class="td_left">配置项：</td>
            <td>
                <!-- 配置项 -->
                <div id="option">
                    @include('admin.console.field.'.$info->type.'_option',['option'=>json_decode($info->option)])
                </div>
                <!-- 配置项结束 -->
            </td>
        </tr>
        <tr>
            <td class="td_left">必填：</td>
            <td>
                <label class="radio-inline"><input type="radio" name="data[required_flag]"@if($info->required_flag == '1') checked="checked"@endif class="input-radio" value="1">
                    是</label>
                <label class="radio-inline"><input type="radio" name="data[required_flag]"@if($info->required_flag == '0') checked="checked"@endif class="input-radio" value="0">否</label>
            </td>
        </tr>
        <tr>
            <td class="td_left">排序：</td>
            <td>
                <input type="number" name="data[sort]" class="form-control input-xs" value="{{ old('data.sort',$info->sort) }}">
                <p class="input-info">最多255字符</p>
            </td>
        </tr>
        <tr>
            <td class="td_left">状态：</td>
            <td>
                <label class="radio-inline"><input type="radio" name="data[status]"@if($info->status == '0') checked="checked"@endif class="input-radio" value="1">
                    是</label>
                <label class="radio-inline"><input type="radio" name="data[status]"@if($info->status == '0') checked="checked"@endif class="input-radio" value="0">否</label>
            </td>
        </tr>
    </table>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
        <div onclick='ajax_submit_form("form_ajax","{{ url('/console/field/edit',$info->id) }}")' name="dosubmit" class="btn btn-info">提交</div>
    </div>
</form>
