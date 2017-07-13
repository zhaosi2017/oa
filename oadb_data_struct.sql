-- MySQL dump 10.13  Distrib 5.7.16, for osx10.12 (x86_64)
--
-- Host: localhost    Database: oadb
-- ------------------------------------------------------
-- Server version	5.7.16

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
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
INSERT INTO `auth_assignment` VALUES ('15','27',1490513306),('16','29',1490857727),('16','30',1490858359),('16','31',1490858782),('16','32',1490932516),('17','28',1490603225);
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
INSERT INTO `auth_item` VALUES ('15',1,'岗位编号-15',NULL,NULL,1490513291,1490513291),('16',1,'岗位编号-16',NULL,NULL,1490519995,1490519995),('17',1,'岗位编号-17',NULL,NULL,1490603208,1490603208),('customer/customer/index',2,'permission: customer/customer/index',NULL,NULL,1490513444,1490513444),('customer/group/rate',2,'permission: customer/group/rate',NULL,NULL,1490513444,1490513444),('finance/finance/summary',2,'permission: finance/finance/summary',NULL,NULL,1490513444,1490513444),('finance/payment/index',2,'permission: finance/payment/index',NULL,NULL,1490513444,1490513444),('finance/receipt/index',2,'permission: finance/receipt/index',NULL,NULL,1490513444,1490513444),('finance/statement/index',2,'permission: finance/statement/index',NULL,NULL,1490513444,1490513444),('product/category/root-set',2,'permission: product/category/root-set',NULL,NULL,1490513444,1490513444),('product/product-category/index',2,'permission: product/product-category/index',NULL,NULL,1490513444,1490513444),('product/product/index',2,'permission: product/product/index',NULL,NULL,1490513444,1490513444),('system/customer/index',2,'permission: system/customer/index',NULL,NULL,1490513444,1490513444),('system/finance-subject/index',2,'permission: system/finance-subject/index',NULL,NULL,1490513444,1490513444),('system/finance/summary',2,'permission: system/finance/summary',NULL,NULL,1490513444,1490513444),('system/group/rate',2,'permission: system/group/rate',NULL,NULL,1490513444,1490513444),('system/login/ip-lock',2,'permission: system/login/ip-lock',NULL,NULL,1490513444,1490513444),('system/login/record',2,'permission: system/login/record',NULL,NULL,1490513444,1490513444),('system/money/index',2,'permission: system/money/index',NULL,NULL,1490513444,1490513444),('system/notice/index',2,'permission: system/notice/index',NULL,NULL,1490513444,1490513444),('system/payment/index',2,'permission: system/payment/index',NULL,NULL,1490513444,1490513444),('system/product-category/index',2,'permission: system/product-category/index',NULL,NULL,1490513444,1490513444),('system/product/index',2,'permission: system/product/index',NULL,NULL,1490513444,1490513444),('system/receipt/index',2,'permission: system/receipt/index',NULL,NULL,1490513444,1490513444),('system/root-category/index',2,'permission: system/root-category/index',NULL,NULL,1490513444,1490513444),('system/statement/index',2,'permission: system/statement/index',NULL,NULL,1490513444,1490513444),('system/task/index',2,'permission: system/task/index',NULL,NULL,1490513444,1490513444),('task/task/received-index',2,'permission: task/task/received-index',NULL,NULL,1490513444,1490513444),('task/task/sent-index',2,'permission: task/task/sent-index',NULL,NULL,1490513444,1490513444),('task/task/wait-index',2,'permission: task/task/wait-index',NULL,NULL,1490513444,1490513444),('user/company/index',2,'permission: user/company/index',NULL,NULL,1490513444,1490513444),('user/department/index',2,'permission: user/department/index',NULL,NULL,1490513444,1490513444),('user/posts/index',2,'permission: user/posts/index',NULL,NULL,1490513444,1490513444),('user/user/index',2,'permission: user/user/index',NULL,NULL,1490513444,1490513444);
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
INSERT INTO `auth_item_child` VALUES ('15','customer/customer/index'),('15','customer/group/rate'),('15','finance/finance/summary'),('15','finance/payment/index'),('15','finance/receipt/index'),('15','finance/statement/index'),('15','product/category/root-set'),('15','product/product-category/index'),('15','product/product/index'),('15','system/customer/index'),('15','system/finance-subject/index'),('15','system/finance/summary'),('15','system/group/rate'),('15','system/login/ip-lock'),('15','system/login/record'),('15','system/money/index'),('15','system/notice/index'),('15','system/payment/index'),('15','system/product-category/index'),('15','system/product/index'),('15','system/receipt/index'),('15','system/root-category/index'),('15','system/statement/index'),('15','system/task/index'),('15','task/task/received-index'),('17','task/task/received-index'),('15','task/task/sent-index'),('17','task/task/sent-index'),('15','task/task/wait-index'),('17','task/task/wait-index'),('15','user/company/index'),('15','user/department/index'),('15','user/posts/index'),('15','user/user/index');
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
  `name` longtext COLLATE utf8_bin,
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT 'çŠ¶æ€:0æ­£å¸¸,1ä½œåºŸ ',
  `level` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT 'å±‚çº§ ',
  `create_author_uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'åˆ›å»ºäººç”¨æˆ·ç¼–å·',
  `update_author_uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'ä¿®æ”¹äººç”¨æˆ·ç¼–å·',
  `create_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'åˆ›å»ºæ—¶é—´',
  `update_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'ä¿®æ”¹æ—¶é—´',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `company`
--

LOCK TABLES `company` WRITE;
/*!40000 ALTER TABLE `company` DISABLE KEYS */;
INSERT INTO `company` VALUES (12,0,'aaPJ4sEL/Pt8Uvr3d69bYWFiZTJjMGE4ZmQxZjNmMzk0MzFhZTgzODgxMWQzODJjYWJkZTEwMjYxNzQ0NTgxYzcwMWMyNDcwNTcwNTAzOTPGBOshcXkdxUYtXdwmBSliR1ONom1dz67Euck8BrKPMg==',0,1,1,1,'2017-03-26 14:27:36','2017-03-26 14:27:36'),(13,12,'ACAT1qUGeYdlM1wPBsQJdDQyNDYwY2Y0NTgyNjE1Y2IwZjljZTE3ZDViMmNhYzAwZmFkZGZmNmM0ZWYyYTA4NjFjOGM1MGNjMjIyYjkyOTJYFb0MJTJhk79vtQQS2kQ/dC59MBSB5ljtsfIeTJZ1Ww==',0,2,27,27,'2017-03-26 14:33:47','2017-03-26 15:51:59'),(14,12,'YGb2lrp4Uoi9hm8s3NTs8Tg3NDcxZDdiZWExYThlYmU4YzM5MmI5NzEyOGJjMTBjN2QzYzYzZjQ3MzcyOTFhNzZhNzgwZWMzMTEwNTM4ZGHnmJZf2lLhPvGgg0P8QKasCXelrxdSxZyXjjMhnz4P6A==',0,1,27,27,'2017-03-26 14:33:53','2017-03-26 14:33:53'),(15,12,'Dmbvv00oL5v4YJFJfN4yljQ3OWRlMDc0MWY0NGJlNzFjOWY2MGE1M2I0NWJhMTk4NzBkZDc2ZjQ2Mjk2OGJhYjljNzFmZGViMmI3ZmY3NjMaCzYORIn+ZagXMUugQY4nA+mJOS1wP32Cxch1du4KkQ==',0,1,27,27,'2017-03-26 14:33:59','2017-03-26 14:33:59');
/*!40000 ALTER TABLE `company` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customer`
--

DROP TABLE IF EXISTS `customer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customer` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` longtext,
  `company_id` int(10) unsigned NOT NULL DEFAULT '0',
  `grade` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT 'çº§åˆ«:1A2B3C4D',
  `remarks` longtext,
  `status` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '0æ­£å¸¸1ä½œåºŸ',
  `create_author_uid` int(10) unsigned NOT NULL DEFAULT '0',
  `update_author_uid` int(10) unsigned NOT NULL DEFAULT '0',
  `create_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='å®¢æˆ·è¡¨';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customer`
--

LOCK TABLES `customer` WRITE;
/*!40000 ALTER TABLE `customer` DISABLE KEYS */;
INSERT INTO `customer` VALUES (6,'pKMXEkiY/J99M7MhuOYzAWYwYzFmMmFhYzgwZTE3MDE0MzMzMzFmODlmNWI3ZDZlY2E1ZDc1N2ExZTM1OTAzNDU0MTUzZjM5MGFkMTU2MWby9leLRQf0TT+uKmD24rayhbzvVcllGejoRsPseQ+39g==',12,3,'rhsaqto6WlLbsu2b5wX4FzExYTZiYWVhYzg2YjU1NWMxNzQxNjhiMmI4YzE1MTA4MDI0ZTcwMTA2NDUxN2JhNGFjMjFhNTE0MzI0MTMyNTJTAECeyFMWPvUoJHHzCr9MKWXKrRDvsyDp2k+AbOVbFw==',0,27,27,'2017-03-27 14:27:50','2017-03-27 14:28:09'),(7,'F6WVgyWLGGTDI0kzt/WlYzZiMjQ1ZTI5NDUyZDljYzk1MzA3NDRlMDNlNDg5YzY5NWFmMmQ1NmY3MTAyYzBmOGI3YzMzZmFmYTE1M2U5ZjPdZmyvYh90AMoYj9mvX3w0GgiIq3LTs8/iq+9QmXAGYA==',12,2,'bXyBDcCESP6bCDnN075z7TM3MmRlMzcxNmYwNmFkNTdkNDA2ODVlODI0ZTA4ZjQ0NzM4NzNkMTRkODU3NDcwYTFjNWE2NjJmYjU0YTg0YWRerWN1gU8bbXciO3iqbqBBcgWLaTsAVDInZQF6ejyzDQ==',0,27,27,'2017-03-27 14:28:01','2017-03-27 14:28:06');
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
  `name` longtext,
  `company_id` int(10) unsigned NOT NULL DEFAULT '0',
  `superior_department_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上级部门编号',
  `status` tinyint(11) unsigned NOT NULL DEFAULT '0' COMMENT 'çŠ¶æ€:0æ­£å¸¸1ä½œåºŸ',
  `create_author_uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'åˆ›å»ºäººç”¨æˆ·ç¼–å· ',
  `update_author_uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'ä¿®æ”¹äººç”¨æˆ·ç¼–å·',
  `create_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'åˆ›å»ºæ—¶é—´',
  `update_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'ä¿®æ”¹æ—¶é—´',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 COMMENT='éƒ¨é—¨è¡¨';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `department`
--

LOCK TABLES `department` WRITE;
/*!40000 ALTER TABLE `department` DISABLE KEYS */;
INSERT INTO `department` VALUES (18,'PGHGR4No1/5HkflQK0EMXzM2ZDllMjhhODY1ZmI4YzI5ZDBkOWM1MGZjNzFmYzJjYmZjOGQzM2I3ZmY3YTEwYzQ4ZmE2NjZlNzgyYTVlMjZG2QTJhLzZkUicATfvXxTGqj6HQfejyQZTGwFfIpV7KA==',12,0,0,1,1,'2017-03-26 14:27:55','2017-03-26 14:27:55'),(19,'IwL76qtBAbX77sT5Qc99YTQ2ODA0MWU4Mzg0NjFiOTk4ZDM0NTQ5MTVjMzZmNWQxNmYwYjMwM2U5OWNiOGRiZmE4NzA3Y2RiYWQzYzRiMDmQk84aTpJmpcaKoq23FmnQb2ouP6afKEShvl9cqRkPeQ==',12,0,0,27,27,'2017-03-26 15:31:33','2017-03-26 15:31:33'),(20,'tXglirByu+Ec7J3yRBKjqWEwNWFiZDhkNjM2Y2NlYjU5ODUzMjA4ZjIzZmY2NzVlMTc0YWJiY2JjMzYwZTQxYTdmZmE3NjI0NzQzZWJlNTjIBMITPK7nIk3KBNMcAUZhw6f7uzdEPoexaSFb3bcOaA==',13,0,0,27,27,'2017-03-26 16:20:28','2017-03-26 16:20:28'),(21,'GA1J6HcoS0/pM4GQ7Du7UDkzNzAxZTJmY2Q5YmFmYmU3NWRjMjliMGU4M2M3ZWNiMGZhZWZjOTBmZGVmMDU3N2ZhYjdjYzE5NzgxYTY0OTDNTIHhQSb/JU504t2E6A6gh/IJBi9a++MkISbhUmE8TQ==',13,20,0,27,27,'2017-03-27 14:26:57','2017-03-27 14:26:57'),(22,'FsttJrUtZS0/N9IDEsyHW2U5YTQ0ZjQ0MzhlYjQyMzA4OGI4ZWIzNWIyYTY1ZjdhNWFjZTViMzQyMDQyOThiMmUxM2RmMDg2NTdmZjlhM2YaL88lPNEcQt839a0E9txXgDdCYdxMpQpHQEG2DqLrMA==',14,0,0,27,27,'2017-03-27 15:26:21','2017-03-27 15:26:21');
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
  `subject_name` longtext,
  `superior_subject_id` int(10) unsigned NOT NULL DEFAULT '0',
  `enable` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '0å¯ç”¨1åœç”¨',
  `status` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '0æ­£å¸¸1ä½œåºŸ',
  `create_author_uid` int(11) NOT NULL,
  `update_author_uid` int(11) NOT NULL,
  `create_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='è´¢åŠ¡ç§‘ç›®è¡¨';
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
INSERT INTO `group_rate` VALUES (12,12,27,2,'2017-03-27 11:32:08','2017-03-27 11:32:08'),(13,12,27,3,'2017-03-27 11:32:08','2017-03-27 11:32:08'),(14,12,27,2,'2017-03-27 11:32:08','2017-03-27 11:32:08'),(15,12,27,3,'2017-03-27 11:32:08','2017-03-27 11:32:08');
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
) ENGINE=MyISAM AUTO_INCREMENT=113 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `login_logs`
--

LOCK TABLES `login_logs` WRITE;
/*!40000 ALTER TABLE `login_logs` DISABLE KEYS */;
INSERT INTO `login_logs` VALUES (77,1,0,'2017-03-26 14:27:13','::1','2017-03-26 14:27:13',0),(78,27,0,'2017-03-26 14:29:13','::1','2017-03-26 14:29:13',0),(79,1,0,'2017-03-26 14:30:13','::1','2017-03-26 14:30:13',0),(80,27,0,'2017-03-26 14:31:19','::1','2017-03-26 14:31:19',0),(81,28,0,'2017-03-27 15:28:06','::1','2017-03-27 15:28:06',0),(82,1,0,'2017-03-30 14:07:41','::1','2017-03-30 14:07:41',0),(83,32,0,'2017-03-31 10:58:51','::1','2017-03-31 10:58:51',0),(84,1,2,'2017-03-31 11:07:29','::1','2017-03-31 11:07:30',0),(85,1,0,'2017-03-31 11:07:50','::1','2017-03-31 11:07:50',0),(86,32,0,'2017-03-31 11:28:38','::1','2017-03-31 11:28:38',0),(87,32,2,'2017-03-31 11:30:47','::1','2017-03-31 11:30:48',0),(88,32,0,'2017-03-31 11:30:59','::1','2017-03-31 11:30:59',0),(89,32,0,'2017-03-31 11:39:39','::1','2017-03-31 11:39:39',0),(90,32,0,'2017-03-31 14:37:48','::1','2017-03-31 14:37:48',0),(91,27,0,'2017-03-31 15:25:57','::1','2017-03-31 15:25:57',0),(92,27,0,'2017-04-01 13:40:27','::1','2017-04-01 13:40:27',0),(93,27,0,'2017-04-05 19:29:40','::1','2017-04-05 19:29:41',0),(94,27,0,'2017-04-10 15:38:27','::1','2017-04-10 15:38:27',0),(95,27,0,'2017-04-10 21:01:55','::1','2017-04-10 21:01:55',0),(96,1,2,'2017-04-11 19:21:47','::1','2017-04-11 19:21:48',0),(97,1,0,'2017-04-11 19:23:04','::1','2017-04-11 19:23:04',0),(98,1,0,'2017-04-11 19:24:28','::1','2017-04-11 19:24:28',0),(99,1,2,'2017-04-13 16:04:52','::1','2017-04-13 16:04:52',0),(100,1,2,'2017-04-13 16:05:02','::1','2017-04-13 16:05:02',0),(101,1,0,'2017-04-13 16:05:16','::1','2017-04-13 16:05:16',0),(102,27,2,'2017-04-17 19:16:09','::1','2017-04-17 19:16:09',0),(103,27,0,'2017-04-17 19:16:27','::1','2017-04-17 19:16:27',0),(104,27,0,'2017-04-21 10:32:57','::1','2017-04-21 10:32:57',0),(105,0,4,'2017-07-12 11:03:02','::1','2017-07-12 11:03:02',0),(106,0,4,'2017-07-12 11:03:17','::1','2017-07-12 11:03:17',0),(107,0,4,'2017-07-12 11:05:19','::1','2017-07-12 11:05:19',0),(108,1,2,'2017-07-12 11:20:48','::1','2017-07-12 11:20:49',0),(109,1,0,'2017-07-12 11:21:03','::1','2017-07-12 11:21:03',0),(110,1,0,'2017-07-12 11:23:31','::1','2017-07-12 11:23:31',0),(111,32,0,'2017-07-12 11:36:47','::1','2017-07-12 11:36:47',0),(112,1,0,'2017-07-13 10:11:28','::1','2017-07-13 10:11:28',0);
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
  `name` longtext,
  `enable` tinyint(2) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(2) unsigned DEFAULT '0',
  `create_author_uid` int(10) unsigned NOT NULL DEFAULT '0',
  `update_author_uid` int(11) NOT NULL DEFAULT '0',
  `create_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `money`
--

LOCK TABLES `money` WRITE;
/*!40000 ALTER TABLE `money` DISABLE KEYS */;
INSERT INTO `money` VALUES (10,'oeVRmzEiFXV17mQEVywelTFkYzM1YzU2ODhjOTVlN2Y0Y2VjZGU0ODc4MTFmZDE1YTk0NzY3NWVmMzhiZTI0NzIxOWIzM2Y0MTJiMTE0NDlH76sAKoPL+rNkBEuo3u+Ipy699GqAga+5nWkuG9zu3A==',0,0,27,27,'2017-03-26 14:31:41','2017-03-26 14:31:41'),(11,'OBR6vz6DcXK2bgPcPgGLdTJjYWI3NzYyMDRlNmI3NGI2OTI3MWM3YjA2M2MwYTc4Y2I0MzI0MTAxMmUyM2YzNWJhOWJmNTQ0YTg3MWUwN2VrkLXIDdqQy1ILuvStKQc+dEGsupd2xlkuWm1/67Er3A==',0,0,27,27,'2017-03-26 14:31:54','2017-03-26 14:31:54');
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
  `title` longtext,
  `content` longtext,
  `recipient_uid` text,
  `sender_uid` int(10) unsigned DEFAULT '0' COMMENT 'å‘ä»¶äºº:0ç³»ç»Ÿ!0ç”¨æˆ·',
  `receive_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `send_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `read_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=42 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notice`
--

LOCK TABLES `notice` WRITE;
/*!40000 ALTER TABLE `notice` DISABLE KEYS */;
INSERT INTO `notice` VALUES (29,0,'ZogwnFiwqqnAlqlB8edAMzkyNzY0NjBhYmQ5ZGUwMDhjMjA2Y2FmOGE0Njg1NGJhZTkzNjBjYWYzMTgxYTM4NGI1ZjgyMDFhZmJiNDg3M2aHQX7Oqf4S+/BoxIZG4LSfGtPtTGhLfO1njgrZ1+68hYL0J6I2Q3RRzjcMq4EePZw=','z19J2wSdUkxS1+Ux3F0v2jg4NzM5Mzk1Njg5NTFmMzdjNTRhN2Q5ZTg0NmJmYzQ5YzdmN2ZjZWEyZDRjOWY3ZGZiODUwZGU0NTRmMmZmZDBP7bQacK6sKMfU4zL33bowk9x9A4V4CJRnuNaoKqWd+m1xB+DyzcjOFxLfhx1tUDzfD9h3BKYqQ4dYlZdWhHAwdxBDEwZevq0SJ5OkU/+39y6sz/QvijqUc5wPfOimN7c=','',27,'2017-03-27 15:29:18','2017-03-27 15:29:18','2017-03-27 15:29:18'),(30,1,'LKN6deK48C0e+xhaEKBvWmRjZTcwZDk3MjMwZDJhNjQwNGE2NTBlNzE1ZTliNzcwMjJjYWI0YzZiNzBkZjA1MTQ2YWI0M2QzZTk0YjBiNDYufSVKDKKtrc6bSb9UYP0waHHGfv/2RKOn3smmMVSuOd+pMYxRsWJ4CGd4Xw+11RU=','9fEr1rGvzc91V31uOKLIizZiMzllYWY2MDE4MzQ0YmU2NzgzOTY2NjViZTJmZjgzN2NiYzE0YmMwMjgxM2U1NDk0MWQyNzIzOGZiMzVkZGIsiTiOyOC+ARW+RqIvmg6mwdkMbfcl5LnrtY0zQMR4vr9IGF0a3iYbdtEjaBxkKVT7ig89B+K4d+6YXAb5v6P/9W0kse+uoSA4PV+s4Y4UirktChAeeoNsGSLjaKiOXoI=','28,',27,'2017-03-27 15:31:07','2017-03-27 15:31:14','2017-03-27 15:31:14'),(31,1,'B7GDZOSMJgVN7IMLVGPgMDk2ZTYxOTg3OGYxYWI4ZjA4OGU4NzA4MTA2N2Q0NWQ1YjVmZTE0NGVkYjJlMTMxNTdiMTY5YTdlYzAzYzhiNjS7oSYf/5PLETr14GkTF3vUJn4pI2E2aQz1DKekazYRiw==','7XgZkTYaeDtGrA4oS2xqwjVlY2UzOTk1YjlhNmRjNzE2ZjNmZDQyZDU1NmZhZGEzMDdmY2M2M2E1ODZlNjVmZmRiMjI3OTAzMmRhNzM0MDCREG9XxYJI+RGZN+iaaI0CPM7EMjS+AdzYbZOQC0/dVsmDponSArcQavwWOGcwsX9v7k95/G5RCgavkanYX/2kxJHbbgnDY1Ys/2LafmjPGg==','27,',28,'2017-03-27 15:32:21','2017-03-27 15:32:21','2017-03-27 16:23:36'),(32,0,'eJToGzlBI80eFdfFPsKdCmM3NjViNjY1NWU0YjI0ZmQzODY4MjJhZWY0MmNmODgxYmFjNzNhNGZmOTY5NmNkZDdjNWI2NTE3M2U1Mjg2NGHOWtP09yCZsiOKag0tFNGGZs8VSD1xXoaDxQRq982Zlg==','oL4b38djU1rYcKUlvzeZfWU1Y2ViZDk1NzhkM2Q4ZTgxM2M0NWI5MWQyZTA0MDc0MzVjMGM3MDFmNWUyMTZlZTU5ODQ4ODdmNTc4NTFmNDJVcSvaarDeYmy4vZXfRxA/rggNbGyjs105HjLgMy1NtA==','',28,'2017-03-27 15:33:17','2017-03-27 15:33:17','2017-03-27 15:33:17'),(33,1,'Lz9k0xUeLH1m6QNIOu6bFTQ4OTQ4ZWJjY2U3YmE5YTk5OWRiNDllNDcwMDZjNzcwODE1MDQ3Zjg1YjI1NzFmOGNjNTM5NWJmNTVmYjcwZmQxlyGgRaTw+vLoFztv6F4/LhjzEe1VL/1SNDlW7WPmfg==','AQrb25MRBqZw8J7tU6r1TGY0MTQ0ZTg2MjY1ZTA5YjgyYzQwNmJjNzY1ZGY1NDFhNDY2NmU4NWYzMWRjZmY5ZmU1NWEyMjZmOTA1OGExOGI/CSc6Mrno6xaIuBkOAoRIg2739vNOnOiB6eOrhNZlWZZYn0IVd7B23lMcLdN7WN6QmnA89pcafUI5GxSe5vdF1va4CwkQjtCEjXb4H0wqoA==','27,',28,'2017-03-27 15:44:58','2017-03-27 15:44:58','2017-03-27 16:23:36'),(34,0,'F8chw3UB7xMl4WrVth7JGTI4YzE0NWY2MzYzOGUxZTg4NDU1NmVkNzhkY2ZkNGJkNGI0NjhiMTAxM2ZkNzI5YmU1MDVkNzZkZWUzZDU1M2OkdTjKsTXb8z4lCwJVhmv2iuviihn+PkyXkii5oSn2OQPLCL7wyVE/moeBCMlkQ5c=','qEEbvBnB8A1FhsJlMEpkumY3NDBiZTllYWMyYTlmNGUyYmYzMThiOTYxYTk3YmE3NTVmY2MxZGEwMmY5MWYyYWJmZGU4M2VkY2MxYmJhZjnAfrKChbXKQDR+QIAlGpfXpSNWjOUusFxnJAWmzFvf/xDvetdMCJpeyFAFycmLMumKxTfx3IxrNy5/EvQzHySNgeffFCnTwv8695ke0HfoDwMnH29IhPCuN2BUUVbxQxc=','28,',27,'2017-03-27 15:46:26','2017-03-27 15:46:26','2017-03-27 15:46:26'),(35,0,'/k2Cn/9SatZC2Az8XwsrkGJmOGY4ODQ4OGI0OTIwYTMxYzI5YmU4NTEzMGFlMDI5ZjkzMDRlZDYxMzFiYmIxMGQwMjYzODY3N2E1MDM3OGKfUm4V5DiuuPgoGlaenqGwuNL64D8bvrEIjB2oleU3VtUjSLiv16YrBNend4+k0Dw=','LH32pqL/ud31Btj5TLeKN2ZlZGNjZTEwOTI2OWQ5NWRjM2VmYzA1YjA3ODM1NjI5ZTc1ODU4OTliNGQxNDY1YjBiMzI0YWY1NTBkZDllYTe65KonllVuWJtumsUxraaC/JXcB76DEfrGNLktE+f4E6Ku5IrFMKnmxPycS4s016IFtm0lK0l1XuC23AQzue0xdu5XdqKlUswZtdwppt4pe7r/uhcTGzA9ZCkOE7nv+Qs=','28,',27,'2017-03-27 15:54:13','2017-03-27 15:54:13','2017-03-27 15:54:13'),(36,1,'Zfxc+gVxWSj/GS5joMJqS2M5NjQzYmVlZjlhNmUyYzBmMWYzNTE3NTEzYmUxYzA2NTZiYTUxYzJiOTMxM2E2YmIwODFmYTFjNjE5YjdmNWVKBw8D7e/oCfKmpPEIySarauIcxkITamiDmBk5/yia0A==','a7Vn8e3wPNQ6yGmMfR7t9zYxYzhlZDg3NjljYmNkYThjY2VkM2ZmMTZhZWRhOThkZGQ4ZGJiOTMzNjNjZTcwY2I5ZjIxMjBkOGJhYjQwMWPORlL136iC1XikfDFLt45zPJ4G/DhX+WCrwKsj1glrLrIua5q+m2gFE+GqJPlsz3gKRxD4fjnbcNidJUe9PBT2AsYSXo6esJQThMCXEw1UKg==','27,',28,'2017-03-27 15:54:37','2017-03-27 15:54:37','2017-03-27 16:23:36'),(37,1,'MOCOo1uUfN8C/X1bkxImNzdhNmE4NmI2MjJiOGQwZjg0OWNlODUyZTU2OWIzOTNlYjM0YjE4MDEzZGYwYWJjMzE1YjZhNzkxYWRmYzAwOTIyl/TpYC+ysZluN3z0UO8fn3yWFeikuu6iAuYxUFskXg==','3ePi8wa95cPSXD2yCQdHgmViM2Q5YjY4Njc1ZWRkNzJkNTZmNWYwZmVlZGVkMjA0NzhkNjhhYTk2MTAwODdmOGI3ODIyMTUxN2NjM2JjYTPBPaYVewextri7nDT51W2vIGzwcCBlI+Gj+ccOCARmj92/x9zGDlqff6vj320Ne8INFDhFWE4HOTCy9w2lTCAyElxuF9Vgc0351Wl4IzHCEg==','27,',28,'2017-03-27 15:55:34','2017-03-27 15:55:34','2017-03-27 16:23:36'),(38,0,'I8/OLKUc7sFhhbe+azcrDDdlMTA5NGM2OThlZWM1MDZiMmUyNTI4MjkwNDU1ZWRkMmM4OGNlNWFmYzNkYzlhNWEwNzNjZTkxYWM4ODc0Nja3uH4GHHOaHMWXfw4WpjKt+B7QAkYvyk3i4je7dbGNDQ==','hUkM9chGI2cDF9nDp60n9jNlNzQ1YzUxMDk4ZDJiMjJkOTQwODNiOGRjYzUwNmI3N2Q0Zjc5YmVhODRjMTFlYjkyMTgxY2YzODk2YmM5NGRU/1OQpRobrn5IMkEOEmpdEqPhOIAqLgBO2v8RqTH6KjQWVsUuJs1mwV6gksUMWhkVqqBuGypzx6HlDniQjOfh50+K9qx+sqKGE39/y4EFHw==','28,',27,'2017-03-27 15:55:44','2017-03-27 15:55:44','2017-03-27 15:55:44'),(39,0,'/7CzUtv/WRHA+a+Jkk6ejDdmZGVhNDdlNzBiZjhiNDQ2MmNjMWU2YTI2NDY5ZjQ3ZGFkYmI2MTNmN2JmMTgxNmNjNTA4MzNmZWJlNDM5NGHdn0XUakKTN6FbIgw0s5Y9fiojp474uB4z9X139STbTQ==','m82dtNdGohdWE2GU2jkO02VmZGEzOTVhMTgwYTEyMDQzODI5MGYzNDdhNDZjZTExMzY4ODZiODNiOTA1YjVlNzlmOGM4MTZmNTZmNTRlYWV0u4k0gsbggbkMBTg9CxAk7mSYYMAytobXwl6+O867tQ==','',27,'2017-03-27 15:56:36','2017-03-27 15:56:36','2017-03-27 15:56:36'),(40,0,'258rNFvuG4AZ0vLCWlTDumY4ZTE2ZGU4OTk0MWY0YjBjM2NiYzc4Y2U1YWViMmFlNWI2ZjY4NmRiNzRkN2QzMzQ0YzNmMThmZmQ5ZGU0ZjKM3+ugPvaPj0DMrzPjaeESa0/B4BNSc9RSi7TJAeL4nw==','Tq2Wiz3fXnjuoHx5EWyoRGZhMDQyYzM3MThiZjBjMjFlMTcwOWJkNzRlNzI3ODYwMDQ3Mjg5MzllMTEzMDdjZGQ3N2RjOTJiZjU1YmMzNTOWeiLCvuDGlQgin0UZsFjzI8BGcTles+oQUZOExOJR5A==','',27,'2017-03-27 16:04:23','2017-03-27 16:04:23','2017-03-27 16:04:23'),(41,0,'wfPsxxi3YV12D3xxm8UBXDMxZDYzNTdlY2Y3MTRmNTQ5MWFiZTY4MWQxMDhiOTIxYWJmYmVlMDgwNGQ2OGZlNGRhMTk4MDIyMzY0MzNmZWFNFbG4JfYBzys3bEaLDKhu138njfii0PZr1ekO8iNigw==','SZVwIofIaSNwFI4B+IKZJTlkYjQ3NzljMTliZjc3MjIzY2I1MWNjNTY1OGQ0MTQ4MmIzYWZkYmZiMWQwYmEzNWE5M2IwMmY1NzE0ZTEyNjRAV96HZmP6keV51yDZ58Y9XoVZYUBxRFna9m5XCDEcug==','',27,'2017-04-03 12:56:38','2017-04-03 12:56:38','2017-04-03 12:56:38');
/*!40000 ALTER TABLE `notice` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notice_queue_user`
--

DROP TABLE IF EXISTS `notice_queue_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notice_queue_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notice_queue_user`
--

LOCK TABLES `notice_queue_user` WRITE;
/*!40000 ALTER TABLE `notice_queue_user` DISABLE KEYS */;
/*!40000 ALTER TABLE `notice_queue_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `posts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` longtext,
  `department_id` int(10) unsigned NOT NULL COMMENT '部门编号',
  `company_id` int(10) unsigned NOT NULL DEFAULT '0',
  `status` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'çŠ¶æ€:0æ­£å¸¸1ä½œåºŸ',
  `create_author_uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'åˆ›å»ºè€…ç”¨æˆ·ç¼–å· ',
  `update_author_uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'ä¿®æ”¹è€…ç”¨æˆ·ç¼–å· ',
  `create_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'åˆ›å»ºæ—¶é—´',
  `update_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'ä¿®æ”¹æ—¶é—´',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COMMENT='å²—ä½è¡¨';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `posts`
--

LOCK TABLES `posts` WRITE;
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;
INSERT INTO `posts` VALUES (15,'Vc76OZVhhTGCG91nidNH6TE0Y2Y2Njk1NmU0OTZiMWQ4N2VlMjU3MzgwMDQwMDA4Mzk4ZTg1MTBlMmY0NDVlYTZkMTE3M2FlZDA2YzcwMjGra75dQcGuH6YkofJIFpfquKCP46hP9QqSwF5yw1AzhQ==',18,12,0,1,1,'2017-03-26 14:28:11','2017-03-26 14:28:11'),(16,'9hKxBgzzBCtcO3TBSGC43jhmMjQxMGI1NmViMzc5OWRmNDhhMDY2OWJiOGVmZmQ4ZjllNjBmMTAyZTc2OWVkNDEwYzNkNjMxMDY3MDI2OTR6akLeMf9dQbP+THlbkIHxLGtbObYFto3rS/VKDhO62w==',18,12,0,27,27,'2017-03-26 16:19:55','2017-03-26 16:19:55'),(17,'zDk61xr18H1s79BdOkjDTTZlYTk0Yjc4YzY3OTFlOGE3ZjllODdhOTllYTI4YmFlZDU0MWJmZGI2OTM2YjU4ZmIxZjViMzFhZWNhMTQwNmGrxg06J+dAmbQHaXZYXMD7HsC7K2Qy8Cz3J1iHENsOlA==',22,14,0,27,27,'2017-03-27 15:26:48','2017-03-27 15:26:48');
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
  `name` longtext,
  `company_id` int(10) unsigned NOT NULL DEFAULT '0',
  `first_category_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '产品一级分类',
  `second_category_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '产品二级分类',
  `number` char(20) NOT NULL COMMENT 'ç¼–å·',
  `description` longtext,
  `enable` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT 'çŠ¶æ€:0æ­£å¸¸1ä½œåºŸ',
  `create_author_uid` int(10) unsigned NOT NULL,
  `update_author_uid` int(10) unsigned DEFAULT NULL,
  `create_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COMMENT='äº§å“è¡¨';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product`
--

LOCK TABLES `product` WRITE;
/*!40000 ALTER TABLE `product` DISABLE KEYS */;
INSERT INTO `product` VALUES (9,'DnagceNW/3CtY5RM0zuiHDNhNmZkZTU3ZmUzMDQ0YWM3MzYwYTFjYWMzMTIwMjlmODdhNjk4YjA1M2QyMTE3NTQ2Zjc2MGI5OTAwODc2NDXAmEEts9bgno0wDqfEVJ7ungcW0ACoemmqC4IQD3RKVw==',12,12,13,'XX-11','Fp3w6dLi90OpkyAr6T5OPzM3ZDRmNmU3MmVmMTVhMTY4MTBhMjA4ZWM3YjM0YWYzNmZmZTYzNDJhZTg2MGUwMzU4MWY5OTZkMjdhNzE3NWbHIrnGwDATfL3aSFqRE1Io3Rg/Jh3AsNj+4dCo8UNTbw==',0,0,27,27,'2017-03-27 14:50:08','2017-03-27 14:50:08'),(10,'McTa7nzMzsgMsIb34xhb4DNmYmMzNTBhZjA3MzZhM2ExODJjZDRlYzJmYTY1ZTZiYmUxNWI1YjM5M2ZmZTBlMDU0MmIxZjIwNDQzMTJkNGLFje6vT7+W8uFdf1hFyXjQBR+dFFr17KtyodDj5Oa2iw==',12,12,13,'XX-12','BVshwynwODYkuNjrIRYZTzczYTdjOThiZmFhNDEzNmFlMDE3MTdmMDdkZjZmMDNmMDAxMmViYTY1NDczOGYxZDQ3YTBhNmMwZjU0ZjQ3ZDhLHa8eUM30FeHKPoN8P6HeZYHD+HOGTwa5CPG8RgwoNA==',0,0,27,27,'2017-03-27 15:51:42','2017-03-27 15:51:42');
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
  `name` longtext,
  `superior_id` int(10) unsigned NOT NULL COMMENT 'ä¸Šçº§åˆ†ç±»ç¼–å·',
  `company_id` int(10) unsigned NOT NULL DEFAULT '0',
  `avisible` int(11) NOT NULL DEFAULT '0' COMMENT '位运算计算是否选中状态',
  `status` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT 'çŠ¶æ€:0æ­£å¸¸1ä½œåºŸ',
  `create_author_uid` int(10) unsigned NOT NULL COMMENT 'åˆ›å»ºäººç”¨æˆ·ç¼–å· ',
  `update_author_uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'ä¿®æ”¹äººç”¨æˆ·ç¼–å·',
  `create_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'ä¿®æ”¹æ—¶é—´',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COMMENT='äº§å“åˆ†ç±»è¡¨';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_category`
--

LOCK TABLES `product_category` WRITE;
/*!40000 ALTER TABLE `product_category` DISABLE KEYS */;
INSERT INTO `product_category` VALUES (11,'Jwwzcx2pTfGgL+H5wDIiHmY0NmUyNmQ1NTcxYThkNDJiN2IwNjc5OTc4MjE4ZTI3NWIxNjBkYjM5NDI3YTAxMzc3NDQ1OGIzMTI0NzUxMjdIM3F6BbwSsMm1Y1/Ap7p3LAwV1G0uEHhBHaL2GU08vY1dVCO2VB2kloFdK/Oi12Q=',0,12,15,0,27,27,'2017-03-27 14:46:59','2017-03-27 14:46:59'),(12,'cs0DVTw7wke9aPooZS86kDdkNmIwYjViYzhiOTVjMzE2ZTFmNTlmMTVmNTI4MWVjN2M5NDM0NWU4NDJkNWM3MDEwYTBiYjNiM2M4ZDg0NTGPKtlju77gsetGm/HAfDrMnnHJ1Ltf+KXo1G01nF7aV2R0Hxqew75y0Yo1hWI9l8I=',0,12,14,0,27,27,'2017-03-27 14:48:46','2017-03-27 14:48:46'),(13,'8qNUQKPXjWr2T2SHhB1GpGMzMTRjODU1NjRjNzFkNDcxMjdlOWI0YTE5NjU2ZmY5MzA3YjMxMWQ1N2RmZmI4OTE2ZGJiOWJhN2RkZmNlY2Q6aMh7f3tcBBFfzbdVXYhGzk2P2Zb9YxbKjDq+WbUsphzeof3xjBQbPpt8nOqmXIM=',12,12,15,0,27,27,'2017-03-27 14:49:05','2017-03-27 14:49:05');
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
) ENGINE=MyISAM AUTO_INCREMENT=31 DEFAULT CHARSET=utf8 COMMENT='äº§å“æ‰§è¡Œä»·æ ¼è¡¨';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_execute_price`
--

LOCK TABLES `product_execute_price` WRITE;
/*!40000 ALTER TABLE `product_execute_price` DISABLE KEYS */;
INSERT INTO `product_execute_price` VALUES (27,9,15,10,3000.00,27,27,'2017-03-27 15:24:54','2017-03-27 15:24:54'),(28,9,14,10,3000.00,27,27,'2017-03-27 15:24:54','2017-03-27 15:24:54'),(29,9,13,10,3000.00,27,27,'2017-03-27 15:24:54','2017-03-27 15:24:54'),(30,10,14,10,5000.00,27,27,'2017-03-27 15:53:47','2017-03-27 15:53:47');
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
) ENGINE=MyISAM AUTO_INCREMENT=52 DEFAULT CHARSET=utf8 COMMENT='äº§å“è´­ä¹°ä»·æ ¼è¡¨';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_purchase_price`
--

LOCK TABLES `product_purchase_price` WRITE;
/*!40000 ALTER TABLE `product_purchase_price` DISABLE KEYS */;
INSERT INTO `product_purchase_price` VALUES (50,9,10,6000.00,5000.00,4000.00,3000.00,27,27,'2017-03-27 15:24:54','2017-03-27 15:24:54'),(51,10,10,8000.00,6000.00,5000.00,4000.00,27,27,'2017-03-27 15:53:47','2017-03-27 15:53:47');
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
  `name` longtext,
  `visible` int(11) NOT NULL DEFAULT '0' COMMENT '位运算记录选中状态值',
  `create_author_uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'åˆ›å»ºäººç”¨æˆ·ç¼–å·',
  `update_author_uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'ä¿®æ”¹äººç”¨æˆ·ç¼–å·',
  `create_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'åˆ›å»ºæ—¶é—´',
  `update_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'ä¿®æ”¹æ—¶é—´',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='æ ¹åˆ†ç±»è¡¨';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `root_category`
--

LOCK TABLES `root_category` WRITE;
/*!40000 ALTER TABLE `root_category` DISABLE KEYS */;
INSERT INTO `root_category` VALUES (3,12,'NDody5DjWQGPWZPmfWY8zThiMzVlZjkzNjRkMjE2ODZjODEwMmEyNWJiZWE4NmNkYTRjODNhOWQ2N2YwNzdkMTI0MDMzYmUyNGE1OTgxNTcviZEg0Bmk4TvAHqBeSr+Z6tInR7/5ivxXRC3UHb/dww==',15,27,27,'2017-03-27 14:28:45','2017-03-27 14:46:29');
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
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `serial_number`
--

LOCK TABLES `serial_number` WRITE;
/*!40000 ALTER TABLE `serial_number` DISABLE KEYS */;
INSERT INTO `serial_number` VALUES (7,3,'task',1490604850),(8,1,'receipt',1490604944),(9,1,'pay',1490604944);
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
  `remark` longtext,
  `create_author_uid` int(10) unsigned NOT NULL DEFAULT '0',
  `update_author_uid` int(10) unsigned NOT NULL DEFAULT '0',
  `create_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `statement`
--

LOCK TABLES `statement` WRITE;
/*!40000 ALTER TABLE `statement` DISABLE KEYS */;
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
  `name` longtext,
  `company_id` int(10) unsigned NOT NULL DEFAULT '0',
  `execute_company_id` int(10) unsigned NOT NULL DEFAULT '0',
  `execute_type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '1:一次性,2:重复',
  `fee_settlement` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '1:全包,2:独立',
  `customer_category` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '1外部客户，2集团公司',
  `customer_grate` tinyint(3) unsigned DEFAULT '0' COMMENT '客户级别：1A2B3C4D',
  `company_customer_id` int(10) unsigned NOT NULL DEFAULT '0',
  `product_id` int(10) unsigned NOT NULL DEFAULT '0',
  `requirement` longtext,
  `attachment` varchar(64) NOT NULL DEFAULT '',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '0正常，1作废，2待发布，3待接收，4处理中，5待验收，6结算中，7已完成，8撤销，9无法执行',
  `superior_task_id` int(10) unsigned NOT NULL DEFAULT '0',
  `create_author_uid` int(10) unsigned NOT NULL DEFAULT '0',
  `update_author_uid` int(10) unsigned NOT NULL DEFAULT '0',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=46 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `task`
--

LOCK TABLES `task` WRITE;
/*!40000 ALTER TABLE `task` DISABLE KEYS */;
INSERT INTO `task` VALUES (43,'1703270001','EGpX5UcB9NcFRQAV0+smdmQ0OGNhZjlmZDRjN2RlMGJmMGE0NTIwMTdhOGM2YWM1MjQ4NmQ4N2FhZTQwMmZjYWFlOWM3Zjc4NmUzNjRhY2ZQ9Ix1mmlrLcdlvEFizzt9if4BmPcs7G4WBbXXSKQaiw==',12,0,1,1,2,2,14,9,'LpjZ1lCY1n2deD5DcAZDvzdiYjYxMjRkYWZkNTZhMzA5NGRjZjhiMjZhNjU3ODg1NTk1MWVlMTQzODczMjE5YzVhMzkwNmQ4MjUzZDVlODGp5qoEkFPQUPGGU7aeGGX/LdmbTbBQIXb0tRM+wmTfeA==','',3,0,27,27,1490603340,1490603358),(44,'1703270002','yHDmdENTknK74Z1fVhVXETUxMzcwODRmNjY0NDA0ZjEyZTBjY2FiOGZjMWQ2NzEyYzkyY2FiYjFmYWJkZDhhMTdjYTZiZDNmMzY1MTk0NjBWWKqiGE0g/gCXGdLDkmljWanncOAvl8ebVtdqDSod8A==',12,14,2,2,2,2,14,9,'S+N6jpbkEKHu+FEeUaLzVmE3M2QyOTgyNjRkZjdjZWY5ZjU3NGRiZGYzZTJkNzYzZTU1MWM2M2RiMjE5ZWJjNTg0Mzg2MThmMGY5NWZjMWbeIoAjjbBXbqxdMz6xax8z4n6UW+dcehXdx1hYwzpbSw==','',10,0,27,27,1490603463,1490604386),(45,'1703270003','MAp4g7UnUdS6UVPeaF7GsjA2NWJhYTMxZDMwZmNiZjc3ZDkwY2MwN2EyNDRiOWUxM2JjMDE2ODU1MGE5NWM0YTUxYzI4NjFlNjk0ZTI0ZWFP8t6U7biweiTunRy/lKn+Ntj7a2+EEu8Ri6VQZ65ZCQ==',12,14,2,2,2,2,14,10,'Q7phY64/nbTtVqRJuKof6zViYWQyMDBlYjg4YjNlNTYzNzA3MGVkZjQ3Y2VkYWVhYTQ3MjZmNmZjODljNmVkNDQxMmU3ODc1Y2E1YjQ3ZGKurTMNB2jhIq8Vp3ltE9oJdgIXMILK5mAXOQINXnvxMA==','',7,0,27,27,1490604850,1490605463);
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
  `remark` longtext,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='æ”¶æ¬¾ä¿¡æ¯';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `task_collection_info`
--

LOCK TABLES `task_collection_info` WRITE;
/*!40000 ALTER TABLE `task_collection_info` DISABLE KEYS */;
INSERT INTO `task_collection_info` VALUES (3,45,12,'1703270001',2,1,14,2,27,27,'2017-03-27 15:55:44','2017-04-03 11:24:54','<p>yes</p><p><span style=\"color: rgb(227, 108, 9);\">ok</span></p>');
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
) ENGINE=MyISAM AUTO_INCREMENT=55 DEFAULT CHARSET=utf8 COMMENT='ä»»åŠ¡æˆäº¤ä»·æ ¼è¡¨';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `task_deal_price`
--

LOCK TABLES `task_deal_price` WRITE;
/*!40000 ALTER TABLE `task_deal_price` DISABLE KEYS */;
INSERT INTO `task_deal_price` VALUES (52,43,9,10,5000.00,5000.00),(53,44,9,10,5000.00,5000.00),(54,45,10,10,6000.00,6000.00);
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
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `task_execute_info`
--

LOCK TABLES `task_execute_info` WRITE;
/*!40000 ALTER TABLE `task_execute_info` DISABLE KEYS */;
INSERT INTO `task_execute_info` VALUES (10,14,44,10,3000.00,'2017-03-27',28,28,'2017-03-27 15:32:21','2017-03-27 15:32:21'),(11,14,45,10,5000.00,'2017-03-27',28,28,'2017-03-27 15:54:37','2017-03-27 15:54:37');
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
  `content` longtext,
  `attachment` varchar(64) DEFAULT NULL,
  `create_author_uid` int(11) NOT NULL,
  `create_time` int(10) unsigned NOT NULL DEFAULT '0',
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(2) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=45 DEFAULT CHARSET=utf8 COMMENT='ä»»åŠ¡åé¦ˆè¡¨ ';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `task_feedback`
--

LOCK TABLES `task_feedback` WRITE;
/*!40000 ALTER TABLE `task_feedback` DISABLE KEYS */;
INSERT INTO `task_feedback` VALUES (37,44,'R4m4bHtulDeKgbvsANq2WzBlYzFkODc5NTBmZThhOWQ2YmMzYWNlZDJjOGFmZjgwNjc2NzBkMjgyYTIwZjRiOTJlYTA0MzcwYWVkZmJmNWJn+WmRD0IDiU/whsPc1zd8WBWkUtaqs8nqc3Q8vcfv5w==','',28,1490603597,0,0),(38,44,'/KlTafElCG1/4bRH2y8UfGVmOWJiNGRlOWJjNGU2YWQ0ZGQ1NjlkZmQyNTg5M2FjNzY2ZDU2M2ZkN2U0NWFlNzA3ODZjYWY0ZmM2ZDc0YTBXCM0+85CIbWcM/TcbrGHtLWy99myabgsp/8GRucHUbA==','',28,1490604298,0,0),(39,44,'MDguDnq53Lna9PldamY7ujY0MWI0ZGNjMjM1N2NkNTY1ZDE3MTMxNTZlZjJkNWFiODc3YzRmNzk0M2MwNTdmYjU4MDRlOGRjNTRlY2RlN2JsZwGmY8ONAj/eDGF8X4/jS2i/h8hHFd3m97BCZoRZUQ==','',27,1490604386,2,0),(40,45,'8Rxg8BXyeATPsP4ZTCztaTFlNjQxZmJhYjM4NzEzMWJkYTI2MzNkNzRlYmVmNDYxNzY3NDZiZmFjMTNiZjhiMTVmY2I4M2FkMTJiYjExMzmZCzVnsg10pbQx+XmADBwrFm+VSLEjcO1jdxegS5c3Jg==','',28,1490604934,0,0),(41,45,'fKvxtsmgyj3zgHlJcLGoImU3NGI3ZDQxZGYwMDUxZmIzNDU4NDJkNWNlY2UyNzMwMTRlNzI2ZDEwY2I2YWI5NTFiY2EyN2M5YjJhMDRjNzSiDDEyRssVJ2yLrF01/rCBrr9vgEqUrEzRAB+3BPIZcA==','',27,1490604944,3,0),(42,45,'8Lx9UJarxmyAS9I5xBC+ETgwZmZhZWUzMzNkZjcwYjMwYTM0Mjk3OGNhM2VkYjc3MTMzNzFjNGY2NGEyNTdmMDVmZTZkZTE0YTUzMWFlNzAjkkPb6iFgRMz6ts17E90uEfQlt+0Ei6wS7NuhOJlXZw==','',27,1490604996,4,0),(43,45,'kMOOhIbN4Jpcu+H4yU9v4DkzOGUyMTUzYTI2ZjlmMjNmMzY0NGZkNzU3ZTlhZWY1MmJhNWNjNGRlY2NhOTliM2Y5MWU5NGM1MTkxNjI2NTjYOem7M6RCVammtMgOxwpyRe7qkHkP+Zj2RavyaXJyPw==','',27,1490605463,4,0),(44,45,'YhgEjUMCQ1xOXep7hHqu1zVjZjQ3MDllYTY3OWM4MWUwYzU5MzE0MGI2OWEyNmY1YjcxNzhhOTg0OGYwNGM0NmZiZmFmZjQ0ODBhZTY4MGae8Uf5NKAztxkcDrlg+4enU5zub4MbsUQnWcCDipECjxO0/GQPxfY4h7N93ErdpDM=','58e1e41659d3c9300.zip',27,1491198998,0,0);
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
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='ä»˜æ¬¾ä¿¡æ¯';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `task_pay_info`
--

LOCK TABLES `task_pay_info` WRITE;
/*!40000 ALTER TABLE `task_pay_info` DISABLE KEYS */;
INSERT INTO `task_pay_info` VALUES (5,45,12,14,'1703270001',2,0,27,27,'2017-03-27 15:55:44','2017-03-27 15:55:44');
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
  `content` longtext,
  `create_author_uid` int(10) unsigned NOT NULL DEFAULT '0',
  `update_author_uid` int(10) unsigned NOT NULL DEFAULT '0',
  `create_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='ä»»åŠ¡åé¦ˆè¡¨ ';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `task_remark`
--

LOCK TABLES `task_remark` WRITE;
/*!40000 ALTER TABLE `task_remark` DISABLE KEYS */;
INSERT INTO `task_remark` VALUES (3,45,'LA1S1UEL/a8NAnSAgkKHuTM2N2QwYzM5ZDc2ODEwODI4ZWU4MmRiOTM4ZjgxNjY4ODZjYmZkNGNhZGQ4YzMxMTMxNWNhYTcxYzY2NDI3NTn1FHZNRXOzw3uAEBPk9CovczCohKYjCGlI/B1YVI7rKg==',27,27,'2017-04-01 19:02:05','2017-04-01 19:02:05',0,0),(4,45,'z9qf6CJl/CfsmG8r8VXPQmM0NmRhN2ZmNzk4YmE3NjNmMDkxM2ZkOTQxNzNjYjFkODlmZTg2MGRkYzJhODFmYjJhYzZjMWNlZThkNjVkNmWPm0+gbtPht9WMHAhfqfv7cOh2+mfmZRmK0kpK5edDIA==',27,27,'2017-04-01 19:24:11','2017-04-01 19:24:11',0,0),(5,45,'3RchIGhpmNSd1KT6olXlTjE2ZTY4OGUyYjE0NzZlOGJjNmQyMGQxMjNmODExYzBiZjAzZDU0MGViMzIyMzM2YmRlNDcwZjgwNTg3YjkwODcpXWR7qEmoLpWSGCNN66UZE0TK+eXkp5Umn+F7svF8cWA00BBVDpweou8EOw0+BmM=',27,27,'2017-04-02 16:54:32','2017-04-02 16:54:32',0,0),(6,45,'6s4yIb90mN2iJb4MiOewOmExZTU4ZGI2ZGI5NTQ1YWI4YTVkMWRmYjU4YjMxYmE4Nzc5NmZkZDk1ZTY0NWZiOTg0ZDUxNzMxYzE5MDg1NTA/2aN1gL7UK25HZ0LOhaNcTUwZrl7u0Rb472iUouWnh52kgirF9P7H7ab2uCggCYY=',27,27,'2017-04-02 19:09:19','2017-04-02 19:09:19',0,0),(7,45,'0rkWdtS9wzCOnH7q4FfQ3zNjNDI2ODZlYjA5OGE1ODNmZTM1YmZmNjAwYzhhZDRiZmFjZmFkZmI5NDM0M2QzOTlhOWE4MDk1OGZjMGU5ZmKnSlcuX4T4XEgLh41UVSbdcWZNKwrfrXaH0x01TSq/Xq9TxAGDQvMsZhaTI9Zzh9xafmzxxO2YJSsxYw9VTxEOQi7t9syuZR9LRmx7epfHjJo2VjXDELvEXAv6Wt9gAwuwf5m4Qpcl814X9kBU9Eff',27,27,'2017-04-02 19:09:34','2017-04-02 19:09:34',0,0),(8,45,'zt2136ly7lEFgMVuIGvjgDc2OTg3NTExMGFmMGZhMjBhN2NhZmM3YmVkM2FlYWM4NTVhMTM2ZmVlNjEwYjZiMTE2YTg3MmQ4NWUzNDA2NjPEEGx4noG6xvjcvlW5aL+9RbiGlaYknLHhTOmFKyLcOQKAnJ1RmilUOvNaRbzMhSE=',27,27,'2017-04-05 19:34:55','2017-04-05 19:34:55',0,0);
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
  `account` longtext COLLATE utf8mb4_unicode_ci,
  `nickname` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '用户昵称',
  `email` longtext COLLATE utf8mb4_unicode_ci,
  `password` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `auth_key` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_id` int(10) unsigned DEFAULT '0',
  `department_id` int(10) unsigned NOT NULL DEFAULT '0',
  `posts_id` int(10) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(4) unsigned NOT NULL DEFAULT '0',
  `login_permission` int(10) unsigned NOT NULL DEFAULT '1' COMMENT '登录许可：1禁止0允许',
  `create_author_uid` int(10) unsigned NOT NULL DEFAULT '0',
  `update_author_uid` int(10) unsigned NOT NULL DEFAULT '0',
  `create_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='ç”¨æˆ·è¡¨';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'USRW1aUurpaT+/qGwKWH/Dc3NjUzZjBhZmUzMGE5M2I2MmE4ZDVlNzgzZDIyMTU3YjI4ODE3MjZiODM1Mjk2MWUyMjJiZTdmMTdmNTVhNmaHtr5qUVhDZFyWj6uoMa7kE8sdIT+Ec0WSIF8e1ZHIjg==','','','$2y$13$JUC0Ue1e7KnJxj.gAEXAZexFCOOmCWy1Wh68rNZBkgqQvkxtdHScu','V5Y4Mtyvo8cuQQ4ekLY8fxye2plydLkH',0,0,0,0,0,2,1,'2017-01-25 11:05:35','2017-04-11 19:24:01'),(27,'7c6MoJdjtiY7yPi28izz32IyMGU1OWQ4OGVlOTUyYTk5NDM0YzljZTczMjdjNzg4NjcxYTE5MDc4MWZmMjUwYTA5MjM2ZjA2MTE3NzFjOWT+YAj/rQQpfi4As3XeMUOwO+qr0ANAdX3yC1Pwmw6L5A==','','mLn9pHDllGhYqlGT1iH5pzM1ODdhZmNmOTUxYTMyYTdmYWRmNmMwOTQ1YTNjM2Y0MzI5ZWY5NDQxMjBiN2JhZGZkZjExMWJlMDRkMTM3NGbtZixwwVOfAHiGQXSOQFEPb+M+GtgANQZSV2sf/ThriHI0JLFYC4yGz5FLsoz7wyo=','$2y$13$FZpOdiKEvU3rRjSSqsvZDOMIMu3UfxGIRhU0RnHPgvCHoXtVU5C66','6pGzmyydaGendm6vFx40wj-Vu1Y3oohr',12,18,15,0,0,1,1,'2017-03-26 14:28:26','2017-03-26 14:28:53'),(28,'eIFycNzlSPQ5OoMusHbsTDA4NDk1ZGJmZGY3ZmFlZjg1ZTQ5MjNjYTAwZTMzOWFmOGIyNjNlYmM3YjI1OGM4NDZmOGZkNWI1MDE3NGM4OWM3tF96XAwfu12ldHsDGyx/5V8quFOdHQIuc+7IA8Djtg==','','EcuOT6usrk7WyBSSDAfr2jQ0MDliMDlkOWYyNDU5NWVjYjdiMWVjY2JhNThjYTQ4NzllNTE2ZmIwM2E4YjI5NzU2NzMxMWQ4ODEwYzBlNWTOuqcoyZ6tuhoD1antyy/BijeTo8tT1ZFzpDa167Lr5Q==','$2y$13$S03ZB6hnt0C8vG.tMdovYerwA06Csre8xfLSrnEYRtwrOPHvZ2pVe','6DF5MHr4KMKKwVPO6c_NOQMYFhbmKydk',14,22,17,0,0,27,27,'2017-03-27 15:27:05','2017-03-27 15:27:23'),(29,'8/u2H3FFXlkMbQJKibLitzUyYjQ5MTRiYzZmMmFmZjEzODAwMzY3Y2NiY2M3YTM0NDRjYTVkMjcyM2E3ZTRkZTMyMWZmYTBjNzY0YTFmZjh4j7Yrh1CFTxlWo8kWojqc4kdv25AODR+u4oipovFedg==','',NULL,'','ZC17NCGNe9i5Rd683rcewhSX3MysL9iD',12,18,16,0,1,1,1,'2017-03-30 14:08:47','2017-03-30 14:08:47'),(30,'gdIiYopeEpL5fKEEYXgZkmVjMGY5MDgxNDI3OWM0YzYwNzhlMjdjNDlmZDUxNjZkMTg2MWZkN2ViNWQ1MmE2ZDAxMzA3MGZkYTNmMTU1NTL7u0pOkp05CPslrLbZUFeZifxWkqM2OppFa5N8RLiWVA==','',NULL,'','tfds5RWHPWNFkZ9gFjOUv-FrUI_Q4PpJ',12,18,16,0,1,1,1,'2017-03-30 14:19:19','2017-03-30 14:19:19'),(31,'uaVsZU+CBsAm8+1oaKNYWDVmMDNhZjkyMjY0ZTFmNTQxYzMyMTczN2VlYmRiODZlNzhkOTM5ZjE0ZDg4NWY3ZTFkZWViMGM5MGRmZDAwYzmX2xf/tmv1Cp8CGTNJSm8cYu5s180hgOtErwQYkdZC9Q==','',NULL,'','95F4UcVxyPVdGrk-KwsgLvf_cvKLT6Jj',12,18,16,0,1,1,1,'2017-03-30 14:26:22','2017-03-30 14:26:22'),(32,'0ebIoIpWIoPYwfIgd2V9fmQxZDAyZmE2ZjM0ZDJhMjhmNGEzN2ZlYzlkYjExMzlmMWQ0Y2U5MTQ4ZWEzYzg2ZTc0NjUzNzdjMTRmZTkwOWXK5aytuskW9DCZt5v33i93LxzvLpvOtFUk60Ms8YzgTg==','','zhTT8aEulKZQeVAaY+lQD2JlNTgwYWY3NjVkZTI3YTFmZDRmN2JmMDJjNjNhMTBhZWEyMTBkMjdjODViMzU1Y2I2Y2RkNGNjYzI0ZTE3NTGQSI0QgEkJYxAOLSlN1MYGH4IVPttK/xEaPaKFuAcgiQH2/bg0SONuXrXKdnjUwDE=','$2y$13$mRoZwDNWCXsWcFl925eoNeMI7ht/2ghT4PPiyurGEdafXd.PQdTpO','IlwLI-6DkgFrfz77eEmQJGtTuBk9KIox',12,18,16,0,0,1,32,'2017-03-31 10:55:16','2017-03-31 14:38:05');
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

-- Dump completed on 2017-07-13 10:20:20
