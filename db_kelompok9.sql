-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 26 Des 2024 pada 07.47
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_kelompok9`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `berita`
--

CREATE TABLE `berita` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `kategori_id` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `file_upload` varchar(200) NOT NULL,
  `isi_berita` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `berita`
--

INSERT INTO `berita` (`id`, `user_id`, `kategori_id`, `judul`, `file_upload`, `isi_berita`, `created_at`) VALUES
(22, 9, 2, 'lambo', '1732898061_download.jpg', 'lamborghini', '2024-11-29 16:34:21'),
(23, 12, 2, 'ferari', '1732953157_OIP.jpg', 'ferari', '2024-11-30 07:52:37');

-- --------------------------------------------------------

--
-- Struktur dari tabel `dosen`
--

CREATE TABLE `dosen` (
  `id` int(11) NOT NULL,
  `nik` char(18) NOT NULL,
  `nama_dosen` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `prodi_id` int(11) NOT NULL,
  `notelp` varchar(15) NOT NULL,
  `alamat` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `dosen`
--

INSERT INTO `dosen` (`id`, `nik`, `nama_dosen`, `email`, `prodi_id`, `notelp`, `alamat`) VALUES
(1, '23231234121', 'speed', 'speed@gmail.com', 303, '082921932131', 'amerisya usara'),
(2, '1232131231212', 'ishowspeed', 'speed@gmail.com', 6, '0829219321', 'ngawi'),
(3, '123123123', 'budi', 'zakiramadan600@gmail.com', 9, '23213123123', 'jl.Berlian raya blok.s no.2 Pagambiran Ampalu nan xx kec.Lubuk Begalung nan XX Padang');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori`
--

CREATE TABLE `kategori` (
  `id` int(11) NOT NULL,
  `nama_kategori` varchar(50) NOT NULL,
  `keterangan` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kategori`
--

INSERT INTO `kategori` (`id`, `nama_kategori`, `keterangan`) VALUES
(1, 'pendidikan', 'mantap'),
(2, 'otomotif', 'mobil'),
(3, 'gaming', 'gamer tanpan idaman'),
(4, 'kecantikan', 'adasdasdwadaw');

-- --------------------------------------------------------

--
-- Struktur dari tabel `level`
--

CREATE TABLE `level` (
  `id` int(11) NOT NULL,
  `nama_level` varchar(100) NOT NULL,
  `keterangan` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `level`
--

INSERT INTO `level` (`id`, `nama_level`, `keterangan`) VALUES
(2, 'admin', 'full access'),
(3, 'user', 'hanya melihat'),
(0, 'guest', 'adiajdawid');

-- --------------------------------------------------------

--
-- Struktur dari tabel `mahasiswa`
--

CREATE TABLE `mahasiswa` (
  `id` int(11) NOT NULL,
  `nim` varchar(20) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `tgl_lahir` date NOT NULL,
  `jenis_kelamin` enum('L','P') NOT NULL,
  `hobi` text DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `no_telp` varchar(20) NOT NULL,
  `alamat` text NOT NULL,
  `prodi_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `mahasiswa`
--

INSERT INTO `mahasiswa` (`id`, `nim`, `nama`, `tgl_lahir`, `jenis_kelamin`, `hobi`, `email`, `no_telp`, `alamat`, `prodi_id`) VALUES
(5, '2232', 'zaki', '1925-01-01', 'L', 'Membaca', 'zakiramadan600@gmail.com', '08953592323232', 'jambi', 9),
(11, '213213', 'Franco', '1900-12-13', 'L', 'Membaca, Olahraga, Travelling', 'franco@gmail.com', '023123121421', 'land of dawn', NULL),
(12, '12312312323', 'afdil', '2007-11-18', 'L', 'Olahraga', 'afdilganteng098@gmail.com', '23213123123', 'solok', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `matakuliah`
--

CREATE TABLE `matakuliah` (
  `id` int(20) NOT NULL,
  `kode_matakuliah` int(20) NOT NULL,
  `nama_matakuliah` varchar(50) NOT NULL,
  `semester` int(2) NOT NULL,
  `jenis_matakuliah` varchar(10) NOT NULL,
  `sks` int(2) NOT NULL,
  `jam` int(2) NOT NULL,
  `keterangan` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `matakuliah`
--

INSERT INTO `matakuliah` (`id`, `kode_matakuliah`, `nama_matakuliah`, `semester`, `jenis_matakuliah`, `sks`, `jam`, `keterangan`) VALUES
(2, 5555, 'web lanjut', 3, 'Praktek', 2, 2, 'Uts'),
(3, 213123, 'Embeded system', 3, 'Teori', 5, 10, 'Online');

-- --------------------------------------------------------

--
-- Struktur dari tabel `prodi`
--

CREATE TABLE `prodi` (
  `id` int(11) NOT NULL,
  `nama_prodi` varchar(25) NOT NULL,
  `jenjang` enum('D3','D4') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `prodi`
--

INSERT INTO `prodi` (`id`, `nama_prodi`, `jenjang`) VALUES
(6, 'bhsa arab', 'D3'),
(9, 'TRPL', 'D3'),
(10, 'ALAT BERAT', 'D3'),
(11, 'Manajemen', 'D3');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `level_id` int(50) NOT NULL,
  `foto` varchar(500) NOT NULL,
  `no_telp` varchar(20) NOT NULL,
  `alamat` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id`, `nama`, `email`, `password`, `level_id`, `foto`, `no_telp`, `alamat`) VALUES
(8, 'jaki', 'jaki@gmail.com', '92ab1583c4542e6ea322221231aeffe4', 1, 'uploads/51195e04ba06bba734de8b22884ac955.jpg', '0', ''),
(9, 'admin', 'admin@gmail.com', '21232f297a57a5a743894a0e4a801fc3', 0, '../backend/uploads/1732951679_ebb78b5a0de477351e9e39b983b56c0c (1).jpg', '0', ''),
(10, 'jaky', 'jaki1@gmail.com', '07d8357e6337bc9a644200c3dd2bf8e4', 0, '', '', ''),
(11, 'Zaki Ramadhan', 'jaki22@gmail.com', '92ab1583c4542e6ea322221231aeffe4', 2, '1732952532_download.jpg', '', ''),
(12, 'Zaki Ramadhan', 'jaki32@gmail.com', '07d8357e6337bc9a644200c3dd2bf8e4', 0, '../uploads/674aca5f48abd.jpg', '', '');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `berita`
--
ALTER TABLE `berita`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `dosen`
--
ALTER TABLE `dosen`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nim` (`nim`),
  ADD KEY `idx_nim` (`nim`),
  ADD KEY `prodi_id` (`prodi_id`);

--
-- Indeks untuk tabel `matakuliah`
--
ALTER TABLE `matakuliah`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `prodi`
--
ALTER TABLE `prodi`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `berita`
--
ALTER TABLE `berita`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT untuk tabel `dosen`
--
ALTER TABLE `dosen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `mahasiswa`
--
ALTER TABLE `mahasiswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `matakuliah`
--
ALTER TABLE `matakuliah`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `prodi`
--
ALTER TABLE `prodi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD CONSTRAINT `mahasiswa_ibfk_1` FOREIGN KEY (`prodi_id`) REFERENCES `prodi` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
