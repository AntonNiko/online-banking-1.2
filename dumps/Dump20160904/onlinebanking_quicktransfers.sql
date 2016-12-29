-- MySQL dump 10.13  Distrib 5.7.12, for Win64 (x86_64)
--
-- Host: localhost    Database: onlinebanking
-- ------------------------------------------------------
-- Server version	5.7.14-log

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
-- Table structure for table `quicktransfers`
--

DROP TABLE IF EXISTS `quicktransfers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `quicktransfers` (
  `transfer_id` varchar(10) NOT NULL,
  `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `origin_account` int(7) NOT NULL,
  `destination_account` int(7) NOT NULL,
  `amount` double NOT NULL,
  `origin_balance` double NOT NULL,
  `destination_balance` double NOT NULL,
  `description` varchar(60) NOT NULL,
  PRIMARY KEY (`transfer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `quicktransfers`
--

LOCK TABLES `quicktransfers` WRITE;
/*!40000 ALTER TABLE `quicktransfers` DISABLE KEYS */;
INSERT INTO `quicktransfers` VALUES ('3436267630','2016-08-31 02:35:38',2331704,9000873,3.5,77535.04,112,'Branch Transaction SERVICE CHARGE'),('4516788422','2016-08-31 02:35:37',1700188,9000873,3.5,15524.43,101.5,'Branch Transaction SERVICE CHARGE'),('5296623761','2016-08-31 02:35:37',1930289,9000873,3.5,86,105,'Branch Transaction SERVICE CHARGE'),('5495300288','2016-08-31 02:35:38',2019971,9000873,3.5,1490.2399999999998,108.5,'Branch Transaction SERVICE CHARGE'),('5789926579','2016-08-31 02:35:22',0,2333901,27.13,0,65134.25,'Branch Transaction INTEREST'),('8119575119','2016-08-31 02:35:22',0,2019971,0.62,0,1493.7399999999998,'Branch Transaction INTEREST'),('8560578554','2016-08-31 02:35:22',0,2331704,32.29,0,77538.54,'Branch Transaction INTEREST'),('999608134','2016-08-31 02:35:38',2333901,9000873,3.5,65130.75,115.5,'Branch Transaction SERVICE CHARGE');
/*!40000 ALTER TABLE `quicktransfers` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-09-04 20:03:00
