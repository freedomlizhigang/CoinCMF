<!doctype html>
<html lang="zh-cn">

<head>
  <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
  <title>{{ cache('config')['sitename'] }}登录</title>
  <meta name="author" content="李潇喃：www.xi-yi.ren" />
  <!-- IE最新兼容 -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <!-- 国产浏览器高速/微信开发不要用 -->
  <meta name="renderer" content="webkit">
  <!-- 移动设备禁止缩放 -->
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <!-- No Baidu Siteapp-->
  <meta http-equiv="Cache-Control" content="no-siteapp" />
  <link rel="stylesheet" href="{{ $sites['static']}}layui/css/layui.css">
  <link rel="stylesheet" href="{{ $sites['static']}}admin/css/login.css">

<body>
  <section id="LAY_app">
    <div class="layadmin-user-login layadmin-user-display-show" id="LAY-user-login">
      <form method="POST" action="{{ url('/console/login') }}" class="layadmin-user-login-main">
        {!! csrf_field() !!}
        <div class="layadmin-user-login-box layadmin-user-login-header">
          <h2><img src="{{ $sites['static']}}admin/images/login_logo.png" width="70" alt=""></h2>
        </div>
        <div class="layadmin-user-login-box layadmin-user-login-body layui-form">
          <div class="layui-form-item pr">
            <label class="layadmin-user-login-icon layui-icon layui-icon-username" for="LAY-user-login-username"></label>
            <input type="text" name="name" id="LAY-user-login-username" lay-verify="required|username" placeholder="请输入用户名" class="layui-input">
          </div>
          <div class="layui-form-item pr">
            <label class="layadmin-user-login-icon layui-icon layui-icon-password" for="LAY-user-login-password"></label>
            <input type="password" name="password" id="LAY-user-login-password" lay-verify="required|pass" placeholder="请输入密码" class="layui-input">
          </div>

          <div class="layui-form-item">
            <button class="layui-btn layui-btn-fluid" lay-submit="" lay-filter="submit-login">登 录</button>
          </div>
        </div>
      </form>
    </div>
  </section>
  <!-- 放最下边，大坑一个 -->
  <script type="text/javascript" src="{{ $sites['static']}}layui/layui.all.js"></script>
  <script type="text/javascript">
    var host = "{{ config('app.url') }}";
    ;!function(){
      var $ = layui.jquery,layer = layui.layer,form = layui.form;
      // 刷新表单元素值
      form.render();
      form.verify({
          username: function(value, item){ //value：表单的值、item：表单的DOM对象
              if(!new RegExp("^[a-zA-Z0-9_\u4e00-\u9fa5\\s·]+$").test(value)){
                  return '用户名不能有特殊字符';
              }
              if(/(^\_)|(\__)|(\_+$)/.test(value)){
                  return '用户名首尾不能出现下划线\'_\'';
              }
              if(/^\d+\d+\d$/.test(value)){
                  return '用户名不能全为数字';
              }
          }
          ,pass: [
              /^[\S]{6,12}$/,
              '密码必须6到15位，且不能出现空格'
          ]
      });
    }();
  </script>
  <!-- 错误提示 -->
  @if(session('message'))
  <script>
    ;!function(){
      var $ = layui.jquery,layer = layui.layer,form = layui.form;
      layer.msg("{{ session('message') }}",{icon:2,offset:'auto'});
    }();
  </script>
  @endif
</body>
</html>