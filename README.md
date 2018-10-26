### 计划

字段类型，text单行文本，textarea多行文本，ueditor富文本，number数字，password密码，thumb单图，album多图，datetime时间，box选项（radio单选，checkbox多选，select下拉框，multiple多选列表框），files文件，linkage联动菜单（分类，radio单选，checkbox多选，select下拉框，multiple多选列表框）

模型生成的表单页面，预览效果

模型数据的保存与修改、查找，暂时考虑用DB::table()方法处理

###完成的

系统基于Laravel 5.4，认证使用了RBAC及系统Gate，RBAC主要产生后台菜单，Gate细化小菜单并进行更细的权限管理

数据库字符集全改 utf8mb64

样式表，bootstrap定制

rbac 中间件控制打开页面是否有权限，同时判断是否登陆，App:make('com')->ifCan()控制细节显示与否

添加调试工具Debugbar http://laravelacademy.org/post/2774.html，主页里关闭调试

提示信息，使用一次性session，在back()或者redirect()后->with('message','信息');

数据库备份功能（改造自V9）

附件删除

用户功能，同时做了一套api的接口

后台整体改ajax方式


### 清空数据

TRUNCATE li_ad_pos;
TRUNCATE li_ads;
TRUNCATE li_attrs;
TRUNCATE li_articles;
TRUNCATE li_categorys;
TRUNCATE li_logs;
TRUNCATE li_migrations;
TRUNCATE li_role_privs;
TRUNCATE li_types;