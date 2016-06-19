CREATE DATABASE  IF NOT EXISTS `dbseminar` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `dbseminar`;
-- MySQL dump 10.13  Distrib 5.5.49, for debian-linux-gnu (x86_64)
--
-- Host: 127.0.0.1    Database: dbseminar
-- ------------------------------------------------------
-- Server version	5.6.14

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
-- Table structure for table `fakultas`
--

DROP TABLE IF EXISTS `fakultas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fakultas` (
  `id_fakultas` int(11) NOT NULL AUTO_INCREMENT,
  `nama_fakultas` varchar(40) NOT NULL,
  `date_create` datetime DEFAULT NULL,
  `date_update` datetime DEFAULT NULL,
  `status_fakultas` varchar(2) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_fakultas`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fakultas`
--

LOCK TABLES `fakultas` WRITE;
/*!40000 ALTER TABLE `fakultas` DISABLE KEYS */;
INSERT INTO `fakultas` VALUES (1,'FIKOM','2016-06-14 19:21:53','2016-06-15 11:38:57','1'),(2,'FASILKOM','2016-06-15 11:36:17','2016-06-15 11:39:00','1'),(3,'1','2016-06-19 14:59:48',NULL,'1');
/*!40000 ALTER TABLE `fakultas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jurusan_fakultas`
--

DROP TABLE IF EXISTS `jurusan_fakultas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jurusan_fakultas` (
  `id_jurusan_fakultas` int(11) NOT NULL AUTO_INCREMENT,
  `nama_jurusan` varchar(60) NOT NULL,
  `id_fakultas` varchar(5) NOT NULL,
  `date_create` datetime DEFAULT NULL,
  `date_update` datetime DEFAULT NULL,
  `status_jurusan` varchar(5) DEFAULT '1',
  PRIMARY KEY (`id_jurusan_fakultas`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jurusan_fakultas`
--

LOCK TABLES `jurusan_fakultas` WRITE;
/*!40000 ALTER TABLE `jurusan_fakultas` DISABLE KEYS */;
/*!40000 ALTER TABLE `jurusan_fakultas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kategori_peserta`
--

DROP TABLE IF EXISTS `kategori_peserta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kategori_peserta` (
  `id_kategori_peserta` int(11) NOT NULL AUTO_INCREMENT,
  `kategori_peserta` int(11) NOT NULL,
  `create_date_kategori_peserta` date NOT NULL,
  `update_date_kategori_peserta` date NOT NULL,
  PRIMARY KEY (`id_kategori_peserta`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kategori_peserta`
--

LOCK TABLES `kategori_peserta` WRITE;
/*!40000 ALTER TABLE `kategori_peserta` DISABLE KEYS */;
/*!40000 ALTER TABLE `kategori_peserta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kategori_user`
--

DROP TABLE IF EXISTS `kategori_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kategori_user` (
  `id_kategori_user` int(11) NOT NULL AUTO_INCREMENT,
  `nama_kategori_user` varchar(100) NOT NULL,
  `create_date_kategori_user` date NOT NULL,
  `update_date_kategori_user` date DEFAULT NULL,
  PRIMARY KEY (`id_kategori_user`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kategori_user`
--

LOCK TABLES `kategori_user` WRITE;
/*!40000 ALTER TABLE `kategori_user` DISABLE KEYS */;
INSERT INTO `kategori_user` VALUES (1,'admin 234','2016-05-19','2016-05-23'),(3,'HIMMA update','2016-05-23','2016-05-23'),(4,'HImma 2','2016-05-23',NULL),(5,'HImma 3','2016-05-23',NULL),(6,'Himma 4','2016-05-23',NULL),(7,'HIMMA 5','2016-05-23',NULL),(8,'Hima laya','2016-05-23',NULL),(9,'Himaladada ahsd','2016-05-23',NULL),(10,'HImalaya 8908234','2016-05-23',NULL),(11,'Arif','2016-05-23',NULL),(12,'Himma Fasilkom','2016-05-24',NULL),(13,'sadasdas','2016-05-25',NULL),(14,'','2016-05-28',NULL);
/*!40000 ALTER TABLE `kategori_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mahasiswa`
--

DROP TABLE IF EXISTS `mahasiswa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mahasiswa` (
  `id_mahasiswa` int(11) NOT NULL AUTO_INCREMENT,
  `nama_depan` varchar(100) NOT NULL,
  `nama_belakang` varchar(100) DEFAULT NULL,
  `nim_mahasiswa` varchar(20) NOT NULL,
  `email_mahasiswa` varchar(175) NOT NULL,
  `alamat_mahasiswa` varchar(250) DEFAULT NULL,
  `telp_mahasiswa` varchar(14) DEFAULT NULL,
  `tipe_mahasiswa` varchar(5) CHARACTER SET big5 NOT NULL COMMENT 'untuk mengetahui,\n1 = reguler\n2 = paraler',
  `tahun_masuk` varchar(8) NOT NULL,
  `semester_mahasiswa` varchar(10) NOT NULL,
  `password_mahasiswa` varchar(150) NOT NULL,
  `id_fakultas` varchar(5) NOT NULL,
  `photo_mahasiswa` varchar(200) DEFAULT NULL,
  `update_date` datetime DEFAULT NULL,
  `status_mahasiswa` varchar(15) DEFAULT '1',
  `date_create` datetime DEFAULT NULL,
  PRIMARY KEY (`id_mahasiswa`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mahasiswa`
--

LOCK TABLES `mahasiswa` WRITE;
/*!40000 ALTER TABLE `mahasiswa` DISABLE KEYS */;
INSERT INTO `mahasiswa` VALUES (1,'Luqman','Hakim','4151412013712','luqman@gmail.com','jkarta','mament','1','2014','ganjil','NmZkNzQyYTYxYmQwMzQ4MDRjMDBjNDliMTgwNDUwMjA=','1','http://localhost/seminar3/assets/uploads/mahasiswa/display/100/150/e86yjfcqoq.jpg',NULL,'1','2016-06-17 00:00:00'),(2,'Luqman','Hakim','4151412','luqman@gmail.com','Jakarta Barat','090909','1','2015','ganjil','202cb962ac59075b964b07152d234b70','2','http://localhost/seminar3/assets/uploads/mahasiswa/display/100/150/955lu4ve1m.jpg',NULL,'1','2016-06-18 00:00:00');
/*!40000 ALTER TABLE `mahasiswa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `peserta`
--

DROP TABLE IF EXISTS `peserta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `peserta` (
  `id_peserta` int(11) NOT NULL AUTO_INCREMENT,
  `nama_peserta` varchar(50) NOT NULL,
  `password_peserta` varchar(100) NOT NULL,
  `email_peserta` varchar(100) NOT NULL,
  `alamat_peserta` varchar(200) NOT NULL,
  `nomor_telepon_peserta` varchar(15) NOT NULL,
  `nim_peserta` varchar(15) NOT NULL,
  `status_peserta` int(11) NOT NULL,
  `bukti_pembayaran_peserta` varchar(300) NOT NULL,
  `create_date_peserta` date NOT NULL,
  `update_date_peserta` date NOT NULL,
  PRIMARY KEY (`id_peserta`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `peserta`
--

LOCK TABLES `peserta` WRITE;
/*!40000 ALTER TABLE `peserta` DISABLE KEYS */;
/*!40000 ALTER TABLE `peserta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `seminar`
--

DROP TABLE IF EXISTS `seminar`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `seminar` (
  `id_seminar` int(11) NOT NULL AUTO_INCREMENT,
  `nama_seminar` varchar(50) NOT NULL,
  `jadwal_seminar` date NOT NULL,
  `harga1_seminar` int(11) NOT NULL,
  `harga2_seminar` int(11) NOT NULL,
  `pembicara_seminar` varchar(50) NOT NULL,
  `tempat_seminar` varchar(50) NOT NULL,
  `quota_seminar` int(11) NOT NULL,
  `status_seminar` int(11) NOT NULL,
  `create_date_seminar` date NOT NULL,
  `update_date_seminar` date NOT NULL,
  PRIMARY KEY (`id_seminar`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `seminar`
--

LOCK TABLES `seminar` WRITE;
/*!40000 ALTER TABLE `seminar` DISABLE KEYS */;
/*!40000 ALTER TABLE `seminar` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `nama_user` varchar(75) NOT NULL,
  `email_user` varchar(150) NOT NULL,
  `telp_user` varchar(15) DEFAULT NULL,
  `kategori_user` varchar(15) NOT NULL,
  `username_user` varchar(75) NOT NULL,
  `password` varchar(300) NOT NULL,
  `create_date` datetime NOT NULL,
  `update_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'Ariep Nurhidayat','arip.nurhidayat@gmail.com','083897510605','admin','ariep','ZGI2OWZjMDM5ZGNiZDI5NjJjYjRkMjhmNTg5MWFhZTE=','2016-06-03 23:40:30','2016-06-04 23:59:40'),(6,'sandra dj  ','sandra.dwijayanto@gmail.com','0892929292','EO','sandradjsdf','Y2NmNWQ4ODUzNDZmYzAxZjBjYTk1Njk4MTQyY2QxMDM=','2016-06-07 09:58:59','2016-06-19 15:54:36');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-06-20  4:13:40
