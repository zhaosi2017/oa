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
INSERT INTO `auth_assignment` VALUES ('3','1',1482239356),('3','2',NULL),('4','10',1484641456),('4','12',1484642176),('4','13',1484642249);
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
INSERT INTO `auth_item` VALUES ('3',1,'',NULL,NULL,1482239356,1482239356),('4',1,'',NULL,NULL,1484641456,1484641456),('5',1,'',NULL,NULL,1484713296,1484713296),('7',1,'',NULL,NULL,1484643358,1484643358),('8',1,'',NULL,NULL,1484712363,1484712363),('customer/customer/create',2,'permission: customer/customer/create',NULL,NULL,1484747548,1484747548),('customer/customer/index',2,'permission: customer/customer/index',NULL,NULL,1484747330,1484747330),('customer/group/rate',2,'permission: customer/group/rate',NULL,NULL,1484747024,1484747024),('user/company/index',2,'permission: user/company/index',NULL,NULL,1484730609,1484730609),('user/company/switch',2,'permission: user/company/switch',NULL,NULL,1484748149,1484748149),('user/department/index',2,'permission: user/department/index',NULL,NULL,1484730609,1484730609),('user/posts/index',2,'permission: user/posts/index',NULL,NULL,1484730609,1484730609),('user/user/create',2,'permission: user/user/create',NULL,NULL,1484747548,1484747548),('user/user/index',2,'permission: user/user/index',NULL,NULL,1484730609,1484730609),('user/user/update',2,'permission: user/user/update',NULL,NULL,1484747631,1484747631);
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
INSERT INTO `auth_item_child` VALUES ('8','customer/customer/create'),('7','customer/customer/index'),('8','customer/customer/index'),('7','customer/group/rate'),('8','customer/group/rate'),('3','user/company/index'),('7','user/company/index'),('8','user/company/index'),('7','user/company/switch'),('8','user/company/switch'),('3','user/department/index'),('8','user/department/index'),('3','user/posts/index'),('7','user/posts/index'),('8','user/user/create'),('3','user/user/index'),('7','user/user/index'),('8','user/user/index'),('8','user/user/update');
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
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `company`
--

LOCK TABLES `company` WRITE;
/*!40000 ALTER TABLE `company` DISABLE KEYS */;
INSERT INTO `company` VALUES (1,0,'3zhong',0,1,0,2,'2017-01-05 15:08:09','2017-01-14 10:09:58'),(2,11,'3总',0,2,0,2,'2017-01-05 15:08:09','2017-01-05 09:54:08'),(3,2,'3总1子1',0,3,0,0,'2017-01-05 15:08:09','2017-01-05 15:08:09'),(4,7,'4zhong1zi',0,3,0,0,'2017-01-05 15:08:09','2017-01-05 15:08:09'),(5,0,'66666666',0,1,0,0,'2017-01-05 15:08:09','2017-01-05 15:08:09'),(6,0,'二总',0,1,0,0,'2017-01-05 15:08:09','2017-01-05 15:08:09'),(7,11,'四总',0,2,0,0,'2017-01-05 15:08:09','2017-01-05 15:08:09'),(8,11,'总三子',0,2,0,0,'2017-01-05 15:08:09','2017-01-05 15:08:09'),(9,11,'总二子',0,2,0,0,'2017-01-05 15:08:09','2017-01-05 15:08:09'),(10,11,'总五子',0,2,0,0,'2017-01-05 15:08:09','2017-01-05 15:08:09'),(11,0,'总公司',0,1,0,2,'2017-01-05 15:08:09','2017-01-14 10:00:34'),(12,13,'总公司111子',0,4,0,0,'2017-01-05 15:08:09','2017-01-05 15:08:09'),(13,14,'总公司11子',0,3,0,0,'2017-01-05 15:08:09','2017-01-05 15:08:09'),(14,11,'总公司1子',0,2,0,0,'2017-01-05 15:08:09','2017-01-05 15:08:09'),(15,11,'总公司2子',0,2,0,0,'2017-01-05 15:08:09','2017-01-05 15:08:09'),(16,11,'总六子',0,2,0,0,'2017-01-05 15:08:09','2017-01-05 15:08:09'),(17,11,'总四子',0,2,0,2,'2017-01-05 15:08:09','2017-01-05 09:57:10'),(18,0,'总集团',0,1,0,0,'2017-01-05 15:08:09','2017-01-05 15:08:09');
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
INSERT INTO `customer` VALUES (1,'客户一',11,1,'工工工工',0,2,2,'2017-01-15 05:25:44','2017-01-18 11:42:47'),(2,'客户二',11,2,'式我',0,2,2,'2017-01-15 05:26:04','2017-01-15 05:28:21'),(3,'客户三',11,3,'',0,2,2,'2017-01-18 11:42:15','2017-01-18 11:42:29');
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
  `superior_subject_id` int(10) unsigned NOT NULL COMMENT 'ä¸Šçº§ç§‘ç›®ç¼–å·',
  `enable` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '0å¯ç”¨1åœç”¨',
  `status` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '0æ­£å¸¸1ä½œåºŸ',
  `create_author_uid` int(11) NOT NULL,
  `update_author_uid` int(11) NOT NULL,
  `create_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='è´¢åŠ¡ç§‘ç›®è¡¨';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `finance_subject`
--

LOCK TABLES `finance_subject` WRITE;
/*!40000 ALTER TABLE `finance_subject` DISABLE KEYS */;
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
  `rater_uid` int(11) NOT NULL COMMENT 'è¯„çº§è€…çš„ç”¨æˆ·ç¼–å·',
  `grade` tinyint(3) unsigned NOT NULL COMMENT 'ç­‰çº§1A2B3C4D',
  `create_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `rate_company_id` int(10) unsigned NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='é›†å›¢å…¬å¸è¯„çº§è¡¨ ';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `group_rate`
--

LOCK TABLES `group_rate` WRITE;
/*!40000 ALTER TABLE `group_rate` DISABLE KEYS */;
INSERT INTO `group_rate` VALUES (2,2,2,'2017-01-18 12:59:59','2017-01-18 12:59:59',11),(1,2,3,'2017-01-18 12:59:59','2017-01-18 12:59:59',11),(3,2,3,'2017-01-18 12:59:59','2017-01-18 12:59:59',11),(4,2,1,'2017-01-18 12:59:59','2017-01-18 12:59:59',11),(5,2,2,'2017-01-18 12:59:59','2017-01-18 12:59:59',11);
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
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `login_logs`
--

LOCK TABLES `login_logs` WRITE;
/*!40000 ALTER TABLE `login_logs` DISABLE KEYS */;
INSERT INTO `login_logs` VALUES (1,6,1,'2016-12-06 17:37:14','0'),(2,0,4,'2016-12-23 15:30:17','::1'),(3,0,4,'2016-12-23 15:31:37','::1'),(4,2,2,'2016-12-23 15:31:44','::1'),(5,2,1,'2016-12-23 15:41:24','::1'),(6,2,3,'2016-12-23 15:59:30','::1'),(7,2,3,'2016-12-23 16:02:03','::1'),(8,2,1,'2016-12-23 16:02:59','::1'),(9,0,4,'2016-12-24 09:31:35','::1'),(10,0,4,'2016-12-24 09:31:54','::1'),(11,2,2,'2016-12-24 13:49:07','::1'),(12,2,1,'2016-12-24 13:49:34','::1'),(13,2,3,'2016-12-24 13:52:49','::1'),(14,2,1,'2016-12-24 13:53:20','::1'),(15,2,1,'2016-12-24 13:55:03','::1'),(16,2,1,'2017-01-19 06:10:57','::1'),(17,2,1,'2017-01-19 06:18:43','::1');
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
  `content` text,
  `recipient_uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'æ”¶ä»¶äººçš„ç”¨æˆ·ç¼–å·',
  `sender_uid` int(10) unsigned DEFAULT '0' COMMENT 'å‘ä»¶äºº:0ç³»ç»Ÿ!0ç”¨æˆ·',
  `recive_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'æŽ¥æ”¶æ—¶é—´',
  `send_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notice`
--

LOCK TABLES `notice` WRITE;
/*!40000 ALTER TABLE `notice` DISABLE KEYS */;
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
  `second_category_id` int(10) unsigned NOT NULL COMMENT 'äºŒçº§åˆ†ç±»ç¼–å·',
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
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='äº§å“è¡¨';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product`
--

LOCK TABLES `product` WRITE;
/*!40000 ALTER TABLE `product` DISABLE KEYS */;
INSERT INTO `product` VALUES (1,'产品二',11,4,'A0002','aaaaa',0,0,2,2,'2017-01-09 04:06:41','2017-01-09 05:01:02'),(2,'产品一',11,2,'A0001','',0,0,2,2,'2017-01-09 04:18:03','2017-01-09 05:39:57'),(3,'美女一枚',11,4,'A00011','哈哈',1,0,2,2,'2017-01-09 05:42:51','2017-01-09 08:34:44');
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
INSERT INTO `product_category` VALUES (1,'一级分类',0,11,13,0,2,2,'2017-01-06 10:02:45','2017-01-06 10:20:07'),(2,'一级分类子类',1,11,11,0,2,2,'2017-01-06 10:21:31','2017-01-06 10:23:37'),(3,'一级分类二',0,11,9,0,2,2,'2017-01-06 10:24:30','2017-01-06 14:39:17'),(4,'一级分类二下的分类',3,11,12,0,2,2,'2017-01-07 08:51:08','2017-01-09 05:38:04');
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
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='äº§å“æ‰§è¡Œä»·æ ¼è¡¨';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_execute_price`
--

LOCK TABLES `product_execute_price` WRITE;
/*!40000 ALTER TABLE `product_execute_price` DISABLE KEYS */;
INSERT INTO `product_execute_price` VALUES (7,3,17,2,200.00,2,2,'2017-01-14 04:40:42','2017-01-14 04:40:42'),(6,3,11,2,2.22,2,2,'2017-01-14 04:40:42','2017-01-14 04:40:42');
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
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COMMENT='äº§å“è´­ä¹°ä»·æ ¼è¡¨';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_purchase_price`
--

LOCK TABLES `product_purchase_price` WRITE;
/*!40000 ALTER TABLE `product_purchase_price` DISABLE KEYS */;
INSERT INTO `product_purchase_price` VALUES (13,3,2,24.00,24.00,24.00,24.00,2,2,'2017-01-14 04:40:42','2017-01-14 04:40:42'),(12,3,1,22.22,22.22,22.22,2.22,2,2,'2017-01-14 04:40:42','2017-01-14 04:40:42');
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
INSERT INTO `root_category` VALUES (1,11,'一个根分类',13,2,2,'2017-01-06 06:38:08','2017-01-06 07:57:34');
/*!40000 ALTER TABLE `root_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `task`
--

DROP TABLE IF EXISTS `task`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `task` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(40) NOT NULL,
  `execute_type` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT 'æ‰§è¡Œæ–¹å¼:1ä¸€æ¬¡æ€§2é‡å¤ ',
  `fee_settlement` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT 'è´¹ç”¨ç»“ç®—:1å…¨åŒ…2ç‹¬ç«‹',
  `customer_category` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT 'å®¢æˆ·ç±»åˆ«:1å¤–éƒ¨å®¢æˆ·2é›†å›¢å…¬å¸',
  `customer_grate` tinyint(2) unsigned DEFAULT '0' COMMENT 'å®¢æˆ·çº§åˆ«1A2B3C4D',
  `company_cuntomer_name` char(40) NOT NULL COMMENT 'é›†å›¢æˆ–å¤–éƒ¨å®¢æˆ·åç§°',
  `product_id` int(10) unsigned NOT NULL,
  `requirement` text NOT NULL COMMENT 'ä»»åŠ¡è¦æ±‚',
  `attachment` varchar(64) DEFAULT NULL,
  `status` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '0å¾…å‘å¸ƒ1å¾…æŽ¥æ”¶2å¤„ç†ä¸­3å¾…éªŒæ”¶4ç»“ç®—ä¸­5å·²å®Œæˆ6ä»»åŠ¡æ’¤é”€7æ— æ³•æ‰§è¡Œ8å·²ä½œåºŸ',
  `superior_task_id` int(10) unsigned NOT NULL,
  `create_author_uid` int(11) NOT NULL,
  `update_author_uid` int(11) NOT NULL,
  `create_time` int(10) unsigned NOT NULL DEFAULT '0',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `task`
--

LOCK TABLES `task` WRITE;
/*!40000 ALTER TABLE `task` DISABLE KEYS */;
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
  `receipt_no` varchar(64) DEFAULT NULL COMMENT 'æ”¶æ¬¾å•ç¼–å·',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT ' æ”¶æ¬¾æ–¹å¼',
  `company_customer_name` char(40) NOT NULL COMMENT 'é›†å›¢å…¬å¸æˆ–å¤–éƒ¨å®¢æˆ·åç§°',
  `create_author_uid` int(10) unsigned NOT NULL,
  `update_author_uid` int(10) unsigned NOT NULL,
  `create_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='æ”¶æ¬¾ä¿¡æ¯';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `task_collection_info`
--

LOCK TABLES `task_collection_info` WRITE;
/*!40000 ALTER TABLE `task_collection_info` DISABLE KEYS */;
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
  `task_id` int(10) unsigned NOT NULL,
  `money_name` char(20) NOT NULL COMMENT 'è´§å¸åç§° ',
  `price` decimal(12,2) NOT NULL DEFAULT '0.00' COMMENT 'æˆäº¤ä»·æ ¼',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='ä»»åŠ¡æˆäº¤ä»·æ ¼è¡¨';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `task_deal_price`
--

LOCK TABLES `task_deal_price` WRITE;
/*!40000 ALTER TABLE `task_deal_price` DISABLE KEYS */;
/*!40000 ALTER TABLE `task_deal_price` ENABLE KEYS */;
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
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '1æ‰§è¡Œåé¦ˆ2ä½œåºŸè¯´æ˜Ž3éªŒæ”¶ä¸é€šè¿‡è¯´æ˜Ž4ç»“ç®—è¯´æ˜Ž5å·²å®Œæˆè¯´æ˜Ž6æ— æ³•æ‰§è¡Œè¯´æ˜Ž7ä»»åŠ¡æ’¤é”€è¯´æ˜Ž',
  `status` tinyint(2) unsigned DEFAULT '0' COMMENT '0æ­£å¸¸1ä½œåºŸ',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='ä»»åŠ¡åé¦ˆè¡¨ ';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `task_feedback`
--

LOCK TABLES `task_feedback` WRITE;
/*!40000 ALTER TABLE `task_feedback` DISABLE KEYS */;
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
  `pay_bill_no` varchar(64) NOT NULL COMMENT 'æ”¶æ¬¾å•ç¼–å·',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `company_customer_name` char(40) NOT NULL COMMENT 'é›†å›¢å…¬å¸æˆ–å¤–éƒ¨å®¢æˆ·åç§°',
  `create_author_uid` int(10) unsigned NOT NULL,
  `update_author_uid` int(10) unsigned NOT NULL,
  `create_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='ä»˜æ¬¾ä¿¡æ¯';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `task_pay_info`
--

LOCK TABLES `task_pay_info` WRITE;
/*!40000 ALTER TABLE `task_pay_info` DISABLE KEYS */;
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
  `create_author_uid` int(11) NOT NULL,
  `create_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '1æ‰§è¡Œåé¦ˆ2ä½œåºŸè¯´æ˜Ž3éªŒæ”¶ä¸é€šè¿‡è¯´æ˜Ž4ç»“ç®—è¯´æ˜Ž5å·²å®Œæˆè¯´æ˜Ž6æ— æ³•æ‰§è¡Œè¯´æ˜Ž7ä»»åŠ¡æ’¤é”€è¯´æ˜Ž',
  `status` tinyint(2) unsigned DEFAULT '0' COMMENT '0æ­£å¸¸1ä½œåºŸ',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='ä»»åŠ¡åé¦ˆè¡¨ ';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `task_remark`
--

LOCK TABLES `task_remark` WRITE;
/*!40000 ALTER TABLE `task_remark` DISABLE KEYS */;
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
  `department_id` int(10) unsigned NOT NULL,
  `posts_id` int(10) unsigned NOT NULL,
  `status` tinyint(4) unsigned NOT NULL DEFAULT '0',
  `login_permission` int(10) unsigned NOT NULL DEFAULT '1' COMMENT '登录许可：1禁止0允许',
  `create_author_uid` int(10) unsigned NOT NULL DEFAULT '0',
  `update_author_uid` int(10) unsigned NOT NULL DEFAULT '0',
  `create_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `account` (`account`) USING HASH
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COMMENT='ç”¨æˆ·è¡¨';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'YunShu','','','$2y$13$3SohGTDn.lb62kXAMDPrnut53n7GRsX/4dBfw955QxR5qZ4d2YmkS',NULL,11,17,3,0,1,0,2,'2016-12-19 17:03:03','2016-12-19 17:03:03'),(2,'zhaosi','','zhaosi2017@gmail.com','$2y$13$HLiF1WVwqXPucSUT7dGO4.4vhTCnq5x5u2TwiNn2LKS0yKdqHv73W','k1W3x1H6il6Vp2jVWDA91xuzCcQAf0v8',11,17,3,0,0,0,0,'2016-12-21 19:08:14','2016-12-21 19:08:14'),(3,'wangwu','','zhaosi2016@gmail.com','$2y$13$mG7Ftue17/VCvA53WRYW2eNqVdelf0iJiXVVOfagFUoB0Za4RjZc6','BSYqJ9qi7BdE8ORyo9vsDbgX0bkOsjTL',7,3,4,0,0,0,2,'2016-12-21 19:09:06','2017-01-16 05:54:56'),(4,'aaaa','','','','jpY9bqRl3MNdAi09h1LbH7hrWXZ6Uh0O',0,17,3,0,1,2,2,'2017-01-16 10:37:49','2017-01-16 10:37:49'),(5,'张茜','','','','ONn-xiYGCdhv_6B5nzqu1FzSFbO-f7pJ',7,3,4,0,1,2,2,'2017-01-17 08:32:27','2017-01-17 08:33:57'),(6,'zhangsan','','','','21lkydPXuKcOB4DXyKXwn40Lm964bhY9',7,3,4,0,1,2,2,'2017-01-17 08:49:46','2017-01-17 08:49:46'),(7,'accountOne','','','','40wiS8fUGn0cctlj81LXiinTV3vreNju',7,3,4,0,1,2,2,'2017-01-17 08:58:36','2017-01-17 08:58:36'),(8,'accountTwo','','','','SiQEuFLptu3G53VwFfFbv739bHkeUOat',7,3,4,0,1,2,2,'2017-01-17 09:04:33','2017-01-17 09:04:33'),(9,'accountThr','','','','fFZaGakYHtr4lHChyn6_4scSfnenSBrU',7,3,4,0,1,2,2,'2017-01-17 09:05:50','2017-01-17 09:05:50'),(10,'Id_one','','','','FPJ_3ln2m6JEidsEFlywyw0KH0hY0vV2',11,17,3,0,1,2,2,'2017-01-17 09:24:16','2017-01-17 09:31:12'),(11,'ID_two','','','','k9ssfV2NWpl1LdG6vIsBVaSJhGO7i5gd',7,3,4,0,1,2,2,'2017-01-17 09:35:04','2017-01-17 09:35:04'),(12,'idone','','','','2oBwhReUCbSsTge__dIxs-RQb5KJ6D61',7,3,4,0,1,2,2,'2017-01-17 09:36:16','2017-01-17 09:36:16'),(13,'idtwo','','','','8gVc7fEeBlfQLmbR469vc2uWlYWaphAz',7,3,4,0,1,2,2,'2017-01-17 09:37:29','2017-01-17 09:37:29'),(14,'idthree','','','','243X4UHHACwuahQaCjkjyIw0jFsI4Qok',7,3,5,0,1,2,2,'2017-01-17 09:37:50','2017-01-17 09:37:50');
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

-- Dump completed on 2017-01-19 12:48:06
