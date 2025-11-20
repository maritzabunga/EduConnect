-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 04 Nov 2025 pada 11.35
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: educonnect
--

-- --------------------------------------------------------

--
-- Struktur dari tabel articles
--

CREATE TABLE articles (
  id int(11) NOT NULL,
  title varchar(255) DEFAULT NULL,
  content text DEFAULT NULL,
  points_value int(11) DEFAULT 10
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel articles
--

INSERT INTO articles (id, title, content, points_value) VALUES
(1, 'Pengenalan Algoritma', NULL, 10);

-- --------------------------------------------------------

--
-- Struktur dari tabel materi
--

CREATE TABLE materi (
  id int(11) NOT NULL,
  judul varchar(200) NOT NULL,
  deskripsi text NOT NULL,
  mentor_id int(11) NOT NULL,
  file_path varchar(255) DEFAULT NULL,
  gambar varchar(255) DEFAULT 'img/default-cover.jpg',
  kategori varchar(50) DEFAULT 'Umum',
  views int(11) DEFAULT 0,
  durasi int(11) DEFAULT 0,
  created_at timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel materi
--

INSERT INTO materi (id, judul, deskripsi, mentor_id, file_path, gambar, kategori, views, durasi, created_at) VALUES
(1, 'Pengantar Algoritma dan Struktur Data', 'Pelajaran dasar algoritma dan struktur data yang penting untuk pemrograman modern.', 1, 'files/algo.pdf', 'img/cover-algo.jpg', 'Pemrograman', 1234, 45, '2025-11-04 07:54:30'),
(2, 'Desain UI/UX untuk Pengembang', 'Memahami prinsip dasar desain interface dan user experience dengan cara praktis.', 2, 'files/uiux.pdf', 'img/cover-uiux.jpg', 'Desain', 987, 60, '2025-11-04 07:54:30'),
(3, 'Machine Learning Dasar dengan Python', 'Eksplorasi konsep machine learning menggunakan Python untuk analisis data modern.', 3, 'files/ml-python.pdf', 'img/cover-ml.jpg', 'Data Science', 2156, 90, '2025-11-04 07:54:30'),
(4, 'Pelajaran Aljabar Dasar', 'Materi lengkap tentang persamaan linear dan kuadrat untuk pemula.', 4, 'files/aljabar.pdf', 'img/cover-aljabar.jpg', 'Matematika', 567, 30, '2025-11-04 07:54:30'),
(5, 'Tips Speaking Bahasa Inggris', 'Panduan praktis untuk meningkatkan kemampuan berbicara sehari-hari.', 2, 'files/speaking.pdf', 'img/cover-speaking.jpg', 'Bahasa', 890, 40, '2025-11-04 07:54:30');

-- --------------------------------------------------------

--
-- Struktur dari tabel mentor
--

CREATE TABLE mentor (
  id int(11) NOT NULL,
  nama varchar(100) NOT NULL,
  email varchar(100) NOT NULL,
  foto varchar(255) DEFAULT 'img/default-avatar.jpg',
  deskripsi text DEFAULT NULL,
  created_at timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel mentor
--

INSERT INTO mentor (id, nama, email, foto, deskripsi, created_at) VALUES
(1, 'Dr. Budi Santoso', 'budi@educonnect.com', 'img/budi.jpg', 'Mentor ahli Pemrograman dan Data Structure dengan pengalaman 15 tahun.', '2025-11-04 07:54:30'),
(2, 'Sarah Wijaya, M.Des', 'sarah@educonnect.com', 'img/sarah.jpg', 'Desainer UI/UX yang fokus pada pengalaman user praktis.', '2025-11-04 07:54:30'),
(3, 'Prof. Ahmad Hidayat', 'ahmad@educonnect.com', 'img/ahmad.jpg', 'Ahli Machine Learning dan Data Science menggunakan Python.', '2025-11-04 07:54:30'),
(4, 'John Doe', 'john@educonnect.com', 'img/john.jpg', 'Mentor Fisika dasar untuk siswa SMA.', '2025-11-04 07:54:30');

-- --------------------------------------------------------

--
-- Struktur dari tabel point_logs
--

CREATE TABLE point_logs (
  id int(11) NOT NULL,
  user_id int(11) DEFAULT NULL,
  content_id int(11) DEFAULT NULL,
  content_type enum('article','video') DEFAULT NULL,
  points_earned int(11) DEFAULT NULL,
  earned_at datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel users
--

CREATE TABLE users (
  id int(11) NOT NULL,
  email varchar(255) NOT NULL,
  password varchar(255) NOT NULL,
  nama_pengguna varchar(100) DEFAULT NULL,
  points int(11) DEFAULT 0,
  created_at datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel users
--

INSERT INTO users (id, email, password, nama_pengguna, points, created_at) VALUES
(1, 'luhungarkananta@gmail.com', '$2y$10$Ru3oxq2zAxDuAhMYGwa6MuGhJaipZOmfaTdVe9roqalIhcN0uKRaa', 'luhung', 0, '2025-11-04 17:18:14');

-- --------------------------------------------------------

--
-- Struktur dari tabel user_progress
--

CREATE TABLE user_progress (
  user_id int(11) NOT NULL,
  content_id int(11) NOT NULL,
  content_type enum('article','video') NOT NULL,
  completed tinyint(1) DEFAULT 0,
  progress_percent decimal(5,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel videos
--

CREATE TABLE videos (
  id int(11) NOT NULL,
  title varchar(255) DEFAULT NULL,
  video_url varchar(255) DEFAULT NULL,
  points_value int(11) DEFAULT 20
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel videos
--

INSERT INTO videos (id, title, video_url, points_value) VALUES
(1, 'Video Algoritma', NULL, 20);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel articles
--
ALTER TABLE articles
  ADD PRIMARY KEY (id);

--
-- Indeks untuk tabel materi
--
ALTER TABLE materi
  ADD PRIMARY KEY (id),
  ADD KEY mentor_id (mentor_id),
  ADD KEY idx_judul (judul),
  ADD KEY idx_deskripsi (deskripsi(768)),
  ADD KEY idx_kategori (kategori);

--
-- Indeks untuk tabel mentor
--
ALTER TABLE mentor
  ADD PRIMARY KEY (id),
  ADD UNIQUE KEY email (email),
  ADD KEY idx_nama (nama);

--
-- Indeks untuk tabel point_logs
--
ALTER TABLE point_logs
  ADD PRIMARY KEY (id);

--
-- Indeks untuk tabel users
--
ALTER TABLE users
  ADD PRIMARY KEY (id),
  ADD UNIQUE KEY email (email);

--
-- Indeks untuk tabel user_progress
--
ALTER TABLE user_progress
  ADD PRIMARY KEY (user_id,content_id,content_type);

--
-- Indeks untuk tabel videos
--
ALTER TABLE videos
  ADD PRIMARY KEY (id);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel articles
--
ALTER TABLE articles
  MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel materi
--
ALTER TABLE materi
  MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel mentor
--
ALTER TABLE mentor
  MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel point_logs
--
ALTER TABLE point_logs
  MODIFY id int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel users
--
ALTER TABLE users
  MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel videos
--
ALTER TABLE videos
  MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel materi
--
ALTER TABLE materi
  ADD CONSTRAINT materi_ibfk_1 FOREIGN KEY (mentor_id) REFERENCES mentor (id) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;