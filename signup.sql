# Host: localhost  (Version 5.5.53)
# Date: 2019-03-11 17:22:40
# Generator: MySQL-Front 6.0  (Build 2.20)


#
# Structure for table "class"
#

CREATE TABLE `class` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `name` varchar(30) NOT NULL DEFAULT '' COMMENT '专业班级名称',
  `delete_time` int(11) NOT NULL DEFAULT '0' COMMENT '删除时间(时间戳)',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='专业班级表';

#
# Data for table "class"
#

INSERT INTO `class` VALUES (1,'信息工程151',0),(2,'信息工程152',0);

#
# Structure for table "signup_items"
#

CREATE TABLE `signup_items` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(40) NOT NULL DEFAULT '' COMMENT '报名项目名称',
  `description` varchar(255) NOT NULL DEFAULT '' COMMENT '描述',
  `max_student_count` int(11) NOT NULL DEFAULT '0' COMMENT '报名人数上限(若为0则表示不限制)',
  `real_student_count` int(11) NOT NULL DEFAULT '0' COMMENT '实际已报名人数',
  `begin_time` int(11) NOT NULL DEFAULT '0' COMMENT '报名开始时间(时间戳)',
  `end_time` int(11) NOT NULL DEFAULT '0' COMMENT '报名结束时间(时间戳)',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间(时间戳)',
  `delete_time` int(11) NOT NULL DEFAULT '0' COMMENT '删除时间(时间戳)',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='报名项目表';

#
# Data for table "signup_items"
#


#
# Structure for table "student_signup_log"
#

CREATE TABLE `student_signup_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `items_id` int(5) NOT NULL DEFAULT '0' COMMENT '项目id',
  `user_id` int(5) NOT NULL DEFAULT '0' COMMENT '报名人user_id(非学号)',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间(时间戳)',
  `delete_time` int(11) NOT NULL DEFAULT '0' COMMENT '删除时间(时间戳)',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='学生报名记录表';

#
# Data for table "student_signup_log"
#


#
# Structure for table "user"
#

CREATE TABLE `user` (
  `id` int(5) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `username` varchar(20) NOT NULL DEFAULT '' COMMENT 'admin用户名/学生学号',
  `password` varchar(255) NOT NULL DEFAULT '' COMMENT '密码(md5加密)',
  `student_id` varchar(20) NOT NULL DEFAULT '' COMMENT '学号',
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '类型 0:admin 1:学生',
  `name` varchar(20) NOT NULL DEFAULT '' COMMENT '姓名',
  `sex` tinyint(1) NOT NULL DEFAULT '0' COMMENT '性别0:男1:女',
  `birthday` int(11) NOT NULL DEFAULT '0' COMMENT '出生日期',
  `id_card` varchar(20) NOT NULL DEFAULT '' COMMENT '身份证号',
  `class_id` int(5) NOT NULL DEFAULT '0' COMMENT '专业班级id',
  `photo` varchar(255) NOT NULL DEFAULT '' COMMENT '照片路径',
  `mobile` varchar(11) NOT NULL DEFAULT '' COMMENT '手机号',
  `email` varchar(30) NOT NULL DEFAULT '' COMMENT '邮箱',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态 0:禁用 1:启用',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间(时间戳)',
  `last_login_time` int(11) NOT NULL DEFAULT '0' COMMENT '最后一次登录时间(时间戳)',
  `delete_time` int(11) NOT NULL DEFAULT '0' COMMENT '删除时间(时间戳)',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='用户表';

#
# Data for table "user"
#

INSERT INTO `user` VALUES (1,'admin','e10adc3949ba59abbe56e057f20f883e','',0,'',0,0,'',0,'','','',1,0,1552290161,0);
