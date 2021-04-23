SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for address
-- ----------------------------
DROP TABLE IF EXISTS `address`;
CREATE TABLE `address`  (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `userid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '0' COMMENT '用户id',
  `realname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '无名氏' COMMENT '收货人姓名',
  `zipcode` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '10010' COMMENT '邮编',
  `mobile` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '暂无' COMMENT '手机号',
  `adetail` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '暂无' COMMENT '收货地址',
  `default` varchar(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '0' COMMENT '默认地址',
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for blog
-- ----------------------------
DROP TABLE IF EXISTS `blog`;
CREATE TABLE `blog`  (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '博客ID',
  `title` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '暂无' COMMENT '博客标题',
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '默认分类' COMMENT '博客分类',
  `author` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'admin' COMMENT '文章作者',
  `picture` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'unknown' COMMENT '博文配图',
  `abstract` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '暂无' COMMENT '博客文章摘要',
  `content` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '博客内容',
  `update_time` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for category
-- ----------------------------
DROP TABLE IF EXISTS `category`;
CREATE TABLE `category`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) NULL DEFAULT 0 COMMENT '父分类ID',
  `name` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '暂无' COMMENT '分类别名',
  `title` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '暂无' COMMENT '分类标题',
  `keywords` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '暂无' COMMENT '分类关键词',
  `description` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '暂无' COMMENT '分类描述',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 16 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of category
-- ----------------------------
INSERT INTO `category` VALUES (1, 0, 'default', '默认分类', '默认分类', '更新分类描述');
INSERT INTO `category` VALUES (2, 0, 'Webvul', 'Web漏洞', '', '');
INSERT INTO `category` VALUES (3, 0, 'PC Clinet', 'PC客户端漏洞', '', '');
INSERT INTO `category` VALUES (4, 0, 'Sever', '服务器漏洞', '', '');
INSERT INTO `category` VALUES (5, 0, 'Mobile Clinet', '移动客户端漏洞', '', '');
INSERT INTO `category` VALUES (6, 2, 'SQLinjection', 'SQL注入', '', '');
INSERT INTO `category` VALUES (7, 2, 'XSS', 'XSS', '', '');
INSERT INTO `category` VALUES (8, 2, 'CSRF', 'CSRF', '', '');
INSERT INTO `category` VALUES (9, 5, 'IOS', 'IOS', '', '');
INSERT INTO `category` VALUES (10, 5, 'Android', 'Android', 'Android', '');
INSERT INTO `category` VALUES (11, 3, 'Overflow', '溢出', '', '');
INSERT INTO `category` VALUES (12, 3, 'DDOS', '拒绝服务', '', '');
INSERT INTO `category` VALUES (13, 7, 'DOM XSS', '基于DOM的XSS', '', '');
INSERT INTO `category` VALUES (14, 7, 'Stored XSS', '存储型XSS', '', '');
INSERT INTO `category` VALUES (15, 2, 'Logic', '逻辑漏洞', '', '');

-- ----------------------------
-- Table structure for comment
-- ----------------------------
DROP TABLE IF EXISTS `comment`;
CREATE TABLE `comment`  (
  `id` int(255) NOT NULL AUTO_INCREMENT COMMENT '评论编号',
  `user_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '匿名用户' COMMENT '评论用户',
  `admin_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '匿名用户',
  `post_id` int(255) NOT NULL COMMENT '评论报告',
  `content` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '暂无' COMMENT '评论内容',
  `update_time` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '评论时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '报告评论' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for gifts
-- ----------------------------
DROP TABLE IF EXISTS `gifts`;
CREATE TABLE `gifts`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '奖品ID',
  `title` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '奖品名称',
  `url` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '奖品图片',
  `price` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '奖品价格',
  `category` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'graphic' COMMENT '奖品类型',
  `stock` int(100) NOT NULL DEFAULT 0 COMMENT '库存',
  `redeemed` int(100) NOT NULL DEFAULT 0 COMMENT '已兑换个数',
  `visible` int(10) NOT NULL DEFAULT 0 COMMENT '上架状态',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for hall
-- ----------------------------
DROP TABLE IF EXISTS `hall`;
CREATE TABLE `hall`  (
  `id` int(10) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '名人堂昵称',
  `team` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'Unknown' COMMENT '团队名称',
  `url` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '名人堂头像URL',
  `des` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '名人堂介绍',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '名人堂' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of hall
-- ----------------------------
INSERT INTO `hall` VALUES (0, 'Nancy Rich', 'Google (Porject Zero)', './PUBLIC/Index/img/400x400/04.jpg', '来自Google Project Zero的Nancy，第一季度帮助我们发现20个涉及Andriod、Google Chrome等核心产品的严重漏洞。对Google安全生态的建设起到了极大的帮助 ');
INSERT INTO `hall` VALUES (1, 'Anna Kusaikina', 'Apple Security Team', './Public/Index/img/400x400/06.jpg', '来自Apple Security Team的Anna，第三季度帮助我们发现5个涉及Google Chrome的高危漏洞，对Chrome的稳定性和安全性的提升贡献非凡。');
INSERT INTO `hall` VALUES (2, 'Microsoft Security Center', 'Microsoft Security Response Center', './Public/Index/img/400x400/05.jpg', '帮助我们发现了一枚严重级别的远程代码执行漏洞，并及时通知我们进行修复，保护了亿万用户的安全，特此表示衷心的感谢。');

-- ----------------------------
-- Table structure for info
-- ----------------------------
DROP TABLE IF EXISTS `info`;
CREATE TABLE `info`  (
  `user_id` int(11) NOT NULL,
  `username` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `realname` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `location` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `tel` varchar(11) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `zipcode` varchar(6) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `alipay` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`user_id`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for manager
-- ----------------------------
DROP TABLE IF EXISTS `manager`;
CREATE TABLE `manager`  (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `avatar` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'admin_avatar.png',
  `email` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '暂无',
  `password` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '暂无',
  `token` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '暂无' COMMENT 'token',
  `login_ip` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '暂无',
  `create_at` varchar(11) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '暂无',
  `update_at` varchar(11) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '暂无',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `username`(`username`) USING BTREE,
  UNIQUE INDEX `username_2`(`username`) USING BTREE,
  UNIQUE INDEX `username_3`(`username`, `email`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for member
-- ----------------------------
DROP TABLE IF EXISTS `member`;
CREATE TABLE `member`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '用户ID',
  `pid` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '个人资料ID',
  `username` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '路人甲' COMMENT '用户昵称',
  `realname` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '暂无' COMMENT '真实姓名',
  `team` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '暂无' COMMENT '团队名称',
  `email` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '暂无' COMMENT '用户邮箱',
  `salt` varchar(9) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '暂无' COMMENT '加密salt',
  `password` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '用户密码',
  `token` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '防护token',
  `avatar` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '/default_avatar.png' COMMENT '用户头像',
  `address` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '暂无' COMMENT '用户住址',
  `description` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '暂无' COMMENT '个人简介',
  `bankcode` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '暂无' COMMENT '银行账号',
  `idcode` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '暂无' COMMENT '身份证号',
  `zipcode` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '暂无' COMMENT '邮编',
  `alipay` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '暂无' COMMENT '支付宝账号',
  `tel` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '暂无' COMMENT '联系电话',
  `website` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '暂无' COMMENT '个人网站',
  `qqnumber` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT 'QQ号',
  `wechat` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '暂无' COMMENT '微信号',
  `create_at` varchar(11) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '0' COMMENT '创建时间',
  `update_at` varchar(11) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '0' COMMENT '更新时间',
  `login_ip` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '0' COMMENT '登录IP',
  `status` tinyint(1) NULL DEFAULT 1 COMMENT '0:禁止登陆 1:正常',
  `type` tinyint(1) NULL DEFAULT 1 COMMENT '1:前台用户 2:管理员 ',
  `jifen` int(10) NOT NULL DEFAULT 0 COMMENT '用户积分',
  `jinbi` int(10) NOT NULL DEFAULT 0 COMMENT '安全币',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `username`(`username`) USING BTREE,
  INDEX `password`(`password`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for message
-- ----------------------------
DROP TABLE IF EXISTS `message`;
CREATE TABLE `message`  (
  `id` int(100) NOT NULL AUTO_INCREMENT COMMENT '消息id',
  `userid` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0',
  `sender` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '系统',
  `content` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `type` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '系统消息',
  `read` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0',
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for notes
-- ----------------------------
DROP TABLE IF EXISTS `notes`;
CREATE TABLE `notes`  (
  `id` int(100) NOT NULL AUTO_INCREMENT COMMENT '特殊页面ID',
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '特殊页面标题',
  `content` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '特殊页面内容',
  `author` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '页面作者',
  `time` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '页面创建时间',
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '页面别名',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '特殊页面' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for order
-- ----------------------------
DROP TABLE IF EXISTS `order`;
CREATE TABLE `order`  (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '订单编号',
  `userid` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '用户ID',
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '暂无' COMMENT '兑换用户',
  `realname` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '暂无' COMMENT '真实姓名',
  `address` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '暂无' COMMENT '住址',
  `tel` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '暂无' COMMENT '电话',
  `gid` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '暂无' COMMENT '礼品名称',
  `price` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '订单金额',
  `num` int(10) NOT NULL DEFAULT 1 COMMENT '兑换数量',
  `trackingno` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '暂无' COMMENT '快递单号',
  `update_time` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '暂无' COMMENT '订单时间',
  `finish` int(2) NOT NULL DEFAULT 0 COMMENT '1. 完成 2.未完成',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for page
-- ----------------------------
DROP TABLE IF EXISTS `page`;
CREATE TABLE `page`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '公告ID',
  `title` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '公告标题',
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '公告编号',
  `author` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '公告作者',
  `abstract` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '暂无' COMMENT '公告摘要',
  `content` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '公告内容',
  `update_time` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '发布日期',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for post
-- ----------------------------
DROP TABLE IF EXISTS `post`;
CREATE TABLE `post`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `session` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '临时报告查看授权id',
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '报告标题',
  `content` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '报告内容',
  `advise` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '无' COMMENT '修复建议',
  `attachment` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '暂无' COMMENT '附件',
  `time` varchar(11) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '0' COMMENT '提交时间',
  `day` tinyint(1) NOT NULL DEFAULT 1 COMMENT '修补期限',
  `cate_id` int(11) NULL DEFAULT NULL COMMENT '分类id',
  `user_id` int(11) NULL DEFAULT NULL COMMENT '提交者id',
  `rank` tinyint(1) NOT NULL DEFAULT 1 COMMENT '无影响:1, 低危:2, 中危:3, 高危:4',
  `bounty` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '评定中' COMMENT '漏洞报告奖励',
  `score` int(11) NOT NULL DEFAULT 0 COMMENT '安全币',
  `points` int(11) NOT NULL DEFAULT 0 COMMENT '积分',
  `type` tinyint(1) NULL DEFAULT 1 COMMENT '1:审核中,2:已忽略,3:已确认,4:已修复,5:已完成',
  `visible` int(2) NOT NULL DEFAULT 0 COMMENT '是否导出临时报告',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `cate_id`(`cate_id`) USING BTREE,
  INDEX `user_id`(`user_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for poststat
-- ----------------------------
DROP TABLE IF EXISTS `poststat`;
CREATE TABLE `poststat`  (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `type` int(10) NOT NULL DEFAULT 0,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `content` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '暂无',
  `postid` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0',
  `operator` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '报告状态记录' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for record
-- ----------------------------
DROP TABLE IF EXISTS `record`;
CREATE TABLE `record`  (
  `id` int(100) NOT NULL AUTO_INCREMENT COMMENT '操作ID',
  `type` int(10) NOT NULL COMMENT '操作类型',
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '操作名称',
  `content` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '操作内容',
  `time` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '操作时间',
  `user` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '变动用户',
  `userid` int(10) NOT NULL DEFAULT 0 COMMENT '变动用户ID',
  `operator` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '暂无' COMMENT '操作人',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '操作记录' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for setting
-- ----------------------------
DROP TABLE IF EXISTS `setting`;
CREATE TABLE `setting`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '配置编号',
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'default',
  `value` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'default	' COMMENT '配置内容',
  `type` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'default',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of setting
-- ----------------------------
INSERT INTO `setting` VALUES (1, 'site_name_cn', '腾讯', 'front');
INSERT INTO `setting` VALUES (2, 'site_intro', '腾讯一直致力于保护广大用户的安全，腾讯安全应急响应中心（Tencent Security Response Center）非常欢迎广大用户向我们反馈腾讯产品和业务的安全漏洞，以帮助我们提升产品和业务的安全性。', 'front');
INSERT INTO `setting` VALUES (3, 'site_analytics', '&lt;script&gt;void(0)&lt;/script&gt;', 'front');
INSERT INTO `setting` VALUES (4, 'site_copyright', 'Tencent', 'front');
INSERT INTO `setting` VALUES (5, 'site_qq', '100000', 'front');
INSERT INTO `setting` VALUES (6, 'site_email', 'security@tencent.com', 'front');
INSERT INTO `setting` VALUES (7, 'site_about', 'https://www.tencent.com', 'front');
INSERT INTO `setting` VALUES (8, 'site_career', 'https://security.tencent.com/index.php/about#joinus', 'front');
INSERT INTO `setting` VALUES (9, 'site_wechat', '/xsrc/Public/Uploads/wechat.png', 'front');
INSERT INTO `setting` VALUES (10, 'site_name_en', 'Tencent', 'front');
INSERT INTO `setting` VALUES (12, 'site_abbrev', 'xSRC', 'front');
INSERT INTO `setting` VALUES (13, 'site_notify_method', '0', 'notify');
INSERT INTO `setting` VALUES (14, 'site_notify_users', 'zhangsan', 'notify');
INSERT INTO `setting` VALUES (15, 'site_notify_corpid', 'none', 'notify');
INSERT INTO `setting` VALUES (16, 'site_notify_corpsecret', 'none', 'notify');
INSERT INTO `setting` VALUES (17, 'site_robot_callback', 'default', 'notify');

SET FOREIGN_KEY_CHECKS = 1;
