-- HRIS Sigma Investment Technologies - Struktur Database

CREATE DATABASE IF NOT EXISTS `hris_sigma` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `hris_sigma`;

-- Tabel role
CREATE TABLE IF NOT EXISTS `role` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `nama` VARCHAR(50) NOT NULL UNIQUE
);

-- Tabel user (login)
CREATE TABLE IF NOT EXISTS `user` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `username` VARCHAR(50) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `role_id` INT NOT NULL,
  `staff_id` INT,
  `theme_mode` VARCHAR(10) NOT NULL DEFAULT 'light',
  FOREIGN KEY (`role_id`) REFERENCES `role`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`staff_id`) REFERENCES `staff`(`id`) ON DELETE SET NULL
);

-- Tabel divisi
CREATE TABLE IF NOT EXISTS `divisi` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `nama` VARCHAR(100) NOT NULL UNIQUE
);

-- Tabel staff
CREATE TABLE IF NOT EXISTS `staff` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `nama` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) NOT NULL UNIQUE,
  `divisi_id` INT,
  `jabatan` VARCHAR(50),
  `tanggal_masuk` DATE,
  `status` ENUM('Aktif','Resign') DEFAULT 'Aktif',
  FOREIGN KEY (`divisi_id`) REFERENCES `divisi`(`id`) ON DELETE SET NULL
);

-- Tabel presensi
CREATE TABLE IF NOT EXISTS `presensi` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `staff_id` INT NOT NULL,
  `tanggal` DATE NOT NULL,
  `jam_masuk` TIME,
  `jam_pulang` TIME,
  `foto_masuk` VARCHAR(255),
  `foto_pulang` VARCHAR(255),
  `lokasi_masuk` VARCHAR(255),
  `lokasi_pulang` VARCHAR(255),
  `status` ENUM('Sesuai Jadwal','Terlambat','Tidak Masuk','Cuti','Lembur','Pulang Cepat') DEFAULT 'Sesuai Jadwal',
  FOREIGN KEY (`staff_id`) REFERENCES `staff`(`id`) ON DELETE CASCADE
);

-- Tabel gaji
CREATE TABLE IF NOT EXISTS `gaji` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `staff_id` INT NOT NULL,
  `tanggal` DATE NOT NULL,
  `jumlah` INT NOT NULL,
  `keterangan` VARCHAR(255),
  FOREIGN KEY (`staff_id`) REFERENCES `staff`(`id`) ON DELETE CASCADE
);

-- Tabel gaji_setting
CREATE TABLE IF NOT EXISTS `gaji_setting` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `nominal_per_jam` INT NOT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Tabel pengaduan
CREATE TABLE IF NOT EXISTS `pengaduan` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `staff_id` INT NOT NULL,
  `tanggal` DATE NOT NULL,
  `jenis` VARCHAR(50),
  `isi` TEXT,
  `status` ENUM('Baru','Diproses','Selesai') DEFAULT 'Baru',
  FOREIGN KEY (`staff_id`) REFERENCES `staff`(`id`) ON DELETE CASCADE
);

-- Tabel pengajuan (resign, cuti, dll)
CREATE TABLE IF NOT EXISTS `pengajuan` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `staff_id` INT NOT NULL,
  `tanggal` DATE NOT NULL,
  `jenis` VARCHAR(50),
  `isi` TEXT,
  `status` ENUM('Baru','Diproses','Disetujui','Ditolak') DEFAULT 'Baru',
  FOREIGN KEY (`staff_id`) REFERENCES `staff`(`id`) ON DELETE CASCADE
);

-- Data role awal
INSERT INTO `role` (`nama`) VALUES ('superadmin'), ('admin'), ('staff'); 

ALTER TABLE `staff`
ADD COLUMN `telepon` VARCHAR(30) DEFAULT NULL,
ADD COLUMN `rekening_atm` VARCHAR(50) DEFAULT NULL,
ADD COLUMN `no_ktp` VARCHAR(30) DEFAULT NULL,
ADD COLUMN `pendidikan` VARCHAR(100) DEFAULT NULL,
ADD COLUMN `gaji_bulanan` INT DEFAULT NULL; 

-- Tabel jam kerja default
CREATE TABLE IF NOT EXISTS jam_kerja (
    id INT AUTO_INCREMENT PRIMARY KEY,
    jam_masuk TIME NOT NULL,
    jam_pulang TIME NOT NULL,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tambah kolom jam kerja khusus di tabel users
ALTER TABLE users
ADD COLUMN jam_masuk TIME NULL AFTER pendidikan,
ADD COLUMN jam_pulang TIME NULL AFTER jam_masuk; 

-- Tabel untuk menyimpan jumlah hari kerja per bulan
CREATE TABLE IF NOT EXISTS hari_kerja_bulanan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tahun INT NOT NULL,
    bulan INT NOT NULL,
    jumlah_hari INT NOT NULL,
    UNIQUE KEY (tahun, bulan)
); 

-- Tabel chat_messages untuk fitur chat real-time
CREATE TABLE IF NOT EXISTS chat_messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sender_id INT NOT NULL,
    receiver_id INT DEFAULT NULL,
    message TEXT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    is_read TINYINT(1) DEFAULT 0,
    FOREIGN KEY (sender_id) REFERENCES user(id) ON DELETE CASCADE,
    FOREIGN KEY (receiver_id) REFERENCES user(id) ON DELETE CASCADE
); 