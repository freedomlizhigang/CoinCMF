@extends('admin.right')

@section('rmenu')
    @if(App::make('com')->ifCan('art-add'))
    <a href="{{ url('/console/art/add') }}" class="layui-btn layui-btn-xs layui-btn-primary"><i class="layui-icon">&#xe654;</i>添加文章</a>
    @endif
@endsection

@section('content')
<!-- 选出栏目 -->
<div class="clearfix">
    <form action="" class="layui-form layui-row layui-col-space10" method="get">
        <div class="layui-inline">
            <select name="catid" id="catid">
                <option value="">请选择栏目</option>
                {!! $cate !!}
            </select>
        </div>
        <div class="layui-inline">
            <select name="push_flag" id="push_flag">
                <option value="">是否推荐</option>
                <option value="1">推荐</option>
                <option value="0">普通</option>
            </select>
        </div>
        <div class="layui-inline">
            <div class="layui-input-inline">
                <input type="text" name="starttime" value="" id="laydate" class="layui-input starttime" autocomplete="off" placeholder="开始时间">
            </div>
        </div>
        <div class="layui-inline">
            <div class="layui-input-inline">
                <input type="text" name="endtime" value="" value="" id="laydate2" class="layui-input endtime" autocomplete="off" placeholder="结束时间">
            </div>
        </div>
        <div class="layui-inline">
            <input type="text" name="q" value="" placeholder="请输入文章标题关键字.." autocomplete="off" class="layui-input key">
        </div>
        <div class="layui-btn layui-btn-normal btn-search">查找</div>
    </form>
</div>

<!-- 工具栏排序等操作 -->
<script type="text/html" id="toolbar">
    <div class="layui-btn-container">
        <button class="layui-btn layui-btn-sm layui-btn-danger" lay-event="deleteAll">批量删除</button>
    </div>
</script>
<table class="layui-table" id="tablelist" lay-filter="tablelist"></table>
<!-- 操作 -->
<script type="text/html" id="barDemo">
    <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
</script>


@include('admin.component.layui')
<script>
    ;!function(){
        // 文章列表页面用的
        laydate.render({
            elem: '#laydate' //指定元素
        });
        laydate.render({
            elem: '#laydate2' //指定元素
        });
        // 请求参数
        var push_flag = $("#push_flag").val();
        var catid = $("#catid").val();
        var starttime = $(".starttime").val();
        var endtime = $(".endtime").val();
        var key = $(".key").val();
        // 获取数据
        var listTable = table.render({
            elem: '#tablelist',
            url:'/console/api/article/list',    // 测试数据，项目中改为真是数据接口
            title: '用户数据表',
            toolbar: '#toolbar',
            //设定异步数据接口的额外参数，任意设
            where: {
                catid: catid,
                push_flag: push_flag,
                starttime: starttime,
                endtime: endtime,
                key: key
            },
            cols: [[
                {type: 'checkbox', fixed: 'left', unresize: true}
                ,{field:'id', title:'ID', width:80, fixed: 'left', unresize: true}
                ,{field:'sort', title:'排序', width:80, edit:'text', unresize: true}
                ,{field:'title', title:'标题', unresize: true}
                ,{field:'catename', title:'栏目', width:150, unresize: true}
                ,{field:'hits', title:'点击量', width:80, unresize: true, sort: true}
                ,{field:'publish_at', title:'发布时间', width:180, unresize: true}
                ,{fixed: 'right', title:'操作', toolbar: '#barDemo', width:120, unresize: true}
            ]],
            page: true,
            response: {
                statusName: 'code' //规定数据状态的字段名称，默认：code
                ,statusCode: 200 //规定成功的状态码，默认：0
            }
        });
        //头工具栏事件
        table.on('toolbar(tablelist)', function(obj){
            var checkStatus = table.checkStatus(obj.config.id); //获取选中行状态
            switch(obj.event){
                case 'deleteAll':
                    var data = checkStatus.data;  //获取选中行数据
                    var ids = [];
                    $.each(data,function(index, el) {
                        ids.push(el.id);
                    });
                    layer.confirm('确定删除选中数据吗？', function(index){
                        // 请求删除操作
                        $.post('/console/api/article/deleteall', {ids: ids}, function(data) {
                            if (data.code == 200) {
                                layer.msg(data.msg,{icon:1,offset:'auto'})
                                // 表格重构
                                listTable.reload({
                                    //设定异步数据接口的额外参数，任意设
                                    where: {
                                        catid: catid,
                                        push_flag: push_flag,
                                        starttime: starttime,
                                        endtime: endtime,
                                        key: key
                                    },
                                    page: {
                                        curr: 1 //重新从第 1 页开始
                                    }
                                });
                            }
                            else
                            {
                                layer.msg(data.msg,{icon:2,offset:'auto'})
                            }
                            layer.close(index);
                        }).error(function(e) {
                            layer.msg('删除失败，请稍后再试！',{icon:2,offset:'auto'})
                            layer.close(index);
                        });
                    });
                    break;
            };
        });
        //监听单元格编辑，排序
        table.on('edit(tablelist)', function(obj){
            var value = obj.value //得到修改后的值
            ,data = obj.data //得到所在行所有键值
            ,field = obj.field; //得到字段
            // 排序
            $.post('/console/api/article/sort', {id: data.id,sort:value}, function(data) {
                if (data.code == 200) {
                    layer.msg(data.msg,{icon:1,offset:'auto'})
                }
                else
                {
                    layer.msg(data.msg,{icon:2,offset:'auto'})
                }
            }).error(function(e) {
                layer.msg('删除失败，请稍后再试！',{icon:2,offset:'auto'})
            });
        });
        //监听行操作事件
        table.on('tool(tablelist)', function(obj){
            var data = obj.data;
            // console.log(data)
            // 编辑，跳转页面
            if(obj.event === 'edit'){
                window.location.href = "{{ url('console/art/edit') }}" + '/' + data.id;
            }
            // 删除
            if(obj.event === 'del'){
                layer.confirm('确定删除吗？', function(index){
                    // 请求删除操作
                    $.post('/console/api/article/delete', {id: data.id}, function(data) {
                        if (data.code == 200) {
                            layer.msg(data.msg,{icon:1,offset:'auto'})
                            obj.del();
                        }
                        else
                        {
                            layer.msg(data.msg,{icon:2,offset:'auto'})
                        }
                        layer.close(index);
                    }).error(function(e) {
                        layer.msg('删除失败，请稍后再试！',{icon:2,offset:'auto'})
                        layer.close(index);
                    });
                });
            }
        });

        // 搜索
        $(".btn-search").click(function(){
            // 获取数据
            push_flag = $("#push_flag").val();
            // 表格重构
            listTable.reload({
                //设定异步数据接口的额外参数，任意设
                where: {
                    catid: catid,
                    push_flag: push_flag,
                    starttime: starttime,
                    endtime: endtime,
                    key: key
                },
                page: {
                    curr: 1 //重新从第 1 页开始
                }
            });
        })
    }();
</script>

@endsection
