-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 27, 2025 at 07:03 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `si_absensi`
--

-- --------------------------------------------------------

--
-- Table structure for table `absensi`
--

CREATE TABLE `absensi` (
  `id` int(11) NOT NULL,
  `satpam_id` bigint(20) UNSIGNED NOT NULL,
  `tanggal` date NOT NULL,
  `jam_masuk` time DEFAULT NULL,
  `jam_keluar` time DEFAULT '00:00:00',
  `latitude_masuk` decimal(10,6) DEFAULT NULL,
  `longitude_masuk` decimal(10,6) DEFAULT NULL,
  `latitude_keluar` decimal(10,6) DEFAULT NULL,
  `longitude_keluar` decimal(10,6) DEFAULT NULL,
  `status` enum('hadir','terlambat','izin','sakit','alpha') DEFAULT 'hadir',
  `keterangan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `absensi`
--

INSERT INTO `absensi` (`id`, `satpam_id`, `tanggal`, `jam_masuk`, `jam_keluar`, `latitude_masuk`, `longitude_masuk`, `latitude_keluar`, `longitude_keluar`, `status`, `keterangan`, `created_at`, `updated_at`) VALUES
(3, 1, '2025-03-31', '17:55:46', '00:00:00', '-7.744701', '112.177540', NULL, NULL, 'terlambat', '', '2025-03-31 10:55:46', '2025-03-31 10:55:46'),
(5, 1, '2025-03-30', '17:55:46', '00:00:00', '-7.744701', '112.177540', NULL, NULL, 'hadir', '', '2025-03-31 10:55:46', '2025-05-26 15:57:58'),
(6, 7, '2025-05-25', '23:05:13', '00:00:00', NULL, NULL, NULL, NULL, 'hadir', NULL, '2025-05-26 16:05:56', '2025-05-26 16:05:56'),
(7, 1, '2025-05-25', '17:55:46', '00:00:00', '-7.744701', '112.177540', NULL, NULL, 'hadir', '', '2025-03-31 10:55:46', '2025-05-26 15:57:58');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `datasatpam`
--

CREATE TABLE `datasatpam` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode_satpam` varchar(255) DEFAULT NULL,
  `nip` varchar(255) NOT NULL,
  `nik` varchar(255) NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `nama` varchar(255) NOT NULL,
  `pekerjaan` enum('Satpam') DEFAULT 'Satpam',
  `status` enum('PKWT','PKWTT') DEFAULT NULL,
  `no_pkwt_pkwtt` varchar(255) DEFAULT NULL,
  `kontrak` varchar(255) DEFAULT NULL,
  `terhitung_mulai_tugas` date DEFAULT NULL,
  `jabatan` enum('Komandan Regu','Anggota') DEFAULT NULL,
  `lokasikerja_id` bigint(20) UNSIGNED DEFAULT NULL,
  `wilayah_kerja` varchar(255) DEFAULT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') DEFAULT NULL,
  `tempat_lahir` varchar(255) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `usia` int(11) DEFAULT NULL,
  `warga_negara` enum('WNI','WNA') DEFAULT NULL,
  `agama` varchar(255) DEFAULT NULL,
  `no_hp` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `kelurahan` varchar(255) DEFAULT NULL,
  `kecamatan` varchar(255) DEFAULT NULL,
  `kabupaten` varchar(255) DEFAULT NULL,
  `provinsi` varchar(255) DEFAULT NULL,
  `negara` varchar(255) DEFAULT NULL,
  `nama_ibu` varchar(255) DEFAULT NULL,
  `no_kontak_darurat` varchar(255) DEFAULT NULL,
  `nama_kontak_darurat` varchar(255) DEFAULT NULL,
  `nama_ahli_waris` varchar(255) DEFAULT NULL,
  `tempat_lahir_ahli_waris` varchar(255) DEFAULT NULL,
  `tanggal_lahir_ahli_waris` date DEFAULT NULL,
  `hub_ahli_waris` varchar(255) DEFAULT NULL,
  `status_nikah` enum('TK','K','K1','K2','K3','K4') DEFAULT NULL,
  `jumlah_anak` int(11) DEFAULT NULL,
  `npwp` varchar(255) DEFAULT NULL,
  `nama_bank` varchar(255) DEFAULT NULL,
  `no_rek` varchar(255) DEFAULT NULL,
  `nama_pemilik_rek` varchar(255) DEFAULT NULL,
  `no_dplk` varchar(255) DEFAULT NULL,
  `pend_terakhir` varchar(255) DEFAULT NULL,
  `sertifikasi_satpam` enum('Gada Pratama','Gada Madya','Gada Utama') DEFAULT NULL,
  `no_reg_kta` varchar(255) DEFAULT NULL,
  `no_kta` varchar(255) DEFAULT NULL,
  `polda` varchar(255) DEFAULT NULL,
  `polres` varchar(255) DEFAULT NULL,
  `no_bpjs_kesehatan` varchar(255) DEFAULT NULL,
  `no_bpjs_ketenagakerjaan` varchar(255) DEFAULT NULL,
  `ukuran_baju` enum('S','M','L','XL','XXL') DEFAULT NULL,
  `ukuran_celana` int(11) DEFAULT NULL,
  `ukuran_sepatu` int(11) DEFAULT NULL,
  `ukuran_topi` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `datasatpam`
--

INSERT INTO `datasatpam` (`id`, `kode_satpam`, `nip`, `nik`, `foto`, `nama`, `pekerjaan`, `status`, `no_pkwt_pkwtt`, `kontrak`, `terhitung_mulai_tugas`, `jabatan`, `lokasikerja_id`, `wilayah_kerja`, `jenis_kelamin`, `tempat_lahir`, `tanggal_lahir`, `usia`, `warga_negara`, `agama`, `no_hp`, `email`, `alamat`, `kelurahan`, `kecamatan`, `kabupaten`, `provinsi`, `negara`, `nama_ibu`, `no_kontak_darurat`, `nama_kontak_darurat`, `nama_ahli_waris`, `tempat_lahir_ahli_waris`, `tanggal_lahir_ahli_waris`, `hub_ahli_waris`, `status_nikah`, `jumlah_anak`, `npwp`, `nama_bank`, `no_rek`, `nama_pemilik_rek`, `no_dplk`, `pend_terakhir`, `sertifikasi_satpam`, `no_reg_kta`, `no_kta`, `polda`, `polres`, `no_bpjs_kesehatan`, `no_bpjs_ketenagakerjaan`, `ukuran_baju`, `ukuran_celana`, `ukuran_sepatu`, `ukuran_topi`, `created_at`, `updated_at`) VALUES
(1, 'SAT0001', '12345', '12345', 'foto_satpam/default_avatar.jpg.avif', 'MISBACHUL', 'Satpam', 'PKWTT', '017/PKWTT-AMP/VII/2023', 'jatin', '2025-03-28', 'Anggota', 1, 'Kota Malang', 'Laki-laki', 'Malang', '2000-01-08', 25, 'WNI', 'Islam', '082333546365', 'tes@gmail.com', 'JL. DIPONEGORO NO. 2, RT. 2/2', 'JUNREJO', 'JUNREJO', 'Kota Batu', 'JAWA TIMUR', 'Indonesia', 'Lasemii', '081249213511', 'Sri Wijayanti', 'Sri Wijayanti', 'Malang', '2000-01-05', 'Istri', 'K3', 3, NULL, 'Mandiri', '1150006824272', 'EDY PURWITO', '1002301298308', 'SMA', 'Gada Pratama', '13.13.887.054', '2861/KTASATPAM-GP/II/2024/Ditbinmas', 'Polda Jawa Timur', 'Kota Batu', '8022429420', '1134336385', 'M', 30, 40, 55, '2025-03-30 04:07:02', '2025-03-30 04:07:05'),
(2, 'SAT0002', '54321', '54321', '1748161625_2.jpg', 'frankie steinlie', 'Satpam', NULL, NULL, NULL, NULL, 'Anggota', 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '08883866931', 'frankie.steinlie@gmail.com', 'medannnnnnnnnnnnnnnnnnn', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(7, 'SAT0003', '123456', '123456', '1743322483_1.jpg', 'M. MISBAH', 'Satpam', 'PKWTT', '018/PKWTT-AMP/VII/2023', 'jatin', '2025-03-28', 'Anggota', 1, 'Kota Malang', 'Laki-laki', 'Malang', '2000-01-08', 25, 'WNI', 'Islam', '082333546366', 'test@gmail.com', 'JL. DIPONEGORO NO. 2, RT. 2/2', 'JUNREJO', 'JUNREJO', 'Kota Batu', 'JAWA TIMUR', 'Indonesia', 'Lasemii', '081249213511', 'Sri Wijayanti', 'Sri Wijayanti', 'Malang', '2000-01-05', 'Istri', 'K3', 3, NULL, 'Mandiri', '1150006824279', 'EDY PURWITO', '1002301298309', 'SMA', 'Gada Pratama', '13.13.887.056', '2866/KTASATPAM-GP/II/2024/Ditbinmas', 'Polda Jawa Timur', 'Kota Batu', '8022429421', '1134336386', 'M', 30, 40, 55, '2025-03-30 04:07:02', '2025-03-30 04:07:05'),
(14, 'SAT9776', 'Impedit tempor sunt', 'Obcaecati quidem nob', 'foto_satpam/1748360806_6835de663659c.jpeg', 'Debitis qui maiores', 'Satpam', 'PKWT', 'Ut ut rerum proident', 'At ut aperiam volupt', '1984-09-27', 'Komandan Regu', 2, 'Consequatur Enim qu', 'Laki-laki', 'Aspernatur vero pari', '1982-11-20', 45, 'WNI', 'Kristen', 'Sed excepteur incidi', 'fosylenyke@mailinator.com', 'Labore lorem do ulla', 'Animi praesentium m', 'Placeat consequatur', 'Aliquid sunt molest', 'Error rem reprehende', 'Laudantium possimus', 'Sapiente architecto', 'Optio omnis sed ali', 'Ea eos at sunt cons', 'Omnis molestiae accu', 'Excepteur mollitia i', '2002-02-07', 'Dolor temporibus vol', 'K', 1, 'Pariatur Pariatur', 'Excepteur adipisci a', 'Ea duis voluptas sed', 'Quasi pariatur Aliq', 'Aut commodo velit r', 'Quia eveniet in non', 'Gada Pratama', 'Pariatur Omnis magn', 'Recusandae Natus ma', 'Velit rerum enim ap', 'Sit quaerat earum s', 'Sit facere consequu', 'Est labore et veniam', 'XXL', 36, 41, 72, '2025-05-27 08:46:46', '2025-05-27 09:45:30');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jadwal`
--

CREATE TABLE `jadwal` (
  `id` int(11) NOT NULL,
  `satpam_id` bigint(20) UNSIGNED NOT NULL,
  `tanggal` date NOT NULL,
  `shift` enum('P','S','M','L') NOT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jadwal`
--

INSERT INTO `jadwal` (`id`, `satpam_id`, `tanggal`, `shift`, `keterangan`, `created_at`, `updated_at`) VALUES
(1, 1, '2025-03-31', 'S', NULL, '2025-03-30 07:33:57', '2025-03-31 10:16:16'),
(2, 1, '2025-03-30', 'P', NULL, '2025-05-25 09:30:31', '2025-05-25 09:30:31'),
(3, 1, '2025-05-26', 'S', 'masuk', '2025-05-26 00:54:01', '2025-05-26 08:22:37'),
(4, 1, '2025-05-27', 'M', NULL, '2025-05-26 00:54:01', '2025-05-26 00:54:01'),
(5, 1, '2025-05-28', 'L', NULL, '2025-05-26 00:54:01', '2025-05-26 00:54:01'),
(6, 1, '2025-05-29', 'P', NULL, '2025-05-26 00:54:01', '2025-05-26 00:54:01'),
(7, 1, '2025-05-30', 'S', NULL, '2025-05-26 00:54:01', '2025-05-26 00:54:01'),
(8, 1, '2025-05-31', 'M', NULL, '2025-05-26 00:54:01', '2025-05-26 00:54:01'),
(9, 7, '2025-05-25', 'S', NULL, '2025-05-26 09:04:05', '2025-05-26 09:04:05'),
(10, 7, '2025-05-26', 'M', NULL, '2025-05-26 09:04:05', '2025-05-26 09:04:05'),
(11, 7, '2025-05-27', 'L', NULL, '2025-05-26 09:04:05', '2025-05-26 09:04:05'),
(12, 7, '2025-05-28', 'P', NULL, '2025-05-26 09:04:05', '2025-05-26 09:04:05'),
(13, 7, '2025-05-29', 'S', NULL, '2025-05-26 10:22:52', '2025-05-26 10:22:52'),
(14, 2, '2025-05-27', 'S', NULL, '2025-05-27 09:50:51', '2025-05-27 09:50:51'),
(15, 2, '2025-05-28', 'M', NULL, '2025-05-27 09:51:06', '2025-05-27 09:51:06'),
(16, 2, '2025-05-29', 'L', NULL, '2025-05-27 09:51:34', '2025-05-27 09:51:34'),
(17, 2, '2025-05-30', 'L', NULL, '2025-05-27 09:51:34', '2025-05-27 09:51:34');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lokasikerja`
--

CREATE TABLE `lokasikerja` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode_loker` varchar(255) DEFAULT NULL,
  `nama_lokasikerja` varchar(255) NOT NULL,
  `ultg_id` bigint(20) UNSIGNED NOT NULL,
  `latitude` decimal(10,6) NOT NULL,
  `longitude` decimal(10,6) NOT NULL,
  `radius` int(11) NOT NULL COMMENT 'Radius dalam meter',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lokasikerja`
--

INSERT INTO `lokasikerja` (`id`, `kode_loker`, `nama_lokasikerja`, `ultg_id`, `latitude`, `longitude`, `radius`, `created_at`, `updated_at`) VALUES
(1, 'LOK0001', 'GI 150KV LAWANG', 1, '-7.744757', '112.177116', 100, '2025-03-30 03:41:39', '2025-03-30 03:41:43'),
(2, 'LOK0002', 'GI GULUK-GULUK', 2, '-7.744757', '112.177116', 100, '2025-03-30 03:42:29', '2025-03-30 03:42:32'),
(6, 'LOK9323', 'coba lagi ini Judah', 2, '1.000000', '1.000000', 15, '2025-05-26 09:52:11', '2025-05-27 05:22:35');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_03_16_114842_buat_tabel_upt', 1),
(5, '2025_03_16_115757_buat_tabel_ultg', 2),
(6, '2025_03_16_115923_buat_tabel_lokasikerja', 3),
(7, '2025_03_18_150541_buat_tabel_dtsatpam', 4),
(8, '2025_03_25_151931_remove_latitude_longitude_radius_from_datasatpam', 5);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ultg`
--

CREATE TABLE `ultg` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode_ultg` varchar(255) DEFAULT NULL,
  `nama_ultg` varchar(255) NOT NULL,
  `upt_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ultg`
--

INSERT INTO `ultg` (`id`, `kode_ultg`, `nama_ultg`, `upt_id`, `created_at`, `updated_at`) VALUES
(1, 'ULTG0001', 'malang', 1, '2025-03-30 03:38:52', '2025-03-30 03:38:55'),
(2, 'ULTG0002', 'sampang', 2, '2025-03-30 03:39:03', '2025-03-30 03:39:06'),
(3, 'ULTG5092', 'Coba Ultra', 3, '2025-05-26 09:40:25', '2025-05-26 09:40:25'),
(4, 'ULTG2211', 'dicpba lagi', 3, '2025-05-26 09:40:41', '2025-05-26 09:40:41');

-- --------------------------------------------------------

--
-- Table structure for table `upt`
--

CREATE TABLE `upt` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode_upt` varchar(255) DEFAULT NULL,
  `nama_upt` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `upt`
--

INSERT INTO `upt` (`id`, `kode_upt`, `nama_upt`, `created_at`, `updated_at`) VALUES
(1, 'UPT0001', 'malang', '2025-03-30 03:38:29', '2025-03-30 03:38:35'),
(2, 'UPT0002', 'gresik', '2025-03-30 03:38:32', '2025-03-30 03:38:38'),
(3, 'UPT9873', 'coba diubah lagi', '2025-05-26 09:33:27', '2025-05-26 09:35:41');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `created_at`, `updated_at`) VALUES
(1, 'admin', '$2y$12$QkRMXuNYSFbHgB89GhqKJ.D2Uzs9DL.TNaxJQvVHp43GD3oDgi4UG', 'Admin', '2025-05-04 11:07:24', '2025-05-04 11:07:24'),
(2, 'pimpinan', '$2y$12$DN/3aKAcperzdQGCvLmPseKSNCcrx8uOnrgCt49U5zZB8j/Ok1f3e', 'Pimpinan', '2025-05-04 11:07:25', '2025-05-04 11:07:25'),
(1, 'admin', '$2y$12$QkRMXuNYSFbHgB89GhqKJ.D2Uzs9DL.TNaxJQvVHp43GD3oDgi4UG', 'Admin', '2025-05-04 11:07:24', '2025-05-04 11:07:24'),
(2, 'pimpinan', '$2y$12$DN/3aKAcperzdQGCvLmPseKSNCcrx8uOnrgCt49U5zZB8j/Ok1f3e', 'Pimpinan', '2025-05-04 11:07:25', '2025-05-04 11:07:25');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `absensi`
--
ALTER TABLE `absensi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `satpam_id` (`satpam_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `datasatpam`
--
ALTER TABLE `datasatpam`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `datasatpam_nip_unique` (`nip`),
  ADD UNIQUE KEY `datasatpam_nik_unique` (`nik`),
  ADD UNIQUE KEY `datasatpam_no_pkwt_pkwtt_unique` (`no_pkwt_pkwtt`),
  ADD UNIQUE KEY `datasatpam_no_rek_unique` (`no_rek`),
  ADD UNIQUE KEY `datasatpam_no_dplk_unique` (`no_dplk`),
  ADD UNIQUE KEY `datasatpam_no_reg_kta_unique` (`no_reg_kta`),
  ADD UNIQUE KEY `datasatpam_no_kta_unique` (`no_kta`),
  ADD UNIQUE KEY `datasatpam_no_bpjs_kesehatan_unique` (`no_bpjs_kesehatan`),
  ADD UNIQUE KEY `datasatpam_no_bpjs_ketenagakerjaan_unique` (`no_bpjs_ketenagakerjaan`),
  ADD KEY `datasatpam_lokasikerja_id_foreign` (`lokasikerja_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jadwal`
--
ALTER TABLE `jadwal`
  ADD PRIMARY KEY (`id`),
  ADD KEY `satpam_id` (`satpam_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lokasikerja`
--
ALTER TABLE `lokasikerja`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lokasikerja_ultg_id_foreign` (`ultg_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `ultg`
--
ALTER TABLE `ultg`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ultg_upt_id_foreign` (`upt_id`);

--
-- Indexes for table `upt`
--
ALTER TABLE `upt`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `absensi`
--
ALTER TABLE `absensi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `datasatpam`
--
ALTER TABLE `datasatpam`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jadwal`
--
ALTER TABLE `jadwal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lokasikerja`
--
ALTER TABLE `lokasikerja`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `ultg`
--
ALTER TABLE `ultg`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `upt`
--
ALTER TABLE `upt`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `absensi`
--
ALTER TABLE `absensi`
  ADD CONSTRAINT `absensi_ibfk_1` FOREIGN KEY (`satpam_id`) REFERENCES `datasatpam` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `datasatpam`
--
ALTER TABLE `datasatpam`
  ADD CONSTRAINT `datasatpam_lokasikerja_id_foreign` FOREIGN KEY (`lokasikerja_id`) REFERENCES `lokasikerja` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `jadwal`
--
ALTER TABLE `jadwal`
  ADD CONSTRAINT `jadwal_ibfk_1` FOREIGN KEY (`satpam_id`) REFERENCES `datasatpam` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `lokasikerja`
--
ALTER TABLE `lokasikerja`
  ADD CONSTRAINT `lokasikerja_ultg_id_foreign` FOREIGN KEY (`ultg_id`) REFERENCES `ultg` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `ultg`
--
ALTER TABLE `ultg`
  ADD CONSTRAINT `ultg_upt_id_foreign` FOREIGN KEY (`upt_id`) REFERENCES `upt` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
