/*
Navicat MySQL Data Transfer

Source Server         : 本地
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : gaoluokeji

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2019-06-05 20:14:18
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `admin`
-- ----------------------------
DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(12) NOT NULL,
  `password` varchar(35) NOT NULL,
  `gid` int(11) NOT NULL DEFAULT '1',
  `addtime` int(11) NOT NULL,
  `lastlogin` int(11) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `url` varchar(100) DEFAULT NULL COMMENT '1 财务 2审核员 3业务员',
  `name` varchar(50) DEFAULT NULL,
  `qq` int(13) DEFAULT '1',
  `logourl` varchar(100) DEFAULT NULL,
  `phone` varchar(11) DEFAULT NULL,
  `leiji_chongzhi` float(11,2) DEFAULT '0.00' COMMENT '累计充值',
  `qianbao` float(11,2) DEFAULT '0.00' COMMENT '当前余额',
  `user_id` varchar(50) NOT NULL COMMENT '属于商家',
  `shenqLv` int(11) DEFAULT NULL COMMENT '申请率（实名数量）',
  `fangkuanLv` int(11) DEFAULT NULL COMMENT '放款率',
  `auth` varchar(255) DEFAULT NULL COMMENT '权限',
  `loanRenci` int(11) DEFAULT '1' COMMENT '借款人次',
  `chenggongrenci` int(11) DEFAULT '1' COMMENT '申请成功人次',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of admin
-- ----------------------------
INSERT INTO `admin` VALUES ('3', 'admin', 'edeccff4668c9c81cb144dbc5c86ace2', '1', '1481807439', '1559699763', '1', null, '111', '0', null, '18628337024', '100101.00', '99949.00', '1', '0', '0', '1', '1', '1');
INSERT INTO `admin` VALUES ('9', 'xiaogao', 'edeccff4668c9c81cb144dbc5c86ace2', '0', '1556896443', '1557411932', '1', null, '小宝钱包', '50', null, '18628337737', '0.00', '0.00', '2', '10', '5', '1', '1', '1');
INSERT INTO `admin` VALUES ('10', 'MGHFmH', 'edeccff4668c9c81cb144dbc5c86ace2', '0', '1558443202', '0', '1', 'http://zhixinyun.ganzizc.com/admin', '协议1地址', '90', 'http://127.0.0.78/Upload/image/20190527/20190527212401_55351.png', '18628337024', '0.00', '0.00', '', '80', '50', '{\"date_time\":\"1\",\"qudaoname\":\"1\",\"zhucecount\":\"1\",\"uvcount\":\"1\",\"shimingcount\":\"1\",\"loancount\":\"1\",\"succcount\":\"1\",\"loanlv\":\"1\",\"tongguolv\":\"\",\"caozuo\":\"\"}', '50', '50');

-- ----------------------------
-- Table structure for `admin_login`
-- ----------------------------
DROP TABLE IF EXISTS `admin_login`;
CREATE TABLE `admin_login` (
  `id` int(11) NOT NULL,
  `username` varchar(16) NOT NULL,
  `logintime` int(11) NOT NULL DEFAULT '0',
  `loginip` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of admin_login
-- ----------------------------
INSERT INTO `admin_login` VALUES ('0', 'admin', '1549869100', '127.0.0.1');
INSERT INTO `admin_login` VALUES ('0', 'test', '1549869144', '127.0.0.1');
INSERT INTO `admin_login` VALUES ('0', 'test', '1549885969', '127.0.0.1');
INSERT INTO `admin_login` VALUES ('0', 'test', '1549886079', '127.0.0.1');
INSERT INTO `admin_login` VALUES ('0', 'test', '1549886142', '127.0.0.1');
INSERT INTO `admin_login` VALUES ('0', 'test', '1549886289', '127.0.0.1');
INSERT INTO `admin_login` VALUES ('0', 'admin', '1549886793', '127.0.0.1');
INSERT INTO `admin_login` VALUES ('0', 'test', '1549891372', '127.0.0.1');
INSERT INTO `admin_login` VALUES ('0', 'test', '1549891400', '127.0.0.1');
INSERT INTO `admin_login` VALUES ('0', 'test', '1549891435', '127.0.0.1');
INSERT INTO `admin_login` VALUES ('0', 'test', '1549897984', '127.0.0.1');
INSERT INTO `admin_login` VALUES ('0', 'test', '1549898032', '127.0.0.1');
INSERT INTO `admin_login` VALUES ('0', 'admin', '1549898099', '127.0.0.1');
INSERT INTO `admin_login` VALUES ('0', 'test', '1549898228', '127.0.0.1');
INSERT INTO `admin_login` VALUES ('0', 'admin', '1549976514', '127.0.0.1');
INSERT INTO `admin_login` VALUES ('0', 'admin', '1549976527', '127.0.0.1');
INSERT INTO `admin_login` VALUES ('0', 'test', '1549977004', '127.0.0.1');
INSERT INTO `admin_login` VALUES ('0', 'admin', '1549977200', '127.0.0.1');
INSERT INTO `admin_login` VALUES ('0', 'admin', '1549977665', '127.0.0.1');
INSERT INTO `admin_login` VALUES ('0', 'test', '1549977912', '127.0.0.1');
INSERT INTO `admin_login` VALUES ('0', 'test', '1549982881', '127.0.0.1');
INSERT INTO `admin_login` VALUES ('0', 'admin', '1550066493', '127.0.0.1');
INSERT INTO `admin_login` VALUES ('0', 'admin', '1550123832', '127.0.0.1');
INSERT INTO `admin_login` VALUES ('0', 'admin', '1550235274', '127.0.0.1');
INSERT INTO `admin_login` VALUES ('0', 'admin', '1550285273', '127.0.0.1');
INSERT INTO `admin_login` VALUES ('0', 'admin', '1550370553', '127.0.0.1');
INSERT INTO `admin_login` VALUES ('0', 'admin', '1550577316', '127.0.0.1');
INSERT INTO `admin_login` VALUES ('0', 'admin', '1550578029', '127.0.0.1');
INSERT INTO `admin_login` VALUES ('0', 'admin', '1550578142', '127.0.0.1');
INSERT INTO `admin_login` VALUES ('0', 'admin', '1550578217', '127.0.0.1');
INSERT INTO `admin_login` VALUES ('0', 'admin', '1550578429', '127.0.0.1');
INSERT INTO `admin_login` VALUES ('0', 'admin', '1550578732', '127.0.0.1');
INSERT INTO `admin_login` VALUES ('0', 'admin', '1550578769', '127.0.0.1');
INSERT INTO `admin_login` VALUES ('0', 'admin', '1550633085', '127.0.0.1');
INSERT INTO `admin_login` VALUES ('0', 'admin', '1550762457', '127.0.0.1');
INSERT INTO `admin_login` VALUES ('0', 'admin', '1550816634', '127.0.0.1');
INSERT INTO `admin_login` VALUES ('0', 'admin', '1550816649', '127.0.0.1');
INSERT INTO `admin_login` VALUES ('0', 'admin', '1551537554', '127.0.0.1');
INSERT INTO `admin_login` VALUES ('0', 'admin', '1551538168', '127.0.0.1');
INSERT INTO `admin_login` VALUES ('0', 'admin', '1552181926', '127.0.0.1');
INSERT INTO `admin_login` VALUES ('0', 'admin', '1552181978', '127.0.0.1');
INSERT INTO `admin_login` VALUES ('0', 'admin', '1552182105', '127.0.0.1');
INSERT INTO `admin_login` VALUES ('0', 'admin', '1552184837', '127.0.0.1');
INSERT INTO `admin_login` VALUES ('0', 'xiaogao', '1552184853', '127.0.0.1');
INSERT INTO `admin_login` VALUES ('0', 'admin', '1555765823', '127.0.0.1');
INSERT INTO `admin_login` VALUES ('0', 'admin', '1555766058', '127.0.0.1');
INSERT INTO `admin_login` VALUES ('0', 'admin', '1555821796', '127.0.0.1');
INSERT INTO `admin_login` VALUES ('0', 'admin', '1555821875', '127.0.0.1');
INSERT INTO `admin_login` VALUES ('0', 'admin', '1556884780', '127.0.0.1');
INSERT INTO `admin_login` VALUES ('0', 'admin', '1556885702', '127.0.0.1');
INSERT INTO `admin_login` VALUES ('0', 'admin', '1556885796', '127.0.0.1');
INSERT INTO `admin_login` VALUES ('0', 'xiaogao', '1556891782', '127.0.0.1');
INSERT INTO `admin_login` VALUES ('0', 'xiaogao', '1556897944', '127.0.0.1');
INSERT INTO `admin_login` VALUES ('0', 'admin', '1556938810', '127.0.0.1');
INSERT INTO `admin_login` VALUES ('0', 'admin', '1557139185', '127.0.0.1');
INSERT INTO `admin_login` VALUES ('0', 'admin', '1557149945', '127.0.0.1');
INSERT INTO `admin_login` VALUES ('0', 'admin', '1557160721', '127.0.0.1');
INSERT INTO `admin_login` VALUES ('0', 'xiaogao', '1557160835', '127.0.0.1');
INSERT INTO `admin_login` VALUES ('0', 'admin', '1557194044', '127.0.0.1');
INSERT INTO `admin_login` VALUES ('0', 'admin', '1557224577', '127.0.0.1');
INSERT INTO `admin_login` VALUES ('0', 'xiaogao', '1557224869', '127.0.0.1');
INSERT INTO `admin_login` VALUES ('0', 'admin', '1557242105', '127.0.0.1');
INSERT INTO `admin_login` VALUES ('0', 'admin', '1557242265', '127.0.0.1');
INSERT INTO `admin_login` VALUES ('0', 'admin', '1557242931', '127.0.0.1');
INSERT INTO `admin_login` VALUES ('0', 'admin', '1557243798', '127.0.0.1');
INSERT INTO `admin_login` VALUES ('0', 'xiaogao', '1557410161', '127.0.0.1');
INSERT INTO `admin_login` VALUES ('0', 'xiaogao', '1557410349', '127.0.0.1');
INSERT INTO `admin_login` VALUES ('0', 'xiaogao', '1557410531', '127.0.0.1');
INSERT INTO `admin_login` VALUES ('0', 'admin', '1557411281', '127.0.0.1');
INSERT INTO `admin_login` VALUES ('0', 'admin', '1557411857', '127.0.0.1');
INSERT INTO `admin_login` VALUES ('0', 'admin', '1557411903', '127.0.0.1');
INSERT INTO `admin_login` VALUES ('0', 'xiaogao', '1557411932', '127.0.0.1');
INSERT INTO `admin_login` VALUES ('0', 'admin', '1557713673', '127.0.0.1');
INSERT INTO `admin_login` VALUES ('0', 'admin', '1557929956', '127.0.0.1');
INSERT INTO `admin_login` VALUES ('0', 'admin', '1557929972', '127.0.0.1');
INSERT INTO `admin_login` VALUES ('0', 'admin', '1558408018', '127.0.0.1');
INSERT INTO `admin_login` VALUES ('0', 'admin', '1558434476', '127.0.0.1');
INSERT INTO `admin_login` VALUES ('0', 'xiaogao', '1558435038', '127.0.0.1');
INSERT INTO `admin_login` VALUES ('0', 'admin', '1558435638', '127.0.0.1');
INSERT INTO `admin_login` VALUES ('0', 'admin', '1558435712', '127.0.0.1');
INSERT INTO `admin_login` VALUES ('0', 'admin', '1558435746', '127.0.0.1');
INSERT INTO `admin_login` VALUES ('0', 'admin', '1558435890', '127.0.0.1');
INSERT INTO `admin_login` VALUES ('0', 'xiaogao', '1558435899', '127.0.0.1');
INSERT INTO `admin_login` VALUES ('0', 'admin', '1558436120', '127.0.0.1');
INSERT INTO `admin_login` VALUES ('0', 'admin', '1558436123', '127.0.0.1');
INSERT INTO `admin_login` VALUES ('0', 'xiaogao', '1558436262', '127.0.0.1');
INSERT INTO `admin_login` VALUES ('0', 'admin', '1558440898', '127.0.0.1');
INSERT INTO `admin_login` VALUES ('0', 'MGHFmH', '1558446420', '127.0.0.1');
INSERT INTO `admin_login` VALUES ('0', 'admin', '1558446746', '127.0.0.1');
INSERT INTO `admin_login` VALUES ('0', 'admin', '1558447133', '127.0.0.1');
INSERT INTO `admin_login` VALUES ('0', 'MGHFmH', '1558447225', '127.0.0.1');
INSERT INTO `admin_login` VALUES ('0', 'MGHFmH', '1558449102', '127.0.0.1');
INSERT INTO `admin_login` VALUES ('0', 'MGHFmH', '1558449441', '127.0.0.1');
INSERT INTO `admin_login` VALUES ('0', 'MGHFmH', '1558449837', '127.0.0.1');
INSERT INTO `admin_login` VALUES ('0', 'xiaogao', '1558452271', '127.0.0.1');
INSERT INTO `admin_login` VALUES ('0', 'admin', '1558497813', '127.0.0.1');
INSERT INTO `admin_login` VALUES ('0', 'admin', '1558497890', '127.0.0.1');
INSERT INTO `admin_login` VALUES ('0', 'xiaogao', '1558497901', '127.0.0.1');
INSERT INTO `admin_login` VALUES ('0', 'admin', '1558498705', '127.0.0.1');
INSERT INTO `admin_login` VALUES ('0', 'xiaogao', '1558501368', '127.0.0.1');
INSERT INTO `admin_login` VALUES ('0', 'MGHFmH', '1558501562', '127.0.0.1');
INSERT INTO `admin_login` VALUES ('0', 'MGHFmH', '1558501707', '127.0.0.1');
INSERT INTO `admin_login` VALUES ('0', 'MGHFmH', '1558501756', '127.0.0.1');
INSERT INTO `admin_login` VALUES ('0', 'MGHFmH', '1558503739', '127.0.0.1');
INSERT INTO `admin_login` VALUES ('0', 'admin', '1558504270', '127.0.0.1');
INSERT INTO `admin_login` VALUES ('0', 'admin', '1558532245', '127.0.0.1');
INSERT INTO `admin_login` VALUES ('0', 'admin', '1558532577', '127.0.0.1');
INSERT INTO `admin_login` VALUES ('0', 'admin', '1558532784', '127.0.0.1');
INSERT INTO `admin_login` VALUES ('0', 'admin', '1558533456', '127.0.0.1');
INSERT INTO `admin_login` VALUES ('0', 'admin', '1558533814', '127.0.0.1');
INSERT INTO `admin_login` VALUES ('0', 'admin', '1558533993', '127.0.0.1');
INSERT INTO `admin_login` VALUES ('0', 'admin', '1558534029', '127.0.0.1');
INSERT INTO `admin_login` VALUES ('0', 'admin', '1558534202', '127.0.0.1');
INSERT INTO `admin_login` VALUES ('0', 'admin', '1558535752', '127.0.0.1');
INSERT INTO `admin_login` VALUES ('0', 'admin', '1558541654', '127.0.0.1');
INSERT INTO `admin_login` VALUES ('0', 'MGHFmH', '1558541672', '127.0.0.1');
INSERT INTO `admin_login` VALUES ('0', 'admin', '1558709930', '127.0.0.1');
INSERT INTO `admin_login` VALUES ('0', 'admin', '1558950875', '127.0.0.1');
INSERT INTO `admin_login` VALUES ('0', 'admin', '1558950971', '127.0.0.1');
INSERT INTO `admin_login` VALUES ('0', 'admin', '1558951016', '127.0.0.1');
INSERT INTO `admin_login` VALUES ('0', 'MGHFmH', '1558953945', '127.0.0.1');
INSERT INTO `admin_login` VALUES ('0', 'MGHFmH', '1558963180', '127.0.0.1');
INSERT INTO `admin_login` VALUES ('0', 'MGHFmH', '1558963648', '127.0.0.1');
INSERT INTO `admin_login` VALUES ('0', 'admin', '1559205233', '127.0.0.1');
INSERT INTO `admin_login` VALUES ('0', 'MGHFmH', '1559205257', '127.0.0.1');
INSERT INTO `admin_login` VALUES ('0', 'admin', '1559699763', '127.0.0.1');

-- ----------------------------
-- Table structure for `del`
-- ----------------------------
DROP TABLE IF EXISTS `del`;
CREATE TABLE `del` (
  `id` int(11) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `password` varchar(40) NOT NULL,
  `addtime` int(11) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '1',
  `yao_phone` varchar(255) NOT NULL,
  `jisuan_ticheng` int(10) NOT NULL,
  `ticheng_sum` int(25) NOT NULL,
  `ketixian` int(22) NOT NULL,
  `shenqing_tixian` int(22) NOT NULL,
  `leiji_tixian` int(22) NOT NULL,
  `truename` varchar(222) NOT NULL,
  `moban` varchar(200) DEFAULT NULL,
  `use_name` varchar(200) DEFAULT NULL,
  `yaocode` varchar(50) DEFAULT NULL,
  `card` varchar(100) DEFAULT NULL,
  `data_from` varchar(100) DEFAULT NULL COMMENT '渠道'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of del
-- ----------------------------
INSERT INTO `del` VALUES ('2', '', '', '1549886896', '1', '127.0.0.1', '0', '0', '0', '0', '0', '', '为君解忧', null, null, null, 'test');

-- ----------------------------
-- Table structure for `d_iou`
-- ----------------------------
DROP TABLE IF EXISTS `d_iou`;
CREATE TABLE `d_iou` (
  `id` varchar(64) NOT NULL,
  `sort_num` bigint(20) NOT NULL AUTO_INCREMENT,
  `create_date` datetime DEFAULT NULL,
  `data_from` char(20) DEFAULT NULL,
  `iou_ip` char(15) DEFAULT NULL,
  `mobileType` varchar(20) DEFAULT NULL COMMENT '手机类型',
  `name` varchar(20) DEFAULT NULL,
  `age` int(3) DEFAULT NULL,
  `userID` varchar(20) DEFAULT NULL COMMENT '身份证号码',
  `email` varchar(30) DEFAULT NULL,
  `phone_number` char(15) DEFAULT NULL,
  `card` varchar(18) DEFAULT NULL,
  `zhimafen` int(3) DEFAULT NULL,
  `area` varchar(20) DEFAULT NULL COMMENT '地区',
  `wechat` varchar(20) DEFAULT NULL,
  `tongdun` varchar(100) DEFAULT NULL,
  `yysrz` int(11) NOT NULL DEFAULT '0' COMMENT '被领取次数',
  `cardphoto_1` varchar(100) DEFAULT NULL,
  `otherimg` varchar(100) DEFAULT NULL,
  `otherexcel` varchar(100) DEFAULT NULL,
  `cardphoto_3` varchar(100) DEFAULT NULL COMMENT '学历',
  `process_content` varchar(500) DEFAULT NULL,
  `process_date` datetime DEFAULT NULL,
  `process_states` char(64) DEFAULT NULL,
  `process_user` char(64) DEFAULT NULL,
  `process_user_name` varchar(100) DEFAULT NULL,
  `cardphoto_2` varchar(100) DEFAULT NULL,
  `name_1` varchar(10) DEFAULT NULL,
  `guanxi_1` varchar(10) DEFAULT NULL,
  `phone_1` varchar(13) DEFAULT NULL,
  `name_2` varchar(10) DEFAULT NULL,
  `guanxi_2` varchar(10) DEFAULT NULL,
  `phone_2` varchar(13) DEFAULT NULL,
  PRIMARY KEY (`sort_num`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of d_iou
-- ----------------------------

-- ----------------------------
-- Table structure for `d_qudaocount`
-- ----------------------------
DROP TABLE IF EXISTS `d_qudaocount`;
CREATE TABLE `d_qudaocount` (
  `id` int(64) NOT NULL AUTO_INCREMENT,
  `addtime` varchar(11) DEFAULT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `qudao` varchar(255) DEFAULT NULL,
  `recored_date` datetime DEFAULT NULL,
  `regs` int(11) DEFAULT NULL,
  `views` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of d_qudaocount
-- ----------------------------
INSERT INTO `d_qudaocount` VALUES ('1', '1557146114', '127.0.0.1', 'xiaogao', null, null, null);

-- ----------------------------
-- Table structure for `member`
-- ----------------------------
DROP TABLE IF EXISTS `member`;
CREATE TABLE `member` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(12) NOT NULL,
  `password` varchar(35) NOT NULL,
  `gid` int(11) NOT NULL DEFAULT '1',
  `addtime` int(11) NOT NULL,
  `lastlogin` int(11) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `url` varchar(100) DEFAULT NULL COMMENT '1 财务 2审核员 3业务员',
  `name` varchar(50) DEFAULT NULL,
  `qq` int(13) DEFAULT '1',
  `logourl` varchar(100) DEFAULT NULL,
  `phone` varchar(11) DEFAULT NULL,
  `leiji_chongzhi` float(11,2) DEFAULT '0.00' COMMENT '累计充值',
  `qianbao` float(11,2) DEFAULT '0.00' COMMENT '当前余额',
  `user_id` varchar(50) NOT NULL COMMENT '属于商家',
  `shenqLv` int(11) DEFAULT NULL COMMENT '申请率（实名数量）',
  `fangkuanLv` int(11) DEFAULT NULL COMMENT '放款率',
  `auth` varchar(255) DEFAULT NULL COMMENT '权限',
  `loanRenci` int(11) DEFAULT '1' COMMENT '借款人次',
  `chenggongrenci` int(11) DEFAULT '1' COMMENT '申请成功人次',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of member
-- ----------------------------

-- ----------------------------
-- Table structure for `order`
-- ----------------------------
DROP TABLE IF EXISTS `order`;
CREATE TABLE `order` (
  `id` int(11) NOT NULL,
  `user` varchar(255) NOT NULL,
  `money` float NOT NULL DEFAULT '0',
  `months` int(11) NOT NULL DEFAULT '0',
  `monthmoney` float NOT NULL,
  `donemonth` int(11) NOT NULL DEFAULT '0',
  `addtime` int(11) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '0' COMMENT '0未支付 1 已支付待审核 2 借款成功 -1申请失败 3已还款',
  `pid` int(11) NOT NULL,
  `ordernum` varchar(255) NOT NULL,
  `bank` varchar(255) NOT NULL,
  `banknum` varchar(255) NOT NULL,
  `name` varchar(233) NOT NULL,
  `lixi` float DEFAULT NULL,
  `hk_date` int(11) DEFAULT NULL,
  `shouxufei` float DEFAULT NULL,
  `shenhefei` float DEFAULT NULL,
  `log` varchar(200) DEFAULT NULL,
  `next_time` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of order
-- ----------------------------

-- ----------------------------
-- Table structure for `otherinfo`
-- ----------------------------
DROP TABLE IF EXISTS `otherinfo`;
CREATE TABLE `otherinfo` (
  `id` int(11) NOT NULL,
  `user` varchar(255) NOT NULL,
  `infojson` varchar(255) NOT NULL,
  `addtime` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of otherinfo
-- ----------------------------
INSERT INTO `otherinfo` VALUES ('7', '18628337024', '[]', '1505572092');

-- ----------------------------
-- Table structure for `payorder`
-- ----------------------------
DROP TABLE IF EXISTS `payorder`;
CREATE TABLE `payorder` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ordernum` varchar(255) NOT NULL,
  `user` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `money` float NOT NULL,
  `addtime` int(11) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '0',
  `datares` longtext,
  `name` varchar(222) NOT NULL,
  `shouxufei` float DEFAULT NULL,
  `shenhefei` float DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of payorder
-- ----------------------------

-- ----------------------------
-- Table structure for `smscode`
-- ----------------------------
DROP TABLE IF EXISTS `smscode`;
CREATE TABLE `smscode` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `phone` varchar(255) NOT NULL,
  `code` varchar(12) NOT NULL,
  `sendtime` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1812 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of smscode
-- ----------------------------
INSERT INTO `smscode` VALUES ('1803', '18628337024', '1636', '1526996198');
INSERT INTO `smscode` VALUES ('1804', '18482105917', '3356', '1526997588');
INSERT INTO `smscode` VALUES ('1805', '18628337737', '103708', '1542548570');
INSERT INTO `smscode` VALUES ('1806', '15112229097', '046697', '1542550778');
INSERT INTO `smscode` VALUES ('1807', '18628337021', '477189', '1542636301');
INSERT INTO `smscode` VALUES ('1808', '18524644779', '117882', '1543293879');
INSERT INTO `smscode` VALUES ('1809', '15357840807', '006171', '1544161331');
INSERT INTO `smscode` VALUES ('1810', '13986771035', '066725', '1544161487');
INSERT INTO `smscode` VALUES ('1811', '15170097261', '200211', '1545120548');

-- ----------------------------
-- Table structure for `user`
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `phone` varchar(11) NOT NULL,
  `password` varchar(40) NOT NULL,
  `addtime` int(11) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '1',
  `yao_phone` varchar(255) NOT NULL,
  `jisuan_ticheng` int(10) NOT NULL,
  `ticheng_sum` int(25) NOT NULL,
  `ketixian` int(22) NOT NULL,
  `shenqing_tixian` int(22) NOT NULL,
  `leiji_tixian` int(22) NOT NULL,
  `truename` varchar(222) NOT NULL,
  `moban` varchar(200) DEFAULT NULL,
  `use_name` varchar(200) DEFAULT NULL,
  `yaocode` varchar(50) DEFAULT NULL,
  `card` varchar(100) DEFAULT NULL,
  `data_from` varchar(100) DEFAULT NULL COMMENT '渠道',
  `flag` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('6', '18628337024', '', '1557146366', '1', '127.0.0.1', '0', '0', '0', '0', '0', '', '下钱雨', null, null, null, null, '0');
INSERT INTO `user` VALUES ('7', '18628337737', '', '1557146509', '1', '127.0.0.1', '0', '0', '0', '0', '0', '', '下钱雨', null, null, null, null, '0');
INSERT INTO `user` VALUES ('8', '18628337790', '', '1558446031', '1', '127.0.0.1', '0', '0', '0', '0', '0', '', '下钱雨', null, null, null, null, '0');
INSERT INTO `user` VALUES ('9', '18628337789', '', '1558446031', '1', '127.0.0.1', '0', '0', '0', '0', '0', '', '下钱雨', null, null, null, 'MGHFmH', '0');
INSERT INTO `user` VALUES ('10', '18628337781', '', '1558446031', '1', '127.0.0.1', '0', '0', '0', '0', '0', '', '下钱雨', null, null, null, 'MGHFmH', '1');
INSERT INTO `user` VALUES ('11', '18628337782', '', '1558446031', '1', '127.0.0.1', '0', '0', '0', '0', '0', '', '下钱雨', null, null, null, 'MGHFmH', '0');
INSERT INTO `user` VALUES ('12', '18628337730', '', '1558446031', '1', '127.0.0.1', '0', '0', '0', '0', '0', '', '为君解忧', null, null, null, 'MGHFmH', '0');
INSERT INTO `user` VALUES ('13', '18628337023', '', '1558446031', '1', '127.0.0.1', '0', '0', '0', '0', '0', '', '下钱雨', null, null, null, 'MGHFmH', '0');
INSERT INTO `user` VALUES ('14', '', '', '1558445904', '1', '127.0.0.1', '0', '0', '0', '0', '0', '', null, null, null, null, 'MGHFmH', '0');
INSERT INTO `user` VALUES ('15', '', '', '1558445974', '1', '127.0.0.1', '0', '0', '0', '0', '0', '', null, null, null, null, 'MGHFmH', '0');
INSERT INTO `user` VALUES ('16', '', '', '1558446031', '1', '127.0.0.1', '0', '0', '0', '0', '0', '', null, null, null, null, 'MGHFmH', '1');
INSERT INTO `user` VALUES ('17', '', '', '1558446041', '1', '127.0.0.1', '0', '0', '0', '0', '0', '', null, null, null, null, 'MGHFmH', '0');
INSERT INTO `user` VALUES ('18', '', '', '1558446246', '1', '127.0.0.1', '0', '0', '0', '0', '0', '', '协议1地址', null, null, null, 'MGHFmH', '0');

-- ----------------------------
-- Table structure for `userinfo`
-- ----------------------------
DROP TABLE IF EXISTS `userinfo`;
CREATE TABLE `userinfo` (
  `id` int(11) NOT NULL,
  `user` varchar(255) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `usercard` varchar(255) DEFAULT NULL,
  `cardphoto_1` varchar(255) DEFAULT NULL,
  `cardphoto_2` varchar(255) DEFAULT NULL,
  `cardphoto_3` varchar(255) DEFAULT NULL,
  `addess_ssq` varchar(255) DEFAULT NULL,
  `addess_more` varchar(255) DEFAULT NULL,
  `dwname` varchar(255) DEFAULT NULL,
  `dwaddess_ssq` varchar(255) DEFAULT NULL,
  `dwaddess_more` varchar(255) DEFAULT NULL,
  `position` varchar(255) DEFAULT NULL,
  `workyears` float DEFAULT NULL,
  `bankcard` varchar(255) DEFAULT NULL,
  `bankname` varchar(255) DEFAULT NULL,
  `alipay` int(100) DEFAULT '0',
  `wechat` int(1) DEFAULT '0',
  `dwphone` varchar(255) DEFAULT NULL,
  `dwysr` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `commpany_name` varchar(255) NOT NULL,
  `wechat_num` varchar(255) NOT NULL,
  `wechat_name` varchar(255) NOT NULL,
  `f_name` varchar(255) NOT NULL,
  `f_phone` varchar(255) NOT NULL,
  `m_name` varchar(255) NOT NULL,
  `m_phone` varchar(255) NOT NULL,
  `commpany_add` varchar(255) NOT NULL,
  `pengyou_phone` varchar(255) NOT NULL,
  `openid` varchar(222) DEFAULT NULL,
  `age` int(10) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `yueshouru` int(10) DEFAULT NULL,
  `qiye_name` varchar(100) DEFAULT NULL,
  `qiye_type` varchar(100) DEFAULT NULL,
  `zhiye` varchar(50) DEFAULT NULL,
  `hunyin` varchar(10) DEFAULT NULL,
  `xueli` varchar(50) DEFAULT NULL,
  `fangchan` varchar(50) DEFAULT NULL,
  `che` varchar(50) DEFAULT NULL,
  `shebao` varchar(50) DEFAULT NULL,
  `shebao_w` varchar(10) DEFAULT NULL,
  `shebao_num` varchar(10) DEFAULT NULL,
  `gongjijin` varchar(50) DEFAULT NULL,
  `gongjijin_num` varchar(10) DEFAULT NULL,
  `xinyongka` varchar(10) DEFAULT NULL,
  `xinyongka_edu` int(10) DEFAULT NULL,
  `jinji_fuqin_name` varchar(20) DEFAULT NULL,
  `jinji_fuqin_phone` varchar(20) DEFAULT NULL,
  `jinji_muqin_name` varchar(20) DEFAULT NULL,
  `jinji_muqin_phone` varchar(20) DEFAULT NULL,
  `other_name` varchar(20) DEFAULT NULL,
  `other_name_gx` varchar(20) DEFAULT NULL,
  `other_name_phone` varchar(20) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of userinfo
-- ----------------------------
INSERT INTO `userinfo` VALUES ('0', 'admin', null, null, null, null, null, null, null, null, null, null, null, null, null, null, '0', '0', null, null, null, '', '', '', '', '', '', '', '', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `userinfo` VALUES ('0', 'xiaogao', null, null, null, null, null, null, null, null, null, null, null, null, null, null, '0', '0', null, null, null, '', '', '', '', '', '', '', '', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `userinfo` VALUES ('0', 'MGHFmH', null, null, null, null, null, null, null, null, null, null, null, null, null, null, '0', '0', null, null, null, '', '', '', '', '', '', '', '', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);

-- ----------------------------
-- Table structure for `zhucelist`
-- ----------------------------
DROP TABLE IF EXISTS `zhucelist`;
CREATE TABLE `zhucelist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) DEFAULT NULL,
  `count` int(11) DEFAULT NULL,
  `todaytime` varchar(11) DEFAULT NULL,
  `qudaoname` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of zhucelist
-- ----------------------------
INSERT INTO `zhucelist` VALUES ('3', 'xiaogao', '12', '1556812800', null);
INSERT INTO `zhucelist` VALUES ('5', 'xiaogao', '12', '1556726400', null);
INSERT INTO `zhucelist` VALUES ('6', 'xiaogao', '34', '1556640000', null);
INSERT INTO `zhucelist` VALUES ('7', 'xiaogao', '56', '1556899200', '小宝钱包');
