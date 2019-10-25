-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: 2019-10-25 09:53:20
-- 服务器版本： 5.7.19-log
-- PHP Version: 7.2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `xycmf_xi_yi_net`
--

-- --------------------------------------------------------

--
-- 表的结构 `admins`
--

CREATE TABLE `admins` (
  `id` int(11) UNSIGNED NOT NULL,
  `section_id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `realname` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `crypt` char(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `lasttime` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `lastip` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `status` tinyint(3) UNSIGNED NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `admins`
--

INSERT INTO `admins` (`id`, `section_id`, `name`, `realname`, `email`, `password`, `crypt`, `phone`, `lasttime`, `lastip`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'admin', 'admins', 'fsda@eee.com', '348db1ff89cb53c0e8912371be92e107', 'ZYsX1M8xIc', '13123212345', '2019-10-25 00:41:47', '127.0.0.1', 1, '2016-08-07 02:05:54', '2019-10-25 00:41:47'),
(2, 1, 'admin22', 'adminss', 'fsda@eee.com', '0a270bd0c5f834ca8394ab944c8a4db2', 'Q5X2B26mxt', '13123212345', '2018-12-26 09:35:11', '127.0.0.1', 1, '2016-08-07 02:05:54', '2018-12-26 09:35:11');

-- --------------------------------------------------------

--
-- 表的结构 `ads`
--

CREATE TABLE `ads` (
  `id` int(10) UNSIGNED NOT NULL,
  `pos_id` int(11) NOT NULL DEFAULT '0' COMMENT '位置ID',
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '标题',
  `thumb` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '图片',
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '链接',
  `starttime` timestamp NULL DEFAULT NULL COMMENT '开始时间',
  `endtime` timestamp NULL DEFAULT NULL COMMENT '结束时间',
  `sort` mediumint(8) UNSIGNED NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态，1正常0关闭',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `ad_pos`
--

CREATE TABLE `ad_pos` (
  `id` int(10) UNSIGNED NOT NULL,
  `is_mobile` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0:PC/1:MOB',
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '名称',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `articles`
--

CREATE TABLE `articles` (
  `id` int(11) UNSIGNED NOT NULL,
  `cate_id` int(11) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keywords` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '关键字',
  `thumb` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `describe` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `source` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sort` mediumint(8) UNSIGNED NOT NULL DEFAULT '0',
  `hits` int(11) NOT NULL DEFAULT '99' COMMENT '点击量',
  `publish_at` timestamp NULL DEFAULT NULL,
  `push_flag` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1推荐，0不推荐',
  `url` char(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tpl` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'show',
  `del_flag` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1删除，0正常',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `articles`
--

INSERT INTO `articles` (`id`, `cate_id`, `title`, `keywords`, `thumb`, `describe`, `content`, `source`, `sort`, `hits`, `publish_at`, `push_flag`, `url`, `tpl`, `del_flag`, `created_at`, `updated_at`) VALUES
(1, 1, 'dddd', 'asd', NULL, 'ddd', 'dsasda', NULL, 2, 99, '2018-11-29 00:50:52', 0, 'sss', 'show', 0, '2018-11-29 00:50:45', '2018-11-29 11:12:12'),
(2, 1, 'dddd', 'asd', NULL, 'ddd', 'dsasda', NULL, 10, 11, '2018-11-29 02:50:52', 0, 'sss', 'show', 0, '2018-11-29 00:50:45', '2018-11-30 02:42:14');

-- --------------------------------------------------------

--
-- 表的结构 `attrs`
--

CREATE TABLE `attrs` (
  `id` int(11) UNSIGNED NOT NULL,
  `filename` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `categorys`
--

CREATE TABLE `categorys` (
  `id` int(11) UNSIGNED NOT NULL,
  `parentid` int(11) UNSIGNED NOT NULL,
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
  `sort` mediumint(8) UNSIGNED NOT NULL DEFAULT '0',
  `url` char(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `categorys`
--

INSERT INTO `categorys` (`id`, `parentid`, `arrparentid`, `child`, `arrchildid`, `name`, `thumb`, `title`, `keyword`, `describe`, `content`, `cate_tpl`, `art_tpl`, `display`, `type`, `sort`, `url`, `created_at`, `updated_at`) VALUES
(1, 0, '0,1', 0, '1', '11111', NULL, NULL, NULL, NULL, NULL, 'list', 'show', 1, 0, 0, '111', '2018-11-29 00:50:17', '2018-11-29 00:50:19'),
(2, 0, '0,2', 0, '2', '2222', NULL, NULL, NULL, NULL, NULL, 'list', 'show', 1, 0, 0, '111', '2018-11-29 00:50:17', '2018-11-29 00:50:19');

-- --------------------------------------------------------

--
-- 表的结构 `config`
--

CREATE TABLE `config` (
  `id` int(10) UNSIGNED NOT NULL,
  `sitename` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '站点名称',
  `describe` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '描述',
  `person` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '联系人',
  `phone` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '联系电话',
  `email` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '邮箱',
  `address` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '地址',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `config`
--

INSERT INTO `config` (`id`, `sitename`, `describe`, `person`, `phone`, `email`, `address`, `created_at`, `updated_at`) VALUES
(1, '山木枝', '前后端分离RBAC管理基础框架', '李', '18932813211', 'lzhigang@shanmuzhi.com', '地址：河北省衡水市育才街永兴路口逸升佳苑29号楼3A02', NULL, '2018-12-08 06:23:29');

-- --------------------------------------------------------

--
-- 表的结构 `groups`
--

CREATE TABLE `groups` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '用户组名',
  `points` int(11) NOT NULL DEFAULT '1000' COMMENT '所需积分',
  `discount` int(11) NOT NULL DEFAULT '100' COMMENT '折扣',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态，1正常0禁用',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `groups`
--

INSERT INTO `groups` (`id`, `name`, `points`, `discount`, `status`, `created_at`, `updated_at`) VALUES
(1, '普通用户', 0, 100, 1, '2017-04-20 08:56:40', '2017-07-22 01:45:33'),
(2, '铜牌用户', 1000, 98, 1, '2017-04-20 08:56:51', '2017-06-20 01:29:09'),
(3, '银牌用户', 2000, 96, 1, '2017-06-14 09:21:03', '2017-06-20 01:30:16'),
(4, '金牌用户', 5000, 93, 1, '2017-06-14 09:21:20', '2017-06-20 01:30:27'),
(5, '钻石用户', 10000, 90, 1, '2017-06-14 09:21:36', '2017-06-20 01:30:34');

-- --------------------------------------------------------

--
-- 表的结构 `logs`
--

CREATE TABLE `logs` (
  `id` int(11) UNSIGNED NOT NULL,
  `admin_id` int(11) NOT NULL,
  `user` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `method` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `action_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '操作名',
  `data` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `menus`
--

CREATE TABLE `menus` (
  `id` int(10) UNSIGNED NOT NULL,
  `parentid` int(11) NOT NULL,
  `arrparentid` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `child` tinyint(1) NOT NULL DEFAULT '0',
  `arrchildid` mediumtext COLLATE utf8mb4_unicode_ci,
  `name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `label` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `display` tinyint(3) UNSIGNED NOT NULL DEFAULT '1',
  `sort` mediumint(8) UNSIGNED NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `menus`
--

INSERT INTO `menus` (`id`, `parentid`, `arrparentid`, `child`, `arrchildid`, `name`, `url`, `label`, `icon`, `display`, `sort`, `created_at`, `updated_at`) VALUES
(5, 0, '0', 1, '5,10,6,7,8,9,354,355,11,12,13,14,15,358,359,16,17,18,19,140,357,67,68,170,171,172,173,356,20,21,353,22,23,24,25,26,361,362,363,28,75,30,31,32,33,34,121,136,242,243,244,245,246,247,300,301,302,303,143,144,145,367,151,152,153,154,360,205', '系统', 'sys/index', 'sys-index', NULL, 1, 98, '2016-03-18 07:47:40', '2019-10-25 01:42:31'),
(6, 10, '0,5,10', 1, '6,7,8,9,354,355', '权限菜单管理', 'menu/tree', 'menu-tree', NULL, 1, 1, '2016-03-18 07:48:07', '2019-10-25 01:36:36'),
(7, 6, '0,5,10,6', 0, '7', '添加菜单', 'menu/create', 'menu-create', NULL, 0, 0, '2016-03-18 07:49:03', '2019-10-25 01:36:36'),
(8, 6, '0,5,10,6', 0, '8', '修改菜单', 'menu/edit', 'menu-edit', NULL, 0, 0, '2016-03-18 07:51:08', '2019-10-25 01:36:36'),
(9, 6, '0,5,10,6', 0, '9', '删除菜单', 'menu/remove', 'menu-remove', NULL, 0, 0, '2016-03-18 07:51:30', '2019-10-25 01:36:36'),
(10, 5, '0,5', 1, '10,6,7,8,9,354,355,11,12,13,14,15,358,359,16,17,18,19,140,357,67,68,170,171,172,173,356', '管理员管理', 'admin/manage', 'admin-manage', 'ios-people-outline', 1, 97, '2016-03-18 08:04:01', '2019-10-25 01:36:36'),
(11, 10, '0,5,10', 1, '11,12,13,14,15,358,359', '用户管理', 'admin/list', 'admin-list', NULL, 1, 0, '2016-03-18 08:04:38', '2019-10-25 01:36:36'),
(12, 11, '0,5,10,11', 0, '12', '添加用户', 'admin/create', 'admin-create', NULL, 0, 0, '2016-03-18 08:05:14', '2019-10-25 01:36:36'),
(13, 11, '0,5,10,11', 0, '13', '修改用户', 'admin/editinfo', 'admin-editinfo', NULL, 0, 0, '2016-03-18 08:06:10', '2019-10-25 01:36:36'),
(14, 11, '0,5,10,11', 0, '14', '删除用户', 'admin/remove', 'admin-remove', NULL, 0, 0, '2016-03-18 08:06:31', '2019-10-25 01:36:37'),
(15, 11, '0,5,10,11', 0, '15', '修改密码', 'admin/editpassword', 'admin-editpassword', NULL, 0, 0, '2016-03-18 08:07:07', '2019-10-25 01:36:37'),
(16, 10, '0,5,10', 1, '16,17,18,19,140,357', '角色管理', 'role/list', 'role-list', NULL, 1, 0, '2016-03-18 08:07:58', '2019-10-25 01:36:37'),
(17, 16, '0,5,10,16', 0, '17', '添加角色', 'role/create', 'role-create', NULL, 0, 0, '2016-03-18 08:08:23', '2019-10-25 01:36:37'),
(18, 16, '0,5,10,16', 0, '18', '修改角色', 'role/edit', 'role-edit', NULL, 0, 0, '2016-03-18 08:08:50', '2019-10-25 01:36:37'),
(19, 16, '0,5,10,16', 0, '19', '删除角色', 'role/remove', 'role-remove', NULL, 0, 0, '2016-03-18 08:09:10', '2019-10-25 01:36:37'),
(20, 5, '0,5', 1, '20,21,353', '所有人都要有的权限', 'index/main', 'index-main', NULL, 0, 99, '2016-03-24 07:42:14', '2019-10-25 01:36:59'),
(21, 20, '0,5,20', 0, '21', '左侧菜单', 'menu/list', 'menu-list', NULL, 1, 0, '2016-03-25 02:34:44', '2019-10-25 01:36:59'),
(22, 5, '0,5', 1, '22,23,24,25,26,361,362,363,28,75,30,31,32,33,34,121,136,242,243,244,245,246,247,300,301,302,303', '内容管理', 'content/manage', 'content-manage', 'ios-basketball-outline', 1, 0, '2016-03-29 00:39:52', '2019-10-25 01:36:20'),
(23, 22, '0,5,22', 1, '23,24,25,26,361,362,363', '栏目管理', 'cate/list', 'cate-list', NULL, 1, 0, '2016-03-29 00:40:08', '2019-10-25 01:36:20'),
(24, 23, '0,5,22,23', 0, '24', '添加栏目', 'cate/create', 'cate-create', NULL, 1, 0, '2016-03-29 00:40:25', '2019-10-25 01:36:20'),
(25, 23, '0,5,22,23', 0, '25', '修改栏目', 'cate/edit', 'cate-edit', NULL, 0, 0, '2016-03-29 00:40:42', '2019-10-25 01:36:20'),
(26, 23, '0,5,22,23', 0, '26', '删除栏目', 'cate/remove', 'cate-remove', NULL, 0, 0, '2016-03-29 00:40:54', '2019-10-25 01:36:20'),
(28, 22, '0,5,22', 1, '28,75', '附件管理', 'attr/index', 'attr-index', NULL, 0, 5, '2016-03-31 00:23:28', '2019-10-25 01:36:21'),
(30, 22, '0,5,22', 1, '30,31,32,33,34,121,136', '文章管理', 'article/list', 'article-list', NULL, 1, 0, '2016-03-31 00:25:22', '2019-10-25 01:36:21'),
(31, 30, '0,5,22,30', 0, '31', '添加文章', 'article/create', 'article-create', NULL, 1, 0, '2016-03-31 00:25:40', '2019-10-25 01:36:21'),
(32, 30, '0,5,22,30', 0, '32', '修改文章', 'article/edit', 'article-edit', NULL, 0, 0, '2016-03-31 00:25:59', '2019-10-25 01:36:21'),
(33, 30, '0,5,22,30', 0, '33', '删除文章', 'article/remove', 'article-remove', NULL, 0, 0, '2016-03-31 00:26:15', '2019-10-25 01:36:21'),
(34, 30, '0,5,22,30', 0, '34', '查看文章', 'article/detail', 'article-detail', NULL, 0, 0, '2016-03-31 00:26:35', '2019-10-25 01:36:21'),
(67, 10, '0,5,10', 1, '67,68', '操作日志', 'log/list', 'log-list', NULL, 1, 4, '2016-04-11 02:38:34', '2019-10-25 01:36:37'),
(68, 67, '0,5,10,67', 0, '68', '清除7天前日志', 'log/clear', 'log-clear', NULL, 0, 0, '2016-04-11 02:38:53', '2019-10-25 01:36:37'),
(75, 28, '0,5,22,28', 0, '75', '删除附件', 'attr/delfile', 'attr-delfile', NULL, 0, 0, '2016-05-09 11:29:09', '2019-10-25 01:36:21'),
(121, 30, '0,5,22,30', 0, '121', '批量删除', 'article/deleteall', 'article-deleteall', NULL, 0, 0, '2016-06-15 00:52:32', '2019-10-25 01:36:21'),
(136, 30, '0,5,22,30', 0, '136', '文章排序', 'article/sort', 'article-sort', NULL, 0, 0, '2016-07-25 00:35:42', '2019-10-25 01:36:21'),
(140, 16, '0,5,10,16', 0, '140', '角色权限', 'role/priv', 'role-priv', NULL, 0, 0, '2016-07-25 03:34:39', '2019-10-25 01:36:37'),
(143, 5, '0,5', 1, '143,144,145', '资料', 'admin/info', 'admin-info', 'ios-outlet-outline', 1, 99, '2016-07-28 06:01:45', '2019-10-25 01:37:11'),
(144, 143, '0,5,143', 0, '144', '修改个人资料', 'admin/selfeditinfo', 'admin-selfeditinfo', NULL, 1, 0, '2016-07-28 06:02:12', '2019-10-25 01:37:11'),
(145, 143, '0,5,143', 0, '145', '修改个人密码', 'admin/selfeditpassword', 'admin-selfeditpassword', NULL, 1, 0, '2016-07-28 06:02:37', '2019-10-25 01:37:11'),
(151, 367, '0,5,367', 1, '151,152,153,154,360', '分类管理', 'type/list', 'type-list', NULL, 1, 2, '2016-12-14 01:56:01', '2019-10-25 01:42:31'),
(152, 151, '0,5,367,151', 0, '152', '添加分类', 'type/create', 'type-create', NULL, 0, 0, '2016-12-14 01:56:23', '2019-10-25 01:42:31'),
(153, 151, '0,5,367,151', 0, '153', '修改分类', 'type/edit', 'type-edit', NULL, 0, 0, '2016-12-14 01:56:42', '2019-10-25 01:42:31'),
(154, 151, '0,5,367,151', 0, '154', '删除分类', 'type/remove', 'type-remove', NULL, 0, 0, '2016-12-14 01:56:57', '2019-10-25 01:42:31'),
(170, 10, '0,5,10', 1, '170,171,172,173,356', '部门管理', 'section/list', 'section-list', NULL, 1, 0, '2016-12-15 00:31:39', '2019-10-25 01:36:37'),
(171, 170, '0,5,10,170', 0, '171', '添加部门', 'section/create', 'section-create', NULL, 0, 0, '2016-12-15 00:32:01', '2019-10-25 01:36:37'),
(172, 170, '0,5,10,170', 0, '172', '修改部门', 'section/edit', 'section-edit', NULL, 0, 0, '2016-12-15 00:32:23', '2019-10-25 01:36:37'),
(173, 170, '0,5,10,170', 0, '173', '删除部门', 'section/remove', 'section-remove', NULL, 0, 0, '2016-12-15 00:32:44', '2019-10-25 01:36:37'),
(194, 0, '0', 1, '194,366,195,196,197,198,199,200,201', '会员', 'member/manage', 'member-manage', NULL, 0, 0, '2017-03-17 00:30:28', '2019-10-25 01:49:51'),
(195, 366, '0,194,366', 1, '195,196,197,198', '会员组', 'group/index', 'group-index', NULL, 1, 0, '2017-03-17 00:30:46', '2019-10-25 01:40:19'),
(196, 195, '0,194,366,195', 0, '196', '添加会员组', 'group/add', 'group-add', NULL, 1, 0, '2017-03-17 00:31:05', '2019-10-25 01:40:19'),
(197, 195, '0,194,366,195', 0, '197', '修改会员组', 'group/edit', 'group-edit', NULL, 0, 0, '2017-03-17 00:31:25', '2019-10-25 01:40:20'),
(198, 195, '0,194,366,195', 0, '198', '删除会员组', 'group/del', 'group-del', NULL, 0, 0, '2017-03-17 00:31:40', '2019-10-25 01:40:20'),
(199, 366, '0,194,366', 1, '199,200,201', '会员列表', 'user/index', 'user-index', NULL, 1, 0, '2017-03-17 00:33:22', '2019-10-25 01:40:30'),
(200, 199, '0,194,366,199', 0, '200', '禁用会员', 'user/status', 'user-status', NULL, 0, 0, '2017-03-17 00:34:25', '2019-10-25 01:40:30'),
(201, 199, '0,194,366,199', 0, '201', '修改会员', 'user/edit', 'user/edit', NULL, 0, 0, '2017-03-17 00:34:46', '2019-10-25 01:40:30'),
(205, 367, '0,5,367', 0, '205', '系统配置', 'config/index', 'config-index', 'icon-brightnesshigh', 1, 0, '2017-04-25 13:49:13', '2019-10-25 01:42:18'),
(242, 22, '0,5,22', 1, '242,243,244,245,246,247', '广告管理', 'ad/index', 'ad-index', NULL, 0, 0, '2017-05-15 22:34:07', '2019-10-25 01:36:21'),
(243, 242, '0,5,22,242', 0, '243', '添加广告', 'ad/add', 'ad-add', NULL, 1, 0, '2017-05-15 22:34:25', '2019-10-25 01:36:21'),
(244, 242, '0,5,22,242', 0, '244', '修改广告', 'ad/edit', 'ad-edit', NULL, 0, 0, '2017-05-15 22:34:40', '2019-10-25 01:36:22'),
(245, 242, '0,5,22,242', 0, '245', '删除广告', 'ad/del', 'ad-del', NULL, 0, 0, '2017-05-15 22:34:55', '2019-10-25 01:36:22'),
(246, 242, '0,5,22,242', 0, '246', '广告排序', 'ad/sort', 'ad-sort', NULL, 0, 0, '2017-05-15 22:35:11', '2019-10-25 01:36:22'),
(247, 242, '0,5,22,242', 0, '247', '批量删除广告', 'ad/alldel', 'ad-alldel', NULL, 0, 0, '2017-05-15 22:35:35', '2019-10-25 01:36:22'),
(300, 22, '0,5,22', 1, '300,301,302,303', '广告位管理', 'adpos/index', 'adpos-index', 'icon-slideshow', 0, 0, '2017-07-01 01:19:12', '2019-10-25 01:36:22'),
(301, 300, '0,5,22,300', 0, '301', '添加广告位', 'adpos/add', 'adpos-add', NULL, 1, 0, '2017-07-01 01:19:37', '2019-10-25 01:36:22'),
(302, 300, '0,5,22,300', 0, '302', '修改广告位', 'adpos/edit', 'adpos-edit', NULL, 0, 0, '2017-07-01 01:19:59', '2019-10-25 01:36:22'),
(303, 300, '0,5,22,300', 0, '303', '删除广告位', 'adpos/del', 'adpos-del', NULL, 0, 0, '2017-07-01 01:20:21', '2019-10-25 01:36:22'),
(353, 20, '0,5,20', 0, '353', '面包屑', 'breadcrumb/list', 'breadcrumb-list', NULL, 1, 0, '2018-12-08 00:41:35', '2019-10-25 01:36:59'),
(354, 6, '0,5,10,6', 0, '354', '权限菜单下拉选框', 'menu/select', 'menu-select', NULL, 0, 0, '2018-12-08 00:44:56', '2019-10-25 01:36:37'),
(355, 6, '0,5,10,6', 0, '355', '查询权限菜单', 'menu/detail', 'menu-detail', NULL, 0, 0, '2018-12-08 00:49:46', '2019-10-25 01:36:38'),
(356, 170, '0,5,10,170', 0, '356', '修改部门状态', 'section/status', 'section-status', NULL, 0, 0, '2018-12-08 00:52:03', '2019-10-25 01:36:38'),
(357, 16, '0,5,10,16', 0, '357', '修改角色状态', 'role/status', 'role-status', NULL, 0, 0, '2018-12-08 00:53:26', '2019-10-25 01:36:38'),
(358, 11, '0,5,10,11', 0, '358', '修改用户状态', 'admin/status', 'admin-status', NULL, 0, 0, '2018-12-08 00:57:40', '2019-10-25 01:36:38'),
(359, 11, '0,5,10,11', 0, '359', '查看用户信息', 'admin/detail', 'admin-detail', NULL, 0, 0, '2018-12-08 00:57:59', '2019-10-25 01:36:38'),
(360, 151, '0,5,367,151', 0, '360', '分类排序', 'type/sort', 'type-sort', NULL, 0, 0, '2018-12-09 03:04:37', '2019-10-25 01:42:31'),
(361, 23, '0,5,22,23', 0, '361', '查看栏目', 'cate/detail', 'cate-detail', NULL, 0, 0, '2018-12-26 09:20:25', '2019-10-25 01:36:22'),
(362, 23, '0,5,22,23', 0, '362', '栏目下拉', 'cate/select', 'cate-select', NULL, 0, 0, '2018-12-26 09:20:43', '2019-10-25 01:36:22'),
(363, 23, '0,5,22,23', 0, '363', '栏目排序', 'cate/sort', 'cate-sort', NULL, 0, 0, '2018-12-26 09:21:05', '2019-10-25 01:36:22'),
(366, 194, '0,194', 1, '366,195,196,197,198,199,200,201', '会员管理', 'member/index', 'member-index', 'ios-person-outline', 1, 0, '2019-10-25 01:39:50', '2019-10-25 01:40:30'),
(367, 5, '0,5', 1, '367,151,152,153,154,360,205', '系统设置', 'system/index', 'system-index', 'ios-cog-outline', 1, 0, '2019-10-25 01:41:20', '2019-10-25 01:42:31');

-- --------------------------------------------------------

--
-- 表的结构 `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `roles`
--

CREATE TABLE `roles` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(3) UNSIGNED NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `roles`
--

INSERT INTO `roles` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, '超级管理员', 1, '2016-03-18 08:42:51', '2018-12-06 02:03:36'),
(3, '三个d', 1, '2018-12-04 12:40:12', '2018-12-04 12:46:12'),
(4, 'sd', 1, '2018-12-06 03:34:22', '2018-12-06 03:34:22'),
(5, 'dd', 1, '2018-12-06 03:34:50', '2018-12-06 03:34:50'),
(6, '111', 1, '2018-12-06 03:35:09', '2018-12-06 03:58:19');

-- --------------------------------------------------------

--
-- 表的结构 `role_privs`
--

CREATE TABLE `role_privs` (
  `id` int(10) UNSIGNED NOT NULL,
  `menu_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL,
  `url` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `label` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `role_privs`
--

INSERT INTO `role_privs` (`id`, `menu_id`, `role_id`, `url`, `label`, `created_at`, `updated_at`) VALUES
(106, 22, 1, 'content/manage', 'content-manage', '2018-12-06 03:35:57', '2018-12-06 03:35:57'),
(107, 23, 1, 'cate/index', 'cate-index', '2018-12-06 03:35:57', '2018-12-06 03:35:57'),
(108, 24, 1, 'cate/add', 'cate-add', '2018-12-06 03:35:57', '2018-12-06 03:35:57'),
(109, 25, 1, 'cate/edit', 'cate-edit', '2018-12-06 03:35:57', '2018-12-06 03:35:57'),
(110, 26, 1, 'cate/del', 'cate-del', '2018-12-06 03:35:57', '2018-12-06 03:35:57'),
(111, 27, 1, 'cate/cache', 'cate-cache', '2018-12-06 03:35:57', '2018-12-06 03:35:57'),
(112, 28, 1, 'attr/index', 'attr-index', '2018-12-06 03:35:57', '2018-12-06 03:35:57'),
(113, 30, 1, 'art/index', 'art-index', '2018-12-06 03:35:57', '2018-12-06 03:35:57'),
(114, 31, 1, 'art/add', 'art-add', '2018-12-06 03:35:57', '2018-12-06 03:35:57'),
(115, 32, 1, 'art/edit', 'art-edit', '2018-12-06 03:35:57', '2018-12-06 03:35:57'),
(116, 33, 1, 'art/del', 'art-del', '2018-12-06 03:35:57', '2018-12-06 03:35:57'),
(117, 34, 1, 'art/show', 'art-show', '2018-12-06 03:35:57', '2018-12-06 03:35:57'),
(118, 75, 1, 'attr/delfile', 'attr-delfile', '2018-12-06 03:35:57', '2018-12-06 03:35:57'),
(119, 121, 1, 'art/alldel', 'art-alldel', '2018-12-06 03:35:57', '2018-12-06 03:35:57'),
(120, 136, 1, 'art/listorder', 'art-listorder', '2018-12-06 03:35:57', '2018-12-06 03:35:57'),
(121, 151, 1, 'type/index', 'type-index', '2018-12-06 03:35:57', '2018-12-06 03:35:57'),
(122, 152, 1, 'type/add', 'type-add', '2018-12-06 03:35:57', '2018-12-06 03:35:57'),
(123, 153, 1, 'type/edit', 'type-edit', '2018-12-06 03:35:57', '2018-12-06 03:35:57'),
(124, 154, 1, 'type/del', 'type-del', '2018-12-06 03:35:57', '2018-12-06 03:35:57'),
(125, 194, 1, 'user/manage', 'user-manage', '2018-12-06 03:35:57', '2018-12-06 03:35:57'),
(126, 195, 1, 'group/index', 'group-index', '2018-12-06 03:35:57', '2018-12-06 03:35:57'),
(127, 196, 1, 'group/add', 'group-add', '2018-12-06 03:35:57', '2018-12-06 03:35:57'),
(128, 197, 1, 'group/edit', 'group-edit', '2018-12-06 03:35:57', '2018-12-06 03:35:57'),
(129, 198, 1, 'group/del', 'group-del', '2018-12-06 03:35:57', '2018-12-06 03:35:57'),
(130, 199, 1, 'user/index', 'user-index', '2018-12-06 03:35:57', '2018-12-06 03:35:57'),
(131, 200, 1, 'user/status', 'user-status', '2018-12-06 03:35:57', '2018-12-06 03:35:57'),
(132, 201, 1, 'user/edit', 'user/edit', '2018-12-06 03:35:57', '2018-12-06 03:35:57'),
(133, 242, 1, 'ad/index', 'ad-index', '2018-12-06 03:35:57', '2018-12-06 03:35:57'),
(134, 243, 1, 'ad/add', 'ad-add', '2018-12-06 03:35:57', '2018-12-06 03:35:57'),
(135, 244, 1, 'ad/edit', 'ad-edit', '2018-12-06 03:35:57', '2018-12-06 03:35:57'),
(136, 245, 1, 'ad/del', 'ad-del', '2018-12-06 03:35:57', '2018-12-06 03:35:57'),
(137, 246, 1, 'ad/sort', 'ad-sort', '2018-12-06 03:35:57', '2018-12-06 03:35:57'),
(138, 247, 1, 'ad/alldel', 'ad-alldel', '2018-12-06 03:35:57', '2018-12-06 03:35:57'),
(139, 300, 1, 'adpos/index', 'adpos-index', '2018-12-06 03:35:57', '2018-12-06 03:35:57'),
(140, 301, 1, 'adpos/add', 'adpos-add', '2018-12-06 03:35:57', '2018-12-06 03:35:57'),
(141, 302, 1, 'adpos/edit', 'adpos-edit', '2018-12-06 03:35:57', '2018-12-06 03:35:57'),
(142, 303, 1, 'adpos/del', 'adpos-del', '2018-12-06 03:35:57', '2018-12-06 03:35:57'),
(143, 342, 1, 'art/select', 'art-select', '2018-12-06 03:35:57', '2018-12-06 03:35:57'),
(144, 343, 1, 'model/index', 'model-index', '2018-12-06 03:35:57', '2018-12-06 03:35:57'),
(145, 344, 1, 'model/add', 'model-add', '2018-12-06 03:35:57', '2018-12-06 03:35:57'),
(146, 345, 1, 'model/edit', 'model-edit', '2018-12-06 03:35:57', '2018-12-06 03:35:57'),
(147, 346, 1, 'model/del', 'model-del', '2018-12-06 03:35:57', '2018-12-06 03:35:57'),
(148, 347, 1, 'field/index', 'field-index', '2018-12-06 03:35:57', '2018-12-06 03:35:57'),
(149, 348, 1, 'field/add', 'field-add', '2018-12-06 03:35:57', '2018-12-06 03:35:57'),
(150, 349, 1, 'field/edit', 'field-edit', '2018-12-06 03:35:57', '2018-12-06 03:35:57'),
(151, 350, 1, 'field/del', 'field-del', '2018-12-06 03:35:57', '2018-12-06 03:35:57'),
(152, 351, 1, 'model/view', 'model-view', '2018-12-06 03:35:57', '2018-12-06 03:35:57'),
(193, 6, 4, 'menu/tree', 'menu-tree', '2018-12-26 09:17:17', '2018-12-26 09:17:17'),
(194, 7, 4, 'menu/create', 'menu-create', '2018-12-26 09:17:17', '2018-12-26 09:17:17'),
(195, 8, 4, 'menu/edit', 'menu-edit', '2018-12-26 09:17:17', '2018-12-26 09:17:17'),
(196, 9, 4, 'menu/remove', 'menu-remove', '2018-12-26 09:17:17', '2018-12-26 09:17:17'),
(197, 10, 4, 'admin/manage', 'admin-manage', '2018-12-26 09:17:17', '2018-12-26 09:17:17'),
(198, 11, 4, 'admin/list', 'admin-list', '2018-12-26 09:17:17', '2018-12-26 09:17:17'),
(199, 12, 4, 'admin/create', 'admin-create', '2018-12-26 09:17:17', '2018-12-26 09:17:17'),
(200, 13, 4, 'admin/editinfo', 'admin-editinfo', '2018-12-26 09:17:17', '2018-12-26 09:17:17'),
(201, 14, 4, 'admin/remove', 'admin-remove', '2018-12-26 09:17:17', '2018-12-26 09:17:17'),
(202, 15, 4, 'admin/editpassword', 'admin-editpassword', '2018-12-26 09:17:17', '2018-12-26 09:17:17'),
(203, 16, 4, 'role/list', 'role-list', '2018-12-26 09:17:17', '2018-12-26 09:17:17'),
(204, 17, 4, 'role/create', 'role-create', '2018-12-26 09:17:17', '2018-12-26 09:17:17'),
(205, 18, 4, 'role/edit', 'role-edit', '2018-12-26 09:17:17', '2018-12-26 09:17:17'),
(206, 19, 4, 'role/remove', 'role-remove', '2018-12-26 09:17:17', '2018-12-26 09:17:17'),
(207, 20, 4, 'index/main', 'index-main', '2018-12-26 09:17:17', '2018-12-26 09:17:17'),
(208, 21, 4, 'menu/list', 'menu-list', '2018-12-26 09:17:17', '2018-12-26 09:17:17'),
(209, 67, 4, 'log/list', 'log-list', '2018-12-26 09:17:17', '2018-12-26 09:17:17'),
(210, 68, 4, 'log/clear', 'log-clear', '2018-12-26 09:17:17', '2018-12-26 09:17:17'),
(211, 140, 4, 'role/priv', 'role-priv', '2018-12-26 09:17:17', '2018-12-26 09:17:17'),
(212, 170, 4, 'section/list', 'section-list', '2018-12-26 09:17:17', '2018-12-26 09:17:17'),
(213, 171, 4, 'section/create', 'section-create', '2018-12-26 09:17:17', '2018-12-26 09:17:17'),
(214, 172, 4, 'section/edit', 'section-edit', '2018-12-26 09:17:17', '2018-12-26 09:17:17'),
(215, 173, 4, 'section/remove', 'section-remove', '2018-12-26 09:17:17', '2018-12-26 09:17:17'),
(216, 194, 4, 'user/manage', 'user-manage', '2018-12-26 09:17:17', '2018-12-26 09:17:17'),
(217, 195, 4, 'group/index', 'group-index', '2018-12-26 09:17:17', '2018-12-26 09:17:17'),
(218, 196, 4, 'group/add', 'group-add', '2018-12-26 09:17:17', '2018-12-26 09:17:17'),
(219, 197, 4, 'group/edit', 'group-edit', '2018-12-26 09:17:17', '2018-12-26 09:17:17'),
(220, 198, 4, 'group/del', 'group-del', '2018-12-26 09:17:17', '2018-12-26 09:17:17'),
(221, 199, 4, 'user/index', 'user-index', '2018-12-26 09:17:17', '2018-12-26 09:17:17'),
(222, 200, 4, 'user/status', 'user-status', '2018-12-26 09:17:17', '2018-12-26 09:17:17'),
(223, 201, 4, 'user/edit', 'user/edit', '2018-12-26 09:17:17', '2018-12-26 09:17:17'),
(224, 353, 4, 'breadcrumb/list', 'breadcrumb-list', '2018-12-26 09:17:17', '2018-12-26 09:17:17'),
(225, 354, 4, 'menu/select', 'menu-select', '2018-12-26 09:17:17', '2018-12-26 09:17:17'),
(226, 355, 4, 'menu/detail', 'menu-detail', '2018-12-26 09:17:17', '2018-12-26 09:17:17'),
(227, 356, 4, 'section/status', 'section-status', '2018-12-26 09:17:17', '2018-12-26 09:17:17'),
(228, 357, 4, 'role/status', 'role-status', '2018-12-26 09:17:17', '2018-12-26 09:17:17'),
(229, 358, 4, 'admin/status', 'admin-status', '2018-12-26 09:17:17', '2018-12-26 09:17:17'),
(230, 359, 4, 'admin/detail', 'admin-detail', '2018-12-26 09:17:17', '2018-12-26 09:17:17'),
(231, 20, 3, 'index/main', 'index-main', '2018-12-26 09:24:50', '2018-12-26 09:24:50'),
(232, 21, 3, 'menu/list', 'menu-list', '2018-12-26 09:24:50', '2018-12-26 09:24:50'),
(233, 22, 3, 'content/manage', 'content-manage', '2018-12-26 09:24:50', '2018-12-26 09:24:50'),
(234, 23, 3, 'cate/list', 'cate-list', '2018-12-26 09:24:50', '2018-12-26 09:24:50'),
(235, 24, 3, 'cate/create', 'cate-create', '2018-12-26 09:24:50', '2018-12-26 09:24:50'),
(236, 25, 3, 'cate/edit', 'cate-edit', '2018-12-26 09:24:50', '2018-12-26 09:24:50'),
(237, 26, 3, 'cate/remove', 'cate-remove', '2018-12-26 09:24:50', '2018-12-26 09:24:50'),
(238, 28, 3, 'attr/index', 'attr-index', '2018-12-26 09:24:50', '2018-12-26 09:24:50'),
(239, 30, 3, 'article/list', 'article-list', '2018-12-26 09:24:50', '2018-12-26 09:24:50'),
(240, 31, 3, 'article/create', 'article-create', '2018-12-26 09:24:50', '2018-12-26 09:24:50'),
(241, 32, 3, 'article/edit', 'article-edit', '2018-12-26 09:24:50', '2018-12-26 09:24:50'),
(242, 33, 3, 'article/remove', 'article-remove', '2018-12-26 09:24:50', '2018-12-26 09:24:50'),
(243, 34, 3, 'article/detail', 'article-detail', '2018-12-26 09:24:50', '2018-12-26 09:24:50'),
(244, 75, 3, 'attr/delfile', 'attr-delfile', '2018-12-26 09:24:50', '2018-12-26 09:24:50'),
(245, 121, 3, 'article/deleteall', 'article-deleteall', '2018-12-26 09:24:50', '2018-12-26 09:24:50'),
(246, 136, 3, 'article/sort', 'article-sort', '2018-12-26 09:24:50', '2018-12-26 09:24:50'),
(247, 242, 3, 'ad/index', 'ad-index', '2018-12-26 09:24:50', '2018-12-26 09:24:50'),
(248, 243, 3, 'ad/add', 'ad-add', '2018-12-26 09:24:50', '2018-12-26 09:24:50'),
(249, 244, 3, 'ad/edit', 'ad-edit', '2018-12-26 09:24:50', '2018-12-26 09:24:50'),
(250, 245, 3, 'ad/del', 'ad-del', '2018-12-26 09:24:50', '2018-12-26 09:24:50'),
(251, 246, 3, 'ad/sort', 'ad-sort', '2018-12-26 09:24:50', '2018-12-26 09:24:50'),
(252, 247, 3, 'ad/alldel', 'ad-alldel', '2018-12-26 09:24:50', '2018-12-26 09:24:50'),
(253, 300, 3, 'adpos/index', 'adpos-index', '2018-12-26 09:24:50', '2018-12-26 09:24:50'),
(254, 301, 3, 'adpos/add', 'adpos-add', '2018-12-26 09:24:50', '2018-12-26 09:24:50'),
(255, 302, 3, 'adpos/edit', 'adpos-edit', '2018-12-26 09:24:50', '2018-12-26 09:24:50'),
(256, 303, 3, 'adpos/del', 'adpos-del', '2018-12-26 09:24:50', '2018-12-26 09:24:50'),
(257, 353, 3, 'breadcrumb/list', 'breadcrumb-list', '2018-12-26 09:24:50', '2018-12-26 09:24:50'),
(258, 361, 3, 'cate/detail', 'cate-detail', '2018-12-26 09:24:50', '2018-12-26 09:24:50'),
(259, 362, 3, 'cate/select', 'cate-select', '2018-12-26 09:24:50', '2018-12-26 09:24:50'),
(260, 363, 3, 'cate/sort', 'cate-sort', '2018-12-26 09:24:50', '2018-12-26 09:24:50');

-- --------------------------------------------------------

--
-- 表的结构 `role_users`
--

CREATE TABLE `role_users` (
  `role_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `role_users`
--

INSERT INTO `role_users` (`role_id`, `user_id`) VALUES
(1, 1),
(3, 2),
(4, 2);

-- --------------------------------------------------------

--
-- 表的结构 `sections`
--

CREATE TABLE `sections` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `sections`
--

INSERT INTO `sections` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, '市场', 1, '2016-12-15 00:43:05', '2018-12-26 09:31:00'),
(2, '开发', 1, '2018-12-04 12:24:30', '2018-12-04 12:26:07');

-- --------------------------------------------------------

--
-- 表的结构 `types`
--

CREATE TABLE `types` (
  `id` int(10) UNSIGNED NOT NULL,
  `parentid` int(10) UNSIGNED NOT NULL,
  `arrparentid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `child` tinyint(4) DEFAULT NULL,
  `arrchildid` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `name` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sort` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `types`
--

INSERT INTO `types` (`id`, `parentid`, `arrparentid`, `child`, `arrchildid`, `name`, `sort`, `created_at`, `updated_at`) VALUES
(1, 0, '0', 1, '1,2', '联动一个', 0, '2018-10-26 02:05:04', '2018-10-26 02:05:13'),
(2, 1, '0,1', 0, '2', '中国', 0, '2018-10-26 02:05:12', '2018-10-26 02:05:13'),
(5, 4, '0', 1, '5,6', '444', 0, '2018-12-09 02:24:48', '2018-12-09 02:57:53'),
(6, 5, '0', 0, '6', '555', 2, '2018-12-09 02:24:54', '2018-12-09 02:57:53');

-- --------------------------------------------------------

--
-- 表的结构 `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
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
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ads`
--
ALTER TABLE `ads`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ad_pos`
--
ALTER TABLE `ad_pos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `url` (`url`),
  ADD KEY `cate_id` (`cate_id`);

--
-- Indexes for table `attrs`
--
ALTER TABLE `attrs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categorys`
--
ALTER TABLE `categorys`
  ADD PRIMARY KEY (`id`),
  ADD KEY `url` (`url`);

--
-- Indexes for table `config`
--
ALTER TABLE `config`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admin_id` (`admin_id`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_privs`
--
ALTER TABLE `role_privs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_privs_roleid_index` (`role_id`),
  ADD KEY `role_privs_url_index` (`url`),
  ADD KEY `role_privs_label_index` (`label`);

--
-- Indexes for table `sections`
--
ALTER TABLE `sections`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `types`
--
ALTER TABLE `types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `openid` (`openid`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 使用表AUTO_INCREMENT `ads`
--
ALTER TABLE `ads`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `ad_pos`
--
ALTER TABLE `ad_pos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `articles`
--
ALTER TABLE `articles`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 使用表AUTO_INCREMENT `attrs`
--
ALTER TABLE `attrs`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `categorys`
--
ALTER TABLE `categorys`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 使用表AUTO_INCREMENT `config`
--
ALTER TABLE `config`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 使用表AUTO_INCREMENT `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- 使用表AUTO_INCREMENT `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `menus`
--
ALTER TABLE `menus`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=368;

--
-- 使用表AUTO_INCREMENT `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- 使用表AUTO_INCREMENT `role_privs`
--
ALTER TABLE `role_privs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=261;

--
-- 使用表AUTO_INCREMENT `sections`
--
ALTER TABLE `sections`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 使用表AUTO_INCREMENT `types`
--
ALTER TABLE `types`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- 使用表AUTO_INCREMENT `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
