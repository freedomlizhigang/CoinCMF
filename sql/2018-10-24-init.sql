/*
SQLyog Ultimate v12.09 (64 bit)
MySQL - 5.7.17-log : Database - xycmf
*********************************************************************
*/


/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `ad_pos` */

DROP TABLE IF EXISTS `ad_pos`;

CREATE TABLE `ad_pos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `is_mobile` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0:PC/1:MOB',
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '名称',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `ad_pos` */

/*Table structure for table `admins` */

DROP TABLE IF EXISTS `admins`;

CREATE TABLE `admins` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `section_id` int(11) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `realname` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `crypt` char(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `lasttime` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `lastip` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `admins` */

insert  into `admins`(`id`,`section_id`,`name`,`realname`,`email`,`password`,`crypt`,`phone`,`lasttime`,`lastip`,`status`,`created_at`,`updated_at`) values (1,1,'admin','adminss','fsda@eee.com','e6be23611b06054652a3c43ed1492965','C5bdPRt0ci','13123212345','2018-06-26 09:42:09','127.0.0.1',1,'2016-08-07 10:05:54','2018-06-26 09:42:09');

/*Table structure for table `ads` */

DROP TABLE IF EXISTS `ads`;

CREATE TABLE `ads` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pos_id` int(11) NOT NULL DEFAULT '0' COMMENT '位置ID',
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '标题',
  `thumb` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '图片',
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '链接',
  `starttime` timestamp NULL DEFAULT NULL COMMENT '开始时间',
  `endtime` timestamp NULL DEFAULT NULL COMMENT '结束时间',
  `sort` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态，1正常0关闭',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `ads` */

/*Table structure for table `areas` */

DROP TABLE IF EXISTS `areas`;

CREATE TABLE `areas` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parentid` int(11) NOT NULL DEFAULT '0' COMMENT '父ID',
  `provinceid` char(12) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '阿里云ID',
  `areaname` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '名称',
  `lat` char(50) COLLATE utf8_unicode_ci NOT NULL COMMENT '1',
  `lon` char(50) COLLATE utf8_unicode_ci NOT NULL COMMENT '1',
  `is_show` tinyint(4) NOT NULL DEFAULT '1' COMMENT '是否显示：0否，1是',
  `sort` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4150 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `articles` */

DROP TABLE IF EXISTS `articles`;

CREATE TABLE `articles` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `cate_id` int(11) unsigned NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keywords` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '关键字',
  `thumb` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `describe` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `source` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sort` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `hits` int(11) NOT NULL DEFAULT '99' COMMENT '点击量',
  `publish_at` timestamp NULL DEFAULT NULL,
  `push_flag` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1推荐，0不推荐',
  `url` char(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tpl` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'show',
  `del_flag` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1删除，0正常',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `url` (`url`),
  KEY `cate_id` (`cate_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `articles` */

/*Table structure for table `attrs` */

DROP TABLE IF EXISTS `attrs`;

CREATE TABLE `attrs` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `filename` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `attrs` */

/*Table structure for table `categorys` */

DROP TABLE IF EXISTS `categorys`;

CREATE TABLE `categorys` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `parentid` int(11) unsigned NOT NULL,
  `arrparentid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `child` tinyint(4) NOT NULL,
  `arrchildid` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `thumb` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '标题',
  `keyword` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '关键字',
  `describe` text COLLATE utf8mb4_unicode_ci,
  `content` text COLLATE utf8mb4_unicode_ci,
  `cate_tpl` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'list' COMMENT '模板',
  `art_tpl` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'show' COMMENT '文章模板',
  `display` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1显示，0不显示',
  `type` tinyint(1) NOT NULL DEFAULT '0',
  `sort` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `url` char(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `url` (`url`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `categorys` */

/*Table structure for table `communitys` */

DROP TABLE IF EXISTS `communitys`;

CREATE TABLE `communitys` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `areaid1` int(11) NOT NULL DEFAULT '0' COMMENT '省',
  `areaid2` int(11) NOT NULL DEFAULT '0' COMMENT '市',
  `areaid3` int(11) NOT NULL DEFAULT '0' COMMENT '县',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '名称',
  `lat` char(50) COLLATE utf8_unicode_ci NOT NULL COMMENT '1',
  `lon` char(50) COLLATE utf8_unicode_ci NOT NULL COMMENT '1',
  `is_show` tinyint(4) NOT NULL DEFAULT '1' COMMENT '是否显示：0否，1是',
  `sort` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=43943 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `config` */

DROP TABLE IF EXISTS `config`;

CREATE TABLE `config` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sitename` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '站点名称',
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'SEO标题',
  `keyword` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '关键字',
  `describe` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '描述',
  `theme` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT 'default' COMMENT '主题',
  `person` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '联系人',
  `phone` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '联系电话',
  `email` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '邮箱',
  `address` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '地址',
  `content` varchar(1000) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '介绍',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `config` */

insert  into `config`(`id`,`sitename`,`title`,`keyword`,`describe`,`theme`,`person`,`phone`,`email`,`address`,`content`,`created_at`,`updated_at`) values (1,'希夷CMF','希夷CMF',NULL,NULL,'home','李','18932813211','lzhigang@xi-yi.net','地址：河北省衡水市育才街永兴路口逸升佳苑29号楼3A02','希夷工作室：拥有多名优秀成员，整个团队工作分工明确，又相互衔接，密不可分。为跟进技术变革，我工作室对工作人员进行定期定向技能培训，保证市场人员拥有先进的行业理念，客服人员可以创造一流的服务质量，设计人员具有敏锐的视觉洞察力，开发人员保持在技术发展的最前延，我们始终认为：不间断的学习才能在飞速发展的互联网时代长久立足。',NULL,'2018-06-26 10:33:20');

/*Table structure for table `groups` */

DROP TABLE IF EXISTS `groups`;

CREATE TABLE `groups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '用户组名',
  `points` int(11) NOT NULL DEFAULT '1000' COMMENT '所需积分',
  `discount` int(11) NOT NULL DEFAULT '100' COMMENT '折扣',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态，1正常0禁用',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `groups` */

insert  into `groups`(`id`,`name`,`points`,`discount`,`status`,`created_at`,`updated_at`) values (1,'普通用户',0,100,1,'2017-04-20 16:56:40','2017-07-22 09:45:33'),(2,'铜牌用户',1000,98,1,'2017-04-20 16:56:51','2017-06-20 09:29:09'),(3,'银牌用户',2000,96,1,'2017-06-14 17:21:03','2017-06-20 09:30:16'),(4,'金牌用户',5000,93,1,'2017-06-14 17:21:20','2017-06-20 09:30:27'),(5,'钻石用户',10000,90,1,'2017-06-14 17:21:36','2017-06-20 09:30:34');

/*Table structure for table `logs` */

DROP TABLE IF EXISTS `logs`;

CREATE TABLE `logs` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `admin_id` int(11) NOT NULL,
  `user` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `method` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `admin_id` (`admin_id`)
) ENGINE=InnoDB AUTO_INCREMENT=299 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `menus` */

DROP TABLE IF EXISTS `menus`;

CREATE TABLE `menus` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parentid` int(11) NOT NULL,
  `arrparentid` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `child` tinyint(1) NOT NULL DEFAULT '0',
  `arrchildid` mediumtext COLLATE utf8mb4_unicode_ci,
  `name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `label` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `display` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `sort` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=351 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `menus` */

insert  into `menus`(`id`,`parentid`,`arrparentid`,`child`,`arrchildid`,`name`,`url`,`label`,`icon`,`display`,`sort`,`created_at`,`updated_at`) values (1,0,'0',1,'1,5,6,7,8,9,67,68,74,148,149,150,281,282,283,284,285,286,287,288,289,10,11,12,13,14,15,16,17,18,19,140,170,171,172,173,20,21','系统','index/index','index-index',NULL,1,99,'2016-03-18 15:46:02','2018-06-26 09:40:26'),(2,0,'0',1,'2,22,23,24,25,26,27,28,75,30,31,32,33,34,121,136,342,151,152,153,154,242,243,244,245,246,247,300,301,302,303,343,344,345,346,347,348,349,350,143,144,145,194,195,196,197,198,199,200,201,299,205','CMF','content/index','content-index',NULL,1,0,'2016-03-18 15:46:21','2018-10-24 06:10:08'),(5,1,'0,1',1,'5,6,7,8,9,67,68,74,148,149,150,281,282,283,284,285,286,287,288,289','系统设置','sys/index','sys-index','icon-brightnessmedium',1,0,'2016-03-18 15:47:40','2018-10-16 10:27:40'),(6,5,'0,1,5',1,'6,7,8,9','菜单管理','menu/index','menu-index','icon-menu',1,1,'2016-03-18 15:48:07','2018-10-16 10:28:31'),(7,6,'0,1,5,6',0,'7','添加菜单','menu/add','menu-add',NULL,1,0,'2016-03-18 15:49:03','2016-03-23 08:25:50'),(8,6,'0,1,5,6',0,'8','修改菜单','menu/edit','menu-edit',NULL,0,0,'2016-03-18 15:51:08','2016-03-23 14:23:43'),(9,6,'0,1,5,6',0,'9','删除菜单','menu/del','menu-del',NULL,0,0,'2016-03-18 15:51:30','2016-03-23 08:25:50'),(10,1,'0,1',1,'10,11,12,13,14,15,16,17,18,19,140,170,171,172,173','用户中心','admin/manage','admin-manage','icon-people',1,0,'2016-03-18 16:04:01','2018-10-16 10:31:27'),(11,10,'0,1,10',1,'11,12,13,14,15','用户管理','admin/index','admin-index','icon-person',1,0,'2016-03-18 16:04:38','2018-10-16 10:31:37'),(12,11,'0,1,10,11',0,'12','添加用户','admin/add','admin-add',NULL,1,0,'2016-03-18 16:05:14','2016-03-24 11:31:16'),(13,11,'0,1,10,11',0,'13','修改用户','admin/edit','admin-edit',NULL,0,0,'2016-03-18 16:06:10','2016-03-24 11:31:24'),(14,11,'0,1,10,11',0,'14','删除用户','admin/del','admin-del',NULL,0,0,'2016-03-18 16:06:31','2016-03-24 11:31:32'),(15,11,'0,1,10,11',0,'15','修改密码','admin/pwd','admin-pwd',NULL,0,0,'2016-03-18 16:07:07','2016-03-24 11:31:44'),(16,10,'0,1,10',1,'16,17,18,19,140','角色管理','role/index','role-index','icon-mood',1,0,'2016-03-18 16:07:58','2018-10-16 10:32:16'),(17,16,'0,1,10,16',0,'17','添加角色','role/add','role-add',NULL,1,0,'2016-03-18 16:08:23','2016-03-23 08:25:50'),(18,16,'0,1,10,16',0,'18','修改角色','role/edit','role-edit',NULL,0,0,'2016-03-18 16:08:50','2016-03-23 08:25:50'),(19,16,'0,1,10,16',0,'19','删除角色','role/del','role-del',NULL,0,0,'2016-03-18 16:09:10','2016-03-23 08:25:50'),(20,1,'0,1',1,'20,21','所有人都要有的权限','index/main','index-main',NULL,0,0,'2016-03-24 15:42:14','2018-10-16 10:34:17'),(21,20,'0,1,20',0,'21','左侧菜单','index/left','index-left',NULL,0,0,'2016-03-25 10:34:44','2016-03-25 10:35:27'),(22,2,'0,2',1,'22,23,24,25,26,27,28,75,30,31,32,33,34,121,136,342,151,152,153,154,242,243,244,245,246,247,300,301,302,303,343,344,345,346,347,348,349,350','内容管理','content/manage','content-manage','icon-viewmodule',1,0,'2016-03-29 08:39:52','2018-10-24 06:10:08'),(23,22,'0,2,22',1,'23,24,25,26,27','栏目管理','cate/index','cate-index','icon-list',1,0,'2016-03-29 08:40:08','2018-10-16 10:11:45'),(24,23,'0,2,22,23',0,'24','添加栏目','cate/add','cate-add',NULL,1,0,'2016-03-29 08:40:25','2016-03-29 08:40:25'),(25,23,'0,2,22,23',0,'25','修改栏目','cate/edit','cate-edit',NULL,0,0,'2016-03-29 08:40:42','2016-03-29 08:41:00'),(26,23,'0,2,22,23',0,'26','删除栏目','cate/del','cate-del',NULL,0,0,'2016-03-29 08:40:54','2016-03-29 08:41:07'),(27,23,'0,2,22,23',0,'27','更新栏目缓存','cate/cache','cate-cache',NULL,0,0,'2016-03-29 08:41:30','2016-03-29 08:41:30'),(28,22,'0,2,22',1,'28,75','附件管理','attr/index','attr-index',NULL,0,5,'2016-03-31 08:23:28','2017-08-04 14:56:05'),(30,22,'0,2,22',1,'30,31,32,33,34,121,136,342','文章管理','art/index','art-index','icon-menu',1,0,'2016-03-31 08:25:22','2018-10-16 10:15:14'),(31,30,'0,2,22,30',0,'31','添加文章','art/add','art-add',NULL,1,0,'2016-03-31 08:25:40','2016-07-23 17:39:54'),(32,30,'0,2,22,30',0,'32','修改文章','art/edit','art-edit',NULL,0,0,'2016-03-31 08:25:59','2016-03-31 08:25:59'),(33,30,'0,2,22,30',0,'33','删除文章','art/del','art-del',NULL,0,0,'2016-03-31 08:26:15','2016-03-31 08:26:15'),(34,30,'0,2,22,30',0,'34','查看文章','art/show','art-show',NULL,0,0,'2016-03-31 08:26:35','2016-03-31 08:26:36'),(67,5,'0,1,5',1,'67,68','操作日志','log/index','log-index','icon-watch',1,4,'2016-04-11 10:38:34','2018-10-16 10:30:42'),(68,67,'0,1,5,67',0,'68','清除7天前日志','log/del','log-del',NULL,0,0,'2016-04-11 10:38:53','2016-05-11 17:37:46'),(74,5,'0,1,5',0,'74','更新缓存','index/cache','index-cache','icon-undo',1,5,'2016-04-11 16:00:30','2018-10-16 10:31:01'),(75,28,'0,2,22,28',0,'75','删除附件','attr/delfile','attr-delfile',NULL,0,0,'2016-05-09 19:29:09','2016-05-09 19:29:09'),(121,30,'0,2,22,30',0,'121','批量删除','art/alldel','art-alldel',NULL,0,0,'2016-06-15 08:52:32','2016-06-15 08:52:32'),(136,30,'0,2,22,30',0,'136','批量排序','art/listorder','art-listorder',NULL,0,0,'2016-07-25 08:35:42','2016-07-25 08:35:42'),(140,16,'0,1,10,16',0,'140','角色权限','role/priv','role-priv',NULL,0,0,'2016-07-25 11:34:39','2016-07-25 11:34:40'),(143,2,'0,2',1,'143,144,145','资料','admin/info','admin-info','icon-accountbox',1,99,'2016-07-28 14:01:45','2018-10-16 10:24:40'),(144,143,'0,2,143',0,'144','修改个人资料','admin/myedit','admin-myedit','icon-personoutline',1,0,'2016-07-28 14:02:12','2018-10-16 10:25:48'),(145,143,'0,2,143',0,'145','修改个人密码','admin/mypwd','admin-mypwd','icon-lockopen',1,0,'2016-07-28 14:02:37','2018-10-16 10:26:07'),(148,5,'0,1,5',1,'148,149,150','数据管理','database/export','database-export','icon-datausage',1,3,'2016-12-02 10:21:37','2018-10-16 10:30:01'),(149,148,'0,1,5,148',0,'149','恢复数据','database/import','database-import',NULL,0,0,'2016-12-02 10:22:16','2016-12-02 10:22:23'),(150,148,'0,1,5,148',0,'150','删除备份文件','database/delfile','database-delfile',NULL,0,0,'2016-12-02 10:22:47','2016-12-02 10:22:48'),(151,22,'0,2,22',1,'151,152,153,154','分类管理','type/index','type-index','icon-viewlist',1,2,'2016-12-14 09:56:01','2018-10-16 10:18:22'),(152,151,'0,2,22,151',0,'152','添加分类','type/add','type-add',NULL,1,0,'2016-12-14 09:56:23','2018-06-26 09:39:50'),(153,151,'0,2,22,151',0,'153','修改分类','type/edit','type-edit',NULL,0,0,'2016-12-14 09:56:42','2018-06-26 09:39:50'),(154,151,'0,2,22,151',0,'154','删除分类','type/del','type-del',NULL,0,0,'2016-12-14 09:56:57','2018-06-26 09:39:50'),(170,10,'0,1,10',1,'170,171,172,173','部门管理','section/index','section-index','icon-drive',1,0,'2016-12-15 08:31:39','2018-10-16 10:33:58'),(171,170,'0,1,10,170',0,'171','添加部门','section/add','section-add',NULL,1,0,'2016-12-15 08:32:01','2016-12-15 08:32:02'),(172,170,'0,1,10,170',0,'172','修改部门','section/edit','section-edit',NULL,0,0,'2016-12-15 08:32:23','2016-12-15 08:32:23'),(173,170,'0,1,10,170',0,'173','删除部门','section/del','section-del',NULL,0,0,'2016-12-15 08:32:44','2016-12-15 08:32:44'),(194,2,'0,2',1,'194,195,196,197,198,199,200,201','会员管理','user/manage','user-manage','icon-group',1,0,'2017-03-17 08:30:28','2018-10-16 10:19:09'),(195,194,'0,2,194',1,'195,196,197,198','会员组','group/index','group-index','icon-groupadd',1,0,'2017-03-17 08:30:46','2018-10-16 10:19:34'),(196,195,'0,2,194,195',0,'196','添加会员组','group/add','group-add',NULL,1,0,'2017-03-17 08:31:05','2018-06-26 09:38:03'),(197,195,'0,2,194,195',0,'197','修改会员组','group/edit','group-edit',NULL,0,0,'2017-03-17 08:31:25','2018-06-26 09:38:03'),(198,195,'0,2,194,195',0,'198','删除会员组','group/del','group-del',NULL,0,0,'2017-03-17 08:31:40','2018-06-26 09:38:03'),(199,194,'0,2,194',1,'199,200,201','会员列表','user/index','user-index','icon-person',1,0,'2017-03-17 08:33:22','2018-10-16 10:19:51'),(200,199,'0,2,194,199',0,'200','禁用会员','user/status','user-status',NULL,0,0,'2017-03-17 08:34:25','2018-06-26 09:38:04'),(201,199,'0,2,194,199',0,'201','修改会员','user/edit','user/edit',NULL,0,0,'2017-03-17 08:34:46','2018-06-26 09:38:04'),(205,299,'0,2,299',0,'205','系统配置','config/index','config-index','icon-brightnesshigh',1,0,'2017-04-25 21:49:13','2018-10-16 10:24:15'),(242,22,'0,2,22',1,'242,243,244,245,246,247','广告管理','ad/index','ad-index','icon-tv',1,0,'2017-05-16 06:34:07','2018-10-16 10:16:08'),(243,242,'0,2,22,242',0,'243','添加广告','ad/add','ad-add',NULL,1,0,'2017-05-16 06:34:25','2018-06-26 09:38:52'),(244,242,'0,2,22,242',0,'244','修改广告','ad/edit','ad-edit',NULL,0,0,'2017-05-16 06:34:40','2018-06-26 09:38:52'),(245,242,'0,2,22,242',0,'245','删除广告','ad/del','ad-del',NULL,0,0,'2017-05-16 06:34:55','2018-06-26 09:38:52'),(246,242,'0,2,22,242',0,'246','广告排序','ad/sort','ad-sort',NULL,0,0,'2017-05-16 06:35:11','2018-06-26 09:38:52'),(247,242,'0,2,22,242',0,'247','批量删除广告','ad/alldel','ad-alldel',NULL,0,0,'2017-05-16 06:35:35','2018-06-26 09:38:53'),(281,5,'0,1,5',1,'281,282,283,284,285','区域管理','area/index','area-index','icon-map',1,2,'2017-06-30 17:31:45','2018-10-16 10:29:19'),(282,281,'0,1,5,281',0,'282','添加区域','area/add','area-add',NULL,1,0,'2017-06-30 17:33:52','2017-06-30 17:33:52'),(283,281,'0,1,5,281',0,'283','修改区域','area/edit','area-edit',NULL,0,0,'2017-06-30 17:34:18','2017-06-30 17:34:18'),(284,281,'0,1,5,281',0,'284','删除区域','area/del','area-del',NULL,0,0,'2017-06-30 17:36:24','2017-06-30 17:36:25'),(285,281,'0,1,5,281',0,'285','取下级区域','area/get','area-get',NULL,0,0,'2017-06-30 17:38:08','2017-06-30 17:38:08'),(286,5,'0,1,5',1,'286,287,288,289','社区管理','community/index','community-index','icon-satellite',1,2,'2017-06-30 18:19:34','2018-10-16 10:29:44'),(287,286,'0,1,5,286',0,'287','添加社区','community/add','community-add',NULL,1,0,'2017-06-30 18:20:03','2017-06-30 18:20:03'),(288,286,'0,1,5,286',0,'288','修改社区','community/edit','community-edit',NULL,0,0,'2017-06-30 18:20:26','2017-06-30 18:20:27'),(289,286,'0,1,5,286',0,'289','删除社区','community/del','community-del',NULL,0,0,'2017-06-30 18:20:44','2017-06-30 18:20:45'),(299,2,'0,2',1,'299,205','设置','sys/set','sys-set','icon-settings',1,98,'2017-07-01 09:18:39','2018-10-16 10:23:32'),(300,22,'0,2,22',1,'300,301,302,303','广告位管理','adpos/index','adpos-index','icon-slideshow',1,0,'2017-07-01 09:19:12','2018-10-16 10:17:59'),(301,300,'0,2,22,300',0,'301','添加广告位','adpos/add','adpos-add',NULL,1,0,'2017-07-01 09:19:37','2018-06-26 09:39:04'),(302,300,'0,2,22,300',0,'302','修改广告位','adpos/edit','adpos-edit',NULL,0,0,'2017-07-01 09:19:59','2018-06-26 09:39:04'),(303,300,'0,2,22,300',0,'303','删除广告位','adpos/del','adpos-del',NULL,0,0,'2017-07-01 09:20:21','2018-06-26 09:39:04'),(342,30,'0,2,22,30',0,'342','文章选择','art/select','art-select',NULL,0,0,'2017-08-18 11:51:16','2017-11-07 09:46:42'),(343,22,'0,2,22',1,'343,344,345,346,347,348,349,350','模型管理','model/index','model-index','icon-terrain',1,0,'2018-10-24 06:07:04','2018-10-24 06:10:08'),(344,343,'0,2,22,343',0,'344','添加模型','model/add','model-add',NULL,1,0,'2018-10-24 06:07:32','2018-10-24 06:07:33'),(345,343,'0,2,22,343',0,'345','修改模型','model/edit','model-edit',NULL,0,0,'2018-10-24 06:07:48','2018-10-24 06:07:57'),(346,343,'0,2,22,343',0,'346','删除模型','model/del','model-del',NULL,0,0,'2018-10-24 06:08:17','2018-10-24 06:08:17'),(347,343,'0,2,22,343',0,'347','字段管理','field/index','field-index',NULL,0,0,'2018-10-24 06:08:38','2018-10-24 06:09:28'),(348,343,'0,2,22,343',0,'348','添加字段','field/add','field-add',NULL,0,0,'2018-10-24 06:09:09','2018-10-24 06:09:09'),(349,343,'0,2,22,343',0,'349','修改字段','field/edit','field-edit',NULL,0,0,'2018-10-24 06:09:51','2018-10-24 06:09:51'),(350,343,'0,2,22,343',0,'350','删除字段','field/del','field-del',NULL,0,0,'2018-10-24 06:10:08','2018-10-24 06:10:08');

/*Table structure for table `migrations` */

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `migrations` */

insert  into `migrations`(`id`,`migration`,`batch`) values (11,'2018_10_24_054742_create_models',1),(12,'2018_10_24_054852_create_model_fields',1);

/*Table structure for table `model_fields` */

DROP TABLE IF EXISTS `model_fields`;

CREATE TABLE `model_fields` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `model_id` int(11) NOT NULL DEFAULT '0' COMMENT '模型ID',
  `type` enum('id','text','textarea','ueditor','number','password','thumb','album','datetime','box','files','linkage') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'text' COMMENT '字段类型，text单行文本，textarea多行文本，ueditor富文本，number数字，password密码，thumb单图，album多图，datetime时间，box选项（radio单选，checkbox多选，select下拉框，multiple多选列表框），files文件，linkage联动菜单（分类，radio单选，checkbox多选，select下拉框，multiple多选列表框）',
  `field_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '字段名',
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '字段别名',
  `tips` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '错误提示',
  `validation` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '验证规则',
  `option` json DEFAULT NULL COMMENT '其它配置',
  `sort` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态：1 正常，0 禁用',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `model_fields` */

insert  into `model_fields`(`id`,`model_id`,`type`,`field_name`,`title`,`tips`,`validation`,`option`,`sort`,`status`,`created_at`,`updated_at`) values (1,1,'id','id','ID',NULL,NULL,NULL,0,1,'2018-10-24 08:55:56','2018-10-24 08:55:56'),(2,1,'datetime','created_at','创建时间',NULL,NULL,NULL,999,1,'2018-10-24 08:55:56','2018-10-24 08:55:56'),(3,1,'datetime','updated_at','修改时间',NULL,NULL,NULL,999,1,'2018-10-24 08:55:56','2018-10-24 08:55:56'),(11,1,'text','name','22',NULL,NULL,'null',0,1,'2018-10-24 10:41:45','2018-10-24 10:41:45'),(12,1,'datetime','publish_at','发布时间',NULL,NULL,'{\"format\": \"Y-m-d H:i:s\", \"human_flag\": \"1\"}',0,1,'2018-10-24 10:52:20','2018-10-24 10:52:20'),(13,1,'textarea','describe','描述',NULL,NULL,'null',0,1,'2018-10-24 10:53:29','2018-10-24 10:53:29'),(14,1,'box','color','颜色',NULL,NULL,'{\"values\": [{\"红\": \"红色\"}, {\"蓝\": \"蓝色\"}], \"out_type\": \"val\", \"select_type\": \"radio\"}',0,1,'2018-10-24 10:56:31','2018-10-24 10:56:31');

/*Table structure for table `models` */

DROP TABLE IF EXISTS `models`;

CREATE TABLE `models` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '模型标题',
  `tablename` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '模型表名称',
  `describe` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '描述',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态：1 正常，0 禁用',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `models` */

insert  into `models`(`id`,`title`,`tablename`,`describe`,`status`,`created_at`,`updated_at`) values (1,'测试模型','text_models',NULL,1,'2018-10-24 08:55:56','2018-10-24 08:55:56');

/*Table structure for table `role_privs` */

DROP TABLE IF EXISTS `role_privs`;

CREATE TABLE `role_privs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `menu_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  `url` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `label` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `role_privs_roleid_index` (`role_id`),
  KEY `role_privs_url_index` (`url`),
  KEY `role_privs_label_index` (`label`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `role_privs` */

/*Table structure for table `role_users` */

DROP TABLE IF EXISTS `role_users`;

CREATE TABLE `role_users` (
  `role_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `role_users` */

insert  into `role_users`(`role_id`,`user_id`) values (1,1);

/*Table structure for table `roles` */

DROP TABLE IF EXISTS `roles`;

CREATE TABLE `roles` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `roles` */

insert  into `roles`(`id`,`name`,`status`,`created_at`,`updated_at`) values (1,'超级管理员',1,'2016-03-18 16:42:51','2017-07-22 09:42:39');

/*Table structure for table `sections` */

DROP TABLE IF EXISTS `sections`;

CREATE TABLE `sections` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `sections` */

insert  into `sections`(`id`,`name`,`status`,`created_at`,`updated_at`) values (1,'市场',1,'2016-12-15 08:43:05','2017-07-22 09:42:44');

/*Table structure for table `text_models` */

DROP TABLE IF EXISTS `text_models`;

CREATE TABLE `text_models` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '22',
  `publish_at` timestamp NULL DEFAULT NULL COMMENT '发布时间',
  `describe` varchar(1000) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '描述',
  `color` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '颜色',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `text_models` */

/*Table structure for table `types` */

DROP TABLE IF EXISTS `types`;

CREATE TABLE `types` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parentid` int(10) unsigned NOT NULL,
  `arrparentid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `child` tinyint(4) DEFAULT NULL,
  `arrchildid` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `name` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sort` int(10) unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `types` */

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `gid` int(11) NOT NULL DEFAULT '1' COMMENT '组ID',
  `openid` char(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '用户名',
  `password` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci DEFAULT NULL COMMENT '密码',
  `token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'API登陆用',
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '手机号',
  `nickname` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '昵称',
  `thumb` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '头像',
  `email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '邮箱',
  `sex` tinyint(4) NOT NULL DEFAULT '0' COMMENT '性别',
  `birthday` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '生日',
  `address` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '地址',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态，1正常0禁用',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `openid` (`openid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `users` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
