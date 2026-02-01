-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: pointofsale
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
-- Table structure for table `barang`
--

DROP TABLE IF EXISTS `barang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `barang` (
  `id_barang` int(11) NOT NULL AUTO_INCREMENT,
  `id_kategori` int(11) DEFAULT NULL,
  `nama_barang` varchar(255) DEFAULT NULL,
  `kode` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `harga` int(11) DEFAULT NULL,
  `modal` int(11) DEFAULT NULL,
  `stok` varchar(255) DEFAULT NULL,
  `foto` text DEFAULT NULL,
  `isdelete` tinyint(4) DEFAULT 0,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id_barang`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `barang`
--

LOCK TABLES `barang` WRITE;
/*!40000 ALTER TABLE `barang` DISABLE KEYS */;
INSERT INTO `barang` VALUES (1,NULL,' Brownies','6920710571178','Tersedia',0,0,'100','1769499376_a9db0e2da509a93d316e.jpg',0,1,'2026-01-27 07:36:16',NULL,NULL,NULL,NULL),(2,1,'Bengbeng','8996001354124','Tersedia',50000,10000,'956','1769499735_80db9dc4ddaaca722c90.jpg',0,1,'2026-01-27 07:40:25',1,'2026-01-27 07:42:52',NULL,NULL),(3,2,'Susu Greenfield','8993351124025','Tersedia',10000,5000,'83','1769500545_23e282f82c23fddf9198.jpg',0,1,'2026-01-27 07:55:45',NULL,NULL,NULL,NULL),(4,1,'Donat','241974504003','Tersedia',5000,2500,'42','1769615331_4383a33eddbb2b3bce6f.jpg',0,1,'2026-01-28 15:48:51',NULL,NULL,NULL,NULL),(5,NULL,NULL,'890170145319',NULL,NULL,NULL,NULL,'',0,1,'2026-01-28 16:11:30',NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `barang` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `barang_masuk`
--

DROP TABLE IF EXISTS `barang_masuk`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `barang_masuk` (
  `id_masuk` int(11) NOT NULL AUTO_INCREMENT,
  `id_barang` int(11) DEFAULT NULL,
  `jumlah` varchar(255) DEFAULT NULL,
  `isdelete` tinyint(4) DEFAULT 0,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id_masuk`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `barang_masuk`
--

LOCK TABLES `barang_masuk` WRITE;
/*!40000 ALTER TABLE `barang_masuk` DISABLE KEYS */;
INSERT INTO `barang_masuk` VALUES (1,2,'8',0,NULL,NULL,NULL,NULL,NULL,NULL),(2,3,'17',1,1,'2026-01-28 16:12:17',NULL,NULL,NULL,'2026-01-28 16:12:28');
/*!40000 ALTER TABLE `barang_masuk` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `input` AFTER INSERT ON `barang_masuk` FOR EACH ROW IF NEW.isdelete = 0 THEN
        UPDATE barang
        SET stok = CAST(stok AS SIGNED) + CAST(NEW.jumlah AS SIGNED)
        WHERE id_barang = NEW.id_barang;
    END IF */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `trg_barang_masuk_update` AFTER UPDATE ON `barang_masuk` FOR EACH ROW BEGIN

    -- UPDATE JUMLAH NORMAL (0 → 0)
    IF OLD.isdelete = 0 AND NEW.isdelete = 0 THEN
        UPDATE barang
        SET stok = CAST(stok AS SIGNED)
                 - CAST(OLD.jumlah AS SIGNED)
                 + CAST(NEW.jumlah AS SIGNED)
        WHERE barang.id_barang = NEW.id_barang;
    END IF;

    -- SOFT DELETE (0 → 1)
    IF OLD.isdelete = 0 AND NEW.isdelete = 1 THEN
        UPDATE barang
        SET stok = CAST(stok AS SIGNED)
                 - CAST(OLD.jumlah AS SIGNED)
        WHERE barang.id_barang = OLD.id_barang;
    END IF;

    -- RESTORE (1 → 0)
    IF OLD.isdelete = 1 AND NEW.isdelete = 0 THEN
        UPDATE barang
        SET stok = CAST(stok AS SIGNED)
                 + CAST(NEW.jumlah AS SIGNED)
        WHERE barang.id_barang = NEW.id_barang;
    END IF;

END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `delete` AFTER DELETE ON `barang_masuk` FOR EACH ROW UPDATE barang
    SET jumlah = jumlah - OLD.jumlah
    WHERE id_barang = OLD.id_barang */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `kategori`
--

DROP TABLE IF EXISTS `kategori`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kategori` (
  `id_kategori` int(11) NOT NULL AUTO_INCREMENT,
  `nama_kategori` varchar(255) DEFAULT NULL,
  `isdelete` tinyint(4) DEFAULT 0,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id_kategori`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kategori`
--

LOCK TABLES `kategori` WRITE;
/*!40000 ALTER TABLE `kategori` DISABLE KEYS */;
INSERT INTO `kategori` VALUES (1,'Makanan',0,1,'2026-01-27 06:44:41',NULL,NULL,NULL,NULL),(2,'Minuman',0,1,'2026-01-27 06:44:45',NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `kategori` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `level`
--

DROP TABLE IF EXISTS `level`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `level` (
  `id_level` int(11) NOT NULL AUTO_INCREMENT,
  `nama_level` varchar(255) DEFAULT NULL,
  `isdelete` tinyint(4) DEFAULT 0,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id_level`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `level`
--

LOCK TABLES `level` WRITE;
/*!40000 ALTER TABLE `level` DISABLE KEYS */;
INSERT INTO `level` VALUES (1,'Superadmin',0,NULL,NULL,NULL,NULL,NULL,NULL),(2,'Admin',0,NULL,NULL,NULL,NULL,NULL,NULL),(3,'Leader Kasir',0,NULL,NULL,NULL,NULL,NULL,NULL),(4,'Kasir',0,NULL,NULL,NULL,NULL,NULL,NULL),(5,'Manager',0,NULL,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `level` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `log`
--

DROP TABLE IF EXISTS `log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log` (
  `id_log` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) DEFAULT NULL,
  `activity` text DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id_log`)
) ENGINE=InnoDB AUTO_INCREMENT=296 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `log`
--

LOCK TABLES `log` WRITE;
/*!40000 ALTER TABLE `log` DISABLE KEYS */;
INSERT INTO `log` VALUES (1,1,'Mengakses halaman Dashboard.','::1','2026-01-27 06:17:36'),(2,1,'Mengakses halaman Level.','::1','2026-01-27 06:17:53'),(3,1,'Mengakses halaman Input Level.','::1','2026-01-27 06:17:55'),(4,1,'Menambahkan level: Superadmin','::1','2026-01-27 06:17:58'),(5,1,'Mengakses halaman Level.','::1','2026-01-27 06:17:58'),(6,1,'Mengakses halaman Input Level.','::1','2026-01-27 06:18:00'),(7,1,'Menambahkan level: Admin','::1','2026-01-27 06:18:09'),(8,1,'Mengakses halaman Level.','::1','2026-01-27 06:18:09'),(9,1,'Mengakses halaman Input Level.','::1','2026-01-27 06:18:14'),(10,1,'Menambahkan level: Leader Kasir','::1','2026-01-27 06:18:20'),(11,1,'Mengakses halaman Level.','::1','2026-01-27 06:18:20'),(12,1,'Mengakses halaman Input Level.','::1','2026-01-27 06:18:21'),(13,1,'Menambahkan level: Kasir','::1','2026-01-27 06:18:24'),(14,1,'Mengakses halaman Level.','::1','2026-01-27 06:18:24'),(15,1,'Mengakses halaman Input Level.','::1','2026-01-27 06:18:25'),(16,1,'Menambahkan level: Manager','::1','2026-01-27 06:18:33'),(17,1,'Mengakses halaman Level.','::1','2026-01-27 06:18:33'),(18,1,'Mengakses halaman Hak Akses Menu.','::1','2026-01-27 06:18:36'),(19,1,'Mengakses halaman Data Menu.','::1','2026-01-27 06:18:41'),(20,1,'Mengakses halaman Input Menu.','::1','2026-01-27 06:18:43'),(21,1,'Menambahkan menu: Dashboard','::1','2026-01-27 06:19:02'),(22,1,'Mengakses halaman Data Menu.','::1','2026-01-27 06:19:02'),(23,1,'Mengakses halaman Input Menu.','::1','2026-01-27 06:19:04'),(24,1,'Menambahkan menu: Data Master','::1','2026-01-27 06:19:16'),(25,1,'Mengakses halaman Data Menu.','::1','2026-01-27 06:19:16'),(26,1,'Mengakses halaman Data Menu.','::1','2026-01-27 06:19:17'),(27,1,'Mengakses halaman Data Menu.','::1','2026-01-27 06:19:19'),(28,1,'Mengakses halaman Data Menu.','::1','2026-01-27 06:19:19'),(29,1,'Mengakses halaman Data Menu.','::1','2026-01-27 06:19:20'),(30,1,'Mengakses halaman Data Menu.','::1','2026-01-27 06:19:20'),(31,1,'Mengakses halaman Data Menu.','::1','2026-01-27 06:19:20'),(32,1,'Mengakses halaman Data Menu.','::1','2026-01-27 06:19:20'),(33,1,'Mengakses halaman Input Menu.','::1','2026-01-27 06:19:27'),(34,1,'Menambahkan menu: User','::1','2026-01-27 06:19:36'),(35,1,'Mengakses halaman Data Menu.','::1','2026-01-27 06:19:36'),(36,1,'Mengakses halaman Input Menu.','::1','2026-01-27 06:19:37'),(37,1,'Menambahkan menu: Level','::1','2026-01-27 06:19:48'),(38,1,'Mengakses halaman Data Menu.','::1','2026-01-27 06:19:48'),(39,1,'Mengakses halaman Input Menu.','::1','2026-01-27 06:19:49'),(40,1,'Menambahkan menu: Log All','::1','2026-01-27 06:20:12'),(41,1,'Mengakses halaman Data Menu.','::1','2026-01-27 06:20:12'),(42,1,'Mengakses halaman Input Menu.','::1','2026-01-27 06:20:13'),(43,1,'Menambahkan menu: Log','::1','2026-01-27 06:20:20'),(44,1,'Mengakses halaman Data Menu.','::1','2026-01-27 06:20:20'),(45,1,'Mengakses halaman Input Menu.','::1','2026-01-27 06:20:24'),(46,1,'Menambahkan menu: Menu','::1','2026-01-27 06:20:34'),(47,1,'Mengakses halaman Data Menu.','::1','2026-01-27 06:20:34'),(48,1,'Mengakses halaman Input Menu.','::1','2026-01-27 06:20:35'),(49,1,'Menambahkan menu: Hak Akses Menu','::1','2026-01-27 06:20:46'),(50,1,'Mengakses halaman Data Menu.','::1','2026-01-27 06:20:46'),(51,1,'Mengakses halaman Input Menu.','::1','2026-01-27 06:20:54'),(52,1,'Menambahkan menu: Data Gudang','::1','2026-01-27 06:21:23'),(53,1,'Mengakses halaman Data Menu.','::1','2026-01-27 06:21:24'),(54,1,'Mengakses halaman Input Menu.','::1','2026-01-27 06:21:25'),(55,1,'Menambahkan menu: Barang','::1','2026-01-27 06:21:38'),(56,1,'Mengakses halaman Data Menu.','::1','2026-01-27 06:21:38'),(57,1,'Mengakses halaman Input Menu.','::1','2026-01-27 06:21:39'),(58,1,'Menambahkan menu: Barang Masuk','::1','2026-01-27 06:21:54'),(59,1,'Mengakses halaman Data Menu.','::1','2026-01-27 06:21:54'),(60,1,'Mengakses halaman Input Menu.','::1','2026-01-27 06:21:58'),(61,1,'Menambahkan menu: Kategori','::1','2026-01-27 06:22:07'),(62,1,'Mengakses halaman Data Menu.','::1','2026-01-27 06:22:07'),(63,1,'Mengakses halaman Input Menu.','::1','2026-01-27 06:22:11'),(64,1,'Menambahkan menu: Metode','::1','2026-01-27 06:22:17'),(65,1,'Mengakses halaman Data Menu.','::1','2026-01-27 06:22:18'),(66,1,'Mengakses halaman Input Menu.','::1','2026-01-27 06:22:24'),(67,1,'Menambahkan menu: Data Keuangan','::1','2026-01-27 06:22:49'),(68,1,'Mengakses halaman Data Menu.','::1','2026-01-27 06:22:49'),(69,1,'Mengakses halaman Input Menu.','::1','2026-01-27 06:22:50'),(70,1,'Menambahkan menu: Penjualan','::1','2026-01-27 06:23:00'),(71,1,'Mengakses halaman Data Menu.','::1','2026-01-27 06:23:00'),(72,1,'Mengakses halaman Input Menu.','::1','2026-01-27 06:23:01'),(73,1,'Menambahkan menu: Nota','::1','2026-01-27 06:23:08'),(74,1,'Mengakses halaman Data Menu.','::1','2026-01-27 06:23:08'),(75,1,'Mengakses halaman Input Menu.','::1','2026-01-27 06:23:09'),(76,1,'Menambahkan menu: Setting Nota','::1','2026-01-27 06:23:23'),(77,1,'Mengakses halaman Data Menu.','::1','2026-01-27 06:23:23'),(78,1,'Mengakses halaman Hak Akses Menu.','::1','2026-01-27 06:23:35'),(79,1,'Mengubah hak akses menu (privileges)','::1','2026-01-27 06:23:49'),(80,1,'Mengakses halaman Hak Akses Menu.','::1','2026-01-27 06:23:52'),(81,1,'Mengakses halaman Hak Akses Menu.','::1','2026-01-27 06:25:38'),(82,1,'Mengakses halaman Level.','::1','2026-01-27 06:25:40'),(83,1,'Mengakses halaman Level.','::1','2026-01-27 06:25:41'),(84,1,'Mengakses halaman Level.','::1','2026-01-27 06:25:41'),(85,1,'Mengakses halaman User.','::1','2026-01-27 06:30:22'),(86,1,'Mengakses halaman Deleted User.','::1','2026-01-27 06:30:24'),(87,1,'Mengakses halaman User.','::1','2026-01-27 06:30:26'),(88,1,'Mengakses halaman Deleted User.','::1','2026-01-27 06:30:27'),(89,1,'Mengakses halaman User.','::1','2026-01-27 06:30:28'),(90,1,'Mengakses halaman Input User.','::1','2026-01-27 06:30:31'),(91,1,'Menambahkan user: Kalila','::1','2026-01-27 06:30:44'),(92,1,'Mengakses halaman User.','::1','2026-01-27 06:30:44'),(93,1,'Menghapus data user dengan ID: 2','::1','2026-01-27 06:30:48'),(94,1,'Mengakses halaman Deleted User.','::1','2026-01-27 06:30:49'),(95,1,'Mengakses halaman User.','::1','2026-01-27 06:30:51'),(96,1,'Mengakses halaman Deleted User.','::1','2026-01-27 06:30:53'),(97,1,'Merestore data user dengan ID: 2','::1','2026-01-27 06:30:54'),(98,1,'Mengakses halaman User.','::1','2026-01-27 06:30:54'),(99,1,'Mengakses halaman Level.','::1','2026-01-27 06:30:57'),(100,1,'Mengakses data Log.','::1','2026-01-27 06:30:59'),(101,1,'Mengakses halaman Data Menu.','::1','2026-01-27 06:31:01'),(102,1,'Mengakses halaman Hak Akses Menu.','::1','2026-01-27 06:31:02'),(103,1,'Mengakses halaman Hak Akses Menu.','::1','2026-01-27 06:36:10'),(104,1,'Mengakses halaman Level.','::1','2026-01-27 06:36:12'),(105,1,'Menghapus data level dengan ID: 5','::1','2026-01-27 06:36:16'),(106,1,'Mengakses halaman Deleted Level.','::1','2026-01-27 06:37:15'),(107,1,'Mengakses halaman Level.','::1','2026-01-27 06:37:18'),(108,1,'Mengakses halaman Deleted Level.','::1','2026-01-27 06:37:19'),(109,1,'Merestore data level dengan ID: 5','::1','2026-01-27 06:37:21'),(110,1,'Mengakses halaman Level.','::1','2026-01-27 06:37:21'),(111,1,'Mengakses halaman Deleted Level.','::1','2026-01-27 06:37:24'),(112,1,'Mengakses halaman Deleted Level.','::1','2026-01-27 06:37:30'),(113,1,'Mengakses halaman Deleted Level.','::1','2026-01-27 06:37:33'),(114,1,'Mengakses halaman Level.','::1','2026-01-27 06:37:34'),(115,1,'Mengakses halaman Data Menu.','::1','2026-01-27 06:37:36'),(116,1,'Mengakses halaman Data Menu.','::1','2026-01-27 06:38:37'),(117,1,'Mengakses halaman Data Menu.','::1','2026-01-27 06:44:09'),(118,1,'Mengakses halaman Data Menu.','::1','2026-01-27 06:44:33'),(119,1,'Mengakses halaman Kategori.','::1','2026-01-27 06:44:35'),(120,1,'Mengakses halaman Input Kategori.','::1','2026-01-27 06:44:38'),(121,1,'Menambahkan kategori: Makanan','::1','2026-01-27 06:44:41'),(122,1,'Mengakses halaman Kategori.','::1','2026-01-27 06:44:41'),(123,1,'Mengakses halaman Input Kategori.','::1','2026-01-27 06:44:42'),(124,1,'Menambahkan kategori: Minuman','::1','2026-01-27 06:44:45'),(125,1,'Mengakses halaman Kategori.','::1','2026-01-27 06:44:45'),(126,1,'Mengakses halaman Deleted Kategori.','::1','2026-01-27 06:44:46'),(127,1,'Mengakses halaman Kategori.','::1','2026-01-27 06:44:47'),(128,1,'Menghapus data kategori dengan ID: 2','::1','2026-01-27 06:44:49'),(129,1,'Mengakses halaman Deleted Kategori.','::1','2026-01-27 06:44:49'),(130,1,'Mengakses halaman Kategori.','::1','2026-01-27 06:44:51'),(131,1,'Mengakses halaman Deleted Kategori.','::1','2026-01-27 06:44:52'),(132,1,'Merestore data kategori dengan ID: 2','::1','2026-01-27 06:44:53'),(133,1,'Mengakses halaman Kategori.','::1','2026-01-27 06:44:53'),(134,1,'Mengakses halaman Metode.','::1','2026-01-27 06:51:14'),(135,1,'Mengakses halaman Input Metode.','::1','2026-01-27 06:51:15'),(136,1,'Menambahkan metode: Dana','::1','2026-01-27 06:51:21'),(137,1,'Mengakses halaman Metode.','::1','2026-01-27 06:51:21'),(138,1,'Menghapus data metode dengan ID: 1','::1','2026-01-27 06:51:24'),(139,1,'Mengakses halaman Deleted Metode.','::1','2026-01-27 06:51:24'),(140,1,'Mengakses halaman Metode.','::1','2026-01-27 06:51:26'),(141,1,'Mengakses halaman Deleted Metode.','::1','2026-01-27 06:51:27'),(142,1,'Merestore data metode dengan ID: 1','::1','2026-01-27 06:51:29'),(143,1,'Mengakses halaman Metode.','::1','2026-01-27 06:51:29'),(144,1,'Mengakses halaman Input Metode.','::1','2026-01-27 06:51:32'),(145,1,'Menambahkan metode: BCA','::1','2026-01-27 06:51:38'),(146,1,'Mengakses halaman Metode.','::1','2026-01-27 06:51:38'),(147,1,'Mengakses halaman Barang.','::1','2026-01-27 07:16:32'),(148,1,'Mengakses halaman Barang.','::1','2026-01-27 07:24:40'),(149,1,'Mengakses halaman Barang.','::1','2026-01-27 07:30:04'),(150,1,'Mengakses halaman Input Barang.','::1','2026-01-27 07:30:05'),(151,1,'Mengakses halaman Input Barang.','::1','2026-01-27 07:31:00'),(152,1,'Menambahkan barang:  Brownies','::1','2026-01-27 07:36:16'),(153,1,'Mengakses halaman Barang.','::1','2026-01-27 07:36:17'),(154,1,'Mengakses halaman Input Barang.','::1','2026-01-27 07:36:56'),(155,1,'Menambahkan barang: Bengbeng','::1','2026-01-27 07:40:25'),(156,1,'Mengakses halaman Barang.','::1','2026-01-27 07:40:25'),(157,1,'Mengakses halaman Edit Barang.','::1','2026-01-27 07:41:13'),(158,1,'Mengakses halaman Edit Barang.','::1','2026-01-27 07:41:30'),(159,1,'Mengakses halaman Edit Barang.','::1','2026-01-27 07:41:50'),(160,1,'Mengakses halaman Edit Barang.','::1','2026-01-27 07:41:55'),(161,1,'Mengedit barang: Bengbeng','::1','2026-01-27 07:42:15'),(162,1,'Mengakses halaman Barang.','::1','2026-01-27 07:42:15'),(163,1,'Mengakses halaman Barang.','::1','2026-01-27 07:42:47'),(164,1,'Mengakses halaman Edit Barang.','::1','2026-01-27 07:42:49'),(165,1,'Mengedit barang: Bengbeng','::1','2026-01-27 07:42:52'),(166,1,'Mengakses halaman Barang.','::1','2026-01-27 07:42:53'),(167,1,'Mengakses halaman Barang.','::1','2026-01-27 07:54:31'),(168,1,'Mengakses halaman Barang.','::1','2026-01-27 07:54:44'),(169,1,'Mengakses halaman Barang.','::1','2026-01-27 07:54:47'),(170,1,'Mengakses halaman Input Barang.','::1','2026-01-27 07:55:26'),(171,1,'Menambahkan barang: Susu Greenfield','::1','2026-01-27 07:55:45'),(172,1,'Mengakses halaman Barang.','::1','2026-01-27 07:55:45'),(173,1,'Mengakses halaman Dashboard.','::1','2026-01-28 06:01:13'),(174,1,'Mengakses halaman Barang.','::1','2026-01-28 06:03:08'),(175,1,'Mengakses halaman Data Menu.','::1','2026-01-28 06:10:36'),(176,1,'Mengakses halaman Nota Setting.','::1','2026-01-28 06:11:35'),(177,1,'Mengakses halaman Nota Setting.','::1','2026-01-28 06:22:26'),(178,1,'Mengakses halaman Input Nota Setting.','::1','2026-01-28 06:22:28'),(179,1,'Mengakses halaman Input Nota Setting.','::1','2026-01-28 06:27:04'),(180,1,'Menambahkan nota setting: POINT OF SALE PERMATA HARAPAN','::1','2026-01-28 06:28:00'),(181,1,'Mengakses halaman Nota Setting.','::1','2026-01-28 06:28:00'),(182,1,'Mengakses halaman Edit Nota Setting.','::1','2026-01-28 07:40:14'),(183,1,'Mengakses halaman Edit Nota Setting.','::1','2026-01-28 07:40:29'),(184,1,'Mengedit nota setting: POINT OF SALE PERMATA HARAPAN','::1','2026-01-28 07:40:31'),(185,1,'Mengakses halaman Nota Setting.','::1','2026-01-28 07:40:31'),(186,1,'Mengakses halaman Edit Nota Setting.','::1','2026-01-28 07:40:34'),(187,1,'Mengedit nota setting: POINT OF SALE PERMATA HARAPAN','::1','2026-01-28 07:40:36'),(188,1,'Mengakses halaman Nota Setting.','::1','2026-01-28 07:40:36'),(189,1,'Mengakses halaman Dashboard.','::1','2026-01-28 07:40:58'),(190,1,'Mengakses halaman Dashboard.','::1','2026-01-28 11:09:37'),(191,1,'Mengakses halaman Dashboard.','::1','2026-01-28 11:12:44'),(192,1,'Mengakses halaman Dashboard.','::1','2026-01-28 11:13:11'),(193,1,'Mengakses halaman Dashboard.','::1','2026-01-28 11:14:34'),(194,1,'Mengakses halaman Dashboard.','::1','2026-01-28 11:19:12'),(195,1,'Mengakses halaman Dashboard.','::1','2026-01-28 11:19:13'),(196,1,'Mengakses halaman Dashboard.','::1','2026-01-28 11:22:23'),(197,1,'Mengakses halaman Barang.','::1','2026-01-28 11:22:36'),(198,1,'Mengakses halaman Dashboard.','::1','2026-01-28 11:22:39'),(199,1,'Mengakses halaman Dashboard.','::1','2026-01-28 11:22:51'),(200,1,'Mengakses halaman Dashboard.','::1','2026-01-28 11:25:42'),(201,1,'Mengakses halaman Dashboard.','::1','2026-01-28 11:26:59'),(202,1,'Mengakses halaman Dashboard.','::1','2026-01-28 11:28:50'),(203,1,'Mengakses halaman Dashboard.','::1','2026-01-28 11:29:27'),(204,1,'Mengakses halaman Dashboard.','::1','2026-01-28 11:30:37'),(205,1,'Mengakses halaman Dashboard.','::1','2026-01-28 11:32:51'),(206,1,'Mengakses halaman Dashboard.','::1','2026-01-28 11:32:53'),(207,1,'Mengakses halaman Dashboard.','::1','2026-01-28 11:39:30'),(208,1,'Mengakses halaman Barang.','::1','2026-01-28 11:39:33'),(209,1,'Mengakses halaman Barang.','::1','2026-01-28 11:40:19'),(210,1,'Mengakses halaman Barang.','::1','2026-01-28 11:40:34'),(211,1,'Mengakses halaman Barang.','::1','2026-01-28 11:41:46'),(212,1,'Mengakses halaman Barang.','::1','2026-01-28 11:42:15'),(213,1,'Mengakses halaman Barang.','::1','2026-01-28 11:42:43'),(214,1,'Mengakses halaman Barang.','::1','2026-01-28 11:43:04'),(215,1,'Mengakses halaman Barang.','::1','2026-01-28 11:43:13'),(216,1,'Mengakses halaman Input Barang.','::1','2026-01-28 11:43:18'),(217,1,'Mengakses halaman Barang.','::1','2026-01-28 11:43:20'),(218,1,'Mengakses halaman Barang.','::1','2026-01-28 11:46:00'),(219,NULL,'Mengakses halaman Barang.','::1','2026-01-28 15:47:33'),(220,1,'Mengakses halaman Dashboard.','::1','2026-01-28 15:47:50'),(221,1,'Mengakses halaman Barang.','::1','2026-01-28 15:47:58'),(222,1,'Mengakses halaman Input Barang.','::1','2026-01-28 15:48:03'),(223,1,'Menambahkan barang: Donat','::1','2026-01-28 15:48:51'),(224,1,'Mengakses halaman Barang.','::1','2026-01-28 15:48:51'),(225,1,'Mengakses halaman User.','::1','2026-01-28 15:56:04'),(226,1,'Mengakses halaman Level.','::1','2026-01-28 15:56:06'),(227,1,'Mengakses data Log.','::1','2026-01-28 15:56:08'),(228,1,'Mengakses halaman Hak Akses Menu.','::1','2026-01-28 15:56:11'),(229,1,'Mengubah hak akses menu (privileges)','::1','2026-01-28 15:57:28'),(230,1,'Mengakses halaman Hak Akses Menu.','::1','2026-01-28 15:57:33'),(231,1,'Mengakses halaman Data Menu.','::1','2026-01-28 15:57:36'),(232,1,'Menghapus menu ID: 16','::1','2026-01-28 15:57:40'),(233,1,'Mengakses halaman Data Menu.','::1','2026-01-28 15:57:41'),(234,1,'Mengakses halaman Nota Setting.','::1','2026-01-28 15:57:52'),(235,1,'Mengakses halaman Metode.','::1','2026-01-28 15:58:00'),(236,1,'Mengakses halaman Data Menu.','::1','2026-01-28 16:09:15'),(237,1,'Mengakses halaman Edit Menu.','::1','2026-01-28 16:09:20'),(238,1,'Mengedit menu: Barang Masuk','::1','2026-01-28 16:09:23'),(239,1,'Mengakses halaman Data Menu.','::1','2026-01-28 16:09:24'),(240,1,'Mengakses halaman Barang Masuk.','::1','2026-01-28 16:10:21'),(241,1,'Mengakses halaman Barang Masuk.','::1','2026-01-28 16:11:13'),(242,1,'Mengakses halaman Barang Masuk.','::1','2026-01-28 16:11:23'),(243,1,'Mengakses halaman Input Barang Masuk.','::1','2026-01-28 16:11:26'),(244,1,'Menambahkan barang: ','::1','2026-01-28 16:11:30'),(245,1,'Mengakses halaman Barang.','::1','2026-01-28 16:11:30'),(246,1,'Mengakses halaman Barang Masuk.','::1','2026-01-28 16:11:56'),(247,1,'Mengakses halaman Input Barang Masuk.','::1','2026-01-28 16:11:58'),(248,1,'Mengakses halaman Barang.','::1','2026-01-28 16:12:08'),(249,1,'Mengakses halaman Barang Masuk.','::1','2026-01-28 16:12:12'),(250,1,'Mengakses halaman Input Barang Masuk.','::1','2026-01-28 16:12:13'),(251,1,'Menambahkan barang masuk: 3','::1','2026-01-28 16:12:17'),(252,1,'Mengakses halaman Barang Masuk.','::1','2026-01-28 16:12:17'),(253,1,'Mengakses halaman Barang.','::1','2026-01-28 16:12:19'),(254,1,'Mengakses halaman Barang Masuk.','::1','2026-01-28 16:12:25'),(255,1,'Menghapus data barang masuk dengan ID: 2','::1','2026-01-28 16:12:28'),(256,1,'Mengakses halaman Deleted Barang Masuk.','::1','2026-01-28 16:12:29'),(257,1,'Mengakses halaman Barang.','::1','2026-01-28 16:12:35'),(258,1,'Mengakses halaman Dashboard.','::1','2026-01-28 23:08:37'),(259,1,'Mengakses halaman Penjualan.','::1','2026-01-28 23:23:15'),(260,1,'Mengakses halaman Penjualan.','::1','2026-01-28 23:23:39'),(261,1,'Mengakses halaman Penjualan.','::1','2026-01-28 23:25:05'),(262,1,'Mengakses halaman Penjualan.','::1','2026-01-28 23:25:38'),(263,1,'Mengakses halaman Penjualan.','::1','2026-01-28 23:28:19'),(264,1,'Mengakses halaman Penjualan.','::1','2026-01-28 23:31:31'),(265,1,'Mengakses halaman Edit Penjualan.','::1','2026-01-28 23:32:13'),(266,1,'Mengakses halaman Edit Penjualan.','::1','2026-01-28 23:32:35'),(267,1,'Mengakses halaman Edit Penjualan.','::1','2026-01-28 23:32:36'),(268,1,'Mengakses halaman Edit Penjualan.','::1','2026-01-28 23:32:38'),(269,1,'Mengakses halaman Edit Penjualan.','::1','2026-01-28 23:32:43'),(270,1,'Mengakses halaman Penjualan.','::1','2026-01-28 23:33:42'),(271,1,'Mengakses halaman Data Menu.','::1','2026-01-28 23:37:35'),(272,1,'Mengakses halaman Input Menu.','::1','2026-01-28 23:37:36'),(273,1,'Mengakses halaman Input Menu.','::1','2026-01-28 23:37:45'),(274,1,'Menambahkan menu: Laporan','::1','2026-01-28 23:38:05'),(275,1,'Mengakses halaman Data Menu.','::1','2026-01-28 23:38:05'),(276,1,'Mengakses halaman Hak Akses Menu.','::1','2026-01-28 23:38:07'),(277,1,'Mengubah hak akses menu (privileges)','::1','2026-01-28 23:38:15'),(278,1,'Mengakses halaman Hak Akses Menu.','::1','2026-01-28 23:38:22'),(279,1,'Mengakses halaman Laporan.','::1','2026-01-28 23:38:50'),(280,1,'Mengakses halaman Laporan.','::1','2026-01-28 23:40:13'),(281,1,'Mengakses halaman Laporan.','::1','2026-01-28 23:41:29'),(282,1,'Mengakses halaman Laporan.','::1','2026-01-28 23:42:28'),(283,1,'Mengakses halaman Laporan.','::1','2026-01-28 23:42:57'),(284,1,'Mengakses halaman Laporan.','::1','2026-01-28 23:44:49'),(285,1,'Mengakses halaman Laporan.','::1','2026-01-28 23:46:08'),(286,1,'Mengakses halaman Laporan.','::1','2026-01-28 23:47:27'),(287,1,'Mengakses halaman Dashboard.','::1','2026-01-29 00:18:04'),(288,1,'Mengakses halaman Dashboard.','::1','2026-01-29 00:18:41'),(289,1,'Mengakses halaman Dashboard.','::1','2026-01-29 00:18:43'),(290,1,'Mengakses halaman Dashboard.','::1','2026-01-29 00:19:32'),(291,1,'Mengakses halaman Dashboard.','::1','2026-01-29 00:19:44'),(292,1,'Mengakses halaman Dashboard.','::1','2026-01-29 00:24:33'),(293,1,'Mengakses halaman Dashboard.','::1','2026-01-29 00:24:46'),(294,1,'Mengakses halaman Dashboard.','::1','2026-01-29 00:25:16'),(295,1,'Mengakses halaman Dashboard.','::1','2026-01-29 00:26:11');
/*!40000 ALTER TABLE `log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menu`
--

DROP TABLE IF EXISTS `menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `menu` (
  `id_menu` int(11) NOT NULL AUTO_INCREMENT,
  `nama_menu` varchar(255) DEFAULT NULL,
  `url` text DEFAULT NULL,
  `icon` text DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `isdelete` tinyint(4) DEFAULT 0,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id_menu`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menu`
--

LOCK TABLES `menu` WRITE;
/*!40000 ALTER TABLE `menu` DISABLE KEYS */;
INSERT INTO `menu` VALUES (1,'Dashboard','dashboard','bi bi-grid',NULL,0,NULL,NULL,NULL,NULL,NULL,NULL),(2,'Data Master','#','bi bi-menu-button-wide',NULL,0,NULL,NULL,NULL,NULL,NULL,NULL),(3,'User','user','bi bi-circle',2,0,NULL,NULL,NULL,NULL,NULL,NULL),(4,'Level','level','bi bi-circle',2,0,NULL,NULL,NULL,NULL,NULL,NULL),(5,'Log All','log','bi bi-circle',2,0,NULL,NULL,NULL,NULL,NULL,NULL),(6,'Log','logsession','bi bi-circle',2,0,NULL,NULL,NULL,NULL,NULL,NULL),(7,'Menu','datamenu','bi bi-circle',2,0,NULL,NULL,NULL,NULL,NULL,NULL),(8,'Hak Akses Menu','menu','bi bi-circle',2,0,NULL,NULL,NULL,NULL,NULL,NULL),(9,'Data Gudang','#','bi bi-menu-button-wide',NULL,0,NULL,NULL,NULL,NULL,NULL,NULL),(10,'Barang','barang','bi bi-circle',9,0,NULL,NULL,NULL,NULL,NULL,NULL),(11,'Barang Masuk','barangmasuk','bi bi-circle',9,0,NULL,NULL,NULL,NULL,NULL,NULL),(12,'Kategori','kategori','bi bi-circle',9,0,NULL,NULL,NULL,NULL,NULL,NULL),(13,'Metode','metode','bi bi-circle',9,0,NULL,NULL,NULL,NULL,NULL,NULL),(14,'Data Keuangan','#','bi bi-menu-button-wide',NULL,0,NULL,NULL,NULL,NULL,NULL,NULL),(15,'Penjualan','penjualan','bi bi-circle',14,0,NULL,NULL,NULL,NULL,NULL,NULL),(17,'Setting Nota','nota/setting','bi bi-circle',14,0,NULL,NULL,NULL,NULL,NULL,NULL),(18,'Laporan','laporan','bi bi-circle',14,0,NULL,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `metode`
--

DROP TABLE IF EXISTS `metode`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `metode` (
  `id_metode` int(11) NOT NULL AUTO_INCREMENT,
  `nama_metode` varchar(255) DEFAULT NULL,
  `kode` varchar(255) DEFAULT NULL,
  `isdelete` tinyint(4) DEFAULT 0,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id_metode`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `metode`
--

LOCK TABLES `metode` WRITE;
/*!40000 ALTER TABLE `metode` DISABLE KEYS */;
INSERT INTO `metode` VALUES (1,'Dana','085376818185',0,1,'2026-01-27 06:51:21',NULL,NULL,NULL,NULL),(2,'BCA','85718211',0,1,'2026-01-27 06:51:38',NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `metode` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nota`
--

DROP TABLE IF EXISTS `nota`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nota` (
  `id_nota` int(11) NOT NULL AUTO_INCREMENT,
  `total` int(11) DEFAULT NULL,
  `bayar` int(11) DEFAULT NULL,
  `kembalian` int(11) DEFAULT NULL,
  `id_metode` int(11) DEFAULT NULL,
  `due` datetime DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `bukti_pembayaran` varchar(255) DEFAULT NULL,
  `isdelete` tinyint(4) DEFAULT 0,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id_nota`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nota`
--

LOCK TABLES `nota` WRITE;
/*!40000 ALTER TABLE `nota` DISABLE KEYS */;
INSERT INTO `nota` VALUES (1,200000,5000000,4800000,NULL,NULL,'Lunas',NULL,0,1,'2026-01-27 07:50:30',NULL,'2026-01-27 07:54:14',NULL,NULL),(2,250000,500000,250000,NULL,NULL,'Lunas',NULL,0,1,'2026-01-27 07:56:42',NULL,'2026-01-27 07:56:50',NULL,NULL),(3,150000,0,0,NULL,NULL,'Belum Lunas',NULL,0,1,'2026-01-28 11:22:48',NULL,NULL,NULL,NULL),(4,150000,0,0,NULL,NULL,'Belum Lunas',NULL,0,1,'2026-01-28 11:25:56',NULL,NULL,NULL,NULL),(5,200000,0,0,NULL,NULL,'Belum Lunas',NULL,0,1,'2026-01-28 11:29:08',NULL,NULL,NULL,NULL),(6,150000,0,0,NULL,NULL,'Belum Lunas',NULL,0,1,'2026-01-28 11:29:40',NULL,NULL,NULL,NULL),(7,180000,0,0,NULL,NULL,'Belum Lunas',NULL,0,1,'2026-01-28 11:31:04',NULL,NULL,NULL,NULL),(8,180000,200000,20000,NULL,NULL,'Lunas',NULL,0,1,'2026-01-28 11:33:10',NULL,NULL,NULL,NULL),(9,10000,0,0,NULL,NULL,'Lunas',NULL,0,1,'2026-01-29 00:18:37',NULL,NULL,NULL,NULL),(10,10000,0,0,NULL,NULL,'Lunas',NULL,0,1,'2026-01-29 00:19:41',NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `nota` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nota_setting`
--

DROP TABLE IF EXISTS `nota_setting`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nota_setting` (
  `id_notset` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `logo` text DEFAULT NULL,
  `alamat` text NOT NULL,
  `notelp` varchar(255) NOT NULL,
  `isdelete` tinyint(4) DEFAULT 0,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id_notset`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nota_setting`
--

LOCK TABLES `nota_setting` WRITE;
/*!40000 ALTER TABLE `nota_setting` DISABLE KEYS */;
INSERT INTO `nota_setting` VALUES (1,'POINT OF SALE PERMATA HARAPAN','1769581680_a64cca5c8c83662145f7.png','Komp.Batu Batam Mas, Jl. Gajah Mada Blok D & E No.1,2,3, Baloi Indah, Kec. Lubuk Baja, Kota Batam, Kepulauan Riau 29444','(0778) 431318',0,1,'2026-01-28 06:28:00',1,'2026-01-28 07:40:36',NULL,NULL);
/*!40000 ALTER TABLE `nota_setting` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `penjualan`
--

DROP TABLE IF EXISTS `penjualan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `penjualan` (
  `id_penjualan` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) DEFAULT NULL,
  `id_nota` int(11) DEFAULT NULL,
  `tanggal` datetime DEFAULT NULL,
  `isdelete` tinyint(4) DEFAULT 0,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id_penjualan`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `penjualan`
--

LOCK TABLES `penjualan` WRITE;
/*!40000 ALTER TABLE `penjualan` DISABLE KEYS */;
INSERT INTO `penjualan` VALUES (2,1,1,'2026-01-27 07:50:30',0,1,'2026-01-27 07:50:30',NULL,NULL,NULL,NULL),(3,1,2,'2026-01-27 07:56:42',0,1,'2026-01-27 07:56:42',NULL,NULL,NULL,NULL),(4,1,3,'2026-01-28 11:22:48',0,1,'2026-01-28 11:22:48',NULL,NULL,NULL,NULL),(5,1,4,'2026-01-28 11:25:56',0,1,'2026-01-28 11:25:56',NULL,NULL,NULL,NULL),(6,1,5,'2026-01-28 11:29:08',0,1,'2026-01-28 11:29:08',NULL,NULL,NULL,NULL),(7,1,6,'2026-01-28 11:29:40',0,1,'2026-01-28 11:29:40',NULL,NULL,NULL,NULL),(8,1,7,'2026-01-28 11:31:04',0,1,'2026-01-28 11:31:04',NULL,NULL,NULL,NULL),(9,1,8,'2026-01-28 11:33:10',0,1,'2026-01-28 11:33:10',NULL,NULL,NULL,NULL),(10,1,9,'2026-01-29 00:18:37',0,1,'2026-01-29 00:18:37',NULL,NULL,NULL,NULL),(11,1,10,'2026-01-29 00:19:41',0,1,'2026-01-29 00:19:41',NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `penjualan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `penjualan_detail`
--

DROP TABLE IF EXISTS `penjualan_detail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `penjualan_detail` (
  `id_detail` int(11) NOT NULL AUTO_INCREMENT,
  `id_penjualan` int(11) DEFAULT NULL,
  `id_barang` int(11) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `isdelete` tinyint(4) DEFAULT 0,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id_detail`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `penjualan_detail`
--

LOCK TABLES `penjualan_detail` WRITE;
/*!40000 ALTER TABLE `penjualan_detail` DISABLE KEYS */;
INSERT INTO `penjualan_detail` VALUES (1,2,2,4,0,1,'2026-01-27 07:50:30',NULL,NULL,NULL,NULL),(2,3,2,10,0,1,'2026-01-27 07:56:42',NULL,NULL,NULL,NULL),(3,3,3,5,0,1,'2026-01-27 07:56:42',NULL,NULL,NULL,NULL),(4,4,2,3,0,1,'2026-01-28 11:22:48',NULL,NULL,NULL,NULL),(5,5,2,3,0,1,'2026-01-28 11:25:56',NULL,NULL,NULL,NULL),(6,6,2,4,0,1,'2026-01-28 11:29:08',NULL,NULL,NULL,NULL),(7,7,2,3,0,1,'2026-01-28 11:29:40',NULL,NULL,NULL,NULL),(8,8,2,3,0,1,'2026-01-28 11:31:04',NULL,NULL,NULL,NULL),(9,8,3,3,0,1,'2026-01-28 11:31:04',NULL,NULL,NULL,NULL),(10,9,3,3,0,1,'2026-01-28 11:33:10',NULL,NULL,NULL,NULL),(11,9,2,3,0,1,'2026-01-28 11:33:10',NULL,NULL,NULL,NULL),(12,10,4,2,0,1,'2026-01-29 00:18:37',NULL,NULL,NULL,NULL),(13,11,4,2,0,1,'2026-01-29 00:19:41',NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `penjualan_detail` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `trg_penjualan_detail_insert` AFTER INSERT ON `penjualan_detail` FOR EACH ROW BEGIN
    IF NEW.isdelete = 0 THEN
        UPDATE barang
        SET stok = CAST(stok AS SIGNED) - CAST(NEW.jumlah AS SIGNED)
        WHERE id_barang = NEW.id_barang;
    END IF;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `trg_penjualan_detail_au` AFTER UPDATE ON `penjualan_detail` FOR EACH ROW BEGIN
    -- UPDATE JUMLAH, TETAP AKTIF
    IF OLD.isdelete = 0 AND NEW.isdelete = 0 THEN
        UPDATE barang
        SET stok = CAST(stok AS SIGNED)
                   + CAST(OLD.jumlah AS SIGNED)
                   - CAST(NEW.jumlah AS SIGNED)
        WHERE id_barang = NEW.id_barang;
    END IF;

    -- SOFT DELETE (0 → 1)
    IF OLD.isdelete = 0 AND NEW.isdelete = 1 THEN
        UPDATE barang
        SET stok = CAST(stok AS SIGNED) + CAST(OLD.jumlah AS SIGNED)
        WHERE id_barang = OLD.id_barang;
    END IF;

    -- RESTORE (1 → 0)
    IF OLD.isdelete = 1 AND NEW.isdelete = 0 THEN
        UPDATE barang
        SET stok = CAST(stok AS SIGNED) - CAST(NEW.jumlah AS SIGNED)
        WHERE id_barang = NEW.id_barang;
    END IF;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `trg_penjualan_detail_delete` AFTER DELETE ON `penjualan_detail` FOR EACH ROW BEGIN
    UPDATE barang
    SET jumlah = jumlah + OLD.jumlah
    WHERE id_barang = OLD.id_barang;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `privileges`
--

DROP TABLE IF EXISTS `privileges`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `privileges` (
  `id_privileges` int(11) NOT NULL AUTO_INCREMENT,
  `id_level` int(11) DEFAULT NULL,
  `id_menu` int(11) DEFAULT NULL,
  `isdelete` tinyint(4) DEFAULT 0,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id_privileges`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `privileges`
--

LOCK TABLES `privileges` WRITE;
/*!40000 ALTER TABLE `privileges` DISABLE KEYS */;
INSERT INTO `privileges` VALUES (1,1,1,0,NULL,NULL,NULL,NULL,NULL,NULL),(2,1,3,0,NULL,NULL,NULL,NULL,NULL,NULL),(3,1,4,0,NULL,NULL,NULL,NULL,NULL,NULL),(4,1,5,0,NULL,NULL,NULL,NULL,NULL,NULL),(5,1,7,0,NULL,NULL,NULL,NULL,NULL,NULL),(6,1,8,0,NULL,NULL,NULL,NULL,NULL,NULL),(7,1,10,0,NULL,NULL,NULL,NULL,NULL,NULL),(8,1,11,0,NULL,NULL,NULL,NULL,NULL,NULL),(9,1,12,0,NULL,NULL,NULL,NULL,NULL,NULL),(10,1,13,0,NULL,NULL,NULL,NULL,NULL,NULL),(11,1,15,0,NULL,NULL,NULL,NULL,NULL,NULL),(12,1,17,0,NULL,NULL,NULL,NULL,NULL,NULL),(13,1,18,0,NULL,NULL,NULL,NULL,NULL,NULL),(14,2,1,0,NULL,NULL,NULL,NULL,NULL,NULL),(15,2,3,0,NULL,NULL,NULL,NULL,NULL,NULL),(16,2,6,0,NULL,NULL,NULL,NULL,NULL,NULL),(17,2,10,0,NULL,NULL,NULL,NULL,NULL,NULL),(18,2,11,0,NULL,NULL,NULL,NULL,NULL,NULL),(19,2,12,0,NULL,NULL,NULL,NULL,NULL,NULL),(20,2,13,0,NULL,NULL,NULL,NULL,NULL,NULL),(21,2,15,0,NULL,NULL,NULL,NULL,NULL,NULL),(22,2,18,0,NULL,NULL,NULL,NULL,NULL,NULL),(23,3,1,0,NULL,NULL,NULL,NULL,NULL,NULL),(24,3,10,0,NULL,NULL,NULL,NULL,NULL,NULL),(25,3,11,0,NULL,NULL,NULL,NULL,NULL,NULL),(26,3,12,0,NULL,NULL,NULL,NULL,NULL,NULL),(27,3,13,0,NULL,NULL,NULL,NULL,NULL,NULL),(28,3,15,0,NULL,NULL,NULL,NULL,NULL,NULL),(29,3,17,0,NULL,NULL,NULL,NULL,NULL,NULL),(30,4,1,0,NULL,NULL,NULL,NULL,NULL,NULL),(31,4,10,0,NULL,NULL,NULL,NULL,NULL,NULL),(32,4,11,0,NULL,NULL,NULL,NULL,NULL,NULL),(33,4,12,0,NULL,NULL,NULL,NULL,NULL,NULL),(34,4,13,0,NULL,NULL,NULL,NULL,NULL,NULL),(35,4,15,0,NULL,NULL,NULL,NULL,NULL,NULL),(36,4,17,0,NULL,NULL,NULL,NULL,NULL,NULL),(37,5,1,0,NULL,NULL,NULL,NULL,NULL,NULL),(38,5,10,0,NULL,NULL,NULL,NULL,NULL,NULL),(39,5,11,0,NULL,NULL,NULL,NULL,NULL,NULL),(40,5,15,0,NULL,NULL,NULL,NULL,NULL,NULL),(41,5,18,0,NULL,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `privileges` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `foto` text DEFAULT NULL,
  `level` int(11) DEFAULT NULL,
  `isdelete` tinyint(4) DEFAULT 0,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'mey','c4ca4238a0b923820dcc509a6f75849b','Meyliana','1767768289_cd67fa4150b652f9dc7b.jpg',1,0,1,'2026-01-27 13:16:54',NULL,NULL,NULL,NULL),(2,'kalila','c4ca4238a0b923820dcc509a6f75849b','Kalila','1769495444_c88c4d2a4cef4a60b7e9.jpg',2,0,1,'2026-01-27 06:30:44',NULL,NULL,NULL,NULL);
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

-- Dump completed on 2026-01-29  7:27:13
