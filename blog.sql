/*
Navicat MySQL Data Transfer

Source Server         : 本地
Source Server Version : 50612
Source Host           : localhost:3306
Source Database       : blog

Target Server Type    : MYSQL
Target Server Version : 50612
File Encoding         : 65001

Date: 2015-08-01 18:02:27
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `pre_article`
-- ----------------------------
DROP TABLE IF EXISTS `pre_article`;
CREATE TABLE `pre_article` (
  `aid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `typeid` smallint(6) unsigned NOT NULL DEFAULT '0',
  `subject` char(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `content` mediumtext CHARACTER SET utf8 NOT NULL,
  `authorid` int(10) unsigned NOT NULL DEFAULT '0',
  `author` char(15) CHARACTER SET utf8 NOT NULL,
  `like` int(10) unsigned NOT NULL DEFAULT '0',
  `views` int(10) unsigned NOT NULL DEFAULT '0',
  `comments` int(10) unsigned NOT NULL,
  `image` tinyint(8) unsigned NOT NULL DEFAULT '0',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `from` tinyint(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`aid`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of pre_article
-- ----------------------------
INSERT INTO `pre_article` VALUES ('2', '0', '恻恻恻恻恻恻', '[div][/div][div]\n[attach]25[/attach][/div][div]\n[/div][div]啊死擦死擦死擦死擦洒洒[div]\n[/div][quote]擦撒擦拭[/quote][h3]擦撒擦拭[/h3][div][b]撒擦拭擦拭从[/b][i]萨斯擦拭擦拭擦[/i][u]拭擦拭擦拭擦[/u]拭擦拭擦[/div][div]\n[/div][div][url=https://www.baidu.com/]链接[/url]&nbsp; &nbsp; csaas&nbsp;[/div][hr][div]\n[/div][div][/div][div]cash曾经撒茶水间[/div][div]\n[/div][div]\n[/div][div]啊擦死[/div]', '1', 'admin', '0', '0', '0', '25', '1436426840', '1', '1');
INSERT INTO `pre_article` VALUES ('3', '0', 'cececcececeeeeee', '[div][/div][div]\n[attach]25[/attach][/div][div]\n[/div][div]啊死擦死擦死擦死擦洒洒[div]\n[/div][quote]擦撒擦拭[/quote][h3]擦撒擦拭[/h3][div][b]撒擦拭擦拭从[/b][i]萨斯擦拭擦拭擦[/i][u]拭擦拭擦拭擦[/u]拭擦拭擦[/div][div]\n[/div][div][url=https://www.baidu.com/]链接[/url]&nbsp; &nbsp; csaas&nbsp;[/div][hr][div]\n[/div][div][/div][div]cash曾经撒茶水间[/div][div]\n[/div][div]\n[/div][div]啊擦死[/div]', '1', 'admin', '0', '0', '0', '0', '1436427142', '1', '1');
INSERT INTO `pre_article` VALUES ('6', '0', '测试测试', '[div]&lt;script&gt;alert(\'OK\')&lt;/script&gt;[/div][div]啊哈哈哈哈啊[/div]', '1', 'admin', '0', '0', '0', '0', '1436511170', '1', '1');
INSERT INTO `pre_article` VALUES ('7', '0', '测试测试', '[div]&lt;script&gt;alert(\'OK\')&lt;/script&gt;[/div][div]啊哈哈哈哈啊[/div]', '1', 'admin', '0', '0', '0', '0', '1436511180', '1', '1');
INSERT INTO `pre_article` VALUES ('8', '0', 'csascacascas', '&nbsp; &nbsp; &nbsp; &nbsp;&nbsp;测测试数据测试数据测试数据测试数据试数据。。。。。。。。。。。。。', '1', 'admin', '0', '0', '0', '0', '1436517058', '1', '1');
INSERT INTO `pre_article` VALUES ('9', '0', 'ascascasas', ' ascasacascas', '1', 'admin', '0', '0', '0', '0', '1436517275', '1', '1');
INSERT INTO `pre_article` VALUES ('10', '0', '测试测试测试测试测试测试测试测试测试测试测试', '[div]cececececeeeeeee[/div][div]\n[/div][div]记得记得记得记得你当年的\n[url=http://192.168.1.227/guide/attachments/answer/origin/201505/29/556836086aa4d.jpg][img=http://192.168.1.227/guide/attachments/answer/600/201505/29/556836086aa4d.jpg][/url]￼&nbsp;\n活动记得记得记得\n喜欢很多很多\n[/div]', '1', 'admin', '0', '0', '0', '0', '1436518343', '1', '1');
INSERT INTO `pre_article` VALUES ('11', '0', '擦拭擦拭擦拭', '记得记得记得记得你当年的\n[url=http://192.168.1.227/guide/attachments/answer/origin/201505/29/556836086aa4d.jpg][img=http://192.168.1.227/guide/attachments/answer/600/201505/29/556836086aa4d.jpg][/url]￼&nbsp;\n活动记得记得记得\n喜欢很多很多', '1', 'admin', '0', '0', '0', '0', '1436518620', '1', '1');
INSERT INTO `pre_article` VALUES ('12', '0', '测试发图测试', '[div]\n[attach]26[/attach][/div][div]\n[/div][div]擦撒撒擦拭从啊[/div][div]\n[/div][div]\n[attach]27[/attach][/div][div]a撒擦拭擦拭[/div][div]\n[/div][div]\n[attach]28[/attach][/div][div]擦拭擦拭擦拭[/div][div]啊死擦死啊[/div][div]\n[/div]', '1', 'admin', '0', '0', '0', '26', '1438414983', '1', '1');
INSERT INTO `pre_article` VALUES ('13', '0', '擦拭擦拭', '[div]啊擦死擦死发生[attach]29[/attach][/div][div]\n[/div][div]\n[/div][div]撒擦拭从[/div][div][attach]30[/attach][/div][div]擦拭长撒as[/div]', '1', 'admin', '0', '0', '0', '29', '1438415108', '1', '1');

-- ----------------------------
-- Table structure for `pre_comment`
-- ----------------------------
DROP TABLE IF EXISTS `pre_comment`;
CREATE TABLE `pre_comment` (
  `cid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rcid` int(10) unsigned NOT NULL DEFAULT '0',
  `ruid` int(10) unsigned NOT NULL DEFAULT '0',
  `username` char(15) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `aid` int(10) unsigned NOT NULL DEFAULT '0',
  `authorid` int(10) unsigned NOT NULL DEFAULT '0',
  `author` char(15) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `content` text CHARACTER SET utf8 NOT NULL,
  `dateline` int(10) NOT NULL,
  `like` int(10) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`cid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of pre_comment
-- ----------------------------

-- ----------------------------
-- Table structure for `pre_image`
-- ----------------------------
DROP TABLE IF EXISTS `pre_image`;
CREATE TABLE `pre_image` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `uid` mediumint(8) unsigned NOT NULL,
  `aid` mediumint(8) unsigned NOT NULL,
  `path` varchar(255) NOT NULL DEFAULT '',
  `type` varchar(20) NOT NULL DEFAULT '',
  `size` int(10) unsigned NOT NULL DEFAULT '0',
  `width` smallint(6) unsigned NOT NULL DEFAULT '0',
  `height` smallint(6) unsigned NOT NULL DEFAULT '0',
  `thumbH` smallint(6) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `dateline` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`),
  KEY `aid` (`aid`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pre_image
-- ----------------------------
INSERT INTO `pre_image` VALUES ('1', '1', '0', 'data/attachment/article/201506/29/161324mu94ec8u5p5eu60g.jpg', 'article', '93043', '1920', '1080', '338', '0', '1435565604');
INSERT INTO `pre_image` VALUES ('2', '1', '0', 'data/attachment/article/201507/04/161228ballgg2ignyfdgdg.jpg', 'article', '93043', '1920', '1080', '338', '0', '1435997548');
INSERT INTO `pre_image` VALUES ('3', '1', '0', 'data/attachment/article/201507/04/161228gldnr62zxf0ek0fc.jpg', 'article', '395934', '1600', '1000', '375', '0', '1435997548');
INSERT INTO `pre_image` VALUES ('4', '1', '0', 'data/attachment/article/201507/04/163605fysuqrqjs2v2cus3.jpg', 'article', '395934', '1600', '1000', '375', '0', '1435998965');
INSERT INTO `pre_image` VALUES ('5', '1', '0', 'data/attachment/article/201507/04/163753khpohxevjpzjsxvj.jpg', 'article', '395934', '1600', '1000', '375', '0', '1435999073');
INSERT INTO `pre_image` VALUES ('6', '1', '0', 'data/attachment/article/201507/04/164110zktvw5rvvzhv3v3k.jpg', 'article', '395934', '1600', '1000', '375', '0', '1435999270');
INSERT INTO `pre_image` VALUES ('7', '1', '0', 'data/attachment/article/201507/04/164138cfv3kpg0gritht1p.jpg', 'article', '395934', '1600', '1000', '375', '0', '1435999298');
INSERT INTO `pre_image` VALUES ('8', '1', '0', 'data/attachment/article/201507/04/164245zhxh1phxik6xap1h.jpg', 'article', '395934', '1600', '1000', '375', '0', '1435999365');
INSERT INTO `pre_image` VALUES ('9', '1', '0', 'data/attachment/article/201507/04/164647dmmn770pzlv7wn85.jpg', 'article', '395934', '1600', '1000', '375', '0', '1435999607');
INSERT INTO `pre_image` VALUES ('10', '1', '0', 'data/attachment/article/201507/04/164850btzo3ps31s3vkh0p.jpg', 'article', '395934', '1600', '1000', '375', '0', '1435999730');
INSERT INTO `pre_image` VALUES ('11', '1', '0', 'data/attachment/article/201507/04/165008ypiiddj329ed0jss.jpg', 'article', '395934', '1600', '1000', '375', '0', '1435999808');
INSERT INTO `pre_image` VALUES ('12', '1', '0', 'data/attachment/article/201507/04/170312yvubhgjhgvkpdbyy.jpg', 'article', '395934', '1600', '1000', '375', '0', '1436000592');
INSERT INTO `pre_image` VALUES ('13', '1', '0', 'data/attachment/article/201507/04/170349b89ll0o5qqd8q58o.jpg', 'article', '395934', '1600', '1000', '375', '0', '1436000629');
INSERT INTO `pre_image` VALUES ('14', '1', '0', 'data/attachment/article/201507/04/170704ne4izrro9k7o8fer.jpg', 'article', '395934', '1600', '1000', '375', '0', '1436000824');
INSERT INTO `pre_image` VALUES ('15', '1', '0', 'data/attachment/article/201507/04/170742wncyddjcdllco3nl.jpg', 'article', '395934', '1600', '1000', '375', '0', '1436000862');
INSERT INTO `pre_image` VALUES ('16', '1', '0', 'data/attachment/article/201507/04/170833z26p8siwuuipuubv.jpg', 'article', '395934', '1600', '1000', '375', '0', '1436000913');
INSERT INTO `pre_image` VALUES ('17', '1', '0', 'data/attachment/article/201507/04/171108koynmko19im23b31.jpg', 'article', '395934', '1600', '1000', '375', '0', '1436001068');
INSERT INTO `pre_image` VALUES ('18', '1', '0', 'data/attachment/article/201507/04/171449k6rkysmq6zharenh.jpg', 'article', '395934', '1600', '1000', '375', '0', '1436001289');
INSERT INTO `pre_image` VALUES ('19', '1', '0', 'data/attachment/article/201507/04/171502szmp4swe9khhh946.jpg', 'article', '395934', '1600', '1000', '375', '0', '1436001302');
INSERT INTO `pre_image` VALUES ('20', '1', '0', 'data/attachment/article/201507/04/171534wsmvq4pkiqo28g8m.jpg', 'article', '395934', '1600', '1000', '375', '0', '1436001334');
INSERT INTO `pre_image` VALUES ('21', '1', '0', 'data/attachment/article/201507/04/171601s9potjm3xw3i0iep.jpg', 'article', '395934', '1600', '1000', '375', '0', '1436001361');
INSERT INTO `pre_image` VALUES ('22', '1', '0', 'data/attachment/article/201507/04/172621a2z5fpck7t0pfz5h.jpg', 'article', '395934', '1600', '1000', '375', '0', '1436001981');
INSERT INTO `pre_image` VALUES ('23', '1', '0', 'data/attachment/article/201507/04/172838nkkleexkdvzxl00l.jpg', 'article', '395934', '1600', '1000', '375', '0', '1436002118');
INSERT INTO `pre_image` VALUES ('24', '1', '0', 'data/attachment/article/201507/04/173321hnn3z3knnlz153ao.jpg', 'article', '395934', '1600', '1000', '375', '0', '1436002401');
INSERT INTO `pre_image` VALUES ('25', '1', '2', 'data/attachment/article/201507/04/173352g13raaxtxl6syzlx.jpg', 'article', '395934', '1600', '1000', '375', '1', '1436002432');
INSERT INTO `pre_image` VALUES ('26', '1', '12', 'data/attachment/article/201508/01/154220pl9xdialy9d9ell7.jpg', 'article', '99863', '1002', '762', '457', '1', '1438414940');
INSERT INTO `pre_image` VALUES ('27', '1', '12', 'data/attachment/article/201508/01/154231qt18s1j7s14fzzts.jpg', 'article', '99863', '1002', '762', '457', '1', '1438414951');
INSERT INTO `pre_image` VALUES ('28', '1', '12', 'data/attachment/article/201508/01/154240ymcyy5njgzmgpgz0.jpg', 'article', '99863', '1002', '762', '457', '1', '1438414960');
INSERT INTO `pre_image` VALUES ('29', '1', '13', 'data/attachment/article/201508/01/154445lf1omrgs85moshfc.jpg', 'article', '99863', '1002', '762', '457', '1', '1438415085');
INSERT INTO `pre_image` VALUES ('30', '1', '13', 'data/attachment/article/201508/01/154451f6uf3fqqhwqwbvo0.jpg', 'article', '99863', '1002', '762', '457', '1', '1438415091');

-- ----------------------------
-- Table structure for `pre_loginfailed`
-- ----------------------------
DROP TABLE IF EXISTS `pre_loginfailed`;
CREATE TABLE `pre_loginfailed` (
  `ip` char(15) NOT NULL DEFAULT '',
  `count` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `lastupdate` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`ip`),
  KEY `ip` (`ip`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pre_loginfailed
-- ----------------------------
INSERT INTO `pre_loginfailed` VALUES ('127.0.0.1', '1', '1422023940');

-- ----------------------------
-- Table structure for `pre_nav`
-- ----------------------------
DROP TABLE IF EXISTS `pre_nav`;
CREATE TABLE `pre_nav` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(10) unsigned NOT NULL DEFAULT '0',
  `name` varchar(20) NOT NULL DEFAULT '',
  `link` varchar(200) NOT NULL DEFAULT '',
  `displayorder` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pre_nav
-- ----------------------------
INSERT INTO `pre_nav` VALUES ('1', '0', '前端', '###', '0', '0', '1');
INSERT INTO `pre_nav` VALUES ('2', '1', 'jquery', 'http://127.0.0.1/blog/jq', '1', '0', '1');
INSERT INTO `pre_nav` VALUES ('3', '1', 'js', 'http://127.0.0.1/blog/js', '4', '0', '1');
INSERT INTO `pre_nav` VALUES ('4', '1', 'css', 'http://127.0.0.1/blog', '3', '0', '1');
INSERT INTO `pre_nav` VALUES ('5', '0', '后端', 'http://127.0.0.1/blog', '2', '0', '1');
INSERT INTO `pre_nav` VALUES ('6', '5', 'linux', '', '1', '0', '1');
INSERT INTO `pre_nav` VALUES ('7', '5', 'php', '', '2', '0', '1');
INSERT INTO `pre_nav` VALUES ('8', '5', 'nginx', '', '3', '0', '1');
INSERT INTO `pre_nav` VALUES ('9', '0', '关于博客', '', '3', '0', '1');
INSERT INTO `pre_nav` VALUES ('15', '0', '关于本人', '#', '4', '1422714147', '1');

-- ----------------------------
-- Table structure for `pre_setting`
-- ----------------------------
DROP TABLE IF EXISTS `pre_setting`;
CREATE TABLE `pre_setting` (
  `sname` varchar(50) NOT NULL,
  `svalue` text NOT NULL,
  PRIMARY KEY (`sname`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pre_setting
-- ----------------------------
INSERT INTO `pre_setting` VALUES ('blog', '{\"blogName\":\"Jam\'s Blog\",\"blogSubhead\":\"Hakuna Matata\",\"blogDescription\":\"php,mysql,jquery,bootstrap,jam,web\\u540e\\u7aef\",\"adminEmail\":\"jam00@vip.qq.com\",\"icp\":\"\"}');
INSERT INTO `pre_setting` VALUES ('nav', '{\"1\":{\"id\":\"1\",\"pid\":\"0\",\"name\":\"\\u524d\\u7aef\",\"link\":\"###\",\"displayorder\":\"0\",\"dateline\":\"0\",\"status\":\"1\",\"downnav\":[{\"id\":\"2\",\"pid\":\"1\",\"name\":\"jquery\",\"link\":\"http:\\/\\/127.0.0.1\\/blog\\/jq\",\"displayorder\":\"1\",\"dateline\":\"0\",\"status\":\"1\"},{\"id\":\"4\",\"pid\":\"1\",\"name\":\"css\",\"link\":\"http:\\/\\/127.0.0.1\\/blog\",\"displayorder\":\"3\",\"dateline\":\"0\",\"status\":\"1\"},{\"id\":\"3\",\"pid\":\"1\",\"name\":\"js\",\"link\":\"http:\\/\\/127.0.0.1\\/blog\\/js\",\"displayorder\":\"4\",\"dateline\":\"0\",\"status\":\"1\"}]},\"5\":{\"id\":\"5\",\"pid\":\"0\",\"name\":\"\\u540e\\u7aef\",\"link\":\"http:\\/\\/127.0.0.1\\/blog\",\"displayorder\":\"2\",\"dateline\":\"0\",\"status\":\"1\",\"downnav\":[{\"id\":\"6\",\"pid\":\"5\",\"name\":\"linux\",\"link\":\"\",\"displayorder\":\"1\",\"dateline\":\"0\",\"status\":\"1\"},{\"id\":\"7\",\"pid\":\"5\",\"name\":\"php\",\"link\":\"\",\"displayorder\":\"2\",\"dateline\":\"0\",\"status\":\"1\"},{\"id\":\"8\",\"pid\":\"5\",\"name\":\"nginx\",\"link\":\"\",\"displayorder\":\"3\",\"dateline\":\"0\",\"status\":\"1\"}]},\"9\":{\"id\":\"9\",\"pid\":\"0\",\"name\":\"\\u5173\\u4e8e\\u535a\\u5ba2\",\"link\":\"\",\"displayorder\":\"3\",\"dateline\":\"0\",\"status\":\"1\"},\"15\":{\"id\":\"15\",\"pid\":\"0\",\"name\":\"\\u5173\\u4e8e\\u672c\\u4eba\",\"link\":\"#\",\"displayorder\":\"4\",\"dateline\":\"1422714147\",\"status\":\"1\"}}');

-- ----------------------------
-- Table structure for `pre_tag`
-- ----------------------------
DROP TABLE IF EXISTS `pre_tag`;
CREATE TABLE `pre_tag` (
  `tagid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tagname` varchar(100) NOT NULL,
  `dateline` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`tagid`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pre_tag
-- ----------------------------
INSERT INTO `pre_tag` VALUES ('2', 'PHP', '1422181828');
INSERT INTO `pre_tag` VALUES ('3', 'MySql', '1422182268');
INSERT INTO `pre_tag` VALUES ('4', 'Linux', '1422182285');
INSERT INTO `pre_tag` VALUES ('5', 'Bootstrap', '1422182323');
INSERT INTO `pre_tag` VALUES ('6', 'JQuery', '1422182343');
INSERT INTO `pre_tag` VALUES ('7', 'Nginx', '1422182366');
INSERT INTO `pre_tag` VALUES ('8', '留言区', '1422182413');
INSERT INTO `pre_tag` VALUES ('9', 'js', '1422182725');
INSERT INTO `pre_tag` VALUES ('10', '评论区', '1422182753');
INSERT INTO `pre_tag` VALUES ('11', '交流区', '1422182759');
INSERT INTO `pre_tag` VALUES ('12', '关于博客', '1422182769');
INSERT INTO `pre_tag` VALUES ('13', '测试1', '1422188328');
INSERT INTO `pre_tag` VALUES ('14', '测试2', '1422188331');
INSERT INTO `pre_tag` VALUES ('15', '测试3', '1422188334');
INSERT INTO `pre_tag` VALUES ('16', '测试4', '1422188338');
INSERT INTO `pre_tag` VALUES ('17', '测试5', '1422189251');
INSERT INTO `pre_tag` VALUES ('18', '测试6', '1422189306');

-- ----------------------------
-- Table structure for `pre_users`
-- ----------------------------
DROP TABLE IF EXISTS `pre_users`;
CREATE TABLE `pre_users` (
  `uid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `username` char(15) NOT NULL DEFAULT '',
  `password` char(32) NOT NULL DEFAULT '',
  `email` char(32) NOT NULL DEFAULT '',
  `notice` smallint(6) unsigned NOT NULL DEFAULT '0',
  `pm` smallint(6) unsigned NOT NULL DEFAULT '0',
  `groupid` smallint(2) unsigned NOT NULL DEFAULT '0',
  `regip` char(15) NOT NULL DEFAULT '',
  `regdate` int(10) unsigned NOT NULL DEFAULT '0',
  `lastloginip` char(15) NOT NULL DEFAULT '',
  `lastlogintime` int(10) unsigned NOT NULL DEFAULT '0',
  `salt` char(6) NOT NULL,
  PRIMARY KEY (`uid`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pre_users
-- ----------------------------
INSERT INTO `pre_users` VALUES ('1', 'admin', 'f77a37575d731c22a6986d7b4ef57602', 'jam00@vip.qq.com', '10', '18', '1', '127.0.0.1', '0', '127.0.0.1', '0', 'd7b50f');
INSERT INTO `pre_users` VALUES ('2', '测试1', '3430916bfea10b8851f24cae695aa54c', 'cs1@qq.com', '0', '0', '10', '127.0.0.1', '1422005439', '127.0.0.1', '1422005439', 'aNO7Z4');
