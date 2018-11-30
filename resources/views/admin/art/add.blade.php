@extends('admin.right')

@section('content')
<form method="post" id="form_ajax">
    <div class="layui-form layui-form-pane">
        {{ csrf_field() }}
        <div class="layui-form-item">
            <label class="layui-form-label">选择栏目：</label>
            <div class="layui-input-inline">
                <select name="cate_id" id="catid" lay-verify="required">
                    <option value="0">选择栏目</option>
                </select>
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">文章标题：</label>
            <div class="layui-input-block">
                <input type="text" name="title" value="{{ old('title') }}" required  lay-verify="required" placeholder="请输入标题" autocomplete="off" class="layui-input">
                <div class="layui-form-mid layui-word-aux">必填</div>
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">关键字：</label>
            <div class="layui-input-block">
                <input type="text" name="keywords" value="{{ old('keywords') }}" placeholder="请输入关键字" autocomplete="off" class="layui-input">
                <div class="layui-form-mid layui-word-aux">不超过255字符</div>
            </div>
        </div>

        <div class="layui-form-item layui-form-text">
            <label class="layui-form-label">描述：</label>
            <div class="layui-input-block">
                <textarea name="describe" placeholder="请输入内容" class="layui-textarea">{{ old('describe') }}</textarea>
                <div class="layui-form-mid layui-word-aux">不超过255字符</div>
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">缩略图：</label>
            <div class="layui-input-block">
                @component('admin.component.thumb')
                    {{ old('thumb') }}
                @endcomponent
            </div>
        </div>

        <div class="layui-form-item layui-form-text">
            <label class="layui-form-label">内容：</label>
            <div class="layui-input-block">
                @component('admin.component.ueditor')
                    @slot('id')
                        container
                    @endslot
                    @slot('filed_name')
                        content
                    @endslot
                    {{ old('content') }}
                @endcomponent
                <div class="layui-form-mid layui-word-aux">必填</div>
            </div>
        </div>

        <div class="layui-form-item" pane="">
            <label class="layui-form-label">推荐：</label>
            <div class="layui-input-block">
                <input type="checkbox" name="push_flag" lay-text="ON|OFF" lay-skin="switch">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">来源：</label>
            <div class="layui-input-block">
                <input type="text" name="source" value="{{ old('source') }}" autocomplete="off" class="layui-input">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">点击量：</label>
            <div class="layui-input-inline">
                <input type="text" name="hits" value="{{ old('hits',99) }}" autocomplete="off" class="layui-input">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">发布时间：</label>
            <div class="layui-input-inline">
                <input type="text" name="publish_at" value="{{ old('publish_at') }}" id="laydate" autocomplete="off" class="layui-input">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">排序：</label>
            <div class="layui-input-inline">
                <input type="text" name="sort" value="{{ old('sort',0) }}" autocomplete="off" class="layui-input">
                <div class="layui-form-mid layui-word-aux">数字越大越靠前</div>
            </div>
        </div>

        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit lay-filter="submitBtn">立即提交</button>
                <button type="reset" class="layui-btn layui-btn-primary">重置</button>
            </div>
        </div>

    </div>
</form>


<script>
    layui.use(['layer','form','laydate'],function(){
        var layer = layui.layer,form = layui.form;
        var laydate = layui.laydate;
        // 下拉框
        $.get(apihost + 'cate/select', function(res) {
            if (res.code == 200) {
                $('#catid').append(res.data);
                // 重新渲染select，真是各种坑
                form.render('select');
            }
            else
            {
                layer.msg(res.msg,{icon:2,offset:'auto'})
            }
        }).error(function(e) {
            layer.msg('获取栏目数据失败，请稍后再试！',{icon:2,offset:'auto'})
        });
        // 时间
        laydate.render({
            elem: '#laydate', //指定元素
            type: 'datetime',
            min: -7,
        });
        // 表单提交
        form.on('submit(submitBtn)', function(data){
            data.field.content = ue.getContent();
            console.log(data.field)
            // 开始真正的提交功能

            return false; //阻止表单跳转。如果需要表单跳转，去掉这段即可。
        });
    });
</script>
@endsection