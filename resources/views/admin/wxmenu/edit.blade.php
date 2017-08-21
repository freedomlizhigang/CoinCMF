<form action="javascript:;" method="post" id="form_ajax">
	{{ csrf_field() }}

    <table class="table table-striped">
        <tr>
            <td class="td_left">名称：</td>
            <td>
                <input type="text" name="data[name]" class="form-control input-sm" value="{{ $info->name }}">
                <p class="input-info"><span class="color_red">*</span>最多50字符</p>
            </td>
        </tr>

        <tr>
            <td class="td_left">类型：</td>
            <td>
                <select name="data[type]" id="wxmenu_type" class="form-control input-sm">
                    <option value="click" @if($info->type == 'click') selected="selected" @endif>点击事件</option>
                    <option value="view" @if($info->type == 'view') selected="selected" @endif>跳转URL</option>
                    <option value="scancode_push" @if($info->type == 'scancode_push') selected="selected" @endif>扫码推事件</option>
                    <option value="scancode_waitmsg" @if($info->type == 'scancode_waitmsg') selected="selected" @endif>扫码推事件wait</option>
                    <option value="pic_sysphoto" @if($info->type == 'pic_sysphoto') selected="selected" @endif>系统拍照发图</option>
                    <option value="pic_photo_or_album" @if($info->type == 'pic_photo_or_album') selected="selected" @endif>拍照或者相册发图</option>
                    <option value="pic_weixin" @if($info->type == 'pic_weixin') selected="selected" @endif>微信相册发图器</option>
                    <option value="location_select" @if($info->type == 'location_select') selected="selected" @endif>地理位置选择器</option>
                    <option value="media_id" @if($info->type == 'media_id') selected="selected" @endif>下发消息</option>
                    <option value="view_limited" @if($info->type == 'view_limited') selected="selected" @endif>跳转图文消息URL</option>
                    <option value="miniprogram" @if($info->type == 'miniprogram') selected="selected" @endif>小程序</option>
                </select>
            </td>
        </tr>

        
        <tr>
            <td class="td_left">关键词：</td>
            <td>
                <textarea name="type[key]" class="form-control input-lg" rows="4" placeholder="下发消息、图文消息时填写微信素材的media_id，关键字时填写文字，最多50字符，小程序时填写小程序路径">{{ $type['key'] }}</textarea>
            </td>
        </tr>
        <tr>
            <td class="td_left">跳转URL：</td>
            <td>
                <input type="text" name="type[url]" class="form-control input-lg" value="{{ $type['url'] }}" placeholder="跳转URL或小程序时填写，网址链接">
            </td>
        </tr>

        <tr>
            <td class="td_left">排序：</td>
            <td>
                <input type="text" name="data[sort]" value="{{ $info->sort }}" class="form-control input-xs">
                <p class="input-info"><span class="color_red">*</span>数字越小越靠前</p>
            </td>
        </tr>

    </table>


	<div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
        <div onclick='ajax_submit_form("form_ajax","{{ url('/console/wxmenu/edit',['id'=>$info->id]) }}")' name="dosubmit" class="btn btn-info">提交</div>
    </div>
</form>