/*
 Navicat Premium Data Transfer

 Source Server         : 服务器
 Source Server Type    : MySQL
 Source Server Version : 50726
 Source Host           : 152.136.182.69:3306
 Source Schema         : chat

 Target Server Type    : MySQL
 Target Server Version : 50726
 File Encoding         : 65001

 Date: 05/01/2022 10:45:06
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for chatrecord
-- ----------------------------
DROP TABLE IF EXISTS `chatrecord`;
CREATE TABLE `chatrecord`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `byid` int(11) NOT NULL,
  `toid` int(11) NOT NULL,
  `text` varchar(1000) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `byisdel` int(11) NOT NULL DEFAULT 0,
  `toisdel` int(11) NOT NULL DEFAULT 0,
  `date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 122 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `username` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `pass` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `img` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `wechat` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `diqu` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `sex` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 14 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

SET FOREIGN_KEY_CHECKS = 1;
