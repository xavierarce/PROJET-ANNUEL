-- MySQL dump 10.13  Distrib 8.0.27, for Linux (x86_64)
--
-- Host: localhost    Database: bge_blog_nrb
-- ------------------------------------------------------
-- Server version	8.0.27

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


--
-- Table structure for table `Role`
--

DROP TABLE IF EXISTS `Role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Role` (
  `id_role` bigint unsigned NOT NULL AUTO_INCREMENT,
  `label` varchar(45) COLLATE utf8mb4_bin NOT NULL,
  PRIMARY KEY (`id_role`),
  UNIQUE KEY `label_UNIQUE` (`label`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Role`
--

LOCK TABLES `Role` WRITE;
/*!40000 ALTER TABLE `Role` DISABLE KEYS */;
INSERT INTO `Role` VALUES (3,'Administrateur'),(2,'Modérateur'),(1,'Rédacteur');
/*!40000 ALTER TABLE `Role` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

--
-- Table structure for table `Compte`
--

DROP TABLE IF EXISTS `Compte`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Compte` (
  `id_compte` bigint unsigned NOT NULL AUTO_INCREMENT,
  `login` varchar(127) COLLATE utf8mb4_bin NOT NULL,
  `password` varchar(63) COLLATE utf8mb4_bin NOT NULL,
  `pseudo` varchar(31) COLLATE utf8mb4_bin NOT NULL,
  `dateCreation` datetime NOT NULL,
  `dateModification` datetime NOT NULL,
  `estSupprime` bit(1) NOT NULL,
  `estSignale` bit(1) NOT NULL,
  `estBanni` bit(1) NOT NULL,
  `enAttenteDeModeration` bit(1) NOT NULL,
  `fk_role` bigint unsigned NOT NULL,
  PRIMARY KEY (`id_compte`),
  UNIQUE KEY `login_UNIQUE` (`login`),
  UNIQUE KEY `pseudo_UNIQUE` (`pseudo`),
  KEY `fk_Compte_Role_idx` (`fk_role`),
  CONSTRAINT `fk_Compte_Role` FOREIGN KEY (`fk_role`) REFERENCES `Role` (`id_role`)
) ENGINE=InnoDB AUTO_INCREMENT=62 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Compte`
--

LOCK TABLES `Compte` WRITE;
/*!40000 ALTER TABLE `Compte` DISABLE KEYS */;
INSERT INTO `Compte` VALUES (1,'ced@bge.fr','azerty','cedric','2024-10-21 15:43:18','2024-10-21 15:43:18',_binary '\0',_binary '\0',_binary '\0',_binary '\0',3),(2,'toto@test.com','AZERTY','toto','2024-10-24 11:10:28','2024-10-24 11:10:28',_binary '\0',_binary '\0',_binary '\0',_binary '',1),(20,'toto@google.com','AZERTY','totooooo','2024-10-25 09:10:45','2024-10-25 09:10:45',_binary '\0',_binary '\0',_binary '\0',_binary '',1),(33,'hash@google.com','$2y$10$5QJWhA6tz7I.yc.hiICDieEWMCi4I8lK4HcLud3CXGvhtkUZz0VH6','hash','2024-10-25 11:10:32','2024-10-25 11:10:32',_binary '\0',_binary '\0',_binary '\0',_binary '',1),(47,'hashddd@google.com','$2y$10$DmJ2AVv6o6JwBsSBRq0KBOU.eL1kCFnA.li0JKCIahBZ/XXUMxKFO','hashsss','2024-10-30 03:10:09','2024-10-30 03:10:09',_binary '\0',_binary '\0',_binary '\0',_binary '',1),(50,'hashmmmmm@google.com','$2y$10$xxwar4UYIsA1aYFf0CICUuNSF9P8gqbRF59lJx7T/xsBSQOnBp2y2','hashmmmmm','2024-10-30 04:10:43','2024-10-30 04:10:43',_binary '\0',_binary '\0',_binary '\0',_binary '',1),(51,'prosper@youpla.boom','$2y$10$NLT/D5iRy5zub9omiUffwOFlf/xfnrO6xZXHx1Fu/WRSJqjZBo5Bi','Prosper Youpla Boom','2025-05-21 10:05:35','2025-05-21 10:05:35',_binary '\0',_binary '\0',_binary '\0',_binary '',1);
/*!40000 ALTER TABLE `Compte` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Configuration`
--

DROP TABLE IF EXISTS `Configuration`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Configuration` (
  `configuration` bigint unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(128) COLLATE utf8mb4_bin NOT NULL,
  `value` varchar(16183) COLLATE utf8mb4_bin NOT NULL,
  PRIMARY KEY (`configuration`),
  UNIQUE KEY `key_UNIQUE` (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
/*!40101 SET character_set_client = @saved_cs_client */;


/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-05-22 18:07:22