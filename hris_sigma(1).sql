-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 10, 2025 at 03:37 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hris_sigma`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_log`
--

CREATE TABLE `activity_log` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `activity_log`
--

INSERT INTO `activity_log` (`id`, `user_id`, `title`, `description`, `created_at`) VALUES
(1, 4, 'Gaji bulanan digenerate', 'Gaji bulan 07/2025 telah digenerate.', '2025-07-09 18:37:40'),
(2, 4, 'Event baru dibuat', 'Event \"NONGKI ASIK\" telah ditambahkan.', '2025-07-09 18:42:11'),
(3, 5, 'Laporan/Masukan dikirim', 'Anda mengirim laporan dengan perihal: gajiii', '2025-07-09 18:48:16'),
(4, 4, 'Event baru dibuat', 'Event \"Jalan Sehat 17 Agustus\" telah ditambahkan.', '2025-07-09 20:24:26'),
(5, 4, 'Gaji bulanan digenerate', 'Gaji bulan 07/2025 telah digenerate.', '2025-07-09 20:25:58');

-- --------------------------------------------------------

--
-- Table structure for table `chat_messages`
--

CREATE TABLE `chat_messages` (
  `id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) DEFAULT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `chat_messages`
--

INSERT INTO `chat_messages` (`id`, `sender_id`, `receiver_id`, `message`, `is_read`, `created_at`) VALUES
(1, 3, NULL, 'test', 0, '2025-07-09 17:55:11'),
(2, 8, NULL, 'yoi slur', 0, '2025-07-09 18:00:26'),
(3, 7, NULL, 'apasih', 0, '2025-07-09 18:00:55'),
(4, 8, 9, 'halo', 1, '2025-07-09 19:35:06'),
(5, 3, NULL, 'p info', 0, '2025-07-09 19:49:23'),
(6, 3, NULL, 'p info', 0, '2025-07-09 19:49:24'),
(7, 3, NULL, 'p info', 0, '2025-07-09 19:49:24');

-- --------------------------------------------------------

--
-- Table structure for table `divisi`
--

CREATE TABLE `divisi` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `divisi`
--

INSERT INTO `divisi` (`id`, `nama`) VALUES
(4, 'branding'),
(2, 'finance'),
(5, 'hr'),
(6, 'it'),
(8, 'lainnya'),
(1, 'marketing'),
(7, 'operational'),
(3, 'sales');

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE `event` (
  `id` int(11) NOT NULL,
  `judul` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_selesai` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `event`
--

INSERT INTO `event` (`id`, `judul`, `deskripsi`, `tanggal_mulai`, `tanggal_selesai`) VALUES
(4, 'Jalan Sehat 17 Agustus', 'Jalan Sehat Rame Rame', '2025-08-17', '2025-08-17');

-- --------------------------------------------------------

--
-- Table structure for table `gaji`
--

CREATE TABLE `gaji` (
  `id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `jumlah` int(11) NOT NULL,
  `keterangan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gaji`
--

INSERT INTO `gaji` (`id`, `staff_id`, `tanggal`, `jumlah`, `keterangan`) VALUES
(1, 2, '2025-07-01', 71, 'Otomatis by sistem'),
(2, 3, '2025-07-01', 190, 'Otomatis by sistem'),
(3, 4, '2025-07-01', 4926316, 'Otomatis by sistem'),
(4, 2, '2025-06-01', 0, 'Otomatis by sistem'),
(5, 3, '2025-06-01', 0, 'Otomatis by sistem'),
(6, 4, '2025-06-01', 0, 'Otomatis by sistem'),
(7, 5, '2025-07-01', 0, 'Otomatis by sistem');

-- --------------------------------------------------------

--
-- Table structure for table `gaji_setting`
--

CREATE TABLE `gaji_setting` (
  `id` int(11) NOT NULL,
  `nominal_per_jam` int(11) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hari_kerja_bulanan`
--

CREATE TABLE `hari_kerja_bulanan` (
  `id` int(11) NOT NULL,
  `tahun` int(11) NOT NULL,
  `bulan` int(11) NOT NULL,
  `jumlah_hari` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hari_kerja_bulanan`
--

INSERT INTO `hari_kerja_bulanan` (`id`, `tahun`, `bulan`, `jumlah_hari`) VALUES
(1, 2025, 7, 19);

-- --------------------------------------------------------

--
-- Table structure for table `jam_kerja`
--

CREATE TABLE `jam_kerja` (
  `id` int(11) NOT NULL,
  `jam_masuk` time NOT NULL,
  `jam_pulang` time NOT NULL,
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `perizinan`
--

CREATE TABLE `perizinan` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `perihal` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alasan` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alasan_detail` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `perizinan`
--

INSERT INTO `perizinan` (`id`, `user_id`, `perihal`, `alasan`, `alasan_detail`, `created_at`) VALUES
(1, 3, 'Izin Tidak Masuk', 'Cuti', NULL, '2025-07-09 20:12:32'),
(2, 3, 'Pengunduran Diri', NULL, 'Gajinya kurenggg', '2025-07-09 20:13:42'),
(3, 4, 'Izin Tidak Masuk', 'Sakit', NULL, '2025-07-09 20:15:59'),
(4, 4, 'Pengunduran Diri', NULL, 'Gajinya ga masuk akal\r\n', '2025-07-09 20:16:11'),
(5, 5, 'Izin Tidak Masuk', 'Cuti', NULL, '2025-07-09 20:21:58');

-- --------------------------------------------------------

--
-- Table structure for table `presensi`
--

CREATE TABLE `presensi` (
  `id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `jam_masuk` time DEFAULT NULL,
  `jam_pulang` time DEFAULT NULL,
  `foto_masuk` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `foto_pulang` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lokasi_masuk` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lokasi_pulang` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('Sesuai Jadwal','Terlambat','Tidak Masuk','Cuti','Lembur','Pulang Cepat') COLLATE utf8mb4_unicode_ci DEFAULT 'Sesuai Jadwal'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `presensi`
--

INSERT INTO `presensi` (`id`, `staff_id`, `tanggal`, `jam_masuk`, `jam_pulang`, `foto_masuk`, `foto_pulang`, `lokasi_masuk`, `lokasi_pulang`, `status`) VALUES
(1, 3, '2025-07-09', '10:50:41', '10:50:49', NULL, NULL, NULL, NULL, 'Sesuai Jadwal'),
(2, 2, '2025-07-09', '10:55:14', '10:55:17', NULL, NULL, NULL, NULL, 'Sesuai Jadwal'),
(3, 4, '2025-07-01', '08:00:00', '16:00:00', NULL, NULL, NULL, NULL, 'Sesuai Jadwal'),
(41, 4, '2025-07-02', '08:00:00', '16:00:00', NULL, NULL, NULL, NULL, 'Sesuai Jadwal'),
(42, 4, '2025-07-03', '08:00:00', '16:00:00', NULL, NULL, NULL, NULL, 'Sesuai Jadwal'),
(43, 4, '2025-07-04', '08:00:00', '16:00:00', NULL, NULL, NULL, NULL, 'Sesuai Jadwal'),
(44, 4, '2025-07-05', '08:00:00', '16:00:00', NULL, NULL, NULL, NULL, 'Sesuai Jadwal'),
(45, 4, '2025-07-06', '08:00:00', '16:00:00', NULL, NULL, NULL, NULL, 'Sesuai Jadwal'),
(46, 4, '2025-07-07', '08:00:00', '16:00:00', NULL, NULL, NULL, NULL, 'Sesuai Jadwal'),
(47, 4, '2025-07-08', '08:00:00', '16:00:00', NULL, NULL, NULL, NULL, 'Sesuai Jadwal'),
(48, 4, '2025-07-09', '08:00:00', '16:00:00', NULL, NULL, NULL, NULL, 'Sesuai Jadwal'),
(49, 4, '2025-07-10', '08:00:00', '16:00:00', NULL, NULL, NULL, NULL, 'Sesuai Jadwal'),
(50, 4, '2025-07-11', '08:00:00', '16:00:00', NULL, NULL, NULL, NULL, 'Sesuai Jadwal'),
(51, 4, '2025-07-12', '08:00:00', '16:00:00', NULL, NULL, NULL, NULL, 'Sesuai Jadwal'),
(52, 4, '2025-07-13', '08:00:00', '16:00:00', NULL, NULL, NULL, NULL, 'Sesuai Jadwal'),
(53, 4, '2025-07-14', '08:00:00', '16:00:00', NULL, NULL, NULL, NULL, 'Sesuai Jadwal'),
(54, 4, '2025-07-15', '08:00:00', '16:00:00', NULL, NULL, NULL, NULL, 'Sesuai Jadwal'),
(55, 4, '2025-07-16', '08:00:00', '16:00:00', NULL, NULL, NULL, NULL, 'Sesuai Jadwal'),
(56, 4, '2025-07-17', '08:00:00', '16:00:00', NULL, NULL, NULL, NULL, 'Sesuai Jadwal'),
(57, 4, '2025-07-18', '08:00:00', '16:00:00', NULL, NULL, NULL, NULL, 'Sesuai Jadwal');

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `perihal` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `isi` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reports`
--

INSERT INTO `reports` (`id`, `user_id`, `perihal`, `isi`, `created_at`) VALUES
(1, 8, '', 'teststestets', '2025-07-09 18:12:35'),
(2, 6, 'Gaji', 'Gaji gw kurang, tambahin dong', '2025-07-09 18:16:54'),
(3, 5, 'gaji', 'gaji kurang', '2025-07-09 18:44:27'),
(4, 5, 'gajiii', 'gaji kurang\r\n', '2025-07-09 18:48:16');

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `id` int(11) NOT NULL,
  `nama` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id`, `nama`) VALUES
(2, 'admin'),
(3, 'staff'),
(1, 'superadmin');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `divisi_id` int(11) DEFAULT NULL,
  `jabatan` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_masuk` date DEFAULT NULL,
  `status` enum('Aktif','Resign') COLLATE utf8mb4_unicode_ci DEFAULT 'Aktif',
  `telepon` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rekening_atm` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_ktp` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pendidikan` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gaji_bulanan` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`id`, `nama`, `email`, `divisi_id`, `jabatan`, `tanggal_masuk`, `status`, `telepon`, `rekening_atm`, `no_ktp`, `pendidikan`, `gaji_bulanan`) VALUES
(2, 'Agus Hidayat', 'agushidayat09@gmail.com', 2, 'Manager Finance', NULL, 'Aktif', '08999786545', '44455232', '3515097867554', 'S1', 13000000),
(3, 'Diiva Nur', 'divanur@gmail.com', 5, 'Manager HR', NULL, 'Aktif', '08133377778', '567665376', '358897687654', 'S2', 13000000),
(4, 'Granade Axel', 'g.axel@gmail.com', 1, 'Staff DigitalMarketing', NULL, 'Aktif', '087674374673', '4545454', '3446565474', 'S1', 5200000),
(5, 'Bimoyudha', 'bim@gmail.com', 6, 'Manager IT', NULL, 'Aktif', '8333304348', '66645343', '3706564534232', 'S2', 13000000);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_id` int(11) NOT NULL,
  `staff_id` int(11) DEFAULT NULL,
  `jam_masuk` time DEFAULT NULL,
  `jam_pulang` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `role_id`, `staff_id`, `jam_masuk`, `jam_pulang`) VALUES
(3, 'admin', '$2y$10$eGP9oXBhcmwCcg89wv8XIeTylvLvuRwlfRGH73tV/1fVtd0HwvYYi', 2, 2, NULL, NULL),
(4, 'superadmin1', '$2y$10$rg98koUNi/8KuQbzLp7CzuT/EToGWThb/ylgb4m9FA1IfyODWrIcm', 1, 3, '08:00:00', '16:00:00'),
(5, 'staff', '$2y$10$zoYv3ZX3UwCW7HtyNBxNzuAzX8ePDRbvDquf1vzd3G.COO8kyI1re', 3, 3, NULL, NULL),
(6, 'agus2', '$2y$10$eBIfysYoo8.HQYjSZrPA8.SbsLgegtnxjonYQ6OaN.mgCncDnNGYu', 2, 2, NULL, NULL),
(7, 'diva', '$2y$10$rkJ8Eah7aeDmBPb4HhGUhOc5bkelGJP2sT.pGbyuuQkWf1lMdF/QG', 1, 3, NULL, NULL),
(8, 'axel', '$2y$10$2VxG7LH0lycVjJBvXss7t.HtO4nQUVHzsWahjcr3XkLXw0Ug6s7T6', 3, 4, '08:00:00', '04:00:00'),
(9, 'bimo', '$2y$10$bICHZNp9CmOEPd0UwJISo.qa1W3hdGDtP9otq8Fao0zVZwN800tKW', 2, 5, '08:00:00', '04:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_log`
--
ALTER TABLE `activity_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `chat_messages`
--
ALTER TABLE `chat_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `divisi`
--
ALTER TABLE `divisi`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nama` (`nama`);

--
-- Indexes for table `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gaji`
--
ALTER TABLE `gaji`
  ADD PRIMARY KEY (`id`),
  ADD KEY `staff_id` (`staff_id`);

--
-- Indexes for table `gaji_setting`
--
ALTER TABLE `gaji_setting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hari_kerja_bulanan`
--
ALTER TABLE `hari_kerja_bulanan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tahun` (`tahun`,`bulan`);

--
-- Indexes for table `jam_kerja`
--
ALTER TABLE `jam_kerja`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `perizinan`
--
ALTER TABLE `perizinan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`);

--
-- Indexes for table `presensi`
--
ALTER TABLE `presensi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `staff_id` (`staff_id`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nama` (`nama`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `divisi_id` (`divisi_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `role_id` (`role_id`),
  ADD KEY `staff_id` (`staff_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_log`
--
ALTER TABLE `activity_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `chat_messages`
--
ALTER TABLE `chat_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `divisi`
--
ALTER TABLE `divisi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `event`
--
ALTER TABLE `event`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `gaji`
--
ALTER TABLE `gaji`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `gaji_setting`
--
ALTER TABLE `gaji_setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hari_kerja_bulanan`
--
ALTER TABLE `hari_kerja_bulanan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `jam_kerja`
--
ALTER TABLE `jam_kerja`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `perizinan`
--
ALTER TABLE `perizinan`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `presensi`
--
ALTER TABLE `presensi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `gaji`
--
ALTER TABLE `gaji`
  ADD CONSTRAINT `gaji_ibfk_1` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `perizinan`
--
ALTER TABLE `perizinan`
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `presensi`
--
ALTER TABLE `presensi`
  ADD CONSTRAINT `presensi_ibfk_1` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `staff`
--
ALTER TABLE `staff`
  ADD CONSTRAINT `staff_ibfk_1` FOREIGN KEY (`divisi_id`) REFERENCES `divisi` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_ibfk_2` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
