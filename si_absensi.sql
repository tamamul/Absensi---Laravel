-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 20, 2025 at 04:28 PM
-- Server version: 8.0.30
-- PHP Version: 8.2.0

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
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `datasatpam`
--

CREATE TABLE `datasatpam` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nip` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nik` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pekerjaan` enum('Satpam') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Satpam',
  `status` enum('PKWT','PKWTT') COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_pkwt_pkwtt` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kontrak` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `terhitung_mulai_tugas` date NOT NULL,
  `jabatan` enum('Komandan Regu','Anggota') COLLATE utf8mb4_unicode_ci NOT NULL,
  `upt_id` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ultg_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lokasikerja_id` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `wilayah_kerja` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') COLLATE utf8mb4_unicode_ci NOT NULL,
  `tempat_lahir` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `usia` int NOT NULL,
  `warga negara` enum('WNI','WNA') COLLATE utf8mb4_unicode_ci NOT NULL,
  `agama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_hp` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `kelurahan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kecamatan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kabupaten` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `provinsi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `negara` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_ibu` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_kontak_darurat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_kontak_darurat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_ahli_waris` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tempat_lahir_ahli_waris` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_lahir_ahli_waris` date NOT NULL,
  `hub_ahli_waris` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_nikah` enum('TK','K','K1','K2','K3','K4') COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah_anak` int NOT NULL,
  `npwp` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_bank` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_rek` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_pemilik_rek` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_dplk` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pend_terakhir` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sertifikasi_satpam` enum('Gada Pratama','Gada Madya','Gada Utama') COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_reg_kta` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_kta` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `polda` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `polres` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_bpjs_kesehatan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_bpjs_ketenagakerjaan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ukuran_baju` enum('S','M','L','XL','XXL') COLLATE utf8mb4_unicode_ci NOT NULL,
  `ukuran_celana` int NOT NULL,
  `ukuran sepatu` int NOT NULL,
  `ukuran_topi` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lokasikerja`
--

CREATE TABLE `lokasikerja` (
  `id` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `upt_id` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ultg_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_lokasikerja` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `latitude` decimal(8,2) NOT NULL,
  `longitude` decimal(8,2) NOT NULL,
  `radius` int NOT NULL COMMENT 'Radius dalam meter',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lokasikerja`
--

INSERT INTO `lokasikerja` (`id`, `upt_id`, `ultg_id`, `nama_lokasikerja`, `latitude`, `longitude`, `radius`, `created_at`, `updated_at`) VALUES
('LOK1443', 'UPT0600', 'ULTG7184', 'GI 150KV Sumenep', '111.55', '-7.01', 100, '2025-05-04 08:07:30', '2025-05-04 08:07:30'),
('LOK4663', 'UPT9335', 'ULTG9040', 'gok,', '111.55', '-7.10', 100, '2025-05-12 06:06:04', '2025-05-12 06:06:04'),
('LOK6284', 'UPT6055', 'ULTG4836', 'GI 150KV Manisrejo', '113.83', '-7.01', 100, '2025-04-28 09:03:01', '2025-04-28 09:03:01');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_03_16_114842_buat_tabel_upt', 1),
(5, '2025_03_16_115757_buat_tabel_ultg', 1),
(6, '2025_03_16_115923_buat_tabel_lokasikerja', 1),
(7, '2025_03_18_150541_buat_tabel_dtsatpam', 1),
(8, '2025_03_25_151931_remove_latitude_longitude_radius_from_datasatpam', 1),
(9, '2025_04_24_153605_ubah_tabel_upt', 1),
(10, '2025_04_25_130803_ubah_tabel_ultg', 1),
(11, '2025_05_05_010530_create_users_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ultg`
--

CREATE TABLE `ultg` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `upt_id` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_ultg` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ultg`
--

INSERT INTO `ultg` (`id`, `upt_id`, `nama_ultg`, `created_at`, `updated_at`) VALUES
('ULTG4836', 'UPT6055', 'ULTG Madiun', '2025-04-28 09:02:40', '2025-05-04 08:07:02'),
('ULTG7184', 'UPT0600', 'ULTG Sampang', '2025-04-28 07:35:28', '2025-04-28 07:35:28'),
('ULTG9040', 'UPT9335', 'ULTG Malang', '2025-04-30 06:35:28', '2025-04-30 06:35:28');

-- --------------------------------------------------------

--
-- Table structure for table `upt`
--

CREATE TABLE `upt` (
  `id` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_upt` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `upt`
--

INSERT INTO `upt` (`id`, `nama_upt`, `created_at`, `updated_at`) VALUES
('UPT0600', 'UPT Gresik', '2025-04-28 07:35:20', '2025-04-28 07:35:20'),
('UPT6055', 'UPT Madiun', '2025-04-28 07:35:08', '2025-04-28 07:35:08'),
('UPT9335', 'UPT Malang', '2025-04-28 07:35:16', '2025-04-28 07:35:16');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `created_at`, `updated_at`) VALUES
(1, 'admin', '$2y$12$QkRMXuNYSFbHgB89GhqKJ.D2Uzs9DL.TNaxJQvVHp43GD3oDgi4UG', 'Admin', '2025-05-04 18:07:24', '2025-05-04 18:07:24'),
(2, 'pimpinan', '$2y$12$DN/3aKAcperzdQGCvLmPseKSNCcrx8uOnrgCt49U5zZB8j/Ok1f3e', 'Pimpinan', '2025-05-04 18:07:25', '2025-05-04 18:07:25');

--
-- Indexes for dumped tables
--

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
  ADD UNIQUE KEY `lokasikerja_id` (`lokasikerja_id`),
  ADD KEY `datasatpam_upt_id_foreign` (`upt_id`),
  ADD KEY `datasatpam_ultg_id_foreign` (`ultg_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

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
  ADD UNIQUE KEY `upt_id` (`upt_id`),
  ADD KEY `lokasikerja_ultg_id_foreign` (`ultg_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `datasatpam`
--
ALTER TABLE `datasatpam`
  ADD CONSTRAINT `datasatpam_upt_id_foreign` FOREIGN KEY (`upt_id`) REFERENCES `upt` (`id`) ON DELETE CASCADE;

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
