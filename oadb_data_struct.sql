-- MySQL dump 10.13  Distrib 5.7.16, for osx10.12 (x86_64)
--
-- Host: localhost    Database: oadb
-- ------------------------------------------------------
-- Server version	5.7.16

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `auth_assignment`
--

DROP TABLE IF EXISTS `auth_assignment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_assignment` (
  `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL COMMENT 'ç”¨æˆ·ç¼–å·',
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`item_name`,`user_id`),
  CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='æƒé™ç”¨æˆ·åˆ†é…è¡¨';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_assignment`
--

LOCK TABLES `auth_assignment` WRITE;
/*!40000 ALTER TABLE `auth_assignment` DISABLE KEYS */;
INSERT INTO `auth_assignment` VALUES ('3','1',1482239356),('3','2',NULL),('4','10',1484641456),('4','12',1484642176),('4','13',1484642249),('5','15',1485338735);
/*!40000 ALTER TABLE `auth_assignment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auth_item`
--

DROP TABLE IF EXISTS `auth_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_item` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL COMMENT '角色|权限',
  `type` int(11) unsigned NOT NULL COMMENT '类型:1角色(岗位),2权限',
  `description` text COLLATE utf8_unicode_ci,
  `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` text COLLATE utf8_unicode_ci,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`),
  KEY `rule_name` (`rule_name`),
  KEY `idx-auth_item-type` (`type`),
  CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='角色权限表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_item`
--

LOCK TABLES `auth_item` WRITE;
/*!40000 ALTER TABLE `auth_item` DISABLE KEYS */;
INSERT INTO `auth_item` VALUES ('3',1,'',NULL,NULL,1482239356,1482239356),('4',1,'',NULL,NULL,1484641456,1484641456),('5',1,'',NULL,NULL,1484713296,1484713296),('7',1,'',NULL,NULL,1484643358,1484643358),('8',1,'',NULL,NULL,1484712363,1484712363),('customer/customer/create',2,'permission: customer/customer/create',NULL,NULL,1484747548,1484747548),('customer/customer/index',2,'permission: customer/customer/index',NULL,NULL,1484747330,1484747330),('customer/group/rate',2,'permission: customer/group/rate',NULL,NULL,1484747024,1484747024),('finance/finance/summary',2,'permission: finance/finance/summary',NULL,NULL,1488788304,1488788304),('finance/payment/index',2,'permission: finance/payment/index',NULL,NULL,1488788304,1488788304),('finance/receipt/index',2,'permission: finance/receipt/index',NULL,NULL,1488788304,1488788304),('finance/statement/index',2,'permission: finance/statement/index',NULL,NULL,1488963899,1488963899),('product/category/root-set',2,'permission: product/category/root-set',NULL,NULL,1488788304,1488788304),('product/product-category/index',2,'permission: product/product-category/index',NULL,NULL,1488788304,1488788304),('product/product/index',2,'permission: product/product/index',NULL,NULL,1488788304,1488788304),('system/customer/index',2,'permission: system/customer/index',NULL,NULL,1488788304,1488788304),('system/finance-subject/index',2,'permission: system/finance-subject/index',NULL,NULL,1488963621,1488963621),('system/finance/summary',2,'permission: system/finance/summary',NULL,NULL,1488788304,1488788304),('system/group/rate',2,'permission: system/group/rate',NULL,NULL,1488963621,1488963621),('system/login/ip-lock',2,'permission: system/login/ip-lock',NULL,NULL,1488788304,1488788304),('system/login/record',2,'permission: system/login/record',NULL,NULL,1488788304,1488788304),('system/money/index',2,'permission: system/money/index',NULL,NULL,1488963621,1488963621),('system/notice/index',2,'permission: system/notice/index',NULL,NULL,1488788304,1488788304),('system/payment/index',2,'permission: system/payment/index',NULL,NULL,1488963621,1488963621),('system/product-category/index',2,'permission: system/product-category/index',NULL,NULL,1488788304,1488788304),('system/product/index',2,'permission: system/product/index',NULL,NULL,1488963621,1488963621),('system/receipt/index',2,'permission: system/receipt/index',NULL,NULL,1488788304,1488788304),('system/root-category/index',2,'permission: system/root-category/index',NULL,NULL,1488788304,1488788304),('system/statement/index',2,'permission: system/statement/index',NULL,NULL,1488963621,1488963621),('system/task/index',2,'permission: system/task/index',NULL,NULL,1488788304,1488788304),('task/task/received-index',2,'permission: task/task/received-index',NULL,NULL,1488788304,1488788304),('task/task/sent-index',2,'permission: task/task/sent-index',NULL,NULL,1488788304,1488788304),('task/task/wait-index',2,'permission: task/task/wait-index',NULL,NULL,1488788304,1488788304),('user/company/index',2,'permission: user/company/index',NULL,NULL,1484730609,1484730609),('user/company/switch',2,'permission: user/company/switch',NULL,NULL,1484748149,1484748149),('user/department/index',2,'permission: user/department/index',NULL,NULL,1484730609,1484730609),('user/posts/index',2,'permission: user/posts/index',NULL,NULL,1484730609,1484730609),('user/user/create',2,'permission: user/user/create',NULL,NULL,1484747548,1484747548),('user/user/index',2,'permission: user/user/index',NULL,NULL,1484730609,1484730609),('user/user/update',2,'permission: user/user/update',NULL,NULL,1484747631,1484747631);
/*!40000 ALTER TABLE `auth_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auth_item_child`
--

DROP TABLE IF EXISTS `auth_item_child`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_item_child` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`),
  CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='å±‚çº§æ˜ å°„è¡¨';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_item_child`
--

LOCK TABLES `auth_item_child` WRITE;
/*!40000 ALTER TABLE `auth_item_child` DISABLE KEYS */;
INSERT INTO `auth_item_child` VALUES ('8','customer/customer/create'),('3','customer/customer/index'),('7','customer/customer/index'),('8','customer/customer/index'),('3','customer/group/rate'),('7','customer/group/rate'),('8','customer/group/rate'),('3','finance/finance/summary'),('3','finance/payment/index'),('3','finance/receipt/index'),('3','finance/statement/index'),('3','product/category/root-set'),('3','product/product-category/index'),('3','product/product/index'),('3','system/customer/index'),('3','system/finance-subject/index'),('3','system/finance/summary'),('3','system/group/rate'),('3','system/login/ip-lock'),('3','system/login/record'),('3','system/money/index'),('3','system/notice/index'),('3','system/payment/index'),('3','system/product-category/index'),('3','system/product/index'),('3','system/receipt/index'),('3','system/root-category/index'),('3','system/statement/index'),('3','system/task/index'),('3','task/task/received-index'),('3','task/task/sent-index'),('3','task/task/wait-index'),('3','user/company/index'),('7','user/company/index'),('8','user/company/index'),('7','user/company/switch'),('8','user/company/switch'),('3','user/department/index'),('8','user/department/index'),('3','user/posts/index'),('7','user/posts/index'),('8','user/user/create'),('3','user/user/index'),('7','user/user/index'),('8','user/user/index'),('8','user/user/update');
/*!40000 ALTER TABLE `auth_item_child` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auth_rule`
--

DROP TABLE IF EXISTS `auth_rule`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_rule` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `data` text COLLATE utf8_unicode_ci,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='æƒé™è§„åˆ™è¡¨';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_rule`
--

LOCK TABLES `auth_rule` WRITE;
/*!40000 ALTER TABLE `auth_rule` DISABLE KEYS */;
/*!40000 ALTER TABLE `auth_rule` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `company`
--

DROP TABLE IF EXISTS `company`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `company` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sup_id` int(10) unsigned NOT NULL DEFAULT '0',
  `name` char(20) COLLATE utf8_bin NOT NULL DEFAULT '',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT 'çŠ¶æ€:0æ­£å¸¸,1ä½œåºŸ ',
  `level` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT 'å±‚çº§ ',
  `create_author_uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'åˆ›å»ºäººç”¨æˆ·ç¼–å·',
  `update_author_uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'ä¿®æ”¹äººç”¨æˆ·ç¼–å·',
  `create_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'åˆ›å»ºæ—¶é—´',
  `update_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'ä¿®æ”¹æ—¶é—´',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `company`
--

LOCK TABLES `company` WRITE;
/*!40000 ALTER TABLE `company` DISABLE KEYS */;
INSERT INTO `company` VALUES (1,0,'3zhong',0,1,0,2,'2017-01-05 15:08:09','2017-01-14 10:09:58'),(2,11,'3总',0,2,0,2,'2017-01-05 15:08:09','2017-01-05 09:54:08'),(3,2,'3总1子1',0,3,0,2,'2017-01-05 15:08:09','2017-02-26 16:42:31'),(4,0,'四zhong一子',0,1,0,2,'2017-01-05 15:08:09','2017-02-04 08:28:47'),(5,0,'大金投资有限公司',0,1,0,2,'2017-01-05 15:08:09','2017-02-04 08:24:11'),(6,0,'二总',0,1,0,0,'2017-01-05 15:08:09','2017-01-05 15:08:09'),(7,11,'四总',0,2,0,0,'2017-01-05 15:08:09','2017-01-05 15:08:09'),(8,11,'总三子',0,2,0,0,'2017-01-05 15:08:09','2017-01-05 15:08:09'),(9,11,'总二子',0,2,0,0,'2017-01-05 15:08:09','2017-01-05 15:08:09'),(10,11,'总五子',0,2,0,0,'2017-01-05 15:08:09','2017-01-05 15:08:09'),(11,0,'总公司',0,1,0,2,'2017-01-05 15:08:09','2017-01-14 10:00:34'),(12,13,'总公司111子',0,4,0,0,'2017-01-05 15:08:09','2017-01-05 15:08:09'),(13,14,'总公司11子',0,3,0,0,'2017-01-05 15:08:09','2017-01-05 15:08:09'),(14,11,'总公司1子',0,2,0,0,'2017-01-05 15:08:09','2017-01-05 15:08:09'),(15,11,'总公司2子',0,2,0,0,'2017-01-05 15:08:09','2017-01-05 15:08:09'),(16,11,'总六子',0,2,0,0,'2017-01-05 15:08:09','2017-01-05 15:08:09'),(17,11,'总四子',0,2,0,2,'2017-01-05 15:08:09','2017-01-05 09:57:10'),(18,0,'总集团',0,1,0,0,'2017-01-05 15:08:09','2017-01-05 15:08:09');
/*!40000 ALTER TABLE `company` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `company_old`
--

DROP TABLE IF EXISTS `company_old`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `company_old` (
  `name` char(40) NOT NULL COMMENT '公司名称',
  `superior_company_name` char(40) NOT NULL DEFAULT '' COMMENT 'ä¸Šçº§å…¬å¸åç§°',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT 'çŠ¶æ€:0æ­£å¸¸,1ä½œåºŸ ',
  `level` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT 'å±‚çº§ ',
  `create_author_uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'åˆ›å»ºäººç”¨æˆ·ç¼–å·',
  `update_author_uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'ä¿®æ”¹äººç”¨æˆ·ç¼–å·',
  `create_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'åˆ›å»ºæ—¶é—´',
  `update_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'ä¿®æ”¹æ—¶é—´',
  PRIMARY KEY (`name`),
  UNIQUE KEY `name` (`name`),
  KEY `superior_company_name` (`superior_company_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='å…¬å¸è¡¨';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `company_old`
--

LOCK TABLES `company_old` WRITE;
/*!40000 ALTER TABLE `company_old` DISABLE KEYS */;
INSERT INTO `company_old` VALUES ('总公司','无',0,1,0,2,'2016-12-12 15:29:00','2016-12-25 08:31:19'),('总公司1子','总公司',0,2,0,2,'2016-12-12 15:29:25','2016-12-25 08:31:37'),('总公司2子','总公司',0,2,0,0,'2016-12-12 15:29:33','2016-12-12 15:29:33'),('总公司11子','总公司1子',0,3,0,0,'2016-12-12 15:29:43','2016-12-12 15:29:43'),('总公司111子','总公司11子',0,4,0,0,'2016-12-12 15:29:52','2016-12-12 15:29:52'),('总二子','总公司',0,2,0,0,'2016-12-12 16:34:35','2016-12-12 16:34:35'),('总三子','总公司',0,2,0,0,'2016-12-12 16:40:16','2016-12-12 16:40:16'),('总四子','总公司',0,2,0,0,'2016-12-12 16:41:47','2016-12-12 16:41:47'),('总五子','总公司',0,2,0,0,'2016-12-12 16:42:21','2016-12-12 16:42:21'),('二总','无',0,1,0,0,'2016-12-12 16:43:38','2016-12-12 16:43:38'),('总六子','总公司',0,2,0,0,'2016-12-12 16:47:37','2016-12-12 16:47:37'),('3zhong','无',0,1,0,0,'2016-12-12 20:03:53','2016-12-12 20:03:53'),('3总','总公司',0,2,0,0,'2016-12-13 11:16:40','2016-12-13 11:16:40'),('四总','总公司',0,2,0,0,'2016-12-14 12:54:27','2016-12-14 12:54:27'),('总集团','无',1,1,0,2,'2016-12-16 11:49:32','2016-12-25 08:45:36'),('3总1子1','3总',0,3,0,2,'2016-12-25 17:15:52','2016-12-25 11:19:14'),('4zhong1zi','四总',0,3,0,0,'2016-12-25 17:20:59','2016-12-25 17:20:59'),('66666666','无',0,1,2,2,'2016-12-25 14:25:16','2016-12-25 20:25:16');
/*!40000 ALTER TABLE `company_old` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customer`
--

DROP TABLE IF EXISTS `customer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customer` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(20) NOT NULL,
  `company_id` int(10) unsigned NOT NULL DEFAULT '0',
  `grade` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT 'çº§åˆ«:1A2B3C4D',
  `remarks` text,
  `status` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '0æ­£å¸¸1ä½œåºŸ',
  `create_author_uid` int(10) unsigned NOT NULL DEFAULT '0',
  `update_author_uid` int(10) unsigned NOT NULL DEFAULT '0',
  `create_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='å®¢æˆ·è¡¨';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customer`
--

LOCK TABLES `customer` WRITE;
/*!40000 ALTER TABLE `customer` DISABLE KEYS */;
INSERT INTO `customer` VALUES (1,'客户一',11,1,'aadddeefff',0,2,2,'2017-01-15 05:25:44','2017-02-01 07:57:55'),(2,'客户二',11,2,'式我',0,2,2,'2017-01-15 05:26:04','2017-01-15 05:28:21'),(3,'客户三',11,3,'',0,2,2,'2017-01-18 11:42:15','2017-01-18 11:42:29');
/*!40000 ALTER TABLE `customer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `department`
--

DROP TABLE IF EXISTS `department`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `department` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(40) NOT NULL COMMENT 'éƒ¨é—¨',
  `company_id` int(10) unsigned NOT NULL DEFAULT '0',
  `superior_department_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上级部门编号',
  `status` tinyint(11) unsigned NOT NULL DEFAULT '0' COMMENT 'çŠ¶æ€:0æ­£å¸¸1ä½œåºŸ',
  `create_author_uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'åˆ›å»ºäººç”¨æˆ·ç¼–å· ',
  `update_author_uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'ä¿®æ”¹äººç”¨æˆ·ç¼–å·',
  `create_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'åˆ›å»ºæ—¶é—´',
  `update_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'ä¿®æ”¹æ—¶é—´',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=utf8 COMMENT='éƒ¨é—¨è¡¨';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `department`
--

LOCK TABLES `department` WRITE;
/*!40000 ALTER TABLE `department` DISABLE KEYS */;
INSERT INTO `department` VALUES (1,'研发部',11,0,0,0,2,'2016-12-17 11:10:45','2016-12-17 11:10:45'),(2,'财务部',6,0,0,0,0,'2016-12-17 11:44:12','2016-12-17 11:44:12'),(3,'财务部',7,0,0,0,0,'2016-12-17 11:45:17','2016-12-17 11:45:17'),(4,'产品部',7,0,0,0,0,'2016-12-17 11:45:59','2016-12-17 11:45:59'),(5,'前端',11,1,0,0,2,'2016-12-17 14:48:07','2016-12-25 11:04:12'),(6,'后台',11,1,0,0,2,'2016-12-17 14:48:32','2016-12-25 11:04:14'),(7,'Ui',11,1,0,0,2,'2016-12-17 16:05:47','2016-12-25 11:04:17'),(15,'后勤部',11,0,0,0,0,'2016-12-17 17:42:20','2016-12-17 17:42:20'),(14,'研发部1',11,6,0,0,2,'2016-12-17 17:03:15','2016-12-25 11:04:09'),(16,'商务部',11,0,0,0,0,'2016-12-17 17:42:44','2016-12-17 17:42:44'),(17,'市场部',11,0,0,0,0,'2016-12-17 17:43:07','2016-12-17 17:43:07'),(18,'销售部',11,1,0,0,0,'2016-12-17 17:43:24','2016-12-17 17:43:24'),(19,'产品部',11,0,0,0,2,'2016-12-17 17:43:43','2017-01-15 04:58:27'),(20,'客服部',11,1,0,0,0,'2016-12-18 13:06:38','2016-12-18 13:06:38'),(21,'客服部',6,0,0,0,2,'2016-12-25 17:23:19','2017-01-15 04:05:42'),(22,'商务部1',6,0,0,0,2,'2016-12-25 17:31:51','2016-12-25 11:32:47'),(23,'4zhong2',7,0,0,0,2,'2016-12-25 17:48:26','2017-01-15 04:05:49'),(24,'4zhong3',7,0,0,0,0,'2016-12-25 17:51:20','2016-12-25 17:51:20'),(25,'adddd',11,0,0,0,2,'2016-12-25 20:13:44','2017-01-15 04:58:16'),(26,'aaaa',11,0,0,2,0,'2016-12-25 14:22:06','2016-12-25 20:22:06'),(27,'bbbbb',11,0,0,2,2,'2016-12-25 14:24:27','2016-12-25 20:24:27'),(28,'业务部',7,4,0,2,2,'2017-01-18 10:39:51','2017-01-18 11:21:32');
/*!40000 ALTER TABLE `department` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `finance_subject`
--

DROP TABLE IF EXISTS `finance_subject`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `finance_subject` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `subject_name` char(20) NOT NULL,
  `superior_subject_id` int(10) unsigned NOT NULL DEFAULT '0',
  `enable` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '0å¯ç”¨1åœç”¨',
  `status` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '0æ­£å¸¸1ä½œåºŸ',
  `create_author_uid` int(11) NOT NULL,
  `update_author_uid` int(11) NOT NULL,
  `create_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='è´¢åŠ¡ç§‘ç›®è¡¨';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `finance_subject`
--

LOCK TABLES `finance_subject` WRITE;
/*!40000 ALTER TABLE `finance_subject` DISABLE KEYS */;
INSERT INTO `finance_subject` VALUES (1,'aaa1',0,1,0,2,2,'2017-02-22 10:13:47','2017-02-22 10:55:47'),(2,'aaa2',1,0,0,2,2,'2017-02-22 10:16:18','2017-02-22 10:43:51'),(3,'subject_one',0,0,0,2,2,'2017-02-24 15:24:37','2017-02-24 15:24:37'),(4,'subject_one_child',3,0,0,2,2,'2017-02-24 14:41:09','2017-02-24 14:41:09');
/*!40000 ALTER TABLE `finance_subject` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `group_rate`
--

DROP TABLE IF EXISTS `group_rate`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `group_rate` (
  `company_id` int(10) unsigned NOT NULL DEFAULT '0',
  `rate_company_id` int(10) unsigned NOT NULL DEFAULT '0',
  `rater_uid` int(11) NOT NULL COMMENT 'è¯„çº§è€…çš„ç”¨æˆ·ç¼–å·',
  `grade` tinyint(3) unsigned NOT NULL COMMENT 'ç­‰çº§1A2B3C4D',
  `create_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='é›†å›¢å…¬å¸è¯„çº§è¡¨ ';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `group_rate`
--

LOCK TABLES `group_rate` WRITE;
/*!40000 ALTER TABLE `group_rate` DISABLE KEYS */;
INSERT INTO `group_rate` VALUES (5,11,2,2,'2017-01-18 12:59:59','2017-01-18 12:59:59'),(4,11,2,1,'2017-01-18 12:59:59','2017-01-18 12:59:59'),(3,11,2,3,'2017-01-18 12:59:59','2017-01-18 12:59:59'),(1,11,2,3,'2017-01-18 12:59:59','2017-01-18 12:59:59'),(2,11,2,2,'2017-01-18 12:59:59','2017-01-18 12:59:59'),(5,2,2,2,'2017-02-28 11:03:38','2017-02-28 11:03:38');
/*!40000 ALTER TABLE `group_rate` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `login_logs`
--

DROP TABLE IF EXISTS `login_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `login_logs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(10) unsigned NOT NULL,
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '1成功,2密码错误,3验证错误,4账号错误',
  `login_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `login_ip` char(15) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '0',
  `unlock_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `unlock_uid` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `login_logs`
--

LOCK TABLES `login_logs` WRITE;
/*!40000 ALTER TABLE `login_logs` DISABLE KEYS */;
INSERT INTO `login_logs` VALUES (1,2,1,'2017-03-08 10:52:54','::1','2017-03-08 10:52:54',0),(2,15,1,'2017-03-08 10:56:37','::1','2017-03-08 10:56:37',0),(3,15,1,'2017-03-08 11:08:01','::1','2017-03-08 11:08:01',0),(4,2,1,'2017-03-08 13:24:38','::1','2017-03-08 13:24:38',0),(5,15,1,'2017-03-08 13:29:10','::1','2017-03-08 13:29:10',0),(6,2,2,'2017-03-08 13:58:16','::1','2017-03-08 13:58:16',0),(7,2,1,'2017-03-08 13:58:31','::1','2017-03-08 13:58:31',0),(8,15,1,'2017-03-08 14:20:10','::1','2017-03-08 14:20:10',0),(9,2,1,'2017-03-08 14:38:17','::1','2017-03-08 14:38:17',0);
/*!40000 ALTER TABLE `login_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migration`
--

DROP TABLE IF EXISTS `migration`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='æƒé™æ•°æ®è¿ç§»è¡¨';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migration`
--

LOCK TABLES `migration` WRITE;
/*!40000 ALTER TABLE `migration` DISABLE KEYS */;
INSERT INTO `migration` VALUES ('m000000_000000_base',1481037472),('m140506_102106_rbac_init',1481037570);
/*!40000 ALTER TABLE `migration` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `money`
--

DROP TABLE IF EXISTS `money`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `money` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(20) NOT NULL,
  `enable` tinyint(2) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(2) unsigned DEFAULT '0',
  `create_author_uid` int(10) unsigned NOT NULL DEFAULT '0',
  `update_author_uid` int(11) NOT NULL DEFAULT '0',
  `create_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `money`
--

LOCK TABLES `money` WRITE;
/*!40000 ALTER TABLE `money` DISABLE KEYS */;
INSERT INTO `money` VALUES (1,'美金',0,0,2,2,'2017-01-10 12:00:09','2017-01-10 12:03:07'),(2,'欢乐豆',0,0,2,2,'2017-01-10 12:00:35','2017-01-10 12:03:19');
/*!40000 ALTER TABLE `money` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notice`
--

DROP TABLE IF EXISTS `notice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notice` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `status` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '0æœªè¯»1å·²è¯»',
  `title` varchar(64) NOT NULL DEFAULT '',
  `content` text,
  `recipient_uid` text,
  `sender_uid` int(10) unsigned DEFAULT '0' COMMENT 'å‘ä»¶äºº:0ç³»ç»Ÿ!0ç”¨æˆ·',
  `receive_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `send_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `read_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notice`
--

LOCK TABLES `notice` WRITE;
/*!40000 ALTER TABLE `notice` DISABLE KEYS */;
INSERT INTO `notice` VALUES (1,1,'aaaa','acontent','2,3,4',0,'2017-02-19 13:25:38','2017-02-19 13:25:38','2017-03-07 16:44:48'),(2,1,'bb','bcontent','3,4,5',0,'2017-02-19 13:33:32','2017-02-19 13:33:32','2017-03-07 16:37:13'),(3,1,'新任务已发布','系统中有一个新发布的任务(170209589c2cf9ecc40)，请尽快处理！','2',2,'2017-02-19 14:36:03','2017-02-19 08:36:03','2017-02-20 18:31:03'),(4,1,'新任务已发布','系统中有一个新发布的任务(17022158abbe406e49e)，请尽快处理！','',2,'2017-02-21 11:13:03','2017-02-21 05:13:03','2017-03-07 16:42:39'),(5,0,'任务已验收','任务(17022158abbe406e49e)已验收，请注意查看！','',2,'2017-02-21 11:16:23','2017-02-21 05:16:22','2017-02-21 11:16:23'),(6,0,'任务撤销','任务(1702045895803cc65af)已被撤销，请注意查看！','',2,'2017-03-03 16:46:30','2017-03-03 16:46:30','2017-03-03 16:46:30'),(7,0,'任务撤销','任务(1702045895803cc65af)已被撤销，请注意查看！','',2,'2017-03-03 16:47:01','2017-03-03 16:47:01','2017-03-03 16:47:01'),(8,0,'新任务已发布','系统中有一个新发布的任务(1703050001)，请尽快处理！','',2,'2017-03-05 12:56:36','2017-03-05 12:56:35','2017-03-05 12:56:36'),(9,0,'新任务已发布','系统中有一个新发布的任务(17030400005)，请尽快处理！','1,2,',2,'2017-03-08 10:11:23','2017-03-08 10:11:23','2017-03-08 10:11:23');
/*!40000 ALTER TABLE `notice` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `posts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(40) NOT NULL COMMENT 'å²—ä½åç§°',
  `department_id` int(10) unsigned NOT NULL COMMENT '部门编号',
  `company_id` int(10) unsigned NOT NULL DEFAULT '0',
  `status` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'çŠ¶æ€:0æ­£å¸¸1ä½œåºŸ',
  `create_author_uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'åˆ›å»ºè€…ç”¨æˆ·ç¼–å· ',
  `update_author_uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'ä¿®æ”¹è€…ç”¨æˆ·ç¼–å· ',
  `create_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'åˆ›å»ºæ—¶é—´',
  `update_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'ä¿®æ”¹æ—¶é—´',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='å²—ä½è¡¨';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `posts`
--

LOCK TABLES `posts` WRITE;
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;
INSERT INTO `posts` VALUES (3,'市场专员',17,11,0,0,0,'2016-12-19 14:08:36','2016-12-19 14:08:36'),(4,'会计',3,7,0,0,2,'2016-12-19 14:09:07','2017-01-15 04:51:51'),(5,'CFO',3,7,0,0,2,'2016-12-19 16:42:00','2017-01-15 04:51:40'),(7,'审计',3,7,0,2,2,'2017-01-17 09:55:58','2017-01-17 09:55:58'),(8,'出纳',23,7,0,2,2,'2017-01-17 09:59:06','2017-01-17 09:59:56');
/*!40000 ALTER TABLE `posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product`
--

DROP TABLE IF EXISTS `product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(20) NOT NULL,
  `company_id` int(10) unsigned NOT NULL DEFAULT '0',
  `first_category_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '产品一级分类',
  `second_category_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '产品二级分类',
  `number` char(20) NOT NULL COMMENT 'ç¼–å·',
  `description` text COMMENT 'è¯´æ˜Ž',
  `enable` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT 'çŠ¶æ€:0æ­£å¸¸1ä½œåºŸ',
  `create_author_uid` int(10) unsigned NOT NULL,
  `update_author_uid` int(10) unsigned DEFAULT NULL,
  `create_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='äº§å“è¡¨';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product`
--

LOCK TABLES `product` WRITE;
/*!40000 ALTER TABLE `product` DISABLE KEYS */;
INSERT INTO `product` VALUES (1,'产品二',11,3,4,'A0002','<p>aaa</p><p>ccc</p>',0,0,2,2,'2017-01-09 04:06:41','2017-03-07 14:40:03'),(2,'产品一',11,1,2,'A0001','',0,0,2,2,'2017-01-09 04:18:03','2017-01-09 05:39:57'),(3,'美女一枚',11,3,4,'A00011','哈哈qq',1,0,2,2,'2017-01-09 05:42:51','2017-01-23 10:15:45'),(4,'攻瑰花',11,3,4,'a0003','AAA',0,0,2,2,'2017-01-22 09:37:08','2017-01-22 09:39:14'),(5,'testEditor',11,1,2,'00023','<p>rowone</p><p>rowtwo</p><p>rowthree</p>',0,0,2,2,'2017-03-07 14:40:44','2017-03-07 15:22:51');
/*!40000 ALTER TABLE `product` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_category`
--

DROP TABLE IF EXISTS `product_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(20) DEFAULT NULL,
  `superior_id` int(10) unsigned NOT NULL COMMENT 'ä¸Šçº§åˆ†ç±»ç¼–å·',
  `company_id` int(10) unsigned NOT NULL DEFAULT '0',
  `avisible` int(11) NOT NULL DEFAULT '0' COMMENT '位运算计算是否选中状态',
  `status` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT 'çŠ¶æ€:0æ­£å¸¸1ä½œåºŸ',
  `create_author_uid` int(10) unsigned NOT NULL COMMENT 'åˆ›å»ºäººç”¨æˆ·ç¼–å· ',
  `update_author_uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'ä¿®æ”¹äººç”¨æˆ·ç¼–å·',
  `create_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'ä¿®æ”¹æ—¶é—´',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='äº§å“åˆ†ç±»è¡¨';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_category`
--

LOCK TABLES `product_category` WRITE;
/*!40000 ALTER TABLE `product_category` DISABLE KEYS */;
INSERT INTO `product_category` VALUES (1,'一级分类1',0,11,13,0,2,2,'2017-01-06 10:02:45','2017-02-27 15:49:36'),(2,'一级分类子类',1,11,11,0,2,2,'2017-01-06 10:21:31','2017-01-06 10:23:37'),(3,'一级分类二',0,11,9,0,2,2,'2017-01-06 10:24:30','2017-01-06 14:39:17'),(4,'一级分类二下的分类',3,11,12,0,2,2,'2017-01-07 08:51:08','2017-01-09 05:38:04');
/*!40000 ALTER TABLE `product_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_execute_price`
--

DROP TABLE IF EXISTS `product_execute_price`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_execute_price` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int(10) unsigned NOT NULL,
  `company_id` int(10) unsigned NOT NULL DEFAULT '0',
  `money_id` int(11) NOT NULL DEFAULT '0',
  `price` decimal(12,2) NOT NULL DEFAULT '0.00',
  `create_author_uid` int(10) unsigned NOT NULL DEFAULT '0',
  `update_author_uid` int(10) unsigned NOT NULL DEFAULT '0',
  `create_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 COMMENT='äº§å“æ‰§è¡Œä»·æ ¼è¡¨';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_execute_price`
--

LOCK TABLES `product_execute_price` WRITE;
/*!40000 ALTER TABLE `product_execute_price` DISABLE KEYS */;
INSERT INTO `product_execute_price` VALUES (21,1,7,2,0.96,2,2,'2017-02-21 05:09:53','2017-02-21 05:09:53'),(19,3,11,2,66.00,2,2,'2017-02-08 09:23:35','2017-02-08 09:23:35'),(18,3,17,2,33.00,2,2,'2017-02-08 09:23:35','2017-02-08 09:23:35'),(22,1,11,2,1.30,2,2,'2017-02-21 05:09:53','2017-02-21 05:09:53');
/*!40000 ALTER TABLE `product_execute_price` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_purchase_price`
--

DROP TABLE IF EXISTS `product_purchase_price`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_purchase_price` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int(10) unsigned NOT NULL,
  `money_id` int(10) unsigned NOT NULL DEFAULT '0',
  `a_grade_price` decimal(12,2) NOT NULL DEFAULT '0.00',
  `b_grade_price` decimal(12,2) NOT NULL DEFAULT '0.00',
  `c_grade_price` decimal(12,2) NOT NULL DEFAULT '0.00',
  `d_grade_price` decimal(12,2) NOT NULL DEFAULT '0.00',
  `create_author_uid` int(10) unsigned NOT NULL,
  `update_author_uid` int(10) unsigned NOT NULL,
  `create_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=48 DEFAULT CHARSET=utf8 COMMENT='äº§å“è´­ä¹°ä»·æ ¼è¡¨';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_purchase_price`
--

LOCK TABLES `product_purchase_price` WRITE;
/*!40000 ALTER TABLE `product_purchase_price` DISABLE KEYS */;
INSERT INTO `product_purchase_price` VALUES (45,3,2,24.00,25.00,26.00,27.00,2,2,'2017-02-08 09:23:35','2017-02-08 09:23:35'),(44,3,1,22.22,23.22,24.22,25.22,2,2,'2017-02-08 09:23:35','2017-02-08 09:23:35'),(47,1,1,0.53,0.36,0.22,0.36,2,2,'2017-02-21 05:09:53','2017-02-21 05:09:53');
/*!40000 ALTER TABLE `product_purchase_price` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `root_category`
--

DROP TABLE IF EXISTS `root_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `root_category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int(10) unsigned NOT NULL DEFAULT '0',
  `name` char(20) NOT NULL,
  `visible` int(11) NOT NULL DEFAULT '0' COMMENT '位运算记录选中状态值',
  `create_author_uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'åˆ›å»ºäººç”¨æˆ·ç¼–å·',
  `update_author_uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'ä¿®æ”¹äººç”¨æˆ·ç¼–å·',
  `create_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'åˆ›å»ºæ—¶é—´',
  `update_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'ä¿®æ”¹æ—¶é—´',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='æ ¹åˆ†ç±»è¡¨';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `root_category`
--

LOCK TABLES `root_category` WRITE;
/*!40000 ALTER TABLE `root_category` DISABLE KEYS */;
INSERT INTO `root_category` VALUES (1,11,'一个根分类',13,2,2,'2017-01-06 06:38:08','2017-02-27 15:23:02');
/*!40000 ALTER TABLE `root_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `serial_number`
--

DROP TABLE IF EXISTS `serial_number`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `serial_number` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `number` int(10) unsigned NOT NULL DEFAULT '0',
  `type` varchar(64) NOT NULL DEFAULT '',
  `create_at` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `serial_number`
--

LOCK TABLES `serial_number` WRITE;
/*!40000 ALTER TABLE `serial_number` DISABLE KEYS */;
INSERT INTO `serial_number` VALUES (1,1,'task',1488783639),(2,2,'statement',1488617763);
/*!40000 ALTER TABLE `serial_number` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `statement`
--

DROP TABLE IF EXISTS `statement`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `statement` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `statement_no` varchar(64) NOT NULL DEFAULT '',
  `company_id` int(10) unsigned NOT NULL DEFAULT '0',
  `first_subject_id` int(10) unsigned NOT NULL DEFAULT '0',
  `second_subject_id` int(10) unsigned NOT NULL DEFAULT '0',
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `associate_id` int(10) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `direction` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '记账方向',
  `money_id` int(10) unsigned NOT NULL DEFAULT '0',
  `amount` decimal(12,2) NOT NULL DEFAULT '0.00',
  `accounting_date` date DEFAULT NULL,
  `remark` text,
  `create_author_uid` int(10) unsigned NOT NULL DEFAULT '0',
  `update_author_uid` int(10) unsigned NOT NULL DEFAULT '0',
  `create_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `statement`
--

LOCK TABLES `statement` WRITE;
/*!40000 ALTER TABLE `statement` DISABLE KEYS */;
INSERT INTO `statement` VALUES (1,'',11,1,2,2,5,0,2,2,0.55,'2017-02-24','aaaaREMARK',2,2,'2017-02-23 09:37:50','2017-02-24 04:47:30'),(2,'17030400002',11,1,2,1,6,2,1,1,200.00,'2017-03-04','aaaa',2,2,'2017-03-04 00:00:00','2017-03-04 00:00:00');
/*!40000 ALTER TABLE `statement` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `task`
--

DROP TABLE IF EXISTS `task`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `task` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `number` varchar(64) NOT NULL DEFAULT '',
  `name` char(40) NOT NULL DEFAULT '',
  `company_id` int(10) unsigned NOT NULL DEFAULT '0',
  `execute_company_id` int(10) unsigned NOT NULL DEFAULT '0',
  `execute_type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '1:一次性,2:重复',
  `fee_settlement` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '1:全包,2:独立',
  `customer_category` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '1外部客户，2集团公司',
  `customer_grate` tinyint(3) unsigned DEFAULT '0' COMMENT '客户级别：1A2B3C4D',
  `company_customer_id` int(10) unsigned NOT NULL DEFAULT '0',
  `product_id` int(10) unsigned NOT NULL DEFAULT '0',
  `requirement` text NOT NULL COMMENT '任务要求',
  `attachment` varchar(64) NOT NULL DEFAULT '',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '0正常，1作废，2待发布，3待接收，4处理中，5待验收，6结算中，7已完成，8撤销，9无法执行',
  `superior_task_id` int(10) unsigned NOT NULL DEFAULT '0',
  `create_author_uid` int(10) unsigned NOT NULL DEFAULT '0',
  `update_author_uid` int(10) unsigned NOT NULL DEFAULT '0',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `task`
--

LOCK TABLES `task` WRITE;
/*!40000 ALTER TABLE `task` DISABLE KEYS */;
INSERT INTO `task` VALUES (1,'','adafsdf',11,11,1,1,1,2,2,3,'fadfad','',1,0,2,2,1486026232,1486026232),(2,'1702025892f60e8366a','asdfadsf',11,11,1,1,1,2,2,3,'sdfdsfd','',0,0,2,2,1486026254,1488523700),(3,'1702025892fcfdb57e2','dfdsf',11,11,1,1,1,2,2,3,'dddd','',0,0,2,2,1486028029,1488532832),(4,'1702025892fd4f8c076','ffff',11,11,1,1,1,2,2,3,'dddd','',0,0,2,2,1486028111,1488533337),(5,'1702025892fdba897a3','bbbb',11,11,1,1,1,2,2,3,'dddfa','',6,0,2,2,1486028218,1488534292),(6,'1702025892fee786566','fdffff',11,11,1,1,1,2,2,3,'ddfd','OA最新开发时间表.zip',7,0,2,2,1486028519,1486028519),(7,'17020358942f05e6765','ji001',11,11,2,2,2,2,2,3,'sdfsdfd','OA最新开发时间表.zip',9,0,2,2,1486106373,1486106373),(8,'170203589433dcbdc0e','发布任务一',11,11,1,2,2,3,3,3,'大工苦 ','',1,0,2,2,1486107612,1486611633),(9,'1702045895803cc65af','task_one',11,11,2,2,2,2,2,3,'wwwwwwww','alipaytranspay.zip',8,0,2,2,1486192700,1486612613),(10,'17020458958dca7dce4','task_two',11,11,1,2,2,3,3,3,'ddddddd','',1,0,2,2,1486196170,1486287877),(11,'170208589a988336631','task_testfile',11,11,1,1,1,2,2,3,'ddddd','589a988333cba1946.zip',5,0,2,2,1486526595,1487048146),(12,'170209589c2b5656636','子任务一',11,6,2,2,2,2,2,3,'有根有据sfad ','589c2b56585aa9621.zip',1,2,2,2,1486629718,1486978858),(13,'170209589c2be5d6a57','子任务二',11,11,1,1,1,3,3,3,'dddddd','589c2be5d71713934.zip',5,2,2,2,1486629861,1487048366),(14,'170209589c2cf9ecc40','子任务三',11,6,1,1,1,2,2,3,'aaaaa','589c2cf9ed8682709.zip',3,2,2,2,1486630137,1487489763),(15,'170209589c2d33a9706','子任务五',11,6,1,1,1,2,2,3,'aaaaaa','589c2d33a9eb62082.zip',2,2,2,2,1486630195,1486630195),(16,'170209589c2d593cc4c','ã6666666',11,6,1,1,1,3,3,3,'dddddd','589c2d593d5194194.zip',2,2,2,2,1486630233,1486630233),(17,'170211589ec47e76350','test_product_catego',11,6,1,1,1,3,3,1,'dddddd','',2,0,2,2,1486799998,1486799998),(18,'170211589ec542dbbcd','dddddadfadf',11,6,1,1,1,2,2,2,'dfdfdsf','',2,0,2,2,1486800194,1486800194),(19,'17022158abbe406e49e','yyuiui',11,11,1,1,2,2,2,1,'eeerrrrr','',6,0,2,2,1487650368,1487650582),(20,'17030400001','TEST00001',11,0,1,1,1,2,2,4,'DDDDD','',2,0,2,2,1488615105,1488615105),(21,'17030400002','TEST00002',11,0,1,1,1,2,2,2,'DDD','',2,0,2,2,1488615347,1488615347),(22,'17030400003','test00003',11,0,1,1,1,2,2,2,'asdfdf','',2,0,2,2,1488615584,1488615584),(23,'17030400000','test00004',11,0,1,1,1,2,2,2,'aaaa','',2,0,2,2,1488615908,1488615908),(24,'17030400005','test00005',11,0,1,1,1,3,3,1,'aasdfasdf','',3,0,2,2,1488616081,1488942683),(25,'1703050001','test0001',11,0,2,1,1,2,2,3,'aaaa','',3,0,2,2,1488693360,1488693395),(26,'1703050002','test0002',11,0,1,1,1,2,2,4,'aaad','',2,0,2,2,1488693473,1488693473),(27,'1703060001','test_task1',11,0,1,1,1,2,2,4,'adfdf','',2,0,2,2,1488783639,1488783639);
/*!40000 ALTER TABLE `task` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `task_collection_info`
--

DROP TABLE IF EXISTS `task_collection_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `task_collection_info` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `task_id` int(10) unsigned NOT NULL,
  `company_id` int(10) unsigned NOT NULL DEFAULT '0',
  `receipt_no` varchar(64) DEFAULT NULL COMMENT 'æ”¶æ¬¾å•ç¼–å·',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT ' æ”¶æ¬¾æ–¹å¼',
  `company_customer_id` int(10) unsigned NOT NULL DEFAULT '0',
  `customer_category` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `create_author_uid` int(10) unsigned NOT NULL,
  `update_author_uid` int(10) unsigned NOT NULL,
  `create_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `remark` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='æ”¶æ¬¾ä¿¡æ¯';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `task_collection_info`
--

LOCK TABLES `task_collection_info` WRITE;
/*!40000 ALTER TABLE `task_collection_info` DISABLE KEYS */;
INSERT INTO `task_collection_info` VALUES (1,19,11,'148765058258abbf1707a6e',2,2,2,2,2,2,'2017-02-21 05:16:22','2017-02-21 09:39:01','aaattttt6666666');
/*!40000 ALTER TABLE `task_collection_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `task_deal_price`
--

DROP TABLE IF EXISTS `task_deal_price`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `task_deal_price` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `task_id` int(10) unsigned NOT NULL DEFAULT '0',
  `product_id` int(10) unsigned NOT NULL DEFAULT '0',
  `money_id` int(10) unsigned NOT NULL DEFAULT '0',
  `price` decimal(12,2) NOT NULL DEFAULT '0.00',
  `purchase_price` decimal(12,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=37 DEFAULT CHARSET=utf8 COMMENT='ä»»åŠ¡æˆäº¤ä»·æ ¼è¡¨';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `task_deal_price`
--

LOCK TABLES `task_deal_price` WRITE;
/*!40000 ALTER TABLE `task_deal_price` DISABLE KEYS */;
INSERT INTO `task_deal_price` VALUES (1,1,3,1,23.33,0.00),(2,1,3,2,25.16,0.00),(3,2,3,1,23.30,0.00),(4,2,3,2,25.19,0.00),(5,3,3,1,23.36,0.00),(6,3,3,2,25.16,0.00),(7,4,3,1,23.29,0.00),(8,4,3,2,25.15,0.00),(9,5,3,1,23.36,0.00),(10,5,3,2,25.13,0.00),(11,6,3,1,23.35,0.00),(12,6,3,2,25.15,0.00),(13,7,3,1,23.36,0.00),(14,7,3,2,25.24,0.00),(15,8,3,1,24.36,0.00),(16,8,3,2,26.16,0.00),(17,9,3,1,23.36,0.00),(18,9,3,2,25.18,0.00),(19,10,3,1,24.65,24.22),(20,10,3,2,26.67,26.00),(21,11,3,1,23.22,23.22),(22,11,3,2,25.00,25.00),(23,12,3,2,25.59,25.00),(24,12,3,1,24.25,23.22),(25,13,3,2,26.00,26.00),(26,13,3,1,24.68,24.22),(27,14,3,2,25.25,25.00),(28,14,3,1,23.52,23.22),(29,15,3,2,26.21,25.00),(30,15,3,1,24.27,23.22),(31,16,3,2,26.17,26.00),(32,16,3,1,24.42,24.22),(33,19,1,1,0.36,0.36),(34,24,1,1,0.22,0.22),(35,25,3,2,25.00,25.00),(36,25,3,1,23.22,23.22);
/*!40000 ALTER TABLE `task_deal_price` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `task_execute_info`
--

DROP TABLE IF EXISTS `task_execute_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `task_execute_info` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int(10) unsigned NOT NULL DEFAULT '0',
  `task_id` int(10) unsigned NOT NULL DEFAULT '0',
  `money_id` int(10) unsigned NOT NULL DEFAULT '0',
  `price` decimal(12,2) NOT NULL DEFAULT '0.00',
  `finish_time` varchar(64) NOT NULL DEFAULT '',
  `create_author_uid` int(10) unsigned NOT NULL DEFAULT '0',
  `update_author_uid` int(10) unsigned NOT NULL DEFAULT '0',
  `create_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `task_execute_info`
--

LOCK TABLES `task_execute_info` WRITE;
/*!40000 ALTER TABLE `task_execute_info` DISABLE KEYS */;
INSERT INTO `task_execute_info` VALUES (1,11,9,2,66.00,'2017-02-22',2,2,'2017-02-08 10:26:45','2017-02-08 10:26:45'),(2,11,2,2,66.00,'2017-02-23',2,2,'2017-02-09 05:04:49','2017-02-09 05:04:49'),(3,11,11,2,66.00,'2017-02-20',2,2,'2017-02-14 05:48:59','2017-02-14 05:48:59'),(4,11,13,2,66.00,'2017-02-28',2,2,'2017-02-14 05:52:49','2017-02-14 05:52:49'),(5,11,19,2,0.96,'2017-02-28',2,2,'2017-02-21 05:14:50','2017-02-21 05:14:50');
/*!40000 ALTER TABLE `task_execute_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `task_feedback`
--

DROP TABLE IF EXISTS `task_feedback`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `task_feedback` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `task_id` int(10) unsigned NOT NULL,
  `content` text,
  `attachment` varchar(64) DEFAULT NULL,
  `create_author_uid` int(11) NOT NULL,
  `create_time` int(10) unsigned NOT NULL DEFAULT '0',
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(2) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=utf8 COMMENT='ä»»åŠ¡åé¦ˆè¡¨ ';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `task_feedback`
--

LOCK TABLES `task_feedback` WRITE;
/*!40000 ALTER TABLE `task_feedback` DISABLE KEYS */;
INSERT INTO `task_feedback` VALUES (1,10,'ddddsdds','',2,1486287877,1,0),(2,8,'aaaaa','',2,1486611633,1,0),(3,3,'提交验收说明','',2,1486612508,0,0),(4,9,'无法执行说明反馈','alipaytranspay.zip',2,1486612613,5,0),(5,12,'言  ','589c2b56585aa9621.zip',2,1486978858,1,0),(6,2,'22222222','',2,1487043603,0,0),(7,2,'222ttttt','',2,1487043811,0,1),(8,2,'s s sssssss','',2,1487046980,0,0),(9,2,'aaa','',2,1487047090,0,0),(10,2,'vvvvv','',2,1487047756,0,1),(11,2,'www','',2,1487047981,0,0),(12,11,'qqqww','589a988333cba1946.zip',2,1487048146,0,0),(13,13,'13','589c2be5d71713934.zip',2,1487048366,0,0),(14,2,'uuuu','',2,1487068122,3,0),(15,3,'iiii','',2,1487068525,3,0),(16,19,'aaaaa','',2,1487650533,0,0),(17,19,'ok','',2,1487650582,3,0),(18,2,'人月金人','',2,1488522991,0,0),(19,2,'工aaaa','',2,1488523017,0,0),(20,2,'wwww','',2,1488523700,0,1),(21,2,'test1','58b934e3b42187383.zip',2,1488532707,0,0),(22,3,'test2','58b935607fbd05545.zip',2,1488532832,0,0),(23,4,'test4','58b937597596f3808.zip',2,1488533337,0,0),(24,5,'test5','58b939692e5342265.zip',2,1488533865,0,0),(25,5,'test55','',2,1488534045,0,0),(26,5,'test555','',2,1488534272,0,0),(27,5,'test5555','58b93b14bc8407500.zip',2,1488534292,0,0),(28,9,'test9','alipaytranspay.zip',2,1488534390,0,0),(29,9,'test999','58b93b95929013333.zip',2,1488534421,0,0);
/*!40000 ALTER TABLE `task_feedback` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `task_pay_info`
--

DROP TABLE IF EXISTS `task_pay_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `task_pay_info` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `task_id` int(10) unsigned NOT NULL,
  `pay_company_id` int(10) unsigned NOT NULL DEFAULT '0',
  `execute_company_id` int(10) unsigned NOT NULL DEFAULT '0',
  `pay_bill_no` varchar(64) NOT NULL COMMENT 'æ”¶æ¬¾å•ç¼–å·',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '付款方式',
  `create_author_uid` int(10) unsigned NOT NULL,
  `update_author_uid` int(10) unsigned NOT NULL,
  `create_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='ä»˜æ¬¾ä¿¡æ¯';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `task_pay_info`
--

LOCK TABLES `task_pay_info` WRITE;
/*!40000 ALTER TABLE `task_pay_info` DISABLE KEYS */;
INSERT INTO `task_pay_info` VALUES (1,2,11,11,'58a2dbda0b9689490',1,1,2,2,'2017-02-14 11:28:42','2017-02-14 11:28:42'),(2,3,11,11,'58a2dd6db8cba8224',0,1,2,2,'2017-02-14 11:35:25','2017-02-14 11:35:25'),(3,19,11,7,'58abbf17087df6480',2,0,2,2,'2017-02-21 05:16:22','2017-02-21 05:16:22');
/*!40000 ALTER TABLE `task_pay_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `task_remark`
--

DROP TABLE IF EXISTS `task_remark`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `task_remark` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `task_id` int(10) unsigned NOT NULL,
  `content` text,
  `create_author_uid` int(10) unsigned NOT NULL DEFAULT '0',
  `update_author_uid` int(10) unsigned NOT NULL DEFAULT '0',
  `create_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='ä»»åŠ¡åé¦ˆè¡¨ ';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `task_remark`
--

LOCK TABLES `task_remark` WRITE;
/*!40000 ALTER TABLE `task_remark` DISABLE KEYS */;
INSERT INTO `task_remark` VALUES (1,2,'aaa',2,2,'2017-02-14 14:43:58','2017-02-14 14:54:42',0,0);
/*!40000 ALTER TABLE `task_remark` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `account` char(20) NOT NULL DEFAULT '' COMMENT '用户名',
  `nickname` varchar(64) NOT NULL DEFAULT '' COMMENT '用户昵称',
  `email` varchar(64) NOT NULL DEFAULT '',
  `password` varchar(64) NOT NULL DEFAULT '',
  `auth_key` varchar(64) DEFAULT NULL,
  `company_id` int(10) unsigned DEFAULT '0',
  `department_id` int(10) unsigned NOT NULL DEFAULT '0',
  `posts_id` int(10) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(4) unsigned NOT NULL DEFAULT '0',
  `login_permission` int(10) unsigned NOT NULL DEFAULT '1' COMMENT '登录许可：1禁止0允许',
  `create_author_uid` int(10) unsigned NOT NULL DEFAULT '0',
  `update_author_uid` int(10) unsigned NOT NULL DEFAULT '0',
  `create_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `account` (`account`) USING HASH
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COMMENT='ç”¨æˆ·è¡¨';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'YunShu','','','$2y$13$3SohGTDn.lb62kXAMDPrnut53n7GRsX/4dBfw955QxR5qZ4d2YmkS',NULL,11,17,3,0,1,0,2,'2016-12-19 17:03:03','2016-12-19 17:03:03'),(2,'zhaosi','','zhaosi2017@gmail.com','$2y$13$SiAq7VDnU5o97dyxCKGck.3.mZj2Qlb0ew3ww8s5BZQpnaHOFgi0m','k1W3x1H6il6Vp2jVWDA91xuzCcQAf0v8',11,17,3,0,0,0,0,'2016-12-21 19:08:14','2017-02-15 04:40:21'),(3,'wangwu','','zhaosi2016@gmail.com','$2y$13$mG7Ftue17/VCvA53WRYW2eNqVdelf0iJiXVVOfagFUoB0Za4RjZc6','BSYqJ9qi7BdE8ORyo9vsDbgX0bkOsjTL',7,3,4,0,0,0,2,'2016-12-21 19:09:06','2017-01-16 05:54:56'),(4,'aaaa','','','','jpY9bqRl3MNdAi09h1LbH7hrWXZ6Uh0O',0,17,3,0,1,2,2,'2017-01-16 10:37:49','2017-01-16 10:37:49'),(5,'张茜','','','','ONn-xiYGCdhv_6B5nzqu1FzSFbO-f7pJ',7,3,4,0,1,2,2,'2017-01-17 08:32:27','2017-01-17 08:33:57'),(6,'zhangsan','','','','21lkydPXuKcOB4DXyKXwn40Lm964bhY9',7,3,4,0,1,2,2,'2017-01-17 08:49:46','2017-03-05 15:28:48'),(7,'accountOne','','','','40wiS8fUGn0cctlj81LXiinTV3vreNju',7,3,4,0,1,2,2,'2017-01-17 08:58:36','2017-01-17 08:58:36'),(8,'accountTwo','','','','SiQEuFLptu3G53VwFfFbv739bHkeUOat',7,3,4,0,1,2,2,'2017-01-17 09:04:33','2017-01-17 09:04:33'),(9,'accountThr','','','','fFZaGakYHtr4lHChyn6_4scSfnenSBrU',7,3,4,0,1,2,2,'2017-01-17 09:05:50','2017-01-17 09:05:50'),(10,'Id_one','','','','FPJ_3ln2m6JEidsEFlywyw0KH0hY0vV2',11,17,3,0,1,2,2,'2017-01-17 09:24:16','2017-01-17 09:31:12'),(11,'ID_two','','','$2y$13$d/yQ861vyV1qBNNGmdqbl.lvBOxHqavDzsRoyvmB7URaZeYlqRy6q','k9ssfV2NWpl1LdG6vIsBVaSJhGO7i5gd',7,3,4,0,0,2,2,'2017-01-17 09:35:04','2017-03-05 15:21:30'),(12,'idone','','','','2oBwhReUCbSsTge__dIxs-RQb5KJ6D61',7,3,4,0,1,2,2,'2017-01-17 09:36:16','2017-01-17 09:36:16'),(13,'idtwo','','','','8gVc7fEeBlfQLmbR469vc2uWlYWaphAz',7,3,4,0,1,2,2,'2017-01-17 09:37:29','2017-01-17 09:37:29'),(14,'idthree','','','','243X4UHHACwuahQaCjkjyIw0jFsI4Qok',7,3,5,0,1,2,2,'2017-01-17 09:37:50','2017-01-17 09:37:50'),(15,'oaAdmin','','','$2y$13$pbKdFbJdaz4I7Dzg9p50ruTC1RTS8AW5Mtip4srMVCyFVUogikOS.','V5Y4Mtyvo8cuQQ4ekLY8fxye2plydLkH',0,0,0,0,0,2,2,'2017-01-25 11:05:35','2017-03-08 10:51:32');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-03-09 10:19:09
