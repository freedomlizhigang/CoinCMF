<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>衡水山木枝技术服务有限公司</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Bootstrap -->
    <link href="{{ asset('statics/home/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('statics/home/css/home.css') }}" rel="stylesheet">
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="{{ asset('statics/common/js/jquery.min.js') }}"></script>
    <!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
    <script src="{{ asset('statics/common/js/bootstrap.min.js') }}"></script>
</head>

<body>
    @yield('content')
</body>
</html>