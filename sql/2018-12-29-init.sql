/*
SQLyog Ultimate v12.09 (64 bit)
MySQL - 5.7.17-log : Database - coincmf
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

/*Data for the table `areas` */

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

/*Data for the table `communitys` */

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
) ENGINE=InnoDB AUTO_INCREMENT=603 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `logs` */

insert  into `logs`(`id`,`admin_id`,`user`,`method`,`url`,`data`,`created_at`) values (299,1,'admin','GET','http://www.xycmf.com/console/index/index','[]','2018-12-29 16:03:36'),(300,1,'admin','GET','http://www.xycmf.com/console/index/main','[]','2018-12-29 16:03:36'),(301,1,'admin','GET','http://www.xycmf.com/console/index/left/2','[]','2018-12-29 16:03:37'),(302,1,'admin','GET','http://www.xycmf.com/console/model/index','[]','2018-12-29 16:03:40'),(303,1,'admin','GET','http://www.xycmf.com/console/index/index','[]','2018-12-29 16:04:46'),(304,1,'admin','GET','http://www.xycmf.com/console/index/main','[]','2018-12-29 16:04:47'),(305,1,'admin','GET','http://www.xycmf.com/console/index/left/2','[]','2018-12-29 16:04:47'),(306,1,'admin','GET','http://www.xycmf.com/console/index/index','[]','2018-12-29 16:04:48'),(307,1,'admin','GET','http://www.xycmf.com/console/index/main','[]','2018-12-29 16:04:48'),(308,1,'admin','GET','http://www.xycmf.com/console/index/left/2','[]','2018-12-29 16:04:49'),(309,1,'admin','GET','http://www.xycmf.com/console/index/index','[]','2018-12-29 16:04:53'),(310,1,'admin','GET','http://www.xycmf.com/console/index/main','[]','2018-12-29 16:04:54'),(311,1,'admin','GET','http://www.xycmf.com/console/index/left/2','[]','2018-12-29 16:04:54'),(312,1,'admin','GET','http://www.xycmf.com/console/index/index','[]','2018-12-29 16:06:42'),(313,1,'admin','GET','http://www.xycmf.com/console/index/main','[]','2018-12-29 16:06:42'),(314,1,'admin','GET','http://www.xycmf.com/console/index/left/2','[]','2018-12-29 16:06:43'),(315,1,'admin','GET','http://www.xycmf.com/console/index/index','[]','2018-12-29 16:06:45'),(316,1,'admin','GET','http://www.xycmf.com/console/index/main','[]','2018-12-29 16:06:45'),(317,1,'admin','GET','http://www.xycmf.com/console/index/left/2','[]','2018-12-29 16:06:45'),(318,1,'admin','GET','http://www.xycmf.com/console/index/index','[]','2018-12-29 16:06:46'),(319,1,'admin','GET','http://www.xycmf.com/console/index/main','[]','2018-12-29 16:06:47'),(320,1,'admin','GET','http://www.xycmf.com/console/index/left/2','[]','2018-12-29 16:06:47'),(321,1,'admin','GET','http://www.xycmf.com/console/index/index','[]','2018-12-29 16:07:09'),(322,1,'admin','GET','http://www.xycmf.com/console/index/main','[]','2018-12-29 16:07:10'),(323,1,'admin','GET','http://www.xycmf.com/console/index/left/2','[]','2018-12-29 16:07:10'),(324,1,'admin','GET','http://www.xycmf.com/console/index/index','[]','2018-12-29 16:07:11'),(325,1,'admin','GET','http://www.xycmf.com/console/index/main','[]','2018-12-29 16:07:11'),(326,1,'admin','GET','http://www.xycmf.com/console/index/left/2','[]','2018-12-29 16:07:12'),(327,1,'admin','GET','http://www.xycmf.com/console/index/index','[]','2018-12-29 16:07:12'),(328,1,'admin','GET','http://www.xycmf.com/console/index/main','[]','2018-12-29 16:07:13'),(329,1,'admin','GET','http://www.xycmf.com/console/index/left/2','[]','2018-12-29 16:07:13'),(330,1,'admin','GET','http://www.xycmf.com/console/index/index','[]','2018-12-29 16:07:36'),(331,1,'admin','GET','http://www.xycmf.com/console/index/main','[]','2018-12-29 16:07:36'),(332,1,'admin','GET','http://www.xycmf.com/console/index/left/2','[]','2018-12-29 16:07:36'),(333,1,'admin','GET','http://www.xycmf.com/console/index/index','[]','2018-12-29 16:07:39'),(334,1,'admin','GET','http://www.xycmf.com/console/index/main','[]','2018-12-29 16:07:39'),(335,1,'admin','GET','http://www.xycmf.com/console/index/left/2','[]','2018-12-29 16:07:40'),(336,1,'admin','GET','http://www.xycmf.com/console/index/index','[]','2018-12-29 16:08:03'),(337,1,'admin','GET','http://www.xycmf.com/console/index/main','[]','2018-12-29 16:08:04'),(338,1,'admin','GET','http://www.xycmf.com/console/index/left/2','[]','2018-12-29 16:08:04'),(339,1,'admin','GET','http://www.xycmf.com/console/cate/index','[]','2018-12-29 16:08:06'),(340,1,'admin','GET','http://www.xycmf.com/console/index/left/1','[]','2018-12-29 16:08:29'),(341,1,'admin','GET','http://www.xycmf.com/console/index/left/2','[]','2018-12-29 16:08:31'),(342,1,'admin','GET','http://www.xycmf.com/console/index/index','[]','2018-12-29 16:09:34'),(343,1,'admin','GET','http://www.xycmf.com/console/index/main','[]','2018-12-29 16:09:34'),(344,1,'admin','GET','http://www.xycmf.com/console/index/left/2','[]','2018-12-29 16:09:35'),(345,1,'admin','GET','http://www.xycmf.com/console/index/index','[]','2018-12-29 16:09:36'),(346,1,'admin','GET','http://www.xycmf.com/console/index/main','[]','2018-12-29 16:09:37'),(347,1,'admin','GET','http://www.xycmf.com/console/index/left/2','[]','2018-12-29 16:09:37'),(348,1,'admin','GET','http://www.xycmf.com/console/index/index','[]','2018-12-29 16:09:54'),(349,1,'admin','GET','http://www.xycmf.com/console/index/main','[]','2018-12-29 16:09:54'),(350,1,'admin','GET','http://www.xycmf.com/console/index/left/2','[]','2018-12-29 16:09:55'),(351,1,'admin','GET','http://www.xycmf.com/console/index/index','[]','2018-12-29 16:10:26'),(352,1,'admin','GET','http://www.xycmf.com/console/index/main','[]','2018-12-29 16:10:26'),(353,1,'admin','GET','http://www.xycmf.com/console/index/left/2','[]','2018-12-29 16:10:26'),(354,1,'admin','GET','http://www.xycmf.com/console/index/index','[]','2018-12-29 16:10:28'),(355,1,'admin','GET','http://www.xycmf.com/console/index/main','[]','2018-12-29 16:10:28'),(356,1,'admin','GET','http://www.xycmf.com/console/index/left/2','[]','2018-12-29 16:10:28'),(357,1,'admin','GET','http://www.xycmf.com/console/index/index','[]','2018-12-29 16:10:52'),(358,1,'admin','GET','http://www.xycmf.com/console/index/main','[]','2018-12-29 16:10:52'),(359,1,'admin','GET','http://www.xycmf.com/console/index/left/2','[]','2018-12-29 16:10:52'),(360,1,'admin','GET','http://www.xycmf.com/console/index/index','[]','2018-12-29 16:10:54'),(361,1,'admin','GET','http://www.xycmf.com/console/index/main','[]','2018-12-29 16:10:54'),(362,1,'admin','GET','http://www.xycmf.com/console/index/left/2','[]','2018-12-29 16:10:54'),(363,1,'admin','GET','http://www.xycmf.com/console/index/index','[]','2018-12-29 16:10:55'),(364,1,'admin','GET','http://www.xycmf.com/console/index/main','[]','2018-12-29 16:10:56'),(365,1,'admin','GET','http://www.xycmf.com/console/index/left/2','[]','2018-12-29 16:10:56'),(366,1,'admin','GET','http://www.xycmf.com/console/index/index','[]','2018-12-29 16:11:05'),(367,1,'admin','GET','http://www.xycmf.com/console/index/main','[]','2018-12-29 16:11:05'),(368,1,'admin','GET','http://www.xycmf.com/console/index/left/2','[]','2018-12-29 16:11:05'),(369,1,'admin','GET','http://www.xycmf.com/console/index/index','[]','2018-12-29 16:11:06'),(370,1,'admin','GET','http://www.xycmf.com/console/index/main','[]','2018-12-29 16:11:07'),(371,1,'admin','GET','http://www.xycmf.com/console/index/left/2','[]','2018-12-29 16:11:07'),(372,1,'admin','GET','http://www.xycmf.com/console/index/index','[]','2018-12-29 16:11:14'),(373,1,'admin','GET','http://www.xycmf.com/console/index/main','[]','2018-12-29 16:11:15'),(374,1,'admin','GET','http://www.xycmf.com/console/index/left/2','[]','2018-12-29 16:11:15'),(375,1,'admin','GET','http://www.xycmf.com/console/index/index','[]','2018-12-29 16:11:16'),(376,1,'admin','GET','http://www.xycmf.com/console/index/main','[]','2018-12-29 16:11:17'),(377,1,'admin','GET','http://www.xycmf.com/console/index/left/2','[]','2018-12-29 16:11:17'),(378,1,'admin','GET','http://www.xycmf.com/console/index/index','[]','2018-12-29 16:11:33'),(379,1,'admin','GET','http://www.xycmf.com/console/index/main','[]','2018-12-29 16:11:34'),(380,1,'admin','GET','http://www.xycmf.com/console/index/left/2','[]','2018-12-29 16:11:34'),(381,1,'admin','GET','http://www.xycmf.com/console/index/index','[]','2018-12-29 16:11:35'),(382,1,'admin','GET','http://www.xycmf.com/console/index/main','[]','2018-12-29 16:11:36'),(383,1,'admin','GET','http://www.xycmf.com/console/index/left/2','[]','2018-12-29 16:11:36'),(384,1,'admin','GET','http://www.xycmf.com/console/index/index','[]','2018-12-29 16:11:40'),(385,1,'admin','GET','http://www.xycmf.com/console/index/main','[]','2018-12-29 16:11:41'),(386,1,'admin','GET','http://www.xycmf.com/console/index/left/2','[]','2018-12-29 16:11:41'),(387,1,'admin','GET','http://www.xycmf.com/console/index/index','[]','2018-12-29 16:11:42'),(388,1,'admin','GET','http://www.xycmf.com/console/index/main','[]','2018-12-29 16:11:42'),(389,1,'admin','GET','http://www.xycmf.com/console/index/left/2','[]','2018-12-29 16:11:43'),(390,1,'admin','GET','http://www.xycmf.com/console/index/index','[]','2018-12-29 16:11:45'),(391,1,'admin','GET','http://www.xycmf.com/console/index/main','[]','2018-12-29 16:11:46'),(392,1,'admin','GET','http://www.xycmf.com/console/index/left/2','[]','2018-12-29 16:11:46'),(393,1,'admin','GET','http://www.xycmf.com/console/group/index','[]','2018-12-29 16:11:48'),(394,1,'admin','GET','http://www.xycmf.com/console/config/index','[]','2018-12-29 16:11:50'),(395,1,'admin','GET','http://www.xycmf.com/console/admin/myedit','[]','2018-12-29 16:11:50'),(396,1,'admin','GET','http://www.xycmf.com/console/index/index','[]','2018-12-29 16:12:13'),(397,1,'admin','GET','http://www.xycmf.com/console/index/main','[]','2018-12-29 16:12:13'),(398,1,'admin','GET','http://www.xycmf.com/console/index/left/2','[]','2018-12-29 16:12:13'),(399,1,'admin','GET','http://www.xycmf.com/console/index/index','[]','2018-12-29 16:12:14'),(400,1,'admin','GET','http://www.xycmf.com/console/index/main','[]','2018-12-29 16:12:15'),(401,1,'admin','GET','http://www.xycmf.com/console/index/left/2','[]','2018-12-29 16:12:15'),(402,1,'admin','GET','http://www.xycmf.com/console/index/index','[]','2018-12-29 16:12:16'),(403,1,'admin','GET','http://www.xycmf.com/console/index/main','[]','2018-12-29 16:12:16'),(404,1,'admin','GET','http://www.xycmf.com/console/index/left/2','[]','2018-12-29 16:12:16'),(405,1,'admin','GET','http://www.xycmf.com/console/index/index','[]','2018-12-29 16:12:21'),(406,1,'admin','GET','http://www.xycmf.com/console/index/main','[]','2018-12-29 16:12:21'),(407,1,'admin','GET','http://www.xycmf.com/console/index/left/2','[]','2018-12-29 16:12:21'),(408,1,'admin','GET','http://www.xycmf.com/console/index/index','[]','2018-12-29 16:12:22'),(409,1,'admin','GET','http://www.xycmf.com/console/index/main','[]','2018-12-29 16:12:23'),(410,1,'admin','GET','http://www.xycmf.com/console/index/left/2','[]','2018-12-29 16:12:23'),(411,1,'admin','GET','http://www.xycmf.com/console/index/index','[]','2018-12-29 16:12:38'),(412,1,'admin','GET','http://www.xycmf.com/console/index/main','[]','2018-12-29 16:12:38'),(413,1,'admin','GET','http://www.xycmf.com/console/index/left/2','[]','2018-12-29 16:12:39'),(414,1,'admin','GET','http://www.xycmf.com/console/index/index','[]','2018-12-29 16:12:52'),(415,1,'admin','GET','http://www.xycmf.com/console/index/main','[]','2018-12-29 16:12:52'),(416,1,'admin','GET','http://www.xycmf.com/console/index/left/2','[]','2018-12-29 16:12:53'),(417,1,'admin','GET','http://www.xycmf.com/console/index/index','[]','2018-12-29 16:13:52'),(418,1,'admin','GET','http://www.xycmf.com/console/index/main','[]','2018-12-29 16:13:53'),(419,1,'admin','GET','http://www.xycmf.com/console/index/left/2','[]','2018-12-29 16:13:53'),(420,1,'admin','GET','http://www.xycmf.com/console/index/index','[]','2018-12-29 16:13:54'),(421,1,'admin','GET','http://www.xycmf.com/console/index/main','[]','2018-12-29 16:13:55'),(422,1,'admin','GET','http://www.xycmf.com/console/index/left/2','[]','2018-12-29 16:13:55'),(423,1,'admin','GET','http://www.xycmf.com/console/index/index','[]','2018-12-29 16:14:02'),(424,1,'admin','GET','http://www.xycmf.com/console/index/main','[]','2018-12-29 16:14:02'),(425,1,'admin','GET','http://www.xycmf.com/console/index/left/2','[]','2018-12-29 16:14:02'),(426,1,'admin','GET','http://www.xycmf.com/console/group/index','[]','2018-12-29 16:14:04'),(427,1,'admin','GET','http://www.xycmf.com/console/config/index','[]','2018-12-29 16:14:05'),(428,1,'admin','GET','http://www.xycmf.com/console/admin/myedit','[]','2018-12-29 16:14:05'),(429,1,'admin','GET','http://www.xycmf.com/console/index/index','[]','2018-12-29 16:14:10'),(430,1,'admin','GET','http://www.xycmf.com/console/index/main','[]','2018-12-29 16:14:10'),(431,1,'admin','GET','http://www.xycmf.com/console/index/left/2','[]','2018-12-29 16:14:10'),(432,1,'admin','GET','http://www.xycmf.com/console/index/index','[]','2018-12-29 16:14:11'),(433,1,'admin','GET','http://www.xycmf.com/console/index/main','[]','2018-12-29 16:14:12'),(434,1,'admin','GET','http://www.xycmf.com/console/index/left/2','[]','2018-12-29 16:14:12'),(435,1,'admin','GET','http://www.xycmf.com/console/index/index','[]','2018-12-29 16:14:24'),(436,1,'admin','GET','http://www.xycmf.com/console/index/main','[]','2018-12-29 16:14:24'),(437,1,'admin','GET','http://www.xycmf.com/console/index/left/2','[]','2018-12-29 16:14:25'),(438,1,'admin','GET','http://www.xycmf.com/console/index/index','[]','2018-12-29 16:14:30'),(439,1,'admin','GET','http://www.xycmf.com/console/index/main','[]','2018-12-29 16:14:31'),(440,1,'admin','GET','http://www.xycmf.com/console/index/left/2','[]','2018-12-29 16:14:31'),(441,1,'admin','GET','http://www.xycmf.com/console/index/index','[]','2018-12-29 16:14:33'),(442,1,'admin','GET','http://www.xycmf.com/console/index/main','[]','2018-12-29 16:14:34'),(443,1,'admin','GET','http://www.xycmf.com/console/index/left/2','[]','2018-12-29 16:14:34'),(444,1,'admin','GET','http://www.xycmf.com/console/index/index','[]','2018-12-29 16:14:35'),(445,1,'admin','GET','http://www.xycmf.com/console/index/main','[]','2018-12-29 16:14:36'),(446,1,'admin','GET','http://www.xycmf.com/console/index/left/2','[]','2018-12-29 16:14:36'),(447,1,'admin','GET','http://www.xycmf.com/console/index/left/1','[]','2018-12-29 16:14:37'),(448,1,'admin','GET','http://www.xycmf.com/console/menu/index','[]','2018-12-29 16:14:38'),(449,1,'admin','GET','http://www.xycmf.com/console/area/index','[]','2018-12-29 16:14:39'),(450,1,'admin','GET','http://www.xycmf.com/console/index/left/2','[]','2018-12-29 16:14:40'),(451,1,'admin','GET','http://www.xycmf.com/console/index/index','[]','2018-12-29 16:14:48'),(452,1,'admin','GET','http://www.xycmf.com/console/index/main','[]','2018-12-29 16:14:48'),(453,1,'admin','GET','http://www.xycmf.com/console/index/left/2','[]','2018-12-29 16:14:48'),(454,1,'admin','GET','http://www.xycmf.com/console/index/index','[]','2018-12-29 16:14:49'),(455,1,'admin','GET','http://www.xycmf.com/console/index/main','[]','2018-12-29 16:14:50'),(456,1,'admin','GET','http://www.xycmf.com/console/index/left/2','[]','2018-12-29 16:14:50'),(457,1,'admin','GET','http://www.xycmf.com/console/index/left/1','[]','2018-12-29 16:14:59'),(458,1,'admin','GET','http://www.xycmf.com/console/menu/index','[]','2018-12-29 16:15:00'),(459,1,'admin','GET','http://www.xycmf.com/console/area/index','[]','2018-12-29 16:15:02'),(460,1,'admin','GET','http://www.xycmf.com/console/menu/index','[]','2018-12-29 16:15:03'),(461,1,'admin','GET','http://www.xycmf.com/console/menu/index','[]','2018-12-29 16:15:11'),(462,1,'admin','GET','http://www.xycmf.com/console/menu/index','[]','2018-12-29 16:15:13'),(463,1,'admin','GET','http://www.xycmf.com/console/menu/index','[]','2018-12-29 16:15:14'),(464,1,'admin','GET','http://www.xycmf.com/console/menu/add/2','[]','2018-12-29 16:15:21'),(465,1,'admin','GET','http://www.xycmf.com/console/menu/index','[]','2018-12-29 16:15:43'),(466,1,'admin','GET','http://www.xycmf.com/console/menu/index','[]','2018-12-29 16:15:45'),(467,1,'admin','GET','http://www.xycmf.com/console/menu/index','[]','2018-12-29 16:15:46'),(468,1,'admin','GET','http://www.xycmf.com/console/menu/index','[]','2018-12-29 16:16:20'),(469,1,'admin','GET','http://www.xycmf.com/console/menu/index','[]','2018-12-29 16:16:21'),(470,1,'admin','GET','http://www.xycmf.com/console/menu/index','[]','2018-12-29 16:18:22'),(471,1,'admin','GET','http://www.xycmf.com/console/menu/index','[]','2018-12-29 16:18:23'),(472,1,'admin','GET','http://www.xycmf.com/console/menu/index','[]','2018-12-29 16:22:14'),(473,1,'admin','GET','http://www.xycmf.com/console/menu/index','[]','2018-12-29 16:22:20'),(474,1,'admin','GET','http://www.xycmf.com/console/menu/index','[]','2018-12-29 16:22:50'),(475,1,'admin','GET','http://www.xycmf.com/console/menu/index','[]','2018-12-29 16:22:51'),(476,1,'admin','GET','http://www.xycmf.com/console/index/index','[]','2018-12-29 16:22:54'),(477,1,'admin','GET','http://www.xycmf.com/console/index/main','[]','2018-12-29 16:22:55'),(478,1,'admin','GET','http://www.xycmf.com/console/index/left/2','[]','2018-12-29 16:22:55'),(479,1,'admin','GET','http://www.xycmf.com/console/cate/index','[]','2018-12-29 16:22:57'),(480,1,'admin','GET','http://www.xycmf.com/console/art/index','[]','2018-12-29 16:22:58'),(481,1,'admin','GET','http://www.xycmf.com/console/index/left/1','[]','2018-12-29 16:23:00'),(482,1,'admin','GET','http://www.xycmf.com/console/area/index','[]','2018-12-29 16:23:01'),(483,1,'admin','GET','http://www.xycmf.com/console/menu/index','[]','2018-12-29 16:23:02'),(484,1,'admin','GET','http://www.xycmf.com/console/index/index','[]','2018-12-29 16:23:30'),(485,1,'admin','GET','http://www.xycmf.com/console/index/main','[]','2018-12-29 16:23:30'),(486,1,'admin','GET','http://www.xycmf.com/console/index/left/2','[]','2018-12-29 16:23:30'),(487,1,'admin','GET','http://www.xycmf.com/console/index/index','[]','2018-12-29 16:23:31'),(488,1,'admin','GET','http://www.xycmf.com/console/index/main','[]','2018-12-29 16:23:31'),(489,1,'admin','GET','http://www.xycmf.com/console/index/left/2','[]','2018-12-29 16:23:32'),(490,1,'admin','GET','http://www.xycmf.com/console/index/index','[]','2018-12-29 16:25:46'),(491,1,'admin','GET','http://www.xycmf.com/console/index/main','[]','2018-12-29 16:25:47'),(492,1,'admin','GET','http://www.xycmf.com/console/index/left/2','[]','2018-12-29 16:25:47'),(493,1,'admin','GET','http://www.xycmf.com/console/index/index','[]','2018-12-29 16:25:48'),(494,1,'admin','GET','http://www.xycmf.com/console/index/main','[]','2018-12-29 16:25:48'),(495,1,'admin','GET','http://www.xycmf.com/console/index/left/2','[]','2018-12-29 16:25:48'),(496,1,'admin','GET','http://www.xycmf.com/console/index/index','[]','2018-12-29 16:25:50'),(497,1,'admin','GET','http://www.xycmf.com/console/index/main','[]','2018-12-29 16:25:50'),(498,1,'admin','GET','http://www.xycmf.com/console/index/left/2','[]','2018-12-29 16:25:50'),(499,1,'admin','GET','http://www.xycmf.com/console/index/index','[]','2018-12-29 16:26:30'),(500,1,'admin','GET','http://www.xycmf.com/console/index/main','[]','2018-12-29 16:26:30'),(501,1,'admin','GET','http://www.xycmf.com/console/index/left/2','[]','2018-12-29 16:26:30'),(502,1,'admin','GET','http://www.xycmf.com/console/index/index','[]','2018-12-29 16:26:31'),(503,1,'admin','GET','http://www.xycmf.com/console/index/main','[]','2018-12-29 16:26:32'),(504,1,'admin','GET','http://www.xycmf.com/console/index/left/2','[]','2018-12-29 16:26:32'),(505,1,'admin','GET','http://www.xycmf.com/console/index/index','[]','2018-12-29 16:26:42'),(506,1,'admin','GET','http://www.xycmf.com/console/index/main','[]','2018-12-29 16:26:42'),(507,1,'admin','GET','http://www.xycmf.com/console/index/left/2','[]','2018-12-29 16:26:42'),(508,1,'admin','GET','http://www.xycmf.com/console/index/index','[]','2018-12-29 16:27:00'),(509,1,'admin','GET','http://www.xycmf.com/console/index/main','[]','2018-12-29 16:27:00'),(510,1,'admin','GET','http://www.xycmf.com/console/index/left/2','[]','2018-12-29 16:27:00'),(511,1,'admin','GET','http://www.xycmf.com/console/index/index','[]','2018-12-29 16:27:12'),(512,1,'admin','GET','http://www.xycmf.com/console/index/main','[]','2018-12-29 16:27:13'),(513,1,'admin','GET','http://www.xycmf.com/console/index/left/2','[]','2018-12-29 16:27:13'),(514,1,'admin','GET','http://www.xycmf.com/console/index/index','[]','2018-12-29 16:27:15'),(515,1,'admin','GET','http://www.xycmf.com/console/index/main','[]','2018-12-29 16:27:15'),(516,1,'admin','GET','http://www.xycmf.com/console/index/left/2','[]','2018-12-29 16:27:15'),(517,1,'admin','GET','http://www.xycmf.com/console/index/index','[]','2018-12-29 16:27:18'),(518,1,'admin','GET','http://www.xycmf.com/console/index/main','[]','2018-12-29 16:27:19'),(519,1,'admin','GET','http://www.xycmf.com/console/index/left/2','[]','2018-12-29 16:27:19'),(520,1,'admin','GET','http://www.xycmf.com/console/index/index','[]','2018-12-29 16:27:48'),(521,1,'admin','GET','http://www.xycmf.com/console/index/main','[]','2018-12-29 16:27:48'),(522,1,'admin','GET','http://www.xycmf.com/console/index/left/2','[]','2018-12-29 16:27:48'),(523,1,'admin','GET','http://www.xycmf.com/console/index/index','[]','2018-12-29 16:27:50'),(524,1,'admin','GET','http://www.xycmf.com/console/index/main','[]','2018-12-29 16:27:50'),(525,1,'admin','GET','http://www.xycmf.com/console/index/left/2','[]','2018-12-29 16:27:50'),(526,1,'admin','GET','http://www.xycmf.com/console/cate/index','[]','2018-12-29 16:27:53'),(527,1,'admin','GET','http://www.xycmf.com/console/art/index','[]','2018-12-29 16:27:54'),(528,1,'admin','GET','http://www.xycmf.com/console/ad/index','[]','2018-12-29 16:27:55'),(529,1,'admin','GET','http://www.xycmf.com/console/adpos/index','[]','2018-12-29 16:27:56'),(530,1,'admin','GET','http://www.xycmf.com/console/adpos/index','[]','2018-12-29 16:27:57'),(531,1,'admin','GET','http://www.xycmf.com/console/type/index','[]','2018-12-29 16:28:01'),(532,1,'admin','GET','http://www.xycmf.com/console/index/left/1','[]','2018-12-29 16:28:02'),(533,1,'admin','GET','http://www.xycmf.com/console/menu/index','[]','2018-12-29 16:28:03'),(534,1,'admin','GET','http://www.xycmf.com/console/database/export','[]','2018-12-29 16:28:04'),(535,1,'admin','GET','http://www.xycmf.com/console/log/index','[]','2018-12-29 16:28:06'),(536,1,'admin','GET','http://www.xycmf.com/console/menu/index','[]','2018-12-29 16:28:08'),(537,1,'admin','GET','http://www.xycmf.com/console/index/left/2','[]','2018-12-29 16:28:20'),(538,1,'admin','GET','http://www.xycmf.com/console/cate/index','[]','2018-12-29 16:28:21'),(539,1,'admin','GET','http://www.xycmf.com/console/art/index','[]','2018-12-29 16:28:21'),(540,1,'admin','GET','http://www.xycmf.com/console/ad/index','[]','2018-12-29 16:28:22'),(541,1,'admin','GET','http://www.xycmf.com/console/adpos/index','[]','2018-12-29 16:28:23'),(542,1,'admin','GET','http://www.xycmf.com/console/index/left/1','[]','2018-12-29 16:28:25'),(543,1,'admin','GET','http://www.xycmf.com/console/database/export','[]','2018-12-29 16:28:25'),(544,1,'admin','GET','http://www.xycmf.com/console/log/index','[]','2018-12-29 16:28:26'),(545,1,'admin','GET','http://www.xycmf.com/console/index/cache','[]','2018-12-29 16:28:27'),(546,1,'admin','GET','http://www.xycmf.com/console/admin/index','[]','2018-12-29 16:28:29'),(547,1,'admin','GET','http://www.xycmf.com/console/role/index','[]','2018-12-29 16:28:30'),(548,1,'admin','GET','http://www.xycmf.com/console/section/index','[]','2018-12-29 16:28:31'),(549,1,'admin','GET','http://www.xycmf.com/console/index/index','[]','2018-12-29 16:29:11'),(550,1,'admin','GET','http://www.xycmf.com/console/index/main','[]','2018-12-29 16:29:12'),(551,1,'admin','GET','http://www.xycmf.com/console/index/left/2','[]','2018-12-29 16:29:12'),(552,1,'admin','GET','http://www.xycmf.com/console/art/index','[]','2018-12-29 16:40:31'),(553,1,'admin','GET','http://www.xycmf.com/console/art/index','[]','2018-12-29 16:41:02'),(554,1,'admin','GET','http://www.xycmf.com/console/art/index','[]','2018-12-29 16:41:24'),(555,1,'admin','GET','http://www.xycmf.com/console/art/index','[]','2018-12-29 16:41:45'),(556,1,'admin','GET','http://www.xycmf.com/console/art/index','[]','2018-12-29 16:41:47'),(557,1,'admin','GET','http://www.xycmf.com/console/art/index','[]','2018-12-29 16:41:53'),(558,1,'admin','GET','http://www.xycmf.com/console/art/index','[]','2018-12-29 16:41:56'),(559,1,'admin','GET','http://www.xycmf.com/console/ad/index','[]','2018-12-29 16:41:57'),(560,1,'admin','GET','http://www.xycmf.com/console/art/index','[]','2018-12-29 16:41:58'),(561,1,'admin','GET','http://www.xycmf.com/console/index/index','[]','2018-12-29 16:41:58'),(562,1,'admin','GET','http://www.xycmf.com/console/index/main','[]','2018-12-29 16:41:59'),(563,1,'admin','GET','http://www.xycmf.com/console/index/left/2','[]','2018-12-29 16:41:59'),(564,1,'admin','GET','http://www.xycmf.com/console/art/index','[]','2018-12-29 16:42:00'),(565,1,'admin','GET','http://www.xycmf.com/console/ad/index','[]','2018-12-29 16:46:39'),(566,1,'admin','GET','http://www.xycmf.com/console/adpos/index','[]','2018-12-29 16:46:40'),(567,1,'admin','GET','http://www.xycmf.com/console/config/index','[]','2018-12-29 16:46:41'),(568,1,'admin','GET','http://www.xycmf.com/console/config/index','[]','2018-12-29 16:46:43'),(569,1,'admin','GET','http://www.xycmf.com/console/index/left/1','[]','2018-12-29 16:46:46'),(570,1,'admin','GET','http://www.xycmf.com/console/menu/index','[]','2018-12-29 16:46:47'),(571,1,'admin','GET','http://www.xycmf.com/console/menu/del/353','[]','2018-12-29 16:47:05'),(572,1,'admin','GET','http://www.xycmf.com/console/menu/index','[]','2018-12-29 16:47:06'),(573,1,'admin','GET','http://www.xycmf.com/console/index/left/2','[]','2018-12-29 16:47:23'),(574,1,'admin','GET','http://www.xycmf.com/console/art/index','[]','2018-12-29 16:47:24'),(575,1,'admin','GET','http://www.xycmf.com/console/cate/index','[]','2018-12-29 16:47:24'),(576,1,'admin','GET','http://www.xycmf.com/console/adpos/index','[]','2018-12-29 16:47:25'),(577,1,'admin','GET','http://www.xycmf.com/console/type/index','[]','2018-12-29 16:47:26'),(578,1,'admin','GET','http://www.xycmf.com/console/adpos/index','[]','2018-12-29 16:47:32'),(579,1,'admin','GET','http://www.xycmf.com/console/index/left/1','[]','2018-12-29 16:47:33'),(580,1,'admin','GET','http://www.xycmf.com/console/database/export','[]','2018-12-29 16:47:34'),(581,1,'admin','GET','http://www.xycmf.com/console/menu/index','[]','2018-12-29 16:47:34'),(582,1,'admin','GET','http://www.xycmf.com/console/menu/del/344','[]','2018-12-29 16:47:41'),(583,1,'admin','GET','http://www.xycmf.com/console/menu/index','[]','2018-12-29 16:47:41'),(584,1,'admin','GET','http://www.xycmf.com/console/menu/del/349','[]','2018-12-29 16:47:48'),(585,1,'admin','GET','http://www.xycmf.com/console/menu/index','[]','2018-12-29 16:47:49'),(586,1,'admin','GET','http://www.xycmf.com/console/index/left/2','[]','2018-12-29 16:47:50'),(587,1,'admin','GET','http://www.xycmf.com/console/adpos/index','[]','2018-12-29 16:47:51'),(588,1,'admin','GET','http://www.xycmf.com/console/ad/index','[]','2018-12-29 16:47:52'),(589,1,'admin','GET','http://www.xycmf.com/console/art/index','[]','2018-12-29 16:47:53'),(590,1,'admin','GET','http://www.xycmf.com/console/cate/index','[]','2018-12-29 16:47:53'),(591,1,'admin','GET','http://www.xycmf.com/console/type/index','[]','2018-12-29 16:47:54'),(592,1,'admin','GET','http://www.xycmf.com/console/config/index','[]','2018-12-29 16:47:55'),(593,1,'admin','GET','http://www.xycmf.com/console/admin/myedit','[]','2018-12-29 16:47:57'),(594,1,'admin','GET','http://www.xycmf.com/console/index/left/1','[]','2018-12-29 16:47:58'),(595,1,'admin','GET','http://www.xycmf.com/console/menu/index','[]','2018-12-29 16:47:59'),(596,1,'admin','GET','http://www.xycmf.com/console/database/export','[]','2018-12-29 16:48:00'),(597,1,'admin','GET','http://www.xycmf.com/console/log/index','[]','2018-12-29 16:48:01'),(598,1,'admin','GET','http://www.xycmf.com/console/index/cache','[]','2018-12-29 16:48:02'),(599,1,'admin','GET','http://www.xycmf.com/console/index/index','[]','2018-12-29 16:48:03'),(600,1,'admin','GET','http://www.xycmf.com/console/index/main','[]','2018-12-29 16:48:04'),(601,1,'admin','GET','http://www.xycmf.com/console/index/left/2','[]','2018-12-29 16:48:04'),(602,1,'admin','GET','http://www.xycmf.com/console/cate/index','[]','2018-12-29 16:48:06');

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
) ENGINE=InnoDB AUTO_INCREMENT=359 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `menus` */

insert  into `menus`(`id`,`parentid`,`arrparentid`,`child`,`arrchildid`,`name`,`url`,`label`,`icon`,`display`,`sort`,`created_at`,`updated_at`) values (1,0,'0',1,'1,5,6,7,8,9,67,68,74,148,149,150,10,11,12,13,14,15,16,17,18,19,140,170,171,172,173,20,21','系统','index/index','index-index',NULL,1,99,'2016-03-18 15:46:02','2018-06-26 11:31:13'),(2,0,'0',1,'2,22,23,24,25,26,27,28,75,30,31,32,33,34,121,136,342,357,358,151,152,153,154,242,243,244,245,246,247,300,301,302,303,348,143,144,145,299,205','内容','content/index','content-index',NULL,1,0,'2016-03-18 15:46:21','2018-12-29 16:47:49'),(5,1,'0,1',1,'5,6,7,8,9,67,68,74,148,149,150','系统设置','sys/index','sys-index','glyphicon glyphicon-cog',1,0,'2016-03-18 15:47:40','2018-06-26 11:31:13'),(6,5,'0,1,5',1,'6,7,8,9','菜单管理','menu/index','menu-index',NULL,1,1,'2016-03-18 15:48:07','2017-04-25 21:49:25'),(7,6,'0,1,5,6',0,'7','添加菜单','menu/add','menu-add',NULL,1,0,'2016-03-18 15:49:03','2016-03-23 08:25:50'),(8,6,'0,1,5,6',0,'8','修改菜单','menu/edit','menu-edit',NULL,0,0,'2016-03-18 15:51:08','2016-03-23 14:23:43'),(9,6,'0,1,5,6',0,'9','删除菜单','menu/del','menu-del',NULL,0,0,'2016-03-18 15:51:30','2016-03-23 08:25:50'),(10,1,'0,1',1,'10,11,12,13,14,15,16,17,18,19,140,170,171,172,173','用户中心','admin/manage','admin-manage','glyphicon glyphicon-user',1,0,'2016-03-18 16:04:01','2017-06-30 13:01:01'),(11,10,'0,1,10',1,'11,12,13,14,15','用户管理','admin/index','admin-index',NULL,1,0,'2016-03-18 16:04:38','2016-03-24 11:31:08'),(12,11,'0,1,10,11',0,'12','添加用户','admin/add','admin-add',NULL,1,0,'2016-03-18 16:05:14','2016-03-24 11:31:16'),(13,11,'0,1,10,11',0,'13','修改用户','admin/edit','admin-edit',NULL,0,0,'2016-03-18 16:06:10','2016-03-24 11:31:24'),(14,11,'0,1,10,11',0,'14','删除用户','admin/del','admin-del',NULL,0,0,'2016-03-18 16:06:31','2016-03-24 11:31:32'),(15,11,'0,1,10,11',0,'15','修改密码','admin/pwd','admin-pwd',NULL,0,0,'2016-03-18 16:07:07','2016-03-24 11:31:44'),(16,10,'0,1,10',1,'16,17,18,19,140','角色管理','role/index','role-index',NULL,1,0,'2016-03-18 16:07:58','2016-12-02 09:41:15'),(17,16,'0,1,10,16',0,'17','添加角色','role/add','role-add',NULL,1,0,'2016-03-18 16:08:23','2016-03-23 08:25:50'),(18,16,'0,1,10,16',0,'18','修改角色','role/edit','role-edit',NULL,0,0,'2016-03-18 16:08:50','2016-03-23 08:25:50'),(19,16,'0,1,10,16',0,'19','删除角色','role/del','role-del',NULL,0,0,'2016-03-18 16:09:10','2016-03-23 08:25:50'),(20,1,'0,1',1,'20,21','系统信息','index/main','index-main',NULL,0,0,'2016-03-24 15:42:14','2017-07-21 19:06:04'),(21,20,'0,1,20',0,'21','左侧菜单','index/left','index-left',NULL,0,0,'2016-03-25 10:34:44','2016-03-25 10:35:27'),(22,2,'0,2',1,'22,23,24,25,26,27,28,75,30,31,32,33,34,121,136,342,357,358,151,152,153,154,242,243,244,245,246,247,300,301,302,303,348','内容管理','content/manage','content-manage','glyphicon glyphicon-book',1,0,'2016-03-29 08:39:52','2018-12-29 16:47:49'),(23,22,'0,2,22',1,'23,24,25,26,27','栏目管理','cate/index','cate-index',NULL,1,0,'2016-03-29 08:40:08','2016-03-29 08:41:30'),(24,23,'0,2,22,23',0,'24','添加栏目','cate/add','cate-add',NULL,1,0,'2016-03-29 08:40:25','2016-03-29 08:40:25'),(25,23,'0,2,22,23',0,'25','修改栏目','cate/edit','cate-edit',NULL,0,0,'2016-03-29 08:40:42','2016-03-29 08:41:00'),(26,23,'0,2,22,23',0,'26','删除栏目','cate/del','cate-del',NULL,0,0,'2016-03-29 08:40:54','2016-03-29 08:41:07'),(27,23,'0,2,22,23',0,'27','更新栏目缓存','cate/cache','cate-cache',NULL,0,0,'2016-03-29 08:41:30','2016-03-29 08:41:30'),(28,22,'0,2,22',1,'28,75','附件管理','attr/index','attr-index',NULL,0,5,'2016-03-31 08:23:28','2017-08-04 14:56:05'),(30,22,'0,2,22',1,'30,31,32,33,34,121,136,342,357,358','文章管理','art/index','art-index',NULL,1,0,'2016-03-31 08:25:22','2018-08-07 09:22:04'),(31,30,'0,2,22,30',0,'31','添加文章','art/add','art-add',NULL,1,0,'2016-03-31 08:25:40','2016-07-23 17:39:54'),(32,30,'0,2,22,30',0,'32','修改文章','art/edit','art-edit',NULL,0,0,'2016-03-31 08:25:59','2016-03-31 08:25:59'),(33,30,'0,2,22,30',0,'33','删除文章','art/del','art-del',NULL,0,0,'2016-03-31 08:26:15','2016-03-31 08:26:15'),(34,30,'0,2,22,30',0,'34','查看文章','art/show','art-show',NULL,0,0,'2016-03-31 08:26:35','2016-03-31 08:26:36'),(67,5,'0,1,5',1,'67,68','操作日志','log/index','log-index',NULL,1,4,'2016-04-11 10:38:34','2017-04-25 21:50:09'),(68,67,'0,1,5,67',0,'68','清除7天前日志','log/del','log-del',NULL,0,0,'2016-04-11 10:38:53','2016-05-11 17:37:46'),(74,5,'0,1,5',0,'74','更新缓存','index/cache','index-cache',NULL,1,5,'2016-04-11 16:00:30','2016-05-15 08:25:53'),(75,28,'0,2,22,28',0,'75','删除附件','attr/delfile','attr-delfile',NULL,0,0,'2016-05-09 19:29:09','2016-05-09 19:29:09'),(121,30,'0,2,22,30',0,'121','批量删除','art/alldel','art-alldel',NULL,0,0,'2016-06-15 08:52:32','2016-06-15 08:52:32'),(136,30,'0,2,22,30',0,'136','批量排序','art/listorder','art-listorder',NULL,0,0,'2016-07-25 08:35:42','2016-07-25 08:35:42'),(140,16,'0,1,10,16',0,'140','角色权限','role/priv','role-priv',NULL,0,0,'2016-07-25 11:34:39','2016-07-25 11:34:40'),(143,2,'0,2',1,'143,144,145','资料','admin/info','admin-info','glyphicon glyphicon-education',1,99,'2016-07-28 14:01:45','2018-06-26 09:41:39'),(144,143,'0,2,143',0,'144','修改个人资料','admin/myedit','admin-myedit',NULL,1,0,'2016-07-28 14:02:12','2018-06-26 09:40:27'),(145,143,'0,2,143',0,'145','修改个人密码','admin/mypwd','admin-mypwd',NULL,1,0,'2016-07-28 14:02:37','2018-06-26 09:40:27'),(148,5,'0,1,5',1,'148,149,150','数据管理','database/export','database-export',NULL,1,3,'2016-12-02 10:21:37','2017-04-25 21:50:02'),(149,148,'0,1,5,148',0,'149','恢复数据','database/import','database-import',NULL,0,0,'2016-12-02 10:22:16','2016-12-02 10:22:23'),(150,148,'0,1,5,148',0,'150','删除备份文件','database/delfile','database-delfile',NULL,0,0,'2016-12-02 10:22:47','2016-12-02 10:22:48'),(151,22,'0,2,22',1,'151,152,153,154','分类管理','type/index','type-index',NULL,1,2,'2016-12-14 09:56:01','2018-06-26 09:39:50'),(152,151,'0,2,22,151',0,'152','添加分类','type/add','type-add',NULL,1,0,'2016-12-14 09:56:23','2018-06-26 09:39:50'),(153,151,'0,2,22,151',0,'153','修改分类','type/edit','type-edit',NULL,0,0,'2016-12-14 09:56:42','2018-06-26 09:39:50'),(154,151,'0,2,22,151',0,'154','删除分类','type/del','type-del',NULL,0,0,'2016-12-14 09:56:57','2018-06-26 09:39:50'),(170,10,'0,1,10',1,'170,171,172,173','部门管理','section/index','section-index',NULL,1,0,'2016-12-15 08:31:39','2016-12-15 08:32:44'),(171,170,'0,1,10,170',0,'171','添加部门','section/add','section-add',NULL,1,0,'2016-12-15 08:32:01','2016-12-15 08:32:02'),(172,170,'0,1,10,170',0,'172','修改部门','section/edit','section-edit',NULL,0,0,'2016-12-15 08:32:23','2016-12-15 08:32:23'),(173,170,'0,1,10,170',0,'173','删除部门','section/del','section-del',NULL,0,0,'2016-12-15 08:32:44','2016-12-15 08:32:44'),(205,299,'0,2,299',0,'205','系统配置','config/index','config-index',NULL,1,0,'2017-04-25 21:49:13','2018-06-26 09:39:24'),(242,22,'0,2,22',1,'242,243,244,245,246,247','广告管理','ad/index','ad-index',NULL,1,0,'2017-05-16 06:34:07','2018-06-26 09:38:52'),(243,242,'0,2,22,242',0,'243','添加广告','ad/add','ad-add',NULL,1,0,'2017-05-16 06:34:25','2018-06-26 09:38:52'),(244,242,'0,2,22,242',0,'244','修改广告','ad/edit','ad-edit',NULL,0,0,'2017-05-16 06:34:40','2018-06-26 09:38:52'),(245,242,'0,2,22,242',0,'245','删除广告','ad/del','ad-del',NULL,0,0,'2017-05-16 06:34:55','2018-06-26 09:38:52'),(246,242,'0,2,22,242',0,'246','广告排序','ad/sort','ad-sort',NULL,0,0,'2017-05-16 06:35:11','2018-06-26 09:38:52'),(247,242,'0,2,22,242',0,'247','批量删除广告','ad/alldel','ad-alldel',NULL,0,0,'2017-05-16 06:35:35','2018-06-26 09:38:53'),(299,2,'0,2',1,'299,205','设置','sys/set','sys-set','glyphicon glyphicon-blackboard',1,98,'2017-07-01 09:18:39','2018-12-29 16:47:06'),(300,22,'0,2,22',1,'300,301,302,303,348','广告位管理','adpos/index','adpos-index',NULL,1,0,'2017-07-01 09:19:12','2018-06-26 11:35:49'),(301,300,'0,2,22,300',0,'301','添加广告位','adpos/add','adpos-add',NULL,1,0,'2017-07-01 09:19:37','2018-06-26 09:39:04'),(302,300,'0,2,22,300',0,'302','修改广告位','adpos/edit','adpos-edit',NULL,0,0,'2017-07-01 09:19:59','2018-06-26 09:39:04'),(303,300,'0,2,22,300',0,'303','删除广告位','adpos/del','adpos-del',NULL,0,0,'2017-07-01 09:20:21','2018-06-26 09:39:04'),(342,30,'0,2,22,30',0,'342','文章选择','art/select','art-select',NULL,0,0,'2017-08-18 11:51:16','2017-11-07 09:46:42'),(348,300,'0,2,22,300',0,'348','友情链接排序','link/sort','link-sort',NULL,0,0,'2018-06-26 11:35:48','2018-06-26 11:35:49'),(357,30,'0,2,22,30',0,'357','文章审核','art/status','art-status',NULL,0,0,'2018-08-07 09:21:18','2018-08-07 09:21:18'),(358,30,'0,2,22,30',0,'358','批量审核','art/allstatus','art-allstatus',NULL,0,0,'2018-08-07 09:22:04','2018-08-07 09:22:04');

/*Table structure for table `migrations` */

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `migrations` */

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

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
