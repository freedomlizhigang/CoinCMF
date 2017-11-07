/*
SQLyog Ultimate v12.09 (64 bit)
MySQL - 5.7.18 : Database - xycmf
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`xycmf` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci */;

USE `xycmf`;

/*Table structure for table `li_ad_pos` */

DROP TABLE IF EXISTS `li_ad_pos`;

CREATE TABLE `li_ad_pos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `is_mobile` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0:PC/1:MOB',
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '名称',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `li_admins` */

DROP TABLE IF EXISTS `li_admins`;

CREATE TABLE `li_admins` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `section_id` int(11) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `realname` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `crypt` char(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `lasttime` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `lastip` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admins_name_unique` (`name`),
  UNIQUE KEY `admins_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `li_ads` */

DROP TABLE IF EXISTS `li_ads`;

CREATE TABLE `li_ads` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pos_id` int(11) NOT NULL DEFAULT '0' COMMENT '位置ID',
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '标题',
  `thumb` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '图片',
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '链接',
  `starttime` timestamp NULL DEFAULT NULL COMMENT '开始时间',
  `endtime` timestamp NULL DEFAULT NULL COMMENT '结束时间',
  `sort` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态，1正常0关闭',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `li_areas` */

DROP TABLE IF EXISTS `li_areas`;

CREATE TABLE `li_areas` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parentid` int(11) NOT NULL DEFAULT '0' COMMENT '父ID',
  `provinceid` char(12) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '阿里云ID',
  `areaname` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '名称',
  `is_show` tinyint(4) NOT NULL DEFAULT '1' COMMENT '是否显示：0否，1是',
  `sort` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4642 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `li_articles` */

DROP TABLE IF EXISTS `li_articles`;

CREATE TABLE `li_articles` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `catid` int(11) unsigned NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `thumb` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `describe` text COLLATE utf8_unicode_ci,
  `content` longtext COLLATE utf8_unicode_ci NOT NULL,
  `source` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `url` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `sort` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `catid` (`catid`),
  KEY `title` (`title`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `li_attrs` */

DROP TABLE IF EXISTS `li_attrs`;

CREATE TABLE `li_attrs` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `filename` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `li_categorys` */

DROP TABLE IF EXISTS `li_categorys`;

CREATE TABLE `li_categorys` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `parentid` int(11) unsigned NOT NULL,
  `arrparentid` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `child` tinyint(4) NOT NULL,
  `arrchildid` text COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `thumb` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '标题',
  `keyword` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '关键字',
  `describe` text COLLATE utf8_unicode_ci,
  `content` text COLLATE utf8_unicode_ci,
  `theme` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'list' COMMENT '模板',
  `type` tinyint(1) NOT NULL DEFAULT '0',
  `url` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `sort` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `parentid` (`parentid`),
  KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `li_communitys` */

DROP TABLE IF EXISTS `li_communitys`;

CREATE TABLE `li_communitys` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `areaid1` int(11) NOT NULL DEFAULT '0' COMMENT '省',
  `areaid2` int(11) NOT NULL DEFAULT '0' COMMENT '市',
  `areaid3` int(11) NOT NULL DEFAULT '0' COMMENT '县',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '名称',
  `is_show` tinyint(4) NOT NULL DEFAULT '1' COMMENT '是否显示：0否，1是',
  `sort` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=38152 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `li_config` */

DROP TABLE IF EXISTS `li_config`;

CREATE TABLE `li_config` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sitename` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '站点名称',
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'SEO标题',
  `keyword` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '关键字',
  `describe` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '描述',
  `theme` varchar(200) COLLATE utf8_unicode_ci DEFAULT 'default' COMMENT '主题',
  `person` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '联系人',
  `phone` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '联系电话',
  `email` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '邮箱',
  `address` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '地址',
  `content` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '介绍',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `li_groups` */

DROP TABLE IF EXISTS `li_groups`;

CREATE TABLE `li_groups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) COLLATE utf8_unicode_ci NOT NULL COMMENT '用户组名',
  `points` int(11) NOT NULL DEFAULT '1000' COMMENT '所需积分',
  `discount` int(11) NOT NULL DEFAULT '100' COMMENT '折扣',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态，1正常0禁用',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `li_logs` */

DROP TABLE IF EXISTS `li_logs`;

CREATE TABLE `li_logs` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `admin_id` int(11) NOT NULL,
  `user` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `admin_id` (`admin_id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `li_menus` */

DROP TABLE IF EXISTS `li_menus`;

CREATE TABLE `li_menus` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parentid` int(11) NOT NULL,
  `arrparentid` varchar(255) COLLATE utf8_unicode_ci DEFAULT '0',
  `child` tinyint(1) NOT NULL DEFAULT '0',
  `arrchildid` mediumtext COLLATE utf8_unicode_ci,
  `name` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `label` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `icon` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `display` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `sort` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `menus_parentid_index` (`parentid`),
  KEY `menus_url_index` (`url`)
) ENGINE=InnoDB AUTO_INCREMENT=363 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `li_migrations` */

DROP TABLE IF EXISTS `li_migrations`;

CREATE TABLE `li_migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=85 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `li_role_privs` */

DROP TABLE IF EXISTS `li_role_privs`;

CREATE TABLE `li_role_privs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `menu_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  `url` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `label` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `role_privs_roleid_index` (`role_id`),
  KEY `role_privs_url_index` (`url`),
  KEY `role_privs_label_index` (`label`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `li_role_users` */

DROP TABLE IF EXISTS `li_role_users`;

CREATE TABLE `li_role_users` (
  `role_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `li_roles` */

DROP TABLE IF EXISTS `li_roles`;

CREATE TABLE `li_roles` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `li_sections` */

DROP TABLE IF EXISTS `li_sections`;

CREATE TABLE `li_sections` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `li_types` */

DROP TABLE IF EXISTS `li_types`;

CREATE TABLE `li_types` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parentid` int(10) unsigned NOT NULL,
  `arrparentid` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `child` tinyint(4) NOT NULL,
  `arrchildid` text COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `sort` int(10) unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `li_users` */

DROP TABLE IF EXISTS `li_users`;

CREATE TABLE `li_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `gid` int(11) NOT NULL DEFAULT '1' COMMENT '组ID',
  `username` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '用户名',
  `password` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '密码',
  `token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'API登陆用',
  `email` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '邮箱',
  `nickname` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '昵称',
  `thumb` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '头像',
  `sex` tinyint(4) NOT NULL DEFAULT '0' COMMENT '性别',
  `birthday` varchar(25) COLLATE utf8_unicode_ci NOT NULL DEFAULT '1970-00-00' COMMENT '生日',
  `phone` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '手机号',
  `address` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '地址',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态，1正常0禁用',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `li_wxart` */

DROP TABLE IF EXISTS `li_wxart`;

CREATE TABLE `li_wxart` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mid` int(11) NOT NULL DEFAULT '0' COMMENT '所属素材ID',
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '标题',
  `author` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '作者',
  `digest` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '描述',
  `show_cover_pic` tinyint(4) NOT NULL DEFAULT '1' COMMENT '显示封面',
  `thumb` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '封面',
  `media_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '封面',
  `content` text COLLATE utf8_unicode_ci NOT NULL COMMENT '内容',
  `content_source_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '来源',
  `sort` mediumint(9) NOT NULL DEFAULT '0' COMMENT '排序',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `li_wxbroadcast` */

DROP TABLE IF EXISTS `li_wxbroadcast`;

CREATE TABLE `li_wxbroadcast` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '标题',
  `type` char(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '类型',
  `msg_id` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0' COMMENT '发送的消息ID',
  `m_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '对应的素材ID',
  `media_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT '' COMMENT 'media_id',
  `content` varchar(500) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '字符消息内容',
  `openids` text COLLATE utf8_unicode_ci NOT NULL COMMENT '收消息人',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `li_wxmater` */

DROP TABLE IF EXISTS `li_wxmater`;

CREATE TABLE `li_wxmater` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(200) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '名称',
  `type` varchar(200) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'news' COMMENT '类型',
  `media_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'media_id',
  `content` text COLLATE utf8_unicode_ci NOT NULL COMMENT '内容',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `li_wxmenu` */

DROP TABLE IF EXISTS `li_wxmenu`;

CREATE TABLE `li_wxmenu` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(10) unsigned NOT NULL DEFAULT '0',
  `name` varchar(200) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '名称',
  `type` varchar(200) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '类型',
  `setting` text COLLATE utf8_unicode_ci NOT NULL COMMENT '设置',
  `sort` mediumint(9) NOT NULL DEFAULT '0' COMMENT '排序',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `li_wxreply` */

DROP TABLE IF EXISTS `li_wxreply`;

CREATE TABLE `li_wxreply` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `msgtype` char(25) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '消息类型',
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '标题',
  `keyword` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '关键字',
  `replytype` char(25) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '回复类型',
  `mid` int(11) DEFAULT '0' COMMENT '如果是图片等素材，记录素材表ID',
  `media_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '如果是图片等素材，记录media_id',
  `aids` varchar(255) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '文章ID',
  `files` varchar(255) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '如果是图片等素材，记录本地路径',
  `content` text COLLATE utf8_unicode_ci COMMENT '内容',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `li_wxtags` */

DROP TABLE IF EXISTS `li_wxtags`;

CREATE TABLE `li_wxtags` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=103 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `li_wxuser` */

DROP TABLE IF EXISTS `li_wxuser`;

CREATE TABLE `li_wxuser` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `groupid` int(11) NOT NULL DEFAULT '0' COMMENT '分组ID',
  `openid` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'OPENID',
  `nickname` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '昵称',
  `sex` tinyint(4) NOT NULL DEFAULT '0' COMMENT '性别',
  `language` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'zh_CN' COMMENT '语言',
  `city` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `province` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `country` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `headimgurl` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `subscribe` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `subscribe_time` int(11) unsigned NOT NULL DEFAULT '0',
  `remark` varchar(500) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `li_wxuser_tag` */

DROP TABLE IF EXISTS `li_wxuser_tag`;

CREATE TABLE `li_wxuser_tag` (
  `u_id` int(11) NOT NULL,
  `t_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
