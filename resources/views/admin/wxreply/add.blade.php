@extends('admin.right')

@section('content')
<form action="javascript:;" method="post" id="form_ajax">
    {{ csrf_field() }}
    
    <table class="table table-striped">
        <tr>
            <td class="td_left">消息类型：</td>
            <td>
                <select name="data[msgtype]" id="type" class="form-control input-sm">
                    <option value="keyword">关键字</option>
                    <option value="subscribe">关注</option>
                </select>
            </td>
        </tr>
        
        <tr>
            <td class="td_left">标题：</td>
            <td>
                <input type="text" name="data[title]" rows="5" value="{{ old('data.title') }}" class="form-control input-md">
                <p class="input-info"><span class="color_red">*</span>不超过255字符</p>
            </td>
        </tr>

        <tr>
            <td class="td_left">关键字：</td>
            <td>
            <textarea name="data[keyword]" rows="5" class="form-control input-sm">{{ old('data.keyword') }}</textarea>
                <p class="input-info"><span class="color_red">*</span>多个关键字用"回车"分隔，不超过255字符</p>
            </td>
        </tr>
        
        <tr>
            <td class="td_left">回复类型：</td>
            <td>
                <select name="data[replytype]" id="type" class="form-control input-sm">
                    <option value="text">文字</option>
                    <option value="image">图片</option>
                    <option value="voice">声音</option>
                    <option value="video">视频</option>
                    <option value="news">图文</option>
                    <option value="article">文章</option>
                </select>
            </td>
        </tr>

        <tr>
            <td class="td_left">素材：</td>
            <td>
                <input type="text" name="m_title" class="m_select_title form-control input-sm" value="{{ old('m_title') }}">
                <input type="hidden" name="data[media_id]" class="m_select_id" value="{{ old('data.media_id') }}">
                <input type="hidden" name="data[mid]" class="m_id" value="{{ old('data.mid',0) }}">
                <p class="btn btn-xs btn-default btn_mater" data-toggle="modal" data-target="#myModal_hd">选择素材</p>
                <p class="input-info"><span class="color_red">*</span>选择素材以后可不必再上传</p>
            </td>
        </tr>

        <tr>
            <td class="td_left">文章：</td>
            <td>
                <table class="table-bordered table">
                    <tr>
                        <td>名称</td>
                        <td>操作</td>
                    </tr>
                    <tbody class="art_lists">
                        
                    </tbody>
                </table>
                <p class="btn btn-xs btn-default btn_art mt5" data-toggle="modal" data-target="#myModal_art">选择文章</p>
                <p class="input-info mt5"><span class="color_red">*</span>当回复类型为文章时，选择对应的文章</p>
            </td>
        </tr>
       

         <tr>
            <td class="td_left">文件：</td>
            <td>
                @component('admin.component.file')
                    @slot('filed_name')
                        files
                    @endslot
                    {{ old('data.files') }}
                @endcomponent
            </td>
        </tr>
        
        <tr>
            <td class="td_left">内容：</td>
            <td>
                <textarea name="data[content]" class="form-control" rows="5">{{ old('data.content') }}</textarea>
                <p class="input-info">当回复类型为文本时必须填写</p>
            </td>
        </tr>
        
        <tr>
            <td></td>
            <td>
                <div class="btn-group">
                    <button type="reset" name="reset" class="btn btn-xs btn-warning">重填</button>
                    <div onclick='ajax_submit_form("form_ajax","{{ url('/console/reply/add') }}")' name="dosubmit" class="btn btn-xs btn-info">提交</div>
                </div>
            </td>
        </tr>
    </table>
</form>

<div class="modal bs-example-modal-lg fade" id="myModal_art" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">选择文章</h4>
      </div>
      <div class="modal-body">
        <iframe src="" id="art_select" name="art_select" height="600px" frameborder="0" width="100%" scrolling="auto" allowtransparency="true"></iframe>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
        <button type="button" class="btn btn-info btn_art_select">提交</button>
      </div>
    </div>
  </div>
</div>

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
        // 选文章
        $('.btn_art').click(function(){
            var url = "{{ url('console/art/select') }}";
            $('#art_select').attr("src",url);
            return;
        });
        // 提交
        $('.btn_art_select').click(function(){
            var iframe = $(window.frames["art_select"].document);
            var art_title = '';
            iframe.find('input:checked').each(function(){
                var n = $(this);
                var art_id = n.val();
                art_title += "<tr class='art_tr_" + art_id + "'><td>" + n.attr('data-title') + "</td><td><input name='art_id[]' type='hidden' value='" + art_id + "' /><span data-id='" + art_id + "' class='btn_del_art btn btn-xs btn-danger glyphicon glyphicon-trash'></span></td></tr>";

            });
            $('.art_lists').append(art_title);
            // 增加移除功能
            $('.art_lists').on('click','.btn_del_art',function(){
                console.log($(this).attr('data-id'));
                $('.art_tr_' + $(this).attr('data-id')).remove();
            });
            $('#myModal_art').modal('hide');
        });
        // 选素材
        $('.btn_mater').click(function(){
            var url = "{{ url('console/mater/select') }}";
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