<form action="javascript:;" method="post" id="form_ajax">
    {{ csrf_field() }}

    <table class="table table-striped">
        <tr>
            <td class="td_left">地区名称：</td>
            <td>
                <input type="text" name="data[areaname]" class="form-control input-sm" value="{{ $info->areaname }}">
                <p class="input-info"><span class="color_red">*</span></p>
            </td>
        </tr>

        <tr>
            <td class="td_left">经度：</td>
            <td>
                <input type="text" name="data[lon]" value="{{ old('data.lon',$info->lon) }}" class="form-control input-sm">
                <p class="input-info"><span class="color_red">*</span>经度，<a href="https://lbs.amap.com/console/show/picker" target="_blank">拾取经纬度，大的是经度</a></p>
            </td>
        </tr>

        <tr>
            <td class="td_left">纬度：</td>
            <td>
                <input type="text" name="data[lat]" value="{{ old('data.lat',$info->lat) }}" class="form-control input-sm">
                <p class="input-info"><span class="color_red">*</span>纬度，<a href="https://lbs.amap.com/console/show/picker" target="_blank">拾取经纬度，小的是纬度</a></p>
            </td>
        </tr>

        <tr>
            <td class="td_left">排序：</td>
            <td>
                <input type="text" name="data[sort]" value="{{ $info->sort }}" class="form-control input-xs">
                <p class="input-info"><span class="color_red">*</span>数字越大越靠前</p>
            </td>
        </tr>

        <tr>
            <td class="td_left">是否显示：</td>
            <td>
               <label class="radio-inline"><input type="radio" name="data[is_show]"@if($info->is_show == 1) checked="checked"@endif class="input-radio" value="1">
                   是</label>
               <label class="radio-inline"><input type="radio" name="data[is_show]"@if($info->is_show != 1) checked="checked"@endif class="input-radio" value="0">否</label>
            </td>
        </tr>
    </table>

    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
        <div onclick='ajax_submit_form("form_ajax","{{ url('/console/area/edit',['id'=>$info->id]) }}")' name="dosubmit" class="btn btn-info">提交</div>
    </div>
</form>