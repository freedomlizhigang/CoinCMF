<form action="javascript:ajax_submit();" method="post" id="form_ajax">
    {{ csrf_field() }}

	<table class="table table-striped">
        <tr>
            <td class="td_left">字段类型：</td>
            <td>
                <select name="data[type]" class="form-control input-sm" id="select_type">
                    <option value="">请选择</option>
                    <option value="text">单行文本</option>
                    <option value="textarea">多行文本</option>
                    <option value="ueditor">富文本</option>
                    <option value="number">数字</option>
                    <option value="password">密码</option>
                    <option value="thumb">单图</option>
                    <option value="album">多图</option>
                    <option value="datetime">时间</option>
                    <option value="box">选项</option>
                    <option value="files">文件</option>
                    <option value="linkage">联动菜单</option>
                </select>
                <p class="input-info"><span class="color_red">*</span></p>
            </td>
        </tr>
        <tr>
            <td class="td_left">字段名称：</td>
            <td>
                <input type="text" name="data[field_name]" class="form-control input-sm" value="{{ old('data.field_name') }}">
                <p class="input-info"><span class="color_red">*</span>数据库字段名，最多50字符</p>
            </td>
        </tr>
        <tr>
            <td class="td_left">字段别名：</td>
            <td>
                <input type="text" name="data[title]" class="form-control input-sm" value="{{ old('data.title') }}">
                <p class="input-info"><span class="color_red">*</span>字段备注，最多50字符</p>
            </td>
        </tr>
        <tr>
            <td class="td_left">字段提示：</td>
            <td>
                <input type="text" name="data[tips]" class="form-control" value="{{ old('data.tips') }}">
                <p class="input-info">最多255字符</p>
            </td>
        </tr>
        <tr>
            <td class="td_left">验证规则：</td>
            <td>
                <input type="text" name="data[validation]" class="form-control" value="{{ old('data.validation') }}">
                <p class="input-info">最多255字符，参考Laravel手册写法</p>
            </td>
        </tr>
        <tr>
            <td class="td_left">配置项：</td>
            <td>
                <!-- 配置项,ajax请求来 -->
                <div id="option">

                </div>
                <!-- 配置项结束 -->
            </td>
        </tr>
        <tr>
            <td class="td_left">排序：</td>
            <td>
                <input type="number" name="data[sort]" class="form-control input-xs" value="{{ old('data.sort',0) }}">
                <p class="input-info">最多255字符</p>
            </td>
        </tr>
        <tr>
            <td class="td_left">状态：</td>
            <td>
                <label class="radio-inline"><input type="radio" name="data[status]" checked="checked" class="input-radio" value="1">
					是</label>
				<label class="radio-inline"><input type="radio" name="data[status]" class="input-radio" value="0">否</label>
            </td>
        </tr>
    </table>
	<div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
        <div onclick='ajax_submit_form("form_ajax","{{ url('/console/field/add',$id) }}")' name="dosubmit" class="btn btn-info">提交</div>
    </div>
</form>

<script>
    $(function(){
        $('#select_type').change(function() {
            var val = $(this).val();
            $.post('/api/common/option/' + val,  function(data) {
                $('#option').html(data);
            }).error(function() {
                alert("请求失败");
            });
        });
    })
</script>