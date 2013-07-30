CREATE TABLE IF NOT EXISTS `img` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hash_code` varchar(32) NOT NULL,
  `file_path` varchar(64) NOT NULL,
  `expire_time` int(11) NOT NULL COMMENT '过期时间戳',
  `width` mediumint(6) NOT NULL DEFAULT '0' COMMENT '图片宽度',
  `height` mediumint(6) NOT NULL DEFAULT '0' COMMENT '图片高度',
  `size` int(11) NOT NULL DEFAULT '0' COMMENT '图片大小 单位为byte',
  `mime` varchar(32) NOT NULL DEFAULT '' COMMENT '图片extension',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `ip` varchar(15) NOT NULL DEFAULT '' COMMENT 'ip地址',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态 0为不可用 1为可用',
  PRIMARY KEY (`id`),
  UNIQUE KEY `ind_hash_code` (`hash_code`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '用户类型：1 为普通用户\\n\\n\\n99 为超级管理员',
  `email` varchar(45) NOT NULL,
  `nick_name` varchar(45) NOT NULL,
  `password` char(40) NOT NULL,
  `salt` char(8) NOT NULL,
  `sex` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `photo` varchar(200) NOT NULL COMMENT '头像',
  `register_ip` varchar(45) DEFAULT NULL,
  `register_time` int(10) unsigned DEFAULT NULL,
  `email_checked` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0为email未验证 \\n1为已验证',
  `score` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '积分',
  `signature` varchar(200) DEFAULT NULL COMMENT '签名档',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email_UNIQUE` (`email`),
  UNIQUE KEY `nick_name_UNIQUE` (`nick_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='用户表' AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `user`
--

INSERT INTO `user` (`id`, `user_type`, `email`, `nick_name`, `password`, `salt`, `sex`, `photo`, `register_ip`, `register_time`, `email_checked`, `score`, `signature`, `status`) VALUES
(1, 1, '157000131@qq.com', 'admin', 'db6fafd115ab2557d79e9ec4d20454f3ac3a1201', 'fa129d', 1, '', '127.0.0.1', NULL, 0, 0, NULL, 1);


ALTER TABLE  `img` ADD  `start_time` INT( 11 ) NOT NULL DEFAULT  '0' COMMENT  '生效开始时间' AFTER  `file_path`;