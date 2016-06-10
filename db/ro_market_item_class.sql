-- MySQL dump 10.13  Distrib 5.6.24, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: ro_market
-- ------------------------------------------------------
-- Server version	5.6.24

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
-- Table structure for table `item_class`
--

DROP TABLE IF EXISTS `item_class`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `item_class` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `class_name` varchar(255) DEFAULT NULL,
  `class_type_id` int(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `item_class`
--

LOCK TABLES `item_class` WRITE;
/*!40000 ALTER TABLE `item_class` DISABLE KEYS */;
INSERT INTO `item_class` VALUES (1,'Two-handed Spear',5),(2,'Book',5),(3,'Dagger',5),(4,'Mace',5),(5,'Bow',5),(6,'One-handed Staff',5),(7,'One-handed Spear',5),(8,'Two-handed Sword',5),(9,'One-handed Axe',5),(10,'Musical Instrument',5),(11,'Two-handed Axe',5),(12,'Knuckle',5),(13,'Shotgun',5),(14,'One-handed Sword',5),(15,'Whip',5),(16,'Katar',5),(17,'Rifle',5),(18,'Fuuma Shuriken',5),(19,'Gatling Gun',5),(20,'Revolver',5),(21,'Two-handed Staff',5),(22,'Grenade Launcher',5),(23,'Upper Headgear',4),(24,'Middle Headgear',4),(25,'Accessory',4),(26,'Lower Headgear',4),(27,'Shield',4),(28,'Armor',4),(29,'Upper & Middle Headgear',4),(30,'Footgear',4),(31,'Middle & Lower Headgear',4),(32,'Garment',4),(33,'U, M & L Headgear',4),(34,'Costume Upper Headgear',4),(35,'Upper & Lower Headgear',4),(36,'Costume Lower Headgear',4),(37,'Costume Middle & Lower Headgear',4),(38,'Costume Upper & Lower Headgear',4),(39,'Costume Middle Headgear',4),(40,'Weapon Card',6),(41,'Armor Card',6),(42,' Card',6),(43,'Footgear Card',6),(44,'Shield Card',6),(45,'Garment Card',6),(46,'Accessory Card',6),(47,'Headgear Card',6),(48,'Throw Weapon',10),(49,'Arrow',10),(50,'Kunai',10),(51,'Grenade',10),(52,'Bullet',10),(53,'Cannon Ball',10),(54,'Shuriken',10),(55,'Throwing dagger',10),(56,'n/a',0);
/*!40000 ALTER TABLE `item_class` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-06-10 17:59:20
