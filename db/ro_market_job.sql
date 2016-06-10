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
-- Table structure for table `job`
--

DROP TABLE IF EXISTS `job`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `job` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `job_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job`
--

LOCK TABLES `job` WRITE;
/*!40000 ALTER TABLE `job` DISABLE KEYS */;
INSERT INTO `job` VALUES (1,'Knight'),(2,'Crusader'),(3,'Priest'),(4,'Sage'),(5,'Star Gladiator'),(6,'Novice (& Supernovice)'),(7,'Every Job'),(8,'Archer'),(9,'Thief'),(10,'Hunter'),(11,'Rogue'),(12,'Bard / Dancer'),(13,'Mage'),(14,'Acolyte'),(15,'Wizard'),(16,'Monk'),(17,'Soul Linker'),(18,'Ninja'),(19,'Assassin'),(20,'Swordman'),(21,'High Swordman'),(22,'Lord Knight'),(23,'Paladin'),(24,'Merchant'),(25,'Blacksmith'),(26,'Alchemist'),(27,'Clown / Gypsy'),(28,'High Merchant'),(29,'Whitesmith'),(30,'Creator'),(31,'Gunslinger'),(32,'Rebellion'),(33,'Assassin Cross'),(34,'Kagerou / Oboro'),(35,'High Acolyte'),(36,'High Priest'),(37,'Champion'),(38,'High Archer'),(39,'Sniper'),(40,'Stalker'),(41,'High Thief'),(42,'High Mage'),(43,'High Wizard'),(44,'Professor'),(45,'Every Job except Novice'),(46,'Mechanic'),(47,'Taekwon'),(48,'Every Rebirth Job except High Novice'),(49,'Shura'),(50,'Warlock'),(51,'Genetic'),(52,'Minstrel / Wanderer'),(53,'Arch Bishop'),(54,'Royal Guard'),(55,'Rune Knight'),(56,'Shadow Chaser'),(57,'Every Rebirth Job'),(58,'Guillotine Cross'),(59,'Ranger'),(60,'Sorcerer');
/*!40000 ALTER TABLE `job` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-06-10 17:59:21
