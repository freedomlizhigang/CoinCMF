### 计划

3. 用户管理，个人资料修改

4. 删除不常用功能，整理文件夹

5. 系统设置

6. 日志

7. 分类

8. 栏目

9. 文章

10. 广告位，广告


###完成的

系统基于Laravel 5.6

权限使用了RBAC

数据库字符集全改 utf8mb64

后台整体改Vue+iview方式，所有数据请求使用接口+js的前后端分离方案，验证用中间件jwt方式

用户功能，同时做了一套api的接口

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