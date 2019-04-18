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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='报名项目表';

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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='学生报名记录表';

#
# Structure for table "user"
#

CREATE TABLE `user` (
  `id` int(5) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `username` varchar(20) NOT NULL DEFAULT '' COMMENT '用户名',
  `password` varchar(255) NOT NULL DEFAULT '' COMMENT '密码(md5加密)',
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '类型 0:admin 1:学生',
  `name` varchar(20) NOT NULL DEFAULT '' COMMENT '姓名',
  `sex` tinyint(1) NOT NULL DEFAULT '2' COMMENT '性别0:男1:女2:未设置',
  `birthday` int(11) NOT NULL DEFAULT '0' COMMENT '出生日期',
  `id_card` varchar(20) NOT NULL DEFAULT '' COMMENT '身份证号',
  `photo` varchar(255) NOT NULL DEFAULT '' COMMENT '照片路径',
  `mobile` varchar(11) NOT NULL DEFAULT '' COMMENT '手机号',
  `email` varchar(30) NOT NULL DEFAULT '' COMMENT '邮箱',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间(时间戳)',
  `last_login_time` int(11) NOT NULL DEFAULT '0' COMMENT '最后一次登录时间(时间戳)',
  `last_login_ip` varchar(20) NOT NULL DEFAULT '' COMMENT '最后一次登录ip',
  `delete_time` int(11) NOT NULL DEFAULT '0' COMMENT '删除时间(时间戳)',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='用户表';

#
# Data for table "user"
#

INSERT INTO `user` VALUES (1,'admin','e10adc3949ba59abbe56e057f20f883e','',0,'',0,0,'',0,'','','',0,1552290161,0);
#
# Structure for table "news"
#

CREATE TABLE `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT '标题',
  `content` text NOT NULL COMMENT '内容',
  `read_count` int(11) NOT NULL DEFAULT '0' COMMENT '阅读数量',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `delete_time` int(11) NOT NULL DEFAULT '0' COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;