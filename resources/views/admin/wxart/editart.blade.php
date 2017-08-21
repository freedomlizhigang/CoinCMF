@extends('admin.right')

@section('content')
<form action="javascript:ajax_submit();" method="post" id="form_ajax">
    {{ csrf_field() }}
    
    <input type="hidden" name="ref" value="{!! $ref !!}">

    <input type="hidden" name="data[mid]" value="{{ $info->mid }}">
    
    <table class="table table-striped">
        
        <tr>
            <td class="td_left">文章标题：</td>
            <td>
                <input type="text" name="data[title]" value="{{ $info->title }}" class="form-control">
                <p class="input-info"><span class="color_red">*</span>不超过255字符</p>
            </td>
        </tr>

        <tr>
            <td class="td_left">文章作者：</td>
            <td>
                <input type="text" name="data[author]" value="{{ $info->author }}" class="form-control">
            </td>
        </tr>
        
        <tr>
            <td class="td_left">描述：</td>
            <td>
                <textarea name="data[digest]" class="form-control input-lg" rows="5">{{ $info->digest }}</textarea>
            </td>
        </tr>

        <tr>
            <td class="td_left">显示封面：</td>
            <td>
                <label class="radio-inline"><input type="radio" name="data[show_cover_pic]" @if($info->show_cover_pic == '1') checked="checked"@endif class="input-radio" value="1">
                    是</label>
                <label class="radio-inline"><input type="radio" name="data[show_cover_pic]" @if($info->show_cover_pic == '0') checked="checked"@endif class="input-radio" value="0">否</label>
            </td>
        </tr>

        <tr>
            <td class="td_left">封面：</td>
            <td>
                @component('admin.component.thumb')
                    @slot('filed_name')
                        thumb
                    @endslot
                    {{ $info->thumb }}
                @endcomponent
                <input type="hidden" name="data[media_id]" value="{{ $info->media_id }}" class="form-control input-sm">
            </td>
        </tr>

        <tr>
            <td class="td_left">内容：</td>
            <td>
                @component('admin.component.ueditor')
                    @slot('id')
                        container
                    @endslot
                    @slot('filed_name')
                        content
                    @endslot
                    {!! $info->content !!}
                @endcomponent
                <p class="input-info"><span class="color_red">*</span></p>
            </td>
        </tr>

        <tr>
            <td class="td_left">来源：</td>
            <td>
                <input type="text" name="data[content_source_url]" value="{{ $info->content_source_url }}" class="form-control input-sm">
            </td>
        </tr>

        <tr>
            <td></td>
            <td>
                <div class="btn-group">
                    <button type="reset" name="reset" class="btn btn-xs btn-warning">重填</button>
                    <div onclick='ajax_submit_form("form_ajax","{{ url('/console/wxart/editart',['id'=>$info->id]) }}")' name="dosubmit" class="btn btn-xs btn-info">提交</div>
                </div>
            </td>
        </tr>
    </table>
</form>

<!-- 实例化编辑器 -->
<script type="text/javascript">

</script>
@endsection