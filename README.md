### 计划

10. 广告位，广告


###完成的

系统基于Laravel 5.6

权限使用了RBAC

数据库字符集全改 utf8mb64

后台整体改Vue+iview方式，所有数据请求使用接口+js的前后端分离方案，验证用中间件jwt方式

用户功能，同时做了一套api的接口

### 常用的几个返回码，请严格按此码返回，方便前后端定位错误：200 正常，500 服务器问题，400 输入参数问题，401 token问题，402 接口权限问题，403 输入正确，但其它相关数据有问题，拒绝继续执行

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