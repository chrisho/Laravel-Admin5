-- phpMyAdmin SQL Dump
-- version 4.5.3.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 2016-01-02 15:43:31
-- 服务器版本： 10.1.9-MariaDB
-- PHP Version: 5.6.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `admin5`
--

-- --------------------------------------------------------

--
-- 表的结构 `xy_admin_assigned_roles`
--

CREATE TABLE `xy_admin_assigned_roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- 转存表中的数据 `xy_admin_assigned_roles`
--

INSERT INTO `xy_admin_assigned_roles` (`id`, `user_id`, `role_id`) VALUES
(1, 1, 1);

-- --------------------------------------------------------

--
-- 表的结构 `xy_admin_generals`
--

CREATE TABLE `xy_admin_generals` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(64) NOT NULL,
  `action` varchar(128) NOT NULL,
  `general_name` varchar(64) NOT NULL,
  `parent_id` int(10) UNSIGNED NOT NULL,
  `order_by` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- 表的结构 `xy_admin_menus`
--

CREATE TABLE `xy_admin_menus` (
  `id` int(10) UNSIGNED NOT NULL,
  `route` varchar(64) NOT NULL,
  `action` varchar(128) NOT NULL,
  `func` varchar(32) NOT NULL,
  `name` varchar(64) NOT NULL,
  `parent_id` int(10) UNSIGNED NOT NULL,
  `order_by` smallint(5) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- 转存表中的数据 `xy_admin_menus`
--

INSERT INTO `xy_admin_menus` (`id`, `route`, `action`, `func`, `name`, `parent_id`, `order_by`) VALUES
(1, 'admin', 'fa-cogs', '', '管理', 0, 0),
(2, 'admin/users', 'Admin\\UserController', '', '管理员', 1, 0),
(3, 'admin/menu', 'Admin\\MenuController', '', '菜单', 1, 1),
(4, 'admin/role', 'Admin\\RoleController', '', '角色权限', 1, 2),
(5, 'admin/route', 'Admin\\RoutesController', '', '前台路由', 1, 3);

-- --------------------------------------------------------

--
-- 表的结构 `xy_admin_menu_roles`
--

CREATE TABLE `xy_admin_menu_roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL,
  `menu_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- 转存表中的数据 `xy_admin_menu_roles`
--

INSERT INTO `xy_admin_menu_roles` (`id`, `role_id`, `menu_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(11, 1, 3),
(12, 1, 4),
(13, 1, 5);

-- --------------------------------------------------------

--
-- 表的结构 `xy_admin_roles`
--

CREATE TABLE `xy_admin_roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `display_name` varchar(128) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- 转存表中的数据 `xy_admin_roles`
--

INSERT INTO `xy_admin_roles` (`id`, `name`, `display_name`, `created_at`, `updated_at`) VALUES
(1, 'admin', '管理员', '2014-04-21 00:00:05', '2014-04-21 00:00:05');

-- --------------------------------------------------------

--
-- 表的结构 `xy_admin_routes`
--

CREATE TABLE `xy_admin_routes` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(30) NOT NULL,
  `action` varchar(120) NOT NULL,
  `route_name` varchar(120) NOT NULL,
  `other_route` varchar(360) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `priority` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- 转存表中的数据 `xy_admin_routes`
--

INSERT INTO `xy_admin_routes` (`id`, `name`, `action`, `route_name`, `other_route`, `parent_id`, `priority`) VALUES
(1, '测试', '', 'www', '', 0, ''),
(2, '前台首页', 'IndexController', '/', '', 1, '');

-- --------------------------------------------------------

--
-- 表的结构 `xy_admin_users`
--

CREATE TABLE `xy_admin_users` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `truename` varchar(255) NOT NULL,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `password_many` varchar(32) NOT NULL,
  `confirmation_code` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `confirmed` tinyint(1) NOT NULL DEFAULT '0',
  `wechat` varchar(32) NOT NULL,
  `telephone` varchar(32) NOT NULL,
  `token` varchar(255) NOT NULL,
  `remember_token` varchar(32) NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL,
  `updated_at` int(10) UNSIGNED NOT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- 转存表中的数据 `xy_admin_users`
--

INSERT INTO `xy_admin_users` (`id`, `username`, `truename`, `email`, `password`, `password_many`, `confirmation_code`, `confirmed`, `wechat`, `telephone`, `token`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '18688381114', 'admin', 'cenne1986@qq.com', '$2y$10$ixB5rF7fjOzYcWTi1g0NjeiU3sBPfXG9Jq90X6syoiN/DsNl0KbQC', '', '59e5405953f6bef57291616e2799b83e', 1, '', '18688381114', '', '03eC2Rd4As7FNFRXZL6gPXZUeiewNkpk', 1450972800, 1451536736, NULL);
-- --------------------------------------------------------

--
-- 表的结构 `xy_common_settings`
--

CREATE TABLE `xy_common_settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(128) NOT NULL,
  `value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- 转存表中的数据 `xy_common_settings`
--

INSERT INTO `xy_common_settings` (`id`, `name`, `value`) VALUES
(1, 'admin.bootstrap.css', 'admin/bootstrap/css'),
(2, 'admin.font-awesome.css', 'admin/font-awesome/css'),
(3, 'admin.ionicons.css', 'admin/ionicons/css'),
(4, 'admin.dist.css', 'admin/dist/css'),
(5, 'admin.plugins', 'admin/plugins'),
(6, 'admin.bootstrap.js', 'admin/bootstrap/js'),
(11, 'admin.dist.js', 'admin/dist/js');

-- --------------------------------------------------------

--
-- 表的结构 `xy_request_log`
--

CREATE TABLE `xy_request_log` (
  `id` int(10) UNSIGNED NOT NULL,
  `ip` varchar(64) NOT NULL,
  `request` text NOT NULL,
  `url` varchar(360) NOT NULL,
  `start_time` double NOT NULL,
  `end_time` double NOT NULL,
  `sum_time` double NOT NULL,
  `error` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `xy_admin_assigned_roles`
--
ALTER TABLE `xy_admin_assigned_roles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assigned_roles_user_id_index` (`user_id`),
  ADD KEY `assigned_roles_role_id_index` (`role_id`);

--
-- Indexes for table `xy_admin_menus`
--
ALTER TABLE `xy_admin_menus`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parent_id` (`parent_id`);

--
-- Indexes for table `xy_admin_menu_roles`
--
ALTER TABLE `xy_admin_menu_roles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_id` (`role_id`,`menu_id`);

--
-- Indexes for table `xy_admin_roles`
--
ALTER TABLE `xy_admin_roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `xy_admin_routes`
--
ALTER TABLE `xy_admin_routes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `xy_admin_users`
--
ALTER TABLE `xy_admin_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `xy_common_settings`
--
ALTER TABLE `xy_common_settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `xy_request_log`
--
ALTER TABLE `xy_request_log`
  ADD PRIMARY KEY (`id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `xy_admin_assigned_roles`
--
ALTER TABLE `xy_admin_assigned_roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- 使用表AUTO_INCREMENT `xy_admin_menus`
--
ALTER TABLE `xy_admin_menus`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=326;
--
-- 使用表AUTO_INCREMENT `xy_admin_menu_roles`
--
ALTER TABLE `xy_admin_menu_roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
--
-- 使用表AUTO_INCREMENT `xy_admin_roles`
--
ALTER TABLE `xy_admin_roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- 使用表AUTO_INCREMENT `xy_admin_routes`
--
ALTER TABLE `xy_admin_routes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- 使用表AUTO_INCREMENT `xy_admin_users`
--
ALTER TABLE `xy_admin_users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=191;
--
-- 使用表AUTO_INCREMENT `xy_common_settings`
--
ALTER TABLE `xy_common_settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- 使用表AUTO_INCREMENT `xy_request_log`
--
ALTER TABLE `xy_request_log`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
