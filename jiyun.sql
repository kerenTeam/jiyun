/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : jiyun

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2017-08-18 16:45:15
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for jy_admin_group
-- ----------------------------
DROP TABLE IF EXISTS `jy_admin_group`;
CREATE TABLE `jy_admin_group` (
  `group_id` int(10) NOT NULL AUTO_INCREMENT COMMENT '用户组id',
  `group_name` varchar(10) DEFAULT NULL COMMENT '用户组名',
  `state` int(10) DEFAULT NULL COMMENT '组状态',
  `rules` varchar(5000) DEFAULT NULL COMMENT '规则或权限id',
  PRIMARY KEY (`group_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jy_admin_group
-- ----------------------------
INSERT INTO `jy_admin_group` VALUES ('1', '超级管理员', '1', '1');

-- ----------------------------
-- Table structure for jy_admin_rule
-- ----------------------------
DROP TABLE IF EXISTS `jy_admin_rule`;
CREATE TABLE `jy_admin_rule` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '网站规则权限表',
  `pid` int(10) DEFAULT NULL COMMENT '父级id',
  `name` varchar(200) DEFAULT NULL COMMENT '控制器路径',
  `title` varchar(100) DEFAULT NULL COMMENT '名称',
  `icon` varchar(200) DEFAULT NULL COMMENT 'icon图片',
  `type` varchar(2) DEFAULT '1' COMMENT '类型',
  `status` varchar(2) DEFAULT '1' COMMENT '状态',
  `islink` varchar(100) DEFAULT NULL COMMENT '链接',
  `sort` varchar(10) DEFAULT NULL COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jy_admin_rule
-- ----------------------------

-- ----------------------------
-- Table structure for jy_admin_user
-- ----------------------------
DROP TABLE IF EXISTS `jy_admin_user`;
CREATE TABLE `jy_admin_user` (
  `user_id` int(10) NOT NULL AUTO_INCREMENT COMMENT '后台管理员用户表',
  `group_id` int(10) NOT NULL COMMENT '用户类型  用户组',
  `head_pic` varchar(200) DEFAULT NULL COMMENT '头像',
  `username` varchar(30) DEFAULT NULL COMMENT '用户登陆名',
  `password` varchar(40) NOT NULL COMMENT '密码',
  `user_state` varchar(255) DEFAULT NULL COMMENT '用户状态',
  `create_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jy_admin_user
-- ----------------------------
INSERT INTO `jy_admin_user` VALUES ('1', '1', null, 'admin1', 'e10adc3949ba59abbe56e057f20f883e', '1', '2017-07-25 15:09:53');
INSERT INTO `jy_admin_user` VALUES ('2', '0', null, 'root', 'e10adc3949ba59abbe56e057f20f883e', null, '2017-07-25 15:09:56');

-- ----------------------------
-- Table structure for jy_banner
-- ----------------------------
DROP TABLE IF EXISTS `jy_banner`;
CREATE TABLE `jy_banner` (
  `banner_id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'banner表',
  `banner_pic` varchar(500) DEFAULT NULL COMMENT 'banner 图片',
  `banner_state` varchar(2) DEFAULT '1',
  `banner_url` varchar(200) DEFAULT NULL COMMENT 'banner 链接',
  `create_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`banner_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jy_banner
-- ----------------------------
INSERT INTO `jy_banner` VALUES ('1', 'upload/banner/2017-07-25_083358.jpg', '1', 'http://www.ba123idu.com', '2017-07-25 16:05:24');
INSERT INTO `jy_banner` VALUES ('3', 'upload/banner/2017-07-27_182130.png', '1', 'http://www.baidu.com', '2017-07-27 18:21:30');

-- ----------------------------
-- Table structure for jy_category
-- ----------------------------
DROP TABLE IF EXISTS `jy_category`;
CREATE TABLE `jy_category` (
  `cate_id` int(10) NOT NULL AUTO_INCREMENT COMMENT '分类表',
  `pid` int(10) DEFAULT '0' COMMENT '父级id',
  `type` int(2) DEFAULT '1' COMMENT '类型',
  `cate_name` varchar(100) DEFAULT NULL COMMENT '分类名称',
  `icon` varchar(200) DEFAULT NULL COMMENT 'icon',
  `info` varchar(100) DEFAULT NULL COMMENT 'j简介',
  `keywords` varchar(500) DEFAULT NULL COMMENT '关键字',
  `content` varchar(500) DEFAULT NULL COMMENT '内容',
  `url` varchar(200) DEFAULT NULL COMMENT '链接',
  `sort` int(10) DEFAULT NULL COMMENT '排序',
  `create_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`cate_id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jy_category
-- ----------------------------
INSERT INTO `jy_category` VALUES ('10', '0', '2', '新闻动态', null, '', null, null, null, null, '2017-07-28 15:38:11');
INSERT INTO `jy_category` VALUES ('11', '0', '2', '产品更新', null, '', null, null, null, null, '2017-07-28 15:38:27');
INSERT INTO `jy_category` VALUES ('12', '0', '2', '安全咨讯', null, '', null, null, null, null, '2017-07-28 15:38:50');

-- ----------------------------
-- Table structure for jy_news
-- ----------------------------
DROP TABLE IF EXISTS `jy_news`;
CREATE TABLE `jy_news` (
  `news_id` int(10) NOT NULL AUTO_INCREMENT COMMENT '新闻资讯表',
  `cate_id` int(10) DEFAULT NULL COMMENT '分类id',
  `title` varchar(100) DEFAULT NULL COMMENT '标题',
  `thumb` varchar(300) DEFAULT NULL COMMENT '缩略图',
  `content` text COMMENT '内容',
  `create_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `read` int(10) DEFAULT '0' COMMENT '点击量',
  `state` int(1) DEFAULT '1' COMMENT '状态',
  PRIMARY KEY (`news_id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jy_news
-- ----------------------------
INSERT INTO `jy_news` VALUES ('1', '6', '1234567', 'upload/news/2017-07-26_184838.jpg', '<p><br></p>', '2017-07-26 18:48:38', '0', '1');
INSERT INTO `jy_news` VALUES ('2', '1', '34567', 'upload/news/2017-07-26_185028.png', '\"<p>说法打发打发发到公司分管岁的法国</p><img src=\\\"../upload/news/2017-07-27_0941220.png\\\">\"', '2017-07-26 18:50:28', '0', '1');
INSERT INTO `jy_news` VALUES ('9', '10', '柔柔弱弱', 'upload/news/2017-07-27_095441.png', '<p>尔特瑞特人</p><img src=\"../upload/news/2017-07-27_0954350.png\" class=\"w-e-selected\">', '2017-07-27 09:54:41', '0', '1');
INSERT INTO `jy_news` VALUES ('6', '10', 'dewer', 'upload/news/2017-07-26_193947.png', '\"<p>sfddfadf</p>\"', '2017-07-26 19:39:47', '0', '1');
INSERT INTO `jy_news` VALUES ('7', '10', 'sfdfasdfa', 'upload/news/2017-07-26_194022.png', '<p>sdfdfdgfdgdfgdfdf sdfsdf</p><p>sdfsdfsdf</p><p>sdfdsfdf</p><img src=\"../upload/editer/2017-07-28_1727570.png\"><img src=\"../upload/editer/2017-07-28_1727572.png\" class=\"\">', '2017-07-26 19:40:23', '0', '1');

-- ----------------------------
-- Table structure for jy_parnter
-- ----------------------------
DROP TABLE IF EXISTS `jy_parnter`;
CREATE TABLE `jy_parnter` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '合作伙伴',
  `name` varchar(200) DEFAULT NULL COMMENT '名称',
  `url` varchar(500) DEFAULT NULL COMMENT '链接',
  `logo` varchar(400) DEFAULT NULL COMMENT 'logo图',
  `create_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jy_parnter
-- ----------------------------
INSERT INTO `jy_parnter` VALUES ('2', '345678', '4567890-', 'upload/parnter/2017-07-27_173605.jpg', '2017-07-27 17:36:05');

-- ----------------------------
-- Table structure for jy_product
-- ----------------------------
DROP TABLE IF EXISTS `jy_product`;
CREATE TABLE `jy_product` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '产品表',
  `title` varchar(200) DEFAULT NULL COMMENT '标题',
  `info` varchar(500) DEFAULT NULL COMMENT '简介',
  `price` decimal(20,0) DEFAULT NULL COMMENT '价格',
  `cate_id` int(10) DEFAULT NULL COMMENT '所属分类',
  `thumb` varchar(500) DEFAULT NULL COMMENT '缩略图',
  `content` text COMMENT '内容',
  `state` int(2) DEFAULT '1' COMMENT '产品状态  1正常   0下架',
  `create_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jy_product
-- ----------------------------
INSERT INTO `jy_product` VALUES ('2', '这些都是', '分割风格豆腐干个风格豆腐干豆腐干地方感豆腐干豆腐干豆腐干豆腐干豆腐干大概风格豆腐干', '345654', '7', 'upload/product/2017-07-27_142555.jpg', '<p>打发士大夫士大夫</p>', '0', '2017-07-27 14:25:55');

-- ----------------------------
-- Table structure for jy_system
-- ----------------------------
DROP TABLE IF EXISTS `jy_system`;
CREATE TABLE `jy_system` (
  `id` int(1) NOT NULL COMMENT '网站信息',
  `seotitle` varchar(300) DEFAULT NULL COMMENT 'seo',
  `keywords` varchar(255) DEFAULT NULL COMMENT '关键字',
  `record` varchar(500) DEFAULT NULL COMMENT '备案信息',
  `logo` varchar(500) DEFAULT NULL COMMENT '网站logo',
  `code` varchar(500) DEFAULT NULL COMMENT '二维码地址',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jy_system
-- ----------------------------
INSERT INTO `jy_system` VALUES ('1', '234xcvc', 'dsadasdads', '567', 'upload/banner/2017-07-28_143749.png', 'upload/banner/2017-07-28_1437491.png');

-- ----------------------------
-- Table structure for jy_system_log
-- ----------------------------
DROP TABLE IF EXISTS `jy_system_log`;
CREATE TABLE `jy_system_log` (
  `id` int(10) NOT NULL COMMENT '系统日志表',
  `user_id` int(10) NOT NULL COMMENT '操作人',
  `content` varchar(500) NOT NULL COMMENT '操作内容',
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '操作时间',
  `login_ip` varchar(200) DEFAULT NULL COMMENT '登陆ip',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jy_system_log
-- ----------------------------
