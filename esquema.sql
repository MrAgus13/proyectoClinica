-- MariaDB dump 10.19  Distrib 10.11.6-MariaDB, for debian-linux-gnu (aarch64)
--
-- Host: localhost    Database: clinica
-- ------------------------------------------------------
-- Server version	10.11.6-MariaDB-0+deb12u1

-- Crear la base de datos `clinica` si no existe
CREATE DATABASE IF NOT EXISTS `clinica` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

-- Usar la base de datos `clinica`
USE `clinica`;

-- Crear el usuario 'alumne' con la contraseña 'alumne'
CREATE USER IF NOT EXISTS 'alumne'@'localhost' IDENTIFIED BY 'alumne';

-- Otorgar privilegios al usuario 'alumne' sobre la base de datos 'clinica'
GRANT ALL PRIVILEGES ON `clinica`.* TO 'alumne'@'localhost';

-- Aplicar los privilegios
FLUSH PRIVILEGES;

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
-- Table structure for table `ADMIN`
--

DROP TABLE IF EXISTS `ADMIN`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ADMIN` (
  `ID_ADMIN` int(11) NOT NULL AUTO_INCREMENT,
  `USUARIO_ADMIN` varchar(255) NOT NULL,
  `NOMBRE` varchar(100) NOT NULL,
  `CONTRASENA` varchar(255) NOT NULL,
  PRIMARY KEY (`ID_ADMIN`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
-- Insertar el registro de Celia como Administrador
INSERT INTO ADMIN (USUARIO_ADMIN, NOMBRE, CONTRASENA)
VALUES ('celia@gmail.com', 'Celia', '123');




--
-- Table structure for table `ADMIN_TICKETS`
--

DROP TABLE IF EXISTS `ADMIN_TICKETS`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ADMIN_TICKETS` (
  `ID_ADTICK` int(11) NOT NULL AUTO_INCREMENT,
  `ID_ADMIN` int(11) DEFAULT NULL,
  `ID_TICKET` int(11) DEFAULT NULL,
  `COMENTARIOS` text DEFAULT NULL,
  PRIMARY KEY (`ID_ADTICK`),
  KEY `ID_ADMIN` (`ID_ADMIN`),
  KEY `ID_TICKET` (`ID_TICKET`),
  CONSTRAINT `ADMIN_TICKETS_ibfk_1` FOREIGN KEY (`ID_ADMIN`) REFERENCES `ADMIN` (`ID_ADMIN`),
  CONSTRAINT `ADMIN_TICKETS_ibfk_2` FOREIGN KEY (`ID_TICKET`) REFERENCES `TICKETS` (`ID_TICKET`)
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ARCHIVOS`
--

DROP TABLE IF EXISTS `ARCHIVOS`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ARCHIVOS` (
  `ID_ARCHIVO` int(11) NOT NULL AUTO_INCREMENT,
  `NOMBRE_ARCHIVO` varchar(255) NOT NULL,
  `RUTA_ARCHIVO` text DEFAULT NULL,
  `ID_TICKET` int(11) DEFAULT NULL,
  `ID_ADTICK` int(11) DEFAULT NULL,
  `ID_USTICK` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID_ARCHIVO`),
  KEY `ID_TICKET` (`ID_TICKET`),
  KEY `ID_ADTICK` (`ID_ADTICK`),
  KEY `FK_ID_USTICK` (`ID_USTICK`),
  CONSTRAINT `ARCHIVOS_ibfk_1` FOREIGN KEY (`ID_TICKET`) REFERENCES `TICKETS` (`ID_TICKET`),
  CONSTRAINT `ARCHIVOS_ibfk_2` FOREIGN KEY (`ID_ADTICK`) REFERENCES `ADMIN_TICKETS` (`ID_ADTICK`),
  CONSTRAINT `FK_ID_USTICK` FOREIGN KEY (`ID_USTICK`) REFERENCES `USER_TICKETS` (`ID_USTICK`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `TICKETS`
--

DROP TABLE IF EXISTS `TICKETS`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `TICKETS` (
  `ID_TICKET` int(11) NOT NULL,
  `FECHA_HECHO` date NOT NULL,
  `FECHA_CREACION` timestamp NULL DEFAULT current_timestamp(),
  `PRIORIDAD` varchar(50) DEFAULT NULL,
  `ESTADO` varchar(50) NOT NULL DEFAULT 'Nueva',
  `DESCRIPCION` varchar(255) NOT NULL,
  `ASUNTO` varchar(100) NOT NULL,
  `LUGAR` varchar(100) NOT NULL,
  `PROCESADO` tinyint(1) NOT NULL DEFAULT 0,
  `ID_USUARIO` int(11) DEFAULT NULL,
  `ID_ADMIN` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID_TICKET`),
  KEY `ID_USUARIO` (`ID_USUARIO`),
  KEY `ID_ADMIN` (`ID_ADMIN`),
  CONSTRAINT `TICKETS_ibfk_1` FOREIGN KEY (`ID_USUARIO`) REFERENCES `USUARIOS` (`ID_USUARIO`),
  CONSTRAINT `TICKETS_ibfk_2` FOREIGN KEY (`ID_ADMIN`) REFERENCES `ADMIN` (`ID_ADMIN`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `USER_TICKETS`
--

DROP TABLE IF EXISTS `USER_TICKETS`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `USER_TICKETS` (
  `ID_USTICK` int(11) NOT NULL AUTO_INCREMENT,
  `ID_USER` int(11) DEFAULT NULL,
  `ID_TICKET` int(11) DEFAULT NULL,
  `COMENTARIOS` text DEFAULT NULL,
  PRIMARY KEY (`ID_USTICK`),
  KEY `ID_USER` (`ID_USER`),
  KEY `ID_TICKET` (`ID_TICKET`),
  CONSTRAINT `USER_TICKETS_ibfk_1` FOREIGN KEY (`ID_USER`) REFERENCES `USUARIOS` (`ID_USUARIO`),
  CONSTRAINT `USER_TICKETS_ibfk_2` FOREIGN KEY (`ID_TICKET`) REFERENCES `TICKETS` (`ID_TICKET`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `USUARIOS`
--

DROP TABLE IF EXISTS `USUARIOS`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `USUARIOS` (
  `ID_USUARIO` int(11) NOT NULL AUTO_INCREMENT,
  `NOMBRE` varchar(255) DEFAULT NULL,
  `CORREO` varchar(255) NOT NULL,
  PRIMARY KEY (`ID_USUARIO`),
  UNIQUE KEY `CORREO` (`CORREO`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO USUARIOS (ID_USUARIO, NOMBRE, CORREO)
VALUES (1, 'Anonimo', '');

/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-12-09 21:39:28
