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
  <link rel="stylesheet" href="{{ $sites['static']}}admin/css/reset.css"></head>

<body class="login-body">
  <div class="login_box">
    <img src="{{ $sites['static']}}admin/images/login_h.png" class="center-block" alt="希夷shop管理中心">
    <form method="POST" action="{{ url('/console/login') }}" class="login-form">
      {!! csrf_field() !!}
      <div class="form-group has-feedback">
        <div class="input-group">
          <span class="input-group-addon"><img src="{{ $sites['static']}}admin/images/login-icon-user.png" alt=""></span>
          <input type="text" name="name" value="{{ old('name') }}" class="form-control login_form_right" placeholder="请输入用户名">
        </div>
      </div>

      <div class="form-group has-feedback">
        <div class="input-group">
          <span class="input-group-addon"><img src="{{ $sites['static']}}admin/images/login-icon-pwd.png" alt=""></span>
          <input type="password" name="password" value="{{ old('name') }}" class="form-control login_form_right" placeholder="请输入密码">
        </div>
      </div>
      @if(session('message'))
      <span class="help-block text-center">{{ session('message') }}</span>
      @endif
      <div class="form-group mt10">
        <input type="submit" value="登录" class="login_submit">
      </div>
    </form>
  </div>
</body>

</html>