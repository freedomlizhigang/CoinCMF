### 安装使用说明
1. 生产环境软件需求：
    NGINX，PHP7.2+，MySQL5.7+，Redis4+，PHP扩展必须安装redis，Composer
2. 开发环境软件需求：
    如上再加npm
3. 安装顺序
    1. 下载整个程序包，运行 composer install 安装必要的laravel依赖
    2. 运行 npm install 安装前端页面开发依赖（生产环境不用）
    3. 配置数据库，运行迁移文件，导入 sql 目录下 init.sql，初始化数据库
    4. 修改项目配置文件 .env ，开始使用
    5. 其他配置按需


### 一些说明
1. 前后端数据传输过程加密过，使用RSA加密token，AES加密表单字段信息