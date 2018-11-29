<!doctype html>
<html lang="zh-cn">

<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>{{ cache('config')['sitename'] }}-右侧框架</title>
    <meta name="author" content="李潇喃：www.www.xi-yi.ren" />
    <!-- IE最新兼容 -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- 国产浏览器高速/微信开发不要用 -->
     <meta name="renderer" content="webkit">

    <!-- 移动设备禁止缩放 -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

    <!-- No Baidu Siteapp-->
    <meta http-equiv="Cache-Control" content="no-siteapp" />

    <!-- 上传用的 css -->
    <link rel="stylesheet" href="{{ $sites['static']}}layui/css/layui.css">
    <link rel="stylesheet" href="{{ $sites['static']}}common/css/iconfont.css">
    <link rel="stylesheet" href="{{ $sites['static']}}admin/css/admin.css">
    <!-- 配置文件 -->
    <script type="text/javascript" src="{{ $sites['static']}}common/js/jquery.min.js"></script>
    <script type="text/javascript" src="{{ $sites['static']}}common/ueditor/ueditor.config.js"></script>
    <!-- 编辑器源码文件 -->
    <script type="text/javascript" src="{{ $sites['static']}}common/ueditor/ueditor.all.js"></script>
    <!-- 放最下边，大坑一个 -->
    <script>
        var host = "{{ config('app.url') }}";
    </script>
</head>

<body>
    <section class="right_con">
        <!-- 右侧标题 -->
        <header class="clearfix right-header">
            <h2 class="main_title f-l">{{ $title }}</h2>
            <div class="layui-btn-group f-r">
                @yield('rmenu')
            </div>
        </header>
        <!-- 主内容区 -->
        <div class="layui-fluid">
            <div class="layui-row layui-col-space15">
                <div class="layui-col-md12">
                    <div class="layui-card">
                        <div class="layui-card-body">
                            @yield('content')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- 错误提示 -->
    @if(session('message'))
    <script>
        ;!function(){
          layer.msg("{{ session('message') }}",{icon:2,offset:'auto'});
        }();
    </script>
    @endif
</body>

</html>