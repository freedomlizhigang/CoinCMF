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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `admins` */

insert  into `admins`(`id`,`section_id`,`name`,`realname`,`email`,`password`,`crypt`,`phone`,`lasttime`,`lastip`,`status`,`created_at`,`updated_at`) values (1,1,'admin','admins','fsda@eee.com','348db1ff89cb53c0e8912371be92e107','ZYsX1M8xIc','13123212345','2018-12-26 17:27:52','127.0.0.1',1,'2016-08-07 10:05:54','2018-12-26 17:27:52'),(2,1,'admin22','adminss','fsda@eee.com','0a270bd0c5f834ca8394ab944c8a4db2','Q5X2B26mxt','13123212345','2018-12-26 17:35:11','127.0.0.1',1,'2016-08-07 10:05:54','2018-12-26 17:35:11');

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

/*Table structure for table `articles` */

DROP TABLE IF EXISTS `articles`;

CREATE TABLE `articles` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `cate_id` int(11) unsigned NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keywords` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '关键字',
  `thumb` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `describe` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `articles` */

insert  into `articles`(`id`,`cate_id`,`title`,`keywords`,`thumb`,`describe`,`content`,`source`,`sort`,`hits`,`publish_at`,`push_flag`,`url`,`tpl`,`del_flag`,`created_at`,`updated_at`) values (1,1,'dddd','asd',NULL,'ddd','dsasda',NULL,2,99,'2018-11-29 08:50:52',0,'sss','show',0,'2018-11-29 08:50:45','2018-11-29 19:12:12'),(2,1,'dddd','asd',NULL,'ddd','dsasda',NULL,10,11,'2018-11-29 10:50:52',0,'sss','show',0,'2018-11-29 08:50:45','2018-11-30 10:42:14');

/*Table structure for table `attrs` */

DROP TABLE IF EXISTS `attrs`;

CREATE TABLE `attrs` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `filename` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=70 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `attrs` */

insert  into `attrs`(`id`,`filename`,`url`,`created_at`,`updated_at`) values (1,'时代记忆直播系统.xlsx','/upload/20181027/20181027091423751.xlsx','2018-10-27 09:14:23','2018-10-27 09:14:23'),(2,'时代记忆直播系统.xlsx','/upload/20181027/20181027091457517.xlsx','2018-10-27 09:14:57','2018-10-27 09:14:57'),(3,'时代记忆直播系统.xlsx','/upload/20181027/20181027091556812.xlsx','2018-10-27 09:15:56','2018-10-27 09:15:56'),(4,'时代记忆直播功能说明计划书(1).docx','/upload/20181027/20181027091556562.docx','2018-10-27 09:15:56','2018-10-27 09:15:56'),(5,'时代记忆直播系统.xlsx','/upload/20181027/20181027091714478.xlsx','2018-10-27 09:17:14','2018-10-27 09:17:14'),(6,'时代记忆直播功能说明计划书(1).docx','/upload/20181027/20181027091717189.docx','2018-10-27 09:17:17','2018-10-27 09:17:17'),(7,'left_r.png','/upload/thumb/20181027/20181027091905834.png','2018-10-27 09:19:05','2018-10-27 09:19:05'),(8,'left_r1.png','/upload/thumb/20181027/20181027091907407.png','2018-10-27 09:19:07','2018-10-27 09:19:07'),(9,'left_l.png','/upload/20181027/20181027092103490.png','2018-10-27 09:21:03','2018-10-27 09:21:03'),(10,'left_r.png','/upload/20181027/20181027092107410.png','2018-10-27 09:21:07','2018-10-27 09:21:07'),(11,'login_bg.png','/upload/thumb/20181027/20181027092128280.png','2018-10-27 09:21:28','2018-10-27 09:21:28'),(12,'left_l.png','/upload/20181027/20181027092221311.png','2018-10-27 09:22:21','2018-10-27 09:22:21'),(13,'left_r1.png','/upload/20181027/20181027092225629.png','2018-10-27 09:22:25','2018-10-27 09:22:25'),(14,'login_bg.png','/upload/20181027/20181027092228787.png','2018-10-27 09:22:28','2018-10-27 09:22:28'),(15,'login_h.png','/upload/20181027/20181027092230895.png','2018-10-27 09:22:30','2018-10-27 09:22:30'),(16,'left_r.png','/upload/20181027/20181027092259312.png','2018-10-27 09:22:59','2018-10-27 09:22:59'),(17,'left_r.png','/upload/thumb/20181027/20181027092329859.png','2018-10-27 09:23:29','2018-10-27 09:23:29'),(18,'left_r.png','/upload/20181027/20181027093149202.png','2018-10-27 09:31:49','2018-10-27 09:31:49'),(19,'left_l.png','/upload/20181027/20181027093213800.png','2018-10-27 09:32:13','2018-10-27 09:32:13'),(20,'left_r.png','/upload/20181027/20181027093213435.png','2018-10-27 09:32:13','2018-10-27 09:32:13'),(21,'left_r1.png','/upload/20181027/20181027093213687.png','2018-10-27 09:32:13','2018-10-27 09:32:13'),(22,'login_bg.png','/upload/20181027/20181027093213630.png','2018-10-27 09:32:13','2018-10-27 09:32:13'),(23,'left_l.png','/upload/20181027/20181027093316330.png','2018-10-27 09:33:16','2018-10-27 09:33:16'),(24,'left_l.png','/upload/20181027/20181027093450449.png','2018-10-27 09:34:50','2018-10-27 09:34:50'),(25,'left_r.png','/upload/20181027/20181027093454424.png','2018-10-27 09:34:54','2018-10-27 09:34:54'),(26,'login_bg.png','/upload/20181027/20181027093458642.png','2018-10-27 09:34:58','2018-10-27 09:34:58'),(27,'left_r.png','/upload/20181027/20181027093530394.png','2018-10-27 09:35:30','2018-10-27 09:35:30'),(28,'login_bg.png','/upload/20181027/20181027093534882.png','2018-10-27 09:35:34','2018-10-27 09:35:34'),(29,'login_h.png','/upload/20181027/20181027093537923.png','2018-10-27 09:35:37','2018-10-27 09:35:37'),(30,'left_r.png','/upload/20181027/20181027093553760.png','2018-10-27 09:35:53','2018-10-27 09:35:53'),(31,'logo.png','/upload/20181027/20181027093556383.png','2018-10-27 09:35:56','2018-10-27 09:35:56'),(32,'left_r.png','/upload/20181027/20181027093734819.png','2018-10-27 09:37:34','2018-10-27 09:37:34'),(33,'login_bg.png','/upload/20181027/20181027093737574.png','2018-10-27 09:37:37','2018-10-27 09:37:37'),(34,'login_h.png','/upload/20181027/20181027093740651.png','2018-10-27 09:37:40','2018-10-27 09:37:40'),(35,'share.png','/upload/20181027/20181027093857256.png','2018-10-27 09:38:57','2018-10-27 09:38:57'),(36,'logo.png','/upload/20181027/20181027093927182.png','2018-10-27 09:39:27','2018-10-27 09:39:27'),(37,'logo.png','/upload/20181027/20181027094113451.png','2018-10-27 09:41:13','2018-10-27 09:41:13'),(38,'share.png','/upload/20181027/20181027094114527.png','2018-10-27 09:41:14','2018-10-27 09:41:14'),(39,'share-map.png','/upload/20181027/20181027094122784.png','2018-10-27 09:41:22','2018-10-27 09:41:22'),(40,'753555069770070372.png','/upload/20181130/20181130094033272.png','2018-11-30 09:40:33','2018-11-30 09:40:33'),(41,'753555069770070372.png','/upload/20181130/20181130094528171.png','2018-11-30 09:45:28','2018-11-30 09:45:28'),(42,'753555069770070372.png','/upload/20181130/20181130094538356.png','2018-11-30 09:45:38','2018-11-30 09:45:38'),(43,'753555069770070372.png','/upload/20181130/20181130094554788.png','2018-11-30 09:45:54','2018-11-30 09:45:54'),(44,'control.png','/upload/20181130/20181130094605655.png','2018-11-30 09:46:05','2018-11-30 09:46:05'),(45,'c-4.png','/upload/20181130/20181130094721472.png','2018-11-30 09:47:21','2018-11-30 09:47:21'),(46,'map.png','/upload/20181130/20181130094816331.png','2018-11-30 09:48:16','2018-11-30 09:48:16'),(47,'blue-arr.png','/upload/thumb/20181130/20181130095033219.png','2018-11-30 09:50:33','2018-11-30 09:50:33'),(48,'banner--椭圆 1 .png','/upload/thumb/20181130/20181130095229148.png','2018-11-30 09:52:29','2018-11-30 09:52:29'),(49,'1543543645.png','/upload/images/20181130/1543543645.png','2018-11-30 10:07:25','2018-11-30 10:07:25'),(50,'blue-arr.png','/upload/thumb/20181130/20181130103052371.png','2018-11-30 10:30:52','2018-11-30 10:30:52'),(51,'1543546125.png','/upload/images/20181130/1543546125.png','2018-11-30 10:48:45','2018-11-30 10:48:45'),(52,'smz_1.png','/upload/20181210/20181210100035664.png','2018-12-10 10:00:35','2018-12-10 10:00:35'),(53,'smz_1.png','/upload/20181210/20181210100135486.png','2018-12-10 10:01:35','2018-12-10 10:01:35'),(54,'smz_1.png','/upload/20181210/20181210100200760.png','2018-12-10 10:02:00','2018-12-10 10:02:00'),(55,'logo.png','/upload/20181210/20181210111608475.png','2018-12-10 11:16:08','2018-12-10 11:16:08'),(56,'logo.png','/upload/20181210/20181210111627842.png','2018-12-10 11:16:27','2018-12-10 11:16:27'),(57,'logo.png','/upload/20181210/20181210111654872.png','2018-12-10 11:16:54','2018-12-10 11:16:54'),(58,'logo.png','/upload/20181210/20181210111722640.png','2018-12-10 11:17:22','2018-12-10 11:17:22'),(59,'logo.png','/upload/20181210/20181210112042172.png','2018-12-10 11:20:42','2018-12-10 11:20:42'),(60,'smz_1.png','/upload/20181210/20181210112052761.png','2018-12-10 11:20:52','2018-12-10 11:20:52'),(61,'smz.png','/upload/20181210/20181210112106744.png','2018-12-10 11:21:06','2018-12-10 11:21:06'),(62,'logo.png','/upload/20181210/20181210112116336.png','2018-12-10 11:21:16','2018-12-10 11:21:16'),(63,'smz.png','/upload/20181210/20181210112144508.png','2018-12-10 11:21:44','2018-12-10 11:21:44'),(64,'logo.png','/upload/20181210/20181210112147296.png','2018-12-10 11:21:47','2018-12-10 11:21:47'),(65,'smz.png','/upload/20181210/20181210112304473.png','2018-12-10 11:23:04','2018-12-10 11:23:04'),(66,'smz_1.png','/upload/20181210/20181210112307334.png','2018-12-10 11:23:07','2018-12-10 11:23:07'),(67,'logo.png','/upload/20181210/20181210112310523.png','2018-12-10 11:23:10','2018-12-10 11:23:10'),(68,'logo.png','/upload/20181210/20181210112315866.png','2018-12-10 11:23:15','2018-12-10 11:23:15'),(69,'smz.png','/upload/20181210/20181210112315952.png','2018-12-10 11:23:15','2018-12-10 11:23:15');

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `categorys` */

insert  into `categorys`(`id`,`parentid`,`arrparentid`,`child`,`arrchildid`,`name`,`thumb`,`title`,`keyword`,`describe`,`content`,`cate_tpl`,`art_tpl`,`display`,`type`,`sort`,`url`,`created_at`,`updated_at`) values (1,0,'0,1',0,'1','11111',NULL,NULL,NULL,NULL,NULL,'list','show',1,0,0,'111','2018-11-29 08:50:17','2018-11-29 08:50:19'),(2,0,'0,2',0,'2','2222',NULL,NULL,NULL,NULL,NULL,'list','show',1,0,0,'111','2018-11-29 08:50:17','2018-11-29 08:50:19');

/*Table structure for table `config` */

DROP TABLE IF EXISTS `config`;

CREATE TABLE `config` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sitename` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '站点名称',
  `describe` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '描述',
  `person` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '联系人',
  `phone` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '联系电话',
  `email` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '邮箱',
  `address` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '地址',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `config` */

insert  into `config`(`id`,`sitename`,`describe`,`person`,`phone`,`email`,`address`,`created_at`,`updated_at`) values (1,'山木枝','前后端分离RBAC管理基础框架','李','18932813211','lzhigang@shanmuzhi.com','地址：河北省衡水市育才街永兴路口逸升佳苑29号楼3A02',NULL,'2018-12-08 14:23:29');

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
) ENGINE=InnoDB AUTO_INCREMENT=116 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `logs` */

insert  into `logs`(`id`,`admin_id`,`user`,`method`,`url`,`data`,`created_at`) values (1,1,'admin','POST','http://www.xycmf.com/c-api/admin/detail','{\"admin_id\":\"1\"}','2018-12-11 11:04:29'),(2,1,'admin','POST','http://www.xycmf.com/c-api/admin/detail','{\"admin_id\":\"2\"}','2018-12-11 11:05:38'),(3,1,'admin','POST','http://www.xycmf.com/c-api/admin/detail','{\"admin_id\":\"1\"}','2018-12-11 11:06:17'),(4,1,'admin','POST','http://www.xycmf.com/c-api/admin/detail','{\"admin_id\":\"2\"}','2018-12-11 11:06:47'),(5,1,'admin','POST','http://www.xycmf.com/c-api/admin/detail','{\"admin_id\":\"1\"}','2018-12-11 11:06:48'),(6,1,'admin','POST','http://www.xycmf.com/c-api/admin/detail','{\"admin_id\":\"2\"}','2018-12-11 11:07:08'),(7,1,'admin','POST','http://www.xycmf.com/c-api/admin/detail','{\"admin_id\":\"1\"}','2018-12-11 11:07:11'),(8,1,'admin','POST','http://www.xycmf.com/c-api/admin/detail','{\"admin_id\":\"1\"}','2018-12-11 11:07:20'),(9,1,'admin','POST','http://www.xycmf.com/c-api/admin/detail','{\"admin_id\":\"2\"}','2018-12-11 11:07:22'),(10,1,'admin','POST','http://www.xycmf.com/c-api/admin/detail','{\"admin_id\":\"2\"}','2018-12-11 11:07:24'),(11,1,'admin','POST','http://www.xycmf.com/c-api/menu/detail','{\"menu_id\":\"194\"}','2018-12-26 09:28:49'),(12,1,'admin','POST','http://www.xycmf.com/c-api/menu/edit','{\"id\":\"194\",\"parentid\":\"0\",\"arrparentid\":\"0\",\"child\":\"1\",\"arrchildid\":\"194,195,196,197,198,199,200,201\",\"name\":\"\\u4f1a\\u5458\\u7ba1\\u7406\",\"url\":\"user\\/manage\",\"label\":\"user-manage\",\"icon\":\"ios-person-outline\",\"display\":\"false\",\"sort\":\"0\",\"created_at\":\"2017-03-17 08:30:28\",\"updated_at\":\"2018-12-08 13:39:48\"}','2018-12-26 09:28:52'),(13,1,'admin','POST','http://www.xycmf.com/c-api/menu/detail','{\"menu_id\":\"242\"}','2018-12-26 09:29:54'),(14,1,'admin','POST','http://www.xycmf.com/c-api/menu/edit','{\"id\":\"242\",\"parentid\":\"22\",\"arrparentid\":\"0,22\",\"child\":\"1\",\"arrchildid\":\"242,243,244,245,246,247\",\"name\":\"\\u5e7f\\u544a\\u7ba1\\u7406\",\"url\":\"ad\\/index\",\"label\":\"ad-index\",\"icon\":null,\"display\":\"false\",\"sort\":\"0\",\"created_at\":\"2017-05-16 06:34:07\",\"updated_at\":\"2018-11-28 11:03:20\"}','2018-12-26 09:29:56'),(15,1,'admin','POST','http://www.xycmf.com/c-api/menu/detail','{\"menu_id\":\"300\"}','2018-12-26 09:29:59'),(16,1,'admin','POST','http://www.xycmf.com/c-api/menu/edit','{\"id\":\"300\",\"parentid\":\"22\",\"arrparentid\":\"0,22\",\"child\":\"1\",\"arrchildid\":\"300,301,302,303\",\"name\":\"\\u5e7f\\u544a\\u4f4d\\u7ba1\\u7406\",\"url\":\"adpos\\/index\",\"label\":\"adpos-index\",\"icon\":\"icon-slideshow\",\"display\":\"false\",\"sort\":\"0\",\"created_at\":\"2017-07-01 09:19:12\",\"updated_at\":\"2018-11-28 11:03:20\"}','2018-12-26 09:30:01'),(17,1,'admin','POST','http://www.xycmf.com/c-api/menu/detail','{\"menu_id\":\"28\"}','2018-12-26 09:30:03'),(18,1,'admin','POST','http://www.xycmf.com/c-api/menu/edit','{\"id\":\"28\",\"parentid\":\"22\",\"arrparentid\":\"0,22\",\"child\":\"1\",\"arrchildid\":\"28,75\",\"name\":\"\\u9644\\u4ef6\\u7ba1\\u7406\",\"url\":\"attr\\/index\",\"label\":\"attr-index\",\"icon\":null,\"display\":\"false\",\"sort\":\"5\",\"created_at\":\"2016-03-31 08:23:28\",\"updated_at\":\"2018-12-08 11:45:02\"}','2018-12-26 09:30:05'),(19,1,'admin','POST','http://www.xycmf.com/c-api/admin/editinfo','[]','2018-12-26 09:35:26'),(20,1,'admin','POST','http://www.xycmf.com/c-api/admin/editinfo','[]','2018-12-26 09:35:33'),(21,1,'admin','POST','http://www.xycmf.com/c-api/admin/editinfo','[]','2018-12-26 09:35:52'),(22,1,'admin','POST','http://www.xycmf.com/c-api/admin/detail','[]','2018-12-26 09:36:29'),(23,1,'admin','POST','http://www.xycmf.com/c-api/admin/detail','[]','2018-12-26 09:36:32'),(24,1,'admin','POST','http://www.xycmf.com/c-api/admin/detail','{\"admin_id\":\"1\"}','2018-12-26 09:37:30'),(25,1,'admin','POST','http://www.xycmf.com/c-api/admin/detail','{\"admin_id\":\"1\"}','2018-12-26 09:37:48'),(26,1,'admin','POST','http://www.xycmf.com/c-api/admin/detail','{\"admin_id\":\"1\"}','2018-12-26 09:38:10'),(27,1,'admin','POST','http://www.xycmf.com/c-api/admin/detail','{\"admin_id\":\"1\"}','2018-12-26 09:38:48'),(28,1,'admin','POST','http://www.xycmf.com/c-api/admin/detail','{\"admin_id\":\"1\"}','2018-12-26 09:38:50'),(29,1,'admin','POST','http://www.xycmf.com/c-api/admin/detail','{\"admin_id\":\"1\"}','2018-12-26 09:39:01'),(30,1,'admin','POST','http://www.xycmf.com/c-api/admin/selfeditinfo','[]','2018-12-26 09:39:03'),(31,1,'admin','POST','http://www.xycmf.com/c-api/admin/detail','{\"admin_id\":\"1\"}','2018-12-26 09:39:16'),(32,1,'admin','POST','http://www.xycmf.com/c-api/admin/selfeditinfo','{\"id\":\"1\",\"section_id\":\"1\",\"name\":\"admin\",\"realname\":\"admins\",\"email\":\"fsda@eee.com\",\"phone\":\"13123212345\",\"lasttime\":\"2018-12-12 08:33:28\",\"lastip\":\"127.0.0.1\",\"status\":\"true\",\"created_at\":\"2016-08-07 10:05:54\",\"updated_at\":\"2018-12-12 08:33:28\",\"role_ids\":[\"1\"],\"section\":{\"id\":\"1\",\"name\":\"\\u5e02\\u573a\",\"status\":\"true\",\"created_at\":\"2016-12-15 08:43:05\",\"updated_at\":\"2018-12-04 20:27:18\"},\"role\":[{\"id\":\"1\",\"name\":\"\\u8d85\\u7ea7\\u7ba1\\u7406\\u5458\",\"status\":\"true\",\"created_at\":\"2016-03-18 16:42:51\",\"updated_at\":\"2018-12-06 10:03:36\",\"pivot\":{\"user_id\":\"1\",\"role_id\":\"1\"}}],\"admin_id\":\"1\"}','2018-12-26 09:39:18'),(33,1,'admin','POST','http://www.xycmf.com/c-api/admin/detail','{\"admin_id\":\"1\"}','2018-12-26 09:39:23'),(34,1,'admin','POST','http://www.xycmf.com/c-api/admin/detail','{\"admin_id\":\"1\"}','2018-12-26 09:39:38'),(35,1,'admin','POST','http://www.xycmf.com/c-api/admin/detail','{\"admin_id\":\"1\"}','2018-12-26 09:39:42'),(36,1,'admin','POST','http://www.xycmf.com/c-api/admin/detail','{\"admin_id\":\"1\"}','2018-12-26 09:39:49'),(37,1,'admin','POST','http://www.xycmf.com/c-api/admin/detail','{\"admin_id\":\"1\"}','2018-12-26 09:40:16'),(38,1,'admin','POST','http://www.xycmf.com/c-api/admin/detail','{\"admin_id\":\"1\"}','2018-12-26 09:40:41'),(39,1,'admin','POST','http://www.xycmf.com/c-api/admin/detail','{\"admin_id\":\"1\"}','2018-12-26 09:40:45'),(40,1,'admin','POST','http://www.xycmf.com/c-api/admin/detail','{\"admin_id\":\"1\"}','2018-12-26 09:40:55'),(41,1,'admin','POST','http://www.xycmf.com/c-api/admin/detail','{\"admin_id\":\"1\"}','2018-12-26 09:41:01'),(42,1,'admin','POST','http://www.xycmf.com/c-api/admin/detail','{\"admin_id\":\"1\"}','2018-12-26 09:41:03'),(43,1,'admin','POST','http://www.xycmf.com/c-api/admin/detail','{\"admin_id\":\"1\"}','2018-12-26 09:41:06'),(44,1,'admin','POST','http://www.xycmf.com/c-api/admin/detail','{\"admin_id\":\"1\"}','2018-12-26 09:41:48'),(45,1,'admin','POST','http://www.xycmf.com/c-api/admin/selfeditpassword','{\"password\":\"111111\",\"password_confirmation\":\"111111\",\"admin_id\":\"1\"}','2018-12-26 09:41:57'),(46,1,'admin','POST','http://www.xycmf.com/c-api/admin/selfeditpassword','{\"password\":\"111111\",\"password_confirmation\":\"111111\",\"admin_id\":\"1\"}','2018-12-26 09:42:17'),(47,1,'admin','POST','http://www.xycmf.com/c-api/admin/selfeditpassword','{\"password\":\"adminss\",\"password_confirmation\":\"adminss\",\"admin_id\":\"1\"}','2018-12-26 09:42:28'),(48,1,'admin','POST','http://www.xycmf.com/c-api/admin/detail','{\"admin_id\":\"2\"}','2018-12-26 17:16:01'),(49,1,'admin','POST','http://www.xycmf.com/c-api/admin/editpassword','{\"admin_id\":\"2\",\"password\":\"111111\",\"password_confirmation\":\"111111\"}','2018-12-26 17:16:07'),(50,1,'admin','POST','http://www.xycmf.com/c-api/admin/detail','{\"admin_id\":\"2\"}','2018-12-26 17:16:11'),(51,1,'admin','POST','http://www.xycmf.com/c-api/admin/editinfo','{\"admin_id\":\"2\",\"section_id\":\"1\",\"role_ids\":[\"3\",\"4\"],\"realname\":\"adminss\",\"phone\":\"13123212345\",\"email\":\"fsda@eee.com\"}','2018-12-26 17:16:15'),(52,1,'admin','POST','http://www.xycmf.com/c-api/role/priv','{\"role_id\":\"3\",\"menu_id\":[\"22\",\"23\",\"24\",\"25\",\"26\",\"27\",\"30\",\"31\",\"32\",\"33\",\"34\",\"121\",\"136\",\"342\",\"242\",\"243\",\"244\",\"245\",\"246\",\"247\",\"300\",\"301\",\"302\",\"303\",\"28\",\"75\",\"20\",\"21\",\"353\"]}','2018-12-26 17:16:25'),(53,1,'admin','POST','http://www.xycmf.com/c-api/role/priv','{\"role_id\":\"4\",\"menu_id\":[\"194\",\"195\",\"196\",\"197\",\"198\",\"199\",\"200\",\"201\",\"20\",\"21\",\"353\"]}','2018-12-26 17:16:31'),(54,1,'admin','POST','http://www.xycmf.com/c-api/role/priv','{\"role_id\":\"4\",\"menu_id\":[\"194\",\"195\",\"196\",\"197\",\"198\",\"199\",\"200\",\"201\",\"10\",\"11\",\"12\",\"13\",\"14\",\"15\",\"358\",\"359\",\"16\",\"17\",\"18\",\"19\",\"140\",\"357\",\"170\",\"171\",\"172\",\"173\",\"356\",\"6\",\"7\",\"8\",\"9\",\"354\",\"355\",\"67\",\"68\",\"20\",\"21\",\"353\"]}','2018-12-26 17:17:17'),(55,1,'admin','POST','http://www.xycmf.com/c-api/menu/detail','{\"menu_id\":\"23\"}','2018-12-26 17:19:24'),(56,1,'admin','POST','http://www.xycmf.com/c-api/menu/edit','{\"id\":\"23\",\"parentid\":\"22\",\"arrparentid\":\"0,22\",\"child\":\"1\",\"arrchildid\":\"23,24,25,26,27\",\"name\":\"\\u680f\\u76ee\\u7ba1\\u7406\",\"url\":\"cate\\/list\",\"label\":\"cate-list\",\"icon\":null,\"display\":\"true\",\"sort\":\"0\",\"created_at\":\"2016-03-29 08:40:08\",\"updated_at\":\"2018-11-28 11:03:19\"}','2018-12-26 17:19:33'),(57,1,'admin','POST','http://www.xycmf.com/c-api/menu/detail','{\"menu_id\":\"24\"}','2018-12-26 17:19:34'),(58,1,'admin','POST','http://www.xycmf.com/c-api/menu/detail','{\"menu_id\":\"24\"}','2018-12-26 17:19:36'),(59,1,'admin','POST','http://www.xycmf.com/c-api/menu/edit','{\"id\":\"24\",\"parentid\":\"23\",\"arrparentid\":\"0,22,23\",\"child\":\"0\",\"arrchildid\":\"24\",\"name\":\"\\u6dfb\\u52a0\\u680f\\u76ee\",\"url\":\"cate\\/create\",\"label\":\"cate-create\",\"icon\":null,\"display\":\"true\",\"sort\":\"0\",\"created_at\":\"2016-03-29 08:40:25\",\"updated_at\":\"2018-11-28 11:03:19\"}','2018-12-26 17:19:49'),(60,1,'admin','POST','http://www.xycmf.com/c-api/menu/detail','{\"menu_id\":\"25\"}','2018-12-26 17:19:50'),(61,1,'admin','POST','http://www.xycmf.com/c-api/menu/detail','{\"menu_id\":\"26\"}','2018-12-26 17:19:52'),(62,1,'admin','POST','http://www.xycmf.com/c-api/menu/edit','{\"id\":\"26\",\"parentid\":\"23\",\"arrparentid\":\"0,22,23\",\"child\":\"0\",\"arrchildid\":\"26\",\"name\":\"\\u5220\\u9664\\u680f\\u76ee\",\"url\":\"cate\\/remove\",\"label\":\"cate-remove\",\"icon\":null,\"display\":\"false\",\"sort\":\"0\",\"created_at\":\"2016-03-29 08:40:54\",\"updated_at\":\"2018-11-28 11:03:19\"}','2018-12-26 17:20:00'),(63,1,'admin','POST','http://www.xycmf.com/c-api/menu/remove','{\"menu_id\":\"27\"}','2018-12-26 17:20:04'),(64,1,'admin','POST','http://www.xycmf.com/c-api/menu/create','{\"id\":\"0\",\"parentid\":\"23\",\"name\":\"\\u67e5\\u770b\\u680f\\u76ee\",\"url\":\"cate\\/detail\",\"label\":\"cate-detail\",\"icon\":null,\"display\":\"false\",\"sort\":\"0\"}','2018-12-26 17:20:25'),(65,1,'admin','POST','http://www.xycmf.com/c-api/menu/create','{\"id\":\"0\",\"parentid\":\"23\",\"name\":\"\\u680f\\u76ee\\u4e0b\\u62c9\",\"url\":\"cate\\/select\",\"label\":\"cate-select\",\"icon\":null,\"display\":\"false\",\"sort\":\"0\"}','2018-12-26 17:20:43'),(66,1,'admin','POST','http://www.xycmf.com/c-api/menu/create','{\"id\":\"0\",\"parentid\":\"23\",\"name\":\"\\u680f\\u76ee\\u6392\\u5e8f\",\"url\":\"cate\\/sort\",\"label\":\"cate-sort\",\"icon\":null,\"display\":\"false\",\"sort\":\"0\"}','2018-12-26 17:21:05'),(67,1,'admin','POST','http://www.xycmf.com/c-api/menu/detail','{\"menu_id\":\"30\"}','2018-12-26 17:21:08'),(68,1,'admin','POST','http://www.xycmf.com/c-api/menu/edit','{\"id\":\"30\",\"parentid\":\"22\",\"arrparentid\":\"0,22\",\"child\":\"1\",\"arrchildid\":\"30,31,32,33,34,121,136,342\",\"name\":\"\\u6587\\u7ae0\\u7ba1\\u7406\",\"url\":\"article\\/list\",\"label\":\"article-list\",\"icon\":null,\"display\":\"true\",\"sort\":\"0\",\"created_at\":\"2016-03-31 08:25:22\",\"updated_at\":\"2018-11-28 11:03:19\"}','2018-12-26 17:21:23'),(69,1,'admin','POST','http://www.xycmf.com/c-api/menu/detail','{\"menu_id\":\"31\"}','2018-12-26 17:21:50'),(70,1,'admin','POST','http://www.xycmf.com/c-api/menu/edit','{\"id\":\"31\",\"parentid\":\"30\",\"arrparentid\":\"0,22,30\",\"child\":\"0\",\"arrchildid\":\"31\",\"name\":\"\\u6dfb\\u52a0\\u6587\\u7ae0\",\"url\":\"article\\/create\",\"label\":\"article-create\",\"icon\":null,\"display\":\"true\",\"sort\":\"0\",\"created_at\":\"2016-03-31 08:25:40\",\"updated_at\":\"2018-11-28 11:03:19\"}','2018-12-26 17:21:56'),(71,1,'admin','POST','http://www.xycmf.com/c-api/menu/detail','{\"menu_id\":\"32\"}','2018-12-26 17:22:14'),(72,1,'admin','POST','http://www.xycmf.com/c-api/menu/edit','{\"id\":\"32\",\"parentid\":\"30\",\"arrparentid\":\"0,22,30\",\"child\":\"0\",\"arrchildid\":\"32\",\"name\":\"\\u4fee\\u6539\\u6587\\u7ae0\",\"url\":\"article\\/edit\",\"label\":\"article-edit\",\"icon\":null,\"display\":\"false\",\"sort\":\"0\",\"created_at\":\"2016-03-31 08:25:59\",\"updated_at\":\"2018-11-28 11:03:19\"}','2018-12-26 17:22:19'),(73,1,'admin','POST','http://www.xycmf.com/c-api/menu/detail','{\"menu_id\":\"33\"}','2018-12-26 17:22:27'),(74,1,'admin','POST','http://www.xycmf.com/c-api/menu/detail','{\"menu_id\":\"32\"}','2018-12-26 17:22:34'),(75,1,'admin','POST','http://www.xycmf.com/c-api/menu/detail','{\"menu_id\":\"33\"}','2018-12-26 17:22:36'),(76,1,'admin','POST','http://www.xycmf.com/c-api/menu/edit','{\"id\":\"33\",\"parentid\":\"30\",\"arrparentid\":\"0,22,30\",\"child\":\"0\",\"arrchildid\":\"33\",\"name\":\"\\u5220\\u9664\\u6587\\u7ae0\",\"url\":\"article\\/detail\",\"label\":\"article-detail\",\"icon\":null,\"display\":\"false\",\"sort\":\"0\",\"created_at\":\"2016-03-31 08:26:15\",\"updated_at\":\"2018-11-28 11:03:19\"}','2018-12-26 17:22:40'),(77,1,'admin','POST','http://www.xycmf.com/c-api/menu/detail','{\"menu_id\":\"34\"}','2018-12-26 17:22:59'),(78,1,'admin','POST','http://www.xycmf.com/c-api/menu/detail','{\"menu_id\":\"33\"}','2018-12-26 17:23:01'),(79,1,'admin','POST','http://www.xycmf.com/c-api/menu/detail','{\"menu_id\":\"34\"}','2018-12-26 17:23:02'),(80,1,'admin','POST','http://www.xycmf.com/c-api/menu/edit','{\"id\":\"34\",\"parentid\":\"30\",\"arrparentid\":\"0,22,30\",\"child\":\"0\",\"arrchildid\":\"34\",\"name\":\"\\u67e5\\u770b\\u6587\\u7ae0\",\"url\":\"article\\/detail\",\"label\":\"article-detail\",\"icon\":null,\"display\":\"false\",\"sort\":\"0\",\"created_at\":\"2016-03-31 08:26:35\",\"updated_at\":\"2018-11-28 11:03:19\"}','2018-12-26 17:23:08'),(81,1,'admin','POST','http://www.xycmf.com/c-api/menu/detail','{\"menu_id\":\"33\"}','2018-12-26 17:23:16'),(82,1,'admin','POST','http://www.xycmf.com/c-api/menu/detail','{\"menu_id\":\"33\"}','2018-12-26 17:23:19'),(83,1,'admin','POST','http://www.xycmf.com/c-api/menu/detail','{\"menu_id\":\"34\"}','2018-12-26 17:23:20'),(84,1,'admin','POST','http://www.xycmf.com/c-api/menu/detail','{\"menu_id\":\"33\"}','2018-12-26 17:23:23'),(85,1,'admin','POST','http://www.xycmf.com/c-api/menu/edit','{\"id\":\"33\",\"parentid\":\"30\",\"arrparentid\":\"0,22,30\",\"child\":\"0\",\"arrchildid\":\"33\",\"name\":\"\\u5220\\u9664\\u6587\\u7ae0\",\"url\":\"article\\/remove\",\"label\":\"article-remove\",\"icon\":null,\"display\":\"false\",\"sort\":\"0\",\"created_at\":\"2016-03-31 08:26:15\",\"updated_at\":\"2018-12-26 17:22:40\"}','2018-12-26 17:23:30'),(86,1,'admin','POST','http://www.xycmf.com/c-api/menu/detail','{\"menu_id\":\"121\"}','2018-12-26 17:23:33'),(87,1,'admin','POST','http://www.xycmf.com/c-api/menu/edit','{\"id\":\"121\",\"parentid\":\"30\",\"arrparentid\":\"0,22,30\",\"child\":\"0\",\"arrchildid\":\"121\",\"name\":\"\\u6279\\u91cf\\u5220\\u9664\",\"url\":\"article\\/deleteall\",\"label\":\"article-deleteall\",\"icon\":null,\"display\":\"false\",\"sort\":\"0\",\"created_at\":\"2016-06-15 08:52:32\",\"updated_at\":\"2018-11-28 11:03:20\"}','2018-12-26 17:23:41'),(88,1,'admin','POST','http://www.xycmf.com/c-api/menu/detail','{\"menu_id\":\"136\"}','2018-12-26 17:24:11'),(89,1,'admin','POST','http://www.xycmf.com/c-api/menu/edit','{\"id\":\"136\",\"parentid\":\"30\",\"arrparentid\":\"0,22,30\",\"child\":\"0\",\"arrchildid\":\"136\",\"name\":\"\\u6587\\u7ae0\\u6392\\u5e8f\",\"url\":\"article\\/sort\",\"label\":\"article-sort\",\"icon\":null,\"display\":\"false\",\"sort\":\"0\",\"created_at\":\"2016-07-25 08:35:42\",\"updated_at\":\"2018-11-28 11:03:20\"}','2018-12-26 17:24:24'),(90,1,'admin','POST','http://www.xycmf.com/c-api/menu/detail','{\"menu_id\":\"342\"}','2018-12-26 17:24:28'),(91,1,'admin','POST','http://www.xycmf.com/c-api/menu/remove','{\"menu_id\":\"342\"}','2018-12-26 17:24:32'),(92,1,'admin','POST','http://www.xycmf.com/c-api/role/priv','{\"role_id\":\"3\",\"menu_id\":[\"22\",\"23\",\"24\",\"25\",\"26\",\"361\",\"362\",\"363\",\"30\",\"31\",\"32\",\"33\",\"34\",\"121\",\"136\",\"242\",\"243\",\"244\",\"245\",\"246\",\"247\",\"300\",\"301\",\"302\",\"303\",\"28\",\"75\",\"20\",\"21\",\"353\"]}','2018-12-26 17:24:50'),(93,1,'admin','POST','http://www.xycmf.com/c-api/menu/detail','{\"menu_id\":\"6\"}','2018-12-26 17:28:06'),(94,1,'admin','POST','http://www.xycmf.com/c-api/menu/detail','{\"menu_id\":\"7\"}','2018-12-26 17:28:15'),(95,1,'admin','POST','http://www.xycmf.com/c-api/menu/detail','{\"menu_id\":\"6\"}','2018-12-26 17:28:50'),(96,1,'admin','POST','http://www.xycmf.com/c-api/menu/detail','{\"menu_id\":\"7\"}','2018-12-26 17:28:53'),(97,1,'admin','POST','http://www.xycmf.com/c-api/menu/detail','{\"menu_id\":\"8\"}','2018-12-26 17:29:00'),(98,1,'admin','POST','http://www.xycmf.com/c-api/menu/detail','{\"menu_id\":\"9\"}','2018-12-26 17:29:02'),(99,1,'admin','POST','http://www.xycmf.com/c-api/menu/detail','{\"menu_id\":\"354\"}','2018-12-26 17:29:04'),(100,1,'admin','POST','http://www.xycmf.com/c-api/menu/detail','{\"menu_id\":\"355\"}','2018-12-26 17:29:08'),(101,1,'admin','POST','http://www.xycmf.com/c-api/menu/detail','{\"menu_id\":\"20\"}','2018-12-26 17:29:21'),(102,1,'admin','POST','http://www.xycmf.com/c-api/menu/detail','{\"menu_id\":\"21\"}','2018-12-26 17:29:22'),(103,1,'admin','POST','http://www.xycmf.com/c-api/menu/detail','{\"menu_id\":\"353\"}','2018-12-26 17:29:43'),(104,1,'admin','POST','http://www.xycmf.com/c-api/menu/detail','{\"menu_id\":\"21\"}','2018-12-26 17:29:45'),(105,1,'admin','POST','http://www.xycmf.com/c-api/menu/detail','{\"menu_id\":\"143\"}','2018-12-26 17:29:47'),(106,1,'admin','POST','http://www.xycmf.com/c-api/menu/edit','{\"id\":\"143\",\"arrparentid\":\"0\",\"child\":\"1\",\"arrchildid\":\"143,144,145\",\"name\":\"\\u8d44\\u6599\",\"url\":\"admin\\/selfeditinfo\",\"label\":\"admin-selfeditinfo\",\"icon\":\"ios-outlet-outline\",\"display\":\"true\",\"sort\":\"99\",\"created_at\":\"2016-07-28 14:01:45\",\"updated_at\":\"2018-12-08 13:42:11\"}','2018-12-26 17:30:00'),(107,1,'admin','POST','http://www.xycmf.com/c-api/menu/detail','{\"menu_id\":\"144\"}','2018-12-26 17:30:06'),(108,1,'admin','POST','http://www.xycmf.com/c-api/menu/edit','{\"id\":\"144\",\"parentid\":\"143\",\"arrparentid\":\"0,143\",\"child\":\"0\",\"arrchildid\":\"144\",\"name\":\"\\u4fee\\u6539\\u4e2a\\u4eba\\u8d44\\u6599\",\"url\":\"admin\\/selfeditinfo\",\"label\":\"admin-selfeditinfo\",\"icon\":null,\"display\":\"true\",\"sort\":\"0\",\"created_at\":\"2016-07-28 14:02:12\",\"updated_at\":\"2018-12-08 13:37:58\"}','2018-12-26 17:30:10'),(109,1,'admin','POST','http://www.xycmf.com/c-api/menu/detail','{\"menu_id\":\"145\"}','2018-12-26 17:30:13'),(110,1,'admin','POST','http://www.xycmf.com/c-api/menu/edit','{\"id\":\"145\",\"parentid\":\"143\",\"arrparentid\":\"0,143\",\"child\":\"0\",\"arrchildid\":\"145\",\"name\":\"\\u4fee\\u6539\\u4e2a\\u4eba\\u5bc6\\u7801\",\"url\":\"admin\\/selfeditpassword\",\"label\":\"admin-selfeditpassword\",\"icon\":null,\"display\":\"true\",\"sort\":\"0\",\"created_at\":\"2016-07-28 14:02:37\",\"updated_at\":\"2018-12-08 13:38:11\"}','2018-12-26 17:30:21'),(111,1,'admin','POST','http://www.xycmf.com/c-api/menu/detail','{\"menu_id\":\"30\"}','2018-12-26 17:30:33'),(112,2,'admin22','POST','http://www.xycmf.com/c-api/section/status','{\"section_id\":\"1\",\"status\":\"false\"}','2018-12-26 17:30:59'),(113,2,'admin22','POST','http://www.xycmf.com/c-api/section/status','{\"section_id\":\"1\",\"status\":\"true\"}','2018-12-26 17:31:00'),(114,2,'admin22','POST','http://www.xycmf.com/c-api/menu/detail','{\"menu_id\":\"32\"}','2018-12-26 17:35:16'),(115,2,'admin22','POST','http://www.xycmf.com/c-api/menu/detail','{\"menu_id\":\"361\"}','2018-12-26 17:35:53');

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
) ENGINE=InnoDB AUTO_INCREMENT=364 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `menus` */

insert  into `menus`(`id`,`parentid`,`arrparentid`,`child`,`arrchildid`,`name`,`url`,`label`,`icon`,`display`,`sort`,`created_at`,`updated_at`) values (5,0,'0',1,'5,151,152,153,154,360,205','系统设置','sys/index','sys-index','ios-cog-outline',1,98,'2016-03-18 15:47:40','2018-12-09 11:04:37'),(6,10,'0,10',1,'6,7,8,9,354,355','权限菜单管理','menu/tree','menu-tree',NULL,1,1,'2016-03-18 15:48:07','2018-12-08 08:49:46'),(7,6,'0,10,6',0,'7','添加菜单','menu/create','menu-create',NULL,0,0,'2016-03-18 15:49:03','2018-12-08 14:28:09'),(8,6,'0,10,6',0,'8','修改菜单','menu/edit','menu-edit',NULL,0,0,'2016-03-18 15:51:08','2018-12-07 11:38:27'),(9,6,'0,10,6',0,'9','删除菜单','menu/remove','menu-remove',NULL,0,0,'2016-03-18 15:51:30','2018-12-08 14:28:18'),(10,0,'0',1,'10,6,7,8,9,354,355,11,12,13,14,15,358,359,16,17,18,19,140,357,67,68,170,171,172,173,356','管理员管理','admin/manage','admin-manage','ios-people-outline',1,97,'2016-03-18 16:04:01','2018-12-09 11:19:02'),(11,10,'0,10',1,'11,12,13,14,15,358,359','用户管理','admin/list','admin-list',NULL,1,0,'2016-03-18 16:04:38','2018-12-08 08:57:59'),(12,11,'0,10,11',0,'12','添加用户','admin/create','admin-create',NULL,0,0,'2016-03-18 16:05:14','2018-12-08 14:26:29'),(13,11,'0,10,11',0,'13','修改用户','admin/editinfo','admin-editinfo',NULL,0,0,'2016-03-18 16:06:10','2018-12-08 14:26:39'),(14,11,'0,10,11',0,'14','删除用户','admin/remove','admin-remove',NULL,0,0,'2016-03-18 16:06:31','2018-12-08 14:26:43'),(15,11,'0,10,11',0,'15','修改密码','admin/editpassword','admin-editpassword',NULL,0,0,'2016-03-18 16:07:07','2018-12-08 14:26:48'),(16,10,'0,10',1,'16,17,18,19,140,357','角色管理','role/list','role-list',NULL,1,0,'2016-03-18 16:07:58','2018-12-09 11:15:46'),(17,16,'0,10,16',0,'17','添加角色','role/create','role-create',NULL,0,0,'2016-03-18 16:08:23','2018-12-08 14:27:00'),(18,16,'0,10,16',0,'18','修改角色','role/edit','role-edit',NULL,0,0,'2016-03-18 16:08:50','2018-11-28 11:04:21'),(19,16,'0,10,16',0,'19','删除角色','role/remove','role-remove',NULL,0,0,'2016-03-18 16:09:10','2018-12-08 14:27:13'),(20,0,'0',1,'20,21,353','所有人都要有的权限','index/main','index-main',NULL,0,99,'2016-03-24 15:42:14','2018-12-08 08:41:54'),(21,20,'0,20',0,'21','左侧菜单','menu/list','menu-list',NULL,1,0,'2016-03-25 10:34:44','2018-12-08 08:43:33'),(22,0,'0',1,'22,23,24,25,26,361,362,363,28,75,30,31,32,33,34,121,136,242,243,244,245,246,247,300,301,302,303','内容管理','content/manage','content-manage','ios-basketball-outline',1,0,'2016-03-29 08:39:52','2018-12-26 17:24:32'),(23,22,'0,22',1,'23,24,25,26,361,362,363','栏目管理','cate/list','cate-list',NULL,1,0,'2016-03-29 08:40:08','2018-12-26 17:21:05'),(24,23,'0,22,23',0,'24','添加栏目','cate/create','cate-create',NULL,1,0,'2016-03-29 08:40:25','2018-12-26 17:19:49'),(25,23,'0,22,23',0,'25','修改栏目','cate/edit','cate-edit',NULL,0,0,'2016-03-29 08:40:42','2018-11-28 11:03:19'),(26,23,'0,22,23',0,'26','删除栏目','cate/remove','cate-remove',NULL,0,0,'2016-03-29 08:40:54','2018-12-26 17:20:00'),(28,22,'0,22',1,'28,75','附件管理','attr/index','attr-index',NULL,0,5,'2016-03-31 08:23:28','2018-12-26 09:30:05'),(30,22,'0,22',1,'30,31,32,33,34,121,136','文章管理','article/list','article-list',NULL,1,0,'2016-03-31 08:25:22','2018-12-26 17:24:32'),(31,30,'0,22,30',0,'31','添加文章','article/create','article-create',NULL,1,0,'2016-03-31 08:25:40','2018-12-26 17:21:56'),(32,30,'0,22,30',0,'32','修改文章','article/edit','article-edit',NULL,0,0,'2016-03-31 08:25:59','2018-12-26 17:22:19'),(33,30,'0,22,30',0,'33','删除文章','article/remove','article-remove',NULL,0,0,'2016-03-31 08:26:15','2018-12-26 17:23:30'),(34,30,'0,22,30',0,'34','查看文章','article/detail','article-detail',NULL,0,0,'2016-03-31 08:26:35','2018-12-26 17:23:08'),(67,10,'0,10',1,'67,68','操作日志','log/list','log-list',NULL,1,4,'2016-04-11 10:38:34','2018-12-09 11:19:15'),(68,67,'0,10,67',0,'68','清除7天前日志','log/clear','log-clear',NULL,0,0,'2016-04-11 10:38:53','2018-12-09 11:13:00'),(75,28,'0,22,28',0,'75','删除附件','attr/delfile','attr-delfile',NULL,0,0,'2016-05-09 19:29:09','2018-12-08 11:45:02'),(121,30,'0,22,30',0,'121','批量删除','article/deleteall','article-deleteall',NULL,0,0,'2016-06-15 08:52:32','2018-12-26 17:23:41'),(136,30,'0,22,30',0,'136','文章排序','article/sort','article-sort',NULL,0,0,'2016-07-25 08:35:42','2018-12-26 17:24:24'),(140,16,'0,10,16',0,'140','角色权限','role/priv','role-priv',NULL,0,0,'2016-07-25 11:34:39','2018-11-28 11:04:21'),(143,0,'0',1,'143,144,145','资料','admin/info','admin-info','ios-outlet-outline',1,99,'2016-07-28 14:01:45','2018-12-08 13:42:11'),(144,143,'0,143',0,'144','修改个人资料','admin/selfeditinfo','admin-selfeditinfo',NULL,1,0,'2016-07-28 14:02:12','2018-12-26 17:30:10'),(145,143,'0,143',0,'145','修改个人密码','admin/selfeditpassword','admin-selfeditpassword',NULL,1,0,'2016-07-28 14:02:37','2018-12-26 17:30:21'),(151,5,'0,5',1,'151,152,153,154,360','分类管理','type/list','type-list',NULL,1,2,'2016-12-14 09:56:01','2018-12-09 11:16:37'),(152,151,'0,5,151',0,'152','添加分类','type/create','type-create',NULL,0,0,'2016-12-14 09:56:23','2018-12-09 11:04:02'),(153,151,'0,5,151',0,'153','修改分类','type/edit','type-edit',NULL,0,0,'2016-12-14 09:56:42','2018-12-08 08:39:14'),(154,151,'0,5,151',0,'154','删除分类','type/remove','type-remove',NULL,0,0,'2016-12-14 09:56:57','2018-12-09 11:04:19'),(170,10,'0,10',1,'170,171,172,173,356','部门管理','section/list','section-list',NULL,1,0,'2016-12-15 08:31:39','2018-12-08 08:52:03'),(171,170,'0,10,170',0,'171','添加部门','section/create','section-create',NULL,0,0,'2016-12-15 08:32:01','2018-12-08 14:27:39'),(172,170,'0,10,170',0,'172','修改部门','section/edit','section-edit',NULL,0,0,'2016-12-15 08:32:23','2018-11-28 11:04:22'),(173,170,'0,10,170',0,'173','删除部门','section/remove','section-remove',NULL,0,0,'2016-12-15 08:32:44','2018-12-08 14:27:53'),(194,0,'0',1,'194,195,196,197,198,199,200,201','会员管理','user/manage','user-manage','ios-person-outline',0,0,'2017-03-17 08:30:28','2018-12-26 09:28:52'),(195,194,'0,194',1,'195,196,197,198','会员组','group/index','group-index',NULL,1,0,'2017-03-17 08:30:46','2018-11-28 11:03:31'),(196,195,'0,194,195',0,'196','添加会员组','group/add','group-add',NULL,1,0,'2017-03-17 08:31:05','2018-11-28 11:03:31'),(197,195,'0,194,195',0,'197','修改会员组','group/edit','group-edit',NULL,0,0,'2017-03-17 08:31:25','2018-11-28 11:03:31'),(198,195,'0,194,195',0,'198','删除会员组','group/del','group-del',NULL,0,0,'2017-03-17 08:31:40','2018-11-28 11:03:31'),(199,194,'0,194',1,'199,200,201','会员列表','user/index','user-index',NULL,1,0,'2017-03-17 08:33:22','2018-11-28 11:03:31'),(200,199,'0,194,199',0,'200','禁用会员','user/status','user-status',NULL,0,0,'2017-03-17 08:34:25','2018-11-28 11:03:31'),(201,199,'0,194,199',0,'201','修改会员','user/edit','user/edit',NULL,0,0,'2017-03-17 08:34:46','2018-11-28 11:03:31'),(205,5,'0,5',0,'205','系统配置','config/index','config-index','icon-brightnesshigh',1,0,'2017-04-25 21:49:13','2018-12-08 08:37:42'),(242,22,'0,22',1,'242,243,244,245,246,247','广告管理','ad/index','ad-index',NULL,0,0,'2017-05-16 06:34:07','2018-12-26 09:29:56'),(243,242,'0,22,242',0,'243','添加广告','ad/add','ad-add',NULL,1,0,'2017-05-16 06:34:25','2018-11-28 11:03:20'),(244,242,'0,22,242',0,'244','修改广告','ad/edit','ad-edit',NULL,0,0,'2017-05-16 06:34:40','2018-11-28 11:03:20'),(245,242,'0,22,242',0,'245','删除广告','ad/del','ad-del',NULL,0,0,'2017-05-16 06:34:55','2018-11-28 11:03:20'),(246,242,'0,22,242',0,'246','广告排序','ad/sort','ad-sort',NULL,0,0,'2017-05-16 06:35:11','2018-11-28 11:03:20'),(247,242,'0,22,242',0,'247','批量删除广告','ad/alldel','ad-alldel',NULL,0,0,'2017-05-16 06:35:35','2018-11-28 11:03:20'),(300,22,'0,22',1,'300,301,302,303','广告位管理','adpos/index','adpos-index','icon-slideshow',0,0,'2017-07-01 09:19:12','2018-12-26 09:30:01'),(301,300,'0,22,300',0,'301','添加广告位','adpos/add','adpos-add',NULL,1,0,'2017-07-01 09:19:37','2018-11-28 11:03:20'),(302,300,'0,22,300',0,'302','修改广告位','adpos/edit','adpos-edit',NULL,0,0,'2017-07-01 09:19:59','2018-11-28 11:03:20'),(303,300,'0,22,300',0,'303','删除广告位','adpos/del','adpos-del',NULL,0,0,'2017-07-01 09:20:21','2018-11-28 11:03:21'),(353,20,'0,20',0,'353','面包屑','breadcrumb/list','breadcrumb-list',NULL,1,0,'2018-12-08 08:41:35','2018-12-08 08:41:54'),(354,6,'0,10,6',0,'354','权限菜单下拉选框','menu/select','menu-select',NULL,0,0,'2018-12-08 08:44:56','2018-12-08 14:28:27'),(355,6,'0,10,6',0,'355','查询权限菜单','menu/detail','menu-detail',NULL,0,0,'2018-12-08 08:49:46','2018-12-08 08:49:46'),(356,170,'0,10,170',0,'356','修改部门状态','section/status','section-status',NULL,0,0,'2018-12-08 08:52:03','2018-12-08 14:28:00'),(357,16,'0,10,16',0,'357','修改角色状态','role/status','role-status',NULL,0,0,'2018-12-08 08:53:26','2018-12-08 14:27:25'),(358,11,'0,10,11',0,'358','修改用户状态','admin/status','admin-status',NULL,0,0,'2018-12-08 08:57:40','2018-12-08 14:26:52'),(359,11,'0,10,11',0,'359','查看用户信息','admin/detail','admin-detail',NULL,0,0,'2018-12-08 08:57:59','2018-12-08 14:26:56'),(360,151,'0,5,151',0,'360','分类排序','type/sort','type-sort',NULL,0,0,'2018-12-09 11:04:37','2018-12-09 11:04:37'),(361,23,'0,22,23',0,'361','查看栏目','cate/detail','cate-detail',NULL,0,0,'2018-12-26 17:20:25','2018-12-26 17:20:25'),(362,23,'0,22,23',0,'362','栏目下拉','cate/select','cate-select',NULL,0,0,'2018-12-26 17:20:43','2018-12-26 17:20:43'),(363,23,'0,22,23',0,'363','栏目排序','cate/sort','cate-sort',NULL,0,0,'2018-12-26 17:21:05','2018-12-26 17:21:05');

/*Table structure for table `migrations` */

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `migrations` */

insert  into `migrations`(`id`,`migration`,`batch`) values (11,'2018_10_24_054742_create_models',1),(12,'2018_10_24_054852_create_model_fields',1),(13,'2018_10_25_172249_add_display_required_to_model_fields',2);

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
) ENGINE=InnoDB AUTO_INCREMENT=261 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `role_privs` */

insert  into `role_privs`(`id`,`menu_id`,`role_id`,`url`,`label`,`created_at`,`updated_at`) values (106,22,1,'content/manage','content-manage','2018-12-06 11:35:57','2018-12-06 11:35:57'),(107,23,1,'cate/index','cate-index','2018-12-06 11:35:57','2018-12-06 11:35:57'),(108,24,1,'cate/add','cate-add','2018-12-06 11:35:57','2018-12-06 11:35:57'),(109,25,1,'cate/edit','cate-edit','2018-12-06 11:35:57','2018-12-06 11:35:57'),(110,26,1,'cate/del','cate-del','2018-12-06 11:35:57','2018-12-06 11:35:57'),(111,27,1,'cate/cache','cate-cache','2018-12-06 11:35:57','2018-12-06 11:35:57'),(112,28,1,'attr/index','attr-index','2018-12-06 11:35:57','2018-12-06 11:35:57'),(113,30,1,'art/index','art-index','2018-12-06 11:35:57','2018-12-06 11:35:57'),(114,31,1,'art/add','art-add','2018-12-06 11:35:57','2018-12-06 11:35:57'),(115,32,1,'art/edit','art-edit','2018-12-06 11:35:57','2018-12-06 11:35:57'),(116,33,1,'art/del','art-del','2018-12-06 11:35:57','2018-12-06 11:35:57'),(117,34,1,'art/show','art-show','2018-12-06 11:35:57','2018-12-06 11:35:57'),(118,75,1,'attr/delfile','attr-delfile','2018-12-06 11:35:57','2018-12-06 11:35:57'),(119,121,1,'art/alldel','art-alldel','2018-12-06 11:35:57','2018-12-06 11:35:57'),(120,136,1,'art/listorder','art-listorder','2018-12-06 11:35:57','2018-12-06 11:35:57'),(121,151,1,'type/index','type-index','2018-12-06 11:35:57','2018-12-06 11:35:57'),(122,152,1,'type/add','type-add','2018-12-06 11:35:57','2018-12-06 11:35:57'),(123,153,1,'type/edit','type-edit','2018-12-06 11:35:57','2018-12-06 11:35:57'),(124,154,1,'type/del','type-del','2018-12-06 11:35:57','2018-12-06 11:35:57'),(125,194,1,'user/manage','user-manage','2018-12-06 11:35:57','2018-12-06 11:35:57'),(126,195,1,'group/index','group-index','2018-12-06 11:35:57','2018-12-06 11:35:57'),(127,196,1,'group/add','group-add','2018-12-06 11:35:57','2018-12-06 11:35:57'),(128,197,1,'group/edit','group-edit','2018-12-06 11:35:57','2018-12-06 11:35:57'),(129,198,1,'group/del','group-del','2018-12-06 11:35:57','2018-12-06 11:35:57'),(130,199,1,'user/index','user-index','2018-12-06 11:35:57','2018-12-06 11:35:57'),(131,200,1,'user/status','user-status','2018-12-06 11:35:57','2018-12-06 11:35:57'),(132,201,1,'user/edit','user/edit','2018-12-06 11:35:57','2018-12-06 11:35:57'),(133,242,1,'ad/index','ad-index','2018-12-06 11:35:57','2018-12-06 11:35:57'),(134,243,1,'ad/add','ad-add','2018-12-06 11:35:57','2018-12-06 11:35:57'),(135,244,1,'ad/edit','ad-edit','2018-12-06 11:35:57','2018-12-06 11:35:57'),(136,245,1,'ad/del','ad-del','2018-12-06 11:35:57','2018-12-06 11:35:57'),(137,246,1,'ad/sort','ad-sort','2018-12-06 11:35:57','2018-12-06 11:35:57'),(138,247,1,'ad/alldel','ad-alldel','2018-12-06 11:35:57','2018-12-06 11:35:57'),(139,300,1,'adpos/index','adpos-index','2018-12-06 11:35:57','2018-12-06 11:35:57'),(140,301,1,'adpos/add','adpos-add','2018-12-06 11:35:57','2018-12-06 11:35:57'),(141,302,1,'adpos/edit','adpos-edit','2018-12-06 11:35:57','2018-12-06 11:35:57'),(142,303,1,'adpos/del','adpos-del','2018-12-06 11:35:57','2018-12-06 11:35:57'),(143,342,1,'art/select','art-select','2018-12-06 11:35:57','2018-12-06 11:35:57'),(144,343,1,'model/index','model-index','2018-12-06 11:35:57','2018-12-06 11:35:57'),(145,344,1,'model/add','model-add','2018-12-06 11:35:57','2018-12-06 11:35:57'),(146,345,1,'model/edit','model-edit','2018-12-06 11:35:57','2018-12-06 11:35:57'),(147,346,1,'model/del','model-del','2018-12-06 11:35:57','2018-12-06 11:35:57'),(148,347,1,'field/index','field-index','2018-12-06 11:35:57','2018-12-06 11:35:57'),(149,348,1,'field/add','field-add','2018-12-06 11:35:57','2018-12-06 11:35:57'),(150,349,1,'field/edit','field-edit','2018-12-06 11:35:57','2018-12-06 11:35:57'),(151,350,1,'field/del','field-del','2018-12-06 11:35:57','2018-12-06 11:35:57'),(152,351,1,'model/view','model-view','2018-12-06 11:35:57','2018-12-06 11:35:57'),(193,6,4,'menu/tree','menu-tree','2018-12-26 17:17:17','2018-12-26 17:17:17'),(194,7,4,'menu/create','menu-create','2018-12-26 17:17:17','2018-12-26 17:17:17'),(195,8,4,'menu/edit','menu-edit','2018-12-26 17:17:17','2018-12-26 17:17:17'),(196,9,4,'menu/remove','menu-remove','2018-12-26 17:17:17','2018-12-26 17:17:17'),(197,10,4,'admin/manage','admin-manage','2018-12-26 17:17:17','2018-12-26 17:17:17'),(198,11,4,'admin/list','admin-list','2018-12-26 17:17:17','2018-12-26 17:17:17'),(199,12,4,'admin/create','admin-create','2018-12-26 17:17:17','2018-12-26 17:17:17'),(200,13,4,'admin/editinfo','admin-editinfo','2018-12-26 17:17:17','2018-12-26 17:17:17'),(201,14,4,'admin/remove','admin-remove','2018-12-26 17:17:17','2018-12-26 17:17:17'),(202,15,4,'admin/editpassword','admin-editpassword','2018-12-26 17:17:17','2018-12-26 17:17:17'),(203,16,4,'role/list','role-list','2018-12-26 17:17:17','2018-12-26 17:17:17'),(204,17,4,'role/create','role-create','2018-12-26 17:17:17','2018-12-26 17:17:17'),(205,18,4,'role/edit','role-edit','2018-12-26 17:17:17','2018-12-26 17:17:17'),(206,19,4,'role/remove','role-remove','2018-12-26 17:17:17','2018-12-26 17:17:17'),(207,20,4,'index/main','index-main','2018-12-26 17:17:17','2018-12-26 17:17:17'),(208,21,4,'menu/list','menu-list','2018-12-26 17:17:17','2018-12-26 17:17:17'),(209,67,4,'log/list','log-list','2018-12-26 17:17:17','2018-12-26 17:17:17'),(210,68,4,'log/clear','log-clear','2018-12-26 17:17:17','2018-12-26 17:17:17'),(211,140,4,'role/priv','role-priv','2018-12-26 17:17:17','2018-12-26 17:17:17'),(212,170,4,'section/list','section-list','2018-12-26 17:17:17','2018-12-26 17:17:17'),(213,171,4,'section/create','section-create','2018-12-26 17:17:17','2018-12-26 17:17:17'),(214,172,4,'section/edit','section-edit','2018-12-26 17:17:17','2018-12-26 17:17:17'),(215,173,4,'section/remove','section-remove','2018-12-26 17:17:17','2018-12-26 17:17:17'),(216,194,4,'user/manage','user-manage','2018-12-26 17:17:17','2018-12-26 17:17:17'),(217,195,4,'group/index','group-index','2018-12-26 17:17:17','2018-12-26 17:17:17'),(218,196,4,'group/add','group-add','2018-12-26 17:17:17','2018-12-26 17:17:17'),(219,197,4,'group/edit','group-edit','2018-12-26 17:17:17','2018-12-26 17:17:17'),(220,198,4,'group/del','group-del','2018-12-26 17:17:17','2018-12-26 17:17:17'),(221,199,4,'user/index','user-index','2018-12-26 17:17:17','2018-12-26 17:17:17'),(222,200,4,'user/status','user-status','2018-12-26 17:17:17','2018-12-26 17:17:17'),(223,201,4,'user/edit','user/edit','2018-12-26 17:17:17','2018-12-26 17:17:17'),(224,353,4,'breadcrumb/list','breadcrumb-list','2018-12-26 17:17:17','2018-12-26 17:17:17'),(225,354,4,'menu/select','menu-select','2018-12-26 17:17:17','2018-12-26 17:17:17'),(226,355,4,'menu/detail','menu-detail','2018-12-26 17:17:17','2018-12-26 17:17:17'),(227,356,4,'section/status','section-status','2018-12-26 17:17:17','2018-12-26 17:17:17'),(228,357,4,'role/status','role-status','2018-12-26 17:17:17','2018-12-26 17:17:17'),(229,358,4,'admin/status','admin-status','2018-12-26 17:17:17','2018-12-26 17:17:17'),(230,359,4,'admin/detail','admin-detail','2018-12-26 17:17:17','2018-12-26 17:17:17'),(231,20,3,'index/main','index-main','2018-12-26 17:24:50','2018-12-26 17:24:50'),(232,21,3,'menu/list','menu-list','2018-12-26 17:24:50','2018-12-26 17:24:50'),(233,22,3,'content/manage','content-manage','2018-12-26 17:24:50','2018-12-26 17:24:50'),(234,23,3,'cate/list','cate-list','2018-12-26 17:24:50','2018-12-26 17:24:50'),(235,24,3,'cate/create','cate-create','2018-12-26 17:24:50','2018-12-26 17:24:50'),(236,25,3,'cate/edit','cate-edit','2018-12-26 17:24:50','2018-12-26 17:24:50'),(237,26,3,'cate/remove','cate-remove','2018-12-26 17:24:50','2018-12-26 17:24:50'),(238,28,3,'attr/index','attr-index','2018-12-26 17:24:50','2018-12-26 17:24:50'),(239,30,3,'article/list','article-list','2018-12-26 17:24:50','2018-12-26 17:24:50'),(240,31,3,'article/create','article-create','2018-12-26 17:24:50','2018-12-26 17:24:50'),(241,32,3,'article/edit','article-edit','2018-12-26 17:24:50','2018-12-26 17:24:50'),(242,33,3,'article/remove','article-remove','2018-12-26 17:24:50','2018-12-26 17:24:50'),(243,34,3,'article/detail','article-detail','2018-12-26 17:24:50','2018-12-26 17:24:50'),(244,75,3,'attr/delfile','attr-delfile','2018-12-26 17:24:50','2018-12-26 17:24:50'),(245,121,3,'article/deleteall','article-deleteall','2018-12-26 17:24:50','2018-12-26 17:24:50'),(246,136,3,'article/sort','article-sort','2018-12-26 17:24:50','2018-12-26 17:24:50'),(247,242,3,'ad/index','ad-index','2018-12-26 17:24:50','2018-12-26 17:24:50'),(248,243,3,'ad/add','ad-add','2018-12-26 17:24:50','2018-12-26 17:24:50'),(249,244,3,'ad/edit','ad-edit','2018-12-26 17:24:50','2018-12-26 17:24:50'),(250,245,3,'ad/del','ad-del','2018-12-26 17:24:50','2018-12-26 17:24:50'),(251,246,3,'ad/sort','ad-sort','2018-12-26 17:24:50','2018-12-26 17:24:50'),(252,247,3,'ad/alldel','ad-alldel','2018-12-26 17:24:50','2018-12-26 17:24:50'),(253,300,3,'adpos/index','adpos-index','2018-12-26 17:24:50','2018-12-26 17:24:50'),(254,301,3,'adpos/add','adpos-add','2018-12-26 17:24:50','2018-12-26 17:24:50'),(255,302,3,'adpos/edit','adpos-edit','2018-12-26 17:24:50','2018-12-26 17:24:50'),(256,303,3,'adpos/del','adpos-del','2018-12-26 17:24:50','2018-12-26 17:24:50'),(257,353,3,'breadcrumb/list','breadcrumb-list','2018-12-26 17:24:50','2018-12-26 17:24:50'),(258,361,3,'cate/detail','cate-detail','2018-12-26 17:24:50','2018-12-26 17:24:50'),(259,362,3,'cate/select','cate-select','2018-12-26 17:24:50','2018-12-26 17:24:50'),(260,363,3,'cate/sort','cate-sort','2018-12-26 17:24:50','2018-12-26 17:24:50');

/*Table structure for table `role_users` */

DROP TABLE IF EXISTS `role_users`;

CREATE TABLE `role_users` (
  `role_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `role_users` */

insert  into `role_users`(`role_id`,`user_id`) values (1,1),(3,2),(4,2);

/*Table structure for table `roles` */

DROP TABLE IF EXISTS `roles`;

CREATE TABLE `roles` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `roles` */

insert  into `roles`(`id`,`name`,`status`,`created_at`,`updated_at`) values (1,'超级管理员',1,'2016-03-18 16:42:51','2018-12-06 10:03:36'),(3,'三个d',1,'2018-12-04 20:40:12','2018-12-04 20:46:12'),(4,'sd',1,'2018-12-06 11:34:22','2018-12-06 11:34:22'),(5,'dd',1,'2018-12-06 11:34:50','2018-12-06 11:34:50'),(6,'111',1,'2018-12-06 11:35:09','2018-12-06 11:58:19');

/*Table structure for table `sections` */

DROP TABLE IF EXISTS `sections`;

CREATE TABLE `sections` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `sections` */

insert  into `sections`(`id`,`name`,`status`,`created_at`,`updated_at`) values (1,'市场',1,'2016-12-15 08:43:05','2018-12-26 17:31:00'),(2,'开发',1,'2018-12-04 20:24:30','2018-12-04 20:26:07');

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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

/*Data for the table `types` */

insert  into `types`(`id`,`parentid`,`arrparentid`,`child`,`arrchildid`,`name`,`sort`,`created_at`,`updated_at`) values (1,0,'0',1,'1,2','联动一个',0,'2018-10-26 10:05:04','2018-10-26 10:05:13'),(2,1,'0,1',0,'2','中国',0,'2018-10-26 10:05:12','2018-10-26 10:05:13'),(5,4,'0',1,'5,6','444',0,'2018-12-09 10:24:48','2018-12-09 10:57:53'),(6,5,'0',0,'6','555',2,'2018-12-09 10:24:54','2018-12-09 10:57:53');

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
