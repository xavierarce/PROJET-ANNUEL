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
-- Table structure for table `Article`
--

DROP TABLE IF EXISTS `Article`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Article` (
  `id_article` bigint unsigned NOT NULL AUTO_INCREMENT,
  `titre` varchar(127) COLLATE utf8mb4_bin NOT NULL,
  `contenu` varchar(8191) COLLATE utf8mb4_bin NOT NULL,
  `dateCreation` datetime NOT NULL,
  `dateModification` datetime NOT NULL,
  `estPublic` bit(1) NOT NULL,
  `enAttenteDeModeration` bit(1) NOT NULL,
  `estSupprime` bit(1) NOT NULL,
  `fk_auteur` bigint unsigned NOT NULL,
  `fk_moderePar` bigint unsigned DEFAULT NULL,
  `dateModeration` datetime DEFAULT NULL,
  `moderationDescription` varchar(127) COLLATE utf8mb4_bin DEFAULT NULL,
  PRIMARY KEY (`id_article`),
  KEY `fk_Article_Compte1_idx` (`fk_auteur`),
  KEY `fk_Article_Compte2_idx` (`fk_moderePar`),
  CONSTRAINT `fk_Article_Compte1` FOREIGN KEY (`fk_auteur`) REFERENCES `Compte` (`id_compte`),
  CONSTRAINT `fk_Article_Compte2` FOREIGN KEY (`fk_moderePar`) REFERENCES `Compte` (`id_compte`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Article`
--

LOCK TABLES `Article` WRITE;
/*!40000 ALTER TABLE `Article` DISABLE KEYS */;
INSERT INTO `Article` VALUES (1,'Bienvenu','Welcome in my blog','2024-10-21 15:46:27','2024-10-21 15:46:27',_binary '',_binary '\0',_binary '\0',1,NULL,NULL,NULL),(2,'Article 2','Les hommes naissent et demeurent libres','2024-10-21 15:47:47','2024-10-21 15:47:47',_binary '',_binary '\0',_binary '\0',1,NULL,NULL,NULL),(3,'Article Privé','Y a rien à voir','2024-10-21 15:50:12','2024-10-21 15:50:12',_binary '\0',_binary '\0',_binary '\0',1,NULL,NULL,NULL);
/*!40000 ALTER TABLE `Article` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Commentaire`
--

DROP TABLE IF EXISTS `Commentaire`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Commentaire` (
  `id_commentaire` bigint unsigned NOT NULL AUTO_INCREMENT,
  `contenu` varchar(1023) COLLATE utf8mb4_bin NOT NULL,
  `dateCreation` datetime NOT NULL,
  `dateModification` datetime NOT NULL,
  `estSupprime` bit(1) NOT NULL,
  `estModere` bit(1) NOT NULL,
  `moderationDescription` varchar(127) COLLATE utf8mb4_bin DEFAULT NULL,
  `fk_article` bigint unsigned NOT NULL,
  `fk_auteur` bigint unsigned NOT NULL,
  `fk_moderePar` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`id_commentaire`),
  KEY `fk_Commentaire_Article1_idx` (`fk_article`),
  KEY `fk_Commentaire_Compte1_idx` (`fk_auteur`),
  KEY `fk_Commentaire_Compte2_idx` (`fk_moderePar`),
  CONSTRAINT `fk_Commentaire_Article1` FOREIGN KEY (`fk_article`) REFERENCES `Article` (`id_article`),
  CONSTRAINT `fk_Commentaire_Compte1` FOREIGN KEY (`fk_auteur`) REFERENCES `Compte` (`id_compte`),
  CONSTRAINT `fk_Commentaire_Compte2` FOREIGN KEY (`fk_moderePar`) REFERENCES `Compte` (`id_compte`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Commentaire`
--

LOCK TABLES `Commentaire` WRITE;
/*!40000 ALTER TABLE `Commentaire` DISABLE KEYS */;
/*!40000 ALTER TABLE `Commentaire` ENABLE KEYS */;
UNLOCK TABLES;

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

--
-- Dumping data for table `Configuration`
--

LOCK TABLES `Configuration` WRITE;
/*!40000 ALTER TABLE `Configuration` DISABLE KEYS */;
/*!40000 ALTER TABLE `Configuration` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Dossier`
--

DROP TABLE IF EXISTS `Dossier`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Dossier` (
  `dossier` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nom` varchar(128) COLLATE utf8mb4_bin NOT NULL,
  `nomCourt` varchar(32) COLLATE utf8mb4_bin NOT NULL,
  `reference` varchar(64) COLLATE utf8mb4_bin NOT NULL,
  `dateCreation` datetime NOT NULL,
  `dateModification` datetime NOT NULL,
  `deleted` tinyint NOT NULL DEFAULT '0',
  PRIMARY KEY (`dossier`),
  UNIQUE KEY `nom_UNIQUE` (`nom`),
  UNIQUE KEY `reference_UNIQUE` (`reference`),
  UNIQUE KEY `nomCourt_UNIQUE` (`nomCourt`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Dossier`
--

LOCK TABLES `Dossier` WRITE;
/*!40000 ALTER TABLE `Dossier` DISABLE KEYS */;
/*!40000 ALTER TABLE `Dossier` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Millesime`
--

DROP TABLE IF EXISTS `Millesime`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Millesime` (
  `millesime` bigint unsigned NOT NULL AUTO_INCREMENT,
  `annee` year NOT NULL,
  `dateCreation` datetime NOT NULL,
  `dateModification` datetime NOT NULL,
  `deleted` tinyint NOT NULL DEFAULT '0',
  PRIMARY KEY (`millesime`),
  UNIQUE KEY `annee_UNIQUE` (`annee`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Millesime`
--

LOCK TABLES `Millesime` WRITE;
/*!40000 ALTER TABLE `Millesime` DISABLE KEYS */;
/*!40000 ALTER TABLE `Millesime` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Mission`
--

DROP TABLE IF EXISTS `Mission`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Mission` (
  `mission` bigint unsigned NOT NULL AUTO_INCREMENT,
  `label` varchar(128) COLLATE utf8mb4_bin NOT NULL,
  `dateCreation` datetime NOT NULL,
  `dateModification` datetime NOT NULL,
  `deleted` tinyint NOT NULL DEFAULT '0',
  PRIMARY KEY (`mission`),
  UNIQUE KEY `label_UNIQUE` (`label`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Mission`
--

LOCK TABLES `Mission` WRITE;
/*!40000 ALTER TABLE `Mission` DISABLE KEYS */;
/*!40000 ALTER TABLE `Mission` ENABLE KEYS */;
UNLOCK TABLES;

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

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-05-22 18:07:22
