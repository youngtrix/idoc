CREATE TABLE `id_project` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `project_name` varchar(255) DEFAULT NULL COMMENT '项目名称',
  `project_description` text COMMENT '项目描述(简介)',
  `user_id` int(11) DEFAULT NULL COMMENT '项目所属人用户ID',
  `cover_img` varchar(255) DEFAULT '' COMMENT '封面图片url',
  `create_time` timestamp NULL DEFAULT NULL COMMENT '创建时间',
  `update_time` timestamp NULL DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

CREATE TABLE `id_article` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `article_title` varchar(255) DEFAULT NULL COMMENT '文章标题',
  `article_content` text NOT NULL COMMENT '文章内容',
  `parent_id` int(11) DEFAULT NULL COMMENT '父级节点ID',
  `project_id` int(11) DEFAULT NULL COMMENT '项目ID',
  `node_type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '节点类型(0:文章节点,1:目录节点)',
  `order_id` tinyint(4) NOT NULL DEFAULT '10' COMMENT '排序ID',
  `last_edit_uid` int(11) DEFAULT NULL COMMENT '最近一次更新人用户ID',
  `create_time` timestamp NULL DEFAULT NULL COMMENT '创建时间',
  `update_time` timestamp NULL DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

CREATE TABLE `id_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户表,自增ID',
  `username` varchar(36) NOT NULL COMMENT '用户名',
  `password` text NOT NULL COMMENT '密码',
  `mobile` varchar(13) DEFAULT NULL COMMENT '手机号',
  `last_login_time` timestamp NULL DEFAULT NULL COMMENT '最近一次登录时间',
  `create_time` timestamp NULL DEFAULT NULL COMMENT '创建时间',
  `update_time` timestamp NULL DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_user` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;