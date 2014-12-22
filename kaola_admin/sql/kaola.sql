/*
SQLyog Ultimate v11.24 (32 bit)
MySQL - 5.1.73 : Database - kaola
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`kaola` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `kaola`;

/*Table structure for table `ws_address` */

DROP TABLE IF EXISTS `ws_address`;

CREATE TABLE `ws_address` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(20) NOT NULL,
  `name` varchar(45) NOT NULL,
  `address` varchar(100) NOT NULL,
  `code` varchar(45) NOT NULL,
  `phone` varchar(45) NOT NULL,
  `add_time` datetime NOT NULL,
  `default` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

/*Table structure for table `ws_collect` */

DROP TABLE IF EXISTS `ws_collect`;

CREATE TABLE `ws_collect` (
  `user_id` varchar(20) NOT NULL,
  `gift_id` int(11) NOT NULL,
  `add_time` datetime NOT NULL,
  PRIMARY KEY (`user_id`,`gift_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Table structure for table `ws_company` */

DROP TABLE IF EXISTS `ws_company`;

CREATE TABLE `ws_company` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `name` varchar(45) NOT NULL,
  `address` varchar(45) NOT NULL COMMENT '地址',
  `email` varchar(45) NOT NULL COMMENT '邮箱',
  `phone` int(11) NOT NULL COMMENT '手机号码',
  `contact` varchar(20) NOT NULL COMMENT '联系人',
  `status` tinyint(4) NOT NULL COMMENT '状态',
  `license_image` varchar(200) DEFAULT NULL COMMENT '执照图片路径',
  `add_time` datetime NOT NULL COMMENT '添加时间',
  `pass_time` datetime NOT NULL COMMENT '审核通过时间',
  `identity` int(11) NOT NULL DEFAULT '1' COMMENT '1 公司 2 个人',
  `qq` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='游戏开发商表';

/*Table structure for table `ws_game` */

DROP TABLE IF EXISTS `ws_game`;

CREATE TABLE `ws_game` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `name` varchar(20) NOT NULL COMMENT '游戏名称',
  `key` varchar(40) NOT NULL COMMENT '游戏秘钥',
  `gift_id` tinyint(4) NOT NULL COMMENT '关联奖品ID',
  `status` tinyint(4) NOT NULL COMMENT '状态',
  `desc` varchar(60) NOT NULL COMMENT '简介',
  `icon` varchar(200) DEFAULT NULL,
  `add_time` datetime NOT NULL COMMENT '添加时间',
  `company_id` int(11) NOT NULL,
  `down_url` varchar(200) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_ws_game_ws_company1_idx` (`company_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='游戏表';

/*Table structure for table `ws_gift` */

DROP TABLE IF EXISTS `ws_gift`;

CREATE TABLE `ws_gift` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '礼品自增ID',
  `name` varchar(60) NOT NULL COMMENT '礼品名称',
  `code` varchar(60) NOT NULL COMMENT '编码',
  `number` int(11) NOT NULL COMMENT '数量',
  `price` decimal(2,0) NOT NULL COMMENT '价格',
  `desc` varchar(255) NOT NULL COMMENT '介绍',
  `image_path` varchar(200) DEFAULT NULL,
  `image_width` int(3) DEFAULT '0',
  `image_height` int(3) DEFAULT '0',
  `game_cond` varchar(60) NOT NULL COMMENT '获得条件',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态：0 未上架 1 上架  2 下架 -1 已删除',
  `add_time` datetime NOT NULL COMMENT '添加时间',
  `notice_num` int(11) NOT NULL COMMENT '通知次数',
  `notice_last_time` datetime NOT NULL COMMENT '最后通知时间',
  `favorites` int(11) NOT NULL DEFAULT '0' COMMENT '收藏次数',
  `supplier_id` int(11) NOT NULL,
  `game_id` int(11) NOT NULL,
  `added_time` datetime DEFAULT NULL,
  `down_time` datetime DEFAULT NULL,
  `is_show` tinyint(4) NOT NULL DEFAULT '0',
  `wish_num` int(11) NOT NULL DEFAULT '0',
  `order_num` int(11) NOT NULL DEFAULT '0',
  `broadcast_img` varchar(50) NOT NULL DEFAULT '' COMMENT '???',
  PRIMARY KEY (`id`),
  KEY `fk_ws_gift_ws_supplier1_idx` (`supplier_id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 COMMENT='奖品表';

/*Table structure for table `ws_order` */

DROP TABLE IF EXISTS `ws_order`;

CREATE TABLE `ws_order` (
  `id` varchar(20) NOT NULL COMMENT '自增ID',
  `user_id` varchar(20) NOT NULL,
  `captcha` varchar(20) NOT NULL COMMENT '验证码',
  `address_id` int(11) NOT NULL COMMENT '收货地址',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态 0  未验证  1 未审核  2   已审核',
  `order_time` datetime NOT NULL COMMENT '订单生成时间',
  `finish_time` datetime NOT NULL,
  `logistics_status` tinyint(4) NOT NULL COMMENT '物流状态',
  `logistics_num` varchar(40) NOT NULL COMMENT '物流号',
  `gift_id` int(11) NOT NULL,
  `game_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ugg_index` (`user_id`,`gift_id`,`game_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='订单表';

/*Table structure for table `ws_supplier` */

DROP TABLE IF EXISTS `ws_supplier`;

CREATE TABLE `ws_supplier` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '供应商自增ID',
  `name` varchar(60) NOT NULL COMMENT '名称',
  `address` varchar(60) NOT NULL COMMENT '地址',
  `email` varchar(30) NOT NULL COMMENT '邮箱地址',
  `phone` int(11) NOT NULL COMMENT '手机号码',
  `contact` varchar(45) NOT NULL COMMENT '联系人',
  `status` tinyint(4) NOT NULL COMMENT '状态 0 未认证 1 认证 -1 已删除',
  `add_time` datetime NOT NULL COMMENT '添加时间',
  `qq` int(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='供应商';

/*Table structure for table `ws_sysmsg` */

DROP TABLE IF EXISTS `ws_sysmsg`;

CREATE TABLE `ws_sysmsg` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `image_path` varchar(200) DEFAULT NULL,
  `title` varchar(40) NOT NULL COMMENT '标题',
  `content` varchar(60) NOT NULL COMMENT '介绍',
  `add_time` datetime NOT NULL COMMENT '添加时间',
  `push_time` datetime NOT NULL COMMENT '最后推送时间',
  `status` int(11) NOT NULL DEFAULT '0' COMMENT '是否推送，0 未推送 1 已推送',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='系统大礼包';

/*Table structure for table `ws_user` */

DROP TABLE IF EXISTS `ws_user`;

CREATE TABLE `ws_user` (
  `id` varchar(20) NOT NULL,
  `code` varchar(20) NOT NULL,
  `passwd` varchar(45) NOT NULL,
  `reg_time` datetime NOT NULL,
  `last_login_time` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `phone_UNIQUE` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `ws_wish` */

DROP TABLE IF EXISTS `ws_wish`;

CREATE TABLE `ws_wish` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `wish_num` int(11) NOT NULL DEFAULT '0',
  `wish_last_time` varchar(45) NOT NULL,
  `add_time` varchar(45) NOT NULL,
  `title` varchar(45) NOT NULL,
  `content` varchar(200) NOT NULL,
  `image` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
