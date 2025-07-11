-- MySQL dump 10.13  Distrib 8.0.27, for Linux (x86_64)
--
-- Host: localhost    Database: chat_web
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

CREATE DATABASE IF NOT EXISTS chat_web;
USE chat_web;

-- Table Role
CREATE TABLE Role (
    pkR INT AUTO_INCREMENT PRIMARY KEY,
    label VARCHAR(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Insert data into Role
INSERT INTO Role (pkR, label) VALUES
(1, 'Membre'),
(2, 'Admin');

-- Table Utilisateur
CREATE TABLE Utilisateur (
    pkU INT AUTO_INCREMENT PRIMARY KEY,
    fkRole INT,
    pseudo VARCHAR(50) NOT NULL,
    login VARCHAR(100) NOT NULL UNIQUE,
    mdp VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    FOREIGN KEY (fkRole) REFERENCES Role(pkR)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Insert data into Utilisateur
INSERT INTO Utilisateur (pkU, fkRole, pseudo, login, mdp, email) VALUES
(1, 1, 'adam', 'adam', '$2y$10$5E7lJOnQd6lbDF1GL3vXuuk7UYUKrTbwmaijHVPprNHLxwt4O4Km6', 'adam@gmail.com'),
(2, 1, 'nathan', 'nathan', '$2y$10$97Qg1ioRqaUqV1pdBIJR..DJ5KVX.yLwdD9i8oQXeBM3BuYPMU30.', 'nathan@gmail.com');

-- Table Salon
CREATE TABLE Salon (
    pkS INT AUTO_INCREMENT PRIMARY KEY,
    fkU_proprio INT,
    nom VARCHAR(100) NOT NULL,
    visibilite BOOLEAN DEFAULT TRUE,
    prive BOOLEAN DEFAULT FALSE,
    topic VARCHAR(255),
    FOREIGN KEY (fkU_proprio) REFERENCES Utilisateur(pkU)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Insert data into Salon
INSERT INTO Salon (pkS, fkU_proprio, nom, visibilite, prive, topic) VALUES
(1, 1, 'nathanLeGay', 1, 0, 'testtt'),
(2, 1, 'ahahahaha', 1, 0, 'hahahaaXDDDXDX');

-- Table Moderer
CREATE TABLE Moderer (
    fkU INT,
    fkS INT,
    PRIMARY KEY (fkU, fkS),
    FOREIGN KEY (fkU) REFERENCES Utilisateur(pkU),
    FOREIGN KEY (fkS) REFERENCES Salon(pkS)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Table Membre
CREATE TABLE Membre (
    fkU INT,
    fkS INT,
    PRIMARY KEY (fkU, fkS),
    FOREIGN KEY (fkU) REFERENCES Utilisateur(pkU),
    FOREIGN KEY (fkS) REFERENCES Salon(pkS)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Table Message
CREATE TABLE Message (
    pkMsg INT AUTO_INCREMENT PRIMARY KEY,
    fkU INT,
    fkS INT,
    message TEXT NOT NULL,
    timestamp DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (fkU) REFERENCES Utilisateur(pkU),
    FOREIGN KEY (fkS) REFERENCES Salon(pkS)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Insert data into Message
INSERT INTO Message (pkMsg, fkU, fkS, message, timestamp) VALUES
(1, 1, 1, 'testtt messageeee', '2025-07-04 14:53:02'),
(2, 1, 1, 'ahaha', '2025-07-04 15:06:46'),
(3, 1, 1, 'ououou', '2025-07-04 15:06:51'),
(4, 1, 1, 'ouou', '2025-07-04 15:06:55'),
(5, 1, 1, 'edazdzadazdza', '2025-07-06 12:27:28'),
(6, 2, 1, 'dzadzadza', '2025-07-09 18:31:44'),
(7, 2, 1, 'dqsdqs', '2025-07-09 18:31:47'),
(8, 1, 1, 'dazdazdza', '2025-07-09 18:32:11');

COMMIT;
