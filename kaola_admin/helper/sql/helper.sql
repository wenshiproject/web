-- 管理员账户表
CREATE TABLE IF NOT EXISTS `admin` (
  `admin_id` int(4) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `username` varchar(50) NOT NULL COMMENT '用户名',
  `password` varchar(50) NOT NULL COMMENT '密码',
  `salt` varchar(128) NOT NULL COMMENT '密钥',
  `nickname` varchar(50) NOT NULL COMMENT '昵称',
  `email` varchar(100) DEFAULT NULL COMMENT '邮箱',
  `mobile` varchar(50) DEFAULT NULL COMMENT '手机',
  `stat` tinyint(1) NOT NULL COMMENT '状态| 1正常 2已冻结 3已删除',
  `created_ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `last_logined_ts` timestamp NULL DEFAULT NULL COMMENT '上次登录时间',
  PRIMARY KEY (`admin_id`),
  UNIQUE KEY `uq_username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户管理';

INSERT INTO `admin`(`admin_id`,`username`,`password`,`salt`,`nickname`,`email`,`mobile`,`stat`,`created_ts`,`last_logined_ts`) values (1,'admin','f3c886c6c7fc33b9c373e1d407186c6e','efnn','Bobby','pengbotao@vip.qq.com','',1,'2013-07-22 11:10:40','2013-07-22 16:12:52');