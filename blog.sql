-- MySQL dump 10.13  Distrib 8.0.27, for Linux (x86_64)
--
-- Host: localhost    Database: chat_web
-- ------------------------------------------------------
-- Server version 8.0.27

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

-- Table roles
CREATE TABLE roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    label VARCHAR(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Insert data into roles
INSERT INTO roles (id, label) VALUES
(1, 'Member'),
(2, 'Admin');

-- Table users
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    role_id INT,
    pseudo VARCHAR(50) NOT NULL,
    login VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    FOREIGN KEY (role_id) REFERENCES roles(id),
    INDEX idx_role_id (role_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Insert data into users
INSERT INTO users (id, role_id, pseudo, login, password, email) VALUES
(1, 1, 'Adam', 'Adam', '$2y$10$VqcnJFjqWyBorMy2gEjmP.r.YcdMaHtXJBJVkSCG5hnhWwZUk5aS6', 'adam@gmail.com'),
(2, 1, 'Nathan', 'Nathan', '$2y$10$TK3VI9.QTK6xJNzQtw2cwe4nH4ivb1O0SMLuJBVm0zT7VhEc1Kg1q', 'nathan@gmail.com'),
(3, 1, 'Xavier', 'Xavier', '$2y$10$bfnrHwsbPcrKWGNwdOdUTeomWN/q0O530wiADKP7oKLg410wrlQAK', 'xavier@gmail.com');

-- Table rooms
CREATE TABLE rooms (
    id INT AUTO_INCREMENT PRIMARY KEY,
    owner_id INT,
    name VARCHAR(100) NOT NULL,
    is_visible BOOLEAN DEFAULT TRUE,
    is_private BOOLEAN DEFAULT FALSE,
    topic VARCHAR(255),
    FOREIGN KEY (owner_id) REFERENCES users(id),
    INDEX idx_owner_id (owner_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Insert data into rooms
INSERT INTO rooms (id, owner_id, name, is_visible, is_private, topic) VALUES
(1, 1, 'nathanLeGay', 1, 0, 'testtt'),
(2, 1, 'ahahahaha', 1, 0, 'hahahaaXDDDXDX');

-- Table moderators
CREATE TABLE moderators (
    user_id INT,
    room_id INT,
    PRIMARY KEY (user_id, room_id),
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (room_id) REFERENCES rooms(id),
    INDEX idx_user_id (user_id),
    INDEX idx_room_id (room_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Table members
CREATE TABLE members (
    user_id INT,
    room_id INT,
    PRIMARY KEY (user_id, room_id),
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (room_id) REFERENCES rooms(id),
    INDEX idx_user_id (user_id),
    INDEX idx_room_id (room_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Table messages
CREATE TABLE messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    room_id INT,
    message TEXT NOT NULL,
    timestamp DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (room_id) REFERENCES rooms(id),
    INDEX idx_user_id (user_id),
    INDEX idx_room_id (room_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Insert data into messages
INSERT INTO messages (id, user_id, room_id, message, timestamp) VALUES
(1, 1, 1, 'Salut', '2025-07-04 14:53:02'),
(2, 1, 1, 'Ca va?', '2025-07-04 15:06:46'),
(3, 2, 1, 'Tres bien et Toi?', '2025-07-04 15:06:51'),
(4, 1, 1, '!!!! :)', '2025-07-04 15:06:55'),

COMMIT;
