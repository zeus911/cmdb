CREATE DATABASE `cmdb` ;

USE `cmdb`;


DROP TABLE IF EXISTS `device`;

CREATE TABLE `device` (
  `assets_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `assets` varchar(100) NOT NULL COMMENT '固资编号',
  `server_type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '设备类型：1：服务器，2：交换机，3：路由器，4：防火墙, 5:虚拟子机',
  `fqdn` varchar(255) DEFAULT NULL COMMENT '主机名称',
  `host_assets_id` varchar(100) NOT NULL COMMENT '虚拟机的宿主机assets_id',
  `frame_name` varchar(100) NOT NULL COMMENT '机架',
  `seat` int(11) NOT NULL COMMENT '机位',
  `manufacturer` varchar(100) DEFAULT NULL COMMENT '厂商型号',
  `logic_area` varchar(255) NOT NULL COMMENT '逻辑区域',
  `device_height` int(11) NOT NULL DEFAULT '2' COMMENT '设备高度（U）',
  `device_status` int(11) NOT NULL DEFAULT '2' COMMENT '状态 1：运营中[需告警]，2：待运营，3：开发中，4：待上线，5：故障中，6：回收中',
  `os` varchar(255) DEFAULT NULL COMMENT '操作系统名称',
  `kernel` varchar(255) DEFAULT NULL COMMENT '内核版本',
  `purchase_date` date NOT NULL COMMENT '购买日期',
  `on_time` date NOT NULL COMMENT '上架时间',
  `service_number` varchar(255) DEFAULT NULL COMMENT '服务号',
  `quick_service_number` varchar(255) DEFAULT NULL COMMENT '快速服务代码',
  `device_serial_number` varchar(255) DEFAULT NULL COMMENT '产品SN号',
  `warranty_time` char(255) DEFAULT '36' COMMENT '保修时间(月)',
  `operator` varchar(100) NOT NULL DEFAULT '' COMMENT '维护人员',
  `uuid` varchar(255) DEFAULT NULL COMMENT 'UUID',
  `disk_info` text COMMENT '存储信息;硬盘空间信息',
  `remarks` varchar(1024) DEFAULT NULL COMMENT '备注',
  `create_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `iso_num` varchar(40) DEFAULT '',
  `cpu` text COMMENT 'CPU信息',
  `memory` varchar(255) DEFAULT NULL COMMENT '内存信息',
  `ilo_mac` varchar(50) DEFAULT '' COMMENT '管理口网卡mac',
  `nic0_mac` varchar(50) DEFAULT '' COMMENT 'eth0 网卡mac',
  `nic1_mac` varchar(50) DEFAULT '' COMMENT 'eth1 网卡mac',
  `nic2_mac` varchar(50) DEFAULT '' COMMENT 'eth2 网卡mac',
  `nic3_mac` varchar(50) DEFAULT '' COMMENT 'eth3 网卡mac',
  `bios_date` varchar(100) DEFAULT NULL COMMENT 'bios日期',
  `bios_version` varchar(100) DEFAULT NULL COMMENT 'bios版本',
  `swap` varchar(100) DEFAULT NULL COMMENT 'swap大小',
  PRIMARY KEY (`assets_id`),
  UNIQUE KEY `assets` (`assets`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `ip`;

CREATE TABLE `ip` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `assets_id` varchar(255) NOT NULL COMMENT '固资编号',
  `ip` varchar(255) NOT NULL COMMENT 'IP',
  `ip_type` tinyint(4) NOT NULL DEFAULT '1' COMMENT 'IP类型 1：内网，2：外网,3：vip, 4：管理ip',
  `mask` varchar(255) NOT NULL COMMENT '子网掩码',
  `segment_ip` varchar(255) NOT NULL COMMENT '网段',
  `gateway` varchar(255) NOT NULL COMMENT '网关',
  `carriers` tinyint(4) NOT NULL DEFAULT '0' COMMENT '运营商 0:内网，1:电信，2：网通，3教育网，4：移动，5：其他',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态：0：不启用，1：启用',
  `environment` tinyint(2) DEFAULT '0' COMMENT '环境 1灰度 0正式 2测试',
  PRIMARY KEY (`id`),
  UNIQUE KEY `ip_type` (`assets_id`,`ip`,`ip_type`),
  KEY `assets` (`assets_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `level_tag`;

CREATE TABLE `level_tag` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `meta_name` varchar(100) DEFAULT NULL COMMENT 'tag',
  `meta_type` enum('level','tag') DEFAULT NULL COMMENT '类型,level,tag',
  `create_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

insert  into `level_tag`(`id`,`meta_name`,`meta_type`,`create_timestamp`) values (1,'cop','level','2016-01-12 10:32:43'),(2,'owt','level','2016-01-12 10:32:43'),(3,'loc','level','2016-01-12 10:32:43'),(4,'idc','level','2016-01-12 10:32:43'),(5,'pdl','level','2016-01-12 10:32:43'),(6,'sbs','level','2016-01-12 10:32:43'),(7,'srv','level','2016-01-12 10:32:43'),(8,'mod','level','2016-01-12 10:32:43'),(9,'grp','level','2016-01-12 10:32:43'),(10,'ptn','level','2016-01-12 10:32:43'),(11,'cln','level','2016-01-12 10:32:43'),(12,'fls','level','2016-01-12 10:32:43'),(13,'status','level','2016-01-12 10:32:43'),(14,'virt','level','2016-01-12 10:32:43');


DROP TABLE IF EXISTS `room`;

CREATE TABLE `room` (
  `room_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `room_name` varchar(255) NOT NULL COMMENT '机房名称',
  `position` varchar(255) NOT NULL COMMENT '机房位置',
  `room_name_short` varchar(4) DEFAULT NULL COMMENT '机房名简写',
  `city_short` varchar(4) DEFAULT NULL COMMENT '城市名简写',
  `tel` varchar(4) DEFAULT NULL COMMENT '客服电话',
  `customer_service` varchar(4) DEFAULT NULL COMMENT '客服',
  `email` varchar(4) DEFAULT NULL COMMENT '客服email',
  PRIMARY KEY (`room_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `segment`;

CREATE TABLE `segment` (
  `segment_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `assets_id` varchar(100) NOT NULL COMMENT '关联设备id',
  `segment_ip` varchar(255) NOT NULL COMMENT 'IP',
  `ip_type` tinyint(4) NOT NULL COMMENT 'IP类型 1：内网，2：外网',
  `mask` varchar(255) NOT NULL COMMENT '子网掩码',
  `gateway` varchar(255) NOT NULL COMMENT '网关',
  `vlan` varchar(20) DEFAULT '1' COMMENT 'VLAN ID',
  `total` int(255) NOT NULL DEFAULT '0' COMMENT 'IP总数',
  `assigned` int(255) NOT NULL DEFAULT '0' COMMENT '已分配',
  `carriers` tinyint(4) DEFAULT '0' COMMENT '运营商 0:内网，1:电信，2：网通，3教育网，4：移动，5：其他',
  `virtual` tinyint(4) DEFAULT '0' COMMENT '0：非虚拟化，1：虚拟化',
  `remarks` varchar(255) DEFAULT NULL COMMENT 'remarks',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态：0：不启用，1：启用',
  `logic_area` varchar(255) DEFAULT NULL COMMENT '逻辑区域',
  PRIMARY KEY (`segment_id`),
  UNIQUE KEY `NewIndex1` (`segment_ip`,`mask`),
  KEY `ip_type` (`ip_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `segment_ip_pool`;

CREATE TABLE `segment_ip_pool` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `segment_id` int(10) unsigned NOT NULL COMMENT '网段ID',
  `ip` varchar(100) NOT NULL COMMENT 'IP',
  `assigned` tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态：0：未分配，1：已分配',
  PRIMARY KEY (`id`),
  UNIQUE KEY `ip` (`ip`),
  KEY `segment_id` (`segment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `server_tag`;

CREATE TABLE `server_tag` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `level_id` int(10) unsigned DEFAULT NULL,
  `server_tag_id` int(10) unsigned DEFAULT NULL,
  `create_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `assets_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `server_tag_user`;

CREATE TABLE `server_tag_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `server_tag_id` int(11) DEFAULT NULL COMMENT 'tag id',
  `uid` int(11) DEFAULT NULL COMMENT '用户id',
  `create_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `sys_group`;

CREATE TABLE `sys_group` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `group_name` varchar(40) NOT NULL COMMENT '组名',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `sys_group_permission`;

CREATE TABLE `sys_group_permission` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `sys_module_id` int(11) unsigned NOT NULL COMMENT '模块ID',
  `user_group_id` int(11) unsigned NOT NULL COMMENT '组ID',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `sys_module`;

CREATE TABLE `sys_module` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `module_icon` varchar(20) DEFAULT NULL COMMENT '模块图标',
  `module_name` varchar(20) NOT NULL COMMENT '模块名称',
  `module_parent_id` varchar(16) DEFAULT NULL COMMENT '父ID',
  `module_type` varchar(10) DEFAULT NULL COMMENT '模块类型',
  `module_resource` varchar(60) DEFAULT NULL COMMENT 'URL',
  `module_order` int(11) NOT NULL DEFAULT '0' COMMENT '顺序',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `sys_user`;

CREATE TABLE `sys_user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_name` varchar(30) NOT NULL COMMENT '名字拼音',
  `truename` varchar(45) NOT NULL DEFAULT '' COMMENT '中文名',
  `email` varchar(80) NOT NULL COMMENT 'email',
  `createdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`,`user_name`,`email`),
  UNIQUE KEY `username_UNIQUE` (`user_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `sys_user_group`;

CREATE TABLE `sys_user_group` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `group_id` varchar(40) NOT NULL COMMENT '组名',
  `uid` int(11) unsigned NOT NULL COMMENT '用户id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;