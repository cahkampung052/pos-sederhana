-- Adminer 4.7.7 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `m_customer`;
CREATE TABLE `m_customer` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `no_hp` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `alamat` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;


DROP TABLE IF EXISTS `m_produk`;
CREATE TABLE `m_produk` (
  `id` int NOT NULL AUTO_INCREMENT,
  `m_produk_kategori_id` int NOT NULL,
  `nama` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `deskripsi` text CHARACTER SET utf8 COLLATE utf8_general_ci,
  `harga_beli` double DEFAULT NULL,
  `harga_jual` double DEFAULT NULL,
  `foto` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `m_produk_kategori_id` (`m_produk_kategori_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

INSERT INTO `m_produk` (`id`, `m_produk_kategori_id`, `nama`, `deskripsi`, `harga_beli`, `harga_jual`, `foto`) VALUES
(1,	1,	'Majoo Pro',	'<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry</p>',	2500000,	2750000,	'20220108/1641706183_e3fb4fab1e77333488d8.png'),
(2,	1,	'Majoo Advance',	'<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a</p>',	2200000,	2750000,	'20220108/1641706294_14a0fbbba8d7f3c86699.png'),
(3,	1,	'Majoo Lifestyle',	'<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged</p>',	2200000,	2750000,	'20220108/1641706378_f55e651ceab8417bff6d.png'),
(4,	1,	'Majoo Desktop',	'<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged</p>',	2300000,	2750000,	'20220108/1641706417_e074385325e9ecfd83de.png');

DROP TABLE IF EXISTS `m_produk_kategori`;
CREATE TABLE `m_produk_kategori` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

INSERT INTO `m_produk_kategori` (`id`, `nama`) VALUES
(1,	'Jasa Poin Of Sales'),
(2,	'Paket Toko Ritel');

DROP TABLE IF EXISTS `m_supplier`;
CREATE TABLE `m_supplier` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama` varchar(50) NOT NULL,
  `no_telepon` varchar(25) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;


DROP TABLE IF EXISTS `m_user`;
CREATE TABLE `m_user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama` varchar(50) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

INSERT INTO `m_user` (`id`, `nama`, `email`, `password`) VALUES
(1,	'Wahyu Agung Tribawono',	'wahyu@admin.com',	'$2y$10$ASDuvcMvcBnfYj4SlhxJ.uhBp/9LsTGfw3A8/fZGxNfMkAsb7vqcu'),
(5,	'Yustanti',	'yustantidwi@gmail.com',	'$2y$10$qq8hAWQZb/9h4tQfvmMqr.mh4.FJZf6kUfyphoTLv.avlLxf3/rry');

-- 2022-01-09 14:58:49
