/*
SQLyog Ultimate v13.1.1 (64 bit)
MySQL - 10.4.32-MariaDB : Database - ipak
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `assembly_barang_jadi` */

DROP TABLE IF EXISTS `assembly_barang_jadi`;

CREATE TABLE `assembly_barang_jadi` (
  `id_assembly` int(20) NOT NULL AUTO_INCREMENT,
  `tanggal` date DEFAULT NULL,
  `id_detail_komposisi` int(15) DEFAULT NULL,
  `kode_stiker` char(25) DEFAULT NULL,
  `qty` int(20) DEFAULT NULL,
  PRIMARY KEY (`id_assembly`),
  KEY `id_detail_komposisi` (`id_detail_komposisi`),
  KEY `kode_stiker` (`kode_stiker`),
  CONSTRAINT `assembly_barang_jadi_ibfk_1` FOREIGN KEY (`id_detail_komposisi`) REFERENCES `detail_komposisi` (`id_detail_komposisi`),
  CONSTRAINT `assembly_barang_jadi_ibfk_2` FOREIGN KEY (`kode_stiker`) REFERENCES `jenis_gambar_stiker` (`kode_stiker`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Table structure for table `bahan_baku_lapak` */

DROP TABLE IF EXISTS `bahan_baku_lapak`;

CREATE TABLE `bahan_baku_lapak` (
  `id_bahan_baku` int(10) NOT NULL AUTO_INCREMENT,
  `kode_bahan` char(15) DEFAULT NULL,
  `lokasi` varchar(50) DEFAULT NULL,
  `id_tanggal` int(11) DEFAULT NULL,
  `qty_lapak` decimal(10,2) DEFAULT NULL,
  `qty_pabrik` decimal(10,2) DEFAULT NULL,
  `ceklist` enum('belum','sudah') DEFAULT 'belum',
  PRIMARY KEY (`id_bahan_baku`),
  KEY `id_tanggal` (`id_tanggal`),
  KEY `kode_bahan` (`kode_bahan`),
  CONSTRAINT `bahan_baku_lapak_ibfk_1` FOREIGN KEY (`id_tanggal`) REFERENCES `tanggal_bahan_lapak` (`id_tanggal`),
  CONSTRAINT `bahan_baku_lapak_ibfk_2` FOREIGN KEY (`kode_bahan`) REFERENCES `kode_bahan` (`kode_bahan`)
) ENGINE=InnoDB AUTO_INCREMENT=129 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Table structure for table `bahan_utama_keluar` */

DROP TABLE IF EXISTS `bahan_utama_keluar`;

CREATE TABLE `bahan_utama_keluar` (
  `id_detail_bahan_utama` int(15) NOT NULL,
  `keluar` int(20) DEFAULT NULL,
  PRIMARY KEY (`id_detail_bahan_utama`),
  CONSTRAINT `bahan_utama_keluar_ibfk_1` FOREIGN KEY (`id_detail_bahan_utama`) REFERENCES `detail_bahan_utama` (`id_detail_bahan_utama`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Table structure for table `barang_jadi` */

DROP TABLE IF EXISTS `barang_jadi`;

CREATE TABLE `barang_jadi` (
  `kode_barang` char(50) NOT NULL,
  `merk` enum('Bubblestar','Yukari','Lollipop') DEFAULT NULL,
  `type` int(10) DEFAULT NULL,
  `susun` int(10) DEFAULT NULL,
  `karakter` varchar(100) DEFAULT NULL,
  `kunci` enum('Key','Non Key') DEFAULT NULL,
  `hanger` enum('Hanger','Non Hanger') DEFAULT NULL,
  `warna` int(10) DEFAULT NULL,
  `jumlah` int(50) DEFAULT 0,
  PRIMARY KEY (`kode_barang`),
  KEY `type` (`type`),
  KEY `warna` (`warna`),
  CONSTRAINT `barang_jadi_ibfk_1` FOREIGN KEY (`type`) REFERENCES `type` (`id_type`),
  CONSTRAINT `barang_jadi_ibfk_2` FOREIGN KEY (`warna`) REFERENCES `jenis_warna` (`id_warna`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Table structure for table `customer` */

DROP TABLE IF EXISTS `customer`;

CREATE TABLE `customer` (
  `id_customer` int(10) NOT NULL AUTO_INCREMENT,
  `nama_customer` varchar(50) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `telepon` char(50) DEFAULT NULL,
  PRIMARY KEY (`id_customer`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Table structure for table `detail_bahan_utama` */

DROP TABLE IF EXISTS `detail_bahan_utama`;

CREATE TABLE `detail_bahan_utama` (
  `id_detail_bahan_utama` int(15) NOT NULL AUTO_INCREMENT,
  `kode_bahan` char(50) DEFAULT NULL,
  `nama_bahan` varchar(100) DEFAULT NULL,
  `warna` int(10) DEFAULT NULL,
  `jenis_bahan` varchar(100) DEFAULT NULL,
  `jumlah` decimal(10,2) DEFAULT 0.00,
  PRIMARY KEY (`id_detail_bahan_utama`),
  KEY `warna` (`warna`),
  CONSTRAINT `detail_bahan_utama_ibfk_1` FOREIGN KEY (`warna`) REFERENCES `jenis_warna` (`id_warna`)
) ENGINE=InnoDB AUTO_INCREMENT=397 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Table structure for table `detail_komposisi` */

DROP TABLE IF EXISTS `detail_komposisi`;

CREATE TABLE `detail_komposisi` (
  `id_detail_komposisi` int(15) NOT NULL AUTO_INCREMENT,
  `kode_barang` char(50) DEFAULT NULL,
  `kode_komponen` char(50) DEFAULT NULL,
  `qty` int(20) DEFAULT NULL,
  `total_berat` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id_detail_komposisi`),
  KEY `kode_komponen` (`kode_komponen`),
  KEY `kode_barang` (`kode_barang`),
  CONSTRAINT `detail_komposisi_ibfk_2` FOREIGN KEY (`kode_komponen`) REFERENCES `komponen` (`code_komponen`),
  CONSTRAINT `detail_komposisi_ibfk_3` FOREIGN KEY (`kode_barang`) REFERENCES `barang_jadi` (`kode_barang`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Table structure for table `jenis_bahan` */

DROP TABLE IF EXISTS `jenis_bahan`;

CREATE TABLE `jenis_bahan` (
  `id_jenis_bahan` int(50) NOT NULL AUTO_INCREMENT,
  `jenis_bahan` char(10) DEFAULT NULL,
  `nama_jenis_bahan` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_jenis_bahan`)
) ENGINE=InnoDB AUTO_INCREMENT=850 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Table structure for table `jenis_gambar_stiker` */

DROP TABLE IF EXISTS `jenis_gambar_stiker`;

CREATE TABLE `jenis_gambar_stiker` (
  `kode_stiker` char(25) NOT NULL,
  `nama_stiker` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`kode_stiker`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Table structure for table `jenis_warna` */

DROP TABLE IF EXISTS `jenis_warna`;

CREATE TABLE `jenis_warna` (
  `id_warna` int(10) NOT NULL AUTO_INCREMENT,
  `nama_warna` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_warna`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Table structure for table `kode_bahan` */

DROP TABLE IF EXISTS `kode_bahan`;

CREATE TABLE `kode_bahan` (
  `kode_bahan` char(15) NOT NULL,
  `id_jenis_bahan` int(11) DEFAULT NULL,
  `id_warna` int(11) DEFAULT NULL,
  `id_supplier` int(11) DEFAULT NULL,
  `jumlah` int(15) DEFAULT 0,
  PRIMARY KEY (`kode_bahan`),
  KEY `id_warna` (`id_warna`),
  KEY `id_jenis_bahan` (`id_jenis_bahan`),
  KEY `id_supplier` (`id_supplier`),
  CONSTRAINT `kode_bahan_ibfk_2` FOREIGN KEY (`id_warna`) REFERENCES `jenis_warna` (`id_warna`),
  CONSTRAINT `kode_bahan_ibfk_3` FOREIGN KEY (`id_jenis_bahan`) REFERENCES `jenis_bahan` (`id_jenis_bahan`),
  CONSTRAINT `kode_bahan_ibfk_4` FOREIGN KEY (`id_supplier`) REFERENCES `supplier` (`id_supplier`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Table structure for table `kode_kendaraan` */

DROP TABLE IF EXISTS `kode_kendaraan`;

CREATE TABLE `kode_kendaraan` (
  `kode_kendaraan` char(25) NOT NULL,
  `nama_kendaraan` varchar(100) DEFAULT NULL,
  `no_polisi` char(50) DEFAULT NULL,
  `jenis_mobil` varchar(100) DEFAULT NULL,
  `tahun_pembuatan` int(50) DEFAULT NULL,
  `jbki` decimal(10,2) DEFAULT NULL,
  `jbi` decimal(10,2) DEFAULT NULL,
  `daya_angkut` decimal(10,2) DEFAULT NULL,
  `atas_nama` varchar(50) DEFAULT NULL,
  `kebersihan` varchar(50) DEFAULT NULL,
  `air_aki` varchar(50) DEFAULT NULL,
  `tangki_bahan_bakar` varchar(50) DEFAULT NULL,
  `air_wiper` varchar(50) DEFAULT NULL,
  `air_radiator` varchar(50) DEFAULT NULL,
  `minyak_rem` varchar(50) DEFAULT NULL,
  `lampu` varchar(50) DEFAULT NULL,
  `kaca_spion` varchar(50) DEFAULT NULL,
  `wiper_kaca` varchar(50) DEFAULT NULL,
  `klakson` varchar(50) DEFAULT NULL,
  `rem` varchar(50) DEFAULT NULL,
  `ban_kanan_d` varchar(50) DEFAULT NULL,
  `ban_kiri_d` varchar(50) DEFAULT NULL,
  `ban_kanan_bd` varchar(50) DEFAULT NULL,
  `ban_kiri_bd` varchar(50) DEFAULT NULL,
  `ban_kanan_bl` varchar(50) DEFAULT NULL,
  `ban_kiri_bl` varchar(50) DEFAULT NULL,
  `mesin` varchar(50) DEFAULT NULL,
  `surat_kendaraan` varchar(50) DEFAULT NULL,
  `kunci_peralatan` varchar(50) DEFAULT NULL,
  `kotak_p3k_apar` varchar(50) DEFAULT NULL,
  `filter_udara` varchar(50) DEFAULT NULL,
  `filter_oli` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`kode_kendaraan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Table structure for table `kode_komponen_pendukung` */

DROP TABLE IF EXISTS `kode_komponen_pendukung`;

CREATE TABLE `kode_komponen_pendukung` (
  `id_pendukung` char(25) NOT NULL,
  `nama_barang` varchar(100) DEFAULT NULL,
  `jumlah` int(50) DEFAULT 0,
  PRIMARY KEY (`id_pendukung`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Table structure for table `komponen` */

DROP TABLE IF EXISTS `komponen`;

CREATE TABLE `komponen` (
  `code_komponen` char(50) NOT NULL,
  `nama_komponen` varchar(50) DEFAULT NULL,
  `bahan` char(25) DEFAULT NULL,
  `berat_komponen` char(50) DEFAULT NULL,
  `cycle_time` char(50) DEFAULT NULL,
  `warna` int(11) DEFAULT NULL,
  `id_type` int(10) DEFAULT NULL,
  `jumlah_ok` int(20) DEFAULT 0,
  `jumlah_ng` int(20) DEFAULT 0,
  PRIMARY KEY (`code_komponen`),
  KEY `detail_bahan_utama` (`bahan`),
  KEY `warna` (`warna`),
  KEY `id_type` (`id_type`),
  CONSTRAINT `komponen_ibfk_3` FOREIGN KEY (`warna`) REFERENCES `jenis_warna` (`id_warna`),
  CONSTRAINT `komponen_ibfk_4` FOREIGN KEY (`id_type`) REFERENCES `type` (`id_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Table structure for table `komponen_keluar` */

DROP TABLE IF EXISTS `komponen_keluar`;

CREATE TABLE `komponen_keluar` (
  `id_komponen` int(25) NOT NULL AUTO_INCREMENT,
  `tgl` datetime DEFAULT NULL,
  `code_komponen` char(50) DEFAULT NULL,
  `jumlah` char(20) DEFAULT NULL,
  PRIMARY KEY (`id_komponen`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Table structure for table `kondisi_kendaraan` */

DROP TABLE IF EXISTS `kondisi_kendaraan`;

CREATE TABLE `kondisi_kendaraan` (
  `id_kondisi` int(20) NOT NULL AUTO_INCREMENT,
  `tanggal` date DEFAULT NULL,
  `kode_kendaraan` char(25) DEFAULT NULL,
  `kebersihan` varchar(50) DEFAULT NULL,
  `air_aki` varchar(50) DEFAULT NULL,
  `tangki_bahan_bakar` varchar(50) DEFAULT NULL,
  `air_wiper` varchar(50) DEFAULT NULL,
  `air_radiator` varchar(50) DEFAULT NULL,
  `minyak_rem` varchar(50) DEFAULT NULL,
  `lampu` varchar(50) DEFAULT NULL,
  `kaca_spion` varchar(50) DEFAULT NULL,
  `wiper_kaca` varchar(50) DEFAULT NULL,
  `klakson` varchar(50) DEFAULT NULL,
  `rem` varchar(50) DEFAULT NULL,
  `ban_kanan_d` varchar(50) DEFAULT NULL,
  `ban_kiri_d` varchar(50) DEFAULT NULL,
  `ban_kanan_bl` varchar(50) DEFAULT NULL,
  `ban_kanan_bd` varchar(50) DEFAULT NULL,
  `ban_kiri_bl` varchar(50) DEFAULT NULL,
  `ban_kiri_bd` varchar(50) DEFAULT NULL,
  `mesin` varchar(50) DEFAULT NULL,
  `surat_kendaraan` varchar(50) DEFAULT NULL,
  `kunci_peralatan` varchar(50) DEFAULT NULL,
  `kotak_p3k_apar` varchar(50) DEFAULT NULL,
  `filter_udara` varchar(50) DEFAULT NULL,
  `filter_oli` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_kondisi`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Table structure for table `mesin` */

DROP TABLE IF EXISTS `mesin`;

CREATE TABLE `mesin` (
  `code_mesin` char(50) NOT NULL,
  `nama_mesin` varchar(100) DEFAULT NULL,
  `merk` varchar(100) DEFAULT NULL,
  `tahun_pembuatan` int(10) DEFAULT NULL,
  `kapasitas` char(50) DEFAULT NULL,
  `lokasi` varchar(50) DEFAULT NULL,
  `type` char(50) DEFAULT NULL,
  `pn_model` char(25) DEFAULT NULL,
  `sn` char(50) DEFAULT NULL,
  `refrigent` char(20) DEFAULT NULL,
  `phase` char(15) DEFAULT NULL,
  `volt` decimal(10,2) DEFAULT NULL,
  `arus` decimal(10,2) DEFAULT NULL,
  `hp` decimal(10,2) DEFAULT NULL,
  `daya` decimal(10,2) DEFAULT NULL,
  `berat` decimal(10,2) DEFAULT NULL,
  `temperatur` char(20) DEFAULT NULL,
  `hz` char(20) DEFAULT NULL,
  `rpm` int(20) DEFAULT NULL,
  `no_mfg` char(20) DEFAULT NULL,
  `isi_oli` decimal(10,2) DEFAULT NULL,
  `pole` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`code_mesin`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Table structure for table `proses_crusher` */

DROP TABLE IF EXISTS `proses_crusher`;

CREATE TABLE `proses_crusher` (
  `id_proses_crusher` int(15) NOT NULL AUTO_INCREMENT,
  `id_tanggal` int(15) DEFAULT NULL,
  `operator` varchar(50) DEFAULT NULL,
  `code_bahan` char(15) DEFAULT NULL,
  `qty_pakai` decimal(10,2) DEFAULT NULL,
  `bahan_crusher` char(15) DEFAULT NULL,
  `total_hasil` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id_proses_crusher`),
  KEY `code_bahan` (`code_bahan`),
  KEY `id_tanggal` (`id_tanggal`),
  KEY `id_detail_bahan_utama` (`bahan_crusher`),
  CONSTRAINT `proses_crusher_ibfk_1` FOREIGN KEY (`code_bahan`) REFERENCES `kode_bahan` (`kode_bahan`),
  CONSTRAINT `proses_crusher_ibfk_3` FOREIGN KEY (`id_tanggal`) REFERENCES `tanggal_proses_crusher` (`id_tanggal_crusher`),
  CONSTRAINT `proses_crusher_ibfk_4` FOREIGN KEY (`bahan_crusher`) REFERENCES `kode_bahan` (`kode_bahan`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Table structure for table `proses_komponen` */

DROP TABLE IF EXISTS `proses_komponen`;

CREATE TABLE `proses_komponen` (
  `id_proses` int(15) NOT NULL AUTO_INCREMENT,
  `tgl` int(15) DEFAULT NULL,
  `regu` enum('A','B','C') DEFAULT NULL,
  `shift` enum('1','2','3') DEFAULT NULL,
  `jam_mulai` time DEFAULT NULL,
  `jam_selesai` time DEFAULT NULL,
  `nama_operator` varchar(100) DEFAULT NULL,
  `kode_mesin` char(50) DEFAULT NULL,
  `code_komponen` char(50) DEFAULT NULL,
  `bahan_pakai` decimal(10,2) DEFAULT NULL,
  `produksi_ok` char(50) DEFAULT NULL,
  `produksi_ng` char(50) DEFAULT NULL,
  PRIMARY KEY (`id_proses`),
  KEY `code_komponen` (`code_komponen`),
  KEY `kode_mesin` (`kode_mesin`),
  KEY `tgl` (`tgl`),
  CONSTRAINT `proses_komponen_ibfk_1` FOREIGN KEY (`code_komponen`) REFERENCES `komponen` (`code_komponen`),
  CONSTRAINT `proses_komponen_ibfk_2` FOREIGN KEY (`kode_mesin`) REFERENCES `mesin` (`code_mesin`),
  CONSTRAINT `proses_komponen_ibfk_3` FOREIGN KEY (`tgl`) REFERENCES `tanggal_komponen` (`id_tgl`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Table structure for table `proses_recycle` */

DROP TABLE IF EXISTS `proses_recycle`;

CREATE TABLE `proses_recycle` (
  `id_proses` int(15) NOT NULL AUTO_INCREMENT,
  `id_tanggal_proses` int(20) DEFAULT NULL,
  `shift` enum('1','2','3') DEFAULT NULL,
  `line` enum('A','B') DEFAULT NULL,
  `jam_mulai` time DEFAULT NULL,
  `jam_selesai` time DEFAULT NULL,
  `kode_bahan` char(15) DEFAULT NULL,
  `qty_ambil` decimal(10,2) DEFAULT NULL,
  `sortir` enum('sortir','non-sortir') DEFAULT NULL,
  `id_detail_bahan_utama` int(15) DEFAULT NULL,
  `hasil` decimal(10,2) DEFAULT NULL,
  `ceklist` enum('sudah','belum') DEFAULT 'belum',
  PRIMARY KEY (`id_proses`),
  KEY `id_tanggal_proses` (`id_tanggal_proses`),
  KEY `kode_bahan` (`kode_bahan`),
  KEY `id_detail_bahan_utama` (`id_detail_bahan_utama`),
  CONSTRAINT `proses_recycle_ibfk_3` FOREIGN KEY (`id_tanggal_proses`) REFERENCES `tanggal_proses_recycle` (`id_proses`),
  CONSTRAINT `proses_recycle_ibfk_4` FOREIGN KEY (`kode_bahan`) REFERENCES `kode_bahan` (`kode_bahan`),
  CONSTRAINT `proses_recycle_ibfk_5` FOREIGN KEY (`id_detail_bahan_utama`) REFERENCES `detail_bahan_utama` (`id_detail_bahan_utama`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Table structure for table `spbg_bahan_baku` */

DROP TABLE IF EXISTS `spbg_bahan_baku`;

CREATE TABLE `spbg_bahan_baku` (
  `id_spbg` int(15) NOT NULL AUTO_INCREMENT,
  `no_spbg` char(50) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `kode_bahan` int(15) DEFAULT NULL,
  `jumlah` decimal(10,2) DEFAULT NULL,
  `sisa` decimal(10,2) DEFAULT NULL,
  `keterangan` varchar(100) DEFAULT NULL,
  `cek` enum('sudah','belum') DEFAULT 'belum',
  PRIMARY KEY (`id_spbg`),
  KEY `kode_bahan` (`kode_bahan`),
  CONSTRAINT `spbg_bahan_baku_ibfk_1` FOREIGN KEY (`kode_bahan`) REFERENCES `detail_bahan_utama` (`id_detail_bahan_utama`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Table structure for table `supplier` */

DROP TABLE IF EXISTS `supplier`;

CREATE TABLE `supplier` (
  `id_supplier` int(10) NOT NULL AUTO_INCREMENT,
  `nama_supplier` varchar(50) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `no_tlp` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_supplier`)
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Table structure for table `surat_jalan` */

DROP TABLE IF EXISTS `surat_jalan`;

CREATE TABLE `surat_jalan` (
  `id_surat` int(15) NOT NULL,
  `no_surat` varchar(50) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `nama_penerima` varchar(150) DEFAULT NULL,
  `alamat_penerima` text DEFAULT NULL,
  `kode_kendaraan` char(25) DEFAULT NULL,
  `sopir` varchar(150) DEFAULT NULL,
  `status` enum('dikirim','diterima','dibatalkan') DEFAULT NULL,
  `tgl` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_surat`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Table structure for table `surat_jalan_detail` */

DROP TABLE IF EXISTS `surat_jalan_detail`;

CREATE TABLE `surat_jalan_detail` (
  `id_detail` int(15) NOT NULL AUTO_INCREMENT,
  `id_surat` int(15) DEFAULT NULL,
  `kode_barang` char(50) DEFAULT NULL,
  `jumlah` decimal(10,2) DEFAULT NULL,
  `keterangan` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id_detail`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Table structure for table `tanggal_bahan_lapak` */

DROP TABLE IF EXISTS `tanggal_bahan_lapak`;

CREATE TABLE `tanggal_bahan_lapak` (
  `id_tanggal` int(11) NOT NULL,
  `tanggal` date DEFAULT NULL,
  `no_surat` varchar(50) DEFAULT NULL,
  `plat` varchar(25) DEFAULT NULL,
  `supir` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_tanggal`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Table structure for table `tanggal_komponen` */

DROP TABLE IF EXISTS `tanggal_komponen`;

CREATE TABLE `tanggal_komponen` (
  `id_tgl` int(15) NOT NULL AUTO_INCREMENT,
  `tanggal` date DEFAULT NULL,
  PRIMARY KEY (`id_tgl`)
) ENGINE=InnoDB AUTO_INCREMENT=636038838 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Table structure for table `tanggal_proses_crusher` */

DROP TABLE IF EXISTS `tanggal_proses_crusher`;

CREATE TABLE `tanggal_proses_crusher` (
  `id_tanggal_crusher` int(15) NOT NULL AUTO_INCREMENT,
  `tanggal` date DEFAULT NULL,
  PRIMARY KEY (`id_tanggal_crusher`)
) ENGINE=InnoDB AUTO_INCREMENT=995916483 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Table structure for table `tanggal_proses_recycle` */

DROP TABLE IF EXISTS `tanggal_proses_recycle`;

CREATE TABLE `tanggal_proses_recycle` (
  `id_proses` int(20) NOT NULL,
  `tanggal` date DEFAULT NULL,
  PRIMARY KEY (`id_proses`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Table structure for table `type` */

DROP TABLE IF EXISTS `type`;

CREATE TABLE `type` (
  `id_type` int(10) NOT NULL AUTO_INCREMENT,
  `type` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_type`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id_users` int(10) NOT NULL AUTO_INCREMENT,
  `nama` varchar(50) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` char(50) DEFAULT NULL,
  `role` enum('admin','Bahan_lapak','Produksi','Logistik','direkrut','teknisi') DEFAULT NULL,
  `cereate_at` datetime DEFAULT NULL,
  `aktif` enum('aktif','non-aktif') DEFAULT NULL,
  PRIMARY KEY (`id_users`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
