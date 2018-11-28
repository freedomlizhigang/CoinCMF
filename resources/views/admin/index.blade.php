<!doctype html>
<html lang="zh-cn">

<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>{{ cache('config')['sitename'] }}管理中心</title>
    <meta name="author" content="李潇喃：www.shanmuzhi.com" />
    <!-- IE最新兼容 -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- 国产浏览器高速/微信开发不要用 -->
    <meta name="renderer" content="webkit">
    <!-- 移动设备禁止缩放 -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <!-- No Baidu Siteapp-->
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <link rel="stylesheet" href="{{ $sites['static']}}layui/css/layui.css">
    <link rel="stylesheet" href="{{ $sites['static']}}common/css/iconfont.css">
    <link rel="stylesheet" href="{{ $sites['static']}}admin/css/admin.css">
</head>

<body class="layui-layout-body">
    <section id="LAY_app" class="layadmin-tabspage-none">
        <div class="layui-layout layui-layout-admin">
            <header class="layui-header">
                <!-- 头部区域 -->
                <ul class="layui-nav layui-layout-left">
                    <li class="layui-nav-item layadmin-flexible">
                        <a href="javascript:;" layadmin-event="flexible" title="侧边伸缩">
                            <i class="layui-icon layui-icon-shrink-right" id="LAY_app_flexible"></i>
                        </a>
                    </li>
                </ul>
                <ul class="layui-nav layui-layout-right" lay-filter="layadmin-layout-right">
                    <li class="layui-nav-item mr10">
                        <a href="/" target="_blank">网站首页</a>
                    </li>
                    <li class="layui-nav-item mr10">
                        <a href="javascript:;"><cite>{{ session('console')->name }}</cite> <span class="layui-nav-more"></span></a>
                        <dl class="layui-nav-child">
                            <dd><a href="{{ url('/console/logout') }}">退出</a></dd>
                        </dl>
                    </li>
                </ul>
            </header>
            <!-- 侧边菜单 -->
            <aside class="layui-side layui-side-menu">
                <div class="layui-side-scroll">
                    <!-- logo -->
                    <div class="layui-logo" lay-href="{{ url('/console/index/main') }}">
                        <span></span>
                    </div>
                    <!-- 侧栏 -->
                    <ul class="layui-nav layui-nav-tree leftmenu" lay-filter="layadmin-system-side-menu">
                        @foreach($leftmenu as $l)
                        <li data-name="home" class="layui-nav-item @if($loop->first) layui-nav-itemed @endif">
                            <a href="javascript:;">
                                <i class="layui-icon iconfont {{ $l['icon'] }}"></i>
                                <cite>{{ $l['name'] }}</cite>
                                <span class="layui-nav-more"></span>
                            </a>
                            <dl class="layui-nav-child">
                                @foreach($l['submenu'] as $ls)
                                <dd>
                                    <a lay-href="{{ '/console/'.$ls['url'] }}">{{ $ls['name'] }}
                                    </a>
                                </dd>
                                @endforeach
                            </dl>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </aside>
            <!-- 主体内容 -->
            <section class="layui-body" id="LAY_app_body">
                <div class="layadmin-tabsbody-item layui-show">
                    <iframe src="{{ url('/console/index/main') }}" frameborder="0" class="layadmin-iframe"></iframe>
                </div>
            </section>
            <!-- 隐藏的内容 -->
            <div class="layadmin-body-shade" layadmin-event="shade"></div>
        </div>
    </section>
    <!-- 放最下边，大坑一个 -->
    <script>
        var host = "{{ config('app.url') }}";
    </script>
    <script type="text/javascript" src="{{ $sites['static']}}common/js/jquery.min.js"></script>
    <script type="text/javascript" src="{{ $sites['static']}}layui/layui.all.js"></script>
    <script type="text/javascript" src="{{ $sites['static']}}admin/js/public.js"></script>
</body>

</html>