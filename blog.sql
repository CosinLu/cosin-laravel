/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 50717
 Source Host           : 127.0.0.1
 Source Database       : blog

 Target Server Type    : MySQL
 Target Server Version : 50717
 File Encoding         : utf-8

 Date: 08/29/2017 22:16:21 PM
*/

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `admins`
-- ----------------------------
DROP TABLE IF EXISTS `admins`;
CREATE TABLE `admins` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '用户状态,默认1:可用,0:不可用',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admins_username_unique` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
--  Records of `admins`
-- ----------------------------
BEGIN;
INSERT INTO `admins` VALUES ('1', 'cosin', '$2y$10$WlxftmCtFbFipo06MrLB6.CWsPBoM/cDSL5/.s0NWJ0ijRe779oIW', '1', '2017-08-05 19:02:52', '2017-08-11 10:47:20'), ('4', 'xiaoxin', '$2y$10$Hj3Ig.mWU7Dc5x8qSHD5euY5DGyCeAdvoAapQD/m60AiXNW8N4d9e', '1', '2017-08-05 19:06:45', '2017-08-06 12:11:18'), ('5', 'admin', '$2y$10$fTl6DH20RKbcWJ5XXpVmPubWVC0/xNXpQsEksdSIM.DhHLQnxrnxK', '1', '2017-08-05 21:45:38', '2017-08-06 00:06:39'), ('6', 'huazai', '$2y$10$jPsVand/S4Xc3h.MtV3/ruY8XzdkcSAEX//RKjjajq.iCh8xuS4ie', '1', '2017-08-05 21:57:38', '2017-08-06 00:06:31'), ('7', 'root1', '$2y$10$6g9kg8Ro6reJf0IR1JOpTuZtk5Yz46LN6u1M8vkto/UsGCcz3XjT6', '1', '2017-08-10 09:51:16', '2017-08-10 13:35:33');
COMMIT;

-- ----------------------------
--  Table structure for `answer_user`
-- ----------------------------
DROP TABLE IF EXISTS `answer_user`;
CREATE TABLE `answer_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `answer_id` int(10) unsigned NOT NULL,
  `vote` smallint(5) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `answer_user_user_id_answer_id_vote_unique` (`user_id`,`answer_id`,`vote`),
  KEY `answer_user_answer_id_foreign` (`answer_id`),
  CONSTRAINT `answer_user_answer_id_foreign` FOREIGN KEY (`answer_id`) REFERENCES `answers` (`id`),
  CONSTRAINT `answer_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
--  Table structure for `answers`
-- ----------------------------
DROP TABLE IF EXISTS `answers`;
CREATE TABLE `answers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `question_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `answers_user_id_foreign` (`user_id`),
  KEY `answers_question_id_foreign` (`question_id`),
  CONSTRAINT `answers_question_id_foreign` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`),
  CONSTRAINT `answers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
--  Records of `answers`
-- ----------------------------
BEGIN;
INSERT INTO `answers` VALUES ('1', 'nothing', '3', '1', '2017-07-23 21:46:23', '2017-07-23 21:46:23'), ('2', 'nothing', '2', '1', '2017-07-23 21:57:55', '2017-07-23 21:57:55');
COMMIT;

-- ----------------------------
--  Table structure for `comments`
-- ----------------------------
DROP TABLE IF EXISTS `comments`;
CREATE TABLE `comments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `question_id` int(10) unsigned DEFAULT NULL,
  `answer_id` int(10) unsigned DEFAULT NULL,
  `reply_to` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `comments_user_id_foreign` (`user_id`),
  KEY `comments_question_id_foreign` (`question_id`),
  KEY `comments_answer_id_foreign` (`answer_id`),
  KEY `comments_reply_to_foreign` (`reply_to`),
  CONSTRAINT `comments_answer_id_foreign` FOREIGN KEY (`answer_id`) REFERENCES `answers` (`id`),
  CONSTRAINT `comments_question_id_foreign` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`),
  CONSTRAINT `comments_reply_to_foreign` FOREIGN KEY (`reply_to`) REFERENCES `comments` (`id`),
  CONSTRAINT `comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
--  Records of `comments`
-- ----------------------------
BEGIN;
INSERT INTO `comments` VALUES ('2', '沙发lalala', '2', '1', null, null, '2017-07-29 09:40:42', '2017-07-29 09:40:42');
COMMIT;

-- ----------------------------
--  Table structure for `logs`
-- ----------------------------
DROP TABLE IF EXISTS `logs`;
CREATE TABLE `logs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL COMMENT '用户id',
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '用户名',
  `modules` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '操作模块',
  `desc` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '操作详情',
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'success' COMMENT '是否操作成功',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
--  Records of `logs`
-- ----------------------------
BEGIN;
INSERT INTO `logs` VALUES ('1', '2', 'cosin', null, '管理员cosin登录', 'success', '2017-08-03 22:39:39', '2017-08-03 22:39:39'), ('2', '2', 'cosin', null, '管理员cosin登录', 'success', '2017-08-05 15:58:59', '2017-08-05 15:58:59'), ('3', '2', 'cosin', null, '管理员cosin登录', 'success', '2017-08-05 21:34:41', '2017-08-05 21:34:41'), ('4', '1', 'cosin', null, '管理员cosin登录', 'success', '2017-08-05 21:35:30', '2017-08-05 21:35:30'), ('5', '5', 'admin', null, '管理员admin登录', 'success', '2017-08-06 12:08:25', '2017-08-06 12:08:25'), ('6', '1', 'cosin', null, '管理员cosin登录', 'success', '2017-08-06 12:28:03', '2017-08-06 12:28:03'), ('7', '1', 'cosin', null, '管理员cosin登录', 'success', '2017-08-06 16:53:10', '2017-08-06 16:53:10'), ('8', '1', 'cosin', null, '管理员cosin登录', 'success', '2017-08-06 23:01:05', '2017-08-06 23:01:05'), ('9', '1', 'cosin', null, '管理员cosin登录', 'success', '2017-08-07 10:36:19', '2017-08-07 10:36:19'), ('10', '1', 'cosin', null, '管理员cosin登录', 'success', '2017-08-07 16:40:02', '2017-08-07 16:40:02'), ('11', '1', 'cosin', null, '管理员cosin登录', 'success', '2017-08-08 09:13:36', '2017-08-08 09:13:36'), ('12', '1', 'cosin', null, '管理员cosin登录', 'success', '2017-08-08 16:00:37', '2017-08-08 16:00:37'), ('13', '1', 'cosin', null, '管理员cosin登录', 'success', '2017-08-08 20:55:32', '2017-08-08 20:55:32'), ('14', '1', 'cosin', null, '管理员cosin登录', 'success', '2017-08-09 09:34:59', '2017-08-09 09:34:59'), ('15', '1', 'cosin', null, '管理员cosin登录', 'success', '2017-08-09 14:14:52', '2017-08-09 14:14:52'), ('16', '1', 'cosin', null, '管理员cosin登录', 'success', '2017-08-09 18:00:26', '2017-08-09 18:00:26'), ('17', '1', 'cosin', null, '管理员cosin登录', 'success', '2017-08-10 09:24:26', '2017-08-10 09:24:26'), ('18', '1', 'cosin', null, '管理员cosin登录', 'success', '2017-08-10 12:05:22', '2017-08-10 12:05:22'), ('19', '1', 'cosin', null, '管理员cosin修改ID为7的管理员登录密码', 'success', '2017-08-10 13:19:55', '2017-08-10 13:19:55'), ('20', '1', 'cosin', null, '管理员cosin修改ID为7的管理员登录密码', 'success', '2017-08-10 13:19:55', '2017-08-10 13:19:55'), ('21', '1', 'cosin', null, '管理员cosin修改ID为7的管理员登录密码', 'success', '2017-08-10 13:20:05', '2017-08-10 13:20:05'), ('22', '1', 'cosin', null, '管理员cosin修改ID为7的管理员登录密码', 'success', '2017-08-10 13:26:07', '2017-08-10 13:26:07'), ('23', '1', 'cosin', null, '管理员cosin修改ID为7的管理员登录密码', 'success', '2017-08-10 13:26:55', '2017-08-10 13:26:55'), ('24', '1', 'cosin', null, '管理员cosin修改ID为7的管理员登录密码', 'success', '2017-08-10 13:34:55', '2017-08-10 13:34:55'), ('25', '1', 'cosin', null, '管理员cosin修改ID为7的管理员登录密码', 'success', '2017-08-10 13:35:18', '2017-08-10 13:35:18'), ('26', '1', 'cosin', null, '管理员cosin修改ID为7的管理员登录密码', 'success', '2017-08-10 13:35:33', '2017-08-10 13:35:33'), ('27', '1', 'cosin', null, '管理员cosin登录', 'success', '2017-08-11 07:49:29', '2017-08-11 07:49:29'), ('28', '1', 'cosin', null, '管理员cosin登录', 'success', '2017-08-11 10:45:01', '2017-08-11 10:45:01'), ('29', '1', 'cosin', null, '管理员cosin修改ID为1的管理员信息', 'success', '2017-08-11 10:47:20', '2017-08-11 10:47:20'), ('30', '1', 'cosin', null, '管理员cosin添加权限首页', 'success', '2017-08-11 10:48:38', '2017-08-11 10:48:38'), ('31', '1', 'cosin', null, '管理员cosin添加权限权限管理', 'success', '2017-08-11 10:49:11', '2017-08-11 10:49:11'), ('32', '1', 'cosin', null, '管理员cosin编辑角色超级管理员', 'success', '2017-08-11 10:49:27', '2017-08-11 10:49:27'), ('33', '1', 'cosin', null, '管理员cosin添加权限删除管理员', 'success', '2017-08-11 11:17:53', '2017-08-11 11:17:53'), ('34', '1', 'cosin', null, '管理员cosin登录', 'success', '2017-08-17 11:03:04', '2017-08-17 11:03:04'), ('35', '1', 'cosin', null, '管理员cosin登录', 'success', '2017-08-22 16:34:23', '2017-08-22 16:34:23'), ('36', '1', 'cosin', null, '管理员cosin登录', 'success', '2017-08-23 12:21:16', '2017-08-23 12:21:16'), ('37', '1', 'cosin', null, '管理员cosin登录', 'success', '2017-08-29 07:24:45', '2017-08-29 07:24:45');
COMMIT;

-- ----------------------------
--  Table structure for `migrations`
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
--  Records of `migrations`
-- ----------------------------
BEGIN;
INSERT INTO `migrations` VALUES ('4', '2017_07_23_143645_create_table_users', '1'), ('6', '2017_07_23_180548_create_table_questions', '2'), ('8', '2017_07_23_210650_create_table_answers', '3'), ('9', '2017_07_29_092231_create_table_comments', '4'), ('12', '2017_07_29_191306_create_table_answer_user', '5'), ('18', '2017_08_03_221206_create_logs_table', '6'), ('22', '2017_08_05_160200_create_admins_table', '7'), ('24', '2017_08_05_212838_entrust_setup_tables', '8');
COMMIT;

-- ----------------------------
--  Table structure for `permission_role`
-- ----------------------------
DROP TABLE IF EXISTS `permission_role`;
CREATE TABLE `permission_role` (
  `permission_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `permission_role_role_id_foreign` (`role_id`),
  CONSTRAINT `permission_role_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `permission_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
--  Records of `permission_role`
-- ----------------------------
BEGIN;
INSERT INTO `permission_role` VALUES ('1', '1'), ('2', '1'), ('3', '1'), ('4', '1'), ('5', '1'), ('1', '2'), ('2', '2'), ('3', '2');
COMMIT;

-- ----------------------------
--  Table structure for `permissions`
-- ----------------------------
DROP TABLE IF EXISTS `permissions`;
CREATE TABLE `permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pid` tinyint(4) NOT NULL DEFAULT '0',
  `display_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
--  Records of `permissions`
-- ----------------------------
BEGIN;
INSERT INTO `permissions` VALUES ('1', '/admin', '0', '管理员列表查看', '查看管理员模块', '2017-08-08 09:19:02', '2017-08-08 09:19:02'), ('2', '/admin/edit', '1', '修改管理员密码', '修改管理员的密码', '2017-08-08 09:25:32', '2017-08-08 09:25:32'), ('3', '/auth/editRole', '1', '编辑角色', '对角色编辑或者添加', '2017-08-09 18:15:17', '2017-08-09 18:15:17'), ('4', '/', '0', '首页', '查看首页', '2017-08-11 10:48:38', '2017-08-11 10:48:38'), ('5', '/auth', '0', '权限管理', '权限管理页面', '2017-08-11 10:49:11', '2017-08-11 10:49:11'), ('6', '/admin/del', '1', '删除管理员', '删除管理员操作', '2017-08-11 11:17:53', '2017-08-11 11:17:53');
COMMIT;

-- ----------------------------
--  Table structure for `questions`
-- ----------------------------
DROP TABLE IF EXISTS `questions`;
CREATE TABLE `questions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `desc` text COLLATE utf8mb4_unicode_ci COMMENT '描述',
  `user_id` int(10) unsigned NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ok',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `questions_user_id_foreign` (`user_id`),
  CONSTRAINT `questions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
--  Records of `questions`
-- ----------------------------
BEGIN;
INSERT INTO `questions` VALUES ('1', '地球怎么成了圆的', null, '2', 'ok', '2017-07-23 18:27:23', '2017-07-23 18:37:06'), ('2', 'test', null, '2', 'ok', '2017-07-23 20:48:52', '2017-07-23 20:48:52'), ('3', 'test', null, '2', 'ok', '2017-07-23 20:50:02', '2017-07-23 20:50:02'), ('4', 'test', null, '2', 'ok', '2017-07-23 20:50:03', '2017-07-23 20:50:03'), ('5', 'test', null, '2', 'ok', '2017-07-23 20:50:03', '2017-07-23 20:50:03'), ('6', 'test', null, '2', 'ok', '2017-07-23 20:50:03', '2017-07-23 20:50:03'), ('7', 'test', null, '2', 'ok', '2017-07-23 20:50:04', '2017-07-23 20:50:04'), ('8', 'test', null, '2', 'ok', '2017-07-23 20:50:04', '2017-07-23 20:50:04'), ('9', 'test', null, '2', 'ok', '2017-07-23 20:50:04', '2017-07-23 20:50:04'), ('10', 'test', null, '2', 'ok', '2017-07-23 20:50:05', '2017-07-23 20:50:05'), ('11', 'test', null, '2', 'ok', '2017-07-23 20:50:05', '2017-07-23 20:50:05'), ('12', 'test', null, '2', 'ok', '2017-07-23 20:50:05', '2017-07-23 20:50:05'), ('13', 'test', null, '2', 'ok', '2017-07-23 20:50:05', '2017-07-23 20:50:05'), ('14', 'test', null, '2', 'ok', '2017-07-23 20:50:05', '2017-07-23 20:50:05'), ('15', 'test', null, '2', 'ok', '2017-07-23 20:50:06', '2017-07-23 20:50:06'), ('16', 'test', null, '2', 'ok', '2017-07-23 20:50:06', '2017-07-23 20:50:06'), ('17', 'test', null, '2', 'ok', '2017-07-23 20:50:06', '2017-07-23 20:50:06'), ('18', 'test', null, '2', 'ok', '2017-07-23 20:50:06', '2017-07-23 20:50:06'), ('19', 'test', null, '2', 'ok', '2017-07-23 20:50:07', '2017-07-23 20:50:07'), ('20', 'test', null, '2', 'ok', '2017-07-23 20:50:07', '2017-07-23 20:50:07');
COMMIT;

-- ----------------------------
--  Table structure for `role_user`
-- ----------------------------
DROP TABLE IF EXISTS `role_user`;
CREATE TABLE `role_user` (
  `user_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`role_id`),
  KEY `role_user_role_id_foreign` (`role_id`),
  CONSTRAINT `role_user_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `role_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `admins` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
--  Records of `role_user`
-- ----------------------------
BEGIN;
INSERT INTO `role_user` VALUES ('1', '1');
COMMIT;

-- ----------------------------
--  Table structure for `roles`
-- ----------------------------
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
--  Records of `roles`
-- ----------------------------
BEGIN;
INSERT INTO `roles` VALUES ('1', 'admin', '超级管理员', '超级管理员', '2017-08-09 19:44:17', '2017-08-11 10:49:27'), ('2', 'admin1', '超级管理员1', '超级管理员1', '2017-08-09 23:31:45', '2017-08-10 09:39:09');
COMMIT;

-- ----------------------------
--  Table structure for `users`
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar_url` text COLLATE utf8mb4_unicode_ci,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `intro` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_username_unique` (`username`),
  UNIQUE KEY `users_phone_unique` (`phone`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
--  Records of `users`
-- ----------------------------
BEGIN;
INSERT INTO `users` VALUES ('2', 'cosin', null, null, null, '$2y$10$3KzrwuF1LPiqS0mBHC6JaOSqUFQI62J.V/Ua6O1TBILrfVxLYOaKm', null, '2017-07-23 15:46:19', '2017-07-23 15:46:19'), ('3', 'aaa', null, null, null, '$2y$10$L7gDhrwBUbtJnmDsyb5JHO8JnTp0Bf33QpwnaS58Oo7fWv8NKrm2K', null, '2017-07-23 21:04:22', '2017-07-23 21:04:22');
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
