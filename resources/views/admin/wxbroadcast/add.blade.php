@extends('admin.right')

@section('content')
<form action="javascript:;" method="post" id="form_ajax">
    {{ csrf_field() }}
    <table class="table table-striped">

        <tr>
            <td class="td_left">消息名称：</td>
            <td>
                <input type="text" name="data[title]" value="{{ old('data.title') }}" class="form-control">
                <p class="input-info"><span class="color_red">*</span>不超过255字符</p>
            </td>
        </tr>

        <tr>
            <td class="td_left">消息类型：</td>
            <td>
                <select name="data[type]" id="type" class="form-control input-sm">
                    <option value="text">文本</option>
                    <option value="image">图片</option>
                    <option value="voice">声音</option>
                    <option value="video">视频</option>
                    <option value="news">图文</option>
                </select>
            </td>
        </tr>

        <tr>
            <td class="td_left">用户标签：</td>
            <td>
                <select name="t_id" class="form-control input-sm">
                    <option value="0">所有粉丝</option>
                    @foreach($tlist as $l)
                    <option value="{{ $l->id }}">{{ $l->name }}</option>
                    @endforeach
                </select>
            </td>
        </tr>
        
        <tr>
            <td class="td_left">素材：</td>
            <td>
                <input type="text" name="m_title" class="m_select_title form-control input-sm" value="{{ old('m_title') }}">
                <input type="hidden" name="data[media_id]" class="m_select_id" value="{{ old('data.media_id') }}">
                <input type="hidden" name="data[m_id]" class="m_id" value="{{ old('data.m_id',0) }}">
                <p class="btn btn-xs btn-default btn_mater" data-toggle="modal" data-target="#myModal_hd">选择素材</p>
                <p class="input-info"><span class="color_red">*</span>当为文本消息时，直接在下方填写</p>
            </td>
        </tr>
        
         
        <tr>
            <td class="td_left">内容：</td>
            <td>
            <textarea name="data[content]" value="{{ old('data.content') }}" class="form-control" rows="4"></textarea>
                <p class="input-info"><span class="color_red">*</span>当为文本消息时，填写</p>
            </td>
        </tr>

        <tr>
            <td></td>
            <td>
                <div class="btn-group">
                    <button type="reset" name="reset" class="btn btn-xs btn-warning">重填</button>
                    <div onclick='ajax_submit_form("form_ajax","{{ url('/console/wxbroadcast/add') }}")' name="dosubmit" class="btn btn-xs btn-info">提交</div>
                </div>
            </td>
        </tr>
    </table>
</form>

<div class="modal bs-example-modal-lg fade" id="myModal_hd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">选择素材</h4>
      </div>
      <div class="modal-body">
        <iframe src="" id="mater_select" name="mater_select" frameborder="0" height="600px" width="100%" scrolling="auto" allowtransparency="true"></iframe>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
        <button type="button" class="btn btn-info btn_mater_select">提交</button>
      </div>
    </div>
  </div>
</div>


<script type="text/javascript">
    $(function(){
        // 选素材
        $('.btn_mater').click(function(){
            var url = "{{ url('console/wxbroadcast/select') }}" + '?type=' + $('#type').val();
            $('#mater_select').attr("src",url);
            return;
        });
        // 提交
        $('.btn_mater_select').click(function(){
            var iframe = $(window.frames["mater_select"].document);
            var that = iframe.find('input:checked');
            var m_id = that.val();
            var m_title = that.attr('data-title');
            var media_id = that.attr('data-mediaid');
            $('.m_select_id').val(media_id);
            $('.m_id').val(m_id);
            $('.m_select_title').val(m_title);
            $('#myModal_hd').modal('hide');
        });
    });
</script>

@endsection