/*
Navicat MySQL Data Transfer

Source Server         : c7
Source Server Version : 50718
Source Host           : 192.168.16.118:3306
Source Database       : cgf_demo

Target Server Type    : MYSQL
Target Server Version : 50718
File Encoding         : 65001

Date: 2019-12-31 11:16:37
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for cgf_admin
-- ----------------------------
DROP TABLE IF EXISTS `cgf_admin`;
CREATE TABLE `cgf_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` char(32) NOT NULL,
  `pwd` char(50) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `auth` tinyint(4) NOT NULL DEFAULT '1',
  `photo` varchar(50) NOT NULL DEFAULT 'default.jpg',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cgf_admin
-- ----------------------------
INSERT INTO `cgf_admin` VALUES ('1', 'admin', 'c3518ee3ab4862fefdd708f539df8fdf', '1', '1', '2016-10-08/57f9128f80bef.jpg');

-- ----------------------------
-- Table structure for cgf_auth_group_access
-- ----------------------------
DROP TABLE IF EXISTS `cgf_auth_group_access`;
CREATE TABLE `cgf_auth_group_access` (
  `uid` int(10) unsigned NOT NULL COMMENT '用户id',
  `group_id` mediumint(8) unsigned NOT NULL COMMENT '用户组id',
  UNIQUE KEY `uid_group_id` (`uid`,`group_id`),
  KEY `uid` (`uid`),
  KEY `group_id` (`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cgf_auth_group_access
-- ----------------------------
INSERT INTO `cgf_auth_group_access` VALUES ('1', '1');
INSERT INTO `cgf_auth_group_access` VALUES ('10', '1');
INSERT INTO `cgf_auth_group_access` VALUES ('11', '1');
INSERT INTO `cgf_auth_group_access` VALUES ('12', '5');

-- ----------------------------
-- Table structure for cgf_category
-- ----------------------------
DROP TABLE IF EXISTS `cgf_category`;
CREATE TABLE `cgf_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) DEFAULT NULL,
  `thumb` varchar(255) DEFAULT NULL,
  `parentid` int(11) DEFAULT '0',
  `isrecommand` int(10) DEFAULT '0',
  `description` varchar(500) DEFAULT NULL,
  `displayorder` tinyint(3) unsigned DEFAULT '0',
  `enabled` tinyint(1) DEFAULT '1',
  `ishome` tinyint(3) DEFAULT '0',
  `level` tinyint(3) DEFAULT NULL,
  `advimg` varchar(255) DEFAULT '',
  `advurl` varchar(500) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=31 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of cgf_category
-- ----------------------------
INSERT INTO `cgf_category` VALUES ('1', '费雪系列', '', '0', '0', '', '0', '1', '0', '1', 'images/1/2019/04/u8EMm84IvZfuIKMbhbKv2e121zcimc.jpg', '');
INSERT INTO `cgf_category` VALUES ('2', '风火轮', '', '0', '0', '', '0', '1', '0', '1', '', '');
INSERT INTO `cgf_category` VALUES ('3', '火火兔', '', '0', '0', '', '0', '1', '0', '1', '', '');
INSERT INTO `cgf_category` VALUES ('4', '母婴生活用品', '', '0', '0', '', '5', '1', '0', '1', '', '');
INSERT INTO `cgf_category` VALUES ('5', '卢卡绘本机器人', 'images/3/2019/06/ztDzOM6dHh8d8rjliT0Dl0tTDoyLjZ.jpg', '15', '1', '', '11', '1', '1', '2', '', '');
INSERT INTO `cgf_category` VALUES ('6', '早教电子产品', '', '0', '0', '', '8', '1', '0', '1', '', '');
INSERT INTO `cgf_category` VALUES ('7', '国际品牌玩具', '', '0', '0', '', '7', '1', '0', '1', '', '');
INSERT INTO `cgf_category` VALUES ('8', '家居', '', '0', '0', '生活', '1', '1', '0', '1', '', '');
INSERT INTO `cgf_category` VALUES ('9', '电子', '', '0', '0', '', '2', '1', '0', '1', '', '');
INSERT INTO `cgf_category` VALUES ('10', '国内品牌玩具', '', '0', '0', '', '6', '1', '0', '1', '', '');
INSERT INTO `cgf_category` VALUES ('11', '火火兔', 'images/3/2019/05/wbDxXkBBOvCbb0CCYxXx6PccC0p8bn.jpg', '15', '1', '', '18', '1', '1', '2', '', '');
INSERT INTO `cgf_category` VALUES ('12', '蓝宝贝', 'images/3/2019/05/R1mKk1ev917lEmpMez9Kkk1ZmL1PEe.jpg', '15', '1', '', '17', '1', '1', '2', '', '');
INSERT INTO `cgf_category` VALUES ('13', '伟易达', 'images/3/2019/05/dC4IQXn5iZ345OiQb35qJq4fcCoz4Q.png', '12', '1', '', '8', '1', '1', '2', '', '');
INSERT INTO `cgf_category` VALUES ('14', '费雪玩具', 'images/3/2019/05/ggV7i5Ck9Vp5PvVxvCXvX5x9Kx89I7.png', '12', '1', '', '7', '1', '1', '2', '', '');
INSERT INTO `cgf_category` VALUES ('15', '德国hape玩具', 'images/3/2019/05/Jy55pdtHjbU5TeTlY0d05LE0HxddPT.png', '12', '1', '', '6', '1', '1', '2', '', '');
INSERT INTO `cgf_category` VALUES ('16', '乐高玩具', 'images/3/2019/05/di6G96JoBEOa6QHWOLqLej7a9JKSS9.jpg', '12', '1', '', '5', '1', '1', '2', '', '');
INSERT INTO `cgf_category` VALUES ('17', '手机数码', '', '0', '0', '', '1', '1', '0', '1', '', '');
INSERT INTO `cgf_category` VALUES ('18', '爱疯系列', 'images/9/2019/04/Gd8FPIvyIMeVb8YP9KZep9e97kpBvv.png', '24', '1', '', '2', '1', '1', '2', '', '');
INSERT INTO `cgf_category` VALUES ('19', '华为系列', 'images/9/2019/04/IcF868fZ8otMM41OYdfNMTTpanQtO6.jpg', '24', '1', '', '1', '1', '1', '2', '', '');
INSERT INTO `cgf_category` VALUES ('20', '时尚上衣', '', '0', '0', '', '0', '1', '0', '1', '', '');
INSERT INTO `cgf_category` VALUES ('21', '新潮女装', 'images/9/2019/04/YQkK8Z3t9gYkQ9832l8p1YGy3tT331.png', '27', '1', '', '0', '1', '1', '2', '', '');
INSERT INTO `cgf_category` VALUES ('22', '时尚女装', '', '0', '0', '', '3', '1', '0', '1', '', '');
INSERT INTO `cgf_category` VALUES ('23', '女装上衣', 'images/10/2019/04/tXhenwetGPxhw11Fngw7f38fHgV7z5.jpg', '29', '1', '', '1', '1', '1', '2', '', '');
INSERT INTO `cgf_category` VALUES ('24', '数码产品', '', '0', '0', '', '2', '1', '0', '1', '', '');
INSERT INTO `cgf_category` VALUES ('25', '苹果手机', 'images/10/2019/04/VD7oyWOzlT1Y997ltd1LVLwtZWYy67.jpg', '31', '1', '', '1', '1', '1', '2', '', '');
INSERT INTO `cgf_category` VALUES ('26', '手机', '', '9', '0', '', '1', '1', '0', '2', '', '');
INSERT INTO `cgf_category` VALUES ('27', '家居用品', '', '0', '0', '', '1', '1', '0', '1', 'images/10/2019/04/vrmdBWuW6LSBFc60mGub60M0gbcbuM.jpg', '');
INSERT INTO `cgf_category` VALUES ('28', '母婴', 'images/10/2019/04/vrmdBWuW6LSBFc60mGub60M0gbcbuM.jpg', '34', '1', '', '1', '1', '1', '2', '', '');
INSERT INTO `cgf_category` VALUES ('29', '牛听听早教机', 'images/3/2019/05/mGj2gng2asN25seAo3e32SLQgZ2osg.jpg', '15', '1', '', '13', '1', '1', '2', '', '');
INSERT INTO `cgf_category` VALUES ('30', '朵拉儿童投影仪', 'images/3/2019/06/UJtyoo02uuUQUzO9Uub2k0ujJUx2Ut.jpg', '15', '1', '', '12', '1', '1', '2', '', '');

-- ----------------------------
-- Table structure for cgf_express
-- ----------------------------
DROP TABLE IF EXISTS `cgf_express`;
CREATE TABLE `cgf_express` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` varchar(60) NOT NULL COMMENT '订单号',
  `goods_id` int(11) NOT NULL COMMENT '商品id',
  `freight` float(10,2) DEFAULT '0.00' COMMENT '运费',
  `company` varchar(250) DEFAULT NULL COMMENT '快递公司',
  `express_no` varchar(100) DEFAULT NULL COMMENT '快递单号',
  `create_t` int(10) unsigned DEFAULT '0' COMMENT '创建时间|0|||date("y-m-d h:i:s",###)''',
  `modify_t` int(10) unsigned DEFAULT '0' COMMENT '修改时间|2|||date("y-m-d h:i:s",###)',
  PRIMARY KEY (`id`),
  KEY `ind_create_t` (`create_t`),
  KEY `ind_modify_t` (`modify_t`),
  KEY `ind_order_no` (`order_id`),
  KEY `ind_activity_id` (`goods_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cgf_express
-- ----------------------------

-- ----------------------------
-- Table structure for cgf_goods
-- ----------------------------
DROP TABLE IF EXISTS `cgf_goods`;
CREATE TABLE `cgf_goods` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `name` varchar(250) DEFAULT NULL COMMENT '商品名',
  `price` float(10,2) DEFAULT '0.00' COMMENT '市场价',
  `orgial_price` float(10,2) DEFAULT '0.00' COMMENT '原价',
  `pur_price` float(10,2) DEFAULT NULL COMMENT '成本',
  `thumb` varchar(255) DEFAULT '' COMMENT '缩略图-image|1110|||tpl_function=show_img()',
  `status` int(1) DEFAULT '0' COMMENT '状态-select|1111||0:上架,1:下架',
  `sort` int(5) DEFAULT '0' COMMENT '商品排序',
  `user_id` int(7) DEFAULT NULL COMMENT '用户id',
  `weight` float(10,2) DEFAULT '0.00' COMMENT '重量',
  `type` int(11) DEFAULT '0' COMMENT '类型-select|1111||0:普通商品,1:会员充值,2:话费充值',
  `category_id` int(11) DEFAULT '0' COMMENT '商品分类',
  `intro` text COMMENT '商品介绍-editor|1100',
  `create_t` int(10) unsigned DEFAULT NULL COMMENT '创建时间|0|||date("y-m-d h:i:s",###)',
  `modify_t` int(10) unsigned DEFAULT NULL COMMENT '修改时间|2|||date("y-m-d h:i:s",###)',
  PRIMARY KEY (`id`),
  KEY `ind_create_t` (`create_t`),
  KEY `ind_modify_t` (`modify_t`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8 COMMENT='商品表||edit:编辑:id,del:删除:id|create_time-desc|export-showMenu ';

-- ----------------------------
-- Records of cgf_goods
-- ----------------------------
INSERT INTO `cgf_goods` VALUES ('1', 'Apple iPad mini 4 平板电脑 7.9英寸', '3288.00', '0.00', '3288.00', 'https://dss3.bdstatic.com/70cFv8Sh_Q1YnxGkpoWK1HF6hhy/it/u=1026016199,1338164578&fm=26&gp=0.jpg', '0', '999', '27', '0.00', '0', '1', '备注', '1501741029', '1532074304');
INSERT INTO `cgf_goods` VALUES ('2', 'Apple iPhone 7 128G', '5799.00', '0.00', '5799.00', 'https://dss3.bdstatic.com/70cFv8Sh_Q1YnxGkpoWK1HF6hhy/it/u=1026016199,1338164578&fm=26&gp=0.jpg', '0', '999', '27', '0.00', '0', '2', '备注', '1501741158', '1527219082');
INSERT INTO `cgf_goods` VALUES ('3', 'Apple iPhone 7 128G 红色特别版 移动联通电信4G手机', '5799.00', '0.00', '5799.00', 'https://dss3.bdstatic.com/70cFv8Sh_Q1YnxGkpoWK1HF6hhy/it/u=1026016199,1338164578&fm=26&gp=0.jpg', '0', '999', '27', '0.00', '0', '3', '备注', '1501741248', '1529055816');
INSERT INTO `cgf_goods` VALUES ('4', 'Apple iPhone 8 ', '520.00', '0.00', '520.00', 'https://dss3.bdstatic.com/70cFv8Sh_Q1YnxGkpoWK1HF6hhy/it/u=1026016199,1338164578&fm=26&gp=0.jpg', '0', '999', '27', '0.00', '0', '4', '备注', '1501741362', '1527219108');
INSERT INTO `cgf_goods` VALUES ('5', 'OPPO R11 全网通4G+64G 双卡双待手机 热力红色', '3199.00', '0.00', '3199.00', 'https://dss3.bdstatic.com/70cFv8Sh_Q1YnxGkpoWK1HF6hhy/it/u=1026016199,1338164578&fm=26&gp=0.jpg', '0', '999', '27', '0.00', '0', '5', '备注', '1501741501', '1527219127');
INSERT INTO `cgf_goods` VALUES ('6', '小米6 6GB+64GB 亮黑色 移动联通电信4G手机 双卡双待', '2799.00', '0.00', '2799.00', 'https://dss3.bdstatic.com/70cFv8Sh_Q1YnxGkpoWK1HF6hhy/it/u=1026016199,1338164578&fm=26&gp=0.jpg', '0', '999', '27', '0.00', '0', '6', '备注', '1501741587', '1531225732');
INSERT INTO `cgf_goods` VALUES ('7', 'Apple iPad Pro 平板电脑 12.9英寸（64G WLAN版/A10X芯片/Retina屏/Multi-Touch技术 MQDC2CH/A）银色', '5988.00', '0.00', '5988.00', 'https://dss3.bdstatic.com/70cFv8Sh_Q1YnxGkpoWK1HF6hhy/it/u=1026016199,1338164578&fm=26&gp=0.jpg', '0', '3', '27', '0.00', '0', '7', '备注', '1501741691', '1535447237');
INSERT INTO `cgf_goods` VALUES ('8', 'Beats Solo2 Wireless 头戴式耳机 - 白色 蓝牙无线 带麦', '1688.00', '0.00', '1488.00', 'https://dss3.bdstatic.com/70cFv8Sh_Q1YnxGkpoWK1HF6hhy/it/u=1026016199,1338164578&fm=26&gp=0.jpg', '0', '999', '27', '0.00', '0', '8', '备注', '1501741785', '1527219141');
INSERT INTO `cgf_goods` VALUES ('9', '全球购 亚马逊Kindle Oasis电子书阅读器', '3088.00', '0.00', '2399.00', 'https://dss3.bdstatic.com/70cFv8Sh_Q1YnxGkpoWK1HF6hhy/it/u=1026016199,1338164578&fm=26&gp=0.jpg', '0', '999', '27', '0.00', '0', '9', '备注', '1501741895', '1527219182');
INSERT INTO `cgf_goods` VALUES ('10', 'Apple iPhone 7 Plus (A1661) 128G 移动联通电信4G手机', '6578.00', '0.00', '6578.00', 'https://dss3.bdstatic.com/70cFv8Sh_Q1YnxGkpoWK1HF6hhy/it/u=1026016199,1338164578&fm=26&gp=0.jpg', '0', '999', '27', '0.00', '0', '10', '备注', '1501741968', '1532059674');
INSERT INTO `cgf_goods` VALUES ('11', '佳能（Canon）EOS 70D 单反相机套装 佳能70d 佳能EF-S 18-135mm IS STM', '8499.00', '0.00', '8499.00', 'https://dss3.bdstatic.com/70cFv8Sh_Q1YnxGkpoWK1HF6hhy/it/u=1026016199,1338164578&fm=26&gp=0.jpg', '0', '999', '27', '0.00', '0', '11', '备注', '1501742161', '1527219206');
INSERT INTO `cgf_goods` VALUES ('12', 'paperang喵喵机P1热敏打印机手机照片打印机便携迷你口袋蓝牙打印机', '239.00', '0.00', '239.00', 'https://dss3.bdstatic.com/70cFv8Sh_Q1YnxGkpoWK1HF6hhy/it/u=1026016199,1338164578&fm=26&gp=0.jpg', '0', '999', '27', '0.00', '0', '12', '备注', '1501742392', '1527219221');
INSERT INTO `cgf_goods` VALUES ('13', 'Apple iPhone 6s Plus (A1699) 128G ', '4899.00', '0.00', '4899.00', 'https://dss3.bdstatic.com/70cFv8Sh_Q1YnxGkpoWK1HF6hhy/it/u=1026016199,1338164578&fm=26&gp=0.jpg', '0', '999', '27', '0.00', '0', '13', '备注', '1501742558', '1527219237');
INSERT INTO `cgf_goods` VALUES ('14', 'Apple MacBook Pro 13.3英寸笔记本电脑 深空灰色（Multi-Touch Bar/Core i5/8GB/256GB MLH12CH/A）', '13888.00', '0.00', '13888.00', 'https://dss3.bdstatic.com/70cFv8Sh_Q1YnxGkpoWK1HF6hhy/it/u=1026016199,1338164578&fm=26&gp=0.jpg', '0', '999', '27', '0.00', '0', '14', '备注', '1501742927', '1527219247');
INSERT INTO `cgf_goods` VALUES ('15', '索尼（SONY）【PS4 Pro 国行主机】PlayStation 4 Pro 电脑娱乐游戏主机 1TB（黑色）', '2999.00', '0.00', '2999.00', 'https://dss3.bdstatic.com/70cFv8Sh_Q1YnxGkpoWK1HF6hhy/it/u=1026016199,1338164578&fm=26&gp=0.jpg', '0', '999', '27', '0.00', '0', '15', '备注', '1501743443', '1527219262');
INSERT INTO `cgf_goods` VALUES ('16', '小米7', '100.00', '0.00', '106.00', 'https://dss3.bdstatic.com/70cFv8Sh_Q1YnxGkpoWK1HF6hhy/it/u=1026016199,1338164578&fm=26&gp=0.jpg', '0', '999', '27', '0.00', '2', '16', '备注', '1501743582', '1527154529');
INSERT INTO `cgf_goods` VALUES ('17', '红米6', '50.00', '0.00', '53.00', 'https://dss3.bdstatic.com/70cFv8Sh_Q1YnxGkpoWK1HF6hhy/it/u=1026016199,1338164578&fm=26&gp=0.jpg', '0', '999', '27', '0.00', '2', '17', '备注', '1501744835', '1527154520');
INSERT INTO `cgf_goods` VALUES ('18', '小米 plus', '10.00', '0.00', '10.60', 'https://dss3.bdstatic.com/70cFv8Sh_Q1YnxGkpoWK1HF6hhy/it/u=1026016199,1338164578&fm=26&gp=0.jpg', '0', '999', '27', '0.00', '2', '18', '备注', '1501745306', '1529057022');
INSERT INTO `cgf_goods` VALUES ('19', 'TSL谢瑞麟 黄金手链 新款足金镂空转运珠手链 送女友 16+3CM手链 YL765 5.2g', '1965.00', '0.00', '1965.00', 'https://dss3.bdstatic.com/70cFv8Sh_Q1YnxGkpoWK1HF6hhy/it/u=1026016199,1338164578&fm=26&gp=0.jpg', '0', '999', '27', '0.00', '0', '19', '备注', '1501751318', '1532074268');
INSERT INTO `cgf_goods` VALUES ('20', '香奈儿（Chanel）香水女士香水淡香持久 粉色邂逅50ml', '638.00', '0.00', '638.00', 'https://dss3.bdstatic.com/70cFv8Sh_Q1YnxGkpoWK1HF6hhy/it/u=1026016199,1338164578&fm=26&gp=0.jpg', '0', '999', '27', '0.00', '0', '20', '备注', '1501752219', '1527219297');
INSERT INTO `cgf_goods` VALUES ('21', 'Beats Solo3 Wireless 蓝牙无线头戴式降噪线控苹果B耳机 红色 通用版', '1799.00', '0.00', '1799.00', 'https://dss3.bdstatic.com/70cFv8Sh_Q1YnxGkpoWK1HF6hhy/it/u=1026016199,1338164578&fm=26&gp=0.jpg', '1', '999', '27', '0.00', '0', '21', '备注', '1501753667', '1527219310');
INSERT INTO `cgf_goods` VALUES ('22', '锤子 坚果Pro 64GB 碳黑色 全网通 移动联通电信4G手机 双卡双待', '1799.00', '0.00', '1799.00', 'https://dss3.bdstatic.com/70cFv8Sh_Q1YnxGkpoWK1HF6hhy/it/u=1026016199,1338164578&fm=26&gp=0.jpg', '0', '999', '27', '0.00', '0', '22', '备注', '1501832116', '1527219320');
INSERT INTO `cgf_goods` VALUES ('23', '大疆（DJI）精灵Phantom 3 SE 4K智能航拍无人机 入门良选', '3499.00', '0.00', '3499.00', 'https://dss3.bdstatic.com/70cFv8Sh_Q1YnxGkpoWK1HF6hhy/it/u=1026016199,1338164578&fm=26&gp=0.jpg', '0', '999', '27', '0.00', '0', '23', '备注', '1501832211', '1527219331');
INSERT INTO `cgf_goods` VALUES ('24', '【Xbox无线手柄】微软（Microsoft）Xbox无线控制器/手柄 特遣奇兵限量版', '459.00', '0.00', '459.00', 'https://dss3.bdstatic.com/70cFv8Sh_Q1YnxGkpoWK1HF6hhy/it/u=1026016199,1338164578&fm=26&gp=0.jpg', '0', '999', '27', '0.00', '0', '24', '备注', '1501832332', '1527219341');
INSERT INTO `cgf_goods` VALUES ('25', 'Chanel香奈儿男士持久香水 蔚蓝男士淡香100ML 男士香水', '888.00', '0.00', '888.00', 'https://dss3.bdstatic.com/70cFv8Sh_Q1YnxGkpoWK1HF6hhy/it/u=1026016199,1338164578&fm=26&gp=0.jpg', '0', '999', '27', '0.00', '0', '25', '备注', '1501832396', '1527219353');
INSERT INTO `cgf_goods` VALUES ('26', '平安银行 鸡年金章银钞 丁酉年纪念套装 足金雄鸡报晓邮票金章 不动明王银钞', '990.00', '0.00', '990.00', 'https://dss3.bdstatic.com/70cFv8Sh_Q1YnxGkpoWK1HF6hhy/it/u=1026016199,1338164578&fm=26&gp=0.jpg', '0', '999', '27', '0.00', '0', '26', '备注', '1501832473', '1532074255');
INSERT INTO `cgf_goods` VALUES ('27', '中钞鉴定 2016版熊猫金币 首日封装版 纪念币', '1960.00', '0.00', '1960.00', 'https://dss3.bdstatic.com/70cFv8Sh_Q1YnxGkpoWK1HF6hhy/it/u=1026016199,1338164578&fm=26&gp=0.jpg', '0', '999', '27', '0.00', '0', '27', '备注', '1501832529', '1527219370');
INSERT INTO `cgf_goods` VALUES ('28', '蚁视 ANTVR 二代 VR眼镜 高端VR头显 虚拟现实VR一体机 空间游戏 3D电影 扩展级', '4399.00', '0.00', '4399.00', 'https://dss3.bdstatic.com/70cFv8Sh_Q1YnxGkpoWK1HF6hhy/it/u=1026016199,1338164578&fm=26&gp=0.jpg', '0', '999', '27', '0.00', '0', '28', '备注', '1501832654', '1527219384');
INSERT INTO `cgf_goods` VALUES ('29', '惠普（HP）惠普小印口袋照片打印机Sprocket 100(白) +惠普（HP）Z9X76A ZINK惠普小印口袋照片打印机相纸', '1058.00', '0.00', '1058.00', 'https://dss3.bdstatic.com/70cFv8Sh_Q1YnxGkpoWK1HF6hhy/it/u=1026016199,1338164578&fm=26&gp=0.jpg', '0', '999', '27', '0.00', '0', '29', '备注', '1502422799', '1532074242');
INSERT INTO `cgf_goods` VALUES ('30', 'Apple iMac 27英寸一体机（四核Core i5 处理器/8GB内存/2TB Fusion Drive/RP580显卡/5K屏 MNED2CH/A）', '18288.00', '0.00', '18288.00', 'https://dss3.bdstatic.com/70cFv8Sh_Q1YnxGkpoWK1HF6hhy/it/u=1026016199,1338164578&fm=26&gp=0.jpg', '0', '999', '22', '0.00', '0', '30', '备注', '1502437615', '1532071882');

-- ----------------------------
-- Table structure for cgf_log_request
-- ----------------------------
DROP TABLE IF EXISTS `cgf_log_request`;
CREATE TABLE `cgf_log_request` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '编号---sort',
  `user_id` int(11) DEFAULT '0' COMMENT '用户id--取cookie必须可以为null',
  `url` varchar(1024) NOT NULL,
  `ip` char(15) NOT NULL DEFAULT '',
  `detail` longtext CHARACTER SET utf8mb4 NOT NULL COMMENT '详情|0',
  `user_agent` text NOT NULL COMMENT '浏览器|0',
  `create_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `params` longtext NOT NULL COMMENT '参数|0',
  `method` char(6) NOT NULL DEFAULT '' COMMENT '请求方式',
  `cookie` varchar(1000) NOT NULL DEFAULT '' COMMENT 'cookie|0',
  `response` longtext CHARACTER SET utf8mb4 COMMENT '返回内容|0',
  `update_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间|0',
  `rinse_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '数据清洗状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='访问日志表';

-- ----------------------------
-- Records of cgf_log_request
-- ----------------------------

-- ----------------------------
-- Table structure for cgf_order
-- ----------------------------
DROP TABLE IF EXISTS `cgf_order`;
CREATE TABLE `cgf_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `openid` varchar(255) NOT NULL,
  `goods_id` int(11) DEFAULT NULL,
  `goods_name` varchar(150) DEFAULT NULL,
  `ch` varchar(150) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '0' COMMENT '订单状态|1111||0:默认,1:处理中, 2:交易成功,3:交易失败',
  `user_type` tinyint(1) DEFAULT '1',
  `create_t` int(10) unsigned DEFAULT NULL,
  `modify_t` int(10) unsigned DEFAULT NULL,
  `order_id` varchar(100) NOT NULL,
  `user_coupon_id` tinyint(1) DEFAULT '0' COMMENT '用户券id',
  PRIMARY KEY (`id`),
  KEY `ind_create_t` (`create_t`),
  KEY `ind_openid` (`openid`),
  KEY `ind_goods_id` (`goods_id`),
  KEY `ind_ch` (`ch`),
  KEY `order_id` (`order_id`),
  KEY `modify_t` (`modify_t`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8 COMMENT='订单|lock';

-- ----------------------------
-- Records of cgf_order
-- ----------------------------
INSERT INTO `cgf_order` VALUES ('1', '54013bebc230998f55000748', '1', null, 'baidu', '0', '0', '1501745882', null, '2017080397529710', '0');
INSERT INTO `cgf_order` VALUES ('2', '53fb440cc23099df5a00008c', '2', null, 'baidu', '0', '0', '1501746152', null, '2017080356521024', '0');
INSERT INTO `cgf_order` VALUES ('3', '54005651c23099aa36000002', '3', null, 'baidu', '0', '0', '1501746152', null, '2017080356545110', '0');
INSERT INTO `cgf_order` VALUES ('4', 'wx_b4d0f9fa092f12f396e35692', '4', null, 'baidu', '2', '1', '1501746646', '1501746990', '2017080354501005', '0');
INSERT INTO `cgf_order` VALUES ('5', '54018b63c230998f55001335', '5', null, 'baidu', '0', '0', '1501746707', null, '2017080351535110', '0');
INSERT INTO `cgf_order` VALUES ('6', '54018325c230998f550011fd', '6', null, 'baidu', '0', '0', '1501746717', null, '2017080310056575', '0');
INSERT INTO `cgf_order` VALUES ('7', '54018887c230998f550012bb', '7', null, 'baidu', '0', '0', '1501747303', null, '2017080355525698', '0');
INSERT INTO `cgf_order` VALUES ('8', '53faf7a2c23099665f000037', '8', null, 'baidu', '0', '0', '1501747466', null, '2017080397515710', '0');
INSERT INTO `cgf_order` VALUES ('9', '5401970fc230998f550014c8', '9', null, 'baidu', '0', '0', '1501747893', null, '2017080353995749', '0');
INSERT INTO `cgf_order` VALUES ('10', '5400368ec23099b3410016df', '10', null, 'baidu', '0', '0', '1501748209', null, '2017080349994898', '0');
INSERT INTO `cgf_order` VALUES ('11', 'qq_8e37de4ab02b8ced7b616594', '11', null, 'baidu', '2', '1', '1501748428', '1501749364', '2017080399100551', '0');
INSERT INTO `cgf_order` VALUES ('12', '53fb1ddec230997f67000085', '12', null, 'baidu', '0', '0', '1501748989', null, '2017080310052525', '0');
INSERT INTO `cgf_order` VALUES ('13', '53ff1f79c230999926000072', '13', null, 'baidu', '0', '0', '1501749539', null, '2017080351569754', '0');
INSERT INTO `cgf_order` VALUES ('14', '54018453c230998f5500122c', '14', null, 'baidu', '0', '0', '1501749590', null, '2017080354531025', '0');
INSERT INTO `cgf_order` VALUES ('15', '53fac588c2309977630001a1', '15', null, 'baidu', '0', '0', '1501749931', null, '2017080398524853', '0');
INSERT INTO `cgf_order` VALUES ('16', '54018916c230998f550012cb', '16', null, 'baidu', '0', '0', '1501750032', null, '2017080348101101', '0');
INSERT INTO `cgf_order` VALUES ('17', '540184b3c230998f5500123a', '17', null, 'baidu', '0', '0', '1501750679', null, '2017080355571005', '0');
INSERT INTO `cgf_order` VALUES ('18', 'qq_dc76e4e83cebb4c57fac9947', '18', null, 'baidu', '2', '1', '1501750745', '1501750812', '2017080357100535', '0');
INSERT INTO `cgf_order` VALUES ('19', '53ff68bdc23099b341000450', '19', null, 'baidu', '0', '0', '1501750873', null, '2017080357495210', '0');
INSERT INTO `cgf_order` VALUES ('20', '53fbe6c5c23099df5a000afd', '20', null, 'baidu', '0', '0', '1501751352', null, '2017080356505697', '0');
INSERT INTO `cgf_order` VALUES ('21', '53ff2b3ac23099e2b3000092', '21', null, 'baidu', '0', '0', '1501751678', null, '2017080310152100', '0');
INSERT INTO `cgf_order` VALUES ('22', '54017f8ac230998f550011a0', '22', null, 'baidu', '0', '0', '1501751989', null, '2017080353975357', '0');
INSERT INTO `cgf_order` VALUES ('23', '54017193c230998f55000f34', '23', null, 'baidu', '0', '0', '1501752071', null, '2017080355511025', '0');
INSERT INTO `cgf_order` VALUES ('24', '5401875ac230998f55001294', '24', null, 'baidu', '0', '0', '1501752622', null, '2017080310155515', '0');
INSERT INTO `cgf_order` VALUES ('25', '540195acc230998f5500149c', '25', null, 'baidu', '0', '0', '1501752647', null, '2017080355101975', '0');
INSERT INTO `cgf_order` VALUES ('26', '53ff0f0dc230999624000017', '26', null, 'baidu', '0', '0', '1501753270', null, '2017080354971015', '0');
INSERT INTO `cgf_order` VALUES ('27', '5401862dc230998f5500126a', '27', null, 'baidu', '0', '0', '1501753970', null, '2017080350495450', '0');
INSERT INTO `cgf_order` VALUES ('28', '5401948bc230998f5500147c', '28', null, 'baidu', '0', '0', '1501754102', null, '2017080354101100', '0');
INSERT INTO `cgf_order` VALUES ('29', '54012149c230998f550003f0', '29', null, 'baidu', '0', '0', '1501754516', null, '2017080352101509', '0');
INSERT INTO `cgf_order` VALUES ('30', '5401854dc230998f5500124f', '30', null, 'baidu', '0', '0', '1501755022', null, '2017080310198529', '0');

-- ----------------------------
-- Table structure for cgf_queue
-- ----------------------------
DROP TABLE IF EXISTS `cgf_queue`;
CREATE TABLE `cgf_queue` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `message` text,
  `create_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='队列';

-- ----------------------------
-- Records of cgf_queue
-- ----------------------------

-- ----------------------------
-- Table structure for cgf_user
-- ----------------------------
DROP TABLE IF EXISTS `cgf_user`;
CREATE TABLE `cgf_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `openid` varchar(255) NOT NULL COMMENT 'openid|3',
  `password` varchar(50) DEFAULT NULL COMMENT '|0',
  `nickname` varchar(250) DEFAULT NULL COMMENT '昵称',
  `gender` tinyint(1) DEFAULT NULL COMMENT '|0',
  `birthday` int(10) unsigned DEFAULT NULL COMMENT '生日-datePicker|0',
  `mobile` varchar(50) DEFAULT NULL COMMENT '手机|3',
  `avatar` varchar(450) DEFAULT NULL COMMENT '图像-img|0010|||tpl_function=show_img()',
  `ch` varchar(50) DEFAULT NULL COMMENT '用户渠道|0010',
  `deviceid` varchar(350) DEFAULT NULL COMMENT '设备id|0011',
  `address` text COMMENT '地址|0010',
  `realname` varchar(50) DEFAULT NULL COMMENT '姓名',
  `balance` float(10,2) DEFAULT '0.00' COMMENT '余额|1110',
  `create_t` int(10) unsigned DEFAULT NULL COMMENT '创建时间|0|||date("y-m-d h:i:s",###)',
  `modify_t` int(10) unsigned DEFAULT NULL COMMENT '修改时间|2|||date("y-m-d h:i:s",###)',
  `login_time` int(10) unsigned DEFAULT NULL COMMENT '登录时间|0|||date("y-m-d h:i:s",###)',
  `platform` int(1) DEFAULT '1' COMMENT '平台-select|0011||1:android,2:iOS',
  `ip` varchar(100) DEFAULT NULL COMMENT 'ip|0011',
  `area` varchar(250) DEFAULT NULL COMMENT '区域|2',
  `memberno` varchar(50) NOT NULL COMMENT '会员编号|0011',
  `status_flag` tinyint(1) NOT NULL DEFAULT '1' COMMENT '用户状态|0010||0:禁用,1:正常',
  `update_time` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间|0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `ind_openid` (`openid`),
  KEY `ind_phone` (`mobile`),
  KEY `ind_create_t` (`create_t`),
  KEY `ind_modify_t` (`modify_t`),
  KEY `memberno` (`memberno`),
  KEY `deviceid` (`deviceid`),
  KEY `ip` (`ip`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='用户||edit:编辑:id,view_recharge:查看充值记录:openid';

-- ----------------------------
-- Records of cgf_user
-- ----------------------------
INSERT INTO `cgf_user` VALUES ('1', '', null, '1', null, null, null, 'https://dss3.bdstatic.com/70cFv8Sh_Q1YnxGkpoWK1HF6hhy/it/u=1026016199,1338164578&fm=26&gp=0.jpg', null, null, null, null, '0.00', null, null, null, '1', null, null, '', '1', '2019-12-31 11:15:33');

-- ----------------------------
-- Procedure structure for p_create_log_table
-- ----------------------------
DROP PROCEDURE IF EXISTS `p_create_log_table`;
DELIMITER ;;
CREATE DEFINER=`root`@`%` PROCEDURE `p_create_log_table`()
BEGIN
	

	SET @max_id = (SELECT max(id) as max_id from pm_log_request);
	 
	set @sql_create_table = concat(
		"CREATE TABLE `pm_log_request_2` (
		`id` int(11) NOT NULL AUTO_INCREMENT COMMENT '编号---sort',
		`user_id` int(11) DEFAULT '0' COMMENT '用户id--取cookie必须可以为null',
		`url` varchar(1024) NOT NULL,
		`ip` char(15) NOT NULL DEFAULT '',
		`detail` longtext CHARACTER SET utf8mb4  NOT NULL COMMENT '详情|0',
		`user_agent` text NOT NULL COMMENT '浏览器|0',
		`create_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
		`params` longtext NOT NULL COMMENT '参数|0',
		`method` char(6) NOT NULL DEFAULT '' COMMENT '请求方式',
		`cookie` varchar(1000) NOT NULL DEFAULT '' COMMENT 'cookie|0',
		`response` longtext CHARACTER SET utf8mb4  COMMENT '返回内容|0',
		`update_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间|0',
		`rinse_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '数据清洗状态',
		PRIMARY KEY (`id`)
	) ENGINE=InnoDB AUTO_INCREMENT=",@max_id," DEFAULT CHARSET=utf8 COMMENT='访问日志表';"
	);
	PREPARE stmt FROM @sql_create_table;
	EXECUTE stmt;
	DEALLOCATE PREPARE stmt;
	 
	set @history_table_name= concat( 'RENAME TABLE pm_log_request TO pm_log_request_',DATE_FORMAT(NOW(),'%m_%Y'));
	 
	PREPARE stmt FROM @history_table_name;
	EXECUTE stmt;
	DEALLOCATE PREPARE stmt;
	 
	RENAME TABLE pm_log_request_2 TO pm_log_request;

END
;;
DELIMITER ;

-- ----------------------------
-- Procedure structure for p_dailydata
-- ----------------------------
DROP PROCEDURE IF EXISTS `p_dailydata`;
DELIMITER ;;
CREATE DEFINER=`pm_user2`@`211.151.211.248` PROCEDURE `p_dailydata`()
BEGIN
  /*充值数据*/
  DELETE 
  FROM
    pm_base.pm_data_bill 
  WHERE dd = SUBSTR(DATE_SUB(NOW(), INTERVAL 1 DAY), 1, 10) ;
  INSERT INTO pm_base.pm_data_bill (
    dd,
    TYPE,
    source,
    billuser_num,
    bill_money
  ) 
  SELECT 
    SUBSTR(
      FROM_UNIXTIME(create_t, '%Y-%m-%d %H:%i:%s'),
      1,
      10
    ) dd,
    TYPE,
    source,
    COUNT(DISTINCT openid) billuser_num,
    SUM(money) bill_money 
  FROM
    pm_base.pm_recharge 
  WHERE TYPE IN ('0') 
    AND STATUS = 2 
    AND SUBSTR(
      FROM_UNIXTIME(create_t, '%Y-%m-%d %H:%i:%s'),
      1,
      10
    ) = SUBSTR(DATE_SUB(NOW(), INTERVAL 1 DAY), 1, 10) 
  GROUP BY SUBSTR(
      FROM_UNIXTIME(create_t, '%Y-%m-%d %H:%i:%s'),
      1,
      10
    ),
    TYPE,
    source 
  ORDER BY dd,
    TYPE,
    source ;
  /*渠道数据*/
  DELETE 
  FROM
    pm_base.pm_data_ch 
  WHERE dd = SUBSTR(DATE_SUB(NOW(), INTERVAL 1 DAY), 1, 10) ;
  INSERT INTO pm_data_ch (
    dd,
    ch,
    regnum,
    bill_usernum,
    bill_money
  ) 
  SELECT 
    mm.dd,
    mm.ch,
    regnum,
    nn.bill_usernum,
    nn.bill_money 
  FROM
    (SELECT 
      SUBSTR(
        FROM_UNIXTIME(create_t, '%Y-%m-%d %H:%i:%s'),
        1,
        10
      ) dd,
      ch,
      COUNT(*) regnum 
    FROM
      pm_user a 
    WHERE SUBSTR(
        FROM_UNIXTIME(create_t, '%Y-%m-%d %H:%i:%s'),
        1,
        10
      ) = SUBSTR(DATE_SUB(NOW(), INTERVAL 1 DAY), 1, 10) 
    GROUP BY SUBSTR(
        FROM_UNIXTIME(create_t, '%Y-%m-%d %H:%i:%s'),
        1,
        10
      ),
      ch 
    ORDER BY ch,
      dd) mm 
    LEFT JOIN 
      (SELECT 
        SUBSTR(
          FROM_UNIXTIME(create_t, '%Y-%m-%d %H:%i:%s'),
          1,
          10
        ) dd,
        ch,
        COUNT(DISTINCT openid) bill_usernum,
        SUM(money) bill_money 
      FROM
        pm_base.pm_recharge 
      WHERE TYPE IN ('0') 
        AND STATUS = 2 
        AND SUBSTR(
          FROM_UNIXTIME(create_t, '%Y-%m-%d %H:%i:%s'),
          1,
          10
        ) = SUBSTR(DATE_SUB(NOW(), INTERVAL 1 DAY), 1, 10) 
      GROUP BY SUBSTR(
          FROM_UNIXTIME(create_t, '%Y-%m-%d %H:%i:%s'),
          1,
          10
        ),
        ch 
      ORDER BY dd,
        ch) nn 
      ON mm.ch = nn.ch 
      AND mm.dd = nn.dd ;
  INSERT INTO pm_data_valid (datatime, value1) 
  VALUES
    (
      DATE_FORMAT(NOW(), '%Y-%m-%d %H:%i:%s'),
      '充值、渠道数据'
    ) ;
  commit ;
  DELETE 
  FROM
    pm_base.pm_inout_money_data 
  WHERE bill_date >= SUBSTR(DATE_SUB(NOW(), INTERVAL 4 DAY), 1, 10) 
    AND bill_date <= SUBSTR(DATE_SUB(NOW(), INTERVAL 1 DAY), 1, 10) ;
  INSERT INTO pm_inout_money_data (
    bill_date,
    billnum,
    billpep,
    billmoney,
    zj_num,
    zj_pep,
    zj_money,
    prize_num,
    prize_pep,
    prize_money
  ) 
  SELECT 
    t1.bill_date,
    t1.billnum,
    t1.billpep,
    t1.billmoney,
    t2.zj_num,
    t2.zj_pep,
    t2.zj_money,
    t3.prize_num,
    t3.prize_pep,
    t3.prize_money 
  FROM
    (
      (SELECT 
        SUBSTR(
          FROM_UNIXTIME(create_t, '%Y-%m-%d %H:%i:%s'),
          1,
          10
        ) bill_date,
        COUNT(*) billnum,
        COUNT(DISTINCT openid) billpep,
        ROUND(SUM(money)) billmoney 
      FROM
        pm_recharge 
      WHERE TYPE = '0' 
        AND STATUS = 2 
        AND SUBSTR(
          FROM_UNIXTIME(create_t, '%Y-%m-%d %H:%i:%s'),
          1,
          10
        ) >= SUBSTR(DATE_SUB(NOW(), INTERVAL 4 DAY), 1, 10) 
        AND SUBSTR(
          FROM_UNIXTIME(create_t, '%Y-%m-%d %H:%i:%s'),
          1,
          10
        ) <= SUBSTR(DATE_SUB(NOW(), INTERVAL 1 DAY), 1, 10) 
      GROUP BY SUBSTR(
          FROM_UNIXTIME(create_t, '%Y-%m-%d %H:%i:%s'),
          1,
          10
        )) t1 
      LEFT JOIN 
        (SELECT 
          SUBSTR(
            FROM_UNIXTIME(win_t, '%Y-%m-%d %H:%i:%s'),
            1,
            10
          ) zj_date,
          COUNT(*) zj_num,
          COUNT(DISTINCT openid) zj_pep,
          ROUND(SUM(pur_price)) zj_money 
        FROM
          pm_goods_activity 
        WHERE state = 3 
          AND user_type = 1 
          AND SUBSTR(
            FROM_UNIXTIME(win_t, '%Y-%m-%d %H:%i:%s'),
            1,
            10
          ) >= SUBSTR(DATE_SUB(NOW(), INTERVAL 4 DAY), 1, 10) 
          AND SUBSTR(
            FROM_UNIXTIME(win_t, '%Y-%m-%d %H:%i:%s'),
            1,
            10
          ) <= SUBSTR(DATE_SUB(NOW(), INTERVAL 1 DAY), 1, 10) 
        GROUP BY SUBSTR(
            FROM_UNIXTIME(win_t, '%Y-%m-%d %H:%i:%s'),
            1,
            10
          )) t2 
        ON t1.bill_date = t2.zj_date
    ) 
    LEFT JOIN 
      (SELECT 
        SUBSTR(modify_t, 1, 10) prize_date,
        COUNT(*) prize_num,
        COUNT(DISTINCT openid) prize_pep,
        SUM(prize_price) prize_money 
      FROM
        pm_prize_draw_log 
      WHERE draw_state = 1 
        AND SUBSTR(modify_t, 1, 10) >= SUBSTR(DATE_SUB(NOW(), INTERVAL 4 DAY), 1, 10) 
        AND SUBSTR(modify_t, 1, 10) <= SUBSTR(DATE_SUB(NOW(), INTERVAL 1 DAY), 1, 10) 
        AND trans_state = 1 
      GROUP BY SUBSTR(modify_t, 1, 10)) t3 
      ON t1.bill_date = t3.prize_date ;
  INSERT INTO pm_data_valid (datatime, value1) 
  VALUES
    (
      DATE_FORMAT(NOW(), '%Y-%m-%d %H:%i:%s'),
      '充值、拍卖、中奖数据'
    ) ;
  DELETE 
  FROM
    pm_base.pm_reg_login_bill_data 
  WHERE data_desc >= SUBSTR(DATE_SUB(NOW(), INTERVAL 4 DAY), 1, 10) 
    AND data_desc <= SUBSTR(DATE_SUB(NOW(), INTERVAL 1 DAY), 1, 10) ;
  INSERT INTO pm_base.pm_reg_login_bill_data (
    data_desc,
    new_user_num,
    reg_user_num,
    reg_rate,
    login_num,
    bill_num,
    billmoney,
    avg_pepbill
  ) 
  SELECT 
    create_t data_desc,
    SUM(new_user) new_user_num,
    SUM(reg_user) reg_user_num,
    ROUND(SUM(reg_user) / SUM(new_user), 3) reg_rate,
    SUM(login_count) login_num,
    SUM(user_count) bill_num,
    ROUND(SUM(user_money), 2) billmoney,
    ROUND(SUM(user_money) / SUM(user_count), 2) avg_pepbill 
  FROM
    pm_ch_data 
  WHERE ch <> '' 
    AND create_t >= SUBSTR(DATE_SUB(NOW(), INTERVAL 4 DAY), 1, 10) 
    AND create_t <= SUBSTR(DATE_SUB(NOW(), INTERVAL 1 DAY), 1, 10) 
  GROUP BY create_t ;
  INSERT INTO pm_data_valid (datatime, value1) 
  VALUES
    (
      DATE_FORMAT(NOW(), '%Y-%m-%d %H:%i:%s'),
      '新增、日活、充值数据'
    ) ;
  DELETE 
  FROM
    pm_base.pm_share_rebate_data 
  WHERE data_desc = SUBSTR(DATE_SUB(NOW(), INTERVAL 1 DAY), 1, 10) ;
  INSERT INTO `pm_base`.`pm_share_rebate_data` (
    `data_desc`,
    `parent_num`,
    `son_num`,
    `avg_invite_num`,
    `gain_parent_num`,
    `gain_son_num`,
    `gain_money`
  ) 
  SELECT 
    mm.data_desc,
    mm.parent_num,
    mm.son_num,
    mm.avg_invite_num,
    nn.gain_parent_num,
    nn.gain_son_num,
    nn.gain_money 
  FROM
    (SELECT 
      SUBSTR(
        FROM_UNIXTIME(create_t, '%Y-%m-%d %H:%i:%s'),
        1,
        10
      ) data_desc,
      COUNT(DISTINCT parent_openid) parent_num,
      COUNT(DISTINCT openid) son_num,
      ROUND(
        COUNT(DISTINCT openid) / COUNT(DISTINCT parent_openid),
        1
      ) avg_invite_num 
    FROM
      pm_share_tree 
    WHERE SUBSTR(
        FROM_UNIXTIME(create_t, '%Y-%m-%d %H:%i:%s'),
        1,
        10
      ) = SUBSTR(DATE_SUB(NOW(), INTERVAL 1 DAY), 1, 10) 
    GROUP BY SUBSTR(
        FROM_UNIXTIME(create_t, '%Y-%m-%d %H:%i:%s'),
        1,
        10
      )) mm 
    LEFT JOIN 
      (SELECT 
        SUBSTR(
          FROM_UNIXTIME(created_t, '%Y-%m-%d %H:%i:%s'),
          1,
          10
        ) data_desc,
        COUNT(DISTINCT openid) gain_parent_num,
        COUNT(DISTINCT child_openid) gain_son_num,
        SUM(amount) gain_money 
      FROM
        pm_share_rebate 
      WHERE SUBSTR(
          FROM_UNIXTIME(created_t, '%Y-%m-%d %H:%i:%s'),
          1,
          10
        ) = SUBSTR(DATE_SUB(NOW(), INTERVAL 1 DAY), 1, 10) 
      GROUP BY SUBSTR(
          FROM_UNIXTIME(created_t, '%Y-%m-%d %H:%i:%s'),
          1,
          10
        )) nn 
      ON mm.data_desc = nn.data_desc ;
  INSERT INTO pm_data_valid (datatime, value1) 
  VALUES
    (
      DATE_FORMAT(NOW(), '%Y-%m-%d %H:%i:%s'),
      '邀请数据'
    ) ;
  
  /*大客户数据*/
  TRUNCATE TABLE pm_special_user02 ;
  INSERT INTO pm_special_user02 (
    openid,
    if_special,
    create_t,
    modify_t
  ) 
  SELECT 
    aa.openid,
    CASE
      WHEN sm >= 50 
      AND sm < 1000 
      THEN 2 
      WHEN sm >= 1000 
      THEN 1 
    END tp1,
    UNIX_TIMESTAMP(),
    UNIX_TIMESTAMP() 
  FROM
    (SELECT 
      openid,
      SUM(money) sm 
    FROM
      pm_recharge 
    WHERE TYPE = 0 
      AND STATUS = 2 
    GROUP BY openid 
    HAVING SUM(money) >= 50) aa ;
  INSERT INTO pm_special_user (
    openid,
    if_special,
    create_t,
    modify_t
  ) 
  SELECT 
    id1,
    if_special,
    UNIX_TIMESTAMP(),
    UNIX_TIMESTAMP() 
  FROM
    (SELECT 
      p.openid id1,
      p.if_special,
      q.openid id2 
    FROM
      pm_special_user02 p 
      LEFT JOIN pm_special_user q 
        ON p.openid = q.openid) mm 
  WHERE mm.id2 IS NULL ;
  INSERT INTO pm_data_valid (datatime, value1) 
  VALUES
    (
      DATE_FORMAT(NOW(), '%Y-%m-%d %H:%i:%s'),
      '大客户更新数据'
    ) ;
END
;;
DELIMITER ;

-- ----------------------------
-- Procedure structure for p_hmd
-- ----------------------------
DROP PROCEDURE IF EXISTS `p_hmd`;
DELIMITER ;;
CREATE DEFINER=`pm_user2`@`211.151.211.248` PROCEDURE `p_hmd`()
BEGIN
  /*黑名单数据*/
  TRUNCATE TABLE pm_prize_special_user02 ;
  INSERT INTO pm_prize_special_user02 (data_desc, openid, flag_status) 
  SELECT 
    data_desc,
    openid,
    flag_status 
  FROM
    (SELECT 
      SUBSTR(
        FROM_UNIXTIME(
          UNIX_TIMESTAMP(NOW()),
          '%Y-%m-%d %H:%i:%s'
        ),
        1,
        10
      ) data_desc,
      openid,
      0 flag_status 
    FROM
      pm_user 
    WHERE ip IN 
      (SELECT 
        ip 
      FROM
        pm_user 
      GROUP BY ip 
      HAVING COUNT(*) > 20) 
      UNION
      ALL 
      SELECT 
        SUBSTR(
          FROM_UNIXTIME(
            UNIX_TIMESTAMP(NOW()),
            '%Y-%m-%d %H:%i:%s'
          ),
          1,
          10
        ) data_desc,
        openid,
        0 flag_status 
      FROM
        pm_hmd_special_tmp 
      UNION
      ALL 
      SELECT 
        SUBSTR(
          FROM_UNIXTIME(
            UNIX_TIMESTAMP(NOW()),
            '%Y-%m-%d %H:%i:%s'
          ),
          1,
          10
        ) data_desc,
        openid,
        0 flag_status 
      FROM
        pm_user 
      WHERE SUBSTR(AREA, 1, INSTR(AREA, '省')) IN (
          '阿尔及利亚省',
          '阿根廷省',
          '阿联酋省',
          '埃及省',
          '爱尔兰省',
          '奥地利省',
          '澳大利亚省',
          '澳门省',
          '巴基斯坦省',
          '巴拉圭省',
          '巴西省',
          '百慕大省',
          '保加利亚省',
          '波兰省',
          '玻利维亚省',
          '丹麦省',
          '德国省',
          '多米尼加省',
          '俄罗斯省',
          '厄瓜多尔省',
          '法国省',
          '菲律宾省',
          '芬兰省',
          '哥伦比亚省',
          '哥斯达黎加省',
          '哈萨克斯坦省',
          '韩国省',
          '荷兰省',
          '加拿大省',
          '柬埔寨省',
          '捷克省',
          '拉脱维亚省',
          '立陶宛省',
          '罗马尼亚省',
          '马来西亚省',
          '美国省',
          '孟加拉国省',
          '秘鲁省',
          '墨西哥省',
          '南非省',
          '尼泊尔省',
          '尼加拉瓜省',
          '尼日利亚省',
          '挪威省',
          '葡萄牙省',
          '日本省',
          '瑞典省',
          '瑞士省',
          '萨尔瓦多省',
          '塞尔维亚省',
          '沙特阿拉伯省',
          '斯洛伐克省',
          '斯洛文尼亚省',
          '泰国省',
          '土耳其省',
          '危地马拉省',
          '委内瑞拉省',
          '乌拉圭省',
          '西班牙省',
          '希腊省',
          '香港省',
          '新西兰省',
          '匈牙利省',
          '意大利省',
          '印度省',
          '印尼省',
          '英国省',
          '越南省',
          '智利省'
        ) 
      UNION
      ALL 
      SELECT 
        SUBSTR(
          FROM_UNIXTIME(
            UNIX_TIMESTAMP(NOW()),
            '%Y-%m-%d %H:%i:%s'
          ),
          1,
          10
        ) data_desc,
        parent_openid openid,
        0 flag_status 
      FROM
        pm_share_tree 
      WHERE parent_openid IS NOT NULL 
      GROUP BY parent_openid 
      HAVING COUNT(*) >= 20 
      UNION
      ALL 
      SELECT 
        SUBSTR(
          FROM_UNIXTIME(
            UNIX_TIMESTAMP(NOW()),
            '%Y-%m-%d %H:%i:%s'
          ),
          1,
          10
        ) data_desc,
        openid,
        0 flag_status 
      FROM
        pm_user 
      WHERE ip IN 
        (SELECT 
          ip 
        FROM
          pm_user 
        WHERE ip <> '' 
          AND openid IN 
          (SELECT 
            openid 
          FROM
            pm_share_tree 
          WHERE parent_openid IN 
            (SELECT 
              parent_openid 
            FROM
              pm_share_tree 
            WHERE parent_openid IS NOT NULL 
            GROUP BY parent_openid 
            HAVING COUNT(*) >= 20)) 
        GROUP BY ip 
        HAVING COUNT(*) >= 20) 
        UNION
        ALL 
        SELECT 
          SUBSTR(
            FROM_UNIXTIME(
              UNIX_TIMESTAMP(NOW()),
              '%Y-%m-%d %H:%i:%s'
            ),
            1,
            10
          ) data_desc,
          openid,
          0 flag_status 
        FROM
          pm_user 
        WHERE deviceid IN 
          (SELECT 
            deviceid 
          FROM
            pm_user 
          WHERE deviceid <> '' 
            AND openid IN 
            (SELECT 
              openid 
            FROM
              pm_share_tree 
            WHERE parent_openid IN 
              (SELECT 
                parent_openid 
              FROM
                pm_share_tree 
              WHERE parent_openid IS NOT NULL 
              GROUP BY parent_openid 
              HAVING COUNT(*) >= 20)) 
          GROUP BY deviceid 
          HAVING COUNT(*) >= 10) 
          UNION
          ALL 
          SELECT 
            SUBSTR(
              FROM_UNIXTIME(
                UNIX_TIMESTAMP(NOW()),
                '%Y-%m-%d %H:%i:%s'
              ),
              1,
              10
            ) data_desc,
            openid,
            0 flag_status 
          FROM
            pm_user 
          WHERE deviceid IN 
            (SELECT 
              deviceid 
            FROM
              pm_user 
            WHERE cname IN ('韩迎旭', '杨亚娟') 
              AND deviceid <> '' 
            GROUP BY deviceid) 
            UNION
            ALL 
            SELECT 
              SUBSTR(
                FROM_UNIXTIME(
                  UNIX_TIMESTAMP(NOW()),
                  '%Y-%m-%d %H:%i:%s'
                ),
                1,
                10
              ) data_desc,
              openid,
              0 flag_status 
            FROM
              pm_user 
            WHERE openid IN 
              (SELECT 
                openid 
              FROM
                pm_user 
              WHERE phone IN (
                  '13163660661',
                  '13163665961',
                  '13234977822',
                  '13370817047',
                  '13796702962',
                  '15146632324',
                  '15146632829'
                ) 
                OR deviceid IN (
                  'AghPg6JWMVyU4D7hzYG8_SAVgSU_WoTVYqAbWa-i6WzJ',
                  'AkluWSbS0HpKPVGLogtqXZ6LC49OUc4haGxmtI33tLXA',
                  'AvRPxm5CpFFZ7McP1shYrmWD6Oo2znuAaRVyOJA00Pwt',
                  'AntdI10LWPYOmL0pujKvJUJC8yLH6_hT2dywU3Mne1AK',
                  'AghPg6JWMVyU4D7hzYG8_SBu5ya_nplxuC7fR-veeMHC'
                ) 
                OR ip IN (
                  '1.189.203.100',
                  '113.0.201.230',
                  '113.5.3.102',
                  '113.5.4.17',
                  '223.104.17.205'
                )) 
              UNION
              ALL 
              SELECT 
                SUBSTR(
                  FROM_UNIXTIME(
                    UNIX_TIMESTAMP(NOW()),
                    '%Y-%m-%d %H:%i:%s'
                  ),
                  1,
                  10
                ) data_desc,
                openid,
                0 flag_status 
              FROM
                pm_hmd_special_tmp 
              UNION
              ALL 
              SELECT 
                SUBSTR(
                  FROM_UNIXTIME(
                    UNIX_TIMESTAMP(NOW()),
                    '%Y-%m-%d %H:%i:%s'
                  ),
                  1,
                  10
                ) data_desc,
                openid,
                0 flag_status 
              FROM
                pm_user 
              WHERE deviceid IN 
                (SELECT 
                  deviceid 
                FROM
                  pm_user 
                WHERE deviceid <> '' 
                GROUP BY deviceid 
                HAVING COUNT(*) >= 5)) aa 
            WHERE openid <> '' 
            GROUP BY data_desc,
              openid,
              flag_status ;
commit;              
  INSERT INTO `pm_base`.`pm_prize_special_user` (
    `data_desc`,
    `openid`,
    `flag_status`
  ) 
  SELECT 
    qq.data_desc,
    qq.openid,
    qq.flag_status 
  FROM
    (SELECT 
      pp.data_desc,
      pp.openid,
      pp.flag_status 
    FROM
      (SELECT 
        m.data_desc,
        m.openid,
        m.flag_status,
        n.openid id2 
      FROM
        pm_prize_special_user02 m 
        LEFT JOIN pm_prize_special_user n 
          ON m.openid = n.openid) pp 
    WHERE pp.id2 IS NULL) qq 
  WHERE qq.openid NOT IN 
    (SELECT 
      openid 
    FROM
      pm_test_inner_account) ;
      commit;
-- 去内部号      
  DELETE 
  FROM
    pm_prize_special_user 
  WHERE openid IN 
    (SELECT 
      openid 
    FROM
      pm_test_inner_account) ;
  COMMIT ;
 
  --  综合识别：
 TRUNCATE TABLE  pm_hmd_info;
INSERT INTO `pm_base`.`pm_hmd_info` (
  `phone`,
  `deviceid`,
   `ip`,
   `login_mobile`
)  
  SELECT phone,deviceid, ip, login_mobile  FROM (  SELECT phone,deviceid, ip,login_mobile  FROM pm_user WHERE ip <> '' AND  ip IN (SELECT 
        ip 
      FROM
        pm_user 
      GROUP BY ip 
      HAVING COUNT(*) > 15) 
      UNION ALL 
   -- 设备   
      SELECT  phone,deviceid, ip,login_mobile
        FROM pm_user WHERE   deviceid IN (SELECT 
        deviceid 
      FROM
        pm_user WHERE  deviceid <> '' 
      GROUP BY deviceid 
      HAVING COUNT(*) > 10)
      
        UNION ALL 
  -- 国外IP：
  SELECT  phone,deviceid, ip,login_mobile
  FROM
        pm_user 
      WHERE SUBSTR(AREA, 1, INSTR(AREA, '省')) IN (
          '阿尔及利亚省',
          '阿根廷省',
          '阿联酋省',
          '埃及省',
          '爱尔兰省',
          '奥地利省',
          '澳大利亚省',
          '澳门省',
          '巴基斯坦省',
          '巴拉圭省',
          '巴西省',
          '百慕大省',
          '保加利亚省',
          '波兰省',
          '玻利维亚省',
          '丹麦省',
          '德国省',
          '多米尼加省',
          '俄罗斯省',
          '厄瓜多尔省',
          '法国省',
          '菲律宾省',
          '芬兰省',
          '哥伦比亚省',
          '哥斯达黎加省',
          '哈萨克斯坦省',
          '韩国省',
          '荷兰省',
          '加拿大省',
          '柬埔寨省',
          '捷克省',
          '拉脱维亚省',
          '立陶宛省',
          '罗马尼亚省',
          '马来西亚省',
          '美国省',
          '孟加拉国省',
          '秘鲁省',
          '墨西哥省',
          '南非省',
          '尼泊尔省',
          '尼加拉瓜省',
          '尼日利亚省',
          '挪威省',
          '葡萄牙省',
          '日本省',
          '瑞典省',
          '瑞士省',
          '萨尔瓦多省',
          '塞尔维亚省',
          '沙特阿拉伯省',
          '斯洛伐克省',
          '斯洛文尼亚省',
          '泰国省',
          '土耳其省',
          '危地马拉省',
          '委内瑞拉省',
          '乌拉圭省',
          '西班牙省',
          '希腊省',
          '香港省',
          '新西兰省',
          '匈牙利省',
          '意大利省',
          '印度省',
          '印尼省',
          '英国省',
          '越南省',
          '智利省'
        )     
       UNION ALL 
 -- 3 师徒 ,分师父、徒弟；-- 117 师
 SELECT  phone,deviceid, ip,login_mobile  FROM pm_user WHERE openid IN (
 SELECT 
    parent_openid
  FROM
    pm_share_tree 
  WHERE parent_openid IN 
    (SELECT 
      parent_openid openid 
    FROM
      pm_share_tree 
    WHERE parent_openid IS NOT NULL 
      
    GROUP BY parent_openid 
    HAVING COUNT(*) >= 15)
    GROUP BY parent_openid)
      ) qq
      GROUP BY phone,deviceid, ip, login_mobile ;
  
  commit;
   -- 2、在异常info表里封号， 最终执行：
UPDATE 
  pm_user 
SET
  status_flag = 0 
WHERE status_flag = 1 
  AND openid IN 
  (SELECT 
    openid 
  FROM
    (SELECT 
      openid 
    FROM
      pm_user 
    WHERE login_mobile <> '' 
      AND login_mobile IN 
      (SELECT 
        login_mobile 
      FROM
        pm_hmd_info) 
      UNION
      ALL 
      SELECT 
        openid 
      FROM
        pm_user 
      WHERE ip <> '' 
        AND ip IN 
        (SELECT 
          ip 
        FROM
          pm_hmd_info) 
        UNION
        ALL 
        SELECT 
          openid 
        FROM
          pm_user 
        WHERE deviceid <> '' 
          AND deviceid IN 
          (SELECT 
            deviceid 
          FROM
            pm_hmd_info)) bb 
      GROUP BY openid) 
      AND openid IN 
      (SELECT openid FROM (SELECT 
        openid 
      FROM
        pm_user 
      WHERE recharge_amount < 10) t )
      AND openid NOT IN 
      (SELECT 
        openid 
      FROM
        pm_test_inner_account) ;
  
  
  commit;
  
  --   ##########
-- 1: 3天内ip注册超4个封号 且充值<5  （选定） 
   UPDATE 
  pm_user SET   status_flag = 0 
WHERE SUBSTR(
    FROM_UNIXTIME(create_t, '%Y-%m-%d %H:%i:%s'),
    1,
    20
  ) >= DATE_ADD(NOW(), INTERVAL - 3 DAY) 
  AND openid IN (SELECT openid FROM (SELECT openid FROM pm_user WHERE recharge_amount<10) t)
  AND status_flag = 1 
  AND openid IN 
  (SELECT 
    openid 
  FROM
    (SELECT 
      openid 
    FROM
      pm_user 
    WHERE ip IN 
      (SELECT 
        ip 
      FROM
        pm_user 
      WHERE ip <> '' 
        AND SUBSTR(
          FROM_UNIXTIME(create_t, '%Y-%m-%d %H:%i:%s'),
          1,
          20
        ) >= DATE_ADD(NOW(), INTERVAL - 3 DAY) 
      GROUP BY ip 
      HAVING COUNT(*) > 5)) aa) ;
   COMMIT;
      -- 2 黑名单：   
  UPDATE 
    pm_user 
  SET
   status_flag = 0 
WHERE status_flag = 1 
  AND openid IN 
  (SELECT 
    openid 
  FROM
    pm_prize_special_user) 
  AND  openid IN  (SELECT openid FROM (SELECT 
        openid 
      FROM
        pm_user 
      WHERE recharge_amount < 10) t );
  
  -- 2天收7个徒弟的封；（选定） OK
 
 UPDATE 
   pm_user 
SET
   status_flag = 0 
  WHERE openid IN  (SELECT openid FROM (SELECT 
        openid 
      FROM
        pm_user 
      WHERE recharge_amount < 10) t ) 
  AND status_flag = 1 
  AND openid IN 
  (SELECT 
    openid 
  FROM
    pm_share_tree 
  WHERE parent_openid IN 
    (SELECT 
      parent_openid openid 
    FROM
      pm_share_tree 
    WHERE parent_openid IS NOT NULL 
      AND SUBSTR(
        FROM_UNIXTIME(create_t, '%Y-%m-%d %H:%i:%s'),
        1,
        10
      ) >= DATE_ADD(NOW(), INTERVAL - 2 DAY) 
    GROUP BY parent_openid 
    HAVING COUNT(*) >= 7)) ;
    COMMIT;  
    -- 2 天 device >=3    accont;     （选定）
  UPDATE 
    pm_user 
  SET
   status_flag = 0 
WHERE openid IN  (SELECT openid FROM (SELECT 
        openid 
      FROM
        pm_user 
      WHERE recharge_amount < 10) t ) 
  AND status_flag = 1 
  AND SUBSTR(
    FROM_UNIXTIME(create_t, '%Y-%m-%d %H:%i:%s'),
    1,
    10
  ) >= DATE_ADD(NOW(), INTERVAL - 2 DAY) 
  AND openid IN 
  (SELECT 
    aa.openid 
  FROM
    (SELECT 
      openid 
    FROM
      pm_user 
    WHERE deviceid IN 
      (SELECT 
        deviceid 
      FROM
        pm_user 
      WHERE deviceid <> '' 
      GROUP BY deviceid 
      HAVING COUNT(*) >= 3)) aa) ;
    COMMIT;    
      -- 2天  ， 密码4 个一样 (选用)
 
   
  -- fx wap 1天没充值就封掉；fx未加入；
--  UPDATE 
--   pm_user 
-- SET
--   status_flag = 0 
-- WHERE status_flag = 1 
--   AND  openid IN ( SELECT openid FROM (
--  SELECT openid FROM pm_user WHERE ch IN ('wap') AND SUBSTR(
--                 FROM_UNIXTIME(create_t, '%Y-%m-%d %H:%i:%s'),
--                 1,
--                 10
--               )>=DATE_ADD(NOW(), INTERVAL - 5 DAY)  AND SUBSTR(
--                 FROM_UNIXTIME(create_t, '%Y-%m-%d %H:%i:%s'),
--                 1,
--                 10
--               )<=DATE_ADD(NOW(), INTERVAL - 1 DAY)   AND  status_flag = 1 AND openid IN  (SELECT openid FROM (SELECT 
--         openid 
--       FROM
--         pm_user 
--       WHERE recharge_amount < 10) t )) d); 
               
    -- 找出封号，充值手机卡号码，再找出号码绑定openid;  最终执行版：  
   
UPDATE 
  pm_user 
SET
  status_flag = 0 
WHERE status_flag = 1 
  AND openid IN 
  (SELECT 
    openid 
  FROM
    (SELECT 
      openid 
    FROM
      pm_user 
    WHERE recharge_amount < 20 
      AND status_flag = 1 
      AND openid IN 
      (SELECT 
        openid 
      FROM
        (SELECT 
          a.openid,
          b.mobile 
        FROM
          pm_goods_activity a 
          INNER JOIN pm_recharge_card b 
            ON a.win_no = b.order_id 
        GROUP BY a.openid,
          b.mobile) c 
      WHERE c.mobile IN 
        (SELECT 
          tel 
        FROM
          pm_user 
        WHERE status_flag = 0 
          AND tel IN 
          (SELECT 
            c.mobile 
          FROM
            (SELECT 
              a.openid,
              b.mobile 
            FROM
              pm_goods_activity a 
              INNER JOIN pm_recharge_card b 
                ON a.win_no = b.order_id 
            GROUP BY a.openid,
              b.mobile) c 
          GROUP BY c.mobile)))) d); 
  COMMIT;          
  
  -- 支付封号alipay,一支付帐号10天中5单，充值少于5元；  OK
--     UPDATE 
--     pm_user 
--   SET
--    status_flag = 0 
-- WHERE status_flag = 1 
--   AND openid IN 
--   (SELECT openid FROM (
-- SELECT openid FROM pm_user WHERE status_flag=1 AND openid NOT IN (SELECT openid FROM pm_test_inner_account) AND  openid IN (
-- SELECT openid FROM pm_user_roi_tag WHERE real_consume<20 AND  openid IN (
-- SELECT openid FROM pm_wxpay WHERE account IN (SELECT account FROM (
-- SELECT a.wx_order,a.account,a.openid   FROM pm_wxpay a,pm_recharge b
-- WHERE SUBSTR(a.wx_order,1,8)>=DATE_FORMAT(DATE_ADD(NOW(), INTERVAL - 3 DAY) ,'%Y%m%d')	AND  a.wx_order=b.recharge_id AND b.goods_id<>0
-- GROUP BY  a.wx_order,a.account,a.openid) c
-- GROUP BY c.account
-- HAVING COUNT(DISTINCT c.wx_order)>=10)
-- GROUP BY openid) ) ) p);
-- 支付封号wx，一支付帐号10天中5单，充值少于5元；
UPDATE 
  pm_user 
SET
  status_flag = 0 
WHERE status_flag = 1 
  AND openid IN 
  (SELECT 
    openid 
  FROM
    (SELECT 
      openid 
    FROM
      pm_user 
    WHERE status_flag = 1 
      AND openid NOT IN 
      (SELECT 
        openid 
      FROM
        pm_test_inner_account) 
      AND openid IN 
      (SELECT 
        openid 
      FROM
        pm_user 
      WHERE recharge_amount < 20 
        AND openid IN 
        (SELECT 
          openid 
        FROM
          pm_alipay 
        WHERE account IN 
          (SELECT 
            account 
          FROM
            (SELECT 
              a.ali_order,
              a.account,
              a.openid 
            FROM
              pm_alipay a,
              pm_recharge b 
            WHERE SUBSTR(a.ali_order, 1, 8) >= DATE_FORMAT(
                DATE_ADD(NOW(), INTERVAL - 3 DAY),
                '%Y%m%d'
              ) 
              AND a.ali_order = b.recharge_id 
              AND b.goods_id <> 0 
            GROUP BY a.ali_order,
              a.account,
              a.openid) c 
          GROUP BY c.account 
          HAVING COUNT(DISTINCT c.ali_order) >= 10) 
        GROUP BY openid))) p) ;
   COMMIT;     
   
       -- 有充值20+,unique_id <10个的放开：(选定)
 
UPDATE 
  pm_user 
SET
  status_flag = 1 
WHERE status_flag = 0 
  AND  openid IN ( SELECT openid FROM ( 
  SELECT openid FROM pm_user WHERE status_flag=0 AND  unique_id IN (
SELECT unique_id  FROM pm_user WHERE recharge_amount>=20 AND unique_id>10
GROUP BY unique_id 
HAVING COUNT(*) <10 )) t );  
  commit;
 -- iosjs 放开   
UPDATE 
  pm_user 
SET
  ch = 'iosjs'  
WHERE login_mobile='13341642079'; 
-- 特殊号处理（IOS及另一特别用户）
UPDATE 
  pm_user 
SET
  status_flag = 1 
WHERE status_flag = 0 
  AND  openid IN ('wx_bd59fbbdbee0673c974b4954','sj_73749985ad0f0fb2ad6c1692','qq_090b60307f40f171d2e52358','wx_d0eb9ef5099977de372a1958','wx_6319d5d303b0630d77667645');   
  
   COMMIT;
UPDATE 
  pm_user 
SET
  status_flag = 0 
WHERE status_flag = 1
AND  openid IN ('wx_c6136568b745a97a90781452','wx_dd8beb336abf103b27a26523');   
--    commit;
 -- 内部设备解封：
UPDATE 
  pm_user 
SET
  status_flag = 1 
WHERE deviceid IN 
  (SELECT 
    deviceid 
  FROM
    (SELECT 
      deviceid 
    FROM
      pm_user 
    WHERE openid IN 
      (SELECT 
        openid 
      FROM
        pm_test_inner_account)) d) ;   
   COMMIT;       
-- 从黑名单去未封的号
DELETE 
FROM
  `pm_prize_special_user` 
WHERE openid IN 
  (SELECT 
    openid 
  FROM
    pm_user 
  WHERE status_flag = 1) ;
        
  COMMIT;         
  REPLACE INTO `pm_base`.`pm_roi_hmd_tmp` (
    `data_desc`,
    `openid`,
    `flag_status`
  ) 
  SELECT 
    SUBSTR(
      FROM_UNIXTIME(
        UNIX_TIMESTAMP(NOW()),
        '%Y-%m-%d %H:%i:%s'
      ),
      1,
      13
    ) data_desc,
    openid,
    0 flag_status 
  FROM
    pm_user 
  WHERE phone IN (
      '13163660661',
      '13163665961',
      '13234977822',
      '13370817047',
      '13796702962',
      '15146632324',
      '15146632829'
    ) 
    OR deviceid IN (
      'AghPg6JWMVyU4D7hzYG8_SAVgSU_WoTVYqAbWa-i6WzJ',
      'AkluWSbS0HpKPVGLogtqXZ6LC49OUc4haGxmtI33tLXA',
      'AvRPxm5CpFFZ7McP1shYrmWD6Oo2znuAaRVyOJA00Pwt'
    ) 
    OR ip IN (
      '1.189.203.100',
      '113.0.201.230',
      '113.5.3.102',
      '113.5.4.17',
      '223.104.17.205'
    ) ;
  COMMIT ;
  INSERT INTO pm_data_valid (datatime, value1) 
  VALUES
    (
      DATE_FORMAT(NOW(), '%Y-%m-%d %H:%i:%s'),
      '黑名单数据11'
    ) ;
END
;;
DELIMITER ;

-- ----------------------------
-- Procedure structure for p_user_roi_tag
-- ----------------------------
DROP PROCEDURE IF EXISTS `p_user_roi_tag`;
DELIMITER ;;
CREATE DEFINER=`pm_user2`@`211.151.211.248` PROCEDURE `p_user_roi_tag`()
BEGIN
  /**/
  TRUNCATE TABLE pm_user_roi_tag_bak ;
  insert INTO `pm_base`.`pm_user_roi_tag_bak` (
    data_desc,
    `openid`,
    `real_consume`,
    `get_money`,
    `jinkui`,
    `roi_bate`
  ) 
  SELECT 
    SUBSTR(
      FROM_UNIXTIME(
        UNIX_TIMESTAMP(NOW()),
        '%Y-%m-%d %H:%i:%s'
      ),
      1,
      13
    ) data_desc,
    aa.openid,
    aa.real_consume,
    (
      IFNULL(bb.zj_money, 0) + IFNULL(cc.prize_money, 0)
    ) get_money,
    (
      IFNULL(aa.bill_money, 0) - IFNULL(cc.prize_money, 0) - IFNULL(bb.zj_money, 0)
    ) jinkui,
    IFNULL(
      (
        IFNULL(bb.zj_money, 0) + IFNULL(cc.prize_money, 0)
      ) / aa.real_consume,
      0
    ) roi_bate 
  FROM
    (SELECT 
      qq.openid,
      (IFNULL(hh.bill_money, 0.1)) real_consume,
      hh.bill_money 
    FROM
      (SELECT 
        openid 
      FROM
        pm_user 
      WHERE SUBSTR(
          FROM_UNIXTIME(login_time, '%Y-%m-%d %H:%i:%s'),
          1,
          10
        ) >= DATE_ADD(NOW(), INTERVAL - 60 DAY)) qq 
      LEFT JOIN 
        (SELECT 
          openid,
          SUM(money) bill_money 
        FROM
          pm_recharge 
        WHERE TYPE = '0' 
          AND STATUS = 2 
          AND SUBSTR(
            FROM_UNIXTIME(create_t, '%Y-%m-%d %H:%i:%s'),
            1,
            10
          ) >= DATE_ADD(NOW(), INTERVAL - 60 DAY) 
        GROUP BY openid) hh 
        ON qq.openid = hh.openid) aa 
    LEFT JOIN 
      (SELECT 
        openid,
        SUM(price) zj_money 
      FROM
        pm_goods_activity 
      WHERE state NOT IN (101, 100, 1, 0) 
        AND user_type = 1 
        AND SUBSTR(
          FROM_UNIXTIME(create_t, '%Y-%m-%d %H:%i:%s'),
          1,
          10
        ) >= DATE_ADD(NOW(), INTERVAL - 60 DAY) 
      GROUP BY openid) bb 
      ON aa.openid = bb.openid 
    LEFT JOIN 
      (SELECT 
        openid,
        SUM(prize_price) prize_money 
      FROM
        pm_prize_draw_log 
      WHERE prize_state = 1 
        AND draw_state = 1 
        AND create_t >= DATE_ADD(NOW(), INTERVAL - 60 DAY) 
      GROUP BY openid) cc 
      ON aa.openid = cc.openid 
  GROUP BY aa.openid ;
  UPDATE 
    pm_user_roi_tag_bak 
  SET
    roi_bate = 3.33 
  WHERE openid IN 
    (SELECT 
      openid 
    FROM
      (SELECT 
        openid 
      FROM
        (SELECT 
          openid 
        FROM
          pm_user_roi_tag 
        WHERE roi_bate >= 1 
          AND jinkui < - 100 
          AND openid NOT IN 
          (SELECT 
            openid 
          FROM
            pm_test_inner_account)) cc 
      UNION
      ALL 
      SELECT 
        openid 
      FROM
        pm_roi_hmd_tmp) dd 
    GROUP BY openid) ;
  DELETE 
  FROM
    pm_base.pm_user_roi_tag_his 
  WHERE data_desc = SUBSTR(
      FROM_UNIXTIME(
        UNIX_TIMESTAMP(NOW()),
        '%Y-%m-%d %H:%i:%s'
      ),
      1,
      13
    ) ;
  INSERT INTO `pm_base`.`pm_user_roi_tag_his` (
    data_desc,
    `openid`,
    `real_consume`,
    `get_money`,
    `jinkui`,
    `roi_bate`
  ) 
  SELECT 
    SUBSTR(
      FROM_UNIXTIME(
        UNIX_TIMESTAMP(NOW()),
        '%Y-%m-%d %H:%i:%s'
      ),
      1,
      13
    ) data_desc,
    aa.openid,
    aa.real_consume,
    (
      IFNULL(bb.zj_money, 0) + IFNULL(cc.prize_money, 0)
    ) get_money,
    (
      IFNULL(aa.bill_money, 0) - IFNULL(cc.prize_money, 0) - IFNULL(bb.zj_money, 0)
    ) jinkui,
    IFNULL(
      (
        IFNULL(bb.zj_money, 0) + IFNULL(cc.prize_money, 0)
      ) / aa.real_consume,
      0
    ) roi_bate 
  FROM
    (SELECT 
      qq.openid,
      (IFNULL(hh.bill_money, 0.1)) real_consume,
      hh.bill_money 
    FROM
      (SELECT 
        openid 
      FROM
        pm_user 
      WHERE SUBSTR(
          FROM_UNIXTIME(login_time, '%Y-%m-%d %H:%i:%s'),
          1,
          10
        ) >= DATE_ADD(NOW(), INTERVAL - 60 DAY)) qq 
      LEFT JOIN 
        (SELECT 
          openid,
          SUM(money) bill_money 
        FROM
          pm_recharge 
        WHERE TYPE = '0' 
          AND STATUS = 2 
          AND SUBSTR(
            FROM_UNIXTIME(create_t, '%Y-%m-%d %H:%i:%s'),
            1,
            10
          ) >= DATE_ADD(NOW(), INTERVAL - 60 DAY) 
        GROUP BY openid) hh 
        ON qq.openid = hh.openid) aa 
    LEFT JOIN 
      (SELECT 
        openid,
        SUM(price) zj_money 
      FROM
        pm_goods_activity 
      WHERE state NOT IN (101, 100, 1, 0) 
        AND user_type = 1 
        AND SUBSTR(
          FROM_UNIXTIME(create_t, '%Y-%m-%d %H:%i:%s'),
          1,
          10
        ) >= DATE_ADD(NOW(), INTERVAL - 60 DAY) 
      GROUP BY openid) bb 
      ON aa.openid = bb.openid 
    LEFT JOIN 
      (SELECT 
        openid,
        SUM(prize_price) prize_money 
      FROM
        pm_prize_draw_log 
      WHERE prize_state = 1 
        AND draw_state = 1 
        AND create_t >= DATE_ADD(NOW(), INTERVAL - 60 DAY) 
      GROUP BY openid) cc 
      ON aa.openid = cc.openid 
  GROUP BY aa.openid ;
  INSERT INTO pm_data_valid (datatime, value1) 
  VALUES
    (
      DATE_FORMAT(NOW(), '%Y-%m-%d %H:%i:%s'),
      '个性化拍卖数据'
    ) ;
END
;;
DELIMITER ;

-- ----------------------------
-- Procedure structure for p_user_roi_tag_new
-- ----------------------------
DROP PROCEDURE IF EXISTS `p_user_roi_tag_new`;
DELIMITER ;;
CREATE DEFINER=`pm_user2`@`211.151.211.248` PROCEDURE `p_user_roi_tag_new`()
BEGIN
  /**/
  -- TRUNCATE TABLE pm_user_roi_tag ;
  replace INTO `pm_base`.`pm_user_roi_tag` (
    data_desc,
    `openid`,
    `real_consume`,
    `get_money`,
    `jinkui`,
    `roi_bate`
  ) 
  SELECT 
    SUBSTR(
      FROM_UNIXTIME(
        UNIX_TIMESTAMP(NOW()),
        '%Y-%m-%d %H:%i:%s'
      ),
      1,
      13
    ) data_desc,
    aa.openid,
    aa.real_consume,
    (
      IFNULL(bb.zj_money, 0) + IFNULL(cc.prize_money, 0)
    ) get_money,
    (
      IFNULL(aa.bill_money, 0) - IFNULL(cc.prize_money, 0) - IFNULL(bb.zj_money, 0)
    ) jinkui,
    IFNULL(
      (
        IFNULL(bb.zj_money, 0) + IFNULL(cc.prize_money, 0)
      ) / aa.real_consume,
      0
    ) roi_bate 
  FROM
    (SELECT 
      qq.openid,
      (IFNULL(hh.bill_money, 0.1)) real_consume,
      hh.bill_money 
    FROM
      (SELECT 
        openid 
      FROM
        pm_user 
      WHERE SUBSTR(
          FROM_UNIXTIME(login_time, '%Y-%m-%d %H:%i:%s'),
          1,
          10
        ) >= DATE_ADD(NOW(), INTERVAL - 60 DAY) OR SUBSTR(
          FROM_UNIXTIME(modify_t, '%Y-%m-%d %H:%i:%s'),
          1,
          10
        ) >= DATE_ADD(NOW(), INTERVAL - 60 DAY)) qq 
      LEFT JOIN 
        (SELECT 
          openid,
          SUM(money) bill_money 
        FROM
          pm_recharge 
        WHERE TYPE = '0' 
          AND STATUS = 2 
          AND SUBSTR(
            FROM_UNIXTIME(create_t, '%Y-%m-%d %H:%i:%s'),
            1,
            10
          ) >= DATE_ADD(NOW(), INTERVAL - 60 DAY) 
        GROUP BY openid) hh 
        ON qq.openid = hh.openid) aa 
    LEFT JOIN 
      (SELECT 
        openid,
        SUM(price) zj_money 
      FROM
        pm_goods_activity 
      WHERE state NOT IN (101, 100, 1, 0) 
        AND user_type = 1 
        AND SUBSTR(
          FROM_UNIXTIME(create_t, '%Y-%m-%d %H:%i:%s'),
          1,
          10
        ) >= DATE_ADD(NOW(), INTERVAL - 60 DAY) 
      GROUP BY openid) bb 
      ON aa.openid = bb.openid 
    LEFT JOIN 
      (SELECT 
        openid,
        SUM(prize_price) prize_money 
      FROM
        pm_prize_draw_log 
      WHERE prize_state = 1 
        AND draw_state = 1 
        AND create_t >= DATE_ADD(NOW(), INTERVAL - 60 DAY) 
      GROUP BY openid) cc 
      ON aa.openid = cc.openid 
  GROUP BY aa.openid ;
commit;
UPDATE 
    pm_user_roi_tag 
  SET
    roi_bate = 0.666 
  WHERE openid IN (
SELECT 
  openid 
FROM
(SELECT 
      openid 
    FROM
      pm_user_roi_tag 
    WHERE roi_bate >= 0.7 
      AND get_money < 100 
      AND openid NOT IN 
      (SELECT 
        openid 
      FROM
        pm_test_inner_account)) cc 
 GROUP BY openid );
 commit;
UPDATE 
    pm_user_roi_tag 
  SET
    roi_bate = 3.33 
  WHERE openid IN 
    (SELECT 
  openid 
FROM
  (SELECT 
    openid 
  FROM
    (SELECT 
      openid 
    FROM
      pm_user_roi_tag 
    WHERE roi_bate >= 0.7 
      AND get_money >=100 
      AND openid NOT IN 
      (SELECT 
        openid 
      FROM
        pm_test_inner_account)) cc 
  UNION
  ALL 
  SELECT 
    openid 
  FROM
    pm_roi_hmd_tmp) dd 
GROUP BY openid 
) ;
COMMIT;
 
--  roiv2_0130  
  
REPLACE INTO `pm_base`.`pm_user_roi_tag_v2` (
  `data_desc`,
  `openid`,
  `real_consume`,
  `get_money`,
  `jinkui`,
  `roi_bate`,
  `pm_allcli_num`,
  `bidnum`,
  `no_bidnum`,
  `no_bidmoney`
) 
SELECT 
  SUBSTR(
    FROM_UNIXTIME(
      UNIX_TIMESTAMP(NOW()),
      '%Y-%m-%d %H:%i:%s'
    ),
    1,
    13
  ) data_desc,
  gg.openid,
  gg.real_consume,
  (
    IFNULL(gg.zj_money, 0) + IFNULL(gg.prize_money, 0)
  ) get_money,
  (
    IFNULL(gg.real_consume, 0) - IFNULL(gg.prize_money, 0) - IFNULL(gg.zj_money, 0)
  ) jinkui,
  IFNULL(
    (
      IFNULL(gg.zj_money, 0) + IFNULL(gg.prize_money, 0)
    ) / gg.real_consume,
    0
  ) roi_bate,
  gg.pm_allcli_num,
  gg.bidnum,
  gg.no_bidnum,
  gg.no_bidmoney 
FROM
  (SELECT 
    aa.openid,
    IFNULL(bb.pm_cli_num, 0) pm_allcli_num,
    (IFNULL(cc.bill_money, 0.1)) real_consume,
    IFNULL(dd.zj_money, 0) zj_money,
    IFNULL(dd.bidnum, 0) bidnum,
    IFNULL(ee.no_bidnum, 0) no_bidnum,
    IFNULL(ee.no_bidmoney, 0) no_bidmoney,
    IFNULL(ff.prize_money, 0) prize_money 
  FROM
  -- 60天活跃
    (SELECT 
      openid 
    FROM
      pm_user 
    WHERE SUBSTR(
        FROM_UNIXTIME(login_time, '%Y-%m-%d %H:%i:%s'),
        1,
        10
      ) >= DATE_ADD(NOW(), INTERVAL - 60 DAY) OR SUBSTR(
          FROM_UNIXTIME(modify_t, '%Y-%m-%d %H:%i:%s'),
          1,
          10
        ) >= DATE_ADD(NOW(), INTERVAL - 60 DAY)) aa 
    LEFT JOIN 
    -- 7天 拍了几件商品
      (SELECT 
        openid,
        COUNT(DISTINCT goods_id) pm_cli_num 
      FROM
        pm_recharge 
      WHERE TYPE = '1' 
        AND STATUS = 2 
        AND SUBSTR(
          FROM_UNIXTIME(create_t, '%Y-%m-%d %H:%i:%s'),
          1,
          10
        ) >= DATE_ADD(NOW(), INTERVAL - 7 DAY) 
      GROUP BY openid) bb 
      ON aa.openid = bb.openid 
    LEFT JOIN 
-- 7天用户充值金额    
      (SELECT 
        openid,
        SUM(money) bill_money 
      FROM
        pm_recharge 
      WHERE TYPE = '0' 
        AND STATUS = 2 
        AND SUBSTR(
          FROM_UNIXTIME(create_t, '%Y-%m-%d %H:%i:%s'),
          1,
          10
        ) >= DATE_ADD(NOW(), INTERVAL - 7 DAY) 
      GROUP BY openid) cc 
      ON aa.openid = cc.openid 
    LEFT JOIN 
    -- 7天拍中商品件数、价值
      (SELECT 
        openid,
        SUM(price) zj_money,
        COUNT(DISTINCT id) bidnum 
      FROM
        pm_goods_activity 
      WHERE state NOT IN (101, 100, 1, 0) 
        AND user_type = 1 
        AND SUBSTR(
          FROM_UNIXTIME(create_t, '%Y-%m-%d %H:%i:%s'),
          1,
          10
        ) >= DATE_ADD(NOW(), INTERVAL - 7 DAY) 
      GROUP BY openid) dd 
      ON aa.openid = dd.openid 
    LEFT JOIN 
    -- 7天未中，商品拍的件数及拍币金额
      (SELECT 
        cc.id1,
        COUNT(DISTINCT cc.goods_id) no_bidnum,
        SUM(cc.sm) no_bidmoney 
      FROM
        (SELECT 
          aa.openid id1,
          aa.goods_id,
          aa.create_t,
          aa.sm,
          bb.openid id2,
          bb.max_ordertime 
        FROM
          (SELECT 
            openid,
            goods_id,
           SUBSTR(
                FROM_UNIXTIME(MIN(create_t), '%Y-%m-%d %H:%i:%s'),
                1,
                20
              )   create_t,
            SUM(money) sm 
          FROM
            pm_recharge 
          WHERE TYPE = 1 
            AND STATUS = 2 
            AND msg = '竞拍扣款' 
            AND SUBSTR(
              FROM_UNIXTIME(create_t, '%Y-%m-%d %H:%i:%s'),
              1,
              10
            ) >= DATE_ADD(NOW(), INTERVAL - 7 DAY) 
          GROUP BY openid,
            goods_id) aa 
          LEFT JOIN 
            (SELECT 
              openid,
             SUBSTR(
              FROM_UNIXTIME(MAX(win_t), '%Y-%m-%d %H:%i:%s'),
              1,
              20
            )   max_ordertime 
            FROM
              pm_goods_activity  
            WHERE SUBSTR(
                FROM_UNIXTIME(create_t, '%Y-%m-%d %H:%i:%s'),
                1,
                10
              ) >= DATE_ADD(NOW(), INTERVAL - 30 DAY) 
              AND user_type = 1 AND state NOT IN (101, 100, 1, 0) 
            GROUP BY openid) bb 
           ON aa.openid = bb.openid 
        ) cc 
      WHERE cc.create_t > IFNULL(cc.max_ordertime, 0) 
      GROUP BY cc.id1) ee 
      ON aa.openid = ee.id1 
    LEFT JOIN 
      (SELECT 
        openid,
        SUM(prize_price) prize_money 
      FROM
        pm_prize_draw_log 
      WHERE prize_state = 1 
        AND draw_state = 1 
        AND create_t >= DATE_ADD(NOW(), INTERVAL - 7 DAY) 
      GROUP BY openid) ff 
      ON aa.openid = ff.openid) gg 
GROUP BY gg.openid ;
 commit;
 
  INSERT INTO pm_data_valid (datatime, value1) 
  VALUES
    (
      DATE_FORMAT(NOW(), '%Y-%m-%d %H:%i:%s'),
      '个性化拍卖数据new'
    ) ;
    
 -- 先更新再插入；   
 -- 
-- UPDATE 
--   pm_base.pm_user_subsidy 
-- SET
--   real_subsidy = (- ROUND(price * 2.75)) 
-- WHERE id IN 
--   (SELECT 
--     id 
--   FROM
--     (SELECT 
--       id 
--     FROM
--       pm_user_subsidy 
--     WHERE openid IN 
--       (SELECT 
--         openid 
--       FROM
--         pm_base.pm_user_roi_tag_v2 
--       WHERE real_consume >= 100 
--         AND no_bidnum < 3 
--         AND bidnum > 10) 
--       AND MOD(num, 2) = 1 
--       AND goods_activity_id IN 
--       (SELECT 
--         id 
--       FROM
--         pm_base.pm_goods_activity 
--       WHERE state = 1) 
--       AND goods_activity_id NOT IN 
--       (SELECT 
--         goods_activity_id 
--       FROM
--         pm_base.pm_user_adjust)) AS t);
  commit;     
-- 找到要罚用户
 -- INSERT INTO `pm_base`.`pm_user_adjust` (
--   `openid`,
--   `goods_activity_id`,
--   `real_subsidy`,
--   `price`,
--   `status`,
--   `data_desc`,
--   `num`
-- )  
-- SELECT  
-- openid,goods_activity_id,(- ROUND(price*2.75)) ,price,0,SUBSTR(
--     FROM_UNIXTIME(
--       UNIX_TIMESTAMP(NOW()),
--       '%Y-%m-%d %H:%i:%s'
--     ),
--     1,
--     13
--   ) ,num
-- FROM
--   pm_user_subsidy 
-- WHERE openid IN 
--   (SELECT 
--     openid 
--   FROM
--     pm_user_roi_tag_v2 
--   WHERE real_consume >= 100 
--     AND no_bidnum < 3 
--     AND bidnum > 10) 
--   AND MOD(num, 2) = 1 
--   AND goods_activity_id IN 
--   (SELECT 
--     id 
--   FROM
--     pm_goods_activity 
--   WHERE state = 1);
 commit; 
 -- 1  
 
 -- 奖
-- INSERT INTO `pm_base`.`pm_user_roi_adjust` (
--   `openid`,
--   `goods_activity_id`,
--   `bate`,
--   `real_subsidy`,
--   `price`,
--   `sm`,
--   `need_money`,status_flag
-- ) 
-- SELECT dd.openid,dd.goods_activity_id,dd.bate,dd.real_subsidy,dd.price,dd.sm,(dd.price*1.3-dd.sm) need_money,'1' FROM (
-- SELECT 
--  cc.openid,cc.goods_activity_id,cc.bate,cc.real_subsidy,cc.price,cc.sm
-- FROM
--   (SELECT 
--     aa.openid,
--     aa.goods_activity_id,
--     aa.real_subsidy,
--     aa.price,
--     bb.sm,
--     bb.sm / (aa.price*1.3) bate 
--   FROM
--     (SELECT 
--       openid,
--       goods_activity_id,
--       real_subsidy,
--       price,
--       STATUS,
--       create_time 
--     FROM
--       pm_user_subsidy 
--     WHERE goods_activity_id IN 
--       (SELECT 
--         id 
--       FROM
--         pm_goods_activity 
--       where state = 1
--       ) 
--       AND openid IN 
--       (SELECT 
--         openid 
--       FROM
--         pm_user_roi_tag_v2 
--       WHERE real_consume >= 100 
--         AND no_bidnum >= 3 AND bidnum < 10
--         AND no_bidmoney > 500)) aa 
--     LEFT JOIN 
--       (SELECT 
--         openid,
--         goods_id,
--         SUM(money) sm 
--       FROM
--         pm_recharge 
--       WHERE TYPE = 1 
--         AND STATUS = 2 
--         AND msg = '竞拍扣款' 
--         AND goods_id IN 
--         (SELECT 
--           id 
--         FROM
--           pm_goods_activity 
--         WHERE state = 1
--         ) 
--       GROUP BY openid,
--         goods_id) bb 
--       ON aa.openid = bb.openid 
--       AND aa.goods_activity_id = bb.goods_id) cc 
-- WHERE cc.bate >= 0.5  AND cc.bate<=1
-- ORDER BY bate DESC LIMIT 1000000) dd
-- GROUP BY dd.openid ;
commit;
-- UPDATE 
--   pm_user_subsidy s,
--   pm_user_roi_adjust c 
-- SET
--   s.real_subsidy = c.price * 1.3 - c.sm 
-- WHERE s.openid = c.openid 
--   AND s.goods_activity_id = c.goods_activity_id 
--   AND c.status_flag = 1 
--   AND s.goods_activity_id IN 
--   (SELECT 
--     id 
--   FROM
--     pm_goods_activity 
--   WHERE state = 1) 
--   AND s.goods_activity_id NOT IN 
--   (SELECT 
--     goods_activity_id 
--   FROM
--     pm_user_adjust) ;
--     
    commit; 
    -- INSERT INTO `pm_base`.`pm_user_adjust` (
--   `openid`,
--   `goods_activity_id`,
--   `real_subsidy`,
--   `price`,
--   `status`,
--   `data_desc`,
--   `num`
-- )  
-- SELECT dd.openid,dd.goods_activity_id,(dd.price*1.3-dd.sm),dd.price,1,SUBSTR(
--     FROM_UNIXTIME(
--       UNIX_TIMESTAMP(NOW()),
--       '%Y-%m-%d %H:%i:%s'
--     ),
--     1,
--     13
--   ),'' FROM (
-- SELECT 
--  cc.openid,cc.goods_activity_id,cc.bate,cc.real_subsidy,cc.price,cc.sm
-- FROM
--   (SELECT 
--     aa.openid,
--     aa.goods_activity_id,
--     aa.real_subsidy,
--     aa.price,
--     bb.sm,
--     bb.sm / (aa.price*1.3) bate 
--   FROM
--     (SELECT 
--       openid,
--       goods_activity_id,
--       real_subsidy,
--       price,
--       STATUS,
--       create_time 
--     FROM
--       pm_user_subsidy 
--     WHERE goods_activity_id IN 
--       (SELECT 
--         id 
--       FROM
--         pm_goods_activity 
--      where state = 1
--       ) 
--       AND openid IN 
--       (SELECT 
--         openid 
--       FROM
--         pm_user_roi_tag_v2 
--       WHERE real_consume >= 100 
--         AND no_bidnum >= 3 AND bidnum < 10
--         AND no_bidmoney > 500)) aa 
--     LEFT JOIN 
--       (SELECT 
--         openid,
--         goods_id,
--         SUM(money) sm 
--       FROM
--         pm_recharge 
--       WHERE TYPE = 1 
--         AND STATUS = 2 
--         AND msg = '竞拍扣款' 
--         AND goods_id IN 
--         (SELECT 
--           id 
--         FROM
--           pm_goods_activity 
--        WHERE state = 1
--         ) 
--       GROUP BY openid,
--         goods_id) bb 
--       ON aa.openid = bb.openid 
--       AND aa.goods_activity_id = bb.goods_id) cc 
-- WHERE cc.bate >= 0.5  AND cc.bate<=1
-- ORDER BY bate DESC LIMIT 1000000) dd 
-- GROUP BY dd.openid ;
 
 commit;
 
  INSERT INTO pm_data_valid (datatime, value1) 
  VALUES
    (
      DATE_FORMAT(NOW(), '%Y-%m-%d %H:%i:%s'),
      '个性化奖罚new'
    ) ;
END
;;
DELIMITER ;

-- ----------------------------
-- Procedure structure for update_roi
-- ----------------------------
DROP PROCEDURE IF EXISTS `update_roi`;
DELIMITER ;;
CREATE DEFINER=`root`@`%` PROCEDURE `update_roi`()
BEGIN
UPDATE  pm_user set recharge_amount=0,income=0,roi=0;

UPDATE pm_user as u INNER JOIN 
(SELECT openid,sum(cost) as cost FROM pm_recharge WHERE type=0 AND `status`=2 AND order_id<=0 AND create_t>UNIX_TIMESTAMP()-86400*60 GROUP BY openid ) as r
on u.openid=r.openid
set u.recharge_amount=cost;

UPDATE pm_user as u INNER JOIN
(SELECT openid,sum(amount) amount,count(*) as c FROM (
 
SELECT openid,sum(pur_price) as amount  FROM pm_goods_activity WHERE state in(2,3,4,5) AND user_type=1  AND create_t>UNIX_TIMESTAMP()-86400*60 GROUP BY openid
UNION ALL
SELECT openid,sum(prize_price) as amount from pm_prize_draw_log WHERE prize_state=1  AND create_t>UNIX_TIMESTAMP()-86400*60  GROUP BY openid

) as a GROUP BY openid ) as p
on u.openid=p.openid
SET u.income=p.amount;#,u.self_income=p.amount;


UPDATE pm_user as u INNER JOIN
(SELECT sum(recharge_amount) as a,sum(income) as i,unique_id,id,sum(income) /(CASE WHEN sum(recharge_amount) <=0 THEN 1 ELSE sum(recharge_amount) END ) as roi FROM pm_user GROUP BY unique_id) as r
on u.unique_id=r.unique_id
SET u.recharge_amount=r.a, u.income=r.i, u.roi=r.roi;



UPDATE pm_user SET roi=3.3 WHERE openid in(
SELECT openid FROM (
SELECT openid FROM pm_user WHERE roi>=1 AND income>100) as ccc
);

UPDATE pm_user SET roi=1.66 WHERE openid in(
SELECT openid FROM (
SELECT openid FROM pm_user WHERE roi>=0.7 AND roi<1 AND income>100) as ccc
);


UPDATE pm_user SET roi=0.666 WHERE openid in(
SELECT openid FROM (
SELECT openid FROM pm_user WHERE roi>=0.7 AND income<=100) as ccc
);


UPDATE pm_user as u
INNER JOIN 
(SELECT unique_id,count(*) as c FROM `pm_user` GROUP BY unique_id HAVING c>1  ) as b
on u.unique_id=b.unique_id
SET estimate_account_num=c;

UPDATE pm_user set roi=3.33 WHERE unique_id=69833;
UPDATE pm_user set status_flag = 0 WHERE memberno in(
9852517310,
5297972300,
9953553934,
9954545453);

END
;;
DELIMITER ;

-- ----------------------------
-- Event structure for create_log_table
-- ----------------------------
DROP EVENT IF EXISTS `create_log_table`;
DELIMITER ;;
CREATE DEFINER=`root`@`%` EVENT `create_log_table` ON SCHEDULE EVERY 1 MONTH STARTS '2019-02-01 00:00:00' ON COMPLETION NOT PRESERVE ENABLE DO CALL p_create_log_table()
;;
DELIMITER ;

-- ----------------------------
-- Event structure for e_hmd
-- ----------------------------
DROP EVENT IF EXISTS `e_hmd`;
DELIMITER ;;
CREATE DEFINER=`root`@`%` EVENT `e_hmd` ON SCHEDULE EVERY 1440000 SECOND STARTS '2018-12-14 00:00:00' ON COMPLETION PRESERVE ENABLE DO CALL p_hmd()
;;
DELIMITER ;

-- ----------------------------
-- Event structure for e_user_roi_tag
-- ----------------------------
DROP EVENT IF EXISTS `e_user_roi_tag`;
DELIMITER ;;
CREATE DEFINER=`pm_user2`@`211.151.211.248` EVENT `e_user_roi_tag` ON SCHEDULE EVERY 86400 SECOND STARTS '2018-11-29 18:30:00' ON COMPLETION PRESERVE ENABLE DO call p_user_roi_tag()
;;
DELIMITER ;

-- ----------------------------
-- Event structure for e_user_roi_tag_new
-- ----------------------------
DROP EVENT IF EXISTS `e_user_roi_tag_new`;
DELIMITER ;;
CREATE DEFINER=`root`@`%` EVENT `e_user_roi_tag_new` ON SCHEDULE EVERY 14400 SECOND STARTS '2018-12-17 12:30:00' ON COMPLETION PRESERVE ENABLE DO CALL p_user_roi_tag_new()
;;
DELIMITER ;

-- ----------------------------
-- Event structure for insertdaydata
-- ----------------------------
DROP EVENT IF EXISTS `insertdaydata`;
DELIMITER ;;
CREATE DEFINER=`pm_user2`@`211.151.211.248` EVENT `insertdaydata` ON SCHEDULE EVERY 1 DAY STARTS '2018-12-15 04:00:00' ON COMPLETION PRESERVE ENABLE DO CALL p_dailydata()
;;
DELIMITER ;

-- ----------------------------
-- Event structure for update_ch_data
-- ----------------------------
DROP EVENT IF EXISTS `update_ch_data`;
DELIMITER ;;
CREATE DEFINER=`root`@`%` EVENT `update_ch_data` ON SCHEDULE EVERY 1 DAY STARTS '2019-04-09 04:00:00' ON COMPLETION NOT PRESERVE ENABLE DO INSERT INTO pm_ch_data_new
SELECT null,a.ch,new_user,reg_user,reg_user/new_user as new_reg_rate,login_count,user_count,user_money,user_money/user_count as urppu,user_money/login_count as urpu,a.date as create_t FROM (
SELECT count(*) as new_user,ch,FROM_UNIXTIME(ct/1000,'%Y-%m-%d') as date FROM zy_basic WHERE ct>=UNIX_TIMESTAMP('2019-3-31')*1000 GROUP BY ch,date ORDER BY date DESC) a 

INNER JOIN(



SELECT count(*) as reg_user,u.ch,FROM_UNIXTIME(u.create_t,'%Y-%m-%d') as date FROM  pm_user as u WHERE u.create_t>=UNIX_TIMESTAMP('2019-3-31') GROUP BY ch,date ORDER BY date DESC
) b on a.ch=b.ch AND a.date=b.date

INNER JOIN(


SELECT count(*) as login_count,u.ch,FROM_UNIXTIME(u.login_time,'%Y-%m-%d') as date FROM  pm_user  as ul
INNER JOIN pm_user as u on ul.openid=u.openid
WHERE 
  u.create_t>=UNIX_TIMESTAMP('2019-3-31') GROUP BY ch,date ORDER BY date DESC

) c on a.ch=c.ch AND a.date=c.date

INNER JOIN(

SELECT sum(cost) as user_money,u.ch,FROM_UNIXTIME(u.create_t,'%Y-%m-%d') as date FROM  pm_user as u
INNER JOIN pm_recharge as r on u.openid=r.openid
WHERE u.create_t>=UNIX_TIMESTAMP('2019-3-31') AND type=0 AND status=2 GROUP BY ch,date ORDER BY date DESC
) d on a.ch=d.ch AND a.date=d.date



INNER JOIN(


SELECT count(*) as user_count,ch as ch_e,date as date_e FROM (
	SELECT u.openid,count(*),u.ch,FROM_UNIXTIME(u.create_t,'%Y-%m-%d') as date FROM  pm_recharge as r 
	INNER JOIN pm_user as u on r.openid=u.openid
	WHERE type=0 AND status=2 AND u.create_t>=UNIX_TIMESTAMP('2019-3-31') GROUP BY ch,date,openid 
) as t
GROUP BY ch,date
ORDER BY date DESC 
) e on a.ch=e.ch_e AND a.date=e.date_e
;
;;
DELIMITER ;

-- ----------------------------
-- Event structure for update_roi
-- ----------------------------
DROP EVENT IF EXISTS `update_roi`;
DELIMITER ;;
CREATE DEFINER=`root`@`%` EVENT `update_roi` ON SCHEDULE EVERY 1 DAY STARTS '2019-01-24 03:00:00' ON COMPLETION NOT PRESERVE ENABLE DO CALL update_roi()
;;
DELIMITER ;
