/*
 Navicat Premium Data Transfer

 Source Server         : local_mysql
 Source Server Type    : MySQL
 Source Server Version : 100132
 Source Host           : localhost:3306
 Source Schema         : penggajian

 Target Server Type    : MySQL
 Target Server Version : 100132
 File Encoding         : 65001

 Date: 16/09/2018 18:13:47
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for absensi
-- ----------------------------
DROP TABLE IF EXISTS `absensi`;
CREATE TABLE `absensi`  (
  `id_absensi` int(20) NOT NULL AUTO_INCREMENT,
  `id_karyawan` int(10) NOT NULL,
  `tgl` date NOT NULL,
  `keterangan` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `jam_masuk` time(0) NULL DEFAULT NULL,
  `jam_pulang` time(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id_absensi`) USING BTREE,
  INDEX `id_karyawan`(`id_karyawan`) USING BTREE,
  CONSTRAINT `absensi_ibfk_1` FOREIGN KEY (`id_karyawan`) REFERENCES `karyawan` (`id_karyawan`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 60 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of absensi
-- ----------------------------
INSERT INTO `absensi` VALUES (51, 3, '2018-09-15', NULL, '10:08:15', '22:10:12');
INSERT INTO `absensi` VALUES (52, 6, '2018-09-15', NULL, '07:10:06', '17:00:11');
INSERT INTO `absensi` VALUES (53, 10, '2018-09-15', NULL, '07:10:12', '20:08:00');
INSERT INTO `absensi` VALUES (54, 11, '2018-09-15', NULL, '07:10:17', '20:08:10');
INSERT INTO `absensi` VALUES (55, 9, '2018-09-15', NULL, '07:10:21', '17:00:15');
INSERT INTO `absensi` VALUES (56, 12, '2018-09-15', NULL, '07:10:25', '20:07:11');
INSERT INTO `absensi` VALUES (57, 13, '2018-09-15', NULL, '07:10:30', '20:07:33');
INSERT INTO `absensi` VALUES (58, 14, '2018-09-15', NULL, '07:10:36', '20:08:19');
INSERT INTO `absensi` VALUES (59, 10, '2018-10-15', NULL, '07:10:12', '20:08:00');

-- ----------------------------
-- Table structure for akun
-- ----------------------------
DROP TABLE IF EXISTS `akun`;
CREATE TABLE `akun`  (
  `id_akun` int(10) NOT NULL AUTO_INCREMENT,
  `nama_akun` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `keterangan` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0),
  `updated_at` timestamp(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id_akun`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of akun
-- ----------------------------
INSERT INTO `akun` VALUES (1, 'kas', 'keterangan kas', '2018-08-28 19:56:15', NULL);
INSERT INTO `akun` VALUES (3, 'hutang gaji', '', '2018-09-07 20:08:30', NULL);

-- ----------------------------
-- Table structure for divisi
-- ----------------------------
DROP TABLE IF EXISTS `divisi`;
CREATE TABLE `divisi`  (
  `id_divisi` int(10) NOT NULL AUTO_INCREMENT,
  `kode_divisi` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `nama_divisi` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id_divisi`) USING BTREE,
  UNIQUE INDEX `kode_divisi`(`kode_divisi`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of divisi
-- ----------------------------
INSERT INTO `divisi` VALUES (1, 'DV20180712205830', 'KANTOR', '2018-07-13 10:58:30', NULL);
INSERT INTO `divisi` VALUES (6, 'DV20180717172049', 'PRODUKSI', '2018-07-18 07:20:49', NULL);

-- ----------------------------
-- Table structure for gapok
-- ----------------------------
DROP TABLE IF EXISTS `gapok`;
CREATE TABLE `gapok`  (
  `id_gapok` int(10) NOT NULL AUTO_INCREMENT,
  `id_karyawan` int(10) NOT NULL,
  `gaji_pokok` int(100) NOT NULL,
  `jenis_pembayaran` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` time(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id_gapok`) USING BTREE,
  INDEX `id_karyawan`(`id_karyawan`) USING BTREE,
  CONSTRAINT `gapok_ibfk_1` FOREIGN KEY (`id_karyawan`) REFERENCES `karyawan` (`id_karyawan`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 27 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of gapok
-- ----------------------------
INSERT INTO `gapok` VALUES (12, 3, 3800000, 'perbulan', '2018-08-04 21:02:30', '07:05:06');
INSERT INTO `gapok` VALUES (13, 6, 200000, 'perhari', '2018-08-05 09:09:54', NULL);
INSERT INTO `gapok` VALUES (14, 7, 165000, 'perhari', '2018-08-05 09:10:38', NULL);
INSERT INTO `gapok` VALUES (15, 17, 90000, 'perhari', '2018-08-05 09:11:17', NULL);
INSERT INTO `gapok` VALUES (16, 5, 5000000, 'perbulan', '2018-08-05 09:11:44', NULL);
INSERT INTO `gapok` VALUES (17, 16, 130000, 'perhari', '2018-08-05 09:12:12', NULL);
INSERT INTO `gapok` VALUES (18, 4, 3800000, 'perbulan', '2018-08-05 09:12:57', NULL);
INSERT INTO `gapok` VALUES (19, 8, 150000, 'perhari', '2018-08-05 09:13:23', NULL);
INSERT INTO `gapok` VALUES (20, 13, 150000, 'perhari', '2018-08-05 09:13:44', NULL);
INSERT INTO `gapok` VALUES (21, 14, 100000, 'perhari', '2018-08-05 09:14:11', NULL);
INSERT INTO `gapok` VALUES (22, 15, 100000, 'perhari', '2018-08-05 09:14:23', NULL);
INSERT INTO `gapok` VALUES (23, 10, 150000, 'perhari', '2018-08-05 09:14:51', NULL);
INSERT INTO `gapok` VALUES (24, 11, 150000, 'perhari', '2018-08-05 09:15:29', NULL);
INSERT INTO `gapok` VALUES (25, 12, 150000, 'perhari', '2018-08-05 09:15:42', NULL);
INSERT INTO `gapok` VALUES (26, 18, 3500000, 'perbulan', '2018-08-05 08:59:55', NULL);

-- ----------------------------
-- Table structure for jabatan
-- ----------------------------
DROP TABLE IF EXISTS `jabatan`;
CREATE TABLE `jabatan`  (
  `id_jabatan` int(10) NOT NULL AUTO_INCREMENT,
  `id_divisi` int(10) NOT NULL,
  `kode_jabatan` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `nama_jabatan` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id_jabatan`) USING BTREE,
  UNIQUE INDEX `kode_jabatan`(`kode_jabatan`) USING BTREE,
  INDEX `id_divisi`(`id_divisi`) USING BTREE,
  CONSTRAINT `jabatan_ibfk_1` FOREIGN KEY (`id_divisi`) REFERENCES `divisi` (`id_divisi`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 15 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of jabatan
-- ----------------------------
INSERT INTO `jabatan` VALUES (3, 6, 'JBT20180717172101', 'KEPALA PRODUKSI', '2018-07-18 07:21:01', '2018-08-05 09:15:15');
INSERT INTO `jabatan` VALUES (4, 1, 'JBT20180717173012', 'STAFF ADMINISTRASI', '2018-07-18 07:30:12', NULL);
INSERT INTO `jabatan` VALUES (5, 1, 'JBT20180721143714', 'STAFF AKUNTING', '2018-07-22 04:37:14', NULL);
INSERT INTO `jabatan` VALUES (6, 1, 'JBT20180721143724', 'ARSITEK', '2018-07-22 04:37:24', NULL);
INSERT INTO `jabatan` VALUES (7, 6, 'JBT20180721143808', 'MANDOR KAYU', '2018-07-22 04:38:08', NULL);
INSERT INTO `jabatan` VALUES (8, 6, 'JBT20180721143822', 'ASISTEN MANDOR', '2018-07-22 04:38:22', NULL);
INSERT INTO `jabatan` VALUES (9, 6, 'JBT20180721143831', 'TUKANG', '2018-07-22 04:38:31', NULL);
INSERT INTO `jabatan` VALUES (10, 6, 'JBT20180721143844', 'MANDOR SIPIL', '2018-07-22 04:38:44', NULL);
INSERT INTO `jabatan` VALUES (11, 6, 'JBT20180721143913', 'MANDOR FINISHING', '2018-07-22 04:39:13', NULL);
INSERT INTO `jabatan` VALUES (12, 6, 'JBT20180721143923', 'TUKANG FINISHING', '2018-07-22 04:39:23', NULL);
INSERT INTO `jabatan` VALUES (13, 1, 'JBT20180804205959', 'STAFF KEPEGAWAIAN', '2018-08-05 10:59:59', NULL);
INSERT INTO `jabatan` VALUES (14, 1, 'JBT20180804191636', 'SECURITY', '2018-08-05 09:16:36', NULL);

-- ----------------------------
-- Table structure for jurnal
-- ----------------------------
DROP TABLE IF EXISTS `jurnal`;
CREATE TABLE `jurnal`  (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `kode_jurnal` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `kode_akun` int(10) NOT NULL,
  `debet` int(100) NULL DEFAULT NULL,
  `kredit` int(255) NULL DEFAULT NULL,
  `tgl` date NULL DEFAULT NULL,
  `created_at` datetime(0) NULL DEFAULT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `kode_akun`(`kode_akun`) USING BTREE,
  CONSTRAINT `jurnal_ibfk_1` FOREIGN KEY (`kode_akun`) REFERENCES `akun` (`id_akun`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 45 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of jurnal
-- ----------------------------
INSERT INTO `jurnal` VALUES (27, 'J20180910171758', 3, 0, 0, '2018-09-10', NULL, NULL);
INSERT INTO `jurnal` VALUES (28, 'J20180910171758', 1, 0, 0, '2018-09-10', NULL, NULL);
INSERT INTO `jurnal` VALUES (29, 'J20180910171936', 1, 50000, 0, '2018-09-10', '2018-09-10 17:19:36', NULL);
INSERT INTO `jurnal` VALUES (30, 'J20180910171936', 3, 0, 50000, '2018-09-10', '2018-09-10 17:19:36', NULL);
INSERT INTO `jurnal` VALUES (31, 'J20180910172013', 1, 10000, 0, '2018-09-10', '2018-09-10 17:20:13', NULL);
INSERT INTO `jurnal` VALUES (32, 'J20180910172013', 1, 0, 10000, '2018-09-10', '2018-09-10 17:20:13', NULL);
INSERT INTO `jurnal` VALUES (33, 'J20180910224726', 3, 10000, 0, '2018-09-10', '2018-09-10 22:47:26', NULL);
INSERT INTO `jurnal` VALUES (34, 'J20180910224726', 1, 0, 500, '2018-09-10', '2018-09-10 22:47:26', NULL);
INSERT INTO `jurnal` VALUES (35, 'J20180910224726', 3, 0, 500, '2018-09-10', '2018-09-10 22:47:26', NULL);
INSERT INTO `jurnal` VALUES (36, 'J20180910171758', 3, 0, 0, '2018-09-10', NULL, NULL);
INSERT INTO `jurnal` VALUES (37, 'J20180910171758', 1, 0, 0, '2018-09-10', NULL, NULL);
INSERT INTO `jurnal` VALUES (38, 'J20180910171936', 1, 50000, 0, '2018-09-10', '2018-09-10 17:19:36', NULL);
INSERT INTO `jurnal` VALUES (39, 'J20180910171936', 3, 0, 50000, '2018-09-10', '2018-09-10 17:19:36', NULL);
INSERT INTO `jurnal` VALUES (40, 'J20180910172013', 1, 10000, 0, '2018-09-10', '2018-09-10 17:20:13', NULL);
INSERT INTO `jurnal` VALUES (41, 'J20180910172013', 1, 0, 10000, '2018-09-10', '2018-09-10 17:20:13', NULL);
INSERT INTO `jurnal` VALUES (42, 'J20180910224726', 3, 10000, 0, '2018-09-10', '2018-09-10 22:47:26', NULL);
INSERT INTO `jurnal` VALUES (43, 'J20180910224726', 1, 0, 500, '2018-09-10', '2018-09-10 22:47:26', NULL);
INSERT INTO `jurnal` VALUES (44, 'J20180910224726', 3, 0, 500, '2018-09-10', '2018-09-10 22:47:26', NULL);

-- ----------------------------
-- Table structure for karyawan
-- ----------------------------
DROP TABLE IF EXISTS `karyawan`;
CREATE TABLE `karyawan`  (
  `id_karyawan` int(10) NOT NULL AUTO_INCREMENT,
  `nik` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `id_jabatan` int(10) NOT NULL,
  `no_identitas` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `nama` varchar(150) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `jk` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `tempat_lahir` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `alamat` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `rt` varchar(5) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `rw` varchar(5) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `kecamatan` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `kelurahan` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `kota` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `no_tlp` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `agama` varchar(25) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `kewarganegaraan` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id_karyawan`) USING BTREE,
  INDEX `id_jabatan`(`id_jabatan`) USING BTREE,
  CONSTRAINT `karyawan_ibfk_1` FOREIGN KEY (`id_jabatan`) REFERENCES `jabatan` (`id_jabatan`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 19 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of karyawan
-- ----------------------------
INSERT INTO `karyawan` VALUES (3, '180721024155', 4, '1234567890123', 'RANI SRI ANGGRAENI', 'PEREMPUAN', 'JAKARTA', '1981-10-13', 'KEBAYORAN LAMA', '001', '001', '', '', 'JAKARTA', '', 'ISLAM', 'WNI', '2018-07-22 04:41:55', NULL);
INSERT INTO `karyawan` VALUES (4, '180721024325', 5, '12345678931241', 'SULAN', 'LAKI-LAKI', 'BANDUNG', '1980-07-24', 'JAKARTA', '002', '003', '', '', 'JAKARTA', '', 'ISLAM', 'WNI', '2018-07-22 04:42:57', '2018-07-22 04:43:25');
INSERT INTO `karyawan` VALUES (5, '180721024518', 6, '32273642023742340237', 'MAECHELE', 'PEREMPUAN', 'BANDUNG', '1990-07-10', 'JAKARTA', '002', '006', '', '', 'JAKARTA', '', 'ISLAM', 'WNI', '2018-07-22 04:45:18', NULL);
INSERT INTO `karyawan` VALUES (6, '180721024701', 3, '3223237472238429308', 'EDWARD', 'LAKI-LAKI', 'YOGYAKARTA', '1971-01-30', 'JAKARTA', '004', '005', '', '', 'JAKARTA', '', 'KRISTEN', 'WNI', '2018-07-22 04:47:01', NULL);
INSERT INTO `karyawan` VALUES (7, '180721024758', 7, '332372384723429', 'JAKA', 'LAKI-LAKI', 'SURABAYA', '1989-07-05', 'JAKARTA', '003', '004', '', '', 'JAKARTA', '', 'ISLAM', 'WNI', '2018-07-22 04:47:58', NULL);
INSERT INTO `karyawan` VALUES (8, '180721024923', 8, '32452524723894923847', 'MUJI', 'LAKI-LAKI', 'MEDAN', '1979-01-08', 'JAKARTA', '009', '005', '', '', 'JAKARTA', '', 'ISLAM', 'WNI', '2018-07-22 04:49:23', NULL);
INSERT INTO `karyawan` VALUES (9, '180721025020', 9, '324322523326468', 'ANANG', 'LAKI-LAKI', 'SURABAYA', '1961-08-25', 'JAKARTA', '001', '002', '', '', 'JAKARTA', '', 'ISLAM', 'WNI', '2018-07-22 04:50:20', NULL);
INSERT INTO `karyawan` VALUES (10, '180721025317', 10, '3234258748234878', 'PRASETIO', 'LAKI-LAKI', 'MALANG', '1984-06-13', 'JAKARTA', '002', '002', '', '', 'JAKARTA', '', 'ISLAM', 'WNI', '2018-07-22 04:53:17', NULL);
INSERT INTO `karyawan` VALUES (11, '180721025406', 10, '32352342374283', 'RIDWAN', 'LAKI-LAKI', 'BANDUNG', '1985-08-23', 'JAKARTA', '001', '005', '', '', 'JAKARTA', '', 'ISLAM', 'WNI', '2018-07-22 04:54:06', NULL);
INSERT INTO `karyawan` VALUES (12, '180721025552', 10, '32734853904583', 'ITO', 'LAKI-LAKI', 'JAKARTA', '1970-07-23', 'JAKARTA', '007', '011', '', '', 'JAKARTA', '', 'ISLAM', 'WNI', '2018-07-22 04:55:52', NULL);
INSERT INTO `karyawan` VALUES (13, '180721025657', 8, '3274563487534095', 'ADE', 'LAKI-LAKI', 'BANDUNG', '1990-07-28', 'JAKARTA', '001', '003', '', '', 'JAKARTA', '', 'ISLAM', 'WNI', '2018-07-22 04:56:57', NULL);
INSERT INTO `karyawan` VALUES (14, '180721025759', 9, '32673458894858394', 'BOBY', 'LAKI-LAKI', 'JAKARTA', '1985-07-25', 'JAKARTA', '003', '005', '', '', 'JAKARTA', '', 'ISLAM', 'WNI', '2018-07-22 04:57:59', NULL);
INSERT INTO `karyawan` VALUES (15, '180721030330', 9, '32723437465358934', 'YUSI', 'LAKI-LAKI', 'BANDUNG', '1980-06-10', 'JAKARTA', '001', '001', '', '', 'JAKARTA', '', 'ISLAM', 'WNI', '2018-07-22 05:03:30', NULL);
INSERT INTO `karyawan` VALUES (16, '180721030432', 11, '2342342364236482', 'UJANG', 'LAKI-LAKI', 'BANDUNG', '1991-03-07', 'JAKARTA', '001', '001', '', '', 'JAKARTA', '', 'ISLAM', 'WNI', '2018-07-22 05:04:32', NULL);
INSERT INTO `karyawan` VALUES (17, '180721030523', 12, '323423872349238', 'VESA', 'LAKI-LAKI', 'JAKARTA', '1989-05-15', 'JAKARTA', '001', '001', '', '', 'JAKARTA', '', 'ISLAM', 'WNI', '2018-07-22 05:05:23', NULL);
INSERT INTO `karyawan` VALUES (18, '180804090049', 13, '82342942874892482937', 'YADI MULYADI', 'LAKI-LAKI', 'BANDUNG', '1979-08-01', 'BANDUNG', '001', '008', '', '', 'BANDUNG', '', 'ISLAM', 'WNI', '2018-08-05 11:00:49', NULL);

-- ----------------------------
-- Table structure for keterlambatan
-- ----------------------------
DROP TABLE IF EXISTS `keterlambatan`;
CREATE TABLE `keterlambatan`  (
  `id_keterlambatan` int(100) NOT NULL AUTO_INCREMENT,
  `id_absensi` int(20) NOT NULL,
  `id_potongan_keterlambatan` int(100) NOT NULL,
  `lama_keterlambatan` int(10) NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id_keterlambatan`) USING BTREE,
  INDEX `id_absensi`(`id_absensi`) USING BTREE,
  INDEX `id_potongan_keterlambatan`(`id_potongan_keterlambatan`) USING BTREE,
  CONSTRAINT `keterlambatan_ibfk_2` FOREIGN KEY (`id_potongan_keterlambatan`) REFERENCES `potongan_keterlambatan` (`id_potongan_keterlambatan`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 13 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of keterlambatan
-- ----------------------------
INSERT INTO `keterlambatan` VALUES (12, 51, 6, 128, '2018-09-15 00:00:00', NULL);

-- ----------------------------
-- Table structure for lemburan_karyawan
-- ----------------------------
DROP TABLE IF EXISTS `lemburan_karyawan`;
CREATE TABLE `lemburan_karyawan`  (
  `id_lemburan` int(100) NOT NULL AUTO_INCREMENT,
  `id_absensi` int(120) NOT NULL,
  `jumlah_lemburan` int(10) NOT NULL,
  `upah_lemburan` int(100) NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id_lemburan`) USING BTREE,
  INDEX `id_absensi`(`id_absensi`) USING BTREE,
  CONSTRAINT `lemburan_karyawan_ibfk_1` FOREIGN KEY (`id_absensi`) REFERENCES `absensi` (`id_absensi`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 50 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of lemburan_karyawan
-- ----------------------------
INSERT INTO `lemburan_karyawan` VALUES (34, 51, 5, 126667, '2018-09-15 22:10:12', NULL);
INSERT INTO `lemburan_karyawan` VALUES (35, 52, 0, 0, '2018-09-15 17:00:12', NULL);
INSERT INTO `lemburan_karyawan` VALUES (36, 55, 0, 0, '2018-09-15 17:00:16', NULL);
INSERT INTO `lemburan_karyawan` VALUES (45, 56, 3, 49998, '2018-09-15 20:07:11', NULL);
INSERT INTO `lemburan_karyawan` VALUES (46, 57, 3, 49998, '2018-09-15 20:07:33', NULL);
INSERT INTO `lemburan_karyawan` VALUES (47, 53, 3, 49998, '2018-09-15 20:08:01', NULL);
INSERT INTO `lemburan_karyawan` VALUES (48, 54, 3, 49998, '2018-09-15 20:08:12', NULL);
INSERT INTO `lemburan_karyawan` VALUES (49, 58, 3, 33333, '2018-09-15 20:08:20', NULL);

-- ----------------------------
-- Table structure for master_tunjangan
-- ----------------------------
DROP TABLE IF EXISTS `master_tunjangan`;
CREATE TABLE `master_tunjangan`  (
  `id_master_tunjangan` int(10) NOT NULL AUTO_INCREMENT,
  `nama_tunjangan` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id_master_tunjangan`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of master_tunjangan
-- ----------------------------
INSERT INTO `master_tunjangan` VALUES (1, 'TUNJANGAN JABATAN', '2018-07-28 22:26:04', '2018-07-28 23:33:00');
INSERT INTO `master_tunjangan` VALUES (4, 'TUNJANGAN KOMUNIKASI', '2018-07-28 23:38:05', NULL);
INSERT INTO `master_tunjangan` VALUES (5, 'TUNJANGAN TEMPAT TINGGAL', '2018-07-29 03:35:56', NULL);

-- ----------------------------
-- Table structure for penggajian_karyawan
-- ----------------------------
DROP TABLE IF EXISTS `penggajian_karyawan`;
CREATE TABLE `penggajian_karyawan`  (
  `id_penggajian` int(100) NOT NULL AUTO_INCREMENT,
  `id_karyawan` int(10) NOT NULL,
  `kode_penggajian` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `tgl` date NOT NULL,
  `tgl_awal` date NOT NULL,
  `tgl_akhir` date NOT NULL,
  `total_gaji` int(100) NOT NULL,
  `total_potongan` int(100) NOT NULL,
  `total_tunjangan` int(100) NOT NULL,
  `total_lemburan` int(100) NOT NULL,
  `transport` int(100) NOT NULL,
  `uang_makan` int(100) NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id_penggajian`) USING BTREE,
  INDEX `id_karyawan`(`id_karyawan`) USING BTREE,
  CONSTRAINT `penggajian_karyawan_ibfk_1` FOREIGN KEY (`id_karyawan`) REFERENCES `karyawan` (`id_karyawan`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 225 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of penggajian_karyawan
-- ----------------------------
INSERT INTO `penggajian_karyawan` VALUES (214, 12, '', '2018-09-16', '2018-09-01', '2018-09-30', 150000, 0, 500000, 49998, 20000, 15000, NULL, NULL);
INSERT INTO `penggajian_karyawan` VALUES (216, 11, '', '2018-09-16', '2018-09-01', '2018-09-30', 150000, 0, 500000, 49998, 20000, 15000, NULL, NULL);
INSERT INTO `penggajian_karyawan` VALUES (219, 14, '', '2018-09-16', '2018-09-01', '2018-09-30', 100000, 0, 0, 33333, 20000, 15000, NULL, NULL);
INSERT INTO `penggajian_karyawan` VALUES (220, 3, '', '2018-09-16', '2018-09-01', '2018-09-30', 126667, 50000, 3000000, 126667, 0, 0, NULL, NULL);
INSERT INTO `penggajian_karyawan` VALUES (221, 13, '', '2018-09-16', '2018-09-01', '2018-09-30', 150000, 0, 400000, 49998, 20000, 15000, NULL, NULL);
INSERT INTO `penggajian_karyawan` VALUES (222, 10, '', '2018-09-16', '2018-09-01', '2018-09-30', 150000, 0, 500000, 49998, 20000, 15000, NULL, NULL);
INSERT INTO `penggajian_karyawan` VALUES (223, 6, '', '2018-09-16', '2018-09-01', '2018-09-30', 200000, 0, 400000, 0, 20000, 15000, NULL, NULL);
INSERT INTO `penggajian_karyawan` VALUES (224, 9, '', '2018-09-16', '2018-09-01', '2018-09-30', 150000, 0, 0, 0, 20000, 15000, NULL, NULL);

-- ----------------------------
-- Table structure for potongan_keterlambatan
-- ----------------------------
DROP TABLE IF EXISTS `potongan_keterlambatan`;
CREATE TABLE `potongan_keterlambatan`  (
  `id_potongan_keterlambatan` int(100) NOT NULL AUTO_INCREMENT,
  `jumlah_menit` int(10) NOT NULL,
  `jumlah_potongan` int(25) NOT NULL,
  `created_at` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0),
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id_potongan_keterlambatan`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of potongan_keterlambatan
-- ----------------------------
INSERT INTO `potongan_keterlambatan` VALUES (2, 20, 20000, '2018-07-24 12:22:31', '2018-07-24 12:22:31');
INSERT INTO `potongan_keterlambatan` VALUES (4, 10, 10000, '2018-07-24 12:22:25', NULL);
INSERT INTO `potongan_keterlambatan` VALUES (5, 30, 30000, '2018-07-23 22:56:04', NULL);
INSERT INTO `potongan_keterlambatan` VALUES (6, 40, 50000, '2018-08-05 07:06:11', NULL);

-- ----------------------------
-- Table structure for shift
-- ----------------------------
DROP TABLE IF EXISTS `shift`;
CREATE TABLE `shift`  (
  `id_shift` int(10) NOT NULL AUTO_INCREMENT,
  `jam_masuk` time(0) NOT NULL,
  `jam_pulang` time(0) NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id_shift`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of shift
-- ----------------------------
INSERT INTO `shift` VALUES (6, '08:00:00', '17:00:00', '2018-07-19 10:13:37', '2018-08-05 09:17:18');

-- ----------------------------
-- Table structure for testing
-- ----------------------------
DROP TABLE IF EXISTS `testing`;
CREATE TABLE `testing`  (
  `id_penggajian` int(100) NOT NULL AUTO_INCREMENT,
  `id_karyawan` int(10) NOT NULL,
  `kode_penggajian` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `tgl` date NOT NULL,
  `tgl_awal` date NOT NULL,
  `tgl_akhir` date NOT NULL,
  `total_gaji` int(100) NOT NULL,
  `total_potongan` int(100) NOT NULL,
  `total_tunjangan` int(100) NOT NULL,
  `total_lemburan` int(100) NOT NULL,
  `transport` int(100) NOT NULL,
  `uang_makan` int(100) NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id_penggajian`) USING BTREE,
  INDEX `id_karyawan`(`id_karyawan`) USING BTREE,
  CONSTRAINT `testing_ibfk_1` FOREIGN KEY (`id_karyawan`) REFERENCES `karyawan` (`id_karyawan`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for transport_makan
-- ----------------------------
DROP TABLE IF EXISTS `transport_makan`;
CREATE TABLE `transport_makan`  (
  `id_transport_makan` int(100) NOT NULL AUTO_INCREMENT,
  `transport` int(10) NOT NULL,
  `uang_makan` int(10) NOT NULL,
  `divisi` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id_transport_makan`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of transport_makan
-- ----------------------------
INSERT INTO `transport_makan` VALUES (3, 20000, 15000, 'PRODUKSI', '2018-08-06 00:40:43', '2018-08-06 06:25:12');

-- ----------------------------
-- Table structure for tunjangan_karyawan
-- ----------------------------
DROP TABLE IF EXISTS `tunjangan_karyawan`;
CREATE TABLE `tunjangan_karyawan`  (
  `id_tunjangan_karyawan` int(20) NOT NULL AUTO_INCREMENT,
  `id_master_tunjangan` int(10) NOT NULL,
  `id_karyawan` int(10) NOT NULL,
  `jumlah_tunjangan` int(100) NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id_tunjangan_karyawan`) USING BTREE,
  INDEX `id_master_tunjangan`(`id_master_tunjangan`) USING BTREE,
  INDEX `id_karyawan`(`id_karyawan`) USING BTREE,
  CONSTRAINT `tunjangan_karyawan_ibfk_1` FOREIGN KEY (`id_master_tunjangan`) REFERENCES `master_tunjangan` (`id_master_tunjangan`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tunjangan_karyawan_ibfk_2` FOREIGN KEY (`id_karyawan`) REFERENCES `karyawan` (`id_karyawan`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 15 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of tunjangan_karyawan
-- ----------------------------
INSERT INTO `tunjangan_karyawan` VALUES (2, 1, 3, 3000000, '2018-07-29 00:58:10', '2018-07-30 02:15:44');
INSERT INTO `tunjangan_karyawan` VALUES (3, 1, 16, 500000, '2018-07-29 03:29:11', NULL);
INSERT INTO `tunjangan_karyawan` VALUES (4, 1, 10, 400000, '2018-07-29 03:32:01', '2018-08-05 07:09:23');
INSERT INTO `tunjangan_karyawan` VALUES (5, 1, 11, 500000, '2018-07-29 03:32:22', NULL);
INSERT INTO `tunjangan_karyawan` VALUES (6, 1, 12, 500000, '2018-07-29 03:32:55', NULL);
INSERT INTO `tunjangan_karyawan` VALUES (7, 1, 8, 400000, '2018-07-29 03:33:16', NULL);
INSERT INTO `tunjangan_karyawan` VALUES (8, 1, 13, 400000, '2018-07-29 03:33:53', NULL);
INSERT INTO `tunjangan_karyawan` VALUES (9, 1, 6, 300000, '2018-07-29 03:34:21', NULL);
INSERT INTO `tunjangan_karyawan` VALUES (13, 4, 6, 100000, '2018-07-30 02:42:25', NULL);
INSERT INTO `tunjangan_karyawan` VALUES (14, 4, 10, 100000, '2018-08-05 07:08:43', NULL);

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user`  (
  `id_user` int(10) NOT NULL AUTO_INCREMENT,
  `id_karyawan` int(10) NOT NULL,
  `username` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `password` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id_user`) USING BTREE,
  INDEX `id_karyawan`(`id_karyawan`) USING BTREE,
  CONSTRAINT `user_ibfk_1` FOREIGN KEY (`id_karyawan`) REFERENCES `karyawan` (`id_karyawan`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES (4, 3, 'administrasi', '15ff3c0a0310a2e3de3e95c8aeb328d0', '2018-08-06 07:49:50', NULL);
INSERT INTO `user` VALUES (5, 4, 'akunting', 'ea90151f1af3606dee9b38ab278a2579', '2018-08-06 07:50:30', NULL);

-- ----------------------------
-- View structure for view_absen_penggajian
-- ----------------------------
DROP VIEW IF EXISTS `view_absen_penggajian`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `view_absen_penggajian` AS select `absensi`.`id_absensi` AS `id_absensi`,`absensi`.`id_karyawan` AS `id_karyawan`,`absensi`.`tgl` AS `tgl_absen`,`absensi`.`keterangan` AS `keterangan`,`absensi`.`jam_masuk` AS `jam_masuk`,`absensi`.`jam_pulang` AS `jam_pulang`,`karyawan`.`id_jabatan` AS `id_jabatan`,`jabatan`.`id_divisi` AS `id_divisi`,`jabatan`.`nama_jabatan` AS `nama_jabatan`,`jabatan`.`kode_jabatan` AS `kode_jabatan`,`divisi`.`kode_divisi` AS `kode_divisi`,`divisi`.`nama_divisi` AS `nama_divisi`,`keterlambatan`.`lama_keterlambatan` AS `lama_keterlambatan`,`keterlambatan`.`id_potongan_keterlambatan` AS `id_potongan_keterlambatan`,`lemburan_karyawan`.`id_lemburan` AS `id_lemburan`,`lemburan_karyawan`.`jumlah_lemburan` AS `jumlah_lemburan`,`lemburan_karyawan`.`upah_lemburan` AS `upah_lemburan`,`potongan_keterlambatan`.`jumlah_menit` AS `jumlah_menit`,`potongan_keterlambatan`.`jumlah_potongan` AS `jumlah_potongan` from ((((((`absensi` left join `karyawan` on((`absensi`.`id_karyawan` = `karyawan`.`id_karyawan`))) left join `jabatan` on((`karyawan`.`id_jabatan` = `jabatan`.`id_jabatan`))) left join `divisi` on((`jabatan`.`id_divisi` = `divisi`.`id_divisi`))) left join `keterlambatan` on((`keterlambatan`.`id_absensi` = `absensi`.`id_absensi`))) left join `lemburan_karyawan` on((`lemburan_karyawan`.`id_absensi` = `absensi`.`id_absensi`))) left join `potongan_keterlambatan` on((`keterlambatan`.`id_potongan_keterlambatan` = `potongan_keterlambatan`.`id_potongan_keterlambatan`))) order by `absensi`.`tgl`;

-- ----------------------------
-- View structure for view_jurnal
-- ----------------------------
DROP VIEW IF EXISTS `view_jurnal`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `view_jurnal` AS select `jurnal`.`id` AS `id_jurnal`,`jurnal`.`kode_jurnal` AS `kode_jurnal`,`jurnal`.`kode_akun` AS `kode_akun`,`jurnal`.`debet` AS `debet`,`jurnal`.`kredit` AS `kredit`,`jurnal`.`tgl` AS `tgl`,`jurnal`.`created_at` AS `created_at`,`jurnal`.`updated_at` AS `updated_at`,`akun`.`nama_akun` AS `nama_akun` from (`jurnal` join `akun` on((`jurnal`.`kode_akun` = `akun`.`id_akun`)));

-- ----------------------------
-- View structure for view_penggajian_karyawan
-- ----------------------------
DROP VIEW IF EXISTS `view_penggajian_karyawan`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `view_penggajian_karyawan` AS select `absensi`.`id_absensi` AS `id_absensi`,`absensi`.`id_karyawan` AS `id_karyawan`,`absensi`.`tgl` AS `tgl`,`absensi`.`keterangan` AS `keterangan`,`absensi`.`jam_masuk` AS `jam_masuk`,`absensi`.`jam_pulang` AS `jam_pulang`,`karyawan`.`nama` AS `nama`,`divisi`.`nama_divisi` AS `nama_divisi`,`jabatan`.`nama_jabatan` AS `nama_jabatan`,`gapok`.`gaji_pokok` AS `gaji_pokok`,`gapok`.`jenis_pembayaran` AS `jenis_pembayaran`,`keterlambatan`.`lama_keterlambatan` AS `lama_keterlambatan`,`potongan_keterlambatan`.`jumlah_potongan` AS `jumlah_potongan`,`lemburan_karyawan`.`upah_lemburan` AS `upah_lemburan`,`lemburan_karyawan`.`jumlah_lemburan` AS `jumlah_lemburan` from (((((((`absensi` join `karyawan` on((`absensi`.`id_karyawan` = `karyawan`.`id_karyawan`))) join `jabatan` on((`karyawan`.`id_jabatan` = `jabatan`.`id_jabatan`))) join `divisi` on((`jabatan`.`id_divisi` = `divisi`.`id_divisi`))) join `gapok` on((`karyawan`.`id_karyawan` = `gapok`.`id_karyawan`))) left join `keterlambatan` on((`absensi`.`id_absensi` = `keterlambatan`.`id_absensi`))) left join `potongan_keterlambatan` on((`keterlambatan`.`id_potongan_keterlambatan` = `potongan_keterlambatan`.`id_potongan_keterlambatan`))) left join `lemburan_karyawan` on((`absensi`.`id_absensi` = `lemburan_karyawan`.`id_absensi`))) order by `absensi`.`id_absensi`;

-- ----------------------------
-- View structure for view_potongan_keterlambatan
-- ----------------------------
DROP VIEW IF EXISTS `view_potongan_keterlambatan`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `view_potongan_keterlambatan` AS select sum(`potongan_keterlambatan`.`jumlah_potongan`) AS `jumlah` from (((`potongan_keterlambatan` join `keterlambatan` on((`keterlambatan`.`id_potongan_keterlambatan` = `potongan_keterlambatan`.`id_potongan_keterlambatan`))) join `absensi` on((`keterlambatan`.`id_absensi` = `absensi`.`id_absensi`))) join `karyawan` on((`absensi`.`id_karyawan` = `karyawan`.`id_karyawan`)));

SET FOREIGN_KEY_CHECKS = 1;
