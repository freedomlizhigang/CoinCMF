@extends('admin.right')

@section('content')
<form action="" method="post" id="form_ajax">
    {{ csrf_field() }}
    
    <table class="table table-striped">
        <tr>
            <td class="td_left">选择类型：</td>
            <td>
                <select name="data[type]" id="type" class="form-control input-sm">
                    <option value="image">图片</option>
                    <option value="voice">声音</option>
                    <option value="video">视频</option>
                    <option value="thumb">缩略图</option>
                </select>
            </td>
        </tr>
        

        <tr>
            <td class="td_left">素材名称：</td>
            <td>
                <input type="text" name="data[name]" value="{{ old('data.name') }}" class="form-control">
                <p class="input-info"><span class="color_red">*</span>不超过255字符</p>
            </td>
        </tr>
        
         <tr>
            <td class="td_left">文件：</td>
            <td>
                @component('admin.component.file')
                    @slot('filed_name')
                        file
                    @endslot
                    {{ old('data.file') }}
                @endcomponent
            </td>
        </tr>
        
        <tr>
            <td class="td_left">素材描述：</td>
            <td>
            <textarea name="data[describe]" value="{{ old('data.describe') }}" class="form-control" rows="4"></textarea>
                <p class="input-info"><span class="color_red">*</span>当为视频时，填写</p>
            </td>
        </tr>

        <tr>
            <td></td>
            <td>
                <div class="btn-group">
                    <button type="reset" name="reset" class="btn btn-xs btn-warning">重填</button>
                    <div onclick='ajax_submit_form("form_ajax","{{ url('/console/mater/add') }}")' name="dosubmit" class="btn btn-xs btn-info">提交</div>
                </div>
            </td>
        </tr>
    </table>
</form>

@endsection