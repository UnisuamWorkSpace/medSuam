-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: bd_medsuam
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

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
-- Table structure for table `adm`
--

DROP TABLE IF EXISTS `adm`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `adm` (
  `id_adm` int(11) NOT NULL AUTO_INCREMENT,
  `nome_adm` varchar(255) NOT NULL,
  `senha_adm` varchar(100) NOT NULL,
  `email_adm` varchar(255) NOT NULL,
  `cpf_adm` varchar(20) NOT NULL,
  `data_nasc_adm` date NOT NULL,
  `nivel_acesso` enum('super','adm') NOT NULL,
  `data_criacao` datetime NOT NULL,
  `ultimo_login` datetime DEFAULT NULL,
  PRIMARY KEY (`id_adm`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `adm`
--

LOCK TABLES `adm` WRITE;
/*!40000 ALTER TABLE `adm` DISABLE KEYS */;
INSERT INTO `adm` VALUES (1,'SUPER01','$2a$12$Odc6bp3kGVod5dyjzGjatuL36brYzWmCNNfR54utoHLSy167H2ou6','ronidomingues.ard@gmail.com','123.456.789-00','1990-01-01','super','2025-10-22 18:02:33','2025-11-03 02:44:15'),(4,'ADM01','$2y$10$pCOcANSM.Ela/hx/f/kideIZaL.CG3P9XcshqW2G8MO/FX03zKUzS','ADM01@gmail.com','14785236912','1996-01-08','adm','2025-10-27 14:17:22','2025-11-02 13:10:00');
/*!40000 ALTER TABLE `adm` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `assistente_medico`
--

DROP TABLE IF EXISTS `assistente_medico`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `assistente_medico` (
  `id_monitoramento` int(11) NOT NULL AUTO_INCREMENT,
  `id_paciente` int(11) NOT NULL,
  `status_monitoramento` varchar(255) NOT NULL,
  `nivel_risco` varchar(45) NOT NULL,
  PRIMARY KEY (`id_monitoramento`,`id_paciente`),
  KEY `fk_MEDICO_FANTASMA_PACIENTE1_idx` (`id_paciente`),
  CONSTRAINT `fk_MEDICO_FANTASMA_PACIENTE1` FOREIGN KEY (`id_paciente`) REFERENCES `paciente` (`id_paciente`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `assistente_medico`
--

LOCK TABLES `assistente_medico` WRITE;
/*!40000 ALTER TABLE `assistente_medico` DISABLE KEYS */;
INSERT INTO `assistente_medico` VALUES (1,17,'ativo','baixo'),(2,18,'ativo','médio'),(3,19,'inativo','alto'),(4,20,'ativo','baixo'),(5,21,'ativo','médio'),(6,22,'ativo','baixo'),(7,23,'inativo','alto'),(8,24,'ativo','médio'),(9,25,'ativo','baixo'),(10,26,'ativo','médio');
/*!40000 ALTER TABLE `assistente_medico` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `atualizacao_adm`
--

DROP TABLE IF EXISTS `atualizacao_adm`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `atualizacao_adm` (
  `id_atualizacao` int(11) NOT NULL AUTO_INCREMENT,
  `paciente_id_paciente` int(11) DEFAULT NULL,
  `adm_id_adm` int(11) DEFAULT NULL,
  `medico_id_medico` int(11) DEFAULT NULL,
  `descricao_atualizacao` varchar(255) NOT NULL,
  `data_atualizacao` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_atualizacao`),
  KEY `fk_atualizacao_adm_adm1_idx` (`adm_id_adm`),
  KEY `fk_atualizacao_adm_medico1_idx` (`medico_id_medico`),
  KEY `fk_atualizacao_adm_paciente1` (`paciente_id_paciente`),
  CONSTRAINT `fk_atualizacao_adm_adm1` FOREIGN KEY (`adm_id_adm`) REFERENCES `adm` (`id_adm`),
  CONSTRAINT `fk_atualizacao_adm_medico1` FOREIGN KEY (`medico_id_medico`) REFERENCES `medico` (`id_medico`),
  CONSTRAINT `fk_atualizacao_adm_paciente1` FOREIGN KEY (`paciente_id_paciente`) REFERENCES `paciente` (`id_paciente`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `atualizacao_adm`
--

LOCK TABLES `atualizacao_adm` WRITE;
/*!40000 ALTER TABLE `atualizacao_adm` DISABLE KEYS */;
INSERT INTO `atualizacao_adm` VALUES (1,NULL,1,NULL,'Adicionou administrador: Ronivaldo Domingues de Andrade','2025-10-22 18:16:06'),(2,NULL,1,NULL,'Adicionou administrador: Teste','2025-10-22 20:59:02'),(3,NULL,1,NULL,'Alterou status do paciente para: inativo','2025-10-22 21:24:13'),(4,NULL,1,NULL,'Alterou status do paciente para: ativo','2025-10-22 21:24:17'),(5,NULL,1,NULL,'Alterou status do paciente para: inativo','2025-10-22 21:25:08'),(6,NULL,1,NULL,'Alterou status do paciente para: ativo','2025-10-22 21:25:09'),(7,NULL,NULL,NULL,'Fez login no sistema','2025-10-24 15:46:01'),(8,NULL,NULL,NULL,'Fez login no sistema','2025-10-24 15:49:35'),(9,NULL,NULL,NULL,'Alterou status do paciente para: inativo','2025-10-27 14:04:32'),(10,NULL,NULL,NULL,'Alterou status do paciente para: ativo','2025-10-27 14:04:33'),(11,NULL,NULL,NULL,'Alterou status do paciente para: ativo','2025-10-27 14:09:09'),(12,NULL,NULL,NULL,'Editou administrador: Ronivaldo Domingues de Andrade','2025-10-27 14:15:59'),(13,NULL,NULL,NULL,'Editou administrador: Ronivaldo Domingues de Andrade','2025-10-27 14:16:06'),(14,NULL,NULL,NULL,'Editou administrador: Ronivaldo Domingues de Andrade','2025-10-27 14:16:36'),(15,NULL,NULL,NULL,'Editou administrador: Ronivaldo Domingues de Andrade','2025-10-27 14:16:53'),(16,NULL,NULL,NULL,'Adicionou administrador: Teste','2025-10-27 14:17:22'),(17,NULL,1,NULL,'Editou administrador: Ronivaldo Domingues de Andrade','2025-10-27 14:31:22'),(18,NULL,NULL,NULL,'Editou administrador: Teste','2025-10-27 14:33:35'),(19,NULL,NULL,NULL,'Editou administrador: Teste01','2025-10-27 14:33:47'),(20,NULL,NULL,NULL,'Editou administrador: Teste02','2025-10-27 14:33:53'),(21,NULL,NULL,NULL,'Excluiu administrador ID: 3','2025-10-27 14:33:56'),(22,NULL,NULL,NULL,'Excluiu paciente ID: 1','2025-10-27 14:37:02'),(23,16,NULL,NULL,'Adicionou paciente: Ronivaldo Domingues de Andrade','2025-10-27 14:37:47'),(24,16,NULL,NULL,'Alterou status do paciente para: inativo','2025-10-27 14:41:13'),(25,16,NULL,NULL,'Alterou status do paciente para: ativo','2025-10-27 14:41:21'),(26,16,NULL,NULL,'Alterou status do paciente para: ativo','2025-10-27 14:45:54'),(27,NULL,NULL,2,'Adicionou médico: Ronivaldo Domingues de Andrade','2025-10-27 14:46:19'),(28,16,NULL,NULL,'Editou paciente: Ronivaldo Domingues de Andrade','2025-10-27 15:02:20'),(29,16,NULL,NULL,'Editou paciente: Ronivaldo Domingues de Andrade','2025-10-27 15:06:07'),(30,16,NULL,NULL,'Editou paciente: Persona 01','2025-10-27 15:06:53'),(31,NULL,NULL,NULL,'Editou administrador: ADM01','2025-10-27 15:10:14'),(32,NULL,NULL,NULL,'Alterou senha do administrador ID: 4','2025-10-27 15:10:38'),(33,NULL,4,NULL,'Agendou consulta ID: 1','2025-10-27 15:12:39'),(34,NULL,4,NULL,'Alterou status da consulta ID: 1 para: realizada','2025-10-27 15:14:08'),(35,NULL,4,NULL,'Alterou status da consulta ID: 1 para: cancelada','2025-10-27 15:14:12'),(36,NULL,1,NULL,'Excluiu administrador ID: 2','2025-10-27 16:31:49'),(37,NULL,1,2,'Editou médico: Persona 01','2025-10-27 16:35:38'),(38,16,1,NULL,'Editou paciente: Persona 02','2025-10-27 16:36:45'),(39,NULL,1,NULL,'Alterou status da consulta ID: 1 para: agendada','2025-10-27 16:36:55'),(40,NULL,1,NULL,'Editou administrador: SUPER01','2025-10-27 16:37:40'),(41,NULL,1,NULL,'Editou administrador: SUPER01','2025-11-02 12:34:29'),(42,NULL,1,NULL,'Editou administrador: ADM01','2025-11-02 13:08:48'),(43,NULL,1,NULL,'Alterou status da consulta ID: 1 para: confirmada','2025-11-02 13:09:27'),(44,NULL,1,NULL,'Alterou status da consulta ID: 1 para: agendada','2025-11-02 13:09:42');
/*!40000 ALTER TABLE `atualizacao_adm` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `condicao_saude`
--

DROP TABLE IF EXISTS `condicao_saude`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `condicao_saude` (
  `id_condicao` int(11) NOT NULL AUTO_INCREMENT,
  `nome_condicao` varchar(80) NOT NULL,
  `descricao` varchar(255) NOT NULL,
  `nivel_risco` int(11) NOT NULL,
  PRIMARY KEY (`id_condicao`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `condicao_saude`
--

LOCK TABLES `condicao_saude` WRITE;
/*!40000 ALTER TABLE `condicao_saude` DISABLE KEYS */;
INSERT INTO `condicao_saude` VALUES (1,'Hipertens├úo','Press├úo arterial persistentemente elevada',2),(2,'Diabetes tipo 2','Altera├º├úo do metabolismo da glicose',3),(3,'Asma','Doen├ºa inflamat├│ria cr├┤nica das vias a├®reas',2),(4,'DPOC','Doen├ºa pulmonar obstrutiva cr├┤nica',3),(5,'Hipotireoidismo','Baixa atividade da tireoide',2),(6,'Depress├úo','Transtorno do humor com sintomas variados',2),(7,'Obesidade','├ìndice de massa corporal elevado',3),(8,'Insufici├¬ncia renal','Perda da fun├º├úo renal',4),(9,'Doen├ºa card├¡aca isqu├¬mica','Problemas por fluxo sangu├¡neo reduzido ao cora├º├úo',4),(10,'Alergia cr├┤nica','Rea├º├Áes al├®rgicas recorrentes',1);
/*!40000 ALTER TABLE `condicao_saude` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `consulta`
--

DROP TABLE IF EXISTS `consulta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `consulta` (
  `id_consulta` int(11) NOT NULL AUTO_INCREMENT,
  `id_paciente` int(11) NOT NULL,
  `id_medico` int(11) NOT NULL,
  `data_consulta` date NOT NULL,
  `hora_consulta` datetime NOT NULL,
  `status` varchar(255) NOT NULL,
  `gravacao_link` varchar(45) NOT NULL,
  `link_videochamada` varchar(45) NOT NULL,
  PRIMARY KEY (`id_consulta`,`id_paciente`,`id_medico`),
  KEY `fk_CONSULTA_PACIENTE1_idx` (`id_paciente`),
  KEY `fk_CONSULTA_MEDICO1_idx` (`id_medico`),
  CONSTRAINT `fk_CONSULTA_MEDICO1` FOREIGN KEY (`id_medico`) REFERENCES `medico` (`id_medico`),
  CONSTRAINT `fk_CONSULTA_PACIENTE1` FOREIGN KEY (`id_paciente`) REFERENCES `paciente` (`id_paciente`)
) ENGINE=InnoDB AUTO_INCREMENT=122 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `consulta`
--

LOCK TABLES `consulta` WRITE;
/*!40000 ALTER TABLE `consulta` DISABLE KEYS */;
INSERT INTO `consulta` VALUES (1,16,2,'2025-12-12','2025-12-12 15:35:00','agendada','',''),(2,17,3,'2024-01-15','2024-01-15 09:00:00','realizada','grav_2.pdf','https://vc/2'),(3,18,4,'2024-02-10','2024-02-10 10:30:00','realizada','grav_3.pdf','https://vc/3'),(4,19,5,'2024-03-05','2024-03-05 14:00:00','cancelada','',''),(5,20,6,'2024-03-20','2024-03-20 15:00:00','agendada','','https://vc/5'),(6,21,7,'2024-04-10','2024-04-10 08:30:00','realizada','grav_6.pdf','https://vc/6'),(7,22,8,'2024-05-22','2024-05-22 11:00:00','realizada','grav_7.pdf','https://vc/7'),(8,23,9,'2024-06-18','2024-06-18 13:15:00','realizada','grav_8.pdf','https://vc/8'),(9,24,10,'2024-07-09','2024-07-09 16:00:00','remarcada','','https://vc/9'),(10,25,11,'2024-07-25','2024-07-25 09:30:00','realizada','grav_10.pdf','https://vc/10'),(11,26,12,'2024-08-12','2024-08-12 10:00:00','agendada','','https://vc/11'),(12,27,13,'2024-09-01','2024-09-01 14:30:00','realizada','grav_12.pdf','https://vc/12'),(13,28,14,'2024-09-20','2024-09-20 15:45:00','cancelada','',''),(14,29,15,'2024-10-05','2024-10-05 11:00:00','realizada','grav_14.pdf','https://vc/14'),(15,30,16,'2024-11-10','2024-11-10 08:00:00','realizada','grav_15.pdf','https://vc/15'),(16,31,17,'2024-11-28','2024-11-28 09:15:00','agendada','','https://vc/16'),(17,32,18,'2024-12-09','2024-12-09 10:30:00','realizada','grav_17.pdf','https://vc/17'),(18,33,19,'2025-01-10','2025-01-10 11:00:00','realizada','grav_18.pdf','https://vc/18'),(19,34,20,'2025-01-22','2025-01-22 14:00:00','agendada','','https://vc/19'),(20,35,21,'2025-02-05','2025-02-05 15:20:00','realizada','grav_20.pdf','https://vc/20'),(21,36,22,'2025-02-18','2025-02-18 09:30:00','realizada','grav_21.pdf','https://vc/21'),(22,37,23,'2025-03-03','2025-03-03 10:45:00','cancelada','',''),(23,38,24,'2025-03-15','2025-03-15 13:00:00','agendada','','https://vc/23'),(24,39,25,'2025-03-25','2025-03-25 14:30:00','realizada','grav_24.pdf','https://vc/24'),(25,40,26,'2025-04-05','2025-04-05 08:00:00','realizada','grav_25.pdf','https://vc/25'),(26,41,27,'2025-04-20','2025-04-20 09:00:00','agendada','','https://vc/26'),(27,42,28,'2025-05-01','2025-05-01 10:00:00','realizada','grav_27.pdf','https://vc/27'),(28,43,29,'2025-05-14','2025-05-14 11:15:00','realizada','grav_28.pdf','https://vc/28'),(29,44,30,'2025-05-28','2025-05-28 15:00:00','agendada','','https://vc/29'),(30,45,31,'2025-06-08','2025-06-08 09:45:00','realizada','grav_30.pdf','https://vc/30'),(31,46,32,'2025-06-21','2025-06-21 10:30:00','realizada','grav_31.pdf','https://vc/31'),(32,47,33,'2025-07-02','2025-07-02 14:00:00','cancelada','',''),(33,48,34,'2025-07-18','2025-07-18 16:00:00','agendada','','https://vc/33'),(34,49,35,'2025-08-05','2025-08-05 08:30:00','realizada','grav_34.pdf','https://vc/34'),(35,50,36,'2025-08-20','2025-08-20 09:00:00','realizada','grav_35.pdf','https://vc/35'),(36,51,37,'2025-09-04','2025-09-04 11:30:00','agendada','','https://vc/36'),(37,52,38,'2025-09-19','2025-09-19 12:45:00','realizada','grav_37.pdf','https://vc/37'),(38,53,39,'2025-10-03','2025-10-03 15:00:00','realizada','grav_38.pdf','https://vc/38'),(39,54,40,'2025-10-17','2025-10-17 09:15:00','agendada','','https://vc/39'),(40,55,41,'2025-10-30','2025-10-30 10:30:00','realizada','grav_40.pdf','https://vc/40'),(41,56,42,'2025-11-12','2025-11-12 11:00:00','realizada','grav_41.pdf','https://vc/41'),(42,57,43,'2025-11-20','2025-11-20 14:00:00','agendada','','https://vc/42'),(43,58,44,'2024-06-06','2024-06-06 09:00:00','realizada','grav_43.pdf','https://vc/43'),(44,59,45,'2024-07-07','2024-07-07 10:00:00','realizada','grav_44.pdf','https://vc/44'),(45,60,46,'2024-08-08','2024-08-08 11:00:00','cancelada','',''),(46,61,47,'2024-09-09','2024-09-09 12:00:00','agendada','','https://vc/46'),(47,62,48,'2024-10-10','2024-10-10 13:00:00','realizada','grav_47.pdf','https://vc/47'),(48,63,49,'2024-11-11','2024-11-11 14:00:00','realizada','grav_48.pdf','https://vc/48'),(49,64,50,'2024-12-12','2024-12-12 15:00:00','agendada','','https://vc/49'),(50,65,51,'2025-01-13','2025-01-13 09:00:00','realizada','grav_50.pdf','https://vc/50'),(51,66,52,'2025-02-14','2025-02-14 10:15:00','realizada','grav_51.pdf','https://vc/51'),(52,17,4,'2025-03-16','2025-03-16 11:30:00','agendada','','https://vc/52'),(53,18,5,'2025-04-17','2025-04-17 14:45:00','realizada','grav_53.pdf','https://vc/53'),(54,19,6,'2025-05-18','2025-05-18 09:00:00','realizada','grav_54.pdf','https://vc/54'),(55,20,7,'2025-06-19','2025-06-19 10:30:00','cancelada','',''),(56,21,8,'2025-07-20','2025-07-20 11:45:00','agendada','','https://vc/56'),(57,22,9,'2025-08-21','2025-08-21 13:00:00','realizada','grav_57.pdf','https://vc/57'),(58,23,10,'2025-09-22','2025-09-22 08:30:00','realizada','grav_58.pdf','https://vc/58'),(59,24,11,'2025-10-23','2025-10-23 09:45:00','agendada','','https://vc/59'),(60,25,12,'2025-11-24','2025-11-24 11:00:00','realizada','grav_60.pdf','https://vc/60'),(61,26,13,'2024-02-05','2024-02-05 14:00:00','realizada','grav_61.pdf','https://vc/61'),(62,27,14,'2024-03-10','2024-03-10 15:30:00','agendada','','https://vc/62'),(63,28,15,'2024-04-12','2024-04-12 09:00:00','cancelada','',''),(64,29,16,'2024-05-14','2024-05-14 10:15:00','realizada','grav_64.pdf','https://vc/64'),(65,30,17,'2024-06-16','2024-06-16 11:30:00','realizada','grav_65.pdf','https://vc/65'),(66,31,18,'2024-07-18','2024-07-18 12:45:00','agendada','','https://vc/66'),(67,32,19,'2024-08-20','2024-08-20 14:00:00','realizada','grav_67.pdf','https://vc/67'),(68,33,20,'2024-09-22','2024-09-22 15:15:00','realizada','grav_68.pdf','https://vc/68'),(69,34,21,'2024-10-24','2024-10-24 09:00:00','cancelada','',''),(70,35,22,'2024-11-26','2024-11-26 10:30:00','agendada','','https://vc/70'),(71,36,23,'2024-12-28','2024-12-28 11:45:00','realizada','grav_71.pdf','https://vc/71'),(72,37,24,'2025-01-30','2025-01-30 13:00:00','realizada','grav_72.pdf','https://vc/72'),(73,38,25,'2025-03-02','2025-03-02 14:15:00','agendada','','https://vc/73'),(74,39,26,'2025-04-04','2025-04-04 09:45:00','realizada','grav_74.pdf','https://vc/74'),(75,40,27,'2025-05-06','2025-05-06 11:00:00','realizada','grav_75.pdf','https://vc/75'),(76,41,28,'2025-06-08','2025-06-08 12:15:00','agendada','','https://vc/76'),(77,42,29,'2025-07-10','2025-07-10 13:30:00','realizada','grav_77.pdf','https://vc/77'),(78,43,30,'2025-08-12','2025-08-12 15:45:00','realizada','grav_78.pdf','https://vc/78'),(79,44,31,'2025-09-14','2025-09-14 09:00:00','cancelada','',''),(80,45,32,'2025-10-16','2025-10-16 10:30:00','agendada','','https://vc/80'),(81,46,33,'2025-11-18','2025-11-18 11:45:00','realizada','grav_81.pdf','https://vc/81'),(82,47,34,'2024-01-20','2024-01-20 14:00:00','realizada','grav_82.pdf','https://vc/82'),(83,48,35,'2024-02-22','2024-02-22 09:15:00','agendada','','https://vc/83'),(84,49,36,'2024-03-24','2024-03-24 10:30:00','realizada','grav_84.pdf','https://vc/84'),(85,50,37,'2024-04-26','2024-04-26 11:45:00','realizada','grav_85.pdf','https://vc/85'),(86,51,38,'2024-05-28','2024-05-28 13:00:00','agendada','','https://vc/86'),(87,52,39,'2024-06-30','2024-06-30 14:15:00','realizada','grav_87.pdf','https://vc/87'),(88,53,40,'2024-07-31','2024-07-31 09:00:00','realizada','grav_88.pdf','https://vc/88'),(89,54,41,'2024-08-31','2024-08-31 10:30:00','agendada','','https://vc/89'),(90,55,42,'2024-09-30','2024-09-30 11:45:00','realizada','grav_90.pdf','https://vc/90'),(91,56,43,'2024-10-29','2024-10-29 14:00:00','realizada','grav_91.pdf','https://vc/91'),(92,57,44,'2024-11-28','2024-11-28 15:15:00','agendada','','https://vc/92'),(93,58,45,'2024-12-27','2024-12-27 09:00:00','realizada','grav_93.pdf','https://vc/93'),(94,59,46,'2025-01-26','2025-01-26 10:30:00','realizada','grav_94.pdf','https://vc/94'),(95,60,47,'2025-02-25','2025-02-25 11:45:00','agendada','','https://vc/95'),(96,61,48,'2025-03-26','2025-03-26 13:00:00','realizada','grav_96.pdf','https://vc/96'),(97,62,49,'2025-04-27','2025-04-27 14:15:00','realizada','grav_97.pdf','https://vc/97'),(98,63,50,'2025-05-28','2025-05-28 15:30:00','agendada','','https://vc/98'),(99,64,51,'2025-06-29','2025-06-29 09:00:00','realizada','grav_99.pdf','https://vc/99'),(100,65,52,'2025-07-30','2025-07-30 10:15:00','realizada','grav_100.pdf','https://vc/100'),(101,66,3,'2025-08-31','2025-08-31 11:30:00','agendada','','https://vc/101'),(102,17,4,'2025-09-01','2025-09-01 14:45:00','realizada','grav_102.pdf','https://vc/102'),(103,18,5,'2025-10-02','2025-10-02 09:00:00','realizada','grav_103.pdf','https://vc/103'),(104,19,6,'2025-11-03','2025-11-03 10:30:00','agendada','','https://vc/104'),(105,20,7,'2024-01-04','2024-01-04 11:45:00','realizada','grav_105.pdf','https://vc/105'),(106,21,8,'2024-02-05','2024-02-05 13:00:00','realizada','grav_106.pdf','https://vc/106'),(107,22,9,'2024-03-06','2024-03-06 14:15:00','agendada','','https://vc/107'),(108,23,10,'2024-04-07','2024-04-07 09:30:00','realizada','grav_108.pdf','https://vc/108'),(109,24,11,'2024-05-08','2024-05-08 10:45:00','realizada','grav_109.pdf','https://vc/109'),(110,25,12,'2024-06-09','2024-06-09 12:00:00','agendada','','https://vc/110'),(111,26,13,'2024-07-10','2024-07-10 13:15:00','realizada','grav_111.pdf','https://vc/111'),(112,27,14,'2024-08-11','2024-08-11 14:30:00','realizada','grav_112.pdf','https://vc/112'),(113,28,15,'2024-09-12','2024-09-12 15:45:00','cancelada','',''),(114,29,16,'2024-10-13','2024-10-13 09:00:00','agendada','','https://vc/114'),(115,30,17,'2024-11-14','2024-11-14 10:15:00','realizada','grav_115.pdf','https://vc/115'),(116,31,18,'2024-12-15','2024-12-15 11:30:00','realizada','grav_116.pdf','https://vc/116'),(117,32,19,'2025-01-16','2025-01-16 12:45:00','agendada','','https://vc/117'),(118,33,20,'2025-02-17','2025-02-17 14:00:00','realizada','grav_118.pdf','https://vc/118'),(119,34,21,'2025-03-18','2025-03-18 15:15:00','realizada','grav_119.pdf','https://vc/119'),(120,35,22,'2025-04-19','2025-04-19 09:30:00','agendada','','https://vc/120'),(121,36,23,'2025-05-20','2025-05-20 10:45:00','realizada','grav_121.pdf','https://vc/121');
/*!40000 ALTER TABLE `consulta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `endereco`
--

DROP TABLE IF EXISTS `endereco`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `endereco` (
  `id_endereco` int(11) NOT NULL AUTO_INCREMENT,
  `cep` varchar(10) NOT NULL,
  `rua` varchar(50) NOT NULL,
  `numero` int(11) NOT NULL,
  `complemento` varchar(45) DEFAULT NULL,
  `bairro` varchar(100) NOT NULL,
  `cidade` varchar(100) NOT NULL,
  `uf_endereco` varchar(2) NOT NULL,
  `paciente_id_paciente` int(11) DEFAULT NULL,
  `medico_id_medico` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_endereco`),
  KEY `fk_endereco_paciente1_idx` (`paciente_id_paciente`),
  KEY `fk_endereco_medico1_idx` (`medico_id_medico`),
  CONSTRAINT `fk_endereco_medico1` FOREIGN KEY (`medico_id_medico`) REFERENCES `medico` (`id_medico`),
  CONSTRAINT `fk_endereco_paciente1` FOREIGN KEY (`paciente_id_paciente`) REFERENCES `paciente` (`id_paciente`)
) ENGINE=InnoDB AUTO_INCREMENT=102 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `endereco`
--

LOCK TABLES `endereco` WRITE;
/*!40000 ALTER TABLE `endereco` DISABLE KEYS */;
INSERT INTO `endereco` VALUES (2,'20010-000','Rua Primeiro de Março',100,'Sala 101','Centro','Rio de Janeiro','RJ',NULL,3),(3,'20120-010','Av. Atlântica',2500,'Apt 702','Copacabana','Rio de Janeiro','RJ',NULL,4),(4,'20230-020','Rua das Laranjeiras',50,NULL,'Laranjeiras','Rio de Janeiro','RJ',NULL,5),(5,'21010-030','Rua Visconde de Pirajá',800,'Sala 3','Ipanema','Rio de Janeiro','RJ',NULL,6),(6,'22011-040','Av. Brasil',1500,NULL,'Vasco','Rio de Janeiro','RJ',NULL,7),(7,'23012-050','Rua do Ouvidor',120,NULL,'Centro','Niterói','RJ',NULL,8),(8,'24013-060','Rua Princesa Isabel',400,NULL,'Centro','Niterói','RJ',NULL,9),(9,'25014-070','Av. Presidente Vargas',900,NULL,'Centro','Rio de Janeiro','RJ',NULL,10),(10,'26015-080','Rua da Constituição',60,NULL,'Leme','Rio de Janeiro','RJ',NULL,11),(11,'27016-090','Rua do Catete',200,NULL,'Catete','Rio de Janeiro','RJ',NULL,12),(12,'28017-100','Av. Niemeyer',500,NULL,'São Conrado','Rio de Janeiro','RJ',NULL,13),(13,'29018-110','Rua do Humaitá',45,NULL,'Humaitá','Rio de Janeiro','RJ',NULL,14),(14,'30019-120','Rua Conde de Bonfim',320,NULL,'Tijuca','Rio de Janeiro','RJ',NULL,15),(15,'31020-130','Rua Barata Ribeiro',210,NULL,'Copacabana','Rio de Janeiro','RJ',NULL,16),(16,'32021-140','Av. das Américas',4200,'Sala 204','Barra da Tijuca','Rio de Janeiro','RJ',NULL,17),(17,'33022-150','Rua Real Grandeza',77,NULL,'Botafogo','Rio de Janeiro','RJ',NULL,18),(18,'34023-160','Rua Visconde de Inhaúma',90,NULL,'Centro','Niterói','RJ',NULL,19),(19,'35024-170','Rua do Senado',10,NULL,'Centro','Angra dos Reis','RJ',NULL,20),(20,'36025-180','Av. Rio Branco',123,NULL,'Centro','Rio de Janeiro','RJ',NULL,21),(21,'37026-190','Rua Adalberto Ferro',5,NULL,'Icaraí','Rio de Janeiro','RJ',NULL,22),(22,'38027-200','Rua Dr. Nilo Peçanha',60,NULL,'Centro','Rio de Janeiro','RJ',NULL,23),(23,'39028-210','Rua Santa Clara',160,NULL,'Centro','Niterói','RJ',NULL,24),(24,'40029-220','Rua Senador Dantas',300,NULL,'Centro','Rio de Janeiro','RJ',NULL,25),(25,'41030-230','Av. das Acácias',88,NULL,'Barra da Tijuca','Rio de Janeiro','RJ',NULL,26),(26,'42031-240','Rua Siqueira Campos',7,NULL,'Copacabana','Rio de Janeiro','RJ',NULL,27),(27,'43032-250','Rua Professor Aristides',44,NULL,'Botafogo','Rio de Janeiro','RJ',NULL,28),(28,'44033-260','Av. Henrique Valadares',200,NULL,'Centro','Rio de Janeiro','RJ',NULL,29),(29,'45034-270','Rua Capitão Salomão',18,NULL,'Niterói','Rio de Janeiro','RJ',NULL,30),(30,'46035-280','Rua das Palmeiras',300,NULL,'Barra da Tijuca','Rio de Janeiro','RJ',NULL,31),(31,'47036-290','Rua do Mercado',6,NULL,'Centro','Rio de Janeiro','RJ',NULL,32),(32,'48037-300','Rua General Osório',120,NULL,'Copacabana','Rio de Janeiro','RJ',NULL,33),(33,'49038-310','Rua do Riachuelo',33,NULL,'Centro','Rio de Janeiro','RJ',NULL,34),(34,'50039-320','Rua Marechal Floriano',55,NULL,'Centro','Niterói','RJ',NULL,35),(35,'51040-330','Rua das Rosas',19,NULL,'Ipanema','Rio de Janeiro','RJ',NULL,36),(36,'52041-340','Rua São Clemente',80,NULL,'Botafogo','Rio de Janeiro','RJ',NULL,37),(37,'53042-350','Rua Humaitá',90,NULL,'Humaitá','Rio de Janeiro','RJ',NULL,38),(38,'54043-360','Av. Atlântica',2300,NULL,'Copacabana','Rio de Janeiro','RJ',NULL,39),(39,'55044-370','Rua 1º de Março',130,NULL,'Centro','Rio de Janeiro','RJ',NULL,40),(40,'56045-380','Av. Pasteur',77,NULL,'Urca','Rio de Janeiro','RJ',NULL,41),(41,'57046-390','Rua Barão de Iguatemi',299,NULL,'Bangu','Rio de Janeiro','RJ',NULL,42),(42,'58047-400','Rua Coronel Moreira César',10,NULL,'Centro','Mesquita','RJ',NULL,43),(43,'59048-410','Av. Victor de Sá',900,NULL,'Niterói','Rio de Janeiro','RJ',NULL,44),(44,'60049-420','Rua Barão do Flamengo',15,NULL,'Flamengo','Rio de Janeiro','RJ',NULL,45),(45,'61050-430','Rua Itapiru',42,NULL,'Tijuca','Rio de Janeiro','RJ',NULL,46),(46,'62051-440','Rua do Russel',12,NULL,'Glória','Rio de Janeiro','RJ',NULL,47),(47,'63052-450','Rua Teresa',320,NULL,'Botafogo','Rio de Janeiro','RJ',NULL,48),(48,'64053-460','Av. Rio Branco',255,NULL,'Centro','Rio de Janeiro','RJ',NULL,49),(49,'65054-470','Rua do Lavradio',6,NULL,'Centro','Rio de Janeiro','RJ',NULL,50),(50,'66055-480','Rua Miguel Lemos',88,NULL,'Copacabana','Rio de Janeiro','RJ',NULL,51),(51,'67056-490','Rua Goiás',101,NULL,'Centro','Niterói','RJ',NULL,52),(52,'21030-000','Rua Afonso Pena',123,NULL,'Centro','Niterói','RJ',17,NULL),(53,'21031-010','Rua São João',45,NULL,'Centro','Rio de Janeiro','RJ',18,NULL),(54,'21032-020','Rua das Acácias',77,'Apto 21','Barra da Tijuca','Rio de Janeiro','RJ',19,NULL),(55,'21033-030','Rua Londres',200,NULL,'Ipanema','Rio de Janeiro','RJ',20,NULL),(56,'21034-040','Av. Presidente Vargas',101,NULL,'Centro','Rio de Janeiro','RJ',21,NULL),(57,'21035-050','Rua Borges de Medeiros',303,NULL,'Copacabana','Rio de Janeiro','RJ',22,NULL),(58,'21036-060','Rua Tenente Coronel',10,NULL,'Centro','Niterói','RJ',23,NULL),(59,'21037-070','Rua João Pessoa',5,NULL,'Centro','Niterói','RJ',24,NULL),(60,'21038-080','Rua Cel. Moreira',89,NULL,'Botafogo','Rio de Janeiro','RJ',25,NULL),(61,'21039-090','Rua João Caetano',160,NULL,'Centro','Rio de Janeiro','RJ',26,NULL),(62,'21100-100','Rua dos Andradas',220,NULL,'Centro','Niterói','RJ',27,NULL),(63,'21101-110','Rua das Rosas',77,NULL,'Ipanema','Rio de Janeiro','RJ',28,NULL),(64,'21102-120','Rua do Mercado',32,NULL,'Centro','Rio de Janeiro','RJ',29,NULL),(65,'21103-130','Rua Dr. Satamini',90,NULL,'Botafogo','Rio de Janeiro','RJ',30,NULL),(66,'21104-140','Rua 7 de Setembro',14,NULL,'Centro','Niterói','RJ',31,NULL),(67,'21105-150','Rua Campo Salles',6,NULL,'Centro','Rio de Janeiro','RJ',32,NULL),(68,'21106-160','Rua Joaquim Silva',44,NULL,'Barra da Tijuca','Rio de Janeiro','RJ',33,NULL),(69,'21107-170','Rua das Flores',75,NULL,'Copacabana','Rio de Janeiro','RJ',34,NULL),(70,'21108-180','Rua Santa Luzia',8,NULL,'Centro','Niterói','RJ',35,NULL),(71,'21109-190','Rua do Sol',110,NULL,'Ipanema','Rio de Janeiro','RJ',36,NULL),(72,'21110-200','Rua São Pedro',23,NULL,'Centro','Rio de Janeiro','RJ',37,NULL),(73,'21111-210','Rua Almirante',99,NULL,'Botafogo','Rio de Janeiro','RJ',38,NULL),(74,'21112-220','Rua do Pilar',18,NULL,'Centro','Niterói','RJ',39,NULL),(75,'21113-230','Rua Vila Rica',40,NULL,'Barra da Tijuca','Rio de Janeiro','RJ',40,NULL),(76,'21114-240','Rua dos Navegantes',55,NULL,'Copacabana','Rio de Janeiro','RJ',41,NULL),(77,'21115-250','Rua Cel. Ribeiro',70,NULL,'Centro','Rio de Janeiro','RJ',42,NULL),(78,'21116-260','Rua das Orquídeas',9,NULL,'Ipanema','Rio de Janeiro','RJ',43,NULL),(79,'21117-270','Rua do Comércio',3,NULL,'Centro','Niterói','RJ',44,NULL),(80,'21118-280','Rua Lins',36,NULL,'Centro','Rio de Janeiro','RJ',45,NULL),(81,'21119-290','Rua do Príncipe',44,NULL,'Botafogo','Rio de Janeiro','RJ',46,NULL),(82,'21120-300','Rua Nova',88,NULL,'Copacabana','Rio de Janeiro','RJ',47,NULL),(83,'21121-310','Rua dos Funcionários',12,NULL,'Centro','Niterói','RJ',48,NULL),(84,'21122-320','Rua do Lavradio',2,NULL,'Centro','Rio de Janeiro','RJ',49,NULL),(85,'21123-330','Rua Bento Ribeiro',33,NULL,'Barra da Tijuca','Rio de Janeiro','RJ',50,NULL),(86,'21124-340','Rua São Vicente',21,NULL,'Ipanema','Rio de Janeiro','RJ',51,NULL),(87,'21125-350','Rua Palmeira',64,NULL,'Centro','Niterói','RJ',52,NULL),(88,'21126-360','Rua Marechal',5,NULL,'Centro','Rio de Janeiro','RJ',53,NULL),(89,'21127-370','Rua Belizário',8,NULL,'Botafogo','Rio de Janeiro','RJ',54,NULL),(90,'21128-380','Rua João Ribeiro',40,NULL,'Copacabana','Rio de Janeiro','RJ',55,NULL),(91,'21129-390','Rua Ceará',90,NULL,'Ipanema','Rio de Janeiro','RJ',56,NULL),(92,'21130-400','Av. Princesa Isabel',100,NULL,'Centro','Niterói','RJ',57,NULL),(93,'21131-410','Rua Domingos',23,NULL,'Centro','Rio de Janeiro','RJ',58,NULL),(94,'21132-420','Rua das Palmeiras',77,NULL,'Barra da Tijuca','Rio de Janeiro','RJ',59,NULL),(95,'21133-430','Rua Felipe',17,NULL,'Botafogo','Rio de Janeiro','RJ',60,NULL),(96,'21134-440','Rua Vitória',200,NULL,'Copacabana','Rio de Janeiro','RJ',61,NULL),(97,'21135-450','Rua das Flores',11,NULL,'Centro','Niterói','RJ',62,NULL),(98,'21136-460','Rua do Pilar',9,NULL,'Centro','Rio de Janeiro','RJ',63,NULL),(99,'21137-470','Rua Santa Maria',32,NULL,'Ipanema','Rio de Janeiro','RJ',64,NULL),(100,'21138-480','Av. Central',55,NULL,'Copacabana','Rio de Janeiro','RJ',65,NULL),(101,'21139-490','Rua do Carmo',7,NULL,'Centro','Rio de Janeiro','RJ',66,NULL);
/*!40000 ALTER TABLE `endereco` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `especialidade`
--

DROP TABLE IF EXISTS `especialidade`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `especialidade` (
  `id_especialidade` int(11) NOT NULL AUTO_INCREMENT,
  `id_medico` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `descricao` varchar(255) NOT NULL,
  PRIMARY KEY (`id_especialidade`,`id_medico`),
  KEY `fk_ESPECIALIDADE_MEDICO1_idx` (`id_medico`),
  CONSTRAINT `fk_ESPECIALIDADE_MEDICO1` FOREIGN KEY (`id_medico`) REFERENCES `medico` (`id_medico`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `especialidade`
--

LOCK TABLES `especialidade` WRITE;
/*!40000 ALTER TABLE `especialidade` DISABLE KEYS */;
INSERT INTO `especialidade` VALUES (1,3,'Clínica Geral','Atendimento de clínica geral e acompanhamento'),(2,4,'Cardiologia','Cardiologia clínica e exames'),(3,5,'Endocrinologia','Transtornos hormonais e diabetes'),(4,6,'Pediatria','Atendimento pediátrico'),(5,7,'Pneumologia','Doenças respiratórias'),(6,8,'Neurologia','Neurologia geral'),(7,9,'Ginecologia','Saúde da mulher'),(8,10,'Ortopedia','Saúde musculoesquelética'),(9,11,'Dermatologia','Saúde da pele'),(10,12,'Psiquiatria','Saúde mental'),(11,13,'Geriatria','Saúde do idoso'),(12,14,'Nefrologia','Saúde renal'),(13,15,'Oftalmologia','Saúde dos olhos'),(14,16,'Cirurgia Geral','Procedimentos cirúrgicos'),(15,17,'Otorrinolaringologia','Ouvido, nariz e garganta'),(16,18,'Reumatologia','Doenças reumáticas'),(17,19,'Infectologia','Doenças infecciosas'),(18,20,'Oncologia','Cuidado oncológico'),(19,21,'Urologia','Saúde urológica'),(20,22,'Nutrição','Orientação nutricional'),(21,23,'Fisioterapia','Reabilitação física'),(22,24,'Cardiologia','Cardiologia intervencionista'),(23,25,'Clínica Geral','Atendimento geral'),(24,26,'Endocrinologia','Diabetes e metabolismo'),(25,27,'Pediatria','Atendimento infantil'),(26,28,'Neurologia','Distúrbios neurológicos'),(27,29,'Ginecologia','Saúde da mulher'),(28,30,'Ortopedia','Traumatologia'),(29,31,'Dermatologia','Tratos de pele'),(30,32,'Psiquiatria','Saúde mental'),(31,33,'Geriatria','Cuidado ao idoso'),(32,34,'Nefrologia','Insuficiência renal'),(33,35,'Oftalmologia','Exames de visão'),(34,36,'Cirurgia Vascular','Cirurgia vascular'),(35,37,'Otorrinolaringologia','ORL'),(36,38,'Reumatologia','Artrites e dores'),(37,39,'Infectologia','Infecções complexas'),(38,40,'Oncologia','Acompanhamento oncológico'),(39,41,'Urologia','Cirurgia urológica'),(40,42,'Nutrição','Avaliação nutricional'),(41,43,'Fisioterapia','Reabilitação'),(42,44,'Clínica Geral','Práticas gerais'),(43,45,'Cardiologia','Exames cardíacos'),(44,46,'Endocrinologia','Hormônios'),(45,47,'Pediatria','Crescimento infantil'),(46,48,'Neurologia','Distúrbios neurológicos'),(47,49,'Ginecologia','Saúde feminina'),(48,50,'Ortopedia','Lesões esportivas'),(49,51,'Dermatologia','Tratos estéticos'),(50,52,'Psiquiatria','Terapia e medicação');
/*!40000 ALTER TABLE `especialidade` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `laudo`
--

DROP TABLE IF EXISTS `laudo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `laudo` (
  `id_laudo` int(11) NOT NULL AUTO_INCREMENT,
  `id_consulta` int(11) NOT NULL,
  `id_paciente` int(11) NOT NULL,
  `id_medico` int(11) NOT NULL,
  `data_emissao` date NOT NULL,
  `descricao` varchar(500) NOT NULL,
  `arquivo_pdf` longblob NOT NULL,
  PRIMARY KEY (`id_laudo`,`id_consulta`,`id_paciente`,`id_medico`),
  KEY `fk_LAUDO_CONSULTA1_idx` (`id_consulta`,`id_paciente`,`id_medico`),
  CONSTRAINT `fk_LAUDO_CONSULTA1` FOREIGN KEY (`id_consulta`, `id_paciente`, `id_medico`) REFERENCES `consulta` (`id_consulta`, `id_paciente`, `id_medico`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `laudo`
--

LOCK TABLES `laudo` WRITE;
/*!40000 ALTER TABLE `laudo` DISABLE KEYS */;
INSERT INTO `laudo` VALUES (1,2,17,4,'2024-01-16','Paciente em acompanhamento para diabetes tipo 2. Glicemia de jejum: 145 mg/dL. Prescrito ajuste na medicação e orientações dietéticas.',''),(2,3,18,5,'2024-02-11','Avaliação de rotina para hipertensão arterial. PA: 130/85 mmHg. Medicação mantida. Orientado continuar com atividade física regular.',''),(3,6,21,7,'2024-04-11','Consulta de acompanhamento para asma. Paciente relata melhora significativa dos sintomas. Função pulmonar dentro dos parâmetros normais.',''),(4,7,22,8,'2024-05-23','Avaliação neurológica de rotina. Exame físico sem alterações significativas. Paciente relata boa adesão ao tratamento.',''),(5,8,23,9,'2024-06-19','Consulta ginecológica de rotina. Exames preventivos realizados. Tudo dentro da normalidade. Retorno anual.',''),(6,10,25,12,'2024-07-26','Acompanhamento psiquiátrico para depressão. Paciente evoluiu bem com a medicação atual. Sintomas controlados.',''),(7,12,27,14,'2024-09-02','Consulta geriátrica. Paciente com bom estado geral. Exames de rotina solicitados.',''),(8,14,29,16,'2024-10-06','Avaliação oftalmológica. Paciente com presbiopia. Prescrito óculos para leitura.',''),(9,15,30,17,'2024-11-11','Consulta de acompanhamento para insuficiência renal. Função renal estável.',''),(10,17,32,19,'2024-12-10','Avaliação cardiológica. ECG sem alterações significativas. PA controlada.','');
/*!40000 ALTER TABLE `laudo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `medico`
--

DROP TABLE IF EXISTS `medico`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `medico` (
  `id_medico` int(11) NOT NULL AUTO_INCREMENT,
  `nome_medico` varchar(100) NOT NULL,
  `crm` varchar(20) NOT NULL,
  `senha_medico` varchar(255) NOT NULL,
  `email_medico` varchar(100) NOT NULL,
  `sexo_medico` varchar(45) NOT NULL,
  `data_nasc_medico` date NOT NULL,
  `cpf_medico` varchar(20) NOT NULL,
  `status_medico` enum('ativo','inativo') NOT NULL DEFAULT 'ativo',
  `nome_social_medico` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_medico`),
  UNIQUE KEY `crm_UNIQUE` (`crm`),
  UNIQUE KEY `email_medico_UNIQUE` (`email_medico`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `medico`
--

LOCK TABLES `medico` WRITE;
/*!40000 ALTER TABLE `medico` DISABLE KEYS */;
INSERT INTO `medico` VALUES (2,'Persona 01','37578000','$2y$10$74YGJnkAq.l3spkl8BXbLeVe1Tvz2ONKfkbIwTcube.jIih4PVYia','persona01@gmail.com','feminino','1965-12-06','12545635865','ativo',''),(3,'Dr. Ana Beatriz Silva','CRM-RJ-10001','$2y$10$medicohash01','ana.silva@medmail.com','feminino','1978-03-12','123.456.001-91','ativo','Ana Silva'),(4,'Dr. Carlos Eduardo Lima','CRM-RJ-10002','$2y$10$medicohash02','carlos.lima@medmail.com','masculino','1980-07-25','223.456.002-82','ativo','Carlos Lima'),(5,'Dra. Mariana Costa','CRM-RJ-10003','$2y$10$medicohash03','mariana.costa@medmail.com','feminino','1985-11-04','323.456.003-73','ativo','Mariana Costa'),(6,'Dr. Felipe Rocha','CRM-RJ-10004','$2y$10$medicohash04','felipe.rocha@medmail.com','masculino','1972-02-20','423.456.004-64','ativo','Felipe Rocha'),(7,'Dra. Luciana Ferreira','CRM-RJ-10005','$2y$10$medicohash05','luciana.ferreira@medmail.com','feminino','1990-09-16','523.456.005-55','ativo','Luciana Ferreira'),(8,'Dr. Marcelo Andrade','CRM-RJ-10006','$2y$10$medicohash06','marcelo.andrade@medmail.com','masculino','1969-12-30','623.456.006-46','ativo','Marcelo Andrade'),(9,'Dra. Paula Gomes','CRM-RJ-10007','$2y$10$medicohash07','paula.gomes@medmail.com','feminino','1982-05-02','723.456.007-37','ativo','Paula Gomes'),(10,'Dr. Roberto Nunes','CRM-RJ-10008','$2y$10$medicohash08','roberto.nunes@medmail.com','masculino','1975-08-10','823.456.008-28','ativo','Roberto Nunes'),(11,'Dra. Silvia Martins','CRM-RJ-10009','$2y$10$medicohash09','silvia.martins@medmail.com','feminino','1988-01-19','923.456.009-19','ativo','Silvia Martins'),(12,'Dr. Eduardo Pereira','CRM-RJ-10010','$2y$10$medicohash10','eduardo.pereira@medmail.com','masculino','1977-04-05','033.456.010-10','ativo','Eduardo Pereira'),(13,'Dra. Fernanda Rocha','CRM-RJ-10011','$2y$10$medicohash11','fernanda.rocha@medmail.com','feminino','1984-06-14','133.456.011-00','ativo','Fernanda Rocha'),(14,'Dr. Gustavo Carvalho','CRM-RJ-10012','$2y$10$medicohash12','gustavo.carvalho@medmail.com','masculino','1973-10-22','233.456.012-91','ativo','Gustavo Carvalho'),(15,'Dra. Raquel Souza','CRM-RJ-10013','$2y$10$medicohash13','raquel.souza@medmail.com','feminino','1986-02-28','333.456.013-82','ativo','Raquel Souza'),(16,'Dr. Henrique Dias','CRM-RJ-10014','$2y$10$medicohash14','henrique.dias@medmail.com','masculino','1968-11-11','433.456.014-73','ativo','Henrique Dias'),(17,'Dra. Clara Ribeiro','CRM-RJ-10015','$2y$10$medicohash15','clara.ribeiro@medmail.com','feminino','1991-07-07','533.456.015-64','ativo','Clara Ribeiro'),(18,'Dr. Ant├┤nio Barros','CRM-RJ-10016','$2y$10$medicohash16','antonio.barros@medmail.com','masculino','1970-05-15','633.456.016-55','ativo','Ant├┤nio Barros'),(19,'Dra. Juliana Castro','CRM-RJ-10017','$2y$10$medicohash17','juliana.castro@medmail.com','feminino','1983-03-03','733.456.017-46','ativo','Juliana Castro'),(20,'Dr. Ricardo Almeida','CRM-RJ-10018','$2y$10$medicohash18','ricardo.almeida@medmail.com','masculino','1976-09-29','833.456.018-37','ativo','Ricardo Almeida'),(21,'Dra. Vanessa Rocha','CRM-RJ-10019','$2y$10$medicohash19','vanessa.rocha@medmail.com','feminino','1987-12-12','933.456.019-28','ativo','Vanessa Rocha'),(22,'Dr. Leandro Silva','CRM-RJ-10020','$2y$10$medicohash20','leandro.silva@medmail.com','masculino','1974-01-01','043.456.020-19','ativo','Leandro Silva'),(23,'Dra. Beatriz Moraes','CRM-RJ-10021','$2y$10$medicohash21','beatriz.moraes@medmail.com','feminino','1992-02-02','143.456.021-10','ativo','Beatriz Moraes'),(24,'Dr. F├íbio Teixeira','CRM-RJ-10022','$2y$10$medicohash22','fabio.teixeira@medmail.com','masculino','1966-06-06','243.456.022-01','ativo','F├íbio Teixeira'),(25,'Dra. Aline Fernandes','CRM-RJ-10023','$2y$10$medicohash23','aline.fernandes@medmail.com','feminino','1989-08-18','343.456.023-92','ativo','Aline Fernandes'),(26,'Dr. Jo├úo Paulo Santos','CRM-RJ-10024','$2y$10$medicohash24','joao.santos@medmail.com','masculino','1971-04-21','443.456.024-83','ativo','Jo├úo Paulo Santos'),(27,'Dra. Adriana Lima','CRM-RJ-10025','$2y$10$medicohash25','adriana.lima@medmail.com','feminino','1981-05-30','543.456.025-74','ativo','Adriana Lima'),(28,'Dr. S├®rgio Oliveira','CRM-RJ-10026','$2y$10$medicohash26','sergio.oliveira@medmail.com','masculino','1959-10-08','643.456.026-65','ativo','S├®rgio Oliveira'),(29,'Dra. Tatiana Moreira','CRM-RJ-10027','$2y$10$medicohash27','tatiana.moreira@medmail.com','feminino','1993-03-27','743.456.027-56','ativo','Tatiana Moreira'),(30,'Dr. Murilo Castro','CRM-RJ-10028','$2y$10$medicohash28','murilo.castro@medmail.com','masculino','1983-11-11','843.456.028-47','ativo','Murilo Castro'),(31,'Dra. Helena Pires','CRM-RJ-10029','$2y$10$medicohash29','helena.pires@medmail.com','feminino','1979-09-09','943.456.029-38','ativo','Helena Pires'),(32,'Dr. Rodrigo Almeida','CRM-RJ-10030','$2y$10$medicohash30','rodrigo.almeida@medmail.com','masculino','1975-01-15','053.456.030-29','ativo','Rodrigo Almeida'),(33,'Dra. L├¡via Nogueira','CRM-RJ-10031','$2y$10$medicohash31','livia.nogueira@medmail.com','feminino','1986-12-05','153.456.031-20','ativo','L├¡via Nogueira'),(34,'Dr. Caio Batista','CRM-RJ-10032','$2y$10$medicohash32','caio.batista@medmail.com','masculino','1967-07-07','253.456.032-11','ativo','Caio Batista'),(35,'Dra. Renata Albuquerque','CRM-RJ-10033','$2y$10$medicohash33','renata.albuquerque@medmail.com','feminino','1980-10-02','353.456.033-02','ativo','Renata Albuquerque'),(36,'Dr. Daniel Fonseca','CRM-RJ-10034','$2y$10$medicohash34','daniel.fonseca@medmail.com','masculino','1972-03-03','453.456.034-93','ativo','Daniel Fonseca'),(37,'Dra. Camila Rocha','CRM-RJ-10035','$2y$10$medicohash35','camila.rocha@medmail.com','feminino','1994-06-16','553.456.035-84','ativo','Camila Rocha'),(38,'Dr. Wagner Souza','CRM-RJ-10036','$2y$10$medicohash36','wagner.souza@medmail.com','masculino','1965-02-02','653.456.036-75','ativo','Wagner Souza'),(39,'Dra. S├¡lvia Albuquerque','CRM-RJ-10037','$2y$10$medicohash37','silvia.albuquerque@medmail.com','feminino','1976-08-08','753.456.037-66','ativo','S├¡lvia Albuquerque'),(40,'Dr. Alexandre Pinto','CRM-RJ-10038','$2y$10$medicohash38','alexandre.pinto@medmail.com','masculino','1984-04-04','853.456.038-57','ativo','Alexandre Pinto'),(41,'Dra. Helena Ramos','CRM-RJ-10039','$2y$10$medicohash39','helena.ramos@medmail.com','feminino','1990-09-01','953.456.039-48','ativo','Helena Ramos'),(42,'Dr. Mateus Correia','CRM-RJ-10040','$2y$10$medicohash40','mateus.correia@medmail.com','masculino','1988-11-21','063.456.040-39','ativo','Mateus Correia'),(43,'Dra. Paula Teixeira','CRM-RJ-10041','$2y$10$medicohash41','paula.teixeira@medmail.com','feminino','1971-01-30','163.456.041-20','ativo','Paula Teixeira'),(44,'Dr. Igor Almeida','CRM-RJ-10042','$2y$10$medicohash42','igor.almeida@medmail.com','masculino','1979-05-05','263.456.042-11','ativo','Igor Almeida'),(45,'Dra. M├┤nica Batista','CRM-RJ-10043','$2y$10$medicohash43','monica.batista@medmail.com','feminino','1982-02-12','363.456.043-02','ativo','M├┤nica Batista'),(46,'Dr. Leandro Pinto','CRM-RJ-10044','$2y$10$medicohash44','leandro.pinto@medmail.com','masculino','1964-09-19','463.456.044-93','ativo','Leandro Pinto'),(47,'Dra. Isabela Moura','CRM-RJ-10045','$2y$10$medicohash45','isabela.moura@medmail.com','feminino','1995-07-07','563.456.045-84','ativo','Isabela Moura'),(48,'Dr. Nicolas Castro','CRM-RJ-10046','$2y$10$medicohash46','nicolas.castro@medmail.com','masculino','1981-06-06','663.456.046-75','ativo','Nicolas Castro'),(49,'Dra. Gra├ºa Menezes','CRM-RJ-10047','$2y$10$medicohash47','graca.menezes@medmail.com','feminino','1973-12-12','763.456.047-66','ativo','Gra├ºa Menezes'),(50,'Dr. Alan Rodrigues','CRM-RJ-10048','$2y$10$medicohash48','alan.rodrigues@medmail.com','masculino','1970-10-10','863.456.048-57','ativo','Alan Rodrigues'),(51,'Dra. Miriam Cabral','CRM-RJ-10049','$2y$10$medicohash49','miriam.cabral@medmail.com','feminino','1987-03-03','963.456.049-48','ativo','Miriam Cabral'),(52,'Dr. Everton Almeida','CRM-RJ-10050','$2y$10$medicohash50','everton.almeida@medmail.com','masculino','1962-01-01','073.456.050-39','ativo','Everton Almeida');
/*!40000 ALTER TABLE `medico` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `missao_gamificada`
--

DROP TABLE IF EXISTS `missao_gamificada`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `missao_gamificada` (
  `id_missao` int(11) NOT NULL AUTO_INCREMENT,
  `id_perfil` int(11) NOT NULL,
  `id_paciente` int(11) NOT NULL,
  `id_condicao` int(11) NOT NULL,
  `id_monitoramento` int(11) NOT NULL,
  `descricao` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `pontos` int(11) NOT NULL,
  PRIMARY KEY (`id_missao`,`id_perfil`,`id_condicao`,`id_paciente`,`id_monitoramento`),
  KEY `fk_MISSAO_GAMIFICADA_PERFIL_GAMIFICADO1_idx` (`id_perfil`,`id_condicao`,`id_paciente`),
  KEY `fk_MISSAO_GAMIFICADA_ASSISTENTE_MEDICO1_idx` (`id_monitoramento`,`id_paciente`),
  CONSTRAINT `fk_MISSAO_GAMIFICADA_ASSISTENTE_MEDICO1` FOREIGN KEY (`id_monitoramento`, `id_paciente`) REFERENCES `assistente_medico` (`id_monitoramento`, `id_paciente`),
  CONSTRAINT `fk_MISSAO_GAMIFICADA_PERFIL_GAMIFICADO1` FOREIGN KEY (`id_perfil`, `id_condicao`, `id_paciente`) REFERENCES `perfil_gamificado` (`id_perfil`, `id_condicao`, `id_paciente`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `missao_gamificada`
--

LOCK TABLES `missao_gamificada` WRITE;
/*!40000 ALTER TABLE `missao_gamificada` DISABLE KEYS */;
INSERT INTO `missao_gamificada` VALUES (1,1,17,1,1,'Medir pressão arterial 2x ao dia por 7 dias consecutivos','concluida',100),(2,1,17,1,1,'Reduzir consumo de sal por 30 dias','em_andamento',200),(3,4,18,2,2,'Monitorar glicemia em jejum por 14 dias','concluida',130),(4,4,18,2,2,'Controlar carboidratos nas refeições','em_andamento',160),(5,11,19,7,3,'Perder 2% do peso corporal em 1 mês','concluida',200),(6,7,20,3,4,'Usar inalador conforme prescrição por 30 dias','concluida',95),(7,2,21,1,5,'Registrar medidas de pressão no app por 15 dias','pendente',120),(8,9,22,5,6,'Tomar medicação no horário correto por 30 dias','concluida',85),(9,14,23,9,7,'Monitorar frequência cardíaca diariamente','concluida',170),(10,10,24,6,8,'Praticar atividade física 3x na semana','concluida',145),(11,5,25,2,9,'Manter glicemia estável por 30 dias','concluida',220),(12,12,26,7,10,'Cumprir plano alimentar por 30 dias','concluida',160),(13,1,17,1,1,'Caminhar 30 minutos diários por 2 semanas','concluida',150),(14,4,18,2,2,'Fazer exame de rotina trimestral','pendente',90),(15,11,19,7,3,'Reduzir circunferência abdominal','em_andamento',180);
/*!40000 ALTER TABLE `missao_gamificada` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `paciente`
--

DROP TABLE IF EXISTS `paciente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `paciente` (
  `id_paciente` int(11) NOT NULL AUTO_INCREMENT,
  `nome_paciente` varchar(255) NOT NULL,
  `cpf_paciente` varchar(14) NOT NULL,
  `data_nasc_paciente` date NOT NULL,
  `email_paciente` varchar(100) NOT NULL,
  `senha_paciente` varchar(100) NOT NULL,
  `sexo_paciente` varchar(20) NOT NULL,
  `status_paciente` enum('ativo','inativo') NOT NULL DEFAULT 'ativo',
  `peso` decimal(6,2) DEFAULT NULL,
  `altura` decimal(5,2) DEFAULT NULL,
  `tipo_sanguineo` varchar(10) DEFAULT NULL,
  `nome_social_paciente` varchar(100) DEFAULT NULL,
  `estado_civil` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id_paciente`),
  UNIQUE KEY `email_UNIQUE` (`email_paciente`),
  UNIQUE KEY `cpf_UNIQUE` (`cpf_paciente`)
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `paciente`
--

LOCK TABLES `paciente` WRITE;
/*!40000 ALTER TABLE `paciente` DISABLE KEYS */;
INSERT INTO `paciente` VALUES (16,'Persona 02','15486394758','1967-06-06','persona02@gmail.com','$2y$10$XTqGq8H3lSjxVr5WjzDFQeC83/fBm3xXxFdo9qIWgecyJRLwAOGe6','masculino','ativo',90.00,170.00,'B+','','Solteiro'),(17,'Carlos Henrique Pereira','111.222.333-44','1985-04-10','carlos.h.pereira@mail.com','$2y$10$pacientehash01','masculino','ativo',82.50,175.00,'O+','Carlos H.','Casado'),(18,'Mariana Oliveira Santos','222.333.444-55','1990-09-22','mariana.oliveira@mail.com','$2y$10$pacientehash02','feminino','ativo',63.00,162.00,'A+','Mariana O.','Solteira'),(19,'Jo├úo Vitor Souza','333.444.555-66','1978-01-15','joao.v.souza@mail.com','$2y$10$pacientehash03','masculino','ativo',90.00,178.00,'B+','Jo├úo V.','Casado'),(20,'Beatriz Almeida','444.555.666-77','1995-05-05','beatriz.almeida@mail.com','$2y$10$pacientehash04','feminino','ativo',58.00,165.00,'A-','Beatriz A.','Solteira'),(21,'Lucas Ferreira','555.666.777-88','1982-12-30','lucas.ferreira@mail.com','$2y$10$pacientehash05','masculino','ativo',76.20,180.00,'O-','Lucas F.','Casado'),(22,'Camila Rodrigues','666.777.888-99','1998-08-08','camila.rodrigues@mail.com','$2y$10$pacientehash06','feminino','ativo',54.50,160.00,'B-','Camila R.','Solteira'),(23,'Rafael Gomes','777.888.999-00','1970-03-03','rafael.gomes@mail.com','$2y$10$pacientehash07','masculino','ativo',88.00,172.00,'AB+','Rafael G.','Casado'),(24,'Patr├¡cia Nunes','888.999.000-11','1992-11-11','patricia.nunes@mail.com','$2y$10$pacientehash08','feminino','ativo',70.00,168.00,'O+','Patr├¡cia N.','Solteira'),(25,'Tiago Mendes','999.000.111-22','1987-06-06','tiago.mendes@mail.com','$2y$10$pacientehash09','masculino','ativo',79.50,177.00,'A+','Tiago M.','Solteiro'),(26,'Sofia Castro','000.111.222-33','2000-02-14','sofia.castro@mail.com','$2y$10$pacientehash10','feminino','ativo',52.00,158.00,'B+','Sofia C.','Solteira'),(27,'Mateus Rocha','111.333.555-88','1975-07-07','mateus.rocha@mail.com','$2y$10$pacientehash11','masculino','ativo',85.40,181.00,'O+','Mateus R.','Casado'),(28,'Daniela Lima','222.444.666-00','1994-10-20','daniela.lima@mail.com','$2y$10$pacientehash12','feminino','ativo',68.00,166.00,'A-','Daniela L.','Solteira'),(29,'Andr├® Santos','333.555.777-11','1980-01-28','andre.santos@mail.com','$2y$10$pacientehash13','masculino','ativo',95.00,182.00,'AB-','Andr├® S.','Casado'),(30,'Renata Ribeiro','444.666.888-22','1989-09-09','renata.ribeiro@mail.com','$2y$10$pacientehash14','feminino','ativo',60.00,164.00,'O+','Renata R.','Solteira'),(31,'Felipe Martins','555.777.999-33','1996-04-04','felipe.martins@mail.com','$2y$10$pacientehash15','masculino','ativo',73.20,176.00,'B+','Felipe M.','Solteiro'),(32,'Larissa Almeida','666.888.000-44','1983-02-02','larissa.almeida@mail.com','$2y$10$pacientehash16','feminino','ativo',64.00,167.00,'A+','Larissa A.','Casada'),(33,'Vitor Hugo','777.999.111-55','1991-12-12','vitor.hugo@mail.com','$2y$10$pacientehash17','masculino','ativo',80.00,179.00,'O-','Vitor H.','Solteiro'),(34,'Bruna Lopes','888.000.222-66','1993-03-18','bruna.lopes@mail.com','$2y$10$pacientehash18','feminino','ativo',57.50,161.00,'B-','Bruna L.','Solteira'),(35,'Gustavo Fernandes','999.111.333-77','1974-07-30','gustavo.fernandes@mail.com','$2y$10$pacientehash19','masculino','ativo',92.00,183.00,'A+','Gustavo F.','Casado'),(36,'Alice Rocha','000.222.444-88','2001-01-01','alice.rocha@mail.com','$2y$10$pacientehash20','feminino','ativo',49.00,155.00,'O+','Alice R.','Solteira'),(37,'Bruno Carvalho','111.444.777-00','1986-10-10','bruno.carvalho@mail.com','$2y$10$pacientehash21','masculino','ativo',86.00,180.00,'AB+','Bruno C.','Casado'),(38,'Camila Dias','222.555.888-11','1999-05-25','camila.dias@mail.com','$2y$10$pacientehash22','feminino','ativo',59.00,162.00,'A-','Camila D.','Solteira'),(39,'Rog├®rio Silva','333.666.999-22','1971-08-08','rogerio.silva@mail.com','$2y$10$pacientehash23','masculino','ativo',94.50,185.00,'B+','Rog├®rio S.','Casado'),(40,'Paula Menezes','444.777.000-33','1984-11-11','paula.menezes@mail.com','$2y$10$pacientehash24','feminino','ativo',66.00,169.00,'O+','Paula M.','Casada'),(41,'Eduardo Silva','555.888.111-44','1992-02-02','eduardo.silva@mail.com','$2y$10$pacientehash25','masculino','ativo',78.00,177.00,'A+','Eduardo S.','Solteiro'),(42,'Mariana Freitas','666.999.222-55','1988-06-06','mariana.freitas@mail.com','$2y$10$pacientehash26','feminino','ativo',62.00,165.00,'B+','Mariana F.','Solteira'),(43,'Hugo Teixeira','777.000.333-66','1979-09-09','hugo.teixeira@mail.com','$2y$10$pacientehash27','masculino','ativo',89.00,181.00,'O-','Hugo T.','Casado'),(44,'Sabrina Gomes','888.111.444-77','1997-12-31','sabrina.gomes@mail.com','$2y$10$pacientehash28','feminino','ativo',55.00,159.00,'A+','Sabrina G.','Solteira'),(45,'Marcos Oliveira','999.222.555-88','1969-04-04','marcos.oliveira@mail.com','$2y$10$pacientehash29','masculino','ativo',98.00,186.00,'B-','Marcos O.','Casado'),(46,'Daniele Carvalho','000.333.666-99','1990-08-08','daniele.carvalho@mail.com','$2y$10$pacientehash30','feminino','ativo',67.50,168.00,'O+','Daniele C.','Solteira'),(47,'Ronaldo Pereira','111.555.999-00','1976-05-05','ronaldo.pereira@mail.com','$2y$10$pacientehash31','masculino','ativo',88.80,182.00,'A+','Ronaldo P.','Casado'),(48,'Nat├ília Campos','222.666.000-11','1994-01-20','natalia.campos@mail.com','$2y$10$pacientehash32','feminino','ativo',61.00,164.00,'B+','Nat├ília C.','Solteira'),(49,'F├íbio Souza','333.777.111-22','1981-03-14','fabio.souza@mail.com','$2y$10$pacientehash33','masculino','ativo',83.00,178.00,'O-','F├íbio S.','Casado'),(50,'L├¡via Marques','444.888.222-33','1993-07-07','livia.marques@mail.com','$2y$10$pacientehash34','feminino','ativo',56.50,160.00,'A-','L├¡via M.','Solteira'),(51,'Rafael Pinto','555.999.333-44','1972-10-10','rafael.pinto@mail.com','$2y$10$pacientehash35','masculino','ativo',91.00,184.00,'AB-','Rafael P.','Casado'),(52,'Vanessa Lima','666.000.444-55','1985-02-02','vanessa.lima@mail.com','$2y$10$pacientehash36','feminino','ativo',65.00,166.00,'O+','Vanessa L.','Casada'),(53,'Igor Mendes','777.111.555-66','1990-06-06','igor.mendes@mail.com','$2y$10$pacientehash37','masculino','ativo',77.00,179.00,'B+','Igor M.','Solteiro'),(54,'Carolina Pinto','888.222.666-77','1998-09-09','carolina.pinto@mail.com','$2y$10$pacientehash38','feminino','ativo',58.20,162.00,'A+','Carolina P.','Solteira'),(55,'Washington Tavares','999.333.777-88','1965-11-11','washington.tavares@mail.com','$2y$10$pacientehash39','masculino','ativo',102.00,187.00,'O-','Washington T.','Casado'),(56,'Renata Matos','000.444.888-99','1987-03-03','renata.matos@mail.com','$2y$10$pacientehash40','feminino','ativo',69.00,167.00,'B-','Renata M.','Solteira'),(57,'Guilherme Rocha','111.666.000-11','1996-12-12','guilherme.rocha@mail.com','$2y$10$pacientehash41','masculino','ativo',75.00,176.00,'A+','Guilherme R.','Solteiro'),(58,'Monica Ribeiro','222.777.111-22','1978-05-05','monica.ribeiro@mail.com','$2y$10$pacientehash42','feminino','ativo',72.50,170.00,'O+','M├┤nica R.','Casada'),(59,'Paulo Victor','333.888.222-33','1983-08-08','paulo.victor@mail.com','$2y$10$pacientehash43','masculino','ativo',85.00,183.00,'B+','Paulo V.','Divorciado'),(60,'Suelen Andrade','444.999.333-44','1992-12-01','suelen.andrade@mail.com','$2y$10$pacientehash44','feminino','ativo',60.50,165.00,'A-','Suelen A.','Solteira'),(61,'Diego Martins','555.000.444-55','1989-09-09','diego.martins@mail.com','$2y$10$pacientehash45','masculino','ativo',79.00,178.00,'O+','Diego M.','Solteiro'),(62,'Lara Cardoso','666.111.555-66','1997-07-07','lara.cardoso@mail.com','$2y$10$pacientehash46','feminino','ativo',54.00,159.00,'B-','Lara C.','Solteira'),(63,'Nelson Freitas','777.222.666-77','1968-02-02','nelson.freitas@mail.com','$2y$10$pacientehash47','masculino','ativo',95.50,185.00,'A+','Nelson F.','Casado'),(64,'Aline Marques','888.333.777-88','1991-11-11','aline.marques@mail.com','$2y$10$pacientehash48','feminino','ativo',63.00,166.00,'O-','Aline M.','Solteira'),(65,'Ot├ívio Moreira','999.444.888-99','1977-04-04','otavio.moreira@mail.com','$2y$10$pacientehash49','masculino','ativo',88.00,181.00,'B+','Ot├ívio M.','Casado'),(66,'S├┤nia Barbosa','000.555.111-22','1986-06-06','sonia.barbosa@mail.com','$2y$10$pacientehash50','feminino','ativo',70.00,168.00,'A+','S├┤nia B.','Casada');
/*!40000 ALTER TABLE `paciente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `paciente_condicao`
--

DROP TABLE IF EXISTS `paciente_condicao`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `paciente_condicao` (
  `id_paciente` int(11) NOT NULL,
  `id_condicao` int(11) NOT NULL,
  `data_inicio` date NOT NULL,
  `status` varchar(255) NOT NULL,
  PRIMARY KEY (`id_condicao`,`id_paciente`),
  KEY `fk_PACIENTE_CONDICAO_CONDICAO_SAUDE1_idx` (`id_condicao`),
  KEY `fk_PACIENTE_CONDICAO_PACIENTE1_idx` (`id_paciente`),
  CONSTRAINT `fk_PACIENTE_CONDICAO_CONDICAO_SAUDE1` FOREIGN KEY (`id_condicao`) REFERENCES `condicao_saude` (`id_condicao`),
  CONSTRAINT `fk_PACIENTE_CONDICAO_PACIENTE1` FOREIGN KEY (`id_paciente`) REFERENCES `paciente` (`id_paciente`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `paciente_condicao`
--

LOCK TABLES `paciente_condicao` WRITE;
/*!40000 ALTER TABLE `paciente_condicao` DISABLE KEYS */;
INSERT INTO `paciente_condicao` VALUES (17,1,'2018-05-01','crônica'),(21,1,'2021-01-15','crônica'),(29,1,'2013-03-03','crônica'),(18,2,'2020-10-10','controlada'),(25,2,'2016-12-12','crônica'),(31,2,'2012-02-02','crônica'),(20,3,'2019-07-20','controlada'),(28,4,'2014-04-04','crônica'),(22,5,'2022-06-06','controlada'),(24,6,'2020-11-11','em tratamento'),(19,7,'2015-03-03','crônica'),(26,7,'2019-09-09','crônica'),(30,8,'2021-07-07','em acompanhamento'),(23,9,'2017-08-08','crônica'),(27,10,'2023-02-02','alérgico');
/*!40000 ALTER TABLE `paciente_condicao` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `perfil_gamificado`
--

DROP TABLE IF EXISTS `perfil_gamificado`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `perfil_gamificado` (
  `id_perfil` int(11) NOT NULL AUTO_INCREMENT,
  `id_condicao` int(11) NOT NULL,
  `id_paciente` int(11) NOT NULL,
  `pontos` int(11) NOT NULL,
  `medalhas` int(11) NOT NULL,
  `nivel_atual` int(11) NOT NULL,
  PRIMARY KEY (`id_perfil`,`id_condicao`,`id_paciente`),
  KEY `fk_PERFIL_GAMIFICADO_PACIENTE_CONDICAO1_idx` (`id_paciente`,`id_condicao`),
  KEY `fk_PERFIL_GAMIFICADO_PACIENTE_CONDICAO1` (`id_condicao`,`id_paciente`),
  CONSTRAINT `fk_PERFIL_GAMIFICADO_PACIENTE_CONDICAO1` FOREIGN KEY (`id_condicao`, `id_paciente`) REFERENCES `paciente_condicao` (`id_condicao`, `id_paciente`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `perfil_gamificado`
--

LOCK TABLES `perfil_gamificado` WRITE;
/*!40000 ALTER TABLE `perfil_gamificado` DISABLE KEYS */;
INSERT INTO `perfil_gamificado` VALUES (1,1,17,1250,3,5),(2,1,21,850,2,3),(3,1,29,2100,5,8),(4,2,18,950,2,4),(5,2,25,1750,4,6),(6,2,31,1100,3,5),(7,3,20,700,1,3),(8,4,28,1450,3,5),(9,5,22,800,2,3),(10,6,24,1650,4,6),(11,7,19,1950,4,7),(12,7,26,1200,3,4),(13,8,30,2300,5,9),(14,9,23,1800,4,7),(15,10,27,600,1,2);
/*!40000 ALTER TABLE `perfil_gamificado` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rg`
--

DROP TABLE IF EXISTS `rg`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rg` (
  `id_rg` int(11) NOT NULL AUTO_INCREMENT,
  `numero_rg` varchar(10) DEFAULT NULL,
  `data_emissao` date DEFAULT NULL,
  `orgao_emissor` varchar(45) DEFAULT NULL,
  `uf_rg` varchar(2) DEFAULT NULL,
  `data_validade` date DEFAULT NULL,
  `medico_id_medico` int(11) DEFAULT NULL,
  `paciente_id_paciente` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_rg`),
  UNIQUE KEY `numero_rg_UNIQUE` (`numero_rg`),
  KEY `fk_rg_medico1_idx` (`medico_id_medico`),
  KEY `fk_rg_paciente1_idx` (`paciente_id_paciente`),
  CONSTRAINT `fk_rg_medico1` FOREIGN KEY (`medico_id_medico`) REFERENCES `medico` (`id_medico`),
  CONSTRAINT `fk_rg_paciente1` FOREIGN KEY (`paciente_id_paciente`) REFERENCES `paciente` (`id_paciente`)
) ENGINE=InnoDB AUTO_INCREMENT=104 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rg`
--

LOCK TABLES `rg` WRITE;
/*!40000 ALTER TABLE `rg` DISABLE KEYS */;
INSERT INTO `rg` VALUES (4,'12.345.678','2000-01-01','SSP','RJ','2030-01-01',3,NULL),(5,'12.345.679','1999-02-02','SSP','RJ','2029-02-02',4,NULL),(6,'12.345.680','2001-03-03','SSP','RJ','2031-03-03',5,NULL),(7,'12.345.681','1998-04-04','SSP','RJ','2028-04-04',6,NULL),(8,'12.345.682','2002-05-05','SSP','RJ','2032-05-05',7,NULL),(9,'12.345.683','2003-06-06','SSP','RJ','2033-06-06',8,NULL),(10,'12.345.684','2004-07-07','SSP','RJ','2034-07-07',9,NULL),(11,'12.345.685','2005-08-08','SSP','RJ','2035-08-08',10,NULL),(12,'12.345.686','2006-09-09','SSP','RJ','2036-09-09',11,NULL),(13,'12.345.687','2007-10-10','SSP','RJ','2037-10-10',12,NULL),(14,'12.345.688','2008-11-11','SSP','RJ','2038-11-11',13,NULL),(15,'12.345.689','2009-12-12','SSP','RJ','2039-12-12',14,NULL),(16,'12.345.690','2010-01-01','SSP','RJ','2040-01-01',15,NULL),(17,'12.345.691','2011-02-02','SSP','RJ','2041-02-02',16,NULL),(18,'12.345.692','2012-03-03','SSP','RJ','2042-03-03',17,NULL),(19,'12.345.693','2013-04-04','SSP','RJ','2043-04-04',18,NULL),(20,'12.345.694','2014-05-05','SSP','RJ','2044-05-05',19,NULL),(21,'12.345.695','2015-06-06','SSP','RJ','2045-06-06',20,NULL),(22,'12.345.696','2016-07-07','SSP','RJ','2046-07-07',21,NULL),(23,'12.345.697','2017-08-08','SSP','RJ','2047-08-08',22,NULL),(24,'12.345.698','2018-09-09','SSP','RJ','2048-09-09',23,NULL),(25,'12.345.699','2019-10-10','SSP','RJ','2049-10-10',24,NULL),(26,'12.345.700','2020-11-11','SSP','RJ','2050-11-11',25,NULL),(27,'12.345.701','2021-12-12','SSP','RJ','2051-12-12',26,NULL),(28,'12.345.702','2022-01-01','SSP','RJ','2052-01-01',27,NULL),(29,'12.345.703','2023-02-02','SSP','RJ','2053-02-02',28,NULL),(30,'12.345.704','2024-03-03','SSP','RJ','2054-03-03',29,NULL),(31,'12.345.705','2025-04-04','SSP','RJ','2055-04-04',30,NULL),(32,'12.345.706','2016-05-05','SSP','RJ','2046-05-05',31,NULL),(33,'12.345.707','2017-06-06','SSP','RJ','2047-06-06',32,NULL),(34,'12.345.708','2018-07-07','SSP','RJ','2048-07-07',33,NULL),(35,'12.345.709','2019-08-08','SSP','RJ','2049-08-08',34,NULL),(36,'12.345.710','2020-09-09','SSP','RJ','2050-09-09',35,NULL),(37,'12.345.711','2021-10-10','SSP','RJ','2051-10-10',36,NULL),(38,'12.345.712','2022-11-11','SSP','RJ','2052-11-11',37,NULL),(39,'12.345.713','2023-12-12','SSP','RJ','2053-12-12',38,NULL),(40,'12.345.714','2014-01-01','SSP','RJ','2044-01-01',39,NULL),(41,'12.345.715','2015-02-02','SSP','RJ','2045-02-02',40,NULL),(42,'12.345.716','2016-03-03','SSP','RJ','2046-03-03',41,NULL),(43,'12.345.717','2017-04-04','SSP','RJ','2047-04-04',42,NULL),(44,'12.345.718','2018-05-05','SSP','RJ','2048-05-05',43,NULL),(45,'12.345.719','2019-06-06','SSP','RJ','2049-06-06',44,NULL),(46,'12.345.720','2020-07-07','SSP','RJ','2050-07-07',45,NULL),(47,'12.345.721','2021-08-08','SSP','RJ','2051-08-08',46,NULL),(48,'12.345.722','2022-09-09','SSP','RJ','2052-09-09',47,NULL),(49,'12.345.723','2023-10-10','SSP','RJ','2053-10-10',48,NULL),(50,'12.345.724','2024-11-11','SSP','RJ','2054-11-11',49,NULL),(51,'12.345.725','2013-12-12','SSP','RJ','2043-12-12',50,NULL),(52,'55667788','2012-01-01','SSP','RJ','2032-01-01',51,NULL),(53,'55667789','2011-02-02','SSP','RJ','2031-02-02',52,NULL),(54,'55667790','2010-03-03','SSP','RJ','2030-03-03',NULL,17),(55,'55667791','2009-04-04','SSP','RJ','2029-04-04',NULL,18),(56,'55667792','2008-05-05','SSP','RJ','2028-05-05',NULL,19),(57,'55667793','2007-06-06','SSP','RJ','2027-06-06',NULL,20),(58,'55667794','2006-07-07','SSP','RJ','2026-07-07',NULL,21),(59,'55667795','2005-08-08','SSP','RJ','2025-08-08',NULL,22),(60,'55667796','2004-09-09','SSP','RJ','2024-09-09',NULL,23),(61,'55667797','2003-10-10','SSP','RJ','2023-10-10',NULL,24),(62,'55667798','2002-11-11','SSP','RJ','2022-11-11',NULL,25),(63,'55667799','2001-12-12','SSP','RJ','2021-12-12',NULL,26),(64,'55667800','2000-01-01','SSP','RJ','2020-01-01',NULL,27),(65,'55667801','1999-02-02','SSP','RJ','2019-02-02',NULL,28),(66,'55667802','1998-03-03','SSP','RJ','2018-03-03',NULL,29),(67,'55667803','1997-04-04','SSP','RJ','2017-04-04',NULL,30),(68,'55667804','1996-05-05','SSP','RJ','2016-05-05',NULL,31),(69,'55667805','1995-06-06','SSP','RJ','2015-06-06',NULL,32),(70,'55667806','1994-07-07','SSP','RJ','2014-07-07',NULL,33),(71,'55667807','1993-08-08','SSP','RJ','2013-08-08',NULL,34),(72,'55667808','1992-09-09','SSP','RJ','2012-09-09',NULL,35),(73,'55667809','1991-10-10','SSP','RJ','2011-10-10',NULL,36),(74,'55667810','1990-11-11','SSP','RJ','2010-11-11',NULL,37),(75,'55667811','1989-12-12','SSP','RJ','2009-12-12',NULL,38),(76,'55667812','1988-01-01','SSP','RJ','2008-01-01',NULL,39),(77,'55667813','1987-02-02','SSP','RJ','2007-02-02',NULL,40),(78,'55667814','1986-03-03','SSP','RJ','2006-03-03',NULL,41),(79,'55667815','1985-04-04','SSP','RJ','2005-04-04',NULL,42),(80,'55667816','1984-05-05','SSP','RJ','2004-05-05',NULL,43),(81,'55667817','1983-06-06','SSP','RJ','2003-06-06',NULL,44),(82,'55667818','1982-07-07','SSP','RJ','2002-07-07',NULL,45),(83,'55667819','1981-08-08','SSP','RJ','2001-08-08',NULL,46),(84,'55667820','1980-09-09','SSP','RJ','2000-09-09',NULL,47),(85,'55667821','1979-10-10','SSP','RJ','1999-10-10',NULL,48),(86,'55667822','1978-11-11','SSP','RJ','1998-11-11',NULL,49),(87,'55667823','1977-12-12','SSP','RJ','1997-12-12',NULL,50),(88,'55667824','1976-01-01','SSP','RJ','1996-01-01',NULL,51),(89,'55667825','1975-02-02','SSP','RJ','1995-02-02',NULL,52),(90,'55667826','1974-03-03','SSP','RJ','1994-03-03',NULL,53),(91,'55667827','1973-04-04','SSP','RJ','1993-04-04',NULL,54),(92,'55667828','1972-05-05','SSP','RJ','1992-05-05',NULL,55),(93,'55667829','1971-06-06','SSP','RJ','1991-06-06',NULL,56),(94,'55667830','1970-07-07','SSP','RJ','1990-07-07',NULL,57),(95,'55667831','1969-08-08','SSP','RJ','1989-08-08',NULL,58),(96,'55667832','1968-09-09','SSP','RJ','1988-09-09',NULL,59),(97,'55667833','1967-10-10','SSP','RJ','1987-10-10',NULL,60),(98,'55667834','1966-11-11','SSP','RJ','1986-11-11',NULL,61),(99,'55667835','1965-12-12','SSP','RJ','1985-12-12',NULL,62),(100,'55667836','1964-01-01','SSP','RJ','1984-01-01',NULL,63),(101,'55667837','1963-02-02','SSP','RJ','1983-02-02',NULL,64),(102,'55667838','1962-03-03','SSP','RJ','1982-03-03',NULL,65),(103,'55667839','1961-04-04','SSP','RJ','1981-04-04',NULL,66);
/*!40000 ALTER TABLE `rg` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `telefone`
--

DROP TABLE IF EXISTS `telefone`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `telefone` (
  `id_telefone` int(11) NOT NULL AUTO_INCREMENT,
  `medico_id_medico` int(11) DEFAULT NULL,
  `paciente_id_paciente` int(11) DEFAULT NULL,
  `dd` varchar(5) NOT NULL,
  `telefone` varchar(15) NOT NULL,
  PRIMARY KEY (`id_telefone`),
  KEY `fk_telefone_medico1_idx` (`medico_id_medico`),
  KEY `fk_telefone_paciente1_idx` (`paciente_id_paciente`),
  CONSTRAINT `fk_telefone_medico1` FOREIGN KEY (`medico_id_medico`) REFERENCES `medico` (`id_medico`),
  CONSTRAINT `fk_telefone_paciente1` FOREIGN KEY (`paciente_id_paciente`) REFERENCES `paciente` (`id_paciente`)
) ENGINE=InnoDB AUTO_INCREMENT=104 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `telefone`
--

LOCK TABLES `telefone` WRITE;
/*!40000 ALTER TABLE `telefone` DISABLE KEYS */;
INSERT INTO `telefone` VALUES (2,NULL,16,'55','21978452358'),(3,2,NULL,'55','2199653529'),(4,3,NULL,'21','21999990001'),(5,4,NULL,'21','21999990002'),(6,5,NULL,'21','21999990003'),(7,6,NULL,'21','21999990004'),(8,7,NULL,'21','21999990005'),(9,8,NULL,'21','21999990006'),(10,9,NULL,'21','21999990007'),(11,10,NULL,'21','21999990008'),(12,11,NULL,'21','21999990009'),(13,12,NULL,'21','21999990010'),(14,13,NULL,'21','21999990011'),(15,14,NULL,'21','21999990012'),(16,15,NULL,'21','21999990013'),(17,16,NULL,'21','21999990014'),(18,17,NULL,'21','21999990015'),(19,18,NULL,'21','21999990016'),(20,19,NULL,'21','21999990017'),(21,20,NULL,'21','21999990018'),(22,21,NULL,'21','21999990019'),(23,22,NULL,'21','21999990020'),(24,23,NULL,'21','21999990021'),(25,24,NULL,'21','21999990022'),(26,25,NULL,'21','21999990023'),(27,26,NULL,'21','21999990024'),(28,27,NULL,'21','21999990025'),(29,28,NULL,'21','21999990026'),(30,29,NULL,'21','21999990027'),(31,30,NULL,'21','21999990028'),(32,31,NULL,'21','21999990029'),(33,32,NULL,'21','21999990030'),(34,33,NULL,'21','21999990031'),(35,34,NULL,'21','21999990032'),(36,35,NULL,'21','21999990033'),(37,36,NULL,'21','21999990034'),(38,37,NULL,'21','21999990035'),(39,38,NULL,'21','21999990036'),(40,39,NULL,'21','21999990037'),(41,40,NULL,'21','21999990038'),(42,41,NULL,'21','21999990039'),(43,42,NULL,'21','21999990040'),(44,43,NULL,'21','21999990041'),(45,44,NULL,'21','21999990042'),(46,45,NULL,'21','21999990043'),(47,46,NULL,'21','21999990044'),(48,47,NULL,'21','21999990045'),(49,48,NULL,'21','21999990046'),(50,49,NULL,'21','21999990047'),(51,50,NULL,'21','21999990048'),(52,51,NULL,'21','21999990049'),(53,52,NULL,'21','21999990050'),(54,NULL,17,'21','21988001017'),(55,NULL,18,'21','21988001018'),(56,NULL,19,'21','21988001019'),(57,NULL,20,'21','21988001020'),(58,NULL,21,'21','21988001021'),(59,NULL,22,'21','21988001022'),(60,NULL,23,'21','21988001023'),(61,NULL,24,'21','21988001024'),(62,NULL,25,'21','21988001025'),(63,NULL,26,'21','21988001026'),(64,NULL,27,'21','21988001027'),(65,NULL,28,'21','21988001028'),(66,NULL,29,'21','21988001029'),(67,NULL,30,'21','21988001030'),(68,NULL,31,'21','21988001031'),(69,NULL,32,'21','21988001032'),(70,NULL,33,'21','21988001033'),(71,NULL,34,'21','21988001034'),(72,NULL,35,'21','21988001035'),(73,NULL,36,'21','21988001036'),(74,NULL,37,'21','21988001037'),(75,NULL,38,'21','21988001038'),(76,NULL,39,'21','21988001039'),(77,NULL,40,'21','21988001040'),(78,NULL,41,'21','21988001041'),(79,NULL,42,'21','21988001042'),(80,NULL,43,'21','21988001043'),(81,NULL,44,'21','21988001044'),(82,NULL,45,'21','21988001045'),(83,NULL,46,'21','21988001046'),(84,NULL,47,'21','21988001047'),(85,NULL,48,'21','21988001048'),(86,NULL,49,'21','21988001049'),(87,NULL,50,'21','21988001050'),(88,NULL,51,'21','21988001051'),(89,NULL,52,'21','21988001052'),(90,NULL,53,'21','21988001053'),(91,NULL,54,'21','21988001054'),(92,NULL,55,'21','21988001055'),(93,NULL,56,'21','21988001056'),(94,NULL,57,'21','21988001057'),(95,NULL,58,'21','21988001058'),(96,NULL,59,'21','21988001059'),(97,NULL,60,'21','21988001060'),(98,NULL,61,'21','21988001061'),(99,NULL,62,'21','21988001062'),(100,NULL,63,'21','21988001063'),(101,NULL,64,'21','21988001064'),(102,NULL,65,'21','21988001065'),(103,NULL,66,'21','21988001066');
/*!40000 ALTER TABLE `telefone` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-11-07 16:52:54
