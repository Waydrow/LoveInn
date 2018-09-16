-- MySQL dump 10.13  Distrib 5.6.24, for Win64 (x86_64)
--
-- Host: localhost    Database: loveinn
-- ------------------------------------------------------
-- Server version	5.6.24-log

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
-- Table structure for table `activity`
--

DROP TABLE IF EXISTS `activity`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `activity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `summary` varchar(65) DEFAULT NULL,
  `info` varchar(100) DEFAULT NULL,
  `photo` varchar(100) DEFAULT NULL,
  `begintime` datetime DEFAULT NULL,
  `endtime` datetime DEFAULT NULL,
  `location` varchar(45) DEFAULT NULL,
  `categoryid` int(11) DEFAULT NULL,
  `contact` varchar(45) DEFAULT NULL,
  `agencyid` int(11) DEFAULT NULL,
  `capacity` int(11) DEFAULT NULL,
  `isend` int(11) DEFAULT '0',
  `israte` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `foreign key 1_idx` (`categoryid`),
  KEY `foreign key 2_idx` (`agencyid`),
  CONSTRAINT `foreign key 1` FOREIGN KEY (`categoryid`) REFERENCES `category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `foreign key 2` FOREIGN KEY (`agencyid`) REFERENCES `agency` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `activity`
--

LOCK TABLES `activity` WRITE;
/*!40000 ALTER TABLE `activity` DISABLE KEYS */;
INSERT INTO `activity` VALUES (3,'活动3','summary3','这是info','/LoveInn/Public/Uploads/2017-02-08/589b1f3b2f194.jpg','2017-02-03 14:20:00','2017-03-01 00:00:00','456',2,'178424',4,20,1,1),(4,'测试活动','没有活动简介','这是一个活动详情222','/LoveInn/Public/Uploads/2017-02-06/589898b8d0e34.jpg','2017-02-09 20:10:00','2017-02-10 00:00:00','中国海洋大学',6,'15178231231',4,20,1,1),(8,'这是另一个活动','没有','还行','/LoveInn/Public/Uploads/2017-02-07/5899c53582fb6.jpg','2017-02-07 13:00:00','2017-02-08 21:18:30','山东',2,'无',4,10,0,0);
/*!40000 ALTER TABLE `activity` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account` varchar(45) DEFAULT NULL,
  `password` varchar(45) DEFAULT NULL,
  `name` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin`
--

LOCK TABLES `admin` WRITE;
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
INSERT INTO `admin` VALUES (1,'222','bcbe3365e6ac95ea2c0343a2395834dd','123');
/*!40000 ALTER TABLE `admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `agency`
--

DROP TABLE IF EXISTS `agency`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `agency` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `photo` varchar(95) DEFAULT NULL,
  `address` varchar(45) DEFAULT NULL,
  `contact` varchar(45) DEFAULT NULL,
  `certification` varchar(95) DEFAULT NULL,
  `ispass` int(11) DEFAULT '-1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `agency`
--

LOCK TABLES `agency` WRITE;
/*!40000 ALTER TABLE `agency` DISABLE KEYS */;
INSERT INTO `agency` VALUES (1,'111','bcbe3365e6ac95ea2c0343a2395834dd','公益机构1',NULL,NULL,NULL,NULL,-1),(3,'444','bcbe3365e6ac95ea2c0343a2395834dd','机构2','/LoveInn/Public/Uploads/2017-02-09/589c84158c352.jpg','3232','178542','/LoveInn/Public/Uploads/2017-02-09/589c84158d690.jpg',1),(4,'333','bcbe3365e6ac95ea2c0343a2395834dd','world','/LoveInn/Public/Uploads/2017-02-05/58972709a71dc.png','4214214','777','/LoveInn/Public/Uploads/2017-02-09/589c849b7cdf0.jpg',1);
/*!40000 ALTER TABLE `agency` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `apply`
--

DROP TABLE IF EXISTS `apply`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `apply` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) DEFAULT NULL,
  `activityid` int(11) DEFAULT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `rate` decimal(2,1) DEFAULT NULL,
  `isjoin` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `foreign key apply 1_idx` (`userid`),
  KEY `foreign key apply 2_idx` (`activityid`),
  CONSTRAINT `foreign key apply 1` FOREIGN KEY (`userid`) REFERENCES `volunteer` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `foreign key apply 2` FOREIGN KEY (`activityid`) REFERENCES `activity` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `apply`
--

LOCK TABLES `apply` WRITE;
/*!40000 ALTER TABLE `apply` DISABLE KEYS */;
INSERT INTO `apply` VALUES (1,1,4,'2017-02-08 14:08:47',NULL,-1),(2,2,4,'2017-02-09 09:09:39',3.0,1),(3,3,4,'2017-02-09 09:09:39',2.5,1),(4,1,3,'2017-02-09 08:53:58',0.5,1),(5,2,3,'2017-02-09 09:10:42',1.0,1);
/*!40000 ALTER TABLE `apply` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category`
--

LOCK TABLES `category` WRITE;
/*!40000 ALTER TABLE `category` DISABLE KEYS */;
INSERT INTO `category` VALUES (1,'关爱老人'),(2,'社区服务'),(6,'关爱儿童'),(10,'其它');
/*!40000 ALTER TABLE `category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `volunteer`
--

DROP TABLE IF EXISTS `volunteer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `volunteer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL,
  `avatar` varchar(95) DEFAULT NULL,
  `realname` varchar(45) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `sex` varchar(2) DEFAULT NULL,
  `idcard` varchar(45) DEFAULT NULL,
  `phone` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `info` varchar(95) DEFAULT NULL,
  `stucard` varchar(95) DEFAULT NULL,
  `money` int(11) DEFAULT '0',
  `ispass` int(11) DEFAULT '-1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `volunteer`
--

LOCK TABLES `volunteer` WRITE;
/*!40000 ALTER TABLE `volunteer` DISABLE KEYS */;
INSERT INTO `volunteer` VALUES (1,'222','bcbe3365e6ac95ea2c0343a2395834dd','/LoveInn/Public/Uploads/2017-02-04/5895f417cca84.jpg','你好',NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,1),(2,'333','bcbe3365e6ac95ea2c0343a2395834dd',NULL,'小胖子',NULL,NULL,NULL,NULL,NULL,NULL,NULL,8,1),(3,'444','bcbe3365e6ac95ea2c0343a2395834dd',NULL,'志愿者3',NULL,NULL,NULL,NULL,NULL,NULL,NULL,5,1),(4,'555','bcbe3365e6ac95ea2c0343a2395834dd',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,-1);
/*!40000 ALTER TABLE `volunteer` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-04-08 20:49:02
