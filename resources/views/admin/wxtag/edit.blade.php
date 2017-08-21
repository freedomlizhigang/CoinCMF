<form action="javascript:ajax_submit();" method="post" id="form_ajax">
    {{ csrf_field() }}

    <table class="table table-striped">
        <tr>
            <td class="td_left">标签名称：</td>
            <td>
                <input type="text" name="data[name]" class="form-control input-sm" value="{{ $info->name }}">
                <p class="input-info"><span class="color_red">*</span>最多50字符</p>
            </td>
        </tr>
        
    </table>


	<div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
        <div onclick='ajax_submit_form("form_ajax","{{ url('/console/wxtag/edit',['id'=>$info->id]) }}")' name="dosubmit" class="btn btn-info">提交</div>
    </div>
</form>