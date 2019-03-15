-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.1.13-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win32
-- HeidiSQL Version:             10.1.0.5464
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping structure for table new_backend.sys_group_users
CREATE TABLE IF NOT EXISTS `sys_group_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `level` varchar(50) NOT NULL,
  `level_name` varchar(50) NOT NULL,
  `deskripsi` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `level` (`level`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Dumping data for table new_backend.sys_group_users: ~4 rows (approximately)
/*!40000 ALTER TABLE `sys_group_users` DISABLE KEYS */;
INSERT INTO `sys_group_users` (`id`, `level`, `level_name`, `deskripsi`) VALUES
	(1, 'root', 'root', 'Super Administrator'),
	(2, 'administrator', 'administrator', 'administrator'),
	(3, 'users', 'users', 'user biasa');
/*!40000 ALTER TABLE `sys_group_users` ENABLE KEYS */;

-- Dumping structure for table new_backend.sys_lang
CREATE TABLE IF NOT EXISTS `sys_lang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `language` varchar(50) NOT NULL,
  `description` varchar(50) NOT NULL,
  `status` enum('Active','Not Active') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table new_backend.sys_lang: ~2 rows (approximately)
/*!40000 ALTER TABLE `sys_lang` DISABLE KEYS */;
INSERT INTO `sys_lang` (`id`, `language`, `description`, `status`) VALUES
	(1, 'en', 'English', 'Not Active'),
	(2, 'id', 'Indonesia', 'Active');
/*!40000 ALTER TABLE `sys_lang` ENABLE KEYS */;

-- Dumping structure for table new_backend.sys_menu
CREATE TABLE IF NOT EXISTS `sys_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nav_act` varchar(150) DEFAULT NULL,
  `page_name` varchar(150) DEFAULT NULL,
  `url` varchar(100) DEFAULT NULL,
  `main_table` varchar(150) DEFAULT NULL,
  `icon` varchar(150) DEFAULT NULL,
  `urutan_menu` int(11) DEFAULT NULL,
  `parent` int(11) DEFAULT NULL,
  `dt_table` enum('Y','N') NOT NULL,
  `tampil` enum('Y','N') NOT NULL,
  `type_menu` enum('main','page','separator') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=latin1;

-- Dumping data for table new_backend.sys_menu: ~10 rows (approximately)
/*!40000 ALTER TABLE `sys_menu` DISABLE KEYS */;
INSERT INTO `sys_menu` (`id`, `nav_act`, `page_name`, `url`, `main_table`, `icon`, `urutan_menu`, `parent`, `dt_table`, `tampil`, `type_menu`) VALUES
	(4, 'sistem', 'system setting', NULL, NULL, 'fa-gear', 1, 0, 'Y', 'Y', 'main'),
	(5, 'page', 'page', 'page', 'sys_menu', 'fa-newspaper-o', 1, 4, 'Y', 'Y', 'page'),
	(6, 'user_group', 'user group', 'user-group', 'sys_users', 'fa-users', 2, 4, 'Y', 'Y', 'page'),
	(7, 'user_managements', 'user managements', 'user-managements', 'sys_menu_role', 'fa-user', 4, 4, 'Y', 'Y', 'page'),
	(8, 'menu_management', 'group permission', 'menu-management', 'sys_users', 'fa-lock', 3, 4, 'Y', 'Y', 'page'),
	(9, 'excel', 'excel generator', 'excel', 'sys_services', 'fa-file-excel-o', 5, 4, 'Y', 'Y', 'page'),
	(10, 'service', 'web service', 'service', 'sys_services', 'fa-server', 6, 4, 'Y', 'Y', 'page'),
	(12, 'service_permission', 'web service permission', 'service-permission', 'sys_services', 'fa-bullseye', 7, 4, 'Y', 'Y', 'page'),
	(23, NULL, 'separator', NULL, NULL, '', 2, 0, 'Y', 'Y', 'separator'),
	(25, NULL, 'second menu', '#', NULL, '', 3, 0, 'Y', 'Y', 'main');
/*!40000 ALTER TABLE `sys_menu` ENABLE KEYS */;

-- Dumping structure for table new_backend.sys_menu_role
CREATE TABLE IF NOT EXISTS `sys_menu_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_menu` int(11) DEFAULT NULL,
  `group_level` varchar(50) DEFAULT NULL,
  `read_act` enum('Y','N') DEFAULT NULL,
  `insert_act` enum('Y','N') DEFAULT NULL,
  `update_act` enum('Y','N') DEFAULT NULL,
  `delete_act` enum('Y','N') DEFAULT NULL,
  `import_act` enum('Y','N') DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_sys_menu_role_sys_menu` (`id_menu`),
  KEY `FK_sys_menu_role_sys_users` (`group_level`),
  CONSTRAINT `FK_sys_menu_role_sys_group_users` FOREIGN KEY (`group_level`) REFERENCES `sys_group_users` (`level`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_sys_menu_role_sys_menu` FOREIGN KEY (`id_menu`) REFERENCES `sys_menu` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=134 DEFAULT CHARSET=latin1;

-- Dumping data for table new_backend.sys_menu_role: ~30 rows (approximately)
/*!40000 ALTER TABLE `sys_menu_role` DISABLE KEYS */;
INSERT INTO `sys_menu_role` (`id`, `id_menu`, `group_level`, `read_act`, `insert_act`, `update_act`, `delete_act`, `import_act`) VALUES
	(10, 4, 'root', 'Y', 'Y', 'Y', 'Y', NULL),
	(11, 4, 'administrator', 'N', 'N', 'N', 'N', NULL),
	(12, 4, 'users', 'N', 'N', 'N', 'N', NULL),
	(13, 5, 'root', 'Y', 'Y', 'Y', 'Y', 'Y'),
	(14, 5, 'administrator', 'N', 'N', 'N', 'N', NULL),
	(15, 5, 'users', 'N', 'N', 'N', 'N', NULL),
	(16, 6, 'root', 'Y', 'Y', 'Y', 'Y', 'Y'),
	(17, 6, 'administrator', 'N', 'N', 'N', 'N', NULL),
	(18, 6, 'users', 'N', 'N', 'N', 'N', NULL),
	(26, 7, 'root', 'Y', 'Y', 'Y', 'Y', 'Y'),
	(27, 7, 'administrator', 'N', 'N', 'N', 'N', NULL),
	(28, 7, 'users', 'N', 'N', 'N', 'N', NULL),
	(29, 8, 'root', 'Y', 'Y', 'Y', 'Y', 'Y'),
	(30, 8, 'administrator', 'N', 'N', 'N', 'N', NULL),
	(31, 8, 'users', 'N', 'N', 'N', 'N', NULL),
	(32, 9, 'root', 'Y', 'Y', 'Y', 'Y', 'Y'),
	(33, 9, 'administrator', 'N', 'N', 'N', 'N', NULL),
	(34, 9, 'users', 'N', 'N', 'N', 'N', NULL),
	(35, 10, 'root', 'Y', 'Y', 'Y', 'Y', 'Y'),
	(36, 10, 'administrator', 'N', 'N', 'N', 'N', NULL),
	(37, 10, 'users', 'N', 'N', 'N', 'N', NULL),
	(41, 12, 'root', 'Y', 'Y', 'Y', 'Y', 'Y'),
	(42, 12, 'administrator', 'N', 'N', 'N', 'N', NULL),
	(43, 12, 'users', 'N', 'N', 'N', 'N', NULL),
	(74, 23, 'root', 'Y', 'Y', 'Y', 'Y', NULL),
	(75, 23, 'administrator', 'N', 'N', 'N', 'N', NULL),
	(76, 23, 'users', 'N', 'N', 'N', 'N', NULL),
	(80, 25, 'root', 'Y', 'Y', 'Y', 'Y', NULL),
	(81, 25, 'administrator', 'N', 'N', 'N', 'N', NULL),
	(82, 25, 'users', 'N', 'N', 'N', 'N', NULL);
/*!40000 ALTER TABLE `sys_menu_role` ENABLE KEYS */;

-- Dumping structure for table new_backend.sys_services
CREATE TABLE IF NOT EXISTS `sys_services` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nav_act` varchar(150) DEFAULT NULL,
  `page_name` varchar(150) DEFAULT NULL,
  `url` varchar(100) DEFAULT NULL,
  `main_table` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=85 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

-- Dumping data for table new_backend.sys_services: ~0 rows (approximately)
/*!40000 ALTER TABLE `sys_services` DISABLE KEYS */;
/*!40000 ALTER TABLE `sys_services` ENABLE KEYS */;

-- Dumping structure for table new_backend.sys_token
CREATE TABLE IF NOT EXISTS `sys_token` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_service` int(11) NOT NULL,
  `enable_token_read` enum('Y','N') NOT NULL,
  `enable_token_create` enum('Y','N') NOT NULL,
  `enable_token_update` enum('Y','N') NOT NULL,
  `enable_token_delete` enum('Y','N') NOT NULL,
  `format_data` enum('json','xml') NOT NULL,
  `read_access` text,
  `create_access` text,
  `update_access` text,
  `delete_access` text,
  PRIMARY KEY (`id`),
  KEY `FK_sys_token_sys_services` (`id_service`),
  CONSTRAINT `FK_sys_token_sys_services` FOREIGN KEY (`id_service`) REFERENCES `sys_services` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=74 DEFAULT CHARSET=latin1;

-- Dumping data for table new_backend.sys_token: ~0 rows (approximately)
/*!40000 ALTER TABLE `sys_token` DISABLE KEYS */;
/*!40000 ALTER TABLE `sys_token` ENABLE KEYS */;

-- Dumping structure for table new_backend.sys_users
CREATE TABLE IF NOT EXISTS `sys_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `full_name` varchar(50) NOT NULL DEFAULT '0',
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `date_created` date DEFAULT NULL,
  `foto_user` varchar(150) DEFAULT NULL,
  `group_level` varchar(50) DEFAULT NULL,
  `aktif` enum('Y','N') NOT NULL,
  `token` varchar(150) DEFAULT NULL,
  `token_expiration` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_sys_users_sys_group_users` (`group_level`),
  CONSTRAINT `FK_sys_users_sys_group_users` FOREIGN KEY (`group_level`) REFERENCES `sys_group_users` (`level`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

-- Dumping data for table new_backend.sys_users: ~3 rows (approximately)
/*!40000 ALTER TABLE `sys_users` DISABLE KEYS */;
INSERT INTO `sys_users` (`id`, `full_name`, `username`, `password`, `email`, `date_created`, `foto_user`, `group_level`, `aktif`, `token`, `token_expiration`) VALUES
	(1, 'mohamad wildannudin', 'root', '63a9f0ea7bb98050796b649e85481845', 'wildannudin@gmail.com', '2015-01-26', '154972622025779.jpg', 'root', 'Y', 'd8deaa1f6cc03157ff31209c497a7d2f', '2016-07-13 17:58:38'),
	(10, 'administrator', 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin@gmail.com', NULL, '154971956312834.jpg', 'administrator', 'Y', '2c0491cfd873acafd4c15a7775e67902', '2019-03-14 21:05:02'),
	(12, 'tes', 'tes', '28b662d883b6d76fd96e4ddc5e9ba780', 'teknis1@gmail.com', NULL, '1552521778770623413.jpg', 'users', 'Y', NULL, NULL);
/*!40000 ALTER TABLE `sys_users` ENABLE KEYS */;

-- Dumping structure for table new_backend.tb_album
CREATE TABLE IF NOT EXISTS `tb_album` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `judul_album` varchar(100) DEFAULT NULL,
  `deskripsi_album` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table new_backend.tb_album: ~2 rows (approximately)
/*!40000 ALTER TABLE `tb_album` DISABLE KEYS */;
INSERT INTO `tb_album` (`id`, `judul_album`, `deskripsi_album`) VALUES
	(1, 'kampus', 'ngusep kampus'),
	(2, 'uyt', 'gt');
/*!40000 ALTER TABLE `tb_album` ENABLE KEYS */;

-- Dumping structure for table new_backend.tb_foto
CREATE TABLE IF NOT EXISTS `tb_foto` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file_foto` varchar(45) DEFAULT NULL,
  `deskripsi_foto` varchar(45) DEFAULT NULL,
  `id_album` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_tb_foto_1_idx` (`id_album`),
  CONSTRAINT `fk_tb_foto_1` FOREIGN KEY (`id_album`) REFERENCES `tb_album` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

-- Dumping data for table new_backend.tb_foto: ~0 rows (approximately)
/*!40000 ALTER TABLE `tb_foto` DISABLE KEYS */;
INSERT INTO `tb_foto` (`id`, `file_foto`, `deskripsi_foto`, `id_album`) VALUES
	(14, NULL, 'nyobaan', NULL);
/*!40000 ALTER TABLE `tb_foto` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
