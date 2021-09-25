CREATE TABLE `tt_user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '用户名',
  `phone` varchar(20) NOT NULL COMMENT '手机号',
  `avatar` varchar(255) NOT NULL DEFAULT '' COMMENT '头像',
  `token` char(32) NOT NULL DEFAULT '' COMMENT '登录token',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0正常 -1删除',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='用户表';

CREATE TABLE `tt_sms_captcha` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(20) NOT NULL COMMENT '类型',
  `phone` varchar(20) NOT NULL COMMENT '手机号码',
  `code` varchar(10) NOT NULL COMMENT 'code',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0正常 -1删除',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='验证码';