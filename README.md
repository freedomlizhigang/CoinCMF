<!-- 完成的 -->

1. 数据库字符集全改 utf8mb64

###完成的

系统基于Laravel 5.4，认证使用了RBAC及系统Gate，RBAC主要产生后台菜单，Gate细化小菜单并进行更细的权限管理

样式表，bootstrap定制

rbac 中间件控制打开页面是否有权限，同时判断是否登陆，App:make('com')->ifCan()控制细节显示与否

添加调试工具Debugbar http://laravelacademy.org/post/2774.html，主页里关闭调试

提示信息，使用一次性session，在back()或者redirect()后->with('message','信息');

数据库备份功能（改造自V9）

附件删除

用户功能，同时做了一套api的接口

后台整体改ajax方式
