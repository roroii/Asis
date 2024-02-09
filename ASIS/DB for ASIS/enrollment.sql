-- MySQL dump 10.13  Distrib 8.0.33, for Win64 (x86_64)
--
-- Host: 192.168.10.101    Database: enrollment
-- ------------------------------------------------------
-- Server version	8.0.32

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `admission`
--

DROP TABLE IF EXISTS `admission`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `admission` (
  `idadmission` int NOT NULL AUTO_INCREMENT,
  `lastname` varchar(45) DEFAULT NULL,
  `firstname` varchar(45) DEFAULT NULL,
  `mi` varchar(45) DEFAULT NULL,
  `ext` varchar(45) DEFAULT NULL,
  `etc` varchar(45) DEFAULT NULL,
  `etc1` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idadmission`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admission`
--

LOCK TABLES `admission` WRITE;
/*!40000 ALTER TABLE `admission` DISABLE KEYS */;
/*!40000 ALTER TABLE `admission` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `campus`
--

DROP TABLE IF EXISTS `campus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `campus` (
  `idcampus` int NOT NULL AUTO_INCREMENT,
  `campusname` varchar(45) DEFAULT NULL,
  `campusaddress` varchar(45) DEFAULT NULL,
  `campuscategory` varchar(45) DEFAULT NULL,
  `active` varchar(45) DEFAULT '1',
  PRIMARY KEY (`idcampus`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `campus`
--

LOCK TABLES `campus` WRITE;
/*!40000 ALTER TABLE `campus` DISABLE KEYS */;
INSERT INTO `campus` VALUES (1,'Main-Campus',NULL,'Transactional','1'),(2,'Sulop-Campus',NULL,'Extension','1'),(3,'Matanao-Campus',NULL,'Extension','1'),(4,'Kapatagan-Campus',NULL,'Satellite','1'),(5,'Padada',NULL,'Satellite','1');
/*!40000 ALTER TABLE `campus` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `course`
--

DROP TABLE IF EXISTS `course`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `course` (
  `idcourse` int NOT NULL AUTO_INCREMENT,
  `coursenumber` varchar(45) DEFAULT NULL,
  `coursedescriptions` varchar(445) DEFAULT NULL,
  `courseunits` varchar(45) DEFAULT NULL,
  `credittostudentunit` varchar(45) DEFAULT NULL,
  `entrydate` datetime DEFAULT CURRENT_TIMESTAMP,
  `active` varchar(45) DEFAULT '1',
  PRIMARY KEY (`idcourse`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `course`
--

LOCK TABLES `course` WRITE;
/*!40000 ALTER TABLE `course` DISABLE KEYS */;
INSERT INTO `course` VALUES (1,'IT-111','Introduction to Programming','3','3','2023-04-27 15:10:14','1'),(2,'IT-112','Programming 2','3','3','2023-04-27 15:10:14','1');
/*!40000 ALTER TABLE `course` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `department`
--

DROP TABLE IF EXISTS `department`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `department` (
  `iddepartment` int NOT NULL AUTO_INCREMENT,
  `departmentname` varchar(45) DEFAULT NULL,
  `descriptions` varchar(45) DEFAULT NULL,
  `entrydate` datetime DEFAULT CURRENT_TIMESTAMP,
  `active` varchar(45) DEFAULT '1',
  PRIMARY KEY (`iddepartment`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='	';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `department`
--

LOCK TABLES `department` WRITE;
/*!40000 ALTER TABLE `department` DISABLE KEYS */;
/*!40000 ALTER TABLE `department` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `institute`
--

DROP TABLE IF EXISTS `institute`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `institute` (
  `idinstitute` int NOT NULL AUTO_INCREMENT,
  `institutename` varchar(45) DEFAULT NULL,
  `institutedescription` varchar(445) DEFAULT NULL,
  `active` varchar(45) DEFAULT '1',
  `entrydate` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idinstitute`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `institute`
--

LOCK TABLES `institute` WRITE;
/*!40000 ALTER TABLE `institute` DISABLE KEYS */;
INSERT INTO `institute` VALUES (1,'ICET','Institute of Computing, Engineering and Technology','1','2023-04-27 15:16:59'),(2,'IGPE','Institute of Computing, Engineering and Technology','1','2023-04-27 15:16:59'),(3,'ITED','Institute of Computing, Engineering and Technology','1','2023-04-27 15:16:59'),(4,'IMAS','Institute of Computing, Engineering and Technology','1','2023-04-27 15:16:59'),(5,'IARS','Institute of Computing, Engineering and Technology','1','2023-04-27 15:16:59'),(6,'IBEG','Institute of Computing, Engineering and Technology','1','2023-04-27 15:16:59');
/*!40000 ALTER TABLE `institute` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `program`
--

DROP TABLE IF EXISTS `program`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `program` (
  `idprogram` int NOT NULL AUTO_INCREMENT,
  `programname` varchar(45) DEFAULT NULL,
  `major` varchar(45) DEFAULT NULL,
  `description` varchar(45) DEFAULT NULL,
  `cmo` varchar(45) DEFAULT NULL,
  `entrydate` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idprogram`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `program`
--

LOCK TABLES `program` WRITE;
/*!40000 ALTER TABLE `program` DISABLE KEYS */;
INSERT INTO `program` VALUES (1,'BSIT','IT','Bachelor of Science in Information Technology','CMO 25.S.2015','2023-04-27 13:31:45'),(2,'BSIS','Information System','Bachelor of Science in Information System','CMO 25.S.2015','2023-04-27 13:32:40');
/*!40000 ALTER TABLE `program` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `schoolsemester`
--

DROP TABLE IF EXISTS `schoolsemester`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `schoolsemester` (
  `idschoolsem` int NOT NULL AUTO_INCREMENT,
  `schoolyear` varchar(45) DEFAULT NULL,
  `semester` varchar(45) DEFAULT NULL,
  `active` varchar(45) DEFAULT '1',
  PRIMARY KEY (`idschoolsem`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `schoolsemester`
--

LOCK TABLES `schoolsemester` WRITE;
/*!40000 ALTER TABLE `schoolsemester` DISABLE KEYS */;
/*!40000 ALTER TABLE `schoolsemester` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `schoolyear`
--

DROP TABLE IF EXISTS `schoolyear`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `schoolyear` (
  `idschoolyear` int NOT NULL AUTO_INCREMENT,
  `schoolyear` varchar(45) DEFAULT NULL,
  `semester` varchar(45) DEFAULT NULL,
  `active` varchar(45) DEFAULT '1',
  PRIMARY KEY (`idschoolyear`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `schoolyear`
--

LOCK TABLES `schoolyear` WRITE;
/*!40000 ALTER TABLE `schoolyear` DISABLE KEYS */;
INSERT INTO `schoolyear` VALUES (1,'2022-2023',NULL,'1'),(2,'2023-2024',NULL,'1');
/*!40000 ALTER TABLE `schoolyear` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `semester`
--

DROP TABLE IF EXISTS `semester`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `semester` (
  `idsemester` int NOT NULL AUTO_INCREMENT,
  `semester` varchar(45) DEFAULT NULL,
  `schoolyear` varchar(45) DEFAULT NULL,
  `active` varchar(45) DEFAULT '1',
  PRIMARY KEY (`idsemester`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `semester`
--

LOCK TABLES `semester` WRITE;
/*!40000 ALTER TABLE `semester` DISABLE KEYS */;
INSERT INTO `semester` VALUES (1,'1st',NULL,'1'),(2,'2nd',NULL,'1'),(3,'summer',NULL,'1');
/*!40000 ALTER TABLE `semester` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-07-20 13:49:07
